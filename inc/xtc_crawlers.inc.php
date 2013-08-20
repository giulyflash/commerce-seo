<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_crawlers.inc.php
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



   
// search engine referer urls
$engines = array(
'www.alexa.com' => 'Alexa',
'www.alltheinternet.com' => 'All the Internet',
'alltheweb.com' => 'AlltheWeb.com',
'www.altavista.com' => 'AltaVista',
'aolsearch.aol.com' => 'AOL Web Search',
'search.aol.com' => 'AOL Web Search',
'web.ask.com' => 'Ask Jeeves',
'search.dmoz.org' => 'DMOZ',
'www.dogpile.com' => 'Dogpile',
'search.earthlink.net' => 'EarthLink',
'www.entireweb.com' => 'Entireweb',
'euroseek.com' => 'Euroseek.com',
'msxml.excite.com' => 'Excite',
'www.gigablast.com' => 'Gigablast',
'www.google.com' => 'Google',
'www.google.de' => 'Google',
'www.bing.com' => 'Bing',
'www.hotbot.com' => 'HotBot',
'search.iwon.com' => 'iWon',
'search.looksmart.com' => 'LookSmart',
'www.metacrawler.com' => 'MetaCrawler',
'search.msn.com' => 'MSN Search',
'search.netscape.com' => 'Netscape Search',
'www.overture.com' => 'Overture',
'www.search.com' => 'Search.com',
's.teoma.com' => 'Teoma',
'search.viewpoint.com' => 'Viewpoint',
'msxml.webcrawler.com' => 'WebCrawler',
'www.wisenut.com' => 'WiseNut',
'search.yahoo.com' => 'Yahoo!',
'br.busca.yahoo.com' => 'Yahoo!', // Brazil
'www.zeal.com' => 'Zeal.com'
);

// search engine "start of query" markers
$keymark = array(
'Alexa' => 'q=',
'All the Internet' => 'q=',
'AlltheWeb.com' => 'q=',
'AltaVista' => 'q=',
'AOL Web Search' => 'query=',
'Ask Jeeves' => 'q=',
'DMOZ' => 'search=',
'Dogpile' => 'web/',
'EarthLink' => 'q=',
'Entireweb' => 'q=',
'Euroseek.com' => 'string=',
'Excite' => 'web/',
'Gigablast' => 'q=',
'Google' => 'q=',
'HotBot' => 'query=',
'iWon' => 'searchfor=',
'LookSmart' => 'qt=',
'MetaCrawler' => 'web/',
'MSN Search' => 'q=',
'Netscape Search' => 'query=',
'Overture' => 'Keywords=',
'Search.com' => 'q=',
'Teoma' => 'q=',
'Viewpoint' => 'k=',
'WebCrawler' => 'web/',
'WiseNut' => 'q=',
'Yahoo!' => 'p=',
'Zeal.com' => 'keyword='
);
?>