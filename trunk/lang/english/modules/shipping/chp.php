<?php
/*-----------------------------------------------------------------
* 	$Id: chp.php 496 2013-07-17 09:56:08Z akausch $
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

define('MODULE_SHIPPING_CHP_TEXT_TITLE', 'The Swiss Post');
define('MODULE_SHIPPING_CHP_TEXT_DESCRIPTION', 'The Swiss Post');
define('MODULE_SHIPPING_CHP_TEXT_WAY', 'Dispatch to');
define('MODULE_SHIPPING_CHP_TEXT_UNITS', 'kg');
define('MODULE_SHIPPING_CHP_INVALID_ZONE', 'Unfortunately it is not possible to dispatch into this country');
define('MODULE_SHIPPING_CHP_UNDEFINED_RATE', 'Forwarding expenses cannot be calculated for the moment');

define('MODULE_SHIPPING_CHP_COST_PRI_5_TITLE' , 'Tariftabelle for Zone 4 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_5_DESC' , 'Tarif Tabelle for die Zone 4, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COST_ECO_5_TITLE' , 'Tariftabelle for Zone 4 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_5_DESC' , 'Tarif Tabelle for die Zone 4, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COUNTRIES_5_TITLE' , 'Tarifzone 4 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_5_DESC' , 'Durch Komma getrennt Liste der Countries als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 4 sind.');
define('MODULE_SHIPPING_CHP_COST_ECO_4_TITLE' , 'Tariftabelle for Zone 3 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_4_DESC' , 'Tarif Tabelle for die Zone 3, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COST_PRI_4_TITLE' , 'Tariftabelle for Zone 3 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_4_DESC' , 'Tarif Tabelle for die Zone 3, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COST_URG_4_TITLE' , 'Tariftabelle for Zone 3 bis 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_4_DESC' , 'Tarif Tabelle for die Zone 3, basiered auf <b>\'URG\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COST_URG_3_TITLE' , 'Tariftabelle for Zone 2 bis 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_3_DESC' , 'Tarif Tabelle for die Zone 2, basiered auf <b>\'URG\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COUNTRIES_4_TITLE' , 'Tarifzone 3 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_4_DESC' , 'Durch Komma getrennt Liste der Countries als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 3 sind.');
define('MODULE_SHIPPING_CHP_STATUS_TITLE' , 'Schweizerische Post');
define('MODULE_SHIPPING_CHP_STATUS_DESC' , 'Wollen Sie den Versand РЎРЉber die schweizerische Post anbieten?');
define('MODULE_SHIPPING_CHP_HANDLING_TITLE' , 'Handling Fee');
define('MODULE_SHIPPING_CHP_HANDLING_DESC' , 'BearbeitungsgebРЎРЉhr for diese Versandart in CHF');
define('MODULE_SHIPPING_CHP_TAX_CLASS_TITLE' , 'Steuersatz');
define('MODULE_SHIPPING_CHP_TAX_CLASS_DESC' , 'WР Т‘hlen Sie den MwSt.-Satz for diese Versandart aus.');
define('MODULE_SHIPPING_CHP_ZONE_TITLE' , 'Versand Zone');
define('MODULE_SHIPPING_CHP_ZONE_DESC' , 'Wenn Sie eine Zone auswР Т‘hlen, wird diese Versandart nur in dieser Zone angeboten.');
define('MODULE_SHIPPING_CHP_SORT_ORDER_TITLE' , 'Reihenfolge der Anzeige');
define('MODULE_SHIPPING_CHP_SORT_ORDER_DESC' , 'Niedrigste wird zuerst angezeigt.');
define('MODULE_SHIPPING_CHP_ALLOWED_TITLE' , 'Einzelne Versandzonen');
define('MODULE_SHIPPING_CHP_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, in welche ein Versand mРЎвЂ glich sein soll. zb AT,DE');
define('MODULE_SHIPPING_CHP_COUNTRIES_1_TITLE' , 'Tarifzone 0 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_1_DESC' , 'Inlandszone');
define('MODULE_SHIPPING_CHP_COST_ECO_1_TITLE' , 'Tariftabelle for Zone 0 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_1_DESC' , 'Tarif Tabelle for die Inlandszone, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COST_PRI_1_TITLE' , 'Tariftabelle for Zone 0 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_1_DESC' , 'Tarif Tabelle for die Inlandszone, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COUNTRIES_2_TITLE' , 'Tarifzone 1 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_2_DESC' , 'Durch Komma getrennt Liste der Countries als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 1 sind.');
define('MODULE_SHIPPING_CHP_COST_ECO_2_TITLE' , 'Tariftabelle for Zone 1 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_2_DESC' , 'Tarif Tabelle for die Zone 1, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COST_PRI_2_TITLE' , 'Tariftabelle for Zone 1 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_2_DESC' , 'Tarif Tabelle for die Zone 1, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COST_URG_2_TITLE' , 'Tariftabelle for Zone 1 bis 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_2_DESC' , 'Tarif Tabelle for die Zone 1, basiered auf <b>\'URG\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COUNTRIES_3_TITLE' , 'Tarifzone 2 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_3_DESC' , 'Durch Komma getrennt Liste der Countries als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 2 sind.');
define('MODULE_SHIPPING_CHP_COST_ECO_3_TITLE' , 'Tariftabelle for Zone 2 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_3_DESC' , 'Tarif Tabelle for die Zone 2, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COST_PRI_3_TITLE' , 'Tariftabelle for Zone 2 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_3_DESC' , 'Tarif Tabelle for die Zone 2, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COST_URG_5_TITLE' , 'Tariftabelle for Zone 4 bis 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_5_DESC' , 'Tarif Tabelle for die Zone 4, basiered auf <b>\'URG\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COUNTRIES_6_TITLE' , 'Tarifzone 4 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_6_DESC' , 'Durch Komma getrennt Liste der Countries als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 4 sind.');
define('MODULE_SHIPPING_CHP_COST_ECO_6_TITLE' , 'Tariftabelle for Zone 4 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_6_DESC' , 'Tarif Tabelle for die Zone 4, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COST_PRI_6_TITLE' , 'Tariftabelle for Zone 4 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_6_DESC' , 'Tarif Tabelle for die Zone 4, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COST_URG_6_TITLE' , 'Tariftabelle for Zone 4 bis 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_6_DESC' , 'Tarif Tabelle for die Zone 4, basiered auf <b>\'URG\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COUNTRIES_7_TITLE' , 'Tarifzone 5 Countries');
define('MODULE_SHIPPING_CHP_COUNTRIES_7_DESC' , 'Durch Komma getrennt Liste der Countries als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 5 sind.');
define('MODULE_SHIPPING_CHP_COST_ECO_7_TITLE' , 'Tariftabelle for Zone 5 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_7_DESC' , 'Tarif Tabelle for die Zone 5, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COST_PRI_7_TITLE' , 'Tariftabelle for Zone 5 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_7_DESC' , 'Tarif Tabelle for die Zone 5, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');
define('MODULE_SHIPPING_CHP_COST_URG_7_TITLE' , 'Tariftabelle for Zone 5 bis 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_7_DESC' , 'Tarif Tabelle for die Zone 5, basiered auf <b>\'URG\'</b> bis 30 kg Versandgewicht.');
