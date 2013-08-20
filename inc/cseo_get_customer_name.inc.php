<?php
/*-----------------------------------------------------------------
* 	ID:						cseo_get_customer_name.inc.php
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

// Return a customer name
function cseo_get_customer_name() {
	if (isset($_SESSION['customer_last_name']) && isset($_SESSION['customer_id'])) {
		$greeting_string = sprintf($_SESSION['customer_first_name'] . '&nbsp;' . $_SESSION['customer_last_name']);
	}
	return $greeting_string;
}