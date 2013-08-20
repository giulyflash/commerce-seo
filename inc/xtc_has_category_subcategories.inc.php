<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_has_category_subcategories.inc.php
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



   
  function xtc_has_category_subcategories($category_id) {
    $child_category_query = "select count(*) as count from " . TABLE_CATEGORIES . " where parent_id = '" . $category_id . "'";
    $child_category_query = xtDBquery($child_category_query);
    $child_category = xtc_db_fetch_array($child_category_query,true);

    if ($child_category['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }
  
 ?>