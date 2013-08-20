<?php
/*-----------------------------------------------------------------
* 	ID:						getManufacturersData.inc.php
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



function cseo_get_manufacturers($man_id) {
	if(!empty($man_id) && is_numeric($man_id)) {
		$man_array = array();
		$image = '';
		$url = '';
		$link = '';
		$manufacturer_query = xtDBquery("SELECT
										m.manufacturers_id,
										m.manufacturers_name,
										m.manufacturers_image,
										mi.manufacturers_url
										FROM
										" . TABLE_MANUFACTURERS . " m,
										" . TABLE_MANUFACTURERS_INFO . " mi
										WHERE m.manufacturers_id = '".$man_id."'
										AND m.manufacturers_id = mi.manufacturers_id
										AND	mi.languages_id = '".(int)$_SESSION['languages_id']."'");
		$manufacturer = xtc_db_fetch_array($manufacturer_query,true);
		if(!empty($manufacturer['manufacturers_image']))
			$image = DIR_WS_IMAGES . $manufacturer['manufacturers_image'];
		if(!empty($manufacturer['manufacturers_url']))
			$url = xtc_href_link(FILENAME_REDIRECT,'action=manufacturer&'.xtc_manufacturer_link($manufacturer['manufacturers_id'],$manufacturer['manufacturers_name']));
		if(!empty($manufacturer['manufacturers_name']))
			$link = xtc_href_link(FILENAME_DEFAULT,xtc_manufacturer_link($manufacturer['manufacturers_id'],$manufacturer['manufacturers_name']));
		
		$man_array = array(
							'image' => $image,
							'name' => $manufacturer['manufacturers_name'],
							'link' => $link,
							'url' => $url);
		return $man_array;
	}
}
?>
