<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_draw_hidden_field.inc.php
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




// Output a form hidden field
  function xtc_draw_hidden_field($name, $value = '', $parameters = '') {
    $field = '<input type="hidden" id="' . xtc_parse_input_field_data($name, array('"' => '&quot;')) . '" name="' . xtc_parse_input_field_data($name, array('"' => '&quot;')) . '" value="';

    if (xtc_not_null($value)) {
      $field .= xtc_parse_input_field_data($value, array('"' => '&quot;'));
    } else {
      $field .= xtc_parse_input_field_data($GLOBALS[$name], array('"' => '&quot;'));
    }

    if (xtc_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '" />';

    return $field;
  }
 ?>