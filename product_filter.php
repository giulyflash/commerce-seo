<?php

/* -----------------------------------------------------------------
 * 	$Id: product_filter.php 420 2013-06-19 18:04:39Z akausch $
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
$breadcrumb->add(NAVBAR_TITLE_PRODUCT_FILTER, xtc_href_link(FILENAME_PRODUCT_FILTER, '', 'NONSSL'));
require (DIR_WS_INCLUDES . 'header.php');
$smarty->assign('language', $_SESSION['language']);

if (( isset($_GET['fcat']) && is_numeric($_GET['fcat'])) && ( isset($_GET['item']) && is_numeric($_GET['item']))) {

    $module_smarty = new Smarty;
    $module_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');

    if ($_SESSION['customers_status']['customers_fsk18_display'] == '0')
        $fsk_lock = " AND p.products_fsk18 != '1' ";
    else
        unset($fsk_lock);

    if (GROUP_CHECK == 'true')
        $group_check = " AND p.group_permission_" . $_SESSION['customers_status']['customers_status_id'] . "=1 ";
    else
        unset($group_check);

    $select_str = "SELECT DISTINCT
                  p.products_id,
                  p.products_price,
                  p.products_model,
                  p.products_quantity,
                  p.products_shippingtime,
                  p.products_fsk18,
                  p.products_image,
                  p.products_weight,
                  p.products_tax_class_id,
                  pd.products_name,
                  pd.products_short_description,
                  pd.products_description ";

    $from_str = "FROM
    				products_to_filter p2f, " . TABLE_PRODUCTS . " AS p LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " AS pd ON (p.products_id = pd.products_id) ";

    $where_str = " WHERE
    					p2f.filter_id = '" . (int) $_GET['item'] . "'
    				AND
    					p.products_id = p2f.products_id
    				AND
    					p.products_status = '1' 
    				AND
    					pd.language_id = '" . (int) $_SESSION['languages_id'] . "'" . $fsk_lock . $group_check;

    $smarty->caching = 0;
    $smarty->assign('language', $_SESSION['language']);

    $select_item_query = xtc_db_query("SELECT
    									fi_i.title AS item_title, fi_c.titel AS cat_title
								      FROM
								      	" . TABLE_PRODUCT_FILTER_ITEMS . " fi_i,
								      	" . TABLE_PRODUCT_FILTER_CATEGORIES . " fi_c
								      WHERE
								      	fi_i.status = 1
								      AND
								      	fi_c.status = 1
								      AND
								      	fi_i.id = '" . (int) $_GET['item'] . "'
								      AND
								      	fi_i.filter_categories_id = '" . (int) $_GET['fcat'] . "'
								      AND
								      	fi_c.id = fi_i.filter_categories_id 
								      AND
								      	fi_i.language_id = '" . $_SESSION['languages_id'] . "'
								      AND
								      	fi_c.language_id = fi_i.language_id");

    $select_item = xtc_db_fetch_array($select_item_query);

    $listing_sql = $select_str . $from_str . $where_str;

    if (isset($_GET['per_site']) && !empty($_GET['per_site']))
        $per_site = $_GET['per_site'];
    elseif (isset($_SESSION['per_site']))
        $per_site = $_SESSION['per_site'];
    elseif (!isset($_SESSION['per_site']) || !isset($_GET['per_site']))
        $per_site = MAX_DISPLAY_SEARCH_RESULTS;

    $_SESSION['per_site'] = $per_site;

    if ($_GET['view_as'] != '') {
        $list_name = $_GET['view_as'];
        $_SESSION['view_as'] = $_GET['view_as'];
    } elseif ($_SESSION['view_as'] != '')
        $list_name = $_SESSION['view_as'];

    elseif (!isset($_SESSION['view_as']) || !isset($_GET['view_as'])) {
        $list_name = 'product_listing_list';
        $_SESSION['view_as'] = 'product_listing_list';
    }

    $listing_split = new splitPageResults($listing_sql, (int) $_GET['page'], (int) $_SESSION['per_site'], 'p.products_id');
    $module_content = array();

    $navigation_smarty = new Smarty;
    $page_links = $listing_split->getLinksArray(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array('page', 'info', 'x', 'y', 'cPath', 'cat', 'per_site', 'view_as')), TEXT_DISPLAY_NUMBER_OF_PRODUCTS);

    $navigation_smarty->assign('LINKS', $page_links);
    $navigation_smarty->assign('language', $_SESSION['language']);
    $navigation_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
    $navigation = $navigation_smarty->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_page_navigation.html');

    $listing_query = xtDBquery($listing_split->sql_query);
    $rows = 0;
    while ($listing = xtc_db_fetch_array($listing_query, true)) {
        $rows++;
        $module_content[] = $product->buildDataArray($listing, 'thumbnail', $list_name, $rows);
    }

    $link = xtc_href_link(FILENAME_PRODUCT_FILTER, xtc_get_all_get_params(array('view_as', 'per_site', 'x', 'y', 'cat', 'cPath')));

    $module_smarty->assign('products_listing_url', $link);

    if ($name != '')
        $module_smarty->assign('filter_request', $namen);

    $module_smarty->assign('language', $_SESSION['language']);

    if (!empty($module_content)) {
        $module_smarty->assign('module_content', $module_content);
        $module_smarty->assign('CATEGORIES_DESCRIPTION', 'Das passende Produkt ist nicht dabei? Versuchen Sie unseren <a rel="nofollow" href="' . xtc_href_link('product_filter.php', 'advanced_filter=' . $_GET['category']) . '">erweiterten Filter</a>.');
        $module_smarty->assign('CATEGORIES_HEADING_TITLE', 'Alle Treffer f&uuml;r <em>' . $select_item['item_title'] . '</em> aus der Kategorie <em>' . $select_item['cat_title'] . '</em>');
        $products_persite = $module_smarty->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_per_site.html');
        $view = $module_smarty->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_view_as.html');

        $module_smarty->assign('PRODUCTS_VIEW_AS', $view);
        $module_smarty->assign('PRODUCTS_PER_SITE', $products_persite);
        $module_smarty->assign('NAVIGATION', $navigation);
    }
    else
        $module_smarty->assign('CATEGORIES_HEADING_TITLE', 'F&uuml;r <em>' . $select_item['item_title'] . '</em> wurde kein Produkt gefunden / zugewiesen.');

    $module_smarty->caching = 0;
    $main_content = $module_smarty->fetch(CURRENT_TEMPLATE . '/module/product_listing/product_listings.html');
} elseif (isset($_GET['advanced_filter'])) {

    if (isset($_GET['per_site']) && !empty($_GET['per_site']))
        $per_site = $_GET['per_site'];
    elseif (isset($_SESSION['per_site']))
        $per_site = $_SESSION['per_site'];
    elseif (!isset($_SESSION['per_site']) || !isset($_GET['per_site']))
        $per_site = MAX_DISPLAY_SEARCH_RESULTS;

    $_SESSION['per_site'] = $per_site;

    if ($_GET['view_as'] != '') {
        $list_name = $_GET['view_as'];
        $_SESSION['view_as'] = $_GET['view_as'];
    } elseif ($_SESSION['view_as'] != '')
        $list_name = $_SESSION['view_as'];

    elseif (!isset($_SESSION['view_as']) || !isset($_GET['view_as'])) {
        $list_name = 'product_listing_list';
        $_SESSION['view_as'] = 'product_listing_list';
    }

    $filter_array = array();

    $cat_count = xtc_db_query("SELECT id, titel, categories_ids FROM " . TABLE_PRODUCT_FILTER_CATEGORIES . " WHERE language_id = '" . $_SESSION['languages_id'] . "' AND status = '1'");

    $count = xtc_db_num_rows($cat_count);

    while ($cat_data = xtc_db_fetch_array($cat_count)) {

        $checkID = explode('|', $cat_data['categories_ids']);

        if (in_array($_GET['advanced_filter'], $checkID) || $cat_data['categories_ids'] == 'all') {

            $filter_array[$cats] = array('CATEGORIE_ID' => $cat_data['id'],
                'CATEGORIE_TITLE' => $cat_data['titel'],
                'ITEMS' => '');

            $filter_query = xtc_db_query("SELECT
	            									id, name, filter_categories_id, position
		            							FROM
		            								" . TABLE_PRODUCT_FILTER_ITEMS . "
		            							WHERE
		            								filter_categories_id = '" . $cat_data['id'] . "'
		            							AND
		            								language_id = '" . $_SESSION['languages_id'] . "'
		            							AND
		            								status = '1'
		            							ORDER BY
		            								position ASC");

            while ($filter = xtc_db_fetch_array($filter_query)) {
                $filter_array[$cats]['ITEMS'][$item] = array('id' => $filter['id'],
                    'text' => $filter['name'],
                    'checkbox_id' => $filter['id'],
                    'checkbox_checked' => (in_array($filter['id'], $_POST['filter']) ? true : false));
                $item++;
            }
            $cats++;
        }
    }

    $smarty->assign('VERBINDER', '<input name="verbinder" type="radio" value="true" checked="" onclick="javascript:searchResults();" /> ' . PRODUCT_FILTER_AND . '<br /><input name="verbinder" type="radio" value="false" onclick="javascript:searchResults();" /> ' . PRODUCT_FILTER_OR . "\n" . xtc_draw_hidden_field('cat', $_GET['advanced_filter']));
    $smarty->assign('filter_search_items', $filter_array);


    $file_name = FILENAME_PRODUCT_FILTER . '?advanced_filter';
    // $file_name = 'product_filter.php?advanced_filter';
    // $page_links = $listing_split->getLinksArrayFilter(MAX_DISPLAY_PAGE_LINKS, $get_param, TEXT_DISPLAY_NUMBER_OF_PRODUCTS);


    $getCols = xtc_db_fetch_array(xtDBquery("SELECT col FROM products_listings WHERE list_name ='" . $list_name . "'"));

    if (isset($_GET['page']) && $_GET['page'] != '')
        $page .= '&page=' . $_GET['page'];


    switch ($getCols['col']) {
        case '3' :
            $view_per_site = ($per_site == 9 ? '<b>9</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=9' . $get_param) . '">9</a>') . ' | ';
            $view_per_site .= ($per_site == 18 ? '<b>18</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=18' . $get_param) . '">18</a>') . ' | ';
            $view_per_site .= ($per_site == 27 ? '<b>27</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=27' . $get_param) . '">27</a>') . ' | ';
            $view_per_site .= ($per_site == 45 ? '<b>45</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=45' . $get_param) . '">45</a>') . ' | ';
            $view_per_site .= ($per_site == 81 ? '<b>81</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=81' . $get_param) . '">81</a>');
            break;

        case '4' :
            $view_per_site = ($per_site == 12 ? '<b>12</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=12' . $get_param) . '">12</a>') . ' | ';
            $view_per_site .= ($per_site == 24 ? '<b>24</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=24' . $get_param) . '">24</a>') . ' | ';
            $view_per_site .= ($per_site == 60 ? '<b>60</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=60' . $get_param) . '">60</a>') . ' | ';
            $view_per_site .= ($per_site == 84 ? '<b>84</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=84' . $get_param) . '">84</a>') . ' | ';
            $view_per_site .= ($per_site == 96 ? '<b>96</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=96' . $get_param) . '">96</a>');
            break;

        default :
            $view_per_site = ($per_site == 10 ? '<b>10</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=10' . $get_param) . $page . '">10</a>') . ' | ';
            $view_per_site .= ($per_site == 20 ? '<b>20</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=20' . $get_param) . $page . '">20</a>') . ' | ';
            $view_per_site .= ($per_site == 30 ? '<b>30</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=30' . $get_param) . $page . '">30</a>') . ' | ';
            $view_per_site .= ($per_site == 50 ? '<b>50</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=50' . $get_param) . $page . '">50</a>') . ' | ';
            $view_per_site .= ($per_site == 100 ? '<b>100</b>' : '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('per_site', 'page', 'x', 'y', 'view_as')) . '&per_site=100' . $get_param) . $page . '">100</a>');
            break;
    }

    $per_site_html = new Smarty;
    $per_site_html->assign('LINKS_PER_SITE', $view_per_site);
    $per_site_html->assign('language', $_SESSION['language']);
    $products_persite = $per_site_html->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_per_site.html');

    switch ($list_name) {
        case 'product_filter_list' :
            $views_as = '<a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('x', 'y', 'page', 'per_site', 'view_as_filter')) . '&view_as_filter=product_filter_grid' . $get_param) . $page . '">' . LISTING_GALLERY . '</a> ' . LISTING_LIST_ACTIVE;
            break;
        default :
            $views_as = LISTING_GALLERY_ACTIVE . ' <a href="' . xtc_href_link($file_name . xtc_get_all_get_params(array('x', 'y', 'page', 'per_site', 'view_as_filter')) . '&view_as_filter=product_filter_list' . $get_param) . $page . '">' . LISTING_LIST . '</a>';
            break;
    }

    $view = new Smarty;
    $view->assign('LINKS_VIEW_AS', $views_as);
    $view->assign('language', $_SESSION['language']);
    $views = $view->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_view_as.html');
    $smarty->assign('PRODUCTS_VIEW_AS', $views);

    $smarty->assign('FILTER_SEARCH', $_SESSION['filters']);
    $smarty->assign('PRODUCTS_PER_SITE', $products_persite);

    $main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/product_filter.html');
} elseif (!isset($_GET['fcat'])) {

    $filter_cat_items = array();

    $filter_cat_query = xtc_db_query("SELECT
										titel, id, categories_ids
									FROM
										" . TABLE_PRODUCT_FILTER_CATEGORIES . "
									WHERE
										status = 1
									AND
										language_id = '" . $_SESSION['languages_id'] . "'
									ORDER BY
										position ASC");
    while ($filter = xtc_db_fetch_array($filter_cat_query)) {

        $checkID = explode('|', $filter['categories_ids']);

        if (in_array($new_catID, $checkID) || $filter['categories_ids'] == 'all') {
            $filter_cat[$filter['titel']] = array('cat_titel' => $filter['titel'], 'filter_items' => array());

            $filter_cat_items_query = xtc_db_query("SELECT
		    											id, title
													FROM
														" . TABLE_PRODUCT_FILTER_ITEMS . "
													WHERE
														filter_categories_id = '" . $filter['id'] . "'
													AND
														language_id = '" . $_SESSION['languages_id'] . "'
													AND
														status = 1");

            while ($filter_items = xtc_db_fetch_array($filter_cat_items_query))
                $filter_cat[$filter['titel']]['filter_items'][] = array('titel' => $filter_items['title'],
                    'link' => xtc_href_link('product_filter.php', 'fcat=' . (int) $filter['id'] . '&item=' . $filter_items['id']));
        }
    }

    $smarty->assign('filter_cat_items', $filter_cat);
    $smarty->assign('language', $_SESSION['language']);
}

$smarty->assign('main_content', $main_content);

$smarty->assign('language', $_SESSION['language']);


$smarty->display(CURRENT_TEMPLATE . '/index.html');

include ('includes/application_bottom.php');
