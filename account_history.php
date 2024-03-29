<?php

/* -----------------------------------------------------------------
 * 	$Id: account_history.php 420 2013-06-19 18:04:39Z akausch $
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
require_once (DIR_FS_INC . 'xtc_image_button.inc.php');
require_once (DIR_FS_INC . 'xtc_get_all_get_params.inc.php');

if (!isset($_SESSION['customer_id'])) {
    xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
}

$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_HISTORY, xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_HISTORY, xtc_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));

require_once (DIR_WS_INCLUDES . 'header.php');

$module_content = array();
if (($orders_total = xtc_count_customer_orders()) > 0) {
    $history_query_raw = "SELECT o.orders_id, o.date_purchased, o.delivery_name, o.billing_name, ot.text as order_total, s.orders_status_name FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS_STATUS . " s WHERE o.customers_id = '" . (int) $_SESSION['customer_id'] . "' AND o.orders_id = ot.orders_id AND ot.class = 'ot_total' AND o.orders_status = s.orders_status_id AND s.language_id = '" . (int) $_SESSION['languages_id'] . "' ORDER BY orders_id DESC";
    $history_split = new splitPageResults($history_query_raw, $_GET['page'], MAX_DISPLAY_ORDER_HISTORY);
    $history_query = xtc_db_query($history_split->sql_query);

    while ($history = xtc_db_fetch_array($history_query)) {
        $products_query = xtc_db_query("SELECT count(*) AS count FROM " . TABLE_ORDERS_PRODUCTS . " WHERE orders_id = '" . (int) $history['orders_id'] . "'");
        $products = xtc_db_fetch_array($products_query);

        if (xtc_not_null($history['delivery_name'])) {
            $order_type = TEXT_ORDER_SHIPPED_TO;
            $order_name = $history['delivery_name'];
        } else {
            $order_type = TEXT_ORDER_BILLED_TO;
            $order_name = $history['billing_name'];
        }
        $module_content[] = array('ORDER_ID' => $history['orders_id'],
            'ORDER_STATUS' => $history['orders_status_name'],
            'ORDER_DATE' => xtc_date_short($history['date_purchased']),
            'ORDER_PRODUCTS' => $products['count'],
            'ORDER_TOTAL' => strip_tags($history['order_total']),
            'ORDER_BUTTON' => '<a href="' . xtc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $history['orders_id'] . '&page=' . (empty($_GET['page']) ? "1" : (int) $_GET['page']), 'SSL') . '">' . xtc_image_button('small_view.gif', SMALL_IMAGE_BUTTON_VIEW) . '</a>');
    }
}

if ($orders_total > 0) {
    $navigation_smarty = new Smarty;
    $page_links = $history_split->getLinksArray(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array('page', 'info', 'x', 'y', 'cat', 'cPath', 'per_site', 'view_as')), TEXT_DISPLAY_NUMBER_OF_ORDERS);

    $navigation_smarty->assign('COUNT', $history_split->display_count(TEXT_DISPLAY_NUMBER_OF_ORDERS));
    $navigation_smarty->assign('LINKS', $page_links);
    $navigation_smarty->assign('language', $_SESSION['language']);
    $navigation_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
    $navigation = $navigation_smarty->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_page_navigation.html');
}
$smarty->assign('navigation', $navigation);
$smarty->assign('order_content', $module_content);

$smarty->assign('BUTTON_BACK', '<a href="' . xtc_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>');

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = false;

$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/account_history.html');

$smarty->assign('main_content', $main_content);

$smarty->display(CURRENT_TEMPLATE . '/index.html');

include ('includes/application_bottom.php');
