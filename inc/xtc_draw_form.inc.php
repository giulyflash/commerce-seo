<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_draw_form.inc.php
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



   
// Output a form
  function xtc_draw_form($name, $action, $method = 'post', $parameters = '') {
    $form = '<form id="' . xtc_parse_input_field_data($name, array('"' => '&quot;')) . '" action="' . xtc_parse_input_field_data($action, array('"' => '&quot;')) . '" method="' . xtc_parse_input_field_data($method, array('"' => '&quot;')) . '"';

    if (xtc_not_null($parameters)) $form .= ' ' . $parameters;

    $form .= '>';

    return $form;
  }
 ?>