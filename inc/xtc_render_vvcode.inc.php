<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_render_vvcode.inc.php
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




require_once(DIR_FS_INC . 'xtc_rand.inc.php');

function vvcode_render_code($code) {
    if (!empty($code)) {

    // load fonts
    $ttf=array();
    if ($dir= opendir(DIR_WS_INCLUDES.'fonts/')){
		while  (($file = readdir($dir)) !==false) {
			if (is_file(DIR_WS_INCLUDES.'fonts/'.$file) and (strstr(strtoupper($file),'.TTF'))) {
				$ttf[]=DIR_FS_CATALOG.'/includes/fonts/'.$file;
			}
		}
	closedir($dir);
    }
    $width = 240;
    $height =55;

    $imgh = imagecreate($width, $height);
    $fonts = imagecolorallocate($imgh, 79, 79, 79);
    $lines = imagecolorallocate($imgh, 146, 185, 83);
    $background = imagecolorallocate($imgh, 255, 255, 255);

    imagefill($imgh, 0, 0, $background);

    $x = xtc_rand(0, 20);
    $y = xtc_rand(20, 40);
    for ($i = $x, $z = $y; $i < $width && $z < $width;) {
        imageLine($imgh, $i, 0, $z, $height, $lines);
        $i += $x;
        $z += $y;
    }

    $x = xtc_rand(0, 20);
    $y = xtc_rand(20, 40);
    for ($i = $x, $z = $y; $i < $width && $z < $width;) {
        imageLine($imgh, $z, 0, $i, $height, $lines);
        $i += $x;
        $z += $y;
    }    
    
    $x = xtc_rand(0, 10);
    $y = xtc_rand(10, 20);
    for ($i = $x, $z = $y; $i < $height && $z < $height;) {
        imageLine($imgh, 0, $i, $width, $z, $lines);
        $i += $x;
        $z += $y;
    }

    $x = xtc_rand(0, 10);
    $y = xtc_rand(10, 20);
    for ($i = $x, $z = $y; $i < $height && $z < $height;) {
        imageLine($imgh, 0, $z, $width, $i, $lines);
        $i += $x;
        $z += $y;
    }    
       
    for ($i = 0; $i < strlen($code); $i++) {
        $font = $ttf[(int)xtc_rand(0, count($ttf)-1)];
        $size = xtc_rand(30, 36);
        $rand = xtc_rand(1,20);
        $direction = xtc_rand(0,1);

      if ($direction == 0) {
       $angle = 0-$rand;
    } else {
       $angle = $rand;
    }
      if (function_exists('imagettftext')) {                   
              imagettftext($imgh, $size, $angle, 15+(36*$i) , 38, $fonts, $font, substr($code, $i, 1));  
      } else {                                            
        $tc = ImageColorAllocate ($imgh, 0, 0, 0); //Schriftfarbe - schwarz         
              ImageString($imgh, $size, 26+(36*$i),20, substr($code, $i, 1), $tc);  
        }
    }                                                                              
                                                                                   
    header('Content-Type: image/png');
    imagejpeg($imgh);
    imagedestroy($imgh);
 }
}
?>