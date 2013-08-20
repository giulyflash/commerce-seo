<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_count_shipping_modules.inc.php
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



  // include needed functions
  require_once(DIR_FS_INC . 'xtc_count_modules.inc.php');
  function xtc_count_shipping_modules() {
    return xtc_count_modules(MODULE_SHIPPING_INSTALLED);
  }
 ?>
