<?php

include_once 'novalnet_common.php';

define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_TITLE', 'PayPal');
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_PUBLIC_TITLE', 'PayPal');

define('MODULE_PAYMENT_NOVALNET_PAYPAL_LOGO_TITLE', '<NOBR>' . NOVALNET_TEXT_LOGO_IMAGE . '&nbsp;' . '</NOBR>');
define('MODULE_PAYMENT_NOVALNET_PAYPAL_PAYMENT_LOGO_TITLE', '<NOBR><a href="https://www.novalnet.de" target="_new"><img src="' . $request_server_type . '://www.novalnet.de/img/paypal-small.png" alt="PayPal" title="PayPal" border="0"></a></NOBR><br>');

 

define('MODULE_PAYMENT_NOVALNET_PAYPAL_API_USER_TITLE', 'PayPal API Benutzername');
define('MODULE_PAYMENT_NOVALNET_PAYPAL_API_USER_DESC', 'Geben Sie Ihren PayPal API Benutzernamen ein');
define('MODULE_PAYMENT_NOVALNET_PAYPAL_API_USER', 'PayPal API Benutzername');
define('MODULE_PAYMENT_NOVALNET_PAYPAL_API_PASSWORD_TITLE', 'PayPal API Passwort');
define('MODULE_PAYMENT_NOVALNET_PAYPAL_API_PASSWORD_DESC', 'Geben Sie Ihr PayPal API Passwort ein');
define('MODULE_PAYMENT_NOVALNET_PAYPAL_API_PASSWORD', 'PayPal API Passwort');
define('MODULE_PAYMENT_NOVALNET_PAYPAL_API_SIGNATURE_TITLE', 'PayPal API Signatur');
define('MODULE_PAYMENT_NOVALNET_PAYPAL_API_SIGNATURE_DESC', 'Geben Sie Ihre PayPal API Signatur ein');
define('MODULE_PAYMENT_NOVALNET_PAYPAL_API_SIGNATURE', 'PayPal API Signatur');
define('MODULE_PAYMENT_PAYPAL_TEXT_INFO', '<img src="https://www.paypal.com/de_DE/DE/i/logo/lockbox_150x47.gif" />');

define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_DESCRIPTION', '<span style="float:left;clear:both;">' . NOVALNET_REDIRECT_TEXT_DESCRIPTION . '</span>');
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_LANG', NOVALNET_TEXT_LANG);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_INFO', NOVALNET_TEXT_INFO);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_STATUS_TITLE', NOVALNET_STATUS_TITLE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_STATUS_DESC', NOVALNET_STATUS_DESC);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_VENDOR_ID_TITLE', NOVALNET_VENDOR_ID_TITLE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_VENDOR_ID_DESC', NOVALNET_VENDOR_ID_DESC);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_AUTH_CODE_TITLE', NOVALNET_AUTH_CODE_TITLE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_AUTH_CODE_DESC', NOVALNET_AUTH_CODE_DESC);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_PRODUCT_ID_TITLE', NOVALNET_PRODUCT_ID_TITLE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_PRODUCT_ID_DESC', NOVALNET_PRODUCT_ID_DESC);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TARIFF_ID_TITLE', NOVALNET_TARIFF_ID_TITLE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TARIFF_ID_DESC', NOVALNET_TARIFF_ID_DESC);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_INFO_TITLE', NOVALNET_INFO_TITLE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_INFO_DESC', NOVALNET_INFO_DESC);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_ORDER_STATUS_ID_TITLE', NOVALNET_ORDER_STATUS_ID_TITLE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_ORDER_STATUS_ID_DESC', NOVALNET_ORDER_STATUS_ID_DESC);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_SORT_ORDER_TITLE', NOVALNET_SORT_ORDER_TITLE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_SORT_ORDER_DESC', NOVALNET_SORT_ORDER_DESC);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_ZONE_TITLE', NOVALNET_ZONE_TITLE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_ZONE_DESC', NOVALNET_ZONE_DESC);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_ALLOWED_TITLE', NOVALNET_ALLOWED_TITLE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_ALLOWED_DESC', NOVALNET_ALLOWED_DESC);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_JS_NN_MISSING', NOVALNET_TEXT_JS_NN_MISSING);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_ERROR', NOVALNET_ACCOUNT_TEXT_ERROR);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_CUST_INFORM', NOVALNET_TEXT_CUST_INFORM);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_ORDERNO', NOVALNET_TEXT_ORDERNO);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_ORDERDATE', NOVALNET_TEXT_ORDERDATE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEST_MODE', NOVALNET_TEST_MODE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_IN_TEST_MODE', NOVALNET_IN_TEST_MODE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_NOT_CONFIGURED', NOVALNET_NOT_CONFIGURED);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEST_MODE_TITLE', NOVALNET_TEST_MODE_TITLE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEST_MODE_DESC', NOVALNET_TEST_MODE_DESC);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEXT_HASH_ERROR', NOVALNET_TEXT_HASH_ERROR);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_PASSWORD_TITLE', NOVALNET_PASSWORD_TITLE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_PASSWORD_DESC', NOVALNET_PASSWORD_DESC);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_PROXY_TITLE', NOVALNET_PROXY_TITLE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_PROXY_DESC', NOVALNET_PROXY_DESC);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TEST_ORDER_MESSAGE', NOVALNET_TEST_ORDER_MESSAGE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_TID_MESSAGE', NOVALNET_TID_MESSAGE);
define('MODULE_PAYMENT_NOVALNET_PAYPAL_REQUEST_FOR_CHOOSE_SHIPPING_METHOD', NOVALNET_REQUEST_FOR_CHOOSE_SHIPPING_METHOD);
