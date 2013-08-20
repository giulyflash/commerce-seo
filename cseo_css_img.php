<?php

/* -----------------------------------------------------------------
 * 	$Id: cseo_css_img.php 420 2013-06-19 18:04:39Z akausch $
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

include('includes/application_top.php');

function hex2dec($hex) {
    $color = str_replace('#', '', $hex);
    $ret = array('r' => hexdec(substr($color, 0, 2)), 'g' => hexdec(substr($color, 2, 2)), 'b' => hexdec(substr($color, 4, 2)));
    return $ret;
}

$w = (isset($_GET['w']) && !empty($_GET['w']) ? $_GET['w'] : '1');
$h = (isset($_GET['h']) && !empty($_GET['h']) ? $_GET['h'] : '30');
$c1 = (isset($_GET['c1']) && !empty($_GET['c1']) ? $_GET['c1'] : 'ffffff');
$c2 = (isset($_GET['c2']) && !empty($_GET['c2']) ? $_GET['c2'] : '000000');

$s = hex2dec($c1);
$e = hex2dec($c2);

$image = imagecreate($w, $h);

for ($i = 0; $i < $h; $i++) {
    $l = imagecolorallocate(
            $image, max(0, $s['r'] - ((($e['r'] - $s['r']) / -$h) * $i)), max(0, $s['g'] - ((($e['g'] - $s['g']) / -$h) * $i)), max(0, $s['b'] - ((($e['b'] - $s['b']) / -$h) * $i)));
    imageline($image, 0, $i, $w, $i, $l);
}
if (isset($_GET['d']) && !empty($_GET['d'])) // Rotation
    $image = imagerotate($image, (int) $_GET['d'], 0);

imagepng($image);
echo $image;

imagedestroy($image);

include(DIR_WS_CLASSES . 'class.cachefiles.php');
$css = new cacheFile('css');
$cache_file = $css->getCachePath('reset.css');
$t_last_modified = filemtime($cache_file);

if (date('I', $t_last_modified) != 1 && date('I') == 1) {
    $t_last_modified += 3600;
} elseif (date('I', $t_last_modified) == 1 && date('I') != 1) {
    $t_last_modified -= 3600;
}

$t_hashes_array = array();
$t_hashes_array[] = md5_file($cache_file);
$t_etag = '"' . md5(implode('', $t_hashes_array)) . '"';
header('Last-Modified: ' . gmdate("D, d M Y H:i:s", $t_last_modified) . ' GMT');
header('Etag: ' . $t_etag);
$max_age = 60 * 60 * 24 * 7;
header("Content-type: image/png");
header('Cache-Control: public, max-age=' . $max_age);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $max_age) . ' GMT');
header('Connection: Keep-Alive');

if ((isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == $t_etag) || (!isset($_SERVER['HTTP_IF_NONE_MATCH']) && isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && @strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $t_last_modified)) {
    header('HTTP/1.1 304 Not Modified');
    exit;
}

