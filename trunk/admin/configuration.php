<?php
/* -----------------------------------------------------------------
 * 	$Id: configuration.php 420 2013-06-19 18:04:39Z akausch $
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
            $configuration_query = xtc_db_query("SELECT configuration_key, configuration_id, configuration_value, use_function, set_function FROM " . TABLE_CONFIGURATION . " WHERE configuration_group_id = '" . (int) $_GET['gID'] . "' ORDER BY sort_order");
            while ($configuration = xtc_db_fetch_array($configuration_query)) {
                xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='" . $_POST[$configuration['configuration_key']] . "' WHERE configuration_key='" . $configuration['configuration_key'] . "'");
            }
            xtc_redirect(FILENAME_CONFIGURATION . '?gID=' . (int) $_GET['gID']);
            break;
    }
}

$cfg_group_query = xtc_db_query("SELECT configuration_group_title FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_id = '" . (int) $_GET['gID'] . "'");
$cfg_group = xtc_db_fetch_array($cfg_group_query);

require(DIR_WS_INCLUDES . 'header.php');
?>

<table class="outerTable" cellpadding="0" cellspacing="0">
    <tr>
        <td class="boxCenter" width="100%" valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
                <tr>
                    <td>
                        <table class="table_pageHeading" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="pageHeading" colspan="2">
                                    <?php echo $cfg_group['configuration_group_title']; ?> - commerce:SEO Konfiguration
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="0">
                            <?php
                            switch ($_GET['gID']) {
                                case 21:
                                case 19:
                                case 25:
                                    echo '<a class="button" href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=21', 'NONSSL') . '">Afterbuy</a> 
					<a class="button" href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=19', 'NONSSL') . '">Google Conversion</a> 
					<a class="button" href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=25', 'NONSSL') . '">PayPal</a>';

                                    if ($_GET['gID'] == '31')
                                        echo MB_INFO;
                                    break;
                            }
                            ?>


                            <tr>
                                <td valign="top" align="right">
<?php echo xtc_draw_form('configuration', FILENAME_CONFIGURATION, 'gID=' . (int) $_GET['gID'] . '&action=save'); ?>
                                    <table width="100%"  border="0" cellspacing="0" cellpadding="4">
                                        <tr>
                                            <td align="right" colspan="3">
                                                <input type="submit" class="button" onClick="this.blur();" value="<?php echo BUTTON_SAVE ?>"/>
                                            </td>
                                        </tr>
                                        <?php
                                        $configuration_query = xtc_db_query("select configuration_key,configuration_id, configuration_value, use_function,set_function from " . TABLE_CONFIGURATION . " where configuration_group_id = '" . (int) $_GET['gID'] . "' order by sort_order");
                                        $i = 1;
                                        while ($configuration = xtc_db_fetch_array($configuration_query)) {
                                            if ($_GET['gID'] == 6) {
                                                switch ($configuration['configuration_key']) {
                                                    case 'MODULE_PAYMENT_INSTALLED':
                                                        if ($configuration['configuration_value'] != '') {
                                                            $payment_installed = explode(';', $configuration['configuration_value']);
                                                            for ($i = 0, $n = sizeof($payment_installed); $i < $n; $i++) {
                                                                include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/payment/' . $payment_installed[$i]);
                                                            }
                                                        }
                                                        break;

                                                    case 'MODULE_SHIPPING_INSTALLED':
                                                        if ($configuration['configuration_value'] != '') {
                                                            $shipping_installed = explode(';', $configuration['configuration_value']);
                                                            for ($i = 0, $n = sizeof($shipping_installed); $i < $n; $i++) {
                                                                include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/shipping/' . $shipping_installed[$i]);
                                                            }
                                                        }
                                                        break;

                                                    case 'MODULE_ORDER_TOTAL_INSTALLED':
                                                        if ($configuration['configuration_value'] != '') {
                                                            $ot_installed = explode(';', $configuration['configuration_value']);
                                                            for ($i = 0, $n = sizeof($ot_installed); $i < $n; $i++) {
                                                                include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/order_total/' . $ot_installed[$i]);
                                                            }
                                                        }
                                                        break;
                                                }
                                            }
                                            if (xtc_not_null($configuration['use_function'])) {
                                                $use_function = $configuration['use_function'];
                                                if (preg_match('/->/', $use_function)) {
                                                    $class_method = explode('->', $use_function);
                                                    if (!is_object(${$class_method[0]})) {
                                                        include(DIR_WS_CLASSES . $class_method[0] . '.php');
                                                        ${$class_method[0]} = new $class_method[0]();
                                                    }
                                                    $cfgValue = xtc_call_function($class_method[1], $configuration['configuration_value'], ${$class_method[0]});
                                                } else {
                                                    $cfgValue = xtc_call_function($use_function, $configuration['configuration_value']);
                                                }
                                            } else {
                                                $cfgValue = $configuration['configuration_value'];
                                            }

                                            if (((!$_GET['cID']) || (@$_GET['cID'] == $configuration['configuration_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
                                                $cfg_extra_query = xtc_db_query("select configuration_key,configuration_value, date_added, last_modified, use_function, set_function from " . TABLE_CONFIGURATION . " where configuration_id = '" . $configuration['configuration_id'] . "'");
                                                $cfg_extra = xtc_db_fetch_array($cfg_extra_query);

                                                $cInfo_array = xtc_array_merge($configuration, $cfg_extra);
                                                $cInfo = new objectInfo($cInfo_array);
                                            }
                                            if ($configuration['set_function']) {
                                                eval('$value_field = ' . $configuration['set_function'] . '"' . htmlspecialchars($configuration['configuration_value']) . '");');
                                            } else {
                                                $value_field = xtc_draw_input_field($configuration['configuration_key'], $configuration['configuration_value'], 'size=40');
                                            }
                                            // add

                                            if (strstr($value_field, 'configuration_value'))
                                                $value_field = str_replace('configuration_value', $configuration['configuration_key'], $value_field);

                                            if ($i % 2 == 0)
                                                $f = '';
                                            else
                                                $f = 'dataTableRow';
                                            echo '
			  <tr class="' . $f . '" >
			    <td width="20%" valign="top" style="border-top: 1px dashed #ccc">
			    	<b>' . constant(strtoupper($configuration['configuration_key'] . '_TITLE')) . '</b>
			    </td>
			    <td width="20%" valign="top" align="left" style="border-top: 1px dashed #ccc">' . $value_field . '</td>
				<td width="60%" valign="top" align="left" style="border-top: 1px dashed #ccc">' . constant(strtoupper($configuration['configuration_key'] . '_DESC')) . '</td>
			  </tr>
			  ';

                                            $i++;
                                        }
                                        ?>
                                    </table>
                                    <input type="submit" class="button" onClick="this.blur();" value="<?php echo BUTTON_SAVE ?>"/></form>
                                </td>

                            </tr>
                        </table></td>
                </tr>
            </table></td>
    </tr>
</table>
<?php
require(DIR_WS_INCLUDES . 'footer.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
