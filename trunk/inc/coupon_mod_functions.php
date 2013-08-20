<?php
/*-----------------------------------------------------------------
* 	ID:						coupon_mod_functions.php
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




//////////////////////////////////////////////////////////////////////////////////////////////
// KUPON CODE IN DER BESTELL-EMAIL
//////////////////////////////////////////////////////////////////////////////////////////////
function get_coupon_code_for_email($insert_id) {
	// KUPON ID AUSLESEN
	$coupon_id_query = xtc_db_query("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . " where order_id = '" . $insert_id . "' limit 1");
	$coupon_id = xtc_db_fetch_array($coupon_id_query);	  
	// KUPON CODE AUSLESEN
	if ($coupon_id['coupon_id'] != ""){
		$coupon_query = xtc_db_query("select coupon_code from " . TABLE_COUPONS . " where coupon_id = '" . $coupon_id['coupon_id'] . "' and coupon_type != 'G' limit 1");
		$coupon = xtc_db_fetch_array($coupon_query);	
	} 

	return $coupon['coupon_code'];
}


//////////////////////////////////////////////////////////////////////////////////////////////
// RESTLICHES GUTHABEN ERMITTELN
//////////////////////////////////////////////////////////////////////////////////////////////
function get_rest_amount($customer_id = "") {
	if ($customer_id != "") {
		$gv_query = xtc_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id ='" . (int) $customer_id . "'  limit 1");
		$gv_result = xtc_db_fetch_array($gv_query);
		require(DIR_WS_CLASSES . 'currencies.php');
		$currencies = new currencies();
		$rest_amount = $currencies->format($gv_result['amount']);
	} else if (isset ($_SESSION['customer_id'])) {
		$gv_query = xtc_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id ='" . (int) $_SESSION['customer_id'] . "'  limit 1");
		$gv_result = xtc_db_fetch_array($gv_query);
		if ($gv_result['amount'] > 0) {
			$rest_amount = $gv_result['amount'];
		}
	}
	return $rest_amount;
}


//////////////////////////////////////////////////////////////////////////////////////////////
// GUTSCHEIN AUS SESSION EINLĂ–SEN (FĂśR GĂ„STE)
//////////////////////////////////////////////////////////////////////////////////////////////
function redeem_gv_from_session() {
	global $REMOTE_ADDR, $xtPrice;

	// KONFIGURATION AUSLESEN
	$enabled = MODULE_ORDER_TOTAL_GV_STATUS == 'true' ? true : false;

	if (isset ($_SESSION['customer_id'])&& $enabled == 'true') {
	
		// KUNDENKONTO PRĂśFEN
		$customers_query = xtc_db_query("select customers_id from " . TABLE_CUSTOMERS . " where customers_id = '" . (int) $_SESSION['customer_id'] . "' limit 1");
		$customers = xtc_db_fetch_array($customers_query);
		
		if (xtc_db_num_rows($customers_query) != 0) {

			// INFOS ZUM GUTSCHEIN AUSLESEN
			$coupon_query = xtc_db_query("select coupon_amount, coupon_id from " . TABLE_COUPONS . " where coupon_id = '" . (int) $_SESSION['gv_id'] . "' and coupon_active = 'Y' limit 1");
		   	$coupon = xtc_db_fetch_array($coupon_query);

	    	// ERROR : GUTSCHEIN BEREITS EINGELĂ–ST
	        $redeem_query = xtc_db_query("select * from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . (int) $_SESSION['gv_id'] . "' limit 1");
	       	if (xtc_db_num_rows($redeem_query) != 0) {
				unset ($_SESSION['gv_id']);
	   	        xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(ERROR_NO_INVALID_REDEEM_GV), 'SSL'));
    	   	}
			
			// VERFĂśGBARES GUTHABEN BERECHNEN
			$gv_amount_query = xtc_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . (int) $_SESSION['customer_id'] . "' limit 1");
			// KUNDE HAT BEREITS EIN GUTHABEN, DANN ADDIEREN
			if ($gv_amount_result = xtc_db_fetch_array($gv_amount_query)) {
           		$total_gv_amount = $gv_amount_result['amount'] + $coupon['coupon_amount'];
	           	$gv_update = xtc_db_query("update " . TABLE_COUPON_GV_CUSTOMER . " set amount = '" . $total_gv_amount . "' where customer_id = '" . (int) $_SESSION['customer_id'] . "'");
    	   	// KUNDE HAT NOCH KEIN GUTHABEN, DANN NEU ANLEGEN
			} else {
				$gv_insert = xtc_db_query("insert into " . TABLE_COUPON_GV_CUSTOMER . " (customer_id, amount) values ('" . (int) $_SESSION['customer_id'] . "', '" . $coupon['coupon_amount'] . "')");
			}

			// GUTSCHEIN DEAKTIVIEREN
			$gv_update = xtc_db_query("update " . TABLE_COUPONS . " set coupon_active = 'N' where coupon_id = '" . $coupon['coupon_id'] . "'");

			// IP ADRESSE DES KUNDEN
			if (!$REMOTE_ADDR) { 
				$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
			}

			// EINLĂ–SEN IN PROTOKOLL EINTRAGEN
			$gv_redeem = xtc_db_query("insert into  " . TABLE_COUPON_REDEEM_TRACK . " (coupon_id, customer_id, redeem_date, redeem_ip) values ('" . $coupon['coupon_id'] . "', '" . (int) $_SESSION['customer_id'] . "', now(),'" . $REMOTE_ADDR . "')");

			// WEITERLEITUNG ZUM WARENKORB NACH ERFOLGREICHEM EINLĂ–SEN DES GUTSCHEINS
			unset ($_SESSION['gv_id']);
			xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART, 'info_message=' . urlencode(REDEEMED_AMOUNT . $xtPrice->xtcFormat($coupon['coupon_amount'], true, 0, true)), 'SSL'));

		}	
	}
}


//////////////////////////////////////////////////////////////////////////////////////////////
// ARTIKELPREIS-BERECHNUNG
//////////////////////////////////////////////////////////////////////////////////////////////
function get_products_price($t_prid, $products_id) {
	global $xtPrice;
	$products_price = array();

	// STEUERKLASSE DES ARTIKELS ERMITTELN
	$product_query = xtc_db_query("select products_tax_class_id from " . TABLE_PRODUCTS . " where products_id='" . $t_prid . "' limit 1");
	$product = xtc_db_fetch_array($product_query);
	// FALLS VORHANDEN, ATTRIBUT-PREIS ERMITTELN
	$attributes_price = 0.00;
	if (isset ($_SESSION['cart']->contents[$products_id]['attributes'])) {
		while (list ($option, $value) = each($_SESSION['cart']->contents[$products_id]['attributes'])) {
			$values = $xtPrice->xtcGetOptionPrice($products_id, $option, $value);
			$attributes_price = $values['price'];
		}
	}

	// 0 = ARTIKELPREIS INKLUSIVE STEUER, 1 = ARTIKELPREIS OHNE STEUER
	$products_price[0] = $xtPrice->xtcGetPrice($products_id, $format = false, 1, $product['products_tax_class_id'], '', 1) + $attributes_price;
	$products_tax_rate = xtc_get_tax_rate($product['products_tax_class_id'], $_SESSION['customer_country_id'], $_SESSION['customer_zone_id']);
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		$products_price[0] = $products_price[0] * ($products_tax_rate / 100 +1);
	}
	
	$products_price[1] = $products_price[0] / ($products_tax_rate + 100) * 100;	
	
	return $products_price;
}


//////////////////////////////////////////////////////////////////////////////////////////////
// RABATT BERECHNEN UND ANZEIGEN
//////////////////////////////////////////////////////////////////////////////////////////////
function calculate_deduction() {
	global $order, $xtPrice;
	$teq = 0;
	$order_total_brutto = 0.00;
	$order_total_netto = 0.00;

	// KONFIGURATION AUSLESEN
	$calculate_tax = MODULE_ORDER_TOTAL_COUPON_CALC_TAX == 'true' ? true : false;

	// INFOS ĂśBER KUPON AUSLESEN
	$coupon_query = xtc_db_query("select restrict_to_categories, restrict_to_products, coupon_type, coupon_amount, coupon_minimum_order from " . TABLE_COUPONS . " where coupon_id = '" . (int) $_SESSION['cc_id'] . "' limit 1");
	$coupon = xtc_db_fetch_array($coupon_query);

	// SCHLEIFE FĂśR ALLE PRODUKTE IM KORB
	$products = $_SESSION['cart']->get_products();			
	for ($i = 0; $i < sizeof($products); $i ++) {
	
		// GRUNDFORM DER ARTIKELNUMMER
		$t_prid = xtc_get_prid($products[$i]['id']);

		// KUPONS OHNE BESCHRĂ„NKUNGEN : RABATT-SUMME ANHAND ALLER ARTIKEL IM KORB BERECHNEN
		if ($coupon['restrict_to_categories'] == '' && $coupon['restrict_to_products'] == '') {
			$products_price = get_products_price($t_prid, $products[$i]['id']);
			$order_total_brutto += $_SESSION['cart']->contents[$products[$i]['id']]['qty'] * $products_price[0];
			$order_total_netto += $_SESSION['cart']->contents[$products[$i]['id']]['qty'] * $products_price[1];					

		// BESCHRĂ„NKUNG AUF KATEGORIEN : RABATT-SUMME ANHAND GĂśLTIGER ARTIKEL BERECHNEN
		} else if ($coupon['restrict_to_categories'] != '') {
			$product_found = false;
			$cat_ids = split("[,]", $coupon['restrict_to_categories']);		
			// SCHLEIFE FĂśR ALLE GĂśLTIGEN KATEGORIEN
			for ($ii = 0; $ii < count($cat_ids); $ii ++) {
				// IN DER AKTUELLEN KATEGORIE NACH UNTERKATEGORIEN SUCHEN
				$subcat_ids = array ();
				require_once (DIR_FS_INC . 'xtc_get_subcategories.inc.php');
				xtc_get_subcategories($subcat_ids, $cat_ids[$ii]);	
				// WENN UNTERKATEGORIEN VORHANDEN SIND, AUCH DIESE DURCHSUCHEN
				if (sizeof($subcat_ids) > 0) {
					for ($iii = 0; $iii < sizeof($subcat_ids); $iii ++) {
						$cat_query = xtc_db_query("select products_id from products_to_categories where products_id = '" . $t_prid . "' and (categories_id = '" . $cat_ids[$ii] . "' or categories_id = '" . $subcat_ids[$iii] . "')");
						// WENN DER ARTIKEL AUS DEM KORB IN EINER DER GĂśLTIGEN KATEGORIEN STEHT, DANN ARTIKELPREIS AUF DIE RABATT-SUMME ADDIEREN
						if (xtc_db_num_rows($cat_query) != 0 && $product_found == false){
							$products_price = get_products_price($t_prid, $products[$i]['id']);
							$order_total_brutto += $_SESSION['cart']->contents[$products[$i]['id']]['qty'] * $products_price[0];
							$order_total_netto += $_SESSION['cart']->contents[$products[$i]['id']]['qty'] * $products_price[1];
							$teq++;
							$product_found = true;
						}
					}	
				// KEINE UNTERKATEGORIEN VORHANDEN, DANN NUR HAUPTKATEGORIE DURCHSUCHEN
				} else {
					$cat_query = xtc_db_query("select products_id from products_to_categories where products_id = '" . $t_prid . "' and categories_id = '" . $cat_ids[$ii] . "'");
					// WENN DER ARTIKEL AUS DEM KORB IN EINER DER GĂśLTIGEN KATEGORIEN STEHT, DANN ARTIKELPREIS AUF DIE RABATT-SUMME ADDIEREN
					if (xtc_db_num_rows($cat_query) != 0 && $product_found == false){
						$products_price = get_products_price($t_prid, $products[$i]['id']);
						$order_total_brutto += $_SESSION['cart']->contents[$products[$i]['id']]['qty'] * $products_price[0];
						$order_total_netto += $_SESSION['cart']->contents[$products[$i]['id']]['qty'] * $products_price[1];
						$teq++;
						$product_found = true;
					}
				}
			}
			
		// BESCHRĂ„NKUNG AUF PRODUKTE : RABATT-SUMME ANHAND GĂśLTIGER ARTIKEL BERECHNEN
		} else if ($coupon['restrict_to_products'] != '') {
			$pr_ids = split("[,]", $coupon['restrict_to_products']);
			// SCHLEIFE FĂśR ALLE GĂśLTIGEN PRODUKTE
			for ($ii = 0; $ii < count($pr_ids); $ii ++) {
				// WENN DER ARTIKEL AUS DEM KORB IN DER LISTE DER GĂśLTIGEN ARTIKEL STEHT, DANN ARTIKELPREIS AUF DIE RABATT-SUMME ADDIEREN
				if ($t_prid == $pr_ids[$ii]){	
					$products_price = get_products_price($t_prid, $products[$i]['id']);
					$order_total_brutto += $_SESSION['cart']->contents[$products[$i]['id']]['qty'] * $products_price[0];
					$order_total_netto += $_SESSION['cart']->contents[$products[$i]['id']]['qty'] * $products_price[1];
					$teq++;
				}	
			}
		}
	}

	// RABATT BERECHNEN
	if ($coupon['coupon_type'] == 'P'){
		$od_amount_brutto = $order_total_brutto * $coupon['coupon_amount'] / 100; 
		$od_amount_netto = $order_total_netto * $coupon['coupon_amount'] / 100; 
	} else if ($coupon['coupon_type'] == 'F'){
		if ($coupon['coupon_amount'] > $order_total_brutto) {
			$od_amount_brutto = $order_total_brutto;
		} else {
			$od_amount_brutto = $coupon['coupon_amount'];
		}
		if ($coupon['coupon_amount'] > $order_total_netto) {
			$od_amount_netto = $order_total_netto;
		} else {
			$od_amount_netto = $coupon['coupon_amount'];
		}
	}
	
	// ERMITTELTE DATEN ZUSAMMENSETZEN
	$coupon_deduction = array();

	// SETZE PRODUKT- ODER KATEGORIE-BESCHRĂ„NKUNG, WENN KEIN EINZIGER PASSENDER ARTIKEL GEFUNDEN WURDE
	$coupon_deduction[0] = '0';
	if ($teq <= 0 && ($coupon['restrict_to_categories'] != '' || $coupon['restrict_to_products'] != '')) {
		$coupon_deduction[0] = '1';		
	}

	// BERĂśCKSICHTIGUNG DER MINDESTBESTELLMENGE
	if ($order_total_brutto < number_format($coupon['coupon_minimum_order'], 2)) {
		$coupon_deduction[0] = '1';	
	}	
	
	// RABATT AUF DIE BESTELLSUMME
	$coupon_deduction[1] = $od_amount_brutto;
	$coupon_deduction[2] = $od_amount_brutto;
	if ($calculate_tax == 'true' && $_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		$coupon_deduction[1] = $od_amount_netto;					
	}
	// AUSGABE DER ERMITTELTEN DATEN
	return $coupon_deduction;
}
?>