<?php
/*-----------------------------------------------------------------
* 	$Id: downloads.php 420 2013-06-19 18:04:39Z akausch $
* 	Copyright (c) 2011-2021 commerce:SEO by Webdesign Erfurt
* 	http://www.commerce-seo.de
* ------------------------------------------------------------------
* 	based on:
* 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
* 	(c) 2002-2003 osCommerce - www.oscommerce.com
* 	(c) 2003     nextcommerce - www.nextcommerce.org
* 	(c) 2005     xt:Commerce - www.xt-commerce.com
* 	Released under the GNU General Public License
* ---------------------------------------------------------------*/




// ibclude the needed functions
if (!function_exists('xtc_date_long')) {
	require_once (DIR_FS_INC.'xtc_date_long.inc.php');
}

$module_smarty = new Smarty;

if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {
	// Get last order id for checkout_success
	$orders_query = xtc_db_query("select orders_id, orders_status from ".TABLE_ORDERS." where customers_id = '".$_SESSION['customer_id']."' order by orders_id desc limit 1");
	$orders = xtc_db_fetch_array($orders_query);
	$last_order = $orders['orders_id'];
	$order_status = $orders['orders_status'];
} else {
	$last_order = (int)$_GET['order_id'];
	$orders_query = xtc_db_query("SELECT orders_status FROM ".TABLE_ORDERS." WHERE orders_id = '".$last_order."'");
	$orders = xtc_db_fetch_array($orders_query);
	$order_status = $orders['orders_status'];
}
if ($order_status < DOWNLOAD_MIN_ORDERS_STATUS) {
	$module_smarty->assign('dl_prevented', 'true');
}
// Now get all downloadable products in that order
$downloads_query = xtc_db_query("select date_format(o.date_purchased, '%Y-%m-%d') as date_purchased_day, opd.download_maxdays, op.products_name, opd.orders_products_download_id, opd.orders_products_filename, opd.download_count, opd.download_maxdays from ".TABLE_ORDERS." o, ".TABLE_ORDERS_PRODUCTS." op, ".TABLE_ORDERS_PRODUCTS_DOWNLOAD." opd where o.customers_id = '".$_SESSION['customer_id']."' and o.orders_id = '".$last_order."' and o.orders_id = op.orders_id and op.orders_products_id = opd.orders_products_id and opd.orders_products_filename != ''");
if (xtc_db_num_rows($downloads_query) > 0) {
	$jj = 0;
	//<!-- list of products -->
	while ($downloads = xtc_db_fetch_array($downloads_query)) {
		// MySQL 3.22 does not have INTERVAL
		list ($dt_year, $dt_month, $dt_day) = explode('-', $downloads['date_purchased_day']);
		$download_timestamp = mktime(23, 59, 59, $dt_month, $dt_day + $downloads['download_maxdays'], $dt_year);
		$download_expiry = date('Y-m-d H:i:s', $download_timestamp);
		//<!-- left box -->
		// The link will appear only if:
		// - Download remaining count is > 0, AND
		// - The file is present in the DOWNLOAD directory, AND EITHER
		// - No expiry date is enforced (maxdays == 0), OR
		// - The expiry date is not reached
		if (($downloads['download_count'] > 0) && (file_exists(DIR_FS_DOWNLOAD.$downloads['orders_products_filename'])) && (($downloads['download_maxdays'] == 0) || ($download_timestamp > time())) && ($order_status >= DOWNLOAD_MIN_ORDERS_STATUS)) {
			$dl[$jj]['download_link'] = '<a href="'.xtc_href_link(FILENAME_DOWNLOAD, 'order='.$last_order.'&id='.$downloads['orders_products_download_id']).'">'.$downloads['products_name'].'</a>';
			$dl[$jj]['pic_link'] = xtc_href_link(FILENAME_DOWNLOAD, 'order='.$last_order.'&id='.$downloads['orders_products_download_id']);
		} else {
			$dl[$jj]['download_link'] = $downloads['products_name'];
		}
		//<!-- right box -->
		$dl[$jj]['date'] = xtc_date_long($download_expiry);
		$dl[$jj]['count'] = $downloads['download_count'];
		$jj ++;
	}
}
$module_smarty->assign('dl', $dl);
$module_smarty->assign('language', $_SESSION['language']);
$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$module_smarty->caching = false;
$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/downloads.html');
$smarty->assign('downloads_content', $module);
?>