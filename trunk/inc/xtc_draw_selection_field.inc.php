<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_draw_selection_field.inc.php
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



  
// Output a selection field - alias function for xtc_draw_checkbox_field() and xtc_draw_radio_field()

  function xtc_draw_selection_field($name, $type, $value = '', $checked = false, $parameters = '') {
    $selection = '<input type="' . xtc_parse_input_field_data($type, array('"' => '&quot;')) . '" name="' . xtc_parse_input_field_data($name, array('"' => '&quot;')) . '"';

    if (xtc_not_null($value)) $selection .= ' value="' . xtc_parse_input_field_data($value, array('"' => '&quot;')) . '"';

    if ( ($checked == true) || ($GLOBALS[$name] == 'on') || ( (isset($value)) && ($GLOBALS[$name] == $value) ) ) {
      $selection .= ' checked="checked"';
    }

    if (xtc_not_null($parameters)) $selection .= ' ' . $parameters;

    $selection .= ' />';

    return $selection;
  }
  
    function xtc_draw_selection_fieldNote($data, $type, $value = '', $checked = false, $parameters = '') {
    $selection = $data['suffix'].'<input type="' . xtc_parse_input_field_data($type, array('"' => '&quot;')) . '" name="' . xtc_parse_input_field_data($data['name'], array('"' => '&quot;')) . '"';

    if (xtc_not_null($value)) $selection .= ' value="' . xtc_parse_input_field_data($value, array('"' => '&quot;')) . '"';

    if ( ($checked == true) || ($GLOBALS[$data['name']] == 'on') || ( (isset($value)) && ($GLOBALS[$data['name']] == $value) ) ) {
      $selection .= ' checked="checked"';
    }

    if (xtc_not_null($parameters)) $selection .= ' ' . $parameters;

    $selection .= ' />'.$data['text'];

    return $selection;
  }
 ?>