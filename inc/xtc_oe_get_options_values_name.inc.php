<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_oe_get_options_values_name.inc.php
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



   
  function xtc_oe_get_options_values_name($products_options_values_id, $language = '') {

    if (empty($language)) $language = $_SESSION['languages_id'];

    $product_query = xtDBquery("select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . $products_options_values_id . "' and language_id = '" . $language . "'");
    $product = xtc_db_fetch_array($product_query);

    return $product['products_options_values_name'];
  }
 ?>