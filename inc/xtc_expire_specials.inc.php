<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_expire_specials.inc.php
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



  require_once(DIR_FS_INC . 'xtc_set_specials_status.inc.php');
// Auto expire products on special
  function xtc_expire_specials() {
    $specials_query = xtc_db_query("select specials_id from " . TABLE_SPECIALS . " where status = '1' and now() >= expires_date and expires_date > 0");
    if (xtc_db_num_rows($specials_query)) {
      while ($specials = xtc_db_fetch_array($specials_query)) {
        xtc_set_specials_status($specials['specials_id'], '0');
      }
    }
  }
 ?>