<?php
/*-----------------------------------------------------------------
* 	$Id: specials.php 434 2013-06-25 17:30:40Z akausch $
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

if (!$product->isProduct()) {
	$box_smarty = new smarty;
	// $box_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
	$box_smarty->assign('html_tpl_path', CURRENT_TEMPLATE.'/html');
	require_once (DIR_FS_INC.'xtc_random_select.inc.php');
	
	//fsk18 lock
	$fsk_lock = '';
	if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
		$fsk_lock = ' AND p.products_fsk18 != 1';
	}
	if (GROUP_CHECK == 'true') {
		$group_check = " AND p.group_permission_".$_SESSION['customers_status']['customers_status_id']." = 1 ";
	}
	if ($random_product = xtc_random_select("SELECT
												p.*,
												pd.products_name,
												s.expires_date,
												s.specials_new_products_price
											FROM 
												".TABLE_PRODUCTS." p
											LEFT JOIN
												".TABLE_SPECIALS." s ON(s.products_id = p.products_id)
											LEFT JOIN 
												".TABLE_PRODUCTS_DESCRIPTION." pd ON(pd.products_id = s.products_id AND pd.language_id = '".(int)$_SESSION['languages_id']."')
											WHERE 
												p.products_status = '1'
											AND 
												s.status = '1'
											".$group_check."
											".$fsk_lock."                                             
											ORDER BY s.specials_date_added DESC 
											LIMIT ".MAX_RANDOM_SELECT_SPECIALS)) {
	
		$box_smarty->assign('box_content',$product->buildDataArray($random_product,'thumbnail','specials_box','1'));
		$box_smarty->assign('SPECIALS_LINK', xtc_href_link(FILENAME_SPECIALS));
		$box_smarty->assign('NEWS_BUTTON', xtc_image_button('button_quick_find.gif', IMAGE_BUTTON_MORE_NEWS));
		
		$box_smarty->assign('language', $_SESSION['language']);
		$box_smarty->assign('box_name', getBoxName('specials'));
		$box_smarty->assign('box_class_name', getBoxCSSName('specials'));
		if ($random_product["products_id"] != '') {
			// set cache ID
			 if (!CacheCheck()) {
				$box_smarty->caching = false;
				$box_content = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_specials.html');
			} else {
				$box_smarty->caching = true;
				$box_smarty->cache_lifetime = CACHE_LIFETIME;
				$box_smarty->cache_modified_check = CACHE_CHECK;
				$cache_id = $_SESSION['language'].$random_product["products_id"].$_SESSION['customers_status']['customers_status_name'].'secials';
				$box_content = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_specials.html', $cache_id);
			}
		}
	}
}
