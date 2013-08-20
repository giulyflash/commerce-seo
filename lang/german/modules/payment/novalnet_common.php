<?php

$request_server_type = (getenv('HTTPS') == '1' || getenv('HTTPS') == 'on') ? 'https' : 'http';
//Start : Backend Configure Values
define('NOVALNET_STATUS_TITLE', 'Modul aktivieren');
define('NOVALNET_STATUS_DESC', '');
define('NOVALNET_VENDOR_ID_TITLE', 'Novalnet H&auml;ndler ID');
define('NOVALNET_VENDOR_ID_DESC', 'Geben Sie Ihre Novalnet H&auml;ndler-ID ein');
define('NOVALNET_AUTH_CODE_TITLE', 'Novalnet Authorisierungsschl&uuml;ssel');
define('NOVALNET_AUTH_CODE_DESC', 'Geben Sie Ihren Novalnet-Authorisierungsschl&uuml;ssel ein');
define('NOVALNET_PRODUCT_ID_TITLE', 'Novalnet Produkt ID');
define('NOVALNET_PRODUCT_ID_DESC', 'Geben Sie Ihre Novalnet Produkt-ID ein');
define('NOVALNET_TARIFF_ID_TITLE', 'Novalnet Tarif ID');
define('NOVALNET_TARIFF_ID_DESC', 'Geben Sie Ihre Novalnet Tarif-ID ein');
define('NOVALNET_MANUAL_CHECK_LIMIT_TITLE', 'Manuelle &Uuml;berpr&uuml;fung des Betrags in Cent');
define('NOVALNET_MANUAL_CHECK_LIMIT_DESC', 'Bitte den Betrag in Cent eingeben');
define('NOVALNET_PRODUCT_ID2_TITLE', 'Zweite Novalnet Produkt ID');
define('NOVALNET_PRODUCT_ID2_DESC', 'zur manuellen &Uuml;berpr&uuml;fung');
define('NOVALNET_TARIFF_ID2_TITLE', 'Zweite Novalnet Tarif ID');
define('NOVALNET_TARIFF_ID2_DESC', 'zur manuellen &Uuml;berpr&uuml;fung');
define('NOVALNET_INFO_TITLE', 'Informationen f&uuml;r den End kunden');
define('NOVALNET_INFO_DESC', 'wird im Bezahlformular erscheinen');
define('NOVALNET_ORDER_STATUS_ID_TITLE', 'Bestellstatus setzen');
define('NOVALNET_ORDER_STATUS_ID_DESC', 'Setzen Sie den Status von &uuml;ber dieses Zahlungsmodul durchgef&uuml;hrten Bestellungen auf diesen Wert');
define('NOVALNET_SORT_ORDER_TITLE', 'Sortierung nach');
define('NOVALNET_SORT_ORDER_DESC', 'Sortierung der Anzeige. Der niedrigste Wert wird zuerst angezeigt.');
define('NOVALNET_ZONE_TITLE', 'Zahlungsgebiet');
define('NOVALNET_ZONE_DESC', 'Wird ein Bereich ausgew&auml;hlt, dann wird dieses Modul nur f&uuml;r den ausgew&auml;hlten Bereich aktiviert');
define('NOVALNET_ALLOWED_TITLE', 'Erlaubte Zonen');
define('NOVALNET_ALLOWED_DESC', 'Bitte die gew&uuml;nschten Zonen durch Komma getrennt eingeben (z.B: AT,DE) oder einfach leer lassen');
define('NOVALNET_LOGO_STATUS_TITLE', 'Novalnet Logo');
define('NOVALNET_LOGO_STATUS_DESC', 'Wollen Sie Novalnet logo im Frontend angezeigt werden?');
define('NOVALNET_TEST_MODE_TITLE', 'Testmodus einschalten');
define('NOVALNET_TEST_MODE_DESC', '');
define('NOVALNET_PASSWORD_TITLE', 'Novalnet Paymentzugriffsschl&uuml;ssel');
define('NOVALNET_PASSWORD_DESC', 'Geben Sie Ihr Novalnet Paymentzugriffsschl&uuml;ssel ein');
define('NOVALNET_PROXY_TITLE', 'Proxy-Server');
define('NOVALNET_PROXY_DESC', 'Wenn Sie einen Proxy-Server einsetzen, tragen Sie hier Ihre Proxy-IP und den Port ein (z.B. www.proxy.de:80)');
define('NOVALNET_IN_TEST_MODE', '<span style="color:#FF0000;">&nbsp;&nbsp;(im Testbetrieb)</span>');
define('NOVALNET_NOT_CONFIGURED', '<span style="color:#FF0000;">&nbsp;&nbsp;(Nicht konfiguriert)</span>');
define('NOVALNET_TEXT_ERROR_MESSAGE', 'Novalnet Fehlermeldung :');
define('NOVALNET_TEXT_ERROR_CODE', 'Novalnet Error Code :');

//End : Backend Configure Values
//Start : Common Error and Description
/* define('NOVALNET_REDIRECT_TEXT_DESCRIPTION', '<div style="margin:10px 0px 10px 0px;">Sie werden zur Website der Novalnet AG umgeleitet, sobald Sie die Bestellung best&auml;tigen.</div>');
  define('NOVALNET_INV_PP_TEXT_DESCRIPTION', '<div style="margin:10px 0px 10px 0px;">Die Bankverbindung wird Ihnen nach Abschluss Ihrer Bestellung per E Mail zugeschickt.</div>');
  define('NOVALNET_CC_TEXT_DESCRIPTION', '<div style="margin:10px 0px 10px 0px;">Die Belastung Ihrer Kreditkarte erfolgt mit dem Abschluss der Bestellung.</div>');
  define('NOVALNET_DD_TEXT_DESCRIPTION', '<div style="margin:10px 0px 10px 0px;">Die Belastung Ihres Kontos erfolgt mit dem Versand der Ware.</div>');
  define('NOVALNET_TEL_TEXT_DESCRIPTION', 'Schnell und Sicher bezahlen &uuml;ber Novalnet AG<BR>Bitte vor aktivierung alle noetige IDs in Bearbeitungmodus eingeben.<br><br>'); */
define('NOVALNET_REDIRECT_TEXT_DESCRIPTION', 'Sie werden zur Website der Novalnet AG umgeleitet, sobald Sie die Bestellung best&auml;tigen.');
define('NOVALNET_INV_PP_TEXT_DESCRIPTION', 'Die Bankverbindung wird Ihnen nach Abschluss Ihrer Bestellung per E-Mail zugeschickt.');
define('NOVALNET_CC_TEXT_DESCRIPTION', 'Die Belastung Ihrer Kreditkarte erfolgt mit dem Abschluss der Bestellung.');
define('NOVALNET_DD_TEXT_DESCRIPTION', 'Die Belastung Ihres Kontos erfolgt mit dem Versand der Ware.');
define('NOVALNET_TEL_TEXT_DESCRIPTION', 'Ihr Betrag wird zu Ihrer Telefonrechnung hinzugef&uuml;gt werden, wenn Sie die Bestellung aufgeben ');
define('NOVALNET_GUEST_USER', 'gast');
define('NOVALNET_TEXT_LANG', 'DE');
define('NOVALNET_TEXT_INFO', '');
define('NOVALNET_TEXT_ERROR_MESSAGE', '<br>Novalnet Fehlermeldung :');
define('NOVALNET_TEXT_JS_NN_MISSING', '* Grundlegende Parameter fehlt.!');
define('NOVALNET_TEXT_JS_NN_ID2_MISSING', '* Produkt ID2 und / oder Tarif ID2 fehlen!');
define('NOVALNET_ACCOUNT_TEXT_ERROR', 'Kontodaten Fehler:');
define('NOVALNET_CC_TEXT_ERROR', 'Kartendaten Fehler:');
define('NOVALNET_TEXT_CUST_INFORM', '"Wir holen zuvor eine Bonit&auml;tsauskunft ein, denn nur bei positiver Auskunft k&ouml;nnen wir die Bestellung durchf&uuml;hren und die Abbuchung erfolgt mit dem Warenversand. Bei Nichteinl&ouml;sung/Widerruf berechnen wir eine Aufwandspauschale von 10,00 Euro und der Vorgang wird sofort dem Inkasso Verfahren &uuml;bergeben."');
define('NOVALNET_TEXT_ORDERNO', 'Best. Nr.: ');
define('NOVALNET_TEXT_ORDERDATE', 'Best. Datum: ');
define('NOVALNET_TEST_MODE', 'Testbestellung');
define('NOVALNET_TEXT_HASH_ERROR', 'checkHash fehlgeschlagen');
define('NOVALNET_TEST_ORDER_MESSAGE', " Testbestellung \n");
define('NOVALNET_TID_MESSAGE', 'Novalnet Transaktions-ID  : ');
define('NOVALNET_REF_TID_MESSAGE', 'Verwendungszweck : TID ');
define('NOVALNET_PAYMENT_MESSAGE', 'Ein Fehler trat auf und Ihre Zahlung konnte nicht abgeschlossen werden.');
define('NOVALNET_REQUEST_FOR_CHOOSE_SHIPPING_METHOD', 'Bitte w&auml;hlen Sie eine Versandart');
define('NOVALNET_TEXT_JS_NN_CHECK_LIMIT_MISSING', '* Manueller &Uuml;berpr&uuml;fung feld fehlen!');
//End : Common Error and Description
//Start : Pin by call back
define('NOVALNET_PIN_COUNTRY_CODE_TITLE', 'L&auml;nder codes');
define('NOVALNET_PIN_COUNTRY_CODE_DESC', 'Bitte geben Sie die Landesvorwahl <b> separat </ b>, die erlaubt, die "Pin Mit Callback" option (zb DE, AT) erm&ouml;glichen soll');
define('NOVALNET_PIN_BY_CALLBACK_SMS_TITLE', 'PIN by Callback/SMS/E-Mail');
define('NOVALNET_PIN_BY_CALLBACK_SMS_DESC', 'Wenn PIN by Callback / SMS / E-Mail aktiviert ist, wird der Kunde gebeten, seine Telefonnummer / Handynummer / E-Mail einzugeben. Per Telefon oder SMS erhält der Kunde eine PIN von Novalnet AG, die vor der Bestellung eingegeben werden muß. Wenn die PIN gültig ist, ist die Zahlung erfolgreich beendet, andernfalls wird der Kunde erneut aufgefordert, die PIN einzugeben. Dieser Service ist nur für Kunden aus bestimmten Ländern verfügbar.');
/* define('NOVALNET_PIN_BY_CALLBACK_TEL_REQ', '<div style="width:125px;">Telefonnummer: <span style="color:red">*</span></div>');
  define('NOVALNET_PIN_BY_CALLBACK_SMS_REQ', '<div style="width:125px;">Mobiltelefonnummer:*</div>');
  define('NOVALNET_PIN_BY_CALLBACK_EMAIL_REQ', '<div style="width:125px;">E-Mail Adresse:*</div>'); */
define('NOVALNET_PIN_BY_CALLBACK_SMS_TEL', 'Telefonnummer: <span style="color:red">*</span>');
define('NOVALNET_PIN_BY_CALLBACK_SMS_MOB', 'Mobiltelefonnummer: <span style="color:red">*</span>');
define('NOVALNET_PIN_BY_CALLBACK_EMAIL', 'E-Mail Adresse: <span style="color:red">*</span>');
define('NOVALNET_PIN_BY_CALLBACK_SMS_PIN', 'PIN:');
define('NOVALNET_PIN_BY_CALLBACK_SMS_NEW_PIN', 'PIN vergessen? [Neue PIN beantragen]');
define('NOVALNET_PIN_BY_CALLBACK_SMS_TEL_NOTVALID', 'Geben Sie bitte die Telefon- / Handynummer ein!');
define('NOVALNET_PIN_BY_CALLBACK_SMS_PIN_NOTVALID', 'Die eingegebene PIN ist falsch oder leer!');
define('NOVALNET_PIN_BY_CALLBACK_EMAIL_NOTVALID', 'Bitte geben Sie die E-Mail-Adresse');
define('NOVALNET_EMAIL_INPUT_REQUEST_DESC', 'Wir haben Ihnen eine Email geschickt, beantworten Sie diese bitte.');
define('NOVALNET_PIN_BY_CALLBACK_SMS_CALL_MESSAGE', 'Sie werden in k&uuml;rze eine PIN per Telefon\/SMS erhalten. Bitte geben Sie die PIN in das entsprechende Textfeld ein.');
define('NOVALNET_PIN_BY_CALLBACK_MIN_LIMIT_TITLE', 'Grenzwert (Mindestbetrag) in Cent f&uuml;r R&uuml;ckruf');
//define('NOVALNET_PIN_BY_CALLBACK_MIN_LIMIT_DESC', 'Bitte geben Sie einen Mindestbetrag in Cent an (z.B. 100, 200), um PIN by Callback in Betrieb zu nehmen.');
define('NOVALNET_PIN_BY_CALLBACK_MIN_LIMIT_DESC', '');
define('NOVALNET_PIN_INPUT_REQUEST_DESC', '<b> PIN Nummer : <span style ="color:red">*</span></b>');
define('NOVALNET_PIN_RECEIVE_DESC', 'Sie erhalten in K&uuml;rze eine PIN per Telefon/SMS. Geben Sie bitte die PIN in das entsprechende Textfeld ein.');
define('NOVALNET_PIN_ENTRY_EXCEED_ERROR', 'Maximale Anzahl von PIN-Eingaben &uuml;erschritten');
define('NOVALNET_PIN_BY_CALLBACK_SESSION_ERROR', 'Ihre PIN Sitzung ist abgelaufen. Bitte versuchen Sie es erneut mit einem neuen Anruf!');
define('NOVALNET_AMOUNT_VARIATION_MESSAGE', 'Sie haben den Betrag in Ihrem Warenkorb ge&auml;ndert, nachdem Sie Ihre PIN erhalten haben. Bitte rufen Sie noch einmal an, um eine neue PIN zu erhalten.');
define('NOVALNET_AMOUNT_VARIATION_MESSAGE_PIN', 'Sie haben die Bestellmenge nach dem Erhalt der PIN-Nummer ge&auml;ndert, versuchen Sie es bitte erneut mit einem neuen Anruf!');
define('NOVALNET_AMOUNT_VARIATION_MESSAGE_EMAIL', 'Sie haben die Bestellmenge nach dem Erhalt der Email ge&auml;ndert, versuchen Sie es bitte erneut mit einem neuen Anruf!');

define('NOVALNET_PIN_CHECK_MSG', 'Sie erhalten in K&uuml;rze eine PIN per Telefon/SMS. Geben Sie bitte die PIN in das entsprechende Textfeld ein!');
define('NOVALNET_EMAIL_REPLY_CHECK_MSG', 'Wir haben Ihnen eine Email geschickt, beantworten Sie diese bitte!');
define('NOVALNET_EMAIL_REPLY_INFO', '<B>Ja, ich habe die E-Mail geantwortet </B>');
define('NOVALNET_EMAIL_REPLY_CHECKBOX_INFO', 'Bitte markieren Sie die Zecke, wenn Sie die E-Mail geantwortet haben');
define('NOVALNET_FORGOT_PIN_INFO', "<B><A HREF='javascript:show_forgot_pin_info()' ONMOUSEOVER='show_forgot_pin_info()'>PIN vergessen? [Neue PIN anfordern]</A></B>");
define('NOVALNET_FORGOT_PIN_DIV', "<SCRIPT>var showbaby;function show_forgot_pin_info(){var url=parent.location.href;url=url.substring(0,url.lastIndexOf('/'))+'/images/forgot_pin_info.png';w='550';h='300';x=screen.availWidth/2-w/2;y=screen.availHeight/2-h/2;showbaby=window.open(url,'showbaby','toolbar=0,location=0,directories=0,status=0,menubar=0,resizable=1,width='+w+',height='+h+',left='+x+',top='+y+',screenX='+x+',screenY='+y);showbaby.focus();}function hide_forgot_pin_info(){showbaby.close();}</SCRIPT>");
define('NOVALNET_PIN_BY_CALLBACK_SMS_MOB_NUMBER', "<div style=\"color:#FF0000;padding-right: 41px;text-align: right;\">Bitte Ihre Handynummer eingeben.</div><br>");
define('NOVALNET_PIN_BY_CALLBACK_SMS_TEL_NUMBER', "<div style=\"color:#FF0000;padding-right: 41px;text-align: right;\">Bitte Ihre Telefon-/Handynummer eingeben.</div><br>");
define('NOVALNET_EMAIL_INFO_DESC', "<br><div style=\"background-color:#FFF8AF;width: 360px;padding:5px;border:1px solid #EFEFEF;color:#FF0000;\"><b>Hinweis:</b> Nach einem Klick auf \"Speichern\" erhalten Sie in K&uuml;rze ein EMAIL, das Sie sofort ohne &auml;nderung des Mailtexts beantworten m&uuml;ssen.</div> <br>");
define('NOVALNET_PIN_INFO_DESC', "<div style=\"background-color:#FFF8AF;width: 360px;padding:5px;border:1px solid #EFEFEF;color:#FF0000;\"><b>Hinweis:</b> Nach einem Klick auf \"Speichern\" erhalten Sie in K&uuml;rze eine PIN per Telefon-/Handyr&uuml;ckruf oder SMS.</div> <br>");
//End : Pin by call back
//Start : User Form variables
define('NOVALNET_TEXT_BANK_ACCOUNT_OWNER_FORM', '<div style="width:125px;">Kontoinhaber:</div>');
define('NOVALNET_TEXT_BANK_ACCOUNT_NUMBER_FORM', '<div style="width:125px;">Kontonummer:</div>');
define('NOVALNET_TEXT_BANK_CODE_FORM', '<div style="width:125px;">Bankleitzahl:</div>');
define('NOVALNET_TEXT_BANK_ACCOUNT_OWNER_LENGTH_FORM', '3');
define('NOVALNET_TEXT_BANK_ACCOUNT_NUMBER_LENGTH_FORM', '5');
define('NOVALNET_TEXT_BANK_CODE_LENGTH_FORM', '3');
define('NOVALNET_DD_TEXT_COMMON_ERROR', 'Geben Sie bitte g&uuml;ltige Kontodaten ein! ');
define('NOVALNET_TEXT_INVALID_BANK_ACCOUNT_OWNER', 'Geben Sie bitte g&uuml;ltige Kontodaten ein! ');
define('NOVALNET_TEXT_JS_BANK_ACCOUNT_OWNER_MIN_LENGTH_ERROR', 'Geben Sie bitte g&uuml;ltige Kontodaten ein! ');
define('NOVALNET_TEXT_JS_BANK_ACCOUNT_NUMBER_MIN_LENGTH_ERROR', 'Geben Sie bitte g&uuml;ltige Kontodaten ein! ');
define('NOVALNET_TEXT_INVALID_BANK_ACCOUNT_NUMBER', 'Geben Sie bitte g&uuml;ltige Kontodaten ein! ');
define('NOVALNET_TEXT_INVALID_BANK_CODE', 'Geben Sie bitte g&uuml;ltige Kontodaten ein! ');
define('NOVALNET_TEXT_JS_BANK_CODE_MIN_LENGTH_ERROR', 'Geben Sie bitte g&uuml;ltige Kontodaten ein! ');
//End : User Form variables
define('NOVALNET_TEXT_BANK_ACCOUNT_OWNER_PAY', 'Kontoinhaber: <span style="color:red;">*</span>');
define('NOVALNET_TEXT_BANK_ACCOUNT_NUMBER_PAY', 'Kontonummer: <span style="color:red;">*</span>');
define('NOVALNET_TEXT_BANK_CODE_PAY', 'Bankleitzahl: <span style="color:red;">*</span>');


//FRONTEND : Testmode description
define('NOVALNET_TEXT_TESTMODE_FRONT','<span style="color:#FF0000;">Bitte beachten Sie: Diese Transaktion wird im Test-Modus ausgeführt werden und der Betrag wird nicht belastet werden</span>');



//Start : Invoice and Prepayment Comment variables
define('NOVALNET_TEXT_BANK_ACCOUNT_OWNER', 'Kontoinhaber : ');
define('NOVALNET_TEXT_BANK_ACCOUNT_NUMBER', 'Kontonummer : ');
define('NOVALNET_TEXT_BANK_CODE', 'Bankleitzahl : ');
define('NOVALNET_TEXT_BANK_IBAN', 'IBAN :');
define('NOVALNET_TEXT_BANK_BIC', 'SWIFT / BIC :');
define('NOVALNET_TEXT_BANK_BANK', 'Bank :');
define('NOVALNET_TEXT_BANK_CITY', 'Stadt :');
define('NOVALNET_TEXT_AMOUNT', 'Betrag :');
define('NOVALNET_TEXT_REFERENCE', 'Verwendungszweck :');
define('NOVALNET_TEXT_IBAN_INFO', 'Nur bei Auslands&uuml;berweisungen :');
/* define('NOVALNET_TEXT_REFERENCE_INFO', 'Bitte beachten Sie, dass die Ueberweisung nur bearbeitet werden kann, wenn der oben angegebene Verwendungszweck verwendet wird.'); */
define('NOVALNET_TEXT_REFERENCE_INFO', '');
define('NOVALNET_TEXT_TRANSFER_INFO', 'Bitte &uuml;berweisen Sie den Betrag mit der folgenden Information an unseren Zahlungsdienstleister Novalnet AG');
define('NOVALNET_TEXT_BANK_INFO', 'Die Bankverbindung wird Ihnen nach Abschluss Ihrer Bestellung per E-Mail zugeschickt!');
define('NOVALNET_TEXT_DURATION_INFO', 'Zahlungsfrist:');
define('NOVALNET_TEXT_DURATION_INFO_DAYS', 'Tage');
define('NOVALNET_TEXT_DURATION_DUE_DATE', 'F&auml;lligkeitsdatum :');
define('NOVALNET_TEXT_DURATION_LIMIT_INFO', 'Bitte &uuml;berweisen Sie den Betrag mit der folgenden Information an unseren Zahlungsdienstleister Novalnet AG');
define('NOVALNET_TEXT_DURATION_LIMIT_END_INFO', 'auf folgendes Konto:');
//End : Invoice and Prepayment Comment variables
//define('NOVALNET_TEXT_LOGO_IMAGE', '<a href="https://www.novalnet.de" target="_new"><img src="https://www.novalnet.de/img/NN_Logo_T.png" alt="novalnet.de" border="0"></a>');
define('NOVALNET_TEXT_LOGO_IMAGE', '<a href="https://www.novalnet.de" target="_new"><img src="' . $request_server_type . '://www.novalnet.de/img/NN_Logo_T.png" alt="novalnet.de" border="0"></a>');

define('MODULE_PAYMENT_ENABLE_NOVALNET_LOGO', '1');

?>
