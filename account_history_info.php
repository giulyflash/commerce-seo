<?php

/* -----------------------------------------------------------------
 * 	$Id: account_history_info.php 420 2013-06-19 18:04:39Z akausch $
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

include ('includes/application_top.php');
$smarty = new Smarty;
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');

require_once (DIR_FS_INC . 'xtc_date_short.inc.php');
require_once (DIR_FS_INC . 'xtc_get_all_get_params.inc.php');
require_once (DIR_FS_INC . 'xtc_image_button.inc.php');
require_once (DIR_FS_INC . 'xtc_display_tax_value.inc.php');
require_once (DIR_FS_INC . 'xtc_format_price_order.inc.php');

//security checks
if (!isset($_SESSION['customer_id'])) {
    xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
}
if (!isset($_GET['order_id']) || (isset($_GET['order_id']) && !is_numeric($_GET['order_id']))) {
    xtc_redirect(xtc_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
}
$customer_info_query = xtc_db_query("SELECT customers_id FROM " . TABLE_ORDERS . " WHERE orders_id = '" . (int) $_GET['order_id'] . "'");
$customer_info = xtc_db_fetch_array($customer_info_query);
if ($customer_info['customers_id'] != $_SESSION['customer_id']) {
    xtc_redirect(xtc_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
}

$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_HISTORY_INFO, xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_HISTORY_INFO, xtc_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
$breadcrumb->add(sprintf(NAVBAR_TITLE_3_ACCOUNT_HISTORY_INFO, (int) $_GET['order_id']), xtc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . (int) $_GET['order_id'], 'SSL'));

require (DIR_WS_CLASSES . 'class.order.php');
$order = new order((int) $_GET['order_id']);
require_once (DIR_WS_INCLUDES . 'header.php');

// Delivery Info
if ($order->delivery != false) {
    $smarty->assign('DELIVERY_LABEL', xtc_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'));
    if ($order->info['shipping_method']) {
        $smarty->assign('SHIPPING_METHOD', $order->info['shipping_method']);
    }
}

$order_total = $order->getTotalData((int) $_GET['order_id']);

$smarty->assign('order_data', $order->getOrderData((int) $_GET['order_id']));
$smarty->assign('order_total', $order_total['data']);

// Payment Method
if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
    include (DIR_WS_LANGUAGES . '/' . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_method'] . '.php');
    $smarty->assign('PAYMENT_METHOD', constant(MODULE_PAYMENT_ . strtoupper($order->info['payment_method']) . _TEXT_TITLE));
}

// Order History
$statuses_query = xtc_db_query("SELECT os.orders_status_name, osh.date_added, osh.comments FROM " . TABLE_ORDERS_STATUS . " os, " . TABLE_ORDERS_STATUS_HISTORY . " osh WHERE osh.orders_id = '" . (int) $_GET['order_id'] . "' AND osh.orders_status_id = os.orders_status_id AND os.language_id = '" . (int) $_SESSION['languages_id'] . "' ORDER BY osh.date_added;");
while ($statuses = xtc_db_fetch_array($statuses_query)) {
    $history_block .= xtc_date_short($statuses['date_added']) . ' <strong>' . $statuses['orders_status_name'] . '</strong><br />' . (empty($statuses['comments']) ? '' : '<em>' . nl2br(htmlspecialchars($statuses['comments'])) . '</em><br />');
}

$smarty->assign('HISTORY_BLOCK', $history_block);

// Download-Products
if (DOWNLOAD_ENABLED == 'true') {
    include (DIR_WS_MODULES . 'downloads.php');
}

//PDF Rechnung Download
$pdf_bill_query = xtc_db_fetch_array(xtc_db_query("SELECT order_id, bill_name FROM " . TABLE_ORDERS_PDF . " WHERE order_id = '" . (int) $_GET['order_id'] . "'"));
$smarty->assign('IPDFBILL_INVOICE_DOWNLOAD', $pdf_bill_query['bill_name']);

$smarty->assign('ORDER_NUMBER', (int) $_GET['order_id']);
$smarty->assign('ORDER_DATE', xtc_date_short($order->info['date_purchased']));
$smarty->assign('ORDER_STATUS', $order->info['orders_status']);
$smarty->assign('BILLING_LABEL', xtc_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'));
$smarty->assign('PRODUCTS_EDIT', xtc_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
$smarty->assign('SHIPPING_ADDRESS_EDIT', xtc_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL'));
$smarty->assign('BILLING_ADDRESS_EDIT', xtc_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL'));
$smarty->assign('BUTTON_PRINT', '<a class="shipping" href="' . xtc_href_link(FILENAME_PRINT_ORDER, 'oID=' . (int) $_GET['order_id']) . '">' . xtc_image_button('button_print.gif', IMAGE_BUTTON_PRINT) . '</a>');

$from_history = preg_match("/page=/i", xtc_get_all_get_params()); // referer from account_history yes/no
$back_to = $from_history ? FILENAME_ACCOUNT_HISTORY : FILENAME_ACCOUNT; // if from account_history => return to account_history
$smarty->assign('BUTTON_BACK', '<a href="' . xtc_href_link($back_to, xtc_get_all_get_params(array('order_id')), 'SSL') . '">' . xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>');

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = false;

$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/account_history_info.html');

$smarty->assign('main_content', $main_content);
$smarty->display(CURRENT_TEMPLATE . '/index.html');

include ('includes/application_bottom.php');
