<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_href_link_from_admin.inc.php
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




    function xtc_href_link_from_admin($page= '',$parameters= '',$connection= 'NONSSL',$add_session_id= true,$search_engine_safe = true) {

    global $request_type, $session_started, $http_domain, $https_domain;

    require_once(DIR_FS_INC . 'xtc_check_agent.inc.php');

    if (!xtc_not_null($page)) {
      die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine the page link ('.$page.')!<br><br>');
    }

    if ($connection == 'NONSSL') {
        $link = HTTP_SERVER . DIR_WS_CATALOG;
    } elseif ($connection == 'SSL') {
        if (ENABLE_SSL == true) {
            $link = HTTPS_SERVER . DIR_WS_CATALOG;
        } else{
            $link = HTTP_SERVER . DIR_WS_CATALOG;
        }
    } else{
        die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br>Known methods: NONSSL SSL</b><br><br>');
    }

    if (xtc_not_null($parameters)) {
      $link .= $page . '?' . $parameters;
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
    if ( ($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'false') ) {
      if (defined('SID') && xtc_not_null(SID)) {
        $sid = SID;
      } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == true) ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
        if ($http_domain != $https_domain) {
          $sid = session_name() . '=' . session_id();
        }
      }
    }


    if (xtc_check_agent()==1) {

    $sid=NULL;

    }
    if (isset($sid)) {
      $link .= $separator . $sid;
    }

//--- SEO Hartmut KĐ ĐŽĐ˛Đ‚Â nig -------------------------//

    return $link;
  }

 ?>