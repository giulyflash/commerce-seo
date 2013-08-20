<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_format_price_order.inc.php
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
require_once(DIR_FS_INC . 'xtc_precision.inc.php');
function xtc_format_price_order ($price_string,$price_special,$currency,$show_currencies=1)
{
// calculate currencies
$currencies_query = xtDBquery("SELECT symbol_left,
          symbol_right,
          decimal_places,
          value
          FROM ". TABLE_CURRENCIES ." WHERE
          code = '".$currency ."'");
$currencies_value=xtc_db_fetch_array($currencies_query);
$currencies_data=array();
$currencies_data=array(
      'SYMBOL_LEFT'=>$currencies_value['symbol_left'] ,
      'SYMBOL_RIGHT'=>$currencies_value['symbol_right'] ,
      'DECIMAL_PLACES'=>$currencies_value['decimal_places'] ,
      'VALUE'=> $currencies_value['value']);
// round price
$price_string=xtc_precision($price_string,$currencies_data['DECIMAL_PLACES']);


if ($price_special=='1') {
$currencies_query = xtDBquery("SELECT symbol_left,
          decimal_point,
          thousands_point,
          value
          FROM ". TABLE_CURRENCIES ." WHERE
          code = '".$currency ."'");
$currencies_value=xtc_db_fetch_array($currencies_query);
$price_string=number_format($price_string,$currencies_data['DECIMAL_PLACES'], $currencies_value['decimal_point'], $currencies_value['thousands_point']);
  if ($show_currencies == 1) {
    $price_string = $currencies_data['SYMBOL_LEFT']. ' '.$price_string.' '.$currencies_data['SYMBOL_RIGHT'];
  }
}
return $price_string;
}
?>