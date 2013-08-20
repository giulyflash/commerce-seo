<?php
/*-----------------------------------------------------------------
* 	$Id: blog.php 460 2013-07-08 20:09:51Z akausch $
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
$cats = 0; 
$item = 0;

$categories_query = xtc_db_query("SELECT categories_id, titel, date
								    FROM ".TABLE_BLOG_CATEGORIES."
								    WHERE status = 2
								    AND language_id = '".(int)$_SESSION['languages_id']."'
								    ORDER BY position ASC");

while($categories = xtc_db_fetch_array($categories_query)){

    $categories_array[$cats] = array('CATEGORIE_ID'     => $categories['categories_id'],
								      'CATEGORIE_TITLE'  => $categories['titel'],
								      'CATEGORIE_LINK'   => xtc_href_link(FILENAME_BLOG,'blog_cat='.$categories['categories_id']));
    // Beitraege
	// print_r($_GET);
	if ($_GET['blog_cat'] == '') {
    $blog = xtc_db_fetch_array(xtc_db_query("SELECT categories_id FROM blog_items WHERE item_id = '" . xtc_db_input($_GET['blog_item']) . "' AND language_id = '" . (int) $_SESSION['languages_id'] . "'"));
    $_GET['blog_cat'] = $blog['categories_id'];
	}
	if(isset($_GET['blog_cat']) && $_GET['blog_cat'] !='' && is_numeric($_GET['blog_cat']) && ($_GET['blog_cat'] == $categories['categories_id'])) {
		$items_query = xtc_db_query("SELECT
										item_id, title, date
									FROM
										".TABLE_BLOG_ITEMS."
									WHERE
										status = 2
									AND
										categories_id = '".xtc_db_input($_GET['blog_cat'])."'
									AND
										language_id = '".(int)$_SESSION['languages_id']."'
									ORDER BY
										position ASC");

		$categories_array[$cats]['ITEMS'] = array();
		if(xtc_db_num_rows($items_query)) {
			while($items = xtc_db_fetch_array($items_query)){
	    		if($_GET['blog_item'] == $items['item_id']) {
	    			$blog_id_active = ' blog_active';
	    		} else {
	    			$blog_id_active = '';
				}

				$categories_array[$cats]['ITEMS'][$item] = array(
					'ITEM_ID'     => $items['item_id'],
					'ITEM_TITLE'  => $items['title'],
					'ITEM_ACTIVE' => $blog_id_active,
					'ITEM_LINK'   => xtc_href_link(FILENAME_BLOG,'blog_cat='.$categories['categories_id'].'&blog_item='.$items['item_id'])
				);
				$item++;
			}
		}
	}
    $cats++;
}

$box_smarty->assign('categories', $categories_array);
$box_smarty->assign('language', $_SESSION['language']);
$box_smarty->assign('box_name', getBoxName('blog'));
$box_smarty->assign('box_class_name', getBoxCSSName('blog'));
$box_smarty->assign('LINK',xtc_href_link(FILENAME_BLOG,'blog_cat'));
$box_smarty->assign('html_tpl_path', CURRENT_TEMPLATE.'/html');

if(!CacheCheck()) {
    $box_smarty->caching = false;
    $box_content = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_blog.html');

} else {
  $box_smarty->caching = true;
  $box_smarty->cache_lifetime=CACHE_LIFETIME;
  $box_smarty->cache_modified_check=CACHE_CHECK;
  $cache_id = $_SESSION['language'].'boxblog';
  $box_content = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_blog.html',$cache_id);
}
