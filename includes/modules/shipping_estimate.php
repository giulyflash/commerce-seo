<?php

/* -----------------------------------------------------------------
 * 	$Id: shipping_estimate.php 420 2013-06-19 18:04:39Z akausch $
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

require_once (DIR_FS_INC . 'xtc_get_country_list.inc.php');
require_once (DIR_WS_CLASSES . 'class.shipping_estimate.php');

$order = new order();
$total = $_SESSION['cart']->show_total();
$selected = isset($_SESSION['customer_country_id']) ? $_SESSION['customer_country_id'] : STORE_COUNTRY;
if (!isset($_SESSION['customer_id']) && sizeof(xtc_get_countriesList()) > 1) {
    if (isset($_SESSION['country'])) {
        $selected = $_SESSION['country'];
    } else {
        $selected = STORE_COUNTRY;
    }
    $module_smarty->assign('SELECT_COUNTRY', xtc_get_country_list(array('name' => 'country'), $selected, 'onchange="this.form.submit()"'));
}

if (!isset($order->delivery['country']['iso_code_2']) || $order->delivery['country']['iso_code_2'] == '') {
    $delivery_zone = xtc_db_fetch_array(xtc_db_query("SELECT countries_id, countries_iso_code_2, countries_name FROM " . TABLE_COUNTRIES . " WHERE countries_id = " . $selected));
    $order->delivery['country']['iso_code_2'] = $delivery_zone['countries_iso_code_2'];
    $order->delivery['country']['title'] = $delivery_zone['countries_name'];
    $order->delivery['country']['id'] = $delivery_zone['countries_id'];
}

$_SESSION['delivery_zone'] = $order->delivery['country']['iso_code_2'];
$shipping = new shipping;
$quotes = $shipping->quote();

$free_shipping = $free_shipping_freeamount = false;
if (defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'true')) {
    switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION) {
        case 'national' :
            if ($order->delivery['country']['id'] == STORE_COUNTRY)
                $pass = true;
            break;
        case 'international' :
            if ($order->delivery['country']['id'] != STORE_COUNTRY)
                $pass = true;
            break;
        case 'both' :
            $pass = true;
            break;
        default :
            $pass = false;
            break;
    }
	
    if (($pass == true) && ($total >= $xtPrice->xtcFormat(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER, false, 0, true))) {
        $free_shipping = true;
    }
}
$has_freeamount = false;
foreach ($quotes as $quote) {
    if ($quote['id'] == 'freeamount') {
        $has_freeamount = true;
        if (isset($quote['methods'])) {
            $free_shipping_freeamount = true;
            break;
        }
    }
}
include_once (DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/order_total/ot_shipping.php');

$shipping_content = array();
if ($free_shipping == true) {
    $shipping_content[] = array(
        'NAME' => FREE_SHIPPING_TITLE,
        'VALUE' => $xtPrice->xtcFormat(0, true, 0, true)
    );
} elseif ($free_shipping_freeamount) {
    $shipping_content[] = array(
        'NAME' => $quote['module'] . ' - ' . $quote['methods'][0]['title'],
        'VALUE' => $xtPrice->xtcFormat(0, true, 0, true)
    );
} else {
    if ($has_freeamount) {
        $module_smarty->assign('FREE_SHIPPING_INFO', sprintf(FREE_SHIPPING_DESCRIPTION, $xtPrice->xtcFormat(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER, true, 0, true)));
    }
    $i = 0;
    foreach ($quotes AS $quote) {
        if ($quote['id'] != 'freeamount') {
            $quote['methods'][0]['cost'] = $xtPrice->xtcCalculateCurr($quote['methods'][0]['cost']);
            $total += ((isset($quote['tax']) && $quote['tax'] > 0) ? $xtPrice->xtcAddTax($quote['methods'][0]['cost'], $quote['tax']) : (!empty($quote['methods'][0]['cost']) ? $quote['methods'][0]['cost'] : '0'));
            if ($_SESSION['customers_status']['customers_status_show_price_tax'] == '1') {
                $shipping_content[$i] = array('NAME' => $quote['module'] . ' - ' . $quote['methods'][0]['title'],
                    'VALUE' => $xtPrice->xtcFormat(((isset($quote['tax']) && $quote['tax'] > 0) ? $xtPrice->xtcAddTax($quote['methods'][0]['cost'], $quote['tax']) : (!empty($quote['methods'][0]['cost']) ? $quote['methods'][0]['cost'] : '0')), true)
                );
            } else {
                $shipping_content[$i] = array('NAME' => $quote['module'] . ' - ' . $quote['methods'][0]['title'],
                    'VALUE' => $xtPrice->xtcFormat(((!empty($quote['methods'][0]['cost']) ? $quote['methods'][0]['cost'] : '0')), true)
                );
            }
            $i++;
        }
    }
}
$module_smarty->assign('shipping_content', $shipping_content);
$module_smarty->assign('COUNTRY', $order->delivery['country']['title']);

if (count($shipping_content) <= 1) {
    $module_smarty->assign('total', $xtPrice->xtcFormat($total, true));
}
