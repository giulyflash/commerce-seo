<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_display_banner.inc.php
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



   
// Display a banner from the specified group or banner id ($identifier)
  function xtc_display_banner($action, $identifier) {
    if ($action == 'dynamic') {
      $banners_query = xtc_db_query("select count(*) as count from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
      $banners = xtc_db_fetch_array($banners_query);
      if ($banners['count'] > 0) {
        $banner = xtc_random_select("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
      } else {
        return '<b>XTC ERROR! (xtc_display_banner(' . $action . ', ' . $identifier . ') -> No banners with group \'' . $identifier . '\' found!</b>';
      }
    } elseif ($action == 'static') {
      if (is_array($identifier)) {
        $banner = $identifier;
      } else {
        $banner_query = xtc_db_query("select banners_id, banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . $identifier . "'");
        if (xtc_db_num_rows($banner_query)) {
          $banner = xtc_db_fetch_array($banner_query);
        } else {
          return '<b>XTC ERROR! (xtc_display_banner(' . $action . ', ' . $identifier . ') -> Banner with ID \'' . $identifier . '\' not found, or status inactive</b>';
        }
      }
    } else {
      return '<b>XTC ERROR! (xtc_display_banner(' . $action . ', ' . $identifier . ') -> Unknown $action parameter value - it must be either \'dynamic\' or \'static\'</b>';
    }

    if (xtc_not_null($banner['banners_html_text'])) {
      $banner_string = $banner['banners_html_text'];
    } else {
      $banner_string = '<a href="' . xtc_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $banner['banners_id']) . '" onclick="window.open(this.href); return false;">' . xtc_image(DIR_WS_IMAGES.'banner/' . $banner['banners_image'], $banner['banners_title']) . '</a>';
    }

    xtc_update_banner_display_count($banner['banners_id']);

    return $banner_string;
  }
 ?>