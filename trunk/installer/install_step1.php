<?php
/*-----------------------------------------------------------------
* 	ID:						install_step1.php
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

if (!$script_filename = str_replace('\\', '/', getenv('PATH_TRANSLATED'))) {
$script_filename = getenv('SCRIPT_FILENAME');
}
$script_filename = str_replace('//', '/', $script_filename);

if (!$request_uri = getenv('REQUEST_URI')) {
if (!$request_uri = getenv('PATH_INFO')) {
  $request_uri = getenv('SCRIPT_NAME');
}

if (getenv('QUERY_STRING')) $request_uri .=  '?' . getenv('QUERY_STRING');
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
  
include('includes/metatag.php');
?>
<title>commerce:SEO Installation - Schritt 1</title>
</head>
<body>
<script type="text/javascript" src="includes/javascript/tooltip.js" encode="UTF-8"></script>
<?php include('includes/header.php'); ?>
<div id="wrapper">
	<div id="inner_wrapper">
		<form name="install" method="post" action="install_step2.php" autocomplete="on">
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
						</table>
					</td>
					<td valign="top">
						<table class="table_pageHeading" border="0" width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td class="pageHeading">
									<h1 class="schatten">Schritt 1</h1>
								</td>
							</tr>
						</table>
						<table border="0" width="100%" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<?php echo TEXT_WELCOME_STEP1; ?><br />
									<h2 class="schatten"><?php echo TITLE_CUSTOM_SETTINGS; ?></h2>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign="top">
						<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
							<tr>
								<td align="left" width="1" valign="middle"  nowrap="nowrap"><?php echo xtc_draw_checkbox_field_installer('install[]', 'database', true);?> <b><?php echo TEXT_IMPORT_DB; ?></b></td>
								<td align="left" valign="middle">
									<?php echo ' <span'.mouseOverJS(TEXT_IMPORT_DB,TEXT_IMPORT_DB_LONG).'><img src="images/icons/icon_help.gif" alt="" /></span>'; ?>
								</td>
							</tr>
						</table>
						<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
							<tr>
								<td width="1" valign="middle"  nowrap="nowrap">
									<?php echo xtc_draw_checkbox_field_installer('install[]', 'configure', true); ?> <b><?php echo TEXT_AUTOMATIC; ?></b>
								</td>
								<td align="left" valign="middle">
									<?php echo ' <span'.mouseOverJS(TEXT_AUTOMATIC,TEXT_AUTOMATIC_LONG).'><img src="images/icons/icon_help.gif" alt="" /></span>'; ?>
								</td>
							</tr>
						</table>
						<h2 class="schatten"><?php echo TITLE_DATABASE_SETTINGS; ?></h2>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<table class="menu_items" width="100%">
							<tr>
								<td width="1" valign="middle">
									<?php echo xtc_image(DIR_WS_ICONS.'/icons/icon_arrow_right.gif'); ?>
								</td>
								<td valign="middle">
									<?php echo BOX_DB_CONNECTION; ?>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
	    				<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
	    					<tr>
	    						<td width="150" valign="middle">
	    							<b><?php echo TEXT_DATABASE_SERVER; ?></b>
	    						</td>
	    						<td valign="middle">
	    							<?php echo xtc_draw_input_field_installer('DB_SERVER'); ?>
	    							<?php echo ' <span'.mouseOverJS(TEXT_DATABASE_SERVER,TEXT_DATABASE_SERVER_LONG).'>
	    								<img src="images/icons/icon_help.gif" alt="" />
	    							</span>'; ?>
	    						</td>
	    					</tr>
	    				</table>
	    				<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
	    					<tr>
	    						<td width="150" valign="middle">
	    							<b><?php echo TEXT_DATABASE; ?></b>
			                	</td>
	    						<td valign="middle">
	    							<?php echo xtc_draw_input_field_installer('DB_DATABASE'); ?>
	    							<?php echo ' <span'.mouseOverJS(TEXT_DATABASE,TEXT_DATABASE_LONG).'>
	    								<img src="images/icons/icon_help.gif" alt="" />
	    							</span>'; ?>
	    						</td>
	    					</tr>
	    				</table>
	    				<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
	    					<tr>
	    						<td width="150" valign="middle">
	    							<b><?php echo TEXT_USERNAME; ?></b>
			                	</td>
	    						<td valign="middle">
	    							<?php echo xtc_draw_input_field_installer('DB_SERVER_USERNAME'); ?>
	    							<?php echo ' <span'.mouseOverJS(TEXT_USERNAME,TEXT_USERNAME_LONG).'>
	    								<img src="images/icons/icon_help.gif" alt="" />
	    							</span>'; ?>
	    						</td>
	    					</tr>
	    				</table>
	    				<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
	    					<tr>
	    						<td width="150" valign="middle">
	    							<b><?php echo TEXT_PASSWORD; ?></b>
			                	</td>
	    						<td valign="middle">
	    							<?php echo xtc_draw_input_field_installer('DB_SERVER_PASSWORD','',''); ?>
	    							<?php echo ' <span'.mouseOverJS(TEXT_PASSWORD,TEXT_PASSWORD_LONG).'>
	    								<img src="images/icons/icon_help.gif" alt="" />
	    							</span>'; ?>
	    						</td>
	    					</tr>
	    				</table>
	    				<h2 class="schatten"><?php echo TITLE_WEBSERVER_SETTINGS; ?></h2>
	    			</td>
	    		</tr>
	    		<tr>
	    			<td valign="top">
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
	    			<td valign="top">
	    				<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
	    					<tr>
	    						<td valign="middle" width="280">
	    							<b><?php echo TEXT_WS_ROOT; ?></b>
	    						</td>
	    						<td valign="middle">
	    							<?php echo xtc_draw_input_field_installer('DIR_FS_DOCUMENT_ROOT', $dir_fs_www_root,'','size=40'); ?>
	    							<?php echo ' <span'.mouseOverJS(TEXT_WS_ROOT,TEXT_WS_ROOT_LONG).'>
	    								<img src="images/icons/icon_help.gif" alt="" />
	    							</span>'; ?>
	    						</td>
	    					</tr>
	    				</table>
	    				<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
	    					<tr>
	    						<td valign="middle" width="280">
	    							<b><?php echo TEXT_WS_CSEO; ?></b>
	    						</td>
	    						<td valign="middle">
	    							<?php echo xtc_draw_input_field_installer('DIR_FS_CATALOG', $local_install_path,'','size=40'); ?>
	    							<?php echo ' <span'.mouseOverJS(TEXT_WS_CSEO,TEXT_WS_CSEO_LONG).'>
	    								<img src="images/icons/icon_help.gif" alt="" />
	    							</span>'; ?>
	    						</td>
	    					</tr>
	    				</table>
	    				<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
	    					<tr>
	    						<td valign="middle" width="280">
	    							<b><?php echo TEXT_WS_ADMIN; ?></b>
	    						</td>
	    						<td valign="middle">
	    							<?php echo xtc_draw_input_field_installer('DIR_FS_ADMIN', $local_install_path.'admin/','','size=40'); ?>
	    							<?php echo ' <span'.mouseOverJS(TEXT_WS_ADMIN,TEXT_WS_ADMIN_LONG).'>
	    								<img src="images/icons/icon_help.gif" alt="" />
	    							</span>'; ?>
	    						</td>
	    					</tr>
	    				</table>
	    				<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
	    					<tr>
	    						<td valign="middle" width="280">
	    							<b> <?php echo TEXT_WS_CATALOG; ?></b>
	    						</td>
	    						<td valign="middle">
	    							<?php echo xtc_draw_input_field_installer('DIR_WS_CATALOG', $dir_ws_www_root . '/','','size=40'); ?>
	    							<?php echo ' <span'.mouseOverJS(TEXT_WS_CATALOG,TEXT_WS_CATALOG_LONG).'>
	    								<img src="images/icons/icon_help.gif" alt="" />
	    							</span>'; ?>
	    						</td>
	    					</tr>
	    				</table>
	    				<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
	    					<tr>
	    						<td valign="middle" width="280">
	    							<b> <?php echo TEXT_WS_ADMINTOOL; ?></b>
	    						</td>
	    						<td valign="middle">
	    							<?php echo xtc_draw_input_field_installer('DIR_WS_ADMIN', $dir_ws_www_root . '/admin/','','size=40'); ?>
	    							<?php echo ' <span'.mouseOverJS(TEXT_WS_ADMINTOOL,TEXT_WS_ADMINTOOL_LONG).'>
	    								<img src="images/icons/icon_help.gif" alt="" />
	    							</span>'; ?>
	    						</td>
	    					</tr>
	    				</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td class="columnRight" valign="top">
						<table border="0" width="100%" cellspacing="8" cellpadding="8">
							<tr>
								<td align="center">
									<a class="button" href="index.php">
										Abbruch
									</a>
								</td>
								<td align="center">
									<input class="button" type="submit" value="weiter zu Schritt 2" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<table id="footer" width="100%">
	<tr>
		<td valign="bottom" align="center"><?php echo TEXT_FOOTER; ?></td>
	</tr>
</table>
</body>
</html>