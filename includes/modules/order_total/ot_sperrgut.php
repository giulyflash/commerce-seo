<?php

/* -----------------------------------------------------------------
 * 	$Id: ot_sperrgut.php 420 2013-06-19 18:04:39Z akausch $
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

class ot_sperrgut {

    var $title, $output;

    function ot_sperrgut() {
        global $xtPrice;
        $this->code = 'ot_sperrgut';
        $this->title = MODULE_ORDER_TOTAL_SPERRGUT_TITLE;
        $this->description = MODULE_ORDER_TOTAL_SPERRGUT_DESCRIPTION;
        $this->enabled = ((MODULE_ORDER_TOTAL_SPERRGUT_STATUS == 'true') ? true : false);
        $this->sort_order = MODULE_ORDER_TOTAL_SPERRGUT_SORT_ORDER;
        $this->include_tax = MODULE_ORDER_TOTAL_SPERRGUT_INC_TAX;
        $this->tax_class = MODULE_ORDER_TOTAL_SPERRGUT_TAX_CLASS;

        $this->output = array();
    }

    function process() {
        global $order, $xtPrice;
        if ($order->info['shipping_class'] == 'selfpickup_selfpickup')
            return;

        $sperrgut_qty = 0;
        $sperrgut_costs = 0;
        for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
            $t_query = xtc_db_query('SELECT products_sperrgut FROM products WHERE products_id = ' . (int) $order->products[$i]['id']);
            $t = xtc_db_fetch_array($t_query);
            if ($t['products_sperrgut'] > 0) {
                $sperrgut_qty += $order->products[$i]['qty'];
                $sperrgut_costs += ($order->products[$i]['qty'] * constant('SHIPPING_SPERRGUT_' . $t['products_sperrgut']));
            }
        }
        if ($sperrgut_qty > 0) {
            $tax_rate = xtc_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
            $tax_desc = xtc_get_tax_description($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
            //echo $tax_desc;
            //$products_tax = $xtPrice->TAX[$gv_result['products_tax_class_id']];
            if ($this->include_tax == 'false') {
                $sperrgut_costs = ($sperrgut_costs / (100 + $tax_rate)) * 100;
                //$gv_amount = $gv_result['products_price'] * $qty;
            } else {
                $sperrgut_costs = $sperrgut_costs;
                $tax_value = $sperrgut_costs - ($sperrgut_costs / (100 + $tax_rate)) * 100;
                $order->info['tax'] += $tax_value;
                $order->info['tax_groups'][TAX_ADD_TAX . $tax_desc] += $tax_value;
            }
            $order->info['total'] += $sperrgut_costs;
            $this->output[] = array('title' => $this->title . ' (' . $sperrgut_qty . 'x) :',
                'text' => $xtPrice->xtcFormat($sperrgut_costs, true, 0, true),
                'value' => $xtPrice->xtcFormat($sperrgut_costs, false, 0, true));
        }


        /*
          $module = substr($_SESSION['shipping']['id'], 0, strpos($_SESSION['shipping']['id'], '_'));

          if (xtc_not_null($order->info['shipping_method'])) {
          if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) {
          // price with tax

          $shipping_tax = xtc_get_tax_rate($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $shipping_tax_description = xtc_get_tax_description($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $tax = $xtPrice->xtcFormat(xtc_add_tax($order->info['shipping_cost'], $shipping_tax),false,0,false)-$order->info['shipping_cost'];
          $tax = $xtPrice->xtcFormat($tax,false,0,true);
          $order->info['shipping_cost'] = xtc_add_tax($order->info['shipping_cost'], $shipping_tax);
          $order->info['tax'] += $tax;
          $order->info['tax_groups'][TAX_ADD_TAX . "$shipping_tax_description"] += $tax;
          $order->info['total'] += $tax;

          } else {

          if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {

          $shipping_tax = xtc_get_tax_rate($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $shipping_tax_description = xtc_get_tax_description($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $tax = $xtPrice->xtcFormat(xtc_add_tax($order->info['shipping_cost'], $shipping_tax),false,0,false)-$order->info['shipping_cost'];
          $tax = $xtPrice->xtcFormat($tax,false,0,true);

          $order->info['tax'] = $order->info['tax'] += $tax;
          $order->info['tax_groups'][TAX_NO_TAX . "$shipping_tax_description"] = $order->info['tax_groups'][TAX_NO_TAX . "$shipping_tax_description"] += $tax;
          }
          }
          $this->output[] = array('title' => $order->info['shipping_method'] . ':',
          'text' => $xtPrice->xtcFormat($order->info['shipping_cost'], true,0,true),
          'value' => $xtPrice->xtcFormat($order->info['shipping_cost'], false,0,true));
          }
         */
    }

    function check() {
        if (!isset($this->_check)) {
            $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_SPERRGUT_STATUS'");
            $this->_check = xtc_db_num_rows($check_query);
        }

        return $this->_check;
    }

    function keys() {
        return array('MODULE_ORDER_TOTAL_SPERRGUT_STATUS', 'MODULE_ORDER_TOTAL_SPERRGUT_SORT_ORDER', 'MODULE_ORDER_TOTAL_SPERRGUT_INC_TAX', /* 'MODULE_ORDER_TOTAL_SPERRGUT_CALC_TAX', */ 'MODULE_ORDER_TOTAL_SPERRGUT_TAX_CLASS');
    }

    function install() {
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_SPERRGUT_STATUS', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_SPERRGUT_SORT_ORDER', '35','6', '2', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('', 'MODULE_ORDER_TOTAL_SPERRGUT_INC_TAX', 'true', '6', '6','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
        //xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('', 'MODULE_ORDER_TOTAL_SPERRGUT_CALC_TAX', 'None', '6', '7','xtc_cfg_select_option(array(\'None\', \'Standard\', \'Credit Note\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_id, configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('', 'MODULE_ORDER_TOTAL_SPERRGUT_TAX_CLASS', '0', '6', '0', 'xtc_get_tax_class_title', 'xtc_cfg_pull_down_tax_classes(', now())");
    }

    function remove() {
        xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

}

