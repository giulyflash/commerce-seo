<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_js_lang.php
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



   
   function xtc_js_lang($message) {
   	
   	
   	$message = str_replace ("&auml;","%E4", $message );
   	$message = str_replace ("&Auml;","%C4", $message );
   	$message = str_replace ("&ouml;","%F6", $message );
   	$message = str_replace ("&Ouml;","%D6", $message );
   	$message = str_replace ("&uuml;","%FC", $message );
   	$message = str_replace ("&Uuml;","%DC", $message );
   	
   	return $message;
   	
   }
   
   
?>
