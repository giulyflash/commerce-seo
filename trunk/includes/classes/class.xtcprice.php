<?php

/* -----------------------------------------------------------------
 * 	ID:						$Id: class.xtcprice.php 461 2013-07-08 20:30:32Z akausch $
 * 	Letzter Stand:			$Revision: 360 $
 * 	zuletzt geändert von: 	$Author: akausch $
 * 	Datum:					$Date: 2013-06-05 15:01:19 +0200 (Mi, 05 Jun 2013) $
 *
 * 	commerce:SEO by Webdesign Erfurt
 * 	http://www.commerce-seo.de
 *
 * 	Copyright (c) since 2010 commerce:SEO
 * ------------------------------------------------------------------
 * 	based on:
 * 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 * 	(c) 2002-2003 osCommerce - www.oscommerce.com
 * 	(c) 2003     nextcommerce - www.nextcommerce.org
 * 	(c) 2005     xt:Commerce - www.xt-commerce.com
 *
 * 	Released under the GNU General Public License
 * --------------------------------------------------------------- */

class xtcPrice {

    var $currencies;

    function xtcPrice($currency, $cGroup) {

        $this->currencies = array();
        $this->cStatus = array();
        $this->actualGroup = (int) $cGroup;
        $this->actualCurr = $currency;
        $this->TAX = array();
        $this->SHIPPING = array();
        $this->showFrom_Attributes = true;

        if (!defined('HTTP_CATALOG_SERVER') && isset($_SESSION['cart'])) {
            $this->content_type = $_SESSION['cart']->get_content_type();
        }

        // select Currencies
        $currencies_query = xtDBquery("SELECT * FROM " . TABLE_CURRENCIES);

        while ($currencies = xtc_db_fetch_array($currencies_query, true)) {
            $this->currencies[$currencies['code']] = array('title' => $currencies['title'],
                'symbol_left' => $currencies['symbol_left'],
                'symbol_right' => $currencies['symbol_right'],
                'decimal_point' => $currencies['decimal_point'],
                'thousands_point' => $currencies['thousands_point'],
                'decimal_places' => $currencies['decimal_places'],
                'value' => $currencies['value']);
        }

        if (!isset($this->currencies[$this->actualCurr])) {
            $this->actualCurr = DEFAULT_CURRENCY;
        }

        // select Customers Status data
        $customers_status_query = xtDBquery("SELECT * FROM " . TABLE_CUSTOMERS_STATUS . " WHERE customers_status_id = '" . $this->actualGroup . "' AND language_id = '" . $_SESSION['languages_id'] . "'");
        $customers_status_value = xtc_db_fetch_array($customers_status_query, true);
        $this->cStatus = array('customers_status_id' => $this->actualGroup,
            'customers_status_name' => $customers_status_value['customers_status_name'],
            'customers_status_image' => $customers_status_value['customers_status_image'],
            'customers_status_public' => $customers_status_value['customers_status_public'],
            'customers_status_discount' => $customers_status_value['customers_status_discount'],
            'customers_status_ot_discount_flag' => $customers_status_value['customers_status_ot_discount_flag'],
            'customers_status_ot_discount' => $customers_status_value['customers_status_ot_discount'],
            'customers_status_graduated_prices' => $customers_status_value['customers_status_graduated_prices'],
            'customers_status_show_price' => $customers_status_value['customers_status_show_price'],
            'customers_status_show_price_tax' => $customers_status_value['customers_status_show_price_tax'],
            'customers_status_add_tax_ot' => $customers_status_value['customers_status_add_tax_ot'],
            'customers_status_payment_unallowed' => $customers_status_value['customers_status_payment_unallowed'],
            'customers_status_shipping_unallowed' => $customers_status_value['customers_status_shipping_unallowed'],
            'customers_status_discount_attributes' => $customers_status_value['customers_status_discount_attributes'],
            'customers_fsk18' => $customers_status_value['customers_fsk18'],
            'customers_fsk18_display' => $customers_status_value['customers_fsk18_display']);

        // prefetch tax rates for standard zone
        $zones_query = xtDBquery("SELECT tax_class_id as class FROM " . TABLE_TAX_CLASS);
        while ($zones_data = xtc_db_fetch_array($zones_query, true)) {

            // calculate tax based on shipping or deliverey country (for downloads)
            if (isset($_SESSION['billto']) && isset($_SESSION['sendto'])) {
                $tax_address_query = xtDBquery("SELECT ab.entry_country_id,
														ab.entry_zone_id FROM " . TABLE_ADDRESS_BOOK . " ab
														LEFT JOIN " . TABLE_ZONES . " z ON (ab.entry_zone_id = z.zone_id)
														WHERE ab.customers_id = '" . $_SESSION['customer_id'] . "'
														AND ab.address_book_id = '" . ($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . "'");
                $tax_address = xtc_db_fetch_array($tax_address_query);
                $this->TAX[$zones_data['class']] = xtc_get_tax_rate($zones_data['class'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']);
            } else {
                // $this->TAX[$zones_data['class']] = xtc_get_tax_rate($zones_data['class']);
                // Versandkosten im Warenkorb
                $country_id = -1;
                if (isset($_SESSION['country']) && !isset($_SESSION['customer_id'])) {
                    $country_id = $_SESSION['country'];
                }
                if (isset($_SESSION['AMZ_COUNTRY_ID']) && isset($_SESSION['AMZ_ZONE_ID'])) {
                    $tax_address = array('entry_country_id' => $_SESSION['AMZ_COUNTRY_ID'], 'entry_zone_id' => $_SESSION['AMZ_ZONE_ID']);
                    $this->TAX[$zones_data['class']] = xtc_get_tax_rate($zones_data['class'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']);
                } else {
                    $this->TAX[$zones_data['class']] = xtc_get_tax_rate($zones_data['class'], $country_id);
                    //
                }
            }
        }
    }

    // Produktpreis ermitteln
    function xtcGetPrice($pID, $format = true, $qty, $tax_class, $pPrice, $vpeStatus = 0, $cedit_id = 0, $price_type = '') {

        // Darf Kunde Preise sehen?
        if ($this->cStatus['customers_status_show_price'] == '0')
            return $this->xtcShowNote($vpeStatus, $vpeStatus);

        // Steuern ermitteln
        if ($cedit_id != 0) {
            require_once (DIR_FS_INC . 'xtc_oe_customer_infos.inc.php');
            $cinfo = xtc_oe_customer_infos($cedit_id);
            $products_tax = xtc_get_tax_rate($tax_class, $cinfo['country_id'], $cinfo['zone_id']);
        }
        else
            $products_tax = $this->TAX[$tax_class];

        if ($this->cStatus['customers_status_show_price_tax'] == '0')
            $products_tax = '';

        // Steuern hinzufügen
        if ($pPrice == 0)
            $pPrice = $this->getPprice($pID);
        $pPrice = $this->xtcAddTax($pPrice, $products_tax);

        // Sonderangebot?
        if ($sPrice = $this->xtcCheckSpecial($pID))
            return $this->xtcFormatSpecial($pID, $this->xtcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, $price_type);

        // check graduated
        if ($this->cStatus['customers_status_graduated_prices'] == '1') {
            // Gruppenpreis ermitteln
            if ($sPrice = $this->xtcGetGraduatedPrice($pID, $qty))
                return $this->xtcFormatSpecialGraduated($pID, $this->xtcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, $pID, $price_type);
        } else {
            // check Group Price
            if ($sPrice = $this->xtcGetGroupPrice($pID, 1))
                return $this->xtcFormatSpecialGraduated($pID, $this->xtcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, $pID, $price_type);
        }

        // check Product Discount
        if ($discount = $this->xtcCheckDiscount($pID))
            return $this->xtcFormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus);

        return $this->xtcFormat($pPrice, $format, 0, false, $vpeStatus, $pID, $price_type);
    }

    function getPprice($pID) {
        $pQuery = "SELECT products_price FROM " . TABLE_PRODUCTS . " WHERE products_id='" . $pID . "'";
        $pQuery = xtDBquery($pQuery);
        $pData = xtc_db_fetch_array($pQuery, true);
        return $pData['products_price'];
    }

    function xtcAddTax($price, $tax) {
        $price = $price + $price / 100 * $tax;
        $price = $this->xtcCalculateCurr($price);
        return round($price, $this->currencies[$this->actualCurr]['decimal_places']);
    }

    function xtcCheckDiscount($pID) {
        if ($this->cStatus['customers_status_discount'] != '0.00') {
            $discount_query = "SELECT products_discount_allowed FROM " . TABLE_PRODUCTS . " WHERE products_id = '" . $pID . "'";
            $discount_query = xtDBquery($discount_query);
            $dData = xtc_db_fetch_array($discount_query, true);

            $discount = $dData['products_discount_allowed'];
            if ($this->cStatus['customers_status_discount'] < $discount)
                $discount = $this->cStatus['customers_status_discount'];
            if ($discount == '0.00')
                return false;
            return $discount;
        }
        return false;
    }

    function xtcGetGraduatedPrice($pID, $qty) {
        if (GRADUATED_ASSIGN == 'true') {
            if (xtc_get_qty($pID) > $qty) {
                $qty = xtc_get_qty($pID);
            }
        }
        if ($_SESSION['customers_status']['customers_status_id'] == '0') {
            $this->actualGroup = '1';
        }

        $graduated_price_query = "SELECT max(quantity) as qty
				                                FROM " . TABLE_PERSONAL_OFFERS_BY . $this->actualGroup . "
				                                WHERE products_id='" . $pID . "'
												AND personal_offer > 0
				                                AND quantity<='" . $qty . "'";
        $graduated_price_query = xtDBquery($graduated_price_query);
        $graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);
        if ($graduated_price_data['qty']) {
            $graduated_price_query = "SELECT personal_offer
						                                FROM " . TABLE_PERSONAL_OFFERS_BY . $this->actualGroup . "
						                                WHERE products_id='" . $pID . "'
														AND personal_offer > 0
						                                AND quantity='" . $graduated_price_data['qty'] . "'";
            $graduated_price_query = xtDBquery($graduated_price_query);
            $graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);

            $sPrice = $graduated_price_data['personal_offer'];
            if ($sPrice != 0.00)
                return $sPrice;
        } else {
            return;
        }
    }

    function xtcGetGroupPrice($pID, $qty) {
        if ($_SESSION['customers_status']['customers_status_id'] == '0') {
            $this->actualGroup = '1';
        }
        $graduated_price_query = "SELECT max(quantity) as qty
				                                FROM " . TABLE_PERSONAL_OFFERS_BY . $this->actualGroup . "
				                                WHERE products_id='" . $pID . "'
												AND personal_offer > 0
				                                AND quantity<='" . $qty . "'";
        $graduated_price_query = xtDBquery($graduated_price_query);
        $graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);
        if ($graduated_price_data['qty']) {
            $graduated_price_query = "SELECT personal_offer
						                                FROM " . TABLE_PERSONAL_OFFERS_BY . $this->actualGroup . "
						                                WHERE products_id='" . $pID . "'
														AND personal_offer > 0
						                                AND quantity='" . $graduated_price_data['qty'] . "'";
            $graduated_price_query = xtDBquery($graduated_price_query);
            $graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);

            $sPrice = $graduated_price_data['personal_offer'];
            if ($sPrice != 0.00)
                return $sPrice;
        } else {
            return;
        }
    }

	function xtcGetOptionPrice($pID, $option, $value, $products_price) {
		$attribute_price_query = xtDBquery("select pd.products_discount_allowed,pd.products_tax_class_id, p.options_values_price, p.price_prefix, p.options_values_weight, p.weight_prefix from ".TABLE_PRODUCTS_ATTRIBUTES." p, ".TABLE_PRODUCTS." pd where p.products_id = '".(int)$pID."' and p.options_id = '".(int)$option."' and pd.products_id = p.products_id and p.options_values_id = '".(int)$value."'");
		$attribute_price_data = xtc_db_fetch_array($attribute_price_query, true);
		$discount = 0; 
		if ($this->cStatus['customers_status_discount_attributes'] == 1 && $this->cStatus['customers_status_discount'] != 0.00) {
			$discount = $this->cStatus['customers_status_discount'];
			if ($attribute_price_data['products_discount_allowed'] < $this->cStatus['customers_status_discount'])
				$discount = $attribute_price_data['products_discount_allowed'];
		}
		if($attribute_price_data['products_tax_class_id'] != 0) {
			$price = $this->xtcFormat($attribute_price_data['options_values_price'], false, $attribute_price_data['products_tax_class_id']);
		} else {
			$price = $this->xtcFormat($attribute_price_data['options_values_price'], false, $attribute_price_data['products_tax_class_id'], true);
		}

		if ($attribute_price_data['weight_prefix'] != '+') {
			$attribute_price_data['options_values_weight'] *= -1;
		}
		if ($attribute_price_data['price_prefix'] == '+') {
			$price = $price - $price / 100 * $discount;
		} elseif ($attribute_price_data['price_prefix'] == '=') {
			$price = ($price - $price / 100 * $discount) - $products_price;
		} else {
			$price = ($price - $price / 100 * $discount) * -1;
		}

		return array ('weight' => $attribute_price_data['options_values_weight'], 'price' => $price);
	}

    function xtcShowNote($vpeStatus, $vpeStatus = 0) {
        if ($vpeStatus == 1)
            return array('formated' => NOT_ALLOWED_TO_SEE_PRICES, 'plain' => 0);
        return NOT_ALLOWED_TO_SEE_PRICES;
    }

    function xtcCheckSpecial($pID) {
        $product = xtc_db_fetch_array(xtDBquery("SELECT specials_new_products_price FROM " . TABLE_SPECIALS . " WHERE products_id = '" . $pID . "' AND status = '1';"));
        return $product['specials_new_products_price'];
    }
	
    function checkSQTY($pID) {
        $product = xtc_db_fetch_array(xtDBquery("SELECT specials_quantity FROM " . TABLE_SPECIALS . " WHERE products_id = '" . $pID . "' AND status = '1';"));
		return $product['specials_quantity'];
    }

    function xtcCalculateCurr($price) {
        return $this->currencies[$this->actualCurr]['value'] * $price;
    }

    function calcTax($price, $tax) {
        return $price * $tax / 100;
    }

    function xtcRemoveCurr($price) {
        if (DEFAULT_CURRENCY != $this->actualCurr) {
            return $price * (1 / $this->currencies[$this->actualCurr]['value']);
        } else {
            return $price;
        }
    }

    function xtcRemoveTax($price, $tax) {
        $price = ($price / (($tax + 100) / 100));
        return $price;
    }

    function xtcGetTax($price, $tax) {
        $tax = $price - $this->xtcRemoveTax($price, $tax);
        return $tax;
    }

    function xtcRemoveDC($price, $dc) {
        $price = $price - ($price / 100 * $dc);
        return $price;
    }

    function xtcGetDC($price, $dc) {
        $dc = $price / 100 * $dc;
        return $dc;
    }

    function checkAttributes($pID) {
        if (!$this->showFrom_Attributes)
            return;
        if ($pID == 0)
            return;
        $products_attributes_query = "SELECT count(*) AS total, sum(patrib.options_values_price) AS summe FROM " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib WHERE patrib.products_id='" . $pID . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int) $_SESSION['languages_id'] . "'";
        $products_attributes = xtDBquery($products_attributes_query);
        $products_attributes = xtc_db_fetch_array($products_attributes, true);
        if (($products_attributes['total'] > 0) && ($products_attributes['summe'] > 0))
            return ' ' . strtolower(FROM) . ' ';
    }

    function xtcCalculateCurrEx($price, $curr) {
        return $price * ($this->currencies[$curr]['value'] / $this->currencies[$this->actualCurr]['value']);
    }

    /**
      Format Functions
     * */
    function xtcFormat($price, $format, $tax_class = 0, $curr = false, $vpeStatus = 0, $pID = 0, $price_type = '', $attr) {
        if ($curr)
            $price = $this->xtcCalculateCurr($price);

        if ($tax_class != 0) {
            $products_tax = $this->TAX[$tax_class];
            if ($this->cStatus['customers_status_show_price_tax'] == '0')
                $products_tax = '';
            $price = $this->xtcAddTax($price, $products_tax);
        }

        if ($format) {
            $Pprice = number_format((double) $price, $this->currencies[$this->actualCurr]['decimal_places'], $this->currencies[$this->actualCurr]['decimal_point'], $this->currencies[$this->actualCurr]['thousands_point']);
            $Pprice = $this->checkAttributes($pID) . $this->currencies[$this->actualCurr]['symbol_left'] . ' ' . $Pprice . ' ' . $this->currencies[$this->actualCurr]['symbol_right'];
            if ($vpeStatus == 0)
                return $Pprice;
            else {
                return array('formated' => '<div itemprop="offers" itemscope itemtype="http://schema.org/Offer"><span itemprop="price">'.trim($Pprice).'</span></div>', 'plain' => $price, 'cur_sm_right' => $this->currencies[$this->actualCurr]['symbol_right']);
            }
        }
        else
            return round($price, $this->currencies[$this->actualCurr]['decimal_places']);
    }

    function xtcFormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus = 0) {
        $sPrice = $pPrice - ($pPrice / 100) * $discount;
        if ($format) {
            $price = '<div itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer">
				<meta itemprop="highPrice" content="'.trim($this->xtcFormat($pPrice, $format)).'">
				<meta itemprop="lowPrice" content="'.trim($this->checkAttributes($pID) . $this->xtcFormat($sPrice, $format)).'">
				<span class="product_info_old">
					' . INSTEAD . '
					' . $this->xtcFormat($pPrice, $format) . '
				</span><br>
				<span class="product_info_real_price">
					' . $this->checkAttributes($pID) . $this->xtcFormat($sPrice, $format) . '
				</span>
				</div>
				<span class="product_price_save">';
            if ($discount != 0) {
                $price .= BOX_LOGINBOX_DISCOUNT . ': ' . round($discount) . '%';
            }
            $price .= '</span>';
            if ($vpeStatus == 0) {
                return $price;
            } else {
                return array('formated' => $price, 'plain' => $sPrice);
            }
        } else {
            return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
        }
    }

    function xtcFormatSpecial($pID, $sPrice, $pPrice, $format, $vpeStatus = 0, $price_type) {
        if ($format) {
            $price = '<div itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer">
						<meta itemprop="highPrice" content="'.trim($this->xtcFormat($pPrice, $format)).'">
						<meta itemprop="lowPrice" content="'.trim($this->checkAttributes($pID) . $this->xtcFormat($sPrice, $format)).'">
						<meta itemprop="offerCount" content="'.$this->checkSQTY($pID).'">
						<span class="product_info_old">' . INSTEAD . '' . $this->xtcFormat($pPrice, $format) . '</span>
						<br>
						<span class="product_info_real_price">' . $this->checkAttributes($pID) . $this->xtcFormat($sPrice, $format) . '</span>
						
					</div>
						';

            if ($vpeStatus == 0) {
                return $price;
            } else {
                return array('formated' => $price, 'plain' => $sPrice);
            }
        } else {
            return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
        }
    }

    function xtcFormatSpecialGraduated($pID, $sPrice, $pPrice, $format, $vpeStatus = 0, $pID, $price_type) {
        $tQuery = "SELECT products_tax_class_id	FROM " . TABLE_PRODUCTS . " WHERE products_id='" . $pID . "'";
        $tQuery = xtDBquery($tQuery);
        $tQuery = xtc_db_fetch_array($tQuery);
        $tax_class = $tQuery[products_tax_class_id];

        if ($pPrice == 0)
            return $this->xtcFormat($sPrice, $format, 0, false, $vpeStatus, $price_type);

        if ($discount = $this->xtcCheckDiscount($pID))
            $sPrice -= $sPrice / 100 * $discount;

        if ($format) {
            if ($this->actualGroup == '0')
                $gruppe = '1';
            else
                $gruppe = $this->actualGroup;

            $pPriceRaw = $pPrice;
            $sPriceRaw = $sPrice;
            $sPrice = number_format($sPrice, $this->currencies[$this->actualCurr]['decimal_places'], $this->currencies[$this->actualCurr]['decimal_point'], $this->currencies[$this->actualCurr]['thousands_point']);
            $pPrice = number_format($pPrice, $this->currencies[$this->actualCurr]['decimal_places'], $this->currencies[$this->actualCurr]['decimal_point'], $this->currencies[$this->actualCurr]['thousands_point']);


            $sQuery = "SELECT max(quantity) as qty FROM " . TABLE_PERSONAL_OFFERS_BY . $gruppe . " WHERE products_id='" . $pID . "'";
            $sQuery = xtDBquery($sQuery);
            $sQuery = xtc_db_fetch_array($sQuery, true);
            if (($this->cStatus['customers_status_graduated_prices'] == '1') && ($sQuery[qty] > 1)) {
                $bestPrice = $this->xtcGetGraduatedPrice($pID, $sQuery[qty]);
                if ($discount)
                    $bestPrice -= $bestPrice / 100 * $discount;
                $price .= FROM . $this->xtcFormat($bestPrice, $format, $tax_class) . ' <br><span class="single_price">' . SINGLE_PRICE . $this->xtcFormat($pPriceRaw, $format) . '</span>';
            } else if ($sPriceRaw != $pPriceRaw)
                $price = '<span class="productOldPrice">' . MSRP . ' ' . $this->xtcFormat($pPriceRaw, $format) . '</span><br>' . YOUR_PRICE . $this->checkAttributes($pID) . $this->xtcFormat($sPriceRaw, $format);
            elseif (($sQuery['qty'] == 1))
                $price = $this->xtcFormat($sPriceRaw, $format);
            else
                $price = FROM . $this->xtcFormat($sPriceRaw, $format);
            if ($vpeStatus == 0)
                return $price;
            else
                return array('formated' => $price, 'plain' => $sPrice);
        }
        else
            return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
    }

    function get_decimal_places($code) {
        return $this->currencies[$this->actualCurr]['decimal_places'];
    }

}

