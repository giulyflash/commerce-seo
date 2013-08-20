<?php

/* -----------------------------------------------------------------
 * 	$Id: cookie_usage.php 420 2013-06-19 18:04:39Z akausch $
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
// include boxes
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');


$breadcrumb->add(NAVBAR_TITLE_COOKIE_USAGE, xtc_href_link(FILENAME_COOKIE_USAGE));

require (DIR_WS_INCLUDES . 'header.php');

$smarty->assign('BUTTON_CONTINUE', '<a href="' . xtc_href_link(FILENAME_DEFAULT) . '">' . xtc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>');
$smarty->assign('language', $_SESSION['language']);

// set cache ID
if (!CacheCheck()) {
    $smarty->caching = false;
    $main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/cookie_usage.html');
} else {
    $smarty->caching = true;
    $smarty->cache_lifetime = CACHE_LIFETIME;
    $smarty->cache_modified_check = CACHE_CHECK;
    $cache_id = $_SESSION['language'];
    $main_content = $smarty->fetch(CURRENT_TEMPLATE . '/module/cookie_usage.html', $cache_id);
}

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = false;

$smarty->display(CURRENT_TEMPLATE . '/index.html');
include ('includes/application_bottom.php');
