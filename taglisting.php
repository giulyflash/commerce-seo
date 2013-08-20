<?php

/* -----------------------------------------------------------------
 * 	$Id: taglisting.php 420 2013-06-19 18:04:39Z akausch $
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
$smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');

require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');

$error = 0; // reset error flag to false
$breadcrumb->add(NAVBAR_TITLE_TAGLIST, xtc_href_link('taglisting.php', '', 'SSL'));

include ('includes/header.php');

// function umlautepas($string){
// $upas = Array("ä" => "ae", "ü" => "ue", "ö" => "oe", "Ä" => "Ae", "Ü" => "Ue", "Ö" => "Oe", "ß" => "ss"); 
// return strtr($string, $upas);
// }
// function umlautereverse($string){
// $upas = Array("ae" => "ä", "ue" => "ü", "ue" => "ü", "Ae" => "Ä", "Ue" => "Ü", "Oe" => "Ö", "ss" => "ß"); 
// return strtr($string, $upas);
// }

$result = true;

// $_GET['tag'] = umlautereverse($_GET['tag']);

if (isset($_GET['tag']) && ($_GET['tag'] != '')) {

    $fsk_lock = '';
    if ($_SESSION['customers_status']['customers_fsk18_display'] == '0')
        $fsk_lock = ' and p.products_fsk18!=1';

    $group_check = '';
    if (GROUP_CHECK == 'true')
        $group_check = " and p.group_permission_" . $_SESSION['customers_status']['customers_status_id'] . "=1 ";

    $listing_sql = "SELECT DISTINCT 
						p.*,
						pd.*,
						m.*,
						t2p.pID,
						t2p.tag
					FROM
						tag_to_product t2p
					LEFT JOIN
						" . TABLE_PRODUCTS_DESCRIPTION . " pd ON pd.products_id = t2p.pID
					LEFT JOIN
						" . TABLE_PRODUCTS . " p ON p.products_id = t2p.pID
						LEFT JOIN
						" . TABLE_MANUFACTURERS . " m ON p.manufacturers_id = m.manufacturers_id
						LEFT JOIN
						" . TABLE_SPECIALS . " s ON p.products_id = s.products_id
					WHERE
						p.products_status = '1'
					AND
						t2p.tag = '" . urldecode($_GET['tag']) . "'
						   " . $group_check . "
						   " . $fsk_lock . "
					AND
						pd.language_id = '" . (int) $_SESSION['languages_id'] . "'";

    $getCount = xtc_db_fetch_array(xtDBquery("SELECT
												COUNT(pID) AS anzahl
											FROM
												tag_to_product
											WHERE
												tag = '" . $_GET['tag'] . "'"));

    if (isset($_GET['per_site']) && !empty($_GET['per_site']))
        $per_site = $_GET['per_site'];
    elseif (isset($_SESSION['per_site']))
        $per_site = $_SESSION['per_site'];
    elseif (!isset($_SESSION['per_site']) || !isset($_GET['per_site']))
        $per_site = MAX_DISPLAY_SEARCH_RESULTS;

    $_SESSION['per_site'] = $per_site;

    $listing_split = new splitPageResults($listing_sql, (int) $_GET['page'], (int) $_SESSION['per_site'], 'p.products_id');

    $list_name = 'tagcloud';

    if (($listing_split->number_of_rows > 0)) {
        $navigation_smarty = new Smarty;
        $page_links = $listing_split->getLinksArrayTag(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array('page', 'tag', 'info', 'x', 'y', (MODULE_COMMERCE_SEO_INDEX_STATUS == 'True' ? 'cPath' : ''), 'cat', 'per_site', 'view_as')), TEXT_DISPLAY_NUMBER_OF_PRODUCTS, '', $_GET['tag']);
        $navigation_smarty->assign('LINKS', $page_links);
        $navigation_smarty->assign('language', $_SESSION['language']);
        $navigation_smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
        $navigation = $navigation_smarty->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_page_navigation.html');
    }
    $module_content = array();
    $listing_query = xtDBquery($listing_split->sql_query);
    $rows = 0;
    while ($tag = xtc_db_fetch_array($listing_query, true)) {
        $rows++;
        $module_content[] = $product->buildDataArray($tag, 'thumbnail', $list_name, $rows);
    }
    switch ($getCols['col']) {
        case '3' :
            $view_per_site = ($per_site == 9 ? '<b>9</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=9' . $get_param) . '">9</a>') . ' | ';
            $view_per_site .= ($per_site == 18 ? '<b>18</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=18' . $get_param) . '">18</a>') . ' | ';
            $view_per_site .= ($per_site == 27 ? '<b>27</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=27' . $get_param) . '">27</a>') . ' | ';
            $view_per_site .= ($per_site == 45 ? '<b>45</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=45' . $get_param) . '">45</a>') . ' | ';
            $view_per_site .= ($per_site == 81 ? '<b>81</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=81' . $get_param) . '">81</a>');
            break;

        case '4' :
            $view_per_site = ($per_site == 12 ? '<b>12</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=12' . $get_param) . '">12</a>') . ' | ';
            $view_per_site .= ($per_site == 24 ? '<b>24</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=24' . $get_param) . '">24</a>') . ' | ';
            $view_per_site .= ($per_site == 60 ? '<b>60</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=60' . $get_param) . '">60</a>') . ' | ';
            $view_per_site .= ($per_site == 84 ? '<b>84</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=84' . $get_param) . '">84</a>') . ' | ';
            $view_per_site .= ($per_site == 96 ? '<b>96</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=96' . $get_param) . '">96</a>');
            break;

        default :
            $view_per_site = ($per_site == 10 ? '<b>10</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=10' . $get_param) . '">10</a>') . ' | ';
            $view_per_site .= ($per_site == 20 ? '<b>20</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=20' . $get_param) . '">20</a>') . ' | ';
            $view_per_site .= ($per_site == 30 ? '<b>30</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=30' . $get_param) . '">30</a>') . ' | ';
            $view_per_site .= ($per_site == 50 ? '<b>50</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=50' . $get_param) . '">50</a>') . ' | ';
            $view_per_site .= ($per_site == 100 ? '<b>100</b>' : '<a rel="nofollow" href="' . xtc_href_link('tag/' . $_GET['tag'] . '/', xtc_get_all_get_params(array('tag', 'products_id', 'x', 'y', 'cat', 'per_site', 'multisort', 'filter_id', 'view_as')) . 'per_site=100' . $get_param) . '">100</a>');
            break;
    }

    $per_site_html = new Smarty;
    $per_site_html->assign('LINKS_PER_SITE', $view_per_site);
    $per_site_html->assign('language', $_SESSION['language']);
    $products_persite = $per_site_html->fetch(CURRENT_TEMPLATE . '/module/product_navigation/products_per_site.html');

    $smarty->assign('NAVIGATION', $navigation);
    //Nur wenn auch Treffer da sind, sonst 404
    if ($getCount['anzahl'] > 0) {
        $smarty->assign('TAG_COUNT', TEXT_TAG_TREFFER1 . $getCount['anzahl'] . TEXT_TAG_TREFFER2);
        $smarty->assign('TITLE', TEXT_TAG_HEAD . $_GET['tag']);
    } else {
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        header('Status: 404 Not Found');
        header('Content-type: text/html');
    }

    $smarty->assign('CLASS', 'tagcloud');
    $smarty->assign('PRODUCTS_PER_SITE', $products_persite);
    $smarty->assign('module_content', $module_content);
    $smarty->assign('language', $_SESSION['language']);
    $smarty->caching = false;
    $module = $smarty->fetch(CURRENT_TEMPLATE . '/module/product_listing/product_listings.html');
    $smarty->assign('main_content', $module);
    $smarty->display(CURRENT_TEMPLATE . '/index.html');
    include ('includes/application_bottom.php');
} else {
    $view = new Smarty;
    $error = TEXT_TAG_NOT_FOUND;
    include (DIR_WS_MODULES . FILENAME_ERROR_HANDLER);

    $smarty->assign('language', $_SESSION['language']);
    $smarty->assign('error', $error);

    function kshuffle2(&$array) {
        if (!is_array($array) || empty($array))
            return false;
        $tmp = array();
        foreach ($array as $key => $value)
            $tmp[] = array('k' => $key, 'v' => $value);

        shuffle($tmp);
        $array = array();
        foreach ($tmp as $entry)
            $array[$entry['k']] = $entry['v'];
        return true;
    }

    function printTagCloud2($tags) {

        kshuffle2($tags); // Zufaellige Anzeige

        $max_size = 32; // max font size in pixels
        $min_size = 12; // min font size in pixels

        $max_qty = max(array_values($tags));
        $min_qty = min(array_values($tags));

        $spread = $max_qty - $min_qty;
        if ($spread == 0)
            $spread = 1;

        $step = ($max_size - $min_size) / ($spread);

        foreach ($tags as $key => $value) {
            $size = round($min_size + (($value - $min_qty) * $step));
            // $cleankey = umlautepas($key);
            $cloud .= '<a rel="nofollow" href="' . xtc_href_link('tag/' . urlencode($key) . '/') . '" style="color:#' . mt_rand(000000, 999999) . ';font-size:' . $size . 'px;" title="' . $value . ' Produkte wurden mit ' . $key . ' getagged" rel="follow">' . $key . '</a> ';
        }
        return $cloud;
    }

    $data_query = xtDBquery("SELECT
									tag, count(tag) AS tag_anzahl
								FROM
									tag_to_product
								WHERE
									lID = '" . $_SESSION['languages_id'] . "'
								GROUP BY
									tag ");

    if (xtc_db_num_rows($data_query)) {
        $tag_array = array();
        while ($data = xtc_db_fetch_array($data_query)) {
            if (!empty($data))
                $tag_array[$data['tag']] = $data['tag_anzahl'];
        }
    }
    if (is_array($tag_array))
        $tag_cloud = printTagCloud2($tag_array);

    $smarty->assign('TITLE', 'Tagcloud');
    $smarty->assign('CLASS', 'tagcloud');
    $smarty->assign('module_content', $tag_cloud);
    $smarty->caching = false;
    $module = $smarty->fetch(CURRENT_TEMPLATE . '/module/taglistings.html');
    $smarty->assign('main_content', $module);
    $smarty->display(CURRENT_TEMPLATE . '/index.html');
    include ('includes/application_bottom.php');
}

