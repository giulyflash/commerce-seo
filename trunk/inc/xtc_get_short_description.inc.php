<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_get_short_description.inc.php
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



   
function xtc_get_short_description($product_id, $language = '') {

	if (empty($language)) $language = $_SESSION['languages_id'];

	$product_query = "SELECT products_short_description from " . TABLE_PRODUCTS_DESCRIPTION . " WHERE products_id = '" . $product_id . "' AND language_id = '" . $language . "'";
	$product_query  = xtDBquery($product_query);
	$product = xtc_db_fetch_array($product_query,true);

	return $product['products_short_description'];
}
?>