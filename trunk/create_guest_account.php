<?php

/* -----------------------------------------------------------------
 * 	$Id: create_guest_account.php 471 2013-07-09 18:32:20Z akausch $
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

if (ACCOUNT_OPTIONS == 'account')
    xtc_redirect(FILENAME_DEFAULT);

if (isset($_SESSION['customer_id'])) {
    xtc_redirect(xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
}

// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC . 'xtc_get_country_list.inc.php');
require_once (DIR_FS_INC . 'xtc_get_countries.inc.php');
require_once (DIR_FS_INC . 'xtc_validate_email.inc.php');
require_once (DIR_FS_INC . 'xtc_encrypt_password.inc.php');
require_once (DIR_FS_INC . 'xtc_create_password.inc.php');
require_once (DIR_FS_INC . 'xtc_get_geo_zone_code.inc.php');

$process = false;
if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    $process = true;

    if (ACCOUNT_GENDER == 'true')
        $gender = xtc_db_prepare_input($_POST['gender']);
    $firstname = xtc_db_prepare_input($_POST['firstname']);
    $lastname = xtc_db_prepare_input($_POST['lastname']);
    if (ACCOUNT_DOB == 'true')
        $dob = xtc_db_prepare_input($_POST['dob']);
    $email_address = xtc_db_prepare_input($_POST['email_address']);
    if (ACCOUNT_COMPANY == 'true')
        $company = xtc_db_prepare_input($_POST['company']);
    if (ACCOUNT_COMPANY_VAT_CHECK == 'true')
        $vat = xtc_db_prepare_input($_POST['vat']);
    $street_address = xtc_db_prepare_input($_POST['street_address']);
    $street_address_num = xtc_db_prepare_input($_POST['street_address_num']);
    if (ACCOUNT_SUBURB == 'true')
        $suburb = xtc_db_prepare_input($_POST['suburb']);
    $postcode = xtc_db_prepare_input($_POST['postcode']);
    $city = xtc_db_prepare_input($_POST['city']);
    $zone_id = xtc_db_prepare_input($_POST['zone_id']);
    if (ACCOUNT_STATE == 'true')
        $state = xtc_db_prepare_input($_POST['state']);
    $country = xtc_db_prepare_input($_POST['country']);
    $telephone = xtc_db_prepare_input($_POST['telephone']);
    $fax = xtc_db_prepare_input($_POST['fax']);
    $newsletter = xtc_db_prepare_input($_POST['newsletter']);
    $password = xtc_db_prepare_input($_POST['password']);
    $confirmation = xtc_db_prepare_input($_POST['confirmation']);
    if (TRUSTED_SHOP_CREATE_ACCOUNT_DS == 'true') {
        $datensg = xtc_db_prepare_input($_POST['datensg']);
    }
    $error = false;

    if (ACCOUNT_GENDER == 'true') {
        if (($gender != 'm') && ($gender != 'f')) {
            $error = true;
            $messageStack->add('create_account', ENTRY_GENDER_ERROR);
        }
    }

    if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_FIRST_NAME_ERROR);
    }

    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_LAST_NAME_ERROR);
    }

    require_once(DIR_WS_CLASSES . 'class.vat_validation.php');
    $vatID = new vat_validation($vat, '', '', $country, true);

    $customers_status = $vatID->vat_info['status'];
    $customers_vat_id_status = $vatID->vat_info['vat_id_status'];
    $error = $vatID->vat_info['error'];

    if ($error == 1) {
        $messageStack->add('create_account', ENTRY_VAT_ERROR);
        $error = true;
    }


    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);
    }
    if (xtc_validate_email($email_address) == false) {
        $error = true;
        $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    }

    if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_STREET_ADDRESS_ERROR);
    }

    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_POST_CODE_ERROR);
    }

    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
        $error = true;
        $messageStack->add('create_account', ENTRY_CITY_ERROR);
    }

    if (is_numeric($country) == false) {
        $error = true;
        $messageStack->add('create_account', ENTRY_COUNTRY_ERROR);
    }

    if (ACCOUNT_STATE == 'true') {
        $zone_id = 0;
        $check_query = xtc_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int) $country . "'");
        $check = xtc_db_fetch_array($check_query);
        $entry_state_has_zones = ($check['total'] > 0);
        if ($entry_state_has_zones == true) {
            $zone_query = xtc_db_query("select zone_id,zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int) $country . "' and zone_id = '" . (int) $state . "' ");

            if (xtc_db_num_rows($zone_query) >= 1) {
                $zone = xtc_db_fetch_array($zone_query);
                $zone_id = $zone['zone_id'];
            } else {
                $error = true;

                $messageStack->add('create_account', ENTRY_STATE_ERROR_SELECT);
            }
        } else {
            if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
                $error = true;

                $messageStack->add('create_account', ENTRY_STATE_ERROR);
            }
        }
    }

    if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
        $error = true;

        $messageStack->add('create_account', ENTRY_TELEPHONE_NUMBER_ERROR);
    }

    if (TRUSTED_SHOP_CREATE_ACCOUNT_DS == 'true' && $mobile_template == 'False') {
        if (!isset($datensg) || empty($datensg)) {
            $error = true;
            $messageStack->add('create_account', ERROR_DATENSG_NOT_ACCEPTED);
        }
    }

    if (ACCOUNT_DOB == 'true') {
        if (ENTRY_DOB_MIN_LENGTH > 0 && $dob != '') {
            if (checkdate(substr(xtc_date_raw($dob), 4, 2), substr(xtc_date_raw($dob), 6, 2), substr(xtc_date_raw($dob), 0, 4)) == false) {
                $error = true;
                $messageStack->add('create_account', ENTRY_DATE_OF_BIRTH_ERROR);
            }
        } elseif (ENTRY_DOB_MIN_LENGTH > 0 && $dob == '') {
            $error = true;
            $messageStack->add('create_account', ENTRY_DATE_OF_BIRTH_ERROR);
        }
    }

    if ($customers_status == 0 || !$customers_status)
        $customers_status = DEFAULT_CUSTOMERS_STATUS_ID_GUEST;
    $password = xtc_create_password(8);


    if ($error == false) {
        $sql_data_array = array('customers_vat_id' => $vat,
            'customers_vat_id_status' => $customers_vat_id_status,
            'customers_status' => $customers_status,
            'customers_firstname' => $firstname,
            'customers_lastname' => $lastname,
            'customers_email_address' => $email_address,
            'customers_telephone' => $telephone,
            'customers_fax' => $fax,
            'account_type' => '1',
            'customers_password' => xtc_encrypt_password($password),
            'customers_newsletter' => $newsletter);

        $_SESSION['account_type'] = '1';

        if (ACCOUNT_GENDER == 'true')
            $sql_data_array['customers_gender'] = $gender;
        if (ACCOUNT_DOB == 'true')
            $sql_data_array['customers_dob'] = xtc_date_raw($dob);

        // Modifikation Automatisch Kundennummer tag monat jahr- nr:
        function new_customer_id($space = '-') {
            $new_cid = '';
            $day = date("d");
            $mon = date("m");
            $year = date("y");

            $cid_query = xtc_db_query("SELECT customers_id FROM " . TABLE_CUSTOMERS . " ORDER BY customers_id DESC LIMIT 1");
            $last_cid = xtc_db_fetch_array($cid_query);
            $new_cid = $day . $mon . $year . $space . ($last_cid['customers_id'] + 1000);

            return $new_cid;
        }

        $sql_data_array['customers_cid'] = new_customer_id();
        // Modifikation Kundennummer tag monat jahr- nr Ende

        xtc_db_perform(TABLE_CUSTOMERS, $sql_data_array);

        $_SESSION['customer_id'] = xtc_db_insert_id();

        $sql_data_array = array('customers_id' => $_SESSION['customer_id'],
            'entry_firstname' => $firstname,
            'entry_lastname' => $lastname,
            'entry_street_address' => $street_address . ' ' . $street_address_num,
            'entry_postcode' => $postcode,
            'entry_city' => $city,
            'entry_country_id' => $country);

        if (ACCOUNT_GENDER == 'true')
            $sql_data_array['entry_gender'] = $gender;
        if (ACCOUNT_COMPANY == 'true')
            $sql_data_array['entry_company'] = $company;
        if (ACCOUNT_SUBURB == 'true')
            $sql_data_array['entry_suburb'] = $suburb;
        if (ACCOUNT_STATE == 'true') {
            if ($zone_id > 0) {
                $sql_data_array['entry_zone_id'] = $zone_id;
                $sql_data_array['entry_state'] = '';
            } else {
                $sql_data_array['entry_zone_id'] = '0';
                $sql_data_array['entry_state'] = $zone['zone_name'];
            }
        }

        xtc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

        $address_id = xtc_db_insert_id();

        xtc_db_query("update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . $address_id . "' where customers_id = '" . (int) $_SESSION['customer_id'] . "'");

        xtc_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int) $_SESSION['customer_id'] . "', '0', now())");

        if ($newsletter == '1') {

            require_once (DIR_FS_INC . 'xtc_random_charcode.inc.php');
            $vlcode = xtc_random_charcode(32);

            $sql_newletter_array = array('customers_email_address' => $email_address,
                'customers_id' => (int) $_SESSION['customer_id'],
                'customers_status' => $customers_status,
                'customers_firstname' => $firstname,
                'customers_lastname' => $lastname,
                'mail_status' => '0',
                'mail_key' => $vlcode,
                'date_added' => 'now()');
            xtc_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_newletter_array);

            $link = xtc_href_link(FILENAME_NEWSLETTER, 'action=activate&email=' . $email_address . '&key=' . $vlcode, 'NONSSL');

            $smarty->assign('EMAIL', xtc_db_input($_POST['email']));
            $smarty->assign('LINK', $link);

            $smarty->assign('language', $_SESSION['language']);

            $smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
            $smarty->assign('logo_path', HTTP_SERVER . DIR_WS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/');
            $smarty->caching = false;
            require_once (DIR_FS_INC . 'cseo_get_mail_body.inc.php');
            $html_mail = $smarty->fetch('html:newsletter_aktivierung');
            $html_mail .= $signatur_html;
            $txt_mail = $smarty->fetch('txt:newsletter_aktivierung');
            $txt_mail .= $signatur_text;
            require_once (DIR_FS_INC . 'cseo_get_mail_data.inc.php');
            $mail_data = cseo_get_mail_data('newsletter_aktivierung');

            $newsletter_subject = str_replace('{$shop_besitzer}', STORE_OWNER, $mail_data['EMAIL_SUBJECT']);
            $newsletter_subject = str_replace('{$shop_name}', STORE_NAME, $newsletter_subject);

            if (SEND_EMAILS == true) {
                xtc_php_mail($mail_data['EMAIL_ADDRESS'], $mail_data['EMAIL_ADDRESS_NAME'], xtc_db_input($email_address), $firstname . ' ' . $lastname, $mail_data['EMAIL_FORWARD'], $mail_data['EMAIL_REPLAY_ADDRESS'], $mail_data['EMAIL_REPLAY_ADDRESS_NAME'], '', '', $newsletter_subject, $html_mail, $txt_mail);
            }
        } else {
            $newsletter = '0';
        }

        if (SESSION_RECREATE == 'true')
            xtc_session_recreate();

        $_SESSION['customer_first_name'] = $firstname;
        $_SESSION['customer_last_name'] = $lastname;
        $_SESSION['customer_default_address_id'] = $address_id;
        $_SESSION['customer_country_id'] = $country;
        $_SESSION['customer_zone_id'] = $zone_id;
        $_SESSION['customer_vat_id'] = $vat;

        // restore cart contents
        $_SESSION['cart']->restore_contents();

        if (isset($_SESSION[tracking]['refID'])) {
            $campaign_check_query_raw = "SELECT * FROM " . TABLE_CAMPAIGNS . " WHERE campaigns_refID = '" . $_SESSION[tracking][refID] . "'";
            $campaign_check_query = xtc_db_query($campaign_check_query_raw);
            if (xtc_db_num_rows($campaign_check_query) > 0) {
                $campaign = xtc_db_fetch_array($campaign_check_query);
                $refID = $campaign['campaigns_id'];
            } else {
                $refID = 0;
            }

            xtc_db_query("update " . TABLE_CUSTOMERS . " set refferers_id = '" . $refID . "' where customers_id = '" . (int) $_SESSION['customer_id'] . "'");

            $leads = $campaign['campaigns_leads'] + 1;
            xtc_db_query("update " . TABLE_CAMPAIGNS . " set campaigns_leads = '" . $leads . "' where campaigns_id = '" . $refID . "'");
        }

        if (CHECKOUT_AJAX_STAT == 'true') {
            xtc_redirect(xtc_href_link(FILENAME_CHECKOUT, '', 'SSL'));
        } else {
            xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
        }
    }
}

$breadcrumb->add(NAVBAR_TITLE_CREATE_GUEST_ACCOUNT, xtc_href_link(FILENAME_CREATE_GUEST_ACCOUNT, '', 'SSL'));

require (DIR_WS_INCLUDES . 'header.php');


if ($messageStack->size('create_account') > 0) {
    $smarty->assign('error', $messageStack->output('create_account'));
}
$smarty->assign('FORM_ACTION', xtc_draw_form('create_account', xtc_href_link(FILENAME_CREATE_GUEST_ACCOUNT, '', 'SSL'), 'post', 'onsubmit="return check_form(this);" autocomplete="off"') . xtc_draw_hidden_field('action', 'process'));

if (ACCOUNT_GENDER == 'true') {
    $smarty->assign('gender', '1');

    $smarty->assign('INPUT_MALE', xtc_draw_radio_field(array('name' => 'gender', 'suffix' => MALE), 'm', '', 'id="gender-1"'));
    $smarty->assign('INPUT_FEMALE', xtc_draw_radio_field(array('name' => 'gender', 'suffix' => FEMALE, 'text' => (xtc_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>' : '')), 'f', '', 'id="gender-2"'));
} else {
    $smarty->assign('gender', '0');
}

$smarty->assign('INPUT_FIRSTNAME', xtc_draw_input_fieldNote(array('name' => 'firstname', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>' : '')), '', 'size="29" class="create_account_firstname" id="create_firstname"'));
$smarty->assign('INPUT_LASTNAME', xtc_draw_input_fieldNote(array('name' => 'lastname', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>' : '')), '', 'size="29" class="create_account_lastname" id="create_lastname"'));

if (ACCOUNT_DOB == 'true') {
    $smarty->assign('birthdate', '1');
    if (ENTRY_DOB_MIN_LENGTH > 0):
        $smarty->assign('INPUT_DOB', xtc_draw_input_fieldNote(array('name' => 'dob', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="inputRequirement">' . ENTRY_DATE_OF_BIRTH_TEXT . '</span>' : '')), '', 'size="29" class="create_account_dob" id="create_dob"', 'date'));
    else:
        $smarty->assign('INPUT_DOB', xtc_draw_input_fieldNote(array('name' => 'dob', 'text' => ''), '', 'size="29" class="create_account_dob"', 'date'));
    endif;
} else {
    $smarty->assign('birthdate', '0');
}

$smarty->assign('INPUT_EMAIL', xtc_draw_input_fieldNote(array('name' => 'email_address', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>' : '')), '', 'size="29" class="create_account_email" id="create_email"', 'email'));

if (ACCOUNT_COMPANY == 'true') {
    $smarty->assign('company', '1');
    $smarty->assign('INPUT_COMPANY', xtc_draw_input_fieldNote(array('name' => 'company', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>' : '')), '', 'size="29" class="create_account_company" id="create_company"'));
} else {
    $smarty->assign('company', '0');
}

if (ACCOUNT_COMPANY_VAT_CHECK == 'true') {
    $smarty->assign('vat', '1');
    $smarty->assign('INPUT_VAT', xtc_draw_input_fieldNote(array('name' => 'vat', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_VAT_TEXT) ? '<span class="inputRequirement">' . ENTRY_VAT_TEXT . '</span>' : '')), '', 'size="29" class="create_account_vat" id="create_vat"'));
} else {
    $smarty->assign('vat', '0');
}

$smarty->assign('INPUT_STREET', xtc_draw_input_fieldNote(array('name' => 'street_address', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>' : '')), '', 'size="21" class="create_account_street" id="create_street_address"'));
$smarty->assign('INPUT_STREET_NUM', xtc_draw_input_fieldNote(array('name' => 'street_address_num', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>' : '')), '', 'size="3" class="create_account_street_num"'));

if (ACCOUNT_SUBURB == 'true') {
    $smarty->assign('suburb', '1');
    $smarty->assign('INPUT_SUBURB', xtc_draw_input_fieldNote(array('name' => 'suburb', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>' : '')), '', 'size="29" class="create_account_suburb" id="create_suburb"'));
} else {
    $smarty->assign('suburb', '0');
}

$smarty->assign('INPUT_CODE', xtc_draw_input_fieldNote(array('name' => 'postcode', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>' : '')), '', 'size="5"  class="create_account_postcode" id="create_postcode"'));
$smarty->assign('INPUT_CITY', xtc_draw_input_fieldNote(array('name' => 'city', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>' : '')), '', 'size="19" class="create_account_city" id="create_city"'));

if (ACCOUNT_STATE == 'true') {
    $smarty->assign('state', '1');

    $zones_array = array();
    $zones_query = xtc_db_query("select zone_id,zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (isset($_POST['country']) ? (int) $country : STORE_COUNTRY) . "' order by zone_name");
    while ($zones_values = xtc_db_fetch_array($zones_query)) {
        $zones_array[] = array('id' => $zones_values['zone_id'], 'text' => $zones_values['zone_name']);
    }
    $state_input = xtc_draw_pull_down_menuNote(array('name' => 'state', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">' . ENTRY_STATE_TEXT . '</span>' : '')), $zones_array, '', 'class="create_account_state" id="create_state"');

    $smarty->assign('INPUT_STATE', $state_input);
} else {
    $smarty->assign('state', '0');
}

if (isset($_POST['country'])) {
    $selected = $_POST['country'];
} elseif (isset($_SESSION['country'])) {
    $selected = $_SESSION['country'];
} else {
    $selected = STORE_COUNTRY;
}


$counrty_count_query = xtc_db_query("select countries_id,status from " . TABLE_COUNTRIES . " where status = '1'");
$counrty_count = xtc_db_num_rows($counrty_count_query);
if ($counrty_count > 1) {
    $smarty->assign('SELECT_COUNTRY_JS', '
	<script type="text/javascript">
	<!--
		jQuery(function(){
			jQuery("select#country").change(function(){
				var value = jQuery("select#country").val();
				jQuery.ajax({
				  type: "GET",
				  url: "getCountry.php",
				  data: "land=" + value,
				  cache: false,
				  success: function(html){
					jQuery("#state").html(html);
				  },
				  beforeSend: function(){
					jQuery("#state").html("<p style=\'width:198px\' align=\'center\'><img src=\'images/wait.gif\' alt=\'\' /></p>");
				  }
				});
			});
		});
	//-->
	</script>');
    $smarty->assign('SELECT_COUNTRY', xtc_get_country_list(array('name' => 'country', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>' : '')), $selected, 'id="country" class="create_account_country"'));
} else {
    $smarty->assign('SELECT_COUNTRY_ENABLE', 'false');
    $smarty->assign('SELECT_COUNTRY', xtc_draw_hidden_field('country', $selected));
}
$smarty->assign('INPUT_TEL', xtc_draw_input_fieldNote(array('name' => 'telephone', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>' : '')), '', 'size="29" class="telephone" id="create_telephone"'));
$smarty->assign('INPUT_FAX', xtc_draw_input_fieldNote(array('name' => 'fax', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_FAX_NUMBER_TEXT . '</span>' : '')), '', 'size="29" id="create_fax"'));
if (TRUSTED_SHOP_CREATE_ACCOUNT_DS == 'true') {
    $shop_content_query = xtc_db_query("SELECT content_title,content_heading,content_text,content_file FROM " . TABLE_CONTENT_MANAGER . " WHERE content_group='2' AND languages_id='" . $_SESSION['languages_id'] . "'");
    $shop_content_data = xtc_db_fetch_array($shop_content_query);
    if ($shop_content_data['content_file'] != '') {
        if ($shop_content_data['content_file'] == 'janolaw_datenschutz.php') {
            include (DIR_FS_INC . 'janolaw.inc.php');
            $datensg = JanolawContent('datenschutzerklaerung', 'txt');
        }
        else
            $datensg = '<iframe src="' . DIR_WS_CATALOG . 'media/content/' . $shop_content_data['content_file'] . '" width="100%" height="300"></iframe>';
    } else {
        $datensg = '<div class="agbframe">' . $shop_content_data['content_text'] . '</div>';
    }
    $smarty->assign('DSG', $datensg);
    $smarty->assign('BUTTON_PRINT', '(<a style="cursor:pointer" onclick="javascript:window.open(\'' . xtc_href_link(FILENAME_PRINT_CONTENT, 'coID=2') . '\', \'popup\', \'toolbar=0, width=640, height=600\')">' . PRINT_CONTENT . '</a>)');
    $smarty->assign('DATENSG_CHECKBOX', '<input type="checkbox" id="create_dsg" value="datensg" name="datensg" /> *');
} else {
    $smarty->assign('TRUSTED_DSG', 'false');
}

$smarty->assign('CHECKBOX_NEWSLETTER', xtc_draw_checkbox_field('newsletter', '1', false));
$smarty->assign('FORM_END', '</form>');
$smarty->assign('language', $_SESSION['language']);
$smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_send.gif', IMAGE_BUTTON_CONTINUE));
$smarty->assign('DEVMODE', USE_TEMPLATE_DEVMODE);
$smarty->caching = false;

$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/create_account_guest.html');
$smarty->assign('main_content', $main_content);

$smarty->display(CURRENT_TEMPLATE . '/index.html');

include ('includes/application_bottom.php');
