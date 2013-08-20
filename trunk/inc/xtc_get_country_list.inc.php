<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_get_country_list.inc.php
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




// include needed functions
  include_once(DIR_FS_INC . 'xtc_draw_pull_down_menu.inc.php');
  include_once(DIR_FS_INC . 'xtc_get_countries.inc.php');
  
  function xtc_get_country_list($name, $selected = '', $parameters = '') {
//    $countries_array = array(array('id' => '', 'text' => PULL_DOWN_DEFAULT));
//    Probleme mit register_globals=off -> erstmal nur auskommentiert. Kann u.U. gelĐ ĐŽĐ˛Đ‚Â scht werden.
    $countries = xtc_get_countriesList();

    for ($i=0, $n=sizeof($countries); $i<$n; $i++) {
      $countries_array[] = array('id' => $countries[$i]['countries_id'], 'text' => $countries[$i]['countries_name']);
    }
	if (is_array($name)) return xtc_draw_pull_down_menuNote($name, $countries_array, $selected, $parameters);
    return xtc_draw_pull_down_menu($name, $countries_array, $selected, $parameters);
  }
  
  
 ?>