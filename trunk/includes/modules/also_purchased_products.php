<?php
/*-----------------------------------------------------------------
* 	$Id: also_purchased_products.php 420 2013-06-19 18:04:39Z akausch $
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



$data = $product->getAlsoPurchased();
if (count($data) >= MIN_DISPLAY_ALSO_PURCHASED) {
	$module_smarty = new Smarty;
	$module_smarty->assign('language', $_SESSION['language']);
	$module_smarty->assign('module_content', $data);
	$module_smarty->assign('also_purchased', true);
	$module_smarty->assign('TITLE', ALSO_PURCHASED);
	$module_smarty->assign('CLASS', 'also_purchased');

	$module_smarty->caching = false;
	$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/product_listing/product_listings.html');
	$info_smarty->assign('MODULE_also_purchased', $module);
}
?>