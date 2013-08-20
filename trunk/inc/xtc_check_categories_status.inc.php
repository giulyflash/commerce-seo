<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_check_categories_status.inc.php
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




function xtc_check_categories_status($categories_id) {

	if (!$categories_id)
		return 0;

	$categorie_query = "SELECT
	                                   parent_id,
	                                   categories_status
	                                   FROM ".TABLE_CATEGORIES."
	                                   WHERE
	                                   categories_id = '".(int) $categories_id."'";

	$categorie_query = xtDBquery($categorie_query);

	$categorie_data = xtc_db_fetch_array($categorie_query, true);
	if ($categorie_data['categories_status'] == 0) {
		return 1;
	} else {
		if ($categorie_data['parent_id'] != 0) {
			if (xtc_check_categories_status($categorie_data['parent_id']) >= 1)
				return 1;
		}
		return 0;
	}

}

function xtc_get_categoriesstatus_for_product($product_id) {

	$categorie_query = "SELECT
	                                   categories_id
	                                   FROM ".TABLE_PRODUCTS_TO_CATEGORIES."
	                                   WHERE products_id='".$product_id."'";

	$categorie_query = xtDBquery($categorie_query);

	while ($categorie_data = xtc_db_fetch_array($categorie_query, true)) {
		if (xtc_check_categories_status($categorie_data['categories_id']) >= 1) {
			return 1;
		} else {
			return 0;
		}
		echo $categorie_data['categories_id'];
	}

}
?>