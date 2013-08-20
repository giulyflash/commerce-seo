<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_checkout_site.inc.php
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




function xtc_checkout_site($site) {
    if (!$_SESSION['customer_id'] || ($site != 'cart' && $site != 'shipping' && $site != 'payment' && $site != 'confirm')) {
        return false;
    }
    $checkQuery = xtc_db_query("SELECT checkout_site FROM " . TABLE_CUSTOMERS_BASKET . " WHERE customers_id=" . $_SESSION['customer_id']);
    $checkResult = xtc_db_fetch_array($checkQuery);
    compareSite($site, $checkResult['checkout_site']);
}

function compareSite($currentSite, $oldSite) {
    $cart = 1;
    $shipping = 2;
    $payment = 3;
    $confirm = 4;
    if ($$currentSite > $$oldSite) {
        xtc_db_query("UPDATE " . TABLE_CUSTOMERS_BASKET . " SET checkout_site='" . xtc_db_input($currentSite) . "', language='" . xtc_db_input($_SESSION['language']) . "' WHERE customers_id=" . (int)$_SESSION['customer_id']);
    }
}
?>