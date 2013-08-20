<?php

/* -----------------------------------------------------------------
 * 	$Id: media_content.php 420 2013-06-19 18:04:39Z akausch $
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

$content_query = xtc_db_query("SELECT content_name, content_read, content_file FROM " . TABLE_PRODUCTS_CONTENT . " WHERE content_id='" . (int) $_GET['coID'] . "'");
$content_data = xtc_db_fetch_array($content_query);

// update file counter

xtc_db_query("UPDATE 
			" . TABLE_PRODUCTS_CONTENT . " 
			SET content_read='" . ($content_data['content_read'] + 1) . "'
			WHERE content_id='" . (int) $_GET['coID'] . "'");

if ($content_data['content_file'] != '') {
    if (strpos($content_data['content_file'], '.txt'))
        echo '<pre>';

    if (preg_match('/.gif/i', $content_data['content_file']) or preg_match('/.jpg/i', $content_data['content_file']) or preg_match('/.png/i', $content_data['content_file']) or preg_match('/.tif/i', $content_data['content_file']) or preg_match('/.bmp/i', $content_data['content_file'])) {
        echo '<div>';
        echo xtc_image(DIR_WS_CATALOG . 'media/products/' . $content_data['content_file']);
        echo '</div>';
    } else {
        echo '<div>';
        include (DIR_FS_CATALOG . 'media/products/' . $content_data['content_file']);
        echo '</div>';
    }

    if (strpos($content_data['content_file'], '.txt'))
        echo '</pre>';
}
