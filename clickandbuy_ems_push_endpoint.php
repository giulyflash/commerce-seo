<?php

/* -----------------------------------------------------------------
 * 	$Id: clickandbuy_ems_push_endpoint.php 420 2013-06-19 18:04:39Z akausch $
 * 	Copyright (c) 2011-2021 commerce:SEO by Webdesign Erfurt
 * 	http://www.commerce-seo.de
 * ------------------------------------------------------------------
 * 	based on:
 * 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 * 	(c) 2002-2003 osCommerce - www.oscommerce.com
 * 	(c) 2003     nextcommerce - www.nextcommerce.org
 * 	(c) 2005     xt:Commerce - www.xt-commerce.com
 * 	Released under the GNU General Public License
 * --------------------------------------------------------------- */

require_once('ext/clickandbuy/lib/xml_parser.php');

include_once('includes/configure.php');
include_once('includes/filenames.php');

require_once (DIR_FS_INC . 'cseo_db.inc.php');

xtc_db_connect();

function find_node($root, $tagName) {
    $res = array();
    foreach ($root->tagChildren as $child) {
        $res = array_merge($res, find_node($child, $tagName));
        if ($child->tagName == $tagName)
            array_push($res, $child);
    }
    return $res;
}

$postData = $_POST['xml'];
if (!$postData)
    die('ERROR no data');
if (get_magic_quotes_gpc())
    $postData = stripslashes($postData);

/* Parse the XML */
$parser = new XMLParser($postData);
$parser->parse();
$doc = $parser->document;

/* Extract the info we want */
$crn = $doc->global[0]->crn[0]->tagData;
$type = $doc->tagChildren[1]->tagName;
$datetime = $doc->global[0]->datetime[0]->tagData;
if ($datetime) {
    $datetime = vsprintf('%s%s-%s-%s %s:%s:%s', explode('|', chunk_split($datetime, 2, '|')));
}

$qr = false;
switch (strtolower($type)) {
    case 'bdr':
        $bdr_data = $doc->bdr[0]->bdr_data[0];

        $BDRID = $bdr_data->bdr_id[0]->tagData;
        $externalBDRID = $bdr_data->externalbdrid[0]->tagData;
        $action = $bdr_data->action[0]->tagData;

        $state = $action;
        $qr = xtc_db_query(vsprintf("INSERT INTO orders_clickandbuy_ems (tst_received, datetime, type, xml, externalBDRID, BDRID, crn, action) VALUES (NOW(), '%s', '%s', '%s', '%s', %d, %d, '%s')", array_map('mysql_escape_string', array($datetime, $type, $postData, $externalBDRID, $BDRID, $crn, $state))));
        break;

    default:
        $action = find_node($doc->tagChildren[1], 'action');
        $state = $action ? $action[0]->tagData : 'other';
        $qr = xtc_db_query(vsprintf("INSERT INTO orders_clickandbuy_ems (tst_received, datetime, type, xml, crn, action) VALUES (NOW(), '%s', '%s', '%s', %d, '%s')", array_map('mysql_escape_string', array($datetime, $type, $postData, $crn, $state))));
        break;
}

if ($qr !== false)
    print('OK');
else
    print('ERROR');
 
