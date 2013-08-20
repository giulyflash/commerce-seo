<?php
/**
 * Novalnet Callback Script for CommerceSEO
 *
 * NOTICE
 *
 * This script is used for real time capturing of parameters passed 
 * from Novalnet AG after Payment processing of customers.
 *
 * This script is only free to the use for Merchants of Novalnet AG
 *
 * If you have found this script useful a small recommendation as well
 * as a comment on merchant form would be greatly appreciated.
 *
 * Please contact sales@novalnet.de for enquiry or info
 *
 * ABSTRACT: This script is called from Novalnet, as soon as a payment 
 * done for payment methods, e.g. Prepayment, Invoice, Paypal.
 * An email will be sent if an error occurs
 *
 *
 * @category   Novalnet
 * @package    Novalnet
 * @copyright  Copyright (c) Novalnet AG. (https://www.novalnet.de)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @notice     1. This script must be placed in CommerceSEO root folder
 *                to avoid rewrite rules (mod_rewrite)
 *             2. You have to adapt the value of all the variables
 *                commented with 'adapt ...'
 *             3. Set $test/$debug to false for live system
 */
	include ('includes/application_top.php');

	//Variable Settings
	$debug 			= false; //false|true; adapt: set to false for go-live
	$test 			= false; //false|true; adapt: set to false for go-live
	$lineBreak 		= empty($_SERVER['HTTP_HOST']) ? PHP_EOL : '<br />';
	$addSubsequentTidToDb = true; //whether to add the new tid to db; adapt if necessary
	// Order State/Status Settings
	/*   4. Standard Types of Status:
	  1. Pending = 1
	  2. Processing = 2
	  3. Delivered  = 3

	 */
	$orderState 	= 3; //Note: Indicates Payment accepted.
	$vendorId 		= 4;
	//Security Setting; only this IP is allowed for call back script
	$ipAllowed 		= '195.143.189.210'; //Novalnet IP, is a fixed value, DO NOT CHANGE!!!!!
	//Reporting Email Addresses Settings
	$shopInfo 		= 'CommerceSEO Shop' . $lineBreak; //manditory;adapt for your need
	$mailHost 		= 'Ihr Email Server'; //adapt
	$mailPort 		= 25; //adapt
	$emailFromAddr 	= 'Ihr Emailaddr'; //sender email addr., manditory, adapt it
	$emailToAddr 	= 'Ihr Emailaddr'; //recipient email addr., manditory, adapt it
	$emailSubject 	= 'Novalnet Callback Script Access Report'; //adapt if necessary; 
	$emailBody 		= ''; //Email text, adapt
	$emailFromName 	= ""; // Sender name, adapt
	$emailToName 	= ""; // Recipient name, adapt
	//Parameters Settings
	if($_REQUEST == 'INVOICE_CREDIT'){
		$hParamsRequired = array(
		'vendor_id' => '',
		'tid' => '',
		'payment_type' => '',
		'status' => '',
		'amount' => '',
		'tid_payment' => '');
	}else{
		$hParamsRequired = array(
		'vendor_id' => '',
		'tid' => '',
		'payment_type' => '',
		'status' => '',
		'amount' => '');
		
	}

	//Test Data Settings
	if ($test) {
		//$_REQUEST = $hParamsTest;
		$emailFromName 	= "Novalnet test"; // Sender name, adapt
		$emailToName 	= ""; // Recipient name, adapt
		$emailFromAddr 	= 'Ihr Emailaddr'; //manditory for test; adapt
		$emailToAddr 	= 'Ihr Emailaddr'; //manditory for test; adapt
		$emailSubject 	= $emailSubject . ' - TEST'; //adapt
	}

	// ################### Main Prog. ##########################
	try {
		//Check Params
		if (checkIP($_REQUEST)) {
			if (checkParams($_REQUEST)) {
				//Get Order ID and Set New Order Status
				if ($orderIncrementId = getIncrementId($_REQUEST)) {
					setOrderStatus($orderIncrementId); //and send error mails if any
				}
			}
		}
		if (!$emailBody) {
			$emailBody .= 'Novalnet Callback Script called for StoreId Parameters: ' . print_r($_POST, true) . $lineBreak;
			$emailBody .= 'Novalnet callback succ. ' . $lineBreak;
			$emailBody .= 'Params: ' . print_r($_REQUEST, true) . $lineBreak;
		}
	} catch (Exception $e) {
		$emailBody .= "Exception catched: $lineBreak\$e:" . $e->getMessage() . $lineBreak;
	}
	if ($emailBody) {
		if (!sendEmailCommerceSEO($emailBody)) {
			if ($debug) {
				echo "Mailing failed!" . $lineBreak;
				echo "This mail text should be sent: " . $lineBreak;
				echo $emailBody;
			}
		}
	}
	// ############## Sub Routines #####################
	function sendEmailCommerceSEO($emailBody) {
		global $lineBreak, $debug, $test, $emailFromAddr, $emailToAddr, $emailFromName, $emailToName, $emailSubject, $shopInfo, $mailHost, $mailPort;
		$emailBodyT = str_replace('<br />', PHP_EOL, $emailBody);

		//Send Email
		ini_set('SMTP', $mailHost);
		ini_set('smtp_port', $mailPort);

		header('Content-Type: text/html; charset=iso-8859-1');
		$headers = 'From: ' . $emailFromAddr . "\r\n";

		try {
			if ($debug) {
				echo __FUNCTION__ . ': Sending Email suceeded!' . $lineBreak;
			}
			$sendmail = mail($emailToAddr, $emailSubject, $emailBodyT, $headers);
		} catch (Exception $e) {
			if ($debug) {
				echo 'Email sending failed: ' . $e->getMessage();
			}
			return false;
		}
		if ($debug) {
			echo 'This text has been sent:' . $lineBreak . $emailBody;
		}
		return true;
	}

	function checkParams($_request) {
		global $lineBreak, $hParamsRequired, $emailBody;
		$error = false;
		$emailBody = '';
		if (!$_request) {
			$emailBody .= 'No params passed over!' . $lineBreak;
			return false;
		}else if(!$_request['payment_type']){
			$emailBody .= 'Novalnet callback received. Payment type is missing! ' . $lineBreak;
			return false;
		}elseif ($hParamsRequired) {
			foreach ($hParamsRequired as $k => $v) {
				if (empty($_request[$k])) {
					$error = true;
					$emailBody .= 'Required param (' . $k . ') missing!' . $lineBreak;
				}
			}
			if ($error) {
				return false;
			}
		}
		if($_request['payment_type'] == 'PAYPAL'){
		    if (strlen($_REQUEST['tid']) != 17) {
				$emailBody .= 'Novalnet callback received. Invalid TID ['.$_REQUEST['tid'].'] for Order ' . "$lineBreak$lineBreak" . $lineBreak;
				return false;
			}
		} 
		if( $_request['payment_type'] == 'INVOICE_CREDIT'){
			if (strlen($_REQUEST['tid']) != 17) {
				$emailBody .= 'Novalnet callback received. New TID is not valid ' . "$lineBreak$lineBreak" . $lineBreak;
				return false;
			}
			if (strlen($_REQUEST['tid_payment']) != 17) {
				$emailBody .= 'Novalnet callback received. Invalid TID ['.$_REQUEST['tid_payment'].'] for Order ' . "$lineBreak$lineBreak" . $lineBreak;
				return false;
			}
		}

		if (!empty($_request['payment_type']) and !in_array($_request['payment_type'],array('INVOICE_CREDIT','PAYPAL')) ) {
			$emailBody .= "Novalnet callback received. Payment type (" . $_request['payment_type'] . ") is mismatched!  $lineBreak";
			return false;
		}

		if (!empty($_request['status']) and 100 != $_request['status']) {
			$emailBody .= 'Novalnet callback received. Status [' . $_request['status'] . '] is not valid: Only 100 is allowed.' . "$lineBreak$lineBreak" . $lineBreak;
			return false;
		}
		return true;
	}

	function getIncrementId($_request) {
		global $lineBreak, $tableOrderPayment, $tableOrder, $emailBody, $debug ,$tid;
		$amount = $_request['amount'];
		if (!$amount || $amount < 0) {
			$emailBody .= "Novalnet callback received. The requested amount [$amount] must be greater than zero." . $lineBreak . $lineBreak;
			return false;
		}
		$orderDetails = array();
		
		if ( is_numeric($_request['order_no']) && $_request['order_no'] != 0) {
			return $_request['order_no'];
		} elseif (is_numeric($_request['order_id']) && $_request['order_no'] != 0) {
			return $_request['order_id'];
		}
		
		if($_request['payment_type'] == 'PAYPAL'){
			$tid = $_request['tid'] ;
		}else{
			$tid = $_request['tid_payment'] ; 
		}
		$query = "select orders_id from " . TABLE_ORDERS . " where comments LIKE '%" . $tid  . "%'";
		try {
			$result = xtc_db_query($query);
			while ($result_values = xtc_db_fetch_array($result)) {
				$orders_id = $result_values['orders_id'];
			}
			
		} catch (Exception $e) {
			$emailBody .= 'The original order not found in the shop database table (`' . TABLE_ORDERS . '`);';
			$emailBody .= 'Reason: ' . $e->getMessage() . $lineBreak . $lineBreak;
			$emailBody .= 'Query : ' . $qry . $lineBreak . $lineBreak;
			return false;
		}
		require (DIR_WS_CLASSES . 'order_total.php');
		require (DIR_WS_CLASSES . 'order.php');
		$orderDetails = new order($orders_id);
		if (empty($orders_id) || (!$_request['order_no'] && $orders_id == $_request['order_no']) || (!$_request['order_no'] && $orders_id == $_request['order_id'])) {
			$emailBody .= 'Novalnet callback received. Order no is not valid ' . $lineBreak;
			return false;
		}
		if (!$result or empty($orders_id) or !$orderDetails) {
			$emailBody .= 'Novalnet callback received. Order no is not valid' . $lineBreak;
			return false;
		}
		
		//check amount
		$amount 	 = $_request['amount'];
		$final_price = round($orderDetails->info['pp_total'], 2);
		$_amount 	 = isset($final_price) ? $final_price * 100 : 0;

		$paymentType = strtolower($orderDetails->info['payment_method']);
		$paymentType = str_replace(' ', '_', $paymentType);
		if (!in_array($paymentType, array('novalnet_prepayment', 'novalnet_invoice','novalnet_paypal'))) {
			$emailBody .= "Novalnet callback received. Payment type [$paymentType] is not Prepayment/Invoice/PayPal!$lineBreak$lineBreak";
			return false;
		}
		
		if($paymentType == 'novalnet_paypal'  && $_request['payment_type'] != 'PAYPAL'){
			$emailBody .= "Novalnet callback received. Payment type [$paymentType] is not PayPal!$lineBreak$lineBreak";
			return false;
		}
		
		if( in_array($paymentType, array('novalnet_prepayment', 'novalnet_invoice'))  && ($_request['payment_type'] != 'INVOICE_CREDIT')){
			$emailBody .= "Novalnet callback received. Payment type [$paymentType] is not Prepayment/Invoice!$lineBreak$lineBreak";
			return false;
		}
		return $orders_id; // == true
	}

	function setOrderStatus($incrementId) {
		global $lineBreak, $createInvoice, $emailBody, $orderStatus, $orderState, $tableOrderPayment, $addSubsequentTidToDb, $db;
		if ($incrementId) {
			if ($addSubsequentTidToDb){
				if($_REQUEST['payment_type'] == 'INVOICE_CREDIT'){ 
					$comments = ' Novalnet Callback Script executed successfully. The subsequent TID: (' . $_REQUEST['tid'] . ') on ' . date('Y-m-d H:i:s');
				}else{
					$comments = ' Novalnet Callback Script executed successfully on ' . date('Y-m-d H:i:s');
				}
			}
			$query = "SELECT * from " . TABLE_ORDERS . " WHERE orders_id = '".$incrementId."' ";
			if($_REQUEST['payment_type'] == 'PAYPAL'){
				$tid = $_REQUEST['tid'] ;
			}else{
				$tid = $_REQUEST['tid_payment'] ; 
			}
			$query .= " and comments LIKE '%" . $tid  . "%'";

			$order_qry 		= xtc_db_query($query);
			$orders_info 	= xtc_db_fetch_array($order_qry);
			
			if(!$orders_info){
				$emailBody .= "Novalnet callback received. Order no is not valid!$lineBreak$lineBreak";			
				return false;
			}
			$orders_status_id = $orders_info['orders_status'];
			$paymentType = $orders_info['payment_class'];
			//$paymentType = strtolower($orderDetails->info['payment_method']);
			$paymentType = str_replace(' ', '_', $paymentType);
			if (!in_array($paymentType, array('novalnet_prepayment', 'novalnet_invoice','novalnet_paypal'))) {
				$emailBody .= "Novalnet callback received. Payment type [$paymentType] is not Prepayment/Invoice/PayPal!$lineBreak$lineBreak";
				return false;
			}
			
			if($_REQUEST['payment_type'] == 'PAYPAL' && $paymentType != 'novalnet_paypal' ){
				$emailBody .= "Novalnet callback received. Payment type [$paymentType] is not PayPal!$lineBreak$lineBreak";
				return false;
			}
			
			if( ($_REQUEST['payment_type'] == 'INVOICE_CREDIT') && !in_array($paymentType, array('novalnet_prepayment', 'novalnet_invoice'))  ){
				$emailBody .= "Novalnet callback received. Payment type [$paymentType] is not Prepayment/Invoice!$lineBreak$lineBreak";
				return false;
			}
			if($orders_status_id!= $orderState){
				$qry 		= xtc_db_query("update ".TABLE_ORDERS." set orders_status = '$orderState', last_modified = now() where orders_id = '".$incrementId."' ");
				$updated 	= mysql_affected_rows();
				if($updated){
					### INSERT HISTORY RECORDS ###
					$customer_notified = '1';
					$new_status_qry =xtc_db_query("INSERT INTO ".TABLE_ORDERS_STATUS_HISTORY." (orders_id, orders_status_id, date_added, customer_notified, comments) VALUES (".$incrementId.", ".$orderState.", NOW(), '".$customer_notified."', '".$comments."')");
				}else{
					$emailBody .= 'Updating database table ('.TABLE_ORDERS.') failed;';
					$emailBody .= 'Query : '.$qry.$lineBreak.$lineBreak;
					return false;
				}
			}
			else{
			  $emailBody .= "Novalnet callback received. Callback Script executed already. Refer Order :$incrementId. ";
			  return false;
			}
		} else {
			$emailBody .= "Novalnet Callback: No order for Increment-ID $incrementId found.";
			return false;
		}
		if(strtoupper($_REQUEST['payment_type']) == 'INVOICE_CREDIT'){
			$emailBody .= "Novalnet Callback Script executed successfully. Payment for order id: ".$incrementId." New TID : ".$_REQUEST['tid'].".";
		}else{
			$emailBody .= "Novalnet Callback Script executed successfully.Payment for order id:" .$incrementId .".";
		}
		return true;
	}
	function checkIP($request) {
		global $lineBreak, $ipAllowed, $test, $emailBody;

		$callerIp = $_SERVER['REMOTE_ADDR'];

		if ($ipAllowed != $callerIp && !$test) {
			$emailBody .= 'Unauthorised access from the IP [' . $callerIp . ']' . $lineBreak . $lineBreak;
			$emailBody .= 'Request Params: ' . print_r($request, true);
			return false;
		}
		return true;
	}

	function isPublicIP($value) {
		if (!$value || count(explode('.', $value)) != 4)
			return false;
		return !preg_match('~^((0|10|172\.16|192\.168|169\.254|255|127\.0)\.)~', $value);
	}

	function getRealIpAddr() {
		if (isPublicIP($_SERVER['HTTP_X_FORWARDED_FOR']))
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		if ($iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])) {
			if (isPublicIP($iplist[0]))
				return $iplist[0];
		}
		if (isPublicIP($_SERVER['HTTP_CLIENT_IP']))
			return $_SERVER['HTTP_CLIENT_IP'];
		if (isPublicIP($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
			return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		if (isPublicIP($_SERVER['HTTP_FORWARDED_FOR']))
			return $_SERVER['HTTP_FORWARDED_FOR'];

		return $_SERVER['REMOTE_ADDR'];
	}
?>
