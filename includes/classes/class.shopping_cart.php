<?php
/*-----------------------------------------------------------------
* 	$Id: class.shopping_cart.php 398 2013-06-17 23:08:26Z akausch $
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

// include needed functions
require_once (DIR_FS_INC.'xtc_create_random_value.inc.php');
require_once (DIR_FS_INC.'xtc_get_prid.inc.php');
require_once (DIR_FS_INC.'xtc_image_submit.inc.php');
require_once (DIR_FS_INC.'xtc_get_tax_description.inc.php');

class shoppingCart {
	var $contents, $total, $weight, $cartID, $content_type;
	
	
	function shoppingCart() {
		$this->reset();
	}

	function restore_contents() {

		if (!isset($_SESSION['customer_id']))
			return false;

		// insert current cart contents in database
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				$qty = $this->contents[$products_id]['qty'];
				$product_query = xtc_db_query("select products_id from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$products_id."'");
				if (!xtc_db_num_rows($product_query)) {
					xtc_db_query("insert into ".TABLE_CUSTOMERS_BASKET." (customers_id, products_id, customers_basket_quantity, customers_basket_date_added) values ('".$_SESSION['customer_id']."', '".$products_id."', '".$qty."', '".date('Ymd')."')");
					if (isset ($this->contents[$products_id]['attributes'])) {
						reset($this->contents[$products_id]['attributes']);
						while (list ($option, $value) = each($this->contents[$products_id]['attributes'])) {
							xtc_db_query("insert into ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." (customers_id, products_id, products_options_id, products_options_value_id) values ('".$_SESSION['customer_id']."', '".$products_id."', '".$option."', '".$value."')");
						}
					}
				} else {
					xtc_db_query("update ".TABLE_CUSTOMERS_BASKET." set customers_basket_quantity = '".$qty."' where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$products_id."'");
				}
			}
		}

		// reset per-session cart contents, but not the database contents
		$this->reset(false);
		//inaktive Produkte aus dem WK entfernen
		$products_status_query_base = xtc_db_query("select products_id, customers_basket_quantity from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."'");
		while ($products_base = xtc_db_fetch_array($products_status_query_base)) {		
			$products_status_query = xtc_db_fetch_array(xtc_db_query("select products_id, products_status from ".TABLE_PRODUCTS." where products_id = '".$products_base['products_id']."'"));
			if ($products_status_query['products_status'] == '0') {
				xtc_db_query("delete from ".TABLE_CUSTOMERS_BASKET." where products_id = '".$products_base['products_id']."' AND customers_id = '".$_SESSION['customer_id']."'");
				xtc_db_query("delete from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where products_id = '".$products_base['products_id']."' AND customers_id = '".$_SESSION['customer_id']."'");
			}
		}
		
		$products_query = xtc_db_query("select products_id, customers_basket_quantity from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."'");
		while ($products = xtc_db_fetch_array($products_query)) {
			$this->contents[$products['products_id']] = array ('qty' => $products['customers_basket_quantity']);
			// attributes
			$attributes_query = xtc_db_query("select products_options_id, products_options_value_id from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$products['products_id']."'");
			while ($attributes = xtc_db_fetch_array($attributes_query)) {
				$this->contents[$products['products_id']]['attributes'][$attributes['products_options_id']] = $attributes['products_options_value_id'];
			}
		}

		$this->cleanup();
	}

	function reset($reset_database = false) {

		$this->contents = array ();
		$this->total = 0;
		$this->tax = 0;
		$this->weight = 0;
		$this->content_type = false;

		if (isset ($_SESSION['customer_id']) && ($reset_database == true)) {
			xtc_db_query("delete from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."'");
			xtc_db_query("delete from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where customers_id = '".$_SESSION['customer_id']."'");
		}

		unset ($this->cartID);
		if (isset ($_SESSION['cartID']))
			unset ($_SESSION['cartID']);
	}

	function add_cart($products_id, $qty = '1', $attributes = '', $notify = true) {
		global $new_products_id_in_cart;

		$products_id = xtc_get_uprid($products_id, $attributes);
		if ($notify == true) {
			$_SESSION['new_products_id_in_cart'] = $products_id;
		}

		if ($this->in_cart($products_id)) {
			$this->update_quantity($products_id, $qty, $attributes);
		} else {
			$this->contents[] = array($products_id);
			$this->contents[$products_id] = array('qty' => $qty);
			// insert into database
			if (isset($_SESSION['customer_id']))
				xtc_db_query("insert into ".TABLE_CUSTOMERS_BASKET." (customers_id, products_id, customers_basket_quantity, customers_basket_date_added) values ('".$_SESSION['customer_id']."', '".$products_id."', '".$qty."', '".date('Ymd')."')");

			if(is_array($attributes)) {
				reset($attributes);
				while (list ($option, $value) = each($attributes)) {
					$this->contents[$products_id]['attributes'][$option] = $value;
					// insert into database
					if (isset ($_SESSION['customer_id']))
						xtc_db_query("insert into ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." (customers_id, products_id, products_options_id, products_options_value_id) values ('".$_SESSION['customer_id']."', '".$products_id."', '".$option."', '".$value."')");
				}
			}
		}
		$this->cleanup();

		// assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
		$this->cartID = $this->generate_cart_id();
	}

	function update_quantity($products_id, $quantity = '', $attributes = '') {
		if (empty ($quantity))
			return true; // nothing needs to be updated if theres no quantity, so we return true..
			
		$this->contents[$products_id] = array ('qty' => $quantity);
		// update database
		if (isset ($_SESSION['customer_id'])) {
			xtc_db_query("update ".TABLE_CUSTOMERS_BASKET." set customers_basket_quantity = '".$quantity."' where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$products_id."'");
		}

		if (is_array($attributes)) {
			reset($attributes);
			while (list ($option, $value) = each($attributes)) {
				$this->contents[$products_id]['attributes'][$option] = $value;
				// update database
				if (isset ($_SESSION['customer_id']))
					xtc_db_query("update ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." set products_options_value_id = '".$value."' where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$products_id."' and products_options_id = '".$option."'");
			}
		}
	}

	function cleanup() {

		reset($this->contents);
		while (list ($key,) = each($this->contents)) {
			if ($this->contents[$key]['qty'] < 1) {
				unset ($this->contents[$key]);
				// remove from database
				if (isset($_SESSION['customer_id'])) {
					xtc_db_query("DELETE FROM ".TABLE_CUSTOMERS_BASKET." WHERE customers_id = '".(int)$_SESSION['customer_id']."' AND products_id = '".$key."'");
					xtc_db_query("DELETE FROM ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." WHERE customers_id = '".(int)$_SESSION['customer_id']."' AND products_id = '".$key."'");
				}
			}
		}
	}

	function count_contents() { // get total number of items in cart
		$total_items = 0;
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				$total_items += $this->get_quantity($products_id);
			}
		}

		return $total_items;
	}

	function get_quantity($products_id) {
		if (isset ($this->contents[$products_id])) {
			return $this->contents[$products_id]['qty'];
		} else {
			return 0;
		}
	}

	function in_cart($products_id) {
		if (isset ($this->contents[$products_id])) {
			return true;
		} else {
			return false;
		}
	}

	function remove($products_id) {

		$this->contents[$products_id]= NULL;
		// remove from database
		if (isset($_SESSION['customer_id'])) {
			xtc_db_query("DELETE FROM ".TABLE_CUSTOMERS_BASKET." WHERE customers_id = '".(int)$_SESSION['customer_id']."' AND products_id = '".$products_id."'");
			xtc_db_query("DELETE FROM ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." WHERE customers_id = '".(int)$_SESSION['customer_id']."' AND products_id = '".$products_id."'");
		}

		// assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
		$this->cartID = $this->generate_cart_id();
	}

	function remove_all() {
		$this->reset();
	}

	function get_product_id_list() {
		$product_id_list = '';
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				$product_id_list .= ', '.$products_id;
			}
		}

		return substr($product_id_list, 2);
	}

    function calculate() {
    	global $xtPrice;
	    $this->total = 0;
	    $this->weight = 0;
	    $this->tax = array ();
	    $this->total_discount = array ();
	    if (!is_array($this->contents))
	    	return 0;
	    reset($this->contents);
	    while (list ($products_id) = each($this->contents)) {
	      	$qty = $this->contents[$products_id]['qty'];
		      // products price
		      $product_query = xtc_db_query("SELECT products_id, 
												products_price, 
												products_discount_allowed, 
												products_tax_class_id, 
												products_weight 
												FROM ".TABLE_PRODUCTS." 
												WHERE products_id='".xtc_get_prid($products_id)."'");
		      if ($product = xtc_db_fetch_array($product_query)) {
		        $products_price = $xtPrice->xtcGetPrice($product['products_id'], $format = false, $qty, $product['products_tax_class_id'], $product['products_price']);
		        $this->total += $products_price * $qty;
		        $this->weight += ($qty * $product['products_weight']);
		        // attributes price
		        $attribute_price = 0;
		        if (isset ($this->contents[$products_id]['attributes'])) {
					reset($this->contents[$products_id]['attributes']);
					while (list ($option, $value) = each($this->contents[$products_id]['attributes'])) {
						$values = $xtPrice->xtcGetOptionPrice($product['products_id'], $option, $value, $products_price);
						$this->weight += $values['weight'] * $qty;
						$this->total += $values['price'] * $qty;
						$attribute_price += $values['price'];
					}
		    	}

				if ($product['products_tax_class_id'] != 0) {
					if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
						$products_price_tax = $products_price - ($products_price / 100 * $_SESSION['customers_status']['customers_status_ot_discount']);
						$attribute_price_tax = $attribute_price - ($attribute_price / 100 * $_SESSION['customers_status']['customers_status_ot_discount']);
					}
					$products_tax = $xtPrice->TAX[$product['products_tax_class_id']];
					$products_tax_description = xtc_get_tax_description($product['products_tax_class_id']);
					// price incl tax
					if ($_SESSION['customers_status']['customers_status_show_price_tax'] == '1') {
						if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
							$this->tax[$product['products_tax_class_id']]['value'] += ((($products_price_tax+$attribute_price_tax) / (100 + $products_tax)) * $products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = TAX_ADD_TAX.$products_tax_description;
						} else {
							$this->tax[$product['products_tax_class_id']]['value'] += ((($products_price+$attribute_price) / (100 + $products_tax)) * $products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = TAX_ADD_TAX.$products_tax_description;
						}
					}
					// excl tax + tax at checkout
					if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
						if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
							$this->tax[$product['products_tax_class_id']]['value'] += (($products_price_tax+$attribute_price_tax) / 100) * ($products_tax)*$qty;
							$this->total_discount[$product['products_tax_class_id']]+=(($products_price_tax+$attribute_price_tax) / 100) * ($products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = TAX_NO_TAX.$products_tax_description;
						} else {
							$this->tax[$product['products_tax_class_id']]['value'] += (($products_price+$attribute_price) / 100) * ($products_tax)*$qty;
							$this->total_discount[$product['products_tax_class_id']]+=(($products_price+$attribute_price) / 100) * ($products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = TAX_NO_TAX.$products_tax_description;
						}
					}
				}
			}
		}
		foreach ($this->total_discount as $value) {
	      $this->total+=round($value, $xtPrice->get_decimal_places($order->info['currency']));
	    }
	}

	function attributes_price($products_id, $products_price) {
		global $xtPrice;
		if (isset ($this->contents[$products_id]['attributes'])) {
			reset($this->contents[$products_id]['attributes']);
			while (list ($option, $value) = each($this->contents[$products_id]['attributes'])) {

				$values = $xtPrice->xtcGetOptionPrice($products_id, $option, $value, $products_price);
				$attributes_price += $values['price'];

			}
		}
		return $attributes_price;
	}

	function get_products() {
		global $xtPrice,$main;
		if (!is_array($this->contents))
			return false;
		$products_array = array ();
		reset($this->contents);
		while (list ($products_id,) = each($this->contents)) {
			if($this->contents[$products_id]['qty'] != 0 || $this->contents[$products_id]['qty'] !=''){
			$products_query = xtc_db_query("SELECT 
												p.products_id, 
												pd.products_name,
												p.products_shippingtime, 
												p.products_discount_allowed, 
												p.products_image, 
												p.products_model, 
												p.products_price,
												p.products_weight, 
												p.products_vpe_status,
												p.products_vpe,
												p.products_vpe_value,
												p.products_tax_class_id 
											FROM 
												".TABLE_PRODUCTS." p, 
												".TABLE_PRODUCTS_DESCRIPTION." pd 
											WHERE 
												p.products_id='".xtc_get_prid($products_id)."' 
											AND 
												pd.products_id = p.products_id 
											AND 
												pd.language_id = '".$_SESSION['languages_id']."'");
												
				if ($products = xtc_db_fetch_array($products_query)) {
					$prid = $products['products_id'];

					$products_price = $xtPrice->xtcGetPrice($products['products_id'], $format = false, $this->contents[$products_id]['qty'], $products['products_tax_class_id'], $products['products_price']);
					if($products['products_vpe_status'] == 1 && $products['products_vpe_value'] != 0.0 && $products_price > 0) {
						require_once (DIR_FS_INC.'xtc_get_vpe_name.inc.php');
						$vpe = $xtPrice->xtcFormat($products_price * (1 / $products['products_vpe_value']), true).TXT_PER.xtc_get_vpe_name($products['products_vpe']);
					} else {
						$vpe = '';
					}
					if (ACTIVATE_SHIPPING_STATUS == 'true') {
						$shipping_time_active = $main->getShippingStatusName($products['products_shippingtime']);
					}
					$products_array[] = array ('id' => $products_id, 
												'name' => $products['products_name'], 
												'shipping_time' => $shipping_time_active, 
												'products_discount_allowed' => $products['products_discount_allowed'], 
												'image' => $products['products_image'], 
												'model' => $products['products_model'], 
												'price' => ($products_price + $this->attributes_price($products_id, $products_price)), 
												'p_single_price' => ($products_price + $this->attributes_price($products_id, $products_price)), 
												'quantity' => $this->contents[$products_id]['qty'], 
												'weight' => $products['products_weight'],
												'vpe' => $vpe,
												'final_price' => ($products_price + $this->attributes_price($products_id, $products_price)), 
												'tax_class_id' => $products['products_tax_class_id'], 
												'attributes' => $this->contents[$products_id]['attributes']);
				}
			}
		}
		return $products_array;
	}

	function show_total() {
		$this->calculate();

		return $this->total;
	}

	function show_weight() {
		$this->calculate();

		return $this->weight;
	}

	function show_tax($format = true) {
		global $xtPrice;
		$this->calculate();
		$output = "";
		$val=0;
        $gval=0;

		foreach ($this->tax as $key => $value) {
			if ($this->tax[$key]['value'] > 0 ) {
				$output .= $this->tax[$key]['desc'].": ".$xtPrice->xtcFormat($this->tax[$key]['value'], true).'<br />';
            	$gval+=$this->tax[$key]['value'];
			}
		}
		if ($format) {
			return $output;
		} else {
			return $gval;

		}
	}

	function generate_cart_id($length = 5) {
		return xtc_create_random_value($length, 'digits');
	}

	function get_content_type() {
		$this->content_type = false;

		if ((DOWNLOAD_ENABLED == 'true') && ($this->count_contents() > 0)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				if (isset ($this->contents[$products_id]['attributes'])) {
					reset($this->contents[$products_id]['attributes']);
					while (list (, $value) = each($this->contents[$products_id]['attributes'])) {
						$virtual_check_query = xtc_db_query("select count(*) as total from ".TABLE_PRODUCTS_ATTRIBUTES." pa, ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." pad where pa.products_id = '".$products_id."' and pa.options_values_id = '".$value."' and pa.products_attributes_id = pad.products_attributes_id");
						$virtual_check = xtc_db_fetch_array($virtual_check_query);

						if ($virtual_check['total'] > 0) {
							switch ($this->content_type) {
								case 'physical' :
									$this->content_type = 'mixed';
									return $this->content_type;
									break;

								default :
									$this->content_type = 'virtual';
									break;
							}
						} else {
							switch ($this->content_type) {
								case 'virtual' :
									$this->content_type = 'mixed';
									return $this->content_type;
									break;

								default :
									$this->content_type = 'physical';
									break;
							}
						}
					}
				} else {
					switch ($this->content_type) {
						case 'virtual' :
							$this->content_type = 'mixed';
							return $this->content_type;
							break;

						default :
							$this->content_type = 'physical';
							break;
					}
				}
			}
		} else {
			$this->content_type = 'physical';
		}
		return $this->content_type;
	}

	function unserialize($broken) {
		for (reset($broken); $kv = each($broken);) {
			$key = $kv['key'];
			if (gettype($this-> $key) != "user function")
				$this-> $key = $kv['value'];
		}
	}
	// GV Code Start
	// ------------------------ ICW CREDIT CLASS Gift Voucher Addittion-------------------------------Start
	// amend count_contents to show nil contents for shipping
	// as we don't want to quote for 'virtual' item
	// GLOBAL CONSTANTS if NO_COUNT_ZERO_WEIGHT is true then we don't count any product with a weight
	// which is less than or equal to MINIMUM_WEIGHT
	// otherwise we just don't count gift certificates

	function count_contents_virtual() { // get total number of items in cart disregard gift vouchers
		$total_items = 0;
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				$no_count = false;
				$gv_query = xtc_db_query("select products_model from ".TABLE_PRODUCTS." where products_id = '".$products_id."'");
				$gv_result = xtc_db_fetch_array($gv_query);
				if (preg_match('/^GIFT/', $gv_result['products_model'])) {
					$no_count = true;
				}
				if (NO_COUNT_ZERO_WEIGHT == 1) {
					$gv_query = xtc_db_query("select products_weight from ".TABLE_PRODUCTS." where products_id = '".xtc_get_prid($products_id)."'");
					$gv_result = xtc_db_fetch_array($gv_query);
					if ($gv_result['products_weight'] <= MINIMUM_WEIGHT) {
						$no_count = true;
					}
				}
				if (!$no_count)
					$total_items += $this->get_quantity($products_id);
			}
		}
		return $total_items;
	}
	// ------------------------ ICW CREDIT CLASS Gift Voucher Addittion-------------------------------End
	//GV Code End
	
	//FIX-WISHLIST TO CART:BEGINN
    function get_attributes_from_id ($var){
    if (!is_numeric($var)) {
    $attributes = explode('{', substr($var, strpos($var, '{')+1));
        foreach($attributes as $element)
        {
            list($key, $value) = explode('}', trim($element));
            $attributes_array[$key]=$value;
        }
        }else{
        $attributes_array="";
        }
    return $attributes_array;
    }
    //FIX_WISHLIST TO CART:END  
}
