<?php
/*-----------------------------------------------------------------
* 	$Id: german.php 486 2013-07-15 22:08:14Z akausch $
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

// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat6.0 I used 'de_DE'
// on FreeBSD 4.0 I use 'de_DE.ISO_8859-1'
// this may not work under win32 environments..
setlocale(LC_TIME, 'de_DE.UTF-8', 'de_DE@euro', 'de_DE', 'de-DE', 'de', 'ge', 'de_DE.ISO_8859-1', 'German');
define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()eMail
define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
define('PHP_DATE_TIME_FORMAT', 'd.m.Y H:i:s'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('DATE_TIME_FORMATED', '<b>'.DATE_FORMAT_SHORT.'</b> %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function xtc_date_raw($date, $reverse = false) {
if ($reverse)
return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
else
return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
}

// Global entries for the <html> tag
define('HTML_PARAMS','dir="ltr" lang="de"');

define('JANUAR','Januar');
define('FEBRUAR','Februar');
define('MAERZ','M&auml;rz');
define('APRIL','April');
define('MAI','Mai');
define('JUNI','Juni');
define('JULI','Juli');
define('AUGUST','August');
define('SEPTEMBER','September');
define('OKTOBER','Oktober');
define('NOVEMBER','November');
define('DEZEMBER','Dezember');

// page title
define('TITLE', 'commerce:SEO v2 Administration');

// header text in includes/header.php
define('HEADER_TITLE_TOP', 'Administration');
define('HEADER_TITLE_SUPPORT_SITE', 'Supportseite');
define('HEADER_TITLE_ONLINE_CATALOG', 'Online Katalog');
define('HEADER_TITLE_ADMINISTRATION', 'Administration');

define('HEADER_TITLE_ORDERS', 'Bestellungen');
define('HEADER_TITLE_CUTOMERS', 'Kunden');
define('HEADER_TITLE_CATEGORIES', 'Kategorien');
define('HEADER_TITLE_CONTENT_MANAGER', 'Content');
define('HEADER_TITLE_CATEGORIES_ARTICLE', 'Kategorien/Artikel');
define('HEADER_TITLE_NO_ENTRIES','keine Eintr&auml;ge');
define('HEADER_TITLE_STATISTICS', 'Statistik');


// text for gender
define('MALE', ' Herr');
define('FEMALE', ' Frau');

// text for date of birth example
define('DOB_FORMAT_STRING', 'tt.mm.jjjj');


//Dividers text for menu

define('BOX_HEADING_MODULES', 'Module');
define('BOX_HEADING_LOCALIZATION', 'Sprachen / W&auml;hrungen');
define('BOX_HEADING_TEMPLATES','Templates');
define('BOX_HEADING_TOOLS', 'Hilfsprogramme');
define('BOX_HEADING_LOCATION_AND_TAXES', 'Land / Steuer');
define('BOX_HEADING_CUSTOMERS', 'Kunden');
define('BOX_HEADING_CATALOG', 'Katalog');
define('BOX_MODULE_NEWSLETTER','Rundschreiben');


// javascript messages
define('JS_ERROR', 'W&auml;hrend der Eingabe sind Fehler aufgetreten!\nBitte korrigieren Sie folgendes:\n\n');


define('JS_GENDER', '* Die \'Anrede\' muss ausgew&auml;hlt werden.\n');
define('JS_FIRST_NAME', '* Der \'Vorname\' muss mindestens aus ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_LAST_NAME', '* Der \'Nachname\' muss mindestens aus ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_DOB', '* Das \'Geburtsdatum\' muss folgendes Format haben: xx.xx.xxxx (Tag/Jahr/Monat).\n');
define('JS_EMAIL_ADDRESS', '* Die \'eMail-Adresse\' muss mindestens aus ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_ADDRESS', '* Die \'Strasse\' muss mindestens aus ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_POST_CODE', '* Die \'Postleitzahl\' muss mindestens aus ' . ENTRY_POSTCODE_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_CITY', '* Die \'Stadt\' muss mindestens aus ' . ENTRY_CITY_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_STATE', '* Das \'Bundesland\' muss ausgew&uuml;hlt werden.\n');
define('JS_STATE_SELECT', '-- W&auml;hlen Sie oberhalb --');
define('JS_ZONE', '* Das \'Bundesland\' muss aus der Liste f&uuml;r dieses Land ausgew&auml;hlt werden.');
define('JS_COUNTRY', '* Das \'Land\' muss ausgew&auml;hlt werden.\n');
define('JS_TELEPHONE', '* Die \'Telefonnummer\' muss aus mindestens ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_PASSWORD', '* Das \'Passwort\' sowie die \'Passwortbest&auml;tigung\' m&uuml;ssen &uuml;bereinstimmen und aus mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen bestehen.\n');

define('JS_ORDER_DOES_NOT_EXIST', 'Auftragsnummer %s existiert nicht!');

define('CATEGORY_PERSONAL', 'Pers&ouml;nliche Daten');
define('CATEGORY_ADDRESS', 'Adresse');
define('CATEGORY_CONTACT', 'Kontakt');
define('CATEGORY_COMPANY', 'Firma');
define('CATEGORY_OPTIONS', 'Weitere Optionen');

define('ENTRY_GENDER', 'Anrede:');
define('ENTRY_GENDER_ERROR', '&nbsp;<span class="errorText">notwendige Eingabe</span>');
define('ENTRY_FIRST_NAME', 'Vorname:');
define('ENTRY_FIRST_NAME_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_LAST_NAME', 'Nachname:');
define('ENTRY_LAST_NAME_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_DATE_OF_BIRTH', 'Geburtsdatum:');
define('ENTRY_DATE_OF_BIRTH_ERROR', '&nbsp;<span class="errorText">(z.B. 21.05.1970)</span>');
define('ENTRY_EMAIL_ADDRESS', 'eMail Adresse:');
define('ENTRY_EMAIL_ADDRESS_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', '&nbsp;<span class="errorText">ung&uuml;ltige eMail Adresse!</span>');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', '&nbsp;<span class="errorText">Diese eMail Adresse existiert schon!</span>');
define('ENTRY_COMPANY', 'Firmenname:');
define('ENTRY_STREET_ADDRESS', 'Strasse:');
define('ENTRY_STREET_ADDRESS_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_SUBURB', 'weitere Anschrift:');
define('ENTRY_POST_CODE', 'Postleitzahl:');
define('ENTRY_POST_CODE_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_POSTCODE_MIN_LENGTH . ' Zahlen</span>');
define('ENTRY_CITY', 'Stadt:');
define('ENTRY_CITY_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_CITY_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_STATE', 'Bundesland:');
define('ENTRY_STATE_ERROR', '&nbsp;<span class="errorText">notwendige Eingabe</span></small>');
define('ENTRY_COUNTRY', 'Land:');
define('ENTRY_TELEPHONE_NUMBER', 'Telefonnummer:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Zahlen</span>');
define('ENTRY_FAX_NUMBER', 'Telefaxnummer:');
define('ENTRY_NEWSLETTER', 'Rundschreiben:');
define('ENTRY_CUSTOMERS_STATUS', 'Kundengruppe:');
define('ENTRY_NEWSLETTER_YES', 'abonniert');
define('ENTRY_NEWSLETTER_NO', 'nicht abonniert');
define('ENTRY_MAIL_ERROR','&nbsp;<span class="errorText">Bitte treffen sie eine Auswahl</span>');
define('ENTRY_PASSWORD','Passwort (autom. erstellt)');
define('ENTRY_PASSWORD_ERROR','&nbsp;<span class="errorText">Ihr Passwort muss aus mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen bestehen.</span>');
define('ENTRY_MAIL_COMMENTS','Zus&auml;tzlicher eMailtext:');

define('ENTRY_MAIL','eMail mit Passwort an Kunden versenden?');
define('YES','ja');
define('NO','nein');
define('SAVE_ENTRY','Änderungen Speichern?');
define('TEXT_CHOOSE_INFO_TEMPLATE','HTML-Vorlage Artikeldetails:');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE','HTML-Vorlage Artikeloptionen:');
define('TEXT_SELECT','-- Bitte w&auml;hlen Sie --');

// Icons
define('ICON_CROSS', 'Falsch');
define('ICON_CURRENT_FOLDER', 'Aktueller Ordner');
define('ICON_DELETE', 'L&ouml;schen');
define('ICON_ERROR', 'Fehler');
define('ICON_FILE', 'Datei');
define('ICON_FILE_DOWNLOAD', 'Herunterladen');
define('ICON_FOLDER', 'Ordner');
define('ICON_LOCKED', 'Gesperrt');
define('ICON_PREVIOUS_LEVEL', 'Vorherige Ebene');
define('ICON_PREVIEW', 'Vorschau');
define('ICON_STATISTICS', 'Statistik');
define('ICON_SUCCESS', 'Erfolg');
define('ICON_TICK', 'Wahr');
define('ICON_UNLOCKED', 'Entsperrt');
define('ICON_WARNING', 'Warnung');
define('IMAGE_ICON_STATUS_GREEN_STOCK',' Produkte auf Lager');
define('IMAGE_ICON_STATUS_GREEN_STATUS','Produkt ist aktiv');
define('IMAGE_ICON_STATUS_GREEN_LIGHT_STATUS','Produkt aktivieren');
define('IMAGE_ICON_STATUS_RED','inaktiv');
define('IMAGE_ICON_STATUS_RED_STATUS','Produkt ist inaktiv');
define('IMAGE_ICON_STATUS_GREEN_LIGHT','aktivieren');
define('IMAGE_ICON_STATUS_RED_LIGHT_STATUS','Produkt deaktivieren');
define('IMAGE_ICON_STATUS_RED_LIGHT_STATUS_CP','Diese Kategrie und alle Produkte darin deaktivieren!');
define('IMAGE_ICON_STATUS_RED_LIGHT_CP','Diese Kategorie und alle Produkte darin aktivieren!');
define('IMAGE_ICON_STATUS_RED_LIGHT','Das Element deaktivieren!');
define('IMAGE_ICON_STATUS_GREEN','Das Element ist aktiv');
define('IMAGE_ICON_STATUS_GREEN_TOP','Produkt wird auf der Startseite angezeigt');
define('IMAGE_ICON_STATUS_GREEN_LIGHT_TOP','Produkt auf Startseite anzeigen');
define('IMAGE_ICON_STATUS_RED_TOP','Produkt wird nicht auf der Startseite angezeigt');
define('IMAGE_ICON_STATUS_RED_LIGHT_TOP','Produkt von der Startseite nehmen');
define('IMAGE_ICON_EDIT_PRODUCT','Produkt direkt bearbeiten');
define('IMAGE_ICON_EDIT','Element direkt bearbeiten');
define('IMAGE_ICON_EDIT_CATEGORY','Kategorie direkt bearbeiten');
define('IMAGE_ICON_ORDER_EDIT','Bestellung direkt bearbeiten');
define('IMAGE_ICON_ARROW',' dieses Produkt ist f&uuml;r die Bearbeitung ausgew&auml;hlt');
define('IMAGE_ICON_INFO','F&uuml;r die Bearbeitung ausw&auml;hlen');
define('IMAGE_ICON_DOWN','absteigend sortieren');
define('IMAGE_ICON_UP','aufsteigend sortieren');

define('HEADING_TITLE_ORDER', 'Bestell-Nr.');
define('HEADING_TITLE_PRODUKT','Produkt');
define('HEADING_TITLE_KUNDE','Kunde');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Seite %s von %d');
define('TEXT_DISPLAY_NUMBER_OF_BANNERS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Bannern)');
define('TEXT_DISPLAY_NUMBER_OF_COUNTRIES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> L&auml;ndern)');
define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Kunden)');
define('TEXT_DISPLAY_NUMBER_OF_CURRENCIES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> W&auml;hrungen)');
define('TEXT_DISPLAY_NUMBER_OF_LANGUAGES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Sprachen)');
define('TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Herstellern)');
define('TEXT_DISPLAY_NUMBER_OF_NEWSLETTERS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Rundschreiben)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', '<b>%d</b> bis <b>%d</b> von insgesamt <b>%d</b> Bestellungen');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS_STATUS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Bestellstatus)');
define('TEXT_DISPLAY_NUMBER_OF_XSELL_GROUP', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Cross-Marketing Gruppen)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_VPE', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Verpackungseinheiten)');
define('TEXT_DISPLAY_NUMBER_OF_SHIPPING_STATUS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Lieferstatus)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Artikeln)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_EXPECTED', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> erwarteten Artikeln)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Bewertungen)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Sonderangeboten)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_CLASSES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Steuerklassen)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_ZONES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Steuerzonen)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_RATES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Steuers&auml;tzen)');
define('TEXT_DISPLAY_NUMBER_OF_ZONES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Bundesl&auml;ndern)');
define('TEXT_DISPLAY_NUMBER_OF_KEYWORDS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Suchbegriffen)'); 

define('PREVNEXT_BUTTON_PREV', '&lt;&lt;');
define('PREVNEXT_BUTTON_NEXT', '&gt;&gt;');

define('TEXT_DEFAULT', 'Standard');
define('TEXT_SET_DEFAULT', 'als Standard definieren');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* Erforderlich</span>');

define('ERROR_NO_DEFAULT_CURRENCY_DEFINED', 'Fehler: Es wurde keine Standardw&auml;hrung definiert. Bitte definieren Sie unter Adminstration -> Sprachen/W&auml;hrungen -> W&auml;hrungen eine Standardw&auml;hrung.');

define('TEXT_CACHE_CATEGORIES', 'Kategorien Box');
define('TEXT_CACHE_MANUFACTURERS', 'Hersteller Box');
define('TEXT_CACHE_ALSO_PURCHASED', 'Ebenfalls gekauft Modul');
define('TEXT_LANGUAGE_ACTIVE','aktiviert');
define('TEXT_LANGUAGE_INACTIVE','deaktiviert');
define('TEXT_NONE', '--keine--');
define('TEXT_TOP', 'Top');

define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Fehler: Speicherort existiert nicht.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Fehler: Speicherort ist nicht beschreibbar.');
define('ERROR_FILE_NOT_SAVED', 'Fehler: Datei wurde nicht gespeichert.');
define('ERROR_FILETYPE_NOT_ALLOWED', 'Fehler: Dateityp ist nicht erlaubt.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Erfolg: Hochgeladene Datei wurde erfolgreich gespeichert.');
define('WARNING_NO_FILE_UPLOADED', 'Warnung: Es wurde keine Datei hochgeladen.');

define('DELETE_ENTRY','Eintrag l&ouml;schen?');
define('TEXT_PAYMENT_ERROR','<b>WARNUNG:</b><br />Bitte aktivieren Sie ein Zahlungsmodul! <a href="modules.php?set=payment">Zum Modul</a>');
define('TEXT_SHIPPING_ERROR','<b>WARNUNG:</b><br />Bitte aktivieren Sie ein Versandmodul! <a href="modules.php?set=shipping">Zum Modul</a>');
define('TEXT_NO_PRODUCTS_RETURNED', 'Keine Artikel gefunden');
define('TEXT_NETTO','Netto: ');

define('ENTRY_CID','Kundennummer:');
define('IP','Bestell IP:');
define('CUSTOMERS_MEMO','Memos:');
define('DISPLAY_MEMOS','Anzeigen/Schreiben');
define('TITLE_MEMO','Kunden MEMO');
define('ENTRY_LANGUAGE','Sprache:');
define('CATEGORIE_NOT_FOUND','Kategorie nicht vorhanden');

define('IMAGE_RELEASE', 'Gutschein einl&ouml;sen');

define('_JANUARY', 'Januar');
define('_FEBRUARY', 'Februar');
define('_MARCH', 'März');
define('_APRIL', 'April');
define('_MAY', 'Mai');
define('_JUNE', 'Juni');
define('_JULY', 'Juli');
define('_AUGUST', 'August');
define('_SEPTEMBER', 'September');
define('_OCTOBER', 'Oktober');
define('_NOVEMBER', 'November');
define('_DECEMBER', 'Dezember');

// Beschreibung f&uuml;r Abmeldelink im Newsletter
define('TEXT_NEWSLETTER_REMOVE', 'Um sich von unserem Newsletter abzumelden klicken Sie hier:');
define('TEXT_DISPLAY_NUMBER_OF_GIFT_VOUCHERS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Gutscheinen)');
define('TEXT_DISPLAY_NUMBER_OF_COUPONS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> ((von insgesamt <b>%d</b> Kupons)');
define('TEXT_VALID_PRODUCTS_LIST', 'Artikelliste');
define('TEXT_VALID_PRODUCTS_ID', 'Artikelnummer');
define('TEXT_VALID_PRODUCTS_NAME', 'Artikelname');
define('TEXT_VALID_PRODUCTS_MODEL', 'Artikelmodell');
define('TEXT_VALID_CATEGORIES_LIST', 'Kategorieliste');
define('TEXT_VALID_CATEGORIES_ID', 'Kategorienummer');
define('TEXT_VALID_CATEGORIES_NAME', 'Kategoriename');
define('SECURITY_CODE_LENGTH_TITLE', 'L&auml;nge des Gutscheincodes');
define('SECURITY_CODE_LENGTH_DESC', 'Geben Sie hier die L&auml;nge des Gutscheincode ein. (max. 16 Zeichen)');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_TITLE', 'Willkommens-Geschenk Gutschein Wert');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_DESC', 'Willkommens-Geschenk Gutschein Wert: Wenn Sie keinen Gutschein in Ihrer Willkommens-eMail versenden wollen, tragen Sie hier 0 ein, ansonsten geben Sie den Wert des Gutscheins an, zB. 10.00 oder 50.00, aber keine W&auml;hrungszeichen');
define('NEW_SIGNUP_DISCOUNT_COUPON_TITLE', 'Willkommens-Rabatt Kupon Code');
define('NEW_SIGNUP_DISCOUNT_COUPON_DESC', 'Willkommens-Rabatt Kupon Code: Wenn Sie keinen Kupon in Ihrer Willkommens-eMail versenden wollen, lassen Sie dieses Feld leer, ansonsten tragen Sie den Kupon Code ein, den Sie verwenden wollen');
define('TXT_ALL','Alle');

// UST ID
define('HEADING_TITLE_VAT','Ust-ID');
define('HEADING_TITLE_VAT','Ust-ID');
define('ENTRY_VAT_ID','Ust-ID:');
define('ENTRY_CUSTOMERS_VAT_ID', 'UstID:');
define('TEXT_VAT_FALSE','<span style="color:red">Gepr&uuml;ft/Falsch!</span>');
define('TEXT_VAT_TRUE','<span style="color:red">Gepr&uuml;ft/OK!</span>');
define('TEXT_VAT_UNKNOWN_COUNTRY','<span style="color:red">Nicht Gepr&uuml;ft/Land unbekannt!</span>');
define('TEXT_VAT_UNKNOWN_ALGORITHM','<span style="color:red">Nicht Gepr&uuml;ft/Keine &Uuml;berpr&uuml;fung m&ouml;glich!</span>');
define('ENTRY_VAT_ID_ERROR', '<span style="color:red">* Die Eingegebene UST ID Nummer ist Falsch oder kann derzeit nicht gepr&uuml;ft werden!</span>');

define('ERROR_GIF_MERGE','Fehlender GDlib Gif Support, kein Wasserzeichen (Merge) m&ouml;glich');
define('ERROR_GIF_UPLOAD','Fehlender GDlib Gif Support, kein Upload von GIF Bildern m&ouml;glich');

define('TEXT_REFERER','Referer: ');

define('BOX_PAYPAL','PayPal Transaktionen');
define('BOX_CUSTOMERS_SIK','gel&ouml;schte Kunden');

/*AJAX Staffelpreise*/
define('STAFFEL_GROUP_BASE_PRICE','Grundpreis:');
define('STAFFEL_QUANTITY','Menge:');
define('STAFFEL_NETTO','netto');
define('STAFFEL_BRUTTO','brutto');
define('STAFFEL_PRICE','Preis:');
define('STAFFEL_SAVE','Speichern');
define('STAFFEL_EDIT','Bearbeiten');
define('STAFFEL_CANCEL','Abbrechen');
define('STAFFEL_NEW','Neu');
define('STAFFEL_DELETE','L&ouml;schen');
define('STAFFEL_ADD','Hinzuf&uuml;gen');
define('STAFFEL_TITLE','Staffelpreise');
define('STAFFEL_ERROR_MESSAGE_1','Sie m&uuml;ssen zun&auml;chst einen Grundwert eingeben und<br /> abspeichern bevor Sie einen Staffelpreis eingeben m&ouml;chten!');
define('STAFFEL_ERROR_MESSAGE_2','erfolgreich gespeichert!');
define('STAFFEL_ERROR_MESSAGE_3','Eintrag schon vorhanden!');
define('STAFFEL_ERROR_MESSAGE_4','Mindestens ein Feld ist leer geblieben!');
define('STAFFEL_ERROR_MESSAGE_5','Staffelpreiseintrag nicht vorhanden!');
define('STAFFEL_ERROR_MESSAGE_6','Staffelpreiseintrag erfolgreich gel&ouml;scht!');
define('STAFFEL_ERROR_MESSAGE_7','Staffelpreiseintrag nicht vorhanden!');
define('STAFFEL_ERROR_MESSAGE_8','Erfolgreich ge&auml;ndert!');
define('STAFFEL_ERROR_MESSAGE_9_0','<br />Das Profil ');
define('STAFFEL_ERROR_MESSAGE_9_1',' wurde erfolgreich gespeichert!');
define('STAFFEL_ERROR_MESSAGE_10_0','<br />Der gew&auml;hlte Profilname ');
define('STAFFEL_ERROR_MESSAGE_10_1',' existiert leider schon.<br />Bitte w&auml;hlen Sie einen anderen Namen!');
define('STAFFEL_ERROR_MESSAGE_11','Bitte w&auml;hlen Sie ein Profil aus!');
define('STAFFEL_ERROR_MESSAGE_12_0','<br />Der Profilname wurde erfolgreich in ');
define('STAFFEL_ERROR_MESSAGE_12_1',' ge&auml;ndert!');
define('STAFFEL_ERROR_MESSAGE_13','<br />Die Staffelpreise wurden erfolgreich &uuml;bertragen!');
define('STAFFEL_ERROR_MESSAGE_14','Folgende Staffelpreise werden nach Best&auml;tigung eingetragen. <span style="color: red">Achtung: Alle bisherigen Staffelpreise dieser Kundengruppe werden &uuml;berschrieben!</span>');
define('STAFFEL_ERROR_MESSAGE_15','<br />M&ouml;chten Sie die Staffelpreise &uuml;bernehmen? ');
define('STAFFEL_ERROR_MESSAGE_16','<br />Das Profil wurde erfolgreich gel&ouml;scht!');
define('PROFILE_WILL_LOAD','Das selektierte Profil wird geladen.');
define('PROFILE_WILL_SAVE','Die angezeigten Staffelpreise werden als neues Profil gespeichert.');
define('PROFILE_WILL_RENAME','Das selektierte Profil wird umbenannt.');
define('PROFILE_WILL_DELETE','Das selektierte Profil wird gel&ouml;scht.');
define('PROFILE_SELECT','Bitte w&auml;hlen Sie ein Profil aus!');
define('PROFILE_CONFIRM','&Uuml;bernehmen');
define('PROFILE_NAME','<span style="color: red">Bitte geben Sie einen Namen für das zu speichernde Profil an!</span> ');
define('PROFILE_NEW_NAME','<span class="clear" style="color: red">Bitte geben Sie einen neuen Namen für das gespeicherte Profil an:</span> ');
/*AJAX Staffelpreise*/


define('BOX_REPORTS_RECOVER_CART_SALES', 'Wiederhergestellte Warenk&ouml;rbe');
define('BOX_TOOLS_RECOVER_CART', 'Offene Warenk&ouml;rbe');
define('TAX_ADD_TAX','inkl. ');
define('TAX_NO_TAX','zzgl. ');
define('BOX_BACKLINK','Backlinkcheck');
define('BOX_HEADING_XSBOOSTER','xs:booster');
define('BOX_XSBOOSTER_LISTAUCTIONS','Auktionen anzeigen');
define('BOX_XSBOOSTER_ADDAUCTIONS','Auktionen erstellen');
define('BOX_XSBOOSTER_CONFIG','Grundkonfiguration');
define('BOX_PDFBILL_CONFIG', 'PDF - Konfig.');                 // pdfrechnung
define('ENTRY_BILLING', 'Rechnungsnummer:');       // pdfrechnung

// PayPal Express
define('BOX_PAYPAL','PayPal');
define('NO_BLOG_ENTRIES', 'Derzeit sind noch keine Blogbeitr&auml;ge zu dieser Kategorie vorhanden.');

#New in V2.1
define('PRODUCTS', 'Produkte');
define('CUSTOMERS', 'Kunden');
define('MODULES', 'Module');
define('STATISTIK', 'Statistik');
define('TOOLS', 'Hilfsprogramme');
define('GIFT', 'Gutscheinsystem');
define('COUNRTY', 'Land/Steuern');
define('CONFIG', 'Konfiguration');

define('BOX_PRODUCT_FILTER', 'Produkt Filter');

define('BOX_MODULE_ORDER_PRODUCTS','Bestellung-Artikel');
define('BOX_MODULE_NEWSLETTER_PRODUCTS','Newsletter-Artikel');
define('BOX_MODULE_NEWSLETTER','Newsletter');
define('BOX_MODULE_BLOG','Blog');
define('BOX_MODULE_DEL_CACHE','Cache leeren');
define('BOX_PRODUCTS_PRICE_CHANGE','Lagerbestände');
define('BOX_GLOBAL_PRODUCTS_PRICE_CHANGE','Preisänderung');
define('BOX_LOGINBOX_DISCOUNT','Artikelrabatt');
define('YOUR_PRICE','Ihr Preis ');
define('FROM','Ab ');
define('FROM','Ab');
define('SINGLE_PRICE','Einzelpreis ');
define('YOU_SAVE','Sie sparen rund ');
define('INSTEAD','bisheriger Preis ');
define('ONLY','jetzt nur ');
define('HEAD_CONFIGURATION','Grundeinstellung');
define('HEAD_FILTER','Filter');
define('HEAD_DESCRIPTION','Beschreibung');
define('HEAD_IMAGES','Bilder');
define('HEAD_ATTRIB','Attribute');
define('HEAD_ACCESS','Zubehör');

define('BOX_ACCESSORIES','Zubeh&ouml;r Manager');


define('PDF_BILL','Rechnung');
define('PDF_INVOICE','Lieferschein');
define('PDF_DELETE','Rechnung l&ouml;schen?');
define('PDF_HEAD','PDF Rechnung + Lieferschein');
define('PDF_ONSERVER','PDF liegt auf dem Server:');
define('PDF_SHOW','PDF Rechnung anzeigen');
define('PDF_REGENERATE','Die Rechnung noch einmal generieren?');
define('PDF_INVOICE_RENEGERATE','Lieferschein erstellen?');
define('PDF_BILL_NR','Rechnungs-Nr:');
define('PDF_BILL_NEXT_NR','n&auml;chste Rech-Nr:');
define('PDF_ACTION','gew&auml;hlte PDF-Aktion durchf&uuml;hren');
define('PDF_BILL_STEP1','Die PDF Rechnung wurde am');
define('PDF_BILL_STEP2','verschickt<br />Nochmal versenden?');
define('PDF_BILL_STEP3','Die PDF Rechnung per Email verschicken?');

define('BOX_REMOVEOLDPICS','Alte Bilder löschen');
define('BOX_CSEO_LANGUAGE_BUTTON','Button Sprache');


define('BOX_CONFIGURATION_CSEO','Grundkonfiguration');
define('BOX_CONFIGURATION_CSS_STYLER','CSS-Button-Manager');
define('BOX_CONFIGURATION_PDF_CONF','PDF-WAWI-Einstellung');
define('BOX_CONFIGURATION_PRODUCT_LISTING','Produkt Listen-Einstellung');
define('BOX_CONFIGURATION_BOX_MANAGER','Boxen Manager');
define('BOX_CONFIGURATION_NEWS_TICKER','News Ticker');
define('BOX_CONFIGURATION_TRUSTED_SHOPS','Trusted Shops');
define('BOX_CONFIGURATION_JANOLAW','Janolaw-Einstellung');
define('BOX_CONFIGURATION_PERSONAL_LINKS','Personal Links');
define('BOX_CONFIGURATION_EMAILS_TEMPLATE','Email Vorlagen');

define('BOX_CONFIGURATION_1', 'Mein Shop');
define('BOX_CONFIGURATION_2', 'Minimum Werte');
define('BOX_CONFIGURATION_3', 'Maximum Werte');
define('BOX_CONFIGURATION_4', 'Bild Optionen');
define('BOX_CONFIGURATION_5', 'Kunden Details');
define('BOX_CONFIGURATION_6', 'Modul Optionen');
define('BOX_CONFIGURATION_7', 'Versand Optionen');
define('BOX_CONFIGURATION_8', 'Artikel Listen Optionen');
define('BOX_CONFIGURATION_9', 'Lagerverwaltungs Optionen');
define('BOX_CONFIGURATION_10', 'Logging Optionen');
define('BOX_CONFIGURATION_11', 'Cache Optionen');
define('BOX_CONFIGURATION_12', 'Email Optionen');
define('BOX_CONFIGURATION_13', 'Download Optionen');
define('BOX_CONFIGURATION_14', 'Gzip Kompression');
define('BOX_CONFIGURATION_15', 'Sessions');
define('BOX_CONFIGURATION_16', 'Meta-Tags / Suchmaschinen');
define('BOX_CONFIGURATION_17', 'Zusatzmodule');
define('BOX_CONFIGURATION_18', 'UST ID');
define('BOX_CONFIGURATION_19', 'Partner');
define('BOX_CONFIGURATION_22', 'Such-Optionen');
define('BOX_CONFIGURATION_25', 'PayPal Express');
define('BOX_CONFIGURATION_33', 'Offene Warenk&ouml;rbe');
define('BOX_CONFIGURATION_333', 'Bestellprozess');
define('BOX_CONFIGURATION_360', 'Mail Anhaenge');
define('BOX_CONFIGURATION_361','Google Analytics');
define('BOX_CONFIGURATION_362','eTracker');
define('BOX_CONFIGURATION_363','Sicherheitseinstellungen');
define('BOX_CONFIGURATION_1000','Tags / Ajax - Einstellung');
define('BOX_CONFIGURATION_1001','Twitter Box');
define('BOX_CONFIGURATION_1002','Produkt-Einstellung');
define('BOX_CONFIGURATION_M_25','<b>Externe Anbieter</b>');


define('BOX_CSEO_IDS','Nummernkreise');
define('BOX_CSEO_ANTISPAM','Antispam-Einstellung');
define('BOX_BEWERTUNGENV','ShopVoting-Verwaltung');
define('BOX_BEWERTUNGENC','ShopVoting-Konfiguration');

#v2.4 NEW
define('UPDATE_TITLE','Aktualisierung erfolgreich');
define('UPDATE_TEXT','Die Aktualisierung wurde erfolgreich ausgeführt.');


//accessories

define('HEADING_TITLE_ACCESSORIES','Zubehör Manager');
define('CONTENT_NOTE','<p>Mit diesem Modul erstellen Sie eine Zubehör-Liste zu jedem Artikel Ihrer Produktpalette.</p>');

define('STEP_1','Hauptartikel festlegen!');
define('STEP_1a','Feld leer lassen für Auswahl aus Gesamtliste!');
define('STEP_2','Zubehör-Artikel suchen!');
define('STEP_2a','Zubehör-Artikel festlegen!');
define('SEARCH','Suchen');
define('INPUT_PRODUCT','Hinzufügen');

define('NAME','Artikel');
define('PICTURE','Bild');
define('MODEL','Art-Nr.');
define('MAIN_ITEM','Hauptartikel');
define('ACCESSORIES','Zubehör');
define('ACTION','Aktion');

define('ACTION_EDIT','Bearbeiten');
define('ACTION_DEL','Löschen');

define('ACCESSORIES_OVERVIEW','Übersicht');
define('ACCESSORIES_NEW','Neue Zubehör-Liste');

define('INPUT_DEL_ACCPRODUCT','Markierte Artikeln löschen');

//backup
define('HEADING_TITLE_BACKUP', 'Datenbanksicherung'); 
define('TABLE_HEADING_TITLE', 'Titel');
define('TABLE_HEADING_FILE_DATE', 'Datum');
define('TABLE_HEADING_FILE_SIZE', 'Gr&ouml;sse');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TEXT_INFO_HEADING_NEW_BACKUP', 'Neue Sicherung');
define('TEXT_INFO_HEADING_RESTORE_LOCAL', 'Lokal wiederherstellen');
define('TEXT_INFO_NEW_BACKUP', 'Bitte den Sicherungsprozess AUF KEINEN FALL unterbrechen. Dieser kann einige Minuten in Anspruch nehmen.');
define('TEXT_INFO_UNPACK', '<br /><br />(nach dem die Dateien aus dem Archiv extrahiert wurden)');
define('TEXT_INFO_RESTORE', 'Den Wiederherstellungsprozess AUF KEINEN FALL unterbrechen.<br /><br />Je gr&ouml;sser die Sicherungsdatei - desto l&auml;nger dauert die Wiederherstellung!<br /><br />Bitte wenn m&ouml;glich den mysql client benutzen.<br /><br />Beispiel:<br /><br /><b>mysql -h' . DB_SERVER . ' -u' . DB_SERVER_USERNAME . ' -p ' . DB_DATABASE . ' < %s </b> %s');
define('TEXT_INFO_RESTORE_LOCAL', 'Den Wiederherstellungsprozess AUF KEINEN FALL unterbrechen.<br /><br />Je gr&ouml;sser die Sicherungsdatei - desto l&auml;nger dauert die Wiederherstellung!');
define('TEXT_INFO_RESTORE_LOCAL_RAW_FILE', 'Die Datei, welche hochgeladen wird muss eine sog. raw sql Datei sein (nur Text).');
define('TEXT_INFO_DATE', 'Datum:');
define('TEXT_INFO_SIZE', 'Gr&ouml;sse:');
define('TEXT_INFO_COMPRESSION', 'Komprimieren:');
define('TEXT_INFO_USE_GZIP', 'Mit GZIP');
define('TEXT_INFO_USE_ZIP', 'Mit ZIP');
define('TEXT_INFO_USE_NO_COMPRESSION', 'Keine Komprimierung (Raw SQL)');
define('TEXT_INFO_DOWNLOAD_ONLY', 'Nur herunterladen (nicht auf dem Server speichern)');
define('TEXT_INFO_BEST_THROUGH_HTTPS', 'Sichere HTTPS Verbindung verwenden!');
define('TEXT_NO_EXTENSION', 'Keine');
define('TEXT_BACKUP_DIRECTORY', 'Sicherungsverzeichnis:');
define('TEXT_LAST_RESTORATION', 'Letzte Wiederherstellung:');
define('TEXT_FORGET', '(<u>vergessen</u>)');
define('TEXT_DELETE_INTRO', 'Sind Sie sicher, dass Sie diese Sicherung l&ouml;schen m&ouml;chten?');
define('ERROR_BACKUP_DIRECTORY_DOES_NOT_EXIST', 'Fehler: Das Sicherungsverzeichnis ist nicht vorhanden.');
define('ERROR_BACKUP_DIRECTORY_NOT_WRITEABLE', 'Fehler: Das Sicherungsverzeichnis ist schreibgesch&uuml;tzt.');
define('ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE', 'Fehler: Download Link nicht akzeptabel.');
define('SUCCESS_LAST_RESTORE_CLEARED', 'Erfolg: Das letzte Wiederherstellungdatum wurde gel&ouml;scht.');
define('SUCCESS_DATABASE_SAVED', 'Erfolg: Die Datenbank wurde gesichert.');
define('SUCCESS_DATABASE_RESTORED', 'Erfolg: Die Datenbank wurde wiederhergestellt.');
define('SUCCESS_BACKUP_DELETED', 'Erfolg: Die Sicherungsdatei wurde gel&ouml;scht.');
define('TEXT_COMPLETE_INSERTS', "<b>Vollst&auml;ndige 'INSERT's</b><br> - Feldnamen werden in jede INSERT-Zeile eingetragen (vergr&ouml;ssert das Backup)");
define('TEXT_INFO_DO_BACKUP', 'Die Datenbank Sicherung wird erstellt!');
define('TEXT_INFO_DO_BACKUP_OK', 'Die Datenbank Sicherung wurde erstellt!');
define('TEXT_INFO_DO_GZIP', 'Die Backupdatei wird gepackt!');
define('TEXT_INFO_WAIT', 'Bitte warten!');
define('TEXT_INFO_DO_RESTORE', 'Die Datenbank wird wiederhergestellt!');
define('TEXT_INFO_DO_RESTORE_OK', 'Die Datenbank wurde wiederhergestellt!');
define('TEXT_INFO_DO_GUNZIP', 'Die Backupdatei wird entpackt!');
define('ERROR_BACKUP_DIRECTORY_DOES_NOT_EXIST', 'Fehler: das Verzeichnis f&uuml;r die Sicherung existiert nicht. Bitte beheben Sie den Fehler in Ihrer configure.php.');
define('ERROR_BACKUP_DIRECTORY_NOT_WRITEABLE', 'Fehler: In das Verzeichnis f&uuml;r die Sicherung kann nicht geschrieben werden.');
define('ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE', 'Fehler: Der Download Link ist nicht akzeptabel.');
define('ERROR_DECOMPRESSOR_NOT_AVAILABLE', 'Fehler: Kein geeigneter Entpacker verf&uuml;gbar.');
define('ERROR_UNKNOWN_FILE_TYPE', 'Fehler: unbekannter Dateityp.');
define('ERROR_RESTORE_FAILES', 'Fehler: Wiederherstellung gescheitert.');
define('ERROR_DATABASE_SAVED', 'Fehler: Die Datenbank konnte nicht gesichert werden.');
define('ERROR_TEXT_PATH', 'Fehler: Der Pfad zu mysqldump wurde nicht gefunden oder angegeben!');
define('SUCCESS_LAST_RESTORE_CLEARED', 'Erfolgreich: Das letzte Wiederherstellungsdatum wurde gel&ouml;scht.');
define('SUCCESS_DATABASE_SAVED', 'Erfolgreich: Die Datenbank wurde gesichert.');
define('SUCCESS_DATABASE_RESTORED', 'Erfolgreich: Die Datenbank wurde wiederhergestellt.');
define('SUCCESS_BACKUP_DELETED', 'Erfolgreich: Die Sicherung wurde entfernt.');
define('TEXT_BACKUP_UNCOMPRESSED', 'Die Backupdatei wurde entpackt: ');
define('TEXT_SIMULATION', '<br>(Simulation mit log-Datei)');

//banner_manager
define('HEADING_TITLE_BANNER_MANAGER', 'Banner Manager');
define('TABLE_HEADING_BANNERS', 'Banner');
define('TABLE_HEADING_GROUPS', 'Gruppe');
define('TABLE_HEADING_STATISTICS', 'Anzeigen / Klicks');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TEXT_BANNERS_TITLE', 'Titel des Banners:'); 
define('TEXT_BANNERS_URL', 'Banner-URL:'); 
define('TEXT_BANNERS_GROUP', 'Banner-Gruppe:'); 
define('TEXT_BANNERS_NEW_GROUP', ', oder geben Sie unten eine neue Banner-Gruppe ein'); 
define('TEXT_BANNERS_IMAGE', 'Bild (Datei):'); 
define('TEXT_BANNERS_IMAGE_LOCAL', ', oder geben Sie unten die lokale Datei auf Ihrem Server an'); 
define('TEXT_BANNERS_IMAGE_TARGET', 'Bildziel (Speichern nach):'); 
define('TEXT_BANNERS_HTML_TEXT', 'HTML Text:');
define('TEXT_BANNERS_EXPIRES_ON', 'G&uuml;ltigkeit bis:');
define('TEXT_BANNERS_OR_AT', ', oder bei');
define('TEXT_BANNERS_IMPRESSIONS', 'Impressionen/Anzeigen.');
define('TEXT_BANNERS_SCHEDULED_AT', 'G&uuml;ltigkeit ab:');
define('TEXT_BANNERS_BANNER_NOTE', '<b>Banner Bemerkung:</b><ul><li>Sie k&ouml;nnen Bild- oder HTML-Text-Banner verwenden, beides gleichzeitig ist nicht m&ouml;glich.</li><li>Wenn Sie beide Bannerarten gleichzeitig verwenden, wird nur der HTML-Text Banner angezeigt.</li></ul>');
define('TEXT_BANNERS_INSERT_NOTE', '<b>Bemerkung:</b><ul><li>Auf das Bildverzeichnis muss ein Schreibrecht bestehen!</li><li>F&uuml;llen Sie das Feld \'Bildziel (Speichern nach)\' nicht aus, wenn Sie kein Bild auf Ihren Server kopieren m&ouml;chten (z.B. wenn sich das Bild bereits auf dem Server befindet).</li><li>Das \'Bildziel (Speichern nach)\' Feld muss ein bereits existierendes Verzeichnis mit \'/\' am Ende sein (z.B. banners/).</li></ul>'); 
define('TEXT_BANNERS_EXPIRCY_NOTE', '<b>G&uuml;ltigkeit Bemerkung:</b><ul><li>Nur ein Feld ausf&uuml;llen!</li><li>Wenn der Banner unbegrenzt angezeigt werden soll, tragen Sie in diesen Feldern nichts ein.</li></ul>');
define('TEXT_BANNERS_SCHEDULE_NOTE', '<b>G&uuml;ltigkeit ab Bemerkung:</b><ul><li>Bei Verwendung dieser Funktion, wird der Banner erst ab dem angegeben Datum angezeigt.</li><li>Alle Banner mit dieser Funktion werden bis ihrer Aktivierung, als Deaktiviert angezeigt.</li></ul>');
define('TEXT_BANNERS_DATE_ADDED', 'hinzugef&uuml;gt am:');
define('TEXT_BANNERS_SCHEDULED_AT_DATE', 'G&uuml;ltigkeit ab: <b>%s</b>');
define('TEXT_BANNERS_EXPIRES_AT_DATE', 'G&uuml;ltigkeit bis zum: <b>%s</b>');
define('TEXT_BANNERS_EXPIRES_AT_IMPRESSIONS', 'G&uuml;ltigkeit bis: <b>%s</b> impressionen/anzeigen');
define('TEXT_BANNERS_STATUS_CHANGE', 'Status ge&auml;ndert: %s');
define('TEXT_BANNERS_DATA', 'D<br />A<br />T<br />E<br />N');
define('TEXT_BANNERS_LAST_3_DAYS', 'letzten 3 Tage');
define('TEXT_BANNERS_BANNER_VIEWS', 'Banneranzeigen');
define('TEXT_BANNERS_BANNER_CLICKS', 'Bannerklicks');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie diesen Banner l&ouml;schen m&ouml;chten?');
define('TEXT_INFO_DELETE_IMAGE', 'Bannerbild l&ouml;schen');
define('SUCCESS_BANNER_INSERTED', 'Erfolg: Der Banner wurde eingef&uuml;gt.');
define('SUCCESS_BANNER_UPDATED', 'Erfolg: Der Banner wurde aktualisiert.');
define('SUCCESS_BANNER_REMOVED', 'Erfolg: Der Banner wurde gel&ouml;scht.');
define('SUCCESS_BANNER_STATUS_UPDATED', 'Erfolg: Der Status des Banners wurde aktualisiert.');
define('ERROR_BANNER_TITLE_REQUIRED', 'Fehler: Ein Bannertitel wird ben&ouml;tigt.');
define('ERROR_BANNER_GROUP_REQUIRED', 'Fehler: Eine Bannergruppe wird ben&ouml;tigt.');
define('ERROR_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Fehler: Das Zielverzeichnis %s existiert nicht.');
define('ERROR_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Fehler: Das Zielverzeichnis %s ist nicht beschreibbar.');
define('ERROR_IMAGE_DOES_NOT_EXIST', 'Fehler: Bild existiert nicht.');
define('ERROR_IMAGE_IS_NOT_WRITEABLE', 'Fehler: Bild kann nicht gel&ouml;scht werden.');
define('ERROR_UNKNOWN_STATUS_FLAG', 'Fehler: Unbekanntes Status Flag.');
define('ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST', 'Fehler: Das Verzeichnis \'graphs\' ist nicht vorhanden! Bitte erstellen Sie ein Verzeichnis \'graphs\' im Verzeichnis \'images\'.');
define('ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE', 'Fehler: Das Verzeichnis \'graphs\' ist schreibgesch&uuml;tzt!');

//banner_statistics
define('HEADING_TITLE_BANNER_STATISTICS', 'Bannerstatistik');
define('TABLE_HEADING_SOURCE', 'Grundlage');
define('TABLE_HEADING_VIEWS', 'Anzeigen');
define('TABLE_HEADING_CLICKS', 'Klicks');
define('TEXT_BANNERS_DAILY_STATISTICS', '%s Tagesstatistik fuer %s %s');
define('TEXT_BANNERS_MONTHLY_STATISTICS', '%s Monatsstatistik fuer %s');
define('TEXT_BANNERS_YEARLY_STATISTICS', '%s Jahresstatistik');
define('STATISTICS_TYPE_DAILY', 't&auml;glich');
define('STATISTICS_TYPE_MONTHLY', 'monatlich');
define('STATISTICS_TYPE_YEARLY', 'j&auml;hrlich');
define('TITLE_TYPE', 'Typ:');
define('TITLE_YEAR', 'Jahr:');
define('TITLE_MONTH', 'Monat:');

//blog
define('HEADING_TITLE_BLOG','Blog');
define('TABLE_HEADING_NAVIGATION','Navigation:');
define('TABLE_HEADING_BLOG_TOPIC','Seiten: ');
define('TABLE_HEADING_BLOG_TOPIC_OFF','davon Offline: ');
define('TABLE_HEADING_NAVIGATION_OVERVIEW','Übersicht');
define('TABLE_HEADING_NAVIGATION_NEWCATEGORIE','Neue Kategorie');
define('TABLE_HEADING_NEWCATEGORIE_STATUS','Status');
define('TABLE_HEADING_NAVIGATION_NEWITEM','Neuer Blog Eintrag');
define('TABLE_HEADING_NAVIGATION_STARTSITE','Startseite bearbeiten');
define('TABLE_HEADING_NAVIGATION_SETTINGS','Einstellungen');
define('VALUE_YES', 'ja');
define('VALUE_NO', 'nein');
define('VALUE_SEND', 'Absenden');
define('SAVE_SUCCESS', '<span style="color:#ff0000;font-weight:700">Deine Einstellungen wurden gespeichert.</span><br /><br />');
define('SOCIAL_TITLE', 'Social Bookmarks');
define('SOCIAL_DESC', 'Sollen &uuml;ber dem Artikel Sociallinks angezeigt werden, die den Betrag beim entsprechenden Dienst verlinken?');
define('REGISTER_USER_TITLE','Kunde');
define('REGISTER_USER_DESC','D&uuml;rfen nur registrierte Kunden eine Bewertung abgeben?');
define('COMMENTS_TITLE', 'Kommentare');
define('COMMENTS_DESC', 'Geben Sie dem Kunden die M&ouml;glichkeit zu Ihrem Beitrag eine Meinung zu schreiben.<br />Sind Sie als eingeloggter Admin im Blog, k&ouml;nnen Sie einzelne Kommentare l&ouml;schen');
define('BLOG_CAPTCHA_TITLE','Captcha');
define('BLOG_CAPTCHA_DESC','Soll eine Captcha-Abfrage bei Kommentaren eingef&uuml;gt werden?');
define('RATE_TITLE', 'Bewertung');
define('RATE_DESC', 'D&uuml;rfen Kunden Ihren Beitrag bewerten?');
define('SESSION_RATE_TITLE', 'Session Sperre');
define('SESSION_RATE_DESC', 'D&uuml;rfen Kunden nur eine Bewertung pro Beitrag in einer Session abgeben?');
define('BLOG_NAV_AJAX_TITLE','Animiertes Blog Men&uuml;');
define('BLOG_NAV_AJAX_DESC','M&ouml;chten Sie ein animiertes Men&uuml; anzeigen lassen? Das geschieht mittels Java Effekt.<br /><br />Bei &quot;NEIN&quot; werden die Kategorien zu Links und erzeugen eine &Uuml;bersichtsseite aller Beitr&auml;ge innerhalb dieser Kategorie.');
define('NO_BLOG_ENTRIES', 'Derzeit sind noch keine Blogbeitr&auml;ge zu dieser Kategorie vorhanden.');
define('NO_BLOG_COMMENTS', 'Derzeit sind noch keine Kommentare zu diesem Beitrag vorhanden.');
define('TABLE_HEADING_EDIT_ALL','Alle Titeln bearbeiten');
define('TABLE_HEADING_TITLE','Kategorien');
define('TABLE_HEADING_DESC','Content');
define('TABLE_HEADING_ACTION','Aktion');
define('TABLE_HEADING_ACTION_EDIT_0','---');
define('TABLE_HEADING_ACTION_EDIT','Bearbeiten');
define('TABLE_HEADING_ACTION_NEWITEM','Neu');
define('TABLE_FOOTER_STATUS','Status: ');	
define('TABLE_FOOTER_STATUS_0','---');	
define('TABLE_FOOTER_STATUS_1','Offline');
define('TABLE_FOOTER_STATUS_2','Online');	
define('TABLE_FOOTER_STATUS_3','Löschen');	
define('UPDATE_ENTRY','Aktualisieren?');	
define('UPDATE_SAVE','Speichern');
define('CHOOSE_CATEGORIE','Wählen Sie eine Kategorie!');
define('TABLE_HEADING_NEWCATEGORIE_NAME','Bezeichung');	
define('TABLE_HEADING_NEWCATEGORIE_POSITION','Position');	
define('TABLE_HEADING_NEWITEM_NAME','Überschrift');	
define('TABLE_HEADING_NEWITEM_TITLE','Titel für die Box');
define('TABLE_HEADING_NEWITEM_LENGHT','Nach wie vielen Zeichen soll in der Übersicht abgeschnitten werden?');
define('TABLE_HEADING_META_TITLE', 'Meta - Titel');	
define('TABLE_HEADING_META_DESCRIPTION', 'Meta - Description');
define('TABLE_HEADING_META_KEYWORDS', 'Meta - Keywords');
define('TABLE_HEADING_CATEGORY', 'Kategorie:');
define('TABLE_HEADING_DEFAULT', 'Grundeinstellungen');
define('TABLE_HEADING_BACK', 'zur Übersicht');
define('TABLE_HEADING_TITLE_TAB', 'Titel');
define('TABLE_HEADING_BLOG_ITEMS', '<br />Blog Beiträge Übersicht:<br />');

//campaigns
define('HEADING_TITLE_CAMPAIGNS', 'Kampagnenverfolgung');
define('TABLE_HEADING_CAMPAIGNS', 'Kampagnen');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TEXT_HEADING_NEW_CAMPAIGN', 'Neue Kampagne');
define('TEXT_HEADING_EDIT_CAMPAIGN', 'Kampagne bearbeiten');
define('TEXT_HEADING_DELETE_CAMPAIGN', 'Kampagne l&ouml;schen');
define('TEXT_CAMPAIGNS', 'Kampagnen:');
define('TEXT_DATE_ADDED', 'hinzugef&uuml;gt am:');
define('TEXT_LAST_MODIFIED', 'letzte &Auml;nderung am:');
define('TEXT_LEADS', 'Leads:');
define('TEXT_SALES', 'Sales:');
define('TEXT_LATE_CONVERSIONS', 'Late Conversions:');
define('TEXT_NEW_INTRO', 'Bitte geben Sie eine neue Kampagne ein.');
define('TEXT_EDIT_INTRO', 'Bitte f&uuml;hren Sie alle notwendigen &Auml;nderungen durch');
define('TEXT_CAMPAIGNS_NAME', 'Kampagnenname:');
define('TEXT_CAMPAIGNS_REFID', 'RefID der Kampagne:');
define('TEXT_DISPLAY_NUMBER_OF_CAMPAIGNS', 'Verfolgte Kampagnen:');
define('TEXT_DELETE_INTRO', 'Sind Sie sicher, dass Sie diese Kampagne l&ouml;schen m&ouml;chten?');

//categories
define('HEADING_TITLE_CATEGORIES', 'Kategorien / Artikel');
define('TEXT_EDIT_STATUS', 'Kategorie aktivieren?');
define('HEADING_BASE', 'Grundeinstellung');
define('HEADING_IMAGE', 'Kategorie Bild');
define('HEADING_IMAGE_NAV_SEARCH', 'Kategorie-Navigation Bild (Optimal: PNG 25x25 px) suchen:');
define('HEADING_IMAGE_FOOTER_SEARCH', 'Kategorie Bild Footer suchen:');
define('HEADING_IMAGE_FOOTER_SEARCH', 'Kategorie Bild Footer');
define('HEADING_IMAGE_SEARCH', 'Bild suchen:');
define('HEADING_IMAGE_ALT', 'Alternativtext:');
define('HEADING_TITLE_SEARCH', 'Suche: ');
define('HEADING_TITLE_GOTO', 'Gehe zu:');
define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Kategorien / Artikel');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_STARTPAGE', 'Top');
define('TABLE_HEADING_STOCK','Lager');
define('TABLE_HEADING_SORT','Sort.');
define('TABLE_HEADING_EDIT','Edit');
define('TEXT_ACTIVE_ELEMENT','Aktives Element');
define('TEXT_MARKED_ELEMENTS','Markierte Elemente');
define('TEXT_INFORMATIONS','Informationen');
define('TEXT_INSERT_ELEMENT','Neues Element');
define('TEXT_WARN_MAIN','Haupt');
define('TEXT_NEW_PRODUCT', 'Neuer Artikel in &quot;%s&quot;');
define('TEXT_CATEGORIES', 'Kategorien:');
define('TEXT_PRODUCTS', 'Produkte:');
define('TEXT_PRODUCTS_PRICE_INFO', 'Preis:');
define('TEXT_PRODUCTS_TAX_CLASS', 'Steuerklasse:');
define('TEXT_PRODUCTS_EXTRA_SHIPPING', 'Versandkostenaufschlag:');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'Durchschn. Bewertung:');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Anzahl:');
define('TEXT_PRODUCTS_QUANTITY_MAX','max. Anzahl im Lager:');
define('TEXT_PRODUCTS_DISCOUNT_ALLOWED_INFO', 'Maximal erlaubter Rabatt:');
define('TEXT_DATE_ADDED', 'Hinzugef&uuml;gt am:');
define('TEXT_DATE_AVAILABLE', 'Erscheinungsdatum:');
define('TEXT_LAST_MODIFIED', 'Letzte &Auml;nderung:');
define('TEXT_PRODUCTS_MODEL', 'Artikel Nummer:');
define('TEXT_IMAGE_NONEXISTENT', 'Bild existiert nicht');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Bitte f&uuml;gen Sie eine neue Kategorie oder einen Artikel in <strong>%s</strong> ein.');
define('TEXT_PRODUCT_MORE_INFORMATION', 'F&uuml;r weitere Informationen, besuchen Sie bitte die <a href="http://%s" target="blank"><u>Homepage</u></a> des Herstellers.');
define('TEXT_PRODUCT_DATE_ADDED', 'Diesen Artikel haben wir am %s in unseren Katalog aufgenommen.');
define('TEXT_PRODUCT_DATE_AVAILABLE', 'Dieser Artikel ist erh&auml;ltlich ab %s.');
define('TEXT_CHOOSE_INFO_TEMPLATE', 'Artikel-Info Vorlage:');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE', 'Artikel-Optionen Vorlage:');
define('TEXT_SELECT', 'Bitte ausw&auml;hlen:');
define('TEXT_EDIT_INTRO', 'Bitte f&uuml;hren Sie alle notwendigen &Auml;nderungen durch.');
define('TEXT_EDIT_CATEGORIES_ID', 'Kategorie ID:');
define('TEXT_EDIT_CATEGORIES_NAME', 'Kategorie Name:');
define('TEXT_EDIT_CATEGORIES_HEADING_TITLE', 'Kategorie &Uuml;berschrift:');
define('TEXT_EDIT_CATEGORIES_GOOGLE_TAX_NEW_TITLE', 'Google-Taxonomie:');
define('TEXT_EDIT_CATEGORIES_SHORT_DESCRIPTION', 'Kategorie Kurz-Beschreibung:<br>(Erscheint in der Kategorie-Listing, wenn es Unterkategorien gibt.)');
define('TEXT_EDIT_CATEGORIES_DESCRIPTION', 'Kategorie Lang-Beschreibung:');
define('TEXT_EDIT_CATEGORIES_DESCRIPTION_FOOTER', 'Kategorie Beschreibung Footer:<br>(Erscheint im Footer der Kategorie.)');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Kategorie Bild:');
define('TEXT_EDIT_CATEGORIES_GOOGLE_TAX_TITLE', '<b>Google Taxonomie Kategorie:</b>');
define('TEXT_EDIT_SORT_ORDER', 'Sortierreihenfolge:');
define('TEXT_INFO_COPY_TO_INTRO', 'Bitte w&auml;hlen Sie eine neue Kategorie aus, in die Sie den Artikel kopieren m&ouml;chten:');
define('TEXT_INFO_CURRENT_CATEGORIES', 'Aktuelle Kategorien:');
define('TEXT_INFO_HEADING_NEW_CATEGORY', 'Neue Kategorie');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Kategorie bearbeiten');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Kategorie l&ouml;schen');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Kategorie verschieben');
define('TEXT_INFO_HEADING_DELETE_PRODUCT', 'Artikel l&ouml;schen');
define('TEXT_INFO_HEADING_MOVE_PRODUCT', 'Artikel verschieben');
define('TEXT_INFO_HEADING_COPY_TO', 'Kopieren nach');
define('TEXT_INFO_HEADING_MOVE_ELEMENTS', 'Elemente verschieben');
define('TEXT_INFO_HEADING_DELETE_ELEMENTS', 'Elemente l&ouml;schen');
define('TEXT_DELETE_CATEGORY_INTRO', 'Sind Sie sicher, dass Sie diese Kategorie l&ouml;schen m&ouml;chten?');
define('TEXT_DELETE_PRODUCT_INTRO', 'Sind Sie sicher, dass Sie diesen Artikel l&ouml;schen m&ouml;chten?');
define('TEXT_DELETE_WARNING_CHILDS', '<b>WARNUNG:</b> Es existieren noch %s (Unter-)Kategorien, die mit dieser Kategorie verbunden sind!');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>WARNUNG:</b> Es existieren noch %s Artikel, die mit dieser Kategorie verbunden sind!');
define('TEXT_MOVE_WARNING_CHILDS', '<b>Info:</b> Es existieren noch %s (Unter-)Kategorien, die mit dieser Kategorie verbunden sind!');
define('TEXT_MOVE_WARNING_PRODUCTS', '<b>Info:</b> Es existieren noch %s Artikel, die mit dieser Kategorie verbunden sind!');
define('TEXT_MOVE_PRODUCTS_INTRO', 'Bitte w&auml;hlen Sie die &uuml;bergordnete Kategorie, in die Sie <b>%s</b> verschieben m&ouml;chten');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Bitte w&auml;hlen Sie die &uuml;bergordnete Kategorie, in die Sie <b>%s</b> verschieben m&ouml;chten');
define('TEXT_MOVE', 'Verschiebe <b>%s</b> nach:');
define('TEXT_MOVE_ALL', 'Verschiebe alle nach:');
define('TEXT_NEW_CATEGORY_INTRO', 'Bitte geben Sie die neue Kategorie mit allen relevanten Daten ein.');
define('TEXT_CATEGORIES_NAME', 'Kategorie Name:');
define('TEXT_CATEGORIES_IMAGE', 'Kategorie Bild:');
define('TEXT_META_TITLE', 'Meta Title:');
define('TEXT_META_DESCRIPTION', 'Meta Description:');
define('TEXT_META_KEYWORDS', 'Meta Keywords:');
define('TEXT_SORT_ORDER', 'Sortierreihenfolge:');
define('TEXT_PRODUCTS_STATUS', 'Artikelstatus:');
define('TEXT_PRODUCTS_STARTPAGE', 'Auf Startseite zeigen:');
define('TEXT_PRODUCTS_STARTPAGE_YES', 'Ja');
define('TEXT_PRODUCTS_STARTPAGE_NO', 'Nein');
define('TEXT_PRODUCTS_STARTPAGE_SORT', 'Reihung (Startseite):');
define('TEXT_PRODUCTS_DATE_AVAILABLE', 'Erscheinungsdatum:');
define('TEXT_PRODUCT_AVAILABLE', 'Auf Lager');
define('TEXT_PRODUCT_NOT_AVAILABLE', 'Nicht vorrätig');
define('TEXT_PRODUCTS_MANUFACTURER', 'Hersteller:');
define('TEXT_PRODUCTS_NAME', 'Artikelname:');
define('TEXT_PRODUCTS_DESCRIPTION', 'Artikelbeschreibung:');
define('TEXT_PRODUCTS_QUANTITY', 'Artikelanzahl:');
define('TEXT_PRODUCTS_MODEL', 'Artikel-Nr.:');
define('TEXT_PRODUCTS_MAIN_IMAGE', 'Hauptbild:');
define('TEXT_PRODUCTS_IMAGE', 'Zusatzbild:');
define('TEXT_PRODUCTS_URL', 'Herstellerlink:');
define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '<nobr>Ohne f&uuml;hrendes http:// angeben.</nobr>');
define('TEXT_PRODUCTS_PRICE', 'Artikelpreis:');
define('TEXT_PRODUCTS_WEIGHT', 'Artikelgewicht:');
define('TEXT_PRODUCTS_EAN','Barcode/EAN:');
define('TEXT_PRODUCT_LINKED_TO','Verlinkt in:');
define('TEXT_DELETE', 'L&ouml;schen');
define('EMPTY_CATEGORY', 'Leere Kategorie');
define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Fehler: Artikel k&ouml;nnen nicht in der gleichen Kategorie verlinkt werden.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Fehler: Das Verzeichnis \'images\' im Katalogverzeichnis ist schreibgesch&uuml;tzt: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Fehler: Das Verzeichnis \'images\' im Katalogverzeichnis ist nicht vorhanden: ' . DIR_FS_CATALOG_IMAGES);
define('TEXT_PRODUCTS_DISCOUNT_ALLOWED','Rabatt erlaubt:');
define('HEADING_PRICES_OPTIONS','<b>Preis-Optionen</b>');
define('HEADING_PRODUCT_IMAGES','<b>Artikel-Bilder</b>');
define('TEXT_PRODUCTS_WEIGHT_INFO','<small>(kg)</small>');
define('TEXT_PRODUCTS_SHORT_DESCRIPTION','Kurzbeschreibung:');
define('TEXT_PRODUCTS_KEYWORDS', 'Zusatz-Begriffe f&uuml;r Suche:');
define('TXT_STK','Stk: ');
define('TXT_PRICE','a :');
define('TXT_NETTO','Nettopreis: ');
define('TEXT_NETTO','Netto: ');
define('TXT_STAFFELPREIS','Staffelpreise');
define('HEADING_PRODUCTS_MEDIA','<b>Artikelmedium</b>');
define('TABLE_HEADING_PRICE','Preis');
define('TEXT_CHOOSE_INFO_TEMPLATE','Artikel-Details Vorlage');
define('TEXT_SELECT','--bitte w&auml;hlen--');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE','Optionen-Details Vorlage');
define('SAVE_ENTRY','Speichern ?');
define('TEXT_FSK18','FSK 18:');
define('TEXT_CHOOSE_INFO_TEMPLATE_CATEGORIE','HTML-Vorlage für Kategorieübersicht:');
define('TEXT_CHOOSE_INFO_TEMPLATE_LISTING','HTML-Vorlage für Artikelübersicht:');
define('TEXT_PRODUCTS_SORT','Reihung (Listen):');
define('TEXT_EDIT_PRODUCT_SORT_ORDER','1. Artikel-Sortierung:');
define('TEXT_EDIT_PRODUCT_SORT_ORDER2','2. Artikel-Sortierung:');
define('TXT_PRICES','Preis');
define('TXT_NAME','Artikelname');
define('TXT_ORDERED','Bestellte Artikel');
define('TXT_SORT','Reihung');
define('TXT_AGE','Alter');
define('TXT_WEIGHT','Gewicht');
define('TXT_QTY','Auf Lager');
define('TEXT_MULTICOPY','Mehrfach');
define('TEXT_MULTICOPY_DESC','Elemente in folgende Kategorien kopieren:<br />(Falls ausgew&auml;hlt werden Einstellungen von "Einfach" ignoriert.)');
define('TEXT_SINGLECOPY','Einfach');
define('TEXT_SINGLECOPY_DESC','Elemente in folgende Kategorie kopieren:<br />(Daf&uuml;r darf unter "Mehrfach" keine Kategorie aktiviert sein.)');
define('TEXT_SINGLECOPY_CATEGORY','Kategorie:');
define('TEXT_HOW_TO_COPY', 'Kopiermethode:');
define('TEXT_COPY_AS_LINK', 'Verlinken');
define('TEXT_COPY_AS_DUPLICATE', 'Duplizieren');
define('TEXT_PRODUCTS_VPE','Grundpreis-Einheit: ');
define('TEXT_PRODUCTS_VPE_VISIBLE','Anzeige Grundpreiseinheit: ');
define('TEXT_PRODUCTS_VPE_VALUE','Grundpreis-Wert: ');
define('CROSS_SELLING','Cross Selling für Artikel');
define('CROSS_SELLING_SEARCH','Produktsuche:');
define('BUTTON_EDIT_CROSS_SELLING','Cross Selling');
define('BUTTON_EDIT_PRODUCTS_PARAMETERS', 'Technische Daten');
define('HEADING_DEL','L&ouml;schen');
define('HEADING_ADD','Hinzuf&uuml;gen?');
define('HEADING_GROUP','Gruppe');
define('HEADING_SORTING','Reihung');
define('HEADING_MODEL','Artikelnummer');
define('HEADING_NAME','Artikel');
define('HEADING_CATEGORY','Kategorie');
define('TEXT_DEFAUL_SETTINGS', 'Grundeinstellungen');
define('TEXT_ATTRIBUT_MANAGER', 'Attribut Verwaltung');
define('TEXT_PAYMENT_METHOD', 'Zahlarten sperren für diesen Artikel:');
define('TEXT_PRODUCTS_ZUSTAND','Artikelzustand:');
define('TEXT_PRODUCTS_TAGCLOUD','weiteres Feld hinzuf&uuml;gen');
define('TEXT_PRODUCTS_IMAGES_FLASH','Produktbilder / Flash');
define('TEXT_PRODUCTS_FLASH_UPLOAD','Flashfilm hochladen:');
define('TEXT_PRODUCTS_FILE_EXIST','bereits auf dem Server');
define('TEXT_PRODUCTS_EMBEDDED_FLASH','Embeded Flash Code:<br /><i>z.B.: von Youtube</i>');
define('TEXT_PRODUCTS_YOUTUBE_ID','Youtube Film ID:<br />z.B.: <i>vyHcIHssdHA</i>');
define('TEXT_PRODUCTS_HEIGHT','Höhe:');
define('TEXT_PRODUCTS_WIDTH','Breite:');
define('TEXT_PRODUCTS_ALTERNATE_IMAGE_DESC', 'Alternativtext:');
define('TEXT_PRODUCTS_CART_SPECIALS', 'Im Warekorb als Promo:');
define('TEXT_PRODUCTS_ZUSATZ_DESCRIPTION', 'Zusatzbeschreibung (wird als Tab dargestellt)');
define('TEXT_PRODUCTS_MANUFACTURERS_MODEL', 'Hersteller Artikel Nummer:');
define('TEXT_PRODUCTS_GOOGLE_TAXONOMIE', 'Google-Taxonomie (<b><a href="http://www.google.com/support/merchants/bin/answer.py?answer=160081" target="_blank">Beispiel</a></b>) :');
define('TEXT_PRODUCTS_TAXONOMIE', 'Ihre Artikelkategorie (<b><a href="http://www.google.com/support/merchants/bin/answer.py?hl=de&answer=188494" target="_blank">Beispiel</a></b>) :');
define('TABLE_HEADING_SECTION','Kategoriebox-Zuordnung:');
define('TXT_SECTION_STANDARD','Standard');
define('TXT_SECTION_ONE','Kategorie-Box 1');
define('TXT_SECTION_TWO','Kategorie-Box 2');
define('TXT_SECTION_THREE','Kategorie-Box 3');
define('TXT_SECTION_FOUR','Kategorie-Box 4');
define('TXT_SECTION_FIVE','Kategorie-Box 5');
define('TXT_SECTION_SIX','Kategorie-Box 6');
define('TXT_SECTION_SEVEN','Kategorie-Box 7');
define('TXT_SECTION_EIGHT','Kategorie-Box 8');
define('TXT_SECTION_NINE','Kategorie-Box 9');
define('TXT_SECTION_TEN','Kategorie-Box 10');
define('TXT_SECTION_ELEVEN','Kategorie-Box 11');
define('TEXT_PRODUCTS_BUNDLE','Produkt-Bundle ?: ');
define('TEXT_BUNDLE_NR','Bundle-Produkt-Nr. ');
define('HEADING_BUNDLE_NAME','Bezeichnung');
define('HEADING_BUNDLE_ID','ID');
define('HEADING_BUNDLE_QTY','Stk');
define('TEXT_BUNDLE_REM','("yes" oder leer lassen)');
define('TEXT_BUNDLE_ADD','Bundle-Produkt einf&uuml;gen:');
define('TEXT_BUNDLE_DEL','[L&ouml;schen]');
define('TEXT_PRODUCTS_SPERRGUT', 'Sperrgut:');
define('TEXT_PRODUCTS_EKPPRICE','Einkaufspreis');
define('TEXT_CAT_PIC_PATH','Bild-Pfad:');
define('HEADING_PROMO','Kategorie Promotion');
define('SPECIALS_TITLE','Sonderangebote');
define('PROMO_TITLE','Produkt Promotion');
define('PRICE_TITLE','Produkt Preis');
define('SPECIALS_TITLE', 'Sonderangebot erstellen/bearbeiten');
define('TEXT_STATUS', 'Status (markiert = aktiv)');
define('TEXT_SPECIALS_PRODUCT', 'Artikel:');
define('TEXT_SPECIALS_SPECIAL_PRICE', 'Angebotspreis:');
define('TEXT_SPECIALS_SPECIAL_QUANTITY', 'Anzahl:');
define('TEXT_SPECIALS_EXPIRES_DATE', 'G&uuml;ltig bis: <small>(JJJJ-MM-TT)</small>');
define('TEXT_SPECIALS_PRICE_TIP', '<strong>Bemerkung:</strong><br>Sie k&ouml;nnen im Feld Angebotspreis auch prozentuale Werte angeben, z.B.: <strong>20%</strong><br>Wenn Sie einen neuen Preis eingeben, m&uuml;ssen die Nachkommastellen mit einem \'.\' getrennt werden, z.B.: <strong>49.99</strong><br>Lassen Sie das Feld <strong>\'G&uuml;ltig bis\'</strong> leer, wenn der Angebotspreis zeitlich unbegrenzt gelten soll.<br>Im Feld <strong>Anzahl</strong> k&ouml;nnen Sie die St&uuml;ckzahl eingeben, f&uuml;r die das Angebot gelten soll. Lassen Sie das Feld leer, wenn Sie die Anzahl nicht begrenzen wollen.');
define('TEXT_INFO_DATE_ADDED', 'hinzugef&uuml;gt am:');
define('TEXT_INFO_LAST_MODIFIED', 'letzte &Auml;nderung:');
define('TEXT_INFO_NEW_PRICE', 'neuer Preis:');
define('TEXT_INFO_ORIGINAL_PRICE', 'alter Preis:');
define('TEXT_INFO_PERCENTAGE', 'Prozent:');
define('TEXT_INFO_EXPIRES_DATE', 'G&uuml;ltig bis:');
define('TEXT_INFO_HEADING_DELETE_SPECIALS', 'Sonderangebot l&ouml;schen');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie das Sonderangebot l&ouml;schen m&ouml;chten?');
define('TEXT_PRODUCTS_MIN_ORDER', 'Mindestbestellmenge');

//comments_orders
define('HEADING_TITLE_COMMENTS_ORDERS', 'Bestellung-Kommentar-Vorlagen');
define('TABLE_HEADING_COMMENT_ORDER', 'Kommentar-Vorlagen');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TEXT_HEADING_NEW_COMMENTS_ORDERS', 'Neue Vorlage');
define('TEXT_HEADING_EDIT_BLACKLIST_CARD', 'Vorlage bearbeiten');
define('TEXT_HEADING_DELETE_BLACKLIST_CARD', 'Vorlage l&ouml;schen');
define('TEXT_DISPLAY_NUMBER_OF_BLACKLIST_CARDS', 'Vorlage anzeigen');
define('TEXT_DATE_ADDED', 'Hinzugef&uuml;gt am:');
define('TEXT_LAST_MODIFIED', 'Zuletzt ge&auml;ndert:');
define('TEXT_COMMENTS_ORDERS_TITLE', 'Titel:');
define('TEXT_COMMENTS_ORDERS_MAIL_TEXT', 'Vorlagen-Text:');
define('TEXT_TITLE', 'Vorlage:');
define('TEXT_HEADING_EDIT_COMMENTS_ORDERS', 'Bearbeitung Kommentar-Vorlage');
define('TEXT_HEADING_DELETE_COMMENTS_ORDERS', 'Löschen Kommentar-Vorlage');
define('TEXT_NEW_INTRO', 'Bitte geben Sie einen Titel und den Mailvorlagentext ein.');
define('TEXT_EDIT_INTRO', 'Bitte f&uuml;hren Sie die notwendigen &Auml;nderungen durch.');
define('TEXT_DELETE_INTRO', 'Sind Sie sicher, dass Sie diese Vorlage l&ouml;schen wollen?');

//content_manager
define('HEADING_TITLE_CONTENT_MANAGER','Content Manager');
define('HEADING_CONTENT','Seiten Content');
define('HEADING_PRODUCTS_CONTENT','Artikel Content');
define('TABLE_HEADING_CONTENT_ID','Link ID');
define('TABLE_HEADING_CONTENT_TITLE','Titel');
define('TABLE_HEADING_CONTENT_FILE','Datei');
define('TABLE_HEADING_CONTENT_STATUS','In Box sichtbar');
define('TABLE_HEADING_CONTENT_BOX','Box');
define('TABLE_HEADING_PRODUCTS_ID','ID');
define('TABLE_HEADING_PRODUCTS','Artikel');
define('TABLE_HEADING_PRODUCTS_CONTENT_ID','ID');
define('TABLE_HEADING_LANGUAGE','Sprache');
define('TABLE_HEADING_CONTENT_NAME','Name/Dateiname');
define('TABLE_HEADING_CONTENT_LINK','Link');
define('TABLE_HEADING_CONTENT_HITS','Hits');
define('TABLE_HEADING_CONTENT_GROUP','Gruppe');
define('TABLE_HEADING_CONTENT_SORT','Reihenfolge');
define('TEXT_YES','Ja');
define('TEXT_NO','Nein');
define('TABLE_HEADING_CONTENT_ACTION','Aktion');
define('TEXT_DELETE','L&ouml;schen');
define('TEXT_EDIT','Bearbeiten');
define('TEXT_PREVIEW','Vorschau');
define('CONFIRM_DELETE','Wollen Sie den Content wirklich l&ouml;schen ?');
define('CONTENT_NOTE','Content markiert mit <font color="ff0000">*</font> geh&ouml;rt zum System und kann nicht gel&ouml;scht werden!');
define('TEXT_LANGUAGE','Sprache:');
define('TEXT_STATUS','Sichtbar:');
define('TEXT_STATUS_DESCRIPTION','Wenn ausgew&auml;hlt, wird ein Link in der Info Box angezeigt');
define('TEXT_TITLE','Titel:');
define('TEXT_TITLE_FILE','Titel/Dateiname:');
define('TEXT_SELECT','-Bitte w&auml;hlen-');
define('TEXT_HEADING','&Uuml;berschrift:');
define('TEXT_CONTENT','Text:');
define('TEXT_UPLOAD_FILE','Datei Hochladen:');
define('TEXT_UPLOAD_FILE_LOCAL','(von Ihrem lokalen System)');
define('TEXT_CHOOSE_FILE','Datei W&auml;hlen:');
define('TEXT_CHOOSE_FILE_DESC','Sie k&ouml;nnen ebenfals eine Bereits verwendete Datei aus der Liste ausw&auml;hlen.');
define('TEXT_NO_FILE','Auswahl L&ouml;schen');
define('TEXT_CHOOSE_FILE_SERVER','(Falls Sie ihre Dateien selbst via FTP auf ihren Server gespeichert haben <i>(media/content)</i>, k&ouml;nnen Sie hier die Datei ausw&auml;hlen.');
define('TEXT_CURRENT_FILE','Aktuelle Datei:');
define('TEXT_FILE_DESCRIPTION','<b>Info:</b><br />Sie haben ebenfalls die M&ouml;glichkeit eine <b>.html</b> oder <b>.htm</b> Datei als Content einzubinden.<br /> Falls Sie eine Datei ausw&auml;hlen oder hochladen, wird der Text im Textfeld ignoriert.<br /><br />');
define('ERROR_FILE','Falsches Dateiformat (nur .html od .htm)');
define('ERROR_TITLE','Bitte geben Sie einen Titel ein');
define('ERROR_COMMENT','Bitte geben Sie eine Dateibeschreibung ein!');
define('TEXT_FILE_FLAG','Box:');
define('TEXT_PARENT','Hauptdokument:');
define('TEXT_PARENT_DESCRIPTION','Diesem Dokument zuweisen');
define('TEXT_PRODUCT','Artikel:');
define('TEXT_LINK','Link:');
define('TEXT_SORT_ORDER','Sortierung:');
define('TEXT_GROUP','Sprachgruppe:');
define('TEXT_GROUP_DESC','Mit dieser ID verkn&uuml;pfen sie gleiche Themen unterschiedlicher Sprachen miteinander.');
define('TEXT_CONTENT_DESCRIPTION','Mit diesem Content Manager haben Sie die M&ouml;glichkeit, jeden beliebige Dateityp einem Artikel hinzuzuf&uuml;gen.<br />Zb. Artikelbeschreibungen, Handb&uuml;cher, technische Datenbl&auml;tter, H&ouml;rproben, usw...<br />Diese Elemente werden In der Artikel-Detailansicht angezeigt.<br /><br />');
define('TEXT_FILENAME','Benutze Datei:');
define('TEXT_FILE_DESC','Beschreibung:');
define('USED_SPACE','Verwendeter Speicherplatz:');
define('TABLE_HEADING_CONTENT_FILESIZE','Dateigr&ouml;sse');
define('TEXT_TEMPLATE_COLUMN', 'Anzeige Positionen im Template:');
define('TEXT_TEMPLATE_COLUMN_TOP', ' 1 oben');
define('TEXT_TEMPLATE_COLUMN_LEFT', ' 2 linke Spalte');
define('TEXT_TEMPLATE_COLUMN_RIGHT', ' 3 rechte Spalte');
define('TEXT_TEMPLATE_COLUMN_BUTTON', ' 4 unten');
define('TEXT_URL_ALIAS', 'URL Alias:');
define('TEXT_META_TITLE', 'Meta Title:');
define('TEXT_META_DESC', 'Meta Description:');
define('TEXT_META_KEY', 'Meta Keywords:');
define('TEXT_ZIEL', 'Ziel:');
define('TEXT_TYP', 'Typ:');

//countries
define('HEADING_TITLE_COUNTRIES', 'L&auml;nder');
define('TABLE_HEADING_COUNTRY_NAME', 'Land');
define('TABLE_HEADING_COUNTRY_CODES', 'ISO Codes');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TABLE_HEADING_STATUS', 'Status');
define('TEXT_INFO_EDIT_INTRO', 'Bitte f&uuml;hren Sie alle notwendigen &Auml;nderungen durch');
define('TEXT_INFO_COUNTRY_NAME', 'Name:');
define('TEXT_INFO_COUNTRY_CODE_2', 'ISO Code (2):');
define('TEXT_INFO_COUNTRY_CODE_3', 'ISO Code (3):');
define('TEXT_INFO_ADDRESS_FORMAT', 'Adressformat:');
define('TEXT_INFO_INSERT_INTRO', 'Bitte geben Sie das neue Land mit allen relevanten Daten ein');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie das Land l&ouml;schen m&ouml;chten?');
define('TEXT_INFO_HEADING_NEW_COUNTRY', 'neues Land');
define('TEXT_INFO_HEADING_EDIT_COUNTRY', 'Land bearbeiten');
define('TEXT_INFO_HEADING_DELETE_COUNTRY', 'Land l&ouml;schen');

//PDF Rechnung
define('FILENAME_BILL', 'Rechnung');
define('FILENAME_PACKINSLIP', 'Lieferschein');
define('TEXT_PDF_SEITE', 'Seite');
define('TEXT_PDF_SEITE_VON', 'von');
define('TEXT_PDF_KUNDENNUMMER', 'Kunden-Nr.');
define('TEXT_PDF_RECHNUNGSNUMMER', 'Rechnungsnummer');
define('TEXT_PDF_LIEFERNUMMER', 'Lieferschein');
define('TEXT_PDF_BESTELLNUMMER', 'Bestellnummer');
define('TEXT_PDF_USTID', 'Ihre UST-ID');
define('TEXT_PDF_DATUM', 'Datum');
define('TEXT_PDF_ZAHLUNGSWEISE', 'Zahlungsweise');
define('TEXT_PDF_RECHNUNG', 'Rechnung');
define('TEXT_PDF_LIEFERSCHEIN', 'Lieferschein');
define('TEXT_PDF_MENGE', 'Menge');
define('TEXT_PDF_ARTIKEL', 'Artikel');
define('TEXT_PDF_ARTIKELNR', 'Artikel-Nr.');
define('TEXT_PDF_EINZELPREIS', 'Einzelpreis');
define('TEXT_PDF_PREIS', 'Gesamtpreis');
define('TEXT_PDF_KOMMENTAR', 'Kommentare');
define('TEXT_PDF_LIFERADRESSE', 'Lieferanschrift: ');

define('AT_PRICE', 'Preis');
define('AT_BRUTTO', 'Brutto');
define('AT_NETTO', 'Netto');
define('AT_SORT', 'Reihenfolge');
define('AT_PNUM', 'Artikel-Nr.');
define('DL_NAME', 'Download Datei');
define('DL_COUNT', 'mögliche Downloads');
define('DL_EXPIRE', 'Tage für Download');
define('AT_EAN', 'EAN');
define('AT_LAGER', 'Lager');
define('AT_WEIGHT', 'Gewicht');


define('HEADING_TITLE_NEWSLETTER','Rundschreiben/Newsletter');
define('TITLE_CUSTOMERS','Kundengruppe');
define('TITLE_STK','Abonniert');
define('TEXT_TITLE','Betreff:');
define('TEXT_TO','An: ');
define('TEXT_CC','Cc: ');
define('TEXT_BODY','Inhalt: ');
define('TITLE_NOT_SEND','Titel');
define('TITLE_ACTION','Aktion');
define('TEXT_EDIT','Bearbeiten');
define('TEXT_DELETE','L&ouml;schen');
define('TEXT_SEND','Senden');
define('CONFIRM_DELETE','Sind Sie sicher?');
define('TITLE_SEND','Versandt');
define('TEXT_NEWSLETTER_ONLY','Auch an Gruppenmitglieder die kein Rundschreiben abonniert haben');
define('TEXT_USERS',' Abonnenten von ');
define('TEXT_CUSTOMERS',' Kunden )</i>');
define('TITLE_DATE','Datum');
define('TEXT_SEND_TO','Empf&auml;nger:');
define('TEXT_PREVIEW','<b>Vorschau:</b>');
define('TEXT_REMOVE_LINK', 'Newsletter abmelden');
define('PERSONAL_NEWLETTER','personalisierter Newsletter:');
define('ANREDE','Anrede: ');
define('ANREDE_HOEFLICH','Anrede: höflich<br>');
define('ANREDE_PERSONAL','Anrede: persönlich<br>');
define('ANREDE_PERSONALISIERT','personalisiert: Nein<br>');
define('NEWSLETTER_SEND','Senden');
define('NEWSLETTER_GIFT','Gutschein:');
define('NEWSLETTER_GIFT_INSERT','Gutschein einfügen:');
define('NEWSLETTER_GIFT_INSERT_INFO',' <i>(Aktivieren Sie diese Funktion, wenn Sie dem Newsletter einen Gutschein beilegen möchten)</i>');
define('NEWSLETTER_GIFT_WERT_INFO',' EUR <i>(Gutscheinwert in EUR. z.B.: 20.00)</i>');
define('NEWSLETTER_GIFT_JA','Gutschein: <b>Ja</b><br>');
define('NEWSLETTER_GIFT_NEIN','Gutschein: Nein<br><br>');
define('NEWSLETTER_GIFT_WERT','Gutscheinwert: ');
define('NEWSLETTER_ARTICLE','Artikelliste: ');
define('PERSONAL_NEWSLETTER','Personalisierung:');
define('NEWSLETTER_ARTICLE_INSERT','Artikelliste einfügen:');
define('NEWSLETTER_ARTICLE_ACT','ausgewählte Artikelliste:');
define('NEWSLETTER_ARTICLE_NEW','neue Artikelliste:');
define('NEWSLETTER_SELECT_HOEFLICH','höfliche Anrede');
define('NEWSLETTER_SELECT_PERSONAL','persönliche Anrede');
define('PERSONALITY_NEWLETTER','Newsletter personalisieren:');
define('PERSONALITY_NEWLETTER_INFO','Sie haben die Möglichkeit, den Newsletter persönlicher zu gestalten, in dem Sie den Kunden mit seinem Namen ansprechen.');
define('OPTIONS','Optionen:');
define('ANREDE_HOEFLICH_INFO','höfliche Anrede = Sehr geehrter Herr Mustermann');
define('ANREDE_PERSONAL_INFO','persönliche Anrede = Hallo Herr Mustermann');
define('TEXT_VIEW_SHORT','Liste anzeigen');
define('PRICE_TITLE_ADVANCED','erweiterte Preiseinstellung');
define('GROUP_PRICES','Gruppen-Preise');
define('HEAD_GOOGLE','Google Taxonomie');
define('TEXT_PRODUCTS_G_GENDER','Geschlecht');
define('TEXT_PRODUCTS_G_AGE','Altersgruppe');
define('TEXT_PRODUCTS_G_COLOR','Farbe');
define('TEXT_PRODUCTS_G_SIZE','Größe');
define('TEXT_PRODUCTS_G_ISBN','ISBN');
define('TEXT_PRODUCTS_G_UPC','UPC');
define('TEXT_PRODUCTS_G_MPN','MPN');
define('TEXT_PRODUCTS_G_BRAND','Marke');
define('TEXT_PRODUCTS_G_AVAILABILITY','Verfügbarkeit');
define('TEXT_PRODUCTS_G_SHIPPING_STATUS','Versandstatus');
define('TEXT_PRODUCTS_GOOGLE','Google Merchant Center Zuordnung (<a href="https://support.google.com/merchants/answer/188494" target="_blank">Hilfe</a>)');
define('P_HELP_ZUSTAND','Der Zustand der Ware.');
define('P_HELP_GOOGLE_TAXONOMIE','Sie können das Dopdown in der nächsten Zeile verwenden, oder hier manuell die Taxonomie fest legen. <br>Bsp.: <b>Baby & Kleinkind > Baby baden > Babybadewannen</b>');
define('P_HELP_GOOGLE_TAXONOMIE_NEW','Hier können Sie die Zuordnung dieses Produktes zur Google Taxonomie vornehmen.');
define('P_HELP_PRODUCTS_TAXONOMIE','Hier können Sie die Zuordnung dieses Produktes zur Google Produktkategorie vornehmen. Dieses Feld ist derzeit kein Pflichtfeld und beschreibt Ihre eigene zuordnung des Produktes.');
define('P_HELP_G_GENDER','Trifft derzeit für Bekleidung zu: Geschlecht');
define('P_HELP_G_AGE','Trifft derzeit für Bekleidung zu: Altersgruppe');
define('P_HELP_G_COLOR','Trifft derzeit für Bekleidung zu: Farbe');
define('P_HELP_G_SIZE','Trifft derzeit für Bekleidung zu: Größe');
define('P_HELP_G_ISBN','Die eindeutige ISBN Nummer des Produktes');
define('P_HELP_G_UPC','Die eindeutige UPC Nummer des Produktes');
define('P_HELP_G_MPN','Die eindeutige MPN Nummer des Produktes');
define('P_HELP_G_BRAND','Die Marke des Produktes');
define('P_HELP_G_AVAILABILITY','Die Verfügbarkeit des Produktes');
define('P_HELP_G_SHIPPING_STATUS','Die Shipping Status ID des Produktes');




define('HEADING_TITLE_MAIN_SORT', 'Startseiten Sortierung');

define('MAIN_SORT_HOWTO', 'Hier können Sie ganz einfach per Drag & Drop die Reihenfolge der Boxen auf der Startseite Ihren Wünschen entsprechend anpassen.');
define('MAIN_SORT_MODULES', 'Kategorien');
define('MAIN_SORT_MODULES_DESC', '');
define('MAIN_SORT_ADDRESSES', 'Bald erscheinende Produkte');
define('MAIN_SORT_ADDRESSES_DESC', 'Produkte die erst in Zukunft erscheinen');
define('MAIN_SORT_NEWP', 'Neue Produkte');
define('MAIN_SORT_NEWP_DESC', 'Neue Produkte der Position Top');
define('MAIN_SORT_PRODUCTS', 'Zufallsprodukte');
define('MAIN_SORT_PRODUCTS_DESC', 'Anzeige der Zufallsprodukte');
define('MAIN_SORT_COMMENTS', 'Sonderangebote');
define('MAIN_SORT_COMMENTS_DESC', 'Anzeige der Sonderangebote');
define('MAIN_SORT_LEGALS', 'Bestseller');
define('MAIN_SORT_LEGALS_DESC', 'Anzeige der Sonderangebote');

define('MAIN_SORT_WD', 'Blog');
define('MAIN_SORT_WD_DESC', 'Anzeige der Blogeinträge');

define('MAIN_SORT_DS', 'Produktpromotion');
define('MAIN_SORT_DS_DESC', 'Anzeige der Produktpromotion');

define('MAIN_SORT_TEXT1', 'Startseitentext');
define('MAIN_SORT_TEXT1_DESC', 'Anzeige des Startseitentext vom Contentmanager Group ID = 5');

define('MAIN_SORT_TEXT2', 'Startseitentext Footer');
define('MAIN_SORT_TEXT2_DESC', 'Anzeige des Startseitentext Footer vom Contentmanager Group ID = 15');

define('MAIN_SORT_STORE_SUCCESS', 'Die neue Sortierung wurde erfolgreich gespeichert.');
define('TEXT_CAT_BOX_START', 'Kategorie in der Startseitenbox?');
define('TEXT_CAT_BOX_CONTENT', 'Kategorie als Content?');
define('TABLE_HEADING_SHORT_DESC', 'Kurzbeschreibung');

define('ORDER_STATUS_STORNO_TITLE','Statusnummer für Stornorechnungen');
define('ORDER_STATUS_STORNO_DESC','Welche Nummer soll eine Stornorechnung / Gutschrift im Standard erhalten?<br />Vergessen Sie nicht, diesen Status anzulegen. Das k&ouml;nnen Sie <a href="'.DIR_WS_ADMIN.'orders_status.php?page=1&action=new">hier</a> machen.');
define('STORNO_INCOICE', 'Stornorechnung');
define('BOX_SHIPPING_STATUS', 'Lieferzeit:');
define('TEXT_SELECT_MULTI', 'Mehrfachauswahl');
define('TEXT_PRODUCTS_REL','Artikel indexierbar:');
define('BUTTON_NEWPRODUCT', 'Duplizieren');
define('TEXT_PRODUCTS_BUYABLE', 'Artikel kaufbar:');
define('TEXT_PRODUCTS_ONLY_REQUEST', 'Artikel auf Anfrage:');
define('TEXT_PRODUCTS_GOOGLE_TAXONOMIE_NEW', 'Google Taxonomie');

define('TEXT_PRODUCTS_MASTER', 'Artikel ist ein Master-Artikel:');
define('TEXT_PRODUCTS_MASTER_SUB', 'Welchem Master-Artikel untergeortnet:');
define('TEXT_PRODUCTS_MASTER_SUB_ERROR', 'Derzeit existiert kein Masterartikel oder der Artikel ist selber ein Master.');
define('TEXT_PRODUCTS_MASTER_LIST', 'Slave Artikel in den Listen anzeigen:');
define('TEXT_PRODUCTS_MASTER_LIST', 'Slave Artikel in den Listen anzeigen:');
define('HEADING_ATTRIBUTE', 'Artikelmerkmale');
define('HEAD_OPTION', 'Optionen');
define('TEXT_PRODUCTS_G_IDENTIFIER', 'Identifier');
define('P_HELP_G_IDENTIFIER', 'Artikel ist ohne Ausnahmeregelung');

define('HEADING_TITLE_CHECKOUT_SORT', 'Bestellprozess Sortierung');

define('CHECKOUT_SORT_HOWTO', 'Hier können Sie ganz einfach per Drag & Drop die Reihenfolge der Boxen auf der Bestellprozess-Seite Ihren Wünschen entsprechend anpassen.<br><b>ACHTUNG: Wir weisen ausdrücklich darauf hin, dass Sie die rechtlichen Vorgaben beachten müssen. Eine sinnvolle Sortierung wäre z.B.: Module, Adressen, Kommentar, AGB (und wenn notwendig Wiederruf etc.) Diese Sortierung ist in 1. Linie dazu gedacht, die AGB, Wiederruf- und Datenschutzblöcke zu sortieren.</b>');
define('CHECKOUT_SORT_MODULES', 'Module');
define('CHECKOUT_SORT_MODULES_DESC', 'Auswahl des Versand- und Zahlungsmoduls');
define('CHECKOUT_SORT_ADDRESSES', 'Adressen');
define('CHECKOUT_SORT_ADDRESSES_DESC', 'Auswahl der Versand- und Rechnungsadresse');
define('CHECKOUT_SORT_PRODUCTS', 'Artikelliste');
define('CHECKOUT_SORT_PRODUCTS_DESC', 'Anzeige des editierbaren Warenkorbinhalts');
define('CHECKOUT_SORT_COMMENTS', 'Kommentar');
define('CHECKOUT_SORT_COMMENTS_DESC', 'Optionales Kommentarfeld');
define('CHECKOUT_SORT_LEGALS', 'AGB');
define('CHECKOUT_SORT_LEGALS_DESC', 'Allgemeine Geschäftsbedingungen Block');

define('CHECKOUT_SORT_STORE_SUCCESS', 'Die neue Sortierung wurde erfolgreich gespeichert.');

define('CHECKOUT_SORT_WD', 'Widerrufsbelehrung');
define('CHECKOUT_SORT_WD_DESC', 'Widerrufsbelehrung Block');

define('CHECKOUT_SORT_DS', 'Datenschutz');
define('CHECKOUT_SORT_DS_DESC', 'Datenschutz Block');








