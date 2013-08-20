<?php

/* -----------------------------------------------------------------
 * 	$Id: orders.php 452 2013-07-03 12:42:36Z akausch $
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
require_once (DIR_FS_CATALOG . DIR_WS_CLASSES . 'class.phpmailer.php');
require_once (DIR_FS_INC . 'xtc_php_mail.inc.php');
require_once (DIR_FS_INC . 'xtc_add_tax.inc.php');
require_once (DIR_FS_INC . 'xtc_validate_vatid_status.inc.php');
require_once (DIR_FS_INC . 'xtc_get_attributes_model.inc.php');

/* magnalister v1.0.1 */
if (function_exists('magnaExecute'))
    magnaExecute('magnaSubmitOrderStatus', array(), array('order_details.php'));
/* END magnalister */

// initiate template engine for mail
$smarty = new Smarty;
require (DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

if ((($_GET['action'] == 'edit') || ($_GET['action'] == 'update_order') || ($_GET['action'] == 'update_box')) && ($_GET['oID'])) {
    $oID = xtc_db_prepare_input($_GET['oID']);
    $orders_query = xtc_db_query("SELECT orders_id FROM " . TABLE_ORDERS . " WHERE orders_id = '" . xtc_db_input($oID) . "'");
    $order_exists = true;
    if (!xtc_db_num_rows($orders_query)) {
        $order_exists = false;
        $messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
    }
}

require(DIR_WS_CLASSES . 'class.order.php');
if ((($_GET['action'] == 'edit') || ($_GET['action'] == 'update_order') || ($_GET['action'] == 'update_box')) && ($order_exists)) {
    $order = new order($_GET['oID']);
}

$lang_query = xtc_db_query("SELECT languages_id FROM " . TABLE_LANGUAGES . " WHERE directory = '" . $order->info['language'] . "'");
$lang = xtc_db_fetch_array($lang_query);
$lang = $lang['languages_id'];

if (!isset($lang))
    $lang = $_SESSION['languages_id'];
$orders_statuses = array();
$orders_status_array = array();
$orders_status_query = xtc_db_query("SELECT orders_status_id, orders_status_name FROM " . TABLE_ORDERS_STATUS . " WHERE language_id = '" . $lang . "'");
while ($orders_status = xtc_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'], 'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
}
switch ($_GET['action']) {

	case 'create_credit' :
		include('includes/modules/order_create_credit.php');
		break;

    case 'multistatus' :
        include('includes/modules/order_update_order.php');
        break;

    case 'send' :
        include('includes/modules/order_send.php');
        xtc_redirect(xtc_href_link(FILENAME_ORDERS, 'oID=' . $_GET['oID']));

    case 'update_order' :
        if (!empty($_POST['mail_template_title']) && !empty($_POST['comments'])) {
            xtc_db_query("INSERT INTO mail_templates (title, mail_text) VALUES ('" . xtc_db_input($_POST['mail_template_title']) . "', '" . xtc_db_prepare_input($_POST['comments']) . "')");
        }

        if (isset($_GET['del_id']) && $_GET['del_id'] != '') {
            xtc_db_query("DELETE FROM orders_status_history WHERE orders_status_history_id = '" . intval($_GET['del_id']) . "' ");
            $messageStack->add_session(SUCCESS_HISTORY_DELETE, 'success');
        } else {
            include('includes/modules/order_update_order.php');
        }
        xtc_redirect(xtc_href_link(FILENAME_ORDERS, xtc_get_all_get_params(array('action', 'del_id')) . 'action=edit#comment'));
        break;

    case 'deleteconfirm' :
        include('includes/modules/order_deleteconfirm.php');
        xtc_redirect(xtc_href_link(FILENAME_ORDERS, xtc_get_all_get_params(array('oID', 'action'))));
        break;

    case 'afterbuy_send' :
        $oID = xtc_db_prepare_input($_GET['oID']);
        require_once (DIR_WS_CLASSES . 'class.afterbuy.php');
        $aBUY = new xtc_afterbuy_functions($oID);
        if ($aBUY->order_send()) {
            $aBUY->process_order();
        }
        break;
}

require (DIR_WS_INCLUDES . 'header.php');

$order = new order($_GET['oID']);

if (($_GET['action'] == 'edit') && ($order_exists)) {
    include('includes/modules/order_details.php');
} else {
    include('includes/modules/order_overview.php');
}

require (DIR_WS_INCLUDES . 'footer.php');
require (DIR_WS_INCLUDES . 'application_bottom.php');
