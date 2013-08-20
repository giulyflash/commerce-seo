<?php
/*-----------------------------------------------------------------
* 	ID:						german.php
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



// Global
define('TEXT_FOOTER','Copyright &copy; 2012 <a href="http://www.commerce-seo.de/" target="_blank">commerce:SEO</a> ein Projekt von Webdesign Erfurt<br />Based on xt:Commerce<br /><br />');

// Box names
define('BOX_LANGUAGE','Sprache w&auml;hlen');
define('BOX_DB_CONNECTION','DB Verbindung') ;
define('BOX_WEBSERVER_SETTINGS','Webserver Einstellungen');
define('BOX_DB_IMPORT','DB Import');
define('BOX_WRITE_CONFIG','Schreiben der Konfigurationsdatei');
define('BOX_ADMIN_CONFIG','Administrator Konfiguration');
define('BOX_USERS_CONFIG','User Konfiguration');

define('PULL_DOWN_DEFAULT','Bitte W&auml;hlen Sie ein Land');


// Error messages
// index.php
define('SELECT_LANGUAGE_ERROR','Bitte w&auml;hlen Sie eine Sprache!');
// install_step2,5.php
define('TEXT_CONNECTION_ERROR','Eine Testverbindung zur Datenbank war nicht erfolgreich.');
define('TEXT_CONNECTION_SUCCESS','Eine Testverbindung zur Datenbank war erfolgreich.');
define('TEXT_DB_ERROR','Folgender Fehler wurde zur&uuml;ckgegeben:');
define('TEXT_DB_ERROR_1','Bitte klicken Sie auf <i>zur&uuml;ck</i> um Ihre Datenbankeinstellungen zu &uuml;berpr&uuml;fen.');
define('TEXT_DB_ERROR_2','Wenn Sie Hilfe zu Ihrer Datenbank ben&ouml;tigen, wenden Sie sich bitte an Ihren Provider.');
// install_step6.php
define('ENTRY_FIRST_NAME_ERROR','Vorname ist zu kurz');
define('ENTRY_LAST_NAME_ERROR','Nachname ist zu kurz');
define('ENTRY_EMAIL_ADDRESS_ERROR','E-Mail Adresse ist zu kurz');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR','Bitte &uuml;berpr&uuml;fen Sie Ihre E-Mail Adresse');
define('ENTRY_STREET_ADDRESS_ERROR','Stra&szlig;e ist zu kurz');
define('ENTRY_POST_CODE_ERROR','Postleitzahl ist zu kurz');
define('ENTRY_CITY_ERROR','Stadt ist zu kurz');
define('ENTRY_COUNTRY_ERROR','Bitte &uuml;berpr&uuml;fen Sie das Bundesland');
define('ENTRY_STATE_ERROR','Bitte &uuml;berpr&uuml;fen Sie das Land');
define('ENTRY_TELEPHONE_NUMBER_ERROR','Telefonnummer ist zu kurz');
define('ENTRY_PASSWORD_ERROR','Bitte &uuml;berpr&uuml;fen Sie das Passwort');
define('ENTRY_STORE_NAME_ERROR','Shop-Name ist zu kurz');
define('ENTRY_COMPANY_NAME_ERROR','Firmenname ist zu kurz');
define('ENTRY_EMAIL_ADDRESS_FROM_ERROR','E-Mail-From ist zu kurz');
define('ENTRY_EMAIL_ADDRESS_FROM_CHECK_ERROR','Bitte &uuml;berpr&uuml;fen Sie den E-Mail-From');
define('SELECT_ZONE_SETUP_ERROR','W&auml;hlen Sie Zone-Setup');
// install_step7.php
define('ENTRY_DISCOUNT_ERROR','Product discount -Guest');
define('ENTRY_OT_DISCOUNT_ERROR','Discount on ot -Guest');
define('SELECT_OT_DISCOUNT_ERROR','Discount on ot -Guest');
define('SELECT_GRADUATED_ERROR','Graduated Prices -Guest');
define('SELECT_PRICE_ERROR','Show Price -Guest');
define('SELECT_TAX_ERROR','Show Tax -Guest');
define('ENTRY_DISCOUNT_ERROR2','Product discount -Default');
define('ENTRY_OT_DISCOUNT_ERROR2','Discount on ot -Default');
define('SELECT_OT_DISCOUNT_ERROR2','Discount on ot -Default');
define('SELECT_GRADUATED_ERROR2','Graduated Prices -Default');
define('SELECT_PRICE_ERROR2','Show Price -Default');
define('SELECT_TAX_ERROR2','Show Tax -Default');


// index.php
define('TITLE_SELECT_LANGUAGE','W&auml;hlen Sie eine Sprache!');

define('TEXT_WELCOME_INDEX','commerce:SEO ist eine Open-Source e-commerce L&ouml;sung, die st&auml;ndig vom commerce:SEO Team und einer großen Gemeinschaft weiterentwickelt wird.<br /><br />commerce:SEO ist auf jedem System lauff&auml;hig, welches eine PHP Umgebung (ab PHP 5.1) und eine mySQL-Datenbank zur Verf&uuml;gung stellt, wie zum Beispiel Linux, Solaris und Microsoft Windows.<br /><br />');
define('TEXT_WELCOME_STEP1','<b>Datenbank- und Webservereinstellungen</b><br /><br />Der Installer ben&ouml;tigt hier einige Informationen bez&uuml;glich Ihrer Datenbank und Ihrer Verzeichnisstruktur.');
define('TEXT_WELCOME_STEP2','<b>Datenbank Installation</b><br /><br />Der commerce:SEO Installer installiert automatisch die commerce:SEO-Datenbank.');
define('TEXT_WELCOME_STEP3','<b>Datenbank Import.</b><br /><br />Die Daten der commerce:SEO v2 Datenbank werden automatisch in die Datenbank importiert.');
define('TEXT_WELCOME_STEP4','<b>Konfiguration der commerce:SEO Konfig-Dateien</b><br /><br /><b>Wenn bereits configure Dateien aus einer fr&uuml;heren Installation vorhanden sind, wird commerce:SEO diese L&ouml;schen.</b><br /><br />Der Installer schreibt die automatisch die Konfigurationsdateien f&uuml;r die Dateistruktur und die Datenbankanbindung.<br /><br />Sie k&ouml;nnen zwischen verschiedenen Session-Handling Varianten w&auml;hlen.');
define('TEXT_WELCOME_STEP5','<b>Webserver Konfiguration</b><br /><br />');
define('TEXT_WELCOME_STEP6','<b>Grunds&auml;tzliche Shopkonfiguration</b><br /><br />Der Installer richtet einen Haupt-Admin-Account ein und schreibt noch diverse Daten in die Datenbank.<br />Die angegebenen Daten f&uuml;r <b>Land</b> und <b>Postleitzahl</b> werden f&uuml;r die Versand- und Steuerberechnungen genutzt.<br /><br />Wenn Sie w&uuml;nschen, kann commerce:SEO automatisch die Zonen, Steuers&auml;tze und Steuerklassen f&uuml;r Versand und Verkauf innerhalb der EU einrichten.');
define('WRONG_FOLDER_PEMISSION','<strong><span style="color:#EB5E00">Achtung</span> - Falsche Rechte f&uuml;r folgende Verzeichnisse</strong>');
define('ATTENTION','Achtung');
define('TEXT_USTID','Ihre UST-ID');
define('WRONG_FILE_PERMISSION','Falsche Rechte f&uuml;r folgende Dateien');
define('CORRECT_FILE_PERMISSION','Die Zugriffsrechte f&uuml;r die Dateien sind richtig gesetzt.');
define('CORRECT_FOLDER_PERMISSION','Die Zugriffsrechte f&uuml;r die Verzeichnisse sind richtig gesetzt.');
define('SERVER_INFO','Zusatzinfo');

// install_step1.php

define('TITLE_CUSTOM_SETTINGS','Installations Optionen');
define('TEXT_IMPORT_DB','Importiere die commerce:SEO (inklusive DEMO Daten!) Datenbank');
define('TEXT_IMPORT_DB_LONG','Importiere die commerce:SEO Datenbankstruktur, welche die Tabellen und Beispieldaten enth&auml;lt.');
define('TEXT_AUTOMATIC','Automatische Konfiguration');
define('TEXT_AUTOMATIC_LONG','Ihre Informationen bez&uuml;glich Webserver und Datenbank werden automatisch in die ben&ouml;tigten Catalog und Admin Konfigurations-Dateien geschrieben..');
define('TITLE_DATABASE_SETTINGS','Datenbank Informationen');
define('TEXT_DATABASE_SERVER','Datenbankserver');
define('TEXT_DATABASE_SERVER_LONG','Der Datenbankserver kann entweder in Form eines Hostnamens, wie zum Beispiel <i>db1.myserver.com</i> oder <i>localhost</i>, oder als IP-Adresse, wie <i>192.168.0.1</i> angegeben werden.');
define('TEXT_USERNAME','Benutzername');
define('TEXT_USERNAME_LONG','Der Benutzername, der zum konnektieren der Datenbank ben&ouml;tigt wird, wie zum Beispiel <i>mysql_10</i>.<br /><br />Bemerkung: Wenn die commerce:SEO Datenbank Importiert werden soll (wenn oben ausgew&auml;hlt), muss der Benutzer CREATE und DROP Rechte f&uuml;r die Datenbank haben. Sollten hier Probleme auftreten, kann Ihnen Ihr Provider weiterhelfen.');
define('TEXT_PASSWORD','Passwort');
define('TEXT_PASSWORD_LONG','Das Passwort wird zusammen mit dem Benutzernamen zum Verbindungsaufbau zur Datenbank benutzt.');
define('TEXT_DATABASE','Datenbank');
define('TEXT_DATABASE_LONG','Der Name der Datenbank, in die die Tabellen eingef&uuml;gt werden sollen.<br /><b>ACHTUNG:</b> Es muss bereits eine leere Datenbank vorhanden sein, falls nicht -> leere Datenbank mit phpMyAdmin erstellen!');
define('TITLE_WEBSERVER_SETTINGS','Webserver Informationen');
define('TEXT_WS_ROOT','Webserver Root Verzeichnis');
define('TEXT_WS_ROOT_LONG','Das Verzeichnis, in das die Webseiten gespeichert werden, zum Beispiel <i>/home/myname/public_html</i>.');
define('TEXT_WS_CSEO','Webserver <i>commerce:SEO</i> Verzeichnis');
define('TEXT_WS_CSEO_LONG','Das Verzeichnis, in welches die Shopdateien des Catalogs geladen wurden (vom Webserver root Verzeichnis), beispielsweise <i>/home/myname/public_html<b>/commerceseo/</b></i>.');
define('TEXT_WS_ADMIN','Webserver Admin Verzeichnis');
define('TEXT_WS_ADMIN_LONG','Das Verzeichnis, in welchem sich die Admin-Werkzeuge Ihres Shops befinden (vom Webserver root Verzeichnis), beispielsweise <i>/home/myname/public_html<b>/commerceseo/admin/</b></i>.');
define('TEXT_WS_CATALOG','WWW Catalog Verzeichnis');
define('TEXT_WS_CATALOG_LONG','Das virtuelle Verzeichnis, in dem sich die commerce:SEO Catalog-Module befinden, beispielsweise <i>http://www.Ihre-Domain.de<b>/commerceseo/</b></i>.');
define('TEXT_WS_ADMINTOOL','WWW Admin Verzeichnis');
define('TEXT_WS_ADMINTOOL_LONG','Das virtuelle Verzeichnis, in dem sich die commerce:SEO Admin-Module befinden, beispielsweise <i>http://www.Ihre-Domain.de<b>/commerceseo/admin/</b></i>');

// install_step2.php

define('TEXT_PROCESS_1','Bitte setzten Sie die Installation nun fort, um die Datenbank zu importieren.');
define('TEXT_PROCESS_2','Dieser Vorgang nimmt einige Zeit in Anspruch. Es ist wichtig, dass Sie den Vorgang nicht unterbrechen, da sonst die Datenbank m&ouml;glicherweise nicht korrekt installiert wird.');
define('TEXT_PROCESS_3','Die zu importierende Datei muss sich an folgendem Ort befinden:');


// install_step3.php

define('TEXT_TITLE_ERROR','Der folgende Fehler ist aufgetreten:');
define('TEXT_TITLE_SUCCESS','Der Datenbank-Import war erfolgreich.');

// install_step4.php
define('TITLE_WEBSERVER_CONFIGURATION','Webserver Informationen:');
define('TITLE_STEP4_ERROR','Der folgenden Fehler ist aufgetreten:');
define('TEXT_STEP4_ERROR','<b>Die Konfigurationsdateien existieren nicht, oder deren Rechte sind nicht richtig gesetzt.</b><br /><br />Bitte F&uuml;hren Sie folgende Aktionen durch: ');
define('TEXT_STEP4_ERROR_1','Wenn <i>chmod 706</i> nicht funktioniert, versuchen Sie <i>chmod 777</i>.');
define('TEXT_STEP4_ERROR_2','Wenn Sie diese Installationsroutine in einer Windows Umgebung ausf&uuml;hren, versuchen Sie das Umbenennen der entsprechenden Dateien.');
define('TEXT_VALUES','Die folgenden Kofiguarations-Werte werden nun in die Dateien geschrieben:');
define('TITLE_CHECK_CONFIGURATION','Bitte pr&uuml;fen Sie Ihre Webserver Informationen');
define('TEXT_HTTP','HTTP Server');
define('TEXT_HTTP_LONG','Der Webserver kann als Hostnamen, wie zum Beispiel <i>http://www.myserver.com</i>, oder als IP-Adresse <i>http://192.168.0.1</i> angegeben werden.');
define('TEXT_HTTPS','HTTPS Server');
define('TEXT_HTTPS_LONG','Der gesicherte Webserver kann als Hostnamen, wie zum Beispiel <i>https://www.myserver.com</i>, oder als IP-Adresse <i>https://192.168.0.1</i> angegeben werden.');
define('TEXT_SSL','Benutze SSL-Verbindung');
define('TEXT_SSL_LONG','Erm&ouml;glicht die Nutzung einer gesicherten Verbindung mittels SSL (HTTPS)');
define('TITLE_CHECK_DATABASE','Bitte &uuml;berpr&uuml;fen Sie Ihre Datenbank Informationen');
define('TEXT_PERSIST','Benutze Persistente Verbindung');
define('TEXT_PERSIST_LONG','H&auml;lt eine Verbindung zur Datenbank f&uuml;r l&auml;ngere Zeit aufrecht. Auf den meisten geteilten Servern ist diese Funktion nicht m&ouml;glich.');
define('TEXT_SESS_FILE','Speichere Sessions in Dateien.');
define('TEXT_SESS_DB','Speichere Sessions in der Datenbank');
define('TEXT_SESS_LONG','Das Verzeichnis, in welches PHP die Session-Dateien speichert.');

// install_step5.php

define('TEXT_WS_CONFIGURATION_SUCCESS','<strong>commerce:SEO</strong> Webserver Konfiguration war erfolgreich');

// install_step6.php

define('TITLE_ADMIN_CONFIG','Administrator Konfiguration');
define('TEXT_REQU_INFORMATION','* erforderliche Information');
define('TEXT_FIRSTNAME','Vorname');
define('TEXT_LASTNAME','Nachname');
define('TEXT_EMAIL','Admin-E-Mail Adresse');
define('TEXT_EMAIL_LONG','E-Mail Adresse, an die eine separate Mail bei Bestellungen gesendet werden soll.');
define('TEXT_STREET','Stra&szlig;e');
define('TEXT_STREET_NUM','Nr.');
define('TEXT_POSTCODE','PLZ');
define('TEXT_CITY','Stadt');
define('TEXT_STATE','Bundesland');
define('TEXT_COUNTRY','Land');
define('TEXT_COUNTRY_LONG','Wird benutzt f&uuml;r Versand und Steuern.');
define('TEXT_TEL','Telefonnummer');
define('TEXT_PASSWORD','Passwort');
define('TEXT_PASSWORD_CONF','Passwort Best&auml;tigung');
define('TITLE_SHOP_CONFIG','Shop Konfiguration');
define('TEXT_STORE','Shop Name');
define('TEXT_STORE_LONG','Der Name des Shops.');
define('TEXT_EMAIL_FROM','Absender-E-Mail');
define('TEXT_EMAIL_FROM_LONG','Die E-Mail Adresse, die in den Bestellungen als From benutzt wird.');
define('TITLE_ZONE_CONFIG','Zonen Konfiguration');
define('TEXT_ZONE','automatisches Einstellen der Steuerzonen?');
define('TITLE_ZONE_CONFIG_NOTE','commerce:SEO kann die Zonen automatisch aufsetzten, sofern Sich Ihr Shop in der EU befindet.');
define('TITLE_SHOP_CONFIG_NOTE','Information for grundlegende Shopeinstellungen');
define('TITLE_ADMIN_CONFIG_NOTE','Informationen f&uuml;r Admin/Superuser zum versenden der E-Mails');
define('TEXT_ZONE_NO','Nein');
define('TEXT_ZONE_YES','Ja');
define('TEXT_COMPANY','Firmenname');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Ihre Passw&ouml;rter stimmen nicht &uuml;berein.');
define('TEXT_PASSWORD_STRONG', 'Passwortst&auml;rke:');

// install_step7
define('TEXT_WELCOME_STEP7','<b>Setup f&uuml;r G&auml;ste und Standardkunden</b><br /><br />Das <strong>commerce:SEO</strong> Gruppen und Preissystem bietet Ihnen unbegrenzte M&ouml;glichkeiten der Preisgebung.<br /><br />
<b>% Rabatt auf ein einzelnes Produkt</b><br />
%max kann f&uuml;r jedes einzelne Produkt und f&uuml;r jede einzelne Kundengruppe gesetzt werden.<br />
wenn %max f&uuml;r Produkt = 10.00% jedoch %max f&uuml;r Gruppe = 5% -> 5% Rabatt auf das Produkt<br />
wenn %max f&uuml;r Produkt = 10.00% jedoch %max f&uuml;r Gruppe = 15% -> 10% Rabatt auf das Produkt<br /><br />
<b>% Rabatt auf die Gesamte Bestellung</b><br />
% Rabatt des Bestellwertes (nach Steuer und W&auml;hrungsberechnung)<br /><br />
<b>Staffelpreise</b><br />
Sie k&ouml;nnen ebenfalls beliebig viele Staffelpreise f&uuml;r einzelne Produkte und einzelne Kundengruppen einrichten.<br />
Sie k&ouml;nnen auch jedes dieser Systeme beliebig kombinieren, wie zum Beispiel:<br />
Kundengruppe 1 -> Staffelpreise auf das Produkt Y<br />
Kundengruppe 2 -> 10% Rabatt auf Produkt Y<br />
Kundengruppe 3 -> ein spezielle Gruppenpreis f&uuml;r Produkt Y<br />
Kundengruppe 4 -> Nettopreis f&uuml;r Produkt Y<br />
');
define('TITLE_GUEST_CONFIG','Gast Konfiguration');
define('TITLE_GUEST_CONFIG_NOTE','Gast-User Einstellungen (nicht-registrierter Benutzer)');
define('TITLE_CUSTOMERS_CONFIG','Standard-Kunde Konfiguration');
define('TITLE_MERCHANT_CONFIG','Standard-H&auml;ndler Konfiguration');
define('TITLE_MERCHANT_CONFIG_NOTE','Standard-H&auml;ndler Einstellungen (&uuml;ber die USt-ID identifizierte Kunden)');
define('TITLE_CUSTOMERS_CONFIG_NOTE','Standard-Kunde Einstellungen (registrierter Kunde)');
define('TEXT_STATUS_DISCOUNT','Rabatt auf Produkte');
define('TEXT_STATUS_DISCOUNT_LONG','Rabatt auf Produkte <i>(in Prozent, z.B. 10.00 , 20.00)</i>');
define('TEXT_STATUS_OT_DISCOUNT_FLAG','Rabatt auf Bestellung');
define('TEXT_STATUS_OT_DISCOUNT_FLAG_LONG',' Erlaubt den Rabatt auf den kompletten Bestellwert');
define('TEXT_STATUS_OT_DISCOUNT','Rabatth&ouml;he auf Bestellung');
define('TEXT_STATUS_OT_DISCOUNT_LONG','H&ouml;he des Rabattes auf den Bestellwert <i>(in Prozent, z.B. 10.00 , 20.00)</i>');
define('TEXT_STATUS_GRADUATED_PRICE','Staffelpreise');
define('TEXT_STATUS_GRADUATED_PRICE_LONG','Erlaubt es dem entsprechenden User die Staffelpreise zu sehen.');
define('TEXT_STATUS_SHOW_PRICE','Preise');
define('TEXT_STATUS_SHOW_PRICE_LONG','Erlaubt es dem User, normale Preise zu sehen.');
define('TEXT_STATUS_SHOW_TAX','incl. Steuer');
define('TEXT_STATUS_SHOW_TAX_LONG','Zeigt die angegebenen Preise mit (Ja) oder ohne (Nein) Steuer.');
define('TEXT_STATUS_COD_PERMISSION','Per Nachnahme');
define('TEXT_STATUS_COD_PERMISSION_LONG','Erlaubt dem Kunden per Nachnahme zu bestellen.');
define('TEXT_STATUS_CC_PERMISSION','Kreditkarten.');
define('TEXT_STATUS_CC_PERMISSION_LONG','Erlaubt dem Kunden &uuml;ber ihre Kreditkartenzahlsysteme zu bestellen.');
define('TEXT_STATUS_BT_PERMISSION','Bankeinzug');
define('TEXT_STATUS_BT_PERMISSION_LONG','Erlaubt dem Kunden per Bankeinzug zu bestellen.');

// install_fnished.php
define('TEXT_SHOP_CONFIG_SUCCESS','<strong>commerce:SEO</strong> Shop Konfiguration war erfolgreich');
define('TEXT_TEAM','Vielen Dank, dass Sie sich f&uuml;r commerce:SEO entschieden haben. Besuchen Sie uns auf der commerce:SEO Supportseite <a href="http://support.commerce-seo.de/">http://support.commerce-seo.de/</a><br /><p><strong>Alles Gute und viel Erfolg w&uuml;nscht Ihnen das gesamte commerce:SEO Team.</strong></p>');
define('TEXT_WELCOME_FINISHED','Der Installer hat nun die Grundfunktionen Ihres Shops eingerichtet. Melden Sie sich im Shop mit Ihrem Admin-Account an und wechseln in den Adminbereich, um die abschliessende Konfiguration Ihres Shops vorzunehmen. Wie das aktivieren der Suchmaschinen freundlichen URL\'s oder anpassen der "Personal Links"');

//Charset
define('SELECT_CHARSET','Aktuelle DB Konvertierung: ');
define('SELECT_CHARSET_DESC','<br /><i style="color:red">Sie nutzen die falsche Konvertierung für die Datenbank. Der Shop setzt UTF8 voraus!</i>');
define('CONVERT_DB','<br /><br /><b>jetzt umwandeln:</b> ');
define('CONVERT_DB_DESC','<br /><i>Die Datenbank wird im nächsten Schritt in UTF8 umgewandelt.</i>');
define('TEXT_BIRTHDAY','Geburtstag');
define('TEXT_SALT_KEY','Salt-Key');

define('TEXT_SALT_KEY_LONG','Dieser Key diehnt zur stärkeren Verschlüsselung der Passwörter.');
define('TEXT_CANCEL','Vorgang abbrechen');


?>