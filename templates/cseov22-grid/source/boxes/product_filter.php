<?php
/*-----------------------------------------------------------------
* 	$Id: product_filter.php 434 2013-06-25 17:30:40Z akausch $
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

$box_smarty = new smarty;
$box_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

$categories_array = array();
$cats = 0; $item = 0;

// Kategorien laden

$categories_query = xtc_db_query("SELECT
										id, titel, categories_ids
									FROM
										".TABLE_PRODUCT_FILTER_CATEGORIES."
									WHERE
										status = 1
									AND
										language_id = '".$_SESSION['languages_id']."'
									ORDER BY
										position ASC");

if(isset($_GET['cPath'])) {
	$catID = explode('_', $_GET['cPath']);
	$new_catID = array_reverse($catID);
	$new_catID = $new_catID[0];

} elseif (isset($_GET['advanced_filter']))
	$new_catID = $_GET['advanced_filter'];

while($categories = xtc_db_fetch_array($categories_query)){

	$checkID = explode('|', $categories['categories_ids']);

	if(in_array($new_catID, $checkID) || $categories['categories_ids'] == 'all') {
		$categories_array[$cats] = array(	'CATEGORIE_ID'     => $categories['id'],
											'CATEGORIE_TITLE'  => $categories['titel'],
											'ITEMS'            => '');

		$items_query = xtc_db_query("SELECT
										id, title
									FROM
										".TABLE_PRODUCT_FILTER_ITEMS."
									WHERE
										status = 1
									AND
										filter_categories_id = '".$categories['id']."'
									AND
										language_id = '".$_SESSION['languages_id']."'
									ORDER BY
										position ASC");

		while($items = xtc_db_fetch_array($items_query)){
			$categories_array[$cats]['ITEMS'][$item] = array('ITEM_ID'    => $items['id'],
															'ITEM_TITLE'  => $items['title'],
															'ITEM_LINK'   => xtc_href_link(FILENAME_PRODUCT_FILTER,'fcat='.$categories['id'].'&item='.$items['id'].(is_numeric($new_catID)?'&category='.$new_catID:'')));
			$item++;
		}
		$cats++;
	}
}

if (empty($categories_array))
	$box_smarty->assign('empty', true);
else
	$box_smarty->assign('categories', $categories_array);


$box_smarty->assign('language', $_SESSION['language']);
$box_smarty->assign('html_tpl_path', CURRENT_TEMPLATE.'/html');
$box_smarty->assign('box_name', getBoxName('product_filter'));
$box_smarty->assign('box_class_name', getBoxCSSName('product_filter'));

$box_smarty->assign('ADVANCED_LINK', '<a  href="'.xtc_href_link(FILENAME_PRODUCT_FILTER,(is_numeric($new_catID)?'advanced_filter='.$new_catID:'advanced_filter')).'"><b>erweiterter Filter</b></a>');

$box_smarty->caching = false;
$box_content = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_product_filter.html');
