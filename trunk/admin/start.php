<?php
/* -----------------------------------------------------------------
 * 	$Id: start.php 497 2013-07-17 11:00:43Z akausch $
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

$aa = xtc_db_fetch_array(xtc_db_query("SELECT * FROM " . TABLE_ADMIN_ACCESS . " WHERE customers_id = '" . $_SESSION['customer_id'] . "'"));
$cs = $_SESSION['customers_status']['customers_status_id'];

if (($cs == '0') && ($aa['stats_sales_report'] == '1')) {

    $customers = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_CUSTOMERS));
    $customers_gast = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_CUSTOMERS . " WHERE customers_status='1'"));
    $customers_neukunde = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_CUSTOMERS . " WHERE customers_status='2'"));
    $customers_haendler = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_CUSTOMERS . " WHERE customers_status='3'"));
    $customers_rest = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_CUSTOMERS . " WHERE customers_status>'3'"));


    $products = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_PRODUCTS . " WHERE products_status = '1'"));
    $products1 = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_PRODUCTS . " WHERE products_status = '0'"));
    $products2 = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_PRODUCTS . ""));
    $category = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_CATEGORIES . " WHERE categories_status = '1'"));
    $category2 = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_CATEGORIES . " WHERE categories_status = '0'"));

    $orders0 = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_ORDERS . " WHERE orders_status > '3' OR orders_status <= '0'"));
    $orders1 = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_ORDERS . " WHERE orders_status = '1'"));
    $orders2 = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_ORDERS . " WHERE orders_status = '2'"));
    $orders3 = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_ORDERS . " WHERE orders_status = '3'"));
    $specials = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_SPECIALS));

    $datelastyear = date("Y");
    if (date("m") == '01') {
        $datelastmonth = '12';
        $datelastyear = $datelastyear - 1;
    } else {
        $datelastmonth = date("m") - 1;
    }
    $datethismonth = date("m");
    $months = array('1' => '01', '2' => '02', '3' => '03', '4' => '04', '5' => '05', '6' => '06', '7' => '07', '8' => '08', '9' => '09', '10' => '10', '11' => '11', '12' => '12');

    $orders_today = xtc_db_fetch_array(xtc_db_query("SELECT sum(ot.value) FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot WHERE o.date_purchased LIKE '" . date("Y-m-d") . "%' AND ot.orders_id = o.orders_id AND ot.class = 'ot_total' "));
    $orders_yesterday = xtc_db_fetch_array(xtc_db_query("SELECT sum(ot.value) FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot WHERE o.date_purchased LIKE '" . date("Y-m-d", time() - 86400) . "%' AND ot.orders_id = o.orders_id AND ot.class = 'ot_total' "));
    $orders_thismonth = xtc_db_fetch_array(xtc_db_query("SELECT sum(ot.value) FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot WHERE o.date_purchased LIKE '" . date('Y') . "-" . date('m') . "%' AND ot.orders_id = o.orders_id AND ot.class = 'ot_total' "));
    $orders_lastmonth = xtc_db_fetch_array(xtc_db_query("SELECT sum(ot.value) FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot WHERE o.date_purchased LIKE '" . $datelastyear . "-" . $months[$datelastmonth] . "%' AND ot.orders_id = o.orders_id AND ot.class = 'ot_total' "));
    $orders_lastmonth_bereinigt = xtc_db_fetch_array(xtc_db_query("SELECT sum(ot.value) FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot WHERE o.orders_status NOT LIKE 1 AND o.date_purchased LIKE '" . $datelastyear . "-" . $months[$datelastmonth] . "%' AND ot.orders_id = o.orders_id AND ot.class = 'ot_total' "));
    $orders_total = xtc_db_fetch_array(xtc_db_query("SELECT sum(ot.value) FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot WHERE ot.orders_id = o.orders_id AND ot.class = 'ot_total' "));
}

function getDataFromMasterServer() {
    $version = xtc_db_fetch_array(xtc_db_query("SELECT version FROM database_version"));
    $params = 'vnumber=' . urlencode($version['version']);

    if (function_exists('curl_init')) {
        $url = 'http://www.commerce-seo.de/1v2nextcheck.php?' . $params;
        $output = '';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        if (!empty($output))
            return $output;
        else
            return 'Der Server konnte nicht erreicht werden.';
    } elseif (ini_get(allow_url_fopen) !== false && function_exists(file_get_contents)) {
        $data = file_get_contents('http://www.commerce-seo.de/1v2nextcheck.php?' . $params);

        if (!empty($data)) {
            return $data;
        } else {
            return 'Der Server konnte nicht erreicht werden.';
        }
    } else {
        return 'Der Server konnte nicht erreicht werden.';
    }
}

require(DIR_WS_INCLUDES . 'header.php');
?>

<!--<meta http-equiv="refresh" content="180" />-->

<div class="inner">
<?php include(DIR_WS_MODULES . FILENAME_SECURITY_CHECK); ?>
    <?php if (($cs == '0') && ($aa['stats_sales_report'] == '1')) { ?>
        <div class="content w100p">
            <div class="title">
                <div class="titleimg">
                    <img  src="images/admin_icons/chart_pie.png" />
                </div>
                <div class="titlehead">
                    <b>Statistiken:</b>
                </div>
            </div>
            <table width="100%" class="dataTableStart">
                <tr>
                    <td width="25%" valign="top">
                        <table width="100%">
                            <tr>
                                <td style="background:#FCF5DD">Umsatz heute:</td>
                                <td  style="background:#FCF5DD" align="right"> <?php echo number_format($orders_today['sum(ot.value)'], 2); ?>&euro;</td>
                            </tr>
                            <tr>
                                <td style="background:#FCF5DD">Umsatz gestern:</td>
                                <td style="background:#FCF5DD" align="right"><?php echo number_format($orders_yesterday['sum(ot.value)'], 2); ?>&euro;</td>
                            </tr>
                            <tr>
                                <td style="background:#FCF5DD">aktueller Monat:</td>
                                <td style="background:#FCF5DD" align="right"> <?php echo number_format($orders_thismonth['sum(ot.value)'], 2); ?>&euro;</td>
                            </tr>
                            <tr>
                                <td style="background:#F1F1F1">letzter Monat (alle):</td>
                                <td style="background:#F1F1F1" align="right"><?php echo number_format($orders_lastmonth['sum(ot.value)'], 2); ?>&euro;</td>
                            </tr>
                            <tr>
                                <td style="background:#F1F1F1">letzter Monat (bezahlt):</td>
                                <td style="background:#F1F1F1" align="right"><?php echo number_format($orders_lastmonth_bereinigt['sum(ot.value)'], 2); ?>&euro;</td>
                            </tr>
                            <tr>
                                <td style="background:#E8E8E8">Umsatz gesamt:</td>
                                <td style="background:#E8E8E8" align="right"><?php echo number_format($orders_total['sum(ot.value)'], 2); ?>&euro;</td>
                            </tr>
                        </table>
                    </td>
                    <td width="25%" valign="top">
                        <table width="100%" class="dataTableStart">
                            <tr>
                                <td colspan="2"><b>Kunden-Gruppenzuordnung</b></td>
                            </tr>
                            <tr>
                                <td>Kunden gesamt</td>
                                <td  align="center"> <?php echo $customers['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Gast-Kunden:</td>
                                <td  align="center"> <?php echo $customers_gast['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Neu-Kunden:</td>
                                <td  align="center"> <?php echo $customers_neukunde['count']; ?></td>
                            </tr>
                            <tr>
                                <td>H&auml;ndler-Kunden:</td>
                                <td align="center"> <?php echo $customers_haendler['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Restliche Gruppen:</td>
                                <td align="center"><?php echo $customers_rest['count']; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td width="25%" valign="top">
                        <table width="100%" class="dataTableStart">
                            <tr>
                                <td>Aktive Artikel:</td>
                                <td align="center"> <?php echo $products['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Inaktive Artikel:</td>
                                <td align="center"> <?php echo $products1['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Artikel gesamt:</td>
                                <td align="center"><?php echo $products2['count'] ?></td>
                            </tr>
                            <tr>
                                <td>Aktive Kategorien:</td>
                                <td align="center"><?php echo $category['count'] ?></td>
                            </tr>
                            <tr>
                                <td>Inaktive Kategorien:</td>
                                <td align="center"><?php echo $category2['count'] ?></td>
                            </tr>
                            <tr>
                                <td>Sonderangebote:</td>
                                <td align="center"><?php echo $specials['count']; ?></td>
                            </tr>
                        </table>
                    </td>
                    <td width="25%" valign="top">
                        <table width="100%" class="dataTableStart">
                            <tr>
                                <td colspan="2"><b>Bestellungen nach Status</b></td>
                            </tr>
                            <tr>
                                <td>Offen</td>
                                <td align="center"><?php echo $orders1['count']; ?></td>
                            </tr>
                            <tr>
                                <td>In Bearbeitung</td>
                                <td align="center"><?php echo $orders2['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Versendet</td>
                                <td align="center"><?php echo $orders3['count']; ?></td>
                            </tr>
                            <tr>
                                <td>Weitere</td>
                                <td align="center"><?php echo $orders0['count']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
<?php } ?>
    <?php if (ADMIN_CSEO_START_WHOISONLINE == 'true') { ?>
        <div class="content w100p">
            <div class="title">
                <div class="titleimg">
                    <img  src="images/admin_icons/Chart-Pie.png" />
                </div>
                <div class="titlehead">
                    <b>Besucher:</b>
                </div>
            </div>

            <table class="dataTableStart" width="100%">
                <tr class="dataTableStartHeadingRow">
                    <th class="dataTableStartHeadingContent" height="20" width="25%">Online seit (min.)</th>
                    <th class="dataTableStartHeadingContent" height="20" width="23%">Name</th>
                    <th class="dataTableStartHeadingContent" align="center" height="20" width="20%">Letzter Klick</th>
                    <th class="dataTableStartHeadingContent" align="center" width="20%">letzte Seite</th>
                    <th class="dataTableStartHeadingContent last" align="center" height="20" width="33%">Infos</th>
                </tr>
    <?php
    $whos_online_query = xtc_db_query("SELECT customer_id, full_name, ip_address, time_entry, time_last_click, last_page_url, session_id FROM " . TABLE_WHOS_ONLINE . " ORDER BY time_last_click desc LIMIT 10");
    $rows = 1;
    while ($whos_online = xtc_db_fetch_array($whos_online_query)) {
        $time_online = (time() - $whos_online['time_entry']);
        if (((!$_GET['info']) || (@$_GET['info'] == $whos_online['session_id'])) && (!$info)) {
            $info = $whos_online['session_id'];
        }
        if ($rows % 2 == 0)
            $f = 'dataTableStartRow';
        else
            $f = '';
        ?>
                    <tr class="<?php echo $f; ?>" onmouseover="this.className = 'dataTableStartRowOver'" onmouseout="this.className = '<?php echo $f; ?>'">
                        <td class="dataTableStartContent" width="25%" height="22px" align="center">
                            <a href="whos_online.php?info=<?php echo $whos_online['session_id']; ?>">
        <?php echo gmdate('H:i:s', $time_online); ?>
                            </a>
                        </td>
                        <td class="dataTableStartContent" width="33%">
                            <a href="whos_online.php?info=<?php echo $whos_online['session_id']; ?>">
        <?php echo $whos_online['full_name']; ?>
                            </a>
                        </td>
                        <td class="dataTableStartContent" align="center" width="30%">
                            <a href="whos_online.php?info=<?php echo $whos_online['session_id']; ?>">
        <?php echo date('H:i:s', $whos_online['time_last_click']); ?>
                            </a>
                        </td>
                        <td class="dataTableStartContent" align="center" width="20%">
        <?php echo $whos_online['last_page_url']; ?>
                        </td>
                        <td class="dataTableStartContent last" align="center" width="33%">
                            <a href="whos_online.php?info=<?php echo $whos_online['session_id']; ?>"><img src="images/icons/preview.gif" title="View" /></a>
                        </td>
                    </tr>

        <?php $rows++;
    } ?>
            </table>
        </div>
    <?php } ?>
    <?php if (ADMIN_CSEO_START_ORDERS == 'true') { ?>
        <div class="content w100p">
            <div class="title">
                <div class="titleimg">
                    <img  src="images/admin_icons/User.png" />
                </div>
                <div class="titlehead">
                    <b>Kunden:</b>
                </div>
            </div>
            <table width="100%" class="dataTableStart" >
                <tr>
                    <td width="50%" valign="top">
                        <table width="100%">
                            <tr class="dataTableStartHeadingRow">
                                <th class="dataTableStartHeadingContent" height="20" width="25%">Name</td>
                                <th class="dataTableStartHeadingContent" height="20" width="25%">Vorname</td>
                                <th class="dataTableStartHeadingContent" align="center" height="20" width="25%">angemeldet am</td>
                                <th class="dataTableStartHeadingContent" align="center" height="20" width="12%">bearbeiten</td>
                                <th class="dataTableStartHeadingContent last" align="center" height="20" width="12%">Bestellungen</td>
                            </tr>
                            <?php
                            $ergebnis = xtc_db_query("SELECT * FROM customers ORDER BY customers_date_added DESC LIMIT 15");
                            $rows = 1;
                            while ($row = xtc_db_fetch_array($ergebnis)) {
                                if ($rows % 2 == 0) {
                                    $f = 'dataTableStartRow';
                                } else {
                                    $f = '';
                                }
                                ?>
                                <tr class="<?php echo $f; ?>" onmouseover="this.className = 'dataTableStartRowOver'" onmouseout="this.className = '<?php echo $f; ?>'">
                                    <td class="dataTableStartContent" width="25%" height="22px">
                                        <?php echo $row['customers_lastname']; ?>
                                    </td>
                                    <td class="dataTableStartContent" width="25%">
                                        <?php echo $row['customers_firstname']; ?>
                                    </td>
                                    <td class="dataTableStartContent" align="center" width="25%">
                                        <?php echo $row['customers_date_added']; ?>
                                    </td>
                                    <td class="dataTableStartContent" align="center" width="12%">
                                        <a href="customers.php?page=1&cID=<?php echo $row['customers_id']; ?>&action=edit"><img src="images/icons/pencil.png" title="Edit" /></a>
                                    </td>
                                    <td class="dataTableStartContent last" align="center" width="12%">
                                        <a href="orders.php?cID=<?php echo $row['customers_id']; ?>"><img src="images/icons/preview.gif" title="View" /></a>
                                    </td>
                                </tr>
                                <?php $rows++;
                            } ?>
                        </table>
                    </td>
                    <td width="50%" valign="top">
                        <table class="dataTableStart" width="100%">
                            <tr class="dataTableStartHeadingRow">
                                <th class="dataTableStartHeadingContent" height="20" width="10%">Best-Nr.</td>
                                <th class="dataTableStartHeadingContent" height="20" width="25%">Bestelldatum</td>
                                <th class="dataTableStartHeadingContent" align="center" height="20" width="25%"> Kundenname</td>
                                <th class="dataTableStartHeadingContent" align="center" height="20" width="15%"> Gesamt</td>
                                <th class="dataTableStartHeadingContent" align="center" height="20" width="12%">bearbeiten</td>
                                <th class="dataTableStartHeadingContent last" align="center" height="20" width="12%">l&ouml;schen</td>
                            </tr>
                            <?php
                            $ergebnis = xtc_db_query("SELECT * FROM orders ORDER BY orders_id DESC LIMIT 20");
                            $rows = 1;
                            while ($row = xtc_db_fetch_array($ergebnis)) {
                                if ($rows % 2 == 0) {
                                    $f = 'dataTableStartRow';
                                } else {
                                    $f = '';
                                }
                                $preis = xtc_db_fetch_array(xtc_db_query("SELECT text FROM orders_total WHERE orders_id = '" . $row['orders_id'] . "' AND class = 'ot_total' "));
                                ?>
                                <tr class="<?php echo $f; ?>" onmouseover="this.className = 'dataTableStartRowOver'" onmouseout="this.className = '<?php echo $f; ?>'">
                                    <td class="dataTableStartContent" width="10%" align="center">
                                        <?php echo $row['orders_id']; ?>
                                    </td>
                                    <td class="dataTableStartContent" width="25%" height="22px">
                                        <?php echo $row['date_purchased']; ?>
                                    </td>
                                    <td class="dataTableStartContent" align="left" width="25%">
                                        <?php echo $row['delivery_name']; ?>
                                    </td>
                                    <td class="dataTableStartContent" width="25%" align="right">
                                        <?php echo $preis['text']; ?>
                                    </td>
                                    <td class="dataTableStartContent" align="center" width="12%">
                                        <a href="orders.php?page=1&oID=<?php echo $row['orders_id']; ?>&action=edit"><img src="images/icons/pencil.png" title="Edit" /></a>
                                    </td>
                                    <td class="dataTableStartContent last" align="center" width="12%">
                                        <a href="orders.php?page=1&oID=<?php echo $row['orders_id']; ?>&action=delete"><img src="images/icons/icon_delete.png" title="Delete" /></a>
                                    </td>
                                </tr>
                                <?php $rows++;
                            } ?>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    <?php } ?>
<?php if (ADMIN_CSEO_START_BIRTHDAY == 'true') { ?>

        <div class="content w100p">
            <div class="title">
                <div class="titleimg">
                    <img  src="images/admin_icons/clock.png" />
                </div>
                <div class="titlehead">
                    <b>Geburtstage:</b>
                </div>
            </div>
        <?php require(DIR_WS_INCLUDES . 'classes/start/geburtstag.php'); ?>
        </div>
    <?php } ?>

        <div class="content w100p">
            <div class="title">
                <div class="titleimg">
                    <img  src="images/admin_icons/Info.png" />
                </div>
                <div class="titlehead">
                    <b>v2next Information:</b>
                </div>
            </div>
            <table width="100%" class="dataTableStart">
                <tr>
                    <td>
						<!--BOF - Barzahlen - 2013-05-17: Barzahlen Version Check-->
						<?php include(DIR_WS_MODULES . "barzahlen_version_check.php"); ?>
						<!--EOF - Barzahlen - 2013-05-17: Barzahlen Version Check-->
						<?php echo getDataFromMasterServer(); ?>
                    </td>
                </tr>
            </table>
        </div>
    <br class="clear" />
</div>
<br />
&copy; 2013 <a href="http://www.commerce-seo.de" target="_blank">commerce:SEO</a> ein Projekt von Webdesign Erfurt, based on xt:Commerce <a rel="nofollow" href="http://www.fsf.org/licenses/gpl.txt" target="_blank">GNU General Public License</a>
<br />
<br />
<?php
require(DIR_WS_INCLUDES . 'footer.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
