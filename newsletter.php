<?php

/* -----------------------------------------------------------------
 * 	$Id: newsletter.php 420 2013-06-19 18:04:39Z akausch $
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

// create smarty elements
$smarty = new Smarty;

// include boxes
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC . 'xtc_random_charcode.inc.php');
require_once (DIR_FS_INC . 'xtc_validate_email.inc.php');


if (isset($_GET['action']) && (($_GET['action'] == 'process') || ($_GET['action'] == 'box'))) {
    $vlcode = xtc_random_charcode(32);
    $link = xtc_href_link(FILENAME_NEWSLETTER, 'action=activate&email=' . xtc_db_input($_POST['email']) . '&key=' . $vlcode, 'SSL');

    // assign language to template for caching
    $smarty->assign('language', $_SESSION['language']);

    $smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
    $smarty->assign('logo_path', HTTP_SERVER . DIR_WS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/');

    // assign vars
    $smarty->assign('EMAIL', xtc_db_input($_POST['email']));
    $smarty->assign('LINK', $link);
    // dont allow cache
    $smarty->caching = false;
    require_once(DIR_FS_INC . 'cseo_get_mail_body.inc.php');
    $html_mail = $smarty->fetch('html:newsletter_aktivierung');
    $html_mail .= $signatur_html;
    $txt_mail = $smarty->fetch('txt:newsletter_aktivierung');
    $txt_mail .= $signatur_text;
    require_once(DIR_FS_INC . 'cseo_get_mail_data.inc.php');
    $mail_data = cseo_get_mail_data('newsletter_aktivierung');

    // Check if email exists 
    if ((($_POST['check'] == 'inp') && !empty($_POST["codeanwser"])) || (($_POST['check'] == 'inp') && ($_GET['action'] == 'box'))) {
        if ($_GET['action'] != 'box') {
            if (!mb_strtolower($antispam_query['answer'], 'UTF-8') == mb_strtolower($_POST["codeanwser"], 'UTF-8')) {
                $check_mail_query = xtc_db_query("select customers_email_address, mail_status from " . TABLE_NEWSLETTER_RECIPIENTS . " where customers_email_address = '" . xtc_db_input($_POST['email']) . "'");
                if (!xtc_db_num_rows($check_mail_query)) {

                    if (isset($_SESSION['customer_id'])) {
                        $customers_id = $_SESSION['customer_id'];
                        $customers_status = $_SESSION['customers_status']['customers_status_id'];
                        $customers_firstname = $_SESSION['customer_first_name'];
                        $customers_lastname = $_SESSION['customer_last_name'];
                    } else {

                        $check_customer_mail_query = xtc_db_query("select customers_id, customers_status, customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_email_address = '" . xtc_db_input($_POST['email']) . "'");
                        if (!xtc_db_num_rows($check_customer_mail_query)) {
                            $customers_id = '0';
                            $customers_status = '1';
                            $customers_firstname = TEXT_CUSTOMER_GUEST;
                            $customers_lastname = '';
                        } else {
                            $check_customer = xtc_db_fetch_array($check_customer_mail_query);
                            $customers_id = $check_customer['customers_id'];
                            $customers_status = $check_customer['customers_status'];
                            $customers_firstname = $check_customer['customers_firstname'];
                            $customers_lastname = $check_customer['customers_lastname'];
                        }
                    }

                    $sql_data_array = array('customers_email_address' => xtc_db_input($_POST['email']),
                        'customers_id' => xtc_db_input($customers_id),
                        'customers_status' => xtc_db_input($customers_status),
                        'customers_firstname' => xtc_db_input($customers_firstname),
                        'customers_lastname' => xtc_db_input($customers_lastname),
                        'mail_status' => '0',
                        'mail_key' => xtc_db_input($vlcode),
                        'date_added' => 'now()');
                    xtc_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);

                    $info_message = TEXT_EMAIL_INPUT;

                    $mail_subject = str_replace('{$shop_name}', STORE_NAME, $mail_data['EMAIL_SUBJECT']);
                    $mail_name = str_replace('{$shop_name}', STORE_NAME, $mail_data['EMAIL_ADDRESS_NAME']);

                    if (SEND_EMAILS == true) {
                        xtc_php_mail($mail_data['EMAIL_ADDRESS'], $mail_name, xtc_db_input($_POST['email']), '', '', $mail_data['EMAIL_REPLAY_ADDRESS'], $mail_data['EMAIL_REPLAY_ADDRESS_NAME'], '', '', $mail_subject, $html_mail, $txt_mail);
                    }
                } else {
                    $check_mail = xtc_db_fetch_array($check_mail_query);

                    if ($check_mail['mail_status'] == '0') {
                        $info_message = TEXT_EMAIL_EXIST_NO_NEWSLETTER;

                        if (SEND_EMAILS == true) {
                            xtc_php_mail($mail_data['EMAIL_ADDRESS'], $mail_name, xtc_db_input($_POST['email']), '', '', $mail_data['EMAIL_REPLAY_ADDRESS'], $mail_data['EMAIL_REPLAY_ADDRESS_NAME'], '', '', $mail_subject, $html_mail, $txt_mail);
                        }
                    } else {
                        $info_message = TEXT_EMAIL_EXIST_NEWSLETTER;
                    }
                }
            } else {
                $info_message = TEXT_WRONG_CODE;
            }
        } else {
            $check_mail_query = xtc_db_query("select customers_email_address, mail_status from " . TABLE_NEWSLETTER_RECIPIENTS . " where customers_email_address = '" . xtc_db_input($_POST['email']) . "'");
            if (!xtc_db_num_rows($check_mail_query)) {

                if (isset($_SESSION['customer_id'])) {
                    $customers_id = $_SESSION['customer_id'];
                    $customers_status = $_SESSION['customers_status']['customers_status_id'];
                    $customers_firstname = $_SESSION['customer_first_name'];
                    $customers_lastname = $_SESSION['customer_last_name'];
                } else {

                    $check_customer_mail_query = xtc_db_query("select customers_id, customers_status, customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_email_address = '" . xtc_db_input($_POST['email']) . "'");
                    if (!xtc_db_num_rows($check_customer_mail_query)) {
                        $customers_id = '0';
                        $customers_status = '1';
                        $customers_firstname = TEXT_CUSTOMER_GUEST;
                        $customers_lastname = '';
                    } else {
                        $check_customer = xtc_db_fetch_array($check_customer_mail_query);
                        $customers_id = $check_customer['customers_id'];
                        $customers_status = $check_customer['customers_status'];
                        $customers_firstname = $check_customer['customers_firstname'];
                        $customers_lastname = $check_customer['customers_lastname'];
                    }
                }

                $sql_data_array = array('customers_email_address' => xtc_db_input($_POST['email']),
                    'customers_id' => xtc_db_input($customers_id),
                    'customers_status' => xtc_db_input($customers_status),
                    'customers_firstname' => xtc_db_input($customers_firstname),
                    'customers_lastname' => xtc_db_input($customers_lastname),
                    'mail_status' => '0',
                    'mail_key' => xtc_db_input($vlcode),
                    'date_added' => 'now()');
                xtc_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);

                $info_message = TEXT_EMAIL_INPUT;

                $mail_subject = str_replace('{$shop_name}', STORE_NAME, $mail_data['EMAIL_SUBJECT']);
                $mail_name = str_replace('{$shop_name}', STORE_NAME, $mail_data['EMAIL_ADDRESS_NAME']);

                if (SEND_EMAILS == true) {
                    xtc_php_mail($mail_data['EMAIL_ADDRESS'], $mail_name, xtc_db_input($_POST['email']), '', '', $mail_data['EMAIL_REPLAY_ADDRESS'], $mail_data['EMAIL_REPLAY_ADDRESS_NAME'], '', '', $mail_subject, $html_mail, $txt_mail);
                }
            } else {
                $check_mail = xtc_db_fetch_array($check_mail_query);

                if ($check_mail['mail_status'] == '0') {
                    $info_message = TEXT_EMAIL_EXIST_NO_NEWSLETTER;

                    if (SEND_EMAILS == true) {
                        xtc_php_mail($mail_data['EMAIL_ADDRESS'], $mail_name, xtc_db_input($_POST['email']), '', '', $mail_data['EMAIL_REPLAY_ADDRESS'], $mail_data['EMAIL_REPLAY_ADDRESS_NAME'], '', '', $mail_subject, $html_mail, $txt_mail);
                    }
                } else {
                    $info_message = TEXT_EMAIL_EXIST_NEWSLETTER;
                }
            }
        }
    }

    if (( ($_POST['check'] == 'del') && (!empty($_POST["codeanwser"])) ) || ( ($_POST['check'] == 'del') && ($_GET['action'] == 'box') )) {
        if ($_GET['action'] != 'box') {
            // if(!$antispam_query['answer'] == $_POST["codeanwser"]) {
            if (!mb_strtolower($antispam_query['answer'], 'UTF-8') == mb_strtolower($_POST["codeanwser"], 'UTF-8')) {

                $check_mail_query = xtc_db_query("select customers_email_address from " . TABLE_NEWSLETTER_RECIPIENTS . " where customers_email_address = '" . xtc_db_input($_POST['email']) . "'");
                if (!xtc_db_num_rows($check_mail_query)) {
                    $info_message = TEXT_EMAIL_NOT_EXIST;
                } else {
                    $del_query = xtc_db_query("delete from " . TABLE_NEWSLETTER_RECIPIENTS . " where customers_email_address ='" . xtc_db_input($_POST['email']) . "'");
                    $info_message = TEXT_EMAIL_DEL;
                }
            } else {
                $info_message = TEXT_WRONG_CODE;
            }
        }//captcha
        else { //box
            $check_mail_query = xtc_db_query("select customers_email_address from " . TABLE_NEWSLETTER_RECIPIENTS . " where customers_email_address = '" . xtc_db_input($_POST['email']) . "'");
            if (!xtc_db_num_rows($check_mail_query)) {
                $info_message = TEXT_EMAIL_NOT_EXIST;
            } else {
                $del_query = xtc_db_query("delete from " . TABLE_NEWSLETTER_RECIPIENTS . " where customers_email_address ='" . xtc_db_input($_POST['email']) . "'");
                $info_message = TEXT_EMAIL_DEL;
            }
        }
    }
}

// Accountaktivierung per Emaillink
if (isset($_GET['action']) && ($_GET['action'] == 'activate')) {
    $check_mail_query = xtc_db_query("select mail_key from " . TABLE_NEWSLETTER_RECIPIENTS . " where customers_email_address = '" . xtc_db_input($_GET['email']) . "'");
    if (!xtc_db_num_rows($check_mail_query)) {
        $info_message = TEXT_EMAIL_NOT_EXIST;
    } else {
        $check_mail = xtc_db_fetch_array($check_mail_query);
        if (!$check_mail['mail_key'] == $_GET['key']) {
            $info_message = TEXT_EMAIL_ACTIVE_ERROR;
        } else {
            xtc_db_query("UPDATE " . TABLE_NEWSLETTER_RECIPIENTS . " SET mail_status = '1' WHERE customers_email_address = '" . xtc_db_input($_GET['email']) . "'");
            $info_message = TEXT_EMAIL_ACTIVE;
        }
    }
}

// Accountdeaktivierung per Emaillink
if (isset($_GET['action']) && ($_GET['action'] == 'remove')) {
    $check_mail_query = xtc_db_query("SELECT 
											customers_email_address, 
											mail_key 
										FROM " . TABLE_NEWSLETTER_RECIPIENTS . " 
										WHERE
											customers_email_address = '" . xtc_db_input($_GET['email']) . "' 
											AND mail_key = '" . xtc_db_input($_GET['key']) . "'");
    if (!xtc_db_num_rows($check_mail_query)) {
        $info_message = TEXT_EMAIL_NOT_EXIST;
    } else {
        $check_mail = xtc_db_fetch_array($check_mail_query);
        if (!xtc_validate_email($check_mail['customers_email_address'], $_GET['key'])) {
            $info_message = TEXT_EMAIL_DEL_ERROR;
        } else {
            $del_query = xtc_db_query("DELETE 
											FROM " . TABLE_NEWSLETTER_RECIPIENTS . " 
											WHERE customers_email_address ='" . xtc_db_input($_GET['email']) . "' 
											AND mail_key = '" . xtc_db_input($_GET['key']) . "'");
            $info_message = TEXT_EMAIL_DEL;
        }
    }
}

$breadcrumb->add(NAVBAR_TITLE_NEWSLETTER, xtc_href_link(FILENAME_NEWSLETTER, '', 'SSL'));

require (DIR_WS_INCLUDES . 'header.php');


$smarty->assign('text_newsletter', TEXT_NEWSLETTER);
$smarty->assign('info_message', $info_message);
if (isset($_GET['action']) && ($_GET['action'] == 'box') || ($_GET['action'] == 'remove') || ($_GET['action'] == 'activate'))
    $smarty->assign('box_activation', true);

$smarty->assign('FORM_ACTION', xtc_draw_form('sign', xtc_href_link(FILENAME_NEWSLETTER, 'action=process', 'NONSSL')));
$smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', xtc_db_input($_POST['email'])));
//Antispam beginn
$antispam_query = xtc_db_fetch_array(xtDBquery("SELECT id, question FROM " . TABLE_CSEO_ANTISPAM . " WHERE language_id = '" . (int) $_SESSION['languages_id'] . "' ORDER BY rand() LIMIT 1"));
$smarty->assign('ANTISPAMCODEID', xtc_draw_hidden_field('antispamid', $antispam_query['id']));
$smarty->assign('ANTISPAMCODEQUESTION', $antispam_query['question']);
$smarty->assign('INPUT_ANTISPAMCODE', xtc_draw_input_field('codeanwser', '', 'size="6" maxlength="6"', 'text', false));
$smarty->assign('ANTISPAMCODEACTIVE', ANTISPAM_NEWSLETTER);
//Antispam end
$smarty->assign('CHECK_INP', xtc_draw_radio_field('check', 'inp'));
$smarty->assign('CHECK_DEL', xtc_draw_radio_field('check', 'del'));
$smarty->assign('BUTTON_SEND', xtc_image_submit('button_send.gif', IMAGE_BUTTON_LOGIN));
$smarty->assign('FORM_END', '</form>');

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = false;

$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/newsletter.html');

$smarty->assign('main_content', $main_content);

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = false;

$smarty->display(CURRENT_TEMPLATE . '/index.html');

include ('includes/application_bottom.php');
?>