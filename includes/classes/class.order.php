<?php
/*-----------------------------------------------------------------
* 	$Id: class.order.php 398 2013-06-17 23:08:26Z akausch $
* 	Copyright (c) 2011-2021 commerce:SEO by Webdesign Erfurt
* 	http://www.commerce-seo.de
* ------------------------------------------------------------------
* 	based on:
* 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
* 	(c) 2002-2003 osCommerce - www.oscommerce.com
* 	(c) 2003     nextcommerce - www.nextcommerce.org
* 	(c) 2005     xt:Commerce - www.xt-commerce.com
* 	Released under the GNU General Public License
* ---------------------------------------------------------------*/


// include needed functions
require_once(DIR_FS_INC . 'xtc_date_long.inc.php');
require_once(DIR_FS_INC . 'xtc_address_format.inc.php');
require_once(DIR_FS_INC . 'xtc_get_country_name.inc.php');
require_once(DIR_FS_INC . 'xtc_get_zone_code.inc.php');
require_once(DIR_FS_INC . 'xtc_get_tax_description.inc.php');


class order {
var $info, $totals, $products, $customer, $delivery, $content_type;

function order($order_id = '') {
	global $xtPrice;
  $this->info = array();
  $this->totals = array();
  $this->products = array();
  $this->customer = array();
  $this->delivery = array();


  if (xtc_not_null($order_id)) {
	$this->query($order_id);
  } else {
	$this->cart();
  }
}

function query($order_id) {

  $order_id = xtc_db_prepare_input($order_id);

  $order_query = xtc_db_query("SELECT
							   *
							   FROM " . TABLE_ORDERS . " WHERE
							   orders_id = '" . xtc_db_input($order_id) . "'");

  $order = xtc_db_fetch_array($order_query);

  $totals_query = xtc_db_query("SELECT * FROM " . TABLE_ORDERS_TOTAL . " where orders_id = '" . xtc_db_input($order_id) . "' order by sort_order");
  while ($totals = xtc_db_fetch_array($totals_query)) {
	$this->totals[] = array('title' => $totals['title'],
							'text' =>$totals['text'],
							'value'=>$totals['value']);
  }

  $order_total_query = xtc_db_query("select text, value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $order_id . "' and class = 'ot_total'");
  $order_total = xtc_db_fetch_array($order_total_query);

  // PayPal Anfang
  $order_tax_query = xtc_db_query("select SUM(value) from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $order_id . "' and class = 'ot_tax'");
  $order_tax = xtc_db_fetch_array($order_tax_query);
  $pp_order_tax=$order_tax['SUM(value)'];
  $pp_order_disc=0;
  $order_disc_query = xtc_db_query("select SUM(value) from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $order_id . "' and class = 'ot_discount'");
  $order_disc = xtc_db_fetch_array($order_disc_query);
  $pp_order_disc+=$order_disc['SUM(value)'];
  $pp_order_gs=0;
  $order_gs_query = xtc_db_query("select SUM(value) from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $order_id . "' and class = 'ot_coupon'");
  $order_gs = xtc_db_fetch_array($order_gs_query);
  $pp_order_gs-=$order_gs['SUM(value)'];
  $order_gs_query = xtc_db_query("select SUM(value) from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $order_id . "' and class = 'ot_gv'");
  $order_gs = xtc_db_fetch_array($order_gs_query);
  $pp_order_gs-=$order_gs['SUM(value)'];
  $pp_order_fee=0;
  $order_fee_query = xtc_db_query("select SUM(value) from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $order_id . "' and class = 'ot_payment'");
  $order_fee = xtc_db_fetch_array($order_fee_query);
  $pp_order_fee+=$order_fee['SUM(value)'];
  $order_fee_query = xtc_db_query("select SUM(value) from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $order_id . "' and class = 'ot_cod_fee'");
  $order_fee = xtc_db_fetch_array($order_fee_query);
  $pp_order_fee+=$order_fee['SUM(value)'];
  $order_fee_query = xtc_db_query("select SUM(value) from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $order_id . "' and class = 'ot_ps_fee'");
  $order_fee = xtc_db_fetch_array($order_fee_query);
  $pp_order_fee+=$order_fee['SUM(value)'];
  $order_fee_query = xtc_db_query("select SUM(value) from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $order_id . "' and class = 'ot_loworderfee'");
  $order_fee = xtc_db_fetch_array($order_fee_query);
  $pp_order_fee+=$order_fee['SUM(value)'];
  // PayPal Ende
  $shipping_method_query = xtc_db_query("select title, value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $order_id . "' and class = 'ot_shipping'");
  $shipping_method = xtc_db_fetch_array($shipping_method_query);

  $order_status_query = xtc_db_query("select orders_status_name from " . TABLE_ORDERS_STATUS . " where orders_status_id = '" . $order['orders_status'] . "' and language_id = '" . $_SESSION['languages_id'] . "'");
  $order_status = xtc_db_fetch_array($order_status_query);

  $this->info = array('currency' => $order['currency'],
					  'currency_value' => $order['currency_value'],
					  'payment_method' => $order['payment_method'],
					  'cc_type' => $order['cc_type'],
					  'cc_owner' => $order['cc_owner'],
					  'cc_number' => $order['cc_number'],
					  'cc_expires' => $order['cc_expires'],
// BMC CC Mod Start
					  'cc_start' => $order['cc_start'],
					  'cc_issue' => $order['cc_issue'],
					  'cc_cvv' => $order['cc_cvv'],
// BMC CC Mod End
					  'date_purchased' => $order['date_purchased'],
					  'orders_status' => $order_status['orders_status_name'],
					  'last_modified' => $order['last_modified'],
					  'total' => strip_tags($order_total['text']),
// PayPal
					  'pp_total' => $order_total['value'],
					  'pp_shipping' => $shipping_method['value'],
					  'pp_tax' => $pp_order_tax,
					  'pp_disc' => $pp_order_disc,
					  'pp_gs' => $pp_order_gs,
					  'pp_fee' => $pp_order_fee,
// PayPal End
					  'shipping_method' => ((substr($shipping_method['title'], -1) == ':') ? substr(strip_tags($shipping_method['title']), 0, -1) : strip_tags($shipping_method['title'])),
					  'comments' => $order['comments']
					  );

  $this->customer = array('id' => $order['customers_id'],
						  'name' => $order['customers_name'],
						  'firstname' => $order['customers_firstname'],
						  'lastname' => $order['customers_lastname'],                            
						  'csID' => $order['customers_cid'],
						  'customers_vat_id' => $order['customers_vat_id'],
						  'company' => $order['customers_company'],
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

  if (empty($this->delivery['name']) && empty($this->delivery['street_address'])) {
	$this->delivery = false;
  }

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
						'country_iso_2' => $order['billing_country_iso_code_2'],
						'format_id' => $order['billing_address_format_id']);

  $index = 0;
  $orders_products_query = xtc_db_query("SELECT * FROM " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . xtc_db_input($order_id) . "'");
  while ($orders_products = xtc_db_fetch_array($orders_products_query)) {
	$this->products[$index] = array('qty' => $orders_products['products_quantity'],
									'id' => $orders_products['products_id'],
									'name' => $orders_products['products_name'],
									'model' => $orders_products['products_model'],
									'tax' => $orders_products['products_tax'],
									'price'=>$orders_products['products_price'],
									'shipping_time'=>$orders_products['products_shipping_time'],
									'final_price' => $orders_products['final_price']);

	$subindex = 0;
	$attributes_query = xtc_db_query("SELECT * FROM " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . xtc_db_input($order_id) . "' and orders_products_id = '" . $orders_products['orders_products_id'] . "'");
	if (xtc_db_num_rows($attributes_query)) {
	  while ($attributes = xtc_db_fetch_array($attributes_query)) {
		$this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options'],
																 'value' => $attributes['products_options_values'],
																 'prefix' => $attributes['price_prefix'],
																 'price' => $attributes['options_values_price']);

		$subindex++;
	  }
	}

	$this->info['tax_groups']["{$this->products[$index]['tax']}"] = '1';

	$index++;
  }
}

function getOrderData($oID) {
	global $xtPrice;

	require_once(DIR_FS_INC . 'xtc_get_attributes_model.inc.php');

	$order_query = "SELECT
						products_id,
						orders_products_id,
						products_model,
						products_name,
						final_price,
						products_shipping_time,
						products_quantity
						FROM ".TABLE_ORDERS_PRODUCTS."
						WHERE orders_id='".(int) $oID."'";
	$order_data = array ();
	$order_query = xtc_db_query($order_query);
	while ($order_data_values = xtc_db_fetch_array($order_query)) {
		$attributes_query = "SELECT
								products_options,
								products_options_values,
								price_prefix,
								options_values_price
								FROM ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES."
								WHERE orders_products_id='".$order_data_values['orders_products_id']."'";
		$attributes_data = '';
		$attributes_model = '';
		$attributes_query = xtc_db_query($attributes_query);
		while ($attributes_data_values = xtc_db_fetch_array($attributes_query)) {
			$attributes_data .= '<br />'.$attributes_data_values['products_options'].':'.$attributes_data_values['products_options_values'];
			$attributes_model .= '<br />'.xtc_get_attributes_model($order_data_values['products_id'], $attributes_data_values['products_options_values'],$attributes_data_values['products_options']);
		}
		$order_data[] = array ('PRODUCTS_MODEL' => $order_data_values['products_model'], 
								'PRODUCTS_NAME' => $order_data_values['products_name'],
								'PRODUCTS_SHIPPING_TIME' => $order_data_values['products_shipping_time'], 
								'PRODUCTS_ATTRIBUTES' => $attributes_data, 
								'PRODUCTS_ATTRIBUTES_MODEL' => $attributes_model, 
								'PRODUCTS_PRICE' => $xtPrice->xtcFormat($order_data_values['final_price'], true),
								'PRODUCTS_SINGLE_PRICE' => $xtPrice->xtcFormat($order_data_values['final_price']/$order_data_values['products_quantity'], true), 
								'PRODUCTS_QTY' => $order_data_values['products_quantity']);
	}

	return $order_data;
	
}

function getTotalData($oID) {
	global $xtPrice,$db;
	
	// get order_total data
	$oder_total_query = "SELECT
						title,
						text,
						class,
						value,
						sort_order
						FROM ".TABLE_ORDERS_TOTAL."
						WHERE orders_id='".(int) $oID."'
						ORDER BY sort_order ASC";

	$order_total = array ();
	$oder_total_query = xtc_db_query($oder_total_query);
	while ($oder_total_values = xtc_db_fetch_array($oder_total_query)) {
		$order_total[] = array ('TITLE' => $oder_total_values['title'], 'CLASS' => $oder_total_values['class'], 'VALUE' => $oder_total_values['value'], 'TEXT' => $oder_total_values['text']);
		if ($oder_total_values['class'] == 'ot_total')
			$total = $oder_total_values['value'];
	}

	return array('data'=>$order_total,'total'=>$total);

}

function cart() {
  global $currencies,$xtPrice;

  $this->content_type = $_SESSION['cart']->get_content_type();

  $customer_address_query = xtc_db_query("select c.payment_unallowed,c.shipping_unallowed,c.customers_firstname,c.customers_cid, c.customers_gender,c.customers_lastname, c.customers_telephone, c.customers_email_address, ab.entry_company, ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id, z.zone_name, co.countries_id, co.countries_name, co.countries_iso_code_2, co.countries_iso_code_3, co.address_format_id, ab.entry_state from " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) left join " . TABLE_COUNTRIES . " co on (ab.entry_country_id = co.countries_id) where c.customers_id = '" . $_SESSION['customer_id'] . "' and ab.customers_id = '" . $_SESSION['customer_id'] . "' and c.customers_default_address_id = ab.address_book_id");
  $customer_address = xtc_db_fetch_array($customer_address_query);

  $shipping_address_query = xtc_db_query("select ab.entry_firstname, ab.entry_lastname, ab.entry_company, ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id, z.zone_name, ab.entry_country_id, c.countries_id, c.countries_name, c.countries_iso_code_2, c.countries_iso_code_3, c.address_format_id, ab.entry_state from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id) where ab.customers_id = '" . $_SESSION['customer_id'] . "' and ab.address_book_id = '" . $_SESSION['sendto'] . "'");
  $shipping_address = xtc_db_fetch_array($shipping_address_query);
  
  $billing_address_query = xtc_db_query("select ab.entry_firstname, ab.entry_lastname, ab.entry_company, ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id, z.zone_name, ab.entry_country_id, c.countries_id, c.countries_name, c.countries_iso_code_2, c.countries_iso_code_3, c.address_format_id, ab.entry_state from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id) where ab.customers_id = '" . $_SESSION['customer_id'] . "' and ab.address_book_id = '" . $_SESSION['billto'] . "'");
  $billing_address = xtc_db_fetch_array($billing_address_query);
	if (isset($_SESSION['AMZ_COUNTRY_ID']) && isset($_SESSION['AMZ_ZONE_ID'])) {
		$tax_address = array('entry_country_id' => $_SESSION['AMZ_COUNTRY_ID'], 'entry_zone_id' => $_SESSION['AMZ_ZONE_ID']);
	} else {
  $tax_address_query = xtc_db_query("select ab.entry_country_id, ab.entry_zone_id from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) where ab.customers_id = '" . $_SESSION['customer_id'] . "' and ab.address_book_id = '" . ($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . "'");
  $tax_address = xtc_db_fetch_array($tax_address_query);
	}
  $this->info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,
					  'currency' => $_SESSION['currency'],
					  'currency_value' => $xtPrice->currencies[$_SESSION['currency']]['value'],
					  'payment_method' => $_SESSION['payment'],
					  'cc_type' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_type']) ? $_SESSION['ccard']['cc_type'] : ''),
					  'cc_owner'=>(isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_owner']) ? $_SESSION['ccard']['cc_owner'] : ''),
					  'cc_number' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_number']) ? $_SESSION['ccard']['cc_number'] : ''),
					  'cc_expires' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_expires']) ? $_SESSION['ccard']['cc_expires'] : ''),
					  'cc_start' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_start']) ? $_SESSION['ccard']['cc_start'] : ''),
					  'cc_issue' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_issue']) ? $_SESSION['ccard']['cc_issue'] : ''),
					  'cc_cvv' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_cvv']) ? $_SESSION['ccard']['cc_cvv'] : ''),
					  'shipping_method' => $_SESSION['shipping']['title'],
					  'shipping_cost' => $_SESSION['shipping']['cost'],
					  'comments' => $_SESSION['comments'],
					  'shipping_class'=>$_SESSION['shipping']['id'],
					  'payment_class' => $_SESSION['payment'],
					  );

  if (isset($_SESSION['payment']) && is_object($_SESSION['payment'])) {
	$this->info['payment_method'] = $_SESSION['payment']->title;
	$this->info['payment_class'] = $_SESSION['payment']->title;
	if ( isset($_SESSION['payment']->order_status) && is_numeric($_SESSION['payment']->order_status) && ($_SESSION['payment']->order_status > 0) ) {
	  $this->info['order_status'] = $_SESSION['payment']->order_status;
	}
  }

  $this->customer = array('firstname' => $customer_address['customers_firstname'],
						  'lastname' => $customer_address['customers_lastname'],
						  'csID' => $customer_address['customers_cid'],
						  'gender' => $customer_address['customers_gender'],
						  'company' => $customer_address['entry_company'],
						  'street_address' => $customer_address['entry_street_address'],
						  'suburb' => $customer_address['entry_suburb'],
						  'city' => $customer_address['entry_city'],
						  'postcode' => $customer_address['entry_postcode'],
						  'state' => ((xtc_not_null($customer_address['entry_state'])) ? $customer_address['entry_state'] : $customer_address['zone_name']),
						  'zone_id' => $customer_address['entry_zone_id'],
						  'country' => array('id' => $customer_address['countries_id'], 'title' => $customer_address['countries_name'], 'iso_code_2' => $customer_address['countries_iso_code_2'], 'iso_code_3' => $customer_address['countries_iso_code_3']),
						  'format_id' => $customer_address['address_format_id'],
						  'telephone' => $customer_address['customers_telephone'],
						  'payment_unallowed' => $customer_address['payment_unallowed'],
						  'shipping_unallowed' => $customer_address['shipping_unallowed'],
						  'email_address' => $customer_address['customers_email_address']);

  $this->delivery = array('firstname' => $shipping_address['entry_firstname'],
						  'lastname' => $shipping_address['entry_lastname'],
						  'company' => $shipping_address['entry_company'],
						  'street_address' => $shipping_address['entry_street_address'],
						  'suburb' => $shipping_address['entry_suburb'],
						  'city' => $shipping_address['entry_city'],
						  'postcode' => $shipping_address['entry_postcode'],
						  'state' => ((xtc_not_null($shipping_address['entry_state'])) ? $shipping_address['entry_state'] : $shipping_address['zone_name']),
						  'zone_id' => $shipping_address['entry_zone_id'],
						  'country' => array('id' => $shipping_address['countries_id'], 'title' => $shipping_address['countries_name'], 'iso_code_2' => $shipping_address['countries_iso_code_2'], 'iso_code_3' => $shipping_address['countries_iso_code_3']),
						  'country_id' => $shipping_address['entry_country_id'],
						  'format_id' => $shipping_address['address_format_id']);

  $this->billing = array('firstname' => $billing_address['entry_firstname'],
						 'lastname' => $billing_address['entry_lastname'],
						 'company' => $billing_address['entry_company'],
						 'street_address' => $billing_address['entry_street_address'],
						 'suburb' => $billing_address['entry_suburb'],
						 'city' => $billing_address['entry_city'],
						 'postcode' => $billing_address['entry_postcode'],
						 'state' => ((xtc_not_null($billing_address['entry_state'])) ? $billing_address['entry_state'] : $billing_address['zone_name']),
						 'zone_id' => $billing_address['entry_zone_id'],
						 'country' => array('id' => $billing_address['countries_id'], 'title' => $billing_address['countries_name'], 'iso_code_2' => $billing_address['countries_iso_code_2'], 'iso_code_3' => $billing_address['countries_iso_code_3']),
						 'country_id' => $billing_address['entry_country_id'],
						 'format_id' => $billing_address['address_format_id']);

  $index = 0;
  $this->tax_discount = array ();
  $products = $_SESSION['cart']->get_products();
  for ($i=0, $n=sizeof($products); $i<$n; $i++) {
	//Beschreibung holen, vorrangig Kurzbeschreibung, wenn nicht, Auszug aus langbeschreibung
	require_once (DIR_FS_INC.'xtc_get_short_description.inc.php');
	require_once (DIR_FS_INC.'xtc_get_long_description.inc.php');
	
	if (CHECKOUT_SHOW_DESCRIPTION == 'true') {
		$order_descrition = cseo_truncate(strip_tags(xtc_get_short_description($products[$i]['id'])), CHECKOUT_SHOW_DESCRIPTION_LENG);
	} else {
		$order_descrition = cseo_truncate(strip_tags(xtc_get_long_description($products[$i]['id'])), CHECKOUT_SHOW_DESCRIPTION_LENG);
	}
	
	$products_price = $xtPrice->xtcGetPrice($products[$i]['id'],
									$format=false,
									$products[$i]['quantity'],
									$products[$i]['tax_class_id'],
									'');
	$products_price += $xtPrice->xtcFormat($_SESSION['cart']->attributes_price($products[$i]['id'],$products_price),false);

	$this->products[$index] = array('qty' => $products[$i]['quantity'],
									'name' => $products[$i]['name'],
									'products_short_description' => $order_descrition,
									'model' => $products[$i]['model'],
									'vpe' => $products[$i]['vpe'],
									'tax_class_id'=> $products[$i]['tax_class_id'],
									'tax' => xtc_get_tax_rate($products[$i]['tax_class_id'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']),
									'tax_description' => xtc_get_tax_description($products[$i]['tax_class_id'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']),
									'price' => $products_price,
									'price_formated' => $xtPrice->xtcFormat($products_price,true),
									'final_price' => $products_price*$products[$i]['quantity'],
									'final_price_formated' => $xtPrice->xtcFormat($products_price*$products[$i]['quantity'],true),
									'shipping_time'=>$products[$i]['shipping_time'],
									'weight' => $products[$i]['weight'],
									'id' => $products[$i]['id']);

	if ($products[$i]['attributes']) {
	  $subindex = 0;
	  reset($products[$i]['attributes']);
	  while (list($option, $value) = each($products[$i]['attributes'])) {
		$attributes_query = xtc_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $products[$i]['id'] . "' and pa.options_id = '" . $option . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $value . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $_SESSION['languages_id'] . "' and poval.language_id = '" . $_SESSION['languages_id'] . "'");
		$attributes = xtc_db_fetch_array($attributes_query);

		$this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options_name'],
																 'value' => $attributes['products_options_values_name'],
																 'option_id' => $option,
																 'value_id' => $value,
																 'prefix' => $attributes['price_prefix'],
																 'price' => $attributes['options_values_price']);

		$subindex++;
	  }
	}

	$shown_price = $this->products[$index]['final_price'];
	$this->info['subtotal'] += $shown_price;
	if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1){
	  $shown_price_tax = $shown_price-($shown_price/100 * $_SESSION['customers_status']['customers_status_ot_discount']);
	}

	$products_tax = $this->products[$index]['tax'];
	$products_tax_description = $this->products[$index]['tax_description'];
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == '1') {
	  if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
		$this->info['tax'] += $shown_price_tax - ($shown_price_tax / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
		$this->info['tax_groups'][TAX_ADD_TAX."$products_tax_description"] += (($shown_price_tax /(100+$products_tax)) * $products_tax);
	  } else {
		$this->info['tax'] += $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
		$this->info['tax_groups'][TAX_ADD_TAX . "$products_tax_description"] += (($shown_price /(100+$products_tax)) * $products_tax);
	  }
	} else {
	  if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
//            $this->info['tax'] += ($shown_price_tax/100) * ($products_tax);
	$this->tax_discount[$products[$i]['tax_class_id']]+=($shown_price_tax/100) * $products_tax;
		$this->info['tax_groups'][TAX_NO_TAX . "$products_tax_description"] += ($shown_price_tax/100) * ($products_tax);
	  } else {
		$this->info['tax'] += ($shown_price/100) * ($products_tax);
		$this->info['tax_groups'][TAX_NO_TAX . "$products_tax_description"] += ($shown_price/100) * ($products_tax);
	  }
	}
	$index++;
  }
  foreach ($this->tax_discount as $value) {
	$this->info['tax']+=round($value, $xtPrice->get_decimal_places($order->info['currency']));
  }

//$this->info['shipping_cost']=0;
  if ($_SESSION['customers_status']['customers_status_show_price_tax'] == '0') {
	$this->info['total'] = $this->info['subtotal']  + $xtPrice->xtcFormat($this->info['shipping_cost'], false,0,true);
	if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1') {
	  $this->info['total'] -= ($this->info['subtotal'] /100 * $_SESSION['customers_status']['customers_status_ot_discount']);
	}
  } else {
	
	$this->info['total'] = $this->info['subtotal']  + $xtPrice->xtcFormat($this->info['shipping_cost'],false,0,true);
	if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1') {
	  $this->info['total'] -= ($this->info['subtotal'] /100 * $_SESSION['customers_status']['customers_status_ot_discount']);
	}
  }

}

}
?>