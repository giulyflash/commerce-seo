<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_draw_checkbox_field.inc.php
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




   require_once(DIR_FS_INC . 'xtc_draw_selection_field.inc.php');
   
// Output a form checkbox field
  function xtc_draw_checkbox_field($name, $value = '', $checked = false, $parameters = '') {
    return xtc_draw_selection_field($name, 'checkbox', $value, $checked, $parameters);
  }
 ?>
