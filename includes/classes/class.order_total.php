<?php
/*-----------------------------------------------------------------
* 	$Id: class.order_total.php 397 2013-06-17 19:36:21Z akausch $
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




class order_total {
	var $modules;

	// GV Code Start
	// ICW ORDER TOTAL CREDIT CLASS/GV SYSTEM - START ADDITION
	//
	// This function is called in checkout payment after display of payment methods. It actually calls
	// two credit class functions.
	//
	// use_credit_amount() is normally a checkbox used to decide whether the credit amount should be applied to reduce
	// the order total. Whether this is a Gift Voucher, or discount coupon or reward points etc.
	//
	// The second function called is credit_selection(). This in the credit classes already made is usually a redeem box.
	// for entering a Gift Voucher number. Note credit classes can decide whether this part is displayed depending on
	// E.g. a setting in the admin section.
	//
	function credit_selection() {
		$selection_string = '';
		$class_desc = str_replace(' ','_',TABLE_HEADING_CREDIT);
		$start_string = '<div class="'.strtolower($class_desc).'">';
		$close_string = '</div>';
		$credit_class_string = '';
		if (MODULE_ORDER_TOTAL_INSTALLED) {
			$header_string = '<h3>'.TABLE_HEADING_CREDIT.'</h3>'."\n";
			reset($this->modules);
			$output_string = '';
			while (list (, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if ($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class) {
					$use_credit_string = $GLOBALS[$class]->use_credit_amount();
					if ($selection_string == '')
						$selection_string = $GLOBALS[$class]->credit_selection();
					if (($use_credit_string != '') || ($selection_string != '')) {
						$output_string = '<strong>'.$GLOBALS[$class]->header.'</strong><br /> '.$use_credit_string;
						$output_string .= "\n";
						$output_string .= $selection_string;
					}

				}
			}
			if ($output_string != '') {
				$output_string = $start_string.$header_string.$output_string;
				$output_string .= $close_string;
			}
		}
		return $output_string;
	}


	// update_credit_account is called in checkout process on a per product basis. It's purpose
	// is to decide whether each product in the cart should add something to a credit account.
	// e.g. for the Gift Voucher it checks whether the product is a Gift voucher and then adds the amount
	// to the Gift Voucher account.
	// Another use would be to check if the product would give reward points and add these to the points/reward account.
	//
	function update_credit_account($i) {
		if (MODULE_ORDER_TOTAL_INSTALLED) {
			reset($this->modules);
			while (list (, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if (($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class)) {
					$GLOBALS[$class]->update_credit_account($i);
				}
			}
		}
	}
	// This function is called in checkout confirmation.
	// It's main use is for credit classes that use the credit_selection() method. This is usually for
	// entering redeem codes(Gift Vouchers/Discount Coupons). This function is used to validate these codes.
	// If they are valid then the necessary actions are taken, if not valid we are returned to checkout payment
	// with an error
	//
	function collect_posts() {

		if (MODULE_ORDER_TOTAL_INSTALLED) {
			reset($this->modules);
			while (list (, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if (($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class)) {
					$post_var = 'c'.$GLOBALS[$class]->code;
					if ($_POST[$post_var]) {
						$_SESSION[$post_var] = $_POST[$post_var];
					}
					$GLOBALS[$class]->collect_posts();
				}
			}
		}
	}
	// pre_confirmation_check is called on checkout confirmation. It's function is to decide whether the
	// credits available are greater than the order total. If they are then a variable (credit_covers) is set to
	// true. This is used to bypass the payment method. In other words if the Gift Voucher is more than the order
	// total, we don't want to go to paypal etc.
	//
	function pre_confirmation_check() {
		global $order;
		if (MODULE_ORDER_TOTAL_INSTALLED) {
			$total_deductions = 0;
			reset($this->modules);
			$order_total = $order->info['total'];
			while (list (, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				$order_total = $this->get_order_total_main($class, $order_total);
				if (($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class)) {
					$total_deductions = $total_deductions + $GLOBALS[$class]->pre_confirmation_check($order_total);
					$order_total = $order_total - $GLOBALS[$class]->pre_confirmation_check($order_total);
				}
			}
			if ($order->info['total'] - $total_deductions <= 0) {
				$_SESSION['credit_covers'] = true;
			} else { // belts and suspenders to get rid of credit_covers variable if it gets set once and they put something else in the cart
				unset ($_SESSION['credit_covers']);
			}
		}
	}
	// this function is called in checkout process. it tests whether a decision was made at checkout payment to use
	// the credit amount be applied aginst the order. If so some action is taken. E.g. for a Gift voucher the account
	// is reduced the order total amount.
	//
	function apply_credit() {
		if (MODULE_ORDER_TOTAL_INSTALLED) {
			reset($this->modules);
			while (list (, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if (($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class)) {
					$GLOBALS[$class]->apply_credit();
				}
			}
		}
	}
	// Called in checkout process to clear session variables created by each credit class module.
	//
	function clear_posts() {

		if (MODULE_ORDER_TOTAL_INSTALLED) {
			reset($this->modules);
			while (list (, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if (($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class)) {
					$post_var = 'c'.$GLOBALS[$class]->code;
					unset ($_SESSION[$post_var]);
				}
			}
		}
	}
	// Called at various times. This function calulates the total value of the order that the
	// credit will be appled aginst. This varies depending on whether the credit class applies
	// to shipping & tax
	//
	function get_order_total_main($class, $order_total) {
		global $credit, $order;
		//      if ($GLOBALS[$class]->include_tax == 'false') $order_total=$order_total-$order->info['tax'];
		//      if ($GLOBALS[$class]->include_shipping == 'false') $order_total=$order_total-$order->info['shipping_cost'];
		return $order_total;
	}
	// ICW ORDER TOTAL CREDIT CLASS/GV SYSTEM - END ADDITION
	// GV Code End

	// class constructor
	function order_total() {
		if (defined('MODULE_ORDER_TOTAL_INSTALLED') && xtc_not_null(MODULE_ORDER_TOTAL_INSTALLED)) {
			$this->modules = explode(';', MODULE_ORDER_TOTAL_INSTALLED);
			$modules = $this->modules;
			sort($modules); // cgoenner: we need to include the ot_coupon & ot_gv BEFORE ot_tax
			reset($modules);
			while (list (, $value) = each($modules)) {
				require_once (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/order_total/'.$value);
				require_once (DIR_WS_MODULES.'order_total/'.$value);

				$class = substr($value, 0, strrpos($value, '.'));
				$GLOBALS[$class] = new $class ();
			}
			unset($modules);
		}
	}

	function process() {
		$order_total_array = array ();
		if (is_array($this->modules)) {
			reset($this->modules);
			while (list (, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if ($GLOBALS[$class]->enabled) {
					$GLOBALS[$class]->process();

					for ($i = 0, $n = sizeof($GLOBALS[$class]->output); $i < $n; $i ++) {
						if (xtc_not_null($GLOBALS[$class]->output[$i]['title']) && xtc_not_null($GLOBALS[$class]->output[$i]['text'])) {
							$order_total_array[] = array ('code' => $GLOBALS[$class]->code, 'title' => $GLOBALS[$class]->output[$i]['title'], 'text' => $GLOBALS[$class]->output[$i]['text'], 'value' => $GLOBALS[$class]->output[$i]['value'], 'sort_order' => $GLOBALS[$class]->sort_order);
						}
					}
				}
			}
		}

		return $order_total_array;
	}

	function output() {
		$output_string = '';
		if (is_array($this->modules)) {
			reset($this->modules);
			while (list (, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if ($GLOBALS[$class]->enabled) {
					$size = sizeof($GLOBALS[$class]->output);
					for ($i = 0; $i < $size; $i ++) {
						$output_string .= '<div class="'.$GLOBALS[$class]->code.'">'.$GLOBALS[$class]->output[$i]['title'] . $GLOBALS[$class]->output[$i]['text'].'</div>';
					}
				}
			}
		}

		return $output_string;
	}

	function pp_output() {
		$output_string = '';
		if (is_array($this->modules)) {
			reset($this->modules);
			while (list (, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if ($GLOBALS[$class]->enabled) {
					$size = sizeof($GLOBALS[$class]->output);
					for ($i = 0; $i < $size; $i ++) {
						$output_string[] = array('title'=>$GLOBALS[$class]->output[$i]['title'], 'text'=>$GLOBALS[$class]->output[$i]['text']);
					}
				}
			}
		}

		return $output_string;
	}
}
?>