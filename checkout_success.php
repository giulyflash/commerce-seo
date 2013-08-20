<?php

/* -----------------------------------------------------------------
 * 	$Id: checkout_success.php 471 2013-07-09 18:32:20Z akausch $
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

// Google Analytics
if (GOOGLE_ANAL_ON == 'true' && GOOGLE_ANAL_CODE != '') {
    require_once (DIR_FS_INC . 'xtc_get_order_data.inc.php');
    require_once (DIR_FS_INC . 'xtc_get_attributes_model.inc.php');
    require (DIR_WS_CLASSES . 'class.order.php');
}
// Google Analytics End
// if the customer is not logged on, redirect them to the shopping cart page
if (!isset($_SESSION['customer_id'])) {
    xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));
}

if (isset($_GET['action']) && ($_GET['action'] == 'update')) {
    if ($_SESSION['account_type'] != 1) {
        xtc_redirect(xtc_href_link(FILENAME_DEFAULT));
    } else {
        xtc_redirect(xtc_href_link(FILENAME_LOGOFF));
    }
}
$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_SUCCESS);
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_SUCCESS);

require_once (DIR_WS_INCLUDES . 'header.php');

$orders_query = xtc_db_query("select orders_id, orders_status from " . TABLE_ORDERS . " where customers_id = '" . $_SESSION['customer_id'] . "' order by orders_id desc limit 1");
$orders = xtc_db_fetch_array($orders_query);
$last_order = $orders['orders_id'];
$order_status = $orders['orders_status'];

//BOF - Barzahlen - 2013-01-28: Barzahlen Checkout-Page
$payment_query = xtc_db_query("SELECT payment_method FROM ".TABLE_ORDERS." WHERE orders_id = '".$last_order."' LIMIT 1");
$payment = xtc_db_fetch_array($payment_query);
if($payment['payment_method'] === 'barzahlen') {
  if (isset($_SESSION['infotext-1'])) {
    $smarty->assign('INFOTEXT_1',$_SESSION['infotext-1']);
    unset($_SESSION['infotext-1']);
  }
  else {
    xtc_redirect(xtc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.$last_order, 'SSL'));
  }
}
//EOF - Barzahlen - 2013-01-28: Barzahlen Checkout-Page
if (file_exists('CheckoutByAmazon/amazon_checkout_success.php')) {
	include_once('CheckoutByAmazon/amazon_checkout_success.php');
}
//Trusted Shops im Checkout
if (TRUSTED_SHOP_STATUS == 'true') {
    include(DIR_WS_MODULES . 'module_trusted_shops.php');
}

// ClickandBuy: Second Confirmation check
if (MODULE_PAYMENT_CLICKANDBUY_SECONDCONFIRMATION_STATUS == 'true') {
    include('ext/clickandbuy/second_confirmation.php');
    list($cbsc_status, $cbsc_result) = clickandbuy_second_confirmation($orders['orders_id']);
    $smarty->assign('cbsc_status', $cbsc_status);
    $smarty->assign('cbsc_result', $cbsc_result);
}
// /ClickandBuy

$smarty->assign('FORM_ACTION', xtc_draw_form('order', xtc_href_link(FILENAME_CHECKOUT_SUCCESS, 'action=update', 'SSL')));
$smarty->assign('BUTTON_CONTINUE', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
$smarty->assign('BUTTON_PRINT', '<a href="javascript:void(0)" onclick="javascript:window.open(\'' . xtc_href_link(FILENAME_PRINT_ORDER, 'oID=' . $orders['orders_id']) . '\', \'popup\', \'toolbar=0, width=640, height=600\')">' . xtc_image_button('print.gif', IMAGE_BUTTON_PRINT) . '</a>');
$smarty->assign('FORM_END', '</form>');

// GV Code Start
$gv_query = xtc_db_query("SELECT amount FROM " . TABLE_COUPON_GV_CUSTOMER . " WHERE customer_id='" . $_SESSION['customer_id'] . "';");
if ($gv_result = xtc_db_fetch_array($gv_query)) {
    if ($gv_result['amount'] > 0) {
        $smarty->assign('GV_SEND_LINK', xtc_href_link(FILENAME_GV_SEND));
    }
}
// GV Code End
// Google Conversion tracking
if (GOOGLE_CONVERSION == 'true') {
    $smarty->assign('google_tracking', 'true');
    $smarty->assign('tracking_code', '
		<noscript>
		<a href="http://services.google.com/sitestats/' . GOOGLE_LANG . '.html" onclick="window.open(this.href); return false;">
		<img height="27" width="135" border="0" src="http://www.googleadservices.com/pagead/conversion/' . GOOGLE_CONVERSION_ID . '/?hl=' . GOOGLE_LANG . '" />
		</a>
		</noscript>
		    ');
}
if (DOWNLOAD_ENABLED == 'true') {
    include (DIR_WS_MODULES . 'downloads.php');
}

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('PAYMENT_BLOCK', $payment_block);
$smarty->caching = false;

$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/checkout_success.html');
$smarty->assign('main_content', $main_content);

$smarty->display(CURRENT_TEMPLATE . '/index.html');

include ('includes/application_bottom.php');
