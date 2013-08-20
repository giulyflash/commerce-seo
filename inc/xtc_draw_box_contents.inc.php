<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_draw_box_contents.inc.php
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




function xtc_draw_box_contents($box_contents, $box_shadow_color = BOX_SHADOW, $box_background_color = BOX_BGCOLOR_CONTENTS) {
    $contents = '<div';

    if (is_array($box_contents)) {
      for ($i=0; $i<sizeof($box_contents); $i++) {
        $contents .= xtc_draw_box_content_bullet($box_contents[$i]['title'], $box_contents[$i]['link']);
      }
    } else {
      $contents .= '<div class="infoboxText">' . $box_contents . '</div>' . CR ;
    }

    $contents .=   '</div>' . CR;

    return $contents;
  }
 ?>