<?php
/* -----------------------------------------------------------------
 * 	$Id: customers.php 452 2013-07-03 12:42:36Z akausch $
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

require ('includes/application_top.php');

require_once (DIR_FS_INC . 'xtc_validate_vatid_status.inc.php');
require_once (DIR_FS_INC . 'xtc_get_geo_zone_code.inc.php');
require_once (DIR_FS_INC . 'xtc_encrypt_password.inc.php');
require_once (DIR_FS_INC . 'xtc_js_lang.php');
require(DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

$customers_statuses_array = xtc_get_customers_statuses();

if ($_GET['special'] == 'remove_memo') {
    $mID = xtc_db_prepare_input($_GET['mID']);
    xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_MEMO . " WHERE memo_id = '" . $mID . "'");
    xtc_redirect(xtc_href_link(FILENAME_CUSTOMERS, 'cID=' . (int) $_GET['cID'] . '&action=edit'));
}

if ($_GET['action'] == 'edit' || $_GET['action'] == 'update') {
    if ($_GET['cID'] == 1 && $_SESSION['customer_id'] == 1) {
        
    } else {
        if ($_GET['cID'] != 1) {
            
        } else {
            xtc_redirect(xtc_href_link(FILENAME_CUSTOMERS, ''));
        }
    }
}

if ($_GET['action']) {
    switch ($_GET['action']) {
        case 'new_order' :
            $customers1_query = xtc_db_query("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . (int) $_GET['cID'] . "'");
            $customers1 = xtc_db_fetch_array($customers1_query);
            $customers_query = xtc_db_query("SELECT * FROM " . TABLE_ADDRESS_BOOK . "
												   WHERE customers_id = '" . (int) $_GET['cID'] . "'
													 AND address_book_id =  '" . (int) $customers1['customers_default_address_id'] . "'
										  ");

            $customers = xtc_db_fetch_array($customers_query);
            $country_query = xtc_db_query("SELECT countries_name,
												countries_iso_code_2,
												address_format_id
										  FROM " . TABLE_COUNTRIES . "
										  WHERE countries_id = '" . (int) $customers['entry_country_id'] . "'");
            $country = xtc_db_fetch_array($country_query);
            $stat_query = xtc_db_query("SELECT * FROM " . TABLE_CUSTOMERS_STATUS . " WHERE customers_status_id = '" . (int) $customers1['customers_status'] . "' ");
            $stat = xtc_db_fetch_array($stat_query);

            $sql_data_array = array(
                'customers_id' => xtc_db_prepare_input($customers['customers_id']),
                'customers_cid' => xtc_db_prepare_input($customers1['customers_cid']),
                'customers_vat_id' => xtc_db_prepare_input($customers1['customers_vat_id']),
                'customers_status' => xtc_db_prepare_input($customers1['customers_status']),
                'customers_status_name' => xtc_db_prepare_input($stat['customers_status_name']),
                'customers_status_image' => xtc_db_prepare_input($stat['customers_status_image']),
                'customers_status_discount' => xtc_db_prepare_input($stat['customers_status_discount']),
                'customers_name' => xtc_db_prepare_input($customers['entry_firstname'] . ' ' . $customers['entry_lastname']),
                'customers_lastname' => xtc_db_prepare_input($customers['entry_lastname']),
                'customers_firstname' => xtc_db_prepare_input($customers['entry_firstname']),
                'customers_company' => xtc_db_prepare_input($customers['entry_company']),
                'customers_street_address' => xtc_db_prepare_input($customers['entry_street_address']),
                'customers_suburb' => xtc_db_prepare_input($customers['entry_suburb']),
                'customers_city' => xtc_db_prepare_input($customers['entry_city']),
                'customers_postcode' => xtc_db_prepare_input($customers['entry_postcode']),
                'customers_state' => xtc_db_prepare_input($customers['entry_state']),
                'customers_country' => xtc_db_prepare_input($country['countries_name']),
                'customers_telephone' => xtc_db_prepare_input($customers1['customers_telephone']),
                'customers_email_address' => xtc_db_prepare_input($customers1['customers_email_address']),
                'customers_address_format_id' => xtc_db_prepare_input($country['address_format_id']), 
                'delivery_name' => xtc_db_prepare_input($customers['entry_firstname'] . ' ' . $customers['entry_lastname']),
                'delivery_lastname' => xtc_db_prepare_input($customers['entry_lastname']),
                'delivery_firstname' => xtc_db_prepare_input($customers['entry_firstname']),
                'delivery_company' => xtc_db_prepare_input($customers['entry_company']),
                'delivery_street_address' => xtc_db_prepare_input($customers['entry_street_address']),
                'delivery_suburb' => xtc_db_prepare_input($customers['entry_suburb']),
                'delivery_city' => xtc_db_prepare_input($customers['entry_city']),
                'delivery_postcode' => xtc_db_prepare_input($customers['entry_postcode']),
                'delivery_state' => xtc_db_prepare_input($customers['entry_state']),
                'delivery_country' => xtc_db_prepare_input($country['countries_name']),
                'delivery_country_iso_code_2' => xtc_db_prepare_input($country['countries_iso_code_2']), 
                'delivery_address_format_id' => xtc_db_prepare_input($country['address_format_id']), 
                'billing_name' => xtc_db_prepare_input($customers['entry_firstname'] . ' ' . $customers['entry_lastname']),
                'billing_lastname' => xtc_db_prepare_input($customers['entry_lastname']),
                'billing_firstname' => xtc_db_prepare_input($customers['entry_firstname']),
                'billing_company' => xtc_db_prepare_input($customers['entry_company']),
                'billing_street_address' => xtc_db_prepare_input($customers['entry_street_address']),
                'billing_suburb' => xtc_db_prepare_input($customers['entry_suburb']),
                'billing_city' => xtc_db_prepare_input($customers['entry_city']),
                'billing_postcode' => xtc_db_prepare_input($customers['entry_postcode']),
                'billing_state' => xtc_db_prepare_input($customers['entry_state']),
                'billing_country' => xtc_db_prepare_input($country['countries_name']),
                'billing_country_iso_code_2' => xtc_db_prepare_input($country['countries_iso_code_2']), 
                'billing_address_format_id' => xtc_db_prepare_input($country['address_format_id']), 
                'payment_method' => 'cod',
                'cc_type' => '',
                'cc_owner' => '',
                'cc_number' => '',
                'cc_expires' => '',
                'cc_start' => '',
                'cc_issue' => '',
                'cc_cvv' => '',
                'comments' => '',
                'last_modified' => 'now()',
                'date_purchased' => 'now()',
                'orders_status' => '1',
                'orders_date_finished' => '',
                'currency' => DEFAULT_CURRENCY, 
                'currency_value' => '1.0000',
                'account_type' => '0',
                'payment_class' => 'cod',
                'shipping_method' => MODULE_SHIPPING_FLAT_TEXT_TITLE, 
                'shipping_class' => 'flat_flat',
                'customers_ip' => '',
                'language' => (int)$_SESSION['language'] 
            );

            xtc_db_perform(TABLE_ORDERS, $sql_data_array);
            $orders_id = xtc_db_insert_id();

            require_once (DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/order_total/ot_total.php');
            $sql_data_array = array('orders_id' => (int) $orders_id, 'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE . ':', 'text' => '0', 'value' => '0', 'class' => 'ot_total');

            $insert_sql_data = array('sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER);
            $sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
            xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

            require_once (DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/order_total/ot_subtotal.php');
            $sql_data_array = array('orders_id' => (int) $orders_id, 'title' => '<b>' . MODULE_ORDER_TOTAL_SUBTOTAL_TITLE . '</b>:', 'text' => '0', 'value' => '0', 'class' => 'ot_subtotal');

            $insert_sql_data = array('sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER);
            $sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
            xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
            xtc_redirect(xtc_href_link(FILENAME_ORDERS, 'oID=' . (int) $orders_id . '&action=edit'));
            break;

        case 'statusconfirm' :
            $customers_id = xtc_db_prepare_input($_GET['cID']);
            $customer_updated = false;
            $check_status_query = xtc_db_query("SELECT customers_firstname,
													 customers_lastname,
													 customers_email_address,
													 customers_status,
													 member_flag
												FROM " . TABLE_CUSTOMERS . "
											   WHERE customers_id = '" . xtc_db_input($_GET['cID']) . "'");
            $check_status = xtc_db_fetch_array($check_status_query);
            if ($check_status['customers_status'] != $status) {
                xtc_db_query("UPDATE " . TABLE_CUSTOMERS . " SET customers_status = '" . xtc_db_input($_POST['status']) . "' WHERE customers_id = '" . xtc_db_input($_GET['cID']) . "'");
                // create insert for admin access table if customers status is set to 0
                if ($_POST['status'] == 0) {
                    xtc_db_query("INSERT INTO  " . TABLE_ADMIN_ACCESS . " (customers_id,start) VALUES ('" . xtc_db_input($_GET['cID']) . "','1')");
                } else {
                    xtc_db_query("DELETE FROM " . TABLE_ADMIN_ACCESS . " WHERE customers_id = '" . xtc_db_input($_GET['cID']) . "'");
                }
                //Temporarily set due to above commented lines
                $customer_notified = '0';
                xtc_db_query("INSERT INTO  " . TABLE_CUSTOMERS_STATUS_HISTORY . " (customers_id, new_value, old_value, date_added, customer_notified) VALUES ('" . xtc_db_input($_GET['cID']) . "', '" . xtc_db_input($_POST['status']) . "', '" . $check_status['customers_status'] . "', now(), '" . $customer_notified . "')");
                $customer_updated = true;
            }
            xtc_redirect(xtc_href_link(FILENAME_CUSTOMERS, 'page=' . (int) $_GET['page'] . '&cID=' . (int) $_GET['cID']));
            break;

        case 'statusconfirm' :
            $customers_id = xtc_db_prepare_input($_GET['cID']);
            $customer_updated = false;
            $check_status_query = xtc_db_query("select customers_firstname, customers_lastname, customers_email_address , customers_status, member_flag from " . TABLE_CUSTOMERS . " where customers_id = '" . xtc_db_input($_GET['cID']) . "'");
            $check_status = xtc_db_fetch_array($check_status_query);
            if ($check_status['customers_status'] != $status) {
                xtc_db_query("UPDATE " . TABLE_CUSTOMERS . " SET customers_status = '" . xtc_db_input($_POST['status']) . "' WHERE customers_id = '" . xtc_db_input($_GET['cID']) . "'");

                // create insert for admin access table if customers status is set to 0
                if ($_POST['status'] == 0) {
                    xtc_db_query("INSERT INTO " . TABLE_ADMIN_ACCESS . " (customers_id,start) VALUES ('" . xtc_db_input($_GET['cID']) . "','1')");
                } else {
                    xtc_db_query("DELETE FROM " . TABLE_ADMIN_ACCESS . " WHERE customers_id = '" . xtc_db_input($_GET['cID']) . "'");
                }
                //Temporarily set due to above commented lines
                $customer_notified = '0';
                xtc_db_query("INSERT INTO " . TABLE_CUSTOMERS_STATUS_HISTORY . " (customers_id, new_value, old_value, date_added, customer_notified) VALUES ('" . xtc_db_input($_GET['cID']) . "', '" . xtc_db_input($_POST['status']) . "', '" . $check_status['customers_status'] . "', now(), '" . $customer_notified . "')");
                $customer_updated = true;
            }
            xtc_redirect(xtc_href_link(FILENAME_CUSTOMERS, 'page=' . $_GET['page'] . '&cID=' . $_GET['cID']));
            break;

        case 'update' :
            $customers_id = xtc_db_prepare_input($_GET['cID']);
            $customers_cid = xtc_db_prepare_input($_POST['csID']);
            $customers_vat_id = xtc_db_prepare_input($_POST['customers_vat_id']);
            $customers_vat_id_status = xtc_db_prepare_input($_POST['customers_vat_id_status']);
            $customers_firstname = xtc_db_prepare_input($_POST['customers_firstname']);
            $customers_lastname = xtc_db_prepare_input($_POST['customers_lastname']);
            $customers_email_address = xtc_db_prepare_input($_POST['customers_email_address']);
            $customers_telephone = xtc_db_prepare_input($_POST['customers_telephone']);
            $customers_fax = xtc_db_prepare_input($_POST['customers_fax']);

            $customers_gender = xtc_db_prepare_input($_POST['customers_gender']);
            $customers_dob = xtc_db_prepare_input($_POST['customers_dob']);

            $default_address_id = xtc_db_prepare_input($_POST['default_address_id']);
            $entry_street_address = xtc_db_prepare_input($_POST['entry_street_address']);
            $entry_suburb = xtc_db_prepare_input($_POST['entry_suburb']);
            $entry_postcode = xtc_db_prepare_input($_POST['entry_postcode']);
            $entry_city = xtc_db_prepare_input($_POST['entry_city']);
            $entry_country_id = xtc_db_prepare_input($_POST['entry_country_id']);

            $entry_company = xtc_db_prepare_input($_POST['entry_company']);
            $entry_state = xtc_db_prepare_input($_POST['entry_state']);
            $entry_zone_id = xtc_db_prepare_input($_POST['entry_zone_id']);

            $memo_title = xtc_db_prepare_input($_POST['memo_title']);
            $memo_text = xtc_db_prepare_input($_POST['memo_text']);

            $payment_unallowed = xtc_db_prepare_input($_POST['payment_unallowed']);
            $shipping_unallowed = xtc_db_prepare_input($_POST['shipping_unallowed']);
            $password = xtc_db_prepare_input($_POST['entry_password']);


            if ($memo_text != '' && $memo_title != '') {
                $sql_data_array = array('customers_id' => $_GET['cID'], 'memo_date' => date("Y-m-d"), 'memo_title' => $memo_title, 'memo_text' => $memo_text, 'poster_id' => $_SESSION['customer_id']);
                xtc_db_perform(TABLE_CUSTOMERS_MEMO, $sql_data_array);
            }

            $error = false; // reset error flag

            if (strlen($customers_firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
                $error = true;
                $entry_firstname_error = true;
            } else {
                $entry_firstname_error = false;
            }

            if (strlen($customers_lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
                $error = true;
                $entry_lastname_error = true;
            } else {
                $entry_lastname_error = false;
            }

            if (ACCOUNT_DOB == 'true') {
                if (checkdate(substr(xtc_date_raw($customers_dob), 4, 2), substr(xtc_date_raw($customers_dob), 6, 2), substr(xtc_date_raw($customers_dob), 0, 4))) {
                    $entry_date_of_birth_error = false;
                } else {
                    $error = true;
                    $entry_date_of_birth_error = true;
                }
            }

            if (xtc_get_geo_zone_code($entry_country_id) != '6') {
                require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'class.vat_validation.php');
                $vatID = new vat_validation($customers_vat_id, $customers_id, '', $entry_country_id);
                $customers_vat_id_status = $vatID->vat_info['vat_id_status'];
                $error = $vatID->vat_info['error'];
                if ($error == 1) {
                    $entry_vat_error = true;
                    $error = true;
                }
            }

            if (strlen($customers_email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
                $error = true;
                $entry_email_address_error = true;
            } else {
                $entry_email_address_error = false;
            }

            if (!xtc_validate_email($customers_email_address)) {
                $error = true;
                $entry_email_address_check_error = true;
            } else {
                $entry_email_address_check_error = false;
            }

            if (strlen($entry_street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
                $error = true;
                $entry_street_address_error = true;
            } else {
                $entry_street_address_error = false;
            }

            if (strlen($entry_postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
                $error = true;
                $entry_post_code_error = true;
            } else {
                $entry_post_code_error = false;
            }

            if (strlen($entry_city) < ENTRY_CITY_MIN_LENGTH) {
                $error = true;
                $entry_city_error = true;
            } else {
                $entry_city_error = false;
            }

            if ($entry_country_id == false) {
                $error = true;
                $entry_country_error = true;
            } else {
                $entry_country_error = false;
            }

            if (ACCOUNT_STATE == 'true') {
                if ($entry_country_error == true) {
                    $entry_state_error = true;
                } else {
                    $zone_id = 0;
                    $entry_state_error = false;
                    $check_query = xtc_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . xtc_db_input($entry_country_id) . "'");
                    $check_value = xtc_db_fetch_array($check_query);
                    $entry_state_has_zones = ($check_value['total'] > 0);
                    if ($entry_state_has_zones == true) {
                        $zone_query = xtc_db_query("select zone_id from " . TABLE_ZONES . " where zone_country_id = '" . xtc_db_input($entry_country_id) . "' and zone_name = '" . xtc_db_input($entry_state) . "'");
                        if (xtc_db_num_rows($zone_query) == 1) {
                            $zone_values = xtc_db_fetch_array($zone_query);
                            $entry_zone_id = $zone_values['zone_id'];
                        } else {
                            $zone_query = xtc_db_query("select zone_id from " . TABLE_ZONES . " where zone_country_id = '" . xtc_db_input($entry_country) . "' and zone_code = '" . xtc_db_input($entry_state) . "'");
                            if (xtc_db_num_rows($zone_query) >= 1) {
                                $zone_values = xtc_db_fetch_array($zone_query);
                                $zone_id = $zone_values['zone_id'];
                            } else {
                                $error = true;
                                $entry_state_error = true;
                            }
                        }
                    } else {
                        if ($entry_state == false) {
                            $error = true;
                            $entry_state_error = true;
                        }
                    }
                }
            }

            if (strlen($customers_telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
                $error = true;
                $entry_telephone_error = true;
            } else {
                $entry_telephone_error = false;
            }

            $check_email = xtc_db_query("SELECT customers_email_address FROM " . TABLE_CUSTOMERS . " WHERE customers_email_address = '" . xtc_db_input($customers_email_address) . "' AND customers_id <> '" . xtc_db_input($customers_id) . "'");
            if (xtc_db_num_rows($check_email)) {
                $error = true;
                $entry_email_address_exists = true;
            } else {
                $entry_email_address_exists = false;
            }

            if ($error == false) {
                $sql_data_array = array('customers_firstname' => $customers_firstname,
                    'customers_cid' => $customers_cid,
                    'customers_vat_id' => $customers_vat_id,
                    'customers_vat_id_status' => $customers_vat_id_status,
                    'customers_lastname' => $customers_lastname,
                    'customers_email_address' => $customers_email_address,
                    'customers_telephone' => $customers_telephone,
                    'customers_fax' => $customers_fax,
                    'payment_unallowed' => $payment_unallowed,
                    'shipping_unallowed' => $shipping_unallowed,
                    'customers_last_modified' => 'now()');

                // if new password is set
                if ($password != "") {
                    $sql_data_array = array_merge($sql_data_array, array('customers_password' => xtc_encrypt_password($password)));
                }

                if (ACCOUNT_GENDER == 'true')
                    $sql_data_array['customers_gender'] = $customers_gender;
                if (ACCOUNT_DOB == 'true')
                    $sql_data_array['customers_dob'] = xtc_date_raw($customers_dob);

                xtc_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . xtc_db_input($customers_id) . "'");

                xtc_db_query("UPDATE " . TABLE_CUSTOMERS_INFO . " SET customers_info_date_account_last_modified = now() WHERE customers_info_id = '" . xtc_db_input($customers_id) . "'");

                if ($entry_zone_id > 0)
                    $entry_state = '';

                $sql_data_array = array('entry_firstname' => $customers_firstname,
                    'entry_lastname' => $customers_lastname,
                    'entry_street_address' => $entry_street_address,
                    'entry_postcode' => $entry_postcode,
                    'entry_city' => $entry_city,
                    'entry_country_id' => $entry_country_id,
                    'address_last_modified' => 'now()');


                if (ACCOUNT_COMPANY == 'true')
                    $sql_data_array['entry_company'] = $entry_company;
                if (ACCOUNT_SUBURB == 'true')
                    $sql_data_array['entry_suburb'] = $entry_suburb;

                if (ACCOUNT_STATE == 'true') {
                    if ($entry_zone_id > 0) {
                        $sql_data_array['entry_zone_id'] = $entry_zone_id;
                        $sql_data_array['entry_state'] = '';
                    } else {
                        $sql_data_array['entry_zone_id'] = '0';
                        $sql_data_array['entry_state'] = $entry_state;
                    }
                }

                xtc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', "customers_id = '" . xtc_db_input($customers_id) . "' and address_book_id = '" . xtc_db_input($default_address_id) . "'");
                xtc_redirect(xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID', 'action')) . 'cID=' . $customers_id));
            } elseif ($error == true) {
                $cInfo = new objectInfo($_POST);
                $processed = true;
            }

            break;

        case 'deleteconfirm' :
            $customers_id = xtc_db_prepare_input($_GET['cID']);

            if ($_POST['delete_reviews'] == 'on') {
                $reviews_query = xtc_db_query("select reviews_id from " . TABLE_REVIEWS . " WHERE customers_id = '" . xtc_db_input($customers_id) . "'");
                while ($reviews = xtc_db_fetch_array($reviews_query)) {
                    xtc_db_query("DELETE FROM " . TABLE_REVIEWS_DESCRIPTION . " WHERE reviews_id = '" . $reviews['reviews_id'] . "'");
                }
                xtc_db_query("DELETE FROM " . TABLE_REVIEWS . " WHERE customers_id = '" . xtc_db_input($customers_id) . "'");
            } else {
                xtc_db_query("UPDATE " . TABLE_REVIEWS . " set customers_id = null WHERE customers_id = '" . xtc_db_input($customers_id) . "'");
            }

            xtc_db_query("DELETE FROM " . TABLE_ADDRESS_BOOK . " WHERE customers_id = '" . xtc_db_input($customers_id) . "'");
            xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . xtc_db_input($customers_id) . "'");
            xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_INFO . " WHERE customers_info_id = '" . xtc_db_input($customers_id) . "'");
            xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_BASKET . " WHERE customers_id = '" . xtc_db_input($customers_id) . "'");
            xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " WHERE customers_id = '" . xtc_db_input($customers_id) . "'");
            xtc_db_query("DELETE FROM " . TABLE_PRODUCTS_NOTIFICATIONS . " WHERE customers_id = '" . xtc_db_input($customers_id) . "'");
            xtc_db_query("DELETE FROM " . TABLE_WHOS_ONLINE . " WHERE customer_id = '" . xtc_db_input($customers_id) . "'");
            xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_STATUS_HISTORY . " WHERE customers_id = '" . xtc_db_input($customers_id) . "'");
            xtc_db_query("DELETE FROM " . TABLE_CUSTOMERS_IP . " WHERE customers_id = '" . xtc_db_input($customers_id) . "'");
            xtc_db_query("DELETE FROM " . TABLE_ADMIN_ACCESS . " WHERE customers_id = '" . xtc_db_input($customers_id) . "'");

            xtc_redirect(xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID', 'action'))));
            break;

        default :
            $customers_query = xtc_db_query("SELECT 
												c.*, 
												a.* 
												FROM 
													" . TABLE_CUSTOMERS . " c 
												LEFT JOIN 
													" . TABLE_ADDRESS_BOOK . " a ON(c.customers_default_address_id = a.address_book_id) 
												WHERE 
													a.customers_id = c.customers_id 
												AND 
													c.customers_id = '" . $_GET['cID'] . "'");
            $customers = xtc_db_fetch_array($customers_query);
            $cInfo = new objectInfo($customers);
    }
}

require(DIR_WS_INCLUDES . 'header.php');
?>
<table class="outerTable" cellpadding="0" cellspacing="0">
    <?php
    if ($_GET['action'] == 'edit' || $_GET['action'] == 'update') {
        $customers_query = xtc_db_query("SELECT 
											c.*, 
											a.* 
											FROM " . TABLE_CUSTOMERS . " c 
											LEFT JOIN " . TABLE_ADDRESS_BOOK . " a ON(c.customers_default_address_id = a.address_book_id)
											WHERE 
												a.customers_id = c.customers_id 
											AND 
												c.customers_id = '" . $_GET['cID'] . "';");

        $customers = xtc_db_fetch_array($customers_query);
        $cInfo = new objectInfo($customers);
        ?>
        <tr>
            <td>
                <table class="table_pageHeading" border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="pageHeading"><?php echo $cInfo->customers_lastname . ' ' . $cInfo->customers_firstname; ?></td>
                    </tr>
                </table>
                <table class="table_pageHeading" border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td colspan="3" class="main"><?php echo HEADING_TITLE_STATUS . ': ' . $customers_statuses_array[$customers['customers_status']]['text']; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
    <?php echo xtc_draw_form('customers', FILENAME_CUSTOMERS, xtc_get_all_get_params(array('action')) . 'action=update', 'post', 'onSubmit="return check_form();"') . xtc_draw_hidden_field('default_address_id', $cInfo->customers_default_address_id); ?>
            <td class="formAreaTitle"><?php echo CATEGORY_PERSONAL; ?></td>
        </tr>
        <tr>
            <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
    <?php if (ACCOUNT_GENDER == 'true') { ?>
                        <tr>
                            <td class="main"><?php echo ENTRY_GENDER; ?></td>
                            <td class="main">
        <?php
        if ($error == true) {
            if ($entry_gender_error == true) {
                echo xtc_draw_radio_field('customers_gender', 'm', false, $cInfo->customers_gender) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . xtc_draw_radio_field('customers_gender', 'f', false, $cInfo->customers_gender) . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . ENTRY_GENDER_ERROR;
            } else {
                echo ($cInfo->customers_gender == 'm') ? MALE : FEMALE;
                echo xtc_draw_hidden_field('customers_gender');
            }
        } else {
            echo xtc_draw_radio_field('customers_gender', 'm', false, $cInfo->customers_gender) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . xtc_draw_radio_field('customers_gender', 'f', false, $cInfo->customers_gender) . '&nbsp;&nbsp;' . FEMALE;
        }
        ?></td>
                        </tr>
                                <?php
                            }
                            ?>
                    <tr>
                        <td class="main" bgcolor="#FFCC33"><?php echo ENTRY_CID; ?></td>
                        <td class="main" width="100%" bgcolor="#FFCC33">
    <?php echo xtc_draw_input_field('csID', $cInfo->customers_cid, 'maxlength="32"', false); ?></td>
                    </tr>
                    <tr>
                        <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
                        <td class="main"><?php
    if ($entry_firstname_error == true) {
        echo xtc_draw_input_field('customers_firstname', $cInfo->customers_firstname, 'maxlength="32"') . '&nbsp;' . ENTRY_FIRST_NAME_ERROR;
    } else {
        echo xtc_draw_input_field('customers_firstname', $cInfo->customers_firstname, 'maxlength="32"', true);
    }
    ?></td>
                    </tr>
                    <tr>
                        <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
                        <td class="main"><?php
                        if ($error == true) {
                            if ($entry_lastname_error == true) {
                                echo xtc_draw_input_field('customers_lastname', $cInfo->customers_lastname, 'maxlength="32"') . '&nbsp;' . ENTRY_LAST_NAME_ERROR;
                            } else {
                                echo $cInfo->customers_lastname . xtc_draw_hidden_field('customers_lastname');
                            }
                        } else {
                            echo xtc_draw_input_field('customers_lastname', $cInfo->customers_lastname, 'maxlength="32"', true);
                        }
    ?></td>
                    </tr>
                            <?php
                            if (ACCOUNT_DOB == 'true') {
                                ?>
                        <tr>
                            <td class="main"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
                            <td class="main"><?php
                        if ($error == true) {
                            if ($entry_date_of_birth_error == true) {
                                echo xtc_draw_input_field('customers_dob', xtc_date_short($cInfo->customers_dob), 'maxlength="10"') . '&nbsp;' . ENTRY_DATE_OF_BIRTH_ERROR;
                            } else {
                                echo $cInfo->customers_dob . xtc_draw_hidden_field('customers_dob');
                            }
                        } else {
                            echo xtc_draw_input_field('customers_dob', xtc_date_short($cInfo->customers_dob), 'maxlength="10"', true);
                        }
                        ?></td>
                        </tr>
                                <?php
                            }
                            ?>
                    <tr>
                        <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
                        <td class="main"><?php
                    if ($error == true) {
                        if ($entry_email_address_error == true) {
                            echo xtc_draw_input_field('customers_email_address', $cInfo->customers_email_address, 'maxlength="96"') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_ERROR;
                        } elseif ($entry_email_address_check_error == true) {
                            echo xtc_draw_input_field('customers_email_address', $cInfo->customers_email_address, 'maxlength="96"') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
                        } elseif ($entry_email_address_exists == true) {
                            echo xtc_draw_input_field('customers_email_address', $cInfo->customers_email_address, 'maxlength="96"') . '&nbsp;' . ENTRY_EMAIL_ADDRESS_ERROR_EXISTS;
                        } else {
                            echo $customers_email_address . xtc_draw_hidden_field('customers_email_address');
                        }
                    } else {
                        echo xtc_draw_input_field('customers_email_address', $cInfo->customers_email_address, 'maxlength="96"', true);
                    }
                    ?></td>
                    </tr>
                </table></td>
        </tr>
                            <?php
                            if (ACCOUNT_COMPANY == 'true') {
                                ?>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="formAreaTitle"><?php echo CATEGORY_COMPANY; ?></td>
            </tr>
            <tr>
                <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
                        <tr>
                            <td class="main"><?php echo ENTRY_COMPANY; ?></td>
                            <td class="main"><?php
        if ($error == true) {
            if ($entry_company_error == true) {
                echo xtc_draw_input_field('entry_company', $cInfo->entry_company, 'maxlength="32"') . '&nbsp;' . ENTRY_COMPANY_ERROR;
            } else {
                echo $cInfo->entry_company . xtc_draw_hidden_field('entry_company');
            }
        } else {
            echo xtc_draw_input_field('entry_company', $cInfo->entry_company, 'maxlength="32"');
        }
        ?></td>
                        </tr>

                                <?php if (ACCOUNT_COMPANY_VAT_CHECK == 'true') { ?>
                            <tr>
                                <td class="main"><?php echo ENTRY_VAT_ID; ?></td>
                                <td class="main"><?php
                                    if ($error == true) {
                                        if ($entry_vat_error == true) {
                                            echo xtc_draw_input_field('customers_vat_id', $cInfo->customers_vat_id, 'maxlength="32"') . '&nbsp;' . ENTRY_VAT_ID_ERROR;
                                        } else {
                                            echo $cInfo->customers_vat_id . xtc_draw_hidden_field('customers_vat_id');
                                        }
                                    } else {
                                        echo xtc_draw_input_field('customers_vat_id', $cInfo->customers_vat_id, 'maxlength="32"');
                                    }
                                    ?></td>
                            </tr>
                                <?php } ?>

                    </table></td>
            </tr>
                                <?php
                            }
                            ?>
        <tr>
            <td class="formAreaTitle"><?php echo CATEGORY_ADDRESS; ?></td>
        </tr>
        <tr>
            <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
                    <tr>
                        <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
                        <td class="main"><?php
                if ($error == true) {
                    if ($entry_street_address_error == true) {
                        echo xtc_draw_input_field('entry_street_address', $cInfo->entry_street_address, 'maxlength="64"') . '&nbsp;' . ENTRY_STREET_ADDRESS_ERROR;
                    } else {
                        echo $cInfo->entry_street_address . xtc_draw_hidden_field('entry_street_address');
                    }
                } else {
                    echo xtc_draw_input_field('entry_street_address', $cInfo->entry_street_address, 'maxlength="64"', true);
                }
                ?></td>
                    </tr>
    <?php
    if (ACCOUNT_SUBURB == 'true') {
        ?>
                        <tr>
                            <td class="main"><?php echo ENTRY_SUBURB; ?></td>
                            <td class="main"><?php
                                if ($error == true) {
                                    if ($entry_suburb_error == true) {
                                        echo xtc_draw_input_field('suburb', $cInfo->entry_suburb, 'maxlength="32"') . '&nbsp;' . ENTRY_SUBURB_ERROR;
                                    } else {
                                        echo $cInfo->entry_suburb . xtc_draw_hidden_field('entry_suburb');
                                    }
                                } else {
                                    echo xtc_draw_input_field('entry_suburb', $cInfo->entry_suburb, 'maxlength="32"');
                                }
                                ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
                        <td class="main"><?php
                            if ($error == true) {
                                if ($entry_post_code_error == true) {
                                    echo xtc_draw_input_field('entry_postcode', $cInfo->entry_postcode, 'maxlength="8"') . '&nbsp;' . ENTRY_POST_CODE_ERROR;
                                } else {
                                    echo $cInfo->entry_postcode . xtc_draw_hidden_field('entry_postcode');
                                }
                            } else {
                                echo xtc_draw_input_field('entry_postcode', $cInfo->entry_postcode, 'maxlength="8"', true);
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <td class="main"><?php echo ENTRY_CITY; ?></td>
                        <td class="main"><?php
                    if ($error == true) {
                        if ($entry_city_error == true) {
                            echo xtc_draw_input_field('entry_city', $cInfo->entry_city, 'maxlength="32"') . '&nbsp;' . ENTRY_CITY_ERROR;
                        } else {
                            echo $cInfo->entry_city . xtc_draw_hidden_field('entry_city');
                        }
                    } else {
                        echo xtc_draw_input_field('entry_city', $cInfo->entry_city, 'maxlength="32"', true);
                    }
                    ?></td>
                    </tr>
                            <?php
                            if (ACCOUNT_STATE == 'true') {
                                ?>
                        <tr>
                            <td class="main"><?php echo ENTRY_STATE; ?></td>
                            <td class="main"><?php
                        $entry_state = xtc_get_zone_name($cInfo->entry_country_id, $cInfo->entry_zone_id, $cInfo->entry_state);
                        if ($error == true) {
                            if ($entry_state_error == true) {
                                if ($entry_state_has_zones == true) {
                                    $zones_array = array();
                                    $zones_query = xtc_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . xtc_db_input($cInfo->entry_country_id) . "' order by zone_name");
                                    while ($zones_values = xtc_db_fetch_array($zones_query)) {
                                        $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
                                    }
                                    echo xtc_draw_pull_down_menu('entry_state', $zones_array) . '&nbsp;' . ENTRY_STATE_ERROR;
                                } else {
                                    echo xtc_draw_input_field('entry_state', xtc_get_zone_name($cInfo->entry_country_id, $cInfo->entry_zone_id, $cInfo->entry_state)) . '&nbsp;' . ENTRY_STATE_ERROR;
                                }
                            } else {
                                echo $entry_state . xtc_draw_hidden_field('entry_zone_id') . xtc_draw_hidden_field('entry_state');
                            }
                        } else {
                            echo xtc_draw_input_field('entry_state', xtc_get_zone_name($cInfo->entry_country_id, $cInfo->entry_zone_id, $cInfo->entry_state));
                        }
                        ?></td>
                        </tr>
                                <?php
                            }
                            ?>
                    <tr>
                        <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
                        <td class="main"><?php
                            if ($error == true) {
                                if ($entry_country_error == true) {
                                    echo xtc_draw_pull_down_menu('entry_country_id', xtc_get_countries(), $cInfo->entry_country_id) . '&nbsp;' . ENTRY_COUNTRY_ERROR;
                                } else {
                                    echo xtc_get_country_name($cInfo->entry_country_id) . xtc_draw_hidden_field('entry_country_id');
                                }
                            } else {
                                echo xtc_draw_pull_down_menu('entry_country_id', xtc_get_countries(), $cInfo->entry_country_id);
                            }
                            ?></td>
                    </tr>
                </table></td>
        </tr>
        <tr>
            <td class="formAreaTitle"><?php echo CATEGORY_CONTACT; ?></td>
        </tr>
        <tr>
            <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
                    <tr>
                        <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
                        <td class="main"><?php
                if ($error == true) {
                    if ($entry_telephone_error == true) {
                        echo xtc_draw_input_field('customers_telephone', $cInfo->customers_telephone, 'maxlength="32"') . '&nbsp;' . ENTRY_TELEPHONE_NUMBER_ERROR;
                    } else {
                        echo $cInfo->customers_telephone . xtc_draw_hidden_field('customers_telephone');
                    }
                } else {
                    echo xtc_draw_input_field('customers_telephone', $cInfo->customers_telephone, 'maxlength="32"', true);
                }
                            ?></td>
                    </tr>
                    <tr>
                        <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
                        <td class="main"><?php
                        if ($processed == true) {
                            echo $cInfo->customers_fax . xtc_draw_hidden_field('customers_fax');
                        } else {
                            echo xtc_draw_input_field('customers_fax', $cInfo->customers_fax, 'maxlength="32"');
                        }
                        ?></td>
                    </tr>
                </table></td>
        </tr>
        <tr>
            <td class="formAreaTitle"><?php echo CATEGORY_OPTIONS; ?></td>
        </tr>
        <tr>
            <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">


                    <tr>
                        <td class="main"><?php echo ENTRY_PAYMENT_UNALLOWED; ?></td>
                        <td class="main"><?php
                            if ($processed == true) {
                                echo $cInfo->payment_unallowed . xtc_draw_hidden_field('payment_unallowed');
                            } else {
                                echo xtc_draw_input_field('payment_unallowed', $cInfo->payment_unallowed, 'maxlength="255"');
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <td class="main"><?php echo ENTRY_SHIPPING_UNALLOWED; ?></td>
                        <td class="main"><?php
                            if ($processed == true) {
                                echo $cInfo->shipping_unallowed . xtc_draw_hidden_field('shipping_unallowed');
                            } else {
                                echo xtc_draw_input_field('shipping_unallowed', $cInfo->shipping_unallowed, 'maxlength="255"');
                            }
                            ?></td>
                    </tr>
                    <td class="main" bgcolor="#FFCC33"><?php echo ENTRY_NEW_PASSWORD; ?></td>
                    <td class="main" bgcolor="#FFCC33"><?php
                            if ($error == true) {
                                if ($entry_password_error == true) {
                                    echo xtc_draw_input_field('entry_password', $customers_password) . '&nbsp;' . ENTRY_PASSWORD_ERROR;
                                } else {
                                    echo xtc_draw_input_field('entry_password');
                                }
                            } else {
                                echo xtc_draw_input_field('entry_password');
                            }
                            ?></td>
        </tr>
        <tr>
                            <?php include(DIR_WS_MODULES . FILENAME_CUSTOMER_MEMO); ?>
        </tr>
    </table></td>
    </tr>
    <tr>
        <td align="right" class="main"><input type="submit" class="button" onClick="this.blur();" value="<?php echo BUTTON_UPDATE; ?>"><?php echo ' <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('action'))) . '">' . BUTTON_CANCEL . '</a>'; ?></td>
    </tr></form>
                            <?php
                        } else {
                            ?>
    <tr>
        <td>
            <table class="table_pageHeading" border="0" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
                    <td align="right">
                        <?php echo xtc_draw_form('search', FILENAME_CUSTOMERS, '', 'get'); ?>
                        <?php echo HEADING_TITLE_SEARCH . ' ' . xtc_draw_input_field('search') . xtc_draw_hidden_field(xtc_session_name(), xtc_session_id()); ?>&nbsp;
                        <?php echo '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_CREATE_ACCOUNT) . '">' . BUTTON_CREATE_ACCOUNT . '</a>'; ?>
                        </form>
                    </td>
                </tr>
            </table>
                        <?php
                        $select_data = array();
                        $select_data = array(array('id' => '99', 'text' => TEXT_SELECT), array('id' => '100', 'text' => TEXT_ALL_CUSTOMERS));
                        ?>
        </td>
    </tr>
    <tr>
        <td>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top"><table width="100%" class="dataTable" cellspacing="0" cellpadding="0">
                            <tr class="dataTableHeadingRow">
                                <th class="dataTableHeadingContent" width="40"><?php echo TABLE_HEADING_ACCOUNT_TYPE; ?></th>
                                <th class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMERS_CID . xtc_sorting(FILENAME_CUSTOMERS, 'customers_cid'); ?></th>
                                <th class="dataTableHeadingContent"><?php echo TABLE_HEADING_LASTNAME . xtc_sorting(FILENAME_CUSTOMERS, 'customers_lastname'); ?></th>
                                <th class="dataTableHeadingContent"><?php echo TABLE_HEADING_FIRSTNAME . xtc_sorting(FILENAME_CUSTOMERS, 'customers_firstname'); ?></th>
                                <th class="dataTableHeadingContent"><?php echo TABLE_HEADING_EMAIL . xtc_sorting(FILENAME_CUSTOMERS, 'customers_email_address'); ?></th>
                                <th class="dataTableHeadingContent"><?php echo TEXT_INFO_COUNTRY . xtc_sorting(FILENAME_CUSTOMERS, 'customers_country'); ?></th>
                                <th class="dataTableHeadingContent"><?php echo TABLE_HEADING_UMSATZ; ?></th>
                                <th class="dataTableHeadingContent" align="left"><?php echo HEADING_TITLE_STATUS; ?></th>
    <?php if (ACCOUNT_COMPANY_VAT_CHECK == 'true') { ?>
                                    <th class="dataTableHeadingContent" align="left"><?php echo HEADING_TITLE_VAT; ?></th>
                        <?php } ?>
                                <th class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACCOUNT_CREATED . xtc_sorting(FILENAME_CUSTOMERS, 'date_account_created'); ?></th>
                                <th class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</th>
                            </tr>
    <?php
    $search_word = '';
    if (($_GET['search']) && (xtc_not_null($_GET['search']))) {
        $keywords = xtc_db_input(xtc_db_prepare_input($_GET['search']));
        $search_word = "AND (c.customers_lastname like '%" . $keywords . "%' or c.customers_firstname like '%" . $keywords . "%' or c.customers_email_address like '%" . $keywords . "%' or c.customers_cid like '%" . $keywords . "%')";
    }
    if (isset($_GET['search_email']) && (xtc_not_null($_GET['search_email']))) {
        $keywords = xtc_db_input(xtc_db_prepare_input($_GET['search_email']));
        $search_word = "AND (c.customers_email_address like '%" . $keywords . "%')";
    }
    if ($_GET['status'] && $_GET['status'] != '100' or $_GET['status'] == '0') {
        $status = xtc_db_prepare_input($_GET['status']);
        $search_word = "AND c.customers_status = '" . $status . "'";
    }

    if (isset($_GET['sorting']) && xtc_not_null($_GET['sorting'])) {
        switch ($_GET['sorting']) {
            case 'customers_cid' :
                $sort = 'ORDER BY c.customers_cid';
                break;

            case 'customers_cid-desc' :
                $sort = 'ORDER BY c.customers_cid DESC';
                break;

            case 'customers_firstname' :
                $sort = 'ORDER BY c.customers_firstname';
                break;

            case 'customers_firstname-desc' :
                $sort = 'ORDER BY c.customers_firstname DESC';
                break;

            case 'customers_lastname' :
                $sort = 'ORDER BY c.customers_lastname';
                break;

            case 'customers_lastname-desc' :
                $sort = 'ORDER BY c.customers_lastname DESC';
                break;

            case 'date_account_created' :
                $sort = 'ORDER BY ci.customers_info_date_account_created';
                break;

            case 'date_account_created-desc' :
                $sort = 'ORDER BY ci.customers_info_date_account_created DESC';
                break;

            case 'customers_country' :
                $sort = 'ORDER BY a.entry_country_id';
                break;

            case 'customers_country-desc' :
                $sort = 'ORDER BY a.entry_country_id DESC';
                break;

            case 'customers_email_address-desc' :
                $sort = 'ORDER BY c.customers_email_address DESC';
                break;

            case 'customers_email_address' :
                $sort = 'ORDER BY c.customers_email_address';
                break;

            default :
                $sort = 'ORDER BY c.customers_date_added DESC';
        }
    } else {
        $sort = 'ORDER BY ci.customers_info_date_account_created DESC';
    }
    // buchstaben sorting
    $customers_query_raw = "SELECT
                                 c.customers_id,
                                 c.customers_cid,
                                 c.customers_vat_id,
                                 c.customers_vat_id_status,
                                 c.customers_status,
                                 c.customers_firstname,
                                 c.customers_lastname,
                                 c.customers_email_address,
                                 c.member_flag,
                                 c.account_type,
                                 a.entry_country_id,
                                 ci.customers_info_date_account_created
                            FROM
                                 " . TABLE_CUSTOMERS . " c ,
                                 " . TABLE_ADDRESS_BOOK . " a,
                                 " . TABLE_CUSTOMERS_INFO . " ci
                           WHERE c.customers_id = a.customers_id
                             AND c.customers_default_address_id = a.address_book_id
                             AND ci.customers_info_id = c.customers_id
							" . $search_word . "
							" . $sort;

    $customers_split = new splitPageResults($_GET['page'], '20', $customers_query_raw, $customers_query_numrows);
    $customers_query = xtc_db_query($customers_query_raw);
    $rows = 1;
    while ($customers = xtc_db_fetch_array($customers_query)) {
        $info_query = xtc_db_query("SELECT customers_info_date_account_created AS date_account_created, customers_info_date_account_last_modified AS date_account_last_modified, customers_info_date_of_last_logon AS date_last_logon, customers_info_number_of_logons AS number_of_logons FROM " . TABLE_CUSTOMERS_INFO . " WHERE customers_info_id = '" . $customers['customers_id'] . "'");
        $info = xtc_db_fetch_array($info_query);
        $umsatz_query = xtc_db_query("SELECT SUM(op.final_price) as ordersum
														FROM " . TABLE_ORDERS_PRODUCTS . " op
														JOIN " . TABLE_ORDERS . " o ON o.orders_id = op.orders_id
													   WHERE '" . (int) $customers['customers_id'] . "' = o.customers_id");
        $umsatz = xtc_db_fetch_array($umsatz_query);
        if (((!$_GET['cID']) || (@ $_GET['cID'] == $customers['customers_id'])) && (!$cInfo)) {
            $country_query = xtc_db_query("SELECT countries_name FROM " . TABLE_COUNTRIES . " WHERE countries_id = '" . $customers['entry_country_id'] . "'");
            $country = xtc_db_fetch_array($country_query);

            $reviews_query = xtc_db_query("SELECT count(*) AS number_of_reviews FROM " . TABLE_REVIEWS . " WHERE customers_id = '" . $customers['customers_id'] . "'");
            $reviews = xtc_db_fetch_array($reviews_query);

            $customer_info = xtc_array_merge($country, $info, $reviews);

            $cInfo_array = xtc_array_merge($customers, $customer_info);
            $cInfo = new objectInfo($cInfo_array);
        }
        if ((is_object($cInfo)) && ($customers['customers_id'] == $cInfo->customers_id)) {
            echo '<tr class="dataTableRowSelected" onclick="document.location.href=\'' . xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=edit') . '\'">' . "\n";
        } else {
            echo '<tr class="' . (($i % 2 == 0) ? 'dataTableRow' : 'dataWhite') . '" onclick="document.location.href=\'' . xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID')) . 'cID=' . $customers['customers_id']) . '\'">' . "\n";
        }

        if ($customers['account_type'] == 1) {

            echo '<td class="dataTableContent">';
            echo TEXT_GUEST;
        } else {
            echo '<td class="dataTableContent">';
            echo TEXT_ACCOUNT;
        }
        echo '</td>';
        ?>
                                <td class="dataTableContent" align="center"><?php echo ($customers['customers_cid'] != '') ? $customers['customers_cid'] : '-'; ?></td>
                                <td class="dataTableContent"><b><?php echo $customers['customers_lastname']; ?></b></td>
                                <td class="dataTableContent"><?php echo $customers['customers_firstname']; ?></td>
                                <td class="dataTableContent"><?php echo $customers['customers_email_address']; ?></td>
                                <td class="dataTableContent"><?php echo xtc_get_country_name($customers['entry_country_id']); ?></td>
                                <?php
                                if ($umsatz['ordersum'] != '') {
                                    ?>
                                    <td class="dataTableContent"><?php if ($umsatz['ordersum'] > 0) {
                            echo $currencies->format($umsatz['ordersum']);
                        } ?></td>
                                    <?php
                                } else {
                                    ?>
                                    <td class="dataTableContent"> --- </td>
                                    <?php
                                }
                                ?>
                                <td class="dataTableContent" align="left"><?php echo $customers_statuses_array[$customers['customers_status']]['text'] . ' (' . $customers['customers_status'] . ')'; ?></td>
                                <?php if (ACCOUNT_COMPANY_VAT_CHECK == 'true') { ?>
                                    <td class="dataTableContent" align="left">&nbsp;
                                    <?php
                                    if ($customers['customers_vat_id']) {
                                        echo $customers['customers_vat_id'] . '<br /><span style="font-size:8pt"><nobr>(' . xtc_validate_vatid_status($customers['customers_id']) . ')</nobr></span>';
                                    }
                                    ?>
                                    </td>
                                <?php } ?>
                                <td class="dataTableContent" align="right"><?php echo (xtc_date_short($info['date_account_created']) != '') ? xtc_date_short($info['date_account_created']) : '-'; ?></td>
                                <td class="dataTableContent" align="right">
                                <?php
                                if ((is_object($cInfo)) && ($customers['customers_id'] == $cInfo->customers_id)) {
                                    echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', '');
                                } else {
                                    echo '<a href="' . xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID')) . 'cID=' . $customers['customers_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>';
                                }
                                ?>&nbsp;</td>
                    </tr>
                                <?php $rows++;
                            } ?>
            </table>
        </td>
                            <?php
                            $heading = array();
                            $contents = array();
                            switch ($_GET['action']) {
                                case 'confirm' :
                                    $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CUSTOMER . '</b>');

                                    $contents = array('form' => xtc_draw_form('customers', FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=deleteconfirm'));
                                    $contents[] = array('text' => TEXT_DELETE_INTRO . '<br /><br /><b>' . $cInfo->customers_firstname . ' ' . $cInfo->customers_lastname . '</b>');
                                    if ($cInfo->number_of_reviews > 0)
                                        $contents[] = array('text' => '<br />' . xtc_draw_checkbox_field('delete_reviews', 'on', true) . ' ' . sprintf(TEXT_DELETE_REVIEWS, $cInfo->number_of_reviews));
                                    $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="button" value="' . BUTTON_DELETE . '"><a class="button" href="' . xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id) . '">' . BUTTON_CANCEL . '</a>');
                                    break;

                                case 'editstatus' :
                                    if ($_GET['cID'] != 1) {
                                        $customers_history_query = xtc_db_query("select new_value, old_value, date_added, customer_notified from " . TABLE_CUSTOMERS_STATUS_HISTORY . " where customers_id = '" . xtc_db_input($_GET['cID']) . "' order by customers_status_history_id desc");
                                        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_STATUS_CUSTOMER . '</b>');
                                        $contents = array('form' => xtc_draw_form('customers', FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=statusconfirm'));
                                        $contents[] = array('text' => '<br />' . xtc_draw_pull_down_menu('status', $customers_statuses_array, $cInfo->customers_status));
                                        $contents[] = array('text' => '<table nowrap border="0" cellspacing="0" cellpadding="0"><tr><td style="border-bottom: 1px solid; border-color: #000000;" nowrap class="smallText" align="center"><b>' . TABLE_HEADING_NEW_VALUE . ' </b></td><td style="border-bottom: 1px solid; border-color: #000000;" nowrap class="smallText" align="center"><b>' . TABLE_HEADING_DATE_ADDED . '</b></td></tr>');

                                        if (xtc_db_num_rows($customers_history_query)) {
                                            while ($customers_history = xtc_db_fetch_array($customers_history_query)) {

                                                $contents[] = array('text' => '<tr>' . "\n" . '<td class="smallText">' . $customers_statuses_array[$customers_history['new_value']]['text'] . '</td>' . "\n" . '<td class="smallText" align="center">' . xtc_datetime_short($customers_history['date_added']) . '</td>' . "\n" . '<td class="smallText" align="center">');

                                                $contents[] = array('text' => '</tr>' . "\n");
                                            }
                                        } else {
                                            $contents[] = array('text' => '<tr>' . "\n" . ' <td class="smallText" colspan="2">' . TEXT_NO_CUSTOMER_HISTORY . '</td>' . "\n" . ' </tr>' . "\n");
                                        }
                                        $contents[] = array('text' => '</table>');
                                        $contents[] = array('align' => 'center', 'text' => '<input type="submit" class="button" value="' . BUTTON_UPDATE . '"><a class="button" href="' . xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id) . '">' . BUTTON_CANCEL . '</a>');
                                        $status = xtc_db_prepare_input($_POST['status']); // maybe this line not needed to recheck...
                                    }
                                    break;

                                default :
                                    $customer_status = xtc_get_customer_status($_GET['cID']);
                                    $cs_id = $customer_status['customers_status'];
                                    $cs_member_flag = $customer_status['member_flag'];
                                    $cs_name = $customer_status['customers_status_name'];
                                    $cs_image = $customer_status['customers_status_image'];
                                    $cs_discount = $customer_status['customers_status_discount'];
                                    $cs_ot_discount_flag = $customer_status['customers_status_ot_discount_flag'];
                                    $cs_ot_discount = $customer_status['customers_status_ot_discount'];
                                    $cs_staffelpreise = $customer_status['customers_status_staffelpreise'];
                                    $cs_payment_unallowed = $customer_status['customers_status_payment_unallowed'];


                                    if (is_object($cInfo)) {
                                        $heading[] = array('text' => '<b>' . $cInfo->customers_firstname . ' ' . $cInfo->customers_lastname . '</b>');
                                        if ($cInfo->customers_id != 1) {
                                            $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=edit') . '">' . BUTTON_EDIT . '</a>');
                                        }
                                        if ($cInfo->customers_id == 1 && $_SESSION['customer_id'] == 1) {
                                            $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=edit') . '">' . BUTTON_EDIT . '</a>');
                                        }
                                        if ($cInfo->customers_id != 1) {
                                            $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=confirm') . '">' . BUTTON_DELETE . '</a>');
                                            $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=editstatus') . '">' . BUTTON_STATUS . '</a>');
                                            $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_ACCOUNTING, xtc_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id) . '">' . BUTTON_ACCOUNTING . '</a>');
                                        }

                                        $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_ORDERS, 'cID=' . $cInfo->customers_id) . '">' . BUTTON_ORDERS . '</a> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_MAIL, 'selected_box=tools&customer=' . $cInfo->customers_email_address) . '">' . BUTTON_EMAIL . '</a>');
                                        if (TRUSTED_SHOP_IP_LOG == 'true') {
                                            $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=iplog') . '">' . BUTTON_IPLOG . '</a>');
                                        }
                                        $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=new_order') . '" onClick="return confirm(\'' . NEW_ORDER . '\')">' . BUTTON_NEW_ORDER . '</a>');

                                        $contents[] = array('text' => '<br />' . TEXT_DATE_ACCOUNT_CREATED . ' ' . xtc_date_short($cInfo->date_account_created));
                                        $contents[] = array('text' => '<br />' . TEXT_DATE_ACCOUNT_LAST_MODIFIED . ' ' . xtc_date_short($cInfo->date_account_last_modified));
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_DATE_LAST_LOGON . ' ' . xtc_date_short($cInfo->date_last_logon));
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_NUMBER_OF_LOGONS . ' ' . $cInfo->number_of_logons);
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_COUNTRY . ' ' . $cInfo->countries_name);
                                        $contents[] = array('text' => '<br />' . TEXT_INFO_NUMBER_OF_REVIEWS . ' ' . $cInfo->number_of_reviews);
                                    }

                                    if ($_GET['action'] == 'iplog') {
                                        if (isset($_GET['cID'])) {
                                            $contents[] = array('text' => '<br /><b>IPLOG :');
                                            $customers_id = xtc_db_prepare_input($_GET['cID']);
                                            $customers_log_info_array = xtc_get_user_info($customers_id);
                                            if (xtc_db_num_rows($customers_log_info_array)) {
                                                while ($customers_log_info = xtc_db_fetch_array($customers_log_info_array)) {
                                                    $contents[] = array('text' => '<tr>' . "\n" . '<td class="smallText">' . $customers_log_info['customers_ip_date'] . ' ' . $customers_log_info['customers_ip'] . ' ' . $customers_log_info['customers_advertiser']);
                                                }
                                            }
                                        }
                                        break;
                                    }
                            }

                            if ((xtc_not_null($heading)) && (xtc_not_null($contents))) {
                                echo '            <td width="25%" class="border" valign="top">' . "\n";
                                echo xtc_draw_form('status', FILENAME_CUSTOMERS, '', 'get');
                                echo HEADING_TITLE_STATUS . ' ' . xtc_draw_pull_down_menu('status', xtc_array_merge($select_data, $customers_statuses_array), '99', 'onChange="this.form.submit();"') . xtc_draw_hidden_field(xtc_session_name(), xtc_session_id()) . '</form>';
                                echo '<br/ >';
                                $box = new box;
                                echo $box->infoBox($heading, $contents);

                                echo '            </td>' . "\n";
                            }

                            $customer_page_dropdown = '<form name="anzahl" action="' . $_SERVER['REQUEST_URI'] . '" method="GET">' . "\n";

                            if ($_GET['oID'] != '')
                                $customer_page_dropdown .= xtc_draw_hidden_field('oID', $_GET['oID']);
                            if ($_GET['page'] != '')
                                $customer_page_dropdown .= xtc_draw_hidden_field('page', $_GET['page']) . "\n";

                            $customers_options = array();

                            $customers_options[] = array('id' => '10', 'text' => '10');
                            $customers_options[] = array('id' => '20', 'text' => '20');
                            $customers_options[] = array('id' => '50', 'text' => '50');
                            $customers_options[] = array('id' => '100', 'text' => '100');

                            $customer_page_dropdown .= xtc_draw_pull_down_menu('anzahl', $customers_options, ($_GET['anzahl'] != '' ? $_GET['anzahl'] : '20'), 'onchange="this.form.submit()"') . "\n";

                            $customer_page_dropdown .= '</form>' . "\n";
                            ?>
    </tr>
    <tr>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr>
            <td class="smallText" valign="top" width="33.33%"><?php echo $customers_split->display_count($customers_query_numrows, ($_GET['anzahl'] != '') ? $_GET['anzahl'] : '20', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CUSTOMERS); ?></td>
            <td class="smallText" align="right" width="33.33%"><?php echo $customers_split->display_links($customers_query_numrows, ($_GET['anzahl'] != '') ? $_GET['anzahl'] : '20', MAX_DISPLAY_PAGE_LINKS, $_GET['page'], xtc_get_all_get_params(array('page', 'info', 'x', 'y', 'cID'))); ?></td>
            <td align="right" width="33.33%">
        <?php
        echo 'Kunden pro Seite: ' . $customer_page_dropdown;
        ?>
            </td>
        </tr>
        <?php
        if (xtc_not_null($_GET['search'])) {
            ?>
            <tr>
                <td align="right" colspan="2"><?php echo '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_CUSTOMERS) . '">' . BUTTON_RESET . '</a>'; ?></td>
            </tr>
        <?php } ?>
    </table>
    </tr>
    </table></td>
    </tr>
    <?php } ?>
</table>
    <?php
    require(DIR_WS_INCLUDES . 'footer.php');
    require(DIR_WS_INCLUDES . 'application_bottom.php');

    