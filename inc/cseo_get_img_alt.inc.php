<?php
/*-----------------------------------------------------------------
* 	ID:						cseo_get_img_alt.inc.php
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



function cseo_get_img_alt($pID, $lID, $imgNr = '') {
	if($pID !='' && $lID !='') {
		$alt = xtc_db_fetch_array(xtDBquery("SELECT alt_langID_".$lID." FROM products_images WHERE products_id = '".$pID."' AND image_nr = '".$imgNr."' "));
		return $alt['alt_langID_'.$lID];
	}
	else 
		return false;
}

?>