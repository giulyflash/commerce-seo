<?php

$request_server_type = (getenv('HTTPS') == '1' || getenv('HTTPS') == 'on') ? 'https' : 'http';
//Start : Backend Configure Values
define('NOVALNET_STATUS_TITLE', 'Enable module');
define('NOVALNET_STATUS_DESC', '');
define('NOVALNET_VENDOR_ID_TITLE', 'Novalnet Merchant ID');
define('NOVALNET_VENDOR_ID_DESC', 'Enter your Novalnet Merchant ID');
define('NOVALNET_AUTH_CODE_TITLE', 'Novalnet Merchant Authorisation code');
define('NOVALNET_AUTH_CODE_DESC', 'Enter your Novalnet Merchant Authorisation code');
define('NOVALNET_PRODUCT_ID_TITLE', 'Novalnet Product ID');
define('NOVALNET_PRODUCT_ID_DESC', 'Enter your Novalnet Product ID');
define('NOVALNET_TARIFF_ID_TITLE', 'Novalnet Tariff ID');
define('NOVALNET_TARIFF_ID_DESC', 'Enter your Novalnet Tariff ID');
define('NOVALNET_MANUAL_CHECK_LIMIT_TITLE', 'Manual checking amount in cents');
define('NOVALNET_MANUAL_CHECK_LIMIT_DESC', 'Please enter the amount in cents');
define('NOVALNET_PRODUCT_ID2_TITLE', 'Second Product ID in Novalnet');
define('NOVALNET_PRODUCT_ID2_DESC', 'for the manual checking');
define('NOVALNET_TARIFF_ID2_TITLE', 'Second Tariff ID in Novalnet');
define('NOVALNET_TARIFF_ID2_DESC', 'for the manual checking');
define('NOVALNET_INFO_TITLE', 'Information to the end customer');
define('NOVALNET_INFO_DESC', 'will appear in the payment form');
define('NOVALNET_ORDER_STATUS_ID_TITLE', 'Set order Status');
define('NOVALNET_ORDER_STATUS_ID_DESC', 'Set the status of orders made with this payment module to this value');
define('NOVALNET_SORT_ORDER_TITLE', 'Sort order of display');
define('NOVALNET_SORT_ORDER_DESC', 'Sort order of display. Lowest is displayed first.');
define('NOVALNET_ZONE_TITLE', 'Payment zone');
define('NOVALNET_ZONE_DESC', 'If a zone is selected then this module is activated only for Selected zone.');
define('NOVALNET_ALLOWED_TITLE', 'Allowed zones');
define('NOVALNET_ALLOWED_DESC', 'Please enter the desired zones separated by comma (Eg: AT,DE) or leave it blank');
define('NOVALNET_LOGO_STATUS_TITLE', 'Novalnet Logo');
define('NOVALNET_LOGO_STATUS_DESC', 'Do you want to display Novalnet logo in front end?');
define('NOVALNET_TEST_MODE_TITLE', 'Enable Test Mode');
define('NOVALNET_TEST_MODE_DESC', '');
define('NOVALNET_PASSWORD_TITLE', 'Novalnet Payment access key');
define('NOVALNET_PASSWORD_DESC', 'Enter your Novalnet payment access key');
define('NOVALNET_PROXY_TITLE', 'Proxy-Server');
define('NOVALNET_PROXY_DESC', 'If you use a Proxy Server, enter the Proxy Server IP with port here (e.g. www.proxy.de:80)');
define('NOVALNET_IN_TEST_MODE', '<span style="color:#FF0000;">&nbsp;&nbsp;(in Testing mode)</span>');
define('NOVALNET_NOT_CONFIGURED', '<span style="color:#FF0000;">&nbsp;&nbsp;(Not Configured)</span>');
//End : Backend Configure Values
//Start : Common Error and Description
/* define('NOVALNET_REDIRECT_TEXT_DESCRIPTION', '<div style="margin:10px 0px 10px 0px;">You will be redirected to Novalnet AG website when you place the order.</div>');
  define('NOVALNET_INV_PP_TEXT_DESCRIPTION', '<div style="margin:10px 0px 10px 0px;">The bank details will be emailed to you soon after the completion of checkout process.</div>');
  define('NOVALNET_CC_TEXT_DESCRIPTION', '<div style="margin:10px 0px 10px 0px;">The amount will be booked immediatley from your credit card when you submit the order.</div>');
  define('NOVALNET_DD_TEXT_DESCRIPTION', '<div style="margin:10px 0px 10px 0px;">Your account will be debited upon delivery of goods.</div>');
  define('NOVALNET_TEL_TEXT_DESCRIPTION', 'Schnell und Sicher bezahlen &uuml;ber Novalnet AG<BR>Bitte vor aktivierung alle noetige IDs in Bearbeitungmodus eingeben.<br><br>'); */
define('NOVALNET_REDIRECT_TEXT_DESCRIPTION', 'You will be redirected to Novalnet AG website when you place the order.');
define('NOVALNET_INV_PP_TEXT_DESCRIPTION', 'The bank details will be emailed to you soon after the completion of checkout process.');
define('NOVALNET_CC_TEXT_DESCRIPTION', 'The amount will be booked immediately from your credit card when you submit the order.');
define('NOVALNET_DD_TEXT_DESCRIPTION', 'Your account will be debited upon delivery of goods.');
define('NOVALNET_TEL_TEXT_DESCRIPTION', 'Your amount will be added in your telephone bill when you place the order ');
define('NOVALNET_GUEST_USER', 'guest');
define('NOVALNET_TEXT_LANG', 'EN');
define('NOVALNET_TEXT_INFO', '');
define('NOVALNET_TEXT_ERROR_MESSAGE', '<br>Novalnet Error Message :');
define('NOVALNET_TEXT_JS_NN_MISSING', '* Basic Parameter Missing!.');
define('NOVALNET_TEXT_JS_NN_ID2_MISSING', '* Product-ID2 and/or Tariff-ID2 missing!');
define('NOVALNET_ACCOUNT_TEXT_ERROR', 'Account data Error:');
define('NOVALNET_CC_TEXT_ERROR', 'Credit card data Error:');
define('NOVALNET_TEXT_CUST_INFORM', '');
define('NOVALNET_TEXT_ORDERNO', 'Order no: ');
define('NOVALNET_TEXT_ORDERDATE', 'Order date: ');
define('NOVALNET_TEST_MODE', 'Test Mode');
define('NOVALNET_TEXT_HASH_ERROR', 'checkHash failed');
define('NOVALNET_TEST_ORDER_MESSAGE', "Test order \n");
define('NOVALNET_TID_MESSAGE', 'Novalnet Transaction ID : ');
define('NOVALNET_REF_TID_MESSAGE', 'Reference : TID ');
define('NOVALNET_PAYMENT_MESSAGE', 'There was an error and your payment could not be completed.');
define('NOVALNET_REQUEST_FOR_CHOOSE_SHIPPING_METHOD', 'Please choose a shipping method');
define('NOVALNET_TEXT_JS_NN_CHECK_LIMIT_MISSING', '* Manual Check limit field missing!');
define('NOVALNET_TEXT_ERROR_MESSAGE', 'Novalnet Error Message :');
//End : Common Error and Description
//Start : Pin by call back
define('NOVALNET_PIN_COUNTRY_CODE_TITLE', 'Country Codes');
define('NOVALNET_PIN_COUNTRY_CODE_DESC', 'Please enter the country code <b>separately</b> which should be allowed to enable the "Pin By Callback" option(eg. DE,AT)');
define('NOVALNET_PIN_BY_CALLBACK_SMS_TITLE', 'PIN by Callback/SMS/E-Mail');
define('NOVALNET_PIN_BY_CALLBACK_SMS_DESC','When activated by PIN Callback / SMS / E-Mail the customer to enter their phone / mobile number / E-Mail requested. By phone or SMS, the customer receives a PIN from Novalnet AG, which must enter before ordering. If the PIN is valid, the payment process has been completed successfully, otherwise the customer will be prompted again to enter the PIN. This service is only available for customers from specified countries.');

/* define('NOVALNET_PIN_BY_CALLBACK_TEL_REQ', '<div style="width:135px;">Phone Number:*</div>');
  define('NOVALNET_PIN_BY_CALLBACK_SMS_REQ', '<div style="width:135px;">Mobile phone number:*</div>');
  define('NOVALNET_PIN_BY_CALLBACK_EMAIL_REQ', '<div style="width:135px;">Email Address:*</div>'); */
define('NOVALNET_PIN_BY_CALLBACK_SMS_TEL', 'Telephone Number: <span style="color:red">*</span>');
define('NOVALNET_PIN_BY_CALLBACK_SMS_MOB', 'Mobile phone number: <span style="color:red">*</span>');
define('NOVALNET_PIN_BY_CALLBACK_EMAIL', 'Email Address: <span style="color:red">*</span>');
define('NOVALNET_PIN_BY_CALLBACK_SMS_PIN', 'PIN:');
define('NOVALNET_PIN_BY_CALLBACK_SMS_NEW_PIN', 'Forgot PIN? [New PIN Request]');
define('NOVALNET_PIN_BY_CALLBACK_SMS_TEL_NOTVALID', 'Please enter the Telephone / Mobilenumber!');
define('NOVALNET_PIN_BY_CALLBACK_SMS_PIN_NOTVALID', 'PIN you have entered is incorrect or empty!');
define('NOVALNET_PIN_BY_CALLBACK_EMAIL_NOTVALID', 'Please enter the E-Mail Address!');
define('NOVALNET_EMAIL_INPUT_REQUEST_DESC', 'We have sent a email, please answer');
define('NOVALNET_PIN_BY_CALLBACK_SMS_CALL_MESSAGE', 'You will shortly receive a PIN via phone / SMS. Please enter the PIN in the appropriate text box.');
define('NOVALNET_PIN_BY_CALLBACK_MIN_LIMIT_TITLE', 'Minimum amount limit for callback in cents');
define('NOVALNET_PIN_BY_CALLBACK_MIN_LIMIT_DESC', 'Please enter minimum amount limit to enable "Pin by CallBack" modul (In Cents, e.g. 100,200).');
define('NOVALNET_PIN_INPUT_REQUEST_DESC', '<b>PIN Number : <span style ="color:red">*<span></b>');
define('NOVALNET_PIN_RECEIVE_DESC', 'You will shortly receive a PIN by phone or SMS. Please enter the PIN in the appropriate text box.');
define('NOVALNET_PIN_ENTRY_EXCEED_ERROR', 'Maximum number of PIN entries exceeded.');
define('NOVALNET_PIN_BY_CALLBACK_SESSION_ERROR', 'Your PIN session has expired. Please try again with a new call.');
define('NOVALNET_AMOUNT_VARIATION_MESSAGE', 'You have changed the cart amount after getting PIN number, please try again with new call');
define('NOVALNET_AMOUNT_VARIATION_MESSAGE_PIN', 'You have changed the order amount after getting PIN number, please try again with a new call!');
define('NOVALNET_AMOUNT_VARIATION_MESSAGE_EMAIL', 'You have changed the order amount after getting e-mail, please try again with a new call!');

define('NOVALNET_PIN_CHECK_MSG', 'You will shortly receive a PIN by phone or SMS. Please enter the PIN in the appropriate text box!');
define('NOVALNET_EMAIL_REPLY_CHECK_MSG', 'We have sent a email, please answer!');
define('NOVALNET_EMAIL_REPLY_INFO', '<B>Yes, I have replied the email </B>');
define('NOVALNET_EMAIL_REPLY_CHECKBOX_INFO', 'Please mark the tick, If you have replied the mail');
define('NOVALNET_FORGOT_PIN_INFO', "<B><A HREF='javascript:show_forgot_pin_info()' ONMOUSEOVER='show_forgot_pin_info()'>Forgot PIN? [New PIN Request]</A></B>");
define('NOVALNET_FORGOT_PIN_DIV', "<SCRIPT>var showbaby;function show_forgot_pin_info(){var url=parent.location.href;url=url.substring(0,url.lastIndexOf('/'))+'/images/forgot_pin_info.png';w='550';h='300';x=screen.availWidth/2-w/2;y=screen.availHeight/2-h/2;showbaby=window.open(url,'showbaby','toolbar=0,location=0,directories=0,status=0,menubar=0,resizable=1,width='+w+',height='+h+',left='+x+',top='+y+',screenX='+x+',screenY='+y);showbaby.focus();}function hide_forgot_pin_info(){showbaby.close();}</SCRIPT>");
define('NOVALNET_PIN_BY_CALLBACK_SMS_MOB_NUMBER', "<div style=\"color:#FF0000;padding-right: 41px;text-align: right;\">Please provide your Mobile Number.</div><br>");
define('NOVALNET_PIN_BY_CALLBACK_SMS_TEL_NUMBER', "<div style=\"color:#FF0000;padding-right: 41px;text-align: right;\">Please provide your Telephone/Mobile Number.</div><br>");
define('NOVALNET_EMAIL_INFO_DESC', "<br><div style=\"background-color:#FFF8AF;width: 360px;padding:5px;border:1px solid #EFEFEF;color:#FF0000;\"><b>Note:</b> Shortly, after clicking on \"Save\" you will recieve an EMAIL, <br> that you need to reply right away, without making any changes.</div> <br>");
define('NOVALNET_PIN_INFO_DESC', "<div style=\"background-color:#FFF8AF;width: 360px;padding:5px;border:1px solid #EFEFEF;color:#FF0000;\"><b>Note:</b> Shortly, after clicking on \"Save\" you will receive a PIN via a <br> landline or mobile network call, or via SMS.</div> <br>");
//End : Pin by call back
//Start : User Form variables
define('NOVALNET_TEXT_BANK_ACCOUNT_OWNER_FORM', '<div style="width:135px;">Account holder :</div>');
define('NOVALNET_TEXT_BANK_ACCOUNT_NUMBER_FORM', '<div style="width:135px;">Account number :</div>');
define('NOVALNET_TEXT_BANK_CODE_FORM', '<div style="width:135px;">Bankcode :</div>');
define('NOVALNET_TEXT_BANK_ACCOUNT_OWNER_LENGTH_FORM', '3');
define('NOVALNET_TEXT_BANK_ACCOUNT_NUMBER_LENGTH_FORM', '5');
define('NOVALNET_TEXT_BANK_CODE_LENGTH_FORM', '3');
define('NOVALNET_DD_TEXT_COMMON_ERROR', '*Please enter valid account details.!');
define('NOVALNET_TEXT_INVALID_BANK_ACCOUNT_OWNER', '* Please enter valid account holder name.!');
define('NOVALNET_TEXT_JS_BANK_ACCOUNT_OWNER_MIN_LENGTH_ERROR', '* Account holder should be atleast 3 digits long!!');
define('NOVALNET_TEXT_JS_BANK_ACCOUNT_NUMBER_MIN_LENGTH_ERROR', '* Account number should be atleast 5 digits long!');
define('NOVALNET_TEXT_INVALID_BANK_ACCOUNT_NUMBER', '* Please enter valid account number.!');
define('NOVALNET_TEXT_INVALID_BANK_CODE', '* Please enter valid bank code.!');
define('NOVALNET_TEXT_JS_BANK_CODE_MIN_LENGTH_ERROR', '* Bankcode should be atleast 3 digits long!');

//FrontEnd:Description for testmode
define('NOVALNET_TEXT_TESTMODE_FRONT','<span style="color:#FF0000;">Please Note: This transaction will run on TEST MODE and the amount will not be charged</span>');


//End : User Form variables
define('NOVALNET_TEXT_BANK_ACCOUNT_OWNER_PAY', 'Account holder: <span style="color:red;">*</span>');
define('NOVALNET_TEXT_BANK_ACCOUNT_NUMBER_PAY', 'Account number: <span style="color:red;">*</span>');
define('NOVALNET_TEXT_BANK_CODE_PAY', 'Bankcode: <span style="color:red;">*</span>');

//Start : Invoice and Prepayment Comment variables
define('NOVALNET_TEXT_BANK_ACCOUNT_OWNER', 'Account holder :');
define('NOVALNET_TEXT_BANK_ACCOUNT_NUMBER', 'Account number :');
define('NOVALNET_TEXT_BANK_CODE', 'Bankcode :');
define('NOVALNET_TEXT_BANK_IBAN', 'IBAN :');
define('NOVALNET_TEXT_BANK_BIC', 'SWIFT / BIC :');
define('NOVALNET_TEXT_BANK_BANK', 'Bank :');
define('NOVALNET_TEXT_BANK_CITY', 'City :');
define('NOVALNET_TEXT_AMOUNT', 'Amount :');
define('NOVALNET_TEXT_REFERENCE', 'Reference :');
define('NOVALNET_TEXT_IBAN_INFO', 'Only for international transfers :');
/* define('NOVALNET_TEXT_REFERENCE_INFO', 'Please note that the Transfer can only be identified with the above mentioned Reference.'); */
define('NOVALNET_TEXT_REFERENCE_INFO', '');
define('NOVALNET_TEXT_TRANSFER_INFO', 'Please transfer the amount to the following information to our Payment service Novalnet AG.');
define('NOVALNET_TEXT_BANK_INFO', 'The Bank details will be emailed to you soon after the completion of checkout process!');
define('NOVALNET_TEXT_DURATION_INFO', 'Payment period:');
define('NOVALNET_TEXT_DURATION_INFO_DAYS', 'days');
define('NOVALNET_TEXT_DURATION_DUE_DATE', 'Due Date : ');
define('NOVALNET_TEXT_DURATION_LIMIT_INFO', 'Please transfer the amount to the following information to our Payment service Novalnet AG.');
define('NOVALNET_TEXT_DURATION_LIMIT_END_INFO', 'tto following account:');
//End : Invoice and Prepayment Comment variables
//define('NOVALNET_TEXT_LOGO_IMAGE', '');
define('NOVALNET_TEXT_LOGO_IMAGE', '<a HREF="http://www.novalnet.com" TARGET="_new"><IMG SRC="' . $request_server_type . '://www.novalnet.de/img/NN_Logo_T.png" ALT="novalnet.com" title="novalnet.com" BORDER="0"></a>');
define('MODULE_PAYMENT_ENABLE_NOVALNET_LOGO', '1');
?>
