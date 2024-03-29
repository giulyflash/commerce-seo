<?php

/* -----------------------------------------------------------------
 * 	$Id: product_reviews.php 420 2013-06-19 18:04:39Z akausch $
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
// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC . 'xtc_row_number_format.inc.php');
require_once (DIR_FS_INC . 'xtc_date_short.inc.php');

// lets retrieve all $HTTP_GET_VARS keys and values..
$get_params = xtc_get_all_get_params();
$get_params_back = xtc_get_all_get_params(array('reviews_id')); // for back button
$get_params = substr($get_params, 0, -1); //remove trailing &
if (xtc_not_null($get_params_back)) {
    $get_params_back = substr($get_params_back, 0, -1); //remove trailing &
} else {
    $get_params_back = $get_params;
}

$product_info_query = xtc_db_query("select pd.products_name from " . TABLE_PRODUCTS_DESCRIPTION . " pd left join " . TABLE_PRODUCTS . " p on pd.products_id = p.products_id where pd.language_id = '" . (int) $_SESSION['languages_id'] . "' and p.products_status = '1' and pd.products_id = '" . (int) $_GET['products_id'] . "'");
if (!xtc_db_num_rows($product_info_query))
    xtc_redirect(xtc_href_link(FILENAME_REVIEWS));
$product_info = xtc_db_fetch_array($product_info_query);

$breadcrumb->add(NAVBAR_TITLE_PRODUCT_REVIEWS, xtc_href_link(FILENAME_PRODUCT_REVIEWS, $get_params));

require (DIR_WS_INCLUDES . 'header.php');

$smarty->assign('PRODUCTS_NAME', $product_info['products_name']);

$data_reviews = array();
$reviews_query = xtc_db_query("select reviews_rating, reviews_id, customers_name, date_added, last_modified, reviews_read from " . TABLE_REVIEWS . " where products_id = '" . (int) $_GET['products_id'] . "' order by reviews_id DESC");
if (xtc_db_num_rows($reviews_query)) {
    $row = 0;
    while ($reviews = xtc_db_fetch_array($reviews_query)) {
        $row++;
        $data_reviews[] = array('ID' => $reviews['reviews_id'],
            'AUTHOR' => '<a href="' . xtc_href_link(FILENAME_PRODUCT_REVIEWS_INFO, $get_params . '&reviews_id=' . $reviews['reviews_id']) . '">' . $reviews['customers_name'] . '</a>',
            'DATE' => xtc_date_short($reviews['date_added']),
            'RATINGNUM' => $reviews['reviews_rating'],
            'RATING' => xtc_image('templates/' . CURRENT_TEMPLATE . '/img/stars_' . $reviews['reviews_rating'] . '.gif', sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $reviews['reviews_rating'])), 'TEXT' => $reviews['reviews_text']);
    }
}
$smarty->assign('module_content', $data_reviews);
$smarty->assign('BUTTON_BACK', '<a href="' . xtc_href_link(FILENAME_PRODUCT_INFO, $get_params_back) . '">' . xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>');
$smarty->assign('BUTTON_WRITE', '<a href="' . xtc_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, $get_params) . '">' . xtc_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a>');

$smarty->assign('language', $_SESSION['language']);

// set cache ID
$smarty->caching = false;
$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/product_reviews.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = false;

$smarty->display(CURRENT_TEMPLATE . '/index.html');
include ('includes/application_bottom.php');
