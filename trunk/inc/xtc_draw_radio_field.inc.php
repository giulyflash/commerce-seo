<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_draw_radio_field.inc.php
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
   
  function xtc_draw_radio_field($name, $value = '', $checked = false, $parameters = '') {
  	if (is_array($name)) return xtc_draw_selection_fieldNote($name, 'radio', $value, $checked, $parameters); 
    return xtc_draw_selection_field($name, 'radio', $value, $checked, $parameters);
  }
 ?>