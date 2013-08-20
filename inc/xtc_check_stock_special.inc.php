<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_check_stock_special.inc.php
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



   
function xtc_check_stock_special($products_id, $products_quantity) {

	$stock_query=xtDBquery("SELECT
							  specials_quantity
							  FROM 
								".TABLE_SPECIALS."
							  WHERE 
								products_id = '".$products_id."'
							  AND
								status = '1'
							  ");
	
	if (xtc_db_num_rows($stock_query, true) >= 1) {
		$stock_data=xtc_db_fetch_array($stock_query);
		$stock_left = $stock_data['specials_quantity'] - $products_quantity;
		$out_of_stock = '';

		if ($stock_left < 0) {
			$out_of_stock = '<span class="markProductOutOfStock"> ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
		}

		return $out_of_stock;
	}
}
?>