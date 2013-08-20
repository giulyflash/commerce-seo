<?php
/*

  clickandbuy.php
  english language file
  
  xt:Commerce ClickandBuy Payment Module
  (c) 2008 Matthias Bauer / Trust in Dialog <http://www.trustindialog.de/>

  @author Matthias Bauer <m.bauer@trustindialog.de>
  @copyright (c) 2008 Matthias Bauer / Trust in Dialog
  @version $Revision: 360 $
  @license GPLv2

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
  
*/

define('MODULE_PAYMENT_CLICKANDBUY_TEXT_TITLE', 'ClickandBuy');
define('MODULE_PAYMENT_CLICKANDBUY_TEXT_DESCRIPTION', 'ClickandBuy');
define('MODULE_PAYMENT_CLICKANDBUY_STATUS_TITLE', 'Activate ClickandBuy module?');
define('MODULE_PAYMENT_CLICKANDBUY_STATUS_DESC', 'Do you want to accept payments via ClickandBuy?');
define('MODULE_PAYMENT_CLICKANDBUY_ID_TITLE', 'Premium link');
define('MODULE_PAYMENT_CLICKANDBUY_ID_DESC', 'Your ClickandBuy premium link');
define('MODULE_PAYMENT_CLICKANDBUY_REDIRECT_TITLE', 'Redirection script name');
define('MODULE_PAYMENT_CLICKANDBUY_REDIRECT_DESC', 'Filename of your ClickandBuy redirection script.<br>SHOULD NOT NORMALLY BE CHANGED!');
define('MODULE_PAYMENT_CLICKANDBUY_CURRENCY_TITLE', 'Transaction Currency');
define('MODULE_PAYMENT_CLICKANDBUY_CURRENCY_DESC', 'Currency to use for ClickandBuy transactions');
define('MODULE_PAYMENT_CLICKANDBUY_SORT_ORDER_TITLE', 'Display Sort Order');
define('MODULE_PAYMENT_CLICKANDBUY_SORT_ORDER_DESC', 'Numerical sort order, lowest first.');
define('MODULE_PAYMENT_CLICKANDBUY_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_CLICKANDBUY_ZONE_DESC', 'If a zone is selected, this payment module will only be allowed for that zone.');
define('MODULE_PAYMENT_CLICKANDBUY_ORDER_STATUS_ID_TITLE', 'Change Order Status');
define('MODULE_PAYMENT_CLICKANDBUY_ORDER_STATUS_ID_DESC', 'Change successful orders with this payment type to this order status:');
define('MODULE_PAYMENT_CLICKANDBUY_ALLOWED_TITLE' , 'Allowed Zones');
define('MODULE_PAYMENT_CLICKANDBUY_ALLOWED_DESC' , 'Enter <b>each</b> Zone for which this module should be enabled (e.g. "UK,DE"). If left empty, all zones are allowed.');
define('MODULE_PAYMENT_CLICKANDBUY_SECONDCONFIRMATION_STATUS_TITLE', 'Use Second Confirmation?');
define('MODULE_PAYMENT_CLICKANDBUY_SECONDCONFIRMATION_STATUS_DESC', 'Enable Second Confirmation check for orders?');
define('MODULE_PAYMENT_CLICKANDBUY_SELLER_ID_TITLE', 'Seller ID');
define('MODULE_PAYMENT_CLICKANDBUY_SELLER_ID_DESC', 'Your merchant account seller ID.');
define('MODULE_PAYMENT_CLICKANDBUY_TMI_PASSWORD_TITLE', 'Transaction Manager Password');
define('MODULE_PAYMENT_CLICKANDBUY_TMI_PASSWORD_DESC', 'Your password for the Transaction Manager Interface.');

// More Info Link
define('MODULE_PAYMENT_CLICKANDBUY_MORE_INFO_LINK_TITLE', 'More information about ClickandBuy');

// ClickandBuy
define('CLICKANDBUY_PAYMENT_ERROR_DB', 'A database error occurred. Please choose a different payment method.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_USERID', 'Error #3 while executing payment. Please try again.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_TRANSACTIONID', 'Error #4 while executing payment. Please try again.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_EXTERNALBDRID', 'Error #5 while executing payment. Please try again.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_PRICE', 'Error #6 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_PAYMENT_ERROR_INVALID_TRANSACTIONID', 'Error #7 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_PAYMENT_ERROR_INVALID_IP', 'Error #8 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_XUSERID', 'Error #9 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_BASKET', 'Error #10 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_PAYMENT_ERROR_INVALID_BASKET', 'Error #11 while executing payment. Please choose a different payment method.');
// /ClickandBuy

?>
<?php
/*

  clickandbuy.php
  english language file
  
  xt:Commerce ClickandBuy Payment Module
  (c) 2008 Matthias Bauer / Trust in Dialog <http://www.trustindialog.de/>

  @author Matthias Bauer <m.bauer@trustindialog.de>
  @copyright (c) 2008 Matthias Bauer / Trust in Dialog
  @version $Revision: 360 $
  @license GPLv2

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
  
*/

define('MODULE_PAYMENT_CLICKANDBUY_TEXT_TITLE', 'ClickandBuy');
define('MODULE_PAYMENT_CLICKANDBUY_TEXT_DESCRIPTION', 'ClickandBuy');
define('MODULE_PAYMENT_CLICKANDBUY_STATUS_TITLE', 'Activate ClickandBuy module?');
define('MODULE_PAYMENT_CLICKANDBUY_STATUS_DESC', 'Do you want to accept payments via ClickandBuy?');
define('MODULE_PAYMENT_CLICKANDBUY_ID_TITLE', 'Premium link');
define('MODULE_PAYMENT_CLICKANDBUY_ID_DESC', 'Your ClickandBuy premium link');
define('MODULE_PAYMENT_CLICKANDBUY_REDIRECT_TITLE', 'Redirection script name');
define('MODULE_PAYMENT_CLICKANDBUY_REDIRECT_DESC', 'Filename of your ClickandBuy redirection script.<br>SHOULD NOT NORMALLY BE CHANGED!');
define('MODULE_PAYMENT_CLICKANDBUY_CURRENCY_TITLE', 'Transaction Currency');
define('MODULE_PAYMENT_CLICKANDBUY_CURRENCY_DESC', 'Currency to use for ClickandBuy transactions');
define('MODULE_PAYMENT_CLICKANDBUY_SORT_ORDER_TITLE', 'Display Sort Order');
define('MODULE_PAYMENT_CLICKANDBUY_SORT_ORDER_DESC', 'Numerical sort order, lowest first.');
define('MODULE_PAYMENT_CLICKANDBUY_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_CLICKANDBUY_ZONE_DESC', 'If a zone is selected, this payment module will only be allowed for that zone.');
define('MODULE_PAYMENT_CLICKANDBUY_ORDER_STATUS_ID_TITLE', 'Change Order Status');
define('MODULE_PAYMENT_CLICKANDBUY_ORDER_STATUS_ID_DESC', 'Change successful orders with this payment type to this order status:');
define('MODULE_PAYMENT_CLICKANDBUY_ALLOWED_TITLE' , 'Allowed Zones');
define('MODULE_PAYMENT_CLICKANDBUY_ALLOWED_DESC' , 'Enter <b>each</b> Zone for which this module should be enabled (e.g. "UK,DE"). If left empty, all zones are allowed.');
define('MODULE_PAYMENT_CLICKANDBUY_SECONDCONFIRMATION_STATUS_TITLE', 'Use Second Confirmation?');
define('MODULE_PAYMENT_CLICKANDBUY_SECONDCONFIRMATION_STATUS_DESC', 'Enable Second Confirmation check for orders?');
define('MODULE_PAYMENT_CLICKANDBUY_SELLER_ID_TITLE', 'Seller ID');
define('MODULE_PAYMENT_CLICKANDBUY_SELLER_ID_DESC', 'Your merchant account seller ID.');
define('MODULE_PAYMENT_CLICKANDBUY_TMI_PASSWORD_TITLE', 'Transaction Manager Password');
define('MODULE_PAYMENT_CLICKANDBUY_TMI_PASSWORD_DESC', 'Your password for the Transaction Manager Interface.');

// More Info Link
define('MODULE_PAYMENT_CLICKANDBUY_MORE_INFO_LINK_TITLE', 'More information about ClickandBuy');

// ClickandBuy
define('CLICKANDBUY_PAYMENT_ERROR_DB', 'A database error occurred. Please choose a different payment method.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_USERID', 'Error #3 while executing payment. Please try again.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_TRANSACTIONID', 'Error #4 while executing payment. Please try again.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_EXTERNALBDRID', 'Error #5 while executing payment. Please try again.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_PRICE', 'Error #6 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_PAYMENT_ERROR_INVALID_TRANSACTIONID', 'Error #7 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_PAYMENT_ERROR_INVALID_IP', 'Error #8 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_XUSERID', 'Error #9 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_BASKET', 'Error #10 while executing payment. Please choose a different payment method.');
define('CLICKANDBUY_PAYMENT_ERROR_INVALID_BASKET', 'Error #11 while executing payment. Please choose a different payment method.');
// /ClickandBuy

?>