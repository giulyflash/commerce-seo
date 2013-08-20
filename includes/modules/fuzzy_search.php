<?php
/*-----------------------------------------------------------------
* 	$Id: fuzzy_search.php 420 2013-06-19 18:04:39Z akausch $
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




  // wenn keywords aus Suche übergeben -> fuzzy search
if (($_GET['keywords']) && (SEARCH_ACTIVATE_SUGGEST == 'true')){

  require_once (DIR_FS_INC.'xtc_get_products_image.inc.php');
  require_once (DIR_WS_CLASSES.'class.fuzzy_search.php');

	$keywords = mb_strtolower($_GET['keywords'], 'UTF-8');

	$Suggest = new FuzzySearch();
	$Suggest->getSuggest($keywords);
	$module_content_keywords = $Suggest->resultKeywords;
	$module_content_products = $Suggest->new_fuzzy;
	$parse_time = $Suggest->parse_time;

	if($module_content_keywords)
		$module_smarty->assign('keyword_data', $module_content_keywords);

	if ($module_content_products){
		$info_smarty = new Smarty;
		$info_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
		$info_smarty->assign('language', $_SESSION['language']);
		$info_smarty->assign('module_content', $module_content_products);
                $info_smarty->assign('CLASS', 'product_listing');//JS SCRIPT ERROR WENN NICHT VORHANDEN
		$info_smarty->caching = false;
		$module_smarty->assign('suggest_products', $info_smarty->fetch(CURRENT_TEMPLATE.'/module/product_listing/product_listings.html'));
	} 

	if (SEARCH_SHOW_PARSETIME == 'true')
		$module_smarty->assign('PARSE_TIME', '<small>'.$parse_time.' s</small>');    
}
?>
