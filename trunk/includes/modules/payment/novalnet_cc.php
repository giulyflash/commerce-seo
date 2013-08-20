<?php
#########################################################
#                                                       #
#  CC / CREDIT CARD payment method class                #
#  This module is used for real time processing of      #
#  Credit card data of customers.                       #
#                                                       #
#  Released under the GNU General Public License.       #
#  This free contribution made by request.              #
#  If you have found this script usefull a small        #
#  recommendation as well as a comment on merchant form #
#  would be greatly appreciated.                        #
#                                                       #
#  Script : novalnet_cc.php                             #
#                                                       #
#########################################################

class novalnet_cc {

    var $code;
    var $title;
    var $description;
    var $enabled;
    var $is_ajax = false;
    var $key;
    var $implementation;
    var $paymentkey = 6;
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
     * Initalze the novalnet credit card method
     *
     */
    function novalnet_cc() {
        global $order;
        $this->code = 'novalnet_cc';
        $this->logo_title = MODULE_PAYMENT_NOVALNET_CC_LOGO_TITLE;
        $this->payment_logo_title = MODULE_PAYMENT_NOVALNET_CC_PAYMENT_LOGO_TITLE;
        $this->title = MODULE_PAYMENT_NOVALNET_CC_TEXT_TITLE.'<br>'.$this->logo_title . $this->payment_logo_title;
        $this->public_title = MODULE_PAYMENT_NOVALNET_CC_TEXT_PUBLIC_TITLE;
        $this->description = MODULE_PAYMENT_NOVALNET_CC_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_PAYMENT_NOVALNET_CC_SORT_ORDER;
        $this->enabled = ((MODULE_PAYMENT_NOVALNET_CC_STATUS == 'True') ? true : false);
        //$this->icons_available = xtc_image($nnsiteurl . 'www.novalnet.de/img/creditcard_small.jpg');
        $this->proxy = MODULE_PAYMENT_NOVALNET_CC_PROXY;
        $this->image = ( MODULE_PAYMENT_ENABLE_NOVALNET_LOGO ==1) ? $this->logo_title.$this->payment_logo_title : $this->payment_logo_title;
       // $this->implementation = 'PHP_PCI'; #'JAVA', 'PHP', '', if empty, then equal to 'PHP'
        $this->doAssignConfigVarsToMembers();

        $this->checkConfigure();
        if (CHECKOUT_AJAX_STAT == 'true') {
            $this->is_ajax = true;
        }
        if ((int) MODULE_PAYMENT_NOVALNET_CC_ORDER_STATUS_ID > 0) {
            $this->order_status = MODULE_PAYMENT_NOVALNET_CC_ORDER_STATUS_ID;
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
        $this->vendorid = trim(MODULE_PAYMENT_NOVALNET_CC_VENDOR_ID);
        $this->productid = trim(MODULE_PAYMENT_NOVALNET_CC_PRODUCT_ID);
        $this->authcode = trim(MODULE_PAYMENT_NOVALNET_CC_AUTH_CODE);
        $this->tariffid = trim(MODULE_PAYMENT_NOVALNET_CC_TARIFF_ID);
        $this->testmode = (strtolower(MODULE_PAYMENT_NOVALNET_CC_TEST_MODE) == 'true' or MODULE_PAYMENT_NOVALNET_CC_TEST_MODE == '1') ? 1 : 0;
        $this->manual_check_limit = trim(MODULE_PAYMENT_NOVALNET_CC_MANUAL_CHECK_LIMIT);
        $this->productid_2 = trim(MODULE_PAYMENT_NOVALNET_CC_PRODUCT_ID2);
        $this->tariffid_2 = trim(MODULE_PAYMENT_NOVALNET_CC_TARIFF_ID2);
        $this->manual_check_limit = str_replace(' ', '', $this->manual_check_limit);
        $this->manual_check_limit = str_replace(',', '', $this->manual_check_limit);
        $this->manual_check_limit = str_replace('.', '', $this->manual_check_limit);
    }

	/**
	 * Check the second product id and tariff id
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
                $this->title .= '<br>'.MODULE_PAYMENT_NOVALNET_CC_NOT_CONFIGURED;
            } elseif ($this->testmode == '1') {
                $this->title .= '<br>'.MODULE_PAYMENT_NOVALNET_CC_IN_TEST_MODE;
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
        if (($this->enabled == true) && ((int) MODULE_PAYMENT_NOVALNET_CC_ZONE > 0)) {
            $check_flag = false;
            $check_query = xtc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_NOVALNET_CC_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
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
	 * Validation for form fields if necessary
	 *
	 * @return bool
	 */
    function javascript_validation() {
        return false;
    }

	/**
	 * Builds set of input fields for collecting Bankdetail info
	 *
	 * @return string
	 */
    function selection() {
        global $xtPrice, $order, $HTTP_POST_VARS, $_POST,$request_type;
        $onFocus = '';
        if($this->is_ajax){
			$form_id = 'form_payment_modules';
			$height = 195;
			$width =  430;
            $val = 1;
		}else{
	        $form_id = 'checkout_payment';
	        $height = 235;
			$width =  800;
	        $val = 0;
	    }

	    if($this->testmode)
        $mode = NOVALNET_TEXT_TESTMODE_FRONT;
        else
        $mode = '';

        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;

        $amount = $this->findTotalAmount();
        list($product_id, $tariff_id) = $this->get_prod_tarif_id($amount);

        $payment_error_return = 'language=' . MODULE_PAYMENT_NOVALNET_CC_TEXT_LANG;
        $payment_error_return .= '&vendor_id=' . $this->vendorid;
        $payment_error_return .= '&product_id=' . $product_id;
        $payment_error_return .= '&payment_id=' . $this->paymentkey;
        //$payment_error_return .= '&nn_pciconfirm_nn=3';
		$url_base_path = (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG;
        $cc_script = $url_base_path . 'includes/modules/payment/novalnet.js';
        $host_type = (($request_type == 'SSL') ? 'https://' : 'http://');


        $selection = array('id' => $this->code,
            'module' => $this->public_title,
            'fields' => array(
						array('title' => '', 'field' =>$this->image. $this->description),
								array('field' => '<span id="loading"><img src="'.$host_type.'www.novalnet.de/img/novalnet-loading-icon.gif" alt="Novalnet AG" /></span>'),
								array('field' => '<iframe id="payment_form_novalnetCc" width="'.$width.'" height="'.$height.'" name="payment_form_novalnetCc"  src="' . xtc_href_link('novalnet_cc_form.php', '', 'SSL', true, false).'?'.$payment_error_return . '" onload="getFormValue(this)" frameBorder="0"></iframe>'
								 . xtc_draw_hidden_field('payment_process',$val)
								 . xtc_draw_hidden_field('cc_type', '')
								 . xtc_draw_hidden_field('cc_owner', '')
								 . xtc_draw_hidden_field('cc_exp_month', '')
								 . xtc_draw_hidden_field('cc_exp_year', '')
								 . xtc_draw_hidden_field('cc_cid', '')
								 . xtc_draw_hidden_field('cc_panhash', '')
								 . xtc_draw_hidden_field('cc_uniqueid', '')
								 . xtc_draw_hidden_field('original_form_id','')
								 . xtc_draw_hidden_field('original_vendor_id', $this->vendorid)
								 . xtc_draw_hidden_field('original_vendor_authcode',$this->authcode)
								 /*Credit Card form control*/
								  
								 . xtc_draw_hidden_field('original_customstyle_css','')
								 . xtc_draw_hidden_field('original_customstyle_cssval','')
								 . xtc_draw_hidden_field('original_iframeparent_submit_btn','')
								 .'<script src="' . $cc_script . '" type="text/javascript"></script>'),
								array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_CC_INFO),
								array('title' => '', 'field' =>$mode)
							));
        if (function_exists(get_percent)) {
            $selection['module_cost'] = $GLOBALS['ot_payment']->get_percent($this->code);
        }

        return $selection;
    }

	/**
	 * Precheck to Evaluate the Bank Datas
	 *
	 * @return string
	 */
    function pre_confirmation_check($vars) {
        global $order,$_POST,$_REQUEST;

        if (!is_array($_REQUEST) && !$_REQUEST) {
            $_REQUEST = array();
        }
        if ($this->is_ajax) {
            $_REQUEST = array_merge($_REQUEST, $vars);
        } else {
            $_REQUEST = array_merge($_REQUEST, $_POST);
        }

        if (!$this->emailVaildate($order->customer['email_address'])) {
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode('Please enter the valid email Id'));
            if ($this->is_ajax) {
                $_SESSION['checkout_payment_error'] = $payment_error_return;
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false).'?'.$payment_error_return);
            }
        }
        #storing the cc details in the session for ajax method
        if($this->is_ajax){
		    $_SESSION['nn_cc_details'] = $_POST['xajaxargs'][0];
		}else {
		    $_SESSION['nncc_details'] =  $_POST;
	    }

        // Check shipping methods are selected or not;
        if (!$order->info['shipping_method']) {
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_CC_REQUEST_FOR_CHOOSE_SHIPPING_METHOD));
            $_SESSION['checkout_payment_error'] = $payment_error_return;
            return;
        }

        $error = '';
        /* Start : Validation */
        if (empty($this->vendorid) || empty($this->productid) || empty($this->authcode) || empty($this->tariffid)) {
            $error = MODULE_PAYMENT_NOVALNET_CC_TEXT_JS_NN_MISSING;
        }elseif ($this->manual_check_limit > 0 && (empty($this->productid_2) || empty($this->tariffid_2))) {
            $error = MODULE_PAYMENT_NOVALNET_CC_TEXT_JS_NN_ID2_MISSING;
        }




        if ($error != '') {
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode($error));
            if ($this->is_ajax) {
                $_SESSION['checkout_payment_error'] = $payment_error_return;
            } else {
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false).'?'.$payment_error_return);
            }
            unset($_SESSION['nncc_cardno_id'],$_SESSION['nncc_unique_id'],$_SESSION['nn_cc_type'],$_SESSION['nn_cc_holder'],$_SESSION['nn_cc_exp_month'],$_SESSION['nn_cc_exp_year'],$_SESSION['nn_cc_cvc']);
        } else {
            if ($this->is_ajax) {
				$this->confirmation();
            }
        }
    }

	/**
	 * Display Information on the Checkout Confirmation Page
	 *
	 * @return array
	 */
    function confirmation() {
        global $HTTP_POST_VARS, $_POST, $order;
        $confirmation = array();

        return $confirmation;
    }

	/**
	 * This is user defined function used for getting order amount in cents with tax
	 *
	 * @return array
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
                xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false).'?'.$payment_error_return);
            }
        }
        $amount = sprintf('%0.2f', $total);
        $amount = preg_replace('/^0+/', '', $amount);
        $amount = str_replace('.', '', $amount);
        return $amount;
    }

    ### Build the data and actions to process when the "Submit" button is pressed on the order-confirmation screen. ###
    ### These are hidden fields on the checkout confirmation page ###
	/**
	 * Get the total amount in process butto
	 *
	 * @return boolean
	 */
    function process_button() {
		global $_POST;
        $_SESSION['nn_tot_amount'] = $this->findTotalAmount();

        return false;
    }

    /*
     * Get Product and Tariff Id function
     */
    function get_prod_tarif_id($amount) {
        $this->doCheckManualCheckLimit($amount);
        $product_id = $this->productid;
        $tariff_id = $this->tariffid;
        return array($product_id, $tariff_id);
    }

    // End : Get Product and Tariff Id function
    ### Insert the Novalnet Transaction ID in DB ###
    function before_process($vars) {
        global $HTTP_POST_VARS, $_POST, $order, $currencies, $customer_id,$_REQUEST,$_SESSION;
        $this->tot_amount = $amount = $_SESSION['nn_tot_amount'];

        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;

        if ($this->order_status) {
            $order->info['order_status'] = $this->order_status;
        }

        if ($this->is_ajax) {
            $_REQUEST = array_merge($_REQUEST, $vars);
        } else {
            $_REQUEST = array_merge($_REQUEST, $_POST);
        }

		$customer_query = xtc_db_query("SHOW COLUMNS FROM " . TABLE_ORDERS); # . " WHERE FIELD='comments'");#MySQL Version 3/4 dislike WHERE CLAUSE here :-(

		while ($customer = xtc_db_fetch_array($customer_query)) {
			if (strtolower($customer['Field']) == 'comments' and strtolower($customer['Type']) != 'text') {
				xtc_db_query("ALTER TABLE " . TABLE_ORDERS . " MODIFY comments text");
			}
		}

        if($this->is_ajax){

		    $nncc_values = $this->deformatNvp($_SESSION['nn_cc_details']);

			$cc_type = $nncc_values['cc_type']; #credit card type
			$cc_holder  = $nncc_values['cc_owner']; #credit card owner name
			$cc_exp_month = $nncc_values['cc_exp_month']; #credit card month
			$cc_exp_year = $nncc_values['cc_exp_year']; #credit card year
			$cc_cvc = $nncc_values['cc_cid']; #credit card  CVC
			$cc_number = $_POST['cc_panhash']; #credit card panhash
			$uniqueid =	 $_POST['cc_uniqueid']; #credit card unique id
			
			
			/*$cc_number = $nncc_values['cc_panhash']; #credit card panhash
			$uniqueid =	 $nncc_values['cc_uniqueid']; #credit card unique id*/
		}else{

			$cc_type  = $_SESSION['nncc_details']['cc_type'];
            $cc_holder = $_SESSION['nncc_details']['cc_owner'];
            $cc_exp_month = $_SESSION['nncc_details']['cc_exp_month'];
            $cc_exp_year = $_SESSION['nncc_details']['cc_exp_year'];
            $cc_cvc = $_SESSION['nncc_details']['cc_cid'];
            $cc_number = $_SESSION['nncc_details']['cc_panhash'];
            $uniqueid = $_SESSION['nncc_details']['cc_uniqueid'];
	    }

				$cc_number = isset($cc_number)?trim($cc_number):'';
				$uniqueid = isset($uniqueid)?trim($uniqueid):'';
				$cc_type = trim($cc_type);
				$cc_holder = trim($cc_holder);
				$cc_exp_month = trim($cc_exp_month);
				$cc_exp_year = trim($cc_exp_year);
				$cc_cvc = trim($cc_cvc);

				if(empty($cc_type)||empty($cc_holder)||empty($cc_exp_month)||empty($cc_exp_month)||empty($cc_cvc)){
					$error =  MODULE_PAYMENT_NOVALNET_CC_TEXT_JS_COMMON_ERROR;
				}elseif(empty($cc_holder) || preg_match('/[#%\^<>@$=*!]/', $cc_holder) || strlen($cc_holder)<2){
					$error = MODULE_PAYMENT_NOVALNET_CC_TEXT_JS_COMMON_ERROR;
				}elseif(strlen($cc_cvc) < 3 || strlen($cc_cvc) >= 4 ){
					$error = MODULE_PAYMENT_NOVALNET_CC_TEXT_JS_COMMON_ERROR;
				}elseif($cc_exp_year <= date('Y')){
					if($cc_exp_year == date('Y')){
						if($cc_exp_month < date('m'))	$error = MODULE_PAYMENT_NOVALNET_CC_TEXT_JS_COMMON_ERROR;
					} else {
						$error = MODULE_PAYMENT_NOVALNET_CC_TEXT_JS_COMMON_ERROR;
					}
				}elseif (empty($cc_number) || empty($uniqueid)) {
					$error = MODULE_PAYMENT_NOVALNET_CC_TEXT_JS_COMMON_ERROR;
				}

				if($error){
					$payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode($error));
					if ($this->is_ajax) {
						$_SESSION['checkout_payment_error'] = $payment_error_return;
						xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, '', 'SSL', true, false).'?'.$payment_error_return);
					} else {
						xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false).'?'.$payment_error_return);
					}
					unset($_SESSION['nn_cc_details'],$_SESSION['nncc_details']);
				}

                #Get the required additional customer details from DB
                // $customer_query = xtc_db_query("SELECT customers_gender, customers_dob, customers_fax,customers_status FROM ". TABLE_CUSTOMERS . " WHERE customers_id='". (int)$_SESSION['customer_id'] ."'");
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
                list($product_id, $tariff_id) = $this->get_prod_tarif_id($amount);
                $auth_code = $this->authcode;
                $test_mode = $this->testmode;
                $user_ip = $this->getRealIpAddr();


                $firstname = !empty($order->customer['firstname']) ? $order->customer['firstname'] : $order->billing['firstname'];
                $lastname = !empty($order->customer['lastname']) ? $order->customer['lastname'] : $order->billing['lastname'];
                $email_address = !empty($order->customer['email_address']) ? $order->customer['email_address'] : $order->billing['email_address'];
                $street_address = !empty($order->customer['street_address']) ? $order->customer['street_address'] : $order->billing['street_address'];
                $city = !empty($order->customer['city']) ? $order->customer['city'] : $order->billing['city'];
                $postcode = !empty($order->customer['postcode']) ? $order->customer['postcode'] : $order->billing['postcode'];
                $country_iso_code_2 = !empty($order->customer['country']['iso_code_2']) ? $order->customer['country']['iso_code_2'] : $order->billing['country']['iso_code_2'];

                $urlparam  = 'vendor=' . $this->vendorid . '&product=' . $product_id . '&key=' . $this->paymentkey . '&tariff=' . $tariff_id . '&auth_code=' . $auth_code . '&currency=' . $order->info['currency'];
                $urlparam .= '&test_mode=' . $test_mode;
                $urlparam .= '&cc_type=' . $cc_type;
                $urlparam .= '&cc_holder=' .$cc_holder;
                $urlparam .= '&cc_no=';
                $urlparam .= '&cc_exp_month=' . $cc_exp_month;
                $urlparam .= '&cc_exp_year=' . $cc_exp_year;
                $urlparam .= '&cc_cvc2=' . $cc_cvc;
                $urlparam .= '&pan_hash='.$cc_number;
                $urlparam .= '&unique_id='.$uniqueid ;
                $urlparam .= '&first_name=' . $firstname . '&last_name=' . $lastname;
                $urlparam .= '&street=' . $street_address . '&city=' . $city . '&zip=' . $postcode;
                $urlparam .= '&email=' . $email_address;
                $urlparam .= '&birth_date=' . $customer['customers_dob'];
                $urlparam .= '&search_in_street=1&tel=' . $order->customer['telephone'] . '&remote_ip=' . $user_ip;
                $urlparam .= '&gender=' . $aAddr['customers_gender'] . '&fax=' . $order->customer['customers_fax'];
                $urlparam .= '&country=' . $country_iso_code_2 . '&language=' . MODULE_PAYMENT_NOVALNET_CC_TEXT_LANG;
                $urlparam .= '&lang=' . MODULE_PAYMENT_NOVALNET_CC_TEXT_LANG;
                $urlparam .= '&customer_no=' . $customer_no;
                $urlparam .= '&use_utf8=1';
                $urlparam .= '&amount=' . $amount;
				$url = 'https://payport.novalnet.de/paygate.jsp';

                list($errno, $errmsg, $data) = $this->perform_https_request($url, $urlparam);

                if ($errno or $errmsg){
                    ### Payment Gateway Error ###
                    $order->info['comments'] .= '. func perform_https_request returned Errorno : ' . $errno . ', Error Message : ' . $errmsg;
                    $payment_error_return = 'payment_error=' . $this->code . '&error=' . $errmsg . '(' . $errno . ')';
                    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
                }
                parse_str($data, $aryResponse);
                
                
                if($aryResponse['status'] == 100 ){
					$old_comments = $order->info['comments'];
					$order->info['comments'] = '';
					$test_order_status = (((isset($aryResponse['test_mode']) && $aryResponse['test_mode'] == 1) || (isset($this->testmode) && $this->testmode == 1)) ? 1 : 0 ); 
					if ($test_order_status){
                        $order->info['comments'] .= MODULE_PAYMENT_NOVALNET_CC_TEST_ORDER_MESSAGE;
					}
					if ($this->order_status)
						$order->info['order_status'] = $this->order_status;
					$order->info['comments'] .= MODULE_PAYMENT_NOVALNET_CC_TID_MESSAGE . $aryResponse['tid'] . '<BR>';
					$order->info['comments'] .= $old_comments;
					$order->info['comments'] = str_replace(array('<b>', '</b>', '<B>', '</B>', '<br>', '<br />', '<BR>'), array('', '', '', '', "\n", "\n", "\n"), $order->info['comments']);
					
					$_SESSION['nn_cc_tid'] = $aryResponse['tid'];
				}else{
                    $checkoutmsg =  $aryResponse['status_desc'];
					$payment_error_return = 'payment_error=' . $this->code . '&error=' . $checkoutmsg;
					if ($this->is_ajax) {
						$_SESSION['checkout_payment_error'] = $payment_error_return;
						xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, '', 'SSL', true, false).'?'.$payment_error_return);
					}else{
						xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false).'?'.$payment_error_return);
					}
                }
    }

    function isPublicIP($value) {
        if (!$value || count(explode('.', $value)) != 4)
            return false;
        return !preg_match('~^((0|10|172\.16|192\.168|169\.254|255|127\.0)\.)~', $value);
    }

    ### get the real Ip Adress of the User ###

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

    ### replace the Special German Charectors ###

    function ReplaceSpecialGermanChars($vOriginalString) {
        $vSomeSpecialChars = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ", "ä", "ö", "ü", "Ä", "Ö", "Ü", "ß", "ë");
        $vReplacementChars = array("ae", "ee", "ie", "oe", "ue", "Ae", "Ee", "Ie", "Oe", "Ue", "ne", "Ne", "ae", "oe", "ue", "Ae", "Oe", "Ue", "ss", "ee");
        $vReplacedString = str_replace($vSomeSpecialChars, $vReplacementChars, $vOriginalString);
        return $vReplacedString;
    }

    ### for email validation ###
    function emailVaildate($email) {
        if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
            return false; //Invalid email
        } else {
            return true;  //Valid email
        }
    }

    ### Send the order detail to Novalnet ###
    function after_process() {
        global $order, $insert_id;
        if ($this->order_status) {
            xtc_db_query("UPDATE " . TABLE_ORDERS . " SET orders_status='" . $this->order_status . "' WHERE orders_id='" . $insert_id . "'");
        }
        list($product_id, $tariff_id) = $this->get_prod_tarif_id($this->tot_amount);

        if (isset($_SESSION['nn_cc_tid'])) {
            $url = 'https://payport.novalnet.de/paygate.jsp';
            $urlparam = 'vendor=' . $this->vendorid . '&product=' . $product_id . '&test_mode='.$this->testmode.'&key=' . $this->paymentkey . '&tariff=' . $tariff_id;
            $urlparam .= '&auth_code=' . $this->authcode . '&status=100&tid=' . $_SESSION['nn_cc_tid']
                         .'&vwz2=' . MODULE_PAYMENT_NOVALNET_CC_TEXT_ORDERNO . '' . $insert_id .
                         '&vwz3=' . MODULE_PAYMENT_NOVALNET_CC_TEXT_ORDERDATE . '' . date('Y-m-d H:i:s');
			$urlparam .= '&order_no=' . $insert_id;
            $this->perform_https_request($url, $urlparam);
        }
        unset($_SESSION['nn_cc_details'],$_SESSION['nncc_details']);
        if (isset($_SESSION['nncc_cardno_id'])) {
            unset($_SESSION['nncc_cardno_id']);
        }
		if (isset($_SESSION['nncc_unique_id'])) {
            unset($_SESSION['nncc_unique_id']);
        }
        if (isset($_SESSION['nn_tot_amount'])) {
            unset($_SESSION['nn_tot_amount']);
        }
		if (isset($_SESSION['nn_cc_tid'])) {
            unset($_SESSION['nn_cc_tid']);
        }
        if (isset($_SESSION['nn_cc_type'])) {
            unset($_SESSION['nn_cc_type']);
        }
        if (isset($_SESSION['nn_cc_holder'])) {
            unset($_SESSION['nn_cc_holder']);
        }
        if (isset($_SESSION['nn_cc_exp_month'])) {
            unset($_SESSION['nn_cc_exp_month']);
        }
        if (isset($_SESSION['nn_cc_exp_year'])) {
            unset($_SESSION['nn_cc_exp_year']);
        }
        if (isset($_SESSION['nn_cc_cvc'])) {
            unset($_SESSION['nn_cc_cvc']);
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
        if (count($HTTP_GET_VARS) == 0 || $HTTP_GET_VARS == '')
            $HTTP_GET_VARS = $_GET;
        $error = array('title' => MODULE_PAYMENT_NOVALNET_CC_TEXT_ERROR, 'error' => stripslashes(html_entity_decode($HTTP_GET_VARS['error'])));
        return $error;
    }


	/*
	* Check to see whether module is installed
	*
	*  @return boolean
	*/
    function check() {
        if (!isset($this->_check)) {
            $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_NOVALNET_CC_STATUS'");
            $this->_check = xtc_db_num_rows($check_query);
        }
        return $this->_check;
    }

    ### Install the payment module and its configuration settings ###

    function install() {
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_ALLOWED', '', '6', '0', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_STATUS', 'True', '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_TEST_MODE', 'True', '6', '2', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_VENDOR_ID', '', '6', '3', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_AUTH_CODE', '', '6', '4', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PRODUCT_ID', '', '6', '5', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_TARIFF_ID', '', '6', '6', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_MANUAL_CHECK_LIMIT', '', '6', '7', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PRODUCT_ID2', '', '6', '8', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_TARIFF_ID2', '', '6', '9', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_INFO', '', '6', '11', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_SORT_ORDER', '0', '6', '12', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_ORDER_STATUS_ID', '0', '6', '13', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_ZONE', '0', '6', '14', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOVALNET_CC_PROXY', '', '6', '15', now())");
    }

    ### Remove the module and all its settings ###

    function remove() {
        xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    ### Internal list of configuration keys used for configuration of the module ###
    // @return array

    function keys() {
        return array('MODULE_PAYMENT_NOVALNET_CC_ALLOWED', 'MODULE_PAYMENT_NOVALNET_CC_STATUS', 'MODULE_PAYMENT_NOVALNET_CC_TEST_MODE', 'MODULE_PAYMENT_NOVALNET_CC_VENDOR_ID', 'MODULE_PAYMENT_NOVALNET_CC_AUTH_CODE', 'MODULE_PAYMENT_NOVALNET_CC_PRODUCT_ID', 'MODULE_PAYMENT_NOVALNET_CC_TARIFF_ID', 'MODULE_PAYMENT_NOVALNET_CC_MANUAL_CHECK_LIMIT', 'MODULE_PAYMENT_NOVALNET_CC_PRODUCT_ID2', 'MODULE_PAYMENT_NOVALNET_CC_TARIFF_ID2', 'MODULE_PAYMENT_NOVALNET_CC_INFO', 'MODULE_PAYMENT_NOVALNET_CC_SORT_ORDER', 'MODULE_PAYMENT_NOVALNET_CC_ORDER_STATUS_ID', 'MODULE_PAYMENT_NOVALNET_CC_ZONE', 'MODULE_PAYMENT_NOVALNET_CC_PROXY');
    }

    function html_to_utf8($data) {
        return preg_replace("/\\&\\#([0-9]{3,10})\\;/e", '$this->_html_to_utf8("\\1")', $data);
    }

	private function deformatNvp($str) {
		$fields = array();
		$temp = explode('&', $str);
		foreach( $temp as $v ) {
			$v = explode('=', $v);
			$fields[urldecode($v[0])] = isset($v[1]) ? urldecode($v[1]) : NULL;
		}
		return $fields;
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

    ### Realtime accesspoint for communication to the Novalnet paygate ###

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
        //$data = $this->ReplaceSpecialGermanChars($data);
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
