<?php

/* -----------------------------------------------------------------
 * 	$Id: ot_shipping.php 457 2013-07-05 16:00:29Z akausch $
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
   
  class ot_shipping {
    var $title, $output;

    function ot_shipping() {
    	global $xtPrice;
      $this->code = 'ot_shipping';
      $this->title = MODULE_ORDER_TOTAL_SHIPPING_TITLE;
      $this->description = MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION;
      $this->enabled = ((MODULE_ORDER_TOTAL_SHIPPING_STATUS == 'true') ? true : false);
      $this->sort_order = MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER;


      $this->output = array();
    }

    function process() {
      global $order, $xtPrice, $free_shipping;

      if (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'true') {
        switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION) {
          case 'national':
            if ($order->delivery['country_id'] == STORE_COUNTRY) $pass = true; break;
          case 'international':
            if ($order->delivery['country_id'] != STORE_COUNTRY) $pass = true; break;
          case 'both':
            $pass = true; break;
          default:
            $pass = false; break;
        }

        if ( ($pass == true) && ( ($order->info['total'] - $order->info['shipping_cost']) >= $xtPrice->xtcFormat(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER,false,0,true)) ) {
          $order->info['shipping_method'] = $this->title;
          $order->info['total'] -= $order->info['shipping_cost'];
          $order->info['shipping_cost'] = 0;
          $free_shipping = true;
        }
      }

      $module = substr($_SESSION['shipping']['id'], 0, strpos($_SESSION['shipping']['id'], '_'));
		//Novalnet Code
		if(!isset($GLOBALS[$module]) && file_exists(DIR_FS_CATALOG . 'includes/modules/shipping/' . basename($module) . '.php'))
		{
			include_once(DIR_FS_CATALOG . 'includes/modules/shipping/' . basename($module) . '.php');
			$GLOBALS[$module] = new $module;
		}
		//Novalnet Code
      // BOF GM_MOD
      if(!isset($GLOBALS[$module]) && file_exists(DIR_FS_CATALOG . 'includes/modules/shipping/' . basename($module) . '.php'))
      {
      	include_once(DIR_FS_CATALOG . 'includes/modules/shipping/' . basename($module) . '.php');
      	$GLOBALS[$module] = new $module;
      } 
      // EOF GM_MOD

      if (xtc_not_null($order->info['shipping_method'])) {
        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) {
        // price with tax

          $shipping_tax = xtc_get_tax_rate($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $shipping_tax_description = xtc_get_tax_description($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $tax = $xtPrice->xtcFormat(xtc_add_tax($order->info['shipping_cost'], $shipping_tax),false,0,false)-$order->info['shipping_cost'];
          // $tax = $xtPrice->xtcFormat($tax,false,0,true);
          $order->info['shipping_cost'] = xtc_add_tax($order->info['shipping_cost'], $shipping_tax);
          $order->info['tax'] += $tax;
          $order->info['tax_groups'][TAX_ADD_TAX . "$shipping_tax_description"] += $tax;

          // BOF GM_MOD:
          $tax = $xtPrice->xtcFormat($tax,false,0,true);
          $order->info['total'] += $tax;

        } else {

        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {

          $shipping_tax = xtc_get_tax_rate($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $shipping_tax_description = xtc_get_tax_description($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $tax = $xtPrice->xtcFormat(xtc_add_tax($order->info['shipping_cost'], $shipping_tax),false,0,false)-$order->info['shipping_cost'];
		 // $tax = $xtPrice->xtcFormat($tax,false,0,true);

          $order->info['tax'] = $order->info['tax'] += $tax;
          $order->info['tax_groups'][TAX_NO_TAX . "$shipping_tax_description"] = $order->info['tax_groups'][TAX_NO_TAX . "$shipping_tax_description"] += $tax;
        }
        }
        $this->output[] = array('title' => $order->info['shipping_method'] . ':',
                                'text' => $xtPrice->xtcFormat($order->info['shipping_cost'], true,0,true),
                                'value' => $xtPrice->xtcFormat($order->info['shipping_cost'], false,0,true));
      }
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_SHIPPING_STATUS'");
        $this->_check = xtc_db_num_rows($check_query);
      }

      return $this->_check;
    }

    function keys() {
      return array('MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', 'MODULE_ORDER_TOTAL_SHIPPING_DESTINATION', 'MODULE_ORDER_TOTAL_SHIPPING_TAX_CLASS');
    }

    function install() {
      xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
      xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER', '3','6', '2', now())");
      xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING', 'false','6', '3', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
      xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, date_added) values ('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', '50', '6', '4', 'currencies->format', now())");
      xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION', 'national','6', '5', 'xtc_cfg_select_option(array(\'national\', \'international\', \'both\'), ', now())");
      xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_ORDER_TOTAL_SHIPPING_TAX_CLASS', '0','6', '7', 'xtc_get_tax_class_title', 'xtc_cfg_pull_down_tax_classes(', now())");      
    }

    function remove() {
      xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }
?>