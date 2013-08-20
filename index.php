<?php

/* -----------------------------------------------------------------
 * 	$Id: index.php 420 2013-06-19 18:04:39Z akausch $
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
$category_depth = 'top';
if (isset($cPath) && xtc_not_null($cPath)) {
    $cateqories_products = xtc_db_fetch_array(xtDBquery("SELECT count(*) as total FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " WHERE categories_id = '" . $current_category_id . "';"));
    if ($cateqories_products['total'] > 0) {
        $category_depth = 'products'; // nur Produkte
    } else {
        $category_parent = xtc_db_fetch_array(xtDBquery("SELECT count(*) as total FROM " . TABLE_CATEGORIES . " WHERE parent_id = '" . $current_category_id . "';"));
        if ($category_parent['total'] > 0) {
            $category_depth = 'nested'; // Kategorie hat Produkte
        } else {
            $category_depth = 'products'; // Kategorie hat keine Produkte
        }
    }
}

if (!isset($_GET['products_id']) && (!isset($_GET['cPath'])) && (!isset($_GET['cat'])) && (!isset($_GET['manufacturers_id'])) && (!isset($_GET['coID']))) {
    $_GET['coID'] = '5';
    $smarty->assign('startpage', 'true');
}

require_once (DIR_WS_INCLUDES . 'header.php');
include (DIR_WS_MODULES . 'default.php');
$smarty->assign('DEVMODE', USE_TEMPLATE_DEVMODE);
$smarty->assign('language', $_SESSION['language']);
$smarty->caching = false;

$smarty->loadFilter('output', 'note');

$smarty->display(CURRENT_TEMPLATE . '/index.html');

include ('includes/application_bottom.php');

