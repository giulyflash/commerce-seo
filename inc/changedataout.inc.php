<?php
/*-----------------------------------------------------------------
* 	ID:						changedataout.inc.php
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
require_once(DIR_FS_INC . 'base64todec.inc.php');

function changedataout($cipher_data,$key){

   // decode cipher data with key using xoft encryption */

   $m=0;
   $all_bin_chars="";

   for($i=0;$i<strlen($cipher_data);$i++){
	$c=substr($cipher_data,$i,1);             // c = ciphertext
	$decimal_value=base64todec($c);           //convert to decimal value

	$decimal_value=($decimal_value - $m) / 4; //substract by m where m=0,1,2,or 3 then divide by 4

	$four_bit=decbin($decimal_value);

	while(strlen($four_bit)<4){
		$four_bit="0".$four_bit;
	}

	$all_bin_chars=$all_bin_chars.$four_bit;
	$m++;

	if($m>3){
		$m=0;
	}
   }

   $key_length=0;
   $plain_data="";

   for($j=0;$j<strlen($all_bin_chars);$j=$j+8){
	$c=substr($all_bin_chars,$j,8);
	$k=substr($key,$key_length,1);

	$dec_chars=bindec($c);
	$dec_chars=$dec_chars - strlen($key);
	$c=chr($dec_chars);
	$key_length++;

	if($key_length>=strlen($key)){
		$key_length=0;
	}

	$dec_chars=ord($c)^ord($k);
	$p=chr($dec_chars);
	$plain_data=$plain_data.$p;
   }

   return $plain_data;
}
?>
