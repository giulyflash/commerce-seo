<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_get_qty.inc.php
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




   function xtc_get_qty($products_id)  {

     if (strpos($products_id,'{'))  {
    $act_id=substr($products_id,0,strpos($products_id,'{'));
  } else {
    $act_id=$products_id;
  }

  return $_SESSION['actual_content'][$act_id]['qty'];

   }

?>