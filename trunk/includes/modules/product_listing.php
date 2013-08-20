<?php

/* -----------------------------------------------------------------
 * 	$Id: product_listing.php 486 2013-07-15 22:08:14Z akausch $
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

$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');

$result = true;
// include needed functions
require_once (DIR_FS_INC . 'xtc_get_all_get_params.inc.php');
require_once (DIR_FS_INC . 'xtc_get_vpe_name.inc.php');

if (isset($_GET['per_site']) && !empty($_GET['per_site'])) {
    $per_site = $_GET['per_site'];
} elseif (isset($_SESSION['per_site'])) {
    $per_site = $_SESSION['per_site'];
} elseif (!isset($_SESSION['per_site']) || !isset($_GET['per_site'])) {
    $per_site = MAX_DISPLAY_SEARCH_RESULTS;
}

$_SESSION['per_site'] = $per_site;

$listing_split = new splitPageResults($listing_sql, (int) $_GET['page'], (int) $per_site, 'p.products_id');

if ($_GET['view_as'] != '') {
    $list_name = $_GET['view_as'];
    $_SESSION['view_as'] = $_GET['view_as'];
} elseif ($_SESSION['view_as'] != '') {
    $list_name = $_SESSION['view_as'];
} elseif (!isset($_SESSION['view_as']) || !isset($_GET['view_as'])) {
    $list_name = 'product_listing_list';
    $_SESSION['view_as'] = 'product_listing_list';
}

$module_content = array();

if ($listing_split->number_of_rows > 0) {
    $navigation_smarty = new Smarty;

    if (isset($_GET['keywords']) && !isset($_GET['manufacturers_id']))
        $file_name = FILENAME_ADVANCED_SEARCH_RESULT;
    else
        $file_name = FILENAME_DEFAULT;

    if (isset($_GET['multisort']) && !empty($_GET['multisort']))
        $get_param = '&multisort=' . $_GET['multisort'];

    if (isset($_GET['filter_id']) && $_GET['filter_id'] != '')
        $get_param .= '&filter_id=' . $_GET['filter_id'];

    if (isset($_GET['keywords']) || isset($_GET['manufactures_id'])) {
        $page_links = $listing_split->getLinksArraySearch(MAX_DISPLAY_PAGE_LINKS, $get_param, TEXT_DISPLAY_NUMBER_OF_PRODUCTS);
    } elseif (MODULE_COMMERCE_SEO_INDEX_STATUS == 'True') {
        $page_links = $listing_split->getSEOLinksArray(MAX_DISPLAY_PAGE_LINKS, $get_param, TEXT_DISPLAY_NUMBER_OF_PRODUCTS);
    } else {
        $page_links = $listing_split->getLinksArray(MAX_DISPLAY_PAGE_LINKS, $get_param, TEXT_DISPLAY_NUMBER_OF_PRODUCTS);
    }

    $navigation_smarty->assign('COUNT', $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS));
    $navigation_smarty->assign('LINKS', $page_links);
    $navigation_smarty->assign('language', $_SESSION['language']);
    $navigation_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
    $navigation = $navigation_smarty->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_page_navigation.html');

    if (GROUP_CHECK == 'true')
        $group_check = " AND c.group_permission_" . $_SESSION['customers_status']['customers_status_id'] . "='1';";

    $category = xtc_db_fetch_array(xtDBquery("SELECT DISTINCT
                                	cd.*,
                                	c.*
								FROM
									" . TABLE_CATEGORIES . " c
								INNER JOIN 
									" . TABLE_CATEGORIES_DESCRIPTION . " cd ON (cd.categories_id = '" . (int) $current_category_id . "' AND cd.language_id = '" . (int) $_SESSION['languages_id'] . "')
                                WHERE
									c.categories_id = '" . (int) $current_category_id . "'" .
								$group_check));

    $image = '';
    if ($category['categories_image'] != '') {
        $image = xtc_image(DIR_WS_IMAGES . 'categories_info/' . $category['categories_image'], ($category['categories_heading_title'] != '' ? $category['categories_heading_title'] : $category['categories_name']), ($category['categories_pic_alt'] != '' ? $category['categories_pic_alt'] : $category['categories_name']));
        if (!file_exists(DIR_WS_IMAGES . 'categories_info/' . $category['categories_image'])) {
            $image = xtc_image(DIR_WS_IMAGES . 'categories_info/noimage.gif', ($category['categories_heading_title'] != '' ? $category['categories_heading_title'] : $category['categories_name']), ($category['categories_pic_alt'] != '' ? $category['categories_pic_alt'] : $category['categories_name']));
		}
    }
    $image_footer = '';
    if ($category['categories_footer_image'] != '') {
        $image_footer = xtc_image( DIR_WS_IMAGES . 'categories_footer/' . $category['categories_footer_image'], ($category['categories_heading_title'] != '' ? $category['categories_heading_title'] : $category['categories_name']), ($category['categories_pic_footer_alt'] != '' ? $category['categories_pic_footer_alt'] : $category['categories_name']));
	}

    $module_smarty->assign('CATEGORIES_NAME', $category['categories_name']);
    $module_smarty->assign('CATEGORIES_HEADING_TITLE', $category['categories_heading_title']);
    $module_smarty->assign('CATEGORIES_IMAGE', $image);
    $module_smarty->assign('CATEGORIES_FOOTER_IMAGE', $image_footer);

    //Kategoriebeschreibung beim blaettern raus
    if (!isset($_GET['page']) || $_GET['page'] == '1') {
        $module_smarty->assign('CATEGORIES_DESCRIPTION', $category['categories_description']);
        $module_smarty->assign('CATEGORIES_DESCRIPTION_FOOTER', $category['categories_description_footer']);
    }

    //Hersteller Ausgabe
    if ($_SESSION['MANUFACTURES_SORTBOX_IS_IN_USE'] == true) {
        $manRes = xtc_db_fetch_array(xtDBquery("SELECT 
									m.manufacturers_id, 
									m.manufacturers_name, 
									m.manufacturers_image, 
									mi.manufacturers_description 
								FROM 
									" . TABLE_MANUFACTURERS . " AS m
									INNER JOIN " . TABLE_MANUFACTURERS_INFO . " AS mi ON(mi.manufacturers_id = m.manufacturers_id AND mi.languages_id = '".(int) $_SESSION['languages_id'] ."') 
								WHERE 
									m.manufacturers_id = '" . (int) $_GET['manufacturers_id'] . "';"));

        $module_smarty->assign("MANUFACTURERS_NAME", $manRes['manufacturers_name']);
        $module_smarty->assign("MANUFACTURERS_DESCRIPTION", $manRes['manufacturers_description']);
        if ($manRes['manufacturers_image'] != NULL)
            $module_smarty->assign("MANUFACTURERS_IMAGE", xtc_image(DIR_WS_IMAGES . $manRes['manufacturers_image'], $manRes['manufacturers_name'], $manRes['manufacturers_name']));
        unset($_SESSION['MANUFACTURES_SORTBOX_IS_IN_USE']);
    }

    $listing_query = xtDBquery($listing_split->sql_query);
    $rows = 0;
    while ($listing = xtc_db_fetch_array($listing_query, true)) {
        $rows++;
        $module_content[] = $product->buildDataArray($listing, 'thumbnail', $list_name, $rows);
    }
} else {
    //Keine Produkte, Kategoriebeschreibung wird aber trotzdem ausgegeben
    if (GROUP_CHECK == 'true')
        $group_check = " AND c.group_permission_" . $_SESSION['customers_status']['customers_status_id'] . "='1';";

    $category = xtc_db_fetch_array(xtDBquery("SELECT DISTINCT
                                	cd.*,
                                	c.*
								FROM
									" . TABLE_CATEGORIES . " c
								INNER JOIN 
									" . TABLE_CATEGORIES_DESCRIPTION . " cd ON (cd.categories_id = '" . (int) $current_category_id . "' AND cd.language_id = '" . (int) $_SESSION['languages_id'] . "')
                                WHERE
									c.categories_id = '" . (int) $current_category_id . "'" .
								$group_check));
    $image = '';
    if ($category['categories_image'] != '') {
        $image = xtc_image(DIR_WS_IMAGES . 'categories_info/' . $category['categories_image'], ($category['categories_pic_alt'] != '' ? $category['categories_pic_alt'] : $category['categories_name']), ($category['categories_heading_title'] != '' ? $category['categories_heading_title'] : $category['categories_name']));
        if (!file_exists(DIR_WS_IMAGES . 'categories_info/' . $category['categories_image'])) {
            $image = xtc_image(DIR_WS_IMAGES . 'categories_info/noimage.gif', ($category['categories_pic_alt'] != '' ? $category['categories_pic_alt'] : $category['categories_name']), ($category['categories_heading_title'] != '' ? $category['categories_heading_title'] : $category['categories_name']));
		}
    }
    $image_footer = '';
    if ($category['categories_footer_image'] != '') {
        $image_footer = xtc_image( DIR_WS_IMAGES . 'categories_footer/' . $category['categories_footer_image'], ($category['categories_pic_footer_alt'] != '' ? $category['categories_pic_footer_alt'] : $category['categories_name']), ($category['categories_heading_title'] != '' ? $category['categories_heading_title'] : $category['categories_name']));
	}

    $module_smarty->assign('CATEGORIES_NAME', $category['categories_name']);
    $module_smarty->assign('CATEGORIES_HEADING_TITLE', $category['categories_heading_title']);
    $module_smarty->assign('CATEGORIES_IMAGE', $image);
    $module_smarty->assign('CATEGORIES_FOOTER_IMAGE', $image_footer);
    $module_smarty->assign('CATEGORIES_DESCRIPTION', $category['categories_description']);
    $module_smarty->assign('CATEGORIES_DESCRIPTION_FOOTER', $category['categories_description_footer']);

    $result = false;
}


if ($result != false) {
    $module_smarty->assign('manufacturer', $manufacturer_dropdown);
    $module_smarty->assign('language', $_SESSION['language']);
    $module_smarty->assign('module_content', $module_content);

    $module_smarty->assign('multisort', $multisort_dropdown);
    $getCols = xtc_db_fetch_array(xtDBquery("SELECT col FROM products_listings WHERE list_name ='" . $list_name . "'"));

    if (isset($_GET['page']) && $_GET['page'] != '')
        $page .= '&page=' . $_GET['page'];


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

    switch ($list_name) {
        case 'product_listing_list' :
            $views_as = '<a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'view_as=product_listing_grid' . $get_param) . '">' . LISTING_GALLERY . '</a> ' . LISTING_LIST_ACTIVE;
            break;
        default :
            $views_as = LISTING_GALLERY_ACTIVE . ' <a rel="nofollow" href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as')) . 'view_as=product_listing_list' . $get_param) . '">' . LISTING_LIST . '</a>';
            break;
    }

    $view = new Smarty;
    $view->assign('LINKS_VIEW_AS', $views_as);
    $view->assign('language', $_SESSION['language']);
    $views = $view->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_view_as.html');
    $multisort = $module_smarty->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_multisort.html');
    $manufacturer = $module_smarty->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_manufacturer_sort.html');


    $module_smarty->assign('MANUFACTURER_DROPDOWN', $manufacturer);
    $module_smarty->assign('MULTISORT_DROPDOWN', $multisort);
    $module_smarty->assign('PRODUCTS_VIEW_AS', $views);
    $module_smarty->assign('PRODUCTS_PER_SITE', $products_persite);
    $module_smarty->assign('NAVIGATION', $navigation);
    $module_smarty->assign('CLASS', 'product_listing');
    $module_smarty->assign('ONLY_ONE', $_SESSION['col_special_class']);
    $module_smarty->assign('language', $_SESSION['language']);
	$module_smarty->assign('DEVMODE', USE_TEMPLATE_DEVMODE);
    if (!empty($keywords)) {
        $module_smarty->assign('KEYWORDS', sprintf(SEARCH_RESULTS_WORDS, $keywords, $listing_split->number_of_rows));
    }
    if ($category['listing_template'] == 'default' || $category['listing_template'] == '') {
        $category['listing_template'] = 'product_listings.html';
    }

    if (!CacheCheck()) {
        $module_smarty->caching = false;
        $module = $module_smarty->fetch(CURRENT_TEMPLATE . '/module/product_listing/' . $category['listing_template']);
    } else {
        $module_smarty->caching = true;
        $module_smarty->cache_lifetime = CACHE_LIFETIME;
        $module_smarty->cache_modified_check = CACHE_CHECK;
        $cache_id = $current_category_id . '_' . $_SESSION['language'] . '_' . $_SESSION['customers_status']['customers_status_name'] . '_' . $_SESSION['currency'] . '_' . $_GET['manufacturers_id'] . '_' . $_GET['filter_id'] . '_' . $_GET['page'] . '_' . $_GET['keywords'] . '_' . $_GET['categories_id'] . '_' . $_GET['pfrom'] . '_' . $_GET['pto'] . '_' . $_GET['x'] . '_' . $_GET['y'] . '_' . $_GET['multisort'] . '_' . $_GET['manufactures_id'] . '_' . $_SESSION['view_as'] . '_' . $_SESSION['per_site'] . '_' . $_GET['page'];
        $module = $module_smarty->fetch(CURRENT_TEMPLATE . '/module/product_listing/' . $category['listing_template'], $cache_id);
    }
    $smarty->assign('main_content', $module);
} else {
    $error = TEXT_PRODUCT_NOT_FOUND;
    include (DIR_WS_MODULES . FILENAME_ERROR_HANDLER);
}
