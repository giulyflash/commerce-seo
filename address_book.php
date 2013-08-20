<?php

/* -----------------------------------------------------------------
 * 	$Id: address_book.php 420 2013-06-19 18:04:39Z akausch $
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
$smarty = new Smarty;
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');

require_once (DIR_FS_INC . 'xtc_address_label.inc.php');
require_once (DIR_FS_INC . 'xtc_get_country_name.inc.php');
require_once (DIR_FS_INC . 'xtc_count_customer_address_book_entries.inc.php');

if (!isset($_SESSION['customer_id'])) {
    xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
}

$breadcrumb->add(NAVBAR_TITLE_1_ADDRESS_BOOK, xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ADDRESS_BOOK, xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));

require_once (DIR_WS_INCLUDES . 'header.php');

if ($messageStack->size('addressbook') > 0) {
    $smarty->assign('error', $messageStack->output('addressbook'));
}

$smarty->assign('ADDRESS_DEFAULT', xtc_address_label($_SESSION['customer_id'], $_SESSION['customer_default_address_id'], true, ' ', '<br />'));

$addresses_data = array();
$addresses_query = xtc_db_query("SELECT 
									address_book_id, 
									entry_firstname AS firstname, 
									entry_lastname AS lastname, 
									entry_company AS company, 
									entry_street_address AS street_address, 
									entry_suburb AS suburb, 
									entry_city AS city, 
									entry_postcode AS postcode, 
									entry_state AS state, 
									entry_zone_id AS zone_id, 
									entry_country_id AS country_id 
								FROM 
									" . TABLE_ADDRESS_BOOK . " 
								WHERE 
									customers_id = '" . (int) $_SESSION['customer_id'] . "' 
								ORDER BY 
									firstname, lastname");

while ($addresses = xtc_db_fetch_array($addresses_query)) {
    $format_id = xtc_get_address_format_id($addresses['country_id']);
    if ($addresses['address_book_id'] == $_SESSION['customer_default_address_id']) {
        $primary = 1;
    } else {
        $primary = 0;
    }
    $addresses_data[] = array('NAME' => $addresses['firstname'] . ' ' . $addresses['lastname'],
        'BUTTON_EDIT' => '<a href="' . xtc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $addresses['address_book_id'], 'SSL') . '">' . xtc_image_button('small_edit.gif', SMALL_IMAGE_BUTTON_EDIT) . '</a>',
        'BUTTON_DELETE' => '<a href="' . xtc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $addresses['address_book_id'], 'SSL') . '">' . xtc_image_button('small_delete.gif', SMALL_IMAGE_BUTTON_DELETE) . '</a>',
        'ADDRESS' => xtc_address_format($format_id, $addresses, true, ' ', '<br />'),
        'PRIMARY' => $primary);
}

$smarty->assign('addresses_data', $addresses_data);
$smarty->assign('BUTTON_BACK', '<a href="' . xtc_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>');

if (xtc_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES) {
    $smarty->assign('BUTTON_NEW', '<a href="' . xtc_href_link(FILENAME_ADDRESS_BOOK_PROCESS, '', 'SSL') . '">' . xtc_image_button('button_add_address.gif', IMAGE_BUTTON_ADD_ADDRESS) . '</a>');
}
$smarty->assign('ADDRESS_COUNT', sprintf(TEXT_MAXIMUM_ENTRIES, MAX_ADDRESS_BOOK_ENTRIES));

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = false;

$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/address_book.html');

$smarty->assign('main_content', $main_content);

$smarty->display(CURRENT_TEMPLATE . '/index.html');
include ('includes/application_bottom.php');
