<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_get_country_name.inc.php
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



   
  require_once(DIR_FS_INC . 'xtc_get_countries.inc.php');
  function xtc_get_country_name($country_id) {
    $country_array = xtc_get_countriesList($country_id);

    return $country_array['countries_name'];
  }
 ?>
