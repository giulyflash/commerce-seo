<?php

/*
 * id = ot_billsafe.php
 * location = /includes/modules/order_total
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @package BillSAFE_2
 * @copyright (C) 2011 Bernd Blazynski
 * @license GPLv2
 */

class ot_billsafe {

    var $title;
    var $output;
    var $is_ajax = false;

    function ot_billsafe() {
        if (CHECKOUT_AJAX_STAT == 'true') {
            $this->is_ajax = true;
        }
        $this->code = 'ot_billsafe';
        $this->title = MODULE_ORDER_TOTAL_BILLSAFE_TITLE;
        $this->description = MODULE_ORDER_TOTAL_BILLSAFE_DESCRIPTION;
        $this->enabled = MODULE_ORDER_TOTAL_BILLSAFE_STATUS == 'true' ? true : false;
        $this->sort_order = MODULE_ORDER_TOTAL_BILLSAFE_SORT_ORDER;
        $this->output = array();
        $this->amount = 0;
        $this->original_total = 0;
        $this->amounts = array();
        $this->schg = array();
    }

    function process() {
        global $order, $xtPrice;
        if ($this->enabled) {
            if ($_SESSION['payment'] == 'billsafe_2') {
                $this->xtc_order_total();
                $this->calc_schg();
                if ($this->schg['amount'] != 0) {
                    if (stristr(MODULE_PAYMENT_BILLSAFE_2_SCHG, '%')) {
                        $this->output[] = array('title' => MODULE_PAYMENT_BILLSAFE_2_SCHG . '&nbsp;' . MODULE_ORDER_TOTAL_BILLSAFE_SCHG, 'text' => $xtPrice->xtcFormat($this->schg['amount'], true), 'value' => $this->schg['amount']);
                    } else {
                        $this->output[] = array('title' => MODULE_ORDER_TOTAL_BILLSAFE_SCHG, 'text' => $xtPrice->xtcFormat($this->schg['amount'], true), 'value' => $this->schg['amount']);
                    }
                    $order->info['total'] += $this->schg['amount'];
                    if ($this->is_ajax) {
                        $_SESSION['discount_value'] = $GLOBALS['ot_discount']->output[0]['value'];
                        $_SESSION['discount_name'] = $GLOBALS['ot_discount']->output[0]['title'];
                        $_SESSION['voucher_value'] = $GLOBALS['ot_gv']->output[0]['value'];
                        $_SESSION['voucher_name'] = $GLOBALS['ot_gv']->output[0]['title'];
                        $_SESSION['coupon_value'] = $GLOBALS['ot_coupon']->output[0]['value'];
                        $_SESSION['coupon_name'] = $GLOBALS['ot_coupon']->output[0]['title'];
                        $_SESSION['schg_value'] = $GLOBALS['ot_billsafe']->output[0]['value'];
                        $_SESSION['schg_name'] = $GLOBALS['ot_billsafe']->output[0]['title'];
                        $_SESSION['lofee_value'] = $GLOBALS['ot_loworderfee']->output[0]['value'];
                        $_SESSION['lofee_name'] = $GLOBALS['ot_loworderfee']->output[0]['title'];
                    }
//					$order->info['tax'] += $this->schg['tax'];
                }
            }
        }
    }

    function calc_schg() {
        global $order;
        if (MODULE_PAYMENT_BILLSAFE_2_SCHG != '') {
            $schg_tax_rate = xtc_get_tax_rate(MODULE_PAYMENT_BILLSAFE_2_SCHGTAX);
            $schg_tax_name = xtc_get_tax_description(MODULE_PAYMENT_BILLSAFE_2_SCHGTAX);
            if (stristr(MODULE_PAYMENT_BILLSAFE_2_SCHG, '%')) {
                if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) {
                    $schg_amount = xtc_add_tax(($this->amount * MODULE_PAYMENT_BILLSAFE_2_SCHG / 100), $schg_tax_rate);
                    $schg_amount_calc = $this->amount * MODULE_PAYMENT_BILLSAFE_2_SCHG / 100;
                } else {
                    $schg_amount = $this->amount * MODULE_PAYMENT_BILLSAFE_2_SCHG / 100;
                    $schg_amount_calc = $this->amount * MODULE_PAYMENT_BILLSAFE_2_SCHG / 100;
                }
            } else {
                if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) {
                    $schg_amount = xtc_add_tax(MODULE_PAYMENT_BILLSAFE_2_SCHG, $schg_tax_rate);
                    $schg_amount_calc = MODULE_PAYMENT_BILLSAFE_2_SCHG;
                } else {
                    $schg_amount = MODULE_PAYMENT_BILLSAFE_2_SCHG;
                    $schg_amount_calc = MODULE_PAYMENT_BILLSAFE_2_SCHG;
                }
            }
            $schg_tax = $schg_amount_calc * $schg_tax_rate / 100;
        } else {
            $schg_amount = 0;
            $schg_tax = 0;
        }
        if ($schg_tax_rate && ($schg_tax > 0)) {
            reset($order->info['tax_groups']);
            while (list($key, $value) = each($order->info['tax_groups'])) {
                if (strpos($key, $schg_tax_rate . '%')) {
                    $order->info['tax_groups'][$key] += $schg_tax;
                } else {
                    $order->info['tax_groups'][TAX_ADD_TAX . $schg_tax_name] += $schg_tax;
                }
            }
        }
        $this->schg['amount'] = $schg_amount;
        $this->schg['tax'] = $schg_tax;
    }

    function xtc_order_total() {
        global $order;
        $order_total = $order->info['total'];
        $products = $_SESSION['cart']->get_products();
        for ($i = 0; $i < sizeof($products); $i++) {
            $prid = xtc_get_prid($products[$i]['id']);
            $gv_query = xtc_db_query('SELECT products_price, products_tax_class_id, products_model FROM ' . TABLE_PRODUCTS . ' WHERE products_id = "' . $prid . '"');
            $gv_result = xtc_db_fetch_array($gv_query);
            $qty = $_SESSION['cart']->get_quantity($products[$i]['id']);
            $products_tax = xtc_get_tax_rate($gv_result['products_tax_class_id']);
            if (preg_match('/^GIFT/', addslashes($gv_result['products_model']))) {
                if ($this->include_tax == 'false') {
                    $gv_amount = $gv_result['products_price'] * $qty;
                } else {
                    $gv_amount = ($gv_result['products_price'] + xtc_calculate_tax($gv_result['products_price'], $products_tax)) * $qty;
                }
                $order_total -= $gv_amount;
            } else {
                $this->amounts[(string) $products_tax] += $gv_result['products_price'] * (int) $qty;
                $this->amounts['total'] += $gv_result['products_price'] * $qty;
            }
        }
        $this->amount = $order_total;
    }

    function check() {
        if (!isset($this->check)) {
            $check_query = xtc_db_query('SELECT configuration_value FROM ' . TABLE_CONFIGURATION . ' WHERE configuration_key = "MODULE_ORDER_TOTAL_BILLSAFE_STATUS"');
            $this->check = xtc_db_num_rows($check_query);
        }
        return $this->check;
    }

    function install() {
        xtc_db_query('INSERT INTO ' . TABLE_CONFIGURATION . ' (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ("MODULE_ORDER_TOTAL_BILLSAFE_STATUS", "true", "6", "1", "xtc_cfg_select_option(array(\'true\', \'false\'), ", now())');
        xtc_db_query('INSERT INTO ' . TABLE_CONFIGURATION . ' (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ("MODULE_ORDER_TOTAL_BILLSAFE_SORT_ORDER", "39", "6", "2", now())');
    }

    function keys() {
        $keys = array();
        $check_query = xtc_db_query('SELECT configuration_key FROM ' . TABLE_CONFIGURATION . ' WHERE configuration_key LIKE "MODULE_ORDER_TOTAL_BILLSAFE_%" ORDER BY sort_order');
        while ($key = xtc_db_fetch_array($check_query))
            $keys[] = $key['configuration_key'];
        return $keys;
    }

    function remove() {
        xtc_db_query('DELETE FROM ' . TABLE_CONFIGURATION . ' WHERE configuration_key LIKE "MODULE_ORDER_TOTAL_BILLSAFE_%"');
    }

}

