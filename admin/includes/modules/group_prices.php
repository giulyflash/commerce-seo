<?php
/* -----------------------------------------------------------------
 * 	$Id: group_prices.php 420 2013-06-19 18:04:39Z akausch $
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
require_once (DIR_FS_INC . 'xtc_get_tax_rate.inc.php');
require_once (DIR_FS_INC . 'xtc_get_tax_class_id.inc.php');
?>

<table width="100%" class="tablePrice">
    <tr>
        <td>
            <?php
            $text_price = STAFFEL_NETTO;
            if (PRICE_IS_BRUTTO == 'true') {
                $text_price = STAFFEL_BRUTTO;
            }
            $i = 0;
            $group_query = xtc_db_query("SELECT * FROM " . TABLE_CUSTOMERS_STATUS . " WHERE language_id = '" . (int) $_SESSION['languages_id'] . "' AND customers_status_id != '0';");
            while ($group_values = xtc_db_fetch_array($group_query)) {
                $i++;
                $group_data[$i] = array('STATUS_NAME' => $group_values['customers_status_name'], 'STATUS_IMAGE' => $group_values['customers_status_image'], 'STATUS_ID' => $group_values['customers_status_id']);
            }
            for ($col = 0, $n = sizeof($group_data); $col < $n + 1; $col++) {
                $staffel_data_array = array();
                if ($col != 0) {
                    if (PRICE_IS_BRUTTO == 'true') {
                        $products_price = (get_group_price($group_data[$col]['STATUS_ID'], $pInfo->products_id) * xtc_get_tax_rate(xtc_get_tax_class_id($pInfo->products_id)) / 100) + get_group_price($group_data[$col]['STATUS_ID'], $pInfo->products_id);
                    } else {
                        $products_price = get_group_price($group_data[$col]['STATUS_ID'], $pInfo->products_id);
                    }
                    $staffel_query = xtc_db_query("SELECT * FROM personal_offers_by_customers_status_" . (int) $group_data[$col]['STATUS_ID'] . " WHERE products_id = '" . $pInfo->products_id . "' AND quantity != 1 ORDER BY quantity ASC;");
                    while ($staffel_values = xtc_db_fetch_array($staffel_query)) {
                        if (PRICE_IS_BRUTTO == 'true') {
                            $products_staffel_price = ($staffel_values['personal_offer'] * xtc_get_tax_rate(xtc_get_tax_class_id($pInfo->products_id)) / 100) + $staffel_values['personal_offer'];
                        } else {
                            $products_staffel_price = $staffel_values['personal_offer'];
                        }
                    }

                    $groups_data_array[] = array('HIDDEN_STATUS_NAME' => xtc_draw_hidden_field('status_name', $group_data[$col]['STATUS_NAME']),
                        'INPUT_STATUS_NAME' => $group_data[$col]['STATUS_NAME'],
                        'INPUT_STATUS_IMAGE' => $group_data[$col]['STATUS_IMAGE'],
                        'INPUT_STATUS_ID' => $group_data[$col]['STATUS_ID'],
                        'INPUT_PRODUCTS_GROUP_PRICE' => xtc_draw_input_field('products_price_' . $group_data[$col]['STATUS_ID'], round($products_price, PRICE_PRECISION), 'size="8"')
                    );
                    ?>
                    <table>
                        <tr>
                            <td align="left"><b><?php echo $group_data[$col]['STATUS_NAME']; ?></b></td>
                            <td align="right">
                                <div class="fieldsetInnertRight">
                                    <?php echo 'Profile'; ?>: 
                                    <div id="profile_<?php echo $group_data[$col]['STATUS_ID']; ?>" name="profile_<?php echo $group_data[$col]['STATUS_ID']; ?>"></div>
                                    <?php /* speichern von Profilen */ ?>
                                    <div id="eingabebox_<?php echo $group_data[$col]['STATUS_ID']; ?>" name="eingabebox_<?php echo $group_data[$col]['STATUS_ID']; ?>" style="display:none">
                                        <?php echo xtc_draw_input_field('templatename_save_' . $group_data[$col]['STATUS_ID'], '', ' id=templatename_save_' . $group_data[$col]['STATUS_ID'] . ' style="width:140px"'); ?>
                                        <?php echo '<img src="images/tick.gif" class="cursor" alt="' . STAFFEL_SAVE . '" title=" ' . STAFFEL_SAVE . ' " onclick="xajax_saveTemplateValues(' . $group_data[$col]['STATUS_ID'] . ',' . $pInfo->products_id . ',document.getElementById(\'templatename_save_' . $group_data[$col]['STATUS_ID'] . '\').value);" height="16" width="16"><img src="images/cancel.gif" class="cursor" alt="' . STAFFEL_CANCEL . '" title=" ' . STAFFEL_CANCEL . ' " onclick="xajax_staffelCancelTemplate(' . $group_data[$col]['STATUS_ID'] . ');" height="16" width="16"><br /><br /><div>' . PROFILE_NAME . '</div><br />'; ?>
                                    </div>
                                    <?php //editieren von Profilen ?>
                                    <!--<div id="editbox_<?php echo $group_data[$col]['STATUS_ID']; ?>" name="editbox_<?php echo $group_data[$col]['STATUS_ID']; ?>" style="display:none;">
                                    <?php echo xtc_draw_input_field('templatename_edit_' . $group_data[$col]['STATUS_ID'], '', ' id=templatename_edit_' . $group_data[$col]['STATUS_ID'] . '  style="width:140px"'); ?>
                                    <?php echo '<img src="images/tick.gif" class="cursor" alt="' . STAFFEL_SAVE . '" title=" ' . STAFFEL_SAVE . ' " onclick="xajax_editTemplateValues(' . $group_data[$col]['STATUS_ID'] . ',' . $pInfo->products_id . ',document.getElementById(\'templatename_edit_' . $group_data[$col]['STATUS_ID'] . '\').value,document.getElementById(\'template_drop_' . $group_data[$col]['STATUS_ID'] . '\').value);" height="16" width="16">
									<img src="images/cancel.gif" class="cursor" alt="' . STAFFEL_CANCEL . '" title=" ' . STAFFEL_CANCEL . ' " onclick="xajax_staffelCancelTemplate(' . $group_data[$col]['STATUS_ID'] . ');" height="16" width="16"><br /><br /><div>' . PROFILE_NEW_NAME . '</div><br />'; ?>
                                    </div>-->

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">
                                <?php //Fehlermedung für die Profile ?>
                                <div id="load_<?php echo $group_data[$col]['STATUS_ID']; ?>" name="load_<?php echo $group_data[$col]['STATUS_ID']; ?>"></div>
                                <div id="fehlermeldung_<?php echo $group_data[$col]['STATUS_ID']; ?>" name="fehlermeldung_<?php echo $group_data[$col]['STATUS_ID']; ?>"></div>
                            </td>
                        </tr>
                    </table
                    <fieldset>
                        <div>
                            <div class="titlePrice"><?php echo STAFFEL_GROUP_BASE_PRICE; ?> (<?php echo $text_price; ?>)</div>
                            <div><?php echo xtc_draw_input_field('products_price_' . $group_data[$col]['STATUS_ID'], round($products_price, PRICE_PRECISION), ' id=products_price_' . $group_data[$col]['STATUS_ID'] . ' size="8" style="width:50px"'); ?></div>
                        </div>
                        <div class="fieldsetInnert">
                            <div id="staffel_value_<?php echo $group_data[$col]['STATUS_ID']; ?>" name="staffel_value_<?php echo $group_data[$col]['STATUS_ID']; ?>"></div>
                            <div id="staffel_add_<?php echo $group_data[$col]['STATUS_ID']; ?>" name="staffel_add_<?php echo $group_data[$col]['STATUS_ID']; ?>"></div>
                        </div>
                    </fieldset>

                    <hr>
                    <?php
                }
            }
            ?>
        </td>
    </tr>
</table>
<?php
if ($pInfo->products_id != '') {
    ?>
    <script type="text/javascript">
        xajax_firstLoad(<?php echo $pInfo->products_id; ?>);
    </script>
    <?php
}
?>