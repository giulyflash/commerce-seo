<?php

/* -----------------------------------------------------------------
 * 	$Id: 404.php 420 2013-06-19 18:04:39Z akausch $
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

if (file_exists('includes/local/configure.php')) {
    include_once('includes/local/configure.php');
} elseif (file_exists('includes/configure.php')) {
    include_once('includes/configure.php');
} else {
    header('Location: installer/');
    exit;
}
include ('includes/application_top.php');

$offline_query = xtc_db_query("SELECT configuration_value FROM configuration WHERE configuration_key = 'DOWN_FOR_MAINTENANCE';");
$offline = xtc_db_fetch_array($offline_query);


$check = basename($_SERVER['REQUEST_URI']);
if (($offline['configuration_value'] == 'true') && ($check != 'login_offline.php')) {
    header('Location: login_offline.php');
    exit;
}


// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');

$breadcrumb->add(NAVBAR_TITLE_404, xtc_href_link('404.php', '', 'SSL'));

include ('includes/header.php');

$error_data = xtc_db_fetch_array(xtc_db_query("SELECT
							   content_title,
							   content_heading,
							   content_text
							   FROM " . TABLE_CONTENT_MANAGER . "
							   WHERE content_group='11' 
							   AND languages_id='" . (int) $_SESSION['languages_id'] . "'"));

if ($error_data) {
    $smarty->assign('404_TITLE', $error_data['content_heading']);
    $smarty->assign('404_TEXT', $error_data['content_text']);
}
require_once (DIR_FS_INC . 'xtc_hide_session_id.inc.php');
$smarty->assign('FORM_ACTION', xtc_draw_form('quick_find', xtc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get') . xtc_hide_session_id());
$smarty->assign('INPUT_SEARCH', xtc_draw_input_field('keywords', '', 'size="40" maxlength="30"'));
$smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_quick_find.gif', IMAGE_BUTTON_SEARCH));
$smarty->assign('FORM_END', '</form>');

$smarty->caching = false;
$smarty->assign('language', $_SESSION['language']);

$main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/404.html');

$smarty->assign('main_content', $main_content);
$smarty->caching = false;
$smarty->loadFilter('output', 'note');
$smarty->loadFilter('output', 'trimwhitespace');
$smarty->display(CURRENT_TEMPLATE . '/index.html');

include ('includes/application_bottom.php');
