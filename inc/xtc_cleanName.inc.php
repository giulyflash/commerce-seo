<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_cleanName.inc.php
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





 function xtc_cleanName($name) {
 	$search_array=array('Đ Â Đ˘â€','Đ Â Đ˛Đ‚Ńś','Đ ĐŽĐ˛Đ‚Â ','Đ Â Đ’Â¦','Đ ĐŽĐ Đ‰','Đ Â Đ’Â¬','&auml;','&Auml;','&ouml;','&Ouml;','&uuml;','&Uuml;');
 	$replace_array=array('ae','Ae','oe','Oe','ue','Ue','ae','Ae','oe','Oe','ue','Ue');
 	$name=str_replace($search_array,$replace_array,$name);   	
 	
     $replace_param='/[^a-zA-Z0-9]/';
     $name=preg_replace($replace_param,'-',$name);    
     return $name;
 }

?>
