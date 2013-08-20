<?php
/*-----------------------------------------------------------------
* 	ID:						cseo_mouse_over.inc.php
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




function mouseOverJS($title='',$text,$img='') {
	if($text !='') {
		$color = ', FONTCOLOR, \'#000000\'';
		$backg_color = ', BGCOLOR, \'#F1F1F1\'';
		$border_color = ', BORDERCOLOR, \'#CCCCCC\'';
		$fade_in = ', FADEIN, 600';
		$fade_out = ', FADEOUT, 500';
		$padding = ', PADDING, 10';
		$width = ', WIDTH, 300';
		$follow_mouse = ', FOLLOWMOUSE, false';
		$titel = ', TITLE, \''.$title.'\'';
		if($img !='') {
			$size = PRODUCT_IMAGE_POPUP_WIDTH + 10;
			$text = '<img class=&quot;img_border&quot; src=&quot;'.$img.'&quot; alt=&quot;'.$title.'&quot; align=&quot;left&quot; style=&quot;margin: 0 10px 10px 0&quot; >'.$text;
		}
		$over = ' onmouseover="Tip(\''.$text.'\''.$titel.''.$backg_color.''.$border_color.''.$fade_in.''.$fade_out.''.$padding.''.$color.''.$width.''.$follow_mouse.')" onmouseout="UnTip()"';
		return $over;	
	} else
		return;
}


 
?>