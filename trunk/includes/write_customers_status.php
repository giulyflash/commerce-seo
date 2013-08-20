<?php
/*-----------------------------------------------------------------
* 	$Id: write_customers_status.php 420 2013-06-19 18:04:39Z akausch $
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

// write customers status in session
if (isset($_SESSION['customer_id'])) {
	$customers_status_query_1 = xtc_db_query("SELECT customers_status FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . (int)$_SESSION['customer_id'] . "'");
	$customers_status_value_1 = xtc_db_fetch_array($customers_status_query_1);

	$customers_status_query = xtc_db_query("SELECT
												*
											FROM
												" . TABLE_CUSTOMERS_STATUS . "
											WHERE
												customers_status_id = '" . (int)$customers_status_value_1['customers_status'] . "' AND language_id = '" . (int)$_SESSION['languages_id'] . "'");

	$customers_status_value = xtc_db_fetch_array($customers_status_query);

	$_SESSION['customers_status'] = array();
	$_SESSION['customers_status']= array(
	  'customers_status_id' => $customers_status_value_1['customers_status'],
	  'customers_status_name' => $customers_status_value['customers_status_name'],
	  'customers_status_image' => $customers_status_value['customers_status_image'],
	  'customers_status_public' => $customers_status_value['customers_status_public'],
	  'customers_status_min_order' => $customers_status_value['customers_status_min_order'],
	  'customers_status_max_order' => $customers_status_value['customers_status_max_order'],
	  'customers_status_discount' => $customers_status_value['customers_status_discount'],
	  'customers_status_ot_discount_flag' => $customers_status_value['customers_status_ot_discount_flag'],
	  'customers_status_ot_discount' => $customers_status_value['customers_status_ot_discount'],
	  'customers_status_graduated_prices' => $customers_status_value['customers_status_graduated_prices'],
	  'customers_status_show_price' => $customers_status_value['customers_status_show_price'],
	  'customers_status_show_price_tax' => $customers_status_value['customers_status_show_price_tax'],
	  'customers_status_add_tax_ot' => $customers_status_value['customers_status_add_tax_ot'],
	  'customers_status_payment_unallowed' => $customers_status_value['customers_status_payment_unallowed'],
	  'customers_status_shipping_unallowed' => $customers_status_value['customers_status_shipping_unallowed'],
	  'customers_status_discount_attributes' => $customers_status_value['customers_status_discount_attributes'],
	  'customers_fsk18' => $customers_status_value['customers_fsk18'],
	  'customers_fsk18_display' => $customers_status_value['customers_fsk18_display'],
	  'customers_status_write_reviews' => $customers_status_value['customers_status_write_reviews'],
	  'customers_status_read_reviews' => $customers_status_value['customers_status_read_reviews']);
} else {
	$customers_status_query = xtc_db_query("SELECT
												*
											FROM
												" . TABLE_CUSTOMERS_STATUS . "
											WHERE
												customers_status_id = '" . DEFAULT_CUSTOMERS_STATUS_ID_GUEST . "' AND language_id = '" . (int)$_SESSION['languages_id'] . "'");
	$customers_status_value = xtc_db_fetch_array($customers_status_query);

	$_SESSION['customers_status'] = array();
	$_SESSION['customers_status']= array(
	  'customers_status_id' => DEFAULT_CUSTOMERS_STATUS_ID_GUEST,
	  'customers_status_name' => $customers_status_value['customers_status_name'],
	  'customers_status_image' => $customers_status_value['customers_status_image'],
	  'customers_status_discount' => $customers_status_value['customers_status_discount'],
	  'customers_status_public' => $customers_status_value['customers_status_public'],
	  'customers_status_min_order' => $customers_status_value['customers_status_min_order'],
	  'customers_status_max_order' => $customers_status_value['customers_status_max_order'],
	  'customers_status_ot_discount_flag' => $customers_status_value['customers_status_ot_discount_flag'],
	  'customers_status_ot_discount' => $customers_status_value['customers_status_ot_discount'],
	  'customers_status_graduated_prices' => $customers_status_value['customers_status_graduated_prices'],
	  'customers_status_show_price' => $customers_status_value['customers_status_show_price'],
	  'customers_status_show_price_tax' => $customers_status_value['customers_status_show_price_tax'],
	  'customers_status_add_tax_ot' => $customers_status_value['customers_status_add_tax_ot'],
	  'customers_status_payment_unallowed' => $customers_status_value['customers_status_payment_unallowed'],
	  'customers_status_shipping_unallowed' => $customers_status_value['customers_status_shipping_unallowed'],
	  'customers_status_discount_attributes' => $customers_status_value['customers_status_discount_attributes'],
	  'customers_fsk18' => $customers_status_value['customers_fsk18'],
	  'customers_fsk18_display' => $customers_status_value['customers_fsk18_display'],
	  'customers_status_write_reviews' => $customers_status_value['customers_status_write_reviews'],
	  'customers_status_read_reviews' => $customers_status_value['customers_status_read_reviews']);
}
