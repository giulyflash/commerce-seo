<?php
/*-----------------------------------------------------------------
* 	ID:						application.php
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



// Some FileSystem Directories
if(!defined('DIR_FS_DOCUMENT_ROOT')) {
	define('DIR_FS_DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
	$local_install_path=str_replace('/installer','',$_SERVER['PHP_SELF']);
	$local_install_path=str_replace('index.php','',$local_install_path);
	$local_install_path=str_replace('install_step1.php','',$local_install_path);
	$local_install_path=str_replace('install_step2.php','',$local_install_path);
	$local_install_path=str_replace('install_step3.php','',$local_install_path);
	$local_install_path=str_replace('install_step4.php','',$local_install_path);
	$local_install_path=str_replace('install_step5.php','',$local_install_path);
	$local_install_path=str_replace('install_step6.php','',$local_install_path);
	$local_install_path=str_replace('install_step7.php','',$local_install_path);
	$local_install_path=str_replace('install_finished.php','',$local_install_path);
	define('DIR_FS_CATALOG', DIR_FS_DOCUMENT_ROOT . $local_install_path);
}
if(!defined('DIR_FS_INC')) 
	define('DIR_FS_INC', DIR_FS_CATALOG.'inc/');

// include
require(DIR_FS_CATALOG.'includes/classes/class.boxes.php');
require(DIR_FS_CATALOG.'includes/classes/class.message_stack.php');
require(DIR_FS_CATALOG.'includes/filenames.php');
require(DIR_FS_CATALOG.'includes/database_tables.php');
require_once(DIR_FS_CATALOG.'inc/xtc_image.inc.php');

session_start();

error_reporting(E_ALL & ~E_NOTICE);

define('CR', "\n");
define('BOX_BGCOLOR_HEADING', '#bbc3d3');
define('BOX_BGCOLOR_CONTENTS', '#f8f8f9');
define('BOX_SHADOW', '#b6b7cb');

// include General functions
require(DIR_FS_INC.'xtc_set_time_limit.inc.php');
require(DIR_FS_INC.'xtc_check_agent.inc.php');
require(DIR_FS_INC.'xtc_in_array.inc.php');

require(DIR_FS_INC.'xtc_db_prepare_input.inc.php');
require(DIR_FS_INC.'xtc_db_connect_installer.inc.php');
require(DIR_FS_INC.'xtc_db_select_db.inc.php');
require(DIR_FS_INC.'xtc_db_close.inc.php');
require(DIR_FS_INC.'xtc_db_query_installer.inc.php');
require(DIR_FS_INC.'xtc_db_fetch_array.inc.php');
require(DIR_FS_INC.'xtc_db_num_rows.inc.php');
require(DIR_FS_INC.'xtc_db_data_seek.inc.php');
require(DIR_FS_INC.'xtc_db_insert_id.inc.php');
require(DIR_FS_INC.'xtc_db_free_result.inc.php');
require(DIR_FS_INC.'xtc_db_test_create_db_permission.inc.php');
require(DIR_FS_INC.'xtc_db_test_connection.inc.php');
require(DIR_FS_INC.'xtc_db_install.inc.php');
require(DIR_FS_INC.'cseo_get_img_size.inc.php');
require(DIR_FS_INC.'cseo_version.inc.php');

require(DIR_FS_INC.'xtc_draw_input_field_installer.inc.php');
require(DIR_FS_INC.'xtc_draw_password_field_installer.inc.php');
require(DIR_FS_INC.'xtc_draw_hidden_field_installer.inc.php');
require(DIR_FS_INC.'xtc_draw_checkbox_field_installer.inc.php');
require(DIR_FS_INC.'xtc_draw_radio_field_installer.inc.php');

require(DIR_FS_INC .'xtc_gdlib_check.inc.php');

$check = '../includes/configure.php';
if (file_exists($check) && filesize($check) > 1) {
	include('../includes/configure.php');
	if(COMMERCE_SEO_V22_INSTALLED =='true') {
		$connect = mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
		mysql_select_db(DB_DATABASE);
		$res = mysql_query("SELECT * FROM admin_access");
		if(@mysql_num_rows($res) > 0) {
			$bn = basename($_SERVER['PHP_SELF']);
			if(($bn !='install_finished.php') && ($bn !='install_step4.php') && ($bn !='install_step5.php') && ($bn !='install_step6.php') && ($bn !='install_step7.php'))
				header('Location: '.HTTP_SERVER.DIR_WS_CATALOG);
		}
	}
}

if(!defined('DIR_WS_ICONS')) 
	define('DIR_WS_ICONS','images/');

function xtDBquery($query) {
	return xtc_db_query($query);
}
	
function mouseOverJS ($title='',$text,$img='',$width='') {
	if($text !='') {
		$color = ', FONTCOLOR, \'#2F2F2F\'';
		$backg_color = ', BGCOLOR, \'#F1F1F1\'';
		$border_color = ', BORDERCOLOR, \'#CCCCCC\'';
		$fade_in = ', FADEIN, 600';
		$fade_out = ', FADEOUT, 500';
		$padding = ', PADDING, 10';
		$title_bg = ', TITLEBGCOLOR, \'#677E98\'';
		$title_color = ', TITLEFONTCOLOR, \'#FFFFFF\'';
		if($width =='')
			$w = ', WIDTH, 400';
		else
			$w = ', WIDTH, '.$width;
		$follow_mouse = ', FOLLOWMOUSE, false';
		$shadow = ', SHADOW, true, SHADOWCOLOR, \'#2F2F2F\'';
		if($title !='')
			$titel = ', TITLE, \''.$title.'\'';
		if($img !='') {
			$size = PRODUCT_IMAGE_POPUP_WIDTH + 10;
			$text = '<img class=&quot;img_border&quot; src=&quot;'.$img.'&quot; alt=&quot;'.$title.'&quot; align=&quot;left&quot; style=&quot;margin: 0 10px 10px 0&quot; >'.$text;
		}
		$over = ' onmouseover="Tip(\''.$text.'\''.$titel.''.$backg_color.''.$border_color.''.$fade_in.''.$fade_out.''.$padding.''.$color.''.$w.''.$follow_mouse.''.$shadow.''.$title_bg.''.$title_color.')" onmouseout="UnTip()"';
		return $over;	
	} else
		return;
}

function cseo_get_help($de_id ='', $en_id ='', $title ='') {
	if(!empty($de_id) || !empty($en_id)) {
		$id = (($de_id !='') ? $de_id : $en_id);
		$help = '<a class="help_tip" href="javascript:void(0);"';
		if(!empty($title))
			$help .= 'title="'.$title.'"';
		$help .= ' rel="includes/get_faq_help.php?id='.$id.'"><img src="images/icons/question-balloon.png" alt="" /></a>';
		return $help;
	} else
		return;
}

function xtc_check_version($mini='5.1.2') {
	$dummy=phpversion();
	sscanf($dummy,"%d.%d.%d%s",$v1,$v2,$v3,$v4);
	sscanf($mini,"%d.%d.%d%s",$m1,$m2,$m3,$m4);
	if($v1>$m1)
	   return(1);
	elseif($v1<$m1)
	 return(0);
	if($v2>$m2)
	   return(1);
	elseif($v2<$m2)
	   return(0);
	if($v3>$m3)
	  return(1);
	elseif($v3<$m3)
	   return(0);
	if((!$v4)&&(!$m4))
	   return(1);
	if(($v4)&&(!$m4)) {
	  $dummy=strpos($v4,"pl");
	   if(is_integer($dummy))
	      return(1);
	   return(0);
	}
	elseif((!$v4)&&($m4)) {
	  $dummy=strpos($m4,"rc");
	   if(is_integer($dummy))
	      return(1);
	   return(0);
	}
	return(0);
}

function xtc_date_raw($date, $reverse = false) {
	if($reverse)
		return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
	else
		return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
}
?>