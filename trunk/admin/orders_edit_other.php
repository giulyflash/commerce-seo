<?php
/* -----------------------------------------------------------------
 * 	$Id: orders_edit_other.php 452 2013-07-03 12:42:36Z akausch $
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
?>
<!-- Sprachen Anfang //-->
<table border="0" width="100%" cellspacing="0" cellpadding="2">
    <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" width="100%" colspan="3"><b><?php echo TEXT_LANGUAGE; ?></b></td>
    </tr>
    <?php
    echo xtc_draw_form('lang_edit', FILENAME_ORDERS_EDIT, 'action=lang_edit', 'post');
    $lang_query = xtc_db_query("select languages_id, name, directory from " . TABLE_LANGUAGES . " ");
    while ($lang = xtc_db_fetch_array($lang_query)) {
        ?>
        <tr class="dataTableRow">
            <td class="dataTableContent" align="left" width="30%"><?php echo $lang['name']; ?></td>
            <td class="dataTableContent" align="left" width="30%">
                <?php
                if ($lang['directory'] == $order->info['language']) {
                    echo xtc_draw_radio_field('lang', $lang['languages_id'], 'checked');
                } else {
                    echo xtc_draw_radio_field('lang', $lang['languages_id']);
                }
                ?>
            </td>
            <td class="dataTableContent" align="left">&nbsp;</td>
        </tr>
        <?php
    }
    ?>
    <tr class="dataTableRow">
        <td class="dataTableContent" align="left" colspan="3">
            <?php
            echo xtc_draw_hidden_field('oID', $_GET['oID']);
            echo '<input type="submit" class="button" value="' . BUTTON_SAVE . '"/>';
            ?>
        </td>
    </tr>
</form>
</table>
<!-- Sprachen Ende //-->
<br /><br />
<!-- Währungen Anfang //-->
<table border="0" width="100%" cellspacing="0" cellpadding="2">
    <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" width="100%" colspan="3"><b><?php echo TEXT_CURRENCIES; ?></b></td>
    </tr>
    <?php
    echo xtc_draw_form('curr_edit', FILENAME_ORDERS_EDIT, 'action=curr_edit', 'post');
    $curr_query = xtc_db_query("select currencies_id, title, code, value from " . TABLE_CURRENCIES . " ");
    while ($curr = xtc_db_fetch_array($curr_query)) {
        ?>
        <tr class="dataTableRow">
            <td class="dataTableContent" align="left" width="30%"><?php echo $curr['title']; ?></td>
            <td class="dataTableContent" align="left" width="30%">
                <?php
                if ($curr['code'] == $order->info['currency']) {
                    echo xtc_draw_radio_field('currencies_id', $curr['currencies_id'], 'checked');
                } else {
                    echo xtc_draw_radio_field('currencies_id', $curr['currencies_id']);
                }
                ?>
            </td>
            <td class="dataTableContent" align="left">&nbsp;</td>
        </tr>
        <?php
    }
    ?>
    <tr class="dataTableRow">
        <td class="dataTableContent" align="left" colspan="3">
            <?php
            echo xtc_draw_hidden_field('old_currency', $order->info['currency']);
            echo xtc_draw_hidden_field('oID', $_GET['oID']);
            echo '<input type="submit" class="button" value="' . BUTTON_SAVE . '"/>';
            ?>
        </td>
    </tr>
</form>
</table>
<!-- Währungen Ende //-->
<br /><br />
<!-- Zahlung Anfang //-->
<table border="0" width="100%" cellspacing="0" cellpadding="2">
    <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" width="100%" colspan="4"><b><?php echo TEXT_PAYMENT; ?></b></td>
    </tr>
    <?php
    if (trim(MODULE_PAYMENT_INSTALLED) != '') {
        $payments = explode(';', MODULE_PAYMENT_INSTALLED);
        for ($i = 0; $i < count($payments); $i++) {
            if (file_exists(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/payment/checkout/' . $payments[$i])) {
                require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/payment/checkout/' . $payments[$i]);
            } else {
                require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/payment/' . $payments[$i]);
            }
            $payment_modul = substr($payments[$i], 0, strrpos($payments[$i], '.'));
            $payment_text = constant('MODULE_PAYMENT_' . strtoupper($payment_modul) . '_TEXT_TITLE');
            $payment_array[] = array('id' => $payment_modul,
                'text' => $payment_text);
        }
    }
    $order_payment = $order->info['payment_class'];
    if (file_exists(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/payment/' . $order_payment . '.php')) {
        if (file_exists(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/payment/checkout/' . $order_payment . '.php')) {
            require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/payment/checkout/' . $order_payment . '.php');
        } else {
            require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/payment/' . $order_payment . '.php');
        }
        $order_payment_text = constant('MODULE_PAYMENT_' . strtoupper($order_payment) . '_TEXT_TITLE');
    }

    echo xtc_draw_form('payment_edit', FILENAME_ORDERS_EDIT, 'action=payment_edit', 'post');
    ?>
    <tr class="dataTableRow">
        <td class="dataTableContent" align="left" width="30%">
            <?php
            echo TEXT_ACTUAL . $order_payment_text;
            ?>
        </td>
        <td class="dataTableContent" align="left" width="30%">
            <?php
            echo TEXT_NEW . xtc_draw_pull_down_menu('payment', $payment_array, $order_payment);
            ?>
        </td>
        <td class="dataTableContent" align="left">
            <?php
            echo xtc_draw_hidden_field('oID', $_GET['oID']);
            echo '<input type="submit" class="button" value="' . BUTTON_SAVE . '"/>';
            ?>
        </td>
    </tr>
</form>
</table>
<!-- Zahlung Ende //-->
<br /><br />
<!-- Versand Anfang //-->
<table border="0" width="100%" cellspacing="0" cellpadding="2">
    <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" width="100%" colspan="4"><b><?php echo TEXT_SHIPPING; ?></b></td>
    </tr>
    <?php
    $shippings = explode(';', MODULE_SHIPPING_INSTALLED);
    for ($i = 0; $i < count($shippings); $i++) {
        if (isset($shippings[$i]) && is_file(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/shipping/' . $shippings[$i])) {
            if (is_file(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/shipping/checkout/' . $shippings[$i])) {
                require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/shipping/checkout/' . $shippings[$i]);
            } else {
                require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/shipping/' . $shippings[$i]);
            }
            $shipping_modul = substr($shippings[$i], 0, strrpos($shippings[$i], '.'));
            $shipping_text = constant('MODULE_SHIPPING_' . strtoupper($shipping_modul) . '_TEXT_TITLE');
            $shipping_array[] = array('id' => $shipping_modul,
                'text' => $shipping_text);
        }
    }
    $order_shipping = explode('_', $order->info['shipping_class']); // Hetfield - 2009-08-18 - replaced deprecated function split with explode to be ready for PHP >= 5.3
    $order_shipping = $order_shipping[0];
    if (is_file(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/shipping/' . $order_shipping . '.php')) {
        if (is_file(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/shipping/checkout/' . $order_shipping . '.php')) {
            require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/shipping/checkout/' . $order_shipping . '.php');
        } else {
            require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/shipping/' . $order_shipping . '.php');
        }
        $order_shipping_text = constant('MODULE_SHIPPING_' . strtoupper($order_shipping) . '_TEXT_TITLE');
    }
    echo xtc_draw_form('shipping_edit', FILENAME_ORDERS_EDIT, 'action=shipping_edit', 'post');
    ?>
    <tr class="dataTableRow">
        <td class="dataTableContent" align="left" width="30%">
            <?php
            echo TEXT_ACTUAL . $order_shipping_text;
            ?>
        </td>
        <td class="dataTableContent" align="left" width="30%">
            <?php
            echo TEXT_NEW . xtc_draw_pull_down_menu('shipping', $shipping_array, $order_shipping);
            ?>
        </td>
        <td class="dataTableContent" align="left">
            <?php
            $order_total_query = xtc_db_query("select value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_GET['oID'] . "' and class = 'ot_shipping' ");
            $order_total = xtc_db_fetch_array($order_total_query);
            echo TEXT_PRICE . xtc_draw_input_field('value', $order_total['value']);
            ?>
        </td>
        <td class="dataTableContent" align="left">
            <?php
            echo xtc_draw_hidden_field('oID', $_GET['oID']);
            echo '<input type="submit" class="button" value="' . BUTTON_SAVE . '"/>';
            ?>
        </td>
    </tr>
</form>
</table>
<!-- Versand Ende //-->
<br /><br />
<!-- OT Module Anfang //-->
<table border="0" width="100%" cellspacing="0" cellpadding="2">
    <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" style="width:200px"><b><?php echo TEXT_ORDER_TOTAL; ?></b></td>
        <td class="dataTableHeadingContent" style="width:300px"><b><?php echo TEXT_ORDER_TITLE; ?></b></td>
        <td class="dataTableHeadingContent" style="width:200px"><b><?php echo TEXT_ORDER_VALUE; ?></b></td>
        <td class="dataTableHeadingContent" width="" colspan="2">&nbsp;</td>
    </tr>
    <?php
    $totals = explode(';', MODULE_ORDER_TOTAL_INSTALLED);
    for ($i = 0; $i < count($totals); $i++) {
        require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/order_total/' . $totals[$i]);
        $total = substr($totals[$i], 0, strrpos($totals[$i], '.'));
        $total_name = str_replace('ot_', '', $total);
        $total_text = constant(MODULE_ORDER_TOTAL_ . strtoupper($total_name) . _TITLE);
        $ototal_query = xtc_db_query("select orders_total_id, title, value, class from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_GET['oID'] . "' and class = '" . $total . "' ");
        $ototal = xtc_db_fetch_array($ototal_query);
        ?>
        <tr class="dataTableRow">
            <?php echo xtc_draw_form('ot_edit', FILENAME_ORDERS_EDIT, 'action=ot_edit', 'post'); ?>
            <td class="dataTableContent" align="left"><?php echo $total_text; ?></td>
            <td class="dataTableContent" align="left"><?php echo xtc_draw_input_field('title', $ototal['title'], 'size=40'); ?></td>
            <td class="dataTableContent" align="left" width="20%"><?php echo xtc_draw_input_field('value', $ototal['value']); ?></td>
            <td class="dataTableContent" align="left">
                <?php
                echo xtc_draw_hidden_field('class', $total);
                echo xtc_draw_hidden_field('sort_order', constant(MODULE_ORDER_TOTAL_ . strtoupper($total_name) . _SORT_ORDER));
                echo xtc_draw_hidden_field('oID', $_GET['oID']);
                echo '<input type="submit" class="button" value="' . BUTTON_SAVE . '"/>';
                ?>
            </td>
            </form>
            <td>
                <?php
                echo xtc_draw_form('ot_delete', FILENAME_ORDERS_EDIT, 'action=ot_delete', 'post');
                echo xtc_draw_hidden_field('oID', $_GET['oID']);
                echo xtc_draw_hidden_field('otID', $ototal['orders_total_id']);

                if ($total != 'ot_total') {
                    echo '<input type="submit" class="button" value="' . BUTTON_DELETE . '"/>';
                }
                ?>
                </form>
            </td>
        </tr>
    <?php
    // }
}
?>
</table>