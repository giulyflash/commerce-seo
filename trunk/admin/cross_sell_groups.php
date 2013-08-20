<?php
/* -----------------------------------------------------------------
 * 	$Id: cross_sell_groups.php 434 2013-06-25 17:30:40Z akausch $
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

switch ($_GET['action']) {
    case 'insert':
    case 'save':
        $cross_sell_id = xtc_db_prepare_input($_GET['oID']);

        $languages = xtc_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
            $cross_sell_name_array = $_POST['cross_sell_group_name'];
			$xsell_sort_order = $_POST['xsell_sort_order'];
            $language_id = $languages[$i]['id'];

            $sql_data_array = array('groupname' => xtc_db_prepare_input($cross_sell_name_array[$language_id]),
									'xsell_sort_order' => xtc_db_prepare_input($xsell_sort_order)
									);

            if ($_GET['action'] == 'insert') {
                if (!xtc_not_null($cross_sell_id)) {
                    $next_id_query = xtc_db_query("select max(products_xsell_grp_name_id) as products_xsell_grp_name_id from " . TABLE_PRODUCTS_XSELL_GROUPS . "");
                    $next_id = xtc_db_fetch_array($next_id_query);
                    $cross_sell_id = $next_id['products_xsell_grp_name_id'] + 1;
                }

                $insert_sql_data = array('products_xsell_grp_name_id' => $cross_sell_id,
                    'language_id' => $language_id);
                $sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
                xtc_db_perform(TABLE_PRODUCTS_XSELL_GROUPS, $sql_data_array);
            } elseif ($_GET['action'] == 'save') {
                xtc_db_perform(TABLE_PRODUCTS_XSELL_GROUPS, $sql_data_array, 'update', "products_xsell_grp_name_id = '" . xtc_db_input($cross_sell_id) . "' and language_id = '" . $language_id . "'");
            }
        }


        xtc_redirect(xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $cross_sell_id));
        break;

    case 'deleteconfirm':
        $oID = xtc_db_prepare_input($_GET['oID']);

        xtc_db_query("delete from " . TABLE_PRODUCTS_XSELL_GROUPS . " where products_xsell_grp_name_id = '" . xtc_db_input($oID) . "'");

        xtc_redirect(xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page']));
        break;

    case 'delete':
        $oID = xtc_db_prepare_input($_GET['oID']);

        $cross_sell_query = xtc_db_query("select count(*) as count from " . TABLE_PRODUCTS_XSELL . " where products_xsell_grp_name_id = '" . xtc_db_input($oID) . "'");
        $status = xtc_db_fetch_array($cross_sell_query);

        $remove_status = true;
        if ($status['count'] > 0) {
            $remove_status = false;
            $messageStack->add(ERROR_STATUS_USED_IN_CROSS_SELLS, 'error');
        }
        break;
}
require(DIR_WS_INCLUDES . 'header.php');
?>

<table class="outerTable" cellpadding="0" cellspacing="0">
    <tr>
        <td class="boxCenter" width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                <tr>
                    <td>
                        <table class="table_pageHeading" border="0" width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="pageHeading"><?php echo BOX_ORDERS_XSELL_GROUP; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                                        <tr class="dataTableHeadingRow">
                                            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_XSELL_GROUP_NAME; ?></td>
                                            <td class="dataTableHeadingContent"><?php echo TABLE_INFO_XSELL_SORT_ORDER; ?></td>
                                            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
                                        </tr>
                                        <?php
                                        $cross_sell_query_raw = "SELECT * FROM " . TABLE_PRODUCTS_XSELL_GROUPS . " WHERE language_id = '" . (int)$_SESSION['languages_id'] . "' ORDER BY xsell_sort_order, products_xsell_grp_name_id";
                                        $cross_sell_split = new splitPageResults($_GET['page'], '20', $cross_sell_query_raw, $cross_sell_query_numrows);
                                        $cross_sell_query = xtc_db_query($cross_sell_query_raw);
                                        $rows = 1;
                                        while ($cross_sell = xtc_db_fetch_array($cross_sell_query)) {
                                            if (((!$_GET['oID']) || ($_GET['oID'] == $cross_sell['products_xsell_grp_name_id'])) && (!$oInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
                                                $oInfo = new objectInfo($cross_sell);
                                            }
                                            if ($rows % 2 == 0)
                                                $f = 'dataTableRow';
                                            else
                                                $f = '';
                                            if ((is_object($oInfo)) && ($cross_sell['products_xsell_grp_name_id'] == $oInfo->products_xsell_grp_name_id)) {
                                                echo '<tr class="dataTableRowSelected" onclick="document.location.href=\'' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id . '&action=edit') . '\'">' . "\n";
                                            } else {
                                                echo '<tr class="' . (($i % 2 == 0) ? 'dataTableRow' : 'dataWhite') . '" onclick="document.location.href=\'' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $cross_sell['products_xsell_grp_name_id']) . '\'">' . "\n";
                                            }


                                            echo '                <td class="dataTableContent">' . $cross_sell['groupname'] . '</td>' . "\n";
                                            echo '                <td class="dataTableContent">' . $cross_sell['xsell_sort_order'] . '</td>' . "\n";
                                            ?>
                                            <td class="dataTableContent" align="right"><?php if ((is_object($oInfo)) && ($cross_sell['products_xsell_grp_name_id'] == $oInfo->products_xsell_grp_name_id)) {
                                            echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', '');
                                        } else {
                                            echo '<a href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $cross_sell['products_xsell_grp_name_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>';
                                        } ?>&nbsp;</td>
                                            <?php
                                            echo '</tr>';
                                            $rows++;
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                                                    <tr>
                                                        <td class="smallText" valign="top"><?php echo $cross_sell_split->display_count($cross_sell_query_numrows, '20', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_XSELL_GROUP); ?></td>
                                                        <td class="smallText" align="right"><?php echo $cross_sell_split->display_links($cross_sell_query_numrows, '20', MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                                                    </tr>
<?php
if (substr($_GET['action'], 0, 3) != 'new') {
    ?>
                                                        <tr>
                                                            <td colspan="2" align="right"><?php echo '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&action=new') . '">' . BUTTON_INSERT . '</a>'; ?></td>
                                                        </tr>
    <?php
}
?>
                                                </table></td>
                                        </tr>
                                    </table></td>
                                <?php
                                $heading = array();
                                $contents = array();
                                switch ($_GET['action']) {
                                    case 'new':
                                        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_XSELL_GROUP . '</b>');

                                        $contents = array('form' => xtc_draw_form('status', FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&action=insert'));
                                        $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);

                                        $cross_sell_inputs_string = '';
                                        $languages = xtc_get_languages();
                                        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                            $cross_sell_inputs_string .= '<br />' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/' . $languages[$i]['image']) . '&nbsp;' . xtc_draw_input_field('cross_sell_group_name[' . $languages[$i]['id'] . ']');
                                        }

                                        $contents[] = array('text' => '<br />' . TEXT_INFO_XSELL_GROUP_NAME . $cross_sell_inputs_string);
										$contents[] = array('text' => '<br />' . TEXT_INFO_XSELL_SORT_ORDER . xtc_draw_input_field('xsell_sort_order'));
                                        $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_INSERT . '"/> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page']) . '">' . BUTTON_CANCEL . '</a>');
                                        break;

                                    case 'edit':
                                        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_XSELL_GROUP . '</b>');

                                        $contents = array('form' => xtc_draw_form('status', FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id . '&action=save'));
                                        $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);

                                        $cross_sell_inputs_string = '';
                                        $languages = xtc_get_languages();
                                        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                            $cross_sell_inputs_string .= '<br />' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/' . $languages[$i]['image']) . '&nbsp;' . xtc_draw_input_field('cross_sell_group_name[' . $languages[$i]['id'] . ']', xtc_get_cross_sell_name($oInfo->products_xsell_grp_name_id, $languages[$i]['id']));
                                        }

                                        $contents[] = array('text' => '<br />' . TEXT_INFO_XSELL_GROUP_NAME . $cross_sell_inputs_string);
										$contents[] = array('text' => '<br />' . TEXT_INFO_XSELL_SORT_ORDER . xtc_draw_input_field('xsell_sort_order', $oInfo->xsell_sort_order));
                                        $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_UPDATE . '"/> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id) . '">' . BUTTON_CANCEL . '</a>');
                                        break;

                                    case 'delete':
                                        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_XSELL_GROUP . '</b>');

                                        $contents = array('form' => xtc_draw_form('status', FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id . '&action=deleteconfirm'));
                                        $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
                                        $contents[] = array('text' => '<br /><b>' . $oInfo->orders_status_name . '</b>');
                                        if ($remove_status)
                                            $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_DELETE . '"/> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id) . '">' . BUTTON_CANCEL . '</a>');
                                        break;

                                    default:
                                        if (is_object($oInfo)) {
                                            $heading[] = array('text' => '<b>' . $oInfo->orders_status_name . '</b>');

                                            $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id . '&action=edit') . '">' . BUTTON_EDIT . '</a> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_XSELL_GROUPS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_xsell_grp_name_id . '&action=delete') . '">' . BUTTON_DELETE . '</a>');

                                            $cross_sell_inputs_string = '';
                                            $languages = xtc_get_languages();
                                            for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                                $cross_sell_inputs_string .= '<br />' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/' . $languages[$i]['image']) . '&nbsp;' . xtc_get_cross_sell_name($oInfo->products_xsell_grp_name_id, $languages[$i]['id']);
                                            }

                                            $contents[] = array('text' => $cross_sell_inputs_string);
                                        }
                                        break;
                                }

                                if ((xtc_not_null($heading)) && (xtc_not_null($contents))) {
                                    echo '            <td width="25%" class="border" valign="top">' . "\n";

                                    $box = new box;
                                    echo $box->infoBox($heading, $contents);

                                    echo '            </td>' . "\n";
                                }
                                ?>
                            </tr>
                        </table></td>
                </tr>
            </table></td>
    </tr>
</table>
<?php
require(DIR_WS_INCLUDES . 'footer.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
