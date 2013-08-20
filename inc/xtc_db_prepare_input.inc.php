<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_db_prepare_input.inc.php
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


  
function xtc_db_prepare_input($string) {
	if (is_string($string)) {
		$string = stripslashes($string);
		$string = preg_replace('/union.*select.*from/i', '', $string);
		return trim($string);
	} elseif (is_array($string)) {
		reset($string);
		while (list($key, $value) = each($string)) 
		{
			$string[$key] = xtc_db_prepare_input($value);
		}
		return $string;
	} else {
		return $string;
	}
}
 ?>