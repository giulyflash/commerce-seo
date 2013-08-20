<?php

/* -----------------------------------------------------------------
 * 	$Id: rss_news.php 420 2013-06-19 18:04:39Z akausch $
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

$Title = "RSS Feed von " . STORE_NAME;
$logo_url = HTTP_SERVER . DIR_WS_CATALOG . "templates/" . CURRENT_TEMPLATE . "/img/logo.gif";
$Description = "Aktuelle Produkte von " . STORE_NAME;
$copyright = STORE_NAME;
$product_count = 999;

//MwSt-Einstellungen
$with_tax = TRUE;
$show_shipping = TRUE;

$SiteLink = HTTP_SERVER . DIR_WS_CATALOG;
$date = date(DATE_RFC822);

if (GROUP_CHECK == 'true') {
    $group_check = " AND p.group_permission_" . $_SESSION['customers_status']['customers_status_id'] . "=1 ";
}

$query = "SELECT
			p.products_id,
            p.products_ean,
			pd.products_name,
            pd.products_short_description,
			p.products_price,
			p.products_image,
       		p.products_model,
            p.group_permission_1,
			p.products_date_added,
			p.products_tax_class_id,
			s.specials_new_products_price
			FROM (products p INNER JOIN products_description pd ON p.products_id = pd.products_id) 
			LEFT JOIN specials s ON p.products_id = s.products_id
			WHERE p.products_status = '1'
			AND pd.language_id = '" . (int) $_SESSION['languages_id'] . "'
			AND IF(s.specials_new_products_price>0, s.status = '1', '1')
			AND IF(s.expires_date>0, s.expires_date>now(), '1')
            " . $group_check . "
			ORDER BY p.products_date_added DESC 
			LIMIT 0," . $product_count;

$listing_query = xtDBquery($query);

header("Content-Type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n\n";
echo "<rss version=\"2.0\">\n\n";
echo "<channel>\n";
echo "<title>$Title</title>\n";
echo "<link>$SiteLink</link>\n";
echo "<description>$Description</description>\n";
echo "<language>de-de</language>\n";
echo "<copyright>$copyright</copyright>\n";
echo "<pubDate>$date</pubDate>\n"; //muss eigentlich folgendes Format haben "2007-02-23T14:25:18.037+02:00" date("c") gibt es aber erst ab PHP5

echo "\t\t<image>\n\t\t\t<url>" . $logo_url . "</url>\n\t\t\t<title>Shoplogo</title>\n\t\t\t<link>" . $SiteLink . "</link>\n\t\t</image>\n\n";

while ($listing = xtc_db_fetch_array($listing_query, true)) {

    if (strcmp(substr($listing['products_model'], 0, 2), 'FP') == 0) {
        $product_type = 'FreePattern';
    } elseif (strcmp(substr($listing['products_model'], 0, 1), 'C') == 0) {
        $product_type = 'Course';
    } elseif ($listing['products_model'] == '') {
        $product_type = 'Amazon';
    }
    else
        $product_type = 'Standard';

    $link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($listing['products_id'], $listing['products_name']), 'NONSSL', false);

    $linkimage = HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_THUMBNAIL_IMAGES;
    $linkimage .= $listing['products_image'];
    $price = $xtPrice->xtcGetPrice($listing['products_id'], $format = true, 1, $listing['products_tax_class_id'], $listing['products_price'], 1);
    $tax_rate = $xtPrice->TAX[$listing['products_tax_class_id']];
    if ($with_tax)
        $tax_info = sprintf(TAX_INFO_INCL, $tax_rate . '%');
    else
        $tax_info = sprintf(TAX_INFO_ADD, $tax_rate . '%');

    if ($show_shipping)
        $ship_info = ' ' . SHIPPING_EXCL . '<a href="' . xtc_href_link(FILENAME_POPUP_CONTENT, 'coID=' . SHIPPING_INFOS, 'NONSSL', false) . '"> ' . SHIPPING_COSTS . '</a>';

    $products_name = $listing['products_name'];
    $products_name = str_replace("&", "&amp;", $products_name);
    $products_name = str_replace("\n", " ", $products_name);

    echo "\n\n<item>";
    echo "<pubDate>" . date(DATE_RFC822) . "</pubDate>";
    echo "<category>" . $category . "</category>";
    echo "<title>" . $products_name . "</title>";
    echo "<link>" . $link . "</link>";
    echo "<guid>" . $link . "</guid>";
    echo "<description><![CDATA[";
    echo "<table width='90%'>
		<tr>
			<td>
				<table width='100%'>
					<tr>";

    echo "<td width='25%'><a href='" . $link . "'><img src='" . $linkimage . "' alt='" . $products_name . "' border='0'></a></td>
         	<td>
                 	<table align='left'>
                                <tr><td>" . $listing['products_short_description'] . "</td></tr>
                                <tr><td>&nbsp;</td></tr>
                                <tr><td><strong>Preis:  " . $price['formated'] . "</strong> " . $tax_info . $ship_info . "</td></tr>
                         </table>
                 </td>";

    echo "</tr>
     			</table>
     		</td>
     	</tr>
     </table><hr>
     ]]></description>";
    echo "</item>";
}

echo "</channel>";
echo "</rss>";
