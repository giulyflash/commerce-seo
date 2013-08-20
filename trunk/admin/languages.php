<?php
/* -----------------------------------------------------------------
 * 	$Id: languages.php 486 2013-07-15 22:08:14Z akausch $
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
        $name = xtc_db_prepare_input($_POST['name']);
        $code = xtc_db_prepare_input($_POST['code']);
        $image = xtc_db_prepare_input($_POST['image']);
        $directory = xtc_db_prepare_input($_POST['directory']);
        if (empty($_POST['sort_order'])) {
            $check_sort_order = xtc_db_fetch_array(xtc_db_query("SELECT sort_order FROM " . TABLE_LANGUAGES . " ORDER BY sort_order DESC LIMIT 1"));
            $sort_order = $check_sort_order['sort_order'] + 1;
        } else {
            $sort_order = xtc_db_prepare_input($_POST['sort_order']);
        }
        $charset = xtc_db_prepare_input($_POST['charset']);
        $status = xtc_db_prepare_input($_POST['status']);
        $status_admin = xtc_db_prepare_input($_POST['status_admin']);

        xtc_db_query("INSERT INTO " . TABLE_LANGUAGES . " (name, code, image, directory, sort_order, language_charset, status, status_admin) values ('" . xtc_db_input($name) . "', '" . xtc_db_input($code) . "', '" . xtc_db_input($image) . "', '" . xtc_db_input($directory) . "', '" . xtc_db_input($sort_order) . "', '" . xtc_db_input($charset) . "', '" . xtc_db_input($status) . "', '" . xtc_db_input($status_admin) . "')");
        $insert_id = xtc_db_insert_id();

        // create additional categories_description records
        $categories_query = xtc_db_query("select c.categories_id, cd.categories_name from " . TABLE_CATEGORIES . " c left join " . TABLE_CATEGORIES_DESCRIPTION . " cd on c.categories_id = cd.categories_id where cd.language_id = '" . $_SESSION['languages_id'] . "'");
        while ($categories = xtc_db_fetch_array($categories_query)) {
            xtc_db_query("insert into " . TABLE_CATEGORIES_DESCRIPTION . " (categories_id, language_id, categories_name) values ('" . $categories['categories_id'] . "', '" . $insert_id . "', '" . xtc_db_input($categories['categories_name']) . "')");
        }

        // create additional products_description records
        $products_query = xtc_db_query("SELECT p.products_id, pd.products_name, pd.products_description, pd.products_url from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id where pd.language_id = '" . $_SESSION['languages_id'] . "'");
        while ($products = xtc_db_fetch_array($products_query)) {
            xtc_db_query("insert into " . TABLE_PRODUCTS_DESCRIPTION . " (products_id, language_id, products_name, products_description, products_url) values ('" . $products['products_id'] . "', '" . $insert_id . "', '" . xtc_db_input($products['products_name']) . "', '" . xtc_db_input($products['products_description']) . "', '" . xtc_db_input($products['products_url']) . "')");
        }

        xtc_db_query("ALTER TABLE products_images ADD alt_langID_" . $insert_id . " VARCHAR(64) NOT NULL");

        // create additional products_options records
        $products_options_query = xtc_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . $_SESSION['languages_id'] . "'");
        while ($products_options = xtc_db_fetch_array($products_options_query)) {
            xtc_db_query("insert into " . TABLE_PRODUCTS_OPTIONS . " (products_options_id, language_id, products_options_name) values ('" . $products_options['products_options_id'] . "', '" . $insert_id . "', '" . xtc_db_input($products_options['products_options_name']) . "')");
        }

        // create additional products_options_values records
        $products_options_values_query = xtc_db_query("select products_options_values_id, products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where language_id = '" . $_SESSION['languages_id'] . "'");
        while ($products_options_values = xtc_db_fetch_array($products_options_values_query)) {
            xtc_db_query("insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name) values ('" . $products_options_values['products_options_values_id'] . "', '" . $insert_id . "', '" . xtc_db_input($products_options_values['products_options_values_name']) . "')");
        }

        // create additional orders_status records
        $orders_status_query = xtc_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "'");
        while ($orders_status = xtc_db_fetch_array($orders_status_query)) {
            xtc_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, language_id, orders_status_name) values ('" . $orders_status['orders_status_id'] . "', '" . $insert_id . "', '" . xtc_db_input($orders_status['orders_status_name']) . "')");
        }

        // create additional shipping_status records
        $shipping_status_query = xtc_db_query("select shipping_status_id, shipping_status_name from " . TABLE_SHIPPING_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "'");
        while ($shipping_status = xtc_db_fetch_array($shipping_status_query)) {
            xtc_db_query("insert into " . TABLE_SHIPPING_STATUS . " (shipping_status_id, language_id, shipping_status_name) values ('" . $shipping_status['shipping_status_id'] . "', '" . $insert_id . "', '" . xtc_db_input($shipping_status['shipping_status_name']) . "')");
        }

        // create additional orders_status records
        $xsell_grp_query = xtc_db_query("select products_xsell_grp_name_id,xsell_sort_order, groupname from " . TABLE_PRODUCTS_XSELL_GROUPS . " where language_id = '" . $_SESSION['languages_id'] . "'");
        while ($xsell_grp = xtc_db_fetch_array($xsell_grp_query)) {
            xtc_db_query("insert into " . TABLE_PRODUCTS_XSELL_GROUPS . " (products_xsell_grp_name_id,xsell_sort_order, language_id, groupname) values ('" . $xsell_grp['products_xsell_grp_name_id'] . "','" . $xsell_grp['xsell_sort_order'] . "', '" . $insert_id . "', '" . xtc_db_input($xsell_grp['groupname']) . "')");
        }

        // create additional customers status
        $customers_status_query = xtc_db_query("SELECT DISTINCT customers_status_id 
	      						FROM " . TABLE_CUSTOMERS_STATUS);
        while ($data = xtc_db_fetch_array($customers_status_query)) {

            $customers_status_data_query = xtc_db_query("SELECT * 
	      						FROM " . TABLE_CUSTOMERS_STATUS . "
	      						WHERE customers_status_id='" . $data['customers_status_id'] . "'");

            $group_data = xtc_db_fetch_array($customers_status_data_query);
            $c_data = array(
                'customers_status_id' => $data['customers_status_id'],
                'language_id' => $insert_id,
                'customers_status_name' => $group_data['customers_status_name'],
                'customers_status_public' => $group_data['customers_status_public'],
                'customers_status_image' => $group_data['customers_status_image'],
                'customers_status_discount' => $group_data['customers_status_discount'],
                'customers_status_ot_discount_flag' => $group_data['customers_status_ot_discount_flag'],
                'customers_status_ot_discount' => $group_data['customers_status_ot_discount'],
                'customers_status_graduated_prices' => $group_data['customers_status_graduated_prices'],
                'customers_status_show_price' => $group_data['customers_status_show_price'],
                'customers_status_show_price_tax' => $group_data['customers_status_show_price_tax'],
                'customers_status_add_tax_ot' => $group_data['customers_status_add_tax_ot'],
                'customers_status_payment_unallowed' => $group_data['customers_status_payment_unallowed'],
                'customers_status_shipping_unallowed' => $group_data['customers_status_shipping_unallowed'],
                'customers_status_discount_attributes' => $group_data['customers_status_discount_attributes']);

            xtc_db_perform(TABLE_CUSTOMERS_STATUS, $c_data);
        }
// echo $directory; exit;
        if (file_exists(DIR_FS_CATALOG . 'lang/' . $_POST['directory'] . '/' . $_POST['directory'] . '.sql')) {
            require_once(DIR_FS_INC . 'cseo_sql_query.inc.php');
            cseo_sql_query(DIR_FS_CATALOG . 'lang/' . $_POST['directory'] . '/' . $_POST['directory'] . '.sql', $insert_id);
        }
        if ($_POST['default'] == 'on')
            xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '" . xtc_db_input($code) . "' WHERE configuration_key = 'DEFAULT_LANGUAGE'");

        xtc_redirect(xtc_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $insert_id . '&new=1'));
        break;

    case 'save':
        $lID = xtc_db_prepare_input($_GET['lID']);
        $name = xtc_db_prepare_input($_POST['name']);
        $code = xtc_db_prepare_input($_POST['code']);
        $image = xtc_db_prepare_input($_POST['image']);
        $directory = xtc_db_prepare_input($_POST['directory']);
        $sort_order = xtc_db_prepare_input($_POST['sort_order']);
        $charset = xtc_db_prepare_input($_POST['charset']);
        $status = xtc_db_prepare_input($_POST['status']);
        $status_admin = xtc_db_prepare_input($_POST['status_admin']);

        xtc_db_query("UPDATE " . TABLE_LANGUAGES . " SET name = '" . xtc_db_input($name) . "', code = '" . xtc_db_input($code) . "', image = '" . xtc_db_input($image) . "', directory = '" . xtc_db_input($directory) . "', sort_order = '" . xtc_db_input($sort_order) . "', language_charset = '" . xtc_db_input($charset) . "', status = '" . xtc_db_input($status) . "', status_admin = '" . xtc_db_input($status_admin) . "' WHERE languages_id = '" . xtc_db_input($lID) . "'");

        if ($_POST['default'] == 'on') {
            xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '" . xtc_db_input($code) . "' WHERE configuration_key = 'DEFAULT_LANGUAGE'");
        }

        xtc_redirect(xtc_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $_GET['lID']));
        break;

    case 'deleteconfirm':
        $lID = xtc_db_prepare_input($_GET['lID']);

        $lng_query = xtc_db_query("SELECT languages_id FROM " . TABLE_LANGUAGES . " WHERE code = '" . DEFAULT_CURRENCY . "'");
        $lng = xtc_db_fetch_array($lng_query);
        if ($lng['languages_id'] == $lID)
            xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '' WHERE configuration_key = 'DEFAULT_CURRENCY'");

        xtc_db_query("DELETE FROM " . TABLE_CATEGORIES_DESCRIPTION . " where language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM " . TABLE_PRODUCTS_DESCRIPTION . " where language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM " . TABLE_PRODUCTS_OPTIONS_VALUES . " where language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM " . TABLE_MANUFACTURERS_INFO . " where languages_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM " . TABLE_ORDERS_STATUS . " where language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM " . TABLE_LANGUAGES . " where languages_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM " . TABLE_CONTENT_MANAGER . " where languages_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM " . TABLE_PRODUCTS_CONTENT . " where languages_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_STATUS . " where language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM " . TABLE_PERSONAL_LINKS_URL . " WHERE language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM " . TABLE_BLOG_CATEGORIES . " where language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM " . TABLE_BLOG_ITEMS . " where language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM emails WHERE languages_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM orders_pdf_profile WHERE languages_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM cseo_lang_button WHERE language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM cseo_antispam WHERE language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM " . TABLE_NEWS_TICKER . " where language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM boxes_names where language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM shipping_status where language_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM addon_languages where languages_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("DELETE FROM admin_navigation where languages_id = '" . xtc_db_input($lID) . "'");
        xtc_db_query("ALTER TABLE products_images DROP COLUMN alt_langID_" . xtc_db_input($lID));

        xtc_redirect(xtc_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page']));
        break;

    case 'delete':
        $lID = xtc_db_prepare_input($_GET['lID']);

        $lng_query = xtc_db_query("SELECT code FROM " . TABLE_LANGUAGES . " WHERE languages_id = '" . xtc_db_input($lID) . "'");
        $lng = xtc_db_fetch_array($lng_query);

        $remove_language = true;
        if ($lng['code'] == DEFAULT_LANGUAGE) {
            $remove_language = false;
            $messageStack->add(ERROR_REMOVE_DEFAULT_LANGUAGE, 'error');
        }
        break;
}

$lang_array = array();
$check_language = xtc_db_query("SELECT code FROM " . TABLE_LANGUAGES . "");
while ($check = xtc_db_fetch_array($check_language)) {
    array_push($lang_array, $check['code']);
}

if ($_GET['new'] == '1')
    $messageStack->add(INFO_INDEX_URL_START, 'info');
unset($_GET['new']);

require(DIR_WS_INCLUDES . 'header.php');
?>
<script type="text/javascript" src="includes/javascript/tooltip.js"></script>
<table class="outerTable" cellpadding="0" cellspacing="0">
    <tr>
        <td class="boxCenter" width="100%" valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
                <tr>
                    <td width="100%">
                        <table class="table_pageHeading" border="0" width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php if (!isset($_GET['action'])) { ?>
                    <tr>
                        <td>
                            <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="main" align="left">
                                        Welche Sprache soll installiert werden?
                                    </td>
                                    <td class="main">
                                        <?php
                                        if (file_exists('../lang/english/english.sql')) {
                                            if (!in_array('en', $lang_array, true)) {
                                                echo xtc_draw_form('languages', FILENAME_LANGUAGES, 'action=insert');
                                                echo xtc_draw_hidden_field('name', 'English') .
                                                xtc_draw_hidden_field('status', '0') .
                                                xtc_draw_hidden_field('code', 'en') .
                                                xtc_draw_hidden_field('charset', 'utf-8') .
                                                xtc_draw_hidden_field('image', 'icon.gif') .
                                                xtc_draw_hidden_field('directory', 'english');
                                                echo '<input class="button" type="submit" value="Englisch" />' . "\n" . '</form>';
                                            }
                                        }
                                        ?>
                                        <?php
                                        if (file_exists('../lang/french/french.sql')) {
                                            if (!in_array('fr', $lang_array, true)) {
                                                echo xtc_draw_form('languages', FILENAME_LANGUAGES, 'action=insert');
                                                echo xtc_draw_hidden_field('name', 'Frensh') .
                                                xtc_draw_hidden_field('status', '0') .
                                                xtc_draw_hidden_field('code', 'fr') .
                                                xtc_draw_hidden_field('charset', 'utf-8') .
                                                xtc_draw_hidden_field('image', 'icon.gif') .
                                                xtc_draw_hidden_field('directory', 'french');
                                                echo '<input class="button" type="submit" value="French" />' . "\n" . '</form>';
                                            }
                                        }
                                        ?>
                                        <?php
                                        if (file_exists('../lang/netherlands/netherlands.sql')) {
                                            if (!in_array('nl', $lang_array, true)) {
                                                echo xtc_draw_form('languages', FILENAME_LANGUAGES, 'action=insert');
                                                echo xtc_draw_hidden_field('name', 'Nederlands') .
                                                xtc_draw_hidden_field('status', '0') .
                                                xtc_draw_hidden_field('code', 'nl') .
                                                xtc_draw_hidden_field('charset', 'utf-8') .
                                                xtc_draw_hidden_field('image', 'icon.gif') .
                                                xtc_draw_hidden_field('directory', 'netherlands');
                                                echo '<input class="button" type="submit" value="Nederlands" />' . "\n" . '</form>';
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>
                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="dataTable">
                                        <tr class="dataTableHeadingRow">
                                            <th class="dataTableHeadingContent"><?php echo TABLE_HEADING_LANGUAGE_NAME; ?></th>
                                            <th class="dataTableHeadingContent"><?php echo TABLE_HEADING_LANGUAGE_CODE; ?></th>
                                            <th class="dataTableHeadingContent"><?php echo TABLE_HEADING_LANGUAGE_STATUS; ?></th>
                                            <th class="dataTableHeadingContent"><?php echo TABLE_HEADING_LANGUAGE_STATUS_ADMIN; ?></th>
                                            <th class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?></th>
                                        </tr>
                                        <?php
                                        $languages_query_raw = "select languages_id, name, code, image, directory, sort_order, language_charset, status, status_admin from " . TABLE_LANGUAGES . " ORDER BY sort_order";
                                        $languages_split = new splitPageResults($_GET['page'], '20', $languages_query_raw, $languages_query_numrows);
                                        $languages_query = xtc_db_query($languages_query_raw);

                                        while ($languages = xtc_db_fetch_array($languages_query)) {
                                            $rows++;
                                            if (((!$_GET['lID']) || (@$_GET['lID'] == $languages['languages_id'])) && (!$lInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
                                                $lInfo = new objectInfo($languages);
                                            }

                                            if ((is_object($lInfo)) && ($languages['languages_id'] == $lInfo->languages_id)) {
                                                echo '<tr class="dataTableRowSelected" onclick="document.location.href=\'' . xtc_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=edit') . '\'">' . "\n";
                                            } else {
                                                echo '<tr class="' . (($i % 2 == 0) ? 'dataTableRow' : 'dataWhite') . '" onclick="document.location.href=\'' . xtc_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $languages['languages_id']) . '\'">' . "\n";
                                            }
                                            if (DEFAULT_LANGUAGE == $languages['code']) {
                                                echo '<td class="dataTableContent"><b>' . $languages['name'] . ' (' . TEXT_DEFAULT . ')</b></td>' . "\n";
                                            } else {
                                                echo '<td class="dataTableContent">' . $languages['name'] . '</td>' . "\n";
                                            }
                                            ?>
                                            <td class="dataTableContent"><?php echo $languages['code']; ?></td>
                                            <?php
                                            if ($languages['status'] == '1') {
                                                echo '<td class="dataTableContent">' . TEXT_LANGUAGE_ACTIVE . '</td>';
                                            } else {
                                                echo '<td class="dataTableContent">' . TEXT_LANGUAGE_INACTIVE . '</td>';
                                            }
                                            ?>
                                            <?php
                                            if ($languages['status_admin'] == '1') {
                                                echo '<td class="dataTableContent">' . TEXT_LANGUAGE_ACTIVE . '</td>';
                                            } else {
                                                echo '<td class="dataTableContent">' . TEXT_LANGUAGE_INACTIVE . '</td>';
                                            }
                                            ?>
                                            <td class="dataTableContent" align="right">
                                                <?php
                                                if ((is_object($lInfo)) && ($languages['languages_id'] == $lInfo->languages_id)) {
                                                    echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif');
                                                } else {
                                                    echo '<a href="' . xtc_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $languages['languages_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>';
                                                }
                                                ?>
                                            </td>
                                            <tr>
                                            <?php } ?>
                                    </table>
                                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                        <tr>
                                            <td class="smallText" valign="top"><i><?php echo $languages_split->display_count($languages_query_numrows, '20', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_LANGUAGES); ?></i></td>
                                            <td class="smallText" align="right"><i><?php echo $languages_split->display_links($languages_query_numrows, '20', MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></i></td>
                                        </tr>
                                    </table>
                                    <?php if (!$_GET['action']) { ?>
                                        <table>
                                            <tr>
                                                <td align="right" colspan="2"><?php echo '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=new') . '">' . BUTTON_NEW_LANGUAGE . '</a>'; ?></td>
                                            </tr>
                                        </table>
                                    <?php } ?>
                                </td>
                                <?php
                                $direction_options = array(array('id' => '', 'text' => TEXT_INFO_LANGUAGE_DIRECTION_DEFAULT),
                                    array('id' => 'ltr', 'text' => TEXT_INFO_LANGUAGE_DIRECTION_LEFT_TO_RIGHT),
                                    array('id' => 'rtl', 'text' => TEXT_INFO_LANGUAGE_DIRECTION_RIGHT_TO_LEFT));

                                $heading = array();
                                $contents = array();
                                switch ($_GET['action']) {
                                    case 'new':
                                        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_LANGUAGE . '</b>');

                                        $contents = array('form' => xtc_draw_form('languages', FILENAME_LANGUAGES, 'action=insert'));
                                        $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_NAME . '<br />' . xtc_draw_input_field('name'));
                                        $contents[] = array('text' => '<br />' . TABLE_HEADING_LANGUAGE_NAME . ':<br />' . xtc_draw_radio_field('status', 1, true) . ' ' . TEXT_LANGUAGE_ACTIVE . ' <br />' . xtc_draw_radio_field('status', 0, false) . ' ' . TEXT_LANGUAGE_INACTIVE);
                                        $contents[] = array('text' => '<br />' . TABLE_HEADING_LANGUAGE_STATUS_ADMIN . ':<br />' . xtc_draw_radio_field('status_admin', 1, true) . ' ' . TEXT_LANGUAGE_ACTIVE . ' <br />' . xtc_draw_radio_field('status_admin', 0, false) . ' ' . TEXT_LANGUAGE_INACTIVE);
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_CODE . '<br />' . xtc_draw_input_field('code'));
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_CHARSET . '<br />' . xtc_draw_input_field('charset'));
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_IMAGE . '<br />' . xtc_draw_input_field('image', 'icon.gif'));
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_DIRECTORY . '<br />' . xtc_draw_input_field('directory'));
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_SORT_ORDER . '<br />' . xtc_draw_input_field('sort_order'));
                                        $contents[] = array('text' => '<br />' . xtc_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
                                        $contents[] = array('align' => 'center', 'text' => '<br /><input class="button" type="submit" value="' . BUTTON_INSERT . '" /> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $_GET['lID']) . '">' . BUTTON_CANCEL . '</a>');
                                        break;

                                    case 'edit':
                                        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_LANGUAGE . '</b>');

                                        $contents = array('form' => xtc_draw_form('languages', FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=save'));
                                        $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_NAME . '<br />' . xtc_draw_input_field('name', $lInfo->name));
                                        $contents[] = array('text' => '<br />' . TABLE_HEADING_LANGUAGE_NAME . ':<br />' . xtc_draw_radio_field('status', '1', ($lInfo->status == 1) ? true : false) . ' ' . TEXT_LANGUAGE_ACTIVE . ' <br />' . xtc_draw_radio_field('status', '0', ($lInfo->status == 0) ? true : false) . ' ' . TEXT_LANGUAGE_INACTIVE);
                                        $contents[] = array('text' => '<br />' . TABLE_HEADING_LANGUAGE_STATUS_ADMIN . ':<br />' . xtc_draw_radio_field('status_admin', '1', ($lInfo->status_admin == 1) ? true : false) . ' ' . TEXT_LANGUAGE_ACTIVE . ' <br />' . xtc_draw_radio_field('status_admin', '0', ($lInfo->status_admin == 0) ? true : false) . ' ' . TEXT_LANGUAGE_INACTIVE);
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_CODE . '<br />' . xtc_draw_input_field('code', $lInfo->code));
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_CHARSET . '<br />' . xtc_draw_input_field('charset', $lInfo->language_charset));
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_IMAGE . '<br />' . xtc_draw_input_field('image', $lInfo->image));
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_DIRECTORY . '<br />' . xtc_draw_input_field('directory', $lInfo->directory));
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_SORT_ORDER . '<br />' . xtc_draw_input_field('sort_order', $lInfo->sort_order));
                                        if (DEFAULT_LANGUAGE != $lInfo->code)
                                            $contents[] = array('text' => '<br />' . xtc_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);

                                        $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_UPDATE . '"/> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id) . '">' . BUTTON_CANCEL . '</a>');
                                        break;

                                    case 'delete':
                                        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_LANGUAGE . '</b>');

                                        $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
                                        $contents[] = array('text' => '<br /><b>' . $lInfo->name . '</b>');
                                        $contents[] = array('align' => 'center', 'text' => '<br />' . (($remove_language) ? '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=deleteconfirm') . '">' . BUTTON_DELETE . '</a>' : '') . ' <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id) . '">' . BUTTON_CANCEL . '</a>');
                                        break;

                                    default:
                                        if (is_object($lInfo)) {
                                            $heading[] = array('text' => '<b><strong>' . $lInfo->name . '</strong></b>');

                                            $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=edit') . '">' . BUTTON_EDIT . '</a> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=delete') . '">' . BUTTON_DELETE . '</a>');
                                            $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_NAME . ' ' . $lInfo->name);

                                            if ($lInfo->status == 1) {
                                                $contents[] = array('text' => '<br />' . TABLE_HEADING_LANGUAGE_NAME . ': <b>' . TEXT_LANGUAGE_ACTIVE . '</b>');
                                            } else {
                                                $contents[] = array('text' => '<br />' . TABLE_HEADING_LANGUAGE_NAME . ': <b>' . TEXT_LANGUAGE_INACTIVE . '</b>');
                                            }
                                            if ($lInfo->status_admin == 1) {
                                                $contents[] = array('text' => TABLE_HEADING_LANGUAGE_STATUS_ADMIN . ': <b>' . TEXT_LANGUAGE_ACTIVE . '</b>');
                                            } else {
                                                $contents[] = array('text' => TABLE_HEADING_LANGUAGE_STATUS_ADMIN . ': <b>' . TEXT_LANGUAGE_INACTIVE . '</b>');
                                            }
                                            $contents[] = array('text' => TEXT_INFO_LANGUAGE_CODE . ' ' . $lInfo->code);
                                            $contents[] = array('text' => TEXT_INFO_LANGUAGE_CHARSET_INFO . ' ' . $lInfo->language_charset);
                                            $contents[] = array('text' => 'Icon: ' . xtc_image(DIR_WS_LANGUAGES . $lInfo->directory . '/' . $lInfo->image, $lInfo->name));
                                            $contents[] = array('text' => TEXT_INFO_LANGUAGE_DIRECTORY . '<br />' . DIR_WS_LANGUAGES . '<b>' . $lInfo->directory . '</b>');
                                            $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_SORT_ORDER . ' ' . $lInfo->sort_order);
                                        }
                                        break;
                                }

                                if ((xtc_not_null($heading)) && (xtc_not_null($contents))) {
                                    echo '<td width="25%" class="border" valign="top">' . "\n";

                                    $box = new box;
                                    echo $box->infoBox($heading, $contents);

                                    echo '</td>' . "\n";
                                }
                                ?>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php
require(DIR_WS_INCLUDES . 'footer.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
