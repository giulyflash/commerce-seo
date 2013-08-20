<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_validate_password.inc.php
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




// This funstion validates a plain text password with an
// encrpyted password
function xtc_validate_password($plain, $encrypted) {
	if (xtc_not_null($plain) && xtc_not_null($encrypted)) {
	// split apart the hash old Style
		if (ACCOUNT_PASSWORD_SECURITY == 'false') {
			if ($encrypted !== md5($plain)){
				return false;
			} else {
				return true;
			}
		} else {
			// split apart the hash / salt
			if ($encrypted !== sha1($plain.SALT_KEY) && $encrypted !== md5($plain)){
				return false;
			} else {
				return true;
			}
		}
	}

	return false;
}
?>