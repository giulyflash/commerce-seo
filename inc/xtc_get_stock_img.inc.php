<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_get_stock_img.inc.php
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




function xtc_get_stock_img($qty) {
	if($qty >= STOCK_WARNING_GREEN)
		$img = '<img src="'.DIR_WS_CATALOG.'admin/images/icons/icon_stock_1.gif" alt="'.$qty.'" />';
	elseif($qty >= STOCK_WARNING_YELLOW)
		$img = '<img src="'.DIR_WS_CATALOG.'admin/images/icons/icon_stock_2.gif" alt="'.$qty.'" />';
	elseif($qty <= STOCK_WARNING_RED)
		$img = '<img src="'.DIR_WS_CATALOG.'admin/images/icons/icon_stock_2.gif" alt="'.$qty.'" />';
	else
		$img = '';

	return $img;
}

?>