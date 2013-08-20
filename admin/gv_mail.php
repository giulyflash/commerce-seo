<?php
/* -----------------------------------------------------------------
 * 	$Id: gv_mail.php 420 2013-06-19 18:04:39Z akausch $
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


require('includes/application_top.php');
require(DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();
require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'class.phpmailer.php');
require_once(DIR_FS_INC . 'xtc_php_mail.inc.php');

// Template Engine fьr Email initialisieren
$smarty = new Smarty;

//////////////////////////////////////////////////////////////////////////////////////////////
// EMAIL VERSENDEN
//////////////////////////////////////////////////////////////////////////////////////////////
if (($_GET['action'] == 'send_email_to_user') && ($_POST['customers_email_address'] || $_POST['email_to']) && (!$_POST['back_x'])) {

    // An Kundengruppe versenden
    if (is_numeric($_POST['customers_email_address'])) {
        $mail_query = xtc_db_query("select customers_firstname, customers_lastname, customers_email_address, customers_id from " . TABLE_CUSTOMERS . " where customers_status = '" . $_POST['customers_email_address'] . "'");
        $customers_status_query = xtc_db_query("select customers_status_id, customers_status_name from " . TABLE_CUSTOMERS_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "' and customers_status_id = '" . $_POST['customers_email_address'] . "'");
        $customers_status = xtc_db_fetch_array($customers_status_query);
        $mail_sent_to = $customers_status['customers_status_name'];
    } else {
        switch ($_POST['customers_email_address']) {
            // An alle Kunden versenden
            case '***':
                $mail_query = xtc_db_query("select customers_firstname, customers_lastname, customers_email_address, customers_id from " . TABLE_CUSTOMERS);
                $mail_sent_to = TEXT_ALL_CUSTOMERS;
                break;
            // An alle Newsletter-Abonennten versenden
            case '**D':
                $mail_query = xtc_db_query("select customers_firstname, customers_lastname, customers_email_address, customers_id from " . TABLE_CUSTOMERS . " where customers_newsletter = '1'");
                $mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
                break;
            // An einzelnen Kunden versenden
            default:
                if ($_POST['email_to']) {
                    $customers_email_address = xtc_db_prepare_input($_POST['email_to']);
                    $mail_sent_to = $_POST['email_to'];
                } else {
                    $customers_email_address = xtc_db_prepare_input($_POST['customers_email_address']);
                    $mail_sent_to = $_POST['customers_email_address'];
                }
                $mail_query = xtc_db_query("select customers_firstname, customers_lastname, customers_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . xtc_db_input($customers_email_address) . "'");
                break;
        }
    }
    $subject = xtc_db_prepare_input($_POST['subject']);
    $coupon_code = create_coupon_code();

    // Neuen Kupon in Datenbank anlegen
    if ($_POST['coupon_type'] != 'G') {
        $insert_query = xtc_db_query("insert into " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created, uses_per_coupon, uses_per_user, coupon_start_date, coupon_expire_date, coupon_minimum_order) values ('" . $coupon_code . "', '" . $_POST['coupon_type'] . "', '" . $_POST['coupon_amount'] . "', now(), '" . $_POST['coupon_uses_coupon'] . "', '" . $_POST['coupon_uses_user'] . "', '" . $_POST['coupon_startdate'] . "', '" . $_POST['coupon_finishdate'] . "', '" . $_POST['coupon_min_order'] . "')");
        $insert_id = xtc_db_insert_id($insert_query);
        // Namen des Kupons eintragen
        if ($_POST['coupon_name'] != '') {
            $coupon_name = $_POST['coupon_name'];
        } else {
            $coupon_name = $coupon_code;
        }
        $insert_query = xtc_db_query("insert into " . TABLE_COUPONS_DESCRIPTION . " (coupon_id, language_id, coupon_name) values ('" . $insert_id . "', '" . $_SESSION['languages_id'] . "', '" . $coupon_name . "')");
    }

    if (xtc_db_num_rows($mail_query) === 0) {
        $mail_query = xtc_db_query("SELECT customers_firstname, customers_lastname, customers_id FROM " . TABLE_CUSTOMERS . " WHERE customers_id  = '1'");
        $tmp_email_name = STORE_NAME;
    }

    // Versenden Schleife
    while ($mail = xtc_db_fetch_array($mail_query)) {

        // Bei Gutscheinen fьr jeden Kunden einen separaten Code generieren
        if ($_POST['coupon_type'] == "G") {
            $coupon_code = create_coupon_code();
        }

        // assign language to template for caching
        $smarty->assign('language', $_SESSION['language']);
        $smarty->caching = false;

        // set dirs manual
        $smarty->template_dir = DIR_FS_CATALOG . 'templates';
        $smarty->compile_dir = DIR_FS_CATALOG . 'templates_c';
        $smarty->config_dir = DIR_FS_CATALOG . 'lang';
        $smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
        $smarty->assign('logo_path', HTTP_SERVER . DIR_WS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/');

        // Smarty Variablen
        $smarty->assign('NAME', $mail['customers_firstname'] . ' ' . $mail['customers_lastname']);
        $smarty->assign('MESSAGE', $_POST['message']);
        $smarty->assign('WEBSITE', HTTP_SERVER . DIR_WS_CATALOG);
        $link = HTTP_SERVER . DIR_WS_CATALOG . 'gv_redeem.php?gv_no=' . $coupon_code;
        $smarty->assign('GIFT_LINK', $link);
        $smarty->assign('COUPON_ID', $coupon_code);
        $smarty->assign('GIFT_ID', $coupon_code);

        // Smarty Variablen fuer Gutscheine
        if ($_POST['coupon_type'] == 'G') {
            $smarty->assign('COUPON_AMOUNT', $currencies->format($_POST['coupon_amount']));
            $smarty->assign('AMMOUNT', $currencies->format($_POST['coupon_amount']));
            // Smarty Variablen fьr Kupons
        } else {
            if ($_POST['coupon_type'] == 'P') {
                $smarty->assign('COUPON_AMOUNT', round($_POST['coupon_amount'], 2) . ' %');
                $smarty->assign('AMMOUNT', round($_POST['coupon_amount'], 2) . ' %');
            } else if ($_POST['coupon_type'] == 'F') {
                $smarty->assign('COUPON_AMOUNT', $currencies->format($_POST['coupon_amount']));
                $smarty->assign('AMMOUNT', $currencies->format($_POST['coupon_amount']));
            } else if ($_POST['coupon_type'] == 'S') {
                $smarty->assign('COUPON_AMOUNT', TEXT_FREE_SHIPPING);
                $smarty->assign('AMMOUNT', TEXT_FREE_SHIPPING);
            }
            if ($_POST['coupon_min_order'] != "") {
                $smarty->assign('COUPON_MINIMUM_ORDER', $currencies->format($_POST['coupon_min_order']));
            }
            $smarty->assign('COUPON_START_DATE', xtc_date_short($_POST['coupon_startdate']));
            $smarty->assign('COUPON_EXPIRE_DATE', xtc_date_short($_POST['coupon_finishdate']));
        }

        // Falls kein Betreff angegben wurde, Standard verwenden
        // An einzelnen Kunden versenden
        if ($customers_email_address != "") {

            require_once (DIR_FS_INC . 'cseo_get_mail_body.inc.php');
            $html_mail = $smarty->fetch('html:send_gift');
            $html_mail .= $signatur_html;
            $txt_mail = $smarty->fetch('txt:send_gift');
            $txt_mail .= $signatur_text;
            require_once (DIR_FS_INC . 'cseo_get_mail_data.inc.php');
            $mail_data = cseo_get_mail_data('send_gift');

            $gv_mail_name = str_replace('{$shop}', STORE_NAME, $mail_data['EMAIL_ADDRESS_NAME']);

            if ($subject == '')
                $subject = $mail_data['EMAIL_SUBJECT'];
            if ($tmp_email_name == '') {
                $tmp_email_name_send = $mail['customers_firstname'] . ' ' . $mail['customers_lastname'];
            } else {
                $tmp_email_name_send = $tmp_email_name;
            }
            xtc_php_mail($mail_data['EMAIL_ADDRESS'], $gv_mail_name, $customers_email_address, $tmp_email_name_send, '', $mail_data['EMAIL_REPLAY_ADDRESS'], $mail_data['EMAIL_REPLAY_ADDRESS_NAME'], '', '', $subject, $html_mail, $txt_mail);
            // An mehrere Kunden versenden			
        } else {

            require_once (DIR_FS_INC . 'cseo_get_mail_body.inc.php');
            $html_mail = $smarty->fetch('html:send_gift');
            $html_mail .= $signatur_html;
            $txt_mail = $smarty->fetch('txt:send_gift');
            $txt_mail .= $signatur_text;
            require_once (DIR_FS_INC . 'cseo_get_mail_data.inc.php');
            $mail_data = cseo_get_mail_data('send_gift');

            $gv_mail_name = str_replace('{$shop}', STORE_NAME, $mail_data['EMAIL_ADDRESS_NAME']);

            xtc_php_mail($mail_data['EMAIL_ADDRESS'], $gv_mail_name, $mail['customers_email_address'], $mail['customers_firstname'] . ' ' . $mail['customers_lastname'], '', $mail_data['EMAIL_REPLAY_ADDRESS'], $mail_data['EMAIL_REPLAY_ADDRESS_NAME'], '', '', $mail_data['EMAIL_SUBJECT'], $html_mail, $txt_mail);
        }

        // Neuen Gutschein in Datenbank anlegen
        if ($_POST['coupon_type'] == 'G') {
            $insert_query = xtc_db_query("insert into " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $coupon_code . "', 'G', '" . $_POST['coupon_amount'] . "', now())");
            $insert_id = xtc_db_insert_id($insert_query);
            // Namen des Gutscheins eintragen
            if ($_POST['coupon_name'] != '') {
                $coupon_name = $_POST['coupon_name'];
            } else {
                $coupon_name = $coupon_code;
            }
            $insert_query = xtc_db_query("insert into " . TABLE_COUPONS_DESCRIPTION . " (coupon_id, language_id, coupon_name) values ('" . $insert_id . "', '" . $_SESSION['languages_id'] . "', '" . $coupon_name . "')");
        }

        // Versand ins Protokoll eintragen
        $insert_query = xtc_db_query("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, sent_lastname, emailed_to, date_sent) values ('" . $insert_id . "', '" . $mail['customers_id'] . "', '" . $mail['customers_firstname'] . "', '" . $mail['customers_lastname'] . "', '" . $mail['customers_email_address'] . "', now() )");
    }

    // Zurьck zum Formular
    xtc_redirect(xtc_href_link(FILENAME_GV_MAIL, 'mail_sent_to=' . urlencode($mail_sent_to)));
}



//////////////////////////////////////////////////////////////////////////////////////////////
// FEHLERMELDUNGEN UND BESTДTIGUNG
//////////////////////////////////////////////////////////////////////////////////////////////
$error = "false";
if ($_GET['action'] == 'preview' && !$_POST['customers_email_address'] && !$_POST['email_to']) {
    $messageStack->add(ERROR_NO_CUSTOMER_SELECTED, 'error');
    $error = "true";
}
if ($_GET['action'] == 'preview' && !$_POST['coupon_amount'] && $_POST['coupon_type'] != "S") {
    $messageStack->add(ERROR_NO_AMOUNT_SELECTED, 'error');
    $error = "true";
}
if (($_GET['action'] == 'preview') && !$_POST['coupon_type']) {
    $messageStack->add(ERROR_NO_TYPE_SELECTED, 'error');
    $error = "true";
}
if ($_GET['mail_sent_to']) {
    $messageStack->add(sprintf(NOTICE_EMAIL_SENT_TO, $_GET['mail_sent_to']), 'notice');
}



//////////////////////////////////////////////////////////////////////////////////////////////
// HEAD DER SEITE
//////////////////////////////////////////////////////////////////////////////////////////////
require(DIR_WS_INCLUDES . 'header.php');
?>

<table class="outerTable" cellspacing="0" cellpadding="0">
    <tr>
        <td class="boxCenter" width="100%" valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="100%">
                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="0" width="100%" cellspacing="0" cellpadding="2">



<?php
if ($_GET['action'] == 'preview' && $error == "false") {
    if (is_numeric($_POST['customers_email_address'])) {
        $customers_status_query = xtc_db_query("select customers_status_id, customers_status_name from " . TABLE_CUSTOMERS_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "' and customers_status_id = '" . $_POST['customers_email_address'] . "'");
        $customers_status = xtc_db_fetch_array($customers_status_query);
        $mail_sent_to = $customers_status['customers_status_name'];
    } else {
        switch ($_POST['customers_email_address']) {
            case '***':
                $mail_sent_to = TEXT_ALL_CUSTOMERS;
                break;
            case '**D':
                $mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
                break;
            default:
                $mail_sent_to = $_POST['customers_email_address'];
                if ($_POST['email_to']) {
                    $mail_sent_to = $_POST['email_to'];
                }
                break;
        }
    }
    ?>
                                <tr>
                                    <td>
                                        <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                            <tr>
                                                <td class="smallText">
                                                    <b><?php echo TEXT_CUSTOMER; ?></b>&nbsp;&nbsp;<?php echo $mail_sent_to; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="smallText">
                                                    <b><?php echo TEXT_SUBJECT; ?></b>&nbsp;&nbsp;<?php echo htmlspecialchars(stripslashes($_POST['subject'])); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="smallText">
                                                    <b><?php echo TEXT_COUPON_NAME; ?></b>&nbsp;&nbsp;<?php echo htmlspecialchars(stripslashes($_POST['coupon_name'])); ?>
                                                </td>
                                            </tr>		  
                                            <tr>
                                                <td class="smallText">
                                                    <b><?php echo COUPON_TYPE; ?></b>&nbsp;&nbsp;
                                                    <?php
                                                    if ($_POST['coupon_type'] == "S") {
                                                        echo TEXT_FREE_SHIPPING;
                                                    } else if ($_POST['coupon_type'] == "F") {
                                                        echo TYPE_F;
                                                    } else if ($_POST['coupon_type'] == "P") {
                                                        echo TYPE_P;
                                                    } else if ($_POST['coupon_type'] == "G") {
                                                        echo TYPE_G;
                                                    }
                                                    ?>				
                                                </td>
                                            </tr>			  
    <?php if ($_POST['coupon_type'] != "S") { ?>
                                                <tr>
                                                    <td class="smallText">
                                                        <?php if ($_POST['coupon_type'] != "P") { ?>
                                                            <b><?php echo TEXT_AMOUNT; ?></b>&nbsp;&nbsp;<?php echo $currencies->format($_POST['coupon_amount']); ?>
        <?php } else { ?>
                                                            <b><?php echo TEXT_AMOUNT; ?></b>&nbsp;&nbsp;<?php echo $_POST['coupon_amount'] . ' %'; ?>
        <?php } ?>
                                                    </td>
                                                </tr>		  
                                                    <?php } ?>								
                                                    <?php if ($_POST['coupon_type'] != "G") { ?>
                                                <tr>
                                                    <td class="smallText">
                                                        <b><?php echo COUPON_MIN_ORDER; ?></b>&nbsp;&nbsp;<?php echo $_POST['coupon_min_order']; ?>
                                                    </td>
                                                </tr>			  
                                                <tr>
                                                    <td class="smallText">
                                                        <b><?php echo COUPON_USES_COUPON; ?></b>&nbsp;&nbsp;<?php echo $_POST['coupon_uses_coupon']; ?>
                                                    </td>
                                                </tr>			  
                                                <tr>
                                                    <td class="smallText">
                                                        <b><?php echo COUPON_USES_USER; ?></b>&nbsp;&nbsp;<?php echo $_POST['coupon_uses_user']; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="smallText">
        <?php $start_date = date(DATE_FORMAT, mktime(0, 0, 0, $_POST['coupon_startdate_month'], $_POST['coupon_startdate_day'], $_POST['coupon_startdate_year'])); ?>
                                                        <b><?php echo COUPON_STARTDATE; ?></b>&nbsp;&nbsp;<?php echo $start_date; ?>
                                                    </td>
                                                </tr>			  
                                                <tr>
                                                    <td class="smallText">
        <?php $finish_date = date(DATE_FORMAT, mktime(0, 0, 0, $_POST['coupon_finishdate_month'], $_POST['coupon_finishdate_day'], $_POST['coupon_finishdate_year'])); ?>
                                                        <b><?php echo COUPON_FINISHDATE; ?></b>&nbsp;&nbsp;<?php echo $finish_date; ?>
                                                    </td>
                                                </tr>					
    <?php } ?>								
                                            <tr>
                                                <td class="smallText">
                                                    <b><?php echo TEXT_MESSAGE; ?></b>&nbsp;&nbsp;<?php echo $_POST['message']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
    <?php echo xtc_draw_form('mail', FILENAME_GV_MAIL, 'action=send_email_to_user'); ?>
    <?php
    echo xtc_draw_hidden_field('customers_email_address', $_POST['customers_email_address']);
    echo xtc_draw_hidden_field('email_to', $_POST['email_to']);
    echo xtc_draw_hidden_field('subject', $_POST['subject']);
    echo xtc_draw_hidden_field('coupon_name', $_POST['coupon_name']);
    echo xtc_draw_hidden_field('coupon_type', $_POST['coupon_type']);
    echo xtc_draw_hidden_field('coupon_amount', $_POST['coupon_amount']);
    echo xtc_draw_hidden_field('coupon_min_order', $_POST['coupon_min_order']);
    echo xtc_draw_hidden_field('coupon_uses_coupon', $_POST['coupon_uses_coupon']);
    echo xtc_draw_hidden_field('coupon_uses_user', $_POST['coupon_uses_user']);
    echo xtc_draw_hidden_field('coupon_startdate', date('Y-m-d', mktime(0, 0, 0, $_POST['coupon_startdate_month'], $_POST['coupon_startdate_day'], $_POST['coupon_startdate_year'])));
    echo xtc_draw_hidden_field('coupon_finishdate', date('Y-m-d', mktime(0, 0, 0, $_POST['coupon_finishdate_month'], $_POST['coupon_finishdate_day'], $_POST['coupon_finishdate_year'])));
    ?>
                                                    <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                                        <tr>
                                                            <td align="right">
    <?php echo '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_GV_MAIL) . '">' . BUTTON_CANCEL . '</a> <input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SEND_EMAIL . '"/>'; ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>



                                                    <?php } else {
                                                    ?>
                                <tr>
                                <script type="text/javascript">
                                    function SetVisHide() {
                                        document.getElementById('couponSep1').className = "hide";
                                        document.getElementById('couponSep2').className = "hide";
                                        document.getElementById('couponSep3').className = "hide";
                                        document.getElementById('couponSep4').className = "hide";
                                        document.getElementById('couponSep5').className = "hide";
                                        document.getElementById('couponSep6').className = "hide";
                                        document.getElementById('couponSep7').className = "hide";
                                        document.getElementById('coupon1').className = "hide";
                                        document.getElementById('coupon2').className = "hide";
                                        document.getElementById('coupon3').className = "hide";
                                        document.getElementById('coupon4').className = "hide";
                                        document.getElementById('coupon5').className = "hide";
                                        document.getElementById('coupon6').className = "hide";
                                        document.getElementById('coupon7').className = "hide";
                                    }
                                    function SetVisShow() {
                                        document.getElementById('couponSep1').className = "show";
                                        document.getElementById('couponSep2').className = "show";
                                        document.getElementById('couponSep3').className = "show";
                                        document.getElementById('couponSep4').className = "show";
                                        document.getElementById('couponSep5').className = "show";
                                        document.getElementById('couponSep6').className = "show";
                                        document.getElementById('couponSep7').className = "show";
                                        document.getElementById('coupon1').className = "show";
                                        document.getElementById('coupon2').className = "show";
                                        document.getElementById('coupon3').className = "show";
                                        document.getElementById('coupon4').className = "show";
                                        document.getElementById('coupon5').className = "show";
                                        document.getElementById('coupon6').className = "show";
                                        document.getElementById('coupon7').className = "show";
                                    }
                                    function SetVisHideAmount() {
                                        document.getElementById('amount').className = "hide";
                                        document.getElementById('amountSep').className = "hide";
                                    }
                                    function SetVisShowAmount() {
                                        document.getElementById('amount').className = "show";
                                        document.getElementById('amountSep').className = "show";
                                    }
                                </script>
    <?php
    $subject = $_POST['subject'];
    $email_to = $_POST['email_to'];
    $coupon_name = $_POST['coupon_name'];
    $coupon_amount = $_POST['coupon_amount'];
    $coupon_type = $_POST['coupon_type'];
    $coupon_min_order = $_POST['coupon_min_order'];
    $coupon_uses_coupon = $_POST['coupon_uses_coupon'];
    $coupon_uses_user = $_POST['coupon_uses_user'];
    if (!$_POST['coupon_startdate_year']) {
        $coupon_startdate = split("[-]", date('Y-m-d'));
    } else {
        $coupon_startdate = array();
        $coupon_startdate[0] = $_POST['coupon_startdate_year'];
        $coupon_startdate[2] = $_POST['coupon_startdate_day'];
        $coupon_startdate[1] = $_POST['coupon_startdate_month'];
    }
    if (!$_POST['coupon_finishdate_year']) {
        $coupon_finishdate = split("[-]", date('Y-m-d'));
        $coupon_finishdate[0] = $coupon_finishdate[0] + 1;
    } else {
        $coupon_finishdate = array();
        $coupon_finishdate[0] = $_POST['coupon_finishdate_year'];
        $coupon_finishdate[2] = $_POST['coupon_finishdate_day'];
        $coupon_finishdate[1] = $_POST['coupon_finishdate_month'];
    }

    echo xtc_draw_form('mail', FILENAME_GV_MAIL, 'action=preview');
    ?>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="2">
                                <?php
                                if ($_GET['cID']) {
                                    $select = 'where customers_id=' . $_GET['cID'];
                                } else {
                                    $customers = array();
                                    $customers[] = array('id' => '', 'text' => TEXT_SELECT_CUSTOMER);
                                    $customers[] = array('id' => '', 'text' => '------------');
                                    $customers[] = array('id' => '***', 'text' => TEXT_ALL_CUSTOMERS);
                                    $customers[] = array('id' => '**D', 'text' => TEXT_NEWSLETTER_CUSTOMERS);
                                    $customers[] = array('id' => '', 'text' => '------------');
                                    $customers_status_query = xtc_db_query("select customers_status_id, customers_status_name from " . TABLE_CUSTOMERS_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "' order by customers_status_id");
                                    while ($customers_status = xtc_db_fetch_array($customers_status_query)) {
                                        $customers[] = array('id' => $customers_status['customers_status_id'], 'text' => $customers_status['customers_status_name']);
                                    }
                                    $customers[] = array('id' => '', 'text' => '------------');
                                }
                                $mail_query = xtc_db_query("select customers_id, customers_email_address, customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " " . $select . " order by customers_lastname");
                                while ($customers_values = xtc_db_fetch_array($mail_query)) {
                                    $customers[] = array('id' => $customers_values['customers_email_address'], 'text' => $customers_values['customers_lastname'] . ', ' . $customers_values['customers_firstname'] . ' (' . $customers_values['customers_email_address'] . ')');
                                }
                                ?>
                                        <tr>
                                            <td class="main" width="210">
                                                <b><?php echo TEXT_CUSTOMER; ?></b>
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250">
                                        <?php echo xtc_draw_pull_down_menu('customers_email_address', $customers, $_GET['customer']); ?>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="main">
                                                <b><?php echo TEXT_TO; ?></b>
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250">
    <?php echo xtc_draw_input_field('email_to', $email_to); ?>
                                                        </td>
                                                        <td class="main">
                                                            <?php echo TEXT_SINGLE_EMAIL; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="main">
                                                <b><?php echo TEXT_SUBJECT; ?></b>
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250">
    <?php echo xtc_draw_input_field('subject', $subject); ?>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="main">
                                                <b><?php echo TEXT_COUPON_NAME; ?></b>
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250">
    <?php echo xtc_draw_input_field('coupon_name', $coupon_name); ?>
                                                        </td>
                                                        <td class="main">
                                                            <?php echo TEXT_INFO_COUPON_NAME; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>			  
                                        <tr>
                                            <td class="main">
                                                <b><?php echo COUPON_TYPE; ?></b>
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250" class="main">
    <?php
    if ($coupon_type == "G") {
        echo '<input type="radio" name="coupon_type" value="G" checked="checked" onclick="SetVisHide(); SetVisShowAmount();" />' . TYPE_G;
    } else {
        echo '<input type="radio" name="coupon_type" value="G" onclick="SetVisHide(); SetVisShowAmount();" />' . TYPE_G;
    }
    ?>
                                                        </td>
                                                        <td class="main">
    <?php echo TYPE_G_HELP; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="main">
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250" class="main">
    <?php
    if ($coupon_type == "F") {
        echo '<input type="radio" name="coupon_type" value="F" checked="checked" onclick="SetVisShow(); SetVisShowAmount();" />' . TYPE_F;
    } else {
        echo '<input type="radio" name="coupon_type" value="F" onclick="SetVisShow(); SetVisShowAmount();" />' . TYPE_F;
    }
    ?>								
                                                        </td>
                                                        <td class="main">
                                                            <?php echo TYPE_F_HELP; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="main">
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250" class="main">
    <?php
    if ($coupon_type == "P") {
        echo '<input type="radio" name="coupon_type" value="P" checked="checked" onclick="SetVisShow(); SetVisShowAmount();" />' . TYPE_P;
    } else {
        echo '<input type="radio" name="coupon_type" value="P" onclick="SetVisShow(); SetVisShowAmount();" />' . TYPE_P;
    }
    ?>								
                                                        </td>
                                                        <td class="main">
                                                            <?php echo TYPE_P_HELP; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>			    
                                        </tr> 
                                        <tr>
                                            <td class="main">
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250" class="main">
    <?php
    if ($coupon_type == "S") {
        echo '<input type="radio" name="coupon_type" value="S" checked="checked" onclick="SetVisShow(); SetVisHideAmount();" />' . TYPE_S;
    } else {
        echo '<input type="radio" name="coupon_type" value="S" onclick="SetVisShow(); SetVisHideAmount();" />' . TYPE_S;
    }
    ?>																
                                                        </td>
                                                        <td class="main">
                                                            <?php echo TYPE_S_HELP; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr> 			  			
                                        <tr id="amount" class="show">
                                            <td valign="top" class="main">
                                                <b><?php echo TEXT_AMOUNT; ?></b>
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250">
                                                            <?php echo xtc_draw_input_field('coupon_amount', $coupon_amount); ?>
                                                        </td>
                                                        <td class="main">
                                                            <?php echo TEXT_INFO_AMOUNT; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>			  			
                                        <tr id="coupon1" class="show"> 
                                            <td class="main">
                                                <b><?php echo COUPON_MIN_ORDER; ?></b>
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250">
    <?php echo xtc_draw_input_field('coupon_min_order', $coupon_min_order); ?>
                                                        </td>
                                                        <td class="main">
                                                            <?php echo COUPON_MIN_ORDER_HELP; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr id="coupon2" class="show"> 
                                            <td class="main">
                                                <b><?php echo COUPON_USES_COUPON; ?></b>
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250">
    <?php echo xtc_draw_input_field('coupon_uses_coupon', $coupon_uses_coupon); ?>
                                                        </td>
                                                        <td class="main">
                                                            <?php echo COUPON_USES_COUPON_HELP; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr id="coupon3" class="show"> 
                                            <td class="main">
                                                <b><?php echo COUPON_USES_USER; ?></b>
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250">
    <?php echo xtc_draw_input_field('coupon_uses_user', $coupon_uses_user); ?>
                                                        </td>
                                                        <td class="main">
                                                            <?php echo COUPON_USES_USER_HELP; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr id="coupon6" class="show"> 
                                            <td class="main">
                                                <b><?php echo COUPON_STARTDATE; ?></b>
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250">
    <?php echo xtc_draw_date_selector('coupon_startdate', mktime(0, 0, 0, $coupon_startdate[1], $coupon_startdate[2], $coupon_startdate[0], 0)); ?>
                                                        </td>
                                                        <td class="main">
                                                            <?php echo COUPON_STARTDATE_HELP; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>			  
                                        <tr id="coupon7" class="show">
                                            <td class="main">
                                                <b><?php echo COUPON_FINISHDATE; ?></b>
                                            </td>
                                            <td>
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="250">
    <?php echo xtc_draw_date_selector('coupon_finishdate', mktime(0, 0, 0, $coupon_finishdate[1], $coupon_finishdate[2], $coupon_finishdate[0], 0)); ?>
                                                        </td>
                                                        <td class="main">
                                                            <?php echo COUPON_FINISHDATE_HELP; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>		 	  
                                        <tr>
                                            <td valign="top" class="main">
                                                <b><?php echo TEXT_MESSAGE; ?></b>
                                            </td>
                                            <td>
    <?php echo xtc_draw_textarea_field('message', 'soft', '100%', '10'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="right">
    <?php echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SEND_EMAIL . '"/>'; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                </form>
                    </tr>
                                            <?php } ?>
            </table>
        </td>
    </tr>
</table>
</td>
</tr>
</table>
                                            <?php
                                            require(DIR_WS_INCLUDES . 'footer.php');
                                            require(DIR_WS_INCLUDES . 'application_bottom.php');

                                            