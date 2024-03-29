<?php
/*-----------------------------------------------------------------
* 	$Id: english.php 452 2013-07-03 12:42:36Z akausch $
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
// on RedHat6.0 I used 'en_US'
// on FreeBSD 4.0 I use 'en_US.ISO_8859-1'
// this may not work under win32 environments..

setlocale(LC_TIME, 'en_US@euro', 'en_US', 'en-US', 'en', 'en_US.ISO_8859-1', 'English','en_US.ISO_8859-15');
define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y');  // this is used for strftime()
define('PHP_DATE_TIME_FORMAT', 'm/d/Y H:i:s'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function xtc_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
  }
}

// Global entries for the <html> tag
define('HTML_PARAMS','dir="ltr" lang="en"');


// page title
define('TITLE', 'commerce:SEO');

// header text in includes/header.php
define('HEADER_TITLE_TOP', 'Administration');
define('HEADER_TITLE_SUPPORT_SITE', 'Support Site');
define('HEADER_TITLE_ONLINE_CATALOG', 'Online Catalog');
define('HEADER_TITLE_ADMINISTRATION', 'Administration');


define('HEADER_TITLE_ORDERS', 'Orders');
define('HEADER_TITLE_CUTOMERS', 'Customers');
define('HEADER_TITLE_CATEGORIES', 'Categories/Products');
define('HEADER_TITLE_STATISTICS', 'Statistics');

// text for gender
define('MALE', 'Male');
define('FEMALE', 'Female');

// text for date of birth example
define('DOB_FORMAT_STRING', 'mm/dd/yyyy');

// configuration box text in includes/boxes/configuration.php

define('BOX_HEADING_CONFIGURATION','Configuration');
define('BOX_HEADING_MODULES','Modules');
define('BOX_HEADING_ZONE','Zone / Tax');
define('BOX_HEADING_CUSTOMERS','Customers');
define('BOX_HEADING_PRODUCTS','Catalog');
define('BOX_HEADING_STATISTICS','Statistics');
define('BOX_HEADING_TOOLS','Tools');
define('BOX_HEADING_CSEO_CONFIG','cSEO Config');
define('BOX_HEADING_CSEO_TOOLS','cSEO Tools');
define('BOX_MODULE_NOVALNET', 'Novalnet AG - Admin');

define('BOX_CONTENT','Content Manager');
define('TEXT_ALLOWED', 'Permission');
define('TEXT_ACCESS', 'Usable Area');
define('BOX_CONFIGURATION', 'General Options');
define('BOX_CONFIGURATION_1', 'My Shop');
define('BOX_CONFIGURATION_2', 'Minimum Values');
define('BOX_CONFIGURATION_3', 'Maximum Values');
define('BOX_CONFIGURATION_4', 'Image Options');
define('BOX_CONFIGURATION_5', 'Customer Details');
define('BOX_CONFIGURATION_6', 'Module Options');
define('BOX_CONFIGURATION_7', 'Shipping Options');
define('BOX_CONFIGURATION_8', 'Product Listing Options');
define('BOX_CONFIGURATION_9', 'Stock Options');
define('BOX_CONFIGURATION_10', 'Logging Options');
define('BOX_CONFIGURATION_11', 'Cache Options');
define('BOX_CONFIGURATION_12', 'eMail Options');
define('BOX_CONFIGURATION_13', 'Download Options');
define('BOX_CONFIGURATION_14', 'Gzip Compression');
define('BOX_CONFIGURATION_15', 'Sessions');
define('BOX_CONFIGURATION_16', 'Meta-Tags/Searchengines');
define('BOX_CONFIGURATION_17', 'Specialmodules');
define('BOX_CONFIGURATION_19', 'xt:C Partner');
define('BOX_CONFIGURATION_22', 'Search-Options');
define('BOX_CONFIGURATION_25', 'PayPal Express');
define('BOX_CONFIGURATION_333', 'Checkout process');
define('BOX_CONFIGURATION_360', 'Mail attachments');
define('BOX_CONFIGURATION_361','Google Analytics');
define('BOX_CONFIGURATION_363','Safe-Login');
define('BOX_CONFIGURATION_365','PHPIDS-Sicherheit');

define('BOX_MODULES', 'Payment-/Shipping-/Billing-Modules');
define('BOX_PAYMENT', 'Payment Systems');
define('BOX_SHIPPING', 'Shipping Methods');
define('BOX_ORDER_TOTAL', 'Order Total');
define('BOX_CATEGORIES', 'Categories / Products');
define('BOX_PRODUCTS_ATTRIBUTES', 'Product Options');
define('BOX_MANUFACTURERS', 'Manufacturers');
define('BOX_REVIEWS', 'Product Reviews');
define('BOX_CAMPAIGNS', 'Campaigns');
define('BOX_XSELL_PRODUCTS', 'Cross Marketing');
define('BOX_SPECIALS', 'Special Pricing');
define('BOX_PRODUCTS_EXPECTED', 'Expected Offers');
define('BOX_CUSTOMERS', 'Customers');
define('BOX_ACCOUNTING', 'Admin Permissions');
define('BOX_CUSTOMERS_STATUS','Customer Groups');
define('BOX_ORDERS', 'Orders');
define('BOX_COUNTRIES', 'Countries');
define('BOX_ZONES', 'Zones');
define('BOX_GEO_ZONES', 'Tax Zones');
define('BOX_TAX_CLASSES', 'Tax Classes');
define('BOX_TAX_RATES', 'Tax Rates');
define('BOX_HEADING_REPORTS', 'Reports');
define('BOX_PRODUCTS_VIEWED', 'Viewed Products');
define('BOX_STOCK_WARNING','Stock Info');
define('BOX_PRODUCTS_PURCHASED', 'Sold Products');
define('BOX_STATS_CUSTOMERS', 'Purchasing Statistics');
define('BOX_BACKUP', 'Database Manager');
define('BOX_BANNER_MANAGER', 'Banner Manager');
define('BOX_CACHE', 'Cache Control');
define('BOX_DEFINE_LANGUAGE', 'Language Definitions');
define('BOX_FILE_MANAGER', 'File-Manager');
define('BOX_MAIL', 'eMail Center');
define('BOX_NEWSLETTERS', 'Notification Manager');
define('BOX_SERVER_INFO', 'Server Info');
define('BOX_WHOS_ONLINE', 'Who is Online');
define('BOX_TPL_BOXES','Boxes Sort Order');
define('BOX_CURRENCIES', 'Currencies');
define('BOX_LANGUAGES', 'Languages');
define('BOX_ORDERS_STATUS', 'Order Status');
define('BOX_ATTRIBUTES_MANAGER','Attribute Manager');
define('BOX_PRODUCTS_ATTRIBUTES','Option-Groups');
define('BOX_MODULE_NEWSLETTER','Newsletter');
define('BOX_SHIPPING_STATUS','Shipping status');
define('BOX_SALES_REPORT','Sales Report');
define('BOX_MODULE_EXPORT','cSEO-Modules');
define('BOX_STATS_KEYWORDS_ALL', 'Keywords Statistics');
define('BOX_HEADING_GV_ADMIN', 'Vouchers/Coupons');
define('BOX_GV_ADMIN_QUEUE', 'Gift Voucher Queue');
define('BOX_GV_ADMIN_MAIL', 'Mail Gift Voucher');
define('BOX_GV_ADMIN_SENT', 'Gift Vouchers sent');
define('BOX_COUPON_ADMIN','Coupon Admin');
define('BOX_TOOLS_BLACKLIST','-CC-Blacklist');
define('BOX_IMPORT','Import/Export');
define('BOX_PRODUCTS_VPE','Packing unit');
define('BOX_CAMPAIGNS_REPORT','Campaign report');
define('BOX_ORDERS_XSELL_GROUP','Cross-sell groups');
define('BOX_GOOGLE_SITEMAP', 'Google Sitemap');

define('TXT_GROUPS','<b>Groups</b>:');
define('TXT_SYSTEM','System');
define('TXT_CUSTOMERS','Customers/Orders');
define('TXT_PRODUCTS','Products/Categories');
define('TXT_STATISTICS','Statistics');
define('TXT_TOOLS','Tools');
define('TEXT_ACCOUNTING','Admin-access for:');

//Dividers text for menu

define('BOX_HEADING_MODULES', 'Modules');
define('BOX_HEADING_LOCALIZATION', 'Languages/Currencies');
define('BOX_HEADING_TEMPLATES','Templates');
define('BOX_HEADING_TOOLS', 'Tools');
define('BOX_HEADING_LOCATION_AND_TAXES', 'Location / Tax');
define('BOX_HEADING_CUSTOMERS', 'Customers');
define('BOX_HEADING_CATALOG', 'Catalog');
define('BOX_MODULE_NEWSLETTER','Newsletter');

// javascript messages
define('JS_ERROR', 'Error have occured during the process of your form!\nPlease make the following corrections:\n\n');

define('JS_OPTIONS_VALUE_PRICE', '* The new product attribute needs a price value\n');
define('JS_OPTIONS_VALUE_PRICE_PREFIX', '* The new product attribute needs a price prefix (+/-)\n');

define('JS_PRODUCTS_NAME', '* The new product needs a name\n');
define('JS_PRODUCTS_DESCRIPTION', '* The new product needs a description\n');
define('JS_PRODUCTS_PRICE', '* The new product needs a price value\n');
define('JS_PRODUCTS_WEIGHT', '* The new product needs a weight value\n');
define('JS_PRODUCTS_QUANTITY', '* The new product needs a quantity value\n');
define('JS_PRODUCTS_MODEL', '* The new product needs a model value\n');
define('JS_PRODUCTS_IMAGE', '* The new product needs an image value\n');

define('JS_SPECIALS_PRODUCTS_PRICE', '* A new price for this product needs to be set\n');

define('JS_GENDER', '* The \'Gender\' value must be chosen.\n');
define('JS_FIRST_NAME', '* The \'First Name\' entry must have at least ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' characters.\n');
define('JS_LAST_NAME', '* The \'Last Name\' entry must have at least ' . ENTRY_LAST_NAME_MIN_LENGTH . ' characters.\n');
define('JS_DOB', '* The \'Date of Birth\' entry must be in the format: xx/xx/xxxx (month/date/year).\n');
define('JS_EMAIL_ADDRESS', '* The \'eMail-Adress\' entry must have at least ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' characters.\n');
define('JS_ADDRESS', '* The \'Street Adress\' entry must have at least ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' characters.\n');
define('JS_POST_CODE', '* The \'Post Code\' entry must have at least ' . ENTRY_POSTCODE_MIN_LENGTH . ' characters.\n');
define('JS_CITY', '* The \'City\' entry must have at least ' . ENTRY_CITY_MIN_LENGTH . ' characters.\n');
define('JS_STATE', '* The \'State\' entry must be selected.\n');
define('JS_STATE_SELECT', '-- Select above --');
define('JS_ZONE', '* The \'State\' entry must be selected from the list for this country.');
define('JS_COUNTRY', '* The \'Country\' value must be chosen.\n');
define('JS_TELEPHONE', '* The \'Telephone Number\' entry must have at least ' . ENTRY_TELEPHONE_MIN_LENGTH . ' characters.\n');
define('JS_PASSWORD', '* The \'Password\' and \'Confirmation\' entries must match and have at least ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.\n');

define('JS_ORDER_DOES_NOT_EXIST', 'Order Number %s does not exist!');

define('CATEGORY_PERSONAL', 'Personal');
define('CATEGORY_ADDRESS', 'Adress');
define('CATEGORY_CONTACT', 'Contact');
define('CATEGORY_COMPANY', 'Company');
define('CATEGORY_OPTIONS', 'More Options');

define('ENTRY_GENDER', 'Gender:');
define('ENTRY_GENDER_ERROR', '&nbsp;<span class="errorText">required</span>');
define('ENTRY_FIRST_NAME', 'First Name:');
define('ENTRY_FIRST_NAME_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' chars</span>');
define('ENTRY_LAST_NAME', 'Last Name:');
define('ENTRY_LAST_NAME_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_LAST_NAME_MIN_LENGTH . ' chars</span>');
define('ENTRY_DATE_OF_BIRTH', 'Date of Birth:');
define('ENTRY_DATE_OF_BIRTH_ERROR', '&nbsp;<span class="errorText">(e.g. 05/21/1970)</span>');
define('ENTRY_EMAIL_ADDRESS', 'eMail Adress:');
define('ENTRY_EMAIL_ADDRESS_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' chars</span>');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', '&nbsp;<span class="errorText">Invalid eMail-Adress!</span>');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', '&nbsp;<span class="errorText">This eMail-Adress already exists!</span>');
define('ENTRY_COMPANY', 'Company name:');
define('ENTRY_STREET_ADDRESS', 'Street Adress:');
define('ENTRY_STREET_ADDRESS_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Chars</span>');
define('ENTRY_SUBURB', 'Suburb:');
define('ENTRY_POST_CODE', 'Post Code:');
define('ENTRY_POST_CODE_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_POSTCODE_MIN_LENGTH . ' chars</span>');
define('ENTRY_CITY', 'City:');
define('ENTRY_CITY_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_CITY_MIN_LENGTH . ' chars</span>');
define('ENTRY_STATE', 'State:');
define('ENTRY_STATE_ERROR', '&nbsp;<span class="errorText">required</font></small>');
define('ENTRY_COUNTRY', 'County:');
define('ENTRY_TELEPHONE_NUMBER', 'Telephone Number:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', '&nbsp;<span class="errorText">min. ' . ENTRY_TELEPHONE_MIN_LENGTH . ' chars</span>');
define('ENTRY_FAX_NUMBER', 'Fax Number:');
define('ENTRY_NEWSLETTER', 'Newsletter:');
define('ENTRY_CUSTOMERS_STATUS', 'Customers status:');
define('ENTRY_NEWSLETTER_YES', 'Subscribed');
define('ENTRY_NEWSLETTER_NO', 'Unsubscribed');
define('ENTRY_MAIL_ERROR','&nbsp;<span class="errorText">Please choose an option</span>');
define('ENTRY_PASSWORD','Password (generated)');
define('ENTRY_PASSWORD_ERROR','&nbsp;<span class="errorText">min. ' . ENTRY_PASSWORD_MIN_LENGTH . ' chars</span>');
define('ENTRY_MAIL_COMMENTS','additional eMailtext:');

define('ENTRY_MAIL','Send eMail with password to customer?');
define('YES','yes');
define('NO','no');
define('SAVE_ENTRY','Save changes?');
define('TEXT_CHOOSE_INFO_TEMPLATE','Template for product details');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE','Template for product options');
define('TEXT_SELECT','-- Please Select --');

// Icons
define('ICON_CROSS', 'False');
define('ICON_CURRENT_FOLDER', 'Current Folder');
define('ICON_DELETE', 'Delete');
define('ICON_ERROR', 'Error');
define('ICON_FILE', 'File');
define('ICON_FILE_DOWNLOAD', 'Download');
define('ICON_FOLDER', 'Folder');
define('ICON_LOCKED', 'Locked');
define('ICON_PREVIOUS_LEVEL', 'Previous Level');
define('ICON_PREVIEW', 'Preview');
define('ICON_STATISTICS', 'Statistics');
define('ICON_SUCCESS', 'Success');
define('ICON_TICK', 'True');
define('ICON_UNLOCKED', 'Unlocked');
define('ICON_WARNING', 'Warning');
define('IMAGE_ICON_STATUS_GREEN_STOCK',' Product on Stock');
define('IMAGE_ICON_STATUS_GREEN_STATUS','Produkt ist aktiv');
define('IMAGE_ICON_STATUS_GREEN_LIGHT_STATUS','Produkt aktivieren');
define('IMAGE_ICON_STATUS_RED_STATUS','Produkt ist inaktiv');
define('IMAGE_ICON_STATUS_RED_LIGHT_STATUS','Produkt deaktivieren');
define('IMAGE_ICON_STATUS_GREEN_TOP','Produkt wird auf der Startseite angezeigt');
define('IMAGE_ICON_STATUS_GREEN_LIGHT_TOP','Produkt auf Startseite anzeigen');
define('IMAGE_ICON_STATUS_RED_TOP','Produkt wird nicht auf der Startseite angezeigt');
define('IMAGE_ICON_STATUS_RED_LIGHT_TOP','Produkt von der Startseite nehmen');
define('IMAGE_ICON_EDIT_PRODUCT','Produkt direkt bearbeiten');
define('IMAGE_ICON_EDIT','edit element directly');
define('IMAGE_ICON_EDIT_CATEGORY','Kategorie direkt bearbeiten');
define('IMAGE_ICON_ORDER_EDIT','Bestellung direkt bearbeiten');
define('IMAGE_ICON_ARROW',' dieses Produkt ist f&uuml;r die Bearbeitung ausgew&auml;hlt');
define('IMAGE_ICON_INFO','F&uuml;r die Bearbeitung ausw&auml;hlen');
define('IMAGE_ICON_DOWN','absteigend sortieren');
define('IMAGE_ICON_UP','aufsteigend sortieren');

define('HEADING_TITLE_ORDER', 'Order-Nr.');
define('HEADING_TITLE_PRODUKT','Product');
define('HEADING_TITLE_KUNDE','Customer');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Page %s of %d');
define('TEXT_DISPLAY_NUMBER_OF_BANNERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Banners)');
define('TEXT_DISPLAY_NUMBER_OF_COUNTRIES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Countries)');
define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Customers)');
define('TEXT_DISPLAY_NUMBER_OF_CURRENCIES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Currencies)');
define('TEXT_DISPLAY_NUMBER_OF_LANGUAGES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Languages)');
define('TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Manufacturers)');
define('TEXT_DISPLAY_NUMBER_OF_NEWSLETTERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Newsletters)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Orders)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS_STATUS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Orders Status)');
define('TEXT_DISPLAY_NUMBER_OF_XSELL_GROUP', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Cross-sell groups)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_VPE', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Packing Units)');
define('TEXT_DISPLAY_NUMBER_OF_SHIPPING_STATUS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Shippingstatus)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Products)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_EXPECTED', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> products expected)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Reviews)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> products on special)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_CLASSES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Tax Classes)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_ZONES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Tax Zones)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_RATES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> Tax Rates)');
define('TEXT_DISPLAY_NUMBER_OF_ZONES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> zones)');
define('TEXT_DISPLAY_NUMBER_OF_KEYWORDS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> keywords)');

define('PREVNEXT_BUTTON_PREV', '&lt;&lt;');
define('PREVNEXT_BUTTON_NEXT', '&gt;&gt;');

define('TEXT_DEFAULT', 'Default');
define('TEXT_SET_DEFAULT', 'Set as default');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* Required</span>');

define('ERROR_NO_DEFAULT_CURRENCY_DEFINED', 'Error: There is currently no default currency set. Please set one at: Administration Tool -> Localization -> Currencies');

define('TEXT_CACHE_CATEGORIES', 'Categories Box');
define('TEXT_CACHE_MANUFACTURERS', 'Manufacturers Box');
define('TEXT_CACHE_ALSO_PURCHASED', 'Also Purchased Module');

define('TEXT_NONE', '--none--');
define('TEXT_TOP', 'Top');

define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Error: Destination does not exist.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Error: Destination is not writeable.');
define('ERROR_FILE_NOT_SAVED', 'Error: File upload not saved.');
define('ERROR_FILETYPE_NOT_ALLOWED', 'Error: File upload type not allowed.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Success: File upload saved successfully.');
define('WARNING_NO_FILE_UPLOADED', 'Warnung: No file uploaded.');

define('DELETE_ENTRY','Delete entry?');
define('TEXT_PAYMENT_ERROR','<b>WARNING:</b><br />Please activate a Payment Module!');
define('TEXT_SHIPPING_ERROR','<b>WARNING:</b><br />Please activate a Shipping Module!');

define('TEXT_NETTO','no tax: ');

define('ENTRY_CID','Customers ID:');
define('IP','Order IP:');
define('CUSTOMERS_MEMO','Memos:');
define('DISPLAY_MEMOS','Show/Write');
define('TITLE_MEMO','Customers MEMO');
define('ENTRY_LANGUAGE','Language:');
define('CATEGORIE_NOT_FOUND','Categorie not found!');

define('IMAGE_RELEASE', 'Redeem Gift Voucher');

define('_JANUARY', 'January');
define('_FEBRUARY', 'February');
define('_MARCH', 'March');
define('_APRIL', 'April');
define('_MAY', 'May');
define('_JUNE', 'June');
define('_JULY', 'July');
define('_AUGUST', 'August');
define('_SEPTEMBER', 'September');
define('_OCTOBER', 'October');
define('_NOVEMBER', 'November');
define('_DECEMBER', 'December');

define('TEXT_DISPLAY_NUMBER_OF_GIFT_VOUCHERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> gift vouchers)');
define('TEXT_DISPLAY_NUMBER_OF_COUPONS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> coupons)');

define('TEXT_VALID_PRODUCTS_LIST', 'Products List');
define('TEXT_VALID_PRODUCTS_ID', 'Products ID');
define('TEXT_VALID_PRODUCTS_NAME', 'Products Name');
define('TEXT_VALID_PRODUCTS_MODEL', 'Products Model');

define('TEXT_VALID_CATEGORIES_LIST', 'Categories List');
define('TEXT_VALID_CATEGORIES_ID', 'Category ID');
define('TEXT_VALID_CATEGORIES_NAME', 'Category Name');

define('SECURITY_CODE_LENGTH_TITLE', 'Length of Gift Voucher Code');
define('SECURITY_CODE_LENGTH_DESC', 'Enter here the length of the Gift Voucher Code (max. 16 characters)');

define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_TITLE', 'Welcome Gift Voucher Amount');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_DESC', 'Welcome Gift Voucher Amount: If you do not wish to send a Gift Voucher in your create account eMail, put 0 for no amount, else place the amount here, i.e. 10.00 or 50.00, no currency signs');
define('NEW_SIGNUP_DISCOUNT_COUPON_TITLE', 'Welcome Discount Coupon Code');
define('NEW_SIGNUP_DISCOUNT_COUPON_DESC', 'Welcome Discount Coupon Code: if you do not want to send a Discount Coupon in your create account eMail ,leave this field blank, else place the coupon code here you wish to use');

define('TXT_ALL','All');

// UST ID
define('BOX_CONFIGURATION_18', 'Vat ID');
define('HEADING_TITLE_VAT','Vat-ID');
define('HEADING_TITLE_VAT','Vat-ID');
define('ENTRY_VAT_ID','Vat-ID');
define('TEXT_VAT_FALSE','<font color="FF0000">Checked/False!</font>');
define('TEXT_VAT_TRUE','<font color="FF0000">Checked/True!</font>');
define('TEXT_VAT_UNKNOWN_COUNTRY','<font color="FF0000">Not Checked/Unknown Country!</font>');
define('TEXT_VAT_UNKNOWN_ALGORITHM','<font color="FF0000">Not Checked/No Check available!</font>');
define('ENTRY_VAT_ID_ERROR', '<font color="FF0000">* Your Vat ID is False!</font>');

define('ERROR_GIF_MERGE','Missing GDlib Gif-Support, merge failed');
define('ERROR_GIF_UPLOAD','Missing GDlib Gif-Support, processing of Gif image failed');

define('TEXT_REFERER','Referer: ');

define('BOX_PAYPAL','PayPal');
define('BOX_CUSTOMERS_SIK','Deleted customers');


/*AJAX Graduated prices*/
define('STAFFEL_GROUP_BASE_PRICE','Base Price:');
define('STAFFEL_QUANTITY','Quantity:');
define('STAFFEL_NETTO','net');
define('STAFFEL_BRUTTO','gross');
define('STAFFEL_PRICE','Price:');
define('STAFFEL_SAVE','Save');
define('STAFFEL_EDIT','Edit');
define('STAFFEL_CANCEL','Cancel');
define('STAFFEL_NEW','New');
define('STAFFEL_DELETE','Delete');
define('STAFFEL_ADD','Add');
define('STAFFEL_TITLE','Graduated prices');
define('STAFFEL_ERROR_MESSAGE_1','You must begin a fundamental value and <br /> save before you enter Season Price!');
define('STAFFEL_ERROR_MESSAGE_2','successfully saved!');
define('STAFFEL_ERROR_MESSAGE_3','Entry already exists!');
define('STAFFEL_ERROR_MESSAGE_4','At least one field is left blank!');
define('STAFFEL_ERROR_MESSAGE_5','Graduated price not available!');
define('STAFFEL_ERROR_MESSAGE_6','Graduated price deleted successfully!');
define('STAFFEL_ERROR_MESSAGE_7','Graduated price not available!');
define('STAFFEL_ERROR_MESSAGE_8','Successfully amended!');
define('STAFFEL_ERROR_MESSAGE_9_0','<br />The profile ');
define('STAFFEL_ERROR_MESSAGE_9_1',' has been successfully saved!');
define('STAFFEL_ERROR_MESSAGE_10_0','<br />The chosen profile name ');
define('STAFFEL_ERROR_MESSAGE_10_1',' unfortunately already exists. <br /> Please choose a different name!');
define('STAFFEL_ERROR_MESSAGE_11','Please select a profile!');
define('STAFFEL_ERROR_MESSAGE_12_0','<br />The profile name has been successfully ');
define('STAFFEL_ERROR_MESSAGE_12_1',' changed!');
define('STAFFEL_ERROR_MESSAGE_13','<br />The scaled prices have been successfully transferred!');
define('STAFFEL_ERROR_MESSAGE_14','The following season prices are entered after confirmation. <span style="color: #FF0000">Note: All prices Squadron this customer group will be overwritten!</span>');
define('STAFFEL_ERROR_MESSAGE_15','<br />Would you like to Season Rates assume? ');
define('STAFFEL_ERROR_MESSAGE_16','<br />The profile has been successfully deleted!');
define('PROFILE_WILL_LOAD','The selected profile will be loaded.');
define('PROFILE_WILL_SAVE','The displayed prices are squadron as a new profile.');
define('PROFILE_WILL_RENAME','The selected profile will be renamed.');
define('PROFILE_WILL_DELETE','The selected profile is deleted.');
define('PROFILE_SELECT','Please select a profile!');
define('PROFILE_CONFIRM','Apply');
define('PROFILE_NAME','<span style="color: #FF0000">Please enter a name for the saved profile!</span> ');
define('PROFILE_NEW_NAME','<span class="clear" style="color: #FF0000">Please enter a new name for the saved profile:</span> ');
/*AJAX Staffelpreise*/

define('BOX_CONFIGURATION_33', 'Open Baskets');
define('BOX_REPORTS_RECOVER_CART_SALES', 'Recovered Baskets');
define('BOX_TOOLS_RECOVER_CART', 'Open Baskets');
define('TAX_ADD_TAX','incl. ');
define('TAX_NO_TAX','plus ');
define('BOX_BACKLINK','Backlinkcheck');
define('BOX_HEADING_XSBOOSTER','xs:booster');	
define('BOX_XSBOOSTER_LISTAUCTIONS','List Auctions');
define('BOX_XSBOOSTER_ADDAUCTIONS','Add Auctions');
define('BOX_XSBOOSTER_CONFIG','Base Configuration');
define('BOX_PDFBILL_CONFIG', 'PDF-Bill config.');                 // pdfrechnung

// moneybookers.com module (2.4)
define('_PAYMENT_MONEYBOOKERS_EMAILID_TITLE','Moneybookers E-Mail Adresse');
define('_PAYMENT_MONEYBOOKERS_EMAILID_DESC','E-Mail Adresse mitwelcher Sie bei Moneybookers.com registriert sind.<br />Wenn Sie noch &uuml;ber kein Konto verf&uuml;gen, <b>melden Sie sich</b> jetzt bei <a href="https://www.moneybookers.com/app/register.pl" target="_blank"><b>Moneybookers</b></a> <b>gratis</b> an.');
define('_PAYMENT_MONEYBOOKERS_MERCHANTID_TITLE','Moneybookers H&auml;ndler ID');
define('_PAYMENT_MONEYBOOKERS_MERCHANTID_DESC','Ihre Moneybookers.com H&auml;ndler ID');
define('_PAYMENT_MONEYBOOKERS_PWD_TITLE','Moneybookers Geheimwort');
define('_PAYMENT_MONEYBOOKERS_PWD_DESC','Mit der Eingabe des Geheimwortes wird die Verbindung beim Bezahlvorgang verschl&uuml;sselt. So wird h&ouml;chste Sicherheit gew&auml;hrleistet. Geben Sie Ihr Moneybookers Geheimwort ein (dies ist nicht ihr Passwort!). Das Geheimwort darf nur aus Kleinbuchstaben und Zahlen bestehen. Sie k&ouml;nnen Ihr Geheimwort <b><font color="red">nach der Freischaltung</b></font> in Ihrem Moneybookers-Benutzerkonto definieren. (H&auml;ndlereinstellungen).<br /><br />
<font color="red">So schalten Sie Ihren Moneybookers.com Account f&uuml;er die xt:Commerce Zahlungsabwicklung frei!</font><br /><br />

Senden Sie eine E-Mail mit:<br/>
- Ihrer Shopdomain<br/>
- Ihrer Moneybookers E-Mail-Adresse<br /><br />

An: <a href="mailto:ecommerce@moneybookers.com?subject=XTCOMMERCE: Aktivierung fuer Moneybookers Quick Checkout">ecommerce@moneybookers.com</a>

');
define('_PAYMENT_MONEYBOOKERS_TMP_STATUS_ID_TITLE','Bestellstatus - Zahlungsvorgang');
define('_PAYMENT_MONEYBOOKERS_TMP_STATUS_ID_DESC',' Sobald der Kunde im Shop auf "Bestellung absenden" dr&uuml;ckt, wird von xt:Commerce eine "Tempor&auml;re Bestellung" angelegt. Dies hat den Vorteil, dass bei Kunden die den Zahlungsvorgang bei Moneybookes abbrechen eine Bestellung aufgezeichnet wurde.');
define('_PAYMENT_MONEYBOOKERS_PROCESSED_STATUS_ID_TITLE','Bestellstatus - Zahlung OK');
define('_PAYMENT_MONEYBOOKERS_PROCESSED_STATUS_ID_DESC','Erscheint, wenn die Zahlung von Moneybookers best&auml;tigt wurde.');
define('_PAYMENT_MONEYBOOKERS_PENDING_STATUS_ID_TITLE','Bestellstatus - Zahlung in Warteschleife');
define('_PAYMENT_MONEYBOOKERS_PENDING_STATUS_ID_DESC','');
define('_PAYMENT_MONEYBOOKERS_CANCELED_STATUS_ID_TITLE','Bestellstatus - Zahlung Storniert');
define('_PAYMENT_MONEYBOOKERS_CANCELED_STATUS_ID_DESC','Wird erscheinen, wenn z.B. eine Kreditkarte abgelehnt wurde');
define('MB_TEXT_MBDATE', 'Letzte Aktualisierung:');
define('MB_TEXT_MBTID', 'TR ID:');
define('MB_TEXT_MBERRTXT', 'Status:');
define('MB_ERROR_NO_MERCHANT','Es Existiert kein Moneybookers.com Account mit dieser E-Mail Adresse!');
define('MB_MERCHANT_OK','Moneybookers.com Account korrekt, H&auml;ndler ID %s von Moneybookers.com empfangen und gespeichert.');

define('MB_INFO','<img src="../images/icons/moneybookers/MBbanner.jpg" /><br /><br />xt:Commerce-Kunden k&ouml;nnen jetzt Kreditkarten, Lastschrift, Sofort&uuml;berweisung, Giropay sowie alle weiteren wichtigen lokalen Bezahloptionen direkt akzeptieren mit einer simplen Aktivierung im Shop. Mit Moneybookers als All-in-One-L&ouml;sung brauchen Sie dabei keine Einzelvertr&auml;ge pro Zahlart abzuschliesen. Sie brauchen lediglich einen <a href="https://www.moneybookers.com/app/register.pl" target="_blank"><b>kostenlosen Moneybookers Account</b></a> um alle wichtigen Bezahloptionen in Ihrem Shop zu akzeptieren. Zus&auml;tzliche Bezahlarten sind ohne Mehrkosten und das Modul beinhaltet <b>keine monatliche Fixkosten oder Installationskosten</b>.
<br /><br />
<b>Ihre Vorteile:</b><br />
-Die Akzeptanz der wichtigsten Bezahloptionen steigern Ihren Umsatz<br />
-Ein Anbieter reduziert Ihre Aufw&auml;nde und Ihre Kosten<br />
-Ihr Kunde bezahlt direkt und ohne Registrierungsprozedur<br />
-Ein-Klick-Aktivierung und Integration<br />
-Sehr attraktive <a href="http://www.moneybookers.com/app/help.pl?s=m_fees" target="_blank"><b>Konditionen</b></a> <br />
-sofortige Zahlungsbest&auml;tigung und Pr&uuml;fung der Kundendaten<br />
-Bezahlabwicklung auch im Ausland und ohne Mehrkosten<br />
-6 Millionen Kunden weltweit vertrauen Moneybookers');

define('FILENAME_BILL', 'Bill');
define('FILENAME_PACKINSLIP', 'Delivery');
define('TEXT_PDF_SEITE', 'Site');
define('TEXT_PDF_SEITE_VON', 'from');
define('TEXT_PDF_KUNDENNUMMER', 'Customer-Nr.');
define('TEXT_PDF_RECHNUNGSNUMMER', 'Bill-Nr.');
define('TEXT_PDF_LIEFERNUMMER', 'Delivery');
define('TEXT_PDF_BESTELLNUMMER', 'Order-nr.');
define('TEXT_PDF_DATUM', 'Date');
define('TEXT_PDF_ZAHLUNGSWEISE', 'Payment');
define('TEXT_PDF_RECHNUNG', 'Bill');
define('TEXT_PDF_LIEFERSCHEIN', 'Delivery');
define('TEXT_PDF_MENGE', 'Qty.');
define('TEXT_PDF_ARTIKEL', 'Item');
define('TEXT_PDF_ARTIKELNR', 'Item-Nr.');
define('TEXT_PDF_EINZELPREIS', 'Single price');
define('TEXT_PDF_PREIS', 'Total price');
define('TEXT_PDF_KOMMENTAR', 'Comments');
define('TEXT_PDF_LIFERADRESSE', 'Delivery: ');

define('BOX_PRODUCT_FILTER', 'Product Filter');
define('BOX_MODULE_ORDER_PRODUCTS','Ordering-articles');
define('BOX_MODULE_NEWSLETTER_PRODUCTS','Newsletter-articles');
define('BOX_MODULE_NEWSLETTER','Newsletter');
define('BOX_MODULE_BLOG','Blog');
define('BOX_MODULE_DEL_CACHE','Clear Cache Folder');
define('BOX_CONFIGURATION_CSEO','v2 general');
define('BOX_CONFIGURATION_CSS_STYLER','CSS-Buttons');
define('BOX_CONFIGURATION_PDF_CONF','PDF-WAWI');
define('BOX_CONFIGURATION_PRODUCT_LISTING','Product List');
define('BOX_CONFIGURATION_BOX_MANAGER','Box Manager');
define('BOX_CONFIGURATION_NEWS_TICKER','News Ticker');
define('BOX_CONFIGURATION_TRUSTED_SHOPS','Trusted Shops');
define('BOX_CONFIGURATION_JANOLAW','Janolaw');
define('BOX_CONFIGURATION_PERSONAL_LINKS','Personal Links');
define('BOX_CONFIGURATION_EMAILS_TEMPLATE','Email templates');
define('BOX_PRODUCTS_PRICE_CHANGE','price change');
define('BOX_GLOBAL_PRODUCTS_PRICE_CHANGE','global price change');

define('BOX_CONFIGURATION_1000','CSEO Special');
define('BOX_CONFIGURATION_1001','Twitter Box');
define('BOX_CONFIGURATION_1002','Product-Config');
define('BOX_LOGINBOX_DISCOUNT','Discount');
define('SINGLE_PRICE','Singleprice ');
define('YOU_SAVE','you save ');
define('INSTEAD','old price ');
define('ONLY','now ');
define('ORDER_STATUS_STORNO_TITLE','Status number for cancellation accounts');
define('ORDER_STATUS_STORNO_DESC','What number will receive a cancellation invoice / credit default?<br />Do not forget to create such status. You can do <a href="'.DIR_WS_ADMIN.'orders_status.php?page=1&action=new">here</a>.');

define('STORNO_INCOICE', 'Cancellation fee');
