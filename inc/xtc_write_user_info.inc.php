<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_write_user_info.inc.php
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




  function xtc_write_user_info($customer_id) {

      $sql_data_array = array('customers_id' => $customer_id,
                              'customers_ip' => $_SESSION['tracking']['ip'],
                              'customers_ip_date' => 'now()',
                              'customers_host' => $_SESSION['tracking']['http_referer']['host'],
                              'customers_advertiser' => $_SESSION['tracking']['refID'],
                              'customers_referer_url' => $_SESSION['tracking']['http_referer']['host'].$_SESSION['tracking']['http_referer']['path'],
                              );

      xtc_db_perform(TABLE_CUSTOMERS_IP, $sql_data_array);
    return -1;
  }
?>