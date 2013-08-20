<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_get_subcategories.inc.php
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



   
  function xtc_get_subcategories(&$subcategories_array, $parent_id = 0) {
    $subcategories_query = "select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . $parent_id . "'";
    $subcategories_query  = xtDBquery($subcategories_query);
    while ($subcategories = xtc_db_fetch_array($subcategories_query,true)) {
      $subcategories_array[sizeof($subcategories_array)] = $subcategories['categories_id'];
      if ($subcategories['categories_id'] != $parent_id) {
        xtc_get_subcategories($subcategories_array, $subcategories['categories_id']);
      }
    }
  }
 ?>