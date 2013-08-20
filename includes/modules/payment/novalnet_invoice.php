<?php

#########################################################
#                                                       #
#  Invoice payment method class                         #
#  This module is used for real time processing of      #
#  Invoice data of customers.                       	#
#                                                       #
#  Released under the GNU General Public License.       #
#  This free contribution made by request.              #
#  If you have found this script useful a small         #
#  recommendation as well as a comment on merchant form #
#  would be greatly appreciated.                        #
#                                                       #
#  Script : novalnet_invoice.php                        #
#                                                       #
#########################################################

require_once (DIR_FS_INC . 'xtc_format_price_order.inc.php');

class novalnet_invoice {

    var $code;
    var $title;
    var $description;
    var $enabled;
    var $proxy;
    var $is_ajax = false;
    var $KEY = 27;
    var $vendorid;
    var $productid;
    var $authcode;
    var $tariffid;
    var $testmode;
    var $logo_title;
    var $payment_logo_title;
    var $nninvoice_allowed_pin_country_list = array('de', 'at', 'ch');

    /**
     * Constructor
     *
     * @return void
     */
    function novalnet_invoice() {
        global $order;
        $this->code = 'novalnet_invoice';
        $this->logo_title = MODULE_PAYMENT_NOVALNET_INVOICE_LOGO_TITLE;
        $this->payment_logo_title = MODULE_PAYMENT_NOVALNET_INVOICE_PAYMENT_LOGO_TITLE;
        $this->title = MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_TITLE . '<br>' . $this->logo_title . $this->payment_logo_title; //backend
        $this->public_title = MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_PUBLIC_TITLE; //frontend
        $this->description = MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_PAYMENT_NOVALNET_INVOICE_SORT_ORDER;
        $this->enabled = ((MODULE_PAYMENT_NOVALNET_INVOICE_STATUS == 'True') ? true : false);
        $this->proxy = MODULE_PAYMENT_NOVALNET_INVOICE_PROXY;
        $this->image = ( MODULE_PAYMENT_ENABLE_NOVALNET_LOGO == 1) ? $this->logo_title . $this->payment_logo_title : $this->payment_logo_title;

        $this->doAssignConfigVarsToMembers();
        $this->checkConfigure();
        if (CHECKOUT_AJAX_STAT == 'true') {
            $this->is_ajax = true;
        }
        // Check the tid in session and make the second call
        if ($_SESSION['nn_tid_invoice']) {
            //Check the time limit
            if ($_SESSION['max_time_invoice'] && time() > $_SESSION['max_time_invoice']) {
                unset($_SESSION['nn_tid_invoice']);
                unset($_SESSION['nn_invoice_pin_max_exceed']);
                $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SESSION_ERROR));
                if ($this->is_ajax) {
                    $_SESSION['checkout_payment_error'] = $payment_error_return;
                    return;
                } else {
                    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                }
            }
            if ($_GET['new_novalnet_pin_invoice'] == 'true') {
                $_SESSION['new_novalnet_pin_invoice'] = true;
                //$this->secondCall();
                $response = $this->secondCall();
                if ($response['status'] != 100) {
                    $_SESSION['xml_resp_error_invoice'] = $this->paymentErrrorMessage($response);
                    $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($_SESSION['xml_resp_error_invoice']) . ' (' . $aryResponse['status'] . ')';
                    if ($response['status'] == '0529006' || $response['status'] == '0529010' || $response['status'] == '0529008') {
                        $_SESSION['nn_invoice_pin_max_exceed'] = TRUE;
                        //unset($_SESSION['nn_tid_elv_de']);
                    }
                    if ($this->is_ajax) {
                        $_SESSION['checkout_payment_error'] = $payment_error_return;
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                }
            }
            if (!$this->is_ajax && $_SESSION['email_reply_check_invoice'] == 'Email Reply' && !isset($_SESSION['xml_resp_error_invoice'])) {
                //$this->secondCall();
                $response = $this->secondCall();
                if ($response['status'] != 100) {
                    $_SESSION['xml_resp_error_invoice'] = $this->paymentErrrorMessage($response);
                    $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($_SESSION['xml_resp_error_invoice']) . ' (' . $response['status'] . ')';
                    if ($response['status'] == '0529006' || $response['status'] == '0529010' || $response['status'] == '0529008') {
                        $_SESSION['nn_invoice_pin_max_exceed'] = TRUE;
                        //unset($_SESSION['nn_tid_elv_de']);
                    }
                    if ($this->is_ajax) {
                        //$_SESSION['checkout_payment_error'] = $payment_error_return;
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, $payment_error_return, 'SSL', true, false));
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                }
            }
        }
        if ((int) MODULE_PAYMENT_NOVALNET_INVOICE_ORDER_STATUS_ID > 0) {
            $this->order_status = MODULE_PAYMENT_NOVALNET_INVOICE_ORDER_STATUS_ID;
        }
        // define callback types
        $this->isActivatedCallback = false;
        if (MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS != 'False') {
            $this->isActivatedCallback = true;
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
        $this->vendorid = trim(MODULE_PAYMENT_NOVALNET_INVOICE_VENDOR_ID);
        $this->productid = trim(MODULE_PAYMENT_NOVALNET_INVOICE_PRODUCT_ID);
        $this->authcode = trim(MODULE_PAYMENT_NOVALNET_INVOICE_AUTH_CODE);
        $this->tariffid = trim(MODULE_PAYMENT_NOVALNET_INVOICE_TARIFF_ID);
        $this->testmode = (strtolower(MODULE_PAYMENT_NOVALNET_INVOICE_TEST_MODE) == 'true' or MODULE_PAYMENT_NOVALNET_INVOICE_TEST_MODE == '1') ? 1 : 0;
    }

    /**
     * Test configure values and test mode in admin panel
     *
     * @return void
     */
    function checkConfigure() {
        if (IS_ADMIN_FLAG == true) {
            if ($this->enabled == 'true' && (empty($this->vendorid) || empty($this->productid) || empty($this->authcode) || empty($this->tariffid))) {
                $this->title .= '<br>' . MODULE_PAYMENT_NOVALNET_INVOICE_NOT_CONFIGURED;
            } elseif ($this->testmode == '1') {
                $this->title .= '<br>' . MODULE_PAYMENT_NOVALNET_INVOICE_IN_TEST_MODE;
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
        if (($this->enabled == true) && ((int) MODULE_PAYMENT_NOVALNET_INVOICE_ZONE > 0)) {
            $check_flag = false;
            $check_query = xtc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_NOVALNET_INVOICE_ZONE . "' and
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
        
        
        if (($this->is_ajax || (!$this->is_ajax && !$_SESSION['nn_tid_invoice'])) && !isset($_SESSION['nn_invoice_pin_max_exceed'])) {
            $selection = array('id' => $this->code,
                'module' => $this->public_title,
                'fields' => array(array('title' => '', 'field' => $this->image . $this->description))
            );
            // Display callback fields
            $amount_check = $this->findTotalAmount();
            $_SESSION['amount_first_invoice'] = $this->findTotalAmount();

            if ($this->isActivatedCallback && in_array(strtolower($order->customer['country']['iso_code_2']), $this->nninvoice_allowed_pin_country_list) && $amount_check >= MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_MIN_LIMIT) {
                if (MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'Email Reply') {
                    $selection['fields'][] = array('title' => MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_EMAIL, 'field' => xtc_draw_input_field('user_email_invoice','', 'id="' . $this->code . '-callback" ' . $onFocus));
                } else {
                    if (MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'Callback (Telefon & Handy)') {
                        $selection['fields'][] = array('title' => MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS_TEL, 'field' => xtc_draw_input_field('user_tel_invoice','', 'id="' . $this->code . '-callback" ' . $onFocus));
                    }
                    if (MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'SMS (nur Handy)') {
                        $selection['fields'][] = array('title' => MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS_MOB, 'field' => xtc_draw_input_field('user_tel_invoice','', 'id="' . $this->code . '-callback" ' . $onFocus));
                    }
                }
            }
        }
        $amount_check = $_SESSION['amount_first_invoice'];
        if ($this->isActivatedCallback && in_array(strtolower($order->customer['country']['iso_code_2']), $this->nninvoice_allowed_pin_country_list) && $amount_check >= MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_MIN_LIMIT) {
            if (($this->is_ajax || (!$this->is_ajax && $_SESSION['nn_tid_invoice'])) && !isset($_SESSION['nn_invoice_pin_max_exceed'])) {
                if (!$this->is_ajax) {
                    $selection = array('id' => $this->code, 'module' => $this->public_title);
                }
                if (MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'Email Reply') {
                    if ($this->is_ajax) {
                        $selection['fields'][] = array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_INVOICE_EMAIL_INFO_DESC);
                        $selection['fields'][] = array('title' => '', 'field' => xtc_draw_checkbox_field('email_replied_invoice', '1', false) . MODULE_PAYMENT_NOVALNET_INVOICE_EMAIL_REPLY_INFO);
                    } else {
                        $selection['fields'][] = array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_INVOICE_EMAIL_INPUT_REQUEST_DESC);
                    }
                } else {
                    if ($this->is_ajax) {
                        unset($_SESSION['email_reply_check_invoice']);
                        $selection['fields'][] = array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_INVOICE_PIN_INFO_DESC);
                        $selection['fields'][] = array('title' => MODULE_PAYMENT_NOVALNET_INVOICE_PIN_INPUT_REQUEST_DESC, 'field' => xtc_draw_input_field('novalnet_pin_invoice', '', 'id="' . $this->code . '-callback" ' . $onFocus));
                        $selection['fields'][] = array('title' => '', 'field' => xtc_draw_checkbox_field('forgot_pin_invoice', '1', false, 'id="' . $this->code . '-forgotpin"' . $onFocus) . MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS_NEW_PIN);
                        $selection['fields'][] = array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_INVOICE_FORGOT_PIN_DIV);
                    } else {
                        // Show PIN field, after first call
                        $selection['fields'][] = array('title' => MODULE_PAYMENT_NOVALNET_INVOICE_PIN_INPUT_REQUEST_DESC, 'field' => xtc_draw_input_field('novalnet_pin_invoice', '', 'id="' . $this->code . '-callback" ' . $onFocus));
                        $selection['fields'][] = array('title' => '', 'field' => '<a href="' . xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'new_novalnet_pin_invoice=true', 'SSL', true, false) . '">' . MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS_NEW_PIN . '</a>');
                    }
                }
            }
        }
        $selection['fields'][] = array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_INVOICE_INFO);
        $selection['fields'][] = array('title' => '', 'field' =>$mode);
        if (function_exists(get_percent)) {
            $selection['module_cost'] = $GLOBALS['ot_payment']->get_percent($this->code);
        }
        return $selection;
    }

    /**
     * Precheck to Evaluate the Novalnet backend params
     * Precheck to Evaluate the  params
     *
     * @return void
     */
    function pre_confirmation_check($vars) {
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
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_INVOICE_REQUEST_FOR_CHOOSE_SHIPPING_METHOD));
            $_SESSION['checkout_payment_error'] = $payment_error_return;
            return;
        }
        if (!is_array($HTTP_POST_VARS) && !$HTTP_POST_VARS) {
            $HTTP_POST_VARS = array();
        }
        if ($this->is_ajax) {
            $HTTP_POST_VARS = array_merge($HTTP_POST_VARS, $vars);
        } else {
            $HTTP_POST_VARS = array_merge($HTTP_POST_VARS, $_POST);
        }
        if (isset($HTTP_POST_VARS['user_tel_invoice'])) {
            $HTTP_POST_VARS['user_tel_invoice'] = trim($HTTP_POST_VARS['user_tel_invoice']);
        }
        if (isset($HTTP_POST_VARS['user_email_invoice'])) {
            $HTTP_POST_VARS['user_email_invoice'] = trim($HTTP_POST_VARS['user_email_invoice']);
        }
        if (isset($HTTP_POST_VARS['novalnet_pin_invoice'])) {
            $HTTP_POST_VARS['novalnet_pin_invoice'] = trim($HTTP_POST_VARS['novalnet_pin_invoice']);
        }
        if ($_SESSION['nn_tid_invoice']) {
            // Callback stuff....
            if (($order->info['subtotal'] != $_SESSION['prod_total_amount_invoice']) || ($order->info['shipping_class'] != $_SESSION['shipping_name_invoice'] )) {
                if (( MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'Callback (Telefon & Handy)' ) || ( MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'SMS (nur Handy)' )) {
                    $error = NOVALNET_AMOUNT_VARIATION_MESSAGE_PIN;
                }
                if (MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'Email Reply') {
                    $error = NOVALNET_AMOUNT_VARIATION_MESSAGE_EMAIL;
                }
                $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode($error));
                unset($_SESSION['nn_tid_invoice']);
                unset($_SESSION['prod_total_amount_invoice']);
                unset($_SESSION['shipping_name_invoice']);
                if ($this->is_ajax) {
                    $_SESSION['checkout_payment_error'] = $payment_error_return;
                    return;
                } else {
                    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                }
            }
            //if($this->is_ajax && $HTTP_POST_VARS['forgot_pin_invoice'] && !$HTTP_POST_VARS['novalnet_pin_invoice'] && isset($_SESSION['nn_tid_invoice'])){
            if ($this->is_ajax && $HTTP_POST_VARS['forgot_pin_invoice'] && isset($_SESSION['nn_tid_invoice'])) {
                $_SESSION['new_novalnet_pin_invoice'] = true;
                //$this->secondCall();
                $response = $this->secondCall();
                if ($response['status'] != 100) {
                    $_SESSION['xml_resp_error_invoice'] = $this->paymentErrrorMessage($response);
                    $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($_SESSION['xml_resp_error_invoice']) . ' (' . $response['status'] . ')';
                    if ($response['status'] == '0529006' || $response['status'] == '0529010' || $response['status'] == '0529008') {
                        $_SESSION['nn_invoice_pin_max_exceed'] = TRUE;
                        //unset($_SESSION['nn_tid_elv_de']);
                    }
                    if ($this->is_ajax) {
                        $_SESSION['checkout_payment_error'] = $payment_error_return;
                        //xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, $payment_error_return, 'SSL', true, false));
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                }
                return;
            }
            if ($this->is_ajax && MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'Email Reply') {
                if ($this->is_ajax && !$HTTP_POST_VARS['email_replied_invoice']) {
                    $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_INVOICE_EMAIL_REPLY_CHECKBOX_INFO));
                    if ($this->is_ajax) {
                        $_SESSION['checkout_payment_error'] = $payment_error_return;
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                } else {
                    $_SESSION['email_reply_check_invoice'] = 'Email Reply';
                }
            }
            if (isset($HTTP_POST_VARS['novalnet_pin_invoice']) && isset($_SESSION['nn_tid_invoice'])) {
                // check pin
                if (empty($HTTP_POST_VARS['novalnet_pin_invoice']) || !preg_match('/^[a-zA-Z0-9]+$/', $HTTP_POST_VARS['novalnet_pin_invoice'])) {
                    $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS_PIN_NOTVALID));
                    if ($this->is_ajax) {
                        $_SESSION['checkout_payment_error'] = $payment_error_return;
                    } else {
                        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                    }
                } else {
                    if ($HTTP_POST_VARS['novalnet_pin_invoice'])
                        $_SESSION['novalnet_pin_invoice'] = $HTTP_POST_VARS['novalnet_pin_invoice'];
                }
            }
        }
        else {
            $error = '';
            if ($this->is_ajax || (!$this->is_ajax && !isset($_SESSION['nn_tid_invoice']))) {
                if (empty($this->vendorid) || empty($this->productid) || empty($this->authcode) || empty($this->tariffid)) {
                    $error .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_JS_NN_MISSING;
                }
                if (isset($HTTP_POST_VARS['user_tel_invoice'])) {
                    $_SESSION['user_tel_invoice'] = $HTTP_POST_VARS['user_tel_invoice'];
                }
                if (isset($HTTP_POST_VARS['user_email_invoice'])) {
                    $_SESSION['user_email_invoice'] = $HTTP_POST_VARS['user_email_invoice'];
                }
                // Callback stuff....
                $amount_check = $_SESSION['amount_first_invoice'];
                if ($this->isActivatedCallback && in_array(strtolower($order->customer['country']['iso_code_2']), $this->nninvoice_allowed_pin_country_list) && $amount_check >= MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_MIN_LIMIT) {
                    if ($error == '') {
                        //checking telephone number
                        if (isset($HTTP_POST_VARS['user_email_invoice'])) {
                            if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $HTTP_POST_VARS['user_email_invoice'])) {
                                $error .= utf8_decode(MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_EMAIL_NOTVALID);
                            }
                        }
                        if (isset($HTTP_POST_VARS['user_tel_invoice'])) {
                            if (strlen($HTTP_POST_VARS['user_tel_invoice']) < 8 || !is_numeric($HTTP_POST_VARS['user_tel_invoice'])) {
                                $error .= utf8_decode(MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS_TEL_NOTVALID);
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
                        $this->before_process();
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

    public function secondCall() {
        // If customer forgets PIN, send a new PIN
        if ($_SESSION['new_novalnet_pin_invoice'])
            $request_type = 'TRANSMIT_PIN_AGAIN';
        else {
            $request_type = 'PIN_STATUS';
        }
        if ($_SESSION['email_reply_check_invoice'] == 'Email Reply') {
            $request_type = 'REPLY_EMAIL_STATUS';
        }
        if ($_SESSION['new_novalnet_pin_invoice'])
            $_SESSION['new_novalnet_pin_invoice'] = false;
        if ($request_type == 'REPLY_EMAIL_STATUS') {
            $xml = '<?xml version="1.0" encoding="UTF-8"?>
				<nnxml>
		  			<info_request>
			    		<vendor_id>' . $this->vendorid . '</vendor_id>
			    		<vendor_authcode>' . $this->authcode . '</vendor_authcode>
			    		<request_type>' . $request_type . '</request_type>
			    		<tid>' . $_SESSION['nn_tid_invoice'] . '</tid>
		  			</info_request>
				</nnxml>';
        } else {
            $xml = '<?xml version="1.0" encoding="UTF-8"?>
				<nnxml>
		  			<info_request>
			    		<vendor_id>' . $this->vendorid . '</vendor_id>
			    		<vendor_authcode>' . $this->authcode . '</vendor_authcode>
			    		<request_type>' . $request_type . '</request_type>
			    		<tid>' . $_SESSION['nn_tid_invoice'] . '</tid>
			    		<pin>' . $_SESSION['novalnet_pin_invoice'] . '</pin>
		  			</info_request>
				</nnxml>';
        }
        $xml_response = $this->curl_xml_post($xml);
        $xml_response = simplexml_load_string($xml_response);
        $array = (array) $xml_response;
        return $array;
    }

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
        #close connection
        curl_close($ch);
        return $xml_response;
    }

    ### Display Bank Information on the Checkout Confirmation Page ###
    // @return array

    function confirmation() {
        global $HTTP_POST_VARS, $_POST, $order;
        $total = $this->findTotalAmount();
        $_SESSION['nn_total_invoice'] = $total;
        $_SESSION['amount_first_invoice'] = $total;
        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;
        //$confirmation = array('fields' => array(array('title' => $this->public_title, 'field' => MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_BANK_INFO)));
        $confirmation = array('');
        return $confirmation;
    }

    /**
     * Build the data and actions to process when the "Submit" button is pressed on the order-confirmation screen.
     * These are hidden fields on the checkout confirmation page
     *
     * @return string
     */
    function process_button() {
        global $HTTP_POST_VARS, $_POST;
        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;
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
    function before_process($vars) {

        global $HTTP_POST_VARS, $_POST, $order, $xtPrice, $currencies, $customer_id;
        if ($this->is_ajax) {
            if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
                $HTTP_POST_VARS = $vars;
        } else {
            if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
                $HTTP_POST_VARS = $_POST;
        }
        // First call is done, so check PIN / second call...
        if ($_SESSION['nn_tid_invoice'] && $this->isActivatedCallback) {
			if( isset($_SESSION['nn_total_amount_invoice']) && $_SESSION['nn_total_amount_invoice'] != $_SESSION['amount_first_invoice']){
                if (( MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'Callback (Telefon & Handy)' ) || ( MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'SMS (nur Handy)' )) {
                    $error = NOVALNET_AMOUNT_VARIATION_MESSAGE_PIN;
                }
                if (MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'Email Reply') {
                    $error = NOVALNET_AMOUNT_VARIATION_MESSAGE_EMAIL;
                }
                $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode($error));
                unset($_SESSION['nn_total_amount_invoice']);
                unset($_SESSION['nn_tid_invoice']);
                unset($_SESSION['prod_total_amount_invoice']);
                unset($_SESSION['shipping_name_invoice']);
                if ($this->is_ajax) {
                    $_SESSION['checkout_payment_error'] = $payment_error_return;
                    return;
                } else {
                    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                }
			}
            if (MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'Email Reply')
                $_SESSION['email_reply_check_invoice'] = 'Email Reply';
            else
                unset($_SESSION['email_reply_check_invoice']);
            if ($this->is_ajax && $HTTP_POST_VARS['forgot_pin_invoice'] && !$HTTP_POST_VARS['novalnet_pin_invoice'])
                $_SESSION['new_novalnet_pin_invoice'] = true;
            else
                $_SESSION['new_novalnet_pin_invoice'] = false;
            $aryResponse = $this->secondCall();
            if ($aryResponse) {
                if ($aryResponse['status'] != 100) {
                    $nnxmlsession = $this->paymentErrrorMessage($aryResponse);
                    $_SESSION['xml_resp_error_invoice'] = 'test';
                    $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($nnxmlsession) . ' (' . $aryResponse['status'] . ')';
                    if ($aryResponse['status'] == '0529006' || $aryResponse['status'] == '0529010' || $aryResponse['status'] == '0529008') {
                        $_SESSION['nn_invoice_pin_max_exceed'] = TRUE;
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
                    $formatted_amount = xtc_format_price_order($_SESSION['original_amount_invoice'], 1, $order->info['currency']);
                    $old_comments = $order->info['comments'];
                    $order->info['comments'] = "";
                    $newlinebreak = "\n";
                    //Test mode based on the responsone test mode value

                    $test_order_status = (((isset($_SESSION['test_mode_invoice']) && $_SESSION['test_mode_invoice'] == 1) || (isset($this->testmode) && $this->testmode == 1)) ? 1 : 0 );
                    if ($test_order_status == 1) {
                        $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEST_ORDER_MESSAGE;
                    }

                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_TITLE . $newlinebreak;
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TID_MESSAGE . ' ' . $_SESSION['nn_tid_invoice'] . $newlinebreak . $newlinebreak;
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_DURATION_LIMIT_INFO . $newlinebreak;
                    if ($_SESSION['due_date_invoice']) {
                        $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_DUE_DATE . ' ' . $_SESSION['due_date_invoice'] . $newlinebreak;
                    }
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_BANK_ACCOUNT_OWNER . ' NOVALNET AG ' . $newlinebreak;
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_BANK_ACCOUNT_NUMBER . ' ' . $_SESSION['nn_invoice_account'] . $newlinebreak;
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_BANK_CODE . ' ' . $_SESSION['nn_invoice_bankcode'] . $newlinebreak;
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_BANK_BANK . ' ' . $_SESSION['nn_invoice_bankname'] . ' ' . trim($_SESSION['nn_invoice_bankplace']) . $newlinebreak;
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_AMOUNT . ' ' . $formatted_amount . $newlinebreak;
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_REF_TID_MESSAGE . $_SESSION['nn_tid_invoice'] . $newlinebreak . $newlinebreak;
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_IBAN_INFO . $newlinebreak;
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_BANK_IBAN . ' ' . $_SESSION['nn_invoice_iban'] . $newlinebreak;
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_BANK_BIC . ' ' . $_SESSION['nn_invoice_bic'] . $newlinebreak;
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_REFERENCE_INFO . $newlinebreak;
                    $order->info['comments'] = html_entity_decode($order->info['comments'], ENT_QUOTES, "UTF-8");
                    $order->info['comments'] .= $old_comments;
                }
            }
            return;
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
        $amount = $_SESSION['amount_first_invoice'];
        $product_id = $this->productid;
        $tariff_id = $this->tariffid;
        $payment_duration = MODULE_PAYMENT_NOVALNET_INVOICE_DURATION;
        $payment_duration = trim($payment_duration);
        $payment_duration = str_replace(' ', '', $payment_duration);
        if (!preg_match("/^[0-9]*$/", $payment_duration)) {
            $payment_duration = '';
        }
        $due_date = '';
        $due_date_string = '';
        if ($payment_duration) {
            $due_date = date("d.m.Y", mktime(0, 0, 0, date("m"), date("d") + $payment_duration, date("Y")));
            $due_date_string = '&due_date=' . date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + $payment_duration, date("Y")));
        }
        $user_ip = $this->getRealIpAddr();
        //set the user telephone
        if ($_SESSION['user_tel_invoice']) {
            $user_telephone = $_SESSION['user_tel_invoice'];
        } else {
            $user_telephone = $order->customer['telephone'];
        }
        //set the user email
        if ($_SESSION['user_email_invoice']) {
            $user_email = $_SESSION['user_email_invoice'];
        } else {
            $user_email = utf8_decode($order->customer['email_address']);
        }
        // set post params
        if ($this->isActivatedCallback && in_array(strtolower($order->customer['country']['iso_code_2']), $this->nninvoice_allowed_pin_country_list) && $amount >= MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_MIN_LIMIT) {
            if (MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'Callback (Telefon & Handy)') {
                $this->callback_type = '&pin_by_callback=1';
                $url_telephone = '&tel=' . $user_telephone;
            }
            if (MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'SMS (nur Handy)') {
                $this->callback_type = '&pin_by_sms=1';
                $url_telephone = '&mobile=' . $user_telephone;
            }
            if (MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'Email Reply') {
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
        $urlparam = 'vendor=' . $this->vendorid . '&product=' . $product_id . '&key=' . $this->KEY . '&tariff=' . $tariff_id;
        $urlparam .= '&auth_code=' . $this->authcode . '&currency=' . $order->info['currency'];
        $urlparam .= '&amount=' . $amount . '&invoice_type=INVOICE' . $due_date_string;
        $urlparam .= '&first_name=' . utf8_decode($firstname) . '&last_name=' . utf8_decode($lastname);
        $urlparam .= '&street=' . utf8_decode($street_address) . '&city=' . utf8_decode($city) . '&zip=' . $postcode;
        $urlparam .= '&country=' . $country_iso_code_2 . '&email=' . $user_email;
        $urlparam .= '&search_in_street=1' . $url_telephone . '&remote_ip=' . $user_ip;
        $urlparam .= '&gender=' . $customer['customers_gender'] . '&birth_date=' . $customer['customers_dob'] . '&fax=' . $customer['customers_fax'];
        $urlparam .= '&language=' . MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_LANG;
        $urlparam .= '&lang=' . MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_LANG;
        $urlparam .= '&test_mode=' . $this->testmode;
        $urlparam .= '&customer_no=' . $customer_no . '&use_utf8=1';
        // For PIN by call back
        $urlparam .= $this->callback_type;
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
            $_SESSION['nn_total_amount_invoice'] = $_SESSION['amount_first_invoice'];
            $_SESSION['prod_total_amount_invoice'] = $order->info['subtotal'];
            $_SESSION['shipping_name_invoice'] = $order->info['shipping_class'];
            $_SESSION['nn_tid_invoice'] = $aryResponse['tid'];

            ### Passing through the Transaction ID from Novalnet's paygate into order-info ###
            if ($this->isActivatedCallback && in_array(strtolower($order->customer['country']['iso_code_2']), $this->nninvoice_allowed_pin_country_list) && $amount >= MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_MIN_LIMIT) {
                // To avoide payment method confussion add code in session
                //set session for maximum time limit to 30 minutes
                $_SESSION['max_time_invoice'] = time() + (30 * 60);
                //TEST BILLING MESSAGE BASED ON THE RESPONSE TEST MODE
                $test_mode = $this->testmode;
                if ($test_mode) {
                    $_SESSION['test_mode_invoice'] = $test_mode;
                }
                $_SESSION['original_amount_invoice'] = $aryResponse['amount'];
                $_SESSION['due_date_invoice'] = $due_date;
                ### WRITE THE INVOICE BANK DATA ON SESSION ###
                $_SESSION['nn_invoice_account'] = $aryResponse['invoice_account'];
                $_SESSION['nn_invoice_bankcode'] = $aryResponse['invoice_bankcode'];
                $_SESSION['nn_invoice_iban'] = $aryResponse['invoice_iban'];
                $_SESSION['nn_invoice_bic'] = $aryResponse['invoice_bic'];
                $_SESSION['nn_invoice_bankname'] = $aryResponse['invoice_bankname'];
                $_SESSION['nn_invoice_bankplace'] = $aryResponse['invoice_bankplace'];
                if (MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS == 'Email Reply') {
                    $checkoutmsg = MODULE_PAYMENT_NOVALNET_INVOICE_EMAIL_REPLY_CHECK_MSG;
                } else {
                    $checkoutmsg = MODULE_PAYMENT_NOVALNET_INVOICE_PIN_CHECK_MSG;
                }
                $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode($checkoutmsg));
                if ($this->is_ajax) {
                    $_SESSION['checkout_payment_error'] = $payment_error_return;
                } else {
                    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                }
            } else {
                if ($this->order_status)
                    $order->info['order_status'] = $this->order_status;
                $old_comments = $order->info['comments'];
                $order->info['comments'] = "";
                $newlinebreak = "\n";
                $test_mode = $this->testmode;
                $amount = str_replace('.', ',', sprintf("%.2f", $amount / 100));
                
                $test_order_status = (((isset($aryResponse['test_mode']) && $aryResponse['test_mode'] == 1) || (isset($this->testmode) && $this->testmode == 1)) ? 1 : 0 );

                if ($test_order_status == 1) {
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEST_ORDER_MESSAGE;
                }
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_TITLE . $newlinebreak;
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TID_MESSAGE . ' ' . $aryResponse['tid'] . $newlinebreak . $newlinebreak;
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_DURATION_LIMIT_INFO . $newlinebreak;
                if ($due_date) {
                    $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_DUE_DATE . ' ' . $due_date . $newlinebreak;
                }
                $formatted_amount = xtc_format_price_order($aryResponse['amount'], 1, $order->info['currency']);
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_BANK_ACCOUNT_OWNER . ' NOVALNET AG ' . $newlinebreak;
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_BANK_ACCOUNT_NUMBER . ' ' . $aryResponse['invoice_account'] . $newlinebreak;
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_BANK_CODE . ' ' . $aryResponse['invoice_bankcode'] . $newlinebreak;
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_BANK_BANK . ' ' . $aryResponse['invoice_bankname'] . ' ' . trim($aryResponse['invoice_bankplace']) . $newlinebreak;
                //$order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_AMOUNT.' '.$aryResponse['amount'].' '.$order->info['currency'].'\n';
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_AMOUNT . ' ' . $formatted_amount . $newlinebreak;
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_REFERENCE . ' TID ' . $aryResponse['tid'] . $newlinebreak . $newlinebreak;
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_IBAN_INFO . $newlinebreak;
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_BANK_IBAN . ' ' . $aryResponse['invoice_iban'] . $newlinebreak;
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_BANK_BIC . ' ' . $aryResponse['invoice_bic'] . $newlinebreak;
                $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_REFERENCE_INFO . $newlinebreak;
                $order->info['comments'] = html_entity_decode($order->info['comments'], ENT_QUOTES, "UTF-8");
                $order->info['comments'] .= $old_comments;
            }
        } else {
            ### Passing through the Error Response from Novalnet's paygate into order-info ###
            $order->info['comments'] .= '. Novalnet Error Code : ' . $aryResponse['status'] . ',' . NOVALNET_TEXT_ERROR_MESSAGE . $aryResponse['status_desc'];
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode($aryResponse['status_desc']));
            if ($this->is_ajax) {
                if ($this->isActivatedCallback) {
                    $_SESSION['checkout_payment_error'] = $payment_error_return;
                } else {
                    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, $payment_error_return, 'SSL', true, false));
                }
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

    /**
     * get the real Ip Adress of the User ###
     *
     * @return String
     */
    function getRealIpAddr() {
        if ($_SERVER['HTTP_X_FORWARDED_FOR'] and $this->isPublicIP($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if ($_SERVER['HTTP_X_FORWARDED_FOR'] and $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])) {
            if ($this->isPublicIP($iplist[0]))
                return $iplist[0];
        }
        if ($_SERVER['HTTP_CLIENT_IP'] and $this->isPublicIP($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        if ($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'] and $this->isPublicIP($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        }
        if ($_SERVER['HTTP_FORWARDED_FOR'] and $this->isPublicIP($_SERVER['HTTP_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        }
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
        $product_id = $this->productid;
        $tariff_id = $this->tariffid;
        if ($_SESSION['nn_tid_invoice']) {
            ### Pass the Order Reference to paygate ##
            $url = 'https://payport.novalnet.de/paygate.jsp';
            $urlparam = 'vendor=' . $this->vendorid . '&product=' . $product_id . '&key=' . $this->KEY . '&tariff=' . $tariff_id;
            $urlparam .= '&auth_code=' . $this->authcode . '&status=100';
            $urlparam .= '&tid=' . $_SESSION['nn_tid_invoice'];
            $urlparam .= '&order_no=' . $insert_id . '&invoice_ref=BNR-' . $product_id . '-' . $insert_id;
            $urlparam .= '&vwz2=' . MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_ORDERNO . '' . $insert_id . '&vwz3=' . MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_ORDERDATE . '' . date('Y-m-d H:i:s');
            $this->perform_https_request($url, $urlparam);
        }
        unset($_SESSION['user_tel_invoice']);
        unset($_SESSION['nn_tid_invoice']);
        if(isset($_SESSION['nn_tid_elv_de'])) unset($_SESSION['nn_tid_elv_de']);
        if(isset($_SESSION['nn_tid_elv_at'])) unset($_SESSION['nn_tid_elv_at']);
        if(isset($_SESSION['nn_tid_tel'])) unset($_SESSION['nn_tid_tel']);
        unset($_SESSION['max_time_invoice']);
        unset($_SESSION['email_reply_check_invoice']);
        unset($_SESSION['xml_resp_error_invoice']);
        unset($_SESSION['user_tel_invoice']);
        unset($_SESSION['user_email_invoice']);
        unset($_SESSION['amount_first_invoice']);
        unset($_SESSION['prod_total_amount_invoice']);
        unset($_SESSION['shipping_name_invoice']);
        unset($_SESSION['nn_total_amount_invoice']);
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
        $error = array('title' => MODULE_PAYMENT_NOVALNET_INVOICE_TEXT_ERROR, 'error' => stripslashes(html_entity_decode($HTTP_GET_VARS['error'])));
        return $error;
    }

    /*
     * Check to see whether module is installed
     *
     *  @return boolean
     */

    function check() {
        if (!isset($this->_check)) {
            $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key =
      'MODULE_PAYMENT_NOVALNET_INVOICE_STATUS'");
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
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
    ('MODULE_PAYMENT_NOVALNET_INVOICE_ALLOWED', '', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS', 'False', '6', '1', 'xtc_cfg_select_option(array( \'False\', \'Callback (Telefon & Handy)\', \'SMS (nur Handy)\', \'Email Reply\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_MIN_LIMIT', '', '6', '2', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added)
    values ('MODULE_PAYMENT_NOVALNET_INVOICE_STATUS', 'True', '6', '3', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added)
    values ('MODULE_PAYMENT_NOVALNET_INVOICE_TEST_MODE', 'True', '6', '4', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
    ('MODULE_PAYMENT_NOVALNET_INVOICE_VENDOR_ID', '', '6', '5', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
    ('MODULE_PAYMENT_NOVALNET_INVOICE_AUTH_CODE', '', '6', '6', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
    ('MODULE_PAYMENT_NOVALNET_INVOICE_PRODUCT_ID', '', '6', '7', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
    ('MODULE_PAYMENT_NOVALNET_INVOICE_TARIFF_ID', '', '6', '8', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
    ('MODULE_PAYMENT_NOVALNET_INVOICE_DURATION', '', '6', '9', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
    ('MODULE_PAYMENT_NOVALNET_INVOICE_INFO', '', '6', '10', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
    ('MODULE_PAYMENT_NOVALNET_INVOICE_SORT_ORDER', '0', '6', '11', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function,
    date_added) values ('MODULE_PAYMENT_NOVALNET_INVOICE_ORDER_STATUS_ID', '0', '6', '12', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name',
    now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function,
    date_added) values ('MODULE_PAYMENT_NOVALNET_INVOICE_ZONE', '0', '6', '13', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
     ('MODULE_PAYMENT_NOVALNET_INVOICE_PROXY', '', '6', '14', now())");
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
        return array('MODULE_PAYMENT_NOVALNET_INVOICE_ALLOWED', 'MODULE_PAYMENT_NOVALNET_INVOICE_STATUS', 'MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_SMS', 'MODULE_PAYMENT_NOVALNET_INVOICE_PIN_BY_CALLBACK_MIN_LIMIT',
            'MODULE_PAYMENT_NOVALNET_INVOICE_TEST_MODE', 'MODULE_PAYMENT_NOVALNET_INVOICE_VENDOR_ID', 'MODULE_PAYMENT_NOVALNET_INVOICE_AUTH_CODE', 'MODULE_PAYMENT_NOVALNET_INVOICE_PRODUCT_ID', 'MODULE_PAYMENT_NOVALNET_INVOICE_TARIFF_ID', 'MODULE_PAYMENT_NOVALNET_INVOICE_DURATION', 'MODULE_PAYMENT_NOVALNET_INVOICE_INFO', 'MODULE_PAYMENT_NOVALNET_INVOICE_SORT_ORDER', 'MODULE_PAYMENT_NOVALNET_INVOICE_ORDER_STATUS_ID', 'MODULE_PAYMENT_NOVALNET_INVOICE_ZONE', 'MODULE_PAYMENT_NOVALNET_INVOICE_PROXY');
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
            $error = MODULE_PAYMENT_NOVALNET_INVOICE_PAYMENT_MESSAGE;
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
