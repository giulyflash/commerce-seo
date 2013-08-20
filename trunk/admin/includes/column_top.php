<?php
/* -----------------------------------------------------------------
 * 	$Id: column_top.php 483 2013-07-15 13:03:19Z akausch $
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

function linkCheck($link) {
    if ($_SESSION['subsite'] == $link) {
        return ' top_link_active';
    } else {
        return false;
    }
}

$p = explode('.', $current_page);
$p = $p[0];
?>

<div class="topNav">
    <div class="topNavleft" id="menu">
        <ul>
            <li>
                <a href="<?php echo xtc_href_link('start.php', 'subsite=empty'); ?>"><img src="images/admin_icons/home.png" /></a>
            </li>
            <!-- Produkte -->
            <li>
                <a href="<?php echo xtc_href_link(FILENAME_CATEGORIES); ?>"><?php echo PRODUCTS ?></a>			
                <ul>
                    <?php
                    $navi_products_sql = xtc_db_query("SELECT 
															* 
														FROM 
															" . TABLE_ADMIN_NAVIGATION . " AS an
														LEFT JOIN 
															" . TABLE_ADMIN_ACCESS . " AS ac ON(customers_id = '" . (int) $_SESSION['customer_id'] . "' AND an.name = '1')
														WHERE 
															subsite = 'products' 
														AND 
															an.languages_id = '" . (int) $_SESSION['languages_id'] . "' 
														ORDER BY an.sort");
                    while ($navi = xtc_db_fetch_array($navi_products_sql)) {
                        if ($navi['gid'] == '') {
                            echo '<li><a ' . ($p == $navi['name'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        } elseif ($navi['gid'] != '') {
                            echo '<li><a ' . ($_GET['gID'] == $navi['gid'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename'], 'gID=' . $navi['gid']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </li>
            <!-- Kunden -->
            <li>
                <?php
                $order_count = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_ORDERS . " WHERE orders_status = '1'"));
                ?>
                <a href="<?php echo xtc_href_link('orders.php'); ?>"><span><?php echo CUSTOMERS ?></span></a>
                <?php
                if ($order_count['count'] > 0) {
                    echo '<b class="numberRed">' . $order_count['count'] . '</b>';
                }
                ?>
                <ul>
                    <?php
                    $navi_products_sql = xtc_db_query("SELECT 
															* 
														FROM 
															" . TABLE_ADMIN_NAVIGATION . " AS an
														LEFT JOIN 
															" . TABLE_ADMIN_ACCESS . " AS ac ON(customers_id = '" . (int) $_SESSION['customer_id'] . "' AND an.name = '1')
														WHERE 
															subsite = 'customers' 
														AND 
															an.languages_id = '" . (int) $_SESSION['languages_id'] . "' 
														ORDER BY an.sort");
                    while ($navi = xtc_db_fetch_array($navi_products_sql)) {
                        if ($navi['gid'] == '') {
                            echo '<li><a ' . ($p == $navi['name'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        } elseif ($navi['gid'] != '') {
                            echo '<li><a ' . ($_GET['gID'] == $navi['gid'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename'], 'gID=' . $navi['gid']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        }
                    }
                    ?>
                </ul>

            </li>
            <!-- Module -->
            <li>
                <a href="<?php echo xtc_href_link(FILENAME_MODULES, 'set=payment'); ?>"><span><?php echo MODULES ?></span></a>
                <ul>
                    <?php
                    $navi_products_sql = xtc_db_query("SELECT 
															* 
														FROM 
															" . TABLE_ADMIN_NAVIGATION . " AS an
														LEFT JOIN 
															" . TABLE_ADMIN_ACCESS . " AS ac ON(customers_id = '" . (int) $_SESSION['customer_id'] . "' AND an.name = '1')
														WHERE 
															subsite = 'modules' 
														AND 
															an.languages_id = '" . (int) $_SESSION['languages_id'] . "' 
														ORDER BY an.sort");
                    while ($navi = xtc_db_fetch_array($navi_products_sql)) {
                        if ($navi['nav_set'] == '') {
                            echo '<li><a ' . ($p == $navi['name'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        } elseif ($navi['nav_set'] != '') {
                            echo '<li><a ' . ($_GET['set'] == $navi['nav_set'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename'], 'set=' . $navi['nav_set']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </li>			
            <!-- Gutscheine -->
<?php if (ACTIVATE_GIFT_SYSTEM == 'true') { ?>
                <li>
                    <a href="<?php echo xtc_href_link(FILENAME_COUPON_ADMIN); ?>"><span><?php echo GIFT; ?></span></a>
                    <ul>
                        <?php
                        $navi_products_sql = xtc_db_query("SELECT 
															* 
														FROM 
															" . TABLE_ADMIN_NAVIGATION . " AS an
														LEFT JOIN 
															" . TABLE_ADMIN_ACCESS . " AS ac ON(customers_id = '" . (int) $_SESSION['customer_id'] . "' AND an.name = '1')
														WHERE 
															subsite = 'gift' 
														AND 
															an.languages_id = '" . (int) $_SESSION['languages_id'] . "' 
														ORDER BY an.sort");
                        while ($navi = xtc_db_fetch_array($navi_products_sql)) {
                            if ($navi['nav_set'] == '') {
                                echo '<li><a ' . ($p == $navi['name'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                            }
                        }
                        ?>
                    </ul>
                </li>
<?php } ?>
            <!-- Statistik -->
            <li>
                <?php
                $who_count = xtc_db_fetch_array(xtc_db_query("SELECT COUNT(*) as count FROM " . TABLE_WHOS_ONLINE));
                ?>
                <a href="<?php echo xtc_href_link('whos_online.php'); ?>"><span><?php echo HEADER_TITLE_STATISTICS ?></span></a>
                <?php
                echo '<b class="numberGreen">' . $who_count['count'] . '</b>';
                ?>
                <ul>
                    <?php
                    $navi_products_sql = xtc_db_query("SELECT 
															* 
														FROM 
															" . TABLE_ADMIN_NAVIGATION . " AS an
														LEFT JOIN 
															" . TABLE_ADMIN_ACCESS . " AS ac ON(customers_id = '" . (int) $_SESSION['customer_id'] . "' AND an.name = '1')
														WHERE 
															subsite = 'statistics' 
														AND 
															an.languages_id = '" . (int) $_SESSION['languages_id'] . "' 
														ORDER BY an.sort");
                    while ($navi = xtc_db_fetch_array($navi_products_sql)) {
                        if ($navi['nav_set'] == '') {
                            echo '<li><a ' . ($p == $navi['name'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </li>
            <!-- Tools -->
            <li>
                <a href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER); ?>"><span><?php echo TOOLS ?></span></a>
                <ul>
                    <?php
                    $navi_products_sql = xtc_db_query("SELECT 
															* 
														FROM 
															" . TABLE_ADMIN_NAVIGATION . " AS an
														LEFT JOIN 
															" . TABLE_ADMIN_ACCESS . " AS ac ON(customers_id = '" . (int) $_SESSION['customer_id'] . "' AND an.name = '1')
														WHERE 
															subsite = 'tools' 
														AND 
															an.languages_id = '" . (int) $_SESSION['languages_id'] . "' 
														ORDER BY an.sort");
                    while ($navi = xtc_db_fetch_array($navi_products_sql)) {
                        if ($navi['nav_set'] == '') {
                            echo '<li><a ' . ($p == $navi['name'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </li>
            <!-- SEO Config -->
            <li>
                <a href="<?php echo xtc_href_link(FILENAME_CONFIGURATION, 'gID=155'); ?>"><span>Einstellungen</span></a>			
                <ul>
                    <?php
                    $navi_products_sql = xtc_db_query("SELECT 
															* 
														FROM 
															" . TABLE_ADMIN_NAVIGATION . " AS an
														LEFT JOIN 
															" . TABLE_ADMIN_ACCESS . " AS ac ON(customers_id = '" . (int) $_SESSION['customer_id'] . "' AND an.name = '1')
														WHERE 
															subsite = 'seo_config' 
														AND 
															an.languages_id = '" . (int) $_SESSION['languages_id'] . "' 
														ORDER BY an.sort");
                    while ($navi = xtc_db_fetch_array($navi_products_sql)) {
                        if ($navi['gid'] == '') {
                            echo '<li><a ' . ($p == $navi['name'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        } elseif ($navi['gid'] != '') {
                            echo '<li><a ' . ($_GET['gID'] == $navi['gid'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename'], 'gID=' . $navi['gid']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </li>
            <!-- Country Config -->
            <li>
                <a href="<?php echo xtc_href_link(FILENAME_LANGUAGES); ?>"><span><?php echo COUNRTY ?></span></a>			
                <ul>
                    <?php
                    $navi_products_sql = xtc_db_query("SELECT 
															* 
														FROM 
															" . TABLE_ADMIN_NAVIGATION . " AS an
														LEFT JOIN 
															" . TABLE_ADMIN_ACCESS . " AS ac ON(customers_id = '" . (int) $_SESSION['customer_id'] . "' AND an.name = '1')
														WHERE 
															subsite = 'zones' 
														AND 
															an.languages_id = '" . (int) $_SESSION['languages_id'] . "' 
														ORDER BY an.sort");
                    while ($navi = xtc_db_fetch_array($navi_products_sql)) {
                        if ($navi['gid'] == '') {
                            echo '<li><a ' . ($p == $navi['name'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        } elseif ($navi['gid'] != '') {
                            echo '<li><a ' . ($_GET['gID'] == $navi['gid'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename'], 'gID=' . $navi['gid']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </li>
            <!-- Config -->
            <li>
                <a href="<?php echo xtc_href_link(FILENAME_CONFIGURATION, 'gID=1'); ?>"><span><?php echo CONFIG ?></span></a>			
                <ul>
                    <?php
                    $navi_products_sql = xtc_db_query("SELECT 
															* 
														FROM 
															" . TABLE_ADMIN_NAVIGATION . " AS an
														LEFT JOIN 
															" . TABLE_ADMIN_ACCESS . " AS ac ON(customers_id = '" . (int) $_SESSION['customer_id'] . "' AND an.name = '1')
														WHERE 
															subsite = 'config' 
														AND 
															an.languages_id = '" . (int) $_SESSION['languages_id'] . "' 
														ORDER BY an.sort");
                    while ($navi = xtc_db_fetch_array($navi_products_sql)) {
                        if ($navi['gid'] == '') {
                            echo '<li><a ' . ($p == $navi['name'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        } elseif ($navi['gid'] != '') {
                            echo '<li><a ' . ($_GET['gID'] == $navi['gid'] ? 'class="menu_link_aktiv"' : '') . ' href="' . xtc_href_link($navi['filename'], 'gID=' . $navi['gid']) . '" class="menuBoxContentLink">' . $navi['title'] . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </li>
        </ul>
    </div>
    <div class="topNavright">
        <?php
        $languages = xtc_get_languages_head();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++)
            echo '<a href="' . basename($_SERVER['SCRIPT_NAME']) . '?language=' . $languages[$i]['code'] . '">' . xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/' . $languages[$i]['image'], $languages[$i]['name']) . '</a> ';
        ?>
    </div>
</div>
