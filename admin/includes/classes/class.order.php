<?php

/* -----------------------------------------------------------------
 * 	$Id: class.order.php 420 2013-06-19 18:04:39Z akausch $
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

class order {

    var $info, $totals, $products, $customer, $delivery;

    // function __construct() {
    // }

    function order($order_id) {
        $this->info = array();
        $this->totals = array();
        $this->products = array();
        $this->customer = array();
        $this->delivery = array();
        $this->query($order_id);
    }

    function query($order_id) {

        $order_query = xtc_db_query("SELECT *
                                     FROM " . TABLE_ORDERS . " 
                                    WHERE orders_id = '" . xtc_db_input($order_id) . "'
                                  ");

        $order = xtc_db_fetch_array($order_query);

        $totals_query = xtc_db_query("SELECT title,
                                           text,
                                           value
                                      FROM " . TABLE_ORDERS_TOTAL . "
                                     WHERE orders_id = '" . xtc_db_input($order_id) . "'
                                     ORDER BY sort_order
                                    ");

        while ($totals = xtc_db_fetch_array($totals_query)) {
            $this->totals[] = array('title' => $totals['title'],
                'value' => $totals['value'],
                'text' => $totals['text']);
        }

        $order['order_id'] = $order_id;
        $this->info = array('order_id' => $order['order_id'], //DokuMan - 2011-08-31 - fix order_id assignment
            'currency' => $order['currency'],
            'currency_value' => $order['currency_value'],
            'payment_method' => $order['payment_method'],
            'account_type' => $order['account_type'],
            'payment_class' => $order['payment_class'],
            'shipping_class' => $order['shipping_class'],
            'shipping_cost' => $order['shipping_cost'],
            'shipping_method' => $order['shipping_method'],
            'status' => $order['customers_status'],
            'status_name' => $order['customers_status_name'],
            'status_image' => $order['customers_status_image'],
            'status_discount' => $order['customers_status_discount'],
            'cc_type' => $order['cc_type'],
            'cc_owner' => $order['cc_owner'],
            'cc_number' => $order['cc_number'],
            'cc_expires' => $order['cc_expires'],
            'cc_cvv' => $order['cc_cvv'],
            'comments' => $order['comments'],
            'language' => $order['language'],
            'date_purchased' => $order['date_purchased'],
            'orders_status' => $order['orders_status'],
            'id' => $order_id,
            'last_modified' => $order['last_modified']);

        $this->customer = array('id' => $order['customers_id'],
            'customers_status' => $order['customers_status'],
            'name' => $order['customers_name'],
            'lastname' => $order['customers_lastname'],
            'firstname' => $order['customers_firstname'],
            'company' => $order['customers_company'],
            'csID' => $order['customers_cid'],
            'cID' => $order['customers_cid'],
            'vat_id' => $order['customers_vat_id'],
            'ID' => $order['customers_id'],
            'cIP' => $order['customers_ip'],
            'street_address' => $order['customers_street_address'],
            'suburb' => $order['customers_suburb'],
            'city' => $order['customers_city'],
            'postcode' => $order['customers_postcode'],
            'state' => $order['customers_state'],
            'country' => $order['customers_country'],
            'format_id' => $order['customers_address_format_id'],
            'telephone' => $order['customers_telephone'],
            'email_address' => $order['customers_email_address']);

        $this->delivery = array('name' => $order['delivery_name'],
            'firstname' => $order['delivery_firstname'],
            'lastname' => $order['delivery_lastname'],
            'company' => $order['delivery_company'],
            'street_address' => $order['delivery_street_address'],
            'suburb' => $order['delivery_suburb'],
            'city' => $order['delivery_city'],
            'postcode' => $order['delivery_postcode'],
            'state' => $order['delivery_state'],
            'country' => $order['delivery_country'],
            'country_iso_2' => $order['delivery_country_iso_code_2'],
            'format_id' => $order['delivery_address_format_id']);

        $this->billing = array('name' => $order['billing_name'],
            'firstname' => $order['billing_firstname'],
            'lastname' => $order['billing_lastname'],
            'company' => $order['billing_company'],
            'street_address' => $order['billing_street_address'],
            'suburb' => $order['billing_suburb'],
            'city' => $order['billing_city'],
            'postcode' => $order['billing_postcode'],
            'state' => $order['billing_state'],
            'country' => $order['billing_country'],
            'format_id' => $order['billing_address_format_id']);

        $index = 0;
        $orders_products_query = xtc_db_query("SELECT orders_products_id,
                                                    products_id,
                                                    products_name,
                                                    products_model,
                                                    products_price,
                                                    products_tax,
                                                    products_quantity,
                                                    final_price,
                                                    allow_tax,
                                                    products_discount_made
                                               FROM " . TABLE_ORDERS_PRODUCTS . "
                                              WHERE orders_id ='" . xtc_db_input($order_id) . "'
                                             ");

        while ($orders_products = xtc_db_fetch_array($orders_products_query)) {
            $this->products[$index] = array('qty' => $orders_products['products_quantity'],
                'name' => $orders_products['products_name'],
                'id' => $orders_products['products_id'],
                'opid' => $orders_products['orders_products_id'],
                'model' => $orders_products['products_model'],
                'tax' => $orders_products['products_tax'],
                'price' => $orders_products['products_price'],
                'discount' => $orders_products['products_discount_made'],
                'final_price' => $orders_products['final_price'],
                'allow_tax' => $orders_products['allow_tax']);

            $subindex = 0;
            $attributes_query = xtc_db_query("SELECT products_options,
                                                 products_options_values,
                                                 options_values_price,
                                                 price_prefix
                                            FROM " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
                                           WHERE orders_id = '" . xtc_db_input($order_id) . "'
                                             AND orders_products_id = '" . $orders_products['orders_products_id'] . "'
											ORDER BY orders_products_attributes_id ASC
                                          ");

            if (xtc_db_num_rows($attributes_query)) {
                while ($attributes = xtc_db_fetch_array($attributes_query)) {
                    $this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options'],
                        'value' => $attributes['products_options_values'],
                        'prefix' => $attributes['price_prefix'],
                        'price' => $attributes['options_values_price']
                    );

                    $subindex++;
                }
            }
            $index++;
        }
    }

    function getOrderData($oID) {
        global $xtPrice;
        require_once(DIR_FS_INC . 'xtc_get_attributes_model.inc.php');

        $order_query = "SELECT products_id,
                             orders_products_id,
                             products_model,
                             products_name,
                             final_price,
                             products_tax,
                             products_shipping_time,
                             products_quantity
                        FROM " . TABLE_ORDERS_PRODUCTS . "
                       WHERE orders_id='" . (int) $oID . "'";
        $order_data = array();
        $order_query = xtc_db_query($order_query);
        while ($order_data_values = xtc_db_fetch_array($order_query)) {
            $attributes_query = "SELECT products_options,
                                    products_options_values,
                                    price_prefix,
                                    options_values_price
                               FROM " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
                              WHERE orders_products_id='" . $order_data_values['orders_products_id'] . "'
                           ORDER BY orders_products_attributes_id ASC";
            $attributes_data = '';
            $attributes_model = '';
            $attributes_query = xtc_db_query($attributes_query);
            while ($attributes_data_values = xtc_db_fetch_array($attributes_query)) {
                $attributes_data .= '<br />' . $attributes_data_values['products_options'] . ':' . $attributes_data_values['products_options_values'];
                $attributes_model .= '<br />' . xtc_get_attributes_model($order_data_values['products_id'], $attributes_data_values['products_options_values'], $attributes_data_values['products_options']);
            }
            $order_data[] = array('PRODUCTS_MODEL' => $order_data_values['products_model'],
                'PRODUCTS_NAME' => $order_data_values['products_name'],
                'PRODUCTS_SHIPPING_TIME' => $order_data_values['products_shipping_time'],
                'PRODUCTS_ATTRIBUTES' => $attributes_data,
                'PRODUCTS_ATTRIBUTES_MODEL' => $attributes_model,
                'PRODUCTS_PRICE' => $xtPrice->xtcFormat($order_data_values['final_price'], true),
                'PRODUCTS_SINGLE_PRICE' => $xtPrice->xtcFormat($order_data_values['final_price'] / $order_data_values['products_quantity'], true),
                'PRODUCTS_TAX' => ($order_data_values['products_tax'] > 0.00) ? number_format($order_data_values['products_tax'], TAX_DECIMAL_PLACES) : 0,
                'PRODUCTS_QTY' => $order_data_values['products_quantity']
            );
        }
        return $order_data;
    }

    function getTotalData($oID) {
        global $xtPrice, $db;
        // get order_total data    
        $order_total_query = "SELECT title,
                                   text,
                                   class,
                                   value,
                                   sort_order
                              FROM " . TABLE_ORDERS_TOTAL . "
                             WHERE orders_id='" . (int) $oID . "'
                          ORDER BY sort_order ASC";

        $order_total = array();
        $order_total_query = xtc_db_query($order_total_query);

        while ($order_total_values = xtc_db_fetch_array($order_total_query)) {
            $order_total[] = array('TITLE' => $order_total_values['title'],
                'CLASS' => $order_total_values['class'],
                'VALUE' => $order_total_values['value'],
                'TEXT' => $order_total_values['text']
            );
            if ($order_total_values['class'] == 'ot_total') {
                $total = $order_total_values['value'];
            }

            if ($order_total_values['class'] == 'ot_shipping') {
                $shipping = $order_total_values['value'];
            }
        }

        return array('data' => $order_total,
            'total' => $total,
            'shipping' => $shipping
        );
    }

}
