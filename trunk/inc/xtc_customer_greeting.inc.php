<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_customer_greeting.inc.php
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

// Return a customer greeting
function xtc_customer_greeting() {

	if (isset($_SESSION['customer_last_name']) && isset($_SESSION['customer_id'])) {
		if (!isset($_SESSION['customer_gender'])) {
			$check_customer_query = xtc_db_fetch_array(xtDBquery("SELECT customers_gender FROM  " . TABLE_CUSTOMERS . " WHERE customers_id = '" . $_SESSION['customer_id'] . "'"));
			$_SESSION['customer_gender'] = $check_customer_query['customers_gender'];
		}
		if($_SESSION['customer_gender']=='f'){
			$greeting_string = sprintf(TEXT_GREETING_PERSONAL, FEMALE . '&nbsp;'. $_SESSION['customer_first_name'] . '&nbsp;'. $_SESSION['customer_last_name'], xtc_href_link(FILENAME_PRODUCTS_NEW));
		}else{
			$greeting_string = sprintf(TEXT_GREETING_PERSONAL, MALE . '&nbsp;'. $_SESSION['customer_first_name'] . '&nbsp;' . $_SESSION['customer_last_name'], xtc_href_link(FILENAME_PRODUCTS_NEW));
		}

	} else {
		$greeting_string = sprintf(TEXT_GREETING_GUEST, xtc_href_link(FILENAME_LOGIN, '', 'SSL'), xtc_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));
	}

	return $greeting_string;
}