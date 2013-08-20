<?php
/* -----------------------------------------------------------------
 * 	$Id: security_check.php 420 2013-06-19 18:04:39Z akausch $
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

$file_warning = '';
if (file_exists(DIR_FS_CATALOG . 'includes/configure.php')) {
    if (!strpos(decoct(fileperms(DIR_FS_CATALOG . 'includes/configure.php')), '444')) {
        $file_warning .= '<br>' . DIR_FS_CATALOG . 'includes/configure.php';
    }
}
if (file_exists(DIR_FS_CATALOG . 'includes/configure.org.php')) {
    if (!strpos(decoct(fileperms(DIR_FS_CATALOG . 'includes/configure.org.php')), '444')) {
        $file_warning .= '<br>' . DIR_FS_CATALOG . 'includes/configure.org.php';
    }
}
if (file_exists(DIR_FS_ADMIN . 'includes/configure.php')) {
    if (!strpos(decoct(fileperms(DIR_FS_ADMIN . 'includes/configure.php')), '444')) {
        $file_warning .= '<br>' . DIR_FS_ADMIN . 'includes/configure.php';
    }
}
if (file_exists(DIR_FS_ADMIN . 'includes/configure.org.php')) {
    if (!strpos(decoct(fileperms(DIR_FS_ADMIN . 'includes/configure.org.php')), '444')) {
        $file_warning .= '<br>' . DIR_FS_ADMIN . 'includes/configure.org.php';
    }
}
if (!strpos(decoct(fileperms(DIR_FS_CATALOG . 'templates_c/')), '777') and !strpos(decoct(fileperms(DIR_FS_CATALOG . 'templates_c/')), '755')) {
    $folder_warning .= '<br>' . DIR_FS_CATALOG . 'templates_c/';
}

if (!strpos(decoct(fileperms(DIR_FS_CATALOG . 'cache/')), '777') and !strpos(decoct(fileperms(DIR_FS_CATALOG . 'cache/')), '755')) {
    $folder_warning .= '<br>' . DIR_FS_CATALOG . 'cache/';
}

if (!strpos(decoct(fileperms(DIR_FS_CATALOG . 'media/')), '777') and !strpos(decoct(fileperms(DIR_FS_CATALOG . 'media/')), '755')) {
    $folder_warning .= '<br>' . DIR_FS_CATALOG . 'media/';
}

if (!strpos(decoct(fileperms(DIR_FS_CATALOG . 'media/content/')), '777') and !strpos(decoct(fileperms(DIR_FS_CATALOG . 'media/content/')), '755')) {
    $folder_warning .= '<br>' . DIR_FS_CATALOG . 'media/content/';
}


$payment = xtc_db_fetch_array(xtc_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_PAYMENT_INSTALLED'"));
$shipping = xtc_db_fetch_array(xtc_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_SHIPPING_INSTALLED'"));

if ($file_warning != '' || $folder_warning != '' || (empty($payment['configuration_value'])) || (empty($shipping['configuration_value']))) {
    ?>
    <table id="security_check" border="0" width="98%" cellspacing="0" cellpadding="8">
        <?php
        if ($file_warning != '') {
            echo '<tr><td>' . TEXT_FILE_WARNING;
            echo '<b>' . $file_warning . '</b></td></tr>';
        }
        if ($folder_warning != '') {
            echo '<tr><td>' . TEXT_FOLDER_WARNING;
            echo '<b>' . $folder_warning . '</b></td></tr>';
        }
        if (empty($payment['configuration_value'])) {
            echo '<tr><td>' . TEXT_PAYMENT_ERROR . '</td></tr>';
        }
        if (empty($shipping['configuration_value']))
            echo '<tr><td>' . TEXT_SHIPPING_ERROR . '</td></tr>';
        ?>
    </table>
<?php } ?>

