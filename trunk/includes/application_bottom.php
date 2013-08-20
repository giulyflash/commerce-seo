<?php
/*-----------------------------------------------------------------
* 	$Id: application_bottom.php 490 2013-07-16 10:43:02Z akausch $
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

echo '<script src="'.DIR_WS_CATALOG.'javascript/head.min.js"></script>';
echo '<script>
	head.js(
	';
echo '"//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js",';
echo '"'.DIR_WS_CATALOG.'javascript/js/jquery-migrate.min.js",';
echo '"'.DIR_WS_CATALOG.'javascript/js/jquery.colorbox-min.js",';
echo '"'.DIR_WS_CATALOG.'javascript/js/formsizecheck.js",';
echo '"'.DIR_WS_CATALOG.'javascript/js/jquery-ui-1.10.3.custom.min.js",';
if (PRODUCT_DETAILS_SOCIAL == 'true') {
	echo '"'.DIR_WS_CATALOG.'javascript/js/jquery.socialshareprivacy.min.js",';
}
echo '"'.DIR_WS_CATALOG.'javascript/js/jquery.rating.pack.js",';
echo '"'.DIR_WS_CATALOG.'javascript/js/main.js"';
echo ');
</script>';

require_once ('templates/'.CURRENT_TEMPLATE.'/javascript/general.js.php');

if(GOOGLE_ANAL_ON == 'true' && GOOGLE_ANAL_CODE != '') {
	include('includes/google_analytics.js.php');
}

$t_products_id = 0;
if(isset($product) && $product->data['products_id'] > 0) {
	$t_products_id = $product->data['products_id'];
}

if (STORE_PAGE_PARSE_TIME == 'true') {
	$time_start = explode(' ', PAGE_PARSE_START_TIME);
	$time_end = explode(' ', microtime());
	$parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);
	error_log(strftime(STORE_PARSE_DATE_TIME_FORMAT) . ' - ' . getenv('REQUEST_URI') . ' (' . $parse_time . 's)' . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
}


if (DISPLAY_PAGE_PARSE_TIME == 'true') {
	$time_start = explode(' ', PAGE_PARSE_START_TIME);
	$time_end = explode(' ', microtime());
	$parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);
	echo '<div id="parsetime">Parse Time: ' . $parse_time . 's</div>';
}
echo '
<!-- Shopsoftware commerce:SEO v2next CE by www.commerce-seo.de based on xt:Commerce 3 - The Shopsoftware is redistributable under the GNU General Public License (Version 2) [http://www.gnu.org/licenses/gpl-2.0.html] -->
</body>
</html>';

if((GZIP_COMPRESSION == 'true') && ($ext_zlib_loaded == 1) && ($ini_zlib_output_compression < 1) ){
	require(DIR_FS_INC.'xtc_gzip_output.inc.php');
	xtc_gzip_output(GZIP_LEVEL);
}