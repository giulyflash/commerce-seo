<?php

/* -----------------------------------------------------------------
 * 	$Id: send_order.php 420 2013-06-19 18:04:39Z akausch $
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

require_once (DIR_FS_INC . 'xtc_get_order_data.inc.php');
require_once (DIR_FS_INC . 'xtc_get_attributes_model.inc.php');
require_once('pdf/html_table.php');

// check if customer is allowed to send this order!
$order_check = xtc_db_fetch_array(xtc_db_query("SELECT customers_id FROM " . TABLE_ORDERS . " WHERE orders_id='" . $insert_id . "'"));

// if ($_SESSION['customer_id'] == $order_check['customers_id']) {
if ($_SESSION['customer_id'] == $order_check['customers_id'] || $send_by_admin || $send_by_amazon) {

    $order = new order($insert_id);

    if ($_SESSION['paypal_express_new_customer'] == 'true' && $_SESSION['ACCOUNT_PASSWORD'] == 'true') {

        require_once (DIR_FS_INC . 'xtc_create_password.inc.php');
        require_once (DIR_FS_INC . 'xtc_encrypt_password.inc.php');

        $password_encrypted = xtc_RandomString(10);
        $password = xtc_encrypt_password($password_encrypted);

        xtc_db_query("UPDATE " . TABLE_CUSTOMERS . " SET customers_password = '" . $password . "' WHERE customers_id = '" . (int) $_SESSION['customer_id'] . "'");

        $smarty->assign('NEW_PASSWORD', $password_encrypted);
    }

    $smarty->assign('address_label_customer', xtc_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'));
    $smarty->assign('address_label_shipping', xtc_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br />'));
    if ($_SESSION['credit_covers'] != '1') {
        $smarty->assign('address_label_payment', xtc_address_format($order->billing['format_id'], $order->billing, 1, '', '<br />'));
    }
    $smarty->assign('csID', $order->customer['csID']);
    // get products data
    $order_query = xtc_db_query("SELECT
			        				products_id,
			        				orders_products_id,
			        				products_model,
			        				products_name,
			        				final_price, 
									products_shipping_time, 
			        				products_quantity
			        			FROM
			        				" . TABLE_ORDERS_PRODUCTS . "
			        			WHERE
			        				orders_id='" . $insert_id . "'");
    $order_data = array();
    while ($order_data_values = xtc_db_fetch_array($order_query)) {
        $attributes_query = xtc_db_query("SELECT
					        				products_options,
					        				products_options_values,
					        				price_prefix,
					        				options_values_price
					        			FROM
					        				" . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
					        			WHERE
					        				orders_products_id='" . $order_data_values['orders_products_id'] . "'");

        $getTaxClass = xtc_db_fetch_array(xtc_db_query("SELECT products_tax_class_id FROM products WHERE products_id = '" . $order_data_values['products_id'] . "' "));

        $attributes_data = '';
        $attributes_model = '';
        $attributes_single_price = '';
        $attributes_final_price = '';
        $attributes_qty = '';
        while ($attributes_data_values = xtc_db_fetch_array($attributes_query)) {
            $attributes_data .= $attributes_data_values['products_options'] . ': ' . $attributes_data_values['products_options_values'] . '<br />';
            $attributes_model .= '<br />' . xtc_get_attributes_model($order_data_values['products_id'], $attributes_data_values['products_options_values'], $attributes_data_values['products_options']);

            $attributes_single_price .= $xtPrice->xtcFormat($attributes_data_values['options_values_price'], true, $getTaxClass['products_tax_class_id']) . '<br />';
            $attributes_final_price .= $xtPrice->xtcFormat($attributes_data_values['options_values_price'] * $order_data_values['products_quantity'], true, $getTaxClass['products_tax_class_id']) . '<br />';
            $attributes_qty .= ($order_data_values['products_options'] != 'Downloads' ? $order_data_values['products_quantity'] . 'x' : '') . '<br />';
        }

        $order_data[] = array('PRODUCTS_MODEL' => $order_data_values['products_model'],
            'PRODUCTS_NAME' => $order_data_values['products_name'],
            'PRODUCTS_ATTRIBUTES' => $attributes_data,
            'PRODUCTS_ATTRIBUTES_MODEL' => $attributes_model,
            'PRODUCTS_ATTRIBUTES_SINGLE_PRICE' => $attributes_data_values['price_prefix'] . $attributes_single_price,
            'PRODUCTS_ATTRIBUTES_FINAL_PRICE' => $attributes_data_values['price_prefix'] . $attributes_final_price,
            'PRODUCTS_ATTRIBUTES_QTY' => $attributes_qty,
            'PRODUCTS_PRICE' => $xtPrice->xtcFormat($order_data_values['final_price'], true),
            'PRODUCTS_SINGLE_PRICE' => $xtPrice->xtcFormat($order_data_values['final_price'] / $order_data_values['products_quantity'], true),
            'PRODUCTS_SHIPPING_TIME' => $order_data_values['products_shipping_time'],
            'PRODUCTS_QTY' => $order_data_values['products_quantity']);
    }
    // get order_total data
    $oder_total_query = xtc_db_query("SELECT
	  					title,
	  					text,
	  					sort_order
	  					FROM " . TABLE_ORDERS_TOTAL . "
	  					WHERE orders_id='" . $insert_id . "'
	  					ORDER BY sort_order ASC");

    $order_total = array();
    while ($oder_total_values = xtc_db_fetch_array($oder_total_query)) {
        $order_total[] = array('TITLE' => $oder_total_values['title'], 'TEXT' => $oder_total_values['text']);
    }

    $smarty->assign('language', $_SESSION['language']);
    $smarty->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');
    $smarty->assign('logo_path', HTTP_SERVER . DIR_WS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/img/');
    $smarty->assign('oID', $insert_id);
    if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
        include (DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_method'] . '.php');
        $payment_method = constant(strtoupper('MODULE_PAYMENT_' . $order->info['payment_method'] . '_TEXT_TITLE'));
    }

    $customers_gender = xtc_db_fetch_array(xtc_db_query("SELECT customers_gender FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . $_SESSION['customer_id'] . "' "));
    $widerruf = xtc_db_fetch_array(xtc_db_query("SELECT content_heading, content_text, content_file FROM " . TABLE_CONTENT_MANAGER . " WHERE content_group = '10' AND languages_id = '" . (int) $_SESSION['languages_id'] . "' "));

    $smarty->assign('GENDER', $customers_gender['customers_gender']);
    $smarty->assign('VNAME', $order->customer['firstname']);
    $smarty->assign('NNAME', $order->customer['lastname']);
    $smarty->assign('UID', $order->customer['customers_vat_id']);
    $smarty->assign('PAYMENT_METHOD', $payment_method);
    $smarty->assign('DATE', xtc_date_long($order->info['date_purchased']));
    $smarty->assign('order_data', $order_data);
    $smarty->assign('order_total', $order_total);
    $smarty->assign('NAME', $order->customer['name']);
    $smarty->assign('COMMENTS', $order->info['comments']);
    $smarty->assign('EMAIL', $order->customer['email_address']);
    $smarty->assign('PHONE', $order->customer['telephone']);
	/** BEGIN BILLPAY CHANGED **/
	require_once(DIR_FS_CATALOG . 'includes/billpay/utils/billpay_mail.php');
	/** EOF BILLPAY CHANGED **/
    $smarty->assign('WIDERRUF_HEAD', $widerruf['content_heading']);
    if ($widerruf['content_file'] != '') {
        ob_start();
        include (DIR_FS_CATALOG . 'media/content/' . $widerruf['content_file']);
        $text = stripslashes(ob_get_contents());
        ob_end_clean();
        $smarty->assign('WIDERRUF_TEXT', $text);
    }
    else
        $smarty->assign('WIDERRUF_TEXT', $widerruf['content_text']);




    // PAYMENT MODUL TEXTS
    // EU Bank Transfer
    if ($order->info['payment_method'] == 'eustandardtransfer') {
        $smarty->assign('PAYMENT_INFO_HTML', MODULE_PAYMENT_EUTRANSFER_TEXT_DESCRIPTION);
        $smarty->assign('PAYMENT_INFO_TXT', str_replace("<br />", "\n", MODULE_PAYMENT_EUTRANSFER_TEXT_DESCRIPTION));
    }

    // MONEYORDER
    if ($order->info['payment_method'] == 'moneyorder') {
        $smarty->assign('PAYMENT_INFO_HTML', MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION);
        $smarty->assign('PAYMENT_INFO_TXT', str_replace("<br />", "\n", MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION));
    }

    // CASH
    if ($order->info['payment_method'] == 'cash') {
        $smarty->assign('PAYMENT_INFO_HTML', MODULE_PAYMENT_CASH_TEXT_INFO);
        $smarty->assign('PAYMENT_INFO_TXT', str_replace("<br />", "\n", MODULE_PAYMENT_CASH_TEXT_INFO));
    }

    $smarty->caching = false;
    require (DIR_FS_INC . 'cseo_get_mail_body.inc.php');
    $html_mail = $smarty->fetch('html:order_mail');
    $html_mail .= $signatur_html;
    $txt_mail = $smarty->fetch('txt:order_mail');
    $txt_mail .= $signatur_text;
    require (DIR_FS_INC . 'cseo_get_mail_data.inc.php');
    $mail_data = cseo_get_mail_data('order_mail');

    // create subject
    $order_subject = str_replace('{$nr}', $insert_id, $mail_data['EMAIL_SUBJECT']);
    $order_subject = str_replace('{$date}', strftime(DATE_FORMAT_LONG), $order_subject);
    $order_subject = str_replace('{$lastname}', $order->customer['lastname'], $order_subject);
    $order_subject = str_replace('{$firstname}', $order->customer['firstname'], $order_subject);
    $order_subject = str_replace('{$shop_besitzer}', STORE_OWNER, $order_subject);
    $order_subject = str_replace('{$shop_name}', STORE_NAME, $order_subject);

    // send mail to admin
    xtc_php_mail($mail_data['EMAIL_ADDRESS'], $order->customer['firstname'] . ' ' . $order->customer['lastname'], $mail_data['EMAIL_ADDRESS'], $mail_data['EMAIL_ADDRESS_NAME'], $mail_data['EMAIL_FORWARD'], $order->customer['email_address'], $order->customer['firstname'] . ' ' . $order->customer['lastname'], '', '', $order_subject, $html_mail, $txt_mail);

    $from_name = str_replace('{$shop_besitzer}', STORE_OWNER, $mail_data['EMAIL_ADDRESS_NAME']);
    $from_name = str_replace('{$shop_name}', STORE_NAME, $from_name);

    // send mail to customer
    xtc_php_mail($mail_data['EMAIL_ADDRESS'], $from_name, $order->customer['email_address'], $order->customer['firstname'] . ' ' . $order->customer['lastname'], '', $mail_data['EMAIL_REPLAY_ADDRESS'], $from_name, '', '', $order_subject, $html_mail, $txt_mail, true);

    if (AFTERBUY_ACTIVATED == 'true') {
        require_once (DIR_WS_CLASSES . 'class.afterbuy.php');
        $aBUY = new xtc_afterbuy_functions($insert_id);
        if ($aBUY->order_send())
            $aBUY->process_order();
    }
} else {
    $smarty->assign('ERROR', 'You are not allowed to view this order!');
    $smarty->display(CURRENT_TEMPLATE . '/module/error_message.html');
}
