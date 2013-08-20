<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_get_parent_categories.inc.php
* 	Letzter Stand:			v2.3
* 	zuletzt geaendert von:	cseoak
* 	Datum:					2012/11/19
*
* 	Copyright (c) since 2010 commerce:SEO by Webdesign Erfurt
* 	http://www.commerce-seo.de
* ------------------------------------------------------------------
* 	based on:
* 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
* 	(c) 2002-2003 osCommerce - www.oscommerce.com
* 	(c) 2003     nextcommerce - www.nextcommerce.org
* 	(c) 2005     xt:Commerce - www.xt-commerce.com
* 	Released under the GNU General Public License
* ---------------------------------------------------------------*/



   
// Recursively go through the categories and retreive all parent categories IDs
// TABLES: categories
  function xtc_get_parent_categories(&$categories, $categories_id) {
    $parent_categories_query = "SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE categories_id = '" . $categories_id . "'";
    $parent_categories_query  = xtDBquery($parent_categories_query);
    while ($parent_categories = xtc_db_fetch_array($parent_categories_query,true)) {
		if ($parent_categories['parent_id'] == 0) 
			return true;
		$categories[sizeof($categories)] = $parent_categories['parent_id'];
      	if($parent_categories['parent_id'] != $categories_id) {
        	xtc_get_parent_categories($categories, $parent_categories['parent_id']);
      	}
    }
  }
 ?>