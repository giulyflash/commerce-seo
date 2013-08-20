<?php
/* -----------------------------------------------------------------
 * 	$Id: product_prices_advanced.php 420 2013-06-19 18:04:39Z akausch $
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
require_once (DIR_FS_INC . 'xtc_get_tax_rate.inc.php');
// require_once (DIR_FS_INC . 'xtc_get_tax_class_id.inc.php');

require_once (DIR_FS_CATALOG . DIR_WS_CLASSES . 'class.xtcprice.php');

$xtPrice = new xtcPrice(DEFAULT_CURRENCY, $_SESSION['customers_status']['customers_status_id']);


if (PRICE_IS_BRUTTO == 'true') {
    $products_ekpprice = xtc_round($pInfo->products_ekpprice * ((100 + xtc_get_tax_rate($pInfo->products_tax_class_id)) / 100), PRICE_PRECISION);
    if ($pInfo->products_tax_class_id == '') {
        $taxdefault = '1';
    } else {
        $taxdefault = $pInfo->products_tax_class_id;
    }
} else {
    $products_ekpprice = xtc_round($pInfo->products_ekpprice, PRICE_PRECISION);
    if ($pInfo->products_tax_class_id == '') {
        $taxdefault = '1';
    } else {
        $taxdefault = $pInfo->products_tax_class_id;
    }
}
?>

<table width="100%" class="tablePrice">
    <tr>
        <td id="productsPrice" class="main"><?php echo TEXT_PRODUCTS_DISCOUNT_ALLOWED; ?></td>
        <td id="productsPriceInput" class="main"><?php echo xtc_draw_input_field('products_discount_allowed', $pInfo->products_discount_allowed); ?></td>
    </tr>
</table>
