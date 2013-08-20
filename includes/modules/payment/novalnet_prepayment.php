<?php

#########################################################
#                                                       #
#  PREPAYMENT payment method class                      #
#  This module is used for real time processing of      #
#  PREPAYMENT payment of customers.                     #
#                                                       #
#  Released under the GNU General Public License.       #
#  This free contribution made by request.              #
#  If you have found this script useful a small         #
#  recommendation as well as a comment on merchant form #
#  would be greatly appreciated.                        #
#                                                       #
#  Script : novalnet_prepayment.php                     #
#                                                       #
#########################################################
require_once (DIR_FS_INC . 'xtc_format_price_order.inc.php');

class novalnet_prepayment {

    var $code;
    var $title;
    var $description;
    var $enabled;
    var $blnDebug = false; #todo: set to false for live system
    var $proxy;
    var $KEY = 27;
    var $is_ajax = false;
    var $vendorid;
    var $productid;
    var $authcode;
    var $tariffid;
    var $testmode;
    var $logo_title;
    var $payment_logo_title;

    /**
     * Constructor 
     *
     * @return void
     */
    function novalnet_prepayment() {
        global $order;
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        $this->code = 'novalnet_prepayment';
        $this->logo_title = MODULE_PAYMENT_NOVALNET_PREPAYMENT_LOGO_TITLE;
        $this->payment_logo_title = MODULE_PAYMENT_NOVALNET_PREPAYMENT_PAYMENT_LOGO_TITLE;

        $this->title = MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_TITLE . '<br>' . $this->logo_title . $this->payment_logo_title;
        $this->public_title = MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_PUBLIC_TITLE;
        $this->description = MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_PAYMENT_NOVALNET_PREPAYMENT_SORT_ORDER;
        $this->enabled = ((MODULE_PAYMENT_NOVALNET_PREPAYMENT_STATUS == 'True') ? true : false);
        $this->proxy = MODULE_PAYMENT_NOVALNET_PREPAYMENT_PROXY;
        $this->image = ( MODULE_PAYMENT_ENABLE_NOVALNET_LOGO == 1) ? $this->logo_title . $this->payment_logo_title : $this->payment_logo_title;
        $this->doAssignConfigVarsToMembers();
        $this->checkConfigure();
        if (CHECKOUT_AJAX_STAT == 'true') {
            $this->is_ajax = true;
        }
        if ((int) MODULE_PAYMENT_NOVALNET_PREPAYMENT_ORDER_STATUS_ID > 0) {
            $this->order_status = MODULE_PAYMENT_NOVALNET_PREPAYMENT_ORDER_STATUS_ID;
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
        $this->vendorid = trim(MODULE_PAYMENT_NOVALNET_PREPAYMENT_VENDOR_ID);
        $this->productid = trim(MODULE_PAYMENT_NOVALNET_PREPAYMENT_PRODUCT_ID);
        $this->authcode = trim(MODULE_PAYMENT_NOVALNET_PREPAYMENT_AUTH_CODE);
        $this->tariffid = trim(MODULE_PAYMENT_NOVALNET_PREPAYMENT_TARIFF_ID);
        $this->testmode = (strtolower(MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEST_MODE) == 'true' or MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEST_MODE == '1') ? 1 : 0;
    }

    /**
     * Test configure values and test mode in admin panel
     *
     * @return void
     */
    function checkConfigure() {
        if (IS_ADMIN_FLAG == true) {
            if ($this->enabled == 'true' && (empty($this->vendorid) || empty($this->productid) || empty($this->authcode) || empty($this->tariffid))) {
                $this->title .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_NOT_CONFIGURED;
            } elseif ($this->testmode == '1') {
                $this->title .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_IN_TEST_MODE;
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
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        if (($this->enabled == true) && ((int) MODULE_PAYMENT_NOVALNET_PREPAYMENT_ZONE > 0)) {
            $check_flag = false;
            $check_query = xtc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_NOVALNET_PREPAYMENT_ZONE . "' and 
      zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
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
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        $onFocus = '';
        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;
        
        if($this->testmode)
        $mode = NOVALNET_TEXT_TESTMODE_FRONT;
        else
        $mode = '';
        
        
        $selection = array('id' => $this->code,
            'module' => $this->public_title,
            'fields' => array(array('title' => '', 'field' => $this->image . $this->description),
                array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_PREPAYMENT_INFO),
                array('title' => '', 'field' =>$mode)
                )
        );
        if (function_exists(get_percent)) {
            $selection['module_cost'] = $GLOBALS['ot_payment']->get_percent($this->code);
        }
        return $selection;
    }

    /*
     * Precheck to Evaluate the Bank Datas
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
        // Check shipping methods are selected or not;
        if (!$order->info['shipping_method']) {
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_PREPAYMENT_REQUEST_FOR_CHOOSE_SHIPPING_METHOD));
            $_SESSION['checkout_payment_error'] = $payment_error_return;
            return;
        }
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        $error = '';
        if (empty($this->vendorid) || empty($this->productid) || empty($this->authcode) || empty($this->tariffid)) {
            $error = MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_JS_NN_MISSING;
        }
        if ($error != '') {
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(utf8_encode($error)));
            if ($this->is_ajax) {
                $_SESSION['checkout_payment_error'] = $payment_error_return;
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            }
        } else {
            if ($this->is_ajax) {
                $this->confirmation();
            }
        }
    }

    ### Display Bank Information on the Checkout Confirmation Page ###
    // @return array

    function confirmation() {
        global $HTTP_POST_VARS, $_POST, $order;
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;
        //$confirmation = array('fields' => array(array('title' => $this->public_title, 'field' => MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_BANK_INFO)));
        $confirmation = array();
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
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . utf8_encode(utf8_encode($err));
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
        global $HTTP_POST_VARS, $_POST, $order;
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;
        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
            $total = $order->info['total'] + $order->info['tax'];
        } else {
            $total = $order->info['total'];
        }
        $_SESSION['nn_total_prepayment'] = sprintf('%.2f', $total);
        $_SESSION['amount_first_prepayment'] = sprintf('%.2f', $total);
        return $process_button_string;
    }

    /**
     *
     * This sends the data to the Novalnet 
     *
     * @param array vars
     * 
     * @return array
     */
    function before_process() {
        global $HTTP_POST_VARS, $_POST, $order, $xtPrice, $currencies, $customer_id, $smarty;
        if ($this->order_status) {
            $order->info['order_status'] = $this->order_status;
        }
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;
        $nn_customer_id = (isset($_SESSION['customer_id'])) ? $_SESSION['customer_id'] : '';
        $customer_query = xtc_db_query("SELECT customers_gender, customers_dob, customers_fax, customers_status FROM " . TABLE_CUSTOMERS . " WHERE customers_id='" . (int) $nn_customer_id . "'");
        $customer = xtc_db_fetch_array($customer_query);
        $nncustomer_no = ($customer_query->fields['customers_status'] != 1) ? $nn_customer_id : NOVALNET_GUEST_USER;
        if (trim($order->customer['csID']))
            $customer_no = $order->customer['csID'];
        else
            $customer_no = $nncustomer_no;

        list($customer['customers_dob'], $extra) = explode(' ', $customer['customers_dob']);
        ### Process the payment to paygate ##
        $url = 'https://payport.novalnet.de/paygate.jsp';
        $amount = $_SESSION['amount_first_prepayment'];
        $user_ip = $this->getRealIpAddr();

        $firstname = !empty($order->customer['firstname']) ? $order->customer['firstname'] : $order->billing['firstname'];
        $lastname = !empty($order->customer['lastname']) ? $order->customer['lastname'] : $order->billing['lastname'];
        $street_address = !empty($order->customer['street_address']) ? $order->customer['street_address'] : $order->billing['street_address'];
        $city = !empty($order->customer['city']) ? $order->customer['city'] : $order->billing['city'];
        $postcode = !empty($order->customer['postcode']) ? $order->customer['postcode'] : $order->billing['postcode'];
        $country_iso_code_2 = !empty($order->customer['country']['iso_code_2']) ? $order->customer['country']['iso_code_2'] : $order->billing['country']['iso_code_2'];

        $urlparam = 'vendor=' . $this->vendorid . '&product=' . $this->productid . '&key=' . $this->KEY . '&tariff=' . $this->tariffid;
        $urlparam .= '&auth_code=' . $this->authcode . '&currency=' . $order->info['currency'];
        $urlparam .= '&amount=' . $amount . '&invoice_type=PREPAYMENT';
        $urlparam .= '&first_name=' . utf8_decode($firstname) . '&last_name=' . utf8_decode($lastname);
        $urlparam .= '&street=' . utf8_decode($street_address) . '&city=' . utf8_decode($city) . '&zip=' . $postcode;
        $urlparam .= '&country=' . $country_iso_code_2 . '&email=' . utf8_decode($order->customer['email_address']);
        $urlparam .= '&search_in_street=1&tel=' . $order->customer['telephone'] . '&remote_ip=' . $user_ip;
        $urlparam .= '&gender=' . $customer['customers_gender'] . '&birth_date=' . $customer['customers_dob'] . '&fax=' . $customer['customers_fax'];
        $urlparam .= '&language=' . MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_LANG;
        $urlparam .= '&lang=' . MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_LANG;
        $urlparam .= '&test_mode=' . $this->testmode;
        $urlparam .= '&customer_no=' . $customer_no . '&use_utf8=1';
        list($errno, $errmsg, $data) = $this->perform_https_request($url, $urlparam);
        if ($errno or $errmsg) {
            ### Payment Gateway Error ###
            $order->info['comments'] .= '. func perform_https_request returned Errorno : ' . $errno . ', Error Message : ' . $errmsg;
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . utf8_encode($errmsg) . '(' . $errno . ')';
            if ($this->is_ajax) {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, '', 'SSL', true, false) . '?' . $payment_error_return);
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            }
        }
        $aryResponse = array();
        #capture the result and message and other parameters from response data '$data' in an array
        $aryPaygateResponse = explode('&', $data);
        foreach ($aryPaygateResponse as $key => $value) {
            if ($value != "") {
                $aryKeyVal = explode("=", $value);
                $aryResponse[$aryKeyVal[0]] = $aryKeyVal[1];
            }
        }
        #Get the type of the comments field on TABLE_ORDERS
        $customer_query = xtc_db_query("SHOW COLUMNS FROM " . TABLE_ORDERS); # . " WHERE FIELD='comments'");#MySQL Version 3/4 dislike WHERE CLAUSE here :-(
        while ($customer = xtc_db_fetch_array($customer_query)) {
            if (strtolower($customer['Field']) == 'comments' and strtolower($customer['Type']) != 'text') {
                ### ALTER TABLE ORDERS modify the column comments ###
                xtc_db_query("ALTER TABLE " . TABLE_ORDERS . " MODIFY comments text");
            }
        }
        if ($aryResponse['status'] == 100) {
            $_SESSION['nn_tid_prepayment'] = $aryResponse['tid'];
            $old_comments = $order->info['comments'];
            $order->info['comments'] = '';
            $amount = str_replace('.', ',', sprintf("%.2f", $amount / 100));
            $newlinebreak = "\n";
            $formatted_amount = xtc_format_price_order($aryResponse['amount'], 1, $order->info['currency']);
           
           
           	$test_order_status = (((isset($aryResponse['test_mode']) && $aryResponse['test_mode'] == 1) || (isset($this->testmode) && $this->testmode == 1)) ? 1 : 0 );
            if ($test_order_status == 1) {
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEST_ORDER_MESSAGE;
            }
            
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_TITLE . $newlinebreak;
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_TID_MESSAGE . ' ' . $aryResponse['tid'] . $newlinebreak . $newlinebreak;
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_TRANSFER_INFO . $newlinebreak;
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_BANK_ACCOUNT_OWNER . ' NOVALNET AG ' . $newlinebreak;
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_BANK_ACCOUNT_NUMBER . ' ' . $aryResponse['invoice_account'] . $newlinebreak;
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_BANK_CODE . ' ' . $aryResponse['invoice_bankcode'] . $newlinebreak;
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_BANK_BANK . ' ' . $aryResponse['invoice_bankname'] . ' ' . trim($aryResponse['invoice_bankplace']) . $newlinebreak;
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_AMOUNT . ' ' . $formatted_amount . $newlinebreak;
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_REF_TID_MESSAGE. $aryResponse['tid'] . $newlinebreak . $newlinebreak;
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_IBAN_INFO . $newlinebreak;
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_BANK_IBAN . ' ' . $aryResponse['invoice_iban'] . $newlinebreak;
            $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_BANK_BIC . ' ' . $aryResponse['invoice_bic'] . $newlinebreak . $newlinebreak;
            //$order->info['comments'] .= MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_REFERENCE_INFO . $newlinebreak.$newlinebreak;
            $order->info['comments'] = html_entity_decode($order->info['comments'], ENT_QUOTES, "UTF-8");
            $order->info['comments'] .= $newlinebreak . $old_comments;

            ### WRITE THE PREPAYMENT BANK DATA ON SESSION ###     
            $_SESSION['nn_invoice_account'] = $aryResponse['invoice_account'];
            $_SESSION['nn_invoice_bankcode'] = $aryResponse['invoice_bankcode'];
            $_SESSION['nn_invoice_iban'] = $aryResponse['invoice_iban'];
            $_SESSION['nn_invoice_bic'] = $aryResponse['invoice_bic'];
            $_SESSION['nn_invoice_bankname'] = $aryResponse['invoice_bankname'];
            $_SESSION['nn_invoice_bankplace'] = $aryResponse['invoice_bankplace'];
            $nnmailcnt = 'Dear Mr. /Mrs.' . $this->ReplaceSpecialGermanChars($firstname) . ' ' . $this->ReplaceSpecialGermanChars($lastname) . '<br>';
            $nnmailcnt .= '<p> Um Ihnen eine h&ouml;chstm&ouml;gliche Sicherheit bei der digitalen Zahlungsabwicklung zu gew&auml;hrleisten, nehmen wir von Kerzen Kr&uuml;ger die Dienstleistungen der Novalnet AG in Anspruch. Aus diesem Grund haben wir uns f&uuml;r ein vertrauensvollem Finanzdienstleistungsinstitut (www.novalnet.de) entschieden.</p>';
            $smarty->assign('nngatewayinfo', $nnmailcnt);
        } else {
            ### Passing through the Error Response from Novalnet's paygate into order-info ###
            $order->info['comments'] .= NOVALNET_TEXT_ERROR_CODE . $aryResponse['status'] . ',' . NOVALNET_TEXT_ERROR_MESSAGE . $aryResponse['status_desc'];
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_decode($aryResponse['status_desc']));
            if ($this->is_ajax) {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, $payment_error_return, 'SSL', true, false));
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            }
        }
        return;
    }

    /*
     * Realtime accesspoint for communication to the Novalnet paygate
     *  
     * @return array
     */

    function perform_https_request($nn_url, $urlparam) {
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
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
        global $order, $customer_id, $insert_id;
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        if ($this->order_status) {
            xtc_db_query("UPDATE " . TABLE_ORDERS . " SET orders_status='" . $this->order_status . "' WHERE orders_id='" . $insert_id . "'");
        }
        if (isset($_SESSION['nn_tid_prepayment'])) {
            ### Pass the Order Reference to paygate ##
            $url = 'https://payport.novalnet.de/paygate.jsp';
            $urlparam = 'vendor=' . $this->vendorid . '&product=' . $this->productid . '&key=' . $this->KEY . '&tariff=' . $this->tariffid;
            $urlparam .= '&auth_code=' . $this->authcode . '&status=100&tid=' . $_SESSION['nn_tid_prepayment'];
            $urlparam .= '&order_no=' . $insert_id . '&invoice_ref=BNR-' . $this->productid . '-' . $insert_id;
            $urlparam .= '&vwz2=' . MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_ORDERNO . '' . $insert_id . '&vwz3=' . MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_ORDERDATE . '' . date('Y-m-d H:i:s');
            $this->perform_https_request($url, $urlparam);
            $_SESSION['nn_tid_prepayment'] = '';
            unset($_SESSION['amount_first_prepayment']);
        }
		if(isset($_SESSION['nn_tid_invoice'])) unset($_SESSION['nn_tid_invoice']);
		if(isset($_SESSION['nn_tid_elv_at'])) unset($_SESSION['nn_tid_elv_at']);
		if(isset($_SESSION['nn_tid_elv_de'])) unset($_SESSION['nn_tid_elv_de']);   
		if(isset($_SESSION['nn_tid_tel'])) unset($_SESSION['nn_tid_tel']);        
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
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        if (count($HTTP_GET_VARS) == 0 || $HTTP_GET_VARS == '')
            $HTTP_GET_VARS = $_GET;
        $error = array('title' => MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEXT_ERROR, 'error' => stripslashes(urldecode($HTTP_GET_VARS['error'])));
        return $error;
    }

    /*
     * Check to see whether module is installed
     *
     *  @return boolean
     */

    function check() {
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        if (!isset($this->_check)) {
            $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 
      'MODULE_PAYMENT_NOVALNET_PREPAYMENT_STATUS'");
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
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values 
    ('MODULE_PAYMENT_NOVALNET_PREPAYMENT_ALLOWED', '', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) 
    values ('MODULE_PAYMENT_NOVALNET_PREPAYMENT_STATUS', 'True', '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) 
    values ('MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEST_MODE', 'True', '6', '2', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values 
    ('MODULE_PAYMENT_NOVALNET_PREPAYMENT_VENDOR_ID', '', '6', '3', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values 
    ('MODULE_PAYMENT_NOVALNET_PREPAYMENT_AUTH_CODE', '', '6', '4', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values 
    ('MODULE_PAYMENT_NOVALNET_PREPAYMENT_PRODUCT_ID', '', '6', '5', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values 
    ('MODULE_PAYMENT_NOVALNET_PREPAYMENT_TARIFF_ID', '', '6', '6', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values 
    ('MODULE_PAYMENT_NOVALNET_PREPAYMENT_INFO', '', '6', '7', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values 
    ('MODULE_PAYMENT_NOVALNET_PREPAYMENT_SORT_ORDER', '0', '6', '8', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, 
    date_added) values ('MODULE_PAYMENT_NOVALNET_PREPAYMENT_ORDER_STATUS_ID', '0', '6', '9', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', 
    now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, 
    date_added) values ('MODULE_PAYMENT_NOVALNET_PREPAYMENT_ZONE', '0', '6', '10', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values 
    ('MODULE_PAYMENT_NOVALNET_PREPAYMENT_PROXY', '', '6', '11', now())");
    }

    /*
     * 
     * Remove the module and all its settings
     * @ return void
     */

    function remove() {
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    /*
     * Internal list of configuration keys used for configuration of the module
     *  
     * @return array
     */

    function keys() {
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        return array('MODULE_PAYMENT_NOVALNET_PREPAYMENT_ALLOWED', 'MODULE_PAYMENT_NOVALNET_PREPAYMENT_STATUS', 'MODULE_PAYMENT_NOVALNET_PREPAYMENT_TEST_MODE',
            'MODULE_PAYMENT_NOVALNET_PREPAYMENT_VENDOR_ID', 'MODULE_PAYMENT_NOVALNET_PREPAYMENT_AUTH_CODE', 'MODULE_PAYMENT_NOVALNET_PREPAYMENT_PRODUCT_ID',
            'MODULE_PAYMENT_NOVALNET_PREPAYMENT_TARIFF_ID', 'MODULE_PAYMENT_NOVALNET_PREPAYMENT_INFO', 'MODULE_PAYMENT_NOVALNET_PREPAYMENT_SORT_ORDER',
            'MODULE_PAYMENT_NOVALNET_PREPAYMENT_ORDER_STATUS_ID', 'MODULE_PAYMENT_NOVALNET_PREPAYMENT_ZONE', 'MODULE_PAYMENT_NOVALNET_PREPAYMENT_PROXY');
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

    function debug2($funcname) {
        $fh = fopen('/tmp/debug2.txt', 'a+');
        fwrite($fh, date('H:i:s ') . $funcname . "\n");
        fclose($fh);
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
