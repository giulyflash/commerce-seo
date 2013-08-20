<?php
/*-----------------------------------------------------------------
* 	$Id: graduated_prices.php 420 2013-06-19 18:04:39Z akausch $
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
$module_content = array ();

$staffel_data = $product->getGraduated();

if (sizeof($staffel_data) > 1) {
	$module_smarty->assign('language', $_SESSION['language']);
	$module_smarty->assign('module_content', $staffel_data);
	// set cache ID

	$module_smarty->caching = false;
	$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/graduated_price.html');

	$info_smarty->assign('MODULE_graduated_price', $module);
}
?>