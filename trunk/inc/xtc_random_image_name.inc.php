<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_random_image_name.inc.php
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



   
  // Returns a random name, 16 to 20 characters long
  // There are more than 10^28 combinations
  // The directory is "hidden", i.e. starts with '.'
  function xtc_random_name() {
    $letters = 'abcdefghijklmnopqrstuvwxyz';
    $dirname = 'button_';
    $length = floor(xtc_rand(16,20));
    for ($i = 1; $i <= $length; $i++) {
     $q = floor(xtc_rand(1,26));
     $dirname .= $letters[$q];
    }
    return $dirname;
  }
 ?>