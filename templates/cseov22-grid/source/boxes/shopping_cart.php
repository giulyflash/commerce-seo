<?php
/*-----------------------------------------------------------------
* 	$Id: shopping_cart.php 434 2013-06-25 17:30:40Z akausch $
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
 
if ($_SESSION['customers_status']['customers_status_show_price'] == 1) {
	$box_smarty = new smarty;
	$box_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
	require_once (DIR_FS_INC.'xtc_recalculate_price.inc.php');

	$box_price_string = '';
	
	if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT) or strstr($PHP_SELF, FILENAME_CHECKOUT_CONFIRMATION) or strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING))
		$box_smarty->assign('deny_cart', 'true');
	
	if ($_SESSION['cart']->count_contents() > 0) {
		$products = $_SESSION['cart']->get_products();
		$products_in_cart = array ();
		$qty = 0;
		for ($i = 0, $n = sizeof($products); $i < $n; $i ++) {
			$qty += $products[$i]['quantity'];
			$products_in_cart[] = array ('QTY' => $products[$i]['quantity'], 
										 'LINK' => xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($products[$i]['id'],$products[$i]['name'])), 
										 'NAME' => $products[$i]['name']);
		}
		$box_smarty->assign('PRODUCTS', $qty);
		$box_smarty->assign('empty', 'false');
	} else {
		$box_smarty->assign('empty', 'true');
	}
	
	if ($_SESSION['cart']->count_contents() > 0) {
		
		$total =$_SESSION['cart']->show_total();
	if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1' && $_SESSION['customers_status']['customers_status_ot_discount'] != '0.00') {
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
			$price = $total-$_SESSION['cart']->show_tax(false);
		} else {
			$price = $total;
		}
		$discount = $xtPrice->xtcGetDC($price, $_SESSION['customers_status']['customers_status_ot_discount']);
		$box_smarty->assign('DISCOUNT', $xtPrice->xtcFormat(($discount * (-1)), $price_special = 1, $calculate_currencies = false));
		
	}
	
	if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) $total-=$discount;
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) $total-=$discount;
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) $total-=$discount;
		$box_smarty->assign('TOTAL', $xtPrice->xtcFormat($total, true));
	} 
		
		$box_smarty->assign('UST', $_SESSION['cart']->show_tax());
		
		if (SHOW_SHIPPING=='true') { 
				$box_smarty->assign('SHIPPING_INFO',' '.SHIPPING_EXCL.'<a href="'.xtc_href_link(FILENAME_POPUP_CONTENT, 'coID='.SHIPPING_INFOS).'" class="shipping">'.SHIPPING_COSTS.'</a>');
		}			
	}
	if (ACTIVATE_GIFT_SYSTEM == 'true') {
		$box_smarty->assign('ACTIVATE_GIFT', 'true');
	}
	
	// GV Code Start
	if (isset ($_SESSION['customer_id'])) {
		$gv_query = xtc_db_query("select amount from ".TABLE_COUPON_GV_CUSTOMER." where customer_id = '".$_SESSION['customer_id']."'");
		$gv_result = xtc_db_fetch_array($gv_query);
		if ($gv_result['amount'] > 0) {
			$box_smarty->assign('GV_AMOUNT', $xtPrice->xtcFormat($gv_result['amount'], true, 0, true));
			$box_smarty->assign('GV_SEND_TO_FRIEND_LINK', '<a href="'.xtc_href_link(FILENAME_GV_SEND).'">');
		}
	}
	if (isset ($_SESSION['gv_id'])) {
		$gv_query = xtc_db_query("select coupon_amount from ".TABLE_COUPONS." where coupon_id = '".$_SESSION['gv_id']."'");
		$coupon = xtc_db_fetch_array($gv_query);
		$box_smarty->assign('COUPON_AMOUNT2', $xtPrice->xtcFormat($coupon['coupon_amount'], true, 0, true));
	}
	if (isset ($_SESSION['cc_id'])) {
		$box_smarty->assign('COUPON_HELP_LINK', '<a href="'.xtc_href_link(FILENAME_POPUP_COUPON_HELP, 'cID='.$_SESSION['cc_id']).'" class="shipping">'.GV_FAQ.'</a>');
	}
	// GV Code End
	$box_smarty->assign('LINK_CART', xtc_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
	$box_smarty->assign('NEWS_BUTTON', cseo_wk_image_button('button_quick_find.gif', IMAGE_BUTTON_TO_CART));
	$box_smarty->assign('products', $products_in_cart);
	
	$box_smarty->caching = false;
	$box_smarty->assign('language', $_SESSION['language']);
	$box_smarty->assign('html_tpl_path', CURRENT_TEMPLATE.'/html');
	$box_smarty->assign('box_name', getBoxName('shopping_cart'));
	$box_smarty->assign('box_class_name', getBoxCSSName('shopping_cart'));
	$box_content = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_cart.html');
}
