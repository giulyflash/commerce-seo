<?php
/*-----------------------------------------------------------------
* 	$Id: main_upcoming_products.php 420 2013-06-19 18:04:39Z akausch $
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

require_once (DIR_FS_INC.'xtc_date_short.inc.php');
$module_content = array ();

$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0')
	$fsk_lock = ' and p.products_fsk18!=1';

if (GROUP_CHECK == 'true')
	$group_check = "and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";

$expected_query = xtDBquery("SELECT 
									p.*,
									pd.*									 
								FROM 
									".TABLE_PRODUCTS." p  
								LEFT JOIN 
									".TABLE_PRODUCTS_DESCRIPTION." pd ON(pd.products_id = p.products_id)
								WHERE 
									to_days(products_date_available) >= to_days(now())
								AND 
									p.products_id = pd.products_id
									".$group_check."
									".$fsk_lock."
								AND 
									pd.language_id = '".(int) $_SESSION['languages_id']."'
								ORDER BY 
									p.products_date_available ".EXPECTED_PRODUCTS_SORT."
								LIMIT 
									".MAX_DISPLAY_UPCOMING_PRODUCTS);
									
if (xtc_db_num_rows($expected_query,true) > 0) {
	$row = 0;
	while ($expected = xtc_db_fetch_array($expected_query,true)) { $row++;
		$module_content[] = $product->buildDataArray($expected, 'thumbnail', 'upcoming_product', $row);
	}

	$module_smarty->assign('language', $_SESSION['language']);
	$module_smarty->assign('module_content', $module_content);
	$module_smarty->assign('TITLE', UPCOMING_PRODUCT);
	$module_smarty->assign('CLASS', 'upcomming_product');
		if (!CacheCheck()) {
			$module_smarty->caching = false;
			$module = $module_smarty->fetch(CURRENT_TEMPLATE . '/module/product_listing/product_listings.html');
		} else {
			$module_smarty->caching = true;
			$module_smarty->cache_lifetime = CACHE_LIFETIME;
			$module_smarty->cache_modified_check = CACHE_CHECK;
			$cache_id = $_SESSION['language'].'_'.$_SESSION['customers_status']['customers_status_id'].'_upcomming_';
			$module = $module_smarty->fetch(CURRENT_TEMPLATE . '/module/product_listing/product_listings.html', $cache_id);
		}

	$default_smarty->assign('MODULE_upcoming_products', $module);
}
