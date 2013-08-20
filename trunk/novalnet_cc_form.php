<?php
#########################################################
#                                                       #
#  CC / CREDIT CARD payment method 	                    #
#  This module is used for real time processing of      #
#  Credit card data of customers.                       #
#                                                       #
#  Copyright (c) Novalnet AG                       	    #
#                                                       #
#  Released under the GNU General Public License        #
#  This free contribution made by request.              #
#  If you have found this script usefull a small        #
#  recommendation as well as a comment on merchant form #
#  would be greatly appreciated.                        #
#                                                       #
#  Version : novalnet_cc_form.php 			            #
#                                                       #
#########################################################
	$request = array();
	$request['nn_lang_nn'] 		= $_REQUEST['language'];
	$request['nn_vendor_id_nn'] = $_REQUEST['vendor_id'];
    $request['nn_product_id_nn']= $_REQUEST['product_id'];
    $request['nn_payment_id_nn']= $_REQUEST['payment_id'];
	$url = "https://payport.novalnet.de/direct_form.jsp";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $request);  // add POST fields
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	$cc_form_content = curl_exec($ch);
	curl_close($ch); 
	echo $cc_form_content;
?>
