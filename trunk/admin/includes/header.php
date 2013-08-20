<?php
/* -----------------------------------------------------------------
 * 	$Id: header.php 420 2013-06-19 18:04:39Z akausch $
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

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
header("Content-Type: text/html; charset=utf-8");
$version = xtc_db_fetch_array(xtc_db_query("SELECT version FROM database_version"));
require(DIR_WS_INCLUDES . 'metatag.php');
?>

<?php
if (ADMIN_CSEO_TOP_COLUMN_VIEW != 'false') {
    include('includes/column_top.php');
}
?>
<br style="clear:both" />
<div id="wrapper">
    <div class="topSubNav">
        <div class="topSubNavleft">Version: <?php echo $version['version']; ?>
        </div>
        <div class="topSubNavright">
            <a href="http://support.commerce-seo.de/" target="_blank">Support</a> |
            <a href="../index.php" target="_blank">Shop</a> |
            <a href="<?php echo xtc_href_link(FILENAME_LOGOUT); ?>">Logout</a> |
            <a href="<?php echo xtc_href_link('delete_cache.php', 'subsite=tools'); ?>">Cache leeren</a> |
            <a href="<?php echo xtc_href_link('module_system.php', 'subsite=modules&set=&module=commerce_seo_url'); ?>">SEO-URL</a>
        </div>
    </div>
    <br style="clear:both" />

    <?php
    if ($messageStack->size > 0) {
        echo $messageStack->output();
    }
    ?>

    <table border="0" width="100%" cellspacing="2" cellpadding="2">
        <tr>
            <td width="100%" valign="top">