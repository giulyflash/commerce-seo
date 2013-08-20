<?php
/*-----------------------------------------------------------------
* 	ID:						application_top.php
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




// Start the clock for the page parse time log
define('PAGE_PARSE_START_TIME', microtime());

// security
define('_VALID_XTC',true);

// Set the level of error reporting
error_reporting( E_ALL & ~E_NOTICE);
#error_reporting(E_ALL);

// Disable use_trans_sid as xtc_href_link() does this manually
if (function_exists('ini_set')) {
	ini_set('session.use_trans_sid', 0);
}

if(file_exists('includes/local/configure.php') && filesize('includes/local/configure.php') !== false) {
	include('includes/local/configure.php');
} elseif(file_exists('includes/configure.php') && filesize('includes/configure.php') !== false) {
	include('includes/configure.php');
} else {
	header('Location: ../installer/');
	exit;
}
if(COMMERCE_SEO_V22_INSTALLED != 'true') {
	header('Location: ../installer/');
	exit;
}
if (version_compare(PHP_VERSION, '5.1.0', '>=')) {
	date_default_timezone_set('Europe/Berlin');
}
define('SQL_CACHEDIR',DIR_FS_CATALOG.'cache/');

// Set the length of the redeem code, the longer the more secure
define('SECURITY_CODE_LENGTH', '10');

// Used in the "Backup Manager" to compress backups
define('LOCAL_EXE_GZIP', '/usr/bin/gzip');
define('LOCAL_EXE_GUNZIP', '/usr/bin/gunzip');
define('LOCAL_EXE_ZIP', '/usr/local/bin/zip');
define('LOCAL_EXE_UNZIP', '/usr/local/bin/unzip');

include('includes/filenames_admin.php');
include('includes/database_admin.php');

// include needed functions
require_once(DIR_FS_INC . 'xtc_db_connect.inc.php');
require_once(DIR_FS_INC . 'xtc_db_close.inc.php');
require_once(DIR_FS_INC . 'xtc_db_error.inc.php');
require_once(DIR_FS_INC . 'xtc_db_query.inc.php');
require_once(DIR_FS_INC . 'xtc_db_queryCached.inc.php');
require_once(DIR_FS_INC . 'xtc_db_perform.inc.php');
require_once(DIR_FS_INC . 'xtc_db_fetch_array.inc.php');
require_once(DIR_FS_INC . 'xtc_db_num_rows.inc.php');
require_once(DIR_FS_INC . 'xtc_db_data_seek.inc.php');
require_once(DIR_FS_INC . 'xtc_db_insert_id.inc.php');
require_once(DIR_FS_INC . 'xtc_db_free_result.inc.php');
require_once(DIR_FS_INC . 'xtc_db_fetch_fields.inc.php');
require_once(DIR_FS_INC . 'xtc_db_output.inc.php');
require_once(DIR_FS_INC . 'xtc_db_input.inc.php');
require_once(DIR_FS_INC . 'xtc_db_prepare_input.inc.php');
require_once(DIR_FS_INC . 'xtc_get_ip_address.inc.php');
require_once(DIR_FS_INC . 'xtc_setcookie.inc.php');
require_once(DIR_FS_INC . 'xtc_validate_email.inc.php');
require_once(DIR_FS_INC . 'xtc_not_null.inc.php');
require_once(DIR_FS_INC . 'xtc_add_tax.inc.php');
require_once(DIR_FS_INC . 'xtc_get_tax_rate.inc.php');
require_once(DIR_FS_INC . 'xtc_get_qty.inc.php');
require_once(DIR_FS_INC . 'xtc_product_link.inc.php');
require_once(DIR_FS_INC . 'xtc_cleanName.inc.php');
require_once(DIR_FS_INC . 'cseo_version.inc.php');

// Define how do we update currency exchange rates
// Possible values are 'oanda' 'xe' or ''
define('CURRENCY_SERVER_PRIMARY', 'oanda');
define('CURRENCY_SERVER_BACKUP', 'xe');

// Use the DB-Logger
define('STORE_DB_TRANSACTIONS', 'false');

// include the database functions
//  require(DIR_WS_FUNCTIONS . 'database.php');

// make a connection to the database... now
xtc_db_connect() or die('Datenbankverbindung kann nicht hergestellt werden!');

// set application wide parameters
$configuration_query = xtc_db_query("SELECT configuration_key AS cfgKey, configuration_value AS cfgValue FROM ".TABLE_CONFIGURATION."");
while ($configuration = xtc_db_fetch_array($configuration_query)) {
	if($configuration['cfgKey']=='DB_CACHE')
		define("DB_CACHE", "false");
	else
		define($configuration['cfgKey'], $configuration['cfgValue']);
}

define('FILENAME_IMAGEMANIPULATOR',IMAGE_MANIPULATOR);

function xtDBquery($query) {
	return xtc_db_query($query);
}

// initialize the logger class
require(DIR_WS_CLASSES . 'class.logger.php');

// include shopping cart class
require(DIR_WS_CLASSES . 'class.shopping_cart.php');

// some code to solve compatibility issues
require(DIR_WS_FUNCTIONS . 'compatibility.php');

require(DIR_WS_FUNCTIONS . 'general.php');

// define how the session functions will be used
require(DIR_WS_FUNCTIONS . 'sessions.php');

// define our general functions used application-wide
require(DIR_WS_FUNCTIONS . 'html_output.php');

// set the session name and save path
session_name('cSEOid');
if(STORE_SESSIONS != 'mysql') 
	session_save_path(SESSION_WRITE_DIRECTORY);

// set the session cookie parameters
if (function_exists('session_set_cookie_params')) {
	session_set_cookie_params(0, '/', (xtc_not_null($current_domain) ? '.' . $current_domain : ''));
} elseif (function_exists('ini_set')) {
	ini_set('session.cookie_lifetime', '0');
	ini_set('session.cookie_path', '/');
	ini_set('session.cookie_domain', (xtc_not_null($current_domain) ? '.' . $current_domain : ''));
}

// set the session ID if it exists
if (isset($_POST[session_name()]))
	session_id($_POST[session_name()]);
elseif(($request_type == 'SSL') && isset($_GET[session_name()]))
	session_id($_GET[session_name()]);

// start the session
$session_started = false;
if (SESSION_FORCE_COOKIE_USE == 'true') {
	xtc_setcookie('cookie_test', 'please_accept_for_session', time()+60*60*24*30, '/', $current_domain);
	// Strato Fix
	if (isset($_COOKIE['cookie_test'])) {
  		session_start();
  		$session_started = true;
	}
} elseif (CHECK_CLIENT_AGENT == 'true') {
	$user_agent = strtolower(getenv('HTTP_USER_AGENT'));
	$spider_flag = false;

	if($spider_flag == false) {
  		session_start();
  		$session_started = true;
	}
} else {
	session_start();
	$session_started = true;
}

// verify the ssl_session_id if the feature is enabled
if ( ($request_type == 'SSL') && (SESSION_CHECK_SSL_SESSION_ID == 'true') && (ENABLE_SSL == true) && ($session_started == true) ) {
	$ssl_session_id = getenv('SSL_SESSION_ID');
	if (!isset($_SESSION['SESSION_SSL_ID'])) { 
  		$_SESSION['SESSION_SSL_ID'] = $ssl_session_id;
	}

	if ($_SESSION['SESSION_SSL_ID'] != $ssl_session_id) {
  		session_destroy();
  		xtc_redirect(xtc_href_link(FILENAME_SSL_CHECK));
	}
}

// verify the browser user agent if the feature is enabled
if (SESSION_CHECK_USER_AGENT == 'true') {
$http_user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
$http_user_agent2 = strtolower(getenv("HTTP_USER_AGENT"));
$http_user_agent = ($http_user_agent == $http_user_agent2) ? $http_user_agent : $http_user_agent.';'.$http_user_agent2;
if (!isset($_SESSION['SESSION_USER_AGENT'])) {
	$_SESSION['SESSION_USER_AGENT'] = $http_user_agent;
}

if ($_SESSION['SESSION_USER_AGENT'] != $http_user_agent) {
	session_destroy();
	xtc_redirect(xtc_href_link(FILENAME_LOGIN));
}
}


// verify the IP address if the feature is enabled
if (SESSION_CHECK_IP_ADDRESS == 'true') {
	$ip_address = xtc_get_ip_address();
	if(!isset($_SESSION['SESSION_IP_ADDRESS'])) {
  		$_SESSION['SESSION_IP_ADDRESS'] = $ip_address;
	}
	if ($_SESSION['SESSION_IP_ADDRESS'] != $ip_address) {
  		session_destroy();
  		xtc_redirect(xtc_href_link(FILENAME_LOGIN));
	}
}

// set the language
if (!isset($_SESSION['language']) || isset($_GET['language'])) {

include(DIR_WS_CLASSES . 'class.language.php');
$lng = new language($_GET['language']);

if (!isset($_GET['language'])) $lng->get_browser_language();

$_SESSION['language'] = $lng->language['directory'];
$_SESSION['languages_id'] = $lng->language['id'];
}

// include the language translations
require(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/'.$_SESSION['language'] . '.php');
require(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/buttons.php');

$current_page = explode('?', basename($_SERVER['PHP_SELF']));
$current_page = $current_page[0];

if (file_exists(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/'.$current_page)) {
	include(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/'.  $current_page);
}

// write customers status in session
require('../' . DIR_WS_INCLUDES . 'write_customers_status.php');

if(file_exists($current_page) == false || $_SESSION['customers_status']['customers_status_id'] !== '0') {
	xtc_redirect(xtc_href_link(FILENAME_LOGIN));
}

// for tracking of customers
$_SESSION['user_info'] = array();
if (!$_SESSION['user_info']['user_ip']) {
	$_SESSION['user_info']['user_ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['user_info']['user_host'] = gethostbyaddr( $_SERVER['REMOTE_ADDR'] );
	$_SESSION['user_info']['advertiser'] = $_GET['ad'];
	$_SESSION['user_info']['referer_url'] = $_SERVER['HTTP_REFERER'];
}

function datei_vorhanden($file) {
	if(file_exists($file)) 
		return true;
	else 
		return false;
}

if(isset($_GET['subsite'])) {
	$site = $_GET['subsite'];
	$_SESSION['subsite'] = $_GET['subsite'];
} elseif(isset($_SESSION['subsite'])) {
	if(strpos($_SERVER["HTTP_REFERER"],'/admin/') !== false)
		$site = $_SESSION['subsite'];
	else
		$site = 'empty';
} else {
	$site = 'empty';
	$_SESSION['subsite'] = 'empty';
}
if($site != 'empty')
	define('BOX_WIDTH', 150);
else
	define('BOX_WIDTH', 0);

// define our localization functions
require(DIR_WS_FUNCTIONS . 'localization.php');

// Include validation functions (right now only email address)
//require(DIR_WS_FUNCTIONS . 'validations.php');

// setup our boxes
require(DIR_WS_CLASSES . 'table_block.php');
require(DIR_WS_CLASSES . 'box.php');

// initialize the message stack for output messages
require(DIR_WS_CLASSES . 'class.message_stack.php');
$messageStack = new messageStack();

// split-page-results
require(DIR_WS_CLASSES . 'class.split_page_results.php');

// entry/item info classes
require(DIR_WS_CLASSES . 'object_info.php');


// file uploading class
require(DIR_WS_CLASSES . 'upload.php');

// calculate category path
if (isset($_GET['cPath']))
	$cPath = $_GET['cPath'];
else
	$cPath = '';

if (strlen($cPath) > 0) {
	$cPath_array = explode('_', $cPath);
	$current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
} else
	$current_category_id = 0;

// the following cache blocks are used in the Tools->Cache section
// ('language' in the filename is automatically replaced by available languages)
$cache_blocks = array(array('title' => TEXT_CACHE_CATEGORIES, 'code' => 'categories', 'file' => 'categories_box-language.cache', 'multiple' => true),
					array('title' => TEXT_CACHE_MANUFACTURERS, 'code' => 'manufacturers', 'file' => 'manufacturers_box-language.cache', 'multiple' => true),
					array('title' => TEXT_CACHE_ALSO_PURCHASED, 'code' => 'also_purchased', 'file' => 'also_purchased-language.cache', 'multiple' => true)
				   );

// check if a default currency is set
if (!defined('DEFAULT_CURRENCY')) {
$messageStack->add(ERROR_NO_DEFAULT_CURRENCY_DEFINED, 'error');
}

// check if a default language is set
if (!defined('DEFAULT_LANGUAGE')) {
$messageStack->add(ERROR_NO_DEFAULT_LANGUAGE_DEFINED, 'error');
}

// for Customers Status
xtc_get_customers_statuses();

$pagename = strtok($current_page, '.');
if (!isset($_SESSION['customer_id'])) {
	xtc_redirect(xtc_href_link(FILENAME_LOGIN));
}

if (xtc_check_permission($pagename) == '0') {
	xtc_redirect(xtc_href_link(FILENAME_LOGIN));
}

//Ist Tabelle da?
function table_exists($table_name) {
  $Table = xtc_db_query("SHOW TABLES LIKE '" . $table_name . "'");
  if(mysql_fetch_row($Table) === false) { 
    return(false); 
  } else {
    return(true);
  }
}

//Ist Spalte da?
	
function column_exists($table, $column) {
  $Table = xtc_db_query("SHOW COLUMNS FROM $table LIKE '" . $column . "'");
  if(mysql_fetch_row($Table) === false) {
    return(false);
  } else {
    return(true);
  }
}

// Include Template Engine
require(DIR_FS_CATALOG.DIR_WS_CLASSES . 'Smarty_3/Smarty.class.php');

/* magnalister v1.0.1 */
if (!defined('MAGNALISTER_PLUGIN') && file_exists(DIR_FS_DOCUMENT_ROOT.'magnaCallback.php')) {
	ob_start();
	require_once (DIR_FS_DOCUMENT_ROOT.'magnaCallback.php');
	ob_end_clean();
}
/* END magnalister */

//New Addonsystem from v2.2.2
if (table_exists('addon_filenames')) {
	$addon_filenames_query = xtc_db_query("SELECT configuration_key, configuration_value FROM addon_filenames");
	while ($addon_filenames = xtc_db_fetch_array($addon_filenames_query)) {
		define($addon_filenames['configuration_key'], $addon_filenames['configuration_value']);
	}
}

if (table_exists('addon_database')) {
	$addon_database_query = xtc_db_query("SELECT configuration_key, configuration_value FROM addon_database");
	while ($addon_database = xtc_db_fetch_array($addon_database_query)) {
		define($addon_database['configuration_key'], $addon_database['configuration_value']);
	}
}
if (table_exists('addon_languages')) {
	$addon_languages_query = xtc_db_query("SELECT configuration_key, configuration_value FROM addon_languages WHERE languages_id = ".$_SESSION['languages_id']."");
	while ($addon_languages = xtc_db_fetch_array($addon_languages_query)) {
		define($addon_languages['configuration_key'], $addon_languages['configuration_value']);
	}
}
//END new Addon System
?>