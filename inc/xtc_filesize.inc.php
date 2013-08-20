<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_filesize.inc.php
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




// returns human readeable filesize :)

function xtc_filesize($file) {
	$a = array("B","KB","MB","GB","TB","PB");
	
	$pos = 0;
	$size = filesize(DIR_FS_CATALOG.'media/products/'.$file);
	while ($size >= 1024) {
		$size /= 1024;
		$pos++;
	}
	return round($size,2)." ".$a[$pos];
}

?>