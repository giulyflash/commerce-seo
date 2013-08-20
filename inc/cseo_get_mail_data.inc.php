<?php
/*-----------------------------------------------------------------
* 	ID:						cseo_get_mail_data.inc.php
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



$search = array('{$store_name}', '{$shop_besitzer}');
$replace = array(STORE_NAME, STORE_OWNER);

function replaceVar($var) {
global $db;
	return str_replace($search, $replace, $var);
}

function cseo_get_mail_data($name = '') {
global $db;
	if($name != '') {
		$subject_query = xtc_db_fetch_array(xtc_db_query("SELECT email_address,
																email_address_name,
																email_replay_address,
																email_replay_address_name,
																email_subject,
																email_forward  
																FROM ".TABLE_EMAILS." 
																WHERE email_name = '".$name."' 
																AND languages_id = '".(int)$_SESSION['languages_id']."' "));

														
		return array('EMAIL_ADDRESS' => replaceVar($subject_query['email_address']),
					  'EMAIL_ADDRESS_NAME' => replaceVar($subject_query['email_address_name']),
					  'EMAIL_REPLAY_ADDRESS' => replaceVar($subject_query['email_replay_address']),
					  'EMAIL_REPLAY_ADDRESS_NAME' => replaceVar($subject_query['email_replay_address_name']),
					  'EMAIL_SUBJECT' => replaceVar($subject_query['email_subject']),
					  'EMAIL_FORWARD' => $subject_query['email_forward']);
		
	} else
		return 'Die Maildaten konnten nicht gefunden werden!';
}

?>