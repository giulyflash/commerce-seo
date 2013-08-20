t<?php

#########################################################
#                                                       #
#  TEL payment method class                             #
#  This module is used for real time processing of      #
#  TEL payment of customers.                            #
#                                                       #
#  Released under the GNU General Public License.       #
#  This free contribution made by request.              #
#  If you have found this script useful a small         #
#  recommendation as well as a comment on merchant form #
#  would be greatly appreciated.                        #
#                                                       #
#  Script : novalnet_tel.php                            #
#                                                       #
#########################################################
require_once (DIR_FS_INC . 'xtc_format_price_order.inc.php');

class novalnet_tel {

    var $code;
    var $title;
    var $description;
    var $enabled;
    var $blnDebug = false; #todo: set to false for live system
    var $proxy;
    var $KEY = 18;
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
    function novalnet_tel() {
        global $order;
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        $this->code = 'novalnet_tel';
		$this->logo_title = MODULE_PAYMENT_NOVALNET_TEL_LOGO_TITLE;
		$this->payment_logo_title = MODULE_PAYMENT_NOVALNET_TEL_PAYMENT_LOGO_TITLE;

        $this->title = MODULE_PAYMENT_NOVALNET_TEL_TEXT_TITLE.'<br>'.$this->logo_title.$this->payment_logo_title;
        $this->public_title = MODULE_PAYMENT_NOVALNET_TEL_TEXT_PUBLIC_TITLE;
        $this->description = MODULE_PAYMENT_NOVALNET_TEL_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_PAYMENT_NOVALNET_TEL_SORT_ORDER;
        $this->enabled = ((MODULE_PAYMENT_NOVALNET_TEL_STATUS == 'True') ? true : false);
        $this->proxy = MODULE_PAYMENT_NOVALNET_TEL_PROXY;
		$this->image = ( MODULE_PAYMENT_ENABLE_NOVALNET_LOGO ==1) ? $this->logo_title.$this->payment_logo_title : $this->payment_logo_title;
        $this->doAssignConfigVarsToMembers();
        $this->checkConfigure();
        if (CHECKOUT_AJAX_STAT == 'true') {
            $this->is_ajax = true;
        }
        if ((int) MODULE_PAYMENT_NOVALNET_TEL_ORDER_STATUS_ID > 0) {
            $this->order_status = MODULE_PAYMENT_NOVALNET_TEL_ORDER_STATUS_ID;
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
        $this->vendorid = trim(MODULE_PAYMENT_NOVALNET_TEL_VENDOR_ID);
        $this->productid = trim(MODULE_PAYMENT_NOVALNET_TEL_PRODUCT_ID);
        $this->authcode = trim(MODULE_PAYMENT_NOVALNET_TEL_AUTH_CODE);
        $this->tariffid = trim(MODULE_PAYMENT_NOVALNET_TEL_TARIFF_ID);
        $this->testmode = (strtolower(MODULE_PAYMENT_NOVALNET_TEL_TEST_MODE) == 'true' or MODULE_PAYMENT_NOVALNET_TEL_TEST_MODE == '1') ? 1 : 0;
    }

	/**
	 * Test configure values and test mode in admin panel
	 *
	 * @return void
	 */
    function checkConfigure() {
        if (IS_ADMIN_FLAG == true) {
            if ($this->enabled == 'true' && (empty($this->vendorid) || empty($this->productid) || empty($this->authcode) || empty($this->tariffid))) {
                $this->title .= '<br>'.MODULE_PAYMENT_NOVALNET_TEL_NOT_CONFIGURED;
            } elseif ($this->testmode == '1') {
                $this->title .= '<br>'.MODULE_PAYMENT_NOVALNET_TEL_IN_TEST_MODE;
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
        if (($this->enabled == true) && ((int) MODULE_PAYMENT_NOVALNET_TEL_ZONE > 0)) {
            $check_flag = false;
            $check_query = xtc_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_NOVALNET_TEL_ZONE . "' and
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
        
            $amount = $this->findTotalAmount();

            #check its a same order or not based on the order id if Novalnet tid is set
            if($_SESSION['nn_tid_tel']){

				if(isset($_COOKIE['cSEOid'])){
					if($_COOKIE['cSEOid'] != $_SESSION['cSEOid']){
					unset($_SESSION['nn_tid_tel']);
					unset($_SESSION['server_amount_tel']);
					unset($_SESSION['novaltel_no']);
					}
				}
				$server_amount =  $_SESSION['server_amount_tel'];
				$server_amount = str_replace('.','',$server_amount);
            }
            
            if(empty($_SESSION['nn_tid_tel']) && strtoupper(MODULE_PAYMENT_NOVALNET_TEL_STATUS) == 'TRUE'){
			
				$selection = array('id' => $this->code,
							'module' => $this->public_title,
							'fields' => array(array('title' => '', 'field' => $this->image.'<br>'.$this->description),
										array('title' => '', 'field' => MODULE_PAYMENT_NOVALNET_TEL_INFO),
										array('title' => '', 'field' =>$mode)
										)
							);
		    
		    }else if(!empty($_SESSION['nn_tid_tel']) && $_SESSION['server_amount_tel']){
			    
			    $sess_tel = trim($_SESSION['novaltel_no']);
		        if($sess_tel)
		        {
		 	        $aryTelDigits = str_split($sess_tel, 4);
			        $count = 0;
			        $str_sess_tel = '';
			        foreach ($aryTelDigits as $ind=>$digits)
			        {
			        $count++;
			        $str_sess_tel .= $digits;
			            if($count==1) $str_sess_tel .= '-';
			            else $str_sess_tel .= ' ';
			        }
			        $str_sess_tel=trim($str_sess_tel);
			        if($str_sess_tel) $sess_tel=$str_sess_tel;
		        }
			    $selection = array('id' => $this->code,
							   'module' => $this->public_title,
							   'fields' => array(array('title' => '', 'field' => $this->image.'<br>'.$this->description),
								array('title' => '',
							   'field' => "<BR>".MODULE_PAYMENT_NOVALNET_TEL_TEXT_STEP_INFO."</B>"),
								array('title' => MODULE_PAYMENT_NOVALNET_TEL_TEXT_STEP1,
							   'field' => MODULE_PAYMENT_NOVALNET_TEL_TEXT_STEP1_DESC." <B>$sess_tel</B>".MODULE_PAYMENT_NOVALNET_TEL_TEXT_COST_INFO.$_SESSION['server_amount_tel'].MODULE_PAYMENT_NOVALNET_TEL_TEXT_TAX_INFO),
								array('title' => MODULE_PAYMENT_NOVALNET_TEL_TEXT_STEP2,
								'field' => MODULE_PAYMENT_NOVALNET_TEL_TEXT_STEP2_DESC),
							    array('title' => '', 'field' =>$mode)
							));
			
			}

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
        global $HTTP_POST_VARS, $_POST, $order, $xtPrice, $currencies, $customer_id;
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
            $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_TEL_REQUEST_FOR_CHOOSE_SHIPPING_METHOD));
            $_SESSION['checkout_payment_error'] = $payment_error_return;
            return;
        }
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        if(!is_array($HTTP_POST_VARS) && !$HTTP_POST_VARS){
			$HTTP_POST_VARS = array();
		}

		if ($this->is_ajax) {
			$HTTP_POST_VARS = array_merge($HTTP_POST_VARS,$vars);
		}else{
			$HTTP_POST_VARS = array_merge($HTTP_POST_VARS,$_POST);
		}

		if (empty($this->vendorid) || empty($this->productid) || empty($this->authcode) || empty($this->tariffid)) {
                 $error =  MODULE_PAYMENT_NOVALNET_TEXT_JS_NN_MISSING;
        }
        if ($error != '') {
             $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode($error));
             if ($this->is_ajax) {
                   $_SESSION['checkout_payment_error'] = $payment_error_return;
             } else {
                   xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
             }
        }
        
		if(empty($error) && empty($_SESSION['nn_tid_tel']) && $this->is_ajax){#telephone first call
			$amount = $this->findTotalAmount();
			if($amount < 99 || $amount > 1000){
				$payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_TEL_TEXT_AMOUNT_ERROR1));
				$_SESSION['checkout_payment_error'] = $payment_error_return;
			} else {				
				$this->first_call($amount);
			}
		}
    }

	function first_call($amount){
        global $HTTP_POST_VARS, $_POST, $order, $xtPrice, $currencies, $customer_id;
        		
		$errno  ='';
		$errmsg ='';
		$nn_customer_id = (isset($_SESSION['customer_id'])) ? $_SESSION['customer_id'] : '';
		$customer_query = xtc_db_query("SELECT customers_gender, customers_dob, customers_fax, customers_status FROM " . TABLE_CUSTOMERS . " WHERE customers_id='" . (int) $nn_customer_id . "'");
		$customer       = xtc_db_fetch_array($customer_query);
		$nncustomer_no  = ($customer_query->fields['customers_status'] != 1) ? $nn_customer_id : NOVALNET_GUEST_USER;
		if (trim($order->customer['csID']))
			$customer_no = $order->customer['csID'];
		else
			$customer_no = $nncustomer_no;
		list($customer['customers_dob'], $extra) = explode(' ', $customer['customers_dob']);
		### Process the payment to paygate ##
		$url    = 'https://payport.novalnet.de/paygate.jsp';

		$user_telephone = '&tel='.$order->customer['telephone'];
		$user_email     = $order->customer['email_address'];

		$nn_customer_id = (isset($_SESSION['customer_id'])) ? $_SESSION['customer_id'] : '';
		$customer_query = xtc_db_query("SELECT customers_gender, customers_dob, customers_fax, customers_status FROM " . TABLE_CUSTOMERS . " WHERE customers_id='" . (int) $nn_customer_id . "'");
		$customer = xtc_db_fetch_array($customer_query);
		$nncustomer_no = ($customer_query->fields['customers_status'] != 1) ? $nn_customer_id : NOVALNET_GUEST_USER;
		if (trim($order->customer['csID']))
			$customer_no = $order->customer['csID'];
		else
			$customer_no = $nncustomer_no;
		list($customer['customers_dob'], $extra) = explode(' ', $customer['customers_dob']);

		$url = 'https://payport.novalnet.de/paygate.jsp';
		$product_id = $this->productid;
		$tariff_id  = $this->tariffid;

		$urlparam['key'] = $this->KEY ;
		$urlparam['vendor'] = $this->vendorid;
		$urlparam['product'] =$product_id;
		$urlparam['tariff'] = $tariff_id;
		$urlparam['auth_code'] = $this->authcode;
		$urlparam['test_mode'] = $this->testmode;
		$urlparam['amount'] = $amount ;

		$urlparam['first_name'] = !empty($order->customer['firstname']) ? $order->customer['firstname'] : $order->billing['firstname'];
		$urlparam['last_name'] = !empty($order->customer['lastname']) ? $order->customer['lastname'] : $order->billing['lastname'];
		$urlparam['street'] = !empty($order->customer['street_address']) ? $order->customer['street_address'] : $order->billing['street_address'];
		$urlparam['city'] = !empty($order->customer['city']) ? $order->customer['city'] : $order->billing['city'];
		$urlparam['zip'] = !empty($order->customer['postcode']) ? $order->customer['postcode'] : $order->billing['postcode'];
		$urlparam['country'] = !empty($order->customer['country']['iso_code_2']) ? $order->customer['country']['iso_code_2'] : $order->billing['country']['iso_code_2'];
		$urlparam['country_code'] = !empty($order->customer['country']['iso_code_2']) ? $order->customer['country']['iso_code_2'] : $order->billing['country']['iso_code_2'];

		$urlparam['currency'] = $order->info['currency'];
		$urlparam['tel'] =  $order->customer['telephone'];
		$urlparam['email'] = utf8_decode($order->customer['email_address']);

		$urlparam['search_in_street'] = 1;
		$urlparam['remote_ip'] = $this->getRealIpAddr();
		$urlparam['gender'] = $customer['customers_gender'];
		$urlparam['birth_date'] = $customer['customers_dob'];
		$urlparam['fax'] = $customer['customers_fax'];
		$urlparam['language'] = MODULE_PAYMENT_NOVALNET_TEXT_LANG;
		$urlparam['lang'] = MODULE_PAYMENT_NOVALNET_TEXT_LANG;
		$urlparam['customer_no'] = $customer_no ;
		$urlparam['use_utf8'] = 1;
		$urlparam = http_build_query($urlparam);
		$urlparam = urldecode($urlparam);
		$_SESSION['cSEOid'] = $_COOKIE['cSEOid'];
		list($errno, $errmsg, $data) = $this->perform_https_request($url, $urlparam);

		if ($errno or $errmsg) {
			$payment_error_return = 'payment_error=' . $this->code . '&error=' .urlencode(utf8_encode($errmsg));
			if ($this->is_ajax) {
				$_SESSION['checkout_payment_error'] = $payment_error_return;
			} else {
				xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
			}
		}
		$aryPaygateResponse = array();
		$aryPaygateResponse = explode('&', $data);
		foreach($aryPaygateResponse as $key => $value)
		{
		   if($value != "")
		   {
				$aryKeyVal = explode("=",$value);
				$aryResponse[$aryKeyVal[0]] = $aryKeyVal[1];
		   }
		}
		if($aryResponse['status']==100 && $aryResponse['tid'])
		{
			$_SESSION['server_amount_tel'] = $aryResponse['amount'];
			$aryResponse['status_desc']='';
			if(!$_SESSION['nn_tid_tel'])
			{
				$_SESSION['nn_tid_tel']  =  $aryResponse['tid'];
				$_SESSION['novaltel_no'] = $aryResponse['novaltel_number'];
			    $_SESSION['test_mode'] = $aryResponse['test_mode'];
			}
		}
		elseif($aryResponse['status']==18){}
		elseif($aryResponse['status']==19)
		{
		   $_SESSION['nn_tid_tel'] = '';
		   $_SESSION['novaltel_no'] = '';
		}
		else{
			$error = $aryResponse['status_desc'];
		}

		if($aryResponse['status']==100){
			$error = ' ';
			if($this->is_ajax){
				$sess_tel = trim($_SESSION['novaltel_no']);
				if($sess_tel)
				{
					$aryTelDigits = str_split($sess_tel, 4);
					$count = 0;
					$str_sess_tel = '';
					foreach ($aryTelDigits as $ind=>$digits)
					{
					$count++;
					$str_sess_tel .= $digits;
						if($count==1) $str_sess_tel .= '-';
						else $str_sess_tel .= ' ';
					}
					$str_sess_tel=trim($str_sess_tel);
					if($str_sess_tel) $sess_tel=$str_sess_tel;
				}
				$info = MODULE_PAYMENT_NOVALNET_TEL_TEXT_STEP_INFO;
				$info1 = MODULE_PAYMENT_NOVALNET_TEL_TEXT_STEP1;
				$info1_desc = MODULE_PAYMENT_NOVALNET_TEL_TEXT_STEP1_DESC;
				$info1_cost = MODULE_PAYMENT_NOVALNET_TEL_TEXT_COST_INFO;
				$info1_tax = MODULE_PAYMENT_NOVALNET_TEL_TEXT_TAX_INFO;
				$info1_tax = $info1_tax;
				$info2 = MODULE_PAYMENT_NOVALNET_TEL_TEXT_STEP2;
				$info2_desc = MODULE_PAYMENT_NOVALNET_TEL_TEXT_STEP2_DESC;

				$focus_on = '<br>'.$info.'</B><br><br>'.$info1.$info1_desc.'<B>'.$sess_tel.'</B>'.$info1_cost.$_SESSION['server_amount_tel'].' '.$info1_tax.'<br><br>'.$info2.$info2_desc;
			}else{ $focus_on = ''; }
		}

		if( $error != '' ){
			$payment_error_return = 'payment_error=' . $this->code . '&error='.$error.$focus_on;
			if($aryResponse['status']==100){
			  	$payment_error_return = 'payment_error=' . $this->code . '&error=' .urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_TEL_FIRST_CALL_NOTIFY));
			}
			if($this->is_ajax) {
				$payment_error_return = 'payment_error=' . $this->code . '&error='.$error.$focus_on;
				$_SESSION['checkout_payment_error'] = $payment_error_return;
			}else{
				xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
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
        global $HTTP_POST_VARS, $_POST, $order;
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        if (count($HTTP_POST_VARS) == 0 || $HTTP_POST_VARS == '')
            $HTTP_POST_VARS = $_POST;
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
        $_SESSION['nn_total_amount_tel'] = $this->findTotalAmount();
		if(empty($_SESSION['nn_tid_tel']) && !$this->is_ajax && ($_SESSION['nn_total_amount_tel'] < 99 || $_SESSION['nn_total_amount_tel'] > 1000)){
			$payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_encode(MODULE_PAYMENT_NOVALNET_TEL_TEXT_AMOUNT_ERROR1));
				   xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
		}        
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
        if(empty($_SESSION['nn_tid_tel']) && !$this->is_ajax){#telephone first call
			$this->first_call($_SESSION['nn_total_amount_tel']);
		} elseif($_SESSION['nn_tid_tel']) {
			if($_SESSION['nn_tid_tel']){
                $server_amount =  $_SESSION['server_amount_tel'];
                $server_amount = str_replace('.','',$server_amount);
 	            $amount = $this->findTotalAmount();
 	        }
			if($server_amount !=  $_SESSION['nn_total_amount_tel']  &&  $_SESSION['nn_tid_tel'] ) {

					unset($_SESSION['nn_tid_tel']);
					unset($_SESSION['server_amount_tel']);
					unset($_SESSION['novaltel_no']);
					unset($_SESSION['nn_total_amount_tel']);

				$errmsg = MODULE_PAYMENT_NOVALNET_TEL_AMOUNT_ERROR ;
				$payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_decode($errmsg));
				if ($this->is_ajax) {
					$_SESSION['checkout_payment_error'] = $payment_error_return;
					xtc_redirect(xtc_href_link(FILENAME_CHECKOUT,'', 'SSL', true, false).'?'.$payment_error_return);
				} else {
				   xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
				}
			}
			$customer_query = xtc_db_query("SHOW COLUMNS FROM " . TABLE_ORDERS); # . " WHERE FIELD='comments'");#MySQL Version 3/4 dislike WHERE CLAUSE here :-(
			while ($customer = xtc_db_fetch_array($customer_query)) {
			   if (strtolower($customer['Field']) == 'comments' and strtolower($customer['Type']) != 'text') {
				  xtc_db_query("ALTER TABLE " . TABLE_ORDERS . " MODIFY comments text");
			   }
			}

			$url = 'https://payport.novalnet.de/nn_infoport.xml';
			$urlparam = '<nnxml><info_request><vendor_id>'.MODULE_PAYMENT_NOVALNET_TEL_VENDOR_ID.'</vendor_id>';
			$urlparam .= '<vendor_authcode>'.MODULE_PAYMENT_NOVALNET_TEL_AUTH_CODE.'</vendor_authcode>';
			$urlparam .= '<request_type>NOVALTEL_STATUS</request_type><tid>'.$_SESSION['nn_tid_tel'].'</tid>';
			$urlparam .= '<lang>'.MODULE_PAYMENT_NOVALNET_TEL_TEXT_LANG.'</lang></info_request></nnxml>';

			list($errno, $errmsg, $data) = $this->perform_https_request($url, $urlparam);

			$aryResponse = array();
			parse_str($data , $aryResponse);

			if(strstr($data, '<novaltel_status>'))
			{
				preg_match('/novaltel_status>?([^<]+)/i', $data, $matches);
				$aryResponse['status'] = $matches[1];
				preg_match('/novaltel_status_message>?([^<]+)/i', $data, $matches);
				$aryResponse['status_desc'] = $matches[1];
			}

			/*if( $this->testmode == 1 || strtolower($this->testmode) == true){
			    $aryResponse['status_desc'] = 'successfull';
			    $aryResponse['status'] = 100;
			}*/

			if($_SESSION['nn_tid_tel']  || $aryResponse['status'] == 100)
			{
				$old_comments = $order->info['comments'];
				$order->info['comments'] = '';
				$test_mode = $this->testmode;
					if ($this->order_status)
						$order->info['order_status'] = $this->order_status;
				
                $test_order_status = (((isset($_SESSION['test_mode']) && $_SESSION['test_mode'] == 1) || (isset($this->testmode) && $this->testmode == 1)) ? 1 : 0 );
				if ( $test_order_status == 1){
					$order->info['comments'] .= MODULE_PAYMENT_NOVALNET_TEST_ORDER_MESSAGE;
				}
				
				$order->info['comments'] .= MODULE_PAYMENT_NOVALNET_TEL_TID_MESSAGE . $_SESSION['nn_tid_tel'] . "\n";
				$order->info['comments'] = str_replace(array('<b>', '</b>', '<B>', '</B>', '<br>', '<br />', '<BR>'), array('', '', '', '', "\n", "\n", "\n"), $order->info['comments']);
				$order->info['comments']  = html_entity_decode($order->info['comments'], ENT_QUOTES, "UTF-8");
				$order->info['comments'] .= $old_comments;
				$_SESSION['novaltel_no'] = '';
			    unset($_SESSION['test_mode']);
			}
			else #### On payment failure ####
			{   
				$status = '';
				unset($_SESSION['test_mode']);
				if($wrong_amount == 1){$status = '1';$aryResponse['status_desc'] = MODULE_PAYMENT_NOVALNET_TEL_TEXT_AMOUNT_ERROR1;}
				elseif($aryResponse['status']==18){
					$order->info['comments'] .= '. func perform_https_request returned Errorno : ' . $aryResponse['status']. ', Error Message : ' . $aryResponse['status_desc'];
					$payment_error_return = 'payment_error=' . $this->code . '&error=' . utf8_encode($errmsg) . '(' . $errno . ')';
					if ($this->is_ajax) {
					    $_SESSION['checkout_payment_error'] = $payment_error_return;
					    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT,'', 'SSL', true, false).'?'.$payment_error_return);
					} else {
					  xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
					}
				}
				elseif($aryResponse['status']==19)
				{
					$_SESSION['tid'] = '';
					$_SESSION['novaltel_no'] = '';
				}
				else {
					$payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode(utf8_decode($aryResponse['status'])) ;
					if ($this->is_ajax) {
						$_SESSION['checkout_payment_error'] = $payment_error_return;
						xtc_redirect(xtc_href_link(FILENAME_CHECKOUT,'', 'SSL', true, false).'?'.$payment_error_return);
					} else {
						xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
					}
			    }
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
        if (isset($_SESSION['nn_tid_tel'])) {
            ### Pass the Order Reference to paygate ##
            $url = 'https://payport.novalnet.de/paygate.jsp';
            $urlparam = 'vendor=' . $this->vendorid . '&product=' . $this->productid . '&key=' . $this->KEY . '&tariff=' . $this->tariffid;
            $urlparam .= '&auth_code=' . $this->authcode . '&status=100&tid=' . $_SESSION['nn_tid_tel'];
            $urlparam .= '&order_no=' . $insert_id;
            $urlparam .= '&vwz2=' . MODULE_PAYMENT_NOVALNET_TEL_TEXT_ORDERNO . '' . $insert_id . '&vwz3=' . MODULE_PAYMENT_NOVALNET_TEL_TEXT_ORDERDATE . '' . date('Y-m-d H:i:s');
            $this->perform_https_request($url, $urlparam);
            unset($_SESSION['server_amount_tel']);
            unset($_SESSION['nn_tid_tel']);
			if(isset($_SESSION['nn_tid_invoice'])) unset($_SESSION['nn_tid_invoice']);
			if(isset($_SESSION['nn_tid_elv_at'])) unset($_SESSION['nn_tid_elv_at']);
			if(isset($_SESSION['nn_tid_elv_de'])) unset($_SESSION['nn_tid_elv_de']);             
        }
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
            //unset($_SESSION['shipping']);
        }
        if ($this->blnDebug) {
            $this->debug2(__FUNCTION__);
        }
        if (count($HTTP_GET_VARS) == 0 || $HTTP_GET_VARS == '')
            $HTTP_GET_VARS = $_GET;
        $error = array('title' => MODULE_PAYMENT_NOVALNET_TEL_TEXT_ERROR, 'error' =>  stripslashes(urldecode($HTTP_GET_VARS['error'])));
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
            'MODULE_PAYMENT_NOVALNET_TEL_STATUS'");
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
		('MODULE_PAYMENT_NOVALNET_TEL_ALLOWED', '', '6', '0', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added)
		values ('MODULE_PAYMENT_NOVALNET_TEL_STATUS', 'True', '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added)
		values ('MODULE_PAYMENT_NOVALNET_TEL_TEST_MODE', 'True', '6', '2', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
		('MODULE_PAYMENT_NOVALNET_TEL_VENDOR_ID', '', '6', '3', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
		('MODULE_PAYMENT_NOVALNET_TEL_AUTH_CODE', '', '6', '4', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
		('MODULE_PAYMENT_NOVALNET_TEL_PRODUCT_ID', '', '6', '5', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
		('MODULE_PAYMENT_NOVALNET_TEL_TARIFF_ID', '', '6', '6', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
		('MODULE_PAYMENT_NOVALNET_TEL_INFO', '', '6', '7', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
		('MODULE_PAYMENT_NOVALNET_TEL_SORT_ORDER', '0', '6', '8', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function,
		date_added) values ('MODULE_PAYMENT_NOVALNET_TEL_ORDER_STATUS_ID', '0', '6', '9', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name',
		now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function,
		date_added) values ('MODULE_PAYMENT_NOVALNET_TEL_ZONE', '0', '6', '10', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values
		('MODULE_PAYMENT_NOVALNET_TEL_PROXY', '', '6', '11', now())");
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
        return array('MODULE_PAYMENT_NOVALNET_TEL_ALLOWED', 'MODULE_PAYMENT_NOVALNET_TEL_STATUS', 'MODULE_PAYMENT_NOVALNET_TEL_TEST_MODE',
            'MODULE_PAYMENT_NOVALNET_TEL_VENDOR_ID', 'MODULE_PAYMENT_NOVALNET_TEL_AUTH_CODE', 'MODULE_PAYMENT_NOVALNET_TEL_PRODUCT_ID',
            'MODULE_PAYMENT_NOVALNET_TEL_TARIFF_ID', 'MODULE_PAYMENT_NOVALNET_TEL_INFO', 'MODULE_PAYMENT_NOVALNET_TEL_SORT_ORDER',
            'MODULE_PAYMENT_NOVALNET_TEL_ORDER_STATUS_ID', 'MODULE_PAYMENT_NOVALNET_TEL_ZONE', 'MODULE_PAYMENT_NOVALNET_TEL_PROXY');
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
?>
