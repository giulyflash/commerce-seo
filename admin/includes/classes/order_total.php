<?php

/* -----------------------------------------------------------------
 * 	$Id: order_total.php 420 2013-06-19 18:04:39Z akausch $
 * 	Copyright (c) 2011-2021 commerce:SEO by Webdesign Erfurt
 * 	http://www.commerce-seo.de
 * ------------------------------------------------------------------
 * 	based on:
 * 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 * 	(c) 2002-2003 osCommerce - www.oscommerce.com
 * 	(c) 2003     nextcommerce - www.nextcommerce.org
 * 	(c) 2005     xt:Commerce - www.xt-commerce.com
 * 	Released under the GNU General Public License
 * --------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

class order_total {

    var $modules;

    // function __construct() {
    // }

    function credit_selection() {
        $selection_string = '';
        $close_string = '';
        $credit_class_string = '';
        if (MODULE_ORDER_TOTAL_INSTALLED) {
            $header_string = '<tr>' . "\n";
            $header_string .= '   <td><table border="0" width="100%" cellspacing="0" cellpadding="2">' . "\n";
            $output1_string .= '      <tr>' . "\n";
            $header_string .= '        <td class="main"><b>' . TABLE_HEADING_CREDIT . '</b></td>' . "\n";
            $header_string .= '      </tr>' . "\n";
            $header_string .= '    </table></td>' . "\n";
            $header_string .= '  </tr>' . "\n";
            $header_string .= '<tr>' . "\n";
            $header_string .= '   <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">' . "\n";
            $header_string .= '     <tr class="infoBoxContents"><td><table border="0" width="100%" cellspacing="0" cellpadding="2">' . "\n";
            $header_string .= '       <tr><td width="10">&nbsp;</td>' . "\n";
            $header_string .= '           <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">' . "\n";
            $close_string = '                           </table></td>';
            $close_string .= '<td width="10">&nbsp;</td>';
            $close_string .= '</tr></table></td></tr></table></td>';
            $close_string .= '<tr><td width="100%">&nbsp;</td></tr>';
            reset($this->modules);
            $output_string = '';
            while (list (, $value) = each($this->modules)) {
                $class = substr($value, 0, strrpos($value, '.'));
                if ($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class) {
                    $use_credit_string = $GLOBALS[$class]->use_credit_amount();
                    if ($selection_string == '')
                        $selection_string = $GLOBALS[$class]->credit_selection();
                    if (($use_credit_string != '') || ($selection_string != '')) {
                        $output_string .= '<tr colspan="4"><td colspan="4" width="100%">&nbsp;</td></tr>';
                        $output_string = ' <tr class="' . (($i % 2 == 0) ? 'dataTableRow' : 'dataWhite') . '">' . "\n" . '   <td width="10">&nbsp;</td>' . '     <td class="main"><b>' . $GLOBALS[$class]->header . '</b></td>' . $use_credit_string;
                        $output_string .= '<td  width="10">&nbsp;</td>';
                        $output_string .= '  </tr>' . "\n";
                        $output_string .= $selection_string;
                    }
                }
            }
            if ($output_string != '') {
                $output_string = $header_string . $output_string;
                $output_string .= $close_string;
            }
        }
        return $output_string;
    }

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

    function collect_posts() {

        if (MODULE_ORDER_TOTAL_INSTALLED) {
            reset($this->modules);
            while (list (, $value) = each($this->modules)) {
                $class = substr($value, 0, strrpos($value, '.'));
                if (($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class)) {
                    $post_var = 'c' . $GLOBALS[$class]->code;
                    if ($_POST[$post_var]) {
                        $_SESSION[$post_var] = $_POST[$post_var];
                    }
                    $GLOBALS[$class]->collect_posts();
                }
            }
        }
    }

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
                unset($_SESSION['credit_covers']);
            }
        }
    }

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

    function clear_posts() {

        if (MODULE_ORDER_TOTAL_INSTALLED) {
            reset($this->modules);
            while (list (, $value) = each($this->modules)) {
                $class = substr($value, 0, strrpos($value, '.'));
                if (($GLOBALS[$class]->enabled && $GLOBALS[$class]->credit_class)) {
                    $post_var = 'c' . $GLOBALS[$class]->code;
                    unset($_SESSION[$post_var]);
                }
            }
        }
    }

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
                include (DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/order_total/' . $value);
                include (DIR_FS_CATALOG_MODULES . 'order_total/' . $value);

                $class = substr($value, 0, strrpos($value, '.'));
                $GLOBALS[$class] = new $class ();
            }
            unset($modules);
        }
    }

    function process() {
        $order_total_array = array();
        if (is_array($this->modules)) {
            reset($this->modules);
            while (list (, $value) = each($this->modules)) {
                $class = substr($value, 0, strrpos($value, '.'));
                if ($GLOBALS[$class]->enabled) {
                    $GLOBALS[$class]->process();

                    for ($i = 0, $n = sizeof($GLOBALS[$class]->output); $i < $n; $i++) {
                        if (xtc_not_null($GLOBALS[$class]->output[$i]['title']) && xtc_not_null($GLOBALS[$class]->output[$i]['text'])) {
                            $order_total_array[] = array('code' => $GLOBALS[$class]->code, 'title' => $GLOBALS[$class]->output[$i]['title'], 'text' => $GLOBALS[$class]->output[$i]['text'], 'value' => $GLOBALS[$class]->output[$i]['value'], 'sort_order' => $GLOBALS[$class]->sort_order);
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
                    for ($i = 0; $i < $size; $i++) {
                        $output_string .= '              <tr>' . "\n" . '                <td align="right" class="main">' . $GLOBALS[$class]->output[$i]['title'] . '</td>' . "\n" . '                <td align="right" class="main">' . $GLOBALS[$class]->output[$i]['text'] . '</td>' . "\n" . '              </tr>';
                    }
                }
            }
        }

        return $output_string;
    }

}
