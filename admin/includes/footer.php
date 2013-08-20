<?php
/* -----------------------------------------------------------------
 * 	$Id: footer.php 420 2013-06-19 18:04:39Z akausch $
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
?>
</td>
</tr>
</table>
<br /><br />
<div id="footpanel">
    <ul id="mainpanel">
        <li><a href="<?php echo xtc_href_link('start.php', 'subsite=empty'); ?>"><img src="images/icons/home.png" title="Startseite" alt="Startseite"></a></li>
        <li><a href="<?php echo xtc_href_link('orders.php', 'subsite=customers'); ?>"><img src="images/icons/table-money.png" alt="<?php echo HEADER_TITLE_ORDERS ?>" title="<?php echo HEADER_TITLE_ORDERS ?>" /></a></li>
        <li><a href="<?php echo xtc_href_link('customers.php', 'subsite=customers'); ?>"><img src="images/icons/user-black.png" alt="<?php echo HEADER_TITLE_CUTOMERS ?>" title="<?php echo HEADER_TITLE_CUTOMERS ?>" /></a></li>
        <li><a href="<?php echo xtc_href_link('whos_online.php', 'subsite=statistics'); ?>"><img src="images/icons/chart.png" alt="<?php echo HEADER_TITLE_STATISTICS ?>" title="<?php echo HEADER_TITLE_STATISTICS ?>" /></a></li>
        <li><a href="<?php echo xtc_href_link('content_manager.php', 'subsite=tools'); ?>"><img src="images/icons/documents-text.png" alt="<?php echo HEADER_TITLE_CONTENT_MANAGER ?>" title="<?php echo HEADER_TITLE_CONTENT_MANAGER ?>" /></a></li>
        <li><a href="<?php echo xtc_href_link('categories.php', 'subsite=products'); ?>"><img src="images/icons/folders-stack.png" alt="<?php echo HEADER_TITLE_CATEGORIES ?>" title="<?php echo HEADER_TITLE_CATEGORIES ?>" /></a></li>
        <li><a href="<?php echo xtc_href_link(FILENAME_CREDITS, 'subsite=empty') ?>"><img src="images/icons/balloons.png" alt="Credits" title="Credits" /></a></li>
        <!--
                                <li id="searchpanel">
        <?php
        echo xtc_draw_form('orders', FILENAME_ORDERS, '', 'get');
        echo HEADING_TITLE_ORDER . ' ' . xtc_draw_input_field('oID', '', 'size="8"') . xtc_draw_hidden_field('action', 'edit') . xtc_draw_hidden_field(xtc_session_name(), xtc_session_id());
        echo '</form>';
        ?>
        <?php
        echo xtc_draw_form('search', FILENAME_CATEGORIES, '', 'get');
        echo HEADING_TITLE_PRODUKT . ' ' . xtc_draw_input_field('search', '', 'size="8"') . xtc_draw_hidden_field(xtc_session_name(), xtc_session_id());
        echo '</form>';
        ?>
        <?php
        // echo xtc_draw_form('search_email', 'customers.php', '', 'get');
        // echo HEADING_TITLE_EMAIL.' '.xtc_draw_input_field('search_email', '', 'size="8"').xtc_draw_hidden_field(xtc_session_name(), xtc_session_id()); 
        // echo '</form>';
        ?>
        <?php
        echo xtc_draw_form('search', 'customers.php', '', 'get');
        echo HEADING_TITLE_KUNDE . ' ' . xtc_draw_input_field('search', '', 'size="8"') . xtc_draw_hidden_field(xtc_session_name(), xtc_session_id());
        echo '</form>';
        ?>
                                </li>
        -->
        <li id="searchpanel">
            <form name="search" id="search" action="global_search.php" method="POST">
                <div style="position: relative">
                    <input type="text" name="search" value="" size="30" class="mag_text" />
                    <input type="image" src="images/search.png" value="" class="mag" />
                </div>
            </form>
        </li>

    </ul>
</div>

</div>


<?php
/*
  echo ('<b>Session Debug:</b><br />');
  echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";
  echo xtc_session_id();
 */
?>
</body>
</html>