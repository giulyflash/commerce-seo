<?php
/*-----------------------------------------------------------------
* 	ID:						dectobase64.inc.php
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




function dectobase64($decimal_value){

   // convert decimal value into base64 value

   switch($decimal_value){
	case 0: $base64_value="A";break;
	case 1: $base64_value="B";break;
	case 2: $base64_value="C";break;
	case 3: $base64_value="D";break;
	case 4: $base64_value="E";break;
	case 5: $base64_value="F";break;
	case 6: $base64_value="G";break;
	case 7: $base64_value="H";break;
	case 8: $base64_value="I";break;
	case 9: $base64_value="J";break;
	case 10: $base64_value="K";break;
	case 11: $base64_value="L";break;
	case 12: $base64_value="M";break;
	case 13: $base64_value="N";break;
	case 14: $base64_value="O";break;
	case 15: $base64_value="P";break;
	case 16: $base64_value="Q";break;
	case 17: $base64_value="R";break;
	case 18: $base64_value="S";break;
	case 19: $base64_value="T";break;
	case 20: $base64_value="U";break;
	case 21: $base64_value="V";break;
	case 22: $base64_value="W";break;
	case 23: $base64_value="X";break;
	case 24: $base64_value="Y";break;
	case 25: $base64_value="Z";break;
	case 26: $base64_value="a";break;
	case 27: $base64_value="b";break;
	case 28: $base64_value="c";break;
	case 29: $base64_value="d";break;
	case 30: $base64_value="e";break;
	case 31: $base64_value="f";break;
	case 32: $base64_value="g";break;
	case 33: $base64_value="h";break;
	case 34: $base64_value="i";break;
	case 35: $base64_value="j";break;
	case 36: $base64_value="k";break;
	case 37: $base64_value="l";break;
	case 38: $base64_value="m";break;
	case 39: $base64_value="n";break;
	case 40: $base64_value="o";break;
	case 41: $base64_value="p";break;
	case 42: $base64_value="q";break;
	case 43: $base64_value="r";break;
	case 44: $base64_value="s";break;
	case 45: $base64_value="t";break;
	case 46: $base64_value="u";break;
	case 47: $base64_value="v";break;
	case 48: $base64_value="w";break;
	case 49: $base64_value="x";break;
	case 50: $base64_value="y";break;
	case 51: $base64_value="z";break;
	case 52: $base64_value="0";break;
	case 53: $base64_value="1";break;
	case 54: $base64_value="2";break;
	case 55: $base64_value="3";break;
	case 56: $base64_value="4";break;
	case 57: $base64_value="5";break;
	case 58: $base64_value="6";break;
	case 59: $base64_value="7";break;
	case 60: $base64_value="8";break;
	case 61: $base64_value="9";break;
	case 62: $base64_value="+";break;
	case 63: $base64_value="/";break;
	case 64: $base64_value="=";break;
	default: $base64_value="a";break;
   }

   return $base64_value;
}
?>
