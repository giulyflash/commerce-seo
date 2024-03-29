<?php

/* -----------------------------------------------------------------
 * 	$Id: account_password.php 420 2013-06-19 18:04:39Z akausch $
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

require_once (DIR_FS_INC . 'xtc_validate_password.inc.php');
require_once (DIR_FS_INC . 'xtc_encrypt_password.inc.php');

if (!isset($_SESSION['customer_id'])) {
    xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
}

if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    $password_current = xtc_db_prepare_input($_POST['password_current']);
    $password_new = xtc_db_prepare_input($_POST['password_new']);
    $password_confirmation = xtc_db_prepare_input($_POST['password_confirmation']);

    $error = false;

    if (strlen($password_current) < ENTRY_PASSWORD_MIN_LENGTH) {
        $messageStack->add('account_password', ENTRY_PASSWORD_CURRENT_ERROR);
        $error = true;
    } elseif (strlen($password_new) < ENTRY_PASSWORD_MIN_LENGTH) {
        $messageStack->add('account_password', ENTRY_PASSWORD_NEW_ERROR);
        $error = true;
    } elseif ($password_new != $password_confirmation) {
        $messageStack->add('account_password', ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING);
        $error = true;
    }

    if ($error == false) {
        $check_customer_query = xtc_db_query("SELECT customers_password FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . (int) $_SESSION['customer_id'] . "';");
        $check_customer = xtc_db_fetch_array($check_customer_query);

        if (xtc_validate_password($password_current, $check_customer['customers_password'])) {
            xtc_db_query("UPDATE " . TABLE_CUSTOMERS . " SET customers_password = '" . xtc_encrypt_password($password_new) . "', customers_last_modified=now() WHERE customers_id = '" . (int) $_SESSION['customer_id'] . "';");
            xtc_db_query("UPDATE " . TABLE_CUSTOMERS_INFO . " SET customers_info_date_account_last_modified = now() WHERE customers_info_id = '" . (int) $_SESSION['customer_id'] . "';");
            $messageStack->add_session('account', SUCCESS_PASSWORD_UPDATED, 'success');
            xtc_redirect(xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
        } else {
            $messageStack->add('account_password', ERROR_CURRENT_PASSWORD_NOT_MATCHING);
            $error = true;
        }
    }
}

$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_PASSWORD, xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_PASSWORD, xtc_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'));

require_once (DIR_WS_INCLUDES . 'header.php');

if ($messageStack->size('account_password') > 0) {
    $smarty->assign('error', $messageStack->output('account_password'));
}

$smarty->assign('FORM_ACTION', xtc_draw_form('account_password', xtc_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'), 'post', 'onsubmit="return check_form(account_password);"') . xtc_draw_hidden_field('action', 'process'));
$smarty->assign('INPUT_ACTUAL', xtc_draw_password_fieldNote(array('name' => 'password_current', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_PASSWORD_CURRENT_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CURRENT_TEXT . '</span>' : ''))));
$smarty->assign('INPUT_NEW', xtc_draw_password_fieldNote(array('name' => 'password_new', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_PASSWORD_NEW_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_NEW_TEXT . '</span>' : ''))));
$smarty->assign('INPUT_CONFIRM', xtc_draw_password_fieldNote(array('name' => 'password_confirmation', 'text' => '&nbsp;' . (xtc_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>' : ''))));
$smarty->assign('BUTTON_BACK', '<a href="' . xtc_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>');
$smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
$smarty->assign('FORM_END', '</form>');

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = false;

$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/account_password.html');

$smarty->assign('main_content', $main_content);

$smarty->display(CURRENT_TEMPLATE . '/index.html');

include ('includes/application_bottom.php');
