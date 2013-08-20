<?php
/*-----------------------------------------------------------------
* 	ID:						charset_mapper.inc.php
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




  //for HTML
  //echo charset_mapper('utf-8',true);
  // for DB
  //echo charset_mapper('utf8',true);

function charset_mapper ( $charset, $change = false) {
  $db = array(
              'big5',
              'latin1',
              'latin2',
              'ascii',
              'hebrew',
              'tis620',
              'euckr',
              'koi8u',
              'gb2312',
              'greek',
              'cp1250',
              'gbk',
              'latin5',
              'utf8',
              'latin7',
              'cp1251',
              'cp1256',
              'cp1257'
              );

  $html = array(
                'big5',
                'ISO-8859-15',
                'ISO-8859-2',
                'US-ASCII',
                'ISO-8859-8',
                'TIS-620',
                'EUC-KR',
                'KOI8-U',
                'gb2312',
                'ISO-8859-7',
                'windows-1250',
                'windows-936',
                'ISO-8859-5',
                'utf-8',
                'ISO-8859-7',
                'Windows-1251',
                'windows-1256',
                'windows-1257'
                );

  if($change == false) {
    return str_replace($db, $html, $charset);
  } elseif($change == true) {
    foreach($html as $key=>$name) {
      $html[$key] = strtolower($name);
    }
    return str_replace( $html, $db, $charset);
  }
  else return false;
}

?>
