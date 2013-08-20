<?php
/*-----------------------------------------------------------------
* 	ID:						install_step6.php
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

require('../includes/configure.php');
require('includes/application.php');
require_once(DIR_FS_INC . 'xtc_rand.inc.php');
require_once(DIR_FS_INC . 'xtc_encrypt_password.inc.php');
require_once(DIR_FS_INC . 'xtc_db_connect.inc.php');
require_once(DIR_FS_INC . 'xtc_db_query.inc.php');
require_once(DIR_FS_INC . 'xtc_db_fetch_array.inc.php');
require_once(DIR_FS_INC . 'xtc_validate_email.inc.php');

require_once(DIR_FS_INC . 'xtc_db_input.inc.php');
require_once(DIR_FS_INC . 'xtc_db_num_rows.inc.php');
require_once(DIR_FS_INC . 'xtc_redirect.inc.php');
require_once(DIR_FS_INC . 'xtc_href_link.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_pull_down_menu.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_input_field.inc.php');
require_once(DIR_FS_INC . 'xtc_get_country_list.inc.php');
include('language/'.$_SESSION['language'].'.php');

// connect do database
xtc_db_connect() or die('Unable to connect to database server!');

// get configuration data
$configuration_query = xtc_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
while ($configuration = xtc_db_fetch_array($configuration_query))
	define($configuration['cfgKey'], $configuration['cfgValue']);


$messageStack = new messageStack();

$process = false;
if(isset($_POST['action']) && ($_POST['action'] == 'process')) {
	$process = true;

    $firstname = xtc_db_prepare_input($_POST['FIRST_NAME']);
    $lastname = xtc_db_prepare_input($_POST['LAST_NAME']);
    $birthday = xtc_db_prepare_input($_POST['BIRTHDAY']);
	$email_address = xtc_db_prepare_input($_POST['EMAIL_ADRESS']);
	$street_address = xtc_db_prepare_input($_POST['STREET_ADRESS']) .' '. xtc_db_prepare_input($_POST['STREET_ADRESS_NUM']);
	$postcode = xtc_db_prepare_input($_POST['POST_CODE']);
    $city = xtc_db_prepare_input($_POST['CITY']);
    $zone_id = xtc_db_prepare_input($_POST['zone_id']);
    $state = xtc_db_prepare_input($_POST['STATE']);
	$country = xtc_db_prepare_input($_POST['COUNTRY']);
    $telephone = xtc_db_prepare_input($_POST['TELEPHONE']);
    $password = xtc_db_prepare_input($_POST['PASSWORD']);
    $confirmation = xtc_db_prepare_input($_POST['PASSWORD_CONFIRMATION']);
    $store_name = xtc_db_prepare_input($_POST['STORE_NAME']);
	$email_from = xtc_db_prepare_input($_POST['EMAIL_ADRESS_FROM']);
	$zone_setup = xtc_db_prepare_input($_POST['ZONE_SETUP']);
	$company = xtc_db_prepare_input($_POST['COMPANY']);
	$ustid = xtc_db_prepare_input($_POST['USTID']);

    $error = false;

    if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
      $error = true;
      $messageStack->add('install_step6', ENTRY_FIRST_NAME_ERROR);
    }

    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;
      $messageStack->add('install_step6', ENTRY_LAST_NAME_ERROR);
    }

    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;
      $messageStack->add('install_step6', ENTRY_EMAIL_ADDRESS_ERROR);
    } elseif (xtc_validate_email($email_address) == false) {
      $error = true;
      $messageStack->add('install_step6', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    }

	if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
      $error = true;
      $messageStack->add('install_step6', ENTRY_STREET_ADDRESS_ERROR);
    }

    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
      $error = true;
      $messageStack->add('install_step6', ENTRY_POST_CODE_ERROR);
    }

    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
      $error = true;
      $messageStack->add('install_step6', ENTRY_CITY_ERROR);
    }

    if (is_numeric($country) == false) {
      $error = true;
      $messageStack->add('install_step6', ENTRY_COUNTRY_ERROR);
    }

	if (ACCOUNT_STATE == 'true') {
		$zone_id = 0;
		$check_query = xtc_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "'");
		$check = xtc_db_fetch_array($check_query);
		$entry_state_has_zones = ($check['total'] > 0);
		if ($entry_state_has_zones == true) {
			$zone_query = xtc_db_query("select zone_id, zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and zone_id = '" . (int)$state . "' ");
			if (xtc_db_num_rows($zone_query) > 0) {
				$zone = xtc_db_fetch_array($zone_query);
				$zone_id = $zone['zone_id'];
				#$country = $zone['zone_name'];
			} else {
				$error = true;
				$messageStack->add('install_step6', ENTRY_STATE_ERROR_SELECT);
			}
		} else {
			if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
				$error = true;
				$messageStack->add('install_step6', ENTRY_STATE_ERROR);
			}
		}
	}

    if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
      $error = true;
      $messageStack->add('install_step6', ENTRY_TELEPHONE_NUMBER_ERROR);
    }


    if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;
      $messageStack->add('install_step6', ENTRY_PASSWORD_ERROR);
    } elseif ($password != $confirmation) {
      $error = true;
      $messageStack->add('install_step6', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
    }

	if (strlen($store_name) < '3') {
      $error = true;
      $messageStack->add('install_step6', ENTRY_STORE_NAME_ERROR);
    }

	if (strlen($company) < '2') {
      $error = true;
      $messageStack->add('install_step6', ENTRY_COMPANY_NAME_ERROR);
    }

    if (strlen($email_from) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;
      $messageStack->add('install_step6', ENTRY_EMAIL_ADDRESS_FROM_ERROR);
    } elseif (xtc_validate_email($email_from) == false) {
      $error = true;
      $messageStack->add('install_step6', ENTRY_EMAIL_ADDRESS_FROM_CHECK_ERROR);
    }

	if ( ($zone_setup != 'yes') && ($zone_setup != 'no') ) {
        $error = true;
        $messageStack->add('install_step6', SELECT_ZONE_SETUP_ERROR);
	}


	if ($error == false) {

	xtc_db_query("insert into ".TABLE_CUSTOMERS." (customers_id,customers_cid,customers_status,customers_firstname,customers_lastname,customers_gender,customers_dob,customers_email_address,customers_default_address_id,customers_telephone,customers_password,delete_user,customers_date_added)
	VALUES
		('1','0001','0','".$firstname."','".$lastname."','m','".xtc_date_raw($birthday)."','".$email_address."','1','".$telephone."','".xtc_encrypt_password($password)."','0',now())");

	xtc_db_query("insert into ".TABLE_CUSTOMERS_INFO." (customers_info_id,customers_info_date_of_last_logon,customers_info_number_of_logons,customers_info_date_account_created,customers_info_date_account_last_modified,global_product_notifications)
	VALUES
		('1','','',now(),'','')");
	xtc_db_query("insert into " .TABLE_ADDRESS_BOOK . " (
											customers_id,
											entry_company,
	   										entry_firstname,
	   										entry_lastname,
	   										entry_street_address,
	   										entry_postcode,
	   										entry_city,
	   										entry_state,
	   										entry_country_id,
	   										entry_zone_id) VALUES
											('1',
											'".($company)."',
											'".($firstname)."',
											'".($lastname)."',
											'".($street_address)."',
											'".($postcode)."',
											'".($city)."',
											'".($state)."',
											'".($country)."',
											'".($zone_id)."'
											)");

	xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_address). "' WHERE configuration_key = 'STORE_OWNER_EMAIL_ADDRESS'");
	xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($store_name). "' WHERE configuration_key = 'STORE_NAME'");
	xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'EMAIL_FROM'");
	xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($country). "' WHERE configuration_key = 'SHIPPING_ORIGIN_COUNTRY'");
	xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($state). "' WHERE configuration_key = 'STORE_ZONE'");
	xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($postcode). "' WHERE configuration_key = 'SHIPPING_ORIGIN_ZIP'");
	xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($company). "' WHERE configuration_key = 'STORE_OWNER'");
	xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($ustid). "' WHERE configuration_key = 'STORE_OWNER_VAT_ID'");
	xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'EMAIL_BILLING_FORWARDING_STRING'");
	xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'EMAIL_BILLING_ADDRESS'");
	xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'CONTACT_US_EMAIL_ADDRESS'");
	xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'EMAIL_SUPPORT_ADDRESS'");
	xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($company.'\n'.$firstname.' '.$lastname.'\n'.$street_address.'\n'.$postcode.' '.$city). "' WHERE configuration_key = 'STORE_NAME_ADDRESS'");
	xtc_db_query("UPDATE " .TABLE_COUNTRIES . " SET status='0' WHERE countries_id != '". ($country) ." '");



if ($zone_setup == 'yes') {
	// Steuersätze des jeweiligen Landes
	$tax_normal='';
	$tax_normal_text='';
	$tax_special='';
	$tax_special_text='';
	switch ($country) {

	case '14':
	// Austria
		$tax_normal='20.0000';
		$tax_normal_text='UST 20%';
		$tax_special='10.0000';
		$tax_special_text='UST 10%';
		 break;
	case '21':
	// Belgien
		$tax_normal='21.0000';
		$tax_normal_text='UST 21%';
		$tax_special='6.0000';
		$tax_special_text='UST 6%';
		 break;
	case '57':
	// Dänemark
		$tax_normal='25.0000';
		$tax_normal_text='UST 25%';
		$tax_special='25.0000';
		$tax_special_text='UST 25%';
		 break;
	case '72':
	// Finnland
		$tax_normal='22.0000';
		$tax_normal_text='UST 22%';
		$tax_special='8.0000';
		$tax_special_text='UST 8%';
		 break;
	case '73':
	// Frankreich
		$tax_normal='19.6000';
		$tax_normal_text='UST 19.6%';
		$tax_special='2.1000';
		$tax_special_text='UST 2.1%';
		 break;
	case '81':
	// Deutschland
		$tax_normal='19.0000';
		$tax_normal_text='MwSt. 19%';
		$tax_special='7.0000';
		$tax_special_text='MwSt. 7%';
		 break;
	case '84':
	// Griechenland
		$tax_normal='18.0000';
		$tax_normal_text='UST 18%';
		$tax_special='4.0000';
		$tax_special_text='UST 4%';
		 break;
	case '103':
	// Irland
		$tax_normal='21.0000';
		$tax_normal_text='UST 21%';
		$tax_special='4.2000';
		$tax_special_text='UST 4.2%';
		 break;
	case '105':
	// Italien
		$tax_normal='20.0000';
		$tax_normal_text='UST 20%';
		$tax_special='4.0000';
		$tax_special_text='UST 4%';
		 break;
	case '124':
	// Luxemburg
		$tax_normal='15.0000';
		$tax_normal_text='UST 15%';
		$tax_special='3.0000';
		$tax_special_text='UST 3%';
		 break;
	case '150':
	// Niederlande
		$tax_normal='19.0000';
		$tax_normal_text='UST 19%';
		$tax_special='6.0000';
		$tax_special_text='UST 6%';
		 break;
	case '171':
	// Portugal
		$tax_normal='17.0000';
		$tax_normal_text='UST 17%';
		$tax_special='5.0000';
		$tax_special_text='UST 5%';
		 break;
	case '195':
	// Spain
		$tax_normal='16.0000';
		$tax_normal_text='UST 16%';
		$tax_special='4.0000';
		$tax_special_text='UST 4%';
		 break;
	case '203':
	// Schweden
		$tax_normal='25.0000';
		$tax_normal_text='UST 25%';
		$tax_special='6.0000';
		$tax_special_text='UST 6%';
		 break;
	case '222':
	// UK
		$tax_normal='17.5000';
		$tax_normal_text='UST 17.5%';
		$tax_special='5.0000';
		$tax_special_text='UST 5%';
		 break;
	default :
	// Deutschland
		$tax_normal='19.0000';
		$tax_normal_text='MwSt. 19%';
		$tax_special='7.0000';
		$tax_special_text='MwSt. 7%';
		 break;
}


			// Steuersätze / tax_rates

			xtc_db_query("INSERT INTO tax_rates (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) VALUES (1, 5, 1, 1, '".$tax_normal."', '".$tax_normal_text."', '', '')");
			xtc_db_query("INSERT INTO tax_rates (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) VALUES (2, 5, 2, 1, '".$tax_special."', '".$tax_special_text."', '', '')");
			xtc_db_query("INSERT INTO tax_rates (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) VALUES (3, 6, 1, 1, '0.0000', 'EU-AUS-UST 0%', '', '')");
			xtc_db_query("INSERT INTO tax_rates (tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) VALUES (4, 6, 2, 1, '0.0000', 'EU-AUS-UST 0%', '', '')");


			// Steuerklassen

			xtc_db_query("INSERT INTO tax_class (tax_class_id, tax_class_title, tax_class_description, last_modified, date_added) VALUES (1, 'Standardsatz', '', '', now())");
			xtc_db_query("INSERT INTO tax_class (tax_class_id, tax_class_title, tax_class_description, last_modified, date_added) VALUES (2, 'ermäßigter Steuersatz', '', NULL, now())");

			// Steuersätze

			xtc_db_query("INSERT INTO geo_zones (geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added) VALUES (6, 'Steuerzone EU-Ausland', '', '', now())");
			xtc_db_query("INSERT INTO geo_zones (geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added) VALUES (5, 'Steuerzone EU', 'Steuerzone für die EU', '', now())");
			xtc_db_query("INSERT INTO geo_zones (geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added) VALUES (7, 'Steuerzone B2B', '', NULL, now())");

			// EU-Steuerzonen


			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (14, 14, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (21, 21, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (55, 55, 0, 5, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (56, 56, 0, 5, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (57, 57, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (67, 67, 0, 5, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (72, 72, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (73, 73, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (81, 81, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (84, 84, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (97, 97, 0, 5, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (103, 103, 0, 5, NULL,now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (105, 105, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (117, 117, 0, 5, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (123, 123, 0, 5, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (124, 124, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (132, 132, 0, 5, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (150, 150, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (170, 170, 0, 5, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (171, 171, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (189, 189, 0, 5, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (190, 190, 0, 5, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (195, 195, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (203, 203, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (222, 222, 0, 5, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (1, 1, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (2, 2, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (3, 3, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (4, 4, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (5, 5, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (6, 6, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (7, 7, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (8, 8, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (9, 9, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (10, 10, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (11, 11, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (12, 12, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (13, 13, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (15, 15, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (16, 16, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (17, 17, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (18, 18, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (19, 19, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (20, 20, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (22, 22, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (23, 23, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (24, 24, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (25, 25, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (26, 26, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (27, 27, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (28, 28, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (29, 29, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (30, 30, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (31, 31, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (32, 32, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (33, 33, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (34, 34, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (35, 35, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (36, 36, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (37, 37, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (38, 38, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (39, 39, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (40, 40, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (41, 41, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (42, 42, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (43, 43, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (44, 44, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (45, 45, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (46, 46, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (47, 47, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (48, 48, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (49, 49, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (50, 50, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (51, 51, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (52, 52, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (53, 53, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (54, 54, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (58, 58, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (59, 59, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (60, 60, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (61, 61, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (62, 62, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (63, 63, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (64, 64, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (65, 65, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (66, 66, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (68, 68, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (69, 69, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (70, 70, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (71, 71, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (74, 74, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (75, 75, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (76, 76, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (77, 77, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (78, 78, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (79, 79, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (80, 80, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (82, 82, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (83, 83, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (85, 85, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (86, 86, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (87, 87, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (88, 88, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (89, 89, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (90, 90, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (91, 91, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (92, 92, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (93, 93, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (94, 94, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (95, 95, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (96, 96, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (98, 98, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (99, 99, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (100, 100, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (101, 101, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (102, 102, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (104, 104, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (106, 106, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (107, 107, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (108, 108, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (109, 109, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (110, 110, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (111, 111, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (112, 112, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (113, 113, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (114, 114, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (115, 115, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (116, 116, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (118, 118, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (119, 119, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (120, 120, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (121, 121, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (122, 122, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (125, 125, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (126, 126, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (127, 127, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (128, 128, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (129, 129, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (130, 130, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (131, 131, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (133, 133, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (134, 134, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (135, 135, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (136, 136, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (137, 137, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (138, 138, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (139, 139, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (140, 140, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (141, 141, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (142, 142, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (143, 143, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (144, 144, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (145, 145, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (146, 146, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (147, 147, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (148, 148, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (149, 149, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (151, 151, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (152, 152, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (153, 153, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (154, 154, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (155, 155, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (156, 156, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (157, 157, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (158, 158, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (159, 159, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (160, 160, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (161, 161, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (162, 162, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (163, 163, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (164, 164, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (165, 165, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (166, 166, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (167, 167, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (168, 168, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (169, 169, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (172, 172, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (173, 173, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (174, 174, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (175, 175, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (176, 176, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (177, 177, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (178, 178, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (179, 179, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (180, 180, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (181, 181, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (182, 182, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (183, 183, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (184, 184, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (185, 185, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (186, 186, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (187, 187, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (188, 188, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (191, 191, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (192, 192, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (193, 193, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (194, 194, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (196, 196, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (197, 197, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (198, 198, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (199, 199, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (200, 200, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (201, 201, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (202, 202, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (204, 204, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (205, 205, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (206, 206, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (207, 207, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (208, 208, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (209, 209, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (210, 210, 0, 6, NULL,  now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (211, 211, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (212, 212, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (213, 213, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (214, 214, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (215, 215, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (216, 216, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (217, 217, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (218, 218, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (219, 219, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (220, 220, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (221, 221, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (223, 223, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (224, 224, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (225, 225, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (226, 226, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (227, 227, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (228, 228, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (229, 229, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (230, 230, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (231, 231, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (232, 232, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (233, 233, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (234, 234, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (235, 235, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (236, 236, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (237, 237, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (238, 238, 0, 6, NULL, now())");
			xtc_db_query("INSERT INTO zones_to_geo_zones (association_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (239, 239, 0, 6, NULL, now())");
			}
			xtc_db_query("UPDATE emails SET email_address = '".$email_from."', email_replay_address = '".$email_from."' ");
			xtc_db_query("UPDATE emails SET email_address_name = '".$store_name."', email_replay_address_name = '".$store_name."' ");
			xtc_db_query("UPDATE configuration SET configuration_value = '".$email_from."' WHERE configuration_key = 'META_REPLY_TO' ");
			xtc_redirect(xtc_href_link('installer/install_step7.php', '', 'NONSSL'));
		}
	}
include('includes/metatag.php');
?>
<title>commerce:SEO Installation - Schritt 6</title>
<script type="text/javascript">
function passwordStrength(password){
	var desc = new Array();
	desc[0] = "sehr schwach";
	desc[1] = "schwach";
	desc[2] = "besser";
	desc[3] = "geht so";
	desc[4] = "gut";
	desc[5] = "sehr gut";

	var score   = 1;
	if (password.length > 6) score++;
	if ((password.match(/[a-z]/)) && (password.match(/[A-Z]/))) score++;
	if (password.match(/\d+/)) score++;
	if (password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;
	if (password.length > 12) score++;
	document.getElementById("passwordDescription").innerHTML = desc[score];
	document.getElementById("passwordStrength").className = "strength" + score;
}
</script>
</head>
<body>
<script src="includes/jquery-1.4.2.min.js" type="text/javascript" encode="UTF-8"></script>
<script type="text/javascript">
	<!--
		$(function(){
			$("select#country").change(function(){
				var value = $("select#country").val();
				$.ajax({
				  type: "GET",
				  url: "includes/getCountry.php",
				  data: "land=" + value,
				  cache: false,
				  success: function(html){
				    $("#provice").html(html);
				  },
				  beforeSend: function(){
				  	$("#state").html("<p style=\'width:215px\' align=\'center\'><img src=\'images/wait.gif\' alt=\'\' /></p>");
				  }
				});
			});
		});
	//-->
</script>
<script type="text/javascript" src="includes/javascript/tooltip.js" encode="UTF-8"></script>
<?php include('includes/header.php'); ?>
<div id="wrapper">
	<div id="inner_wrapper">
		<table class="outerTable" width="100%">
			<tr>
				<td class="columnLeft" width="200" valign="top">
					<div class="menu_titel">Install</div>
					<table class="menu_items ok" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_LANGUAGE; ?>
							</td>
						</tr>
					</table><br />
					<table class="menu_items ok" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_DB_CONNECTION; ?>
							</td>
						</tr>
					</table>
					<table class="menu_items ok" width="100%" style="padding-left:20px">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_DB_IMPORT; ?>
							</td>
						</tr>
					</table><br />
					<table class="menu_items ok" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_WEBSERVER_SETTINGS; ?>
							</td>
						</tr>
					</table>
					<table class="menu_items ok" width="100%" style="padding-left:20px">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_WRITE_CONFIG; ?>
							</td>
						</tr>
					</table><br />
					<table class="menu_items" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/icon_arrow_right.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_ADMIN_CONFIG; ?>
							</td>
						</tr>
					</table>
					<?php if ($messageStack->size('install_step6') > 0) { ?>
						<table class="menu_items" width="100%">
							<tr>
								<td valign="middle"><?php echo $messageStack->output('install_step6'); ?></td>
							</tr>
						</table>
					<?php } ?>
				</td>
				<td class="columnRight" valign="top">
					<table class="table_pageHeading" border="0" width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td class="pageHeading">
								<h1 class="schatten">Schritt 6</h1>
							</td>
						</tr>
					</table>
					<?php echo TEXT_WELCOME_STEP6; ?>

					<h2 class="schatten">
						<?php echo TITLE_ADMIN_CONFIG; ?>
						<?php echo ' <span'.mouseOverJS('Notiz',TITLE_ADMIN_CONFIG_NOTE).'>
							<img src="images/icons/icon_help.gif" alt="" />
						</span>'; ?>
					</h2>
					<p align="right"><span style="color:#990000"><b><?php echo TEXT_REQU_INFORMATION; ?></b></span></p>
					<form name="install" action="install_step6.php" method="post" autocomplete="on" onsubmit="return check_form(install_step6);">
              			<input name="action" type="hidden" value="process">
              			<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
              				<tr>
              					<td valign="middle" width="150">
              					    <b><?php echo TEXT_FIRSTNAME; ?></b>
              					</td>
              					<td valign="middle">
              						<?php echo xtc_draw_input_field_installer('FIRST_NAME','','','size="30"');?>
              						<span style="color:#990000">*</span>
              					</td>
              				</tr>
              			</table>
              			<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
              				<tr>
              					<td valign="middle" width="150">
              					    <b><?php echo TEXT_LASTNAME; ?></b>
              					</td>
              					<td valign="middle">
              						<?php echo xtc_draw_input_field_installer('LAST_NAME','','','size="30"');?>
              						<span style="color:#990000">*</span>
              					</td>
              				</tr>
              			</table>
              			<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
              				<tr>
              					<td valign="middle" width="150">
              					    <b><?php echo TEXT_BIRTHDAY; ?></b>
              					</td>
              					<td valign="middle">
              						<?php echo xtc_draw_input_field_installer('BIRTHDAY','','','size="30"');?>
              						<span style="color:#990000">*</span>
              					</td>
              				</tr>
              			</table>
              			<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
              				<tr>
              					<td valign="middle" width="150">
              					    <b><?php echo TEXT_EMAIL; ?></b>
              					</td>
              					<td valign="middle">
              						<?php echo xtc_draw_input_field_installer('EMAIL_ADRESS','','','size="30"');?>
              						<span style="color:#990000">*</span>
              						<?php echo ' <span'.mouseOverJS(TEXT_EMAIL,TEXT_EMAIL_LONG).'>
									<img src="images/icons/icon_help.gif" alt="" />
									</span>'; ?>
              					</td>
              				</tr>
              			</table>
              			<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
              				<tr>
              					<td valign="middle" width="150">
              					    <b><?php echo TEXT_STREET; ?></b>&nbsp;&nbsp;
              					    <b><?php echo TEXT_STREET_NUM; ?></b>
              					</td>
              					<td valign="middle">
              						<?php echo xtc_draw_input_field_installer('STREET_ADRESS','','','size="22"');?>
              						<span style="color:#990000">*</span>
              						<?php echo xtc_draw_input_field_installer('STREET_ADRESS_NUM','','','size="3"');?>
              						<span style="color:#990000">*</span>
              					</td>
              				</tr>
              			</table>
              			<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
              				<tr>
              					<td valign="middle" width="150">
              					    <b><?php echo TEXT_POSTCODE; ?></b>&nbsp;&nbsp;
              					    <b><?php echo TEXT_CITY; ?></b>
              					</td>
              					<td valign="middle">
              						<?php echo xtc_draw_input_field_installer('POST_CODE','','','size="5"');?>
              						<span style="color:#990000">*</span>&nbsp;&nbsp;
              						<?php echo xtc_draw_input_field_installer('CITY','','','size="19"');?>
              						<span style="color:#990000">*</span>
              					</td>
              				</tr>
              			</table>
              			<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
              				<tr>
              					<td valign="middle" width="150">
              					    <b><?php echo TEXT_COUNTRY; ?></b>
              					</td>
              					<td valign="middle">
              						<?php echo xtc_get_country_list('COUNTRY','81','style="width:224px" id="country"');?>
              						<span style="color:#990000">*</span>
              						<?php echo ' <span'.mouseOverJS(TEXT_COUNTRY,TEXT_COUNTRY_LONG).'>
									<img src="images/icons/icon_help.gif" alt="" />
									</span>'; ?>
              					</td>
              				</tr>
              			</table>
              			<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
              				<tr>
              					<td valign="middle" width="150">
              					    <b><?php echo TEXT_STATE; ?></b>
              					</td>
              					<td valign="middle">
              						<div id="provice">
              							<?php
              								$zones_array = array();
              								if(!empty($_POST['COUNTRY']))
              									$zone = (int)$_POST['COUNTRY'];
              								elseif(!empty($country))
              									$zone = (int)$country;
              								else
              									$zone = '81';
											$zones_query = xtc_db_query("select zone_id, zone_name from " . TABLE_ZONES . " where zone_country_id = '" . $zone . "' order by zone_name");
											while ($zones_values = xtc_db_fetch_array($zones_query)) {
												$zones_array[] = array('id' => $zones_values['zone_id'], 'text' => $zones_values['zone_name']);
											}
											echo xtc_draw_pull_down_menu('STATE', $zones_array);
       									?><span style="color:#990000">*</span>
              						</div>
              					</td>
              				</tr>
              			</table>
              			<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
              				<tr>
              					<td valign="middle" width="150">
              					    <b><?php echo TEXT_TEL; ?></b>
              					</td>
              					<td valign="middle">
              						<?php echo xtc_draw_input_field_installer('TELEPHONE','','','size="30"');?>
              						<span style="color:#990000">*</span>
              					</td>
              				</tr>
              			</table>
                		<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
                			<tr>
                				<td valign="middle" width="150">
                				    <b><?php echo TEXT_PASSWORD; ?></b>
                				</td>
                				<td valign="middle">
                					<?php echo xtc_draw_input_field_installer('PASSWORD','','password','size="30" id="pass" onkeyup="passwordStrength(this.value)"');?>
                					<span style="color:#990000">*</span>
                				</td>
                			</tr>
                			<tr>
                				<td valign="middle" width="150">
                				    <b><?php echo TEXT_PASSWORD_CONF; ?></b>
                				</td>
                				<td valign="middle">
                					<?php echo xtc_draw_input_field_installer('PASSWORD_CONFIRMATION','','password','size="30" id="pass2"');?>
                					<span style="color:#990000">*</span>
                				</td>
                			<tr>
                			<tr>
                				<td valign="middle" align="right">
                					<div id="passwordDescription"><?php echo TEXT_PASSWORD_STRONG; ?></div>
                				</td>
                				<td align="left">
									<div id="passwordStrength" class="strength0"></div>
                				</td>
                			</tr>
                		</table>
                		<h2 class="schatten">
                			<?php echo TITLE_SHOP_CONFIG; ?>
                			<?php echo ' <span'.mouseOverJS('Notiz',TITLE_SHOP_CONFIG_NOTE).'>
								<img src="images/icons/icon_help.gif" alt="" />
							</span>'; ?>
						</h2>
                		<p align="right"><span style="color:#990000"><b><?php echo TEXT_REQU_INFORMATION; ?></b></span></p>
                		<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
                			<tr>
                				<td valign="middle" width="150">
                				    <b><?php echo TEXT_STORE; ?></b>
                				</td>
                				<td valign="middle">
                					<?php echo xtc_draw_input_field_installer('STORE_NAME','','','size="30"');?>
                					<span style="color:#990000">*</span>
                					<?php echo ' <span'.mouseOverJS(TEXT_STORE,TEXT_STORE_LONG,'','200').'>
									<img src="images/icons/icon_help.gif" alt="" />
									</span>'; ?>
                				</td>
                			<tr>
                		</table>
              			<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
              				<tr>
              					<td valign="middle" width="150">
              					    <b><?php echo TEXT_COMPANY; ?></b>
              					</td>
              					<td valign="middle">
              						<?php echo xtc_draw_input_field_installer('COMPANY','','','size="30"');?>
              						<span style="color:#990000">*</span>
              					</td>
              				</tr>
              			</table>
              			<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
              				<tr>
              					<td valign="middle" width="150">
              					    <b><?php echo TEXT_USTID; ?></b>
              					</td>
              					<td valign="middle">
              						<?php echo xtc_draw_input_field_installer('USTID','','','size="30"');?>
              					</td>
              				</tr>
              			</table>
              			<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
              				<tr>
              					<td valign="middle" width="150">
              					    <b><?php echo TEXT_EMAIL_FROM; ?></b>
              					</td>
              					<td valign="middle">
              						<?php echo xtc_draw_input_field_installer('EMAIL_ADRESS_FROM','','','size="30"');?>
              						<span style="color:#990000">*</span>
              						<?php echo ' <span'.mouseOverJS(TEXT_EMAIL_FROM,TEXT_EMAIL_FROM_LONG).'>
									<img src="images/icons/icon_help.gif" alt="" />
									</span>'; ?>
              					</td>
              				</tr>
              			</table>
              			<input type="hidden" name="ZONE_SETUP" value="yes" />
              			<table cellpadding="8" cellspacing="8" width="100%">
              				<tr>
              					<td align="center" valign="middle">
              					    <input class="button" name="image" type="submit" value="weiter zu Schritt 7">
              					</td>
              				</tr>
              			</table>
              		</form>
				</td>
			</tr>
		</table>
	</div>
</div>
<table id="footer" width="100%">
	<tr>
		<td valign="bottom" align="center"><?php echo TEXT_FOOTER; ?></td>
	</tr>
</table>
</body>
</html>