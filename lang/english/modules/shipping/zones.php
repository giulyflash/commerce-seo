<?php
/*-----------------------------------------------------------------
* 	$Id: zones.php 496 2013-07-17 09:56:08Z akausch $
* 	Copyright (c) 2011-2021 commerce:SEO by Webdesign Erfurt
* 	http://www.commerce-seo.de
* ------------------------------------------------------------------
* 	based on:
* 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
* 	(c) 2002-2003 osCommerce - www.oscommerce.com
* 	(c) 2003     nextcommerce - www.nextcommerce.org
* 	(c) 2005     xt:Commerce - www.xt-commerce.com
* 	Released under the GNU General Public License
* ---------------------------------------------------------------*/
   
   // CUSTOMIZE THIS SETTING
define('NUMBER_OF_ZONES',10);

define('MODULE_SHIPPING_ZONES_TEXT_TITLE', 'Zone Rates');
define('MODULE_SHIPPING_ZONES_TEXT_DESCRIPTION', 'Zone Based Rates');
define('MODULE_SHIPPING_ZONES_TEXT_WAY', 'Shipping to:');
define('MODULE_SHIPPING_ZONES_TEXT_UNITS', 'lb(s)');
define('MODULE_SHIPPING_ZONES_INVALID_ZONE', 'No shipping available to the selected country!');
define('MODULE_SHIPPING_ZONES_UNDEFINED_RATE', 'The shipping rate cannot be determined at this time.');

define('MODULE_SHIPPING_ZONES_STATUS_TITLE' , 'Enable Zones Method');
define('MODULE_SHIPPING_ZONES_STATUS_DESC' , 'Do you want to offer zone rate shipping?');
define('MODULE_SHIPPING_ZONES_ALLOWED_TITLE' , 'Allowed Zones');
define('MODULE_SHIPPING_ZONES_ALLOWED_DESC' , 'Please enter the zones <b>separately</b> which should be allowed to use this modul (e. g. AT,DE (leave empty if you want to allow all zones))');
define('MODULE_SHIPPING_ZONES_TAX_CLASS_TITLE' , 'Tax Class');
define('MODULE_SHIPPING_ZONES_TAX_CLASS_DESC' , 'Use the following tax class on the shipping fee.');
define('MODULE_SHIPPING_ZONES_SORT_ORDER_TITLE' , 'Sort Order');
define('MODULE_SHIPPING_ZONES_SORT_ORDER_DESC' , 'Sort order of display.');

for ($ii=0;$ii<NUMBER_OF_ZONES;$ii++) {
define('MODULE_SHIPPING_ZONES_COUNTRIES_'.$ii.'_TITLE' , 'Zone '.$ii.' Countries');
define('MODULE_SHIPPING_ZONES_COUNTRIES_'.$ii.'_DESC' , 'Comma separated list of two character ISO country codes that are part of Zone '.$ii.'.');
define('MODULE_SHIPPING_ZONES_COST_'.$ii.'_TITLE' , 'Zone '.$ii.' Shipping Table');
define('MODULE_SHIPPING_ZONES_COST_'.$ii.'_DESC' , 'Shipping rates to Zone '.$ii.' destinations based on a group of maximum order weights. Example: 3:8.50,7:10.50,... Weights less than or equal to 3 would cost 8.50 for Zone '.$ii.' destinations.');
define('MODULE_SHIPPING_ZONES_HANDLING_'.$ii.'_TITLE' , 'Zone '.$ii.' Handling Fee');
define('MODULE_SHIPPING_ZONES_HANDLING_'.$ii.'_DESC' , 'Handling Fee for this shipping zone');
}
