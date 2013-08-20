<?php

/* -----------------------------------------------------------------
 * 	$Id: account.php 480 2013-07-14 10:40:27Z akausch $
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

require_once (DIR_FS_INC . 'xtc_count_customer_orders.inc.php');
require_once (DIR_FS_INC . 'xtc_date_short.inc.php');
require_once (DIR_FS_INC . 'xtc_get_path.inc.php');
require_once (DIR_FS_INC . 'xtc_get_product_path.inc.php');
require_once (DIR_FS_INC . 'xtc_get_products_name.inc.php');
require_once (DIR_FS_INC . 'xtc_get_products_image.inc.php');

$breadcrumb->add(NAVBAR_TITLE_ACCOUNT, xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));

require_once (DIR_WS_INCLUDES . 'header.php');

if ($messageStack->size('account') > 0) {
    $smarty->assign('error_message', $messageStack->output('account'));
}

if (isset($_SESSION['tracking']['products_history'])) {
    $i = 0;
    $max = count($_SESSION['tracking']['products_history']);
    $row = 0;
    $module_content = array();
    while ($i < $max) {
        $row++;
        $product_history_query = xtDBquery("SELECT * FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd WHERE p.products_id=pd.products_id and pd.language_id='" . (int) $_SESSION['languages_id'] . "' AND p.products_status = '1' and p.products_id = '" . $_SESSION['tracking']['products_history'][$i] . "'");
        $history_product = xtc_db_fetch_array($product_history_query, true);
        $cpath = xtc_get_product_path($_SESSION['tracking']['products_history'][$i]);
        if ($history_product['products_status'] != 0) {
            $cpath = xtc_get_product_path($_SESSION['tracking']['products_history'][$i]);
            $history_product = array_merge($history_product, array('cat_url' => xtc_href_link(FILENAME_DEFAULT, 'cPath=' . $cpath)));
            $module_content[] = $product->buildDataArray($history_product, 'thumbnail', 'history_product', $row);
        }
        $i++;
    }
}

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('module_content', $module_content);
$smarty->assign('TITLE', HISTORY_PRODUCT);
$module = $smarty->fetch(CURRENT_TEMPLATE . '/module/product_listing/product_listings.html');

$smarty->assign('MODULE_products_history', $module);

$order_content = '';
if (xtc_count_customer_orders() > 0) {

    $orders_query = xtc_db_query("SELECT
									o.*,
									ot.text as order_total,
									s.orders_status_name
								FROM 
									" . TABLE_ORDERS . " o, 
									" . TABLE_ORDERS_TOTAL . " ot, 
									" . TABLE_ORDERS_STATUS . " s
								WHERE 
									o.customers_id = '" . (int) $_SESSION['customer_id'] . "'
								AND 
									o.orders_id = ot.orders_id
								AND 
									ot.class = 'ot_total'
								AND 
									o.orders_status = s.orders_status_id
								AND 
									s.language_id = '" . (int) $_SESSION['languages_id'] . "'
								ORDER BY orders_id DESC");

    while ($orders = xtc_db_fetch_array($orders_query)) {
        if (xtc_not_null($orders['delivery_name'])) {
            $order_name = $orders['delivery_name'];
            $order_country = $orders['delivery_country'];
        } else {
            $order_name = $orders['billing_name'];
            $order_country = $orders['billing_country'];
        }
        $order_content[] = array('ORDER_ID' => $orders['orders_id'],
            'ORDER_DATE' => xtc_date_short($orders['date_purchased']),
            'ORDER_STATUS' => $orders['orders_status_name'],
            'ORDER_TOTAL' => $orders['order_total'],
            'ORDER_LINK' => xtc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'SSL'),
            'ORDER_BUTTON' => '<a href="' . xtc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'SSL') . '">' . xtc_image_button('small_view.gif', SMALL_IMAGE_BUTTON_VIEW) . '</a>');
    }
}

$smarty->assign('LINK_EDIT', xtc_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'));
$smarty->assign('LINK_ADDRESS', xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
$smarty->assign('LINK_PASSWORD', xtc_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'));
$smarty->assign('LINK_DELETE', xtc_href_link(FILENAME_ACCOUNT_DELETE, '', 'SSL'));
if (!isset($_SESSION['customer_id'])) {
    $smarty->assign('LINK_LOGIN', xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
}

if (ACTIVATE_GIFT_SYSTEM == 'true') {
    $smarty->assign('ACTIVATE_GIFT', 'true');
}

// GV Code Start
if (isset($_SESSION['customer_id'])) {
    $gv_query = xtc_db_query("SELECT amount FROM " . TABLE_COUPON_GV_CUSTOMER . " WHERE customer_id = '" . (int) $_SESSION['customer_id'] . "'");
    $gv_result = xtc_db_fetch_array($gv_query);
    if ($gv_result['amount'] > 0) {
        $smarty->assign('GV_AMOUNT', $xtPrice->xtcFormat($gv_result['amount'], true, 0, true));
        $smarty->assign('GV_SEND_TO_FRIEND_LINK', '<a href="' . xtc_href_link(FILENAME_GV_SEND) . '">');
    }
}

$smarty->assign('LINK_ORDERS', xtc_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
$smarty->assign('LINK_NEWSLETTER', xtc_href_link(FILENAME_NEWSLETTER, '', 'SSL'));
$smarty->assign('LINK_ALL', xtc_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
$smarty->assign('order_content', $order_content);
$smarty->assign('also_purchased_history', $also_purchased_history);

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('DEVMODE', USE_TEMPLATE_DEVMODE);
$smarty->caching = false;

$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/account.html');
$smarty->assign('main_content', $main_content);

$smarty->display(CURRENT_TEMPLATE . '/index.html');

include ('includes/application_bottom.php');
