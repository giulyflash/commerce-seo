<?php
/*-----------------------------------------------------------------
* 	ID:						install_step4.php
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

include('includes/metatag.php');
?>
<title>commerce:SEO Installation - Schritt 4</title>
</head>
<body>
<script type="text/javascript" src="includes/javascript/tooltip.js" encode="UTF-8" ></script>
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
					<table class="menu_items ok" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/icons/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_DB_CONNECTION; ?>
							</td>
						</tr>
					</table>
					<table class="menu_items ok" width="100%" style="padding-left:20px">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/icons/tick.gif'); ?>
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
					<table class="menu_items" width="100%" style="padding-left:20px">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/icons/icon_arrow_right.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_WRITE_CONFIG; ?>
							</td>
						</tr>
					</table>
				</td>
				<td class="columnRight" valign="top">
					<table class="table_pageHeading" border="0" width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td class="pageHeading">
								<h1 class="schatten">Schritt 4</h1>
							</td>
						</tr>
					</table>
					<?php if(((file_exists(DIR_FS_CATALOG . 'includes/configure.php')) && (!is_writeable(DIR_FS_CATALOG . 'includes/configure.php'))) || 
							((file_exists(DIR_FS_CATALOG . 'admin/includes/configure.php')) && (!is_writeable(DIR_FS_CATALOG . 'admin/includes/configure.php')))) { ?>
						<form name="install" action="install_step4.php" method="post">
							<fieldset class="installer red">
								<legend><strong><span style="color:#EB5E00"><?php echo TEXT_TITLE_ERROR; ?></span></strong></legend>
								
	            				<p><?php echo TEXT_STEP4_ERROR; ?></p>
								<ul style="margin-left:15px">
									<li>Wechseln Sie zu <?php echo DIR_FS_CATALOG; ?>admin/includes/</li>
									<li>&auml;ndern Sie die Schreibrechte dieser beiden Dateien:</li>
									<li>chmod 644 configure.php</li>
									<li>chmod 644 configure.org.php</li>
								</ul><br />
								<ul style="margin-left:15px">
									<li>Wechseln Sie zu <?php echo DIR_FS_CATALOG; ?>includes/</li>
									<li>&auml;ndern Sie die Schreibrechte dieser beiden Dateien:</li>
									<li>chmod 644 configure.php </li>
									<li>chmod 644 configure.org.php</li>
								</ul>
	            				<p><?php echo TEXT_STEP4_ERROR_1; ?></p>
	            				<p><?php echo TEXT_STEP4_ERROR_2; ?></p>
								<?php
									reset($_POST);
									while (list($key, $value) = each($_POST)) {
										if ($key != 'x' && $key != 'y') {
											if (is_array($value)) {
												for ($i=0; $i<sizeof($value); $i++) {
													echo xtc_draw_hidden_field_installer($key . '[]', $value[$i]);
												}
											} else
												echo xtc_draw_hidden_field_installer($key, $value);
										}
									}
								?>
							</fieldset>
							<table border="0" width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td align="center">
										<a class="button" href="index.php">
											Abbruch
										</span>
									</td>
									<td align="center">
										<input type="submit" class="button" value="Pr&uuml;fung wiederholen" >
									</td>
								</tr>
							</table>
						</form>
					<?php } else { ?>
						<table border="0" width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<?php echo TEXT_WELCOME_STEP4; ?>
								</td>
							</tr>
						</table>
						<h2 class="schatten"><?php echo TITLE_WEBSERVER_CONFIGURATION; ?></h2>
						<form name="install" action="install_step5.php" method="post">
							<p><?php echo TEXT_VALUES; ?></p>
							includes/configure.php<br />
							includes/configure.org.php<br />
							admin/includes/configure.php<br />
							admin/includes/configure.org.php<br /><br />
							<h2 class="schatten"><?php echo TITLE_CHECK_CONFIGURATION; ?></h2>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
		    					<tr>
		    						<td valign="middle" width="220">
		    							<b><?php echo TEXT_HTTP; ?></b>
		    						</td>
		    						<td valign="middle">
		    							<?php echo xtc_draw_input_field_installer('HTTP_SERVER', 'http://'.getenv('HTTP_HOST'),'','size="40"'); ?>
		    							<?php echo ' <span'.mouseOverJS(TEXT_HTTP,TEXT_HTTP_LONG).'>
		    								<img src="images/icons/icon_help.gif" alt="" />
		    							</span>'; ?>
		    						</td>
		    					<tr>
		    				</table>
		    				<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
		    					<tr>
		    						<td valign="middle" width="220">
		    						    <b><?php echo TEXT_HTTPS; ?></b>
		    						</td>
		    						<td valign="middle">
		    							<?php echo xtc_draw_input_field_installer('HTTPS_SERVER', 'https://' . getenv('HTTP_HOST'),'','size="40"'); ?>
		    							<?php echo ' <span'.mouseOverJS(TEXT_HTTPS,TEXT_HTTPS_LONG).'>
		    						    <img src="images/icons/icon_help.gif" alt="" />
		    							</span>'; ?>
		    						</td>
		    					<tr>
		    				</table>
		    				<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
		    					<tr>
		    						<td valign="middle" width="220">
		    						    <b><?php echo TEXT_SSL; ?></b>
		    						</td>
		    						<td valign="middle">
		    							<?php echo xtc_draw_checkbox_field_installer('ENABLE_SSL', 'true'); ?>
		    							<?php echo ' <span'.mouseOverJS(TEXT_SSL,TEXT_SSL_LONG).'>
		    						    <img src="images/icons/icon_help.gif" alt="" />
		    							</span>'; ?>
		    						</td>
		    					<tr>
		    				</table>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_WS_ROOT; ?></b>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_input_field_installer('DIR_FS_DOCUMENT_ROOT','','','size=40'); ?>
										<?php echo ' <span'.mouseOverJS(TEXT_WS_ROOT,TEXT_WS_ROOT_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>'; ?>
									</td>
								<tr>
							</table>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_WS_ROOT; ?></b>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_input_field_installer('DIR_FS_DOCUMENT_ROOT', '','','size=40'); ?>
										<?php echo ' <span'.mouseOverJS(TEXT_WS_ROOT,TEXT_WS_ROOT_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>'; ?>
									</td>
								<tr>
							</table>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_WS_CSEO; ?></b>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_input_field_installer('DIR_FS_CATALOG','','','size=40');?>
										<?php echo ' <span'.mouseOverJS(TEXT_WS_CSEO,TEXT_WS_CSEO_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>'; ?>
									</td>
								<tr>
							</table>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_WS_ADMIN; ?></b>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_input_field_installer('DIR_FS_ADMIN', '','','size=40'); ?>
										<?php echo ' <span'.mouseOverJS(TEXT_WS_ADMIN,TEXT_WS_ADMIN_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>'; ?>
									</td>
								<tr>
							</table>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_WS_CATALOG; ?></b>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_input_field_installer('DIR_WS_CATALOG', '','','size=40'); ?>
										<?php echo ' <span'.mouseOverJS(TEXT_WS_CATALOG,TEXT_WS_CATALOG_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>'; ?>
									</td>
								<tr>
							</table>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_WS_ADMINTOOL; ?></b>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_input_field_installer('DIR_WS_ADMIN', $local_install_path,'','size=40'); ?>
										<?php echo ' <span'.mouseOverJS(TEXT_WS_ADMINTOOL,TEXT_WS_ADMINTOOL_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>'; ?>
									</td>
								<tr>
							</table>
							
							<h2 class="schatten"><?php echo TITLE_CHECK_DATABASE; ?></h2>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_DATABASE_SERVER; ?></b>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_input_field_installer('DB_SERVER','','','size=40'); ?>
										<?php echo ' <span'.mouseOverJS(TEXT_DATABASE_SERVER,TEXT_DATABASE_SERVER_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>'; ?>
									</td>
								<tr>
							</table>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_USERNAME; ?></b>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_input_field_installer('DB_SERVER_USERNAME', '','','size=40'); ?>
										<?php echo ' <span'.mouseOverJS(TEXT_USERNAME,TEXT_USERNAME_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>'; ?>
									</td>
								<tr>
							</table>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_PASSWORD; ?></b>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_input_field_installer('DB_SERVER_PASSWORD','','','size=40');?>
										<?php echo ' <span'.mouseOverJS(TEXT_PASSWORD,TEXT_PASSWORD_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>';?>
									</td>
								<tr>
							</table>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_DATABASE; ?></b>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_input_field_installer('DB_DATABASE','','','size=40');?>
										<?php echo ' <span'.mouseOverJS(TEXT_DATABASE,TEXT_DATABASE_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>';?>
									</td>
								<tr>
							</table>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_PERSIST; ?></b>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_checkbox_field_installer('USE_PCONNECT', 'true');?>
										<?php echo ' <span'.mouseOverJS(TEXT_PERSIST,TEXT_PERSIST_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>';?>
									</td>
								<tr>
							</table>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_SESS_FILE; ?></b>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_radio_field_installer('STORE_SESSIONS', 'files', true);?>
										<?php echo ' <span'.mouseOverJS(TEXT_SESS_FILE,TEXT_SESS_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>';?>
									</td>
								</tr>
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_SESS_DB; ?></b>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_radio_field_installer('STORE_SESSIONS', 'mysql', true);?>
										<?php echo ' <span'.mouseOverJS(TEXT_SESS_DB,TEXT_SESS_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>';?>
									</td>
								</tr>
							</table>
							<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
								<tr>
									<td valign="middle" width="220">
									    <b><?php echo TEXT_SALT_KEY; ?></b>
										<?php echo ' <span'.mouseOverJS(TEXT_SALT_KEY,TEXT_SALT_KEY_LONG).'>
									    <img src="images/icons/icon_help.gif" alt="" />
										</span>';?>
									</td>
									<td valign="middle">
										<?php echo xtc_draw_input_field_installer('SALT_KEY','cseov22p','','size=40');?>
									</td>
								</tr>

							</table>
							<table border="0" width="100%" cellspacing="8" cellpadding="8">
								<tr>
									<td align="center" valign="middle">
										<a class="button" href="index.php">
											<?php echo TEXT_CANCEL; ?>
										</span>
									</td>
									<td align="center" valign="middle">
										<input type="submit" class="button" value="weiter zu Schritt 5" />
									</td>
								</tr>
							</table>
							<input type="hidden" name="install[]" value="configure">
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
