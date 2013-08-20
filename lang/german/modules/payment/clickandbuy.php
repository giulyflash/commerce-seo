<?php
/*

  clickandbuy.php
  german language file
  
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

define('MODULE_PAYMENT_CLICKANDBUY_TEXT_TITLE', 'ClickandBuy');
define('MODULE_PAYMENT_CLICKANDBUY_TEXT_DESCRIPTION', 'ClickandBuy');
define('MODULE_PAYMENT_CLICKANDBUY_STATUS_TITLE', 'ClickandBuy-Module aktivieren');
define('MODULE_PAYMENT_CLICKANDBUY_STATUS_DESC', 'M&ouml;chten Sie Zahlungen via ClickandBuy akzeptieren?');
define('MODULE_PAYMENT_CLICKANDBUY_ID_TITLE', 'Premiumlink');
define('MODULE_PAYMENT_CLICKANDBUY_ID_DESC', 'Ihr ClickandBuy-Premiumlink');
define('MODULE_PAYMENT_CLICKANDBUY_REDIRECT_TITLE', 'Name des Redirection-Scripts');
define('MODULE_PAYMENT_CLICKANDBUY_REDIRECT_DESC', 'Dateiname des ClickandBuy-Redirection-Scripts.<br>SOLLTE NORMALERWEISE NICHT GE&Auml;NDERT WERDEN!');
define('MODULE_PAYMENT_CLICKANDBUY_CURRENCY_TITLE', 'Transaktionsw&auml;hrung');
define('MODULE_PAYMENT_CLICKANDBUY_CURRENCY_DESC', 'Zu verwendende W&auml;hrung für ClickandBuy-Transaktionen');
define('MODULE_PAYMENT_CLICKANDBUY_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_CLICKANDBUY_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Niedrigste wird zuerst angezeigt.');
define('MODULE_PAYMENT_CLICKANDBUY_ZONE_TITLE', 'Zahlungszone');
define('MODULE_PAYMENT_CLICKANDBUY_ZONE_DESC', 'Falls eine Zone gew&auml;hlt wird, wird die Zahlungsart auf diese Zone beschr&auml;nkt.');
define('MODULE_PAYMENT_CLICKANDBUY_ORDER_STATUS_ID_TITLE', 'Bestellstatus setzen');
define('MODULE_PAYMENT_CLICKANDBUY_ORDER_STATUS_ID_DESC', 'Erfolgreiche Bestellungen mit dieser Zahlungsart automatisch auf diesen Status setzen:');
define('MODULE_PAYMENT_CLICKANDBUY_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_CLICKANDBUY_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen (z.B. "AT,DE"). Wenn leer, werden alle Zonen erlaubt.');
define('MODULE_PAYMENT_CLICKANDBUY_SECONDCONFIRMATION_STATUS_TITLE', 'Second Confirmation verwenden?');
define('MODULE_PAYMENT_CLICKANDBUY_SECONDCONFIRMATION_STATUS_DESC', 'Gesonderte Best&auml;tigung der Zahlung (Second Confirmation)');
define('MODULE_PAYMENT_CLICKANDBUY_SELLER_ID_TITLE', 'Anbieter-ID');
define('MODULE_PAYMENT_CLICKANDBUY_SELLER_ID_DESC', 'Die Anbieter-ID Ihres Händleraccounts. (ClickandBuy &gt; Einstellungen &gt; Stammdaten)');
define('MODULE_PAYMENT_CLICKANDBUY_TMI_PASSWORD_TITLE', 'Transaktionsmanager-Passwort');
define('MODULE_PAYMENT_CLICKANDBUY_TMI_PASSWORD_DESC', 'Ihr Passwort für das Transaktionsmanager-Interface.');

// More Info Link
define('MODULE_PAYMENT_CLICKANDBUY_MORE_INFO_LINK_TITLE', 'Mehr Informationen zu ClickandBuy');

// ClickandBuy
define('CLICKANDBUY_PAYMENT_ERROR_DB', 'Es ist ein Datenbankfehler aufgetreten. Bitte wählen Sie eine andere Zahlungsart.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_USERID', 'Fehler #3 bei der Bezahlung. Bitte versuchen Sie es erneut.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_TRANSACTIONID', 'Fehler #4 bei der Bezahlung. Bitte versuchen Sie es erneut.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_EXTERNALBDRID', 'Fehler #5 bei der Bezahlung. Bitte versuchen Sie es erneut.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_PRICE', 'Fehler #6 bei der Bezahlung. Bitte wählen Sie eine andere Zahlungsart.');
define('CLICKANDBUY_PAYMENT_ERROR_INVALID_TRANSACTIONID', 'Fehler #7 bei der Bezahlung. Bitte wählen Sie eine andere Zahlungsart.');
define('CLICKANDBUY_PAYMENT_ERROR_INVALID_IP', 'Fehler #8 bei der Bezahlung. Bitte wählen Sie eine andere Zahlungsart.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_XUSERID', 'Fehler #9 bei der Bezahlung. Bitte wählen Sie eine andere Zahlungsart.');
define('CLICKANDBUY_PAYMENT_ERROR_NO_BASKET', 'Fehler #10 bei der Bezahlung. Bitte wählen Sie eine andere Zahlungsart.');
define('CLICKANDBUY_PAYMENT_ERROR_INVALID_BASKET', 'Fehler #11 bei der Bezahlung. Bitte wählen Sie eine andere Zahlungsart.');
// /ClickandBuy

?>