<?php
/*-----------------------------------------------------------------
* 	ID:						cseo_get_box_data.inc.php
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



function getBoxTitle($box_name) {
	$title = '';
	$name_query = xtc_db_query("SELECT box_title FROM boxes_names WHERE box_name = '".$box_name."' AND language_id = '".$_SESSION['languages_id']."' AND status = '1' ");
	$bs  = xtc_db_fetch_array(xtc_db_query("SELECT border_color,background_content,color_content,background_head,background_head,color_head FROM boxes_styles WHERE box_name = '".$box_name."' "));
	
	$title = '<div class="box" style="'.(($bs['border_color']!='')?'border-color:#'.$bs['border_color'].';':'').(($bs['background_content']!='')?'background:#'.$bs['background_content'].';':'').(($bs['color_content']!='')?'color:#'.$bs['color_content'].';':'').'">'."\n";
	
	if(xtc_db_num_rows($name_query)) {	
		$name = xtc_db_fetch_array($name_query);

		$title .= '<div class="infoBoxHeading" style="'.(($bs['background_head']!='')?'background:#'.$bs['background_head'].';':'').(($bs['color_head']!='')?'color:#'.$bs['color_head'].';':'').'">'."\n";
		$title .= $name['box_title'];
		$title .= '</div>';
		return $title;
	} else {

		return $title;
	}	
}

function getBoxContent($box_name) {
	$desc_query = xtc_db_query("SELECT box_desc FROM boxes_names WHERE box_name = '".$box_name."' AND language_id = '".$_SESSION['languages_id']."'");
	if(xtc_db_num_rows($desc_query)){
		$desc = xtc_db_fetch_array($desc_query);
		return $desc['box_desc'];
	} else
		return;
}

?>