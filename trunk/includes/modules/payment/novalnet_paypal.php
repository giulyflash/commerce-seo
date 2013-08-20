<?php

#########################################################
#                                                       #
#  Paypal payment method class                          #
#  This module is used for real time processing of      #
#  transaction of customers.                            #
#                                                       #
#  Released under the GNU General Public License.       #
#  This free contribution made by request.              #
#  If you have found this script useful a small         #
#  recommendation as well as a comment on merchant form #
#  would be greatly appreciated.                        #
#                                                       #
#  Script : novalnet_paypal.php                         #
#                                                       #
#########################################################

class novalnet_paypal {

    var $code;
    var $title;
    var $description;
    var $enabled;
    var $blnDebug;
    var $key;
    var $implementation;
    var $KEY = 34;
    var $is_ajax = false;
    var $vendorid;
    var $productid;
    var $authcode;
    var $tariffid;
    var $testmode;
    var $password;
    var $api_signature;
    var $api_user;
    var $api_password;
    var $logo_title;
    var $payment_logo_title;
    var $nn_image;

    /**
     * Constructor 
     *
     * @return void
     */
    function novalnet_paypal() {
        global $order;
        $this->key = trim(MODULE_PAYMENT_NOVALNET_PAYPAL_PASSWORD);
        $this->code = 'novalnet_paypal';
        $this->form_action_url = 'https://payport.novalnet.de/paypal_payport';
        $this->logo_title = MODULE_PAYMENT_NOVALNET_PAYPAL_LOGO_TITLE;
        $this->payment_logo_title = MODULE_PAYMENT_NOVALNET_PAYPAL_PAYMENT_LOGO_TITLE;

        $this->title = MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_TITLE . '<br>' . $this->logo_title . $this->payment_logo_title;
        $this->public_title = MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_PUBLIC_TITLE;
        $this->description = MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_PAYMENT_NOVALNET_PAYPAL_SORT_ORDER;
        $this->enabled = ((MODULE_PAYMENT_NOVALNET_PAYPAL_STATUS == 'True') ? true : false);
        $this->nn_image = ( MODULE_PAYMENT_ENABLE_NOVALNET_LOGO == 1) ? $this->logo_title . $this->payment_logo_title : $this->payment_logo_title;
        $this->blnDebug = false; #todo: set to false for live system
        $this->proxy = MODULE_PAYMENT_NOVALNET_PAYPAL_PROXY;
        $this->implementation = ''; #'JAVA', 'PHP', '', if empty, then equal to 'PHP'
        $this->doAssignConfigVarsToMembers();
        $this->checkConfigure();
        if (CHECKOUT_AJAX_STAT == 'true') {
            $this->is_ajax = true;
        }
        #check encoded data
        if ($_REQUEST['hash2'] && $_SESSION['payment'] == $this->code) {
            if (strtoupper($this->implementation) == 'JAVA') {#Java encoded
                if ($_REQUEST['auth_code'] != md5($this->authcode . strrev($this->key))) {
                    $err = MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_HASH_ERROR . '; wrong auth_code!';
                    $payment_error_return = 'payment_error=novalnet_paypal&error=' . $_REQUEST['status_text'] . (isset($err) ? ';' . utf8_encode($err) : '');
                    if ($this->is_ajax) {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, '', 'SSL', true, false) . '?' . $payment_error_return);
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                }
                $_REQUEST['auth_code'] = MODULE_PAYMENT_NOVALNET_PAYPAL_AUTH_CODE; #todo: check?
                $_REQUEST['product_id'] = $this->encode4java($_REQUEST['product'], 'bindec');
                $_REQUEST['tariff_id'] = $this->encode4java($_REQUEST['tariff'], 'bindec');
                $_REQUEST['amount'] = $this->encode4java($_REQUEST['amount'], 'bindec');
                $_REQUEST['test_mode'] = $this->encode4java($_REQUEST['test_mode'], 'bindec');
                $_REQUEST['uniqid'] = $this->encode4java($_REQUEST['uniqid'], 'bindec');

                if (!$this->checkHash4java($_REQUEST)) {#PHP encoded
                    $err = MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_HASH_ERROR;
                    $payment_error_return = 'payment_error=novalnet_paypal&error=' . $_REQUEST['status_text'] . (isset($err) ? ';' . utf8_encode($err) : '');
                    if ($this->is_ajax) {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, $payment_error_return, 'SSL', true, false));
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                }
            } else {#PHP encoded
                if (!$this->checkHash($_REQUEST)) {
                    $err = MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_HASH_ERROR;
                    $payment_error_return = 'payment_error=novalnet_paypal&error=' . $_REQUEST['status_text'] . (isset($err) ? ';' . utf8_encode($err) : '');
                    if ($this->is_ajax) {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, '', 'SSL', true, false) . '?' . $payment_error_return);
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                } else {
                    $_REQUEST['auth_code'] = $this->decode($_REQUEST['auth_code']);
                    $_REQUEST['product_id'] = $this->decode($_REQUEST['product_id']);
                    $_REQUEST['tariff_id'] = $this->decode($_REQUEST['tariff_id']);
                    $_REQUEST['amount'] = $this->decode($_REQUEST['amount']);
                    $_REQUEST['test_mode'] = $this->decode($_REQUEST['test_mode']);
                    $_REQUEST['uniqid'] = $this->decode($_REQUEST['uniqid']);
                }
            }
        }
        if ((int) MODULE_PAYMENT_NOVALNET_PAYPAL_ORDER_STATUS_ID > 0) {
            $this->order_status = MODULE_PAYMENT_NOVALNET_PAYPAL_ORDER_STATUS_ID;
        }
        if (is_object($order))
            $this->update_status();
    }

    /**
     * Set all the backend parameters required by novalnet payment gateway for processing payment
     *
     * @return void
     */
    function doAssignConfigVarsToMembers() {
        $this->vendorid = trim(MODULE_PAYMENT_NOVALNET_PAYPAL_VENDOR_ID);
        $this->productid = trim(MODULE_PAYMENT_NOVALNET_PAYPAL_PRODUCT_ID);
        $this->authcode = trim(MODULE_PAYMENT_NOVALNET_PAYPAL_AUTH_CODE);
        $this->tariffid = trim(MODULE_PAYMENT_NOVALNET_PAYPAL_TARIFF_ID);
        $this->testmode = (strtolower(MODULE_PAYMENT_NOVALNET_PAYPAL_TEST_MODE) == 'true' or MODULE_PAYMENT_NOVALNET_PAYPAL_TEST_MODE == '1') ? 1 : 0;
        $this->api_signature = trim(MODULE_PAYMENT_NOVALNET_PAYPAL_API_SIGNATURE);
        $this->api_user = trim(MODULE_PAYMENT_NOVALNET_PAYPAL_API_USER);
        $this->api_password = trim(MODULE_PAYMENT_NOVALNET_PAYPAL_API_PASSWORD);
    }

    /**
     * Test configure values and test mode in admin panel
     *
     * @return void
     */
    function checkConfigure() {
        if (IS_ADMIN_FLAG == true) {
            if ($this->enabled == 'true' && (empty($this->vendorid) || empty($this->productid) || empty($this->authcode) || empty($this->tariffid) || empty($this->api_signature) || empty($this->api_user) || empty($this->api_password))) {
                $this->title .= '<br>' . MODULE_PAYMENT_NOVALNET_PAYPAL_NOT_CONFIGURED;
            } elseif ($this->testmode == '1') {
                $this->title .= '<br>' . MODULE_PAYMENT_NOVALNET_PAYPAL_IN_TEST_MODE;
            }
        }
    }

    /**
     * calculate zone matches and flag settings to determine whether this module should display to customers or not
     *
     * @return void
     */
    function update_status() {
        global $order;
        if (($this->enabled == true) && ((int) MODULE_PAYMENT_NOVALNET_PAYPAL_ZONE > 0)) {
            $check_flag = false;
            $check_query = xtc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_NOVALNET_PAYPAL_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
            while ($check = xtc_db_fetch_array($check_query)) {
                if ($check['zone_id'] < 1) {
                    $check_flag = true;
                    break;
                } elseif ($check['zone_id'] == $order->billing['zone_id']) {
                    $check_flag = true;
                    break;
                }
            }
            if ($check_flag == false) {
                $this->enabled = false;
            }
        }
    }

    /**
     * JS validation which does error-checking of data-entry if this module is selected for use
     * the fields to be cheked are (Bank Owner, Bank Account Number and Bank Code Lengths)
     * currently this function is not in use
     * 
     * 
     * @return string
     */
    function javascript_validation() {
        return false;
    }

    /**
     * Builds set of fields for frontend
     * 
     * 
     * @return array
     */
    function selection() {
        global $xtPrice, $order, $HTTP_POST_VARS, $_POST;
        $onFocus = '';
        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;
        
        
        if($this->testmode)
        $mode = NOVALNET_TEXT_TESTMODE_FRONT;
        else
        $mode = '';
        
        $selection = array('id' => $this->code,
            'module' => $this->public_title,
            'fields' => array(
                array('title' => '', 'field' => $this->nn_image . $this->description),
                array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_PAYPAL_INFO),
                array('title' => '', 'field' =>$mode)
                ));

        if (function_exists(get_percent)) {
            $selection['module_cost'] = $GLOBALS['ot_payment']->get_percent($this->code);
        }
        return $selection;
    }

    /**
     * Precheck to Evaluate the Novalnet backend params
     * 
     * 
     * @return void
     */
    function pre_confirmation_check() {
        global $HTTP_POST_VARS, $_POST, $order;
        if (!$this->emailVaildate($order->customer['email_address'])) {
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode('Please enter the valid email Id'));
            if ($this->is_ajax) {
                $_SESSION['checkout_payment_error'] = $payment_error_return;
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            }
        }
        // Check shipping methods are selected or not;
        if (!$order->info['shipping_method']) {
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_PAYPAL_REQUEST_FOR_CHOOSE_SHIPPING_METHOD));
            $_SESSION['checkout_payment_error'] = $payment_error_return;
            return;
        }
        if (!is_array($HTTP_POST_VARS) && !$HTTP_POST_VARS) {
            $HTTP_POST_VARS = array();
        }
        $HTTP_POST_VARS = array_merge($HTTP_POST_VARS, $_POST);
        $error = '';
        if (empty($this->vendorid) || empty($this->productid) || empty($this->authcode) || empty($this->tariffid) || empty($this->api_signature) || empty($this->api_user) || empty($this->api_password)) {
            $error = MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_JS_NN_MISSING;
        }
        if ($error != '') {
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode($error));
            if ($this->is_ajax) {
                $_SESSION['checkout_payment_error'] = $payment_error_return;
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            }
        }
    }

    /**
     * This is user defined function used for getting order amount in cents with tax
     * 
     * 
     * @return int
     */
    public function findTotalAmount() {
        global $order;
        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
            $total = $order->info['total'] + $order->info['tax'];
        } else {
            $total = $order->info['total'];
        }
        if (preg_match('/[^\d\.]/', $total) or !$total) {
            ### $amount contains some unallowed chars or empty ###
            $err = 'amount (' . $total . ') is empty or has a wrong format';
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . utf8_encode($err);
            if ($this->is_ajax) {
                $_SESSION['checkout_payment_error'] = $payment_error_return;
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            }
        }
        $amount = sprintf('%0.2f', $total);
        $amount = preg_replace('/^0+/', '', $amount);
        $amount = str_replace('.', '', $amount);
        return $amount;
    }

    /**
     * Display Information on the Checkout Confirmation Page
     * 
     * 
     * @return array
     */
    function confirmation() {
        global $HTTP_POST_VARS, $_POST, $order;
        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
            $total = $order->info['total'] + $order->info['tax'];
        } else {
            $total = $order->info['total'];
        }
        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;
        $confirmation = array();
        return $confirmation;
    }

    /**
     * Build the data and actions to process when the "Submit" button is pressed on the order-confirmation screen.
     * These are hidden fields on the checkout confirmation page
     * 
     * @return string
     */
    function process_button() {
        global $HTTP_POST_VARS, $_POST, $order, $currencies, $customer_id;
        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;
        #Get the required additional customer details from DB
        // $customer_query = xtc_db_query("SELECT customers_gender, customers_dob, customers_fax FROM ". TABLE_CUSTOMERS . " WHERE customers_id='". (int)$customer_id ."'");
        // $customer = xtc_db_fetch_array($customer_query);
        $nn_customer_id = (isset($_SESSION['customer_id'])) ? $_SESSION['customer_id'] : '';
        $customer_query = xtc_db_query("SELECT customers_gender, customers_dob, customers_fax, customers_status FROM " . TABLE_CUSTOMERS . " WHERE customers_id='" . (int) $nn_customer_id . "'");
        $customer = xtc_db_fetch_array($customer_query);
        $nncustomer_no = ($customer_query->fields['customers_status'] != 1) ? $nn_customer_id : NOVALNET_GUEST_USER;
        if (trim($order->customer['csID']))
            $customer_no = $order->customer['csID'];
        else
            $customer_no = $nncustomer_no;

        list($customer['customers_dob'], $extra) = explode(' ', $customer['customers_dob']);

        $amount = $this->findTotalAmount();
        $uniqid = uniqid();

        if (strtoupper($this->implementation) == 'JAVA') {
            $uniqid = time(); #must ne a long integer
            $hash = md5($this->authcode . $this->productid . $this->tariffid . $amount . $this->testmode . $uniqid . strrev($this->key));
            $auth_code = md5($auth_code . strrev($this->key));
            $product_id = $this->encode4java($this->productid, 'decbin');
            $tariff_id = $this->encode4java($this->tariffid, 'decbin');
            $amount = $this->encode4java($amount, 'decbin');
            $test_mode = $this->encode4java($this->testmode, 'decbin');
            $uniqid = $this->encode4java($uniqid, 'decbin');
            $api_signature = $this->encode($this->api_signature);
            $api_user = $this->encode($this->api_user);
            $api_pw = $this->encode($this->api_password);
        } else {
            $auth_code = $this->encode($this->authcode);
            $product_id = $this->encode($this->productid);
            $tariff_id = $this->encode($this->tariffid);
            $amount = $this->encode($amount);
            $test_mode = $this->encode($this->testmode);
            $uniqid = $this->encode($uniqid);
            $hash = $this->hash(array('auth_code' => $auth_code, 'product_id' => $product_id, 'tariff' => $tariff_id, 'amount' => $amount, 'test_mode' => $test_mode, 'uniqid' => $uniqid));
            $api_signature = $this->encode($this->api_signature);
            $api_user = $this->encode($this->api_user);
            $api_pw = $this->encode($this->api_password);
        }
        $user_ip = $this->getRealIpAddr();
        
        $firstname = !empty($order->customer['firstname']) ? $order->customer['firstname'] : $order->billing['firstname'];
        $lastname = !empty($order->customer['lastname']) ? $order->customer['lastname'] : $order->billing['lastname'];
        $street_address = !empty($order->customer['street_address']) ? $order->customer['street_address'] : $order->billing['street_address'];
        $city = !empty($order->customer['city']) ? $order->customer['city'] : $order->billing['city'];
        $postcode = !empty($order->customer['postcode']) ? $order->customer['postcode'] : $order->billing['postcode'];
        $country_iso_code_2 = !empty($order->customer['country']['iso_code_2']) ? $order->customer['country']['iso_code_2'] : $order->billing['country']['iso_code_2'];
        $shop_url = '';
        if ($this->is_ajax) {
            $firstname = (mb_detect_encoding($firstname, 'UTF-8', false) == 'UTF-8') ? utf8_decode($firstname) : $firstname;
            $lastname = (mb_detect_encoding($lastname, 'UTF-8', false) == 'UTF-8') ? utf8_decode($lastname) : $lastname;
            $street_address = (mb_detect_encoding($street_address, 'UTF-8', false) == 'UTF-8') ? utf8_decode($street_address) : $street_address;
            $city = (mb_detect_encoding($city, 'UTF-8', false) == 'UTF-8') ? utf8_decode($city) : $city;
            $email = (mb_detect_encoding($order->customer['email_address'], 'UTF-8', false) == 'UTF-8') ? utf8_decode($order->customer['email_address']) : $order->customer['email_address'];
        }

        $shop_url = (ENABLE_SSL ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG;
        $process_button_string =
                xtc_draw_hidden_field('api_signature', $api_signature) .
                xtc_draw_hidden_field('api_user', $api_user) .
                xtc_draw_hidden_field('api_pw', $api_pw) .
                xtc_draw_hidden_field('vendor', $this->vendorid) .
                xtc_draw_hidden_field('auth_code', $auth_code) .
                xtc_draw_hidden_field('product', $product_id) .
                xtc_draw_hidden_field('tariff', $tariff_id) .
                xtc_draw_hidden_field('test_mode', $test_mode) .
                xtc_draw_hidden_field('uniqid', $uniqid) .
                xtc_draw_hidden_field('amount', $amount) .
                xtc_draw_hidden_field('hash', $hash) .
                xtc_draw_hidden_field('key', $this->KEY) .
                xtc_draw_hidden_field('currency', $order->info['currency']) .
                xtc_draw_hidden_field('first_name', $firstname) .
                xtc_draw_hidden_field('last_name', $lastname) .
                xtc_draw_hidden_field('email', $email) .
                xtc_draw_hidden_field('street', $street_address) .
                xtc_draw_hidden_field('city', $city) .
                xtc_draw_hidden_field('gender', 'u') .
                xtc_draw_hidden_field('search_in_street', '1') .
                xtc_draw_hidden_field('zip', $postcode) .
                xtc_draw_hidden_field('country', $country_iso_code_2) .
                xtc_draw_hidden_field('country_code', $country_iso_code_2) .
                xtc_draw_hidden_field('lang', MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_LANG) . #default: 'DE'
                xtc_draw_hidden_field('language', MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_LANG) . #default: 'DE'
                xtc_draw_hidden_field('remote_ip', $user_ip) . #Pflicht
                xtc_draw_hidden_field('tel', $order->customer['telephone']) .
                xtc_draw_hidden_field('fax', $customer['customers_fax']) .
                xtc_draw_hidden_field('birth_date', $customer['customers_dob']) .
                xtc_draw_hidden_field('session', $_SESSION['tmp_oID']) .
                xtc_draw_hidden_field('return_url', xtc_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')) .
                xtc_draw_hidden_field('return_method', 'POST') .
                xtc_draw_hidden_field('error_return_url', xtc_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')) .
                xtc_draw_hidden_field('customer_no', $customer_no) .
                xtc_draw_hidden_field('use_utf8', '1') .
                xtc_draw_hidden_field('user_variable_0', $shop_url) .
                xtc_draw_hidden_field('implementation', strtoupper($this->implementation)) .
                xtc_draw_hidden_field('error_return_method', 'POST');
        return $process_button_string;
    }

    /**
     * Checking the server Response
     *
     * @return void
     */
    function before_process() {
        global $HTTP_POST_VARS, $_POST, $order, $currencies, $customer_id;
        if ($_POST['tid'] && $_POST['status'] == '100' || $_POST['status'] == '90') {
            if ($this->order_status) {
                $order->info['order_status'] = $this->order_status;
            }
            //if($_POST['status'] == '90'){
            //$order->info['order_status'] = 1;
            //}   
            $test_mode = $this->testmode;
            $old_comments = $order->info['comments'];
            $order->info['comments'] = '';
            
            
            if (strtoupper($this->implementation) == 'JAVA') {
				$server_test_mode = $this->encode4java($_POST['test_mode'], 'bindec');
			}else{
				$server_test_mode = $this->decode($_POST['test_mode']);
			}
			$test_order_status = ((((isset($server_test_mode)) && $server_test_mode == 1) || (isset($this->testmode) && $this->testmode == 1)) ? 1 : 0 );
            if ($test_order_status == 1) {
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PAYPAL_TEST_ORDER_MESSAGE;
            }

            $_SESSION['nn_tid_paypal'] = $_POST['tid'];
            $newlinebreak = "\n";
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PAYPAL_TID_MESSAGE . $_POST['tid'] . $newlinebreak;
            $order->info['comments'] .= $old_comments;
            #todo: 
        } else {
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_decode($_POST['status_text']));
            if ($this->is_ajax) {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, '', 'SSL', true, false) . '?' . $payment_error_return);
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            }
        }
    }

    /*
     * Sending the postback params to Novalnet 
     * Updating to order details into  Sho DB
     * 
     * @return boolean
     */

    function after_process() {
        global $order, $customer_id, $insert_id;
        if ($this->order_status) {
            xtc_db_query("UPDATE " . TABLE_ORDERS . " SET orders_status='" . $this->order_status . "' WHERE orders_id='" . $insert_id . "'");
        }

        if (isset($_SESSION['nn_tid_paypal'])) {
            ### Pass the Order Reference to paygate ##
            $url = 'https://payport.novalnet.de/paygate.jsp';
            $urlparam = 'vendor=' . $this->vendorid . '&product=' . $this->productid . '&key=' . $this->KEY . '&tariff=' . $this->tariffid;
            $urlparam .= '&order_no=' . $insert_id;
            $urlparam .= '&auth_code=' . $this->authcode . '&status=100&tid=' . $_SESSION['nn_tid_paypal'] . '&vwz2=' . MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_ORDERNO . '' . $insert_id . '&vwz3=' . MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_ORDERDATE . '' . date('Y-m-d H:i:s');
            $this->perform_https_request($url, $urlparam);
        }
		if(isset($_SESSION['nn_tid_invoice'])) unset($_SESSION['nn_tid_invoice']);
		if(isset($_SESSION['nn_tid_elv_at'])) unset($_SESSION['nn_tid_elv_at']);
		if(isset($_SESSION['nn_tid_elv_de'])) unset($_SESSION['nn_tid_elv_de']);   
		if(isset($_SESSION['nn_tid_tel'])) unset($_SESSION['nn_tid_tel']);        
        unset($_SESSION['nn_tid_paypal']);
        ### Implement here the Emailversand and further functions, incase if you want to send a own email ###
        return false;
    }

    /*
     * Used to display error message details
     * function call at checkout_payment.php
     *
     *  @return array
     */

    function get_error() {
        global $HTTP_GET_VARS, $_GET;
        if ($this->is_ajax) {
            unset($_SESSION['shipping']);
        }
        if (count($HTTP_GET_VARS) == 0 || $HTTP_GET_VARS == '')
            $HTTP_GET_VARS = $_GET;
        $error = array('title' => MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_ERROR, 'error' => stripslashes(html_entity_decode($HTTP_GET_VARS['error'])));
        return $error;
    }

    /*
     * Check to see whether module is installed
     *
     *  @return boolean
     */

    function check() {
        if (!isset($this->_check)) {
            $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_NOVALNET_PAYPAL_STATUS'");
            $this->_check = xtc_db_num_rows($check_query);
        }
        return $this->_check;
    }

    /*
     * 
     * Install the payment module and its configuration settings
     *
     * @ return void
     */

    function install() {
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_ALLOWED', '', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_STATUS', 'True', '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_TEST_MODE', 'True', '6', '2', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_PASSWORD', '', '6', '3', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_VENDOR_ID', '', '6', '4', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_AUTH_CODE', '', '6', '5', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_PRODUCT_ID', '', '6', '6', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_TARIFF_ID', '', '6', '7', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_SORT_ORDER', '0', '6', '8', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_ORDER_STATUS_ID', '0', '6', '9', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_ZONE', '0', '6', '10', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_INFO', '', '6', '11', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_PROXY', '', '6', '12', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_API_USER', '', '6', '13', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_API_PASSWORD', '', '6', '14', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_PAYPAL_API_SIGNATURE', '', '6', '15', now())");
    }

    /*
     * 
     * Remove the module and all its settings
     * @ return void
     */

    function remove() {
        xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    /*
     * Internal list of configuration keys used for configuration of the module
     *  
     * @return array
     */

    function keys() {
        return array('MODULE_PAYMENT_NOVALNET_PAYPAL_ALLOWED', 'MODULE_PAYMENT_NOVALNET_PAYPAL_STATUS', 'MODULE_PAYMENT_NOVALNET_PAYPAL_TEST_MODE', 'MODULE_PAYMENT_NOVALNET_PAYPAL_VENDOR_ID', 'MODULE_PAYMENT_NOVALNET_PAYPAL_AUTH_CODE', 'MODULE_PAYMENT_NOVALNET_PAYPAL_PRODUCT_ID', 'MODULE_PAYMENT_NOVALNET_PAYPAL_TARIFF_ID', 'MODULE_PAYMENT_NOVALNET_PAYPAL_INFO', 'MODULE_PAYMENT_NOVALNET_PAYPAL_SORT_ORDER', 'MODULE_PAYMENT_NOVALNET_PAYPAL_ORDER_STATUS_ID', 'MODULE_PAYMENT_NOVALNET_PAYPAL_ZONE', 'MODULE_PAYMENT_NOVALNET_PAYPAL_PASSWORD', 'MODULE_PAYMENT_NOVALNET_PAYPAL_PROXY', 'MODULE_PAYMENT_NOVALNET_PAYPAL_API_USER', 'MODULE_PAYMENT_NOVALNET_PAYPAL_API_PASSWORD', 'MODULE_PAYMENT_NOVALNET_PAYPAL_API_SIGNATURE');
    }

    function html_to_utf8($data) {
        $data = utf8_encode($data);
        return preg_replace("/\\&\\#([0-9]{3,10})\\;/e", '$this->_html_to_utf8("\\1")', $data);
    }

    function _html_to_utf8($data) {
        if ($data > 127) {
            $i = 5;
            while (($i--) > 0) {
                if ($data != ($a = $data % ($p = pow(64, $i)))) {
                    $ret = chr(base_convert(str_pad(str_repeat(1, $i + 1), 8, "0"), 2, 10) + (($data - $a) / $p));
                    for ($i; $i > 0; $i--)
                        $ret .= chr(128 + ((($data % pow(64, $i)) - ($data % ($p = pow(64, $i - 1)))) / $p));
                    break;
                }
            }
        } else {
            $ret = "&#$data;";
        }
        return $ret;
    }

    function debug2($text) {
        $fh = fopen('/tmp/debug2.txt', 'a+');
        if (gettype($text) == 'class' or gettype($text) == 'array') {
            $text = serialize($text);
            fwrite($fh, $text);
        } else {
            fwrite($fh, date('H:i:s ') . $text . "\n");
        }
        fclose($fh);
    }

    function getAmount($amount) {
        if (!$amount)
            $amount = $order->info['total'];
        if (preg_match('/[,.]$/', $amount)) {
            $amount = $amount . '00';
        } else if (preg_match('/[,.][0-9]$/', $amount)) {
            $amount = $amount . '0';
        }
        $amount = str_replace(array('.', ','), array('', ''), $amount);
        return$amount;
    }

    /**
     * to check IP
     *
     * @param int
     * 
     * @return boolean
     */
    function isPublicIP($value) {
        if (!$value || count(explode('.', $value)) != 4)
            return false;
        return !preg_match('~^((0|10|172\.16|192\.168|169\.254|255|127\.0)\.)~', $value);
    }

    /**
     * get the real Ip Adress of the User ###
     *
     * @return String 
     */
    function getRealIpAddr() {
        if ($this->isPublicIP($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        if ($iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])) {
            if ($this->isPublicIP($iplist[0]))
                return $iplist[0];
        }
        if ($this->isPublicIP($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
        if ($this->isPublicIP($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        if ($this->isPublicIP($_SERVER['HTTP_FORWARDED_FOR']))
            return $_SERVER['HTTP_FORWARDED_FOR'];
        return $_SERVER['REMOTE_ADDR'];
    }

    /*
     * replace the Special German Charectors
     *
     * @return array
     */

    function ReplaceSpecialGermanChars($vOriginalString) {
        $vSomeSpecialChars = array("�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�");
        $vReplacementChars = array("ae", "ee", "ie", "oe", "ue", "Ae", "Ee", "Ie", "Oe", "Ue", "ne", "Ne", "ae", "oe", "ue", "Ae", "Oe", "Ue", "ss", "ee");
        $vReplacedString = str_replace($vSomeSpecialChars, $vReplacementChars, $vOriginalString);
        return $vReplacedString;
    }

    /*
     *  for email validation
     *
     * @return boolean
     */

    function emailVaildate($email) {
        if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
            return false; //Invalid email
        } else {
            return true;  //Valid email
        }
    }

    function getParams4paypal() {
        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;
        $params = xtc_draw_hidden_field('user_variable_0', (str_replace(array('http://', 'www.'), array('', ''), HTTP_SERVER)));
        return$params;
    }

    /*
     * Realtime accesspoint for communication to the Novalnet paygate
     *  
     * @return array
     */

    function perform_https_request($nn_url, $urlparam) {
        $debug = 0; #set it to 1 if you want to activate the debug mode

        if ($debug)
            print "<BR>perform_https_request: $nn_url<BR>\n\r\n";
        if ($debug)
            print "perform_https_request: $urlparam<BR>\n\r\n";

        ## some prerquisites for the connection
        $ch = curl_init($nn_url);
        curl_setopt($ch, CURLOPT_POST, 1);  // a non-zero parameter tells the library to do a regular HTTP post.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $urlparam);  // add POST fields
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);  // don't allow redirects
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // decomment it if you want to have effective ssl checking
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // decomment it if you want to have effective ssl checking
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 240);  // maximum time, in seconds, that you'll allow the CURL functions to take
        if ($this->proxy) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        }

        ## establish connection
        $data = curl_exec($ch);
        $data = $this->ReplaceSpecialGermanChars($data);

        ## determine if there were some problems on cURL execution
        $errno = curl_errno($ch);
        $errmsg = curl_error($ch);

        ###bug fix for PHP 4.1.0/4.1.2 (curl_errno() returns high negative value in case of successful termination)
        if ($errno < 0)
            $errno = 0;
        ##bug fix for PHP 4.1.0/4.1.2

        if ($debug) {
            print_r(curl_getinfo($ch));
            echo "\n<BR><BR>\n\n\nperform_https_request: cURL error number:" . $errno . "\n<BR>\n\n";
            echo "\n\n\nperform_https_request: cURL error:" . $errmsg . "\n<BR>\n\n";
        }

        #close connection
        curl_close($ch);

        ## read and return data from novalnet paygate
        if ($debug)
            print "<BR>\n\n" . $data . "\n<BR>\n\n";

        return array($errno, $errmsg, $data);
    }

    function encode($data) {
        $data = trim($data);
        if ($data == '')
            return'Error: no data';
        if (!function_exists('base64_encode') or !function_exists('pack') or !function_exists('crc32')) {
            return'Error: func n/a';
        }

        try {
            $crc = sprintf('%u', crc32($data)); # %u is a must for ccrc32 returns a signed value
            $data = $crc . "|" . $data;
            $data = bin2hex($data . $this->key);
            $data = strrev(base64_encode($data));
        } catch (Exception $e) {
            echo('Error: ' . $e);
        }
        return $data;
    }

    function decode($data) {
        $data = trim($data);
        if ($data == '') {
            return'Error: no data';
        }
        if (!function_exists('base64_decode') or !function_exists('pack') or !function_exists('crc32')) {
            return'Error: func n/a';
        }

        try {
            $data = base64_decode(strrev($data));
            $data = pack("H" . strlen($data), $data);
            $data = substr($data, 0, stripos($data, $this->key));
            $pos = strpos($data, "|");
            if ($pos === false) {
                return("Error: CKSum not found!");
            }
            $crc = substr($data, 0, $pos);
            $value = trim(substr($data, $pos + 1));
            if ($crc != sprintf('%u', crc32($value))) {
                return("Error; CKSum invalid!");
            }
            return $value;
        } catch (Exception $e) {
            echo('Error: ' . $e);
        }
    }

    function hash($h) {
        global $amount_zh;
        if (!$h)
            return'Error: no data';
        if (!function_exists('md5')) {
            return'Error: func n/a';
        }
        return md5($h['auth_code'] . $h['product_id'] . $h['tariff'] . $h['amount'] . $h['test_mode'] . $h['uniqid'] . strrev($this->key));
    }

    function checkHash($request) {
        if (!$request)
            return false;#'Error: no data';
        $h['auth_code'] = $request['auth_code']; #encoded
        $h['product_id'] = $request['product']; #encoded
        $h['tariff'] = $request['tariff']; #encoded
        $h['amount'] = $request['amount']; #encoded
        $h['test_mode'] = $request['test_mode']; #encoded
        $h['uniqid'] = $request['uniqid']; #encoded
        if ($request['hash2'] != $this->hash($h)) {
            return false;
        }
        return true;
    }

    function checkHash4java($request) {
        if (!$request)
            return false;#'Error: no data';
        $h['auth_code'] = $request['auth_code']; #encoded
        $h['product_id'] = $request['product_id']; #encoded
        $h['tariff'] = $request['tariff_id']; #encoded
        $h['amount'] = $request['amount']; #encoded
        $h['test_mode'] = $request['test_mode']; #encoded
        $h['uniqid'] = $request['uniqid']; #encoded

        if ($request['hash2'] != $this->hash($h)) {
            return false;
        }
        return true;
    }

    function encode4java($data = '', $func = '') {
        $salt = 1010;
        if (!isset($data) or trim($data) == '' or !$func) {
            return'Error: missing arguments: $str and/or $func!';
        }
        if ($func != 'decbin' and $func != 'bindec') {
            return'Error: $func has wrong value!';
        }
        if ($func == 'decbin') {
            return decbin(intval($data) + intval($salt));
        } else {
            return bindec($data) - intval($salt);
        }
    }

}

/*
  order of functions:
  selection              -> $order-info['total'] wrong, cause shipping_cost is net
  pre_confirmation_check -> $order-info['total'] wrong, cause shipping_cost is net
  confirmation           -> $order-info['total'] right, cause shipping_cost is gross
  process_button         -> $order-info['total'] right, cause shipping_cost is gross
  before_process         -> $order-info['total'] wrong, cause shipping_cost is net
  after_process          -> $order-info['total'] right, cause shipping_cost is gross
*/
