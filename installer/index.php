<?php
/*-----------------------------------------------------------------
* 	ID:						index.php
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

require_once(DIR_FS_INC . 'xtc_image.inc.php');
require_once(DIR_FS_INC . 'xtc_redirect.inc.php');
require_once(DIR_FS_INC . 'xtc_href_link.inc.php');

include('language/german.php');

define('HTTP_SERVER', '');
define('HTTPS_SERVER', '');
define('DIR_WS_CATALOG', '');

$messageStack = new messageStack();

$process = false;
if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
	$process = true;
	$_SESSION['language'] = $_POST['LANGUAGE'];
	$error = false;
	if (($_SESSION['language'] != 'german') && ($_SESSION['language'] != 'english')) {
		$error = true;
		$messageStack->add('index', SELECT_LANGUAGE_ERROR);
	}
	if ($error == false && $error_folder_flag == false && $error_file_flag == false && $error_flag == false)
		xtc_redirect(xtc_href_link('install_step1.php', '', 'NONSSL'));
}

function get_php_setting($val) {
	$r = (ini_get($val) == '1' ? 1 : 0);
	return $r ? 'An' : 'Aus';
}
include('includes/metatag.php');
?>
	<title>commerce:SEO v2.2 Installation - Willkommen</title>
	<link rel="stylesheet" type="text/css" href="includes/javascript/cluetip/jquery.cluetip.css" />
	<script src="includes/javascript/jquery-1.4.2.min.js" type="text/javascript"></script>
	<script src="includes/javascript/jquery-ui.js" type="text/javascript"></script>
	<script src="includes/javascript/cluetip/jquery.cluetip.js" type="text/javascript"></script>
	<script type="text/javascript">
		<!--
		jQuery(document).ready(function() {
			jQuery('a.help_tip').cluetip({width:500,sticky:true,activation:'click',closePosition:'title',closeText:'schliessen [x]'});
			jQuery("#cluetip").draggable();
		});
		//-->
	</script>
	</head>
	<body>
<?php include('includes/header.php'); ?>
		<?php if ($messageStack->size('index') > 0) { ?>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
				<tr>
					<td valign="middle"><?php echo $messageStack->output('index'); ?></td>
				</tr>
			</table>
		<?php } ?>

				<table class="outerTable" width="100%">
					<tr>
						<td class="columnLeft" width="200" valign="top">
							<div class="menu_titel">Installation</div>
							<table class="menu_items" width="100%">
								<tr>
									<td width="1" valign="middle">
										<?php echo xtc_image(DIR_WS_ICONS . '/icons/icon_arrow_right.gif'); ?>
									</td>
									<td valign="middle">
										<?php echo BOX_LANGUAGE; ?>
									</td>
								</tr>
							</table>
						</td>
						<td class="columnRight" valign="top">
							<table class="table_pageHeading" border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td class="pageHeading">
										<h1 class="schatten">Willkommen zur <?php echo PROJECT_VERSION; ?> Installation</h1>
									</td>
								</tr>
							</table>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<?php echo TEXT_WELCOME_INDEX; ?><br /><hr /><br />
										<?php
										$error_folder_flag = false;
										$error_file_flag = false;
										$error_flag = false;
										$php_flag == false;
										$gdlib_flag == false;
										$error_message = '';
										$ok_message = '';
										$infos = '';

										// config files
										if (!is_writeable(DIR_FS_CATALOG . 'includes/configure.php')) {
											$error_file_flag = true;
											$file_message .= DIR_FS_CATALOG . 'includes/<strong>configure.php</strong><br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'includes/configure.org.php')) {
											$error_file_flag = true;
											$file_message .= DIR_FS_CATALOG . 'includes/<strong>configure.org.php</strong><br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'admin/includes/configure.php')) {
											$error_file_flag = true;
											$file_message .= DIR_FS_CATALOG . 'admin/includes/<strong>configure.php</strong><br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'admin/includes/configure.org.php')) {
											$error_file_flag = true;
											$file_message .= DIR_FS_CATALOG . 'admin/includes/<strong>configure.org.php</strong><br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'templates_c/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . '<strong>templates_c</strong>/<br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'cache/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . '<strong>cache</strong>/<br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'admin/images/graphs')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . 'admin/images/<strong>graphs</strong><br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'admin/backups/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . 'admin/<strong>backups</strong>/<br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'images/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . '<strong>images</strong>/<br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'images/categories/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . 'images/<strong>categories</strong>/<br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'images/categories_org/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . 'images/<strong>categories_org</strong>/<br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'images/banner/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . 'images/<strong>banner</strong>/<br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'images/products_movies/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . 'images/<strong>products_movies</strong>/<br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'images/product_options/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . 'images/<strong>product_options</strong>/<br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'images/product_images/info_images/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . 'images/product_images/<strong>info_images</strong>/<br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'images/product_images/original_images/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . 'images/product_images/<strong>original_images</strong>/<br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'images/product_images/popup_images/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . 'images/product_images/<strong>popup_images</strong>/<br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'images/product_images/thumbnail_images/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . 'images/product_images/<strong>thumbnail_images</strong>/<br />';
										}
										if (!is_writeable(DIR_FS_CATALOG . 'images/product_images/mini_images/')) {
											$error_folder_flag = true;
											$folder_message .= DIR_FS_CATALOG . 'images/product_images/<strong>mini_images</strong>/<br />';
										}

										// check PHP-Version

										if (xtc_check_version() != 1) {
											$error_flag = true;
											$error_message .= '<strong>Achtung!, Ihre PHP Version ist zu alt, commerce:SEO ben&ouml;tigt mindestens PHP 5.</strong><br /><br />Ihre PHP Version: <b>' . phpversion() . '</b><br /><br />commerce:SEO wird auf diesem Server nicht laufen. Updaten Sie Ihr PHP oder wechseln Sie den Server.';
										} else {
											$php_version = phpversion();
											$ok_message .= 'PHP Version - <strong>' . $php_version . '</strong><br />';
										}

										// Pruefen der GDLib Version
										$gd = gd_info();
										if ($gd['GD Version'] == '') {
											$error_flag = true;
											$error_message .= '<br /><strong>Fehler keine GDlib gefunden!</strong><br /><br />Sie haben keine Unterst&uuml;tzung f&uuml;r GIF Grafiken';
										} else {
											$ok_message .= 'GDlib Version - <strong>' . $gd['GD Version'] . '</strong><br />';
										}
										if ($gd['GIF Create Support'] == 1) // GIF
											$infos .= '<tr><td width="100">GIF Erstellung</td> <td><span style="color:#177701">Ja</span></td></tr>';
										else
											$infos .= '<tr><td width="100">GIF Erstellung</td> <td><span style="color:#990000">Nein</span></td></tr>';

										if ($gd['JPG Support'] == 1 || $gd['JPEG Support'] == 1)
											$infos .= '<tr><td>JPG Erstellung</td> <td><span style="color:#177701">Ja</span></td></tr>';
										else
											$infos .= '<tr><td>JPG Erstellung</td> <td><span style="color:#990000">Nein</span></td></tr>';
										if ($gd['PNG Support'] == 1)
											$infos .= '<tr><td>PNG Erstellung</td> <td><span style="color:#177701">Ja</span></td></tr>';
										else
											$infos .= '<tr><td>PNG Erstellung</td> <td><span style="color:#990000">Nein</span></td></tr>';

										$output = shell_exec('mysql -V');
										preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version);
										$infos .= '<tr><td>MySQL Version</td> <td>' . $version[0] . '</td></tr>';
										$infos .= '<tr><td>Webserver</td><td>' . $_SERVER['SERVER_SOFTWARE'] . '</td></tr>';
										$infos .= '<tr><td><nobr>PHP-Anbindung zum Webserver&nbsp;</nobr></td> <td>' . php_sapi_name() . '</td></tr>';
										$infos .= '<tr><td>Safe Mode</td> <td>' . get_php_setting('safe_mode') . '</td></tr>';
										$infos .= '<tr><td>Fehler Ausgabe</td> <td>' . get_php_setting('display_errors') . '</td></tr>';
										$infos .= '<tr><td>Kurze Open-Tags</td> <td>' . get_php_setting('short_open_tag') . '</td></tr>';
										$infos .= '<tr><td>Datei-Uploads</td> <td>' . get_php_setting('file_uploads') . '</td></tr>';
										$infos .= '<tr><td>Magic-Quotes</td> <td>' . get_php_setting('magic_quotes_gpc') . '</td></tr>';
										$infos .= '<tr><td>Register-Globals</td> <td>' . get_php_setting('register_globals') . '</td></tr>';
										$infos .= '<tr><td>Session Speicherpfad</td> <td>' . ini_get('session.save_path') . '</td></tr>';

										if ($gd['GIF Read Support'] == 1 || $gd['GIF Create Support'] == 1) {
											$ok_message .= 'GDlib Create-Support - <strong>Ja</strong> - Overlay f&uuml;r Grafiken wird unterst&uuml;tzt.<br />';
										} else {
											$error_message .= 'Sie haben keinen GDlib Support, die Overlay Funktion f&uuml;r die Kategorie- und Produktbilder wird nicht unterst&uuml;tzt!';
										}

										// Falsche - Richtige Dateirechte
										if ($error_file_flag == true) {
											echo '<fieldset class="installer red"><legend><strong><span style="color:#990000">' . ATTENTION . '</span> - ' . WRONG_FILE_PERMISSION . '</strong> ' . cseo_get_help('84', '', 'Installationshilfe') . '</legend>';
											echo $file_message;
											echo '</fieldset>';
										} else {
											echo '<fieldset class="installer green"><legend><strong><span style="color:#177701">OK</span></strong></legend>';
											echo CORRECT_FILE_PERMISSION;
											echo '</fieldset>';
										}
										// Falsche - Richtige Verzeichnisrechte
										if ($error_folder_flag == true) {
											echo '<fieldset class="installer red"><legend>' . WRONG_FOLDER_PEMISSION . ' ' . cseo_get_help('84', '', 'Installationshilfe') . '</legend>';
											echo $folder_message;
											echo '</fieldset>';
										} else {
											echo '<fieldset class="installer green"><legend><strong><span style="color:#177701">OK</span></strong></legend>';
											echo CORRECT_FOLDER_PERMISSION;
											echo '</fieldset>';
										}

										if ($error_flag == true) {
											echo '<fieldset class="installer red"><legend><strong><span style="color:#990000">' . ATTENTION . '</span></strong></legend>';
											echo $error_message;
											echo '</fieldset>';
										} else {
											echo '<fieldset class="installer green"><legend><strong><span style="color:#177701">OK</span></strong></legend>';
											echo $ok_message;
											echo '</fieldset>';
										}
										if ($infos != '') {
											echo '<fieldset class="installer"><legend><strong>' . SERVER_INFO . '</strong></legend>';
											echo '<table width="100%">' . $infos . '</table>';
											echo '</fieldset>';
										}
										?>
										<h2 class="schatten"><?php echo TITLE_SELECT_LANGUAGE; ?></h2>
										<form name="language" method="post" action="index.php?action=process">
											<table width="100%" cellpadding="8" cellspacing="8" class="table_input">
												<tr>
													<td width="100">
														<img src="language/german.gif" alt="" /> Deutsch
													</td>
													<td>
														<?php echo xtc_draw_radio_field_installer('LANGUAGE', 'german', 'true'); ?>
													</td>
												</tr>
												<tr>
													<td>
														<img src="language/english.gif" alt="" /> Englisch
													</td>
													<td>
														<?php echo xtc_draw_radio_field_installer('LANGUAGE', 'english'); ?>
													</td>
												</tr>
											</table>

											<table width="100%" cellpadding="8" cellspacing="8">
												<tr>
													<td align="center" valign="middle">
														<?php if ($error == false && $error_folder_flag == false && $error_file_flag == false && $error_flag == false) { ?>
															<input type="submit" class="button" value="Installation fortsetzen" /><input type="hidden" name="action" value="process" />
														<?php } else { ?>
															<a href="index.php" class="button">Pr&uuml;fung wiederholen</a>
														<?php } ?>
													</td>
												</tr>
											</table>
										</form>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
		<table id="footer" width="100%">
			<tr>
				<td valign="bottom" align="center"><?php echo TEXT_FOOTER; ?></td>
			</tr>
		</table>
		</div>
	</body>
</html>
