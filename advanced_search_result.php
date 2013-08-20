<?php

/* -----------------------------------------------------------------
 * 	$Id: advanced_search_result.php 486 2013-07-15 22:08:14Z akausch $
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
require_once (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');

require_once (DIR_FS_INC . 'xtc_parse_search_string.inc.php');
require_once (DIR_FS_INC . 'xtc_get_subcategories.inc.php');
require_once (DIR_FS_INC . 'xtc_get_currencies_values.inc.php');
require_once (DIR_FS_INC . 'xtc_get_path.inc.php');
require_once (DIR_FS_INC . 'xtc_check_categories_status.inc.php');

if (empty($_GET['keywords']) && empty($_POST['manufacturers'])) {
    xtc_redirect(xtc_href_link(FILENAME_ADVANCED_SEARCH, '', 'SSL'));
}

$_GET['keywords'] = isset($_GET['keywords']) && !empty($_GET['keywords']) ? stripslashes(trim(urldecode($_GET['keywords']))) : false;
$_GET['pfrom'] = isset($_GET['pfrom']) && !empty($_GET['pfrom']) ? stripslashes($_GET['pfrom']) : false;
$_GET['pto'] = isset($_GET['pto']) && !empty($_GET['pto']) ? stripslashes($_GET['pto']) : false;
$_GET['manufacturers_id'] = isset($_GET['manufacturers_id']) && xtc_not_null($_GET['manufacturers_id']) ? (int) $_GET['manufacturers_id'] : false;
$_GET['categories_id'] = isset($_GET['categories_id']) && xtc_not_null($_GET['categories_id']) ? (int) $_GET['categories_id'] : false;
$_GET['inc_subcat'] = isset($_GET['inc_subcat']) && xtc_not_null($_GET['inc_subcat']) ? (int) $_GET['inc_subcat'] : 0;

if (isset($_GET['n']) && ($_GET['n'] == '1') && !empty($_GET['keywords']) && MODULE_COMMERCE_SEO_INDEX_STATUS == 'True') {
    xtc_redirect(xtc_href_link('keywords/' . str_replace(' ', '+', $_GET['keywords'])));
}

$error = 0;
$errorno = 0;
$keyerror = 0;

if (isset($_GET['keywords']) && empty($_GET['keywords'])) {
    $keyerror = 1;
}

if ((isset($_GET['keywords']) && empty($_GET['keywords'])) && (isset($_GET['pfrom']) && empty($_GET['pfrom'])) && (isset($_GET['pto']) && empty($_GET['pto']))) {
    $errorno += 1;
    $error = 1;
} elseif (isset($_GET['keywords']) && empty($_GET['keywords']) && !(isset($_GET['pfrom'])) && !(isset($_GET['pto']))) {
    $errorno += 1;
    $error = 1;
}

if (strlen($_GET['keywords']) < 3 && strlen($_GET['keywords']) > 0 && $error == 0) {
    $errorno += 1;
    $error = 1;
    $keyerror = 1;
}

if (strlen($_GET['pfrom']) > 0) {
    $pfrom_to_check = xtc_db_input($_GET['pfrom']);
    if (!settype($pfrom_to_check, "double")) {
        $errorno += 10000;
        $error = 1;
    }
}

if (strlen($_GET['pto']) > 0) {
    $pto_to_check = $_GET['pto'];
    if (!settype($pto_to_check, "double")) {
        $errorno += 100000;
        $error = 1;
    }
}

if (strlen($_GET['pfrom']) > 0 && !(($errorno & 10000) == 10000) && strlen($_GET['pto']) > 0 && !(($errorno & 100000) == 100000)) {
    if ($pfrom_to_check > $pto_to_check) {
        $errorno += 1000000;
        $error = 1;
    }
}

if (strlen($_GET['keywords']) > 0) {
    if (!xtc_parse_search_string(stripslashes($_GET['keywords']), $search_keywords)) {
        $errorno += 10000000;
        $error = 1;
        $keyerror = 1;
    }
}

if ($error == 1 && $keyerror != 1) {
    xtc_redirect(xtc_href_link(FILENAME_ADVANCED_SEARCH, 'errorno=' . $errorno . '&' . xtc_get_all_get_params(array('x', 'y'))));
} else {
    $breadcrumb->add(NAVBAR_TITLE_ADVANCED_SEARCH, xtc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'keywords=' . htmlspecialchars(xtc_db_input($_GET['keywords'])) . '&search_in_description=' . xtc_db_input($_GET['search_in_description']) . '&categories_id=' . (int) $_GET['categories_id'] . '&inc_subcat=' . xtc_db_input($_GET['inc_subcat']) . '&manufacturers_id=' . (int) $_GET['manufacturers_id'] . '&pfrom=' . xtc_db_input($_GET['pfrom']) . '&pto=' . xtc_db_input($_GET['pto']) . '&dfrom=' . xtc_db_input($_GET['dfrom']) . '&dto=' . xtc_db_input($_GET['dto'])));
    require_once (DIR_WS_INCLUDES . 'header.php');

    if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
        $fsk_lock = " AND p.products_fsk18 != '1' ";
    } else {
        unset($fsk_lock);
    }

    if (GROUP_CHECK == 'true') {
        $group_check = " AND p.group_permission_" . $_SESSION['customers_status']['customers_status_id'] . "=1 ";
    } else {
        unset($group_check);
    }

    if (isset($_GET['manufacturers_id']) && xtc_not_null($_GET['manufacturers_id'])) {
        $manu_check = " AND p.manufacturers_id = '" . (int) $_GET['manufacturers_id'] . "' ";
    }

    //include subcategories if needed
    if (isset($_GET['categories_id']) && xtc_not_null($_GET['categories_id'])) {
        if ($_GET['inc_subcat'] == '1') {
            $subcategories_array = array();
            xtc_get_subcategories($subcategories_array, (int) $_GET['categories_id']);
            $subcat_join = " LEFT OUTER JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " AS p2c ON (p.products_id = p2c.products_id) ";
            $subcat_where = " AND p2c.categories_id IN ('" . (int) $_GET['categories_id'] . "' ";
            foreach ($subcategories_array AS $scat) {
                $subcat_where .= ", '" . $scat . "'";
            }
            $subcat_where .= ") ";
        } else {
            $subcat_join = " LEFT OUTER JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " AS p2c ON (p.products_id = p2c.products_id) ";
            $subcat_where = " AND p2c.categories_id = '" . (int) $_GET['categories_id'] . "' ";
        }
    }

    if ($_GET['pfrom'] || $_GET['pto']) {
        $rate = xtc_get_currencies_values($_SESSION['currency']);
        $rate = $rate['value'];
        if ($rate && $_GET['pfrom'] != '') {
            $pfrom = $_GET['pfrom'] / $rate;
        }
        if ($rate && $_GET['pto'] != '') {
            $pto = $_GET['pto'] / $rate;
        }
    }

    //price filters
    if (($pfrom != '') && (is_numeric($pfrom))) {
        $pfrom_check = " AND (IF(s.status = '1' AND p.products_id = s.products_id, s.specials_new_products_price, p.products_price) >= " . $pfrom . ") ";
    } else {
        unset($pfrom_check);
    }

    if (($pto != '') && (is_numeric($pto))) {
        $pto_check = " AND (IF(s.status = '1' AND p.products_id = s.products_id, s.specials_new_products_price, p.products_price) <= " . $pto . " ) ";
    } else {
        unset($pto_check);
    }

    //build query
    $select_str = "SELECT p.*,  pd.*";

    $from_str = " FROM " . TABLE_PRODUCTS . " AS p
	LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " AS pd ON (p.products_id = pd.products_id)
	LEFT JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " AS pc ON (p.products_id = pc.products_id)
	LEFT JOIN " . TABLE_CATEGORIES . " AS c ON (pc.categories_id = c.categories_id)
	LEFT JOIN " . TABLE_CATEGORIES_DESCRIPTION . " AS cd ON (c.categories_id = cd.categories_id)";
    $from_str .= $subcat_join;
    if (SEARCH_IN_ATTR == 'true') {
        $from_str .= " LEFT OUTER JOIN " . TABLE_PRODUCTS_ATTRIBUTES . " AS pa ON (p.products_id = pa.products_id) LEFT OUTER JOIN " . TABLE_PRODUCTS_OPTIONS_VALUES . " AS pov ON (pa.options_values_id = pov.products_options_values_id) ";
    }

    if ((DISPLAY_PRICE_WITH_TAX == 'true') && ((isset($_GET['pfrom']) && xtc_not_null($_GET['pfrom'])) || (isset($_GET['pto']) && xtc_not_null($_GET['pto'])))) {
        if (!isset($_SESSION['customer_country_id'])) {
            $_SESSION['customer_country_id'] = STORE_COUNTRY;
            $_SESSION['customer_zone_id'] = STORE_ZONE;
        }
        $from_str .= " LEFT OUTER JOIN " . TABLE_TAX_RATES . " tr ON (p.products_tax_class_id = tr.tax_class_id) LEFT OUTER JOIN " . TABLE_ZONES_TO_GEO_ZONES . " gz ON (tr.tax_zone_id = gz.geo_zone_id) ";
        $tax_where = " AND (gz.zone_country_id IS NULL OR gz.zone_country_id = '0' OR gz.zone_country_id = '" . (int) $_SESSION['customer_country_id'] . "') AND (gz.zone_id is null OR gz.zone_id = '0' OR gz.zone_id = '" . (int) $_SESSION['customer_zone_id'] . "')";
    } else {
        unset($tax_where);
    }

    //where-string
    $where_str = " WHERE 
						p.products_status = '1' 
					AND 
						c.categories_status = '1' 
					AND 
						(p.products_slave_in_list = '1' OR p.products_master = '1' OR ((p.products_slave_in_list = '0' OR p.products_slave_in_list = '') AND (p.products_master_article = '' OR p.products_master_article = '0')))
					AND 
						pd.language_id = '" . (int) $_SESSION['languages_id'] . "'" .
            $subcat_where . $att_where . $fsk_lock . $manu_check . $group_check . $tax_where . $pfrom_check . $pto_check;


    //go for keywords... this is the main search process
    if (isset($_GET['keywords']) && xtc_not_null($_GET['keywords'])) {
        if (xtc_parse_search_string(stripslashes($_GET['keywords']), $search_keywords)) {
            $where_str .= " AND ( ";
            for ($i = 0, $n = sizeof($search_keywords); $i < $n; $i++) {
                switch ($search_keywords[$i]) {
                    case '(' :
                    case ')' :
                    case 'and' :
                    case 'or' :
                        $where_str .= " " . $search_keywords[$i] . " ";
                        break;
                    default :
                        $where_str .= " ( ";
                        $where_str .= "pd.products_keywords LIKE ('%" . addslashes($search_keywords[$i]) . "%') ";
                        if (SEARCH_IN_DESC == 'true') {
                            $where_str .= "OR pd.products_description LIKE ('%" . addslashes($search_keywords[$i]) . "%') ";
                            $where_str .= "OR pd.products_short_description LIKE ('%" . addslashes($search_keywords[$i]) . "%') ";
                            $where_str .= "AND pd.language_id = '" . (int) $_SESSION['languages_id'] . "'";
                        }
                        if (SEARCH_IN_CATDESC == 'true') {
                            $where_str .= "OR cd.categories_name LIKE ('%" . addslashes($search_keywords[$i]) . "%') ";
                            $where_str .= "OR cd.categories_description LIKE ('%" . addslashes($search_keywords[$i]) . "%') ";
                            $where_str .= "AND cd.language_id = '" . (int) $_SESSION['languages_id'] . "'";
                        }
                        $where_str .= "OR pd.products_name LIKE ('%" . addslashes($search_keywords[$i]) . "%') ";
                        $where_str .= "OR p.products_model LIKE ('%" . addslashes($search_keywords[$i]) . "%') ";
                        if (SEARCH_IN_ATTR == 'true') {
                            $where_str .= "OR (pov.products_options_values_name LIKE ('%" . addslashes($search_keywords[$i]) . "%') ";
                            $where_str .= "OR pa.attributes_model LIKE ('%" . addslashes($search_keywords[$i]) . "%') ";
                            $where_str .= "AND pov.language_id = '" . (int) $_SESSION['languages_id'] . "')";
                        }
                        $where_str .= " ) ";
                        break;
                }
            }
            $where_str .= " ) ";
        }
    }
	$order_str = ' GROUP BY p.products_id ORDER BY pd.products_name';
    if (DISPLAY_SUBCAT_PRODUCTS == 'true') {
        if ($_GET['multisort'] == 'specialprice' || $_GET['multisort'] == 'new_asc' || $_GET['multisort'] == 'new_desc' || $_GET['multisort'] == 'name_asc' || $_GET['multisort'] == 'name_desc' || $_GET['multisort'] == 'price_asc' || $_GET['multisort'] == 'price_desc' || $_GET['multisort'] == 'manu_asc' || $_GET['multisort'] == 'manu_desc') {
            switch ($_GET['multisort']) {
                case 'new_asc':
                    $order_str = 'GROUP BY p.products_id ORDER BY p.products_date_added ASC';
                    break;
                case 'new_desc':
                    $order_str = 'GROUP BY p.products_id ORDER BY p.products_date_added DESC';
                    break;
                case 'name_asc':
                    $order_str = 'GROUP BY p.products_id ORDER BY pd.products_name ASC';
                    break;
                case 'name_desc':
                    $order_str = 'GROUP BY p.products_id ORDER BY pd.products_name DESC';
                    break;
                case 'price_asc':
                    $order_str = 'GROUP BY p.products_id ORDER BY p.products_price ASC';
                    break;
                case 'price_desc':
                    $order_str = 'GROUP BY p.products_id ORDER BY p.products_price DESC';
                    break;
                case 'manu_asc':
                    $from_str .= 'LEFT OUTER JOIN ' . TABLE_MANUFACTURERS . ' AS m ON ( p.manufacturers_id = m.manufacturers_id )';
                    $order_str = 'GROUP BY p.products_id ORDER BY m.manufacturers_name ASC';
                    break;
                case 'manu_desc':
                    $from_str .= 'LEFT OUTER JOIN ' . TABLE_MANUFACTURERS . ' AS m ON ( p.manufacturers_id = m.manufacturers_id )';
                    $order_str = 'GROUP BY p.products_id ORDER BY m.manufacturers_name DESC';
                    break;
                case 'specialprice':
                    $from_str .= "LEFT OUTER JOIN " . TABLE_SPECIALS . " AS s ON (p.products_id = s.products_id) AND s.status = '1'";
                    $order_str = 'GROUP BY p.products_id ORDER BY s.specials_new_products_price DESC';
                    break;
                default:
                    $order_str = ' GROUP BY p.products_id ORDER BY pd.products_name';
            }
        }

        $multisort_dropdown = xtc_draw_form('multisort', FILENAME_ADVANCED_SEARCH_RESULT, 'get') . "\n";
        $multisort_dropdown.= xtc_draw_hidden_field('keywords', $_GET['keywords']) . "\n";
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
    }

    $listing_sql = $select_str . $from_str . $where_str . $order_str;
    $keywords = $_GET['keywords'];

    if (isset($_GET['per_site']) && !empty($_GET['per_site'])) {
        $per_site = $_GET['per_site'];
    } elseif (isset($_SESSION['per_site'])) {
        $per_site = $_SESSION['per_site'];
    } elseif (!isset($_SESSION['per_site']) || !isset($_GET['per_site'])) {
        $per_site = MAX_DISPLAY_SEARCH_RESULTS;
    }

    $_SESSION['per_site'] = $per_site;
    $get_param .= '&keywords=' . $_GET['keywords'];
    $get_param .= '&multisort=' . $_GET['multisort'];

    $listing_split = new splitPageResults($listing_sql, (int) $_GET['page'], (int) $_SESSION['per_site'], 'p.products_id');

    if ($_GET['view_as_advsr'] != '') {
        $list_name = $_GET['view_as_advsr'];
        $_SESSION['view_as_advsr'] = $_GET['view_as_advsr'];
    } elseif ($_SESSION['view_as_advsr'] != '') {
        $list_name = $_SESSION['view_as_advsr'];
    } elseif (!isset($_SESSION['view_as_advsr']) || !isset($_GET['view_as_advsr'])) {
        $list_name = 'advanced_search_result_grid';
        $_SESSION['view_as_advsr'] = 'advanced_search_result_grid';
    }

    if ($listing_split->number_of_rows > 0) {
        $navigation_smarty = new Smarty;
        $page_links = $listing_split->getLinksArraySearch(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array('page', 'keywords', 'info', 'x', 'y', (MODULE_COMMERCE_SEO_INDEX_STATUS == 'True' ? 'cPath' : ''), 'cat', 'per_site', 'view_as_advsr')), TEXT_DISPLAY_NUMBER_OF_PRODUCTS, '', $_GET['keywords']);
        $navigation_smarty->assign('LINKS', $page_links);
        $navigation_smarty->assign('language', $_SESSION['language']);
        $navigation_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
        $navigation = $navigation_smarty->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_page_navigation.html');
        $getCols = xtc_db_fetch_array(xtDBquery("SELECT col FROM products_listings WHERE list_name ='" . $list_name . "'"));
        $module_content = array();
        $listing_query = xtDBquery($listing_split->sql_query);
        $rows = 0;
        while ($tag = xtc_db_fetch_array($listing_query, true)) {
            $rows++;
            $module_content[] = $product->buildDataArray($tag, 'thumbnail', $list_name, $rows);
        }
        $getCols = xtc_db_fetch_array(xtDBquery("SELECT col FROM products_listings WHERE list_name ='" . $list_name . "'"));

        if (isset($_GET['page']) && $_GET['page'] != '') {
            $page .= '&page=' . $_GET['page'];
        }
        if (isset($_GET['multisort']) && $_GET['multisort'] != '') {
            $page .= '&multisort=' . $_GET['multisort'];
        }

        $file_name = FILENAME_ADVANCED_SEARCH_RESULT;
        switch ($getCols['col']) {
            case '3' :
                $view_per_site = ($per_site == 9 ? '<b>9</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=9' . $get_param) . '">9</a>') . ' | ';
                $view_per_site .= ($per_site == 18 ? '<b>18</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=18' . $get_param) . '">18</a>') . ' | ';
                $view_per_site .= ($per_site == 27 ? '<b>27</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=27' . $get_param) . '">27</a>') . ' | ';
                $view_per_site .= ($per_site == 45 ? '<b>45</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=45' . $get_param) . '">45</a>') . ' | ';
                $view_per_site .= ($per_site == 81 ? '<b>81</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=81' . $get_param) . '">81</a>');
                break;

            case '4' :
                $view_per_site = ($per_site == 12 ? '<b>12</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=12' . $get_param) . '">12</a>') . ' | ';
                $view_per_site .= ($per_site == 24 ? '<b>24</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=24' . $get_param) . '">24</a>') . ' | ';
                $view_per_site .= ($per_site == 60 ? '<b>60</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=60' . $get_param) . '">60</a>') . ' | ';
                $view_per_site .= ($per_site == 84 ? '<b>84</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=84' . $get_param) . '">84</a>') . ' | ';
                $view_per_site .= ($per_site == 96 ? '<b>96</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=96' . $get_param) . '">96</a>');
                break;

            default :
                $view_per_site = ($per_site == 10 ? '<b>10</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=10' . $get_param) . '">10</a>') . ' | ';
                $view_per_site .= ($per_site == 20 ? '<b>20</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=20' . $get_param) . '">20</a>') . ' | ';
                $view_per_site .= ($per_site == 30 ? '<b>30</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=30' . $get_param) . '">30</a>') . ' | ';
                $view_per_site .= ($per_site == 50 ? '<b>50</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=50' . $get_param) . '">50</a>') . ' | ';
                $view_per_site .= ($per_site == 100 ? '<b>100</b>' : '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'per_site=100' . $get_param) . '">100</a>');
                break;
        }
        $per_site_html = new Smarty;
        $per_site_html->assign('LINKS_PER_SITE', $view_per_site);
        $per_site_html->assign('language', $_SESSION['language']);

        $products_persite = $per_site_html->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_per_site.html');

        switch ($list_name) {
            case 'advanced_search_result_list' :
                $views_as = '<a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'view_as_advsr=advanced_search_result_grid' . $get_param) . '">' . LISTING_GALLERY . '</a> ' . LISTING_LIST_ACTIVE;
                break;
            default :
                $views_as = LISTING_GALLERY_ACTIVE . ' <a href="' . xtc_href_link($file_name, xtc_get_all_get_params(array('keywords', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'page', 'view_as_advsr')) . 'view_as_advsr=advanced_search_result_list' . $get_param) . '">' . LISTING_LIST . '</a>';
                break;
        }

        $view = new Smarty;
        $view->assign('LINKS_VIEW_AS', $views_as);
        $view->assign('language', $_SESSION['language']);

        $views = $view->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_view_as.html');

        $smarty->assign('PRODUCTS_VIEW_AS', $views);
        $smarty->assign('language', $_SESSION['language']);
        $smarty->assign('MANUFACTURER_DROPDOWN', $manufacturer);
        $smarty->assign('MULTISORT_DROPDOWN', $multisort_dropdown);

        $smarty->assign('PRODUCTS_PER_SITE', $products_persite);
        $smarty->assign('NAVIGATION', $navigation);

        $smarty->assign('module_content', $module_content);
        $smarty->assign('language', $_SESSION['language']);

        $smarty->assign('TITLE', $listing_split->number_of_rows . ' ' . ADVANCED_SEARCH_HEADER . '<em>' . $_GET['keywords'] . '</em>');
        $smarty->assign('CLASS', 'advanced_search_result');

        if (SEARCH_IN_CATDESC == 'true') {
            $categories_a_query = "SELECT DISTINCT
										cd.categories_description,
										c.categories_id, 
										c.categories_image, 
										cd.categories_name,
										cd.categories_heading_title
									FROM
										" . TABLE_CATEGORIES . " c,
										" . TABLE_CATEGORIES_DESCRIPTION . " cd
									WHERE
										c.categories_status = '1'
									AND 
										cd.categories_id = c.categories_id
									AND
										cd.language_id = '" . (int) $_SESSION['languages_id'] . "'
									AND
										(cd.categories_name LIKE ('%" . addslashes($_GET['keywords']) . "%') OR	cd.categories_description LIKE ('%" . addslashes($_GET['keywords']) . "%'))
									ORDER BY
										cd.categories_name";
            $categories_query_q = xtDBquery($categories_a_query);
            $rows_cat = 0;
            while ($categories_a = xtc_db_fetch_array($categories_query_q, true)) {
                $rows_cat++;
                $cPath_new = xtc_category_link($categories_a['categories_id'], $categories_a['categories_name']);
                $image = '';
                if ($categories_a['categories_image'] != '')
                    $image = xtc_image(DIR_WS_IMAGES . 'categories/' . $categories_a['categories_image'], $categories_a['categories_name'], $categories_a['categories_heading_title']);

                $categories_content[] = array('CATEGORIES_NAME' => $categories_a['categories_name'],
                    'CATEGORIES_IMAGE' => $image,
                    'CATEGORIES_LINK' => xtc_href_link(FILENAME_DEFAULT, $cPath_new));
            }
            $smarty->assign('CATEGORY_LINK', $categories_content);
        }

        $smarty->caching = false;
        $module = $smarty->fetch(CURRENT_TEMPLATE . '/module/product_listing/product_listings.html');
    } else {
        $error = TEXT_PRODUCT_NOT_FOUND;
        include (DIR_WS_MODULES . FILENAME_ERROR_HANDLER);
    }

    if (LOG_SEARCH_RESULTS == 'true') {
        if ($_SESSION['last_keyword'] != $_GET['keywords']) {
            $report_search_keywords = addslashes($_GET['keywords']);
            $rows = xtc_db_num_rows(xtDBquery($listing_sql));
            $_SESSION['last_keyword'] = $_GET['keywords'];
            xtDBquery("INSERT INTO search_queries_all (search_text, search_result) VALUES ('" . $report_search_keywords . "','" . $rows . "')");
        }
    }
}
$smarty->assign('language', $_SESSION['language']);
$smarty->caching = false;

$smarty->assign('main_content', $module);

$smarty->display(CURRENT_TEMPLATE . '/index.html');

include ('includes/application_bottom.php');
