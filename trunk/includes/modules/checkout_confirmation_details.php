<?php
/*-----------------------------------------------------------------
* 	$Id: checkout_confirmation_details.php 420 2013-06-19 18:04:39Z akausch $
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
// include needed functions
require_once (DIR_FS_INC.'xtc_check_stock.inc.php');
require_once (DIR_FS_INC.'xtc_get_products_stock.inc.php');
require_once (DIR_FS_INC.'xtc_remove_non_numeric.inc.php');
require_once (DIR_FS_INC.'xtc_get_short_description.inc.php');
require_once (DIR_FS_INC.'xtc_format_price.inc.php');
require_once (DIR_FS_INC.'xtc_get_attributes_model.inc.php');

$module_content = array ();
$any_out_of_stock = '';
$mark_stock = '';

for ($i = 0, $n = sizeof($order->products); $i < $n; $i ++) {
	$image = '';
	$products_image_query = xtc_db_query ("SELECT products_image FROM products WHERE products_id = '".$order->products[$i]['id']."'");
	$products_image = xtc_db_fetch_array($products_image_query);
	
	
	if ((isset ($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0)) {
		for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++) {
			$module_content[$i]['ATTRIBUTES'][] .= '<div>&nbsp;<em> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '</em></div>';
		}
	}
	
	if($products_image['products_image'] !='')
		$img = DIR_WS_THUMBNAIL_IMAGES.$products_image['products_image'];
	else
		$img = DIR_WS_THUMBNAIL_IMAGES.'no_img.jpg';
	
	$module_content[$i] = array ('PRODUCTS_NAME' => '<a href="'.xtc_href_link('checkout_product_info.php', xtc_product_link($order->products[$i]['id'], $order->products[$i]['name'])).'" class="shipping">'.$order->products[$i]['name'].'</a>'.$mark_stock, 
								'PRODUCTS_QTY' => $order->products[$i]['qty'] . 'x', 
								'PRODUCTS_VPE' => $order->products[$i]['vpe'],
								'PRODUCTS_SHORT_DESCRIPTION' => $order->products[$i]['products_short_description'],
								'PRODUCTS_MODEL' => $order->products[$i]['model'],
								'PRODUCTS_SHIPPING_TIME'=>$order->products[$i]['shipping_time'],
								'PRODUCTS_IMAGE' => $img,
								'IMAGE_ALT' => $order->products[$i]['name'],
								'ATTRIBUTES' => Array(),
								'PRODUCTS_PRICE' => $xtPrice->xtcFormat($order->products[$i]['final_price'], true), 
								'PRODUCTS_SINGLE_PRICE' => $order->products[$i]['price_formated']);
	// Product options names
	
	if ((isset ($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0)) {
		for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++) {
			$module_content[$i]['ATTRIBUTES'][] = array ('ID' => $order->products[$i][$option]['products_attributes_id'], 
														'MODEL' => xtc_get_attributes_model(xtc_get_prid($order->products[$i]['id']), $order->products[$i][$option]['products_options_values_name'],$order->products[$i][$option]['products_options_name']), 
														'NAME' => $order->products[$i]['attributes'][$j]['option'], 
														'VALUE_NAME' => $order->products[$i]['attributes'][$j]['value']);
		}
	}

}

$module_smarty->assign('module_content', $module_content);
$module_smarty->assign('language', $_SESSION['language']);
$module_smarty->caching = false;
$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/checkout_confirmation_details.html');

$smarty->assign('MODULE_checkout_confirmation_details', $module);
?>