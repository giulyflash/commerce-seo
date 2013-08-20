<?php
/*-----------------------------------------------------------------
* 	ID:						install_step2.php
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

// include needed functions
require_once(DIR_FS_INC.'xtc_redirect.inc.php');
require_once(DIR_FS_INC.'xtc_href_link.inc.php');
require_once(DIR_FS_INC.'xtc_not_null.inc.php');
require_once(DIR_FS_INC.'xtc_db_query.inc.php');
require_once(DIR_FS_INC.'xtc_db_fetch_array.inc.php');
require_once(DIR_FS_INC.'xtc_draw_pull_down_menu.inc.php');
include('language/'.$_SESSION['language'].'.php');

if (!$script_filename = str_replace('\\', '/', getenv('PATH_TRANSLATED'))) {
	$script_filename = getenv('SCRIPT_FILENAME');
}
$script_filename = str_replace('//', '/', $script_filename);

if (!$request_uri = getenv('REQUEST_URI')) {
	if (!$request_uri = getenv('PATH_INFO'))
		$request_uri = getenv('SCRIPT_NAME');
	if (getenv('QUERY_STRING')) 
		$request_uri .=  '?' . getenv('QUERY_STRING');
}

// test database connection and write permissions
if (xtc_in_array('database', $_POST['install'])) {
	$db = array();
	$db['DB_SERVER'] = trim(stripslashes($_POST['DB_SERVER']));
	$db['DB_SERVER_USERNAME'] = trim(stripslashes($_POST['DB_SERVER_USERNAME']));
	$db['DB_SERVER_PASSWORD'] = trim(stripslashes($_POST['DB_SERVER_PASSWORD']));
	$db['DB_DATABASE'] = trim(stripslashes($_POST['DB_DATABASE']));
	
	$db_error = false;
	xtc_db_connect_installer($db['DB_SERVER'], $db['DB_SERVER_USERNAME'], $db['DB_SERVER_PASSWORD']);
	
	if (!$db_error)
		xtc_db_test_create_db_permission($db['DB_DATABASE']);
	
	if ($db_error) {
		$img_box = xtc_image(DIR_WS_ICONS.'/icons/cancel.gif');
		$class_box = 'red';
	} else {
		$img_box = xtc_image(DIR_WS_ICONS.'/icons/tick.gif');
		$class_box = 'ok';
	}
}

$dir_fs_www_root_array = explode('/', dirname($script_filename));
$dir_fs_www_root = array();
for ($i=0; $i<sizeof($dir_fs_www_root_array)-2; $i++) {
	$dir_fs_www_root[] = $dir_fs_www_root_array[$i];
}
$dir_fs_www_root = implode('/', $dir_fs_www_root);
$dir_ws_www_root_array = explode('/', dirname($request_uri));
$dir_ws_www_root = array();
for ($i=0; $i<sizeof($dir_ws_www_root_array)-1; $i++) {
	$dir_ws_www_root[] = $dir_ws_www_root_array[$i];
}
$dir_ws_www_root = implode('/', $dir_ws_www_root);

if (xtc_in_array('database', $_POST['install'])) {
	// do nothin
} else {
	xtc_redirect('install_step4.php');
}
include('includes/metatag.php');
?>
<title>commerce:SEO Installation - Schritt 2</title>
</head>
<body>
<?php include('includes/header.php'); ?>
<div id="wrapper">
	<div id="inner_wrapper">		
		<table class="outerTable" width="100%">
			<tr>
				<td class="columnLeft" width="200" valign="top">
					<div class="menu_titel">Installation</div>
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
					<table class="menu_items" width="100%" style="padding-left:20px">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/icons/icon_arrow_right.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_DB_IMPORT; ?>
							</td>
						</tr>
					</table>
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
								<h1 class="schatten">Schritt 2</h1>
							</td>
						</tr>
					</table>
					<?php if($db_error) { ?>
						<form name="install" action="install_step1.php" method="post">
							<fieldset class="installer red">
								<legend><strong><span style="color:#EB5E00"><?php echo TEXT_CONNECTION_ERROR; ?></span></strong></legend>
								<?php echo TEXT_DB_ERROR; ?>
	          					<p><b><?php echo $db_error; ?></b></p>
								<p><?php echo TEXT_DB_ERROR_1; ?></p>
								<p><?php echo TEXT_DB_ERROR_2; ?></p>
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
										<input type="submit" class="button" value="zur&uuml;ck" />
									</td>
								</tr>
							</table>
						</form>
					<?php } else { ?>
						<form name="install" action="install_step3.php" method="post">
							<fieldset class="installer green">
								<legend><strong><span style="color:#4eb56c"><?php echo TEXT_CONNECTION_SUCCESS; ?></span></strong></legend>
								<p><?php echo TEXT_WELCOME_STEP2; ?></p>
								<p><?php echo TEXT_PROCESS_1; ?></p>
								<p><?php echo TEXT_PROCESS_2; ?></p>
								<p><?php echo TEXT_PROCESS_3; ?></p>
								<p><b><?php echo DIR_FS_CATALOG . 'installer/sql/commerce_seo.sql'; ?></b>.</p>
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

								// check out usable charsets:
								$dbcharset_query = xtc_db_query('show variables like \'character_set_database\'');
								$dbcharset = xtc_db_fetch_array($dbcharset_query);

								if ($dbcharset['Value'] != 'utf8') {
									echo SELECT_CHARSET .'<b style="color:red">'.$dbcharset['Value'].'</b>';
									echo SELECT_CHARSET_DESC;
									echo CONVERT_DB."\n".'<input type="checkbox" name="convertdb" value="true" checked />';
									echo CONVERT_DB_DESC;
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
										<input type="submit" class="button" value="weiter zu Schritt 3" />
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