<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_inc_next_ibillnr.inc.php
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



   
//set customer satus to new customer for upgrade account
function xtc_inc_next_ibillnr(){
  $query = "select 
              configuration_value 
            from " . 
              TABLE_CONFIGURATION . "
            where 
              configuration_key = 'IBN_BILLNR'";
  $result = xtc_db_query($query);
  $data=xtc_db_fetch_array($result);
  
  $data = $data['configuration_value'];
  if( $data==0 ) 
    return 0;

  $data++;
  
  $query = "update " . 
              TABLE_CONFIGURATION . " 
            set 
              configuration_value = '" . $data . "'
            where 
              configuration_key = 'IBN_BILLNR'";
  return xtc_db_query($query);
}

 ?>