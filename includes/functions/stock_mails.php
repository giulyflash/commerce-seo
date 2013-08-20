<?php
/*-----------------------------------------------------------------
* 	$Id: stock_mails.php 420 2013-06-19 18:04:39Z akausch $
* 	Copyright (c) 2011-2021 commerce:SEO by Webdesign Erfurt
* 	http://www.commerce-seo.de
* ------------------------------------------------------------------
* 	based on:
* 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
* 	(c) 2002-2003 osCommerce - www.oscommerce.com
* 	(c) 2003     nextcommerce - www.nextcommerce.org
* 	(c) 2005     xt:Commerce - www.xt-commerce.com
* 	Released under the GNU General Public License
* ---------------------------------------------------------------*/


function sendstockmails() {

	$smarty= new Smarty();
	$smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
	$smarty->assign('logo_path',HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
	$smarty->assign('STORE_NAME',STORE_NAME);

	$smarty->caching = false;
	
	$strstockQuery_allready_sent = "
		SELECT
			products_id,
			products_quantity,
			products_model,
			products_price, 
			stock_mail
		FROM
			".TABLE_PRODUCTS."
		WHERE
			products_quantity > '".STOCK_REORDER_LEVEL."'
		AND
			stock_mail = '1'
	";
	
	$resstockQuery_allready_sent = xtc_db_query($strstockQuery_allready_sent);

	while($arrstock_allready_sent = xtc_db_fetch_array($resstockQuery_allready_sent)) {
		
		$strMarkQuery_allready_sent = "
			UPDATE
				".TABLE_PRODUCTS."
			SET
				stock_mail = '0'
			WHERE
				products_id = '".$arrstock_allready_sent['products_id']."' 
			AND
				stock_mail = '1'
		";
		
		xtc_db_query($strMarkQuery_allready_sent);			
	}
	
	if(MODULE_CUSTOMERS_ADMINMAIL_STATUS == 'true') {

		$strstockQuery = "
			SELECT
				p.products_id,
				p.products_quantity,
				p.products_model,
				p.products_price,
				pd.products_name,
				p.stock_mail
			FROM
				".TABLE_PRODUCTS." p,
				".TABLE_PRODUCTS_DESCRIPTION." pd
				
			WHERE
				p.products_id = pd.products_id
			AND
				p.products_quantity <= '".STOCK_REORDER_LEVEL."'
			AND
				p.stock_mail = '0'
		";	
	
		$resstockQuery = xtc_db_query($strstockQuery);

		while($arrstock = xtc_db_fetch_array($resstockQuery)) {
		
			$smarty->assign('PRODUCTS_ID', $arrstock['products_id']);
			$smarty->assign('PRODUCTS_NAME', $arrstock['products_name']);
			$smarty->assign('PRODUCTS_MODEL', $arrstock['products_model']);
			$smarty->assign('PRODUCTS_QUANTITY', $arrstock['products_quantity']);
			$smarty->assign('STOCK_AMOUNT', STOCK_REORDER_LEVEL);
			
			$link = HTTP_SERVER.DIR_WS_CATALOG.FILENAME_PRODUCT_INFO."?products_id=".$arrstock['products_id'];
			
			$smarty->assign('LINK', $link);
			$smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');	

			$strValidateQuery = "
				SELECT
					products_id
				FROM
					".TABLE_PRODUCTS."
				WHERE
					products_id = '".$arrstock['products_id']."' 
				AND
					stock_mail = '0'
			";
	
			$strMarkQuery = "
				UPDATE
					".TABLE_PRODUCTS."
				SET
					stock_mail = '1'
				WHERE
					products_id = '".$arrstock['products_id']."' 
				AND
					stock_mail = '0'
			";
	
			if(xtc_db_num_rows(xtc_db_query($strValidateQuery)) == 1) {
	
				xtc_db_query($strMarkQuery);
			
			require_once (DIR_FS_INC.'cseo_get_mail_body.inc.php');
			$html_mail = $smarty->fetch('html:stock_mail');
			$txt_mail = $smarty->fetch('txt:stock_mail');
			require_once (DIR_FS_INC.'cseo_get_mail_data.inc.php');
			$mail_data = cseo_get_mail_data('stock_mail');

			// create subject
			// $order_subject = sprintf('Lagerwarnung: '.$arrstock['products_name'].' ('.$arrstock['products_model'].') '.'hat niedrigen Lagerstand erreicht', STORE_NAME);
			$order_subject = str_replace('{$name}', $arrstock['products_name'], $mail_data['EMAIL_SUBJECT']);
			$order_subject = str_replace('{$artnr}', $arrstock['products_model'], $order_subject);
			
			
			xtc_php_mail($mail_data['EMAIL_ADDRESS'],
					$order->customer['firstname'].' '.$order->customer['lastname'],
					$mail_data['EMAIL_ADDRESS'],
					$mail_data['EMAIL_ADDRESS_NAME'],
					$mail_data['EMAIL_FORWARD'],
					$order->customer['email_address'],
					$order->customer['firstname'].' '.$order->customer['lastname'],
					'',
					'',
					$order_subject,
					$html_mail,
					$txt_mail);
			}
		}
	}
	return;
}
?>