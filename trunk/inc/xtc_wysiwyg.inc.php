<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_wysiwyg.inc.php
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


function xtc_wysiwyg($type, $lang = '', $langID = '', $value = '') {
	if(USE_WYSIWYG == 'true') {
		include_once DIR_WS_INCLUDES .'editor/ckeditor/ckeditor.php';
		include_once DIR_WS_INCLUDES .'editor/ckfinder/ckfinder.php';

		$ckeditor = new CKEditor();
		$ckeditor->basePath = DIR_WS_INCLUDES . 'editor/ckeditor/';
		$ckfinder = new CKFinder();
		$ckfinder->BasePath = DIR_WS_INCLUDES . 'editor/ckfinder/';
		$ckfinder->SetupCKEditorObject($ckeditor);

		$ckeditor->replace($type);
	}	
}
?>
