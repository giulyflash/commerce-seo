<?php

/* -----------------------------------------------------------------
 * 	$Id: specials.php 452 2013-07-03 12:42:36Z akausch $
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

// require_once (DIR_FS_INC.'xtc_get_short_description.inc.php');

$breadcrumb->add(NAVBAR_TITLE_SPECIALS, xtc_href_link(FILENAME_SPECIALS));

if ($_SESSION['customers_status']['customers_fsk18_display'] == '0')
    $fsk_lock = ' AND p.products_fsk18 != 1';

if (GROUP_CHECK == 'true')
    $group_check = " AND p.group_permission_" . $_SESSION['customers_status']['customers_status_id'] . " = 1 ";

$specials_query_raw = "SELECT 
						p.*,
                        pd.*,
                        s.specials_new_products_price 
					FROM 
						" . TABLE_PRODUCTS . " p
					LEFT JOIN
						" . TABLE_PRODUCTS_DESCRIPTION . " pd ON(p.products_id = pd.products_id AND pd.language_id = '" . (int) $_SESSION['languages_id'] . "') 
					LEFT JOIN
						" . TABLE_SPECIALS . " s ON(s.products_id = p.products_id)
                    WHERE 
						p.products_status = '1'
                        " . $group_check . "
                        " . $fsk_lock . "
                    AND 
						s.status = '1' 
					ORDER BY 
						s.specials_date_added DESC";

if (isset($_GET['per_site']) && !empty($_GET['per_site']))
    $per_site = $_GET['per_site'];
elseif (isset($_SESSION['per_site']))
    $per_site = $_SESSION['per_site'];
elseif (!isset($_SESSION['per_site']) || !isset($_GET['per_site']))
    $per_site = MAX_DISPLAY_SEARCH_RESULTS;

$_SESSION['per_site'] = $per_site;

$listing_split = new splitPageResults($specials_query_raw, $_GET['page'], (int) $_SESSION['per_site']);
if (($listing_split->number_of_rows > 0)) {
    $navigation_smarty = new Smarty;
    $page_links = $listing_split->getLinksArraySpecials(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array('page', 'info', 'x', 'y')), TEXT_DISPLAY_NUMBER_OF_PRODUCTS);
    $navigation_smarty->assign('COUNT', $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS));
    $navigation_smarty->assign('LINKS', $page_links);
    $navigation_smarty->assign('language', $_SESSION['language']);
    $navigation_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
    $navigation = $navigation_smarty->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_page_navigation.html');
}


$file_name = FILENAME_SPECIALS;

$getCols = xtc_db_fetch_array(xtDBquery("SELECT col FROM products_listings WHERE list_name ='specials'"));

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

$module_content = array();
$row = 0;
if ($listing_split->number_of_rows == 0)
    xtc_redirect(xtc_href_link(FILENAME_DEFAULT));

require (DIR_WS_INCLUDES . 'header.php');
$specials_query = xtc_db_query($listing_split->sql_query);
$i = 0;
while ($specials = xtc_db_fetch_array($specials_query)) {
    $i++;
    $module_content[] = $product->buildDataArray($specials, 'thumbnail', 'specials', $i);
}

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('module_content', $module_content);
$smarty->assign('TITLE', SPECIALS);
$smarty->assign('PRODUCTS_PER_SITE', $products_persite);
$smarty->assign('NAVIGATION', $navigation);
$smarty->caching = false;
$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/product_listing/product_listings.html');

$smarty->assign('sonderangebote', 'true');
$smarty->assign('main_content', $main_content);
$smarty->caching = false;
$smarty->display(CURRENT_TEMPLATE . '/index.html');

include ('includes/application_bottom.php');
