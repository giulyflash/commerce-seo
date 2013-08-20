<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_db_error.inc.php
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



  function xtc_db_error($errno, $errstr, $errfile, $errline) {
    switch ($errno) {
    case E_USER_ERROR:
        if ($errstr == "(SQL)"){
            // handling an sql error
            // if ($_SESSION['customers_status']['customers_status_id'] == 0) {
				echo "<b>SQL Fehler</b> [$errno] " . SQLMESSAGE . "<br /><br />\n\n";
				echo "<b>Query:</b> " . SQLQUERY . "<br /><br />\n\n";
				echo "Beim Aufruf der Datei <em>" . SQLERRORFILE . "</em> ";
				echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br /><br />\n\n";
			// }
            xtc_db_query("REPAIR TABLE sessions");
            xtc_db_query("REPAIR TABLE whos_online");
            xtc_db_query("REPAIR TABLE whos_online_month");
            xtc_db_query("REPAIR TABLE whos_online_year");
            echo "<b>Die Abfrage wurde abgebrochen, kontaktieren Sie den Administrator...</b><br /><br />\n\n";
        } else {
				echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
				echo "  Fatal error on line $errline in file $errfile";
				echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			echo "<b>Die Abfrage wurde abgebrochen, kontaktieren Sie den Administrator...</b><br />\n";
        }
        exit(1);
        break;

    case E_USER_WARNING:
    case E_USER_NOTICE:
    }
    /* Don't execute PHP internal error handler */
    return true;
  }


function sqlerrorhandler($ERROR, $QUERY, $PHPFILE, $LINE) {
    define("SQLQUERY", $QUERY);
    define("SQLMESSAGE", $ERROR);
    define("SQLERRORLINE", $LINE);
    define("SQLERRORFILE", $PHPFILE);
    trigger_error("(SQL)", E_USER_ERROR);
}

set_error_handler("xtc_db_error");
?>