<?php
/* -----------------------------------------------------------------
 * 	$Id: css_styler.php 480 2013-07-14 10:40:27Z akausch $
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

require('includes/application_top.php');

if ($_GET['action']) {
    switch ($_GET['action']) {
        case 'save':

            $configuration_query = xtc_db_query("SELECT configuration_key,configuration_id, configuration_value, use_function, set_function FROM " . TABLE_CONFIGURATION . " WHERE configuration_group_id = '23' ORDER BY sort_order");
            while ($configuration = xtc_db_fetch_array($configuration_query)) {
                xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . $_POST[$configuration['configuration_key']] . "' where configuration_key='" . $configuration['configuration_key'] . "'");
            }
            xtc_redirect('css_styler.php');
            break;
    }
}

$configuration_query = xtc_db_query("SELECT configuration_key, configuration_id, configuration_value, use_function, set_function FROM " . TABLE_CONFIGURATION . " WHERE configuration_group_id = '23' ORDER BY sort_order");
$i = 1;
$css_conf = array();
while ($configuration = xtc_db_fetch_array($configuration_query)) {
    $cfgValue = $configuration['configuration_value'];

    if ($configuration['set_function']) {
        eval('$value_field = ' . $configuration['set_function'] . '"' . htmlspecialchars($configuration['configuration_value']) . '");');
    } else {
        if ($configuration['configuration_key'] == 'CSS_BUTTON_BACKGROUND' ||
                $configuration['configuration_key'] == 'CSS_BUTTON_BORDER_COLOR' ||
                $configuration['configuration_key'] == 'WK_CSS_BUTTON_BORDER_COLOR' ||
                $configuration['configuration_key'] == 'CSS_BUTTON_BACKGROUND_1' ||
                $configuration['configuration_key'] == 'CSS_BUTTON_BACKGROUND_2' ||
                $configuration['configuration_key'] == 'CSS_BUTTON_HOVER_BACKGROUND_1' ||
                $configuration['configuration_key'] == 'CSS_BUTTON_HOVER_BACKGROUND_2' ||
                $configuration['configuration_key'] == 'WK_CSS_BUTTON_BACKGROUND' ||
                $configuration['configuration_key'] == 'WK_CSS_BUTTON_BACKGROUND_PIC' ||
                $configuration['configuration_key'] == 'WK_CSS_BUTTON_BACKGROUND_1' ||
                $configuration['configuration_key'] == 'WK_CSS_BUTTON_BACKGROUND_2' ||
                $configuration['configuration_key'] == 'WK_CSS_BUTTON_BACKGROUND_HOVER' ||
                $configuration['configuration_key'] == 'WK_CSS_BUTTON_HOVER_BACKGROUND_PIC' ||
                $configuration['configuration_key'] == 'WK_CSS_BUTTON_HOVER_BACKGROUND_1' ||
                $configuration['configuration_key'] == 'WK_CSS_BUTTON_HOVER_BACKGROUND_2' ||
                $configuration['configuration_key'] == 'WK_CSS_BUTTON_FONT_COLOR' ||
                $configuration['configuration_key'] == 'WK_CSS_BUTTON_FONT_COLOR_HOVER' ||
                $configuration['configuration_key'] == 'CSS_BUTTON_FONT_COLOR' ||
                $configuration['configuration_key'] == 'CSS_BUTTON_FONT_COLOR_HOVER' ||
                $configuration['configuration_key'] == 'CSS_BUTTON_BACKGROUND_HOVER' ||
                $configuration['configuration_key'] == 'CSS_BUTTON_BORDER_COLOR_HOVER') {
            $value_field = xtc_draw_input_field($configuration['configuration_key'], $configuration['configuration_value'], 'class="multiple" size="10"');
        } else {
            $value_field = xtc_draw_input_field($configuration['configuration_key'], $configuration['configuration_value'], 'size="20"');
        }
    }

    if (strstr($value_field, 'configuration_value')) {
        $value_field = str_replace('configuration_value', $configuration['configuration_key'], $value_field);
    }
    $css_conf[$configuration['configuration_key']] = array('key_name' => $configuration['configuration_key'], 'key_name_raw' => $configuration['configuration_key'], 'key_value' => $value_field, 'key_value_raw' => $configuration['configuration_value']);
    $i++;
}

function getHex($value) {
    $v = substr($value, 0, 6);
    return '#' . $v;
}

function kn($name) {
    return constant(strtoupper($name['key_name'] . '_TITLE'));
}

function knr($name) {
    return $name['key_name_raw'];
}

function kd($name) {
    return constant(strtoupper($name['key_name'] . '_DESC'));
}

function kv($name) {
    return $name['key_value'];
}

function kvr($name) {
    return $name['key_value_raw'];
}

function tr_input($conf) {
    return '<table width="100%"><tr><td valign="top" width="20%">' . kn($conf) . '</td><td valign="top" width="80%">' . kd($conf) . '<br />' . kv($conf) . '</td></tr></table>';
}

function tr_gradient_input($conf_1, $conf_2) {
    return '<table width="100%"><tr><td valign="top" width="20%">' . kn($conf_1) . '</td><td valign="top"><table width="100%" align="left"><tr>
			<td>' . kd($conf_1) . '<br />' . kv($conf_1) . '</td><td>' . kd($conf_2) . '<br />' . kv($conf_2) . '</td><td valign="bottom">
			<span id="' . strtolower(knr($conf_1)) . '" class="vorschau_gradient" style="background-image: -webkit-linear-gradient(' . getHex(kvr($conf_1)) . ', ' . getHex(kvr($conf_2)) . ');background-image: -moz-linear-gradient(' . getHex(kvr($conf_1)) . ', ' . getHex(kvr($conf_2)) . ');background-image: linear-gradient(' . getHex(kvr($conf_1)) . ', ' . getHex(kvr($conf_2)) . ');">&nbsp;</span>
			</td></tr></table></td></tr></table>';
}

require(DIR_WS_INCLUDES . 'header.php');
?>
<script type="text/javascript" src="includes/javascript/jpicker/jpicker-1.0.13.js"></script>
<link rel="stylesheet" type="text/css" href="includes/javascript/jpicker/css/jPicker-1.0.13.css" />
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.multiple').jPicker(
                {
                    window: {
                        position: {
                            x: 'right',
                            y: 'center',
                        },
                        expandable: false,
                        liveUpdate: true
                    },
                }
        );
    });
</script>

<?php echo xtc_draw_form('configuration', 'css_styler.php', 'action=save'); ?>
<h1>CSS - Styler</h1>
<hr />
<div style="text-align:right"><input type="submit" class="button" onClick="this.blur();" value="<?php echo BUTTON_SAVE ?>" /></div>

<div id="csstabs">
    <ul>
        <li><a href="#buttons"><?php echo HEAD_CSS_NORMAL_BUTTON; ?></a></li>
        <li><a href="#wkbuttons"><?php echo HEAD_CSS_WK_BUTTON; ?></a></li>
    </ul>
    <div id="buttons">
        <table>
            <tr>
                <td class="main">
                    <h2><?php echo CSS_BUTTON_CONFIG; ?></h2>
                </td>
            </tr>
            <tr>
                <td class="main gray">
                    <?php echo tr_input($css_conf['CSS_BUTTON_ACTIVE']); ?>
                </td>
            </tr>
            <tr>
                <td class="main">
                    <?php echo tr_input($css_conf['CSS_BUTTON_BACKGROUND']) . tr_input($css_conf['CSS_BUTTON_BACKGROUND_PIC']); ?>
                </td>
            </tr>
            <tr>
                <td class="main gray">
                    <?php echo tr_gradient_input($css_conf['CSS_BUTTON_BACKGROUND_1'], $css_conf['CSS_BUTTON_BACKGROUND_2']); ?>
                </td>
            </tr>
            <tr>
                <td class="main">
                    <?php echo tr_input($css_conf['CSS_BUTTON_BORDER_STYLE']) . tr_input($css_conf['CSS_BUTTON_BORDER_WIDTH']); ?>
                </td>
            </tr>
            <tr>
                <td class="main gray">
                    <?php echo tr_input($css_conf['CSS_BUTTON_BORDER_COLOR']) . tr_input($css_conf['CSS_BUTTON_BORDER_RADIUS']); ?>
                </td>
            </tr>
            <tr>
                <td class="main">
                    <?php echo tr_input($css_conf['CSS_BUTTON_FONT_FAMILY']) . tr_input($css_conf['CSS_BUTTON_FONT_SIZE']); ?>
                </td>
            </tr>
            <tr>
                <td class="main gray">
                    <?php echo tr_input($css_conf['CSS_BUTTON_FONT_ITALIC']) . tr_input($css_conf['CSS_BUTTON_FONT_UNDERLINE']); ?>
                </td>
            </tr>
            <tr>
                <td class="main">
                    <?php echo tr_input($css_conf['CSS_BUTTON_FONT_COLOR']) . tr_input($css_conf['CSS_BUTTON_FONT_COLOR_HOVER']); ?>
                </td>
            </tr>
            <tr>
                <td class="main gray">
                    <?php echo tr_input($css_conf['CSS_BUTTON_FONT_SHADOW']); ?>
                </td>
            </tr>
            <tr>
                <td class="main">
                    <?php echo tr_input($css_conf['CSS_BUTTON_BACKGROUND_HOVER']) . tr_input($css_conf['CSS_BUTTON_BACKGROUND_PIC_HOVER']); ?>
                </td>
            </tr>
            <tr>
                <td class="main gray">
                    <?php echo tr_gradient_input($css_conf['CSS_BUTTON_HOVER_BACKGROUND_1'], $css_conf['CSS_BUTTON_HOVER_BACKGROUND_2']) . tr_input($css_conf['CSS_BUTTON_BORDER_COLOR_HOVER']); ?>
                </td>
            </tr>
        </table>
        <br class="clear" />
    </div>
    <div id="wkbuttons">
        <table>
            <tr>
                <td class="main">
                    <h2><?php echo WK_CSS_BUTTON_CONFIG; ?></h2>
                </td>
            </tr>
            <tr>
                <td class="main gray">
                    <?php echo tr_input($css_conf['WK_CSS_BUTTON_BACKGROUND']) . tr_input($css_conf['WK_CSS_BUTTON_BACKGROUND_PIC']); ?>
                </td>
            </tr>
            <tr>
                <td class="main">
                    <?php echo tr_gradient_input($css_conf['WK_CSS_BUTTON_BACKGROUND_1'], $css_conf['WK_CSS_BUTTON_BACKGROUND_2']); ?>
                </td>
            </tr>
            <tr>
                <td class="main gray">
                    <?php echo tr_input($css_conf['WK_CSS_BUTTON_BACKGROUND_HOVER']) . tr_input($css_conf['WK_CSS_BUTTON_HOVER_BACKGROUND_PIC']); ?>
                </td>
            </tr>
            <tr>
                <td class="main">
                    <?php echo tr_gradient_input($css_conf['WK_CSS_BUTTON_HOVER_BACKGROUND_1'], $css_conf['WK_CSS_BUTTON_HOVER_BACKGROUND_2']); ?>
                </td>
            </tr>
            <tr>
                <td class="main gray">
                    <?php echo tr_input($css_conf['WK_CSS_BUTTON_FONT_COLOR']); ?>
                </td>
            </tr>
            <tr>
                <td class="main">
                    <?php echo tr_input($css_conf['WK_CSS_BUTTON_FONT_COLOR_HOVER']); ?>
                </td>
            </tr>
            <tr>
                <td class="main gray">
                    <?php echo tr_input($css_conf['WK_CSS_BUTTON_FONT_SHADOW']); ?>
                </td>
            </tr>
            <tr>
                <td class="main">
                    <?php echo tr_input($css_conf['WK_CSS_BUTTON_BORDER_COLOR']); ?>
                </td>
            </tr>
        </table>
        <br class="clear" />
    </div>
</div>
<div style="text-align:right"><input type="submit" class="button" onClick="this.blur();" value="<?php echo BUTTON_SAVE ?>" /></div>
</form>


<?php
require(DIR_WS_INCLUDES . 'footer.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
