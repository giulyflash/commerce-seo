<?php
/*-----------------------------------------------------------------
* 	$Id: product_navigator.php 420 2013-06-19 18:04:39Z akausch $
* 	Copyright (c) 2011-2021 commerce:SEO by Webdesign Erfurt
* 	http://www.commerce-seo.de
* ------------------------------------------------------------------
* 	based on:
* 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
* 	(c) 2002-2003 osCommerce - www.oscommerce.com
* 	(c) 2003     nextcommerce - www.nextcommerce.org
* 	(c) 2005     xt:Commerce - www.xt-commerce.com
* 	Released under the GNU General Public License
* ---------------------------------------------------------------*/




$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
$group_check = "";
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}

$path = explode('_', $cPath);
$cat = array_reverse($path);

$products_query = xtDBquery("SELECT
                                 pc.products_id 
                             FROM ".TABLE_PRODUCTS_TO_CATEGORIES." pc,
                                 ".TABLE_PRODUCTS." p 
							 WHERE 
							 	pc.categories_id = '".$cat[0]."'
                             AND 
                             	p.products_id = pc.products_id  
                             AND 
                             	p.products_status=1 
                                 ".$fsk_lock.$group_check);
$i = 0;
while ($products_data = xtc_db_fetch_array($products_query, true)) {
	$p_data[$i] = array ('pID' => $products_data['products_id'], 'pName' => $products_data['products_name']);
	if ($products_data['products_id'] == $product->data['products_id'])
		$actual_key = $i;
	$i++;
}

// check if array key = first
if ($actual_key == 0) {
	// aktuel key = first product
} else {
	$prev_id = $actual_key -1;
	$prev_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($p_data[$prev_id]['pID'], $p_data[$prev_id]['pName']));
	// check if prev id = first
	if ($prev_id != 0)
		$first_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($p_data[0]['pID'], $p_data[0]['pName']));
}

// check if key = last
if ($actual_key == (sizeof($p_data) - 1)) {
	// actual key is last
} else {
	$next_id = $actual_key +1;
	$next_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($p_data[$next_id]['pID'], $p_data[$next_id]['pName']));
	// check if next id = last
	if ($next_id != (sizeof($p_data) - 1))
		$last_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($p_data[(sizeof($p_data) - 1)]['pID'], $p_data[(sizeof($p_data) - 1)]['pName']));
}
$module_smarty->assign('FIRST', $first_link);
$module_smarty->assign('PREVIOUS', $prev_link);
$module_smarty->assign('NEXT', $next_link);
$module_smarty->assign('LAST', $last_link);
$module_smarty->assign('ACTUAL_PRODUCT', $actual_key +1);

$module_smarty->assign('PRODUCTS_COUNT', count($p_data));
$module_smarty->assign('language', $_SESSION['language']);

$module_smarty->caching = false;
$product_navigator = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/product_navigation/product_navigator.html');

$info_smarty->assign('PRODUCT_NAVIGATOR', $product_navigator);
?>