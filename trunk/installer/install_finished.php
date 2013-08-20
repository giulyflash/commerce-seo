<?php
/*-----------------------------------------------------------------
* 	ID:						install_finished.php
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
require('../admin/includes/configure.php');
include('language/'.$_SESSION['language'].'.php');
include('includes/metatag.php');
?>
<title>commerce:SEO - Installation abgeschlossen</title>
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
								<?php echo xtc_image(DIR_WS_ICONS.'/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_LANGUAGE; ?>
							</td>
						</tr>
					</table><br />
					<table class="menu_items ok" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_DB_CONNECTION; ?>
							</td>
						</tr>
					</table>
					<table class="menu_items ok" width="100%" style="padding-left:20px">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_DB_IMPORT; ?>
							</td>
						</tr>
					</table><br />
					<table class="menu_items ok" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_WEBSERVER_SETTINGS; ?>
							</td>
						</tr>
					</table>
					<table class="menu_items ok" width="100%" style="padding-left:20px">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_WRITE_CONFIG; ?>
							</td>
						</tr>
					</table><br />
					<table class="menu_items ok" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_ADMIN_CONFIG; ?>
							</td>
						</tr>
					</table><br />
					<table class="menu_items ok" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/tick.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_USERS_CONFIG; ?>
							</td>
						</tr>
					</table>
				</td>
				<td class="columnRight" valign="top">
					<table class="table_pageHeading" border="0" width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td class="pageHeading">
								<h1 class="schatten">Installation abgeschlossen</h1>
							</td>
						</tr>
					</table>
					<h2 class="schatten"><?php echo TEXT_SHOP_CONFIG_SUCCESS; ?></h2>
					<p><?php echo TEXT_WELCOME_FINISHED; ?></p><br />
					<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
						<tr>
							<td valign="middle" align="center">
							    <?php echo TEXT_TEAM; ?>
							</td>
						</tr>
					</table>
					<table cellpadding="8" cellspacing="8" width="100%">
						<tr>
							<td valign="middle" align="center">
							    <a class="button" href="<?php echo HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'index.php'; ?>">
							    	zum Shop wechseln
							    </a>
							</td>
						</tr>
					</table>
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