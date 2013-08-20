<?php

#########################################################
#                                                       #
#  ELVAT / DIRECT DEBIT payment method class            #
#  This module is used for real time processing of      #
#  Austrian Bankdata of customers.                      #
#                                                       #
#  Released under the GNU General Public License.       #
#  This free contribution made by request.              #
#  If you have found this script useful a small         #
#  recommendation as well as a comment on merchant form #
#  would be greatly appreciated.                        #
#                                                       #
#  Script : novalnet_elv_at.php                         #
#                                                       #
#########################################################

class novalnet_elv_at {

    var $code;
    var $title;
    var $description;
    var $enabled;
    var $proxy;
    var $callback_type;
    var $is_ajax = false;
    var $KEY = 8;
    var $tot_amount;
    var $vendorid;
    var $productid;
    var $authcode;
    var $tariffid;
    var $testmode;
    var $manual_check_limit;
    var $productid_2;
    var $tariffid_2;
    var $nnelvat_allowed_pin_country_list = array('de', 'at', 'ch');
    var $logo_title;
    var $payment_logo_title;
    var $nn_elv_at_image;

    /**
     * Initalze the novalnet credit card PCI method
     *
     */
    function novalnet_elv_at() {
        global $order;
        $this->code = 'novalnet_elv_at';
        $this->logo_title = MODULE_PAYMENT_NOVALNET_ELV_AT_LOGO_TITLE;
        $this->payment_logo_title = MODULE_PAYMENT_NOVALNET_ELV_AT_PAYMENT_LOGO_TITLE;
        $this->title = MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_TITLE . '<br>' . $this->logo_title . $this->payment_logo_title;
        $this->public_title = MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_PUBLIC_TITLE;
        $this->description = MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_PAYMENT_NOVALNET_ELV_AT_SORT_ORDER;
        $this->enabled = ((MODULE_PAYMENT_NOVALNET_ELV_AT_STATUS == 'True') ? true : false);
        $this->nn_elv_at_image = ( MODULE_PAYMENT_ENABLE_NOVALNET_LOGO == 1) ? $this->logo_title . $this->payment_logo_title : $this->payment_logo_title;
        $this->proxy = MODULE_PAYMENT_NOVALNET_ELV_AT_PROXY;

        $this->doAssignConfigVarsToMembers();
        $this->checkConfigure();
        if (CHECKOUT_AJAX_STAT == 'true') {
            $this->is_ajax = true;
        }
        if ($_SESSION['nn_tid_elv_at']) {
            if ($_SESSION['max_time_elv_at'] && time() > $_SESSION['max_time_elv_at']) {
                unset($_SESSION['nn_tid_elv_at']);
                unset($_SESSION['nn_elv_de_pin_max_exceed']);
                $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SESSION_ERROR));
                if ($this->is_ajax) {
                    $_SESSION['checkout_payment_error'] = $payment_error_return;
                } else {
                    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                }
            }
            if ($_GET['new_novalnet_pin_elv_at'] == 'true') {
                $_SESSION['new_novalnet_pin_elv_at'] = true;
                //$this->secondcall();
                $response = $this->secondCall();
                if ($response['status'] != 100) {
                    $_SESSION['xml_resp_error_elv_at'] = $this->paymentErrrorMessage($response);
                    $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($_SESSION['xml_resp_error_elv_at']) . ' (' . $aryResponse['status'] . ')';
                    if ($response['status'] == '0529006' || $response['status'] == '0529010' || $response['status'] == '0529008') {
                        $_SESSION['nn_elv_at_pin_max_exceed'] = TRUE;
                        //unset($_SESSION['nn_tid_elv_de']);
                    }
                    if ($this->is_ajax) {
                        $_SESSION['checkout_payment_error'] = $payment_error_return;
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                }
            }
            if (!$this->is_ajax && $_SESSION['email_reply_check_elv_at'] == 'Email Reply' && !isset($_SESSION['xml_resp_error_elv_at'])) {
                //$this->secondCall();
                $response = $this->secondCall();
                if ($response['status'] != 100) {
                    $_SESSION['xml_resp_error_elv_at'] = $this->paymentErrrorMessage($response);
                    $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($_SESSION['xml_resp_error_elv_at']) . ' (' . $response['status'] . ')';
                    if ($response['status'] == '0529006' || $response['status'] == '0529010' || $response['status'] == '0529008') {
                        $_SESSION['nn_elv_at_pin_max_exceed'] = TRUE;
                        //unset($_SESSION['nn_tid_elv_de']);
                    }
                    if ($this->is_ajax) {
                        $_SESSION['checkout_payment_error'] = $payment_error_return;
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, '', 'SSL', true, false) . '?' . $payment_error_return);
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                }
            }
        }
        $this->isActivatedCallback = false;
        if (MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS != 'False') {
            $this->isActivatedCallback = true;
        }
        if ((int) MODULE_PAYMENT_NOVALNET_ELV_AT_ORDER_STATUS_ID > 0) {
            $this->order_status = MODULE_PAYMENT_NOVALNET_ELV_AT_ORDER_STATUS_ID;
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
        $this->vendorid = trim(MODULE_PAYMENT_NOVALNET_ELV_AT_VENDOR_ID);
        $this->productid = trim(MODULE_PAYMENT_NOVALNET_ELV_AT_PRODUCT_ID);
        $this->authcode = trim(MODULE_PAYMENT_NOVALNET_ELV_AT_AUTH_CODE);
        $this->tariffid = trim(MODULE_PAYMENT_NOVALNET_ELV_AT_TARIFF_ID);
        $this->testmode = (strtolower(MODULE_PAYMENT_NOVALNET_ELV_AT_TEST_MODE) == 'true' or MODULE_PAYMENT_NOVALNET_ELV_AT_TEST_MODE == '1') ? 1 : 0;
        $this->manual_check_limit = trim(MODULE_PAYMENT_NOVALNET_ELV_AT_MANUAL_CHECK_LIMIT);
        $this->productid_2 = trim(MODULE_PAYMENT_NOVALNET_ELV_AT_PRODUCT_ID2);
        $this->tariffid_2 = trim(MODULE_PAYMENT_NOVALNET_ELV_AT_TARIFF_ID2);
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
            if ($this->enabled == 'true' && (empty($this->vendorid) || empty($this->productid) || empty($this->authcode) || empty($this->tariffid))) {
                $this->title .= '<br>' . MODULE_PAYMENT_NOVALNET_ELV_AT_NOT_CONFIGURED;
            } elseif ($this->testmode == '1') {
                $this->title .= '<br>' . MODULE_PAYMENT_NOVALNET_ELV_AT_IN_TEST_MODE;
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
        $this->enabled = ((MODULE_PAYMENT_NOVALNET_ELV_AT_STATUS == 'True') ? true : false);
        if (($this->enabled == true) && ((int) MODULE_PAYMENT_NOVALNET_ELV_AT_ZONE > 0)) {
            $check_flag = false;
            $check_query = xtc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_NOVALNET_ELV_AT_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
     * Builds set of input fields for collecting Bankdetail details info
     *
     *
     * @return array
     */
    function selection() {
        global $xtPrice, $order, $_REQUEST, $_POST;
        $onFocus = '';
        if (count($_REQUEST) == 0 || $_REQUEST == '')
            $_REQUEST = $_POST;
        //$bank_account_holder_at = trim($_REQUEST['bank_account_holder_at']);
        $billing_iso_code = strtolower($order->customer['country']['iso_code_2']);
        $bank_account_holder_at = trim($_REQUEST['bank_account_holder_at']);
        $bank_account = trim($_REQUEST['bank_account_at']);
        $bank_code = trim($_REQUEST['bank_code_at']);
        if (!$bank_account) {
            $bank_account = $_SESSION['bank_account_at'];
        }
        if (!$bank_code) {
            $bank_code = $_SESSION['bank_code_at'];
        }
        if (!$bank_account_holder_at) {
            $bank_account_holder_at = ($_SESSION['bank_account_holder_at']);
        }
        if ($this->is_ajax) {
            $bank_account_holder_at = utf8_encode($bank_account_holder_at);
        }
        if (!$bank_account_holder_at) {
            $bank_account_holder_at = html_entity_decode($order->billing['firstname'] . ' ' . $order->billing['lastname']);
        } 
        
        if($this->testmode)
        $mode = NOVALNET_TEXT_TESTMODE_FRONT;
        else
        $mode = '';
        
        if (($this->is_ajax || (!$this->is_ajax && !$_SESSION['nn_tid_elv_at'])) && !isset($_SESSION['nn_elv_at_pin_max_exceed'])) {
            $selection = array('id' => $this->code,
                'module' => $this->public_title,
                'fields' => array(
                    array('title' => '', 'field' => $this->nn_elv_at_image . $this->description),
                    array('title' => MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_BANK_ACCOUNT_OWNER,
                        'field' => xtc_draw_input_field('bank_account_holder_at', '', 'id="' . $this->code . '-bank_account_holder_at" AUTOCOMPLETE=OFF' . $onFocus),
                        'tag' => $this->code . '-bank_account_holder_at'),
                    array('title' => MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_BANK_ACCOUNT_NUMBER,
                        'field' => xtc_draw_input_field('bank_account_at', '', 'id="' . $this->code . '-bank_account_at"  AUTOCOMPLETE=OFF ' . $onFocus),
                        'tag' => $this->code . '-bank_account_at'),
                    array('title' => MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_BANK_CODE,
                        'field' => xtc_draw_input_field('bank_code_at', '', 'id="' . $this->code . '-bank_code_at"  AUTOCOMPLETE=OFF ' . $onFocus),
                        'tag' => $this->code . '-bank_code_at')
                    ));
            $amount_check = $this->findTotalAmount();
            $_SESSION['amount_first_elv_at'] = $amount_check;
            if ($this->isActivatedCallback && in_array($billing_iso_code, $this->nnelvat_allowed_pin_country_list) && $amount_check >= MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_MIN_LIMIT) {
                if (MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'Email Reply') {
                    $selection['fields'][] = array('title' => MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_EMAIL, 'field' => xtc_draw_input_field('user_email_elv_at', '', 'id="' . $this->code . '-callback" AUTOCOMPLETE=OFF' . $onFocus));
                } else {
                    if (MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'Callback (Telefon & Handy)') {
                        $selection['fields'][] = array('title' => MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS_TEL, 'field' => xtc_draw_input_field('user_tel_elv_at', '', 'id="' . $this->code . '-callback" AUTOCOMPLETE=OFF' . $onFocus));
                    }
                    if (MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'SMS (nur Handy)') {
                        $selection['fields'][] = array('title' => MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS_MOB, 'field' => xtc_draw_input_field('user_tel_elv_at', '', 'id="' . $this->code . '-callback" AUTOCOMPLETE=OFF' . $onFocus));
                    }
                }
            }
            $selection['fields'][] = array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_ELV_AT_INFO);
            $selection['fields'][] = array('title' => '', 'field' =>$mode);
        }
        $amount_check = $_SESSION['amount_first_elv_at'];
        if ($this->isActivatedCallback && in_array($billing_iso_code, $this->nnelvat_allowed_pin_country_list) && $amount_check >= MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_MIN_LIMIT) {
            if (($this->is_ajax || (!$this->is_ajax && $_SESSION['nn_tid_elv_at'])) && !isset($_SESSION['nn_elv_at_pin_max_exceed'])) {
                if (!$this->is_ajax) {
                    $selection = array('id' => $this->code, 'module' => $this->public_title);
                }
                if (MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'Email Reply') {
                    if ($this->is_ajax) {
                        $selection['fields'][] = array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_ELV_AT_EMAIL_INFO_DESC);
                        $selection['fields'][] = array('title' => '', 'field' => xtc_draw_checkbox_field('email_replied_elv_at', '1', false) . MODULE_PAYMENT_NOVALNET_ELV_AT_EMAIL_REPLY_INFO);
                    } else {
                        $selection['fields'][] = array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_ELV_AT_EMAIL_INPUT_REQUEST_DESC);
                    }
                } else {
                    // Show PIN field, after first call
                    if ($this->is_ajax) {
                        unset($_SESSION['email_reply_check_elv_at']);
                        $selection['fields'][] = array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_INFO_DESC);
                        $selection['fields'][] = array('title' => MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_INPUT_REQUEST_DESC, 'field' => xtc_draw_input_field('novalnet_pin_elv_at', '', 'id="' . $this->code . '-callback" ' . $onFocus));
                        $selection['fields'][] = array('title' => '', 'field' => xtc_draw_checkbox_field('forgot_pin_elv_at', '1', false, 'id="' . $this->code . '-forgotpin"' . $onFocus) . MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS_NEW_PIN);
                        $selection['fields'][] = array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_ELV_AT_FORGOT_PIN_DIV);
                    } else {
                        $selection['fields'][] = array('title' => MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_INPUT_REQUEST_DESC, 'field' => xtc_draw_input_field('novalnet_pin_elv_at', '', 'id="' . $this->code . '-callback" ' . $onFocus));
                        $selection['fields'][] = array('title' => '', 'field' => '<a href="' . xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'new_novalnet_pin_elv_at=true', 'SSL', true, false) . '">' . MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS_NEW_PIN . '</a>');
                    }
                }
            }
        }

        if (function_exists(get_percent)) {
            $selection['module_cost'] = $GLOBALS['ot_payment']->get_percent($this->code);
        }
        return $selection;
    }

    /**
     * Precheck to Evaluate the Bank detail's and Novalnet backend params
     *
     *
     * @return void
     */
    function pre_confirmation_check($vars) {
        global $_REQUEST, $_POST, $order;
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
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_ELV_AT_REQUEST_FOR_CHOOSE_SHIPPING_METHOD));
            $_SESSION['checkout_payment_error'] = $payment_error_return;
            return;
        }
        if (!is_array($_REQUEST) && !$_REQUEST) {
            $_REQUEST = array();
        }
        if ($this->is_ajax) {
            $_REQUEST = array_merge($_REQUEST, $vars);
        } else {
            $_REQUEST = array_merge($_REQUEST, $_POST);
        }
        if (isset($_REQUEST['user_tel_elv_at'])) {
            $_REQUEST['user_tel_elv_at'] = trim($_REQUEST['user_tel_elv_at']);
        }
        if (isset($_REQUEST['user_email_elv_at'])) {
            $_REQUEST['user_email_elv_at'] = trim($_REQUEST['user_email_elv_at']);
        }
        if (isset($_REQUEST['novalnet_pin_elv_at'])) {
            $_REQUEST['novalnet_pin_elv_at'] = trim($_REQUEST['novalnet_pin_elv_at']);
        }
        if ($_SESSION['nn_tid_elv_at']) {
            // Callback stuff....
            if ($order->info['subtotal'] != $_SESSION['prod_total_amount_elv_at'] || $order->info['shipping_class'] != $_SESSION['shipping_name_elv_at']) {
                if (( MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'Callback (Telefon & Handy)' ) || ( MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'SMS (nur Handy)' )) {
                    $error = NOVALNET_AMOUNT_VARIATION_MESSAGE_PIN;
                }
                if (MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'Email Reply') {
                    $error = NOVALNET_AMOUNT_VARIATION_MESSAGE_EMAIL;
                }
                $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($error);
                unset($_SESSION['nn_tid_elv_at']);
                unset($_SESSION['prod_total_amount_elv_at']);
                unset($_SESSION['shipping_name_elv_at']);
                if ($this->is_ajax) {
                    $_SESSION['checkout_payment_error'] = $payment_error_return;
                    return;
                } else {
                    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                }
            }
            // check pin
            //if($this->is_ajax && $_REQUEST['forgot_pin_elv_at'] && !$_REQUEST['novalnet_pin_elv_at']){
            if ($this->is_ajax && $_REQUEST['forgot_pin_elv_at']) {
                $_SESSION['new_novalnet_pin_elv_at'] = true;
                $response = $this->secondCall();
                if ($response['status'] != 100) {
                    $_SESSION['xml_resp_error_elv_at'] = $this->paymentErrrorMessage($response);
                    $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($_SESSION['xml_resp_error_elv_at']) . ' (' . $response['status'] . ')';
                    if ($response['status'] == '0529006' || $response['status'] == '0529010' || $response['status'] == '0529008') {
                        $_SESSION['nn_elv_at_pin_max_exceed'] = TRUE;
                        //unset($_SESSION['nn_tid_elv_de']);
                    }
                    if ($this->is_ajax) {
                        $_SESSION['checkout_payment_error'] = $payment_error_return;
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                }
                return;
            }
            if ($this->is_ajax && MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'Email Reply') {
                if ($this->is_ajax && !$_REQUEST['email_replied_elv_at']) {
                    $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_ELV_AT_EMAIL_REPLY_CHECKBOX_INFO));
                    if ($this->is_ajax) {
                        $_SESSION['checkout_payment_error'] = $payment_error_return;
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                } else {
                    $_SESSION['email_reply_check_elv_at'] = 'Email Reply';
                }
            }
            if (isset($_REQUEST['novalnet_pin_elv_at']) && isset($_SESSION['nn_tid_elv_at'])) {
                if (empty($_REQUEST['novalnet_pin_elv_at']) || !preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['novalnet_pin_elv_at'])) {
                    $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS_PIN_NOTVALID));
                    if ($this->is_ajax) {
                        $_SESSION['checkout_payment_error'] = $payment_error_return;
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                } else {
                    if ($_REQUEST['novalnet_pin_elv_at'])
                        $_SESSION['novalnet_pin_elv_at'] = $_REQUEST['novalnet_pin_elv_at'];
                }
            }
            return;
        }
        else {
            $error = '';
            if ($this->is_ajax || (!$this->is_ajax && !isset($_SESSION['nn_tid_elv_at']))) {
                $acc_holder = trim(($_REQUEST['bank_account_holder_at']));
                $acc_no = trim($_REQUEST['bank_account_at']);
                $bank_code = trim($_REQUEST['bank_code_at']);
                $acc_no = $this->novalnet_elv_at_sanitizeCcNumber($acc_no);
                $bank_code = $this->novalnet_elv_at_sanitizeCcNumber($bank_code);
                /* Start : Validation */
                if (empty($this->vendorid) || empty($this->productid) || empty($this->authcode) || empty($this->tariffid)) {
                    $error = MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_JS_NN_MISSING;
                } elseif ($this->manual_check_limit > 0 && (empty($this->productid_2) || empty($this->tariffid_2))) {
                    $error = MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_JS_NN_ID2_MISSING;
                } elseif (empty($acc_holder) || preg_match('/[#%\^<>@$=*!]/', $acc_holder) || strlen($acc_holder) < MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_BANK_ACCOUNT_OWNER_LENGTH) {
                    $error = MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_JS_NN_COMMON_ERROR;
                } elseif (empty($acc_no) || strlen($acc_no) < MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_BANK_ACCOUNT_NUMBER_LENGTH || (!$this->novalnet_elv_at_getCcType($acc_no))) {
                    $error = MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_JS_NN_COMMON_ERROR;
                } elseif (empty($bank_code) || strlen($bank_code) < MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_BANK_CODE_LENGTH || (!$this->novalnet_elv_at_getCcType($bank_code))) {
                    $error = MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_JS_NN_COMMON_ERROR;
                }
                /* End : Validation */
                $_SESSION['bank_account_holder_at'] = $acc_holder;
                $_SESSION['bank_account_at'] = $acc_no;
                $_SESSION['bank_code_at'] = $bank_code;
                if (isset($_REQUEST['user_tel_elv_at'])) {
                    $_SESSION['user_tel_elv_at'] = trim($_REQUEST['user_tel_elv_at']);
                }
                if (isset($_REQUEST['user_email_elv_at'])) {
                    $_SESSION['user_email_elv_at'] = trim($_REQUEST['user_email_elv_at']);
                }
                // Callback stuff....
                $amount_check = $_SESSION['amount_first_elv_at'];

                if ($this->isActivatedCallback && in_array(strtolower($order->customer['country']['iso_code_2']), $this->nnelvat_allowed_pin_country_list) && $amount_check >= MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_MIN_LIMIT) {
                    if ($error == '') {
                        //checking email address
                        if (isset($_REQUEST['user_email_elv_at'])) {
                            if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_REQUEST['user_email_elv_at'])) {
                                $error .= MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_EMAIL_NOTVALID;
                            }
                        }
                        //checking telephone number
                        if (isset($_REQUEST['user_tel_elv_at'])) {
                            if (strlen($_REQUEST['user_tel_elv_at']) < 8 || !is_numeric($_REQUEST['user_tel_elv_at'])) {
                                $error .= MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS_TEL_NOTVALID;
                            }
                        }
                    }
                    if ($error != '') {
                        $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode($error));
                        if ($this->is_ajax) {
                            $_SESSION['checkout_payment_error'] = $payment_error_return;
                        } else {
                            xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                        }
                    } else {
                        $this->confirmation();
                        // firstcall()
                        $this->before_process($vars);
                        if (!$this->is_ajax) {
                            xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false));
                        }
                    }
                }
            }
            if ($error != '') {
                $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode($error));
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
    }

    /**
     * Display Information on the Checkout Confirmation Page
     *
     *
     * @return array
     */
    function confirmation() {
        global $_REQUEST, $_POST, $order;
        $total = $this->findTotalAmount();
        $_SESSION['amount_first_elv_at'] = $total;
        $_SESSION['nn_total_elv_at'] = $total;
        if (count($_REQUEST) == 0 || $_REQUEST == '')
            $_REQUEST = $_POST;
        #to hide account number
        $crdNo = str_replace(' ', '', $_SESSION['bank_account_at']);
        if ($crdNo) {
            $cardnoInfo = str_pad(substr($crdNo, 0, -4), strlen($crdNo), '*', STR_PAD_RIGHT);
        }
        #to hide bank code
        $codeNo = str_replace(' ', '', $_SESSION['bank_code_at']);
        if ($codeNo) {
            $codeInfo = str_pad(substr($codeNo, 0, -4), strlen($codeNo), '*', STR_PAD_RIGHT);
        }
        $confirmation = array('fields' => array(array('title' => MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_BANK_ACCOUNT_OWNER,
                    'field' => $_SESSION['bank_account_holder_at']),
                array('title' => MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_BANK_ACCOUNT_NUMBER,
                    'field' => $cardnoInfo),
                array('title' => MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_BANK_CODE,
                    'field' => $codeInfo)
                ));
        return $confirmation;
    }

    /**
     * Build the data and actions to process when the "Submit" button is pressed on the order-confirmation screen.
     * These are hidden fields on the checkout confirmation page
     *
     * @return string
     */
    function process_button() {
        global $_REQUEST, $_POST;
        if (count($_REQUEST) == 0 || $_REQUEST == '')
            $_REQUEST = $_POST;
        $process_button_string = xtc_draw_hidden_field('bank_account_holder_at', $_SESSION['bank_account_holder_at']) .
                xtc_draw_hidden_field('bank_account_at', $_SESSION['bank_account_at']) .
                xtc_draw_hidden_field('bank_code_at', $_SESSION['bank_code_at']);
        return $process_button_string;
    }

    /**
     *  
     * to tranfer the pin to novalnet gateway
     *
     * @return array
     */
    public function secondCall() {
        // If customer forgets PIN, send a new PIN
        if ($_SESSION['new_novalnet_pin_elv_at'])
            $request_type = 'TRANSMIT_PIN_AGAIN';
        else
            $request_type = 'PIN_STATUS';
        if ($_SESSION['email_reply_check_elv_at'] == 'Email Reply')
            $request_type = 'REPLY_EMAIL_STATUS';
        if ($_SESSION['new_novalnet_pin_elv_at'])
            $_SESSION['new_novalnet_pin_elv_at'] = false;
        if ($request_type == 'REPLY_EMAIL_STATUS') {
            $xml = '<?xml version="1.0" encoding="UTF-8"?>
				<nnxml>
		  			<info_request>
			    		<vendor_id>' . $this->vendorid . '</vendor_id>
			    		<vendor_authcode>' . $this->authcode . '</vendor_authcode>
			    		<request_type>' . $request_type . '</request_type>
			    		<tid>' . $_SESSION['nn_tid_elv_at'] . '</tid>
		  			</info_request>
				</nnxml>';
        } else {
            $xml = '<?xml version="1.0" encoding="UTF-8"?>
				<nnxml>
		  			<info_request>
			    		<vendor_id>' . $this->vendorid . '</vendor_id>
			    		<vendor_authcode>' . $this->authcode . '</vendor_authcode>
			    		<request_type>' . $request_type . '</request_type>
			    		<tid>' . $_SESSION['nn_tid_elv_at'] . '</tid>
			    		<pin>' . $_SESSION['novalnet_pin_elv_at'] . '</pin>
		  			</info_request>
				</nnxml>';
        }
        $xml_response = $this->curl_xml_post($xml);
        // Parse XML Response to object
        $xml_response = simplexml_load_string($xml_response);
        $array = (array) $xml_response;
        return $array;
    }

    /*
     * Realtime accesspoint for communication to the Novalnet paygate
     *  
     * @return array
     */

    public function curl_xml_post($request) {
        $ch = curl_init("https://payport.novalnet.de/nn_infoport.xml");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close'));
        curl_setopt($ch, CURLOPT_POST, 1);  // a non-zero parameter tells the library to do a regular HTTP post.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);  // add POST fields
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);  // don't allow redirects
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // decomment it if you want to have effective ssl checking
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // decomment it if you want to have effective ssl checking
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 240);  // maximum time, in seconds, that you'll allow the CURL functions to take
        ## establish connection
        $xml_response = curl_exec($ch);
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
        return $xml_response;
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
     *  Store the BANK info to the order
     *  This sends the data to the payment gateway for processing and Evaluates the Bankdatas for acceptance and the validity of the Bank Details
     *  sending params to Novalnet server
     *
     * @param array vars
     *
     * @return array
     */
    function before_process($vars) {
        global $_REQUEST, $_POST, $order, $currencies, $customer_id;
        // Setting callback type // see constructor
        // First call is done, so check PIN / second call...
        $this->tot_amount = $amount = $_SESSION['amount_first_elv_at'];
        if ($_SESSION['nn_tid_elv_at'] && $this->isActivatedCallback && in_array(strtolower($order->customer['country']['iso_code_2']), $this->nnelvat_allowed_pin_country_list) && $amount >= MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_MIN_LIMIT) {
             if( isset($_SESSION['nn_total_amount_elv_at']) && $_SESSION['nn_total_amount_elv_at'] != $_SESSION['amount_first_elv_at']){  
                if (( MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'Callback (Telefon & Handy)' ) || ( MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'SMS (nur Handy)' )) {
                    $error = NOVALNET_AMOUNT_VARIATION_MESSAGE_PIN;
                }
                if (MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'Email Reply') {
                    $error = NOVALNET_AMOUNT_VARIATION_MESSAGE_EMAIL;
                }
                $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($error);
                unset($_SESSION['nn_total_amount_elv_at']);
                unset($_SESSION['nn_tid_elv_at']);
                unset($_SESSION['prod_total_amount_elv_at']);
                unset($_SESSION['shipping_name_elv_at']);
                if ($this->is_ajax) {
                    $_SESSION['checkout_payment_error'] = $payment_error_return;
                    return;
                } else {
                    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                }
            }
            if (MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'Email Reply')
                $_SESSION['email_reply_check_elv_at'] = 'Email Reply';
            else
                unset($_SESSION['email_reply_check_elv_at']);
            if ($this->is_ajax && $_REQUEST['forgot_pin_elv_at'] && !$_REQUEST['novalnet_pin_elv_at'])
                $_SESSION['new_novalnet_pin_elv_at'] = true;
            else
                $_SESSION['new_novalnet_pin_elv_at'] = false;
            $aryResponse = $this->secondCall();
            if ($aryResponse) {
                if ($aryResponse['status'] != 100) {
                    //$_SESSION['xml_resp_error_elv_at'] = $this->paymentErrrorMessage($aryResponse);
                    $nnxmlsession = $this->paymentErrrorMessage($aryResponse);
                    $_SESSION['xml_resp_error_elv_at'] = 'test';
                    $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($nnxmlsession) . ' (' . $aryResponse['status'] . ')';
                    if ($aryResponse['status'] == '0529006' || $aryResponse['status'] == '0529010' || $aryResponse['status'] == '0529008') {
                        $_SESSION['nn_elv_at_pin_max_exceed'] = TRUE;
                        //unset($_SESSION['nn_tid_elv_de']);
                    }
                    if ($this->is_ajax) {
                        $_SESSION['checkout_payment_error'] = $payment_error_return;
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, '', 'SSL', true, false) . '?' . $payment_error_return);
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                } else {
                    if ($this->order_status)
                        $order->info['order_status'] = $this->order_status;
                    $old_comments = $order->info['comments'];
                    $order->info['comments'] = '';
                    //Test mode based on the response test mode value
                    $test_mode = $this->testmode;
                    
                    $test_order_status = (((isset($_SESSION['test_mode_elv_at']) && $_SESSION['test_mode_elv_at'] == 1) || (isset($this->testmode) && $this->testmode == 1)) ? 1 : 0 );

                    if ($test_order_status == 1) {
                        $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_ELV_AT_TEST_ORDER_MESSAGE;
                    }
                    
                    $newlinebreak = "\n";
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_ELV_AT_TID_MESSAGE . $_SESSION['nn_tid_elv_at'] . $newlinebreak;
                    $order->info['comments'] = str_replace(array('<b>', '</b>', '<B>', '</B>', '<br>', '<br />', '<BR>'), array('', '', '', '', "\n", "\n", "\n"), $order->info['comments']);
                    $order->info['comments'] .= $old_comments;
                }
            }
            return;
        }
        if ($this->is_ajax && $this->isActivatedCallback && in_array(strtolower($order->customer['country']['iso_code_2']), $this->nnelvat_allowed_pin_country_list) && $amount >= MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_MIN_LIMIT) {
            if (count($_REQUEST) == 0 || $_REQUEST == '')
                $_REQUEST = $vars;
        } else {
            if (count($_REQUEST) == 0 || $_REQUEST == '')
                $_REQUEST = $_POST;
        }
        #Get the required additional customer details from DB
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
        $this->tot_amount = $amount = $_SESSION['amount_first_elv_at'];
        list($product_id, $tariff_id) = $this->get_prod_tarif_id($amount);
        //set the user telephone
        if ($_SESSION['user_tel_elv_at']) {
            $user_telephone = $_SESSION['user_tel_elv_at'];
        } else {
            $user_telephone = $order->customer['telephone'];
        }
        //set the user email
        if ($_SESSION['user_email_elv_at']) {
            $user_email = $_SESSION['user_email_elv_at'];
        } else {
            //$user_email	= $this->ReplaceSpecialGermanChars($order->customer['email_address']);
            $user_email = $this->ReplaceSpecialGermanChars($order->customer['email_address']);
        }
        if ($this->isActivatedCallback && in_array(strtolower($order->customer['country']['iso_code_2']), $this->nnelvat_allowed_pin_country_list) && $amount >= MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_MIN_LIMIT) {
            if (MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'Callback (Telefon & Handy)') {
                $this->callback_type = '&pin_by_callback=1';
                $url_telephone = '&tel=' . $user_telephone;
            }
            if (MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'SMS (nur Handy)') {
                $this->callback_type = '&pin_by_sms=1';
                $url_telephone = '&mobile=' . $user_telephone;
            }
            if (MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'Email Reply') {
                $this->callback_type = '&reply_email_check=1';
            }
        } else {
            $url_telephone = '&tel=' . $user_telephone;
        }
        $firstname = !empty($order->customer['firstname']) ? $order->customer['firstname'] : $order->billing['firstname'];
        $lastname = !empty($order->customer['lastname']) ? $order->customer['lastname'] : $order->billing['lastname'];
        $street_address = !empty($order->customer['street_address']) ? $order->customer['street_address'] : $order->billing['street_address'];
        $city = !empty($order->customer['city']) ? $order->customer['city'] : $order->billing['city'];
        $postcode = !empty($order->customer['postcode']) ? $order->customer['postcode'] : $order->billing['postcode'];
        $country_iso_code_2 = !empty($order->customer['country']['iso_code_2']) ? $order->customer['country']['iso_code_2'] : $order->billing['country']['iso_code_2'];

        $user_ip = $this->getRealIpAddr();
        $urlparam = 'vendor=' . $this->vendorid . '&product=' . $product_id . '&key=' . $this->KEY . '&tariff=' . $tariff_id;
        $urlparam .= '&auth_code=' . $this->authcode . '&currency=' . $order->info['currency'];
        $urlparam .= '&bank_account_holder=' . utf8_decode($_SESSION['bank_account_holder_at']) . '&bank_account=' . $_SESSION['bank_account_at'];
        $urlparam .= '&bank_code=' . $_SESSION['bank_code_at'] . '&first_name=' . utf8_decode($firstname) . '&last_name=' . utf8_decode($lastname);
        $urlparam .= '&street=' . utf8_decode($street_address) . '&city=' . utf8_decode($city) . '&zip=' . $postcode;
        $urlparam .= '&country=' . $country_iso_code_2 . '&email=' . $user_email;
        $urlparam .= '&search_in_street=1' . $url_telephone . '&remote_ip=' . $user_ip;
        $urlparam .= '&gender=' . $customer['customers_gender'] . '&birth_date=' . $customer['customers_dob'] . '&fax=' . $customer['customers_fax'];
        $urlparam .= '&language=' . MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_LANG;
        $urlparam .= '&lang=' . MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_LANG;
        $urlparam .= '&test_mode=' . $this->testmode;
        $urlparam .= '&input1=tot_amount&inputval1=' . $this->tot_amount;
        $urlparam .= $this->callback_type;
        $urlparam .= '&amount=' . $amount;
        $urlparam .= '&customer_no=' . $customer_no . '&use_utf8=1';
        list($errno, $errmsg, $data) = $this->perform_https_request($url, $urlparam);
        if ($errno or $errmsg) {
            ### Payment Gateway Error ###
            $order->info['comments'] .= '. func perform_https_request returned Errorno : ' . $errno . ', Error Message : ' . $errmsg;
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . utf8_encode($errmsg) . '(' . $errno . ')';
            if ($this->is_ajax) {
                $_SESSION['checkout_payment_error'] = $payment_error_return;
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            }
        }
        #capture the result and message and other parameters from response data '$data' in an array
        parse_str($data, $aryResponse);
        if ($aryResponse['status'] == 100) {
            if ($this->isActivatedCallback && in_array(strtolower($order->customer['country']['iso_code_2']), $this->nnelvat_allowed_pin_country_list) && $amount >= MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_MIN_LIMIT) {
				$_SESSION['nn_total_amount_elv_at'] = $_SESSION['amount_first_elv_at'];
                $_SESSION['prod_total_amount_elv_at'] = $order->info['subtotal'];
                $_SESSION['shipping_name_elv_at'] = $order->info['shipping_class'];
                $_SESSION['nn_tid_elv_at'] = $aryResponse['tid'];
                $_SESSION['nn_amount'] = $aryResponse['amount'];
                // To avoide payment method confussion add code in session
                //set session for maximum time limit to 30 minutes
                $_SESSION['max_time_elv_at'] = time() + (30 * 60);
                //TEST BILLING MESSAGE BASED ON THE RESPONSE TEST MODE
                $test_mode = $this->testmode;
                if ($test_mode) {
                    $_SESSION['test_mode_elv_at'] = $test_mode;
                }
                if (MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS == 'Email Reply') {
                    $checkoutmsg = MODULE_PAYMENT_NOVALNET_ELV_AT_EMAIL_REPLY_CHECK_MSG;
                } else {
                    $checkoutmsg = MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_CHECK_MSG;
                }
                $payment_error_return = 'payment_error=' . $this->code . '&error=' . rawurlencode($checkoutmsg);
                if ($this->is_ajax) {
                    $_SESSION['checkout_payment_error'] = $payment_error_return;
                } else {
                    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                }
            } else {
                $this->tot_amount = $aryResponse['inputval1'];
                $_SESSION['nn_tid_elv_at'] = $aryResponse['tid'];
                $test_mode = $this->testmode;
                $old_comments = $order->info['comments'];
                $order->info['comments'] = '';
                
                $test_order_status = (((isset($aryResponse['test_mode']) && $aryResponse['test_mode'] == 1) || (isset($this->testmode) && $this->testmode == 1)) ? 1 : 0 );

                if ($test_order_status == 1) {
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_ELV_AT_TEST_ORDER_MESSAGE;
                }
                if ($this->order_status)
                    $order->info['order_status'] = $this->order_status;
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_ELV_AT_TID_MESSAGE . $aryResponse['tid'] . '<BR>';
                $order->info['comments'] = str_replace(array('<b>', '</b>', '<B>', '</B>', '<br>', '<br />', '<BR>'), array('', '', '', '', "\n", "\n", "\n"), $order->info['comments']);
                $order->info['comments'] .= $old_comments;
            }
            ### Passing through the Transaction ID from Novalnet's paygate into order-info ###
        }
        else {
            ### Passing through the Error Response from Novalnet's paygate into order-info ###
            $order->info['comments'] .= '. Novalnet Error Code : ' . $aryResponse['status'] . ', Novalnet Error Message : ' . $aryResponse['status_desc'];
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode($aryResponse['status_desc']));
            if ($this->is_ajax) {
                if ($this->isActivatedCallback && in_array(strtolower($order->customer['country']['iso_code_2']), $this->nnelvat_allowed_pin_country_list) && $amount >= MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_MIN_LIMIT) {
                    $_SESSION['checkout_payment_error'] = $payment_error_return;
                } else {
                    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, '', 'SSL', true, false) . '?' . $payment_error_return);
                }
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
            }
        }
        return;
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

    /*
     * Realtime accesspoint for communication to the Novalnet paygate
     *
     * @return array
     */

    function perform_https_request($nn_url, $urlparam) {
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
        #close connection
        curl_close($ch);
        ## read and return data from novalnet paygate
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
        $vSomeSpecialChars = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ", "ä", "ö", "ü", "Ä", "Ö", "Ü", "ß", "ë");
        $vReplacementChars = array("ae", "ee", "ie", "oe", "ue", "Ae", "Ee", "Ie", "Oe", "Ue", "ne", "Ne", "ae", "oe", "ue", "Ae", "Oe", "Ue", "ss", "ee");
        $vReplacedString = str_replace($vSomeSpecialChars, $vReplacementChars, $vOriginalString);
        return $vReplacedString;
    }

    /*
     * replace the Special German Charectors
     *
     * @return array
     */

    function ReplaceSpecialGermanCharsUML($string) {
        $what = array("ä", "ö", "ü", "Ä", "Ö", "Ü", "ß");
        $how = array("&auml;", "&ouml;", "&uuml;", "&Auml;", "&Ouml;", "&Uuml;", "&szlig;");
        $string = str_replace($what, $how, $string);
        return $string;
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
        if ($this->order_status) {
            xtc_db_query("UPDATE " . TABLE_ORDERS . " SET orders_status='" . $this->order_status . "' WHERE orders_id='" . $insert_id . "'");
        }
        list($product_id, $tariff_id) = $this->get_prod_tarif_id($this->tot_amount);
        if (isset($_SESSION['nn_tid_elv_at'])) {
            ### Pass the Order Reference to paygate ##
            $url = 'https://payport.novalnet.de/paygate.jsp';
            $urlparam = 'vendor=' . $this->vendorid . '&product=' . $product_id . '&key=' . $this->KEY . '&tariff=' . $tariff_id;
            $urlparam .= '&order_no=' . $insert_id;
            $urlparam .= '&auth_code=' . $this->authcode . '&status=100&tid=' . $_SESSION['nn_tid_elv_at'] . '&vwz3=' . $insert_id . '&vwz3_prefix=' . MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_ORDERNO . '&vwz4=' . date('Y.m.d') . '&vwz4_prefix=' . MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_ORDERDATE;
            $this->perform_https_request($url, $urlparam);
        }
        unset($_SESSION['nn_tid_elv_at']);
		if(isset($_SESSION['nn_tid_invoice'])) unset($_SESSION['nn_tid_invoice']);
		if(isset($_SESSION['nn_tid_elv_de'])) unset($_SESSION['nn_tid_elv_de']);   
		if(isset($_SESSION['nn_tid_tel'])) unset($_SESSION['nn_tid_tel']);          
        unset($_SESSION['bank_account_at']);
        unset($_SESSION['bank_code_at']);
        unset($_SESSION['bank_account_holder_at']);
        unset($_SESSION['max_time_elv_at']);
        unset($_SESSION['test_mode_elv_at']);
        unset($_SESSION['email_reply_check_elv_at']);
        unset($_SESSION['xml_resp_error_elv_at']);
        unset($_SESSION['user_tel_elv_at']);
        unset($_SESSION['user_email_elv_at']);
        unset($_SESSION['amount_first_elv_at']);
        unset($_SESSION['prod_total_amount_elv_at']);
        unset($_SESSION['shipping_name_elv_at']);
        unset($_SESSION['nn_total_amount_elv_at']);
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
        $error = array('title' => MODULE_PAYMENT_NOVALNET_ELV_AT_TEXT_ERROR, 'error' => stripslashes(html_entity_decode($HTTP_GET_VARS['error'])));
        return $error;
    }

    /*
     * Check to see whether module is installed
     *
     *  @return boolean
     */

    function check() {
        if (!isset($this->_check)) {
            $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_NOVALNET_ELV_AT_STATUS'");
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
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_ALLOWED', '', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS', 'False', '6', '1', 'xtc_cfg_select_option(array( \'False\', \'Callback (Telefon & Handy)\', \'SMS (nur Handy)\', \'Email Reply\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_MIN_LIMIT', '', '6', '2', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_STATUS', 'True', '6', '3', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_TEST_MODE', 'True', '6', '4', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_VENDOR_ID', '', '6', '5', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_AUTH_CODE', '', '6', '6', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_PRODUCT_ID', '', '6', '7', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_TARIFF_ID', '', '6', '8', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_MANUAL_CHECK_LIMIT', '', '6', '9', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_PRODUCT_ID2', '', '6', '10', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_TARIFF_ID2', '', '6', '11', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_INFO', '', '6', '12', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_SORT_ORDER', '0', '6', '13', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_ORDER_STATUS_ID', '0', '6', '14', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_ZONE', '0', '6', '15', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_ELV_AT_PROXY', '', '6', '16', now())");
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
        return array('MODULE_PAYMENT_NOVALNET_ELV_AT_ALLOWED', 'MODULE_PAYMENT_NOVALNET_ELV_AT_STATUS', 'MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_SMS', 'MODULE_PAYMENT_NOVALNET_ELV_AT_PIN_BY_CALLBACK_MIN_LIMIT', 'MODULE_PAYMENT_NOVALNET_ELV_AT_TEST_MODE', 'MODULE_PAYMENT_NOVALNET_ELV_AT_VENDOR_ID', 'MODULE_PAYMENT_NOVALNET_ELV_AT_AUTH_CODE', 'MODULE_PAYMENT_NOVALNET_ELV_AT_PRODUCT_ID', 'MODULE_PAYMENT_NOVALNET_ELV_AT_TARIFF_ID', 'MODULE_PAYMENT_NOVALNET_ELV_AT_MANUAL_CHECK_LIMIT', 'MODULE_PAYMENT_NOVALNET_ELV_AT_PRODUCT_ID2', 'MODULE_PAYMENT_NOVALNET_ELV_AT_TARIFF_ID2', 'MODULE_PAYMENT_NOVALNET_ELV_AT_INFO', 'MODULE_PAYMENT_NOVALNET_ELV_AT_SORT_ORDER', 'MODULE_PAYMENT_NOVALNET_ELV_AT_ORDER_STATUS_ID', 'MODULE_PAYMENT_NOVALNET_ELV_AT_ZONE', 'MODULE_PAYMENT_NOVALNET_ELV_AT_PROXY');
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

    function debug2($object, $filename) {
        $fh = fopen("/tmp/$filename", 'a+');
        if (gettype($object) == 'object' or gettype($object) == 'array') {
            fwrite($fh, serialize($object));
        } else {
            fwrite($fh, date('H:i:s') . ' ' . $object);
        }
        fwrite($fh, "<hr />\n");
        fclose($fh);
    }

    function novalnet_elv_at_sanitizeCcNumber(&$ccNumber) {
        $ccNumber = preg_replace('/[\-\s]+/', '', $ccNumber);
        return $ccNumber;
    }

    function novalnet_elv_at_getCcType($ccNumber) {
        if (preg_match('/^[0-9]+$/', $ccNumber)) {
            return true;
        }
        return false;
    }

    #Method to return the error message

    function paymentErrrorMessage($aryResponse) {
        $error = '';
        if ($aryResponse['status_text'] != '') {
            $error = $aryResponse['status_text'];
        } elseif ($aryResponse['status_desc'] != '') {
            $error = $aryResponse['status_desc'];
        } elseif ($aryResponse['status_message'] != '') {
            $error = $aryResponse['status_message'];
        } elseif ($aryResponse['pin_status']->status_message != '') {
            $error = $aryResponse['pin_status']->status_message;
        } else {
            $error = MODULE_PAYMENT_NOVALNET_ELV_AT_PAYMENT_MESSAGE;
        }
        return $error;
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
