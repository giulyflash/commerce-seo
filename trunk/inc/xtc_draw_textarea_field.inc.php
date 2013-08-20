<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_draw_textarea_field.inc.php
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




// Output a form textarea field
  function xtc_draw_textarea_field($name, $wrap, $width, $height, $text = '', $parameters = '', $reinsert_value = true) {
    $field = '<textarea name="' . xtc_parse_input_field_data($name, array('"' => '&quot;')) . '" id="' . xtc_parse_input_field_data($name, array('"' => '&quot;')) . '" cols="' . xtc_parse_input_field_data($width, array('"' => '&quot;')) . '" rows="' . xtc_parse_input_field_data($height, array('"' => '&quot;')) . '"';

    if (xtc_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if ( (isset($GLOBALS[$name])) && ($reinsert_value == true) ) {
      $field .= $GLOBALS[$name];
    } elseif (xtc_not_null($text)) {
      $field .= $text;
    }
    $field .= '</textarea>'."\n";

    return $field;
  }
 ?>