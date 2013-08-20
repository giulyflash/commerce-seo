<?php
/*-----------------------------------------------------------------
* 	$Id: center_modules.php 428 2013-06-21 09:55:06Z akausch $
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

require(DIR_WS_MODULES . FILENAME_NEW_PRODUCTS);

if(CATEGORY_LISTING_START == 'true' && file_exists(DIR_WS_MODULES . FILENAME_MAIN_CATEGORIES_LIST)) {
	require(DIR_WS_MODULES . FILENAME_MAIN_CATEGORIES_LIST);
}

if (UPCOMING_PRODUCTS_START == 'true' && file_exists(DIR_WS_MODULES . FILENAME_MAIN_UPCOMING_PRODUCTS)) {
	require(DIR_WS_MODULES . FILENAME_MAIN_UPCOMING_PRODUCTS);
}

if (RANDOM_PRODUCTS_START == 'true' && file_exists(DIR_WS_MODULES . FILENAME_MAIN_RANDOM_PRODUCTS)) {
	require(DIR_WS_MODULES . FILENAME_MAIN_RANDOM_PRODUCTS);
}

return $module;
