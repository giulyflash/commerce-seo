<?php
/*-----------------------------------------------------------------
* 	ID:						cseo_get_url_friendly_text.inc.php
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



function cseo_get_url_friendly_text($string) {
	$search = array();
	$replace = array();
	getRegExps($search, $replace);
    $validUrl  = preg_replace("/<br>/i","-",$string);
    $validUrl  = strip_tags($validUrl);
    $validUrl  = preg_replace("/\//","-",$validUrl);
    $validUrl  = preg_replace($search,$replace,$validUrl);
    $validUrl  = preg_replace("/(-){2,}/","-",$validUrl);
	$validUrl = preg_replace("/[^a-z0-9-]/i", "", $validUrl);
    $validUrl  = urlencode($validUrl);
    return($validUrl);
}


function getRegExps(&$search, &$replace) {
	$search = array(
					"/ß/",              //--Umlaute entfernen
                    "/ä/",
                    "/ü/",
                    "/ö/",
                    "/Ä/",
                    "/Ü/",
                    "/Ö/",
					"'&(auml|#228);'i",
					"'&(ouml|#246);'i",
					"'&(uuml|#252);'i",
					"'&(szlig|#223);'i",
					"'[\r\n\s]+'",	    // strip out white space
					"'&(quote|#34);'i",	// replace html entities
					"'&(amp|#38);'i",
					"'&(lt|#60);'i",
					"'&(gt|#62);'i",
					"'&(nbsp|#160);'i",
					"'&(iexcl|#161);'i",
					"'&(cent|#162);'i",
					"'&(pound|#163);'i",
					"'&(copy|#169);'i",
                    "'&'",              // ampersant in + konvertieren
                    "'%'",              //-- % entfernen
                    "/[\[\({]/",        //--ˆffnende Klammern nach Bindestriche entfernen
                    "/[\)\]\}]/",       //--schliessende Klammern entfernen
                    "/ﬂ/",              //--Umlaute entfernen
                    "/‰/",
                    "/¸/",
                    "/ˆ/",
                    "/ƒ/",
                    "/‹/",
                    "/÷/",
                    "/'|\"|¥|`/",       //--Anfuehrungszeichen entfernen
                    "/[:,\.!?\*\+]/",   //--Doppelpunkte, Komma, Punkt, asterisk entfernen
					"'\s&\s'",          // remove ampersant
                        );
    $replace    = array(
						"ss",
                        "ae",
                        "ue",
                        "oe",
                        "Ae",
                        "Ue",
                        "Oe",
						"ae",
						"oe",
						"ue",
						"ss",
						"-",
						"\"",
						"-",
						"<",
						">",
						"",
						chr(161),
						chr(162),
						chr(163),
						chr(169),
						"-",
						"+",
                        "-",
                        "",
                        "ss",
                        "ae",
                        "ue",
                        "oe",
                        "Ae",
                        "Ue",
                        "Oe",
                        "",
                        "",
						"-"
                        );
}
?>