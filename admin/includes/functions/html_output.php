<?php

/* -----------------------------------------------------------------
 * 	$Id: html_output.php 420 2013-06-19 18:04:39Z akausch $
 * 	Copyright (c) 2011-2021 commerce:SEO by Webdesign Erfurt
 * 	http://www.commerce-seo.de
 * ------------------------------------------------------------------
 * 	based on:
 * 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 * 	(c) 2002-2003 osCommerce - www.oscommerce.com
 * 	(c) 2003     nextcommerce - www.nextcommerce.org
 * 	(c) 2005     xt:Commerce - www.xt-commerce.com
 * 	Released under the GNU General Public License
 * --------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

////
// The HTML href link wrapper function
function xtc_href_link($page = '', $parameters = '', $connection = 'NONSSL') {
    if ($page == '') {
        die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine the page link!<br><br>Function used:<br><br>xtc_href_link(\'' . $page . '\', \'' . $parameters . '\', \'' . $connection . '\')</b>');
    }
    if ($connection == 'NONSSL') {
        $link = HTTP_SERVER . DIR_WS_ADMIN;
    } elseif ($connection == 'SSL') {
        if (ENABLE_SSL == 'true') {
            $link = HTTPS_SERVER . DIR_WS_ADMIN;
        } else {
            $link = HTTP_SERVER . DIR_WS_ADMIN;
        }
    } else {
        die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br>Known methods: NONSSL SSL<br><br>Function used:<br><br>xtc_href_link(\'' . $page . '\', \'' . $parameters . '\', \'' . $connection . '\')</b>');
    }
    if ($parameters == '') {
        $link = $link . $page . '?' . SID;
    } else {
        $link = $link . $page . '?' . $parameters . '&' . SID;
    }

    while ((substr($link, -1) == '&') || (substr($link, -1) == '?'))
        $link = substr($link, 0, -1);

    return $link;
}

function xtc_catalog_href_link($page = '', $parameters = '', $connection = 'NONSSL') {
    if ($connection == 'NONSSL') {
        $link = HTTP_SERVER . DIR_WS_CATALOG;
    } elseif ($connection == 'SSL') {
        if (ENABLE_SSL == 'true') {
            $link = HTTPS_SERVER . DIR_WS_CATALOG;
        } else {
            $link = HTTP_SERVER . DIR_WS_CATALOG;
        }
    } else {
        die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br>Known methods: NONSSL SSL<br><br>Function used:<br><br>xtc_href_link(\'' . $page . '\', \'' . $parameters . '\', \'' . $connection . '\')</b>');
    }
    if ($parameters == '') {
        $link .= $page;
    } else {
        $link .= $page . '?' . $parameters;
    }

    while ((substr($link, -1) == '&') || (substr($link, -1) == '?'))
        $link = substr($link, 0, -1);

    return $link;
}

////
// The HTML image wrapper function
function xtc_image($src, $alt = '', $width = '', $height = '', $params = '') {
    $image = '<img src="' . $src . '" border="0" alt="' . $alt . '"';
    if ($alt) {
        $image .= ' title=" ' . $alt . ' "';
    }
    if ($width) {
        $image .= ' width="' . $width . '"';
    }
    if ($height) {
        $image .= ' height="' . $height . '"';
    }
    if ($params) {
        $image .= ' ' . $params;
    }
    $image .= '>';

    return $image;
}

////
// Draw a 1 pixel black line
function xtc_black_line() {
    return xtc_image(DIR_WS_IMAGES . 'pixel_black.gif', '', '100%', '1');
}

////


////
// javascript to dynamically update the states/provinces list when the country is changed
// TABLES: zones
function xtc_js_zone_list($country, $form, $field) {
    $countries_query = xtc_db_query("select distinct zone_country_id from " . TABLE_ZONES . " order by zone_country_id");
    $num_country = 1;
    $output_string = '';
    while ($countries = xtc_db_fetch_array($countries_query)) {
        if ($num_country == 1) {
            $output_string .= '  if (' . $country . ' == "' . $countries['zone_country_id'] . '") {' . "\n";
        } else {
            $output_string .= '  } else if (' . $country . ' == "' . $countries['zone_country_id'] . '") {' . "\n";
        }

        $states_query = xtc_db_query("select zone_name, zone_id from " . TABLE_ZONES . " where zone_country_id = '" . $countries['zone_country_id'] . "' order by zone_name");

        $num_state = 1;
        while ($states = xtc_db_fetch_array($states_query)) {
            if ($num_state == '1')
                $output_string .= '    ' . $form . '.' . $field . '.options[0] = new Option("' . PLEASE_SELECT . '", "");' . "\n";
            $output_string .= '    ' . $form . '.' . $field . '.options[' . $num_state . '] = new Option("' . $states['zone_name'] . '", "' . $states['zone_id'] . '");' . "\n";
            $num_state++;
        }
        $num_country++;
    }
    $output_string .= '  } else {' . "\n" .
            '    ' . $form . '.' . $field . '.options[0] = new Option("' . TYPE_BELOW . '", "");' . "\n" .
            '  }' . "\n";

    return $output_string;
}

////
// Output a form
function xtc_draw_form($name, $action, $parameters = '', $method = 'post', $params = '') {
    $form = '<form name="' . $name . '" action="';
    if ($parameters) {
        $form .= xtc_href_link($action, $parameters);
    } else {
        $form .= xtc_href_link($action);
    }
    $form .= '" method="' . $method . '"';
    if ($params) {
        $form .= ' ' . $params;
    }
    $form .= '>';

    return $form;
}

////
// Output a form input field
function xtc_draw_input_field($name, $value = '', $parameters = '', $required = false, $type = 'text', $reinsert_value = true) {
    $field = '<input type="' . $type . '" name="' . $name . '"';
    if (($GLOBALS[$name]) && ($reinsert_value)) {
        $field .= ' value="' . htmlspecialchars(trim($GLOBALS[$name])) . '"';
    } elseif ($value != '') {
        $field .= ' value="' . htmlspecialchars(trim($value)) . '"';
    }
    if ($parameters != '') {
        $field .= ' ' . $parameters;
    }
    $field .= '>';

    if ($required)
        $field .= TEXT_FIELD_REQUIRED;

    return $field;
}

// Output a form small input field
function xtc_draw_small_input_field($name, $value = '', $parameters = '', $required = false, $type = 'text', $reinsert_value = true) {
    $field = '<input type="' . $type . '" size="3" name="' . $name . '"';
    if (($GLOBALS[$name]) && ($reinsert_value)) {
        $field .= ' value="' . htmlspecialchars(trim($GLOBALS[$name])) . '"';
    } elseif ($value != '') {
        $field .= ' value="' . htmlspecialchars(trim($value)) . '"';
    }
    if ($parameters != '') {
        $field .= ' ' . $parameters;
    }
    $field .= '>';

    if ($required)
        $field .= TEXT_FIELD_REQUIRED;

    return $field;
}

////
// Output a form password field
function xtc_draw_password_field($name, $value = '', $required = false) {
    $field = xtc_draw_input_field($name, $value, 'maxlength="40"', $required, 'password', false);

    return $field;
}

////
// Output a form filefield
function xtc_draw_file_field($name, $required = false) {
    $field = xtc_draw_input_field($name, '', '', $required, 'file');

    return $field;
}

////
// Output a selection field - alias function for xtc_draw_checkbox_field() and xtc_draw_radio_field()
function xtc_draw_selection_field($name, $type, $value = '', $checked = false, $compare = '') {
    $selection = '<input type="' . $type . '" name="' . $name . '"';
    if ($value != '') {
        $selection .= ' value="' . $value . '"';
    }
    if (($checked == true) || ($GLOBALS[$name] == 'on') || ($value && ($GLOBALS[$name] == $value)) || ($value && ($value == $compare))) {
        $selection .= ' CHECKED';
    }
    $selection .= '>';

    return $selection;
}

////
// Output a form checkbox field
function xtc_draw_checkbox_field($name, $value = '', $checked = false, $compare = '') {
    return xtc_draw_selection_field($name, 'checkbox', $value, $checked, $compare);
}

////
// Output a form radio field
function xtc_draw_radio_field($name, $value = '', $checked = false, $compare = '') {
    return xtc_draw_selection_field($name, 'radio', $value, $checked, $compare);
}

////
// Output a form textarea field
function xtc_draw_textarea_field($name, $wrap, $width, $height, $text = '', $params = '', $reinsert_value = true) {
    $field = '<textarea id="' . $name . '" name="' . $name . '" wrap="' . $wrap . '" cols="' . $width . '" rows="' . $height . '"';
    if ($params)
        $field .= ' ' . $params;
    $field .= '>';
    if (($GLOBALS[$name]) && ($reinsert_value)) {
        $field .= $GLOBALS[$name];
    } elseif ($text != '') {
        $field .= $text;
    }
    $field .= '</textarea>';
    return $field;
}

////
// Output a form hidden field
function xtc_draw_hidden_field($name, $value = '') {
    $field = '<input type="hidden" name="' . $name . '" value="';
    if ($value != '') {
        $field .= trim($value);
    } else {
        $field .= trim($GLOBALS[$name]);
    }
    $field .= '">';

    return $field;
}

////
// Output a form pull down menu
function xtc_draw_pull_down_menu($name, $values, $default = '', $params = '', $required = false) {
    $field = '<select name="' . $name . '"';
    if ($params)
        $field .= ' ' . $params;
    $field .= '>';
    if (is_array($values)) {
        foreach ($values as $key => $val) {
            $field .= '<option value="' . $val['id'] . '"';
            if (((strlen($val['id']) > 0) && ($GLOBALS[$name] == $val['id'])) || ($default == $val['id'])) {
                $field .= ' SELECTED';
            }
            $field .= '>' . $val['text'] . '</option>';
        }
    }
    $field .= '</select>';

    if ($required)
        $field .= TEXT_FIELD_REQUIRED;

    return $field;
}

// output 2 Soring arrows
function xtc_sorting($page, $sort) {

    switch ($page) {
        case FILENAME_CUSTOMERS:

            $nav = '<br><a title="' . IMAGE_ICON_DOWN . '" href="' . xtc_href_link(FILENAME_CUSTOMERS, 'sorting=' . $sort . '&' . xtc_get_all_get_params(array('action', 'sorting'))) . '">';
            $nav.=xtc_image(DIR_WS_ICONS . 'sort_down.gif', '', '16', '16') . '</a>';
            $nav.='<a title="' . IMAGE_ICON_UP . '" href="' . xtc_href_link(FILENAME_CUSTOMERS, 'sorting=' . $sort . '-desc&' . xtc_get_all_get_params(array('action', 'sorting'))) . '">';
            $nav.= xtc_image(DIR_WS_ICONS . 'sort_up.gif', '', '16', '16') . '</a>';

            break;

        case FILENAME_CATEGORIES:

            $nav = '<br><div><a title="' . IMAGE_ICON_DOWN . '" href="' . xtc_href_link(FILENAME_CATEGORIES, 'sorting=' . $sort . '&' . xtc_get_all_get_params(array('action', 'sorting'))) . '">';
            $nav.=xtc_image(DIR_WS_ICONS . 'sort_down.gif', IMAGE_ICON_DOWN, '16', '16') . '</a>';
            $nav.='<a title="' . IMAGE_ICON_UP . '" href="' . xtc_href_link(FILENAME_CATEGORIES, 'sorting=' . $sort . '-desc&' . xtc_get_all_get_params(array('action', 'sorting'))) . '">';
            $nav.= xtc_image(DIR_WS_ICONS . 'sort_up.gif', '', '16', '16') . '</a></div>';

            break;
    }

    return $nav;
}

