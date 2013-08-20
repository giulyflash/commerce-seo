<?php
/* -----------------------------------------------------------------
 * 	$Id: product_prices.php 480 2013-07-14 10:40:27Z akausch $
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
    $products_price = xtc_round($pInfo->products_price * ((100 + xtc_get_tax_rate($pInfo->products_tax_class_id)) / 100), PRICE_PRECISION);
    if ($pInfo->products_tax_class_id == '') {
        $taxdefault = '1';
    } else {
        $taxdefault = $pInfo->products_tax_class_id;
    }
} else {
    $products_price = xtc_round($pInfo->products_price, PRICE_PRECISION);
    if ($pInfo->products_tax_class_id == '') {
        $taxdefault = '1';
    } else {
        $taxdefault = $pInfo->products_tax_class_id;
    }
}
?>

<table width="100%" class="tablePrice">
    <tr>
        <td id="productsPrice" class="main"><?php echo TEXT_PRODUCTS_PRICE; ?></td>
        <td id="productsPriceInput" class="main">
            <?php
            echo xtc_draw_input_field('products_price', $products_price);
            if (PRICE_IS_BRUTTO == 'true') {
                echo '&nbsp;' . TEXT_NETTO . '<b>' . $xtPrice->xtcFormat($pInfo->products_price, false) . '</b>  ';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td id="productsPrice" class="main"><?php echo TEXT_PRODUCTS_QUANTITY; ?></td>
        <td id="productsPriceInput" class="main">
            <?php
            echo xtc_draw_input_field('products_quantity', $pInfo->products_quantity);
            ?>
        </td>
    </tr>
    <tr>
        <td id="productsPrice" class="main"><?php echo TEXT_PRODUCTS_MODEL; ?></td>
        <td id="productsPriceInput" class="main">
            <?php
            echo xtc_draw_input_field('products_model', $pInfo->products_model);
            ?>
        </td>
    </tr>
    <tr>
        <td id="productsPrice" class="main"><?php echo TEXT_PRODUCTS_TAX_CLASS; ?></td>
        <td id="productsPriceInput" class="main"><?php echo xtc_draw_pull_down_menu('products_tax_class_id', $tax_class_array, $taxdefault); ?></td>
    </tr>
</table>
