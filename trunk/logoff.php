<?php

/* -----------------------------------------------------------------
 * 	$Id: logoff.php 420 2013-06-19 18:04:39Z akausch $
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

include ('includes/application_top.php');
// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');

$breadcrumb->add(NAVBAR_TITLE_LOGOFF);

//delete Guests from Database   

if (($_SESSION['account_type'] == 1) && (DELETE_GUEST_ACCOUNT == 'true')) {
    xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . $_SESSION['customer_id'] . "'");
    xtc_db_query("DELETE FROM " . TABLE_ADDRESS_BOOK . " WHERE customers_id = '" . $_SESSION['customer_id'] . "'");
    xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_INFO . " WHERE customers_info_id = '" . $_SESSION['customer_id'] . "'");
}

xtc_session_destroy();

unset($_SESSION['customer_id']);
unset($_SESSION['customer_default_address_id']);
unset($_SESSION['customer_first_name']);
unset($_SESSION['customer_country_id']);
unset($_SESSION['customer_zone_id']);
unset($_SESSION['comments']);
unset($_SESSION['user_info']);
unset($_SESSION['customers_status']);
unset($_SESSION['selected_box']);
unset($_SESSION['navigation']);
unset($_SESSION['shipping']);
unset($_SESSION['payment']);
unset($_SESSION['ccard']);
unset($_SESSION['gv_id']);
unset($_SESSION['cc_id']);

$_SESSION['cart']->reset();
// write customers status guest in session again
require (DIR_WS_INCLUDES . 'write_customers_status.php');

require (DIR_WS_INCLUDES . 'header.php');

$smarty->assign('BUTTON_CONTINUE', '<a href="' . xtc_href_link(FILENAME_DEFAULT) . '">' . xtc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>');
$smarty->assign('language', $_SESSION['language']);

$smarty->caching = false;

$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/logoff.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = false;

$smarty->display(CURRENT_TEMPLATE . '/index.html');
xtc_redirect(xtc_href_link(FILENAME_DEFAULT, '', 'NONSSL'));
include ('includes/application_bottom.php');
