<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_draw_box_heading.inc.php
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



   
function xtc_draw_box_heading($heading_title, $left_corner = false, $right_corner = false) {
    $heading = '';
    if ($left_corner) {
      $heading .= '';
    } else {
      $heading .= '';
    }

    $heading .= '';

    if ($right_corner) {
      $heading .= '';
    }

    $heading .= '' . CR .
                '' . CR;

    return $heading;
  }
 ?>