<?php

#########################################################
#                                                       #
#  CCPCI / CREDIT CARD PCI payment method class     	#
#  This module is used for real time processing of      #
#  Credit card data of customers.     					#
#                                                       #
#  Released under the GNU General Public License.       #
#  This free contribution made by request.              #
#  If you have found this script useful a small         #
#  recommendation as well as a comment on merchant form #
#  would be greatly appreciated.                        #
#                                                       #
#  Script : novalnet_cc_pci.php                         #
#                                                       #
#########################################################

class novalnet_cc_pci {

    var $code;
    var $title;
    var $description;
    var $enabled;
    var $is_ajax = false;
    var $key;
    var $implementation;
    var $KEY = 6;
    var $tot_amount;
    var $vendorid;
    var $productid;
    var $authcode;
    var $tariffid;
    var $testmode;
    var $password;
    var $manual_check_limit;
    var $productid_2;
    var $tariffid_2;
    var $logo_title;
    var $payment_logo_title;
    var $image;

    /**
     * Initalze the novalnet credit card PCI method
     *
     */
    function novalnet_cc_pci() {
        global $order;
        $this->code = 'novalnet_cc_pci';
        $this->form_action_url = 'https://payport.novalnet.de/pci_payport';
        $this->logo_title = MODULE_PAYMENT_NOVALNET_CC_PCI_LOGO_TITLE;
        $this->payment_logo_title = MODULE_PAYMENT_NOVALNET_CC_PCI_PAYMENT_LOGO_TITLE;
        $this->title = MODULE_PAYMENT_NOVALNET_CC_PCI_TEXT_TITLE . '<br>' . $this->logo_title . $this->payment_logo_title;
        $this->public_title = MODULE_PAYMENT_NOVALNET_CC_PCI_TEXT_PUBLIC_TITLE;
        $this->description = MODULE_PAYMENT_NOVALNET_CC_PCI_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_PAYMENT_NOVALNET_CC_PCI_SORT_ORDER;
        $this->enabled = ((MODULE_PAYMENT_NOVALNET_CC_PCI_STATUS == 'True') ? true : false);
        $this->proxy = MODULE_PAYMENT_NOVALNET_CC_PCI_PROXY;
        $this->key = trim(MODULE_PAYMENT_NOVALNET_CC_PCI_PASSWORD);
        $this->image = ( MODULE_PAYMENT_ENABLE_NOVALNET_LOGO == 1) ? $this->logo_title . $this->payment_logo_title : $this->payment_logo_title;
        $this->implementation = 'PHP_PCI'; #'JAVA', 'PHP', '', if empty, then equal to 'PHP'
        $this->doAssignConfigVarsToMembers();
        $this->checkConfigure();
        if (CHECKOUT_AJAX_STAT == 'true') {
            $this->is_ajax = true;
        }
        #check encoded data
        if ($_REQUEST['hash2'] && $_SESSION['payment'] == $this->code) {
            if (strtoupper($this->implementation) == 'JAVA') {#Java encoded
                if ($_REQUEST['auth_code'] != md5($this->authcode . strrev($this->key))) {
                    $err = MODULE_PAYMENT_NOVALNET_CC_PCI_TEXT_HASH_ERROR . '; wrong auth_code!';
                    $payment_error_return = 'payment_error=novalnet_cc_pci&error=' . $_REQUEST['status_text'] . (isset($err) ? ';' . utf8_encode($err) : '');
                    if ($this->is_ajax) {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, $payment_error_return, 'SSL', true, false));
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                }
                $_REQUEST['auth_code'] = $this->authcode; #todo: check?
                $_REQUEST['product_id'] = $this->encode4java($_REQUEST['product'], 'bindec');
                $_REQUEST['tariff_id'] = $this->encode4java($_REQUEST['tariff'], 'bindec');
                $_REQUEST['amount'] = $this->encode4java($_REQUEST['amount'], 'bindec');
                $_REQUEST['test_mode'] = $this->encode4java($_REQUEST['test_mode'], 'bindec');
                $_REQUEST['uniqid'] = $this->encode4java($_REQUEST['uniqid'], 'bindec');
                if (!$this->checkHash4java($_REQUEST)) {#PHP encoded
                    $err = MODULE_PAYMENT_NOVALNET_CC_PCI_TEXT_HASH_ERROR;
                    $payment_error_return = 'payment_error=novalnet_cc_pci&error=' . $_REQUEST['status_text'] . (isset($err) ? ';' . utf8_encode($err) : '');
                    if ($this->is_ajax) {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, '', 'SSL', true, false) . '?' . $payment_error_return);
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                }
            } else {#PHP encoded
                if (!$this->checkHash($_REQUEST)) {
                    $err = MODULE_PAYMENT_NOVALNET_CC_PCI_TEXT_HASH_ERROR;
                    $payment_error_return = 'payment_error=novalnet_cc_pci&error=' . $_REQUEST['status_text'] . (isset($err) ? ';' . utf8_encode($err) : '');
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
        if ((int) MODULE_PAYMENT_NOVALNET_CC_PCI_ORDER_STATUS_ID > 0) {
            $this->order_status = MODULE_PAYMENT_NOVALNET_CC_PCI_ORDER_STATUS_ID;
        }
        if (is_object($order))
            $this->update_status();
        if ($_POST['session'] && $_SESSION['payment'] == $this->code) {
            $this->checkSecurity();
        }
    }

    /**
     * Set all the backend parameters required by novalnet payment gateway for processing payment
     *
     * @return void
     */
    function doAssignConfigVarsToMembers() {
        $this->vendorid = trim(MODULE_PAYMENT_NOVALNET_CC_PCI_VENDOR_ID);
        $this->productid = trim(MODULE_PAYMENT_NOVALNET_CC_PCI_PRODUCT_ID);
        $this->authcode = trim(MODULE_PAYMENT_NOVALNET_CC_PCI_AUTH_CODE);
        $this->tariffid = trim(MODULE_PAYMENT_NOVALNET_CC_PCI_TARIFF_ID);
        $this->testmode = (strtolower(MODULE_PAYMENT_NOVALNET_CC_PCI_TEST_MODE) == 'true' or MODULE_PAYMENT_NOVALNET_CC_PCI_TEST_MODE == '1') ? 1 : 0;
        $this->password = trim(MODULE_PAYMENT_NOVALNET_CC_PCI_PASSWORD);
        $this->manual_check_limit = trim(MODULE_PAYMENT_NOVALNET_CC_PCI_MANUAL_CHECK_LIMIT);
        $this->productid_2 = trim(MODULE_PAYMENT_NOVALNET_CC_PCI_PRODUCT_ID2);
        $this->tariffid_2 = trim(MODULE_PAYMENT_NOVALNET_CC_PCI_TARIFF_ID2);
        $this->manual_check_limit = str_replace(' ', '', $this->manual_check_limit);
        $this->manual_check_limit = str_replace(',', '', $this->manual_check_limit);
        $this->manual_check_limit = str_replace('.', '', $this->manual_check_limit);
    }

    /**
     * To check manual check limit
     *
     * @return void
     */
    function doCheckManualCheckLimit($amount) {
        if ($this->manual_check_limit && $amount >= $this->manual_check_limit) {
            if ($this->productid_2 != '' && $this->tariffid_2 != '') {
                $this->productid = $this->productid_2;
                $this->tariffid = $this->tariffid_2;
            }
        }
    }

    /**
     * Test configure values and test mode in admin panel
     *
     * @return void
     */
    function checkConfigure() {
        if (IS_ADMIN_FLAG == true) {
            if ($this->enabled == 'true' && (empty($this->vendorid) || empty($this->productid) || empty($this->authcode) || empty($this->tariffid) || empty($this->password))) {
                $this->title .= '<br>' . MODULE_PAYMENT_NOVALNET_CC_PCI_NOT_CONFIGURED;
            } elseif ($this->testmode == '1') {
                $this->title .= '<br>' . MODULE_PAYMENT_NOVALNET_CC_PCI_IN_TEST_MODE;
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
        if (($this->enabled == true) && ((int) MODULE_PAYMENT_NOVALNET_CC_PCI_ZONE > 0)) {
            $check_flag = false;
            $check_query = xtc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_NOVALNET_CC_PCI_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
     * Builds set of fields for front end
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
						array('title' => '', 'field' => $this->image . $this->description),
						array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_CC_PCI_INFO),
						array('title' => '', 'field' =>$mode)
                    ));
        if (function_exists(get_percent)) {
            $selection['module_cost'] = $GLOBALS['ot_payment']->get_percent($this->code);
        }
        return $selection;
    }

    /**
     * Precheck to Evaluate Novalnet backend params
     *
     *
     * @return void
     */
    function pre_confirmation_check($vars) {
        global $order;
        if (!$this->emailVaildate($order->customer['email_address'])) {
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode('Please enter the valid email Id'));
            if ($this->is_ajax) {
                $_SESSION['checkout_payment_error'] = $payment_error_return;
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            }
        }

        $error = '';
        /* Start : Validation */
        if (empty($this->vendorid) || empty($this->productid) || empty($this->authcode) || empty($this->tariffid) || empty($this->password)) {
            $error = MODULE_PAYMENT_NOVALNET_CC_PCI_TEXT_JS_NN_MISSING;
        } elseif ($this->manual_check_limit > 0) {
            if (empty($this->productid_2) || empty($this->tariffid_2)) {
                $error = MODULE_PAYMENT_NOVALNET_CC_PCI_TEXT_JS_NN_ID2_MISSING;
            }
        }
        /* End : Validation */

        if ($error != '') {
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode($error));
            if ($this->is_ajax) {
                $_SESSION['checkout_payment_error'] = $payment_error_return;
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            }
        }
        // Check shipping methods are selected or not;
        if (!$order->info['shipping_method']) {
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_CC_PCI_REQUEST_FOR_CHOOSE_SHIPPING_METHOD));
            $_SESSION['checkout_payment_error'] = $payment_error_return;
            return;
        }
    }

    /**
     * Display Information on the Checkout Confirmation Page
     *
     *
     * @return array
     */
    function confirmation() {
        global $HTTP_POST_VARS, $_POST, $order;
        $total = $this->findTotalAmount();
        $_SESSION['nn_total_cc_pci'] = $total;
        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;
        return $confirmation;
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
     * Build the data and actions to process when the "Submit" button is pressed on the order-confirmation screen.
     * These are hidden fields on the checkout confirmation page
     *
     * @return string
     */
    function process_button() {
        global $order, $currencies, $customer_id;
        #Get the required additional customer details from DB
        $customer_query = xtc_db_query("SELECT customers_gender, customers_dob, customers_fax FROM " . TABLE_CUSTOMERS . " WHERE customers_id='" . (int) $customer_id . "'");

        $nn_customer_id = (isset($_SESSION['customer_id'])) ? $_SESSION['customer_id'] : '';
        $customer_query = xtc_db_query("SELECT customers_gender, customers_dob, customers_fax, customers_status FROM " . TABLE_CUSTOMERS . " WHERE customers_id='" . (int) $nn_customer_id . "'");
        $customer = xtc_db_fetch_array($customer_query);
        $nncustomer_no = ($customer_query->fields['customers_status'] != 1) ? $nn_customer_id : NOVALNET_GUEST_USER;
        if (trim($order->customer['csID']))
            $customer_no = $order->customer['csID'];
        else
            $customer_no = $nncustomer_no;
        list($customer['customers_dob'], $extra) = explode(' ', $customer['customers_dob']);
        $auth_code = $this->authcode;
        $this->tot_amount = $amount = $this->findTotalAmount();
        list($product_id, $tariff_id) = $this->get_prod_tarif_id($amount);
        $uniqid = uniqid();
        $test_mode = $this->testmode;
        $_SESSION['test_mode_cc_pci'] = $this->testmode;
        if (strtoupper($this->implementation) == 'JAVA') {
            $uniqid = time(); #must ne a long integer
            $hash = md5($auth_code . $product_id . $tariff_id . $amount . $test_mode . $uniqid . strrev($this->key));
            $auth_code = md5($auth_code . strrev($this->key));
            $product_id = $this->encode4java($product_id, 'decbin');
            $tariff_id = $this->encode4java($tariff_id, 'decbin');
            $amount = $this->encode4java($amount, 'decbin');
            $test_mode = $this->encode4java($test_mode, 'decbin');
            $uniqid = $this->encode4java($uniqid, 'decbin');
        } else {
            $auth_code = $this->encode($auth_code);
            $product_id = $this->encode($product_id);
            $tariff_id = $this->encode($tariff_id);
            $amount = $this->encode($amount);
            $test_mode = $this->encode($test_mode);
            $uniqid = $this->encode($uniqid);
            $hash = $this->hash(array('auth_code' => $auth_code, 'product_id' => $product_id, 'tariff' => $tariff_id, 'amount' => $amount, 'test_mode' => $test_mode, 'uniqid' => $uniqid));
        }
        $user_ip = $this->getRealIpAddr();
        if ($this->is_ajax)
            $checkout_url = xtc_href_link(FILENAME_CHECKOUT, '', 'SSL');
        else
            $checkout_url = xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL');
        if (strstr($checkout_url, '?')) {
            $checkout_url = str_replace(' ', '', $checkout_url);
            if (substr($checkout_url, -1) == '?')
                $error_url = $checkout_url . 'payment_error=novalnet_cc_pci&error=$ERROR_MESSAGE ($STATUS)';
            else
                $error_url = $checkout_url . '&payment_error=novalnet_cc_pci&error=$ERROR_MESSAGE ($STATUS)';
        }
        else
            $error_url = $checkout_url . '?payment_error=novalnet_cc_pci&error=$ERROR_MESSAGE ($STATUS)';


        $firstname = !empty($order->customer['firstname']) ? $order->customer['firstname'] : $order->billing['firstname'];
        $lastname = !empty($order->customer['lastname']) ? $order->customer['lastname'] : $order->billing['lastname'];
        $email_address = !empty($order->customer['email_address']) ? $order->customer['email_address'] : $order->billing['email_address'];
        $street_address = !empty($order->customer['street_address']) ? $order->customer['street_address'] : $order->billing['street_address'];
        $city = !empty($order->customer['city']) ? $order->customer['city'] : $order->billing['city'];
        $postcode = !empty($order->customer['postcode']) ? $order->customer['postcode'] : $order->billing['postcode'];
        $country_iso_code_2 = !empty($order->customer['country']['iso_code_2']) ? $order->customer['country']['iso_code_2'] : $order->billing['country']['iso_code_2'];

        if ($this->is_ajax) {
            $firstname = (mb_detect_encoding($firstname, 'UTF-8', false) == 'UTF-8') ? utf8_decode($firstname) : $firstname;
            $lastname = (mb_detect_encoding($lastname, 'UTF-8', false) == 'UTF-8') ? utf8_decode($lastname) : $lastname;
            $street_address = (mb_detect_encoding($street_address, 'UTF-8', false) == 'UTF-8') ? utf8_decode($street_address) : $street_address;
            $city = (mb_detect_encoding($city, 'UTF-8', false) == 'UTF-8') ? utf8_decode($city) : $city;
            $email = (mb_detect_encoding($email_address, 'UTF-8', false) == 'UTF-8') ? utf8_decode($email_address) : $email_address;
        }
        $process_button_string = xtc_draw_hidden_field('vendor_id', $this->vendorid) .
                xtc_draw_hidden_field('vendor_authcode', $auth_code) .
                xtc_draw_hidden_field('product_id', $product_id) .
                xtc_draw_hidden_field('tariff_id', $tariff_id) .
                xtc_draw_hidden_field('test_mode', $test_mode) .
                xtc_draw_hidden_field('uniqid', $uniqid) .
                xtc_draw_hidden_field('amount', $amount) .
                xtc_draw_hidden_field('hash', $hash) .
                xtc_draw_hidden_field('payment_id', $this->KEY) .
                xtc_draw_hidden_field('currency', $order->info['currency']) .
                xtc_draw_hidden_field('firstname', $firstname) .
                xtc_draw_hidden_field('lastname', $lastname) .
                xtc_draw_hidden_field('email', $email) .
                xtc_draw_hidden_field('street', $street_address) .
                xtc_draw_hidden_field('city', $city) .
                xtc_draw_hidden_field('gender', 'u') .
                xtc_draw_hidden_field('search_in_street', '1') .
                xtc_draw_hidden_field('zip', $postcode) .
                xtc_draw_hidden_field('country', $country_iso_code_2) .
                xtc_draw_hidden_field('country_code', $country_iso_code_2) .
                xtc_draw_hidden_field('lang', MODULE_PAYMENT_NOVALNET_CC_PCI_TEXT_LANG) .
                xtc_draw_hidden_field('language', MODULE_PAYMENT_NOVALNET_CC_PCI_TEXT_LANG) .
                xtc_draw_hidden_field('remote_ip', $user_ip) .
                xtc_draw_hidden_field('tel', $order->customer['telephone']) .
                xtc_draw_hidden_field('fax', $customer['customers_fax']) .
                xtc_draw_hidden_field('birthday', $customer['customers_dob']) .
                xtc_draw_hidden_field('session', $_SESSION['tmp_oID']) .
                xtc_draw_hidden_field('return_url', xtc_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')) .
                xtc_draw_hidden_field('return_method', 'POST') .
                //xtc_draw_hidden_field('error_return_url', $error_url) .
                xtc_draw_hidden_field('error_return_url', xtc_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')) .
                xtc_draw_hidden_field('customer_no', $customer_no) .
                xtc_draw_hidden_field('use_utf8', '1') .
                xtc_draw_hidden_field('implementation', strtoupper($this->implementation)) .
                xtc_draw_hidden_field('error_return_method', 'POST') .
                xtc_draw_hidden_field('tot_amount', $this->tot_amount);
        return $process_button_string;
    }

    /**
     * To Get Product and Tariff Id function
     * @param int amount
     *
     * @return array
     */
    function get_prod_tarif_id($amount) {
        $this->doCheckManualCheckLimit($amount);
        $product_id = $this->productid;
        $tariff_id = $this->tariffid;
        return array($product_id, $tariff_id);
    }

    /**
     * Checking the server Response
     *
     * @return void
     */
    function before_process() {
        global $_POST, $order;
        if ($_POST['status'] == 100) {
            $this->tot_amount = $_POST['tot_amount'];
            $customer_query = xtc_db_query("SHOW COLUMNS FROM " . TABLE_ORDERS); # . " WHERE FIELD='comments'");#MySQL Version 3/4 dislike WHERE CLAUSE here :-(
            while ($customer = xtc_db_fetch_array($customer_query)) {
                if (strtolower($customer['Field']) == 'comments' and strtolower($customer['Type']) != 'text') {
                    xtc_db_query("ALTER TABLE " . TABLE_ORDERS . " MODIFY comments text");
                }
            }
            if ($this->order_status) {
                $order->info['order_status'] = $this->order_status;
            }
            $test_mode = $this->testmode;
            $old_comments = $order->info['comments'];
            $order->info['comments'] = '';
            $server_testmode  = $this->decode($_POST['test_mode']);
            $test_order_status = ((isset($server_testmode) && $server_testmode == 1) || (isset($this->testmode) && $this->testmode == 1)) ? 1 : 0 ;
            if ($test_order_status == 1) {
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_CC_PCI_TEST_ORDER_MESSAGE;
            }
            
            
            $newlinebreak = "\n";
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_CC_PCI_TID_MESSAGE . $_POST['tid'] . $newlinebreak;
            //$order->info['comments']  = str_replace(array('<b>', '</b>','<B>','</B>', '<br>','<br />','<BR>'), array('', '', '','',"\n", "\n","\n"), $order->info['comments']);
            $order->info['comments'] .= $old_comments;
            $_SESSION['nn_tid_cc_pci'] = $_POST['tid'];
        } else {
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . $_REQUEST['status_text'] . (isset($err) ? ';' . utf8_encode($err) : '');
            if ($this->is_ajax) {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, '', 'SSL', true, false) . '?' . $payment_error_return);
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            }
        }
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

    /*
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
        $vSomeSpecialChars = array("Ã¡", "Ã©", "Ã­", "Ã³", "Ãº", "Ã�", "Ã‰", "Ã�", "Ã“", "Ãš", "Ã±", "Ã‘", "Ã¤", "Ã¶", "Ã¼", "Ã„", "Ã–", "Ãœ", "ÃŸ", "Ã«");
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

    /*
     * Sending the postback params to Novalnet
     * Updating to order details into  Sho DB
     *
     * @return boolean
     */

    function after_process() {
        global $order, $insert_id;
        if ($this->order_status) {
            xtc_db_query("UPDATE " . TABLE_ORDERS . " SET orders_status='" . $this->order_status . "' WHERE orders_id='" . $insert_id . "'");
        }
        list($product_id, $tariff_id) = $this->get_prod_tarif_id($this->tot_amount);
        if (isset($_SESSION['nn_tid_cc_pci'])) {
            $url = 'https://payport.novalnet.de/paygate.jsp';
            $urlparam = 'vendor=' . $this->vendorid . '&product=' . $product_id . '&key=' . $this->KEY . '&tariff=' . $tariff_id;
            $urlparam .= '&order_no=' . $insert_id;
            $urlparam .= '&auth_code=' . $this->authcode . '&status=100&tid=' . $_SESSION['nn_tid_cc_pci'] . '&vwz2=' . MODULE_PAYMENT_NOVALNET_CC_PCI_TEXT_ORDERNO . '' . $insert_id . '&vwz3=' . MODULE_PAYMENT_NOVALNET_CC_PCI_TEXT_ORDERDATE . '' . date('Y-m-d H:i:s');
            $this->perform_https_request($url, $urlparam);
            unset($_SESSION['nn_tid_cc_pci']);
        }
		if(isset($_SESSION['nn_tid_invoice'])) unset($_SESSION['nn_tid_invoice']);
		if(isset($_SESSION['nn_tid_elv_at'])) unset($_SESSION['nn_tid_elv_at']);
		if(isset($_SESSION['nn_tid_elv_de'])) unset($_SESSION['nn_tid_elv_de']);   
		if(isset($_SESSION['nn_tid_tel'])) unset($_SESSION['nn_tid_tel']);          
        unset($_SESSION['checkout_payment_error']);
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
        $error = array('title' => MODULE_PAYMENT_NOVALNET_CC_PCI_TEXT_ERROR, 'error' => stripslashes(html_entity_decode($HTTP_GET_VARS['error'])));
        return $error;
    }

    /*
     * Check to see whether module is installed
     *
     *  @return boolean
     */

    function check() {
        if (!isset($this->_check)) {
            $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_NOVALNET_CC_PCI_STATUS'");
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
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_ALLOWED', '', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_STATUS', 'True', '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_TEST_MODE', 'True', '6', '2', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_VENDOR_ID', '', '6', '3', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_AUTH_CODE', '', '6', '4', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_PRODUCT_ID', '', '6', '5', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_TARIFF_ID', '', '6', '6', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_MANUAL_CHECK_LIMIT', '', '6', '7', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_PRODUCT_ID2', '', '6', '8', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_TARIFF_ID2', '', '6', '9', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_PASSWORD', '', '6', '10', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_INFO', '', '6', '11', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_SORT_ORDER', '0', '6', '12', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_ORDER_STATUS_ID', '0', '6', '13', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_ZONE', '0', '6', '14', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PCI_PROXY', '', '6', '15', now())");
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
        return array('MODULE_PAYMENT_NOVALNET_CC_PCI_ALLOWED', 'MODULE_PAYMENT_NOVALNET_CC_PCI_STATUS', 'MODULE_PAYMENT_NOVALNET_CC_PCI_TEST_MODE', 'MODULE_PAYMENT_NOVALNET_CC_PCI_VENDOR_ID', 'MODULE_PAYMENT_NOVALNET_CC_PCI_AUTH_CODE', 'MODULE_PAYMENT_NOVALNET_CC_PCI_PRODUCT_ID', 'MODULE_PAYMENT_NOVALNET_CC_PCI_TARIFF_ID', 'MODULE_PAYMENT_NOVALNET_CC_PCI_MANUAL_CHECK_LIMIT', 'MODULE_PAYMENT_NOVALNET_CC_PCI_PRODUCT_ID2', 'MODULE_PAYMENT_NOVALNET_CC_PCI_TARIFF_ID2', 'MODULE_PAYMENT_NOVALNET_CC_PCI_PASSWORD', 'MODULE_PAYMENT_NOVALNET_CC_PCI_INFO', 'MODULE_PAYMENT_NOVALNET_CC_PCI_SORT_ORDER', 'MODULE_PAYMENT_NOVALNET_CC_PCI_ORDER_STATUS_ID', 'MODULE_PAYMENT_NOVALNET_CC_PCI_ZONE', 'MODULE_PAYMENT_NOVALNET_CC_PCI_PROXY');
    }

    function html_to_utf8($data) {
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

    function debug2($object, $filename, $debug = false) {
        if (!$debug) {
            return;
        }
        $fh = fopen("/tmp/$filename", 'a+');
        fwrite($fh, date('Y-m-d H:i:s') . ' ' . print_r($object, true));
        fwrite($fh, "<hr />\n");
        fclose($fh);
    }

    function checkSecurity() {
        global $_POST, $order, $insert_id;
        if (strlen(trim($_POST['tid'])) == 17 && $_POST['status'] == 100 && $_POST['session'] == $_COOKIE['XTCsid']) {
            #xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL'));
        } else {
            //$err                      = $_POST['status_desc']." (".$_POST['status'].")";
            $err = (!empty($_POST['status_desc'])) ? $_POST['status_desc'] : $_POST['status_text'];
            #'session missing or returned session is wrong';
            $order->info['comments'] .= NOVALNET_TEXT_ERROR_MESSAGE . $err;
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode($err));
            if ($this->is_ajax) {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, '', 'SSL', true, false) . '?' . $payment_error_return);
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            }
        }
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

    /*
     *
     * $h contains encoded data
     *
     */

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
        $h['auth_code'] = $request['vendor_authcode']; #encoded
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

    function checkHash4java($request) {
        if (!$request)
            return false;#'Error: no data';
        $h['auth_code'] = $request['vendor_authcode']; #encoded
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

    function debug($lineNo, $funcName, $fileName) {
        echo 'PHP File Name :' . basename($fileName) . '<BR>PHP Function name : ' . $funcName . '<br>PHP line no: ' . $lineNo . '';
        exit;
    }

}

/*
flow of functions:
selection              -> $order-info['total'] wrong, cause shipping_cost is net
pre_confirmation_check -> $order-info['total'] wrong, cause shipping_cost is net
confirmation           -> $order-info['total'] right, cause shipping_cost is gross
process_button         -> $order-info['total'] right, cause shipping_cost is gross
before_process         -> $order-info['total'] wrong, cause shipping_cost is net
after_process          -> $order-info['total'] right, cause shipping_cost is gross
---------------
flow of url/path:
/xtcommerce/account.php
/xtcommerce/account_history_info.php
/xtcommerce/address_book.php
/xtcommerce/checkout_shipping.php
/xtcommerce/checkout_shipping.php
/xtcommerce/checkout_payment.php
/xtcommerce/checkout_confirmation.php
*/
