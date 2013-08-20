<?php

/* -----------------------------------------------------------------
 * 	$Id: cseo_get_stock_img.inc.php 15 2013-07-19 08:21:26Z akausch $
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

function cseo_get_stock_img($qty) {
    if ($qty >= STOCK_WARNING_GREEN) {
        $img = '<img class="product_stock_img" src="' . DIR_WS_CATALOG . 'images/icons/icon_stock_1.png" alt="' . $qty . '" title="' . $qty . '" width="37" height="10" />';
    } elseif ($qty > STOCK_WARNING_RED && $qty < STOCK_WARNING_GREEN) {
        $img = '<img class="product_stock_img" src="' . DIR_WS_CATALOG . 'images/icons/icon_stock_2.png" alt="' . $qty . '" title="' . $qty . '" width="37" height="10" />';
    } elseif ($qty <= STOCK_WARNING_RED) {
        $img = '<img class="product_stock_img" src="' . DIR_WS_CATALOG . 'images/icons/icon_stock_3.png" alt="' . $qty . '" title="' . $qty . '" width="37" height="10" />';
    } else {
        $img = '';
    }

    return $img;
}
