<?php
/*

  second_confirmation.php
  
  xt:Commerce ClickandBuy Payment Module
  (c) 2008 Matthias Bauer / Trust in Dialog <http://www.trustindialog.de/>

  @author Matthias Bauer <m.bauer@trustindialog.de>
  @copyright (c) 2008 Matthias Bauer / Trust in Dialog
  @version $Revision: 360 $
  @license GPLv2

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details. 
  
*/

function clickandbuy_second_confirmation($order_id) {
  require_once('lib/nusoap.php');

  // XXX FIXME Please update the system code from eu to uk/us/se/dk/no based on your ClickandBuy Merchant account platform
  $client = new nusoapclient('http://wsdl.eu.clickandbuy.com/TMI/1.4/TransactionManagerbinding.wsdl', true);
  $err = $client->getError();
  if ($err) {
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
  }

  // Get order data
  $qr = xtc_db_query(sprintf("SELECT * FROM orders_clickandbuy WHERE orders_id = %d", $order_id));
  if (!$qr || mysql_num_rows($qr) < 1) {
    return array('empty', null);
  }
  $qa = xtc_db_fetch_array($qr);

  $result = $client->call(
    'isExternalBDRIDCommitted',
    array(
      'sellerID' => MODULE_PAYMENT_CLICKANDBUY_SELLER_ID,
      'tmPassword' => MODULE_PAYMENT_CLICKANDBUY_TMI_PASSWORD,
      'slaveMerchantID' => '0',
      'externalBDRID' => $qa['f_externalBDRID']
    ), 'https://clickandbuy.com/TransactionManager/', 'https://clickandbuy.com/TransactionManager/'
  );

  if ($client->fault) {
    return array('fault', $result);
  }
  else {
    if ($err = $client->getError()) {
      return array('error', $err);
    }
    else {
      return array('success', $result);
    }
  }
}

?>
