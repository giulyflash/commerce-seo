<?php
/*-----------------------------------------------------------------
* 	ID:						install_step7.php
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

require('../includes/configure.php');
require('includes/application.php');
require_once(DIR_FS_INC . 'xtc_rand.inc.php');
require_once(DIR_FS_INC . 'xtc_encrypt_password.inc.php');
require_once(DIR_FS_INC . 'xtc_db_connect.inc.php');
require_once(DIR_FS_INC . 'xtc_db_query.inc.php');
require_once(DIR_FS_INC . 'xtc_db_fetch_array.inc.php');
require_once(DIR_FS_INC . 'xtc_validate_email.inc.php');
require_once(DIR_FS_INC . 'xtc_db_input.inc.php');
require_once(DIR_FS_INC . 'xtc_db_num_rows.inc.php');
require_once(DIR_FS_INC . 'xtc_redirect.inc.php');
require_once(DIR_FS_INC . 'xtc_href_link.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_pull_down_menu.inc.php');
require_once(DIR_FS_INC . 'xtc_draw_input_field.inc.php');
require_once(DIR_FS_INC . 'xtc_get_country_list.inc.php');
include('language/'.$_SESSION['language'].'.php');

xtc_db_connect() or die('Unable to connect to database server!');

$configuration_query = xtc_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
while ($configuration = xtc_db_fetch_array($configuration_query)) {
	define($configuration['cfgKey'], $configuration['cfgValue']);
}

$messageStack = new messageStack();

$process = false;
if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    $process = true;

    $status_discount = xtc_db_prepare_input($_POST['STATUS_DISCOUNT']);
    $status_ot_discount_flag = xtc_db_prepare_input($_POST['STATUS_OT_DISCOUNT_FLAG']);
    $status_ot_discount = xtc_db_prepare_input($_POST['STATUS_OT_DISCOUNT']);
    $graduated_price = xtc_db_prepare_input($_POST['STATUS_GRADUATED_PRICE']);
    $show_price = xtc_db_prepare_input($_POST['STATUS_SHOW_PRICE']);
    $show_tax = xtc_db_prepare_input($_POST['STATUS_SHOW_TAX']);


    $status_discount2 = xtc_db_prepare_input($_POST['STATUS_DISCOUNT2']);
    $status_ot_discount_flag2 = xtc_db_prepare_input($_POST['STATUS_OT_DISCOUNT_FLAG2']);
    $status_ot_discount2 = xtc_db_prepare_input($_POST['STATUS_OT_DISCOUNT2']);
    $graduated_price2 = xtc_db_prepare_input($_POST['STATUS_GRADUATED_PRICE2']);
    $show_price2 = xtc_db_prepare_input($_POST['STATUS_SHOW_PRICE2']);
    $show_tax2 = xtc_db_prepare_input($_POST['STATUS_SHOW_TAX2']);
    
    $status_discount3 = xtc_db_prepare_input($_POST['STATUS_DISCOUNT3']);
    $status_ot_discount_flag3 = xtc_db_prepare_input($_POST['STATUS_OT_DISCOUNT_FLAG3']);
    $status_ot_discount3 = xtc_db_prepare_input($_POST['STATUS_OT_DISCOUNT3']);
    $graduated_price3 = xtc_db_prepare_input($_POST['STATUS_GRADUATED_PRICE3']);
    $show_price3 = xtc_db_prepare_input($_POST['STATUS_SHOW_PRICE3']);
    $show_tax3 = xtc_db_prepare_input($_POST['STATUS_SHOW_TAX3']);

    $error = false;
    // Standard fuer Gaeste
	if (strlen($status_discount) < '3') {
		$error = true;
		$messageStack->add('install_step7', ENTRY_DISCOUNT_ERROR);
	}
	if (strlen($status_ot_discount) < '3') {
		$error = true;
		$messageStack->add('install_step7', ENTRY_OT_DISCOUNT_ERROR);
	}
	if ( ($status_ot_discount_flag != '1') && ($status_ot_discount_flag != '0') ) {
		$error = true;
		$messageStack->add('install_step7', SELECT_OT_DISCOUNT_ERROR);
	}
	if ( ($graduated_price != '1') && ($graduated_price != '0') ) {
		$error = true;
		$messageStack->add('install_step7', SELECT_GRADUATED_ERROR);
	}
	if ( ($show_price != '1') && ($show_price != '0') ) {
		$error = true;
		$messageStack->add('install_step7', SELECT_PRICE_ERROR);
	}
	if ( ($show_tax != '1') && ($show_tax != '0') ) {
		$error = true;
		$messageStack->add('install_step7', SELECT_TAX_ERROR);
	}
	
	// Standard fuer "Neuer Kunde"
	if (strlen($status_discount2) < '3') {
		$error = true;
		$messageStack->add('install_step7', ENTRY_DISCOUNT_ERROR2);
	}
	if (strlen($status_ot_discount2) < '3') {
		$error = true;
		$messageStack->add('install_step7', ENTRY_OT_DISCOUNT_ERROR2);
	}
	if ( ($status_ot_discount_flag2 != '1') && ($status_ot_discount_flag2 != '0') ) {
		$error = true;
		$messageStack->add('install_step7', SELECT_OT_DISCOUNT_ERROR2);
	}
	if ( ($graduated_price2 != '1') && ($graduated_price2 != '0') ) {
		$error = true;
		$messageStack->add('install_step7', SELECT_GRADUATED_ERROR2);
	}
	if ( ($show_price2 != '1') && ($show_price2 != '0') ) {
		$error = true;
		$messageStack->add('install_step7', SELECT_PRICE_ERROR2);
	}
	if ( ($show_tax2 != '1') && ($show_tax2 != '0') ) {
		$error = true;
		$messageStack->add('install_step7', SELECT_TAX_ERROR2);
	}
	
	// Standard fuer "Haendler"
	if (strlen($status_discount2) < '3') {
		$error = true;
		$messageStack->add('install_step7', ENTRY_DISCOUNT_ERROR2);
	}
	if (strlen($status_ot_discount2) < '3') {
		$error = true;
		$messageStack->add('install_step7', ENTRY_OT_DISCOUNT_ERROR2);
	}
	if ( ($status_ot_discount_flag2 != '1') && ($status_ot_discount_flag2 != '0') ) {
		$error = true;
		$messageStack->add('install_step7', SELECT_OT_DISCOUNT_ERROR2);
	}
	if ( ($graduated_price2 != '1') && ($graduated_price2 != '0') ) {
		$error = true;
		$messageStack->add('install_step7', SELECT_GRADUATED_ERROR2);
	}
	if ( ($show_price2 != '1') && ($show_price2 != '0') ) {
		$error = true;
		$messageStack->add('install_step7', SELECT_PRICE_ERROR2);
	}
	if ( ($show_tax2 != '1') && ($show_tax2 != '0') ) {
		$error = true;
		$messageStack->add('install_step7', SELECT_TAX_ERROR2);
	}

	if ($error == false) {

		// admin
		xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES ('0', '1', 'admin', 1, 'admin_status.png', '0.00', '1', '0.00', '1', '1', '1')");
		
		// Standard fuer Gaeste
		xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES (1, 1, 'Guest', 1, 'guest_status.png', '".$status_discount."', '".$status_ot_discount_flag."', '".$status_ot_discount."', '".$graduated_price."', '".$show_price."', '".$show_tax."')");
		
		// Standard fuer "Neuer Kunde"
		xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES (2, 1, 'new Customer', 1, 'customer_status.png', '".$status_discount2."', '".$status_ot_discount_flag2."', '".$status_ot_discount2."', '".$graduated_price2."', '".$show_price2."', '".$show_tax2."')");
		
		// Standard fuer "Haendler"
		xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES (3, 1, 'Merchant', 1, 'merchant_status.png', '".$status_discount3."', '".$status_ot_discount_flag3."', '".$status_ot_discount3."', '".$graduated_price3."', '".$show_price3."', '".$show_tax3."')");
		
		// admin
		xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES ('0', '2', 'Admin', 1, 'admin_status.png', '0.00', '1', '0.00', '1', '1', '1')");
		
		// Standard fuer Gaeste
		xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES (1, 2, 'Gast', 1, 'guest_status.png', '".$status_discount."', '".$status_ot_discount_flag."', '".$status_ot_discount."', '".$graduated_price."', '".$show_price."', '".$show_tax."')");
		
		// Standard fuer "Neuer Kunde"
		xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES (2, 2, 'Neuer Kunde', 1, 'customer_status.png', '".$status_discount2."', '".$status_ot_discount_flag2."', '".$status_ot_discount2."', '".$graduated_price2."', '".$show_price2."', '".$show_tax2."')");
		
		// Standard fuer "Haendler"
		xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES (3, 2, 'H&auml;ndler', 1, 'merchant_status.png', '".$status_discount3."', '".$status_ot_discount_flag3."', '".$status_ot_discount3."', '".$graduated_price3."', '".$show_price3."', '".$show_tax3."')");
		
		// create Group prices (Admin wont get own status!)
		xtc_db_query('SET storage_engine = MYISAM;');
		xtc_db_query("
		CREATE TABLE personal_offers_by_customers_status_ 
		(price_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		products_id int NOT NULL,
		quantity int, 
		personal_offer decimal(15,4),
		KEY products_id (products_id,quantity),
		KEY products_id_2 (products_id)
		)");
		xtc_db_query("
		CREATE TABLE personal_offers_by_customers_status_0 
		(price_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		products_id int NOT NULL,
		quantity int, 
		personal_offer decimal(15,4),
		KEY products_id (products_id,quantity),
		KEY products_id_2 (products_id)
		)");
		xtc_db_query("
		CREATE TABLE personal_offers_by_customers_status_1 
		(price_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		products_id int NOT NULL,
		quantity int, 
		personal_offer decimal(15,4),
		KEY products_id (products_id,quantity),
		KEY products_id_2 (products_id)
		)");
		xtc_db_query("
		CREATE TABLE personal_offers_by_customers_status_2 
		(price_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		products_id int NOT NULL,
		quantity int, 
		personal_offer decimal(15,4),
		KEY products_id (products_id,quantity),
		KEY products_id_2 (products_id)
		)");
		xtc_db_query("
		CREATE TABLE personal_offers_by_customers_status_3 
		(price_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		products_id int NOT NULL,
		quantity int, 
		personal_offer decimal(15,4),
		KEY products_id (products_id,quantity),
		KEY products_id_2 (products_id)
		)");		
		xtc_redirect(xtc_href_link('installer/install_finished.php', '', 'NONSSL'));
	}
}
include('includes/metatag.php');
?>
<title>commerce:SEO Installation - Schritt 7</title>
</head>
<body>
<script type="text/javascript" src="includes/javascript/tooltip.js" encode="UTF-8" ></script>
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
					<table class="menu_items" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo xtc_image(DIR_WS_ICONS.'/icon_arrow_right.gif'); ?>
							</td>
							<td valign="middle">
								<?php echo BOX_ADMIN_CONFIG; ?>
							</td>
						</tr>
					</table>
					<?php if ($messageStack->size('install_step7') > 0) { ?>
						<table class="menu_items" width="100%">
							<tr>
								<td valign="middle"><?php echo $messageStack->output('install_step6'); ?></td>
							</tr>
						</table>
					<?php } ?>
				</td>
				<td class="columnRight" valign="top">
					<table class="table_pageHeading" border="0" width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td class="pageHeading">
								<h1 class="schatten">Schritt 7</h1>
							</td>
						</tr>
					</table>
					<form name="install" action="install_step7.php" method="post" onSubmit="return check_form(install_step6);">
					<p><?php echo TEXT_WELCOME_STEP7; ?></p>
					
					<h2 class="schatten">
						<?php echo TITLE_GUEST_CONFIG; ?>
						<?php echo ' <span'.mouseOverJS('',TITLE_GUEST_CONFIG_NOTE,'','200').'>
							<img src="images/icons/icon_help.gif" alt="" />
						</span>'; ?>
					</h2>
					<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
						<tr>
							<td valign="middle" width="150">
							    <b><?php echo TEXT_STATUS_DISCOUNT; ?></b>
							</td>
							<td valign="middle">
								<?php echo xtc_draw_input_field_installer('STATUS_DISCOUNT','0.00');?>
								<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_DISCOUNT_LONG).'>
								<img src="images/icons/icon_help.gif" alt="" />
								</span>'; ?>
							</td>
						</tr>
					</table>
					<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
						<tr>
							<td valign="middle" width="150">
							    <b><?php echo TEXT_STATUS_OT_DISCOUNT_FLAG; ?></b>
							</td>
							<td valign="middle"> 
								<?php echo  TEXT_ZONE_YES .' '. xtc_draw_radio_field_installer('STATUS_OT_DISCOUNT_FLAG', '1');?>
								<?php echo  TEXT_ZONE_NO .' '. xtc_draw_radio_field_installer('STATUS_OT_DISCOUNT_FLAG', '0', 'true'); ?>
								<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_OT_DISCOUNT_FLAG_LONG).'>
								<img src="images/icons/icon_help.gif" alt="" />
								</span>'; ?>
							</td>
						</tr>
					</table>
					<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
						<tr>
							<td valign="middle" width="150">
							    <b><?php echo TEXT_STATUS_OT_DISCOUNT; ?></b>
							</td>
							<td valign="middle">
								<?php echo xtc_draw_input_field_installer('STATUS_OT_DISCOUNT','0.00');?>
								<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_OT_DISCOUNT_LONG).'>
								<img src="images/icons/icon_help.gif" alt="" />
								</span>'; ?>
							</td>
						</tr>
					</table>
					<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
						<tr>
							<td valign="middle" width="150">
							    <b><?php echo TEXT_STATUS_GRADUATED_PRICE; ?></b>
							</td>
							<td valign="middle">
								<?php echo  TEXT_ZONE_YES.' '. xtc_draw_radio_field_installer('STATUS_GRADUATED_PRICE', '1');?>
								<?php echo  TEXT_ZONE_NO .' '. xtc_draw_radio_field_installer('STATUS_GRADUATED_PRICE', '0', 'true'); ?>
								<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_GRADUATED_PRICE_LONG).'>
								<img src="images/icons/icon_help.gif" alt="" />
								</span>'; ?>
							</td>
						</tr>
					</table>
					<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
						<tr>
							<td valign="middle" width="150">
							    <b><?php echo TEXT_STATUS_SHOW_PRICE; ?></b>
							</td>
							<td valign="middle">
								<?php echo  TEXT_ZONE_YES.' '. xtc_draw_radio_field_installer('STATUS_SHOW_PRICE', '1', 'true'); ?>
								<?php echo  TEXT_ZONE_NO .' '. xtc_draw_radio_field_installer('STATUS_SHOW_PRICE', '0'); ?>
								<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_SHOW_PRICE_LONG).'>
								<img src="images/icons/icon_help.gif" alt="" />
								</span>'; ?>
							</td>
						</tr>
					</table>
					<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
						<tr>
							<td valign="middle" width="150">
							    <b><?php echo TEXT_STATUS_SHOW_TAX; ?></b>
							</td>
							<td valign="middle">
								<?php echo  TEXT_ZONE_YES.' '. xtc_draw_radio_field_installer('STATUS_SHOW_TAX', '1', 'true'); ?>
                      			<?php echo  TEXT_ZONE_NO .' '. xtc_draw_radio_field_installer('STATUS_SHOW_TAX', '0'); ?>
								<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_SHOW_TAX_LONG).'>
								<img src="images/icons/icon_help.gif" alt="" />
								</span>'; ?>
							</td>
						</tr>
					</table>
                    
					<h2 class="schatten">
						<?php echo TITLE_CUSTOMERS_CONFIG; ?>
						<?php echo ' <span'.mouseOverJS('',TITLE_CUSTOMERS_CONFIG_NOTE,'','200').'>
							<img src="images/icons/icon_help.gif" alt="" />
						</span>'; ?>
					</h2>
					<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
						<tr>
							<td valign="middle" width="150">
							    <b><?php echo TEXT_STATUS_DISCOUNT; ?></b>
							</td>
							<td valign="middle">
								<?php echo xtc_draw_input_field_installer('STATUS_DISCOUNT2','0.00');?>
								<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_DISCOUNT_LONG).'>
								<img src="images/icons/icon_help.gif" alt="" />
								</span>'; ?>
							</td>
						</tr>
					</table>
					<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
						<tr>
							<td valign="middle" width="150">
							    <b><?php echo TEXT_STATUS_OT_DISCOUNT_FLAG; ?></b>
							</td>
							<td valign="middle">
								<?php echo  TEXT_ZONE_YES .' '. xtc_draw_radio_field_installer('STATUS_OT_DISCOUNT_FLAG2', '1'); ?>
                      			<?php echo  TEXT_ZONE_NO .' '. xtc_draw_radio_field_installer('STATUS_OT_DISCOUNT_FLAG2', '0', 'true'); ?>
								<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_OT_DISCOUNT_FLAG_LONG).'>
								<img src="images/icons/icon_help.gif" alt="" />
								</span>'; ?>
							</td>
						</tr>
					</table>
					<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
						<tr>
							<td valign="middle" width="150">
							    <b><?php echo TEXT_STATUS_OT_DISCOUNT; ?></b>
							</td>
							<td valign="middle">
								<?php echo xtc_draw_input_field_installer('STATUS_OT_DISCOUNT2','0.00');?>
								<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_OT_DISCOUNT_LONG).'>
								<img src="images/icons/icon_help.gif" alt="" />
								</span>'; ?>
							</td>
						</tr>
					</table>
                    <table cellpadding="8" cellspacing="8" class="table_input" width="100%">
                    	<tr>
                    		<td valign="middle" width="150">
                    		    <b><?php echo TEXT_STATUS_GRADUATED_PRICE; ?></b>
                    		</td>
                    		<td valign="middle">
                    			<?php echo  TEXT_ZONE_YES .' '. xtc_draw_radio_field_installer('STATUS_GRADUATED_PRICE2', '1', 'true'); ?>
                      			<?php echo  TEXT_ZONE_NO .' '. xtc_draw_radio_field_installer('STATUS_GRADUATED_PRICE2', '0'); ?>
                    			<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_GRADUATED_PRICE_LONG).'>
                    			<img src="images/icons/icon_help.gif" alt="" />
                    			</span>'; ?>
                    		</td>
                    	</tr>
                    </table>
                    <table cellpadding="8" cellspacing="8" class="table_input" width="100%">
                    	<tr>
                    		<td valign="middle" width="150">
                    		    <b><?php echo TEXT_STATUS_SHOW_PRICE; ?></b>
                    		</td>
                    		<td valign="middle">
                    			<?php echo  TEXT_ZONE_YES .' '. xtc_draw_radio_field_installer('STATUS_SHOW_PRICE2', '1', 'true'); ?>
                      			<?php echo  TEXT_ZONE_NO .' '. xtc_draw_radio_field_installer('STATUS_SHOW_PRICE2', '0'); ?>
                    			<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_SHOW_PRICE_LONG).'>
                    			<img src="images/icons/icon_help.gif" alt="" />
                    			</span>'; ?>
                    		</td>
                    	</tr>
                    </table>
                    <table cellpadding="8" cellspacing="8" class="table_input" width="100%">
                     	<tr>
                     		<td valign="middle" width="150">
                     		    <b><?php echo TEXT_STATUS_SHOW_TAX; ?></b>
                     		</td>
                     		<td valign="middle">
                     			<?php echo  TEXT_ZONE_YES .' '. xtc_draw_radio_field_installer('STATUS_SHOW_TAX2', '1', 'true'); ?>
                      			<?php echo  TEXT_ZONE_NO .' '. xtc_draw_radio_field_installer('STATUS_SHOW_TAX2', '0'); ?>
                     			<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_SHOW_TAX_LONG).'>
                     			<img src="images/icons/icon_help.gif" alt="" />
                     			</span>'; ?>
                     		</td>
                     	</tr>
					</table>
					
					<h2 class="schatten">
						<?php echo TITLE_MERCHANT_CONFIG; ?>
						<?php echo ' <span'.mouseOverJS('',TITLE_MERCHANT_CONFIG_NOTE,'','200').'>
							<img src="images/icons/icon_help.gif" alt="" />
						</span>'; ?>
					</h2>
					<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
						<tr>
							<td valign="middle" width="150">
							    <b><?php echo TEXT_STATUS_DISCOUNT; ?></b>
							</td>
							<td valign="middle">
								<?php echo xtc_draw_input_field_installer('STATUS_DISCOUNT3','0.00');?>
								<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_DISCOUNT_LONG).'>
								<img src="images/icons/icon_help.gif" alt="" />
								</span>'; ?>
							</td>
						</tr>
					</table>
					<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
						<tr>
							<td valign="middle" width="150">
							    <b><?php echo TEXT_STATUS_OT_DISCOUNT_FLAG; ?></b>
							</td>
							<td valign="middle">
								<?php echo  TEXT_ZONE_YES .' '. xtc_draw_radio_field_installer('STATUS_OT_DISCOUNT_FLAG3', '1', 'true'); ?>
                      			<?php echo  TEXT_ZONE_NO .' '. xtc_draw_radio_field_installer('STATUS_OT_DISCOUNT_FLAG3', '0'); ?>
								<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_OT_DISCOUNT_FLAG_LONG).'>
								<img src="images/icons/icon_help.gif" alt="" />
								</span>'; ?>
							</td>
						</tr>
					</table>
					<table cellpadding="8" cellspacing="8" class="table_input" width="100%">
						<tr>
							<td valign="middle" width="150">
							    <b><?php echo TEXT_STATUS_OT_DISCOUNT; ?></b>
							</td>
							<td valign="middle">
								<?php echo xtc_draw_input_field_installer('STATUS_OT_DISCOUNT3','0.00');?>
								<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_OT_DISCOUNT_LONG).'>
								<img src="images/icons/icon_help.gif" alt="" />
								</span>'; ?>
							</td>
						</tr>
					</table>
                    <table cellpadding="8" cellspacing="8" class="table_input" width="100%">
                    	<tr>
                    		<td valign="middle" width="150">
                    		    <b><?php echo TEXT_STATUS_GRADUATED_PRICE; ?></b>
                    		</td>
                    		<td valign="middle">
                    			<?php echo  TEXT_ZONE_YES .' '. xtc_draw_radio_field_installer('STATUS_GRADUATED_PRICE3', '1', 'true'); ?>
                      			<?php echo  TEXT_ZONE_NO .' '. xtc_draw_radio_field_installer('STATUS_GRADUATED_PRICE3', '0'); ?>
                    			<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_GRADUATED_PRICE_LONG).'>
                    			<img src="images/icons/icon_help.gif" alt="" />
                    			</span>'; ?>
                    		</td>
                    	</tr>
                    </table>
                    <table cellpadding="8" cellspacing="8" class="table_input" width="100%">
                    	<tr>
                    		<td valign="middle" width="150">
                    		    <b><?php echo TEXT_STATUS_SHOW_PRICE; ?></b>
                    		</td>
                    		<td valign="middle">
                    			<?php echo  TEXT_ZONE_YES .' '. xtc_draw_radio_field_installer('STATUS_SHOW_PRICE3', '1', 'true'); ?>
                      			<?php echo  TEXT_ZONE_NO .' '. xtc_draw_radio_field_installer('STATUS_SHOW_PRICE3', '0'); ?>
                    			<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_SHOW_PRICE_LONG).'>
                    			<img src="images/icons/icon_help.gif" alt="" />
                    			</span>'; ?>
                    		</td>
                    	</tr>
                    </table>
                    <table cellpadding="8" cellspacing="8" class="table_input" width="100%">
                     	<tr>
                     		<td valign="middle" width="150">
                     		    <b><?php echo TEXT_STATUS_SHOW_TAX; ?></b>
                     		</td>
                     		<td valign="middle">
                     			<?php echo  TEXT_ZONE_YES .' '. xtc_draw_radio_field_installer('STATUS_SHOW_TAX3', '1'); ?>
                      			<?php echo  TEXT_ZONE_NO .' '. xtc_draw_radio_field_installer('STATUS_SHOW_TAX3', '0', 'true'); ?>
                     			<?php echo ' <span'.mouseOverJS('',TEXT_STATUS_SHOW_TAX_LONG).'>
                     			<img src="images/icons/icon_help.gif" alt="" />
                     			</span>'; ?>
                     		</td>
                     	</tr>
					</table>
					<table cellpadding="8" cellspacing="8" width="100%">
						<tr>
							<td valign="middle" align="center">
							    <input name="image" type="submit" class="button" value="Installation abschliessen" />
							</td>
						</tr>
					</table>
					<input name="action" type="hidden" value="process" />
					</form>
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