<?php
/*-----------------------------------------------------------------
* 	$Id: configuration.php 485 2013-07-15 14:27:21Z akausch $
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

define('TABLE_HEADING_CONFIGURATION_TITLE', 'Name');
define('TABLE_HEADING_CONFIGURATION_VALUE', 'Wert');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_EDIT_INTRO', 'Bitte f&uuml;hren Sie alle notwendigen &Auml;nderungen durch');
define('TEXT_INFO_DATE_ADDED', 'hinzugef&uuml;gt am:');
define('TEXT_INFO_LAST_MODIFIED', 'letzte &Auml;nderung:');

// commerce:SEO
define('PRODUCT_LISTING_MANU_NAME_TITLE','Herstellername');
define('PRODUCT_LISTING_MANU_NAME_DESC','Herstellername in der Produkt&uuml;bersichtsseite anzeigen?<br />Wird automatisch verlinkt.');
define('PRODUCT_LISTING_MANU_IMG_TITLE','Herstellerbild');
define('PRODUCT_LISTING_MANU_IMG_DESC','Herstellerbild in der Produkt&uuml;bersichtsseite anzeigen?<br />Wird automatisch verlinkt.');
define('PRODUCT_LISTING_VPE_TITLE','VPE Anzeige');
define('PRODUCT_LISTING_VPE_DESC','VPE Anzeige in der Produkt&uuml;bersichtsseite anzeigen?');
define('PRODUCT_LISTING_MODEL_TITLE','Modelnummer');
define('PRODUCT_LISTING_MODEL_DESC','Modelnummer in der Produkt&uuml;bersichtsseite anzeigen?');
define('PDF_IN_ODERMAIL_TITLE','PDF in Bestellbest&auml;tigungsmail');
define('PDF_IN_ODERMAIL_DESC','Soll der Bestellbest&auml;tigungmail eine oder mehrere PDF\'s angeh&auml;ngt werden?');
define('PDF_IN_ORDERMAIL_COID_TITLE','Content ID/s ');
define('PDF_IN_ORDERMAIL_COID_DESC','Nummer des Contents von der die PDF/s erzeugt werden sollen. Ohne Leerzeichen, Kommagetrennt und ohne Komma am Ende.<br /> Beispiel: 2,3,10');
define('BOXLESS_CHECKOUT_TITLE','Boxenloser Checkout');
define('BOXLESS_CHECKOUT_DESC','Sollen die boxen beim Checkout ausgeblendet werden?');
define('IMAGE_NAME_CATEGORIE_TITLE','Namensformat - Kategorie');
define('IMAGE_NAME_CATEGORIE_DESC','Wie sollen die Namen der Kategoriebilder im Shop abgelegt werden?<br /><br />c_id = Die Kategorie ID wird genutzt : 2337.jpg<br />c_name = Der Kategorienamen wird genutzt, aus Technischen gr&uuml;nden derzeit immer in Deutsch : Erste-Kategorie.jpg<br />c_image = Die Bildername wird beibehalten : bohrmaschinen.jpg');
define('IMAGE_NAME_PRODUCT_TITLE','Namensformat - Produkte');
define('IMAGE_NAME_PRODUCT_DESC','Wie sollen die Namen der Produktbilder im Shop abgelegt werden?<br /><br />p_id = Die Produkt ID wird genutzt : 34.jpg, 34-1.jpg, usw.<br />p_name = Der Produktnamen wird genutzt, aus Technischen gr&uuml;nden derzeit immer in Deutsch : Das-erste-Produkt.jpg, Das-erste-Produkt-1.jpg<br />p_image = Die Bildername wird bebehalten : dvd_57h.jpg, dvd_57h-1.jpg');
define('DOWN_FOR_MAINTENANCE_TITLE','<b style="color:red">Wartungsmodus</b>');
define('DOWN_FOR_MAINTENANCE_DESC','Wartungsmodus aktivieren?<br />Sie k&ouml;nnen den Text f&uuml;r jede Sprache im <a href="content_manager.php">Content-Manager</a> einzeln anpassen.');

define('CHECKOUT_SHOW_SHIPPING_MODULES_TITLE','Versandmodule aufgeklappt?');
define('CHECKOUT_SHOW_SHIPPING_MODULES_DESC','Sollen die Versandmodule standardm&auml;&szlig;ig angezeigt werden?');
define('CHECKOUT_SHOW_SHIPPING_ADDRESS_TITLE','Versandadresse aufgeklappt?');
define('CHECKOUT_SHOW_SHIPPING_ADDRESS_DESC','Soll die Versandadresse standardm&auml;&szlig;ig angezeigt werden?');
define('CHECKOUT_SHOW_PAYMENT_MODULES_TITLE','Zahlungsmethoden aufgeklappt?');
define('CHECKOUT_SHOW_PAYMENT_MODULES_DESC','Sollen die Zahlungsmethoden standardm&auml;&szlig;ig angezeigt werden?');
define('CHECKOUT_SHOW_PAYMENT_ADDRESS_TITLE','Rechnungsadresse aufgeklappt?');
define('CHECKOUT_SHOW_PAYMENT_ADDRESS_DESC','Soll die Rechnungsadresse standardm&auml;&szlig;ig angezeigt werden?');
define('CHECKOUT_SHOW_COMMENTS_TITLE','Kommentarfeld aufgeklappt?');
define('CHECKOUT_SHOW_COMMENTS_DESC','Soll das Kommentarfeld standardm&auml;&szlig;ig angezeigt werden?');
define('CHECKOUT_SHOW_PRODUCTS_TITLE','Artikelliste aufgeklappt?');
define('CHECKOUT_SHOW_PRODUCTS_DESC','Sollen die Produktliste standardm&auml;&szlig;ig angezeigt werden?');
define('CHECKOUT_SHOW_AGB_TITLE','AGBs aufgeklappt?');
define('CHECKOUT_SHOW_AGB_DESC','Sollen die allgemeinen Gesch&auml;ftsbedingungen standardm&auml;&szlig;ig angezeigt werden?');
define('CHECKOUT_SHOW_DSG_TITLE','Datenschutz aufgeklappt');
define('CHECKOUT_SHOW_DSG_DESC','Sollen die Datenschutzbestimmungen standardm&auml;&szlig;ig aufgeklappt werden?');
define('CHECKOUT_SHOW_REVOCATION_TITLE','Widerrufrecht aufgeklappt?');
define('CHECKOUT_SHOW_REVOCATION_DESC','Soll das Widerrufrecht standardm&auml;&szlig;ig angezeigt werden?');
define('CHECKOUT_AJAX_PRODUCTS_TITLE','M&ouml;glichkeit Artikelliste zu editieren?');
define('CHECKOUT_AJAX_PRODUCTS_DESC','Sollen die Kunden w&auml;hrend des Bestellprozesses die M&ouml;glichkeit haben, die Artikel zu editieren?');
define('CHECKOUT_AJAX_STAT_TITLE','AJAX Checkout Prozess aktiviert?');
define('CHECKOUT_AJAX_STAT_DESC','Sollen die Kunden &uuml;ber einen vereinfachten und kompakten Bestellvorgang Ihre Artikel bestellen?');

// language definitions for config
define('STORE_NAME_TITLE' , 'Name des Shops');
define('STORE_NAME_DESC' , 'Der Name dieses Online Shops');
define('STORE_OWNER_TITLE' , 'Inhaber');
define('STORE_OWNER_DESC' , 'Der Name des Shop-Betreibers');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE' , 'Email Adresse');
define('STORE_OWNER_EMAIL_ADDRESS_DESC' , 'Die Email Adresse des Shop-Betreibers');

define('EMAIL_FROM_TITLE' , 'Email von');
define('EMAIL_FROM_DESC' , 'Email Adresse die beim versenden (send mail)benutzt werden soll.');

define('STORE_COUNTRY_TITLE' , 'Land');
define('STORE_COUNTRY_DESC' , 'Das Land aus dem der Versand erfolgt <br /><b>Hinweis: Bitte nicht vergessen die Region richtig anzupassen.</b>');
define('STORE_ZONE_TITLE' , 'Region');
define('STORE_ZONE_DESC' , 'Die Region des Landes aus dem der Versand erfolgt.');

define('EXPECTED_PRODUCTS_SORT_TITLE' , 'Reihenfolge f&uuml;r Artikelank&uuml;ndigungen');
define('EXPECTED_PRODUCTS_SORT_DESC' , 'Das ist die Reihenfolge wie angek&uuml;ndigte Artikel angezeigt werden.');
define('EXPECTED_PRODUCTS_FIELD_TITLE' , 'Sortierfeld f&uuml;r Artikelank&uuml;ndigungen');
define('EXPECTED_PRODUCTS_FIELD_DESC' , 'Das ist die Spalte die zum Sortieren angek&uuml;ndigter Artikel benutzt wird.');

define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE' , 'Auf die Landesw&auml;hrung automatisch umstellen');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC' , 'Wenn die Spracheinstellung gewechselt wird automatisch die W&auml;hrung anpassen.');

define('SEND_EXTRA_ORDER_EmailS_TO_TITLE' , 'Senden einer extra Bestell-Email an:');
define('SEND_EXTRA_ORDER_EmailS_TO_DESC' , 'Wenn zus&auml;tzlich eine Kopie des Bestell-Emails versendet werden soll, bitte in dieser Weise die Empfangs-Adressen auflisten: Name 1 &lt;Email@adresse1&gt;, Name 2 &lt;Email@adresse2&gt;');

define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE' , 'Suchmaschinenfreundliche URLs benutzen?');
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC' , 'Die Seiten URLs k&ouml;nnen automatisch f&uuml;r Suchmaschinen optimiert angezeigt werden.');

define('DISPLAY_CART_TITLE' , 'Soll Warenkorb nach dem einf&uuml;gen Angezeigt werden?');
define('DISPLAY_CART_DESC' , 'Nach dem hinzuf&uuml;gen eines Artikels zum Warenkorb, oder zur&uuml;ck zum Artikel?');

define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE' , 'G&auml;sten erlauben, ihre Bekannten per Email zu informieren?');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC' , 'G&auml;sten erlauben, ihre Bekannten per Email &uuml;ber Artikel zu informieren?');

define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE' , 'Suchverkn&uuml;pfungen');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC' , 'Standard Operator zum Verkn&uuml;pfen von Suchw&ouml;rtern.');

define('STORE_NAME_ADDRESS_TITLE' , 'Gesch&auml;ftsadresse und Telefonnummer etc');
define('STORE_NAME_ADDRESS_DESC' , 'Tragen Sie hier Ihre Gesch&auml;ftsadresse wie in einem Briefkopf ein.');

define('SHOW_COUNTS_TITLE' , 'Artikelanzahl hinter Kategorienamen?');
define('SHOW_COUNTS_DESC' , 'Z&auml;hlt rekursiv die Anzahl der verschiedenen Artikel pro Warengruppe, und zeigt die anzahl (x) hinter jedem Kategorienamen');

define('DISPLAY_PRICE_WITH_TAX_TITLE' , 'Preis inkl. MwSt. anzeigen');
define('DISPLAY_PRICE_WITH_TAX_DESC' , 'Preise inklusive Steuer anzeigen (true) oder am Ende aufrechnen (false)');

define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_TITLE' , 'Kundenstatus(Kundengruppe) f&uuml;r Administratoren');
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_DESC' , 'W&auml;hlen Sie den Kundenstatus(Gruppe) f&uuml;r Administratoren anhand der jeweiligen ID!');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_TITLE' , 'Kundenstatus(Kundengruppe) f&uuml;r G&auml;ste');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_DESC' , 'W&auml;hlen Sie den Kundenstatus(Gruppe) f&uuml;r G&auml;ste anhand der jeweiligen ID!');
define('DEFAULT_CUSTOMERS_STATUS_ID_TITLE' , 'Kundenstatus f&uuml;r Neukunden');
define('DEFAULT_CUSTOMERS_STATUS_ID_DESC' , 'W&auml;hlen Sie den Kundenstatus(Gruppe) f&uuml;r G&auml;ste anhand der jeweiligen ID!<br />TIPP: Sie k&ouml;nnen im Men&uuml; Kundengruppen weitere Gruppen einrichten und zb Aktionswochen machen: Diese Woche 10 % Rabatt f&uuml;r alle Neukunden?');

define('ALLOW_ADD_TO_CART_TITLE' , 'Erlaubt, Artikel in den Einkaufswagen zu legen');
define('ALLOW_ADD_TO_CART_DESC' , 'Erlaubt das Einf&uuml;gen von Artikeln in den Warenkorb auch dann, wenn "Preise anzeigen" in der Kundengruppe auf "Nein" steht');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_TITLE' , 'Rabatte auch auf die Artikelattribute verwenden?');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_DESC' , 'Erlaubt, den eingestellten Rabatt der Kundengruppe auch auf die Artikelattribute anzuwenden (Nur wenn der Artikel nicht als "Sonderangebot" ausgewiesen ist)');
define('CURRENT_TEMPLATE_TITLE' , 'Template');
define('CURRENT_TEMPLATE_DESC' , 'W&auml;hlen Sie ein Template aus. Das Template muss sich im Ordner /templates/ befinden.<br /><b style="color:red">ACHTUNG: Beim Wechsel des Templates unbedingt den Shop-Cache leeren!</b><br />Weitere Templates finden sie unter <a href="http://www.seo-template.de">http://www.seo-template.de</a>');
define('TEMPLATE_TITLE' , 'Templateset (Theme)');
define('TEMPLATE_DESC' , 'W&auml;hlen Sie ein Templateset (Theme) aus. Das Template muss sich im Ordner /templates/ befinden.<br /><br />Weitere Templates finden sie unter <a href="http://www.seo-template.de">http://www.seo-template.de</a>');
define('CC_KEYCHAIN_TITLE','CC String');
define('CC_KEYCHAIN_DESC','String zur verschl&uuml;sselung der CC Informationen (Bitte umbedingt &auml;ndern!)');

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE' , 'Vorname');
define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des Vornamens');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE' , 'Nachname');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des Nachnamens');
define('ENTRY_DOB_MIN_LENGTH_TITLE' , 'Geburtsdatum');
define('ENTRY_DOB_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des Geburtsdatums');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE' , 'Email Adresse');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC' , 'Minimum L&auml;nge der Email Adresse');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE' , 'Strasse');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC' , 'Minimum L&auml;nge der Strassenanschrift');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE' , 'Firma');
define('ENTRY_COMPANY_MIN_LENGTH_DESC' , 'Minimuml&auml;nge des Firmennamens');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE' , 'Postleitzahl');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC' , 'Minimum L&auml;nge der Postleitzahl');
define('ENTRY_CITY_MIN_LENGTH_TITLE' , 'Stadt');
define('ENTRY_CITY_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des St&auml;dtenamens');
define('ENTRY_STATE_MIN_LENGTH_TITLE' , 'Bundesland');
define('ENTRY_STATE_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des Bundeslandes');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE' , 'Telefon Nummer');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC' , 'Minimum L&auml;nge der Telefon Nummer');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE' , 'Passwort');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des Passwort');

define('CC_OWNER_MIN_LENGTH_TITLE' , 'Kreditkarteninhaber');
define('CC_OWNER_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des Namens des Kreditkarteninhabers');
define('CC_NUMBER_MIN_LENGTH_TITLE' , 'Kreditkartennummer');
define('CC_NUMBER_MIN_LENGTH_DESC' , 'Minimum L&auml;nge von Kreditkartennummern');

define('REVIEW_TEXT_MIN_LENGTH_TITLE' , 'Bewertungen');
define('REVIEW_TEXT_MIN_LENGTH_DESC' , 'Minimum L&auml;nge der Texteingabe bei Bewertungen');

define('MIN_DISPLAY_BESTSELLERS_TITLE' , 'Bestseller');
define('MIN_DISPLAY_BESTSELLERS_DESC' , 'Minimum Anzahl der Bestseller, die angezeigt werden sollen');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE' , 'Ebenfalls gekauft');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC' , 'Minimum Anzahl der ebenfalls gekauften Artikel, die bei der Artikelansicht angezeigt werden sollen');

define('MAX_ADDRESS_BOOK_ENTRIES_TITLE' , 'Adressbuch Eintr&auml;ge');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC' , 'Maximum erlaubte Anzahl an Adressbucheintr&auml;gen');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE' , 'Suchergebnisse');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC' , 'Anzahl der Artikel die als Suchergebnis angezeigt werden sollen');
define('MAX_DISPLAY_PAGE_LINKS_TITLE' , 'Seiten bl&auml;ttern');
define('MAX_DISPLAY_PAGE_LINKS_DESC' , 'Anzahl der Einzelseiten, f&uuml;r die ein Link angezeigt werden soll im Seitennavigationsmen&uuml;');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE' , 'Sonderangebote');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC' , 'Maximum Anzahl an Sonderangeboten, die angezeigt werden sollen');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE' , 'Neue Artikel Anzeigemodul');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC' , 'Maximum Anzahl an neuen Artikeln, die bei den Warenkategorien angezeigt werden sollen');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE' , 'Erwartete Artikel Anzeigemodul');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC' , 'Maximum Anzahl an erwarteten Artikeln die auf der Startseite angezeigt werden sollen');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE' , 'Hersteller-Liste Schwellenwert');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC' , 'In der Hersteller Box; Wenn die Anzahl der Hersteller diese Schwelle &uuml;bersteigt wird anstatt der &uuml;blichen Liste eine Popup Liste angezeigt');
define('MAX_MANUFACTURERS_LIST_TITLE' , 'Hersteller Liste');
define('MAX_MANUFACTURERS_LIST_DESC' , 'In der Hersteller Box; Wenn der Wert auf "1" gesetzt wird, wird die Herstellerbox als Drop Down Liste angezeigt. Andernfalls als Liste.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE' , 'L&auml;nge des Herstellernamens');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC' , 'In der Hersteller Box; Maximum L&auml;nge von Namen in der Herstellerbox');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE' , 'Neue Bewertungen');
define('MAX_DISPLAY_NEW_REVIEWS_DESC' , 'Maximum Anzahl an neuen Bewertungen die angezeigt werden sollen');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE' , 'Auswahlpool der Bewertungen');
define('MAX_RANDOM_SELECT_REVIEWS_DESC' , 'Aus wieviel Bewertungen sollen die zuf&auml;llig angezeigten Bewertungen in der Box ausgew&auml;hlt werden?');
define('MAX_RANDOM_SELECT_NEW_TITLE' , 'Auswahlpool der Neuen Artikel');
define('MAX_RANDOM_SELECT_NEW_DESC' , 'Aus wieviel neuen Artikeln sollen die zuf&auml;llig angezeigten neuen Artikel in der Box ausgew&auml;hlt werden?');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE' , 'Auswahlpool der Sonderangebote');
define('MAX_RANDOM_SELECT_SPECIALS_DESC' , 'Aus wieviel Sonderangeboten sollen die zuf&auml;llig angezeigten Sonderangebote in der Box ausgew&auml;hlt werden?');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE' , 'Anzahl an Warengruppen');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC' , 'Anzahl an Warengruppen die pro Zeile in den &Uuml;bersichten angezeigt werden sollen.');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE' , 'Neue Artikel Liste');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC' , 'Maximum Anzahl neuer Artikel die in der Liste angezeigt werden sollen.');
define('MAX_DISPLAY_BESTSELLERS_TITLE' , 'Bestsellers');
define('MAX_DISPLAY_BESTSELLERS_DESC' , 'Maximum Anzahl an Bestsellern die angezeigt werden sollen');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE' , 'Ebenfalls gekauft');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC' , 'Maximum Anzahl der ebenfalls gekauften Artikel, die bei der Artikelansicht angezeigt werden sollen');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE' , 'Bestell&uuml;bersichts Box');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC' , 'Maximum Anzahl an Artikeln die in der pers&ouml;nlichen Bestell&uuml;bersichts Box des Kunden angezeigt werden sollen.');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE' , 'Bestell&uuml;bersicht');
define('MAX_DISPLAY_ORDER_HISTORY_DESC' , 'Maximum Anzahl an Bestellungen die in der &Uuml;bersicht im Kundenbereich des Shop angezeigt werden sollen.');
define('MAX_PRODUCTS_QTY_TITLE', 'Maximale Produktanzahl');
define('MAX_PRODUCTS_QTY_DESC', 'Maximale Produktanzahl, die man eingeben kann');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_TITLE' , 'Anzahl der Tage f&uuml;r Neue Produkte');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_DESC' , 'Maximum Anzahl an Tagen die neue Artikel angezeigt werden sollen');

define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_TITLE' , 'Breite der Artikel-Thumbnails');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_DESC' , 'Maximale Breite der Artikel-Thumbnails in Pixel');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_TITLE' , 'H&ouml;he der Artikel-Thumbnails');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_DESC' , 'Maximale H&ouml;he der Artikel-Thumbnails in Pixel');

define('PRODUCT_IMAGE_INFO_WIDTH_TITLE' , 'Breite der Artikel-Info Bilder');
define('PRODUCT_IMAGE_INFO_WIDTH_DESC' , 'Maximale Breite der Artikel-Info Bilder in Pixel');
define('PRODUCT_IMAGE_INFO_HEIGHT_TITLE' , 'H&ouml;he der Artikel-Info Bilder');
define('PRODUCT_IMAGE_INFO_HEIGHT_DESC' , 'Maximale H&ouml;he der Artikel-Info Bilder in Pixel');

define('PRODUCT_IMAGE_MINI_WIDTH_TITLE' , 'Breite der Mini Bilder');
define('PRODUCT_IMAGE_MINI_WIDTH_DESC' , 'Maximale Breite der Mini Bilder in Pixel');
define('PRODUCT_IMAGE_MINI_HEIGHT_TITLE' , 'H&ouml;he der Mini Bilder');
define('PRODUCT_IMAGE_MINI_HEIGHT_DESC' , 'Maximale H&ouml;he der Mini Bilder in Pixel');

define('CATEGORY_INFO_IMAGE_WIDTH_TITLE' , 'Breite der Kategorie Bilder');
define('CATEGORY_INFO_IMAGE_WIDTH_DESC' , 'Maximale Breite der Kategorie Bilder in Pixel');
define('CATEGORY_INFO_IMAGE_HEIGHT_TITLE' , 'H&ouml;he der Kategorie Bilder');
define('CATEGORY_INFO_IMAGE_HEIGHT_DESC' , 'Maximale H&ouml;he der Kategorie Bilder in Pixel');

define('CATEGORY_IMAGE_WIDTH_TITLE' , 'Breite der Kategorie Thumb-Bilder');
define('CATEGORY_IMAGE_WIDTH_DESC' , 'Maximale Breite der Kategorie Thumb-Bilder in Pixel');
define('CATEGORY_IMAGE_HEIGHT_TITLE' , 'H&ouml;he der Kategorie Thumb-Bilder');
define('CATEGORY_IMAGE_HEIGHT_DESC' , 'Maximale H&ouml;he der Kategorie Thumb-Bilder in Pixel');


define('PRODUCT_IMAGE_POPUP_WIDTH_TITLE' , 'Breite der Artikel-Popup Bilder');
define('PRODUCT_IMAGE_POPUP_WIDTH_DESC' , 'Maximale Breite der Artikel-Popup Bilder in Pixel');
define('PRODUCT_IMAGE_POPUP_HEIGHT_TITLE' , 'H&ouml;he der Artikel-Popup Bilder');
define('PRODUCT_IMAGE_POPUP_HEIGHT_DESC' , 'Maximale H&ouml;he der Artikel-Popup Bilder in Pixel');

define('SMALL_IMAGE_WIDTH_TITLE' , 'Breite der Artikel Bilder');
define('SMALL_IMAGE_WIDTH_DESC' , 'Maximale Breite der Artikel Bilder in Pixel');
define('SMALL_IMAGE_HEIGHT_TITLE' , 'H&ouml;he der Artikel Bilder');
define('SMALL_IMAGE_HEIGHT_DESC' , 'Maximale H&ouml;he der Artikel Bilderin Pixel');

define('HEADING_IMAGE_WIDTH_TITLE' , 'Breite der &Uuml;berschrift Bilder');
define('HEADING_IMAGE_WIDTH_DESC' , 'Maximale Breite der &Uuml;berschrift Bilder in Pixel');
define('HEADING_IMAGE_HEIGHT_TITLE' , 'H&ouml;he der &Uuml;berschrift Bilder');
define('HEADING_IMAGE_HEIGHT_DESC' , 'Maximale H&ouml;he der &Uuml;berschriftbilder in Pixel');


define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE' , 'Bildgr&ouml;sse berechnen');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC' , 'Sollen die Bildgr&ouml;ssen berechnet werden?');

define('IMAGE_REQUIRED_TITLE' , 'Bilder werden ben&ouml;tigt?');
define('IMAGE_REQUIRED_DESC' , 'Wenn Sie hier auf "1" setzen, werden nicht vorhandene Bilder als Rahmen angezeigt. Gut f&uuml;r Entwickler.');

define('MO_PICS_TITLE', 'Anzahl zus&auml;tzlicher Produktbilder');
define('MO_PICS_DESC', 'Anzahl der Produktbilder die zus&auml;tzlich zum Haupt-Produktbild zur Verf&uuml;gung stehen sollen.');


//Mini Images

define('PRODUCT_IMAGE_MINI_BEVEL_TITLE' , 'Mini Bilder:Bevel<br />');
define('PRODUCT_IMAGE_MINI_BEVEL_DESC' , 'Mini Bilder:Bevel<br /><br />Default Wert: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Verwendung:<br />(edge width,hex light colour,hex dark colour)');

define('PRODUCT_IMAGE_MINI_GREYSCALE_TITLE' , 'Mini Bilder:Greyscale<br />');
define('PRODUCT_IMAGE_MINI_GREYSCALE_DESC' , 'Mini Bilder:Greyscale<br /><br />Default Wert: (32,22,22)<br /><br />basic black n white<br />Verwendung:<br />(int red,int green,int blue)');

define('PRODUCT_IMAGE_MINI_ELLIPSE_TITLE' , 'Mini Bilder:Ellipse<br />');
define('PRODUCT_IMAGE_MINI_ELLIPSE_DESC' , 'Mini Bilder:Ellipse<br /><br />Default Wert: (FFFFFF)<br /><br />ellipse on bg colour<br />Verwendung:<br />(hex background colour)');

define('PRODUCT_IMAGE_MINI_ROUND_EDGES_TITLE' , 'Mini Bilder:Round-edges<br />');
define('PRODUCT_IMAGE_MINI_ROUND_EDGES_DESC' , 'Mini Bilder:Round-edges<br /><br />Default Wert: (5,FFFFFF,3)<br /><br />corner trimming<br />Verwendung:<br />(edge_radius,background colour,anti-alias width)');

define('PRODUCT_IMAGE_MINI_MERGE_TITLE' , 'Mini Bilder:Merge<br />');
define('PRODUCT_IMAGE_MINI_MERGE_DESC' , 'Mini Bilder:Merge<br /><br />Default Wert: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Verwendung:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity, transparent colour on merge image)');

define('PRODUCT_IMAGE_MINI_FRAME_TITLE' , 'Mini Bilder:Frame<br />');
define('PRODUCT_IMAGE_MINI_FRAME_DESC' , 'Mini Bilder:Frame<br /><br />Default Wert: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Verwendung:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');

define('PRODUCT_IMAGE_MINI_DROP_SHADDOW_TITLE' , 'Mini Bilder:Drop-Shadow<br />');
define('PRODUCT_IMAGE_MINI_DROP_SHADDOW_DESC' , 'Mini Bilder:Drop-Shadow<br /><br />Default Wert: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Verwendung:<br />(shadow width,hex shadow colour,hex background colour)');

define('PRODUCT_IMAGE_MINI_MOTION_BLUR_TITLE' , 'Mini Bilder:Motion-Blur<br />');
define('PRODUCT_IMAGE_MINI_MOTION_BLUR_DESC' , 'Mini Bilder:Motion-Blur<br /><br />Default Wert: (4,FFFFFF)<br /><br />fading parallel lines<br />Verwendung:<br />(int number of lines,hex background colour)');


//This is for the Images showing your products for preview. All the small stuff.

define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_TITLE' , 'Artikel-Thumbnails:Bevel<br />');
define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_DESC' , 'Artikel-Thumbnails:Bevel<br /><br />Default Wert: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Verwendung:<br />(edge width,hex light colour,hex dark colour)');

define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_TITLE' , 'Artikel-Thumbnails:Greyscale<br />');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_DESC' , 'Artikel-Thumbnails:Greyscale<br /><br />Default Wert: (32,22,22)<br /><br />basic black n white<br />Verwendung:<br />(int red,int green,int blue)');

define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_TITLE' , 'Artikel-Thumbnails:Ellipse<br />');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_DESC' , 'Artikel-Thumbnails:Ellipse<br /><br />Default Wert: (FFFFFF)<br /><br />ellipse on bg colour<br />Verwendung:<br />(hex background colour)');

define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_TITLE' , 'Artikel-Thumbnails:Round-edges<br />');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_DESC' , 'Artikel-Thumbnails:Round-edges<br /><br />Default Wert: (5,FFFFFF,3)<br /><br />corner trimming<br />Verwendung:<br />(edge_radius,background colour,anti-alias width)');

define('PRODUCT_IMAGE_THUMBNAIL_MERGE_TITLE' , 'Artikel-Thumbnails:Merge<br />');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_DESC' , 'Artikel-Thumbnails:Merge<br /><br />Default Wert: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Verwendung:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity, transparent colour on merge image)');

define('PRODUCT_IMAGE_THUMBNAIL_FRAME_TITLE' , 'Artikel-Thumbnails:Frame<br />');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_DESC' , 'Artikel-Thumbnails:Frame<br /><br />Default Wert: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Verwendung:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');

define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_TITLE' , 'Artikel-Thumbnails:Drop-Shadow<br />');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_DESC' , 'Artikel-Thumbnails:Drop-Shadow<br /><br />Default Wert: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Verwendung:<br />(shadow width,hex shadow colour,hex background colour)');

define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_TITLE' , 'Artikel-Thumbnails:Motion-Blur<br />');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_DESC' , 'Artikel-Thumbnails:Motion-Blur<br /><br />Default Wert: (4,FFFFFF)<br /><br />fading parallel lines<br />Verwendung:<br />(int number of lines,hex background colour)');

// Kategorie Bilder

define('CATEGORY_INFO_IMAGE_MERGE_TITLE' , 'Kategorie Bilder:Merge');
define('CATEGORY_INFO_IMAGE_MERGE_DESC' , 'Kategorie Bilder:Merge<br /><br />Default Wert: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Verwendung:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');

define('CATEGORY_IMAGE_MERGE_TITLE' , 'Kategorie Thumb-Bilder:Merge');
define('CATEGORY_IMAGE_MERGE_DESC' , 'Kategorie Thumb-Bilder:Merge<br /><br />Default Wert: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Verwendung:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');


//And this is for the Images showing your products in single-view

define('PRODUCT_IMAGE_INFO_SMOTH_TITLE' , 'Bildschärfe');
define('PRODUCT_IMAGE_INFO_SMOTH_DESC' , 'Hiermit können Sie die Bildschärfe definieren: <br /><b>leer = keine Änderung</b><br /><b>negativ Wert (z.B. -15) = schärfer</b><br /><b>positiv Wert (z.B. 10) = weicher</b>');

define('PRODUCT_IMAGE_INFO_BEVEL_TITLE' , 'Artikel-Info Bilder:Bevel');
define('PRODUCT_IMAGE_INFO_BEVEL_DESC' , 'Artikel-Info Bilder:Bevel<br /><br />Default Wert: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Verwendung:<br />(edge width, hex light colour, hex dark colour)');

define('PRODUCT_IMAGE_INFO_GREYSCALE_TITLE' , 'Artikel-Info Bilder:Greyscale');
define('PRODUCT_IMAGE_INFO_GREYSCALE_DESC' , 'Artikel-Info Bilder:Greyscale<br /><br />Default Wert: (32,22,22)<br /><br />basic black n white<br />Verwendung:<br />(int red, int green, int blue)');

define('PRODUCT_IMAGE_INFO_ELLIPSE_TITLE' , 'Artikel-Info Bilder:Ellipse');
define('PRODUCT_IMAGE_INFO_ELLIPSE_DESC' , 'Artikel-Info Bilder:Ellipse<br /><br />Default Wert: (FFFFFF)<br /><br />ellipse on bg colour<br />Verwendung:<br />(hex background colour)');

define('PRODUCT_IMAGE_INFO_ROUND_EDGES_TITLE' , 'Artikel-Info Bilder:Round-edges');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_DESC' , 'Artikel-Info Bilder:Round-edges<br /><br />Default Wert: (5,FFFFFF,3)<br /><br />corner trimming<br />Verwendung:<br />( edge_radius, background colour, anti-alias width)');

define('PRODUCT_IMAGE_INFO_MERGE_TITLE' , 'Artikel-Info Bilder:Merge');
define('PRODUCT_IMAGE_INFO_MERGE_DESC' , 'Artikel-Info Bilder:Merge<br /><br />Default Wert: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Verwendung:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');

define('PRODUCT_IMAGE_INFO_FRAME_TITLE' , 'Artikel-Info Bilder:Frame');
define('PRODUCT_IMAGE_INFO_FRAME_DESC' , 'Artikel-Info Bilder:Frame<br /><br />Default Wert: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Verwendung:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');

define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_TITLE' , 'Artikel-Info Bilder:Drop-Shadow');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_DESC' , 'Artikel-Info Bilder:Drop-Shadow<br /><br />Default Wert: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Verwendung:<br />(shadow width,hex shadow colour,hex background colour)');

define('PRODUCT_IMAGE_INFO_MOTION_BLUR_TITLE' , 'Artikel-Info Bilder:Motion-Blur');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_DESC' , 'Artikel-Info Bilder:Motion-Blur<br /><br />Default Wert: (4,FFFFFF)<br /><br />fading parallel lines<br />Verwendung:<br />(int number of lines,hex background colour)');

//so this image is the biggest in the shop this

define('PRODUCT_IMAGE_POPUP_BEVEL_TITLE' , 'Artikel-Popup Bilder:Bevel');
define('PRODUCT_IMAGE_POPUP_BEVEL_DESC' , 'Artikel-Popup Bilder:Bevel<br /><br />Default Wert: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Verwendung:<br />(edge width,hex light colour,hex dark colour)');

define('PRODUCT_IMAGE_POPUP_GREYSCALE_TITLE' , 'Artikel-Popup Bilder:Greyscale');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_DESC' , 'Artikel-Popup Bilder:Greyscale<br /><br />Default Wert: (32,22,22)<br /><br />basic black n white<br />Verwendung:<br />(int red,int green,int blue)');

define('PRODUCT_IMAGE_POPUP_ELLIPSE_TITLE' , 'Artikel-Popup Bilder:Ellipse');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_DESC' , 'Artikel-Popup Bilder:Ellipse<br /><br />Default Wert: (FFFFFF)<br /><br />ellipse on bg colour<br />Verwendung:<br />(hex background colour)');

define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_TITLE' , 'Artikel-Popup Bilder:Round-edges');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_DESC' , 'Artikel-Popup Bilder:Round-edges<br /><br />Default Wert: (5,FFFFFF,3)<br /><br />corner trimming<br />Verwendung:<br />(edge_radius,background colour,anti-alias width)');

define('PRODUCT_IMAGE_POPUP_MERGE_TITLE' , 'Artikel-Popup Bilder:Merge');
define('PRODUCT_IMAGE_POPUP_MERGE_DESC' , 'Artikel-Popup Bilder:Merge<br /><br />Default Wert: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Verwendung:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');

define('PRODUCT_IMAGE_POPUP_FRAME_TITLE' , 'Artikel-Popup Bilder:Frame');
define('PRODUCT_IMAGE_POPUP_FRAME_DESC' , 'Artikel-Popup Bilder:Frame<br /><br />Default Wert: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Verwendung:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');

define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_TITLE' , 'Artikel-Popup Bilder:Drop-Shadow');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_DESC' , 'Artikel-Popup Bilder:Drop-Shadow<br /><br />Default Wert: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Verwendung:<br />(shadow width,hex shadow colour,hex background colour)');

define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_TITLE' , 'Artikel-Popup Bilder:Motion-Blur');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_DESC' , 'Artikel-Popup Bilder:Motion-Blur<br /><br />Default Wert: (4,FFFFFF)<br /><br />fading parallel lines<br />Verwendung:<br />(int number of lines,hex background colour)');

define('IMAGE_MANIPULATOR_TITLE','GDlib processing');
define('IMAGE_MANIPULATOR_DESC','Image Manipulator f&uuml;r GD2 oder GD1');


define('ACCOUNT_GENDER_TITLE' , 'Anrede');
define('ACCOUNT_GENDER_DESC' , 'Die Abfrage f&uuml;r die Anrede im Account benutzen');
define('ACCOUNT_DOB_TITLE' , 'Geburtsdatum');
define('ACCOUNT_DOB_DESC' , 'Die Abfrage f&uuml;r das Geburtsdatum im Account benutzen');
define('ACCOUNT_COMPANY_TITLE' , 'Firma');
define('ACCOUNT_COMPANY_DESC' , 'Die Abfrage f&uuml;r die Firma im Account benutzen');
define('ACCOUNT_SUBURB_TITLE' , 'Vorort');
define('ACCOUNT_SUBURB_DESC' , 'Die Abfrage f&uuml;r den Vorort im Account benutzen');
define('ACCOUNT_STATE_TITLE' , 'Bundesland');
define('ACCOUNT_STATE_DESC' , 'Die Abfrage f&uuml;r das Bundesland im Account benutzen');


define('DEFAULT_CURRENCY_TITLE' , 'Standard W&auml;hrung');
define('DEFAULT_CURRENCY_DESC' , 'W&auml;hrung die standardm&auml;ssig benutzt wird');
define('DEFAULT_LANGUAGE_TITLE' , 'Standard Sprache');
define('DEFAULT_LANGUAGE_DESC' , 'Sprache die standardm&auml;ssig benutzt wird');
define('DEFAULT_ORDERS_STATUS_ID_TITLE' , 'Standard Bestellstatus bei neuen Bestellungen');
define('DEFAULT_ORDERS_STATUS_ID_DESC' , 'Wenn eine neue Bestellung eingeht, wird dieser Status als Bestellstatus gesetzt.');

define('SHIPPING_ORIGIN_COUNTRY_TITLE' , 'Versandland');
define('SHIPPING_ORIGIN_COUNTRY_DESC' , 'W&auml;hlen Sie das Versandland aus, zur Berechnung korrekter Versandgeb&uuml;hren.');
define('SHIPPING_ORIGIN_ZIP_TITLE' , 'Postleitzahl des Versandstandortes');
define('SHIPPING_ORIGIN_ZIP_DESC' , 'Bitte geben Sie die Postleitzahl des Versandstandortes ein, der zur Berechnung der Versandkosten in Frage kommt.');
define('SHIPPING_MAX_WEIGHT_TITLE' , 'Maximalgewicht, dass als ein Paket versendet werden kann');
define('SHIPPING_MAX_WEIGHT_DESC' , 'Versandpartner(Post/UPS etc haben ein maximales Paketgewicht. Geben Sie einen Wert daf&uuml;r ein.');
define('SHIPPING_BOX_WEIGHT_TITLE' , 'Paketleergewicht.');
define('SHIPPING_BOX_WEIGHT_DESC' , 'Wie hoch ist das Gewicht eines durchschnittlichen kleinen bis mittleren Leerpaketes?');
define('SHIPPING_BOX_PADDING_TITLE' , 'Bei gr&ouml;sseren Leerpaketen - Gewichtszuwachs in %.');
define('SHIPPING_BOX_PADDING_DESC' , 'F&uuml;r etwa 10% geben Sie 10 ein');
define('SHOW_SHIPPING_DESC' , 'Verlinkte Anzeige von "zzgl. Versandkosten" in den Produktinformationen.');
define('SHOW_SHIPPING_TITLE' , 'Versandkosten in Produktinfos');
define('SHIPPING_INFOS_DESC' , 'Sprachgruppen ID der Versandkosten (Default 1) f&uuml;r die Verlinkung.');
define('SHIPPING_INFOS_TITLE' , 'Versandkosten ID');

define('PRODUCT_LIST_FILTER_MANUFACTURER_TITLE' , 'Herstellerfilter');
define('PRODUCT_LIST_FILTER_MANUFACTURER_DESC' , 'Anzeige des Filters f&uuml;r Hersteller. Sind keine Hersteller in der Datenbank');
define('PRODUCT_LIST_FILTER_SORT_TITLE' , 'Sortierung');
define('PRODUCT_LIST_FILTER_SORT_DESC' , 'Anzeige des Sortierungsfilters f&uuml;r Preis, Alter, nach Namen....');
define('PRODUCT_LIST_FILTER_RESULT_TITLE' , 'Artikel pro Seite');
define('PRODUCT_LIST_FILTER_RESULT_DESC' , 'Anzeige des Dropdowns f&uuml;r die Menge der Artikel auf einer Seite, welche der Kunde selber w&auml;hlen kann.');

define('PRODUCT_LIST_FILTER_TITLE' , 'Display Kategorie / Hersteller-Filter (0 = deaktiviert, 1 = aktiviert)');
define('PRODUCT_LIST_FILTER_DESC' , 'Wollen die Kategorie / Hersteller-Filter anzeigen lassen?');


define('STOCK_CHECK_TITLE' , '&Uuml;berpr&uuml;fen des Warenbestandes');
define('STOCK_CHECK_DESC' , 'Pr&uuml;fen ob noch genug Ware zum Ausliefern von Bestellungen verf&uuml;gbar ist.');

define('ATTRIBUTE_STOCK_CHECK_TITLE' , '&Uuml;berpr&uuml;fen des Artikelattribut Bestandes');
define('ATTRIBUTE_STOCK_CHECK_DESC' , '&Uuml;berpr&uuml;fen des Bestandes an Ware mit bestimmten Artikelattributen');

define('STOCK_LIMITED_TITLE' , 'Warenmenge abziehen');
define('STOCK_LIMITED_DESC' , 'Warenmenge im Warenbestand abziehen, wenn die Ware bestellt wurde');
define('STOCK_ALLOW_CHECKOUT_TITLE' , 'Einkaufen nicht vorr&auml;tiger Ware erlauben');
define('STOCK_ALLOW_CHECKOUT_DESC' , 'M&ouml;chten Sie auch dann erlauben zu bestellen, wenn bestimmte Ware laut Warenbestand nicht verf&uuml;gbar ist?');
define('STOCK_ALLOW_CHECKOUT_DEACTIVATE_TITLE' , 'Produkt deaktivieren');
define('STOCK_ALLOW_CHECKOUT_DEACTIVATE_DESC' , 'Wenn auf true gesetzt, wird das Produkt automatisch deaktiviert! Sie m&uuml;ssen es dann manuell aktivieren.');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE' , 'Kennzeichnung vergriffener Artikel');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC' , 'Dem Kunden kenntlich machen, welche Artikel nicht mehr verf&uuml;gbar sind.');
define('STOCK_REORDER_LEVEL_TITLE' , 'Meldung an den Admin dass ein Artikel nachbestellt werden muss');
define('STOCK_REORDER_LEVEL_DESC' , 'Ab welcher St&uuml;ckzahl soll diese Meldung erscheinen?');
define('STOCK_WARNING_LISTING_TITLE' , 'Lagerampel in der Produkt&uuml;bersicht');
define('STOCK_WARNING_LISTING_DESC' , 'Soll in der Produkt&uuml;bersicht eine Lagerampel erscheinen?');
define('STOCK_WARNING_INFO_TITLE' , 'Lagerampel in der Produktdetailseite?');
define('STOCK_WARNING_INFO_DESC' , 'Soll in der Produktdetailseite eine Lagerampel erscheinen?');

define('STOCK_WARNING_GREEN_TITLE' , 'Lagerampel - Gr&uuml;n');
define('STOCK_WARNING_GREEN_DESC' , 'Die Menge ab wann das Lager &quot;voll&quot; ist.');
define('STOCK_WARNING_YELLOW_TITLE' , 'Lagerampel - Gelb');
define('STOCK_WARNING_YELLOW_DESC' , 'Die Menge ab wann Status gelb ausgegeben wird.');
define('STOCK_WARNING_RED_TITLE' , 'Lagerampel - Rot');
define('STOCK_WARNING_RED_DESC' , 'Das Lager ist fast oder ganz leer.');

define('TRUSTED_SHOP_STATUS_TITLE','Status');
define('TRUSTED_SHOP_STATUS_DESC','Soll die Box f&uuml;r Trusted Shopangezeigt werden?');
define('TRUSTED_SHOP_NR_TITLE','Shop ID');
define('TRUSTED_SHOP_NR_DESC','Tragen Sie hier die von Trusted Shop vergeben Nummer ein.');
define('TRUSTED_SHOP_TEMPLATE_TITLE','Template f&uuml;r die Box');
define('TRUSTED_SHOP_TEMPLATE_DESC','W&auml;hlen Sie das Template f&uuml;r Ihre Box.');

define('STORE_PAGE_PARSE_TIME_TITLE' , 'Speichern der Berechnungszeit der Seite');
define('STORE_PAGE_PARSE_TIME_DESC' , 'Speicher der Zeit die ben&ouml;tigt wird, um Skripte bis zum Output der Seite zu berechnen');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE' , 'Speicherort des Logfile der Berechnungszeit');
define('STORE_PAGE_PARSE_TIME_LOG_DESC' , 'Ordner und Filenamen eintragen f&uuml;r den Logfile f&uuml;r Berechnung der Parsing Dauer');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE' , 'Log Datum Format');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC' , 'Das Datumsformat f&uuml;r Logging');

define('DISPLAY_PAGE_PARSE_TIME_TITLE' , 'Berechnungszeiten der Seiten anzeigen');
define('DISPLAY_PAGE_PARSE_TIME_DESC' , 'Wenn das Speichern der Berechnungszeiten f&uuml;r Seiten eingeschaltet ist, k&ouml;nnen diese im Footer angezeigt werden.');

define('STORE_DB_TRANSACTIONS_TITLE' , 'Speichern der Database Queries');
define('STORE_DB_TRANSACTIONS_DESC' , 'Speichern der einzelnen Datenbank Queries im Logfile f&uuml;r Berechnungszeiten (PHP4 only)');

define('USE_TEMPLATE_CACHE_TITLE' , 'Template-CSS Cache Erneuerung');
define('USE_TEMPLATE_CACHE_DESC' , 'Die CSS werden im cache-Ordner abgelegt. Ist diese Funktion auf <b>false</b> gestellt, werden die CSS-Dateien einmal im Cache abgelegt und erst wieder erneuert, wenn der Cache-Ordner geleert wird.<br />Steht diese Funktion auf <b>true</b> wird der CSS-Cache im Abstand der <b>Template CSS Cache Lebenszeit</b> erneuert.<br />Wenn Sie das Template anpassen, sollten Sie die Einstellung hier auf <b>true</b> setzen und die Cache Lebenszeit herunter drehen. Das ist besonders für Entwickler relevant.');

define('CACHE_TEMPLATE_LIFETIME_TITLE' , 'Template-CSS Cache Lebenszeit');
define('CACHE_TEMPLATE_LIFETIME_DESC' , 'Template-CSS Cache Lebenszeit in Sekunden.');

define('USE_CACHE_TITLE' , 'Cache benutzen');
define('USE_CACHE_DESC' , 'Die Cache Features verwenden');

define('DB_CACHE_TITLE','DB Cache');
define('DB_CACHE_DESC','SELECT Abfragen k&ouml;nnen von commerce:SEO gecached werden, um die Datenbankabfragen zu veringern, und die Geschwindigkeit zu erh&ouml;hen');

define('DB_CACHE_EXPIRE_TITLE','DB Cache Lebenszeit');
define('DB_CACHE_EXPIRE_DESC','Zeit in Sekunden, bevor Cache Datein mit Daten aus der Datenbank automatisch &Uuml;berschrieben werden.');

define('DIR_FS_CACHE_TITLE' , 'Cache Ordner');
define('DIR_FS_CACHE_DESC' , 'Der Ordner wo die gecachten Files gespeichert werden sollen');

define('LOG_SEARCH_RESULTS_TITLE', 'Suchergebnisse loggen');
define('LOG_SEARCH_RESULTS_DESC', 'Wenn <b>true</b> dann werden die Suchergebnisse in der Suchbegriff Statistik geloggt.');

define('ACCOUNT_OPTIONS_TITLE','Art der Kontoerstellung');
define('ACCOUNT_OPTIONS_DESC','Wie m&ouml;chten Sie die Anmeldeprozedur in Ihrem Shop gestallten ?<br />Sie haben die Wahl zwischen Kundenkonten und "einmal Bestellungen" ohne erstellung eines Kundenkontos (es wird ein Konto erstellt, aber dies ist f&uuml;r den Kunden nicht ersichtlich)');

define('EMAIL_TRANSPORT_TITLE' , 'Email Transport Methode');
define('EMAIL_TRANSPORT_DESC' , 'Definiert ob der Server eine lokale Verbindung zum "Sendmail-Programm" benutzt oder ob er eine SMTP Verbindung &uuml;ber TCP/IP ben&ouml;tigt. Server die auf Windows oder MacOS laufen sollten SMTP verwenden.');

define('EMAIL_LINEFEED_TITLE' , 'Email Linefeeds');
define('EMAIL_LINEFEED_DESC' , 'Definiert die Zeichen die benutzt werden sollen um die Mail Header zu trennen.');
define('EMAIL_USE_HTML_TITLE' , 'Benutzen von MIME HTML beim Versand von Emails');
define('EMAIL_USE_HTML_DESC' , 'Emails im HTML Format versenden');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE' , '&Uuml;berpr&uuml;fen der Email Adressen &uuml;ber DNS');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC' , 'Die Email Adressen k&ouml;nnen &uuml;ber einen DNS Server gepr&uuml;ft werden');
define('SEND_EMAILS_TITLE' , 'Senden von Emails');
define('SEND_EMAILS_DESC' , 'Emails an Kunden versenden (bei Bestellungen etc)');
define('SENDMAIL_PATH_TITLE' , 'Der Pfad zu Sendmail');
define('SENDMAIL_PATH_DESC' , 'Wenn Sie Sendmail benutzen, geben Sie hier den Pfad zum Sendmail Programm an(normalerweise: /usr/bin/sendmail):');
define('SMTP_MAIN_SERVER_TITLE' , 'Adresse des SMTP Servers');
define('SMTP_MAIN_SERVER_DESC' , 'Geben Sie die Adresse Ihres Haupt SMTP Servers ein.');
define('SMTP_BACKUP_SERVER_TITLE' , 'Adresse des SMTP Backup Servers');
define('SMTP_BACKUP_SERVER_DESC' , 'Geben Sie die Adresse Ihres Backup SMTP Servers ein.');
define('SMTP_USERNAME_TITLE' , 'SMTP Username');
define('SMTP_USERNAME_DESC' , 'Bitte geben Sie hier den Usernamen Ihres SMTP Accounts ein.');
define('SMTP_PASSWORD_TITLE' , 'SMTP Passwort');
define('SMTP_PASSWORD_DESC' , 'Bitte geben Sie hier das Passwort Ihres SMTP Accounts ein.');
define('SMTP_AUTH_TITLE' , 'SMTP AUTH');
define('SMTP_AUTH_DESC' , 'Erfordert der SMTP Server eine sichere Authentifizierung?');
define('SMTP_PORT_TITLE' , 'SMTP Port');
define('SMTP_PORT_DESC' , 'Geben sie den SMTP Port Ihres SMTP Servers ein (default: 25)?');

//Constants for contact_us
define('CONTACT_US_EMAIL_ADDRESS_TITLE' , 'Kontakt - Email Adresse');
define('CONTACT_US_EMAIL_ADDRESS_DESC' , 'Bitte geben Sie eine korrekte Absender Adresse f&uuml;r das Versenden der Emails &uuml;ber das "Kontakt" Formular ein.');
define('CONTACT_US_NAME_TITLE' , 'Kontakt - Email Adresse, Name');
define('CONTACT_US_NAME_DESC' , 'Bitte geben Sie einen Absender Namen f&uuml;r das Versenden der Emails &uuml;ber das "Kontakt" Formular ein.');
define('CONTACT_US_FORWARDING_STRING_TITLE' , 'Kontakt - Weiterleitungsadressen');
define('CONTACT_US_FORWARDING_STRING_DESC' , 'Geben Sie weitere Mailadressen ein, an welche die Emails des "Kontakt" Formulares noch versendet werden sollen (mit , getrennt)');
define('CONTACT_US_REPLY_ADDRESS_TITLE' , 'Kontakt - Antwortadresse');
define('CONTACT_US_REPLY_ADDRESS_DESC' , 'Bitte geben Sie eine Emailadresse ein, an die Ihre Kunden Antworten k&ouml;nnen.');
define('CONTACT_US_REPLY_ADDRESS_NAME_TITLE' , 'Kontakt - Antwortadresse, Name');
define('CONTACT_US_REPLY_ADDRESS_NAME_DESC' , 'Absendername f&uuml;r Antwortmails.');
define('CONTACT_US_EMAIL_SUBJECT_TITLE' , 'Kontakt - Email Betreff');
define('CONTACT_US_EMAIL_SUBJECT_DESC' , 'Betreff f&uuml;r Emails vom Kontaktformular des Shops');

//Constants for support system
define('EMAIL_SUPPORT_ADDRESS_TITLE' , 'Technischer Support - Email Adresse');
define('EMAIL_SUPPORT_ADDRESS_DESC' , 'Bitte geben Sie eine korrekte Absender Adresse f&uuml;r das Versenden der Emails &uuml;ber das <b>Support System</b> ein (Kontoerstellung,Password&auml;nderung).');
define('EMAIL_SUPPORT_NAME_TITLE' , 'Technischer Support - Email Adresse, Name');
define('EMAIL_SUPPORT_NAME_DESC' , 'Bitte geben Sie einen Absender Namen f&uuml;r das Versenden der mails &uuml;ber das <b>Support System</b> ein (Kontoerstellung,Password&auml;nderung).');
define('EMAIL_SUPPORT_FORWARDING_STRING_TITLE' , 'Technischer Support - Weiterleitungsadressen');
define('EMAIL_SUPPORT_FORWARDING_STRING_DESC' , 'Geben Sie weitere Emailadressen ein, an welche die Emails des <b>Support Systems</b> noch versendet werden sollen (mit , getrennt)');
define('EMAIL_SUPPORT_REPLY_ADDRESS_TITLE' , 'Technischer Support - Antwortadresse');
define('EMAIL_SUPPORT_REPLY_ADDRESS_DESC' , 'Bitte geben Sie eine Emailadresse ein, an die Ihre Kunden Antworten k&ouml;nnen.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_TITLE' , 'Technischer Support - Antwortadresse, Name');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC' , 'Absendername f&uuml;r Antwortmails.');
define('EMAIL_SUPPORT_SUBJECT_TITLE' , 'Technischer Support - Email Betreff');
define('EMAIL_SUPPORT_SUBJECT_DESC' , 'Betreff f&uuml;r Emails des <b>Support Systems</b>.');

//Constants for newsletter system
define('EMAIL_NEWSLETTER_ADDRESS_TITLE' , 'Newsletter - Email Adresse');
define('EMAIL_NEWSLETTER_ADDRESS_DESC' , 'Bitte geben Sie eine korrekte Absender Adresse f&uuml;r das Versenden der Emails &uuml;ber das <b>Newsletter</b> ein.');
define('EMAIL_NEWSLETTER_NAME_TITLE' , 'Newsletter - Email Adresse, Name');
define('EMAIL_NEWSLETTER_NAME_DESC' , 'Bitte geben Sie einen Absender Namen f&uuml;r das Versenden der mails &uuml;ber das <b>Newslettersystem</b> ein.<br />Es steht Ihnen {$shop} zur Verf&uuml;gung.');
define('EMAIL_NEWSLETTER_FORWARDING_STRING_TITLE' , 'Newsletter - Email Kopien');
define('EMAIL_NEWSLETTER_FORWARDING_STRING_DESC' , 'Geben Sie weitere Emailadressen ein, an welche die Emails des <b>Newsletter</b> noch versendet werden sollen (mit , getrennt)');
define('EMAIL_NEWSLETTER_REPLY_ADDRESS_TITLE' , 'Newsletter - Antwortadresse');
define('EMAIL_NEWSLETTER_REPLY_ADDRESS_DESC' , 'Bitte geben Sie eine Emailadresse ein, an die Ihre Kunden Antworten k&ouml;nnen.');
define('EMAIL_NEWSLETTER_REPLY_ADDRESS_NAME_TITLE' , 'Newsletter - Antwortadresse, Name');
define('EMAIL_NEWSLETTER_REPLY_ADDRESS_NAME_DESC' , 'Absendername f&uuml;r Antwortmails.');
define('EMAIL_NEWSLETTER_SUBJECT_TITLE' , 'Newsletter - Email Betreff');
define('EMAIL_NEWSLETTER_SUBJECT_DESC' , 'Betreff f&uuml;r Emails des <b>Newsletter</b>.');

//Constants for voucher system
define('EMAIL_VOUCHER_ADDRESS_TITLE' , 'Gutschein - E-Mail Adresse');
define('EMAIL_VOUCHER_ADDRESS_DESC' , 'Bitte geben Sie eine korrekte Absender Adresse f&uuml;r das Versenden der Emails &uuml;ber das <b>Gutscheinsystem</b> ein.');
define('EMAIL_VOUCHER_NAME_TITLE' , 'Gutschein - Email Adresse, Name');
define('EMAIL_VOUCHER_NAME_DESC' , 'Bitte geben Sie einen Absender Namen f&uuml;r das Versenden der mails &uuml;ber das <b>Gutschein System</b> ein.<br />Es steht Ihnen {$shop} zur Verf&uuml;gung.');
define('EMAIL_VOUCHER_FORWARDING_STRING_TITLE' , 'Gutschein - Email Kopien');
define('EMAIL_VOUCHER_FORWARDING_STRING_DESC' , 'Geben Sie weitere Emailadressen ein, an welche die Emails des <b>Gutschein Systems</b> noch versendet werden sollen (mit , getrennt)');
define('EMAIL_VOUCHER_REPLY_ADDRESS_TITLE' , 'Gutschein - Antwortadresse');
define('EMAIL_VOUCHER_REPLY_ADDRESS_DESC' , 'Bitte geben Sie eine Emailadresse ein, an die Ihre Kunden Antworten k&ouml;nnen.');
define('EMAIL_VOUCHER_REPLY_ADDRESS_NAME_TITLE' , 'Gutschein - Antwortadresse, Name');
define('EMAIL_VOUCHER_REPLY_ADDRESS_NAME_DESC' , 'Absendername f&uuml;r Antwortmails.');
define('EMAIL_VOUCHER_SUBJECT_TITLE' , 'Gutschein - Email Betreff');
define('EMAIL_VOUCHER_SUBJECT_DESC' , 'Betreff f&uuml;r Emails des <b>Gutscheins</b>.');

//Constants for pdf_bill system
define('EMAIL_PDF_BILL_ADDRESS_TITLE' , 'PDF-Rechnung - Email Adresse');
define('EMAIL_PDF_BILL_ADDRESS_DESC' , 'Bitte geben Sie eine korrekte Absender Adresse f&uuml;r das Versenden der Emails &uuml;ber das <b>PDF-Rechnung System</b> ein.');
define('EMAIL_PDF_BILL_NAME_TITLE' , 'PDF-Rechnung - Email Adresse, Name');
define('EMAIL_PDF_BILL_NAME_DESC' , 'Bitte geben Sie einen Absender Namen f&uuml;r das Versenden der mails &uuml;ber das <b>PDF-Rechnung System</b> ein.<br />Es steht Ihnen {$store_name} zur Verf&uuml;gung.');
define('EMAIL_PDF_BILL_FORWARDING_STRING_TITLE' , 'PDF-Rechnung - Email Kopien');
define('EMAIL_PDF_BILL_FORWARDING_STRING_DESC' , 'Geben Sie weitere Emailadressen ein, an welche die Emails des <b>PDF-Rechnung Systems</b> noch versendet werden sollen (mit , getrennt)');
define('EMAIL_PDF_BILL_REPLY_ADDRESS_TITLE' , 'PDF-Rechnung - Antwortadresse');
define('EMAIL_PDF_BILL_REPLY_ADDRESS_DESC' , 'Bitte geben Sie eine Emailadresse ein, an die Ihre Kunden Antworten k&ouml;nnen.');
define('EMAIL_PDF_BILL_REPLY_ADDRESS_NAME_TITLE' , 'PDF-Rechnung - Antwortadresse, Name');
define('EMAIL_PDF_BILL_REPLY_ADDRESS_NAME_DESC' , 'Absendername f&uuml;r Antwortmails.');
define('EMAIL_PDF_BILL_SUBJECT_TITLE' , 'PDF-Rechnung - Email Betreff');
define('EMAIL_PDF_BILL_SUBJECT_DESC' , 'Betreff f&uuml;r Emails der <b>PDF-Rechnung</b>.<br />Beispiel: <i>Ihre PDF-Rechnung vom {$date}</i>. {$date} ist das Datum des Kaufes.');

//Constants for Billing system
define('EMAIL_BILLING_ADDRESS_TITLE' , 'Verrechnung - Email Adresse');
define('EMAIL_BILLING_ADDRESS_DESC' , 'Bitte geben Sie eine korrekte Absenderadresse f&uuml;r das Versenden der mails &uuml;ber das <b>Verrechnungssystem</b> ein (Bestellbest&auml;tigung,Status&auml;nderungen,..).');

define('EMAIL_BILLING_NAME_TITLE' , 'Absender - Mail Adresse oder Name');
define('EMAIL_BILLING_NAME_DESC' , 'Bitte geben Sie einen Absendernamen f&uuml;r das Versenden der Emails &uuml;ber das <b>Verrechnungssystem</b> ein (Bestellbest&auml;tigung,Status&auml;nderungen,..).<br />Folgende Variablen stehen zur Verf&uuml;gung: {$shop_name} <-Shop Bezeichnung,{$shop_besitzer} <- Ihr Shopname');

define('EMAIL_BILLING_FORWARDING_STRING_TITLE' , 'Verrechnung - Weiterleitungsadressen');
define('EMAIL_BILLING_FORWARDING_STRING_DESC' , 'Geben Sie weitere Mailadressen ein, wohin die Emails des <b>Verrechnungssystem</b> noch versendet werden sollen (mit , getrennt)');
define('EMAIL_BILLING_REPLY_ADDRESS_TITLE' , 'Verrechnung - Antwortadresse');
define('EMAIL_BILLING_REPLY_ADDRESS_DESC' , 'Bitte geben Sie eine Emailadresse ein, an die Ihre Kunden Antworten k&ouml;nnen.');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_TITLE' , 'Verrechnung - Antwortadresse, Name');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_DESC' , 'Absendername f&uuml;r replay Emails.');

define('EMAIL_BILLING_SUBJECT_TITLE' , 'Status&auml;nderung - Email Betreff');
define('EMAIL_BILLING_SUBJECT_DESC' , 'Geben Sie bitte einen Emailbetreff f&uuml;r Emails des <b>Status&auml;nderungs-Systems</b> Ihres Shops ein.');

define('EMAIL_BILLING_SUBJECT_ORDER_TITLE','Bestellbest&auml;ttigung - Email Betreff');
define('EMAIL_BILLING_SUBJECT_ORDER_DESC','Geben Sie bitte einen Emailbetreff f&uuml;r Ihre Bestellmails an. (zb: <b>Ihre Bestellung {$nr},am {$date}</b>)<br />Folgende Variablen stehen zur Verf&uuml;gung, {$nr},{$date},{$firstname},{$lastname}');


define('DOWNLOAD_ENABLED_TITLE' , 'Download von Artikeln erlauben');
define('DOWNLOAD_ENABLED_DESC' , 'Die Artikel Download Funktionen einschalten (Software etc).');
define('DOWNLOAD_BY_REDIRECT_TITLE' , 'Download durch Redirection');
define('DOWNLOAD_BY_REDIRECT_DESC' , 'Browser-Umleitung f&uuml;r Artikeldownloads benutzen. Auf nicht Linux/Unix Systemen ausschalten.');
define('DOWNLOAD_MAX_DAYS_TITLE' , 'Verfallsdatum der Download Links(Tage)');
define('DOWNLOAD_MAX_DAYS_DESC' , 'Anzahl an Tagen, die ein Download Link f&uuml;r den Kunden aktiv bleibt. 0 bedeutet ohne Limit.');
define('DOWNLOAD_MAX_COUNT_TITLE' , 'Maximale Anzahl der Downloads eines gekauften Medienproduktes');
define('DOWNLOAD_MAX_COUNT_DESC' , 'Stellen Sie die maximale Anzahl an Downloads ein, die Sie dem Kunden erlauben, der einen Artikel dieser Art erworben hat. 0 bedeutet kein Download.');

define('GZIP_COMPRESSION_TITLE' , 'GZip Kompression einschalten');
define('GZIP_COMPRESSION_DESC' , 'Schalten Sie HTTP GZip Kompression ein um die Seitenaufbaugeschwindigkeit zu optimieren.');
define('GZIP_LEVEL_TITLE' , 'Kompressions Level');
define('GZIP_LEVEL_DESC' , 'W&auml;hlen Sie einen Kompressionslevel zwischen 0-9 (0 = Minimum, 9 = Maximum).');

define('SESSION_WRITE_DIRECTORY_TITLE' , 'Session Speicherort');
define('SESSION_WRITE_DIRECTORY_DESC' , 'Wenn Sessions als Files gespeichert werden sollen, benutzen Sie folgenden Ordner.');
define('SESSION_FORCE_COOKIE_USE_TITLE' , 'Cookie Benutzung bevorzugen');
define('SESSION_FORCE_COOKIE_USE_DESC' , 'Session starten falls Cookies vom Browser erlaubt werden.');
define('SESSION_CHECK_SSL_SESSION_ID_TITLE' , 'Checken der SSL Session ID');
define('SESSION_CHECK_SSL_SESSION_ID_DESC' , '&Uuml;berpr&uuml;fen der SSL_SESSION_ID bei jedem HTTPS Seitenaufruf.');
define('SESSION_CHECK_USER_AGENT_TITLE' , 'Checken des User Browsers');
define('SESSION_CHECK_USER_AGENT_DESC' , '&Uuml;berpr&uuml;fen des Browsers den der User benutzt, bei jedem Seitenaufruf.');
define('SESSION_CHECK_IP_ADDRESS_TITLE' , 'Checken der IP Adresse');
define('SESSION_CHECK_IP_ADDRESS_DESC' , '&Uuml;berpr&uuml;fen der IP Adresse des Users bei jedem Seitenaufruf.');
define('SESSION_RECREATE_TITLE' , 'Session erneuern');
define('SESSION_RECREATE_DESC' , 'Erneuern der Session und Zuweisung einer neuen Session ID sobald ein User einloggt oder sich registriert (PHP >=4.1 needed).');
define('SESSION_TIMEOUT_ADMIN_TITLE' , 'Session Timeout Admin');
define('SESSION_TIMEOUT_ADMIN_DESC' , 'Geben Sie die Zeit in Sekunden an, wie lange die Session für den Admin gültig sein soll');

define('DISPLAY_CONDITIONS_ON_CHECKOUT_TITLE' , 'Unterzeichnen der AGB');
define('DISPLAY_CONDITIONS_ON_CHECKOUT_DESC' , 'Anzeigen und Unterzeichnen der AGB beim Bestellvorgang');

define('META_MIN_KEYWORD_LENGTH_TITLE' , 'Minimum L&auml;nge Meta-Keywords');
define('META_MIN_KEYWORD_LENGTH_DESC' , 'Minimum L&auml;nge der automatisch erzeugten Meta-Keywords.');
define('META_KEYWORDS_NUMBER_TITLE' , 'Anzahl der Meta-Keywords');
define('META_KEYWORDS_NUMBER_DESC' , 'Anzahl der Meta-Keywords (DERZEIT NOCH NICHT VERWENDET!)');
define('META_AUTHOR_TITLE' , 'author');
define('META_AUTHOR_DESC' , '<meta name="author">');
define('META_PUBLISHER_TITLE' , 'publisher');
define('META_PUBLISHER_DESC' , '<meta name="publisher">');
define('META_COMPANY_TITLE' , 'company');
define('META_COMPANY_DESC' , '<meta name="company">');
define('META_TOPIC_TITLE' , 'page-topic');
define('META_TOPIC_DESC' , '<meta name="page-topic">');
define('META_REPLY_TO_TITLE' , 'reply-to');
define('META_REPLY_TO_DESC' , '<meta name="reply-to">');
define('META_REVISIT_AFTER_TITLE' , 'revisit-after');
define('META_REVISIT_AFTER_DESC' , '<meta name="revisit-after">');
define('META_ROBOTS_TITLE' , 'robots');
define('META_ROBOTS_DESC' , '<meta name="robots">');
define('META_DESCRIPTION_TITLE' , 'Standard-Description');
define('META_DESCRIPTION_DESC' , 'Gilt für alle Seiten, die keine automatische Meta-Description bereitstellen.');
define('META_KEYWORDS_TITLE' , 'Standard-Keywords');
define('META_KEYWORDS_DESC' , 'Gilt für alle Seiten, die keine automatische Meta-Description bereitstellen.');

define('MODULE_PAYMENT_INSTALLED_TITLE' , 'Installierte Zahlungsmodule');
define('MODULE_PAYMENT_INSTALLED_DESC' , 'Liste der Zahlungsmodul-Dateinamen (getrennt durch einen Strichpunkt (;)). Diese wird automatisch aktualisiert, daher ist es nicht notwendig diese zu editieren. (Beispiel: cc.php;cod.php;paypal.php)');
define('MODULE_ORDER_TOTAL_INSTALLED_TITLE' , 'Installierte Order Total-Module');
define('MODULE_ORDER_TOTAL_INSTALLED_DESC' , 'Liste der Order-Total-Modul-Dateinamen (getrennt durch einen Strichpunkt (;)). Diese wird automatisch aktualisiert, daher ist es nicht notwendig diese zu editieren. (Beispiel: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)');
define('MODULE_SHIPPING_INSTALLED_TITLE' , 'Installierte Versand Module');
define('MODULE_SHIPPING_INSTALLED_DESC' , 'Liste der Versandmodul-Dateinamen (getrennt durch einen Strichpunkt (;)). Diese wird automatisch aktualisiert, daher ist es nicht notwendig diese zu editieren. (Beispiel: ups.php;flat.php;item.php)');

define('CACHE_LIFETIME_TITLE','Cache Lebenszeit');
define('CACHE_LIFETIME_DESC','Zeit in Sekunden, bevor Cache Datein automatisch &uuml;berschrieben werden.');
define('CACHE_CHECK_TITLE','Pr&uuml;fe ob Cache modifiziert');
define('CACHE_CHECK_DESC','Wenn "true", dann werden If-Modified-Since headers bei ge-cache-tem Content ber&uuml;cksichtigt, und passende HTTP headers werden ausgegeben. Somit werden regelm&auml;ssig aufgerufene Seiten nicht jedesmal neu an den Client versandt.');

define('PRODUCT_REVIEWS_VIEW_TITLE','Bewertungen in Artikeldetails');
define('PRODUCT_REVIEWS_VIEW_DESC','Anzahl der angezeigten Bewertungen in der Artikeldetailansicht');

define('DELETE_GUEST_ACCOUNT_TITLE','L&ouml;schen von Gast-Konten');
define('DELETE_GUEST_ACCOUNT_DESC','Sollen Gast-Konten nach erfolgter Bestellung gel&ouml;scht werden ? (Bestelldaten bleiben erhalten)');

define('USE_WYSIWYG_TITLE','WYSIWYG-Editor aktivieren');
define('USE_WYSIWYG_DESC','WYSIWYG-Editor f&uuml;r CMS und Artikel aktivieren ?');

define('USE_WYSIWYG_CKEDITOR_TITLE','Neuen CKEditor benutzen?');
define('USE_WYSIWYG_CKEDITOR_DESC','Der neue CKEditor ist sehr viel schneller als sein alter Vorg&auml;nger. Leider bringt er keinen Filemanager mehr mit, da dieser Part nun Kommerziell ist.<br />Hier k&ouml;nnen Sie zwischen beiden wechseln.');

define('PRICE_IS_BRUTTO_TITLE','Brutto Admin');
define('PRICE_IS_BRUTTO_DESC','Erm&ouml;glicht die Eingabe der Bruttopreise im Admin');

define('PRICE_PRECISION_TITLE','Brutto/Netto Dezimalstellen');
define('PRICE_PRECISION_DESC','Umrechnungsgenauigkeit');

define('CHECK_CLIENT_AGENT_TITLE','Spider Sessions vermeiden?');
define('CHECK_CLIENT_AGENT_DESC','Bekannte Suchmaschinen Spider ohne Session auf die Seite lassen.');
define('SHOW_IP_LOG_TITLE','IP-Log im Checkout?');
define('SHOW_IP_LOG_DESC','Text "Ihre IP wird aus Sicherheitsgr&uuml;nden gespeichert", beim Checkout anzeigen?');

define('ACTIVATE_GIFT_SYSTEM_TITLE','Gutscheinsystem aktivieren?');
define('ACTIVATE_GIFT_SYSTEM_DESC','Gutscheinsystem aktivieren?');

define('ACTIVATE_SHIPPING_STATUS_TITLE','Versandstatusanzeige aktivieren?');
define('ACTIVATE_SHIPPING_STATUS_DESC','Versandstatusanzeige aktivieren? (Verschiedene Versandzeiten k&ouml;nnen f&uuml;r einzelne Artikel festgelegt werden. Nach Aktivierung erscheint ein neuer Punkt <b>Lieferstatus</b> bei der Artikeleingabe)');

define('SECURITY_CODE_LENGTH_TITLE','L&auml;nge des Sicherheitscodes');
define('SECURITY_CODE_LENGTH_DESC','L&auml;nge des Sicherheitscodes (Geschenk-Gutschein)');

define('IMAGE_QUALITY_TITLE','Bildqualit&auml;t');
define('IMAGE_QUALITY_DESC','Bildqualit&auml;t (0= h&ouml;chste Kompression, 100=beste Qualit&auml;t)');

define('GROUP_CHECK_TITLE','Kundengruppencheck');
define('GROUP_CHECK_DESC','Nur bestimmten Kundengruppen Zugang zu einzelnen Kategorien,Produkten,Contentelementen erlauben ? (Nach Aktivierung erscheinen Eingabem&ouml;glichkeiten bei Artikeln,Kategorien und im Contentmanager)');

define('ACTIVATE_NAVIGATOR_TITLE','Artikelnavigator aktivieren?');
define('ACTIVATE_NAVIGATOR_DESC','Artikelnavigator in der Artikeldetailansicht aktivieren/deaktivieren (aus performancegr&uuml;nden bei hoher Artikelanzahl)');

define('QUICKLINK_ACTIVATED_TITLE','Multilink/Kopierfunktion aktivieren');
define('QUICKLINK_ACTIVATED_DESC','Die Multilink/Kopierfunktion erleichtert das Kopieren/Verlinken eines Artikels in mehrere Kategorien, durch die M&ouml;glichkeit einzelne Kategorien per Checkbox zu selektieren');

define('ACTIVATE_REVERSE_CROSS_SELLING_TITLE','Reverse Cross-Marketing');
define('ACTIVATE_REVERSE_CROSS_SELLING_DESC','Reverse Cross-Marketing Funktion aktivieren?');

define('DOWNLOAD_UNALLOWED_PAYMENT_TITLE', 'Download Zahlungsmodule');
define('DOWNLOAD_UNALLOWED_PAYMENT_DESC', 'Nicht Erlaubte Zahlungsweisen f&uuml;r Downloadprodukte durch Komma getrennt. Z.B. {banktransfer,cod,invoice,moneyorder}');
define('DOWNLOAD_MIN_ORDERS_STATUS_TITLE', 'Min. Bestellstatus');
define('DOWNLOAD_MIN_ORDERS_STATUS_DESC', 'Min. Bestellstatus, ab dem bestellte Downloads freigegeben sind.');

// Vat ID
define('STORE_OWNER_VAT_ID_TITLE' , 'UST ID des Shopbetreibers');
define('STORE_OWNER_VAT_ID_DESC' , 'Die UST ID des Shopbetreibers');
define('STORE_OWNER_VAT_ID_TITLE' , 'Umsatzsteuer ID');
define('STORE_OWNER_VAT_ID_DESC' , 'Die Umsatzsteuer ihres Unternehmens');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_TITLE' , 'Kundenstatus f&uuml;r UST ID gepr&uuml;fte Kunden (Ausland)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_DESC' , 'W&auml;hlen Sie den Kundenstatus(Gruppe) f&uuml;r UST ID gepr&uuml;fte Kunden aus!');
define('ACCOUNT_COMPANY_VAT_CHECK_TITLE' , 'Umsatzsteuer ID &Uuml;berpr&uuml;fen');
define('ACCOUNT_COMPANY_VAT_CHECK_DESC' , 'Die Umsatzsteuer ID auf Plausibilit&auml;t &Uuml;berpr&uuml;fen');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_TITLE' , 'Umsatzsteuer ID Live &Uuml;berpr&uuml;fen');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_DESC' , 'Die Umsatzsteuer ID auf Live Plausibilit&auml;t &Uuml;berpr&uuml;fen falls keine Berechnungsgrundlage vorhanden? (Gateway des Bundesamt f&uuml;r Finanzen)');
define('ACCOUNT_COMPANY_VAT_GROUP_TITLE' , 'Kundengruppe nach UST ID Check anpassen?');
define('ACCOUNT_COMPANY_VAT_GROUP_DESC' , 'Durch einschalten dieser Option wird die Kundengruppe nach einen postiven UST ID Check ge&auml;ndert');
define('ACCOUNT_VAT_BLOCK_ERROR_TITLE' , 'Eintragung falscher oder ungepr&uuml;fter UstID Nummern sperren?');
define('ACCOUNT_VAT_BLOCK_ERROR_DESC' , 'Durch einschalten dieser Option werden nur gepr&uuml;fte und richtige UstIDs eingetragen');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_TITLE','Kundenstatus f&uuml;r UST ID Geprp&uuml;fte Kunden (Innland)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_DESC','W&auml;hlen Sie den Kundenstatus(Gruppe) f&uuml;r UST ID gepr&uuml;fte Kunden aus!');
// Google Conversion
define('GOOGLE_CONVERSION_TITLE','Google Conversion-Tracking');
define('GOOGLE_CONVERSION_DESC','Die Aufzeichnung von Conversions-Keywords bei Bestellungen');
define('GOOGLE_CONVERSION_ID_TITLE','Conversion ID');
define('GOOGLE_CONVERSION_ID_DESC','Ihre Google Conversion ID');
define('GOOGLE_LANG_TITLE','Google Sprache');
define('GOOGLE_LANG_DESC','ISO Code der verwendeten Sprache');
// Afterbuy
define('AFTERBUY_ACTIVATED_TITLE','Aktiv');
define('AFTERBUY_ACTIVATED_DESC','Afterbuyschnittstelle aktivieren');
define('AFTERBUY_PARTNERID_TITLE','Partner ID');
define('AFTERBUY_PARTNERID_DESC','Ihre Afterbuy Partner ID');
define('AFTERBUY_PARTNERPASS_TITLE','Partner Passwort');
define('AFTERBUY_PARTNERPASS_DESC','Ihr Partner Passwort f&uuml;r die Afterbuy XML Schnittstelle');
define('AFTERBUY_USERID_TITLE','User ID');
define('AFTERBUY_USERID_DESC','Ihre Afterbuy User ID');
define('AFTERBUY_ORDERSTATUS_TITLE','Bestellstatus');
define('AFTERBUY_ORDERSTATUS_DESC','Bestellstatus nach erfolgreicher &Uuml;betragung der Bestelldaten');

define('AFTERBUY_URL','Afterbuy');

// Search-Options
define('SEARCH_IN_DESC_TITLE','Suche in Produktbeschreibungen');
define('SEARCH_IN_DESC_DESC','Aktivieren um die Suche in den Produktbeschreibungen (Kurz + Lang) zu erm&ouml;glichen');
define('SEARCH_IN_ATTR_TITLE','Suche in Produkt- Attributen');
define('SEARCH_IN_ATTR_DESC','Aktivieren um die Suche in den Produktattributen (z.B. Farbe, L&auml;nge) zu erm&ouml;glichen');

// changes for 3.0.4 SP2
define('REVOCATION_ID_TITLE','Widerrufsrecht Gruppen-Nr.');
define('REVOCATION_ID_DESC','Nr. der Gruppe des Widerrufrechts');
define('DISPLAY_REVOCATION_ON_CHECKOUT_TITLE','Anzeige Widerrufrecht?');
define('DISPLAY_REVOCATION_ON_CHECKOUT_DESC','Widerrufrecht auf checkout_confirmation anzeigen?');

// Google Analytics
define('GOOGLE_ANAL_ON_TITLE','Google Analytics einschalten');
define('GOOGLE_ANAL_ON_DESC','Einschalten: true<br />Ausschalten: false');
define('GOOGLE_ANAL_CODE_TITLE','Analytics code:');
define('GOOGLE_ANAL_CODE_DESC','Geben Sie hier ihren Analytics Code an.<br />Beispiel: UA-XXXXXXX-1<br /><strong>ACHTUNG: Sie sollten die Verwendung von Analytics in Ihren Datenschutzbestimmungen vermerken!</strong>');

define('GOOGLE_ANONYM_ON_TITLE','Google Analytics Anonymisierung einschalten');
define('GOOGLE_ANONYM_ON_DESC','Einschalten: true<br />Ausschalten: false');


// Widerruf und Datenschutz beim Bestellen
define('DISPLAY_DATENSCHUTZ_ON_CHECKOUT_TITLE' , 'Unterzeichnen der Datenschutzbelehrung');
define('DISPLAY_DATENSCHUTZ_ON_CHECKOUT_DESC' , 'Anzeigen und Unterzeichnen der Datenschutzbelehrung beim Bestellvorgang');
define('DISPLAY_WIDERRUFSRECHT_ON_CHECKOUT_TITLE' , 'Unterzeichnen des Widerrufsrecht');
define('DISPLAY_WIDERRUFSRECHT_ON_CHECKOUT_DESC' , 'Anzeigen und Unterzeichnen des Widerrufsrecht beim Bestellvorgang');

// PayPal Express
define('PAYPAL_MODE_TITLE','PayPal-Modus:');
define('PAYPAL_MODE_DESC','Live (Normal) oder Testbetrieb (Sandbox)');
define('PAYPAL_API_USER_TITLE','PayPal-API-Benutzer (Live)');
define('PAYPAL_API_USER_DESC','trage hier den Benutzernamen ein.');
define('PAYPAL_API_PWD_TITLE','PayPal-API-Passwort (Live)');
define('PAYPAL_API_PWD_DESC','trage hier das Passwort ein.');
define('PAYPAL_API_SIGNATURE_TITLE','PayPal-API-Signatur (Live)');
define('PAYPAL_API_SIGNATURE_DESC','trage hier die API Signatur ein.');
define('PAYPAL_API_SANDBOX_USER_TITLE','PayPal-API-Benutzer (Sandbox)');
define('PAYPAL_API_SANDBOX_USER_DESC','trage hier den Benutzernamen ein.');
define('PAYPAL_API_SANDBOX_PWD_TITLE','PayPal-API-Passwort (Sandbox)');
define('PAYPAL_API_SANDBOX_PWD_DESC','trage hier das Passwort ein.');
define('PAYPAL_API_SANDBOX_SIGNATURE_TITLE','PayPal-API-Signatur (Sandbox)');
define('PAYPAL_API_SANDBOX_SIGNATURE_DESC','trage hier die API Signatur ein.');
define('PAYPAL_API_VERSION_TITLE','PayPal-API-Version');
define('PAYPAL_API_VERSION_DESC','trage hier die aktuelle PayPal API Version ein - z.B.: 62.0');
define('PAYPAL_API_IMAGE_TITLE','PayPal Shop-Logo');
define('PAYPAL_API_IMAGE_DESC','trage hier die Logo-Datei ein, die bei PayPal angezeigt werden soll.<br />Achtung: Wird nur &uuml;bertragen wenn der Shop mit SSL arbeitet.<br />Das Bild darf max. 750px breit und 90px hoch sein.<br />Aufgerufen wird die Datei aus: '.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
define('PAYPAL_API_CO_BACK_TITLE','PayPal Hintergrund-Farbe');
define('PAYPAL_API_CO_BACK_DESC','trage hier die Hintergrundfarbe ein, die bei PayPal angezeigt werden soll. z.B. FEE8B9');
define('PAYPAL_API_CO_BORD_TITLE','PayPal Rahmen-Farbe');
define('PAYPAL_API_CO_BORD_DESC','trage hier die Rahmenfarbe ein, die bei PayPal angezeigt werden soll. z.B. E4C558');
define('PAYPAL_ERROR_DEBUG_TITLE','PayPal Fehler Anzeige');
define('PAYPAL_ERROR_DEBUG_DESC','Soll der original PayPal Fehler angezeigt werden? Normal=false');
define('PAYPAL_ORDER_STATUS_TMP_ID_TITLE','Bestellstatus "abgebrochen"');
define('PAYPAL_ORDER_STATUS_TMP_ID_DESC','w&auml;hle den Bestellstatus f&uuml;r ein abgebrochenen Aktion aus (z.B. PayPal Abbruch)');
define('PAYPAL_ORDER_STATUS_SUCCESS_ID_TITLE','Bestellstatus OK');
define('PAYPAL_ORDER_STATUS_SUCCESS_ID_DESC','w&auml;hle den Bestellstatus f&uuml;r eine erfolgreiche Transaktion aus (z.B. Offen PP bezahlt)');
define('PAYPAL_ORDER_STATUS_PENDING_ID_TITLE','Bestellstatus "in Bearbeitung"');
define('PAYPAL_ORDER_STATUS_PENDING_ID_DESC','w&auml;hle den Bestellstatus f&uuml;r eine Transaktion aus, die noch nicht von PayPal bearbeitet wurde (z.B. Offen PP wartend)');
define('PAYPAL_ORDER_STATUS_REJECTED_ID_TITLE','Bestellstatus "abgewiesen"');
define('PAYPAL_ORDER_STATUS_REJECTED_ID_DESC','w&auml;hle den Bestellstatus f&uuml;r eine abgelehnte Transaktion aus (z.B. PayPal abgelehnt)');
define('PAYPAL_COUNTRY_MODE_TITLE','PayPal-L&auml;ndermodus');
define('PAYPAL_COUNTRY_MODE_DESC','w&auml;hle hier die Einstellung f&uuml;r den L&auml;ndermodus. Verschiedene Funktionen von PayPal sind nur in UK m&ouml;glich (z.b. DirectPayment )');
define('PAYPAL_EXPRESS_ADDRESS_CHANGE_TITLE','PayPal-Express-Adressdaten');
define('PAYPAL_EXPRESS_ADDRESS_CHANGE_DESC','Erlaubt das &Auml;ndern der von PayPal &uuml;bermittelten Adressdaten');
define('PAYPAL_EXPRESS_ADDRESS_OVERRIDE_TITLE','Lieferadresse &uuml;berschreiben');
define('PAYPAL_EXPRESS_ADDRESS_OVERRIDE_DESC','Erlaubt das &Auml;ndern der von PayPal &uuml;bermittelten Adressdaten (bestehendes Konto)');
define('PAYPAL_INVOICE_TITLE','Shop-Kenner f&uuml;r PayPal Rg.Nr.');
define('PAYPAL_INVOICE_DESC','Buchstabe(n) die vor die Order-Nr. als Shop-Kenner gesetzt werden und als Rechnungs-Nr. von PayPal benutzt werden.<br />Durch unterschiedliche Shop-Kenner k&ouml;nnen mehrere Shops mit einem PayPal Konto arbeiten, ohne das es bei gleichen Order-Nummern zu gleichen Rechnungs-Nummern im PayPal Konto kommt.');

// Anmeldung Sicherheit CSEO 1.0.7
define ('LOGIN_NUM_TITLE','Anzahl der erlaubten Login-Versuche:');
define ('LOGIN_NUM_DESC','Stellen Sie hier ein, nach wie viel falschen Versuchen die Sicherheitsabfrage erscheinen soll.<br /><b>default: 3</b>');
define ('LOGIN_TIME_TITLE','Zeit zwischen den Anmeldungen:');
define ('LOGIN_TIME_DESC','Wenn diese Zeit vergangen ist, wird die Sicherheitsabfrage abgeschaltet, und es ist wieder eine normale Anmeldung m&ouml;glich. (in Sekunden!)<br /><b>default: 300</b>');
define ('LOGIN_SAFE_TITLE','Anmeldeschutz aktivieren:');
define ('LOGIN_SAFE_DESC','true = Anmeldeschutz aktiv, false = Anmeldeschutz inaktiv');


// Recover Cart Sales

define('RCS_BASE_DAYS_TITLE', 'Zeitraum');
define('RCS_BASE_DAYS_DESC', 'Anzahl der vergangenen Tage f&uuml;r nicht abgeschlossene Warenk&ouml;rbe.');
define('RCS_REPORT_DAYS_TITLE', 'Verkaufsbericht Zeitraum');
define('RCS_REPORT_DAYS_DESC', 'Anzahl der Tage, die ber&uuml;cksichtigt werden sollen. Je mehr, desto l&auml;nger dauert die Abfrage!');
define('RCS_EMAIL_TTL_TITLE', 'Lebensdauer Email');
define('RCS_EMAIL_TTL_DESC','Anzahl der Tage, die die E-Mail als gesendet markiert wird');
define('RCS_EMAIL_FRIENDLY_TITLE', 'Pers&ouml;nliche E-Mails');
define('RCS_EMAIL_FRIENDLY_DESC', 'Wenn <b>true</b> wird der Name des Kunden in der Anrede verwendet. Wenn <b>false</b> wird eine allgemeine Anrede verwendet.');
define('RCS_EMAIL_COPIES_TO_TITLE', 'E-Mail Kopien an');
define('RCS_EMAIL_COPIES_TO_DESC', 'Wenn Kopien der Emails an die Kunden versendet werden sollen, bitte Empf&auml;nger hier eintragen.');
define('RCS_SHOW_ATTRIBUTES_TITLE', 'Attribute anzeigen');
define('RCS_SHOW_ATTRIBUTES_DESC', 'Kontrolliert die Anzeige von Attributen.<br>Einige Shops nutzen Produktattribute.<br>Auf <b>true</b> setzen, wenn die Attribute angezeigt werden sollen, ansonsten auf <b>false</b>.');
define('RCS_CHECK_SESSIONS_TITLE', 'Ignoriere Kunden mit Sitzung');
define('RCS_CHECK_SESSIONS_DESC', 'Wenn Kunden mit aktiver Sitzung ignoriert werden sollen (z.B. weil sie noch einkaufen), w&auml;hlen sie <b>true</b>.<br>Wenn auf <b>false</b> gesetzt, werden die Sitzungsdaten ignoriert (schneller).');
define('RCS_CURCUST_COLOR_TITLE', 'Farbe aktiver Kunde');
define('RCS_CURCUST_COLOR_DESC', 'Farbe, die aktive Kunden markiert<br>Ein &quot;aktiver Kunde&quot; hat bereits Artikel im Shop bestellt.');
define('RCS_UNCONTACTED_COLOR_TITLE', 'Farbe "noch nicht kontaktiert"');
define('RCS_UNCONTACTED_COLOR_DESC', 'Hintergrundfarbe f&uuml;r noch nicht kontaktierte Kunden.<br>Ein nicht kontaktierter Kunde wurde noch <i>nicht</i> mit diesem Tool angeschrieben.');
define('RCS_CONTACTED_COLOR_TITLE', 'Farbe kontaktiert');
define('RCS_CONTACTED_COLOR_DESC', 'Hintergrundfarbe f&uuml;r kontaktierte Kunden.<br>Ein kontaktierter Kunde wurde bereits mit diesem Tool <i>informiert</i>.');
define('RCS_MATCHED_ORDER_COLOR_TITLE', 'Farbe alternative Bestellung gefunden');
define('RCS_MATCHED_ORDER_COLOR_DESC', 'Hintergrundfarbe f&uuml;r gefundene alternative Bestellungen.<br>Diese wird verwendet, wenn sich ein oder mehrere Artikel im offenen Warenkorb befinden und die E-Mail-Adresse oder die Kundennummer mit einer anderen Bestellung &uuml;bereinstimmt (siehe n&auml;chster Punkt).');
define('RCS_SKIP_MATCHED_CARTS_TITLE', '&Uuml;berspringe alternative Warenk&ouml;rbe');
define('RCS_SKIP_MATCHED_CARTS_DESC', 'Pr&uuml;fen, ob der Kunde den Warenkorb alternativ abgeschlossen hat (z.B. &uuml;ber Gastzugang statt per Anmeldung).');
define('RCS_AUTO_CHECK_TITLE', '"sichere" Warenk&ouml;rbe automatisch markieren');
define('RCS_AUTO_CHECK_DESC', 'Um Eintr&auml;ge, die relativ sicher sind (z.B. noch nicht existierende Kunden, noch nicht angemailt, etc.) zu markieren, setzen Sie <b>true</b>.<br>Wenn auf <b>false</b> gesetzt, werden keine Eintr&auml;ge vorausgew&auml;hlt.');
define('RCS_CARTS_MATCH_ALL_DATES_TITLE', 'Verwende Bestellungen jeden Datums');
define('RCS_CARTS_MATCH_ALL_DATES_DESC', 'Wenn <b>true</b> wird jede Bestellung des Kunden f&uuml;r die alternativen Abschl&uuml;sse herangezogen.<br>Wenn <b>false</b> werden nur Bestellungen im Zeitraum nach dem ablegen des letzten Artikels im Warenkorb gesucht.');
define('RCS_PENDING_SALE_STATUS_TITLE', 'Mindestbestellstatus');
define('RCS_PENDING_SALE_STATUS_DESC', 'H&ouml;chster Status, den eine Bestellung haben kann, um immer noch als offen zu gelten. Alle Werte dar&uuml;ber werden als Kauf gewertet');
define('RCS_REPORT_EVEN_STYLE_TITLE', 'Style ungerade Reihe');
define('RCS_REPORT_EVEN_STYLE_DESC', 'Style f&uuml;r die ungeraden Reihen im Bericht. Typische Optionen sind <i>dataTableRow</i> und <i>attributes-even</i>.');
define('RCS_REPORT_ODD_STYLE_TITLE', 'Style gerade Reihe');
define('RCS_REPORT_ODD_STYLE_DESC', 'Style f&uuml;r die geraden Reihen im Bericht. Typische Optionen sind NULL (bzw. kein Eintrag) und <i>attributes-odd</i>.');
define('RCS_SHOW_BRUTTO_PRICE_TITLE', 'Brutto-Anzeige');
define('RCS_SHOW_BRUTTO_PRICE_DESC', 'Sollen die Preise Brutto (true) oder Netto (false) angezeigt werden?');
define('DEFAULT_RCS_PAYMENT_TITLE', 'Standard-Zahlweise');
define('DEFAULT_RCS_PAYMENT_DESC', 'Modulname der Zahlweise f&uuml;r das abschlie&szlig;en der Bestellung (z.B. moneyorder).');
define('DEFAULT_RCS_SHIPPING_TITLE', 'Standard-Versandart');
define('DEFAULT_RCS_SHIPPING_DESC', 'Modulname der Versandart f&uuml;r das abschlie&szlig;en der Bestellung (z.B. dp_dp).');
define('RCS_DELETE_COMPLETED_ORDERS_TITLE', 'Bestellte Warenk&ouml;rbe l&ouml;schen');
define('RCS_DELETE_COMPLETED_ORDERS_DESC', 'Soll der Warenkorb im Zuge des Bestellabschlusses automatisch gel&ouml;scht werden?');

define('IBN_BILLNR_TITLE', 'N&auml;chste Rechnungsnummer');
define('IBN_BILLNR_DESC', 'Beim fakturieren einer Bestellung wird diese Nummer als n&auml;chstes vergeben.'); 
define('IBN_BILLNR_FORMAT_TITLE', 'Rechnungsnummer Format');
define('IBN_BILLNR_FORMAT_DESC', 'Aufbauschema Rechn.Nr.: {n}=laufende Nummer, {d}=Tag, {m}=Monat, {y}=Jahr, <br>z.B. "100{n}-{d}-{m}-{y}" ergibt "10099-28-02-2007"'); 
define('MAX_RANDOM_PRODUCTS_TITLE','Zufallsprodukte Startseite');
define('MAX_RANDOM_PRODUCTS_DESC','Maximum Anzahl an Zufallsprodukten, die auf der Startseite angezeigt werden sollen.');

define('SEARCH_ACTIVATE_SUGGEST_TITLE','Fehlertolerante Suche aktivieren');
define('SEARCH_ACTIVATE_SUGGEST_DESC','Vorschl&auml;ge zu Suchbegriffen und &auml;hnlichen Produkten bei erfolgloser Suche aktivieren / deaktivieren');
define('SEARCH_PRODUCT_KEYWORDS_TITLE','Extra Keywords einbeziehen');
define('SEARCH_PRODUCT_KEYWORDS_DESC','Bezieht das Extra Feld "Zusatz-Begriffe f&uuml;r Suche" mit ein.');
define('SEARCH_PRODUCT_DESCRIPTION_TITLE','Produktbeschreibungen mit einbeziehen');
define('SEARCH_PRODUCT_DESCRIPTION_DESC','Durchsucht die Produktbeschreibung und die Produkt-Kurzbeschreibung nach &auml;nlichen Begriffen.<br /><b style="color:red">Vorsicht: Diese Option ist nur f&uuml;r Shops mit geringen Produktmengen geeignet!</b>');
define('SEARCH_PROXIMITY_TRIGGER_TITLE','Aktivieren ab &Uuml;bereinstimmung in %');
define('SEARCH_PROXIMITY_TRIGGER_DESC','Ab wieviel % &Uuml;bereinstimmung sollen Vorschl&auml;ge angezeigt werden? <br /><b>Standard = 70</b>');
define('SEARCH_WEIGHT_LEVENSHTEIN_TITLE','LEVENSHTEIN-Faktor in % (0-100)');
define('SEARCH_WEIGHT_LEVENSHTEIN_DESC','Welchen Anteil soll die LEVENSHTEIN-Funktion an der Berechnung der &Uuml;bereinstimmung erhalten?<br /><span style="color:red"><b><u>Hinweise zum Laufzeitverhalten:</u></b> die Nutzung mehrerer Funktionen erh&ouml;ht die Laufzeit! Bei Problemen mit zu langer Laufzeit am Besten nur eine Fukntion nutzen. <br/>Alle drei Funktionen sollten addiert 100% ergeben, also z.B. 40%-40%-20%.</span> <br /><b>Standard = 0</b>');
define('SEARCH_WEIGHT_SIMILAR_TEXT_TITLE','SIMILAR-TEXT-Faktor in % (0-100)');
define('SEARCH_WEIGHT_SIMILAR_TEXT_DESC','Welchen Anteil soll die SIMILAR-TEXT-Funktion an der Berechnung der &Uuml;bereinstimmung erhalten? <br />Hinweise siehe LEVENSHTEIN!<br /><b>Standard = 100</b>');
define('SEARCH_WEIGHT_METAPHONE_TITLE','METAPHONE-Faktor in % (0-100)');
define('SEARCH_WEIGHT_METAPHONE_DESC','Welchen Anteil soll die METAPHONE-Funktion an der Berechnung der &Uuml;bereinstimmung erhalten? <br />Hinweise siehe LEVENSHTEIN!<br /><b>Standard = 0</b>');
define('SEARCH_SPLIT_MINIMUM_LENGTH_TITLE','Ignorierte Wortl&auml;nge');
define('SEARCH_SPLIT_MINIMUM_LENGTH_DESC','W&ouml;rter werden ignoriert, wenn kurz oder k&uuml;rzer als der Wert.<br /><span style="color:red"><b><u>Hinweise zum Laufzeitverhalten:</u></b> Bei Problemen mit zu langer Laufzeit kann der Wert auf 4 oder 5 erh&ouml;ht werden, wenn Sie keine relevanten Begriffe dieser Wortl&auml;nge im Shop haben.</span><br /> <b>Standard = 3</b>');
define('SEARCH_SPLIT_PRODUCT_NAMES_TITLE','Produktnamen teilen');
define('SEARCH_SPLIT_PRODUCT_NAMES_DESC','Sollen Produktnamen an bestimmten Stellen geteilt und getrennt untersucht werden? <br /><span style="color:red"><b><u>Hinweise zum Laufzeitverhalten:</u></b> Deaktivieren schont die Laufzeit, findet aber weniger Begriffe</span><br />Diese Einstellung wird ignoriert, wenn Keywords und/oder Produktbeschreibungen einbezogen werden!<br /><b>Standard = true</b>');
define('SEARCH_SPLIT_PRODUCT_CHARS_TITLE','Trennzeichen zur Teilung');
define('SEARCH_SPLIT_PRODUCT_CHARS_DESC','an welchen Zeichen sollen die Produktnamen zerlegt werden? Die gew&uuml;nschten Zeichen sind in eckige Klammern zu setzen.<br />Beispiele: [ ] oder [-] oder [ -] oder [ /-]<br /><b>Standard = [ ]</b>');
define('SEARCH_MAX_KEXWORD_SUGGESTS_TITLE','Anzahl der Suchbegriff-Vorschl&auml;ge');
define('SEARCH_MAX_KEXWORD_SUGGESTS_DESC','Wieviele Suchbegriffe sollen maximal vorgeschlagen werden? <br /><b>Standard = 6</b>');
define('SEARCH_COUNT_PRODUCTS_TITLE','Produkte zu Vorschl&auml;gen z&auml;hlen');
define('SEARCH_COUNT_PRODUCTS_DESC','Soll die Anzahl der Produkte, die ein vorgeschlagener Suchbegriff findet angezeigt werden?<br /><span style="color:red"><b><u>Hinweise zum Laufzeitverhalten:</u></b> Kann in Kombination mit vielen Suchbegriffvorschl&auml;gen die Laufzeit verl&auml;ngern. Bei Problemen deaktivieren.</span> <br /><b>Standard = true</b>');
define('SEARCH_ENABLE_PROXIMITY_COLOR_TITLE','Farbwerte f&uuml;r &Uuml;bereinstimmung aktivieren');
define('SEARCH_ENABLE_PROXIMITY_COLOR_DESC','Soll die Anzeige der Relevanz (&Uuml;bereinstimmung) mit Farben unterst&uuml;tzt werden? <br/> <b>Standard = true</b>');
define('SEARCH_PROXIMITY_COLORS_TITLE','Farbwerte');
define('SEARCH_PROXIMITY_COLORS_DESC','Angabe der Farbwerte mit Semikolon getrennt. Der erste Farbwert wird bei &Uuml;bereinstimmungen zwischen 90% und 100% angezeigt, der zweite von 80% - 89% etc. <br/><b>Standard = #9f6;#cf6;#ff6;#fc9;#f99</b>');
define('SEARCH_ENABLE_PRODUCTS_SUGGEST_TITLE','Produktvorschl&auml;ge aktivieren');
define('SEARCH_ENABLE_PRODUCTS_SUGGEST_DESC','Sollen zus&auml;tzlich relevante Produkte angezeigt werden?<br /><span style="color:red"><b><u>Hinweise zum Laufzeitverhalten:</u></b> Bei Problemen mit der Laufzeit, diese Option deaktivieren oder zumindest die Anzahl der vorgeschlagenen Produkte verringern</span><br/><b>Standard = true</b>');
define('SEARCH_MAX_PRODUCTS_SUGGEST_TITLE','Maximale Produktvorschl&auml;ge');
define('SEARCH_MAX_PRODUCTS_SUGGEST_DESC','Wieviele Produktvorschl&auml;ge sollen maximal angezeigt werden? <br/><b>Standard = 15</b>');
define('SEARCH_SHOW_PARSETIME_TITLE','Ausgabe der Parsetime');
define('SEARCH_SHOW_PARSETIME_DESC','Zu Test- und Einrichtungszwecken kann die Parsetime der fehlertoleranten Suche ausgegeben werden. F&uuml;r den produktiven Betrieb sollte diese Funktion abgestellt werden!');

define('MAX_ROW_LISTS_OPTIONS_TITLE' , 'L&auml;nge der Artikelmerkmale Listen');
define('MAX_ROW_LISTS_OPTIONS_DESC' , 'Anzeige, wie viele Artikelmerkmale und Optionswerte in der Artikelmerkmale-Verwaltung angezeigt werden sollen');

define('TAX_DECIMAL_PLACES_TITLE' , 'Steuersatz-Dezimalstellen');
define('TAX_DECIMAL_PLACES_DESC' , 'Die Anzahl der Dezimalstellen f&uuml;r den Steuersatz');
#Category Listing Frontpage 2.0.10
define('CATEGORY_LISTING_START_TITLE','Kategoriebox Startseite Mitte:');
define('CATEGORY_LISTING_START_DESC','Soll die Mittelbox Kategorien auf der Startseite angezeigt werden?');

define('CATEGORY_LISTING_START_HEAD_TITLE','Kategoriebox Startseite Überschrift:');
define('CATEGORY_LISTING_START_HEAD_DESC','Sollen die Überschriften in der Kategoriebox auf der Startseite angezeigt werden?');

define('CATEGORY_LISTING_START_PICTURE_TITLE','Kategoriebox Startseite Bilder:');
define('CATEGORY_LISTING_START_PICTURE_DESC','Sollen die Kategorie-Bilder in der Kategoriebox auf der Startseite angezeigt werden?');

define('CATEGORY_LISTING_START_DESCR_TITLE','Kategoriebox Startseite Beschreibung:');
define('CATEGORY_LISTING_START_DESCR_DESC','Sollen die Beschreibungen in der Kategoriebox auf der Startseite angezeigt werden?');

#New in V2.1

define('MAX_DISPLAY_TAGS_RESULTS_TITLE','Wie viele Tags sollen angezeigt werden?');
define('MAX_DISPLAY_TAGS_RESULTS_DESC','Einstellung für die Box Tag-Cloud, wie viele angezeigt werden sollen.');
define('MIN_DISPLAY_TAGS_FONT_TITLE','Mindestschriftgr&ouml;sse Tags?');
define('MIN_DISPLAY_TAGS_FONT_DESC','Wie gross soll die Schrift minimal sein?');
define('MAX_DISPLAY_TAGS_FONT_TITLE','Maximalschriftgr&ouml;sse Tags?');
define('MAX_DISPLAY_TAGS_FONT_DESC','Wie gross soll die Schrift maximal sein?');
define('DISPLAY_NEW_PRODUCTS_SLIDE_TITLE','Startseiten Produkt-Boxen als Slide:');
define('DISPLAY_NEW_PRODUCTS_SLIDE_DESC','Gibt an, ob neue Produkte auf der Startseite oder in Kategorien als Slideshow angezeigt werden sollen. Diese Funktion ist für die Grid-Templates optimiert. Für die Responsive- / Fluid-Templates sind Anpassungen notwendig.');

define('CURRENT_MOBILE_TEMPLATE_TITLE' , 'mobiles-Template');
define('CURRENT_MOBILE_TEMPLATE_DESC' , 'Dieses Template ist für Mobilgeräte. Das Template muss sich im Ordner /templates/ befinden.<br /><br />Weitere Templates finden sie unter <a href="http://www.seo-template.de">http://www.seo-template.de</a>');


define('TWITTERBOX_STATUS_TITLE' , 'Twitterbox-Status');
define('TWITTERBOX_STATUS_DESC' , 'true = aktiv, false = inaktiv');
define('TWITTER_ACCOUNT_TITLE' , 'Twitterbox-Account');
define('TWITTER_ACCOUNT_DESC' , 'Verwenden Sie hier Ihren Account Name von Twitter, Beispiel: commerce_SEO (http://www.twitter.com/commerce_SEO)');
define('TWITTER_SCROLLBAR_TITLE' , 'Scrollbar');
define('TWITTER_SCROLLBAR_DESC' , 'Soll der Kunde in der Box die Beiträge scrollen können? (true = aktiv, false = inaktiv)');
define('TWITTER_LOOP_TITLE' , 'Twitter Loop');
define('TWITTER_LOOP_DESC' , 'true = aktiv, false = inaktiv');
define('TWITTER_LIVE_TITLE' , 'Twitter Live');
define('TWITTER_LIVE_DESC' , 'true = aktiv, false = inaktiv');
define('TWITTER_HASHTAGS_TITLE' , 'Twitter Hashtags');
define('TWITTER_HASHTAGS_DESC' , 'true = aktiv, false = inaktiv');
define('TWITTER_TIMESTAMP_TITLE' , 'Twitter Zeitstempel');
define('TWITTER_TIMESTAMP_DESC' , 'true = aktiv, false = inaktiv');
define('TWITTER_AVATARS_TITLE' , 'Twitter Avatar');
define('TWITTER_AVATARS_DESC' , 'true = aktiv, false = inaktiv');
define('TWITTER_BEHAVIOR_TITLE' , 'Twitter Limit');
define('TWITTER_BEHAVIOR_DESC' , 'all = alle');
define('TWITTER_SHELL_BACKGROUND_TITLE' , 'Hintergrund-Farbe Kopf');
define('TWITTER_SHELL_BACKGROUND_DESC' , 'Geben Sie die Hex-Farbwerte ein');
define('TWITTER_SHELL_COLOR_TITLE' , 'Schrift-Farbe Kopf');
define('TWITTER_SHELL_COLOR_DESC' , 'Geben Sie die Hex-Farbwerte ein');
define('TWITTER_TWEETS_BACKGROUND_TITLE' , 'Hintergrund-Farbe Tweets');
define('TWITTER_TWEETS_BACKGROUND_DESC' , 'Geben Sie die Hex-Farbwerte ein');
define('TWITTER_TWEETS_COLOR_TITLE' , 'Schrift-Farbe Tweets');
define('TWITTER_TWEETS_COLOR_DESC' , 'Geben Sie die Hex-Farbwerte ein');
define('TWITTER_TWEETS_LINKS_TITLE' , 'Link-Farbe Tweets');
define('TWITTER_TWEETS_LINKS_DESC' , 'Geben Sie die Hex-Farbwerte ein');
define('TWITTER_BOX_WIDTH_TITLE' , 'Breite der Box');
define('TWITTER_BOX_WIDTH_DESC' , 'Geben Sie die Breite der Box in Pixel (ohne px) an');
define('TWITTER_BOX_HEIGHT_TITLE' , 'Höhe der Box');
define('TWITTER_BOX_HEIGHT_DESC' , 'Geben Sie die Höhe der Box in Pixel (ohne px) an');
define('TWITTER_BOX_INTERVAL_TITLE' , 'Interval der Aktualisierung');
define('TWITTER_BOX_INTERVAL_DESC' , 'Geben Sie den Wert in Millisekunden an');

define('PRODUCT_INFO_QR_TITLE' , 'QR Code generieren für Produkte');
define('PRODUCT_INFO_QR_DESC' , 'true = aktiv, false = inaktiv');

define('PRODUCT_DETAILS_MODELLNR_TITLE' , 'Artikelnummer');
define('PRODUCT_DETAILS_MODELLNR_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_MANUFACTURERS_MODELLNR_TITLE' , 'Hersteller-Artikelnummer');
define('PRODUCT_DETAILS_MANUFACTURERS_MODELLNR_DESC' , 'true = aktiv, false = inaktiv');

define('PRODUCT_DETAILS_SHIPPINGTIME_TITLE' , 'Lieferzeit');
define('PRODUCT_DETAILS_SHIPPINGTIME_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_STOCK_TITLE' , 'Verfügbarkeit');
define('PRODUCT_DETAILS_STOCK_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_EAN_TITLE' , 'EAN');
define('PRODUCT_DETAILS_EAN_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_VPE_TITLE' , 'VPE');
define('PRODUCT_DETAILS_VPE_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_WEIGHT_TITLE' , 'Gewicht');
define('PRODUCT_DETAILS_WEIGHT_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_PRINT_TITLE' , 'Drucken');
define('PRODUCT_DETAILS_PRINT_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_WISHLIST_TITLE' , 'Merkzettel');
define('PRODUCT_DETAILS_WISHLIST_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_ASKQUESTION_TITLE' , 'Tab Frage zum Produkt');
define('PRODUCT_DETAILS_ASKQUESTION_DESC' , 'true = aktiv, false = inaktiv');

define('PRODUCT_DETAILS_TAB_DESCRIPTION_TITLE' , 'Tab Beschreibung');
define('PRODUCT_DETAILS_TAB_DESCRIPTION_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_TAB_ADD_TITLE' , 'Tab Allgemeine Zusatzbeschreibung');
define('PRODUCT_DETAILS_TAB_ADD_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_TAB_PRODUCT_TITLE' , 'Tab Produktbezogene Zusatzbeschreibung ');
define('PRODUCT_DETAILS_TAB_PRODUCT_DESC' , 'true = aktiv, false = inaktiv (abhängig, ob eine Content-Group ID für das jeweilige Produkt angegeben wurde');
define('PRODUCT_DETAILS_TAB_ADD_CONTENT_GROUP_ID_TITLE' , 'Content Group-ID');
define('PRODUCT_DETAILS_TAB_ADD_CONTENT_GROUP_ID_DESC' , 'Content <b>Group-ID</b> für die allgemeine Zusatzbeschreibung. Diese entnehmen Sie dem Content Manager.');
define('PRODUCT_DETAILS_TAB_ACCESSORIES_TITLE' , 'Tab Zubehör');
define('PRODUCT_DETAILS_TAB_ACCESSORIES_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_TAB_PARAMETERS_TITLE' , 'Tab Produkteigenschaften');
define('PRODUCT_DETAILS_TAB_PARAMETERS_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_TAB_REVIEWS_TITLE' , 'Tab Bewertung');
define('PRODUCT_DETAILS_TAB_REVIEWS_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_TAB_CROSS_SELLING_TITLE' , 'Tab Cross Selling');
define('PRODUCT_DETAILS_TAB_CROSS_SELLING_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_TAB_MEDIA_TITLE' , 'Tab Produkt Media');
define('PRODUCT_DETAILS_TAB_MEDIA_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_TAB_ALSO_PURCHASED_TITLE' , 'Tab Auch gekauft');
define('PRODUCT_DETAILS_TAB_ALSO_PURCHASED_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_TAB_REVERSE_CROSS_SELLING_TITLE' , 'Tab Reverse Cross Selling');
define('PRODUCT_DETAILS_TAB_REVERSE_CROSS_SELLING_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_TAGS_TITLE' , 'Tags');
define('PRODUCT_DETAILS_TAGS_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_RELATED_CAT_TITLE' , 'Zufallsartikel');
define('PRODUCT_DETAILS_RELATED_CAT_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_SOCIAL_TITLE' , 'Twitter/Facebook');
define('PRODUCT_DETAILS_SOCIAL_DESC' , 'true = aktiv, false = inaktiv');
define('PRODUCT_DETAILS_TAB_MANUFACTURERS_TITLE' , 'Tab Herstellerinformationen');
define('PRODUCT_DETAILS_TAB_MANUFACTURERS_DESC' , 'true = aktiv, false = inaktiv');

define('META_MAX_KEYWORD_LENGTH_TITLE' , 'Maximale L&auml;nge Meta-Keywords');
define('META_MAX_KEYWORD_LENGTH_DESC' , 'Maximum L&auml;nge der automatisch erzeugten Meta-Keywords');
define('META_MAX_DESCRIPTION_LENGTH_TITLE' , 'Maximale L&auml;nge Meta-Description');
define('META_MAX_DESCRIPTION_LENGTH_DESC' , 'Maximum L&auml;nge der automatisch erzeugten Meta-Description (versteckte Beschreibung), ein guter Wert ist 160.');
define('META_MAX_TITLE_LENGTH_TITLE' , 'Maximale L&auml;nge title Ausgabe');
define('META_MAX_TITLE_LENGTH_DESC' , 'Maximum L&auml;nge der automatisch erzeugten title (Browsertitel), ein guter Wert ist 60-70.');

define('MAX_DISPLAY_CART_SPECIALS_TITLE' , 'Max. Anzahl Artikel unter Warenkorb'); 
define('MAX_DISPLAY_CART_SPECIALS_DESC' , 'Maximum Anzahl Anzeige weitere Artikel unterhalb des Warenkorbes');

define('TRUSTED_SHOP_CREATE_ACCOUNT_DS_TITLE' , 'Datenschutz bei Konto erstellen'); 
define('TRUSTED_SHOP_CREATE_ACCOUNT_DS_DESC' , 'true = aktiv, false = inaktiv (soll beim Anlegen von Kundenaccounts die Datenschutzbestimmung abgefragt werden)');
define('TRUSTED_SHOP_IP_LOG_TITLE' , 'IP Anzeige im Admin'); 
define('TRUSTED_SHOP_IP_LOG_DESC' , 'true = aktiv, false = inaktiv (wenn false, werden alle IPs von Besuchern / Kunden im Admin nicht mehr angezeigt)');
define('TRUSTED_SHOP_PASSWORD_EMAIL_TITLE' , 'Login und Passwort in Order-Mail'); 
define('TRUSTED_SHOP_PASSWORD_EMAIL_DESC' , 'true = aktiv, false = inaktiv (wenn false, werden dem Kunden nach Anlegen seines Accounts keine Zugangsdaten gesendet)');

define('CHECKOUT_CHECKBOX_AGB_TITLE' , 'AGB als Checkbox'); 
define('CHECKOUT_CHECKBOX_AGB_DESC' , 'true = aktiv, false = inaktiv (wenn false, werden die AGB nur angezeigt, müssen aber nicht abgehakt werden)');

define('CHECKOUT_CHECKBOX_REVOCATION_TITLE' , 'Widerrufsrecht als Checkbox'); 
define('CHECKOUT_CHECKBOX_REVOCATION_DESC' , 'true = aktiv, false = inaktiv (wenn false, wird das Widerrufsrecht nur angezeigt, muss aber nicht abgehakt werden)');

define('CHECKOUT_CHECKBOX_DSG_TITLE' , 'Datenschutz als Checkbox'); 
define('CHECKOUT_CHECKBOX_DSG_DESC' , 'true = aktiv, false = inaktiv (wenn false, wird der Datenschutz nur angezeigt, muss aber nicht abgehakt werden)');

define('PRODUCT_INFO_GALLERY_TITLE' , 'Bildergalerie Anzeige'); 
define('PRODUCT_INFO_GALLERY_DESC' , 'Gibt an, wie die Bildergalerie (Popup) angezeigt werden soll.  <br />Gültige Werte: <br /><b>dark_rounded, dark_square, facebook, light_rounded, light_square, default</b>');

define('PRODUCT_INFO_GALLERY_SLIDE_TITLE' , 'Slideshow in der Bildergalerie automatisch starten?'); 
define('PRODUCT_INFO_GALLERY_SLIDE_DESC' , 'true = aktiv, false = inaktiv');

define('PRODUCT_GOOGLE_STANDARD_TAXONOMIE_TITLE' , 'Google-Standard-Taxonomie:'); 
define('PRODUCT_GOOGLE_STANDARD_TAXONOMIE_DESC' , 'Stellen Sie hier die Standardvorgabe für die neue Google-Base Taxonomie ein. <br />Diese wird verwendet, wenn Sie Ihrem Produkt noch keine Google-Taxonomie zugeordnet haben.<br /><b>Beispiel: Bekleidung & Accessoires > Bekleidung > Kleider</b> <br />WICHTIG: Bitte bei Google die korrekte <a href ="http://www.google.com/support/merchants/bin/answer.py?answer=160081" target="_blank">Taxonomie</a> für Ihren Shop ermitteln!');

define('SEARCH_IN_CATDESC_TITLE' , 'Suche auch in Katekorie-Namen / Beschreibungen?'); 
define('SEARCH_IN_CATDESC_DESC' , 'true = aktiv, false = inaktiv');

define('CAT_NAV_AJAX_TITLE' , 'Kategorie als AJAX:'); 
define('CAT_NAV_AJAX_DESC' , 'Unterkategorien werden als AJAX-Menue dargestellt. Horizontales ausklappen der Unterkategorien. (true = aktiv, false = inaktiv). Diese Funktion ist für die Grid-Templates optimiert. Für die Responsive- / Fluid-Templates sind Anpassungen notwendig.');

define('DISPLAY_RAND_PRODUCTS_SLIDE_TITLE' , 'Besondere Produkte Startseite als Slide:'); 
define('DISPLAY_RAND_PRODUCTS_SLIDE_DESC' , 'Besondere Produkte Startseite als Slideshow. Diese Funktion ist für die Grid-Templates optimiert. Für die Responsive- / Fluid-Templates sind Anpassungen notwendig.');

define('ADMIN_AFTER_LOGIN_TITLE' , 'Admin Start nach Login?'); 
define('ADMIN_AFTER_LOGIN_DESC' , 'Mit dieser Einstellung wird der Master Admin nach dem Login automatisch auf die Admin-Startseite geleitet.');

define('SHIPPING_SPERRGUT_1_TITLE','Sperrgut 1');
define('SHIPPING_SPERRGUT_1_DESC','Aufpreis für Sperrgut 1');

define('SHIPPING_SPERRGUT_2_TITLE','Sperrgut 2');
define('SHIPPING_SPERRGUT_2_DESC','Aufpreis für Sperrgut 2');

define('SHIPPING_SPERRGUT_3_TITLE','Sperrgut 3');
define('SHIPPING_SPERRGUT_3_DESC','Aufpreis für Sperrgut 3');

define('PDF_RECHNUNG_OID_TITLE','Rechnungsnummer Vergabe');
define('PDF_RECHNUNG_OID_DESC','<b>true</b> = Rechnungsnummer = Bestellnummer <br /><b>false</b> = Rechnungsnummer unabhängig von der Bestellnummer fortlaufend.');

define('PDF_RECHNUNG_DATE_ACT_TITLE','Rechnungsdatum');
define('PDF_RECHNUNG_DATE_ACT_DESC','<b>true</b> = Rechnungsdatum = Rechnungserstellungsdatum <br /><b>false</b> = Rechnungsdatum = Bestelldatum.');

//AmazonPayMent
include_once('../lang/german/modules/payment/rmamazon.php');

define('MODULE_CUSTOMERS_ADMINMAIL_STATUS_TITLE' , 'Lagerbestandswarnung aktivieren');
define('MODULE_CUSTOMERS_ADMINMAIL_STATUS_DESC' , 'Aktivieren Sie diese Funktion, wenn Sie als Admin eine Infomail erhalten wollen, wenn der Lagerbestand eines Artikels einen bestimmten Wert unterschritten hat.');

define('ANTISPAM_REVIEWS_TITLE' , 'Antispam Abfrage in Produktbewertungen:');
define('ANTISPAM_REVIEWS_DESC' , 'Soll in den Produktkommentaren / Bewertungen eine Antispam Abfrage erscheinen?');

define('ANTISPAM_BLOG_TITLE' , 'Antispam Abfrage im Blog:');
define('ANTISPAM_BLOG_DESC' , 'Soll im Blog für Kommentare eine Antispam Abfrage erscheinen?');

define('ANTISPAM_ASKQUESTION_TITLE' , 'Antispam Abfrage in Frage zum Produkt:');
define('ANTISPAM_ASKQUESTION_DESC' , 'Soll in Frage zum Produkt eine Antispam Abfrage erscheinen?');

define('ANTISPAM_CONTACT_TITLE' , 'Antispam Abfrage im Kontaktformular:');
define('ANTISPAM_CONTACT_DESC' , 'Soll im Kontaktformular eine Antispam Abfrage erscheinen?');

define('ANTISPAM_NEWSLETTER_TITLE' , 'Antispam Abfrage Newsletteranmeldung:');
define('ANTISPAM_NEWSLETTER_DESC' , 'Soll in der Newsletteranmeldung eine Antispam Abfrage erscheinen?');

define('ANTISPAM_PASSWORD_TITLE' , 'Antispam Abfrage bei Passwort-Seiten:');
define('ANTISPAM_PASSWORD_DESC' , 'Soll bei Seiten, bei denen ein Passwort (wie Login mit aktivierter Anmeldeschutz-Funtion, Login-Offline oder Passwort vergessen) abgefragt wird, eine Antispam Abfrage erscheinen?');

define('ACCOUNT_PASSWORD_SECURITY_TITLE' , '<span style="color:red">Erweiterte Passwort Sicherheit</span>:');
define('ACCOUNT_PASSWORD_SECURITY_DESC' , 'Soll die erweiterte Passwort Sicherheit eingeschaltet werden?<br /><b>Beachten Sie, dass hierdurch das Passwortverfahren auf eine erweitere Verschlüsselung umgestellt wird. Unter Umständen kann es hierbei zu Problemen mit WAWI-Anbietern kommen!</b><br />Sollten Sie keine externen Schnittstellen nutzen, die eine Passwortabfrage nach xt:Commerce Standard machen, können Sie diese Funktion beruhigt einschalten. Somit erhalten Sie mehr Schutz für Ihre Passwörter im Shop.');

define('ETRACKER_CODE_TITLE', 'eTracker Code:');
define('ETRACKER_CODE_DESC', 'Geben Sie hier den eTracker-Code ein.');

define('CSEO_URL_ADMIN_ON_TITLE', 'SEO-URL Update im Admin:');
define('CSEO_URL_ADMIN_ON_DESC', 'Wenn Sie im Admin ein Produkt bearbeiten oder Content, wird im Hintergrund automatisch die SEO-URL, wenn installiert, aktualisiert. Das kann bei sehr großen Shops teilweise zu Performance-Problemen bei der Erfassung führen. Wenn Sie diese Option auf "<b>false</b>" stellen, werden die SEO-URL nicht mehr automatish aktualisiert, wenn Sie ein Produkt ändern. <br /><b>WICHTIG:</b> Wenn Sie Ihre Änderungen am Shop vorgenommen haben, starten Sie die SEO-URL anschließend manuell.');

define('CHECKOUT_SHOW_SHIPPING_TITLE', 'Anzeige Steuer/Zoll-Hinweis im Checkout:');
define('CHECKOUT_SHOW_SHIPPING_DESC', 'Soll der Hinweis im Checkout angezeigt werden, dass für den versand zusätzliche Gebühren anfallen können?.');

define('CHECKOUT_SHOW_SHIPPING_ID_TITLE', 'Content-Group ID für Checkouthinweis:');
define('CHECKOUT_SHOW_SHIPPING_ID_DESC', 'Tragen Sie hier die Content-Group-ID ein, in welcher der Text für den Hinweis steht. Der Text muss im Contentmanager angelegt sein, muss aber nicht in einer Box sichtbar sein.');

define('PAYPAL_EXPRESS_INFOID_TITLE', 'Content-Group ID für Checkout-PayPal:');
define('PAYPAL_EXPRESS_INFOID_DESC', 'Tragen Sie hier die Content-Group-ID ein, in welcher der Text für den PayPal Express Hinweis steht. Der Text muss im Contentmanager angelegt sein, muss aber nicht in einer Box sichtbar sein.');

define('USE_MOBILE_TEMPLATE_TITLE', 'mobiles Template:');
define('USE_MOBILE_TEMPLATE_DESC', 'Soll auf Mobil-Telefonen das mobile-Template aktiviert werden? Dieses mobile-Template ähnelt einer i-Phone App und wird über jQuery Mobile ausgegeben.');

define('USE_MOBILE_TEMPLATE_TOPSELLER_TITLE', 'mobiles Template Topsellerbox:');
define('USE_MOBILE_TEMPLATE_TOPSELLER_DESC', 'Soll auf Mobil-Telefonen die Topsellerbox aktiviert werden.');

define('USE_MOBILE_TEMPLATE_SEARCH_TITLE', 'mobiles Template Suche:');
define('USE_MOBILE_TEMPLATE_SEARCH_DESC', 'Soll auf Mobil-Telefonen die Suchebox aktiviert werden.');

define('USE_MOBILE_TEMPLATE_NEWPRODUCTS_TITLE', 'mobiles Template Neue Produkte:');
define('USE_MOBILE_TEMPLATE_NEWPRODUCTS_DESC', 'Soll auf Mobil-Telefonen die neuen Produkte als Box aktiviert.');


define('ADMIN_CSEO_ATTRIBUT_MANAGER_TITLE', 'Attributmanager im Produkt aktivieren:');
define('ADMIN_CSEO_ATTRIBUT_MANAGER_DESC', 'Soll der Attributmanager im Produkt aktiviert werden.');

define('ADMIN_CSEO_TABS_VIEW_TITLE', 'Tabs in Produkbearbeitung aktivieren:');
define('ADMIN_CSEO_TABS_VIEW_DESC', 'Sollen die Tabs in Produkbearbeitung aktiviert werden.');

define('ADMIN_CSEO_TOP_COLUMN_VIEW_TITLE', 'Admin Navigation Top:');
define('ADMIN_CSEO_TOP_COLUMN_VIEW_DESC', 'Soll die oberste Navigationsleiste aktiviert werden.');

define('ADMIN_CSEO_LEFT_COLUMN_FULL_VIEW_TITLE', 'Admin Navigation links alle:');
define('ADMIN_CSEO_LEFT_COLUMN_FULL_VIEW_DESC', 'Soll die linke Navigationsleite angezeigt werden. Hier wird die komplette Navigation links angezeigt.');

define('ADMIN_CSEO_LEFT_COLUMN_SECTION_VIEW_TITLE', 'Admin Navigation links Sektionen:');
define('ADMIN_CSEO_LEFT_COLUMN_SECTION_VIEW_DESC', 'Soll die linke Navigationsleite angezeigt werden. Hier wird pro Admin-Sektion die entsprechende Box angezeigt.');

define('ADMIN_CSEO_START_BIRTHDAY_TITLE', 'Admin Start Geburtstage:');
define('ADMIN_CSEO_START_BIRTHDAY_DESC', 'Soll auf der Admin Startseite das Geburtstag-Modul angezeigt werden.');

define('ADMIN_CSEO_START_RSS_TITLE', 'Admin Start RSS Feed:');
define('ADMIN_CSEO_START_RSS_DESC', 'Soll auf der Admin Startseite das RSS Feed-Modul angezeigt werden.');

define('ADMIN_CSEO_START_WHOISONLINE_TITLE', 'Admin Start Besucher:');
define('ADMIN_CSEO_START_WHOISONLINE_DESC', 'Soll auf der Admin Startseite das Besucher-Modul angezeigt werden.');

define('ADMIN_CSEO_START_ORDERS_TITLE', 'Admin Start Bestellungen:');
define('ADMIN_CSEO_START_ORDERS_DESC', 'Soll auf der Admin Startseite das Bestellungen-Modul angezeigt werden.');

define('CSEO_LOG_404_TITLE', '404 aufzeichnen:');
define('CSEO_LOG_404_DESC', 'Sollen 404 Aufrufe in der Datenbank protokolliert werden.');

define('ADMIN_CSS_VIEW_TITLE', 'Admin Style:');
define('ADMIN_CSS_VIEW_DESC', 'normal = kräftige Farben, light = einfache Farbgebung.');

define('DISPLAY_SUBCAT_PRODUCTS_TITLE', 'alle Produkte in Kategorielisting:');
define('DISPLAY_SUBCAT_PRODUCTS_DESC', 'Sollen alle Produkte in Kategorien angezeigt werden, wo Unterkategorien vorhanden sind, statt nur neue Produkte.');

#v2.3.2
define('ADDCATSHOPTITLE_TITLE', 'Shoptitle in Kategorien');
define('ADDCATSHOPTITLE_DESC', 'Soll der Shop Name in Kategorien angehangen werden.');

define('ADDPRODSHOPTITLE_TITLE', 'Shoptitle in Produkten');
define('ADDPRODSHOPTITLE_DESC', 'Soll der Shop Name in Produkten angehangen werden.');

define('ADDCONTENTSHOPTITLE_TITLE', 'Shoptitle in Content');
define('ADDCONTENTSHOPTITLE_DESC', 'Soll der Shop Name in Content angehangen werden.');

define('ADDSPECIALSSHOPTITLE_TITLE', 'Shoptitle in Sonderangeboten');
define('ADDSPECIALSSHOPTITLE_DESC', 'Soll der Shop Name in Sonderangeboten angehangen werden.');

define('ADDNEWSSHOPTITLE_TITLE', 'Shoptitle in neuen Produkten');
define('ADDNEWSSHOPTITLE_DESC', 'Soll der Shop Name in neuen Produkten angehangen werden.');

define('ADDSEARCHSHOPTITLE_TITLE', 'Shoptitle in der Suche');
define('ADDSEARCHSHOPTITLE_DESC', 'Soll der Shop Name in der Suche angehangen werden.');

define('ADDOTHERSSHOPTITLE_TITLE', 'Shoptitle in weiteren Seiten');
define('ADDOTHERSSHOPTITLE_DESC', 'Soll der Shop Name in weiteren Seiten angehangen werden.');

define('USE_CODEMIRROR_TITLE', 'Code Mirror verwenden');
define('USE_CODEMIRROR_DESC', 'Soll Codemirror inkl. Vorschau verwendet werden.');

define('TRACKING_PIWIK_ACTIVE_TITLE', 'Piwik eCommerce Tracking');
define('TRACKING_PIWIK_ACTIVE_DESC', 'true = an / false = aus');

define('TRACKING_PIWIK_LOCAL_PATH_TITLE', 'globaler HTTP Piwik Pfad');
define('TRACKING_PIWIK_LOCAL_PATH_DESC', 'Shop-Domain plus Piwik Pfad');

define('TRACKING_PIWIK_LOCAL_SSL_PATH_TITLE', 'SSL Piwik Pfad');
define('TRACKING_PIWIK_LOCAL_SSL_PATH_DESC', 'SSL-Domain plus Piwik Pfad');

define('TRACKING_PIWIK_ID_TITLE', 'Piwik ID');
define('TRACKING_PIWIK_ID_DESC', 'Piwik ID für diese Domain');

define('TREEPODI_GLOBAL_CATCH_1_TITLE', 'Treepodia Catch-Phrase 1');
define('TREEPODI_GLOBAL_CATCH_1_DESC', 'Treepodia globale Catch-Phrase 1');

define('TREEPODI_GLOBAL_CATCH_2_TITLE', 'Treepodia Catch-Phrase 2');
define('TREEPODI_GLOBAL_CATCH_2_DESC', 'Treepodia globale Catch-Phrase 2');

define('TREEPODI_GLOBAL_CATCH_3_TITLE', 'Treepodia Catch-Phrase 3');
define('TREEPODI_GLOBAL_CATCH_3_DESC', 'Treepodia globale Catch-Phrase 3');

define('TREEPODI_GLOBAL_CATCH_4_TITLE', 'Treepodia Catch-Phrase 4');
define('TREEPODI_GLOBAL_CATCH_4_DESC', 'Treepodia globale Catch-Phrase 4');

define('TREEPODIAACTIVE_TITLE', 'Treepodia aktivieren');
define('TREEPODIAACTIVE_DESC', 'true = an / false = aus');

define('TREEPODIAID_TITLE', 'Treepodia ID');
define('TREEPODIAID_DESC', 'Ihre Treepodia ID.<br /><b>Der Link zu Ihrem Treepodia-RSS-Feed ist www.domain.de/treepodia_rss_feed.php</b><br />www.domain.de bitte gegen Ihre Shop Domain tauschen. Dieser Link muss bei Bedarf Treepodia mitgeteilt werden.');


define('USE_TEMPLATE_DEVMODE_TITLE', 'Developer Modus');
define('USE_TEMPLATE_DEVMODE_DESC', 'Diese Funktion ist für Entwickler vorgesehen und sollte NICHT in Produktion verwendet werden!');


define('UPCOMING_PRODUCTS_START_TITLE', 'Bald erscheinende Produkte Start:');
define('UPCOMING_PRODUCTS_START_DESC', 'Produkte, die erst in der Zukunft erscheinen auf der Startseite anzeigen.');

define('RANDOM_PRODUCTS_START_TITLE', 'Zufallsprodukte (Besondere) Start:');
define('RANDOM_PRODUCTS_START_DESC', 'Zufallsprodukte auf der Startseite anzeigen.');

define('RANDOM_SPECIALS_START_TITLE', 'Zufällige Sonderangebote Start:');
define('RANDOM_SPECIALS_START_DESC', 'Sonderangebote auf der Startseite anzeigen.');

define('BLOG_START_TITLE', 'Blog Modul Start:');
define('BLOG_START_DESC', 'Blogbeiträge auf der Startseite anzeigen.');

define('PRODUCT_LISTING_ATTRIBUT_TEMPLATE_TITLE', 'Template für Produktlisten-Attribute');
define('PRODUCT_LISTING_ATTRIBUT_TEMPLATE_DESC', 'Vorlage für die Darstellung der Attribute in Produktlisten.');

define('GOOGLE_VERIFY_TITLE','Google Verifikationscode');
define('GOOGLE_VERIFY_DESC','Geben Sie hier den von Google erzeugten Verifikationscode ein, <b>ohne</b> die meta Definition.');

define('BING_VERIFY_TITLE','Bing Verifikationscode');
define('BING_VERIFY_DESC','Geben Sie hier den von Bing erzeugten Verifikationscode ein, <b>ohne</b> die meta Definition.');

define('GOOGLE_PLUS_AUTHOR_ID_TITLE','Google+ Author ID');
define('GOOGLE_PLUS_AUTHOR_ID_DESC','Geben Sie hier den von Google+ erzeugte Author ID ein, <b>aber</b> nur die Nummer.');

define('FACEBOOK_URL_TITLE','Facebook URL');
define('FACEBOOK_URL_DESC','Geben Sie hier die vollständige Facebook URL zu Ihrem Profil an.');

define('XING_URL_TITLE','Xing URL');
define('XING_URL_DESC','Geben Sie hier die vollständige Xing URL zu Ihrem Profil an.');

define('TWITTER_URL_TITLE','Twitter URL');
define('TWITTER_URL_DESC','Geben Sie hier die vollständige Twitter URL zu Ihrem Profil an.');

define('PINTEREST_URL_TITLE','Pinterest URL');
define('PINTEREST_URL_DESC','Geben Sie hier die vollständige Pinterest URL zu Ihrem Profil an.');

define('GOOGLEPLUS_URL_TITLE','Google+ URL');
define('GOOGLEPLUS_URL_DESC','Geben Sie hier die vollständige Google+ URL zu Ihrem Profil an.');

define('YOUTUBE_URL_TITLE','Youtube URL');
define('YOUTUBE_URL_DESC','Geben Sie hier die vollständige Youtube URL zu Ihrem Profil an.');

define('TUMBLR_URL_TITLE','Tumblr URL');
define('TUMBLR_URL_DESC','Geben Sie hier die vollständige Tumblr URL zu Ihrem Profil an.');

define('MASTER_SLAVE_FUNCTION_TITLE','Master-/Slave Funktion in Produkten');
define('MASTER_SLAVE_FUNCTION_DESC','Soll für Produkte Master-/Slave verwendet werden? <b>Hinweis</b>: Diese Funktion kann bei sehr großen Shops zu Performance Einbussen führen!');

define('CHECKOUT_SHOW_DESCRIPTION_TITLE','Produktbeschreibung im Checkout anzeigen');
define('CHECKOUT_SHOW_DESCRIPTION_DESC','<b>true</b> = Anzeige Kurzbeschreibung, <b>false</b> = Langbeschreibung');

define('CHECKOUT_SHOW_DESCRIPTION_LENG_TITLE','Wie viele Zeichen sollen angezeigt werden');
define('CHECKOUT_SHOW_DESCRIPTION_LENG_DESC','Nach wie vilenen Zeichen soll die Beschreibung abgeschnitten werden.');

define('EMAIL_SQL_ERRORS_TITLE','E-Mail bei SQL Fehlern');
define('EMAIL_SQL_ERRORS_DESC','Soll eine E-Mail an den Shopbetreiber bei Datenbankfehlern gesendet werden?');

define('ETRACKER_ON_TITLE','eTracker');
define('ETRACKER_ON_DESC','eTracker Funktion.');

define('DISPLAY_TAX_TITLE','Anzeige MwSt.');
define('DISPLAY_TAX_DESC','Nur für Schweiz und Liechtenstein relevant.');

define('DISPLAY_MORE_CAT_DESC_TITLE','Kategoriebeschreibung bei leeren Kategorien');
define('DISPLAY_MORE_CAT_DESC_DESC','Anzeige Kategoriebeschreibung bei leeren Kategorien.');

define('PRODUCT_DETAILS_TAB_SHORT_DESCRIPTION_TITLE','Kurzbeschreibung in Produkten');
define('PRODUCT_DETAILS_TAB_SHORT_DESCRIPTION_DESC','Anzeige Kurzbeschreibung in den Produkt Details.');

define('PRODUCT_DETAILS_SPECIALS_COUNTER_TITLE','Sonderangebote als Ajax darstellen');
define('PRODUCT_DETAILS_SPECIALS_COUNTER_DESC','Anzeige der Counterfunktion für Sonderangebote in den Produkt Details.');

define('BESTSELLER_START_TITLE','Bestseller Modul Start');
define('BESTSELLER_START_DESC','Anzeige der Bestseller auf der Startseite im Mittelbereich.');
