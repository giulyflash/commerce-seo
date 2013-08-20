<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_oe_customer_infos.inc.php
* 	Letzter Stand:			v2.3
* 	zuletzt geaendert von:	cseoak
* 	Datum:					2012/11/19
*
* 	Copyright (c) since 2010 commerce:SEO by Webdesign Erfurt
* 	http://www.commerce-seo.de
* ------------------------------------------------------------------
* 	based on:
* 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
* 	(c) 2002-2003 osCommerce - www.oscommerce.com
* 	(c) 2003     nextcommerce - www.nextcommerce.org
* 	(c) 2005     xt:Commerce - www.xt-commerce.com
* 	Released under the GNU General Public License
* ---------------------------------------------------------------*/




  function  xtc_oe_customer_infos($customers_id) {

    $customer_query = xtc_db_query("select a.entry_country_id, a.entry_zone_id from " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " a where c.customers_id  = '" . $customers_id . "' and c.customers_id = a.customers_id and c.customers_default_address_id = a.address_book_id");
    $customer = xtc_db_fetch_array($customer_query);


	$customer_info_array = array('country_id' => $customer['entry_country_id'],
                                 'zone_id' => $customer['entry_zone_id']);

return $customer_info_array;
  }
 ?>