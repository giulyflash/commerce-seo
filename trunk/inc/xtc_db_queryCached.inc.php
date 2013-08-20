<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_db_queryCached.inc.php
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






  function xtc_db_queryCached($query, $link = 'db_link') {
    global $$link;

    // get HASH ID for filename
    $id=md5($query);


    // cache File Name
    $file=SQL_CACHEDIR.$id.'.xtc';

    // file life time
    $expire = DB_CACHE_EXPIRE; // 24 hours

    if (STORE_DB_TRANSACTIONS == 'true') {
      error_log('QUERY ' . $query . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

    if (file_exists($file) && filemtime($file) > (time() - $expire)) {

     // get cached resulst
        $result = unserialize(implode('',file($file)));

        } else {

         if (file_exists($file)) @unlink($file);

        // get result from DB and create new file
        $result = mysql_query($query, $$link) or xtc_db_error($query, mysql_errno(), mysql_error());

        if (STORE_DB_TRANSACTIONS == 'true') {
                $result_error = mysql_error();
                error_log('RESULT ' . $result . ' ' . $result_error . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
        }

        // fetch data into array
        while ($record = xtc_db_fetch_array($result))
                $records[]=$record;


        // safe result into file.
        $stream = serialize($records);
        $fp = fopen($file,"w");
        fwrite($fp, $stream);
        fclose($fp);
        $result = unserialize(implode('',file($file)));

   }

    return $result;
  }
?>
