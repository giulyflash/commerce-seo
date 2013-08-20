<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_redirect.inc.php
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



  
require_once(DIR_FS_INC . 'xtc_exit.inc.php');
  
function xtc_redirect($url) {
	if((ENABLE_SSL == true) && (getenv('HTTPS') == 'on' || getenv('HTTPS') == '1')) 
		if (substr($url, 0, strlen(HTTP_SERVER)) == HTTP_SERVER) 
			$url = HTTPS_SERVER . substr($url, strlen(HTTP_SERVER));
		
	$patterns = array('/\t/i', '/\n/i', '/\r/i');
	$replacements = array('', '', '');
	header('Location: ' . preg_replace($patterns, $replacements, $url));

	exit();
}
?>