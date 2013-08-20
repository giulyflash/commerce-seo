<?php
/*-----------------------------------------------------------------
* 	ID:						install_step3.php
* 	Letzter Stand:			v2.3
* 	zuletzt geaendert von:	cseoak
* 	Datum:					2012/11/19
*
* 	Copyright (c) since 2010 commerce:SEO by Webdesign Erfurt
* 	http://www.commerce-seo.de
* ------------------------------------------------------------------
* 	based on:
* 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
* 	(c) 2002-2003 osCommerce - www.oscommerce.com
* 	(c) 2003     nextcommerce - www.nextcommerce.org
* 	(c) 2005     xt:Commerce - www.xt-commerce.com
* 	Released under the GNU General Public License
* ---------------------------------------------------------------*/



require('includes/application.php');

include('language/'.$_SESSION['language'].'.php');

if (xtc_in_array('database', $_POST['install'])) {
	$db = array();
	$db['DB_SERVER'] = trim(stripslashes($_POST['DB_SERVER']));
	$db['DB_SERVER_USERNAME'] = trim(stripslashes($_POST['DB_SERVER_USERNAME']));
	$db['DB_SERVER_PASSWORD'] = trim(stripslashes($_POST['DB_SERVER_PASSWORD']));
	$db['DB_DATABASE'] = trim(stripslashes($_POST['DB_DATABASE']));
	$db['convertdb'] = trim(stripslashes($_POST['convertdb']));
	
	xtc_db_connect_installer($db['DB_SERVER'], $db['DB_SERVER_USERNAME'], $db['DB_SERVER_PASSWORD']);
	if($_POST['convertdb'] == 'true') {
		xtc_db_query_installer('ALTER DATABASE '.$db['DB_DATABASE'].' CHARACTER SET utf8;');
		xtc_db_query_installer('ALTER DATABASE '.$db['DB_DATABASE'].' COLLATE utf8_general_ci;');
	}
	xtc_db_query_installer('SET storage_engine = MYISAM;');
	$db_error = false;
	$sql_file = DIR_FS_CATALOG . 'installer/sql/commerce_seo.sql';
	xtc_db_install($db['DB_DATABASE'], $sql_file);
	
	if ($db_error) {
		$img_box = xtc_image(DIR_WS_ICONS.'/icons/cancel.gif');
		$class_box = 'red';
	} else {
		$img_box = xtc_image(DIR_WS_ICONS.'/icons/tick.gif');
		$class_box = 'ok';
	}
}
include('includes/metatag.php');
?>
<title>commerce:SEO Installation - Schritt 3</title>
</head>
<body>
<?php include('includes/header.php'); ?>
<div id="wrapper">
	<div id="inner_wrapper">
		<table class="outerTable" width="100%">
			<tr>
				<td class="columnLeft" width="200" valign="top">
					<div class="menu_titel">Install</div>
					<table class="menu_items ok" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/icons/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_LANGUAGE; ?>
							</td>
						</tr>
					</table><br />
					<table class="menu_items <?php echo $class_box; ?>" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo $img_box ?>
							</td>
							<td valign="middle">
								<?php echo BOX_DB_CONNECTION; ?>
							</td>
						</tr>
					</table>
					<table class="menu_items <?php echo $class_box; ?>" width="100%" style="padding-left:20px">
						<tr>
							<td width="1" valign="middle">
								<?php echo $img_box ?>
							</td>
							<td valign="middle">
								<?php echo BOX_DB_IMPORT; ?>
							</td>
						</tr>
					</table><br />
					<table class="menu_items" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/icons/icon_arrow_right.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_WEBSERVER_SETTINGS; ?>
							</td>
						</tr>
					</table>
				</td>
				<td class="columnRight" valign="top">
					<table class="table_pageHeading" border="0" width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td class="pageHeading">
								<h1 class="schatten">Schritt 3</h1>
							</td>
						</tr>
					</table>
					<?php if($db_error) { ?>
						<form name="install" action="install_step3.php" method="post">
							<fieldset class="installer red">
								<legend><strong><span style="color:#EB5E00"><?php echo TEXT_TITLE_ERROR; ?></span></strong></legend>
								<p>Folgender Fehler wurde zur&uuml;ckgegeben:</p>
								<p><strong><?php echo $db_error; ?></p></strong>
								<p>Stellen Sie sicher, das sich die SQL Datei im richtigen Order befindet und wiederholen Sie den Vorgang.</p>
							</fieldset>
							<?php
								reset($_POST);
								while (list($key, $value) = each($_POST)) {
									if ($key != 'x' && $key != 'y') {
										if (is_array($value)) {
											for ($i=0; $i<sizeof($value); $i++)
												echo xtc_draw_hidden_field_installer($key . '[]', $value[$i]);
										} else
											echo xtc_draw_hidden_field_installer($key, $value);
									}
								}
							?>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td align="center">
										<a class="button" href="index.php">Abbruch</a>
									</td>
									<td align="center">
										<input type="submit" class="button" value="Import wiederholen" />
									</td>
								</tr>
							</table>
						</form>
					<?php } else { ?>
						<form name="install" action="install_step4.php" method="post">
							<fieldset class="installer green">
								<legend><strong><span style="color:#4eb56c"><?php echo TEXT_TITLE_SUCCESS; ?></span></strong></legend>
								<p>Der Import, bzw. das Anlegen der Tabellen war erfolgreich.</p>
							</fieldset>
							<?php
								reset($_POST);
								while (list($key, $value) = each($_POST)) {
									if ($key != 'x' && $key != 'y') {
										if (is_array($value)) {
											for ($i=0; $i<sizeof($value); $i++)
												echo xtc_draw_hidden_field_installer($key . '[]', $value[$i]);
										} else
											echo xtc_draw_hidden_field_installer($key, $value);
									}
								}
							?>
							<table border="0" width="100%" cellspacing="8" cellpadding="8">
								<tr>
									<td align="center" valign="middle">
										<a class="button" href="install_step1.php">
											Abbruch
										</a>
									</td>
									<td align="center" valign="middle">
										<input type="submit" class="button" value="weiter zu Schritt 4" />
									</td>
								</tr>
							</table>
						</form>
					<?php } ?>
				</td>
			</tr>
		</table>
	</div>
</div>
<table id="footer" width="100%">
	<tr>
		<td valign="bottom" align="center"><?php echo TEXT_FOOTER; ?></td>
	</tr>
</table>
</body>
</html>