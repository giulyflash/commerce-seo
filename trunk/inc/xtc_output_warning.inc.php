<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_output_warning.inc.php
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



   
  function xtc_output_warning($warning) {
    new errorBox(array(array('text' => '<li style="display:block;padding:10px;margin-bottom:2px;border:1px solid #ccc; background:url(images/error_bg.gif) center left repeat-x;color:#fff;font-weight:700"> ' . $warning . '</li>')));
  }

 ?>