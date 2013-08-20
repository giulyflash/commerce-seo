<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_currency_exists.inc.php
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




function xtc_currency_exists($code) {
	$param ='/[^a-zA-Z]/';
	$code=preg_replace($param,'',$code);
	$currency_code = xtc_db_query("SELECT code, currencies_id from " . TABLE_CURRENCIES . " WHERE code = '" . $code . "' LIMIT 1");
	if (xtc_db_num_rows($currency_code)) {
		$curr = xtc_db_fetch_array($currency_code);
		if ($curr['code'] == $code) {
			return $code;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
?>