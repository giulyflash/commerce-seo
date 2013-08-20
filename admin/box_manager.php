<?php
/* -----------------------------------------------------------------
 * 	$Id: box_manager.php 486 2013-07-15 22:08:14Z akausch $
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

$query = xtc_db_query("SELECT code FROM " . TABLE_LANGUAGES . " WHERE languages_id='" . (int) $_SESSION['languages_id'] . "'");
$data = xtc_db_fetch_array($query);
$languages = xtc_get_languages();

if ((isset($_POST['action'])) && ($_POST['action'] == 'save')) {

    $box_position = xtc_db_prepare_input($_POST['box_position']);
    $box_sort_id = xtc_db_prepare_input($_POST['box_sort_id']);
    $box_status = xtc_db_prepare_input($_POST['box_status']);
    $box_name_status = xtc_db_prepare_input($_POST['box_name_status']);
    $name = xtc_db_prepare_input($_POST['name']);

    $db_box = xtc_db_query("UPDATE boxes SET position = '" . $box_position . "', sort_id = '" . $box_sort_id . "', status = '" . $box_status . "' WHERE box_name = '" . $name . "'  ");

    $box_name = xtc_db_prepare_input($_POST['box_name']);
    foreach ($languages AS $lang) {
        foreach ($box_name[$lang['id']] AS $box) {
            if (!empty($box)) {
                $db = xtc_db_query("UPDATE boxes_names SET box_title = '" . trim($box) . "', status = '" . $box_name_status . "' WHERE language_id = '" . $lang['id'] . "' AND box_name = '" . $name . "' ");
            }
        }
    }


    xtc_redirect(xtc_href_link('box_manager.php'));
    exit();
} elseif (isset($_GET['set_flag']) && (!empty($_GET['set_flag']))) {
    $box_status = xtc_db_prepare_input($_GET['status']);
    $db_box = xtc_db_query("UPDATE boxes SET status = '" . $box_status . "' WHERE box_name = '" . $_GET['set_flag'] . "'  ");

    xtc_redirect(xtc_href_link('box_manager.php'));
    exit();
} elseif (isset($_GET['set_name_flag']) && (!empty($_GET['set_name_flag']))) {
    $box_status = xtc_db_prepare_input($_GET['status']);
    $db_box = xtc_db_query("UPDATE boxes_names SET status = '" . $box_status . "' WHERE box_name = '" . $_GET['set_name_flag'] . "'  ");

    xtc_redirect(xtc_href_link('box_manager.php'));
    exit();
} elseif (isset($_GET['delete']) && (!empty($_GET['delete']))) {
    xtc_db_query("DELETE FROM boxes WHERE box_name = '".$_GET['delete']."' AND box_type != 'file' ");
    // xtc_db_query("DELETE FROM boxes WHERE box_name = '" . $_GET['delete'] . "'");
    xtc_db_query("DELETE FROM boxes_names WHERE box_name = '" . $_GET['delete'] . "' ");
    xtc_redirect(xtc_href_link('box_manager.php'));
    exit();
} elseif ((isset($_POST['save'])) && (($_POST['save'] == 'new_box') || $_POST['save'] == 'edit_new_box')) {

    if ($_POST['save'] == 'new_box') {
        $sql_data_array = array('id' => '',
            'box_name' => xtc_db_prepare_input($_POST['box_int_name']),
            'position' => xtc_db_prepare_input($_POST['box_position']),
            'sort_id' => xtc_db_prepare_input($_POST['box_sort_id']),
            'status' => xtc_db_prepare_input($_POST['box_status']),
            'box_type' => 'database',
            'file_flag' => 0);
        xtc_db_perform('boxes', $sql_data_array);
    } elseif ($_POST['save'] == 'edit_new_box') {
        $sql_data_array = array('position' => xtc_db_prepare_input($_POST['box_position']),
            'sort_id' => xtc_db_prepare_input($_POST['box_sort_id']),
            'status' => xtc_db_prepare_input($_POST['box_status']));
        xtc_db_perform('boxes', $sql_data_array, 'update', 'box_name = \'' . $_POST['name'] . '\'');
    }

    foreach ($languages AS $lang) {
        $language_id = $lang['id'];
        if ($_POST['save'] == 'new_box') {
            $insert_data_array = array('id' => '',
                'box_name' => xtc_db_prepare_input($_POST['box_int_name']),
                'box_title' => xtc_db_prepare_input($_POST['box_title_' . $language_id]),
                'box_desc' => xtc_db_prepare_input($_POST['new_box_' . $language_id]),
                'language_id' => $language_id,
                'status' => xtc_db_prepare_input($_POST['box_name_status']));

            xtc_db_perform('boxes_names', $insert_data_array);
        } elseif ($_POST['save'] == 'edit_new_box') {
            $update_data_array = array('box_title' => xtc_db_prepare_input($_POST['box_title_' . $language_id]),
                'box_desc' => xtc_db_prepare_input($_POST['new_box_' . $language_id]),
                'language_id' => $language_id,
                'status' => xtc_db_prepare_input($_POST['box_name_status']));
            xtc_db_perform('boxes_names', $update_data_array, 'update', 'box_name = \'' . $_GET['name'] . '\' and language_id = \'' . $language_id . '\'');
        }
    }
    xtc_redirect(xtc_href_link('box_manager.php'));
    exit();
} elseif (isset($_POST['filter']) && ($_POST['filter'] == 'boxes')) {
    $sql_where = '';
    $sql_order_by = '';

    if ($_POST['name_int'] == 'asc') {
        $sql_order_by = " ORDER BY b.box_name ASC";
    } elseif ($_POST['name_int'] == 'desc') {
        $sql_order_by = " ORDER BY b.box_name DESC";
    }
    if ($_POST['box_status'] == 'on') {
        $sql_where .= " AND b.status = '1'";
    } elseif ($_POST['box_status'] == 'off') {
        $sql_where .= " AND b.status = '0'";
    }
    if ($_POST['name'] == 'asc') {
        $sql_order_by = " ORDER BY bn.box_title ASC";
    } elseif ($_POST['name'] == 'desc') {
        $sql_order_by = " ORDER BY bn.box_title DESC";
    }
    if (!empty($_POST['position'])) {
        $sql_where .= " AND b.position = '" . $_POST['position'] . "'";
    }
    if ($_POST['box_name'] == 'on') {
        $sql_where .= " AND bn.status = '1'";
    } elseif ($_POST['box_name'] == 'off') {
        $sql_where .= " AND bn.status = '0'";
    }
}

if ($sql_order_by == '')
    $sql_order_by = " ORDER BY position,sort_id ASC";

$position_query = xtc_db_query("SELECT id, position_name FROM boxes_positions order by id");
$position_array = array(array('id' => '', 'text' => '------'));
while ($pos = xtc_db_fetch_array($position_query)) {
    $position_array[] = array('id' => $pos['position_name'], 'text' => $pos['position_name']);
}

$status = array(array('id' => '0', 'text' => '----'));
$status[] = array('id' => 'on', 'text' => YES);
$status[] = array('id' => 'off', 'text' => NO);

$box_name = array(array('id' => '', 'text' => '-----------'));
$box_name[] = array('id' => 'asc', 'text' => 'Alphabet A-Z');
$box_name[] = array('id' => 'desc', 'text' => 'Alphabet Z-A');

require(DIR_WS_INCLUDES . 'header.php');
if (USE_WYSIWYG == 'true') {
?>
<script src="includes/editor/ckeditor/ckeditor.js" type="text/javascript"></script>
<?php
if (file_exists('includes/editor/ckfinder/ckfinder.js')) {
    echo '<script src="includes/editor/ckfinder/ckfinder.js" type="text/javascript"></script>';
}
}
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="3">
            <table class="table_pageHeading" border="0" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="pageHeading">Boxen Manager</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left">
            <?php if ((!isset($_GET['action'])) && ($_GET['action'] != 'edit_box')) { ?>
                <script type="text/javascript">
                    <!--
                        function changeFlag(box_id) {
                        jQuery.ajax({
                            type: "POST",
                            url: "includes/javascript/box_manager_change_flag.php",
                            data: {'id': box_id},
                            dataType: "html",
                            success: function(msg) {
                                jQuery('#box_' + box_id).html(msg).fadeIn("slow");
                                jQuery(location).attr("hash", jQuery(this).attr("hash"));
                            }
                        });
                        return false;
                    }
                    ;
                    //-->
                </script>
                <form method="POST" action="box_manager.php" name="sort_boxes">
                    <table cellpadding="8" cellspacing="8" width="100%">
                        <tr>
                            <td><strong>Filter</strong></td>
                            <td>Box Name: <?php echo xtc_draw_pull_down_menu('name', $box_name, $_POST['name'], 'onchange="this.form.submit();"'); ?></td>
                            <td>interne Bez.: <?php echo xtc_draw_pull_down_menu('name_int', $box_name, $_POST['name_int'], 'onchange="this.form.submit();"'); ?></td>
                            <td>Position: <?php echo xtc_draw_pull_down_menu('position', $position_array, $_POST['position'], 'onchange="this.form.submit();"'); ?></td>
                            <td>Box aktiv: <?php echo xtc_draw_pull_down_menu('box_status', $status, $_POST['box_status'], 'onchange="this.form.submit();"'); ?></td>
                            <td>Name aktiv: <?php echo xtc_draw_pull_down_menu('box_name', $status, $_POST['box_name'], 'onchange="this.form.submit();"'); ?></td>
                            <td align="center" style="padding:8px 0"><a class="button" href="box_manager.php?action=new_box">neue Box</a></td>
                        </tr>
                    </table>
                    <input type="hidden" name="filter" value="boxes" />
                </form>
                <table class="dataTable" width="100%">
                    <tr class="dataTableHeadingRow">
                        <th class="dataTableHeadingContent" height="20" width="5%">&nbsp;</th>
                        <th class="dataTableHeadingContent" align="left" width="30%">Boxen Name</th>
                        <th class="dataTableHeadingContent" align="left" width="15%">interne Bezeichnung</th>
                        <th class="dataTableHeadingContent" align="center" width="10%">Position</th>
                        <th class="dataTableHeadingContent" align="center" width="10%">Sortierung</th>
                        <th class="dataTableHeadingContent" align="center" width="10%">Box aktiv?</th>
                        <th class="dataTableHeadingContent" align="center" width="10%">Titel aktiv?</th>
                        <th class="dataTableHeadingContent" align="center" width="5%">Typ</th>
                        <th class="dataTableHeadingContent" align="center" width="5%">Delete</th>
                    </tr>
                    <?php
                    $uebersicht_query = xtc_db_query("SELECT b.id AS bid,
															bn.id AS bnid,
															b.box_name,
															b.position,
															b.sort_id,
															b.box_type,
															b.status AS box,
															bn.status AS bname,
															bn.box_title
															FROM boxes b,
															boxes_names bn
															WHERE bn.box_name = b.box_name
															AND bn.language_id = '" . (int) $_SESSION['languages_id'] . "'
															" . $sql_where . "
															" . $sql_order_by . " ");

                    $i = 1;
                    while ($box = xtc_db_fetch_array($uebersicht_query)) {
                        if ($i % 2 == 0)
                            $f = 'dataTableRow';
                        else
                            $f = '';
                        ?>
                        <tr class="<?php echo (($i % 2 == 0) ? 'dataTableRow' : 'dataWhite'); ?>">
                            <td align="center">
                                <?php
                                if ($box['box_type'] == 'database') {
                                    echo '<a href="' . xtc_href_link('box_manager.php', 'action=edit_new_box&name=' . $box['box_name']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_edit.gif') . '</a>';
                                } else {
                                    echo '<a href="' . xtc_href_link('box_manager.php', 'action=edit_box&name=' . $box['box_name']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_edit.gif') . '</a>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo '<strong>' . $box['box_title'] . '</strong>'; ?>
                            </td>
                            <td>
                                <?php echo $box['box_name']; ?>
                            </td>
                            <td align="center" valign="middle">
                                <?php echo $box['position'] ?>
                            </td>
                            <td align="center" valign="middle">
                                <?php echo $box['sort_id'] ?>
                            </td>
                            <td align="center" valign="middle" id="box_bs_<?php echo $box['bid']; ?>">
                                <?php
                                if ($box['box'] == 1) {
                                    echo '<img src="' . DIR_WS_IMAGES . 'icon_status_green.gif" alt="" height="10" title="" />';
                                    echo '<a class="box_flag" id="bs_' . $box['bid'] . '" href="javascript:void(0)" onclick="javascript:changeFlag(this.id);"><img src="' . DIR_WS_IMAGES . 'icon_status_red_light.gif" height="10" alt="" title="deaktivieren" /></a>';
                                } else {
                                    echo '<a class="box_flag" id="bs_' . $box['bid'] . '" height="10" href="javascript:void(0)" onclick="javascript:changeFlag(this.id);"><img src="' . DIR_WS_IMAGES . 'icon_status_green_light.gif" alt="" height="10" title="aktivieren" /></a> ';
                                    echo xtc_image(DIR_WS_IMAGES . 'icon_status_red.gif', '', '10');
                                }
                                ?>
                            </td>
                            <td class="last" align="center" valign="middle" id="box_bn_<?php echo $box['bnid']; ?>">
                                <?php
                                if ($box['bname'] == 1) {
                                    echo xtc_image(DIR_WS_IMAGES . 'icon_status_green.gif', '', '10') . ' ';
                                    echo ' <a class="box_flag" id="bn_' . $box['bnid'] . '" href="javascript:void(0)" onclick="javascript:changeFlag(this.id);"><img src="' . DIR_WS_IMAGES . 'icon_status_red_light.gif" height="10" alt="" title="deaktivieren" /></a>';
                                } else {
                                    echo '<a class="box_flag" id="bn_' . $box['bnid'] . '" href="javascript:void(0)" onclick="javascript:changeFlag(this.id);"><img src="' . DIR_WS_IMAGES . 'icon_status_green_light.gif" height="10" alt="" title="aktivieren" /></a> ';
                                    echo xtc_image(DIR_WS_IMAGES . 'icon_status_red.gif', '', '10');
                                }
                                ?>
                            </td>
                            <td class="last" align="center">
                                <?php
                                if ($box['box_type'] == 'file') {
                                    echo '<img src="' . DIR_WS_IMAGES . 'icons/icon_file.gif" alt="" title="Datei" />';
                                } else {
                                    echo '<img src="' . DIR_WS_IMAGES . 'icons/icon_database.gif" alt="" title="Datenbank" /> ';
                                }
                                ?>
                            </td>
                            <td class="last" align="center">
                                <?php
                                if ($box['box_type'] == 'file') {
                                    // echo '<a href="' . $_SERVER['REQUEST_URI'] . '?delete=' . $box['box_name'] . '"><img src="' . DIR_WS_IMAGES . 'delete.gif" alt="" title="Box l&ouml;schen" /></a>';
                                } else {
                                    echo '<a href="' . $_SERVER['REQUEST_URI'] . '?delete=' . $box['box_name'] . '"><img src="' . DIR_WS_IMAGES . 'delete.gif" alt="" title="Box l&ouml;schen" /></a>';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php $i++;
                    }
                    ?>
                </table>
                <?php
            } elseif ((isset($_GET['action'])) && (($_GET['action'] == 'new_box') || ($_GET['action'] == 'edit_new_box'))) {

                $dd[] = array('id' => '1', 'text' => YES);
                $dd[] = array('id' => '0', 'text' => NO);

                $positions_query = xtc_db_query("SELECT id, position_name FROM boxes_positions order by id");
                while ($pos = xtc_db_fetch_array($positions_query, true))
                    $positions_array[] = array('id' => $pos['position_name'], 'text' => $pos['position_name']);

                if ($_GET['action'] == 'edit_new_box') {
                    $new_box_query = xtc_db_query("SELECT b.id, b.box_name, b.position, b.sort_id,b.status AS box,bn.status AS bname FROM boxes b, boxes_names bn WHERE bn.box_name = b.box_name AND bn.language_id = '" . (int) $_SESSION['languages_id'] . "' AND b.box_name = '" . $_GET['name'] . "' ");
                    $new_box = xtc_db_fetch_array($new_box_query);
                }
                ?>
                <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" name="new_box" id="database_box">
                    <script type="text/javascript">
                        <!--
						jQuery('#database_box').submit(function() {
                            if (jQuery('.box_int_name').val() != '') {
                                return true;
                            }
                            alert('Geben Sie einen eindeutigen Begriff für die interne Bezeichnung an!');
                            jQuery('.box_int_name').focus().css('border', '2px solid #b20000');
                            return false;
                        });
                        //-->
                    </script>
                    <table width="100%">
                        <tr class="dataTableHeadingRow">
                            <th class="dataTableHeadingContent" align="left" height="20">Box Einstellungen</th>
                            <th class="dataTableHeadingContent" align="center" height="20">Name / Inhalt</th>
                        </tr>
                        <tr>
                            <td valign="top" width="30%">
                                <table class="dataTable" width="100%">
                                    <tr>
                                        <td>Position: </td>
                                        <td><?php echo xtc_draw_pull_down_menu('box_position', $positions_array, $new_box['position']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Sortierung: </td>
                                        <td><?php echo xtc_draw_input_field('box_sort_id', $new_box['sort_id'], 'size="3" style="text-align:center"'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Box aktiv: </td>
                                        <td><?php echo xtc_draw_pull_down_menu('box_status', $dd, $new_box['box']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Titel an: </td>
                                        <td><?php echo xtc_draw_pull_down_menu('box_name_status', $dd, $new_box['bname']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>interne Bezeichnung:</td>
                                        <td><?php
                                            if (!empty($new_box['box_name']))
                                                echo $new_box['box_name'] . xtc_draw_hidden_field('box_int_name', $new_box['box_name']);
                                            else
                                                echo xtc_draw_input_field('box_int_name', '', 'class="box_int_name"');
                                            ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td valign="top" width="70%">
                                <div id="tabslang">
                                    <ul>
									<?php for ($i = 0, $n = sizeof($languages); $i < $n; $i++) { ?>
                                            <li><a href="#language_<?php echo $languages[$i]['id']; ?>">
                                                    <span><?php echo xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] . '/' . $languages[$i]['image'], $languages[$i]['name']); ?> <?php echo $languages[$i]['name'] ?></span>
                                                </a>
                                            </li>
                                    <?php } ?>
                                    </ul>
                                    <?php
                                    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                        if ($_GET['action'] == 'edit_new_box') {
                                            $name_query = xtc_db_query("SELECT box_title,box_desc FROM boxes_names WHERE box_name = '" . $_GET['name'] . "' AND language_id = '" . $languages[$i]['id'] . "' ");
                                            $name = xtc_db_fetch_array($name_query);
                                        }
                                        ?>
                                        <div id="language_<?php echo $languages[$i]['id'] ?>">	
                                            <table width="100%">
                                                <tr>
                                                    <td width="100" style="border:0" nowrap="nowrap">
                                                        Box-Titel: 
                                                    </td>
                                                    <td style="border:0">
													<?php echo xtc_draw_input_field('box_title_' . $languages[$i]['id'], $name['box_title']); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <?php
                                                        echo xtc_draw_textarea_field('new_box_' . $languages[$i]['id'], 'soft', '', '', $name['box_desc'], 'class="ckeditor" name="editor1"');
                                                        if (USE_WYSIWYG == 'true') {
														if (file_exists('includes/editor/ckfinder/ckfinder.js')) {
                                                            ?>	
                                                            <script type="text/javascript">
                                                                var newCKEdit = CKEDITOR.replace('<?php echo 'new_box_' . $languages[$i]['id'] ?>');
                                                                CKFinder.setupCKEditor(newCKEdit, 'includes/editor/ckfinder/');
                                                            </script>
                                                            <?php
                                                        }
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
    <?php } ?>
                                </div>									

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">
                                <?php
                                if (xtc_db_num_rows($name_query))
                                    echo xtc_draw_hidden_field('save', 'edit_new_box');
                                else
                                    echo xtc_draw_hidden_field('save', 'new_box');
                                ?>
                                <input type="submit" class="button" value="<?php echo BUTTON_SAVE; ?>" /> <a class="button" href="box_manager.php"><?php echo BUTTON_CANCEL ?></a>
    <?php echo xtc_draw_hidden_field('name', $_GET['name']); ?>
                            </td>
                        </tr>
                    </table>
                </form>
<?php } elseif ($_GET['action'] == 'edit_box') { ?>
                <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" name="edit_box">
                    <table class="dataTable" width="100%">
                        <tr class="dataTableHeadingRow">
                            <th class="dataTableHeadingContent" align="left" height="20">Box Titel</th>
                            <th class="dataTableHeadingContent" align="center" height="20">Position</th>
                            <th class="dataTableHeadingContent" align="center" height="20">Sortierung</th>
                            <th class="dataTableHeadingContent" align="center" height="20">Box aktiv?</th>
                            <th class="dataTableHeadingContent" align="center" height="20">Titel an?</th>
                            <th class="dataTableHeadingContent" align="right" height="20" class="last"></th>
                        </tr>
                        <?php
                        $box_query = xtc_db_query("SELECT b.id AS id,
														b.box_name AS box_name,
														b.position AS position,
														b.sort_id AS sort_id,
														b.status AS box,
														b.box_type AS type,
														bn.status AS bname,
														bn.box_title AS title
														FROM boxes b, boxes_names bn
														WHERE b.box_name = '" . $_GET['name'] . "'
														AND bn.box_name = '" . $_GET['name'] . "' ");

                        $box = xtc_db_fetch_array($box_query);

                        $dd[] = array('id' => '1', 'text' => YES);
                        $dd[] = array('id' => '0', 'text' => NO);

                        $position_edit_query = xtc_db_query("SELECT id, position_name FROM boxes_positions ORDER BY id");
                        while ($pos = xtc_db_fetch_array($position_edit_query)) {
                            $position_edit_array[] = array('id' => $pos['position_name'], 'text' => $pos['position_name']);
                        }
                        ?>
                        <tr>
                            <td>
                                <table width="100%">
                                    <?php
                                    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                        $name = xtc_db_fetch_array(xtc_db_query("SELECT box_title FROM boxes_names WHERE box_name = '" . $_GET['name'] . "' AND language_id = '" . $languages[$i]['id'] . "' "));
                                        ?>
                                        <tr>
                                            <td width="1" style="border:0">
                                                <?php echo '<img src="../lang/' . $languages[$i]['directory'] . '/' . $languages[$i]['image'] . '" alt="' . $name['box_title'] . '" /> '; ?>
                                            </td>
                                            <td style="border:0">
                                        <?php echo xtc_draw_input_field('box_name[' . $languages[$i]['id'] . '][]', $name['box_title'], 'style="width:200px"'); ?>
                                            </td>
                                        </tr>
    <?php } ?>
                                </table>
                            </td>
                            <td align="center" valign="middle">
                                <?php echo xtc_draw_pull_down_menu('box_position', $position_edit_array, $box['position']); ?>
                            </td>
                            <td align="center" valign="middle">
                                <?php echo xtc_draw_input_field('box_sort_id', ($box['sort_id'] != '') ? $box['sort_id'] : '0', 'size="3" style="text-align:center"'); ?>
                            </td>
                            <td align="center" valign="middle">
                                <?php echo xtc_draw_pull_down_menu('box_status', $dd, $box['box']); ?>
                            </td>
                            <td class="last" align="center" valign="middle">
    <?php echo xtc_draw_pull_down_menu('box_name_status', $dd, $box['bname']); ?>
                            </td>
                            <td nowrap="nowrap" class="last">
                                <input type="submit" class="button" value="<?php echo BUTTON_SAVE; ?>" /> <a class="button" href="box_manager.php"><?php echo BUTTON_CANCEL ?></a>
    <?php echo xtc_draw_hidden_field('name', $_GET['name']) . xtc_draw_hidden_field('action', 'save'); ?>
                            </td>
                        </tr>
                    </table>

                </form>
<?php } ?>
        </td>
    </tr>
</table>
<?php
require(DIR_WS_INCLUDES . 'footer.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
