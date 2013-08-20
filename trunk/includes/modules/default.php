<?php
/*-----------------------------------------------------------------
* 	$Id: default.php 453 2013-07-03 20:17:29Z akausch $
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

$default_smarty = new smarty;

$default_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$default_smarty->assign('session', session_id());
$main_content = '';

require_once (DIR_FS_INC.'xtc_customer_greeting.inc.php');
require_once (DIR_FS_INC.'xtc_get_path.inc.php');
require_once (DIR_FS_INC.'xtc_check_categories_status.inc.php');

if(xtc_check_categories_status($current_category_id) >= 1) {
	$error = CATEGORIE_NOT_FOUND;
	include (DIR_WS_MODULES.FILENAME_ERROR_HANDLER);

} else {
	if(GROUP_CHECK == 'true') {
		$group_check_c = "AND c.group_permission_".$_SESSION['customers_status']['customers_status_id']." = 1 "; // Kategorie
		$group_check_p = "AND p.group_permission_".$_SESSION['customers_status']['customers_status_id']." = 1 "; // Produkt
	}

	if ($category_depth == 'nested') {

		$category_query = "SELECT
		                    	cd.*,
		                        c.*
		                   FROM
		                   		".TABLE_CATEGORIES." c 
								INNER JOIN ".TABLE_CATEGORIES_DESCRIPTION." cd ON(cd.categories_id = '".$current_category_id."' AND cd.language_id = '".(int) $_SESSION['languages_id']."')
		                   WHERE
		                   		c.categories_id = '".$current_category_id."'
		                        ".$group_check_c."";

		$category_query = xtDBquery($category_query);
		$category = xtc_db_fetch_array($category_query, true);
		if(isset ($cPath) && preg_match('/_/', $cPath)) {
			$category_links = array_reverse($cPath_array);
			for ($i = 0, $n = sizeof($category_links); $i < $n; $i ++) {

				$categories_query = "SELECT
										cd.*,
										c.*
									FROM
										".TABLE_CATEGORIES." c 
										INNER JOIN ".TABLE_CATEGORIES_DESCRIPTION." cd ON(c.categories_id = cd.categories_id AND cd.language_id = '".(int) $_SESSION['languages_id']."')
									WHERE
										c.categories_status = '1'
									AND
										c.parent_id = '".$category_links[$i]."'
										".$group_check_c."
									ORDER BY
										sort_order, cd.categories_name";
				$categories_query = xtDBquery($categories_query);

				if (xtc_db_num_rows($categories_query, true) >= 1)
	    			break;
			}
		} else {

			$categories_query = "SELECT
									cd.*,
									c.*
								FROM
									".TABLE_CATEGORIES." c 
									INNER JOIN ".TABLE_CATEGORIES_DESCRIPTION." cd ON(c.categories_id = cd.categories_id AND cd.language_id = '".(int) $_SESSION['languages_id']."')
								WHERE
									c.categories_status = '1'
								AND
									c.parent_id = '".$current_category_id."'
									".$group_check_c."
								ORDER BY
									sort_order, cd.categories_name";
			$categories_query = xtDBquery($categories_query);
		}

		$rows = 0;
		//Unterkategorien anzeigen
		while ($categories = xtc_db_fetch_array($categories_query, true)) {
			$rows ++;

			$cPath_new = xtc_category_link($categories['categories_id'],$categories['categories_name']);

			$image = '';
			if ($categories['categories_image'] != '') {
				$image = xtc_image(DIR_WS_IMAGES.'categories/'.$categories['categories_image'],($categories['categories_heading_title'] !='' ? $categories['categories_heading_title'] : $categories['categories_name']), ($categories['categories_pic_alt'] !='' ? $categories['categories_pic_alt'] : $categories['categories_name']));
				if(!file_exists(DIR_WS_IMAGES.'categories/'.$categories['categories_image'])) $image = xtc_image(DIR_WS_IMAGES.'categories/noimage.gif', ($categories['categories_pic_alt'] !='' ? $categories['categories_pic_alt'] : $categories['categories_name']), ($categories['categories_heading_title'] !='' ? $categories['categories_heading_title'] : $categories['categories_name']));
			}
			
			if (DISPLAY_MORE_CAT_DESC == 'true') {
				$cat_desc = $categories['categories_short_description'];
			} else {
				$cat_desc = '';
			}
			
			$categories_content[] = array ('CATEGORIES_NAME' => $categories['categories_name'],
	  										'CATEGORIES_HEADING_TITLE' => $categories['categories_heading_title'],
	  										'CATEGORIES_IMAGE' => $image,
	  										'CATEGORIES_LINK' => xtc_href_link(FILENAME_DEFAULT, $cPath_new),
	  										'CATEGORIES_DESCRIPTION' => $cat_desc,
	  										'CATEGORIES_DESCRIPTION_FOOTER' => $categories['categories_description_footer']);
		}
		$new_products_category_id = $current_category_id;
		include (DIR_WS_MODULES.FILENAME_NEW_PRODUCTS);

		$image = '';
		if ($category['categories_image'] != '') {
			$image = xtc_image(DIR_WS_IMAGES.'categories_info/'.$category['categories_image'], ($category['categories_heading_title'] !='' ? $category['categories_heading_title'] : $category['categories_name']), ($category['categories_pic_alt'] !='' ? $category['categories_pic_alt'] : $category['categories_name']));
		}
		$image_footer = '';
		if ($category['categories_footer_image'] != '') {
			$image_footer = xtc_image(DIR_WS_IMAGES.'categories_footer/'.$category['categories_footer_image'], ($category['categories_heading_title'] !='' ? $category['categories_heading_title'] : $category['categories_name']), ($category['categories_pic_footer_alt'] !='' ? $category['categories_pic_footer_alt'] : $category['categories_name']));
		}
		//Hauptkategorie Beschreibung etc.
		$default_smarty->assign('CATEGORIES_NAME', $category['categories_name']);
		$default_smarty->assign('CATEGORIES_HEADING_TITLE', $category['categories_heading_title']);
		$default_smarty->assign('CATEGORIES_IMAGE', $image);
		$default_smarty->assign('CATEGORIES_FOOTER_IMAGE', $image_footer);
		$default_smarty->assign('CATEGORIES_DESCRIPTION', $category['categories_description']);
		$default_smarty->assign('CATEGORIES_DESCRIPTION_FOOTER', $category['categories_description_footer']);
		$default_smarty->assign('CATEGORIES_IMAGE_DIMENSION', cseo_get_img_size($image));
		
		$default_smarty->assign('language', $_SESSION['language']);
		$default_smarty->assign('DEVMODE', USE_TEMPLATE_DEVMODE);
		$default_smarty->assign('module_content', $categories_content);

		if($category['categories_template'] == '' or $category['categories_template'] == 'default') {
			$files = array ();
			if($dir = opendir(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/categorie_listing/')) {
				while(($file = readdir($dir)) !== false) {
					if(is_file(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/categorie_listing/'.$file) && (substr($file, -5) == '.html') && ($file != 'index.html') && (substr($file, 0, 1) !='.'))
						$files[] = $file;
				}
				closedir($dir);
			}
			sort($files);
			$category['categories_template'] = $files[0];
		}
		
		$default_smarty->caching = false;
		$main_content = $default_smarty->fetch(CURRENT_TEMPLATE.'/module/categorie_listing/'.$category['categories_template']);
	
		$smarty->assign('main_content', $main_content);
	} elseif ($category_depth == 'products' || (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] > 0)) {
  	//fsk18 lock
	$fsk_lock = '';
	if($_SESSION['customers_status']['customers_fsk18_display'] == '0')
		$fsk_lock = ' AND p.products_fsk18!=1';

	if(isset($_GET['manufacturers_id'])) {

 		$sorting_data = xtc_db_fetch_array(xtDBquery("SELECT products_sorting, products_sorting2 FROM ".TABLE_CATEGORIES." WHERE categories_id='".$new_products_category_id."';"));

		if($sorting_data['products_sorting'] == '')
			$sorting_data['products_sorting'] = 'pd.products_name';

	  	if(isset($_GET['filter_id']) && xtc_not_null($_GET['filter_id'])) {
			if ($_GET['multisort'] == 'specialprice' || $_GET['multisort'] == 'new_asc' || $_GET['multisort'] == 'new_desc' || $_GET['multisort'] == 'name_asc' || $_GET['multisort'] == 'name_desc' || $_GET['multisort'] == 'price_asc' || $_GET['multisort'] == 'price_desc' || $_GET['multisort'] == 'manu_asc' || $_GET['multisort'] == 'manu_desc') {
			switch ($_GET['multisort']) {
			    case 'specialprice':
				  $sorting = ' GROUP BY p.products_id ORDER BY s.specials_new_products_price DESC';
				  $field = ' INNER JOIN '.TABLE_SPECIALS.' s ON(p.products_id = s.products_id )';
			      break;
			    case 'new_asc':
			      $sorting = ' ORDER BY p.products_date_added ASC';
			      break;
			    case 'new_desc':
			      $sorting = ' ORDER BY p.products_date_added DESC';
			      break;
			    case 'name_asc':
			      $sorting = ' ORDER BY pd.products_name ASC';
			      break;
			    case 'name_desc':
			      $sorting = ' ORDER BY pd.products_name DESC';
			      break;
			    case 'price_asc':
			      $sorting = ' ORDER BY p.products_price ASC';
			      break;
			    case 'price_desc':
			      $sorting = ' ORDER BY p.products_price DESC';
			      break;
			    case 'manu_asc':
			      $sorting = ' ORDER BY m.manufacturers_name ASC';
			      break;
			    case 'manu_desc':
			      $sorting = ' ORDER BY m.manufacturers_name DESC';
			      break;
			    default:
			      $sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
		 	}
		 	} else {
				$sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
			}
			

	    // We are asked to show only a specific category
	    $listing_sql = "SELECT DISTINCT 
							p.*,
							m.*,
							pd.*
						FROM 
							".TABLE_PRODUCTS." p
							INNER JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." p2c ON(p.products_id = p2c.products_id)
							INNER JOIN ".TABLE_PRODUCTS_DESCRIPTION." pd ON(pd.products_id = p2c.products_id) 
							INNER JOIN ".TABLE_MANUFACTURERS." m ON(p.manufacturers_id = m.manufacturers_id AND m.manufacturers_id = '".(int) $_GET['manufacturers_id']."')
						".$field."
						WHERE 
							p.products_status = '1'
						AND 
							(p.products_slave_in_list = '1' OR p.products_master = '1' OR ((p.products_slave_in_list = '0' OR p.products_slave_in_list = '') AND (p.products_master_article = '' OR p.products_master_article = '0')))
						".$group_check_p."
						".$fsk_lock."
						AND 
							pd.language_id = '".(int) $_SESSION['languages_id']."'
						AND 
							p2c.categories_id = '".(int) $_GET['filter_id']."'".$sorting;
	  } else {
		if ($_GET['multisort'] == 'specialprice' || $_GET['multisort'] == 'new_asc' || $_GET['multisort'] == 'new_desc' || $_GET['multisort'] == 'name_asc' || $_GET['multisort'] == 'name_desc' || $_GET['multisort'] == 'price_asc' || $_GET['multisort'] == 'price_desc' || $_GET['multisort'] == 'manu_asc' || $_GET['multisort'] == 'manu_desc') {
			switch ($_GET['multisort']) {
			    case 'specialprice':
				  $sorting = ' GROUP BY p.products_id ORDER BY s.specials_new_products_price DESC';
				  $field = ' INNER JOIN '.TABLE_SPECIALS.' s ON(p.products_id = s.products_id)';
			      break;
			    case 'new_asc':
			      $sorting = ' ORDER BY p.products_date_added ASC';
			      break;
			    case 'new_desc':
			      $sorting = ' ORDER BY p.products_date_added DESC';
			      break;
			    case 'name_asc':
			      $sorting = ' ORDER BY pd.products_name ASC';
			      break;
			    case 'name_desc':
			      $sorting = ' ORDER BY pd.products_name DESC';
			      break;
			    case 'price_asc':
			      $sorting = ' ORDER BY p.products_price ASC';
			      break;
			    case 'price_desc':
			      $sorting = ' ORDER BY p.products_price DESC';
			      break;
			    case 'manu_asc':
			      $sorting = ' ORDER BY m.manufacturers_name ASC';
			      break;
			    case 'manu_desc':
			      $sorting = ' ORDER BY m.manufacturers_name DESC';
			      break;
			    default:
			    	$sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
			}
		} else {
			$sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
		}
			$listing_sql = "SELECT
								p.*,
								pd.*,
								m.*
							FROM
								".TABLE_PRODUCTS." p
								INNER JOIN ".TABLE_PRODUCTS_DESCRIPTION." pd ON(pd.products_id = p.products_id)
								INNER JOIN ".TABLE_MANUFACTURERS." m ON(p.manufacturers_id = m.manufacturers_id AND m.manufacturers_id = '".(int) $_GET['manufacturers_id']."')
							".$field."
							WHERE
								p.products_status = '1'
							AND 
								(p.products_slave_in_list = '1' OR p.products_master = '1' OR ((p.products_slave_in_list = '0' OR p.products_slave_in_list = '') AND (p.products_master_article = '' OR p.products_master_article = '0')))
							AND
								pd.language_id = '".(int) $_SESSION['languages_id']."'".
								$group_check_p.$fsk_lock.$sorting;
			}

	  } else {
		// Hersteller ist drin
	 	if (isset($_GET['filter_id']) && xtc_not_null($_GET['filter_id'])) {
		    // sorting query
		    $sorting_data = xtc_db_fetch_array(xtDBquery("SELECT products_sorting, products_sorting2 FROM ".TABLE_CATEGORIES." WHERE categories_id='".$current_category_id."';"));

		    if($sorting_data['products_sorting']=='')
			    $sorting_data['products_sorting'] = 'pd.products_name';
		    $sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
			if ($_GET['multisort'] == 'specialprice' || $_GET['multisort'] == 'new_asc' || $_GET['multisort'] == 'new_desc' || $_GET['multisort'] == 'name_asc' || $_GET['multisort'] == 'name_desc' || $_GET['multisort'] == 'price_asc' || $_GET['multisort'] == 'price_desc' || $_GET['multisort'] == 'manu_asc' || $_GET['multisort'] == 'manu_desc') {
				switch ($_GET['multisort']) {
				case 'specialprice':
					$field = ' INNER JOIN '.TABLE_SPECIALS.' s ON ( p.products_id = s.products_id )';
					$sorting = ' GROUP BY p.products_id ORDER BY s.specials_new_products_price DESC';
					break;
				case 'new_asc':
					$sorting = ' ORDER BY p.products_date_added ASC';
					break;
				case 'new_desc':
					$sorting = ' ORDER BY p.products_date_added DESC';
					break;
				case 'name_asc':
					$sorting = ' ORDER BY pd.products_name ASC';
					break;
				case 'name_desc':
					$sorting = ' ORDER BY pd.products_name DESC';
					break;
				case 'price_asc':
					$sorting = ' ORDER BY p.products_price ASC';
					break;
				case 'price_desc':
					$sorting = ' ORDER BY p.products_price DESC';
					break;
				case 'manu_asc':
					$sorting = ' ORDER BY m.manufacturers_name ASC';
					break;
				case 'manu_desc':
					$sorting = ' ORDER BY m.manufacturers_name DESC';
					break;
				default:
					$sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
				}
			} else {
				$sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
			}
		    $listing_sql = "SELECT
		    					p.*,
								pd.*,
								m.*
							FROM
								".TABLE_PRODUCTS." p
								INNER JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." p2c ON(p.products_id = p2c.products_id)
								INNER JOIN ".TABLE_PRODUCTS_DESCRIPTION." pd ON(pd.products_id = p2c.products_id AND pd.language_id = '".(int) $_SESSION['languages_id']."')
								INNER JOIN ".TABLE_MANUFACTURERS." m ON(p.manufacturers_id = m.manufacturers_id AND m.manufacturers_id = '".(int) $_GET['filter_id']."')
								".$field."
							WHERE
								p.products_status = '1'
							AND 
								(p.products_slave_in_list = '1' OR p.products_master = '1' OR ((p.products_slave_in_list = '0' OR p.products_slave_in_list = '') AND (p.products_master_article = '' OR p.products_master_article = '0')))
							AND
								p2c.categories_id = '".$current_category_id."'"
								.$group_check_p
								.$fsk_lock
								.$sorting;
	  } else {
		//normale Kategorie
	    $sorting_data = xtc_db_fetch_array(xtDBquery("SELECT products_sorting, products_sorting2 FROM ".TABLE_CATEGORIES." where categories_id='".$current_category_id."';"));

	    if(!$sorting_data['products_sorting'])
	    	$sorting_data['products_sorting'] = 'pd.products_name';
			
	    $sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
		if ($_GET['multisort'] == 'specialprice' || $_GET['multisort'] == 'new_asc' || $_GET['multisort'] == 'new_desc' || $_GET['multisort'] == 'name_asc' || $_GET['multisort'] == 'name_desc' || $_GET['multisort'] == 'price_asc' || $_GET['multisort'] == 'price_desc' || $_GET['multisort'] == 'manu_asc' || $_GET['multisort'] == 'manu_desc') {
			switch ($_GET['multisort']) {
				case 'specialprice':
				  $sorting = ' GROUP BY p.products_id ORDER BY s.specials_new_products_price DESC';
				  $field = ' INNER JOIN '.TABLE_SPECIALS.' s ON ( p.products_id = s.products_id AND s.status = 1)';
				  break;
				case 'new_asc':
				  $sorting = ' ORDER BY p.products_date_added ASC';
				  break;
				case 'new_desc':
				  $sorting = ' ORDER BY p.products_date_added DESC';
				  break;
				case 'name_asc':
				  $sorting = ' ORDER BY pd.products_name ASC';
				  break;
				case 'name_desc':
				  $sorting = ' ORDER BY pd.products_name DESC';
				  break;
				case 'price_asc':
				  $sorting = ' ORDER BY p.products_price ASC';
				  break;
				case 'price_desc':
				  $sorting = ' ORDER BY p.products_price DESC';
				  break;
				case 'manu_asc':
				  $sorting = ' ORDER BY m.manufacturers_name ASC';
				  $field = ' INNER JOIN '.TABLE_MANUFACTURERS.' m ON ( p.manufacturers_id = m.manufacturers_id )';
				  break;
				case 'manu_desc':
				  $sorting = ' ORDER BY m.manufacturers_name DESC';
				  $field = ' INNER JOIN '.TABLE_MANUFACTURERS.' m ON ( p.manufacturers_id = m.manufacturers_id )';
				  break;
				default:
					$sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
			}
			} else {
				$sorting = ' ORDER BY '.$sorting_data['products_sorting'].' '.$sorting_data['products_sorting2'].' ';
			}
		$listing_sql = "SELECT DISTINCT
							p.*,
							pd.*
						FROM
							".TABLE_PRODUCTS." p
							INNER JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." p2c ON (p2c.categories_id = '".$current_category_id."')
							INNER JOIN ".TABLE_PRODUCTS_DESCRIPTION." pd ON (pd.products_id = p2c.products_id AND pd.language_id = '".(int)$_SESSION['languages_id']."')
						".$field."
						WHERE
							p.products_status = '1'
						AND 
							(p.products_slave_in_list = '1' OR p.products_master = '1' OR ((p.products_slave_in_list = '0' OR p.products_slave_in_list = '') AND (p.products_master_article = '' OR p.products_master_article = '0')))
						AND
							p.products_id = p2c.products_id
						".$group_check_p."
						".$fsk_lock."
						".$sorting;
		}
	}

		if(isset($_GET['manufacturers_id'])) {
			$filterlist_query = xtDBquery("SELECT DISTINCT
									c.categories_id as id,
									cd.categories_name as name
								FROM
									".TABLE_PRODUCTS." AS p
									INNER JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." AS p2c ON(p.products_id = p2c.products_id)
									INNER JOIN ".TABLE_CATEGORIES." AS c ON(p2c.categories_id = c.categories_id AND c.categories_status = 1)
									INNER JOIN ".TABLE_CATEGORIES_DESCRIPTION." AS cd ON(p2c.categories_id = cd.categories_id AND cd.language_id = '".(int) $_SESSION['languages_id']."')
								WHERE
									p.products_status = '1'
								AND
									p.manufacturers_id = '".(int) $_GET['manufacturers_id']."'
								ORDER BY
									cd.categories_name;");
		} else {
			$filterlist_query = xtDBquery("SELECT DISTINCT
									m.manufacturers_id as id,
									m.manufacturers_name as name
								FROM
									".TABLE_PRODUCTS." AS p
									INNER JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." AS p2c ON(p.products_id = p2c.products_id AND p2c.categories_id = '".$current_category_id."')
									INNER JOIN ".TABLE_MANUFACTURERS." AS m ON(p.manufacturers_id = m.manufacturers_id)
								WHERE
									p.products_status = '1'
								ORDER BY
									m.manufacturers_name;");
		}

		if (xtc_db_num_rows($filterlist_query) > 1) {
		    $manufacturer_dropdown = xtc_draw_form('filter', $_SERVER['REQUEST_URI'], 'get');
		    if (isset ($_GET['manufacturers_id'])) {
		    	$manufacturer_dropdown .= xtc_draw_hidden_field('manufacturers_id', (int)$_GET['manufacturers_id']);
		    	$options = array (array ('text' => TEXT_ALL_CATEGORIES));
		    } else {
		    	$options = array (array ('text' => TEXT_ALL_MANUFACTURERS));
		    }
			if($_GET['page'] != '') {
		   		$manufacturer_dropdown .= xtc_draw_hidden_field('page', $_GET['page']);
			}
		    if($_GET['cPath'] != '' && MODULE_COMMERCE_SEO_INDEX_STATUS != 'True') {
		   		$manufacturer_dropdown .= xtc_draw_hidden_field('cPath', $_GET['cPath']);
			}
		    if($_GET['multisort'] != '') {
		   		$manufacturer_dropdown .= xtc_draw_hidden_field('multisort', $_GET['multisort']);
			}
		   	if($_GET['result'] != '') {
		   		$manufacturer_dropdown .= xtc_draw_hidden_field('result', $_GET['result']);
			}

		    while ($filterlist = xtc_db_fetch_array($filterlist_query)) {
		    	$options[] = array ('id' => $filterlist['id'], 'text' => $filterlist['name']);
			}

		    $manufacturer_dropdown .= xtc_draw_pull_down_menu('filter_id', $options, $_GET['filter_id'], 'onchange="javascript:this.form.submit();"');
		    $manufacturer_dropdown .= '</form>'."\n";
		}

		if(PRODUCT_LIST_FILTER_SORT == 'true') {
			$multisort_dropdown = xtc_draw_form('multisort', $_SERVER['REQUEST_URI'], 'GET') . "\n";

			if($_GET['page'] != '')
		   		$multisort_dropdown .= xtc_draw_hidden_field('page', $_GET['page']);

		    if($_GET['cPath'] != '' && MODULE_COMMERCE_SEO_INDEX_STATUS != 'True')
		   		$multisort_dropdown .= xtc_draw_hidden_field('cPath', $_GET['cPath']);
			if (isset($_GET['manufacturers_id']))
				$multisort_dropdown .= xtc_draw_hidden_field('manufacturers_id', $_GET['manufacturers_id']);
				
		   	if($_GET['result'] != '')
		   		$manufacturer_dropdown .= xtc_draw_hidden_field('result', $_GET['result']);
				

			if(isset($_GET['filter_id']))
				$multisort_dropdown .= xtc_draw_hidden_field('filter_id', (int)$_GET['filter_id']);

			// Abfrage, ob Sonderangebote da sind
			$specials_query_raw = xtDBquery("SELECT 
												s.products_id
											FROM 
												".TABLE_SPECIALS." AS s
											INNER JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." AS ptc ON(ptc.products_id = s.products_id AND ptc.categories_id = ".$current_category_id.")
											WHERE 
												status = '1'");
			$count_specials = xtc_db_num_rows($specials_query_raw);
			$options = array(
			  array('text' => MULTISORT_STANDARD));
				if (($count_specials > 0)) {
					$options[] = array('id' => 'specialprice', 'text' => MULTISORT_SPECIALS_DESC);
				}
				$options[] = array('id' => 'new_desc', 'text' => MULTISORT_NEW_DESC);
				$options[] = array('id' => 'new_asc',  'text' => MULTISORT_NEW_ASC);
				$options[] = array('id' => 'price_asc', 'text' => MULTISORT_PRICE_ASC);
				$options[] = array('id' => 'price_desc', 'text' => MULTISORT_PRICE_DESC);
				$options[] = array('id' => 'name_asc', 'text' => MULTISORT_ABC_AZ);
				$options[] = array('id' => 'name_desc', 'text' => MULTISORT_ABC_ZA);
				$options[] = array('id' => 'manu_asc', 'text' => MULTISORT_MANUFACTURER_ASC);
				$options[] = array('id' => 'manu_desc', 'text' => MULTISORT_MANUFACTURER_DESC);

			$multisort_dropdown .= xtc_draw_pull_down_menu('multisort', $options, $_GET['multisort'], 'onchange="javascript:this.form.submit();"') . "\n";
			$multisort_dropdown .= '</form>' . "\n";
		}

		include (DIR_WS_MODULES.FILENAME_PRODUCT_LISTING);

	} else { 
	// Content Manager default page
		if (GROUP_CHECK == 'true')
			$group_check = " AND group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";

		$shop_content_query = xtDBquery("SELECT
											*
											FROM 
												".TABLE_CONTENT_MANAGER."
											WHERE 
												content_group='5'
												".$group_check."
											AND 
												languages_id='".(int)$_SESSION['languages_id']."'");
												
		$shop_content_data = xtc_db_fetch_array($shop_content_query,true);

		$default_smarty -> assign('title', ($shop_content_data['content_heading']));
		include (DIR_WS_INCLUDES.FILENAME_CENTER_MODULES);

		if ($shop_content_data['content_file'] != '') {
			ob_start();
			if (strpos($shop_content_data['content_file'], '.txt'))
				echo '<pre>';

			include (DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);

			if (strpos($shop_content_data['content_file'], '.txt'))
				echo '</pre>';
			$shop_content_data['content_text'] = ob_get_contents();
			ob_end_clean();
		}
			$default_smarty->assign('text', str_replace('{$greeting}', xtc_customer_greeting(), $shop_content_data['content_text']));
			
		if (GROUP_CHECK == 'true')
			$group_check = " AND group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
			
		$shop_content_footer_data = xtc_db_fetch_array(xtDBquery("SELECT
											*
											FROM 
												".TABLE_CONTENT_MANAGER."
											WHERE 
												content_group='15'
												".$group_check."
											AND 
												languages_id='".$_SESSION['languages_id']."'"));
		
		if ($shop_content_footer_data['content_heading'] != '') {
			$default_smarty->assign('title_footer', $shop_content_footer_data['content_heading']);
		}
		if ($shop_content_footer_data['content_text'] != '') {
			$default_smarty->assign('text_footer', $shop_content_footer_data['content_text']);
		}

		
		$default_smarty->assign('language', $_SESSION['language']);
		$default_smarty->assign('DEVMODE', USE_TEMPLATE_DEVMODE);
		// print_r(getSorting());

	  // set cache ID
		if(!CacheCheck()) {
	  		$default_smarty->caching = false;
			$main_content = $default_smarty->fetch(CURRENT_TEMPLATE.'/module/main_content.html');
	  	} else {
	  		$default_smarty->caching = true;
	  		$default_smarty->cache_lifetime = CACHE_LIFETIME;
	  		$default_smarty->cache_modified_check = CACHE_CHECK;
	  		$cache_id = $_SESSION['language'].$_SESSION['currency'].$_SESSION['customer_id'];
			$main_content = $default_smarty->fetch(CURRENT_TEMPLATE.'/module/main_content.html', $cache_id);
	  	}
	  	$smarty->assign('main_content', $main_content);
	}
}
?>