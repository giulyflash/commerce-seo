<?php
/*-----------------------------------------------------------------
* 	ID:						install_step5.php
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

$db = array();
$db['DB_SERVER'] = trim(stripslashes($_POST['DB_SERVER']));
$db['DB_SERVER_USERNAME'] = trim(stripslashes($_POST['DB_SERVER_USERNAME']));
$db['DB_SERVER_PASSWORD'] = trim(stripslashes($_POST['DB_SERVER_PASSWORD']));
$db['DB_DATABASE'] = trim(stripslashes($_POST['DB_DATABASE']));
$db_error = false;
xtc_db_connect_installer($db['DB_SERVER'], $db['DB_SERVER_USERNAME'], $db['DB_SERVER_PASSWORD']);

if (!$db_error)
	xtc_db_test_connection($db['DB_DATABASE']);
	
if ($db_error) {
	$img_box = xtc_image(DIR_WS_ICONS.'/icons/cancel.gif');
	$class_box = 'red';
} else {
	$img_box = xtc_image(DIR_WS_ICONS.'/icons/tick.gif');
	$class_box = 'ok';
}
include('includes/metatag.php');
?>
<title>commerce:SEO Installation - Schritt 5</title> 
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
					<table class="menu_items <?php echo $class_box; ?>" width="100%">
						<tr>
							<td width="1" valign="middle">
								<?php echo $img_box; ?>
							</td>
							<td valign="middle">
								<?php echo BOX_WEBSERVER_SETTINGS; ?>
							</td>
						</tr>
					</table>
					<table class="menu_items <?php echo $class_box; ?>" width="100%" style="padding-left:20px">
						<tr>
							<td width="1" valign="middle">
								<?php echo $img_box; ?>
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
								<h1 class="schatten">Schritt 5</h1>
							</td>
						</tr>
					</table>
					<?php if ($db_error) { ?>
						<form name="install" action="install_step4.php" method="post">
							<fieldset class="installer red">
								<legend><strong><span style="color:#EB5E00"><?php echo TEXT_CONNECTION_ERROR; ?></span></strong></legend>
								<p><strong><?php echo TEXT_DB_ERROR; ?></strong></p>
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
					<?php } else { 
						$file_contents = '<?php' . "\n" .
	                      '/* --------------------------------------------------------------' . "\n" .
	                     '' . "\n" .
	                     'Copyright 2012 - commerce:SEO - ein Projekt von Webdesign Erfurt' . "\n" .
	                     'website: http://www.commerce-seo.de' . "\n" .
	                     '' . "\n" .
	                     '--------------------------------------------------------------' . "\n" .
	                     'based on:' . "\n" .
	                     '(c) 2000-2001 The Exchange Project' . "\n" .
	                     '(c) 2002-2003 osCommerce' . "\n" .
	                     '(c) 2003-2005 xtCommerce' . "\n" .
	                     '' . "\n" .
	                     'Released under the GNU General Public License' . "\n" .
	                     '--------------------------------------------------------------*/' . "\n" .
	                     '' . "\n" .
	                     '// * DIR_FS_* = Filesystem directories (local/physical)' . "\n" .
	                     '// * DIR_WS_* = Webserver directories (virtual/URL)' . "\n" .
	                     'define(\'HTTP_SERVER\', \'' . $_POST['HTTP_SERVER'] . '\'); ' . "\n" .
	                     'define(\'HTTPS_SERVER\', \'' . $_POST['HTTPS_SERVER'] . '\'); ' . "\n" .
	                     'define(\'ENABLE_SSL\', ' . (($_POST['ENABLE_SSL'] == 'true') ? 'true' : 'false') . '); ' . "\n" .
	                     'define(\'DIR_WS_CATALOG\', \'' . $_POST['DIR_WS_CATALOG'] . '\'); ' . "\n" .
	                     'define(\'DIR_FS_DOCUMENT_ROOT\', \'' . $_SERVER['DOCUMENT_ROOT'].$local_install_path  . '\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG\', \'' . $_SERVER['DOCUMENT_ROOT'].$local_install_path  . '\');' . "\n" .
	                     'define(\'COMMERCE_SEO_V22_INSTALLED\', \'true\');' . "\n" .
	                     'define(\'DIR_WS_IMAGES\', \'images/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_MOVIES\', DIR_WS_IMAGES .\'products_movies/\');' . "\n" .
	                     'define(\'DIR_WS_ORIGINAL_IMAGES\', DIR_WS_IMAGES .\'product_images/original_images/\');' . "\n" .
	                     'define(\'DIR_WS_THUMBNAIL_IMAGES\', DIR_WS_IMAGES .\'product_images/thumbnail_images/\');' . "\n" .
	                     'define(\'DIR_WS_INFO_IMAGES\', DIR_WS_IMAGES .\'product_images/info_images/\');' . "\n" .
	                     'define(\'DIR_WS_MINI_IMAGES\', DIR_WS_IMAGES .\'product_images/mini_images/\');' . "\n" .
	                     'define(\'DIR_WS_POPUP_IMAGES\', DIR_WS_IMAGES .\'product_images/popup_images/\');' . "\n" .
	                     'define(\'DIR_WS_ICONS\', DIR_WS_IMAGES . \'icons/\');' . "\n" .
	                     'define(\'DIR_WS_INCLUDES\',DIR_FS_DOCUMENT_ROOT. \'includes/\');' . "\n" .
	                     'define(\'DIR_WS_FUNCTIONS\', DIR_WS_INCLUDES . \'functions/\');' . "\n" .
	                     'define(\'DIR_WS_CLASSES\', DIR_WS_INCLUDES . \'classes/\');' . "\n" .
	                     'define(\'DIR_WS_MODULES\', DIR_WS_INCLUDES . \'modules/\');' . "\n" .
	                     'define(\'DIR_WS_LANGUAGES\', DIR_FS_CATALOG . \'lang/\');' . "\n" .
	                     'define(\'DIR_WS_DOWNLOAD_PUBLIC\', DIR_WS_CATALOG . \'pub/\');' . "\n" .
	                     'define(\'DIR_FS_DOWNLOAD\', DIR_FS_CATALOG . \'download/\');' . "\n" .
	                     'define(\'DIR_FS_DOWNLOAD_PUBLIC\', DIR_FS_CATALOG . \'pub/\');' . "\n" .
	                     'define(\'DIR_FS_INC\', DIR_FS_CATALOG . \'inc/\');' . "\n" .
	                     'define(\'SALT_KEY\', \'' . $_POST['SALT_KEY'] . '\');' . "\n" .		
	                     '' . "\n" .
	                     'define(\'DB_SERVER\', \'' . $_POST['DB_SERVER'] . '\');' . "\n" .
	                     'define(\'DB_SERVER_USERNAME\', \'' . $_POST['DB_SERVER_USERNAME'] . '\');' . "\n" .
	                     'define(\'DB_SERVER_PASSWORD\', \'' . $_POST['DB_SERVER_PASSWORD']. '\');' . "\n" .
	                     'define(\'DB_DATABASE\', \'' . $_POST['DB_DATABASE']. '\');' . "\n" .
	                     'define(\'USE_PCONNECT\', \'' . (($_POST['USE_PCONNECT'] == 'true') ? 'true' : 'false') . '\');' . "\n" .
	                     'define(\'STORE_SESSIONS\', \'' . (($_POST['STORE_SESSIONS'] == 'files') ? '' : 'mysql') . '\'); // frei lassen \'\' fuer Standard oder zu  \'mysql\' aendern' . "\n" .                     '?>';
	    $fp = fopen(DIR_FS_CATALOG . 'includes/configure.php', 'w');
	    fputs($fp, $file_contents);
	    fclose($fp);
	
	    $file_contents = '<?php' . "\n" .
	                      '/* --------------------------------------------------------------' . "\n" .
	                     '' . "\n" .
	                     'Copyright 2012 - commerce:SEO - ein Projekt von Webdesign Erfurt' . "\n" .
	                     'website: http://www.commerce-seo.de' . "\n" .
	                     '' . "\n" .
	                     '--------------------------------------------------------------' . "\n" .
	                     'based on:' . "\n" .
	                     '(c) 2000-2001 The Exchange Project' . "\n" .
	                     '(c) 2002-2003 osCommerce' . "\n" .
	                     '(c) 2003-2005 xtCommerce' . "\n" .
	                     '' . "\n" .
	                     'Released under the GNU General Public License' . "\n" .
	                     '--------------------------------------------------------------*/' . "\n" .
	                     '' . "\n" .
	                     '// * DIR_FS_* = Filesystem directories (local/physical)' . "\n" .
	                     '// * DIR_WS_* = Webserver directories (virtual/URL)' . "\n" .
	                     'define(\'HTTP_SERVER\', \'' . $_POST['HTTP_SERVER'] . '\'); ' . "\n" .
	                     'define(\'HTTPS_SERVER\', \'' . $_POST['HTTPS_SERVER'] . '\'); ' . "\n" .
	                     'define(\'ENABLE_SSL\', ' . (($_POST['ENABLE_SSL'] == 'true') ? 'true' : 'false') . '); ' . "\n" .
	                     'define(\'DIR_WS_CATALOG\', \'' . $_POST['DIR_WS_CATALOG'] . '\'); // absolute path required' . "\n" .
	                     'define(\'DIR_FS_DOCUMENT_ROOT\', \'' . $_SERVER['DOCUMENT_ROOT'].$local_install_path  . '\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG\', \'' . $_SERVER['DOCUMENT_ROOT'].$local_install_path  . '\');' . "\n" .
						 'define(\'COMMERCE_SEO_V22_INSTALLED\', \'true\');' . "\n" .
	                     'define(\'DIR_WS_IMAGES\', \'images/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_MOVIES\', DIR_WS_IMAGES .\'products_movies/\');' . "\n" .
	                     'define(\'DIR_WS_ORIGINAL_IMAGES\', DIR_WS_IMAGES .\'product_images/original_images/\');' . "\n" .
	                     'define(\'DIR_WS_THUMBNAIL_IMAGES\', DIR_WS_IMAGES .\'product_images/thumbnail_images/\');' . "\n" .
	                     'define(\'DIR_WS_INFO_IMAGES\', DIR_WS_IMAGES .\'product_images/info_images/\');' . "\n" .
	                     'define(\'DIR_WS_MINI_IMAGES\', DIR_WS_IMAGES .\'product_images/mini_images/\');' . "\n" .
	                     'define(\'DIR_WS_POPUP_IMAGES\', DIR_WS_IMAGES .\'product_images/popup_images/\');' . "\n" .
	                     'define(\'DIR_WS_ICONS\', DIR_WS_IMAGES . \'icons/\');' . "\n" .
	                     'define(\'DIR_WS_INCLUDES\',DIR_FS_DOCUMENT_ROOT. \'includes/\');' . "\n" .
	                     'define(\'DIR_WS_FUNCTIONS\', DIR_WS_INCLUDES . \'functions/\');' . "\n" .
	                     'define(\'DIR_WS_CLASSES\', DIR_WS_INCLUDES . \'classes/\');' . "\n" .
	                     'define(\'DIR_WS_MODULES\', DIR_WS_INCLUDES . \'modules/\');' . "\n" .
	                     'define(\'DIR_WS_LANGUAGES\', DIR_FS_CATALOG . \'lang/\');' . "\n" .
	                     '' . "\n" .
	                     'define(\'DIR_WS_DOWNLOAD_PUBLIC\', DIR_WS_CATALOG . \'pub/\');' . "\n" .
	                     'define(\'DIR_FS_DOWNLOAD\', DIR_FS_CATALOG . \'download/\');' . "\n" .
	                     'define(\'DIR_FS_DOWNLOAD_PUBLIC\', DIR_FS_CATALOG . \'pub/\');' . "\n" .
	                     'define(\'DIR_FS_INC\', DIR_FS_CATALOG . \'inc/\');' . "\n" .
						 'define(\'SALT_KEY\', \'' . $_POST['SALT_KEY'] . '\');' . "\n" .		
	                     '' . "\n" .
	                     'define(\'DB_SERVER\', \'' . $_POST['DB_SERVER'] . '\');' . "\n" .
	                     'define(\'DB_SERVER_USERNAME\', \'' . $_POST['DB_SERVER_USERNAME'] . '\');' . "\n" .
	                     'define(\'DB_SERVER_PASSWORD\', \'' . $_POST['DB_SERVER_PASSWORD']. '\');' . "\n" .
	                     'define(\'DB_DATABASE\', \'' . $_POST['DB_DATABASE']. '\');' . "\n" .
	                     'define(\'USE_PCONNECT\', \'' . (($_POST['USE_PCONNECT'] == 'true') ? 'true' : 'false') . '\');' . "\n" .
	                     'define(\'STORE_SESSIONS\', \'' . (($_POST['STORE_SESSIONS'] == 'files') ? '' : 'mysql') . '\'); // frei lassen \'\' fuer Standard oder zu  \'mysql\' aendern' . "\n" .
	                     '?>';
	    $fp = fopen(DIR_FS_CATALOG . 'includes/configure.org.php', 'w');
	    fputs($fp, $file_contents);
	    fclose($fp);
	//create a configure.php
	    $file_contents = '<?php' . "\n" .
	                     '/* --------------------------------------------------------------' . "\n" .
	                     '' . "\n" .
	                     'Copyright 2012 - commerce:SEO - ein Projekt von Webdesign Erfurt' . "\n" .
	                     'website: http://www.commerce-seo.de' . "\n" .
	                     '' . "\n" .
	                     '--------------------------------------------------------------' . "\n" .
	                     'based on:' . "\n" .
	                     '(c) 2000-2001 The Exchange Project' . "\n" .
	                     '(c) 2002-2003 osCommerce' . "\n" .
	                     '(c) 2003-2005 xtCommerce' . "\n" .
	                     '' . "\n" .
	                     'Released under the GNU General Public License' . "\n" .
	                     '--------------------------------------------------------------*/' . "\n" .
	                     '' . "\n" .
	                     '// * DIR_FS_* = Filesystem directories (local/physical)' . "\n" .
	                     '// * DIR_WS_* = Webserver directories (virtual/URL)' . "\n" .
	                     'define(\'HTTP_SERVER\', \'' . $_POST['HTTP_SERVER'] . '\');' . "\n" .
	                     'define(\'HTTP_CATALOG_SERVER\', \'' . $_POST['HTTP_SERVER'] . '\');' . "\n" .
	                     'define(\'HTTPS_CATALOG_SERVER\', \'' . $_POST['HTTPS_SERVER'] . '\');' . "\n" .
	                     'define(\'ENABLE_SSL_CATALOG\', \'' . (($_POST['ENABLE_SSL'] == 'true') ? 'true' : 'false') . '\'); ' . "\n" .
	                     'define(\'DIR_FS_DOCUMENT_ROOT\', \'' . $_SERVER['DOCUMENT_ROOT'].$local_install_path  . '\'); ' . "\n" .
	                     'define(\'DIR_WS_ADMIN\', \'' . $_POST['DIR_WS_CATALOG'] .'admin/' . '\');' . "\n" .
	                     'define(\'DIR_FS_ADMIN\', \'' . $_SERVER['DOCUMENT_ROOT'].$local_install_path .'admin/' . '\'); ' . "\n" .
	                     'define(\'DIR_WS_CATALOG\', \'' . $_POST['DIR_WS_CATALOG'] . '\'); // absolute path required' . "\n" .
	                     'define(\'DIR_FS_CATALOG\', \'' . $_SERVER['DOCUMENT_ROOT'].$local_install_path  . '\');' . "\n" .
	                     'define(\'COMMERCE_SEO_V22_INSTALLED\', \'true\');' . "\n" .
	                     'define(\'DIR_WS_IMAGES\', \'images/\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG_IMAGES\', DIR_FS_CATALOG . \'images/\');' . "\n" .
						 'define(\'DIR_FS_CATALOG_MOVIES\', DIR_FS_CATALOG_IMAGES . \'products_movies/\');' . "\n" . 
	                     'define(\'DIR_FS_CATALOG_ORIGINAL_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/original_images/\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG_THUMBNAIL_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/thumbnail_images/\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG_INFO_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/info_images/\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG_MINI_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/mini_images/\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG_POPUP_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/popup_images/\');' . "\n" .
	                     'define(\'DIR_WS_ICONS\', DIR_WS_IMAGES . \'icons/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_IMAGES\', DIR_WS_CATALOG . \'images/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_MOVIES\', DIR_WS_CATALOG_IMAGES .\'products_movies/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_ORIGINAL_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/original_images/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_THUMBNAIL_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/thumbnail_images/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_INFO_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/info_images/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_MINI_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/mini_images/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_POPUP_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/popup_images/\');' . "\n" .
	                     'define(\'DIR_WS_INCLUDES\', \'includes/\');' . "\n" .
	                     'define(\'DIR_WS_BOXES\', DIR_WS_INCLUDES . \'boxes/\');' . "\n" .
	                     'define(\'DIR_WS_FUNCTIONS\', DIR_WS_INCLUDES . \'functions/\');' . "\n" .
	                     'define(\'DIR_WS_CLASSES\', DIR_WS_INCLUDES . \'classes/\');' . "\n" .
	                     'define(\'DIR_WS_MODULES\', DIR_WS_INCLUDES . \'modules/\');' . "\n" .
	                     'define(\'DIR_WS_LANGUAGES\', DIR_WS_CATALOG. \'lang/\');' . "\n" .
	                     'define(\'DIR_FS_LANGUAGES\', DIR_FS_CATALOG. \'lang/\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG_MODULES\', DIR_FS_CATALOG . \'includes/modules/\');' . "\n" .
	                     'define(\'DIR_FS_BACKUP\', DIR_FS_ADMIN . \'backups/\');' . "\n" .
	                     'define(\'DIR_FS_INC\', DIR_FS_CATALOG . \'inc/\');' . "\n" .
	                     'define(\'DIR_WS_FILEMANAGER\', DIR_WS_MODULES . \'fckeditor/editor/filemanager/browser/default/\');' . "\n" .					 
						 'define(\'SALT_KEY\', \'' . $_POST['SALT_KEY'] . '\');' . "\n" .					 
	                     '' . "\n" .
	                     'define(\'DB_SERVER\', \'' . $_POST['DB_SERVER'] . '\');' . "\n" .
	                     'define(\'DB_SERVER_USERNAME\', \'' . $_POST['DB_SERVER_USERNAME'] . '\');' . "\n" .
	                     'define(\'DB_SERVER_PASSWORD\', \'' . $_POST['DB_SERVER_PASSWORD']. '\');' . "\n" .
	                     'define(\'DB_DATABASE\', \'' . $_POST['DB_DATABASE']. '\');' . "\n" .
	                     'define(\'USE_PCONNECT\', \'' . (($_POST['USE_PCONNECT'] == 'true') ? 'true' : 'false') . '\');' . "\n" .
	                     'define(\'STORE_SESSIONS\', \'' . (($_POST['STORE_SESSIONS'] == 'files') ? '' : 'mysql') . '\'); // frei lassen \'\' fuer Standard oder zu  \'mysql\' aendern' . "\n" .
	                     '' . "\n" .
	 '?>';
	    $fp = fopen(DIR_FS_CATALOG . 'admin/includes/configure.php', 'w');
	    fputs($fp, $file_contents);
	    fclose($fp);
	
	
	//Create a backup of the original configure
	    $file_contents = '<?php' . "\n" .
	                    '/* --------------------------------------------------------------' . "\n" .
	                     '' . "\n" .
	                     'Copyright 2012 - commerce:SEO - ein Projekt von Webdesign Erfurt' . "\n" .
	                     'website: http://www.commerce-seo.de' . "\n" .
	                     '' . "\n" .
	                     '--------------------------------------------------------------' . "\n" .
	                     'based on:' . "\n" .
	                     '(c) 2000-2001 The Exchange Project' . "\n" .
	                     '(c) 2002-2003 osCommerce' . "\n" .
	                     '(c) 2003-2005 xtCommerce' . "\n" .
	                     '' . "\n" .
	                     'Released under the GNU General Public License' . "\n" .
	                     '--------------------------------------------------------------*/' . "\n" .
	                     '' . "\n" .
	                     '// * DIR_FS_* = Filesystem directories (local/physical)' . "\n" .
	                     '// * DIR_WS_* = Webserver directories (virtual/URL)' . "\n" .
	                     'define(\'HTTP_SERVER\', \'' . $_POST['HTTP_SERVER'] . '\');' . "\n" .
	                     'define(\'HTTP_CATALOG_SERVER\', \'' . $_POST['HTTP_SERVER'] . '\');' . "\n" .
	                     'define(\'HTTPS_CATALOG_SERVER\', \'' . $_POST['HTTPS_SERVER'] . '\');' . "\n" .
	                     'define(\'ENABLE_SSL_CATALOG\', \'' . (($_POST['ENABLE_SSL'] == 'true') ? 'true' : 'false') . '\');' . "\n" .
	                     'define(\'DIR_FS_DOCUMENT_ROOT\', \'' . $_SERVER['DOCUMENT_ROOT'].$local_install_path  . '\');' . "\n" .
	                     'define(\'DIR_WS_ADMIN\', \'' . $_POST['DIR_WS_CATALOG'] .'admin/' . '\'); // absolute path required' . "\n" .
	                     'define(\'DIR_FS_ADMIN\', \'' . $_SERVER['DOCUMENT_ROOT'].$local_install_path .'admin/' . '\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG\', \'' . $_POST['DIR_WS_CATALOG'] . '\'); // absolute path required' . "\n" .
	                     'define(\'DIR_FS_CATALOG\', \'' . $_SERVER['DOCUMENT_ROOT'].$local_install_path  . '\');' . "\n" .
						 'define(\'COMMERCE_SEO_V22_INSTALLED\', \'true\');' . "\n" .
	                     'define(\'DIR_WS_IMAGES\', \'images/\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG_IMAGES\', DIR_FS_CATALOG . \'images/\');' . "\n" .
						 'define(\'DIR_FS_CATALOG_MOVIES\', DIR_FS_CATALOG_IMAGES . \'products_movies/\');' . "\n" . 
	                     'define(\'DIR_FS_CATALOG_ORIGINAL_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/original_images/\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG_THUMBNAIL_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/thumbnail_images/\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG_INFO_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/info_images/\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG_MINI_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/mini_images/\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG_POPUP_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/popup_images/\');' . "\n" .
	                     'define(\'DIR_WS_ICONS\', DIR_WS_IMAGES . \'icons/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_IMAGES\', DIR_WS_CATALOG . \'images/\');' . "\n" .
						 'define(\'DIR_WS_CATALOG_MOVIES\', DIR_WS_CATALOG_IMAGES . \'products_movies/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_ORIGINAL_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/original_images/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_THUMBNAIL_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/thumbnail_images/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_INFO_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/info_images/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_MINI_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/mini_images/\');' . "\n" .
	                     'define(\'DIR_WS_CATALOG_POPUP_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/popup_images/\');' . "\n" .
	                     'define(\'DIR_WS_INCLUDES\', \'includes/\');' . "\n" .
	                     'define(\'DIR_WS_BOXES\', DIR_WS_INCLUDES . \'boxes/\');' . "\n" .
	                     'define(\'DIR_WS_FUNCTIONS\', DIR_WS_INCLUDES . \'functions/\');' . "\n" .
	                     'define(\'DIR_WS_CLASSES\', DIR_WS_INCLUDES . \'classes/\');' . "\n" .
	                     'define(\'DIR_WS_MODULES\', DIR_WS_INCLUDES . \'modules/\');' . "\n" .
	                     'define(\'DIR_WS_LANGUAGES\', DIR_WS_CATALOG. \'lang/\');' . "\n" .
	                     'define(\'DIR_FS_LANGUAGES\', DIR_FS_CATALOG. \'lang/\');' . "\n" .
	                     'define(\'DIR_FS_CATALOG_MODULES\', DIR_FS_CATALOG . \'includes/modules/\');' . "\n" .
	                     'define(\'DIR_FS_BACKUP\', DIR_FS_ADMIN . \'backups/\');' . "\n" .
	                     'define(\'DIR_FS_INC\', DIR_FS_CATALOG . \'inc/\');' . "\n" .
	                     'define(\'DIR_WS_FILEMANAGER\', DIR_WS_MODULES . \'fckeditor/editor/filemanager/browser/default/\');' . "\n" .					 
						 'define(\'SALT_KEY\', \'' . $_POST['SALT_KEY'] . '\');' . "\n" .			 
	                     '' . "\n" .
	                     'define(\'DB_SERVER\', \'' . $_POST['DB_SERVER'] . '\');' . "\n" .
	                     'define(\'DB_SERVER_USERNAME\', \'' . $_POST['DB_SERVER_USERNAME'] . '\');' . "\n" .
	                     'define(\'DB_SERVER_PASSWORD\', \'' . $_POST['DB_SERVER_PASSWORD']. '\');' . "\n" .
	                     'define(\'DB_DATABASE\', \'' . $_POST['DB_DATABASE']. '\');' . "\n" .
	                     'define(\'USE_PCONNECT\', \'' . (($_POST['USE_PCONNECT'] == 'true') ? 'true' : 'false') . '\');' . "\n" .
	                     'define(\'STORE_SESSIONS\', \'' . (($_POST['STORE_SESSIONS'] == 'files') ? '' : 'mysql') . '\'); // frei lassen \'\' fuer Standard oder zu  \'mysql\' aendern' . "\n" .
	                     '' . "\n" .
	
	 '?>';
	
	    $fp = fopen(DIR_FS_CATALOG . 'admin/includes/configure.org.php', 'w');
	    fputs($fp, $file_contents);
	    fclose($fp); ?>
						<fieldset class="installer green">
							<legend><strong><span style="color:#4eb56c"><?php echo TEXT_TITLE_SUCCESS; ?></span></strong></legend>
							<p><?php echo TEXT_WELCOME_STEP5; ?></p>
							<p><?php echo TEXT_WS_CONFIGURATION_SUCCESS; ?></p>
						</fieldset>
						<table width="100%" cellspacing="8" cellpadding="8">
							<tr>
								<td align="center" valign="middle">
									<a class="button" href="install_step6.php">
										weiter zu Schritt 6
									</a>
								</td>
							</tr>
						</table>
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
