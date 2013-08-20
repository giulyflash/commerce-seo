<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_check_stock.inc.php
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



// include needed functions
require_once(DIR_FS_INC . 'xtc_get_products_stock.inc.php');
	function xtc_check_stock($products_id, $products_quantity) {
		$stock_left = xtc_get_products_stock($products_id) - $products_quantity;
		$out_of_stock = '';

		if ($stock_left < 0) {
			$out_of_stock = '<span class="markProductOutOfStock"> ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
		}

	return $out_of_stock;
}
?>
