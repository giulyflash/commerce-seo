<?php

/* -----------------------------------------------------------------
 * 	ID:						products_new.php
 * 	Letzter Stand:			v2.3
 * 	zuletzt geaendert von:	cseoak
 * 	Datum:					2012/11/19
 *
 * 	Copyright (c) since 2010 commerce:SEO by Webdesign Erfurt
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
// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');

// include needed function
require_once (DIR_FS_INC . 'xtc_date_long.inc.php');
require_once (DIR_FS_INC . 'xtc_get_vpe_name.inc.php');

$breadcrumb->add(NAVBAR_TITLE_PRODUCTS_NEW, xtc_href_link(FILENAME_PRODUCTS_NEW));

require (DIR_WS_INCLUDES . 'header.php');

$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
    $fsk_lock = ' AND p.products_fsk18!=1';
}
if (GROUP_CHECK == 'true') {
    $group_check = " AND p.group_permission_" . $_SESSION['customers_status']['customers_status_id'] . "=1 ";
}
if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0') {
    $date_new_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - MAX_DISPLAY_NEW_PRODUCTS_DAYS, date(Y)));
    $days = " AND p.products_date_added > '" . $date_new_products . "' ";
}
if ($_GET['multisort'] == 'specialprice' || $_GET['multisort'] == 'new_asc' || $_GET['multisort'] == 'new_desc' || $_GET['multisort'] == 'name_asc' || $_GET['multisort'] == 'name_desc' || $_GET['multisort'] == 'price_asc' || $_GET['multisort'] == 'price_desc' || $_GET['multisort'] == 'manu_asc' || $_GET['multisort'] == 'manu_desc') {
	switch ($_GET['multisort']) {
		case 'new_asc':
			$order_str = ' GROUP BY p.products_id ORDER BY p.products_date_added ASC';
			break;
		case 'new_desc':
			$order_str = ' GROUP BY p.products_id ORDER BY p.products_date_added DESC';
			break;
		case 'name_asc':
			$order_str = ' GROUP BY p.products_id ORDER BY pd.products_name ASC';
			break;
		case 'name_desc':
			$order_str = ' GROUP BY p.products_id ORDER BY pd.products_name DESC';
			break;
		case 'price_asc':
			$order_str = ' GROUP BY p.products_id ORDER BY p.products_price ASC';
			break;
		case 'price_desc':
			$order_str = ' GROUP BY p.products_id ORDER BY p.products_price DESC';
			break;
		case 'manu_asc':
			$from_str .= ' INNER JOIN ' . TABLE_MANUFACTURERS . ' AS m ON ( p.manufacturers_id = m.manufacturers_id )';
			$order_str = ' GROUP BY p.products_id ORDER BY m.manufacturers_name ASC';
			break;
		case 'manu_desc':
			$from_str .= ' INNER JOIN ' . TABLE_MANUFACTURERS . ' AS m ON ( p.manufacturers_id = m.manufacturers_id )';
			$order_str = ' GROUP BY p.products_id ORDER BY m.manufacturers_name DESC';
			break;
		case 'specialprice':
			$from_str .= " INNER JOIN " . TABLE_SPECIALS . " AS s ON (p.products_id = s.products_id) AND s.status = '1'";
			$order_str = ' GROUP BY p.products_id ORDER BY s.specials_new_products_price DESC';
			break;
		default:
			$order_str = ' GROUP BY p.products_id ORDER BY p.products_date_added DESC';
	}
} else {
	$order_str = ' GROUP BY p.products_id ORDER BY p.products_date_added DESC';
}

$products_new_query_raw = "SELECT DISTINCT
                                    p.*,
                                    pd.*
                                    FROM 
										" . TABLE_PRODUCTS . " p
                                    INNER JOIN 
										" . TABLE_PRODUCTS_DESCRIPTION . " pd ON(p.products_id = pd.products_id AND pd.language_id = '" . (int) $_SESSION['languages_id'] . "')
									INNER JOIN
										" . TABLE_PRODUCTS_TO_CATEGORIES . " p2c ON(p.products_id = p2c.products_id)
									INNER JOIN
										" . TABLE_CATEGORIES . " c ON(c.categories_id = p2c.categories_id AND c.categories_status = 1)
									" . $from_str . "
                                    WHERE 
										p.products_status = '1'
									AND 
										(p.products_slave_in_list = '1' OR p.products_master = '1' OR ((p.products_slave_in_list = '0' OR p.products_slave_in_list = '') AND (p.products_master_article = '' OR p.products_master_article = '0')))
                                    " . $group_check . " 
                                    " . $fsk_lock . "                                  
                                    " . $days . " 
                                    " . $order_str;

if(PRODUCT_LIST_FILTER_SORT == 'true') {
	$multisort_dropdown = xtc_draw_form('multisort', 'products_new.php', 'get') . "\n";
	$options = array(
		array('text' => MULTISORT_STANDARD));
	$options[] =
			array('id' => 'specialprice',
				'text' => MULTISORT_SPECIALS_DESC);
	$options[] =
			array('id' => 'new_desc',
				'text' => MULTISORT_NEW_DESC);
	$options[] =
			array('id' => 'new_asc',
				'text' => MULTISORT_NEW_ASC);
	$options[] =
			array('id' => 'price_asc',
				'text' => MULTISORT_PRICE_ASC);
	$options[] =
			array('id' => 'price_desc',
				'text' => MULTISORT_PRICE_DESC);
	$options[] =
			array('id' => 'name_asc',
				'text' => MULTISORT_ABC_AZ);
	$options[] =
			array('id' => 'name_desc',
				'text' => MULTISORT_ABC_ZA);
	$options[] =
			array('id' => 'manu_asc',
				'text' => MULTISORT_MANUFACTURER_ASC);
	$options[] =
			array('id' => 'manu_desc',
				'text' => MULTISORT_MANUFACTURER_DESC);


	$multisort_dropdown .= xtc_draw_pull_down_menu('multisort', $options, $_GET['multisort'], 'onchange="this.form.submit()"') . "\n";
	$multisort_dropdown .= '</form>' . "\n";
	$smarty->assign('MULTISORT_DROPDOWN', $multisort_dropdown);
}

if (isset($_GET['per_site']) && !empty($_GET['per_site']))
    $per_site = $_GET['per_site'];
elseif (isset($_SESSION['per_site']))
    $per_site = $_SESSION['per_site'];
elseif (!isset($_SESSION['per_site']) || !isset($_GET['per_site']))
    $per_site = MAX_DISPLAY_SEARCH_RESULTS;

$_SESSION['per_site'] = $per_site;

$listing_split = new splitPageResults($products_new_query_raw, (int) $_GET['page'], (int) $_SESSION['per_site']);
if ($listing_split->number_of_rows == 0)
    xtc_redirect(xtc_href_link(FILENAME_DEFAULT));

if (($listing_split->number_of_rows > 0)) {
    $navigation_smarty = new Smarty;
    $page_links = $listing_split->getLinksArrayProductsNew(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array('page', 'info', 'x', 'y')), TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW);
    $navigation_smarty->assign('COUNT', $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW));
    $navigation_smarty->assign('LINKS', $page_links);
    $navigation_smarty->assign('language', $_SESSION['language']);
    $navigation_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
    $navigation = $navigation_smarty->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_page_navigation.html');
}

$file_name = FILENAME_PRODUCTS_NEW;


switch ($getCols['col']) {
    case '3' :
        $view_per_site = ($per_site == 9 ? '<b>9</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=9' . $get_param) . '">9</a>') . ' | ';
        $view_per_site .= ($per_site == 18 ? '<b>18</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=18' . $get_param) . '">18</a>') . ' | ';
        $view_per_site .= ($per_site == 27 ? '<b>27</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=27' . $get_param) . '">27</a>') . ' | ';
        $view_per_site .= ($per_site == 45 ? '<b>45</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=45' . $get_param) . '">45</a>') . ' | ';
        $view_per_site .= ($per_site == 81 ? '<b>81</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=81' . $get_param) . '">81</a>');
        break;

    case '4' :
        $view_per_site = ($per_site == 12 ? '<b>12</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=12' . $get_param) . '">12</a>') . ' | ';
        $view_per_site .= ($per_site == 24 ? '<b>24</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=24' . $get_param) . '">24</a>') . ' | ';
        $view_per_site .= ($per_site == 60 ? '<b>60</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=60' . $get_param) . '">60</a>') . ' | ';
        $view_per_site .= ($per_site == 84 ? '<b>84</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=84' . $get_param) . '">84</a>') . ' | ';
        $view_per_site .= ($per_site == 96 ? '<b>96</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=96' . $get_param) . '">96</a>');
        break;

    default :
        $view_per_site = ($per_site == 10 ? '<b>10</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=10' . $get_param) . '">10</a>') . ' | ';
        $view_per_site .= ($per_site == 20 ? '<b>20</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=20' . $get_param) . '">20</a>') . ' | ';
        $view_per_site .= ($per_site == 30 ? '<b>30</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=30' . $get_param) . '">30</a>') . ' | ';
        $view_per_site .= ($per_site == 50 ? '<b>50</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=50' . $get_param) . '">50</a>') . ' | ';
        $view_per_site .= ($per_site == 100 ? '<b>100</b>' : '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'per_site=100' . $get_param) . '">100</a>');
        break;
}

$per_site_html = new Smarty;
$per_site_html->assign('LINKS_PER_SITE', $view_per_site);
$per_site_html->assign('language', $_SESSION['language']);
$products_persite = $per_site_html->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_per_site.html');


$module_content = '';
if ($listing_split->number_of_rows > 0) {
    $products_new_query = xtDBquery($listing_split->sql_query);
    $i = 0;
    while ($products_new = xtc_db_fetch_array($products_new_query)) {
        $i++;
        $module_content[] = $product->buildDataArray($products_new, 'thumbnail', 'new_products_overview', $i);
    }
} else {
    $smarty->assign('ERROR', TEXT_NO_NEW_PRODUCTS);
}

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = false;
$smarty->assign('module_content', $module_content);
$smarty->assign('PRODUCTS_PER_SITE', $products_persite);
$smarty->assign('NAVIGATION', $navigation);
$smarty->assign('TITLE', NEW_PRODUCTS_OVERVIEW);

$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/product_listing/product_listings.html');

$smarty->assign('main_content', $main_content);

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = false;

$smarty->display(CURRENT_TEMPLATE . '/index.html');

include ('includes/application_bottom.php');
