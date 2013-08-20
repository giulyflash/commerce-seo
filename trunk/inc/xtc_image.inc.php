<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_image.inc.php
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



 
$hover_suffix = '_hover';
$down_suffix = '_down';
$file_ext = '.gif';

require_once(DIR_FS_INC . 'xtc_parse_input_field_data.inc.php');
require_once(DIR_FS_INC . 'xtc_not_null.inc.php');

function xtc_image($src, $alt = '', $width = '', $height = '', $parameters = '', $mouseover = false, $mousedown = false, $title = '') {
	if ((empty($src) || ($src == DIR_WS_IMAGES)) || ( $src == DIR_WS_THUMBNAIL_IMAGES) && (IMAGE_REQUIRED == 'false') ) {
  		return false;
	}

	$image = '<img src="' . xtc_parse_input_field_data($src, array('"' => '&quot;')) . '" alt="' . xtc_parse_input_field_data($alt, array('"' => '&quot;')) . '"';
	
	if($width =='' || $height == '')
		$image .= ' '.cseo_get_img_size($src).' ';
	
	if (xtc_not_null($alt)) {
  		$image .= ' title="' . xtc_parse_input_field_data($alt, array('"' => '&quot;')) . '"';
	}

	if ($mouseover == true || $mousedown == true)  {
		$image .= image_mouseover($mouseover, $mousedown, $src);
	}
	
	if (xtc_not_null($parameters)) 
		$image .= ' ' . $parameters;
	
	$image .= ' />';
	
	return $image;
}
 
function image_mouseover($mouseover, $mousedown, $src){
	$str_mouse_over = '';
	global $hover_suffix, $down_suffix, $file_ext;
	
    require_once(DIR_FS_INC . 'xtc_random_image_name.inc.php');
	$name = xtc_random_name();
	$str_mouse_over .= ' id="'. $name . '"';
	
	$load_files = '';
		
	if ($mouseover == true)	{
		$hover_file = str_replace($file_ext,'', $src) . $hover_suffix . $file_ext;
		if (file_exists($hover_file)) {
			$str_mouse_over .= ' onmouseover="javascript:MM_swapImage(\''. $name .'\',\'\',\'' . $hover_file .'\',1)" onmouseout="javascript:MM_swapImgRestore()"';
			$load_files .= '\'' . $hover_file . '\'';
		}  
	}

	if ($mousedown == true) {
	  $down_file = str_replace($file_ext, '', $src) . $down_suffix . $file_ext;

	  if (file_exists($down_file)) {
	    $str_mouse_over .= ' onmousedown="javascript:MM_swapImage(\''. $name .'\',\'\',\'' . $down_file .'\',1)" onmouseup="javascript:MM_swapImgRestore()"';
		if ($load_files!=''){
		  $load_files .= ',\'' . $down_file .'\'';   
		}else{
		  $load_files .= ',\'' . $down_file . '\'';   
		}
	  }  
	}
	
	return $str_mouse_over;
}
?>
