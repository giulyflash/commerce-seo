<?php
/*-----------------------------------------------------------------
* 	ID:						xtc_collect_posts.inc.php
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




function xtc_collect_posts() {
	global $REMOTE_ADDR, $xtPrice;
	
	if ($_POST['gv_redeem_code']) {
	
		// ERROR : KEINEN CODE EINGEGEBEN
     	if ($_POST['gv_redeem_code'] == '') {
			xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_NO_REDEEM_CODE), 'SSL'));
		}
	
		// INFOS ZUM GUTSCHEIN / KUPON AUSLESEN
		$gv_query = xtc_db_query("select * from " . TABLE_COUPONS . " where coupon_code = '" . $_POST['gv_redeem_code'] . "' and coupon_active = 'Y' limit 1");
        $gv_result = xtc_db_fetch_array($gv_query);
    
	    // ERROR : CODE EXISTIERT NICHT
		if (xtc_db_num_rows($gv_query) == 0) {
	        xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_NO_INVALID_REDEEM_GV), 'SSL'));
        }


		//////////////////////////////////////////////////////////////////
		// BEREICH FĂśR GUTSCHEINE
		//////////////////////////////////////////////////////////////////
        if ($gv_result['coupon_type'] == 'G') {
	
			// ERROR : GUTSCHEIN BEREITS EINGELĂ–ST
	        $redeem_query = xtc_db_query("select * from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $gv_result['coupon_id'] . "' limit 1");
	        if (xtc_db_num_rows($redeem_query) != 0) {
    	        xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_NO_INVALID_REDEEM_GV), 'SSL'));
          	}

			// GUTSCHEIN ID IN SESSION SPEICHERN
			$_SESSION['gv_id'] = $gv_result['coupon_id'];
			if (!$_SESSION['gv_id']) {
				$_SESSION['gv_id'] = 'gv_id';
			}
		
			// ERROR : KUNDE IST NICHT EINGELOGGT, BZW. HAT KEIN KUNDENKONTO
			$customers_query = xtc_db_query("select customers_id from " . TABLE_CUSTOMERS . " where customers_id = '" . (int) $_SESSION['customer_id'] . "' limit 1");
			$customers = xtc_db_fetch_array($customers_query);
			if (xtc_db_num_rows($customers_query) == 0) {
	        	xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_GV_LOGIN), 'SSL'));		
			}

			// GUTSCHEIN EINLĂ–SEN
			require_once (DIR_FS_INC . 'coupon_mod_functions.php');
			redeem_gv_from_session();

      	} 
		
		
		//////////////////////////////////////////////////////////////////
		// BEREICH FĂśR KUPONS
		//////////////////////////////////////////////////////////////////
        if ($gv_result['coupon_type'] != 'G') {
			$teq = 0;
			
			// KUPON ID IN SESSION SPEICHERN
			$_SESSION['cc_id'] = $gv_result['coupon_id']; 
			if (!$_SESSION['cc_id']) {
				$_SESSION['cc_id'] = 'cc_id';
			}

			// ERROR : LAUFZEIT HAT NOCH NICHT BEGONNEN
			if ($gv_result['coupon_start_date'] > date('Y-m-d H:i:s')) {
        	    xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_STARTDATE_COUPON), 'SSL'));
        	}

			// ERROR : LAUFZEIT BEENDET
			if ($gv_result['coupon_expire_date'] < date('Y-m-d H:i:s')) {
        	    xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_FINISDATE_COUPON), 'SSL'));
        	}

			// ERROR : MINDESTBESTELLWERT NICHT ERREICHT
			if ($gv_result['coupon_minimum_order'] > $_SESSION['cart']->show_total()) {
        	    xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_MINIMUM_ORDER_COUPON_1 . ' ' . $xtPrice->xtcFormat($gv_result['coupon_minimum_order'], true) . ' ' . ERROR_MINIMUM_ORDER_COUPON_2), 'SSL'));
			}
			
			// ERROR : GESAMTES VERWENDUNGSLIMIT ĂśBERSCHRITTEN				
	        $coupon_count = xtc_db_query("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $gv_result['coupon_id']."'");
        	if (xtc_db_num_rows($coupon_count) >= $gv_result['uses_per_coupon'] && $gv_result['uses_per_coupon'] > 0) {
            	xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_USES_COUPON . $gv_result['uses_per_coupon'] . TIMES ), 'SSL'));
	        }

			// ERROR : VERWENDUNGSLIMIT FĂśR EINZELNEN KUNDEN ĂśBERSCHRITTEN		
    	    $coupon_count_customer = xtc_db_query("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $gv_result['coupon_id']."' and customer_id = '" . (int) $_SESSION['customer_id'] . "'");
    	    if (xtc_db_num_rows($coupon_count_customer) >= $gv_result['uses_per_user'] && $gv_result['uses_per_user'] > 0) {
        	    xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_USES_USER_COUPON . $gv_result['uses_per_user'] . TIMES2 ), 'SSL'));
	        }

			// ERROR : BESCHRĂ„NKUNG AUF PRODUKTE
			if ($gv_result['restrict_to_products']) {							
				$products = $_SESSION['cart']->get_products();			
				// SCHLEIFE FĂśR JEDES PRODUKT IM WARENKORB
				for ($i = 0; $i < sizeof($products); $i ++) {
					$product_found = false;
					$t_prid = xtc_get_prid($products[$i]['id']);
					$pr_ids = split("[,]", $gv_result['restrict_to_products']);							
					// SCHLEIFE FĂśR ALLE GĂśLTIGEN PRODUKTE
					for ($ii = 0; $ii < sizeof($pr_ids); $ii ++) {						
						// PASSENDER ARTIKEL GEFUNDEN
						if ($t_prid == $pr_ids[$ii]){
							$product_found = true;	
						// KEINEN PASSENDEN ARTIKEL GEFUNDEN
						} else {
							if ($ii+1 == sizeof($pr_ids) && $product_found == false) {
								xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_PRODUCT_COUPON), 'SSL'));
							}
						}	
					}						
				}
			}

			// ERROR : BESCHRĂ„NKUNG AUF KATEGORIEN
			if ($gv_result['restrict_to_categories']) {
				$products = $_SESSION['cart']->get_products();
				// SCHLEIFE FĂśR JEDES PRODUKT IM WARENKORB
				for ($i = 0; $i < sizeof($products); $i ++) {
					$product_found = false;
					$t_prid = xtc_get_prid($products[$i]['id']);
					$cat_ids = split("[,]", $gv_result['restrict_to_categories']);
					// SCHLEIFE FĂśR GĂśLTIGE KATEGORIEN
					for ($ii = 0; $ii < sizeof($cat_ids); $ii ++) {
						// NACH UNTERKATEGORIEN SUCHEN
						$subcategories_array = array ();
						require_once (DIR_FS_INC.'xtc_get_subcategories.inc.php');
						xtc_get_subcategories($subcategories_array, $cat_ids[$ii]);	
						// WENN UNTERKATEGORIEN EXISTIEREN
						if (sizeof($subcategories_array) > 0) {
							for ($iii = 0; $iii < sizeof($subcategories_array); $iii ++) {
								$cat_query = xtc_db_query("select products_id from products_to_categories where products_id = '" . $t_prid . "' and (categories_id = '" . $cat_ids[$ii] . "' or categories_id = '" . $subcat_ids[$iii] . "')");
								// PASSENDER ARTIKEL GEFUNDEN
								if (xtc_db_num_rows($cat_query) != 0){
									$product_found = true;
								// KEINEN PASSENDEN ARTIKEL GEFUNDEN
								} else {
									if ($ii+1 == sizeof($cat_ids) && $product_found == false) {
										xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_CATEGORIE_COUPON), 'SSL'));
									}									
								}
							}
						// KEINE UNTERKATEGORIEN VORHANDEN
						} else {
							$cat_query = xtc_db_query("select products_id from products_to_categories where products_id = '" . $t_prid . "' and categories_id = '" . $cat_ids[$ii] . "'");
							// PASSENDER ARTIKEL GEFUNDEN
							if (xtc_db_num_rows($cat_query) != 0){
								$product_found = true;
							// KEINEN PASSENDEN ARTIKEL GEFUNDEN
							} else {
								if ($ii+1 == sizeof($cat_ids) && $product_found == false) {
									xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_INVALID_CATEGORIE_COUPON), 'SSL'));
								}									
							}
						}
					} 
				} 
			} 
							
			// WEITERLEITUNG ZUM WARENKORB NACH ERFOLGREICHEM EINLĂ–SEN DES KUPONS
	        xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(REDEEMED_COUPON), 'SSL'));

		} 

	// ERROR : KEINEN CODE EINGEGEBEN
	} else if (!$_POST['gv_redeem_code']) {
		xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_NO_REDEEM_CODE), 'SSL'));
	}

}
?>