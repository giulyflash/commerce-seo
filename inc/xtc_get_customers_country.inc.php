<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_get_customers_country.inc.php
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



   
  function xtc_get_customers_country($customers_id) {
    $customers_query = xtc_db_query("select customers_default_address_id from " . TABLE_CUSTOMERS . " where customers_id = '" . $customers_id . "'");
    $customers = xtc_db_fetch_array($customers_query);

    $address_book_query = xtc_db_query("select entry_country_id from " . TABLE_ADDRESS_BOOK . " where address_book_id = '" . $customers['customers_default_address_id'] . "'");
    $address_book = xtc_db_fetch_array($address_book_query);
    return $address_book['entry_country_id'];
    }
 ?>