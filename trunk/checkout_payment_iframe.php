<?php
/*-----------------------------------------------------------------
* 	$Id: checkout_payment_iframe.php 420 2013-06-19 18:04:39Z akausch $
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

include ('includes/application_top.php');

// include needed functions
require_once (DIR_FS_INC.'xtc_calculate_tax.inc.php');
require_once (DIR_FS_INC.'xtc_address_label.inc.php');

$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');


// if the customer is not logged on, redirect them to the login page
if (!isset ($_SESSION['customer_id'])) {
	xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
}

if ($_SESSION['customers_status']['customers_status_show_price'] != '1') {
	xtc_redirect(xtc_href_link(FILENAME_DEFAULT, '', ''));
}


if ((xtc_not_null(MODULE_PAYMENT_INSTALLED)) && (!isset ($_SESSION['payment']))) {
	xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
}

// avoid hack attempts during the checkout procedure by checking the internal cartID
if (isset ($_SESSION['cart']->cartID) && isset ($_SESSION['cartID'])) {
	if ($_SESSION['cart']->cartID != $_SESSION['cartID']) {
		xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
	}
}
require (DIR_WS_INCLUDES . 'header.php');
// load selected payment module
require (DIR_WS_CLASSES.'class.payment.php');

$payment_modules = new payment($_SESSION['payment']);

// load the selected shipping module
require (DIR_WS_CLASSES.'class.shipping.php');
$shipping_modules = new shipping($_SESSION['shipping']);

require (DIR_WS_CLASSES . 'class.order_total.php');
require (DIR_WS_CLASSES.'class.order.php');
$order = new order();


$order_total_modules = new order_total();
$order_total_modules->process();

$iframe_url = $payment_modules->iframeAction();

if ($iframe_url =='') {
	xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
}

$smarty->assign('iframe_url', $iframe_url);

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = false;

$main_content = '<iframe src="'.$iframe_url.'" width="100%" height="750" name="_top" frameborder="0"></iframe>';


$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = false;

$smarty->display(CURRENT_TEMPLATE . '/index.html');
include ('includes/application_bottom.php');
