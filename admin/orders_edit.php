<?php
/* -----------------------------------------------------------------
 * 	$Id: orders_edit.php 452 2013-07-03 12:42:36Z akausch $
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

require ('includes/application_top.php');

//Fuer korrekte Steuerberechnung hier die Rabattmodule eintragen - kommagetrennt
define('DISCOUNT_MODULES', 'ot_discount,ot_coupon,ot_gv,ot_loyalty_discount,ot_payment');

define('FORMAT_NEGATIVE', '<b>%s</b>');

// Benötigte Funktionen und Klassen Anfang:
require (DIR_WS_CLASSES . 'class.order.php');
if (!$_GET['oID']) {
    $_GET['oID'] = $_POST['oID'];
}
$order = new order((int) $_GET['oID']);

require (DIR_FS_CATALOG . DIR_WS_CLASSES . 'class.xtcprice.php');
$xtPrice = new xtcPrice($order->info['currency'], $order->info['status']);

require_once (DIR_FS_INC . 'xtc_get_tax_class_id.inc.php');
require_once (DIR_FS_INC . 'xtc_get_tax_rate.inc.php');

require_once (DIR_FS_INC . 'xtc_oe_get_options_name.inc.php');
require_once (DIR_FS_INC . 'xtc_oe_get_options_values_name.inc.php');
require_once (DIR_FS_INC . 'xtc_oe_customer_infos.inc.php');

require_once (DIR_FS_INC . 'xtc_get_countries.inc.php');
require_once (DIR_FS_INC . 'xtc_get_address_format_id.inc.php');
// Benötigte Funktionen und Klassen Ende
/** BEGIN BILLPAY CHANGED **/
require_once(DIR_FS_CATALOG . 'includes/billpay/utils/billpay_edit_orders.php');
/** EOF BILLPAY CHANGED **/

$action = (isset($_GET['action']) ? $_GET['action'] : '');

// Adressbearbeitung Anfang
if ($action == 'address_edit') {

    $customers_country = xtc_get_countriesList(xtc_db_prepare_input($_POST['customers_country_id']));
    $delivery_country = xtc_get_countriesList(xtc_db_prepare_input($_POST['delivery_country_id']), true);
    $billing_country = xtc_get_countriesList(xtc_db_prepare_input($_POST['billing_country_id']), true);

    $lang_query = xtc_db_query("select languages_id from " . TABLE_LANGUAGES . " where directory = '" . $order->info['language'] . "'");
    $lang = xtc_db_fetch_array($lang_query);

    $status_query = xtc_db_query("select customers_status_name from " . TABLE_CUSTOMERS_STATUS . " where customers_status_id = '" . (int) $_POST['customers_status'] . "' and language_id = '" . (int) $lang['languages_id'] . "' ");
    $status = xtc_db_fetch_array($status_query);

    $sql_data_array = array('customers_vat_id' => xtc_db_prepare_input($_POST['customers_vat_id']),
        'customers_status' => xtc_db_prepare_input($_POST['customers_status']),
        'customers_status_name' => xtc_db_prepare_input($status['customers_status_name']),
        'customers_company' => xtc_db_prepare_input($_POST['customers_company']),
        'customers_firstname' => xtc_db_prepare_input($_POST['customers_firstname']),
        'customers_lastname' => xtc_db_prepare_input($_POST['customers_lastname']),
        'customers_name' => xtc_db_prepare_input($_POST['customers_name']),
        'customers_street_address' => xtc_db_prepare_input($_POST['customers_street_address']),
        'customers_suburb' => xtc_db_prepare_input($_POST['customers_suburb']),
        'customers_city' => xtc_db_prepare_input($_POST['customers_city']),
        'customers_postcode' => xtc_db_prepare_input($_POST['customers_postcode']),
        'customers_country' => $customers_country['countries_name'],
        'customers_telephone' => xtc_db_prepare_input($_POST['customers_telephone']),
        'customers_email_address' => xtc_db_prepare_input($_POST['customers_email_address']),
        'delivery_company' => xtc_db_prepare_input($_POST['delivery_company']),
        'delivery_firstname' => xtc_db_prepare_input($_POST['delivery_firstname']),
        'delivery_lastname' => xtc_db_prepare_input($_POST['delivery_lastname']),
        'delivery_name' => xtc_db_prepare_input($_POST['delivery_name']),
        'delivery_street_address' => xtc_db_prepare_input($_POST['delivery_street_address']),
        'delivery_suburb' => xtc_db_prepare_input($_POST['delivery_suburb']),
        'delivery_city' => xtc_db_prepare_input($_POST['delivery_city']),
        'delivery_postcode' => xtc_db_prepare_input($_POST['delivery_postcode']),
        'delivery_country' => $delivery_country['countries_name'],
        'delivery_country_iso_code_2' => $delivery_country['countries_iso_code_2'],
        'delivery_address_format_id' => xtc_get_address_format_id($_POST['delivery_country_id']),
        'billing_company' => xtc_db_prepare_input($_POST['billing_company']),
        'billing_firstname' => xtc_db_prepare_input($_POST['billing_firstname']),
        'billing_lastname' => xtc_db_prepare_input($_POST['billing_lastname']),
        'billing_name' => xtc_db_prepare_input($_POST['billing_name']),
        'billing_street_address' => xtc_db_prepare_input($_POST['billing_street_address']),
        'billing_suburb' => xtc_db_prepare_input($_POST['billing_suburb']),
        'billing_city' => xtc_db_prepare_input($_POST['billing_city']),
        'billing_postcode' => xtc_db_prepare_input($_POST['billing_postcode']),
        'billing_country' => $billing_country['countries_name'],
        'billing_country_iso_code_2' => $billing_country['countries_iso_code_2'],
        'billing_address_format_id' => xtc_get_address_format_id($_POST['billing_country_id']),
        'last_modified' => 'now()'
    );
    xtc_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id = \'' . (int) ($_POST['oID']) . '\'');

    xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=address&oID=' . (int) $_POST['oID']));
}
// Adressbearbeitung Ende
// Artikeldaten einfügen / bearbeiten Anfang:
// Artikel bearbeiten Anfang:
if ($action == 'product_edit') {

    $lang_query = xtc_db_query("SELECT languages_id FROM " . TABLE_LANGUAGES . " WHERE directory = '" . $order->info['language'] . "'");
    $lang = xtc_db_fetch_array($lang_query);

    $status = get_customers_taxprice_status();

    $product_query = xtc_db_query("SELECT op.allow_tax,
                                        op.products_tax,
                                        p.products_tax_class_id,
                                        pd.products_name
                                   FROM " . TABLE_ORDERS_PRODUCTS . " op
                              LEFT JOIN " . TABLE_PRODUCTS . " p ON op.products_id = p.products_id
                              LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON op.products_id = pd.products_id AND pd.language_id = '" . (int) $lang['languages_id'] . "'
                                  WHERE op.products_id = " . (int) ($_POST['products_id']) . "
                                    AND op.orders_products_id = " . (int) ($_POST['opID'])
    );
    $product = xtc_db_fetch_array($product_query);

    if (isset($_POST['products_tax'])) {
        $product['products_tax'] = $_POST['products_tax'];
    }

    $c_info = get_c_infos($order->customer['ID'], trim($order->delivery['country_iso_2']));

    // $tax_rate = xtc_get_tax_rate($product['products_tax_class_id'], $c_info['country_id'], $c_info['zone_id']);
    //ACHTUNG: es kann die MwSt. mit übergeben werden, ABER die MwSt muss auch existieren
    $tax_rate = $_POST['products_tax'];

    if ($status['customers_status_show_price_tax'] == 0 && $status['customers_status_add_tax_ot'] == 0) {
        $tax_rate = 0;
    }

    if ($tax_rate > 0 && $product['allow_tax'] == 0) {
        $product['products_tax'] = $tax_rate;
    }

    // Korrektur Kundengruppenwechsel
    $group_subtax = $group_addtax = false;
    if ($status['customers_status_show_price_tax'] == 0 && $status['customers_status_add_tax_ot'] == 0 && $product['products_tax'] > 0 && $product['allow_tax'] == 1) {
        $group_subtax = true;
    }
    if ($status['customers_status_show_price_tax'] == 0 && $status['customers_status_add_tax_ot'] == 1 && $product['allow_tax'] == 1) {
        $group_subtax = true;
    }
    if ($status['customers_status_show_price_tax'] == 1 && $status['customers_status_add_tax_ot'] == 0 && $product['allow_tax'] == 0) {
        $group_addtax = true;
    }

    $products_a_query = xtc_db_query("SELECT orders_products_attributes_id,
                                           options_values_price
                                      FROM " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
                                     WHERE orders_products_id = '" . (int) ($_POST['opID']) . "'
									 ORDER BY orders_products_attributes_id ASC
                                   ");


    //Produktpreise neu berechnen - Steuer hinzufügen
    if ($group_addtax) {
        $_POST['products_price'] += $_POST['products_price'] / 100 * $product['products_tax'];
        //Optionspreise neu berechnen  - Steuer hinzufügen 
        while ($products_a = xtc_db_fetch_array($products_a_query)) {
            if ($products_a['options_values_price'] > 0) {
                $products_a['options_values_price'] += $products_a['options_values_price'] / 100 * $product['products_tax'];
            }
        }
    }
    //Produktpreise neu berechnen - Steuer abziehen
    if ($group_subtax) {
        $_POST['products_price'] = $_POST['products_price'] * 100 / (100 + $product['products_tax']);
        //Optionspreise neu berechnen  - Steuer abziehen  
        while ($products_a = xtc_db_fetch_array($products_a_query)) {
            if ($products_a['options_values_price'] > 0) {
                $products_a['options_values_price'] = $products_a['options_values_price'] * 100 / (100 + $product['products_tax']);
            }
        }
    }
    //Gesamtpreis
    $final_price = $_POST['products_price'] * $_POST['products_quantity'];

    $sql_data_array = array('orders_id' => (int) ($_POST['oID']),
        'products_id' => (int) ($_POST['products_id']),
        'products_name' => xtc_db_prepare_input($_POST['products_name']),
        'products_price' => (float) $_POST['products_price'],
        'products_discount_made' => '',
        'final_price' => (float) $final_price,
        'products_tax' => xtc_db_prepare_input($tax_rate),
        'products_quantity' => xtc_db_prepare_input($_POST['products_quantity']),
        'allow_tax' => (int) $status['customers_status_show_price_tax'],
        'products_model' => xtc_db_prepare_input($_POST['products_model'])
    );

    xtc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id = \'' . (int) ($_POST['opID']) . '\'');

    $new_qty = (double) $_POST['old_qty'] - (double) $_POST['products_quantity'];
    xtc_db_query("UPDATE " . TABLE_PRODUCTS . " SET products_quantity = products_quantity + " . $new_qty . " WHERE products_id = " . (int) ($_POST['products_id']));

    xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=products&oID=' . (int) $_POST['oID']));
}
// Artikel bearbeiten Ende:
// Artikel einfügen Anfang
if ($action == 'product_ins') {

    $lang_query = xtc_db_query("select languages_id from " . TABLE_LANGUAGES . " where directory = '" . $order->info['language'] . "'");
    $lang = xtc_db_fetch_array($lang_query);

    $status = get_customers_taxprice_status();

    $shipping_time_query = xtc_db_query("SELECT ps.shipping_status_name
                                         FROM " . TABLE_PRODUCTS . " p,
                                              " . TABLE_SHIPPING_STATUS . " ps
                                        WHERE products_id = '" . (int) $_POST['products_id'] . "'
                                          AND p.products_shippingtime = ps.shipping_status_id
                                          AND ps.language_id = '" . (int) $lang['languages_id'] . "'
                                      ");

    $shipping_time_array = xtc_db_fetch_array($shipping_time_query);

    $shipping_time = $shipping_time_array['shipping_status_name'];

    $product_query = xtc_db_query("SELECT p.products_model,
                                        p.products_tax_class_id,
                                        pd.products_name
                                   FROM " . TABLE_PRODUCTS . " p,
                                        " . TABLE_PRODUCTS_DESCRIPTION . " pd
                                  WHERE p.products_id = '" . (int) $_POST['products_id'] . "'
                                    AND pd.products_id = p.products_id
                                    AND pd.language_id = '" . (int) $lang['languages_id'] . "'
                                ");

    $product = xtc_db_fetch_array($product_query);

    $c_info = get_c_infos($order->customer['ID'], trim($order->delivery['country_iso_2']));

    $tax_rate = xtc_get_tax_rate($product['products_tax_class_id'], $c_info['country_id'], $c_info['zone_id']);

    if ($status['customers_status_show_price_tax'] == 0 && $status['customers_status_add_tax_ot'] == 0) {
        $tax_rate = 0;
    }

    $price = $xtPrice->xtcGetPrice($_POST['products_id'], $format = false, $_POST['products_quantity'], $product['products_tax_class_id'], '', '', $order->customer['ID']);

    $final_price = $price * $_POST['products_quantity'];

    $sql_data_array = array('orders_id' => (int) ($_POST['oID']),
        'products_id' => (int) ($_POST['products_id']),
        'products_name' => xtc_db_prepare_input($product['products_name']),
        'products_price' => (float) $price,
        'products_discount_made' => '',
        'products_shipping_time' => xtc_db_prepare_input($shipping_time),
        'final_price' => (float) $final_price,
        'products_tax' => xtc_db_prepare_input($tax_rate),
        'products_quantity' => xtc_db_prepare_input($_POST['products_quantity']),
        'allow_tax' => (int) $status['customers_status_show_price_tax'],
        'products_model' => xtc_db_prepare_input($product['products_model'])
    );
    xtc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);

    if ($_POST['products_quantity'] != 0) {
        xtc_db_query("UPDATE " . TABLE_PRODUCTS . " SET products_quantity = products_quantity - " . (double) $_POST['products_quantity'] . " WHERE products_id= " . (int) $_POST['products_id']);
    }
    xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=products&oID=' . $_POST['oID']));
}
// Artikel einfügen Ende
// Produkt Optionen bearbeiten Anfang
if ($action == 'product_option_edit') {

    $lang_query = xtc_db_query("select languages_id from " . TABLE_LANGUAGES . " where directory = '" . $order->info['language'] . "'");
    $lang = xtc_db_fetch_array($lang_query);

    $status = get_customers_taxprice_status();

    $sql_data_array = array('products_options' => xtc_db_prepare_input($_POST['products_options']),
        'products_options_values' => xtc_db_prepare_input($_POST['products_options_values']),
        'options_values_price' => xtc_db_prepare_input($_POST['options_values_price'])
    );

    $update_sql_data = array('price_prefix' => xtc_db_prepare_input($_POST['prefix']));
    $sql_data_array = xtc_array_merge($sql_data_array, $update_sql_data);
    xtc_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array, 'update', 'orders_products_attributes_id = \'' . xtc_db_input($_POST['opAID']) . '\'');

    $products_query = xtc_db_query("select op.products_id,
                                         op.products_quantity,
                                         op.products_discount_made,
                                         op.products_tax
                                    from " . TABLE_ORDERS_PRODUCTS . " op
                                   where op.orders_products_id = '" . (int) $_POST['opID'] . "'
                                ");
    $products = xtc_db_fetch_array($products_query);

    $products_a_query = xtc_db_query("SELECT options_values_price, price_prefix FROM " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " WHERE orders_products_id = '" . (int) $_POST['opID'] . "'");

    $ov_price = 0;
    while ($products_a = xtc_db_fetch_array($products_a_query)) {
        $ov_price += $products_a['price_prefix'] . $products_a['options_values_price'];
    };

    //Attribute Discount
    $discount = 0;
    if ($status['customers_status_discount_attributes'] == 1 && $status['customers_status_discount'] != 0.00 && $options_values_price > 0.00) {
        $discount = $status['customers_status_discount'];
        if ($products['products_discount_made'] < $status['customers_status_discount']) {
            $discount = $products['products_discount_made'];
        }
        $ov_price -= $ov_price / 100 * $discount;
    }

    //Produktpreis/Sonderpreis/Staffelpreis/Gruppenpreis/Dicountpreis ohne Steuer
    $products_old_price = $xtPrice->xtcGetPrice($products['products_id'], $format = false, $products['products_quantity'], '', '', '', $order->customer['ID']);

    //Gesamtpreis
    $products_price = ($products_old_price + $ov_price);

    //Steuer UND Währungskorrektur
    $tax_rate = $products['products_tax'];
    if ($status['customers_status_show_price_tax'] == 0 && $status['customers_status_add_tax_ot'] == 0) {
        $tax_rate = 0;
    }
    $price = $xtPrice->xtcAddTax($products_price, $tax_rate); //tax by products


    $final_price = $price * $products['products_quantity'];

    $sql_data_array = array('products_price' => xtc_db_prepare_input($price));
    $update_sql_data = array('final_price' => xtc_db_prepare_input($final_price));
    $sql_data_array = xtc_array_merge($sql_data_array, $update_sql_data);
    xtc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id = \'' . (int) ($_POST['opID']) . '\'');

    xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=options&oID=' . (int) $_POST['oID'] . '&pID=' . (int) $products['products_id'] . '&opID=' . (int) $_POST['opID']));
}
// Produkt Optionen bearbeiten Ende
// Produkt Optionen einfügen Anfang
if ($action == 'product_option_ins') {

    $lang_query = xtc_db_query("select languages_id from " . TABLE_LANGUAGES . " where directory = '" . $order->info['language'] . "'");
    $lang = xtc_db_fetch_array($lang_query);

    $status = get_customers_taxprice_status();

    $products_attributes_query = xtc_db_query("SELECT options_id,
                                                    options_values_id,
                                                    options_values_price,
                                                    price_prefix
                                               FROM " . TABLE_PRODUCTS_ATTRIBUTES . "
                                              WHERE products_attributes_id = '" . (int) $_POST['aID'] . "'");
    $products_attributes = xtc_db_fetch_array($products_attributes_query);

    $products_options_query = xtc_db_query("SELECT products_options_name
                                            FROM " . TABLE_PRODUCTS_OPTIONS . "
                                           WHERE products_options_id = '" . (int) $products_attributes['options_id'] . "'
                                             AND language_id = '" . (int) $lang['languages_id'] . "'
                                         ");
    $products_options = xtc_db_fetch_array($products_options_query);

    $products_options_values_query = xtc_db_query("SELECT products_options_values_name
                                                   FROM " . TABLE_PRODUCTS_OPTIONS_VALUES . "
                                                  WHERE products_options_values_id = '" . (int) $products_attributes['options_values_id'] . "'
                                                    AND language_id = '" . (int) $lang['languages_id'] . "'
                                                ");
    $products_options_values = xtc_db_fetch_array($products_options_values_query);

    $sql_data_array = array('orders_id' => (int) ($_POST['oID']),
        'orders_products_id' => (int) ($_POST['opID']),
        'products_options' => xtc_db_prepare_input($products_options['products_options_name']),
        'products_options_values' => xtc_db_prepare_input($products_options_values['products_options_values_name']),
        'options_values_price' => xtc_db_prepare_input($products_attributes['options_values_price']));

    $insert_sql_data = array('price_prefix' => xtc_db_prepare_input($products_attributes['price_prefix']));
    $sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
    xtc_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

    $products_query = xtc_db_query("SELECT op.products_id, 
										op.products_quantity,
										op.products_discount_made, 
										op.products_tax, 
										p.products_tax_class_id
									FROM 
										" . TABLE_ORDERS_PRODUCTS . " op, 
										" . TABLE_PRODUCTS . " p
									WHERE 
										op.orders_products_id = '" . (int) $_POST['opID'] . "'
									AND 
										op.products_id = p.products_id");

    $products = xtc_db_fetch_array($products_query);

    $products_a_query = xtc_db_query("SELECT options_values_price, price_prefix FROM " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " WHERE orders_products_id = '" . (int) $_POST['opID'] . "'");

    $ov_price = 0;
    while ($products_a = xtc_db_fetch_array($products_a_query)) {
        $ov_price += $products_a['price_prefix'] . $products_a['options_values_price'];
    };

    if (DOWNLOAD_ENABLED == 'true') {
        $attributes_query = "SELECT popt.products_options_name,
                                poval.products_options_values_name,
                                pa.options_values_price,
                                pa.price_prefix,
                                pad.products_attributes_maxdays,
                                pad.products_attributes_maxcount,
                                pad.products_attributes_filename
                           FROM " . TABLE_PRODUCTS_OPTIONS . " popt,
                                " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval,
                                " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                      LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                             ON pa.products_attributes_id=pad.products_attributes_id
                          WHERE pa.products_id = '" . (int) $products['products_id'] . "'
                            AND pa.options_id = '" . (int) $products_attributes['options_id'] . "'
                            AND pa.options_id = popt.products_options_id
                            AND pa.options_values_id = '" . (int) $products_attributes['options_values_id'] . "'
                            AND pa.options_values_id = poval.products_options_values_id
                            AND popt.language_id = '" . (int) $lang['languages_id'] . "'
                            AND poval.language_id = '" . (int) $lang['languages_id'] . "'";

        $attributes = xtc_db_query($attributes_query);

        $attributes_values = xtc_db_fetch_array($attributes);

        if (isset($attributes_values['products_attributes_filename']) && xtc_not_null($attributes_values['products_attributes_filename'])) {
            $sql_data_array = array('orders_id' => (int) ($_POST['oID']),
                'orders_products_id' => (int) ($_POST['opID']),
                'orders_products_filename' => $attributes_values['products_attributes_filename'],
                'download_maxdays' => $attributes_values['products_attributes_maxdays'],
                'download_count' => $attributes_values['products_attributes_maxcount']);

            xtc_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
        }
    }

    //Attribute Discount
    $discount = 0;
    if ($status['customers_status_discount_attributes'] == 1 && $status['customers_status_discount'] != 0.00 && $options_values_price > 0.00) {
        $discount = $status['customers_status_discount'];
        if ($products['products_discount_made'] < $status['customers_status_discount']) {
            $discount = $products['products_discount_made'];
        }
        $ov_price -= $ov_price / 100 * $discount;
    }

    //Produktpreis/Sonderpreis/Staffelpreis/Gruppenpreis/Dicountpreis ohne Steuer
    $products_old_price = $xtPrice->xtcGetPrice($products['products_id'], $format = false, $products['products_quantity'], '', '', '', $order->customer['ID']);

    //Gesamtpreis
    $products_price = ($products_old_price + $ov_price);

    //Steuer UND Währungskorrektur
    $tax_rate = $products['products_tax'];
    if ($status['customers_status_show_price_tax'] == 0 && $status['customers_status_add_tax_ot'] == 0) {
        $tax_rate = 0;
    }
    $price = $xtPrice->xtcAddTax($products_price, $tax_rate); //tax by products

    $final_price = $price * $products['products_quantity'];

    $sql_data_array = array('products_price' => xtc_db_prepare_input($price));
    $update_sql_data = array('final_price' => xtc_db_prepare_input($final_price));
    $sql_data_array = xtc_array_merge($sql_data_array, $update_sql_data);
    xtc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id = \'' . (int) ($_POST['opID']) . '\'');

    xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=options&oID=' . (int) $_POST['oID'] . '&pID=' . (int) $products['products_id'] . '&opID=' . (int) $_POST['opID']));
}

// Produkt Optionen einfügen Ende
// Artikeldaten einfügen / bearbeiten Ende:
// Zahlung Anfang
if ($action == 'payment_edit') {

    $sql_data_array = array('payment_method' => xtc_db_prepare_input($_POST['payment']), 'payment_class' => xtc_db_prepare_input($_POST['payment']),);
    xtc_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id = \'' . (int) ($_POST['oID']) . '\'');

    xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID=' . (int) $_POST['oID']));
}
// Zahlung Ende
// Versandkosten Anfang
if ($action == 'shipping_edit') {

    $module = $_POST['shipping'] . '.php';
    require (DIR_FS_LANGUAGES . $order->info['language'] . '/modules/shipping/' . $module);
    $shipping_text = constant('MODULE_SHIPPING_' . strtoupper($_POST['shipping']) . '_TEXT_TITLE');
    $shipping_class = $_POST['shipping'] . '_' . $_POST['shipping'];

    $text = $xtPrice->xtcFormat($_POST['value'], true);
    $shipping_order = (int) (MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER);
    $sql_data_array = array('orders_id' => (int) ($_POST['oID']),
        'title' => xtc_db_prepare_input($shipping_text),
        'text' => $text,
        'value' => xtc_db_prepare_input($_POST['value']),
        'class' => 'ot_shipping',
        'sort_order' => xtc_db_prepare_input($shipping_order));

    $check_shipping_query = xtc_db_query("select class from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int) $_POST['oID'] . "' and class = 'ot_shipping'");
    if (xtc_db_num_rows($check_shipping_query)) {
        xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_id = \'' . (int) ($_POST['oID']) . '\' and class="ot_shipping"');
    } else {
        xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
    }

    $sql_data_array = array('shipping_method' => xtc_db_prepare_input($shipping_text), 'shipping_class' => xtc_db_prepare_input($shipping_class),);
    xtc_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id = \'' . (int) ($_POST['oID']) . '\'');

    xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID=' . (int) $_POST['oID']));
}
// Versandkosten Ende
// OT Module Anfang:
if ($action == 'ot_edit') {

    if ($_POST['class'] == 'ot_shipping') {
        // ckeck for used  shipping modul
        $module_query = xtc_db_query("select value, class from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int) $_POST['oID'] . "' and class='ot_shipping'");
        if (!xtc_db_num_rows($module_query)) {
            $messageStack->add_session(ERROR_INPUT_SHIPPING_TITLE, 'error');
            xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID=' . (int) $_POST['oID']));
        }
    }
    if ($_POST['value'] != '' && trim($_POST['title']) == '') {
        $messageStack->add_session(ERROR_INPUT_TITLE, 'error');
        xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID=' . (int) $_POST['oID']));
    }
    if ($_POST['value'] == '' && trim($_POST['title']) == '') {
        $messageStack->add_session(ERROR_INPUT_EMPTY, 'error');
        xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID=' . (int) $_POST['oID']));
    }

    $check_total_query = xtc_db_query("select orders_total_id from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_POST['oID'] . "' and class = '" . $_POST['class'] . "'");
    if (xtc_db_num_rows($check_total_query)) {

        $check_total = xtc_db_fetch_array($check_total_query);

        $text = $xtPrice->xtcFormat($_POST['value'], true);

        if ($_POST['value'] < 0) {
            $text = ' ' . sprintf(FORMAT_NEGATIVE, trim($xtPrice->xtcFormat($_POST['value'], true)));
        }

        $sql_data_array = array('title' => xtc_db_prepare_input($_POST['title']),
            'text' => $text,
            'value' => xtc_db_prepare_input($_POST['value']),
            'sort_order' => xtc_db_prepare_input($_POST['sort_order'])
        );

        xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_total_id = \'' . (int) ($check_total['orders_total_id']) . '\'');
    } else {

        $text = $xtPrice->xtcFormat($_POST['value'], true);

        if ($_POST['value'] < 0) {
            $text = ' ' . sprintf(FORMAT_NEGATIVE, trim($xtPrice->xtcFormat($_POST['value'], true)));
        }

        $sql_data_array = array('orders_id' => (int) ($_POST['oID']),
            'title' => xtc_db_prepare_input($_POST['title']),
            'text' => $text,
            'value' => xtc_db_prepare_input($_POST['value']),
            'class' => xtc_db_prepare_input($_POST['class']),
            'sort_order' => xtc_db_prepare_input($_POST['sort_order'])
        );

        xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
    }

    xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID=' . (int) $_POST['oID']));
}
// OT Module Ende
// Sprachupdate Anfang

if ($action == 'lang_edit') {

    // Daten für Sprache wählen
    $lang_query = xtc_db_query("select languages_id, name, directory from " . TABLE_LANGUAGES . " where languages_id = '" . $_POST['lang'] . "'");
    $lang = xtc_db_fetch_array($lang_query);
    // Daten für Sprache wählen Ende
    // Produkte
    $order_products_query = xtc_db_query("select orders_products_id , products_id from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int) $_POST['oID'] . "'");
    while ($order_products = xtc_db_fetch_array($order_products_query)) {

        $products_query = xtc_db_query("SELECT products_name
                                      FROM " . TABLE_PRODUCTS_DESCRIPTION . "
                                     WHERE products_id = '" . (int) $order_products['products_id'] . "'
                                       AND language_id = '" . (int) $_POST['lang'] . "'
                                  ");
        $products = xtc_db_fetch_array($products_query);

        $sql_data_array = array('products_name' => xtc_db_prepare_input($products['products_name']));
        xtc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id  = \'' . (int) ($order_products['orders_products_id']) . '\'');
    };
    // Produkte Ende
    //BOF OT Module
    $order_total_query = xtc_db_query("select orders_total_id, title, class from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_POST['oID'] . "'");
    while ($order_total = xtc_db_fetch_array($order_total_query)) {

        require (DIR_FS_LANGUAGES . $lang['directory'] . '/modules/order_total/' . $order_total['class'] . '.php');
        $name = str_replace('ot_', '', $order_total['class']);
        $text = constant('MODULE_ORDER_TOTAL_' . strtoupper($name) . '_TITLE');

        $sql_data_array = array('title' => xtc_db_prepare_input($text));
        xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_total_id  = \'' . (int) ($order_total['orders_total_id']) . '\'');
    }
    //EOF OT Module

    $sql_data_array = array('language' => xtc_db_prepare_input($lang['directory']));
    xtc_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id  = \'' . (int) ($_POST['oID']) . '\'');

    xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID=' . (int) $_POST['oID']));
}

// Sprachupdate Ende
// Währungswechsel Anfang

if ($action == 'curr_edit') {

    $curr_query = xtc_db_query("SELECT currencies_id,
                                     title,
                                     code,
                                     value
                                FROM " . TABLE_CURRENCIES . "
                               WHERE currencies_id = '" . (int) $_POST['currencies_id'] . "' ");
    $curr = xtc_db_fetch_array($curr_query);

    $old_curr_query = xtc_db_query("select currencies_id, title, code, value from " . TABLE_CURRENCIES . " where code = '" . $_POST['old_currency'] . "' ");
    $old_curr = xtc_db_fetch_array($old_curr_query);

    $sql_data_array = array('currency' => xtc_db_prepare_input($curr['code']), 'currency_value' => xtc_db_prepare_input($curr['value']));
    xtc_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id  = \'' . (int) ($_POST['oID']) . '\'');

    // Produkte
    $order_products_query = xtc_db_query("select orders_products_id , products_id, products_price, final_price from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int) $_POST['oID'] . "'");
    while ($order_products = xtc_db_fetch_array($order_products_query)) {

        if ($old_curr['code'] == DEFAULT_CURRENCY) {
            $xtPrice = new xtcPrice($curr['code'], $order->info['status']);
            $products_price = $xtPrice->xtcGetPrice($order_products['products_id'], $format = false, '', '', $order_products['products_price'], '', $order->customer['ID']);
            $final_price = $xtPrice->xtcGetPrice($order_products['products_id'], $format = false, '', '', $order_products['final_price'], '', $order->customer['ID']);
        } else {
            $xtPrice = new xtcPrice($old_curr['code'], $order->info['status']);
            $p_price = $xtPrice->xtcRemoveCurr($order_products['products_price']);
            $f_price = $xtPrice->xtcRemoveCurr($order_products['final_price']);
            $xtPrice = new xtcPrice($curr['code'], $order->info['status']);
            $products_price = $xtPrice->xtcGetPrice($order_products['products_id'], $format = false, '', '', $p_price, '', $order->customer['ID']);
            $final_price = $xtPrice->xtcGetPrice($order_products['products_id'], $format = false, '', '', $f_price, '', $order->customer['ID']);
        }
        $sql_data_array = array('products_price' => xtc_db_prepare_input($products_price), 'final_price' => xtc_db_prepare_input($final_price));

        xtc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id  = \'' . (int) ($order_products['orders_products_id']) . '\'');
    };
    // Produkte Ende
    // OT
    $order_total_query = xtc_db_query("select orders_total_id, value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int) $_POST['oID'] . "'");
    while ($order_total = xtc_db_fetch_array($order_total_query)) {

        if ($old_curr['code'] == DEFAULT_CURRENCY) {
            $xtPrice = new xtcPrice($curr['code'], $order->info['status']);
            $value = $xtPrice->xtcGetPrice('', $format = false, '', '', $order_total['value'], '', $order->customer['ID']);
        } else {
            $xtPrice = new xtcPrice($old_curr['code'], $order->info['status']);
            $nvalue = $xtPrice->xtcRemoveCurr($order_total['value']);
            $xtPrice = new xtcPrice($curr['code'], $order->info['status']);
            $value = $xtPrice->xtcGetPrice('', $format = false, '', '', $nvalue, '', $order->customer['ID']);
        }

        $text = $xtPrice->xtcFormat($value, true);

        $sql_data_array = array('text' => $text,
            'value' => xtc_db_prepare_input($value));

        xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_total_id  = \'' . (int) ($order_total['orders_total_id']) . '\'');
    }
    // OT Ende

    xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID=' . (int) $_POST['oID']));
}

// Währungswechsel Ende
// Löschfunktionen Anfang:
// Löschen eines Artikels aus der Bestellung Anfang:
if ($action == 'product_delete') {

    xtc_db_query("delete from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_products_id = '" . (int) ($_POST['opID']) . "'");
    xtc_db_query("delete from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int) ($_POST['oID']) . "' and orders_products_id = '" . (int) ($_POST['opID']) . "'");

    xtc_db_query("UPDATE " . TABLE_PRODUCTS . " SET products_quantity = products_quantity + " . xtc_db_input($_POST['del_qty']) . " WHERE products_id = " . (int) $_POST['del_pID']);

    xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=products&oID=' . (int) $_POST['oID']));
}
// Löschen eines Artikels aus der Bestellung Ende:
// Löschen einer Artikeloption aus der Bestellung Anfang:
if ($action == 'product_option_delete') {

    xtc_db_query("delete from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_products_attributes_id = '" . (int) ($_POST['opAID']) . "'");

    $products_query = xtc_db_query("select op.products_id, op.products_quantity, p.products_tax_class_id from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p where op.orders_products_id = '" . (int) $_POST['opID'] . "' and op.products_id = p.products_id");
    $products = xtc_db_fetch_array($products_query);

    $products_a_query = xtc_db_query("select options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_products_id = '" . (int) $_POST['opID'] . "'");
    while ($products_a = xtc_db_fetch_array($products_a_query)) {
        $options_values_price += $products_a['price_prefix'] . $products_a['options_values_price'];
    };

    $products_old_price = $xtPrice->xtcGetPrice($products['products_id'], $format = false, $products['products_quantity'], '', '', '', $order->customer['ID']);
    $products_price = ($products_old_price + $options_values_price);
    $price = $xtPrice->xtcGetPrice($products['products_id'], $format = false, $products['products_quantity'], $products['products_tax_class_id'], $products_price, '', $order->customer['ID']);
    $final_price = $price * $products['products_quantity'];

    $sql_data_array = array('products_price' => xtc_db_prepare_input($price));
    $update_sql_data = array('final_price' => xtc_db_prepare_input($final_price));
    $sql_data_array = xtc_array_merge($sql_data_array, $update_sql_data);
    xtc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id = \'' . (int) ($_POST['opID']) . '\'');

    xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=options&oID=' . (int) $_POST['oID'] . '&pID=' . (int) $products['products_id'] . '&opID=' . (int) $_POST['opID']));
}
// Löschen einer Artikeloptions aus der Bestellung Ende:
// Löschen eines OT Moduls aus der Bestellung Anfang:
if ($action == 'ot_delete') {

    xtc_db_query("delete from " . TABLE_ORDERS_TOTAL . " where orders_total_id = '" . (int) ($_POST['otID']) . "'");

    xtc_redirect(xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID=' . (int) $_POST['oID']));
}
// Löschen eines OT Moduls aus der Bestellung Ende:
// Löschfunktionen Ende
// Rückberechnung Anfang

if ($action == 'save_order') {
    $lang_query = xtc_db_query("SELECT languages_id
                                FROM " . TABLE_LANGUAGES . "
                               WHERE directory = '" . $order->info['language'] . "'");
    $lang = xtc_db_fetch_array($lang_query);

    xtc_db_query("DELETE FROM " . TABLE_ORDERS_RECALCULATE . "
                      WHERE orders_id = '" . (int) ($_POST['oID']) . "'");
    $status_query = xtc_db_query("SELECT customers_status_show_price_tax,
                                       customers_status_add_tax_ot
                                  FROM " . TABLE_CUSTOMERS_STATUS . "
                                 WHERE customers_status_id = '" . $order->info['status'] . "'
                                   AND language_id ='" . (int) $lang['languages_id'] . "'
                               ");
    $status = xtc_db_fetch_array($status_query);

    // Errechne neue Zwischensumme für Artikel Anfang
    $products_query = xtc_db_query("select SUM(final_price) as subtotal_final from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int) $_POST['oID'] . "' ");
    $products = xtc_db_fetch_array($products_query);
    $subtotal_final = $products['subtotal_final'];
    $subtotal_text = $xtPrice->xtcFormat($subtotal_final, true);

    xtc_db_query("update " . TABLE_ORDERS_TOTAL . " set text = '" . $subtotal_text . "', value = '" . $subtotal_final . "' where orders_id = '" . (int) $_POST['oID'] . "' and class = 'ot_subtotal' ");
    // Errechne neue Zwischensumme für Artikel Ende

    $products_query = xtc_db_query("select final_price, products_tax, allow_tax from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int) $_POST['oID'] . "' ");
    while ($products = xtc_db_fetch_array($products_query)) {

        $tax_rate = $products['products_tax'];

        if ($products['allow_tax'] == '1') {
            $bprice = $products['final_price'];
            $nprice = $xtPrice->xtcRemoveTax($bprice, $tax_rate);
            $tax = $xtPrice->calcTax($nprice, $tax_rate);
        } else {
            $nprice = $products['final_price'];
            $bprice = $xtPrice->xtcAddTax($nprice, $tax_rate);
            $tax = $xtPrice->calcTax($nprice, $tax_rate);
        }

        $sql_data_array = array('orders_id' => (int) ($_POST['oID']),
            'n_price' => xtc_db_prepare_input($nprice),
            'b_price' => xtc_db_prepare_input($bprice),
            'tax' => xtc_db_prepare_input($tax),
            'tax_rate' => xtc_db_prepare_input($products['products_tax']));


        $insert_sql_data = array('class' => 'products');
        $sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
        xtc_db_perform(TABLE_ORDERS_RECALCULATE, $sql_data_array);
    }

    $tax_query = xtc_db_query("SELECT tax_rate, SUM(tax) as tax_value
                               FROM " . TABLE_ORDERS_RECALCULATE . "
                              WHERE orders_id = '" . (int) $_POST['oID'] . "'
                                AND class = 'products'
                           GROUP BY tax_rate
                            ");

    while ($tax = xtc_db_fetch_array($tax_query)) {
        $sql_data_array = array('orders_id' => (int) ($_POST['oID']),
            'tax' => xtc_db_prepare_input($tax['tax_value']),
            'tax_rate' => xtc_db_prepare_input($tax['tax_rate']),
            'class' => 'ot_tax'
        );
        xtc_db_perform(TABLE_ORDERS_RECALCULATE, $sql_data_array);
    }

    $module_query = xtc_db_query("SELECT value, class
                                  FROM " . TABLE_ORDERS_TOTAL . "
                                 WHERE orders_id = '" . (int) $_POST['oID'] . "'
                                   AND class!='ot_total'
                                   AND class!='ot_subtotal_no_tax'
                                   AND class!='ot_tax'
                                   AND class!='ot_subtotal'
                                ");

    $discount_modules = array_map('trim', explode(",", DISCOUNT_MODULES));
    while ($module_value = xtc_db_fetch_array($module_query)) {
        $module_name = str_replace('ot_', '', $module_value['class']);
        if (!in_array($module_value['class'], $discount_modules)) {
            $module_tax_class = '0';
            if ($module_name != 'shipping' && defined('MODULE_ORDER_TOTAL_' . strtoupper($module_name) . '_TAX_CLASS')) {
                $module_tax_class = constant('MODULE_ORDER_TOTAL_' . strtoupper($module_name) . '_TAX_CLASS');
            } else {
                $module_tmp_name = explode('_', $order->info['shipping_class']);
                $module_tmp_name = $module_tmp_name[0];
                if ($module_tmp_name != 'selfpickup' && $module_tmp_name != 'free' && defined('MODULE_SHIPPING_' . strtoupper($module_tmp_name) . '_TAX_CLASS')) {
                    $module_tax_class = constant('MODULE_SHIPPING_' . strtoupper($module_tmp_name) . '_TAX_CLASS');
                }
            }
        } else {
            $module_tax_class = '0';
        }

        $c_info = get_c_infos($order->customer['ID'], trim($order->delivery['country_iso_2']));
        $module_tax_rate = xtc_get_tax_rate($module_tax_class, $c_info['country_id'], $c_info['zone_id']);
        if ($status['customers_status_show_price_tax'] == 1) {
            $module_b_price = $module_value['value'];
            if ($module_tax_class == '0') {
                $module_n_price = $module_value['value'];
            } else {
                $module_n_price = $xtPrice->xtcRemoveTax($module_b_price, $module_tax_rate);
            }
            $module_tax = $xtPrice->calcTax($module_n_price, $module_tax_rate);
        } else {
            $module_n_price = $module_value['value'];
            $module_b_price = $xtPrice->xtcAddTax($module_n_price, $module_tax_rate);
            $module_tax = $xtPrice->calcTax($module_n_price, $module_tax_rate);
        }

        if ($module_name != 'shipping' && $module_name != 'cod_fee' && $module_tax_rate == 0) {
            $module_tax = calculate_tax($module_value['value']);
        }

        $sql_data_array = array(
            'orders_id' => (int) ($_POST['oID']),
            'n_price' => xtc_db_prepare_input($module_n_price),
            'b_price' => xtc_db_prepare_input($module_b_price),
            'tax' => xtc_db_prepare_input($module_tax),
            'tax_rate' => xtc_db_prepare_input($module_tax_rate)
        );

        $insert_sql_data = array('class' => $module_value['class']);
        $sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
        xtc_db_perform(TABLE_ORDERS_RECALCULATE, $sql_data_array);
    }
    //Module

    $tax_rate_query = xtc_db_query("select tax_rate from " . TABLE_ORDERS_RECALCULATE . " where orders_id = '" . (int) $_POST['oID'] . "' and class = 'ot_tax' GROUP BY tax_rate");
    while ($newtax = xtc_db_fetch_array($tax_rate_query)) {

        $new_tax_query = xtc_db_query("
                                  SELECT SUM(tax) as new_tax_value
                                    FROM " . TABLE_ORDERS_RECALCULATE . "
                                   WHERE orders_id = '" . (int) $_POST['oID'] . "'
                                     AND class != 'products'
                                     AND tax_rate > 0
                                     AND tax_rate = '" . $newtax['tax_rate'] . "'
                                  ");

        $newtax_array = xtc_db_fetch_array($new_tax_query);

        xtc_db_query("UPDATE " . TABLE_ORDERS_RECALCULATE . "
                     SET tax = '" . xtc_db_prepare_input($newtax_array['new_tax_value']) . "'
                   WHERE orders_id = '" . (int) $_POST['oID'] . "'
                     AND tax_rate = '" . xtc_db_prepare_input($newtax['tax_rate']) . "'
                     AND class = 'ot_tax'
                 ");
    }

    //Gesamtsumme NETTO
    $check_no_tax_value_query = xtc_db_query("select count(*) as count from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int) $_POST['oID'] . "' and class = 'ot_subtotal_no_tax'");
    $check_no_tax_value = xtc_db_fetch_array($check_no_tax_value_query);

    if ((int) $check_no_tax_value['count'] > 0) {

        include (DIR_FS_LANGUAGES . $order->info['language'] . '/modules/order_total/ot_subtotal_no_tax.php');

        $subtotal_no_tax_query = xtc_db_query("select SUM(n_price) as subtotal_no_tax_value from " . TABLE_ORDERS_RECALCULATE . " where orders_id = '" . (int) $_POST['oID'] . "'");
        $subtotal_no_tax_value = xtc_db_fetch_array($subtotal_no_tax_query);
        $subtotal_no_tax_final = $subtotal_no_tax_value['subtotal_no_tax_value'];
        $subtotal_no_tax_text = '<b>' . $xtPrice->xtcFormat($subtotal_no_tax_final, true) . '</b>';

        $sql_data_array = array(
            'title' => MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_TITLE . ':',
            'text' => $subtotal_no_tax_text,
            'value' => $subtotal_no_tax_final,
            'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_SORT_ORDER
        );

        xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', "orders_id = '" . (int) ($_POST['oID']) . "' and class = 'ot_subtotal_no_tax'");
    } else {
        if ($status['customers_status_show_price_tax'] == 0 || $status['customers_status_show_price_tax'] == 1 && $status['customers_status_add_tax_ot'] == 1 && MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS) {

            include (DIR_FS_LANGUAGES . $order->info['language'] . '/modules/order_total/ot_subtotal_no_tax.php');

            $subtotal_no_tax_value_query = xtc_db_query("select SUM(n_price) as subtotal_no_tax_value from " . TABLE_ORDERS_RECALCULATE . " where orders_id = '" . (int) $_POST['oID'] . "'");
            $subtotal_no_tax_value = xtc_db_fetch_array($subtotal_no_tax_value_query);
            $subtotal_no_tax_final = $subtotal_no_tax_value['subtotal_no_tax_value'];
            $subtotal_no_tax_text = '<b>' . $xtPrice->xtcFormat($subtotal_no_tax_final, true) . '</b>';

            $sql_data_array = array(
                'orders_id' => (int) ($_POST['oID']),
                'title' => MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_TITLE . ':',
                'text' => $subtotal_no_tax_text,
                'value' => xtc_db_prepare_input($subtotal_no_tax_final),
                'class' => 'ot_subtotal_no_tax',
                'sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_SORT_ORDER
            );
            xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
        }
    }
    if (!MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS) {
        xtc_db_query("DELETE FROM " . TABLE_ORDERS_TOTAL . " WHERE orders_id = '" . (int) ($_POST['oID']) . "' AND class='ot_subtotal_no_tax'");
    }

    // Alte UST Löschen ANFANG
    xtc_db_query("DELETE FROM " . TABLE_ORDERS_TOTAL . " WHERE orders_id = '" . (int) ($_POST['oID']) . "' AND class='ot_tax'");
    // Alte UST Löschen ENDE

    $ust_query = xtc_db_query("
                            SELECT tax_rate, SUM(tax) as tax_value_new
                              FROM " . TABLE_ORDERS_RECALCULATE . "
                             WHERE orders_id = '" . (int) $_POST['oID'] . "'
                               AND tax !='0'
                               AND class = 'ot_tax'
                          GROUP BY tax_rate DESC
                            ");


    while ($ust = xtc_db_fetch_array($ust_query)) {
        $ust_desc_query = xtc_db_query("select tax_description from " . TABLE_TAX_RATES . " where tax_rate = '" . $ust['tax_rate'] . "'");
        $ust_desc = xtc_db_fetch_array($ust_desc_query);

        $title = $ust_desc['tax_description'];
        $tax_info = '';
        if ($status['customers_status_show_price_tax'] == 1)
            $tax_info = TEXT_ADD_TAX;
        if ($status['customers_status_show_price_tax'] == 0)
            $tax_info = TEXT_NO_TAX;
        $title = $tax_info . $title . ':';

        if ($ust['tax_value_new']) {
            $text = $xtPrice->xtcFormat($ust['tax_value_new'], true);


            $sql_data_array = array(
                'orders_id' => (int) ($_POST['oID']),
                'title' => xtc_db_prepare_input($title),
                'text' => $text,
                'value' => xtc_db_prepare_input($ust['tax_value_new']),
                'class' => 'ot_tax',
                'sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER
            );


            xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
        }
    }

    if ($status['customers_status_show_price_tax'] == 0 && $status['customers_status_add_tax_ot'] == 0) {
        xtc_db_query("DELETE FROM " . TABLE_ORDERS_TOTAL . " WHERE orders_id = '" . (int) ($_POST['oID']) . "' AND class='ot_tax'");
    }

    //Mwst feststellen
    $add_tax = 0;
    $price = 'b_price';
    if ($status['customers_status_show_price_tax'] == 0 || $status['customers_status_show_price_tax'] == 1 && $status['customers_status_add_tax_ot'] == 1) {
        $tax_query = xtc_db_query("select SUM(value) as value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int) ($_POST['oID']) . "' and class='ot_tax'");
        $tax = xtc_db_fetch_array($tax_query);
        $add_tax = $tax['value'];
        $price = 'n_price';
    }

    $total_query = xtc_db_query("select SUM(" . $price . ") as value from " . TABLE_ORDERS_RECALCULATE . " where orders_id = '" . (int) $_POST['oID'] . "'");


    $total = xtc_db_fetch_array($total_query);
    $total_final = $total['value'] + $add_tax; //Mwst hinzurechnen
    $total_text = '<b>' . $xtPrice->xtcFormat($total_final, true) . '</b>';

    xtc_db_query("update " . TABLE_ORDERS_TOTAL . "
                   set text = '" . $total_text . "',
                       value = '" . $total_final . "'
                 where orders_id = '" . (int) $_POST['oID'] . "'
                   and class = 'ot_total'");
    //Errechne neue Gesamtsumme für Artikel
    // Löschen des Zwischenspeichers Anfang
    xtc_db_query("delete from " . TABLE_ORDERS_RECALCULATE . " where orders_id = '" . xtc_db_input($_POST['oID']) . "'");
    // Löschen des Zwischenspeichers Ende

    xtc_redirect(xtc_href_link(FILENAME_ORDERS, 'action=edit&oID=' . (int) $_POST['oID']));
}

// Rückberechnung Ende
//---------------------------------//

function get_customers_taxprice_status() {
    global $order, $lang;

    $status_query = xtc_db_query("SELECT customers_status_show_price_tax,
                                       customers_status_add_tax_ot,
                                       customers_status_discount,
                                       customers_status_discount_attributes
                                  FROM " . TABLE_CUSTOMERS_STATUS . "
                                 WHERE customers_status_id = '" . $order->info['status'] . "'
                                   AND language_id ='" . (int) $lang['languages_id'] . "'
                               ");
    return xtc_db_fetch_array($status_query);
}

//Steuersatz Coupon/Rabatt neu berechnen
//Der Steuersatz muss anhand der Posten mit unterschiedlichen Steuersätzen anteilig berechnet werden
function calculate_tax($amount) {
    global $xtPrice, $status;

    $price = 'b_price';
    if ($status['customers_status_show_price_tax'] == 0 || $status['customers_status_show_price_tax'] == 1 && $status['customers_status_add_tax_ot'] == 1) {
        $price = 'n_price';
    }

    $sum_query = xtc_db_query("select SUM(" . $price . ") as price from " . TABLE_ORDERS_RECALCULATE . " where orders_id = '" . (int) $_POST['oID'] . "' and class = 'products'");
    $sum_total = xtc_db_fetch_array($sum_query);

    //Gutscheinwert/Rabatt in % berechnen, vereinheitlicht die Berechnungen
    if ($sum_total['price'] == 0)
        return 0;
    $amount_pro = $amount / $sum_total['price'] * 100;

    //Steuersätze alle Produkte der Bestellung feststellen
    $tax_rate_query = xtc_db_query("select tax_rate from " . TABLE_ORDERS_RECALCULATE . " where orders_id = '" . (int) $_POST['oID'] . "' and class = 'ot_tax' GROUP BY tax_rate");

    $tod_amount = 0;
    //Berechnungen pro Steuersatz durchführen
    while ($tax_rate = xtc_db_fetch_array($tax_rate_query)) {

        $tax_query = xtc_db_query("select SUM(tax) as value from " . TABLE_ORDERS_RECALCULATE . " where orders_id = '" . (int) $_POST['oID'] . "' and tax_rate = '" . $tax_rate['tax_rate'] . "'and class = 'products'");
        $tax_total = xtc_db_fetch_array($tax_query);

        $god_amount = $tax_total['value'] * $amount_pro / 100;

        $new_tax_query = xtc_db_query("select tax as value from " . TABLE_ORDERS_RECALCULATE . " where orders_id = '" . (int) $_POST['oID'] . "' and tax_rate = '" . $tax_rate['tax_rate'] . "'and class = 'ot_tax'");
        $new_tax_total = xtc_db_fetch_array($new_tax_query);
        $new_tax = $new_tax_total['value'] + $god_amount; //web29 - 2011-08-25 - Fix negative sign
        //Einzelne Steuersätze neu in Kalkulationstabelle speichern
        xtc_db_query("UPDATE " . TABLE_ORDERS_RECALCULATE . "
                     SET tax = '" . xtc_db_prepare_input($new_tax) . "'
                   WHERE orders_id = '" . (int) $_POST['oID'] . "'
                     AND tax_rate = '" . xtc_db_prepare_input($tax_rate['tax_rate']) . "'
                     AND class = 'ot_tax'
                 ");

        $tod_amount += $god_amount; //hier wird die Steuer aufaddiert
    }

    return $tod_amount;
}

function get_c_infos($customers_id, $delivery_country_iso_code_2) {

    $countries_query = xtc_db_query("select c.countries_id
                                    from  " . TABLE_COUNTRIES . " c
                                   where c.countries_iso_code_2  = '" . $delivery_country_iso_code_2 . "'
                                 ");

    $countries = xtc_db_fetch_array($countries_query);

    $zone_id = '';
    if ($countries['countries_id'] > 0) {

        $zones_query = xtc_db_query("select z.zone_id
                                    from " . TABLE_ORDERS . " o,
                                         " . TABLE_ZONES . " z
                                   where o.customers_id  = '" . $customers_id . "'
                                     and z.zone_country_id = '" . $countries['countries_id'] . "'
                                     and z.zone_name = o.delivery_state
                                 ");

        $zones = xtc_db_fetch_array($zones_query);
        $zone_id = $zones['zone_id'];
    }

    $c_info_array = array('country_id' => $countries['countries_id'],
        'zone_id' => $zone_id
    );

    return $c_info_array;
}

require(DIR_WS_INCLUDES . 'header.php');
?>

<table class="outerTable" cellpadding="0" cellspacing="0">
    <tr>
        <td width="100%" valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%" colspan="2">
                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="pageHeading"><?php echo TABLE_HEADING; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td  valign="top">
                        <?php
                        if ($_GET['text'] == 'address') {
                            ?>
                            <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                <tr>
                                    <td class="main">
                                        <b>
                                            <?php
                                            if ($_GET['text'] == 'address') {
                                                echo TEXT_EDIT_ADDRESS_SUCCESS;
                                            }
                                            ?>
                                        </b>
                                    </td>
                                </tr>
                            </table>
                            <?php
                        }
                        ?>
                        <?php
                        if (!isset($_GET['edit_action'])) {
                            ?>
                            <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                <tr>
                                    <td class="myerrorlog">
                                        <?php echo TEXT_ORDERS_EDIT_INFO; ?>
                                    </td>
                                </tr>
                            </table>
                            <br />
                            <?php
                        }
                        ?>
                        <?php
                        if ($_GET['edit_action'] == 'address') {
                            include ('orders_edit_address.php');
                        } elseif ($_GET['edit_action'] == 'products') {
                            include ('orders_edit_products.php');
                        } elseif ($_GET['edit_action'] == 'other') {
                            include ('orders_edit_other.php');
                        } elseif ($_GET['edit_action'] == 'options') {
                            include ('orders_edit_options.php');
                        }
                        ?>

                        <table border="0" width="100%" cellspacing="0" cellpadding="2">
                            <tr class="dataTableRow">
                                <td class="dataTableContent" align="right">
                                    <?php
                                    echo TEXT_SAVE_ORDER;
                                    echo xtc_draw_form('save_order', FILENAME_ORDERS_EDIT, 'action=save_order', 'post');
                                    echo xtc_draw_hidden_field('customers_status_id', $address[customers_status]);
                                    echo xtc_draw_hidden_field('oID', (int) $_GET['oID']);
                                    echo xtc_draw_hidden_field('cID', (int) $_GET['cID']);
                                    echo '<input type="submit" class="button" value="' . BUTTON_SAVE . '"/>';
                                    if (isset($_GET['edit_action'])) {
                                        echo '&nbsp;&nbsp;&nbsp;';
                                        echo '<a class="button" href="' . xtc_href_link(FILENAME_ORDERS_EDIT, 'oID=' . (int) $_GET['oID']) . '">' . BUTTON_BACK . '</a>';
                                    } else {
                                        echo '&nbsp;&nbsp;&nbsp;';
                                        echo '<a class="button" href="' . xtc_href_link(FILENAME_ORDERS, 'action=edit&oID=' . (int) $_GET['oID']) . '">' . BUTTON_BACK . '</a>';
                                    }
                                    ?>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <?php
                    $heading = array();
                    $contents = array();
                    switch ($action) {
                        default :
                            if (is_object($order)) {
                                $heading[] = array('text' => '<b>' . TABLE_HEADING_ORDER . (int) $_GET['oID'] . '</b>');
                                $contents[] = array('align' => 'center', 'text' => '<br />' . TEXT_EDIT_ADDRESS . '<br /><a class="button" href="' . xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=address&oID=' . (int) $_GET['oID']) . '">' . BUTTON_EDIT . '</a><br /><br />');
                                $contents[] = array('align' => 'center', 'text' => '<br />' . TEXT_EDIT_PRODUCTS . '<br /><a class="button" href="' . xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=products&oID=' . (int) $_GET['oID']) . '">' . BUTTON_EDIT . '</a><br /><br />');
                                $contents[] = array('align' => 'center', 'text' => '<br />' . TEXT_EDIT_OTHER . '<br /><a class="button" href="' . xtc_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID=' . (int) $_GET['oID']) . '">' . BUTTON_EDIT . '</a><br /><br />');
                            }
                            break;
                    }
                    if ((xtc_not_null($heading)) && (xtc_not_null($contents))) {
                        echo '            <td width="20%" valign="top">' . "\n";
                        $box = new box;
                        echo $box->infoBox($heading, $contents);
                        echo '            </td>' . "\n";
                    }
                    ?>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?php
require(DIR_WS_INCLUDES . 'footer.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
