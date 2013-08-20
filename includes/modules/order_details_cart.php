<?php
/*-----------------------------------------------------------------
* 	$Id: order_details_cart.php 458 2013-07-08 06:10:18Z akausch $
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
require_once (DIR_FS_INC.'xtc_get_long_description.inc.php');
require_once (DIR_FS_INC.'xtc_format_price.inc.php');
require_once (DIR_FS_INC.'xtc_get_attributes_model.inc.php');
require_once (DIR_FS_INC.'xtc_check_stock_special.inc.php');

function xtc_check_minorder($products_id, $products_quantity) {

	$query = xtc_db_query(" SELECT products_minorder FROM ".TABLE_PRODUCTS." WHERE products_id = '".$products_id."' ");

	if(xtc_db_num_rows($query) == 0) {
		return;
	} else {
		$value = xtc_db_fetch_array($query);
		if ($value['products_minorder'] > $products_quantity) {
		return array('minorder' => $value['products_minorder'],'mark' => '<span class="markProductOutOfStock">'.STOCK_MARK_PRODUCT_OUT_OF_STOCK.'</span>');
	}
	}
}

$module_content = array ();
$any_out_of_stock = '';
$mark_stock = '';
$minorder = array();

for ($i = 0, $n = sizeof($products); $i < $n; $i ++) {

	if (STOCK_CHECK == 'true') {
		$mark_stock = xtc_check_stock($products[$i]['id'], $products[$i]['quantity']);
		if ($mark_stock)
			$_SESSION['any_out_of_stock'] = 1;
	}
	
	//Mindestbestellmenge
	$mark_minorder = xtc_check_minorder($products[$i]['id'], $products[$i]['quantity']);
	if($mark_minorder['mark']) {
		$minorder[] = array('name' => $products[$i]['name'], 'minorder' => $mark_minorder['minorder']);
	}

	if (STOCK_CHECK == 'true') {
		$mark_special_stock = xtc_check_stock_special($products[$i]['id'], $products[$i]['quantity']);
		if ($mark_special_stock)
			$_SESSION['any_out_of_stock'] = 1;
	}
	
	$image = '';
	if ($products[$i]['image'] != '') {
		$image = DIR_WS_MINI_IMAGES.$products[$i]['image'];
	} else {
		$image = DIR_WS_THUMBNAIL_IMAGES.'no_img.jpg';
	}

	$attributes_exist = ((isset ($products[$i]['attributes'])) ? 1 : 0);
	// Beschreibung holen
	if (xtc_get_short_description($products[$i]['id']) != '') {
		$description = xtc_get_short_description($products[$i]['id']);
	} elseif (xtc_get_long_description($products[$i]['id']) != '') {
		$description = substr(strip_tags(xtc_get_long_description($products[$i]['id'])), 0 , 200) . ' ...';
	}
	
	$module_content[$i] = array ('PRODUCTS_NAME' => $products[$i]['name'].$mark_stock.$mark_minorder.$mark_special_stock,
								'PRODUCTS_QTY' => xtc_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="2"').xtc_draw_hidden_field('products_id[]', $products[$i]['id']).xtc_draw_hidden_field('old_qty[]', $products[$i]['quantity']),
								'QTY' => $products[$i]['quantity'],
								'PRODUCTS_MODEL' => $products[$i]['model'],
								'PRODUCTS_VPE' => $products[$i]['vpe'],
								'PRODUCTS_SHIPPING_TIME'=>$products[$i]['shipping_time'],
								'PRODUCTS_TAX' => number_format($products[$i]['tax_class_id'], TAX_DECIMAL_PLACES),
								'PRODUCTS_IMAGE' => $image,
								'PRODUCTS_POS' => $i+1,
								'IMAGE_ALT' => $products[$i]['name'],
								'BOX_DELETE' => xtc_draw_checkbox_field('cart_delete[]', $products[$i]['id']),
								'DEL_LINK' => xtc_href_link(FILENAME_SHOPPING_CART, xtc_get_all_get_params().'del='.$products[$i]['id']),
								'PLUS_LINK' => xtc_href_link(FILENAME_SHOPPING_CART, xtc_get_all_get_params().'plus='.$products[$i]['id']),
								'MINUS_LINK' => xtc_href_link(FILENAME_SHOPPING_CART, xtc_get_all_get_params().'minus='.$products[$i]['id']),
								'PRODUCTS_LINK' => xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($products[$i]['id'], $products[$i]['name'])),
								'PRODUCTS_PRICE' => $xtPrice->xtcFormat($products[$i]['price'] * $products[$i]['quantity'], true),
								'PRODUCTS_SINGLE_PRICE' => $xtPrice->xtcFormat($products[$i]['p_single_price'], true),
								'PRODUCTS_SHORT_DESCRIPTION' => $description, 
								'ATTRIBUTES' => '');
	// Product options names

	$count_attr_value = '';
	if ($attributes_exist == 1) {
		reset($products[$i]['attributes']);
		//Check Rabatt Attribute
		// $discount_check = $_SESSION['customers_status']['customers_status_discount_attributes'];
		// $discount =  $products[$i]['products_discount_allowed'];
		while (list ($option, $value) = each($products[$i]['attributes'])) {

			if (ATTRIBUTE_STOCK_CHECK == 'true' && STOCK_CHECK == 'true') {
				$attribute_stock_check = xtc_check_stock_attributes($products[$i][$option]['products_attributes_id'], $products[$i]['quantity']);
				if ($attribute_stock_check)
					$_SESSION['any_out_of_stock'] = 1;
			}
			$price = $products[$i][$option]['options_values_price'];
			
			// if ($discount_check == 1 && $products[$i][$option]['price_prefix'] == '+')
					// $price -= $price / 100 * $discount;
					
			$module_content[$i]['ATTRIBUTES'][] = array ('ID' => $products[$i][$option]['products_attributes_id'],
														'MODEL' => xtc_get_attributes_model(xtc_get_prid($products[$i]['id']), $products[$i][$option]['products_options_values_name'],$products[$i][$option]['products_options_name']),
														'NAME' => $products[$i][$option]['products_options_name'],
														'ATTR_QTY' => ($products[$i][$option]['products_options_name'] != 'Downloads')? $products[$i]['quantity'].'x':'',
														'PRICE' => ($products[$i][$option]['products_options_name'] != 'Downloads')?$xtPrice->xtcFormat($price,true,$products[$i]['tax_class_id']):'',
														'PREFIX' =>  ($products[$i][$option]['products_options_name'] != 'Downloads')?$products[$i][$option]['price_prefix']:'',
														'VALUE_NAME' => $products[$i][$option]['products_options_values_name'].$attribute_stock_check);
			$count_attr_value += $products[$i][$option]['options_values_price'];
		}
	}

}

//Mindestbestellmenge
if(sizeof($minorder) > 0) {
	$_SESSION['any_out_of_minorder_products'] = $minorder;
}

$total_content = '';
$total = $_SESSION['cart']->show_total();
$total_netto = $_SESSION['cart']->show_total();

// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';

if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1' && $_SESSION['customers_status']['customers_status_ot_discount'] != '0.00') {
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		$price = $total - $_SESSION['cart']->show_tax(false);
	} else {
		$price = $total;
	}
	$discount = $xtPrice->xtcGetDC($price, $_SESSION['customers_status']['customers_status_ot_discount']);
	$total_content = '<div class="ot_total">' . $_SESSION['customers_status']['customers_status_ot_discount'].'% '.SUB_TITLE_OT_DISCOUNT.' -'.xtc_format_price($discount, $price_special = 1, $calculate_currencies = false).'</div>';
}

// Kupon-Rabatt Anzeige
if (isset ($_SESSION['cc_id'])) {
	require_once (DIR_FS_INC . 'coupon_mod_functions.php');
	$coupon_deduction = calculate_deduction();
	if ($coupon_deduction[1] > '0' && $coupon_deduction[0] != '1') {
		$total_content .= SUB_TITLE_OT_COUPON . ' -' . $xtPrice->xtcFormat($coupon_deduction[1], true) . '<br />';
	}
}
// ENDE Kupon-Rabatt Anzeige

if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) {
		$total -= $discount;
	} elseif ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		$total -= $discount;
	} else {
		$total -= $discount;
	}
if ($coupon_deduction[1] > '0' && $coupon_deduction[0] != '1') {
	$total -= $coupon_deduction[2];
}
	$netto = $total_netto - $_SESSION['cart']->show_tax(false);
	$module_smarty->assign('TOTAL_CONTENT_NETTO', '<div class="ot_total_netto">'.WK_NETTO.': '.$xtPrice->xtcFormat($netto, true).'</div>');
	$total_content .= '<div class="ot_total">' . SUB_TITLE_SUB_TOTAL.$xtPrice->xtcFormat($total, true).'</div>';
} else {
	$total_content .= '<div class="ot_total">' . NOT_ALLOWED_TO_SEE_PRICES.'</div>';
}
// display only if there is an ot_discount
if ($customer_status_value['customers_status_ot_discount'] != 0) {
	$total_content .= TEXT_CART_OT_DISCOUNT.$customer_status_value['customers_status_ot_discount'].'%';
}
if (SHOW_SHIPPING == 'true') {
	$module_smarty->assign('SHIPPING_INFO', $main->getShippingLink());
}
if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
	$module_smarty->assign('UST_CONTENT', '<div class="ot_tax">' . $_SESSION['cart']->show_tax() . '</div>');
}
// Versandkosten im Warenkorb
include DIR_FS_CATALOG.'includes/modules/shipping_estimate.php';
$module_smarty->assign('TOTAL_CONTENT', $total_content);
$module_smarty->assign('language', $_SESSION['language']);
$module_smarty->assign('module_content', $module_content);

$module_smarty->caching = false;

$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/order_details.html');

$smarty->assign('MODULE_order_details', $module);
