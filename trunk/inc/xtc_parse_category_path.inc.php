<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_parse_category_path.inc.php
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



 // include needed function
 require_once(DIR_FS_INC . 'xtc_string_to_int.inc.php');
 // Parse and secure the cPath parameter values
  function xtc_parse_category_path($cPath) {
    // make sure the category IDs are integers
    $cPath_array = array_map('xtc_string_to_int', explode('_', $cPath));

    // make sure no duplicate category IDs exist which could lock the server in a loop
	return array_unique($cPath_array);
  }
 ?>
