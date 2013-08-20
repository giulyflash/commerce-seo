<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_encrypt_password.inc.php
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




// This function makes a new password from a plaintext password. 
function xtc_encrypt_password($plain) {
	if (ACCOUNT_PASSWORD_SECURITY == 'false') {
		$password=md5($plain);
	} else {
		$password=sha1($plain.SALT_KEY);
	}

	return $password;

}
?>