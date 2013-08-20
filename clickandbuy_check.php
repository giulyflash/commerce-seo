<?php

/* -----------------------------------------------------------------
 * 	$Id: clickandbuy_check.php 420 2013-06-19 18:04:39Z akausch $
 * 	Copyright (c) 2011-2021 commerce:SEO by Webdesign Erfurt
 * 	http://www.commerce-seo.de
 * ------------------------------------------------------------------
 * 	based on:
 * 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 * 	(c) 2002-2003 osCommerce - www.oscommerce.com
 * 	(c) 2003     nextcommerce - www.nextcommerce.org
 * 	(c) 2005     xt:Commerce - www.xt-commerce.com
 * 	Released under the GNU General Public License
 * --------------------------------------------------------------- */

include_once('includes/configure.php');
include_once('includes/filenames.php');
include_once('includes/database_tables.php');

require_once (DIR_FS_INC . 'cseo_db.inc.php');

require_once(DIR_WS_FUNCTIONS . 'sessions.php');
require_once(DIR_FS_INC . 'xtc_get_all_get_params.inc.php');

xtc_db_connect();

$args = '?' . xtc_get_all_get_params();

$shop_domain = (ENABLE_SSL ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG;
$final_price = ($_SERVER["HTTP_X_PRICE"] / 1000) / 100;

$qr = xtc_db_query(sprintf("SELECT customers_basket_id FROM %s WHERE customers_id = %d AND final_price = '%s' AND clickandbuy_TransactionID = '%s' AND clickandbuy_externalBDRID = '%s'", TABLE_CUSTOMERS_BASKET, $_GET['userid'], xtc_db_input($final_price), xtc_db_input($_GET['TransactionID']), xtc_db_input($_GET['externalBDRID'])));
if (!$qr) {
    header('Location: ' . $shop_domain . FILENAME_CHECKOUT_PAYMENT . $args . '&result=error&error_c=CLICKANDBUY_PAYMENT_ERROR_DB'); // db error -> error
    exit;
}

$qa = xtc_db_fetch_array($qr);

if (!isset($_GET['userid'])) {
    // userid missing
    header('Location: ' . $shop_domain . FILENAME_CHECKOUT_PAYMENT . $args . '&result=error&error_c=CLICKANDBUY_PAYMENT_ERROR_NO_USERID');
    exit;
}
if (!isset($_GET['TransactionID'])) {
    // TransactionID missing
    header('Location: ' . $shop_domain . FILENAME_CHECKOUT_PAYMENT . $args . '&result=error&error_c=CLICKANDBUY_PAYMENT_ERROR_NO_TRANSACTIONID');
    exit;
}
if (!isset($_GET['externalBDRID'])) {
    // ExternalBDRID missing
    header('Location: ' . $shop_domain . FILENAME_CHECKOUT_PAYMENT . $args . '&result=error&error_c=CLICKANDBUY_PAYMENT_ERROR_NO_EXTERNALBDRID');
    exit;
}
if (!isset($_SERVER["HTTP_X_PRICE"])) {
    // no X-Price header
    header('Location: ' . $shop_domain . FILENAME_CHECKOUT_PAYMENT . $args . '&result=error&error_c=CLICKANDBUY_PAYMENT_ERROR_NO_PRICE');
    exit;
}
if ($_SERVER["HTTP_X_TRANSACTION"] == '0') {
    // no TransactionID from ClickandBuy, test purchase, or the transaction is fraudulent
    header('Location: ' . $shop_domain . FILENAME_CHECKOUT_PAYMENT . $args . '&result=error&error_c=CLICKANDBUY_PAYMENT_ERROR_INVALID_TRANSACTIONID');
    exit;
}
if (substr($_SERVER["REMOTE_ADDR"], 0, 10) != '217.22.128') {
    // remote address is not from the ClickandBuy proxy network
    header('Location: ' . $shop_domain . FILENAME_CHECKOUT_PAYMENT . $args . '&result=error&error_c=CLICKANDBUY_PAYMENT_ERROR_INVALID_IP');
    exit;
}
if (!isset($_SERVER["HTTP_X_USERID"])) {
    // no X-UserId header
    header('Location: ' . $shop_domain . FILENAME_CHECKOUT_PAYMENT . $args . '&result=error&error_c=CLICKANDBUY_PAYMENT_ERROR_NO_XUSERID');
    exit;
}
if (!isset($qa['customers_basket_id'])) {
    // no basket_id
    header('Location: ' . $shop_domain . FILENAME_CHECKOUT_PAYMENT . $args . '&result=error&error_c=CLICKANDBUY_PAYMENT_ERROR_NO_BASKET&dbg=' . urlencode($_GET['userid']) . '-' . urlencode($_SERVER["HTTP_X_TRANSACTION"]) . '-' . urlencode($final_price));
    exit;
}
if ($qa['customers_basket_id'] <= 0) {
    // invalid basket_id
    header('Location: ' . $shop_domain . FILENAME_CHECKOUT_PAYMENT . $args . '&result=error&error_c=CLICKANDBUY_PAYMENT_ERROR_INVALID_BASKET');
    exit;
}

// no errors
// all ok -> process payment and checkout
header('Location: ' . $shop_domain . FILENAME_CHECKOUT_PROCESS . $args . '&result=success&transaction=' . urlencode($_GET['TransactionID']) . '&userid=' . urlencode($_GET['userid']) . '&price=' . urlencode($final_price) . '&externalBDRID=' . urlencode($_GET['externalBDRID']) . '&xTransaction=' . urlencode($_SERVER["HTTP_X_TRANSACTION"]) . '&xUser=' . urlencode($_SERVER["HTTP_X_USERID"]));
exit;

