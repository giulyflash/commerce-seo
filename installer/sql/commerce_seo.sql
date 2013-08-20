DROP TABLE IF EXISTS address_book;
CREATE TABLE address_book (
address_book_id INT NOT NULL auto_increment,
customers_id INT NOT NULL,
entry_gender char(1) NOT NULL,
entry_company VARCHAR(32),
entry_firstname VARCHAR(32) NOT NULL,
entry_lastname VARCHAR(32) NOT NULL,
entry_street_address VARCHAR(64) NOT NULL,
entry_suburb VARCHAR(32),
entry_postcode VARCHAR(10) NOT NULL,
entry_city VARCHAR(32) NOT NULL,
entry_state VARCHAR(32),
entry_country_id INT DEFAULT '0' NOT NULL,
entry_zone_id INT DEFAULT '0' NOT NULL,
address_date_added datetime DEFAULT '0000-00-00 00:00:00',
address_last_modified datetime DEFAULT '0000-00-00 00:00:00',
address_class VARCHAR( 32 ) NOT NULL,
PRIMARY KEY (address_book_id),
KEY idx_address_book_customers_id (customers_id),
KEY entry_country_id (entry_country_id),
KEY entry_zone_id (entry_zone_id)
);

DROP TABLE IF EXISTS boxes;
CREATE TABLE boxes (
id INT(11) NOT NULL auto_increment,
box_name VARCHAR(32) NOT NULL,
position VARCHAR(16) NOT NULL,
sort_id INT(4) NOT NULL,
status INT(1) NOT NULL DEFAULT '1',
box_type VARCHAR(16) NOT NULL,
file_flag INT(2) NOT NULL,
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS boxes_names;
CREATE TABLE boxes_names (
id INT(11) NOT NULL auto_increment,
box_name VARCHAR(32) NOT NULL,
box_title VARCHAR(128) NOT NULL,
box_desc text NOT NULL,
language_id INT(2) NOT NULL,
status INT(1) NOT NULL DEFAULT '1',
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS boxes_positions;
CREATE TABLE boxes_positions (
id INT(11) NOT NULL auto_increment,
position_name VARCHAR(16) NOT NULL,
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS boxes_styles;
CREATE TABLE boxes_styles (
id INT(11) NOT NULL auto_increment,
box_name VARCHAR(32) NOT NULL,
border_color VARCHAR(6) NOT NULL,
background_content VARCHAR(32) NOT NULL,
color_content VARCHAR(6) NOT NULL,
background_head VARCHAR(32) NOT NULL,
color_head VARCHAR(6) NOT NULL,
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS customers_memo;
CREATE TABLE customers_memo (
memo_id INT(11) NOT NULL auto_increment,
customers_id INT(11) NOT NULL DEFAULT '0',
memo_date date NOT NULL DEFAULT '0000-00-00',
memo_title text NOT NULL,
memo_text text NOT NULL,
poster_id INT(11) NOT NULL DEFAULT '0',
PRIMARY KEY (memo_id)
);

DROP TABLE IF EXISTS products_xsell;
CREATE TABLE products_xsell (
ID INT(10) NOT NULL auto_increment,
products_id INT(10) NOT NULL DEFAULT '1',
products_xsell_grp_name_id INT(10) NOT NULL DEFAULT '1',
xsell_id INT(10) NOT NULL DEFAULT '1',
sort_order INT(10) NOT NULL DEFAULT '1',
PRIMARY KEY (ID),
KEY products_id (products_id),
KEY products_id_2 (products_xsell_grp_name_id,products_id)
);

DROP TABLE IF EXISTS products_xsell_grp_name;
CREATE TABLE products_xsell_grp_name (
products_xsell_grp_name_id INT(10) NOT NULL,
xsell_sort_order INT(10) NOT NULL DEFAULT '0',
language_id smallint(6) NOT NULL DEFAULT '0',
groupname VARCHAR(255) NOT NULL DEFAULT ''
);

DROP TABLE IF EXISTS campaigns;
CREATE TABLE campaigns (
campaigns_id INT(11) NOT NULL auto_increment,
campaigns_name VARCHAR(32) NOT NULL DEFAULT '',
campaigns_refID VARCHAR(64) DEFAULT NULL,
campaigns_leads INT(11) NOT NULL DEFAULT '0',
date_added datetime DEFAULT NULL,
last_modified datetime DEFAULT NULL,
PRIMARY KEY (campaigns_id),
KEY IDX_CAMPAIGNS_NAME (campaigns_name)
);

DROP TABLE IF EXISTS campaigns_ip;
CREATE TABLE campaigns_ip (
user_ip VARCHAR( 15 ) NOT NULL ,
time DATETIME NOT NULL ,
campaign VARCHAR( 32 ) NOT NULL
);

DROP TABLE IF EXISTS address_format;
CREATE TABLE address_format (
address_format_id INT NOT NULL auto_increment,
address_format VARCHAR(128) NOT NULL,
address_summary VARCHAR(48) NOT NULL,
PRIMARY KEY (address_format_id)
);

DROP TABLE IF EXISTS database_version;
CREATE TABLE database_version (
version VARCHAR(32) NOT NULL
);

DROP TABLE IF EXISTS admin_access;
CREATE TABLE admin_access (
customers_id VARCHAR(32) NOT NULL DEFAULT '0',
configuration INT(1) NOT NULL DEFAULT '0',
modules INT(1) NOT NULL DEFAULT '0',
countries INT(1) NOT NULL DEFAULT '0',
currencies INT(1) NOT NULL DEFAULT '0',
zones INT(1) NOT NULL DEFAULT '0',
geo_zones INT(1) NOT NULL DEFAULT '0',
tax_classes INT(1) NOT NULL DEFAULT '0',
tax_rates INT(1) NOT NULL DEFAULT '0',
accounting INT(1) NOT NULL DEFAULT '0',
backup INT(1) NOT NULL DEFAULT '0',
cache INT(1) NOT NULL DEFAULT '0',
server_info INT(1) NOT NULL DEFAULT '0',
whos_online INT(1) NOT NULL DEFAULT '0',
languages INT(1) NOT NULL DEFAULT '0',
define_language INT(1) NOT NULL DEFAULT '0',
orders_status INT(1) NOT NULL DEFAULT '0',
shipping_status INT(1) NOT NULL DEFAULT '0',
module_export INT(1) NOT NULL DEFAULT '0',
filemanager INT(1) NOT NULL DEFAULT '0',
database_manager INT(1) NOT NULL DEFAULT '0',
customers INT(1) NOT NULL DEFAULT '0',
create_account INT(1) NOT NULL DEFAULT '0',
customers_status INT(1) NOT NULL DEFAULT '0',
orders INT(1) NOT NULL DEFAULT '0',
campaigns INT(1) NOT NULL DEFAULT '0',
print_packingslip INT(1) NOT NULL DEFAULT '0',
print_order INT(1) NOT NULL DEFAULT '0',
popup_memo INT(1) NOT NULL DEFAULT '0',
coupon_admin INT(1) NOT NULL DEFAULT '0',
listcategories INT(1) NOT NULL DEFAULT '0',
listproducts INT(1) NOT NULL DEFAULT '0',
gv_queue INT(1) NOT NULL DEFAULT '0',
gv_mail INT(1) NOT NULL DEFAULT '0',
gv_sent INT(1) NOT NULL DEFAULT '0',
validproducts INT(1) NOT NULL DEFAULT '0',
validcategories INT(1) NOT NULL DEFAULT '0',
mail INT(1) NOT NULL DEFAULT '0',
emails INT(1) NOT NULL DEFAULT '0',
categories INT(1) NOT NULL DEFAULT '0',
new_attributes INT(1) NOT NULL DEFAULT '0',
janolaw INT(1) NOT NULL DEFAULT '0',
delete_cache INT(1) NOT NULL DEFAULT '0',
products_attributes INT(1) NOT NULL DEFAULT '0',
price_change INT(1) NOT NULL DEFAULT '0',
manufacturers INT(1) NOT NULL DEFAULT '0',
reviews INT(1) NOT NULL DEFAULT '0',
specials INT(1) NOT NULL DEFAULT '0',
stats_products_expected INT(1) NOT NULL DEFAULT '0',
stats_products_viewed INT(1) NOT NULL DEFAULT '0',
stats_products_purchased INT(1) NOT NULL DEFAULT '0',
stats_customers INT(1) NOT NULL DEFAULT '0',
stats_sales_report INT(1) NOT NULL DEFAULT '0',
stats_stock_warning INT(1) NOT NULL DEFAULT '0',
stats_stock_warning_print INT(1) NOT NULL DEFAULT '0',
stats_campaigns INT(1) NOT NULL DEFAULT '0',
stats_keywords_all INT(1) NOT NULL DEFAULT '0',
stats_keywords_all_print INT(1) NOT NULL DEFAULT '0',
banner_manager INT(1) NOT NULL DEFAULT '0',
banner_statistics INT(1) NOT NULL DEFAULT '0',
module_newsletter INT(1) NOT NULL DEFAULT '0',
start INT(1) NOT NULL DEFAULT '0',
box_manager INT(1) NOT NULL DEFAULT '0',
content_manager INT(1) NOT NULL DEFAULT '0',
content_preview INT(1) NOT NULL DEFAULT '0',
credits INT(1) NOT NULL DEFAULT '0',
blacklist INT(1) NOT NULL DEFAULT '0',
news_ticker INT(1) NOT NULL DEFAULT '0',
orders_edit INT(1) NOT NULL DEFAULT '0',
popup_image INT(1) NOT NULL DEFAULT '0',
csv_backend INT(1) NOT NULL DEFAULT '0',
products_vpe INT(1) NOT NULL DEFAULT '0',
products_parameters INT(1) NOT NULL DEFAULT '0',
products_parameters_edit INT(1) NOT NULL DEFAULT '0',
cross_sell_groups INT(1) NOT NULL DEFAULT '0',
fck_wrapper INT(1) NOT NULL DEFAULT '0',
paypal INT( 1 ) NOT NULL DEFAULT '0',
customers_sik INT( 1 ) NOT NULL DEFAULT '0',
novalnet INT( 1 ) NOT NULL DEFAULT '0',
group_prices INT( 1 ) NOT NULL DEFAULT '0',
customers_aquise INT( 1 ) NOT NULL DEFAULT '0',
customers_aquise_request INT( 1 ) NOT NULL DEFAULT '0',
orders_overview INT( 1 ) NOT NULL DEFAULT '0',
orders_overview_print INT( 1 ) NOT NULL DEFAULT '0',
recover_cart_sales INT( 1 ) NOT NULL DEFAULT '0',
stats_recover_cart_sales INT( 1 ) NOT NULL DEFAULT '0',
module_newsletter_products INT( 1 ) NOT NULL DEFAULT '0',
close_cart_new_order INT( 1 ) NOT NULL DEFAULT '0',
product_listings INT( 1 ) NOT NULL DEFAULT '0',
css_styler INT( 1 ) NOT NULL DEFAULT '0',
slimstat INT( 1 ) NOT NULL DEFAULT '0',
orders_pdf_profiler INT(1) NOT NULL DEFAULT '0',
create_pdf INT(1) NOT NULL DEFAULT '0',
create_pdf_download INT(1) NOT NULL DEFAULT '0',
personal_links INT(1) NOT NULL DEFAULT '0',
blog INT(1) NOT NULL DEFAULT '0',
google_sitemap INT(1) NOT NULL DEFAULT '0',
product_filter INT(1) NOT NULL DEFAULT '0',
module_order_products INT(1) NOT NULL DEFAULT '0',
mobile INT(1) NOT NULL DEFAULT '0',
module_install INT(1) NOT NULL DEFAULT '0',
module_system INT(1) NOT NULL DEFAULT '0',
accessories INT(1) NOT NULL DEFAULT '0',
global_products_price INT(1) NOT NULL DEFAULT '0',
attribute_manager INT(1) NOT NULL DEFAULT '0',
products_expected INT(1) NOT NULL DEFAULT '0',
cseo_language_button INT(1) NOT NULL DEFAULT '0',
cseo_ids INT(1) NOT NULL DEFAULT '0',
cseo_antispam INT(1) NOT NULL DEFAULT '0',
recover_wish_list INT(1) NOT NULL DEFAULT '0',
removeoldpics INT(1) NOT NULL DEFAULT '0',
cseo_redirect INT(1) NOT NULL DEFAULT '0',
cseo_center_security INT(1) NOT NULL DEFAULT '0',
cseo_product_export INT(1) NOT NULL DEFAULT '0',
xajax_dispatcher INT(1) NOT NULL DEFAULT '0',
haendlerbund INT(1) NOT NULL DEFAULT '0',
cseo_imageprocessing INT(1) NOT NULL DEFAULT '0',
global_search INT(1) NOT NULL DEFAULT '0',
comments_orders INT(1) NOT NULL DEFAULT '0',
cseo_checkout_sort INT(1) NOT NULL DEFAULT '0',
cseo_main_sort INT(1) NOT NULL DEFAULT '0',
PRIMARY KEY (customers_id)
);

DROP TABLE IF EXISTS customers_sik;
CREATE TABLE customers_sik (
customers_id INT(11) NOT NULL auto_increment,
customers_cid VARCHAR(32) DEFAULT NULL,
customers_vat_id VARCHAR(20) DEFAULT NULL,
customers_vat_id_status INT(2) NOT NULL DEFAULT '0',
customers_warning VARCHAR(32) DEFAULT NULL,
customers_status INT(5) NOT NULL DEFAULT '1',
customers_gender char(1) NOT NULL,
customers_firstname VARCHAR(32) NOT NULL,
customers_lastname VARCHAR(32) NOT NULL,
customers_dob datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
customers_email_address VARCHAR(96) NOT NULL,
customers_DEFAULT_address_id INT(11) NOT NULL,
customers_telephone VARCHAR(32) NOT NULL,
customers_fax VARCHAR(32) DEFAULT NULL,
customers_password VARCHAR(50) NOT NULL,
customers_newsletter char(1) DEFAULT NULL,
customers_newsletter_mode char(1) NOT NULL DEFAULT '0',
member_flag char(1) NOT NULL DEFAULT '0',
delete_user char(1) NOT NULL DEFAULT '1',
account_type INT(1) NOT NULL DEFAULT '0',
password_request_key VARCHAR(32) NOT NULL,
payment_unallowed VARCHAR(255) NOT NULL,
shipping_unallowed VARCHAR(255) NOT NULL,
refferers_id INT(5) NOT NULL DEFAULT '0',
customers_date_added datetime DEFAULT '0000-00-00 00:00:00',
customers_last_modified datetime DEFAULT '0000-00-00 00:00:00',
datensg datetime DEFAULT NULL,
login_tries VARCHAR( 2 ) NOT NULL DEFAULT '0',
login_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (customers_id)
);

DROP TABLE IF EXISTS customers_wishlist;
CREATE TABLE customers_wishlist (
customers_basket_id INT(11) NOT NULL auto_increment,
customers_id INT(11) NOT NULL DEFAULT '0',
products_id tinytext NOT NULL,
customers_basket_quantity INT(2) NOT NULL DEFAULT '0',
final_price decimal(15,4) NOT NULL DEFAULT '0.0000',
customers_basket_date_added VARCHAR(8) DEFAULT NULL,
PRIMARY KEY (customers_basket_id)
);

DROP TABLE IF EXISTS customers_wishlist_attributes;
CREATE TABLE customers_wishlist_attributes (
customers_basket_attributes_id INT(11) NOT NULL auto_increment,
customers_id INT(11) NOT NULL DEFAULT '0',
products_id tinytext NOT NULL,
products_options_id INT(11) NOT NULL DEFAULT '0',
products_options_value_id INT(11) NOT NULL DEFAULT '0',
PRIMARY KEY (customers_basket_attributes_id)
);

DROP TABLE IF EXISTS banktransfer;
CREATE TABLE banktransfer (
orders_id INT(11) NOT NULL DEFAULT '0',
banktransfer_owner VARCHAR(64) DEFAULT NULL,
banktransfer_number VARCHAR(24) DEFAULT NULL,
banktransfer_bankname VARCHAR(255) DEFAULT NULL,
banktransfer_blz VARCHAR(8) DEFAULT NULL,
banktransfer_status INT(11) DEFAULT NULL,
banktransfer_prz char(2) DEFAULT NULL,
banktransfer_fax char(2) DEFAULT NULL,
KEY orders_id(orders_id)
);

DROP TABLE IF EXISTS news_ticker;
CREATE TABLE news_ticker (
id INT(11) NOT NULL auto_increment,
ticker_text text NOT NULL,
language_id INT(2) NOT NULL,
status INT(1) NOT NULL DEFAULT '0',
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS banners;
CREATE TABLE banners (
banners_id INT NOT NULL auto_increment,
banners_title VARCHAR(64) NOT NULL,
banners_url VARCHAR(255) NOT NULL,
banners_image VARCHAR(64) NOT NULL,
banners_group VARCHAR(10) NOT NULL,
banners_html_text text,
expires_impressions INT(7) DEFAULT '0',
expires_date datetime DEFAULT NULL,
date_scheduled datetime DEFAULT NULL,
date_added datetime NOT NULL,
date_status_change datetime DEFAULT NULL,
status INT(1) DEFAULT '1' NOT NULL,
PRIMARY KEY (banners_id),
KEY status (status,banners_group)
);

DROP TABLE IF EXISTS banners_history;
CREATE TABLE banners_history (
banners_history_id INT NOT NULL auto_increment,
banners_id INT NOT NULL,
banners_shown INT(5) NOT NULL DEFAULT '0',
banners_clicked INT(5) NOT NULL DEFAULT '0',
banners_history_date datetime NOT NULL,
PRIMARY KEY (banners_history_id)
);

DROP TABLE IF EXISTS commerce_seo_url;
CREATE TABLE commerce_seo_url (
url_md5 VARCHAR(32) NOT NULL DEFAULT '',
url_text VARCHAR(255) NOT NULL DEFAULT '',
products_id INT(11) DEFAULT NULL,
categories_id INT(11) DEFAULT NULL,
blog_id INT(11) DEFAULT NULL,
blog_cat INT(11) DEFAULT NULL,
content_group INT(11) DEFAULT NULL,
language_id INT(11) NOT NULL DEFAULT '0',
PRIMARY KEY (url_md5),
KEY url_text (url_text,products_id)
);

DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
categories_id INT NOT NULL auto_increment,
categories_image VARCHAR(64),
categories_nav_image VARCHAR( 64 ),
categories_footer_image VARCHAR( 64 ),
parent_id INT DEFAULT '0' NOT NULL,
section INT DEFAULT '0' NOT NULL,
categories_status TINYINT (1) UNSIGNED DEFAULT "1" NOT NULL,
categories_main_status TINYINT (1) UNSIGNED DEFAULT "1" NOT NULL,
categories_content_status TINYINT (1) UNSIGNED DEFAULT "0" NOT NULL,
categories_template VARCHAR(64),
group_permission_0 TINYINT(1) NOT NULL,
group_permission_1 TINYINT(1) NOT NULL,
group_permission_2 TINYINT(1) NOT NULL,
group_permission_3 TINYINT(1) NOT NULL,
listing_template VARCHAR(64) NOT NULL DEFAULT '',
sort_order INT(3) DEFAULT '0' NOT NULL,
products_sorting VARCHAR(32),
products_sorting2 VARCHAR(32),
date_added datetime,
last_modified datetime,
categories_col_top TINYINT(1) NOT NULL DEFAULT 1,
categories_col_left TINYINT(1) NOT NULL DEFAULT 1,
categories_col_right TINYINT(1) NOT NULL DEFAULT 1,
categories_col_bottom TINYINT(1) NOT NULL DEFAULT 1,
PRIMARY KEY (categories_id),
KEY idx_categories_parent_id (parent_id),
KEY categories_id (categories_id,parent_id,categories_status,sort_order),
KEY parent_id (parent_id,categories_status,sort_order),
KEY categories_status (categories_status)
);

DROP TABLE IF EXISTS categories_description;
CREATE TABLE categories_description (
categories_id INT DEFAULT '0' NOT NULL,
language_id INT DEFAULT '1' NOT NULL,
categories_name VARCHAR(64) NOT NULL,
categories_heading_title VARCHAR(255) NOT NULL,
categories_description TEXT NOT NULL,
categories_short_description TEXT NOT NULL,
categories_description_footer TEXT NULL,
categories_pic_alt VARCHAR(128) NOT NULL,
categories_pic_footer_alt VARCHAR(128) NOT NULL,
categories_pic_nav_alt VARCHAR(128) NOT NULL,
categories_meta_title VARCHAR(128) NOT NULL,
categories_meta_description VARCHAR(255) NOT NULL,
categories_meta_keywords VARCHAR(255) NOT NULL,
categories_url_alias VARCHAR(64) NULL,
categories_google_taxonomie TEXT NULL,
PRIMARY KEY (categories_id, language_id),
KEY idx_categories_name (categories_name),
FULLTEXT (categories_name),
FULLTEXT (categories_description),
FULLTEXT (categories_description_footer)
);

DROP TABLE IF EXISTS configuration;
CREATE TABLE configuration (
configuration_id INT NOT NULL auto_increment,
configuration_key VARCHAR(64) NOT NULL,
configuration_value text NOT NULL,
configuration_group_id INT NOT NULL,
sort_order INT(5) NULL,
last_modified datetime NULL,
date_added datetime NOT NULL,
use_function VARCHAR(255) NULL,
set_function VARCHAR(255) NULL,
PRIMARY KEY (configuration_id),
KEY idx_configuration_group_id (configuration_group_id)
);

DROP TABLE IF EXISTS configuration_group;
CREATE TABLE configuration_group (
configuration_group_id INT NOT NULL auto_increment,
configuration_group_title VARCHAR(64) NOT NULL,
configuration_group_description VARCHAR(255) NOT NULL,
sort_order INT(5) NULL,
visible INT(1) DEFAULT '1' NULL,
PRIMARY KEY (configuration_group_id)
);

DROP TABLE IF EXISTS counter;
CREATE TABLE counter (
startdate char(8),
counter INT(12)
);

DROP TABLE IF EXISTS counter_history;
CREATE TABLE counter_history (
month char(8),
counter INT(12)
);

DROP TABLE IF EXISTS countries;
CREATE TABLE countries (
countries_id INT NOT NULL auto_increment,
countries_name VARCHAR(64) NOT NULL,
countries_iso_code_2 char(2) NOT NULL,
countries_iso_code_3 char(3) NOT NULL,
address_format_id INT NOT NULL,
status INT(1) DEFAULT '1' NULL,
PRIMARY KEY (countries_id),
KEY IDX_COUNTRIES_NAME (countries_name)
);

DROP TABLE IF EXISTS currencies;
CREATE TABLE currencies (
currencies_id INT NOT NULL auto_increment,
title VARCHAR(32) NOT NULL,
code char(3) NOT NULL,
symbol_left VARCHAR(12),
symbol_right VARCHAR(12),
decimal_point char(1),
thousands_point char(1),
decimal_places char(1),
value float(13,8),
last_updated datetime NULL,
PRIMARY KEY (currencies_id)
);

DROP TABLE IF EXISTS customers;
CREATE TABLE customers (
customers_id INT NOT NULL auto_increment,
customers_cid VARCHAR(32),
customers_vat_id VARCHAR (20),
customers_vat_id_status INT(2) DEFAULT '0' NOT NULL,
customers_warning VARCHAR(32),
customers_status INT(5) DEFAULT '1' NOT NULL,
customers_gender char(1) NOT NULL,
customers_firstname VARCHAR(32) NOT NULL,
customers_lastname VARCHAR(32) NOT NULL,
customers_dob datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
customers_email_address VARCHAR(96) NOT NULL,
customers_default_address_id INT NOT NULL,
customers_telephone VARCHAR(32) NOT NULL,
customers_fax VARCHAR(32),
customers_password VARCHAR(40) NOT NULL,
customers_newsletter char(1),
customers_newsletter_mode char( 1 ) DEFAULT '0' NOT NULL,
member_flag char(1) DEFAULT '0' NOT NULL,
delete_user char(1) DEFAULT '1' NOT NULL,
account_type INT(1) NOT NULL DEFAULT '0',
password_request_key VARCHAR(32) NOT NULL,
payment_unallowed VARCHAR(255) NOT NULL,
shipping_unallowed VARCHAR(255) NOT NULL,
refferers_id VARCHAR(32) DEFAULT '0' NOT NULL,
customers_date_added datetime DEFAULT '0000-00-00 00:00:00',
customers_last_modified datetime DEFAULT '0000-00-00 00:00:00',
datensg DATETIME NULL,
login_tries VARCHAR( 2 ) NOT NULL DEFAULT '0',
login_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (customers_id)
);

DROP TABLE IF EXISTS customers_basket;
CREATE TABLE customers_basket (
customers_basket_id INT NOT NULL auto_increment,
customers_id INT NOT NULL,
products_id tinytext NOT NULL,
customers_basket_quantity INT(2) NOT NULL,
final_price decimal(15,4) NOT NULL,
customers_basket_date_added char(8),
checkout_site enum('cart','shipping','payment','confirm') NOT NULL DEFAULT 'cart',
language VARCHAR(32) DEFAULT NULL,
PRIMARY KEY (customers_basket_id)
);

DROP TABLE IF EXISTS customers_basket_attributes;
CREATE TABLE customers_basket_attributes (
customers_basket_attributes_id INT NOT NULL auto_increment,
customers_id INT NOT NULL,
products_id tinytext NOT NULL,
products_options_id INT NOT NULL,
products_options_value_id INT NOT NULL,
PRIMARY KEY (customers_basket_attributes_id)
);

DROP TABLE IF EXISTS customers_info;
CREATE TABLE customers_info (
customers_info_id INT NOT NULL,
customers_info_date_of_last_logon datetime,
customers_info_number_of_logons INT(5),
customers_info_date_account_created datetime,
customers_info_date_account_last_modified datetime,
global_product_notifications INT(1) DEFAULT '0',
PRIMARY KEY (customers_info_id)
);

DROP TABLE IF EXISTS customers_ip;
CREATE TABLE customers_ip (
customers_ip_id INT(11) NOT NULL auto_increment,
customers_id INT(11) NOT NULL DEFAULT '0',
customers_ip VARCHAR(15) NOT NULL DEFAULT '',
customers_ip_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
customers_host VARCHAR(255) NOT NULL DEFAULT '',
customers_advertiser VARCHAR(30) DEFAULT NULL,
customers_referer_url VARCHAR(255) DEFAULT NULL,
PRIMARY KEY (customers_ip_id),
KEY customers_id (customers_id)
);

DROP TABLE IF EXISTS customers_status;
CREATE TABLE customers_status (
customers_status_id INT(11) NOT NULL DEFAULT '0',
language_id INT(11) NOT NULL DEFAULT '1',
customers_status_name VARCHAR(32) NOT NULL DEFAULT '',
customers_status_public INT(1) NOT NULL DEFAULT '1',
customers_status_min_order INT(7) DEFAULT NULL,
customers_status_max_order INT(7) DEFAULT NULL,
customers_status_image VARCHAR(64) DEFAULT NULL,
customers_status_discount decimal(4,2) DEFAULT '0',
customers_status_ot_discount_flag char(1) NOT NULL DEFAULT '0',
customers_status_ot_discount decimal(4,2) DEFAULT '0',
customers_status_graduated_prices VARCHAR(1) NOT NULL DEFAULT '0',
customers_status_show_price INT(1) NOT NULL DEFAULT '1',
customers_status_show_price_tax INT(1) NOT NULL DEFAULT '1',
customers_status_add_tax_ot INT(1) NOT NULL DEFAULT '0',
customers_status_payment_unallowed VARCHAR(255) NOT NULL,
customers_status_shipping_unallowed VARCHAR(255) NOT NULL,
customers_status_discount_attributes INT(1) NOT NULL DEFAULT '0',
customers_fsk18 INT(1) NOT NULL DEFAULT '1',
customers_fsk18_display INT(1) NOT NULL DEFAULT '1',
customers_status_write_reviews INT(1) NOT NULL DEFAULT '1',
customers_status_read_reviews INT(1) NOT NULL DEFAULT '1',
PRIMARY KEY (customers_status_id,language_id),
KEY idx_orders_status_name (customers_status_name)
);

DROP TABLE IF EXISTS customers_status_history;
CREATE TABLE customers_status_history (
customers_status_history_id INT(11) NOT NULL auto_increment,
customers_id INT(11) NOT NULL DEFAULT '0',
new_value INT(5) NOT NULL DEFAULT '0',
old_value INT(5) DEFAULT NULL,
date_added datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
customer_notified INT(1) DEFAULT '0',
PRIMARY KEY (customers_status_history_id)
);

DROP TABLE IF EXISTS languages;
CREATE TABLE languages (
languages_id INT NOT NULL auto_increment,
name VARCHAR(32) NOT NULL,
code char(5) NOT NULL,
image VARCHAR(64),
directory VARCHAR(32),
sort_order INT(3),
language_charset TEXT NOT NULL,
status INT(1) NOT NULL DEFAULT '0',
status_admin INT(1) NOT NULL DEFAULT '0',
PRIMARY KEY (languages_id),
KEY IDX_LANGUAGES_NAME (name)
);

DROP TABLE IF EXISTS manufacturers;
CREATE TABLE manufacturers (
manufacturers_id INT NOT NULL auto_increment,
manufacturers_name VARCHAR(64) NOT NULL,
manufacturers_image VARCHAR(64),
date_added datetime NULL,
last_modified datetime NULL,
PRIMARY KEY (manufacturers_id),
KEY IDX_MANUFACTURERS_NAME (manufacturers_name),
KEY manufacturers_id (manufacturers_id,manufacturers_name)
);

DROP TABLE IF EXISTS manufacturers_info;
CREATE TABLE manufacturers_info (
manufacturers_id int(11) NOT NULL,
languages_id int(11) NOT NULL,
manufacturers_description text NOT NULL,
manufacturers_meta_title VARCHAR(100) NOT NULL,
manufacturers_meta_description VARCHAR(255) NOT NULL,
manufacturers_meta_keywords VARCHAR(255) NOT NULL,
manufacturers_url VARCHAR(255) NOT NULL,
url_clicked int(5) NOT NULL DEFAULT '0',
date_last_click datetime DEFAULT NULL,
KEY manufacturers_id (manufacturers_id,languages_id)
);

DROP TABLE IF EXISTS newsletters;
CREATE TABLE newsletters (
newsletters_id INT NOT NULL auto_increment,
title VARCHAR(255) NOT NULL,
content text NOT NULL,
module VARCHAR(255) NOT NULL,
date_added datetime NOT NULL,
date_sent datetime,
status INT(1),
locked INT(1) DEFAULT '0',
PRIMARY KEY (newsletters_id)
);

DROP TABLE IF EXISTS newsletter_recipients;
CREATE TABLE newsletter_recipients (
mail_id INT(11) NOT NULL auto_increment,
customers_email_address VARCHAR(96) NOT NULL DEFAULT '',
customers_id INT(11) NOT NULL DEFAULT '0',
customers_status INT(5) NOT NULL DEFAULT '0',
customers_firstname VARCHAR(32) NOT NULL DEFAULT '',
customers_lastname VARCHAR(32) NOT NULL DEFAULT '',
mail_status INT(1) NOT NULL DEFAULT '0',
mail_key VARCHAR(32) NOT NULL DEFAULT '',
date_added datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (mail_id)
);

DROP TABLE IF EXISTS newsletters_history;
CREATE TABLE newsletters_history (
news_hist_id INT(11) NOT NULL DEFAULT '0',
news_hist_cs INT(11) NOT NULL DEFAULT '0',
news_hist_cs_date_sent date DEFAULT NULL,
PRIMARY KEY (news_hist_id)
);

DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
orders_id INT NOT NULL auto_increment,
customers_id INT NOT NULL,
customers_cid VARCHAR(32),
customers_vat_id VARCHAR (20),
customers_status INT(11),
customers_status_name VARCHAR(32) NOT NULL,
customers_status_image VARCHAR (64),
customers_status_discount decimal (4,2),
customers_name VARCHAR(64) NOT NULL,
customers_firstname VARCHAR(64) NOT NULL,
customers_lastname VARCHAR(64) NOT NULL,
customers_company VARCHAR(32),
customers_street_address VARCHAR(64) NOT NULL,
customers_suburb VARCHAR(32),
customers_city VARCHAR(32) NOT NULL,
customers_postcode VARCHAR(10) NOT NULL,
customers_state VARCHAR(32),
customers_country VARCHAR(32) NOT NULL,
customers_telephone VARCHAR(32) NOT NULL,
customers_email_address VARCHAR(96) NOT NULL,
customers_address_format_id INT(5) NOT NULL,
delivery_name VARCHAR(64) NOT NULL,
delivery_firstname VARCHAR(64) NOT NULL,
delivery_lastname VARCHAR(64) NOT NULL,
delivery_company VARCHAR(32),
delivery_street_address VARCHAR(64) NOT NULL,
delivery_suburb VARCHAR(32),
delivery_city VARCHAR(32) NOT NULL,
delivery_postcode VARCHAR(10) NOT NULL,
delivery_state VARCHAR(32),
delivery_country VARCHAR(32) NOT NULL,
delivery_country_iso_code_2 char(2) NOT NULL,
delivery_address_format_id INT(5) NOT NULL,
billing_name VARCHAR(64) NOT NULL,
billing_firstname VARCHAR(64) NOT NULL,
billing_lastname VARCHAR(64) NOT NULL,
billing_company VARCHAR(32),
billing_street_address VARCHAR(64) NOT NULL,
billing_suburb VARCHAR(32),
billing_city VARCHAR(32) NOT NULL,
billing_postcode VARCHAR(10) NOT NULL,
billing_state VARCHAR(32),
billing_country VARCHAR(32) NOT NULL,
billing_country_iso_code_2 char(2) NOT NULL,
billing_address_format_id INT(5) NOT NULL,
payment_method VARCHAR(32) NOT NULL,
cc_type VARCHAR(20),
cc_owner VARCHAR(64),
cc_number VARCHAR(64),
cc_expires VARCHAR(4),
cc_start VARCHAR(4) DEFAULT NULL,
cc_issue VARCHAR(3) DEFAULT NULL,
cc_cvv VARCHAR(4) DEFAULT NULL,
comments text,
last_modified datetime,
date_purchased datetime,
orders_status INT(5) NOT NULL,
orders_date_finished datetime,
currency char(3),
currency_value decimal(14,6),
account_type INT(1) DEFAULT '0' NOT NULL,
payment_class VARCHAR(32) NOT NULL,
shipping_method VARCHAR(128) NOT NULL,
shipping_class VARCHAR(32) NOT NULL,
shipping_cost VARCHAR(5) NOT NULL,
customers_ip VARCHAR(32) NOT NULL,
language VARCHAR(32) NOT NULL,
afterbuy_success INT(1) DEFAULT'0' NOT NULL,
afterbuy_id INT(32) DEFAULT '0' NOT NULL,
refferers_id VARCHAR(32) NOT NULL,
conversion_type INT(1) DEFAULT '0' NOT NULL,
orders_ident_key VARCHAR(128),
edebit_transaction_id VARCHAR(32),
edebit_gutid VARCHAR(32),
ibn_billnr INT NOT NULL,
ibn_billdate DATE NOT NULL,
ibn_pdfnotifydate DATE NOT NULL,
PRIMARY KEY (orders_id),
KEY customers_status (customers_status)
);


DROP TABLE IF EXISTS orders_products;
CREATE TABLE orders_products (
orders_products_id INT NOT NULL auto_increment,
orders_id INT NOT NULL,
products_id INT NOT NULL,
products_model VARCHAR(64),
products_name VARCHAR(64) NOT NULL,
products_price decimal(15,4) NOT NULL,
products_discount_made decimal(4,2) DEFAULT NULL,
products_shipping_time VARCHAR(255) DEFAULT NULL,
final_price decimal(15,4) NOT NULL,
products_tax decimal(7,4) NOT NULL,
products_quantity INT(2) NOT NULL,
allow_tax INT(1) NOT NULL,
PRIMARY KEY (orders_products_id),
KEY idx_orders_id (orders_id),
KEY idx_products_id (products_id)
);

DROP TABLE IF EXISTS orders_status;
CREATE TABLE orders_status (
orders_status_id INT DEFAULT '0' NOT NULL,
language_id INT DEFAULT '1' NOT NULL,
orders_status_name VARCHAR(32) NOT NULL,
PRIMARY KEY (orders_status_id, language_id),
KEY idx_orders_status_name (orders_status_name)
);

DROP TABLE IF EXISTS shipping_status;
CREATE TABLE shipping_status (
shipping_status_id INT DEFAULT '0' NOT NULL,
language_id INT DEFAULT '1' NOT NULL,
shipping_status_name VARCHAR(32) NOT NULL,
shipping_status_image VARCHAR(32) NOT NULL,
PRIMARY KEY (shipping_status_id, language_id),
KEY idx_shipping_status_name (shipping_status_name),
KEY language_id (language_id)
);

DROP TABLE IF EXISTS search_queries_all;
CREATE TABLE search_queries_all (
search_id INT(11) NOT NULL auto_increment,
search_text tinytext ,
search_result VARCHAR(255) NOT NULL,
PRIMARY KEY (search_id)
);

DROP TABLE IF EXISTS search_queries_sorted;
CREATE TABLE search_queries_sorted (
search_id smallint(6) not null auto_increment,
search_text tinytext not null ,
search_count INT(11) default '0' NOT NULL,
search_result VARCHAR(255) NOT NULL,
PRIMARY KEY (search_id)
);

DROP TABLE IF EXISTS orders_status_history;
CREATE TABLE orders_status_history (
orders_status_history_id INT NOT NULL auto_increment,
orders_id INT NOT NULL,
orders_status_id INT(5) NOT NULL,
date_added datetime NOT NULL,
customer_notified INT(1) DEFAULT '0',
comments TEXT,
PRIMARY KEY (orders_status_history_id)
);

DROP TABLE IF EXISTS orders_products_attributes;
CREATE TABLE orders_products_attributes (
orders_products_attributes_id INT NOT NULL auto_increment,
orders_id INT NOT NULL,
orders_products_id INT NOT NULL,
products_options VARCHAR(32) NOT NULL,
products_options_values VARCHAR(64) NOT NULL,
options_values_price decimal(15,4) NOT NULL,
price_prefix CHAR(1) NOT NULL,
products_attributes_model VARCHAR( 255 ) NULL,
PRIMARY KEY (orders_products_attributes_id)
);

DROP TABLE IF EXISTS orders_products_download;
CREATE TABLE orders_products_download (
orders_products_download_id INT NOT NULL auto_increment,
orders_id INT NOT NULL DEFAULT '0',
orders_products_id INT NOT NULL DEFAULT '0',
orders_products_filename VARCHAR(255) NOT NULL DEFAULT '',
download_maxdays INT(2) NOT NULL DEFAULT '0',
download_count INT(2) NOT NULL DEFAULT '0',
download_ip VARCHAR(15) NOT NULL DEFAULT '0',
download_time DATETIME NOT NULL,
PRIMARY KEY (orders_products_download_id)
);

DROP TABLE IF EXISTS orders_total;
CREATE TABLE orders_total (
orders_total_id INT NOT NULL auto_increment,
orders_id INT NOT NULL,
title VARCHAR(255) NOT NULL,
text VARCHAR(255) NOT NULL,
value decimal(15,4) NOT NULL,
class VARCHAR(32) NOT NULL,
sort_order INT NOT NULL,
PRIMARY KEY (orders_total_id),
KEY idx_orders_total_orders_id (orders_id)
);

DROP TABLE IF EXISTS paypal;
CREATE TABLE paypal (
paypal_ipn_id int(11) NOT NULL auto_increment,
xtc_order_id int(11) NOT NULL default '0',
txn_type VARCHAR(32) NOT NULL default '',
reason_code VARCHAR(15) default NULL,
payment_type VARCHAR(7) NOT NULL default '',
payment_status VARCHAR(17) NOT NULL default '',
pending_reason VARCHAR(14) default NULL,
invoice VARCHAR(64) default NULL,
mc_currency char(3) NOT NULL default '',
first_name VARCHAR(32) NOT NULL default '',
last_name VARCHAR(32) NOT NULL default '',
payer_business_name VARCHAR(64) default NULL,
address_name VARCHAR(32) default NULL,
address_street VARCHAR(64) default NULL,
address_city VARCHAR(32) default NULL,
address_state VARCHAR(32) default NULL,
address_zip VARCHAR(10) default NULL,
address_country VARCHAR(64) default NULL,
address_status VARCHAR(11) default NULL,
payer_email VARCHAR(96) NOT NULL default '',
payer_id VARCHAR(32) NOT NULL default '',
payer_status VARCHAR(10) NOT NULL default '',
payment_date datetime NOT NULL default '0001-01-01 00:00:00',
business VARCHAR(96) NOT NULL default '',
receiver_email VARCHAR(96) NOT NULL default '',
receiver_id VARCHAR(32) NOT NULL default '',
txn_id VARCHAR(40) NOT NULL default '',
parent_txn_id VARCHAR(17) default NULL,
num_cart_items tinyint(4) NOT NULL default '1',
mc_gross decimal(7,2) NOT NULL default '0.00',
mc_fee decimal(7,2) NOT NULL default '0.00',
mc_shipping decimal(7,2) NOT NULL default '0.00',
payment_gross decimal(7,2) default NULL,
payment_fee decimal(7,2) default NULL,
settle_amount decimal(7,2) default NULL,
settle_currency char(3) default NULL,
exchange_rate decimal(4,2) default NULL,
notify_version decimal(2,1) NOT NULL default '0.0',
verify_sign VARCHAR(128) NOT NULL default '',
last_modified datetime NOT NULL default '0001-01-01 00:00:00',
date_added datetime NOT NULL default '0001-01-01 00:00:00',
memo text,
mc_authorization decimal(7,2) NOT NULL,
mc_captured decimal(7,2) NOT NULL,
PRIMARY KEY (paypal_ipn_id,txn_id),
KEY xtc_order_id (xtc_order_id)
);

DROP TABLE if EXISTS paypal_status_history;
CREATE TABLE paypal_status_history (
payment_status_history_id int(11) NOT NULL auto_increment,
paypal_ipn_id int(11) NOT NULL default '0',
txn_id VARCHAR(64) NOT NULL default '',
parent_txn_id VARCHAR(64) NOT NULL default '',
payment_status VARCHAR(17) NOT NULL default '',
pending_reason VARCHAR(64) default NULL,
mc_amount decimal(7,2) NOT NULL,
date_added datetime NOT NULL default '0001-01-01 00:00:00',
PRIMARY KEY (payment_status_history_id),
KEY paypal_ipn_id (paypal_ipn_id)
);

DROP TABLE IF EXISTS orders_recalculate;
CREATE TABLE orders_recalculate (
orders_recalculate_id INT(11) NOT NULL auto_increment,
orders_id INT(11) NOT NULL DEFAULT '0',
n_price decimal(15,4) NOT NULL DEFAULT '0.0000',
b_price decimal(15,4) NOT NULL DEFAULT '0.0000',
tax decimal(15,4) NOT NULL DEFAULT '0.0000',
tax_rate decimal(7,4) NOT NULL DEFAULT '0.0000',
class VARCHAR(32) NOT NULL DEFAULT '',
PRIMARY KEY (orders_recalculate_id)
);

DROP TABLE IF EXISTS products;
CREATE TABLE products (
products_id INT NOT NULL auto_increment,
products_ean VARCHAR(128),
products_isbn VARCHAR(128),
products_upc VARCHAR(128),
products_g_identifier VARCHAR(128),
products_brand_name VARCHAR(128),
products_g_availability VARCHAR(128),
products_g_shipping_status INT(10),
products_quantity INT(4) NOT NULL,
products_shippingtime INT(4) NOT NULL,
products_model VARCHAR(64),
products_manufacturers_model VARCHAR(64),
group_permission_0 TINYINT(1) NOT NULL,
group_permission_1 TINYINT(1) NOT NULL,
group_permission_2 TINYINT(1) NOT NULL,
group_permission_3 TINYINT(1) NOT NULL,
products_sort INT(4) NOT NULL DEFAULT '0',
products_image VARCHAR(254),
products_price decimal(15,4) NOT NULL,
products_ekpprice decimal(15,4) NOT NULL,
products_discount_allowed decimal(5,2) DEFAULT '0.00' NOT NULL,
products_date_added datetime NOT NULL,
products_last_modified datetime,
products_date_available datetime,
products_weight decimal(10,3) DEFAULT '0.00' NOT NULL,
products_status TINYINT(1) NOT NULL,
products_tax_class_id INT NOT NULL,
product_template VARCHAR (64),
options_template VARCHAR (64),
manufacturers_id INT NULL,
products_ordered INT NOT NULL DEFAULT '0',
products_fsk18 INT(1) NOT NULL DEFAULT '0',
products_vpe INT(11) NOT NULL,
products_vpe_status INT(1) NOT NULL DEFAULT '0',
products_vpe_value decimal(15,4) NOT NULL,
products_startpage INT(1) NOT NULL DEFAULT '0',
products_startpage_sort INT(4) NOT NULL DEFAULT '0',
products_zustand VARCHAR(10) NOT NULL DEFAULT 'neu',
products_movie_embeded_code TEXT NULL,
products_movie_height INT(4) NULL,
products_movie_width INT(4) NULL,
products_movie_youtube_id VARCHAR(32) NOT NULL DEFAULT '',
products_movie_on_server VARCHAR(255) NOT NULL DEFAULT '',
products_col_top TINYINT(1) NOT NULL DEFAULT 1,
products_col_left TINYINT(1) NOT NULL DEFAULT 1,
products_col_right TINYINT(1) NOT NULL DEFAULT 1,
products_col_bottom TINYINT(1) NOT NULL DEFAULT 1,
products_cartspecial INT(1) NOT NULL DEFAULT 0,
products_buyable INT(1) NOT NULL DEFAULT 1,
products_sperrgut TINYINT(1) NOT NULL DEFAULT 0,
products_shipping_costs VARCHAR(64) NOT NULL,
products_forbidden_payment TEXT,
products_master int(1) NOT NULL DEFAULT 0,
products_master_article VARCHAR(64) NOT NULL,
products_slave_in_list int(1) NOT NULL DEFAULT 0,
stock_mail int(1) unsigned NOT NULL DEFAULT 0,
products_promotion_status int(1) NOT NULL default 0,
products_promotion_product_title int(1) NOT NULL default 0,
products_promotion_product_desc int(1) NOT NULL default 0,
products_treepodia_activate int(1) NOT NULL default 1,
products_minorder int(5) NULL,
products_only_request int(1) NOT NULL default '0',
products_rel int(1) NOT NULL default '1',
products_google_gender VARCHAR( 128 ) NULL,
products_google_age_group VARCHAR( 128 ) NULL,
products_google_color VARCHAR( 128 ) NULL,
products_google_size VARCHAR( 128 ) NULL,
PRIMARY KEY (products_id),
KEY idx_products_date_added (products_date_added),
KEY products_id (products_id,products_status,products_date_added),
KEY products_status (products_status,products_id,products_date_added),
KEY products_status_2 (products_status,products_id,products_price),
KEY products_status_3 (products_status,products_ordered,products_id),
KEY products_status_4 (products_status,products_model,products_id),
KEY products_id_2 (products_id,products_startpage,products_status,products_startpage_sort),
KEY products_date_available (products_date_available,products_id),
KEY products_quantity (products_quantity),
KEY products_sort (products_sort),
KEY products_tax_class_id (products_tax_class_id),
KEY manufacturers_id (manufacturers_id),
KEY products_startpage (products_startpage), 
KEY model (products_model)
);

DROP TABLE IF EXISTS products_attributes;
CREATE TABLE products_attributes (
products_attributes_id INT NOT NULL auto_increment,
products_id INT NOT NULL,
options_id INT NOT NULL,
options_values_id INT NOT NULL,
options_values_price decimal(15,4) NOT NULL,
price_prefix char(1) NOT NULL,
attributes_model VARCHAR(64) NULL,
attributes_stock INT(4) NULL,
options_values_weight decimal(15,4) NOT NULL,
weight_prefix char(1) NOT NULL,
sortorder INT(11) NULL,
attributes_ean VARCHAR( 128 ) NULL DEFAULT NULL,
attributes_vpe_status INT( 1 ) NOT NULL DEFAULT  '0',
attributes_vpe INT( 11 ) NOT NULL,
attributes_vpe_value DECIMAL( 15, 4 ) NOT NULL,
PRIMARY KEY (products_attributes_id),
KEY idx_products_id (products_id),
KEY idx_options (options_id, options_values_id),
KEY sortorder (sortorder),
FULLTEXT (attributes_model)
);

DROP TABLE IF EXISTS products_attributes_download;
CREATE TABLE products_attributes_download (
products_attributes_id INT NOT NULL,
products_attributes_filename VARCHAR(255) NOT NULL DEFAULT '',
products_attributes_maxdays INT(2) DEFAULT '0',
products_attributes_maxcount INT(2) DEFAULT '0',
PRIMARY KEY (products_attributes_id)
);

DROP TABLE IF EXISTS products_description;
CREATE TABLE products_description (
products_id INT NOT NULL auto_increment,
language_id INT NOT NULL DEFAULT '1',
products_name VARCHAR(128) NOT NULL DEFAULT '',
products_description TEXT NULL,
products_short_description TEXT NULL,
products_zusatz_description TEXT NULL,
products_google_taxonomie TEXT NULL,
products_taxonomie TEXT,
products_img_alt VARCHAR(128) NULL,
products_keywords VARCHAR(255) DEFAULT NULL,
products_meta_title VARCHAR(128) NULL,
products_meta_description TEXT NULL,
products_meta_keywords TEXT NULL,
products_url VARCHAR(255) DEFAULT NULL,
products_viewed INT(5) DEFAULT '0',
products_tag_cloud VARCHAR(32) NULL,
products_url_alias VARCHAR(128) NULL,
products_promotion_title VARCHAR(128) NULL,
products_promotion_image VARCHAR(64) NULL,
products_promotion_desc text NULL,
products_treepodia_catch_phrase_1 VARCHAR(255) DEFAULT NULL,
products_treepodia_catch_phrase_2 VARCHAR(255) DEFAULT NULL,
products_treepodia_catch_phrase_3 VARCHAR(255) DEFAULT NULL,
products_treepodia_catch_phrase_4 VARCHAR(255) DEFAULT NULL,
products_treepodia_youtube_keyword1 VARCHAR(255) NULL,
products_treepodia_youtube_keyword2 VARCHAR(255) NULL,
products_treepodia_youtube_keyword3 VARCHAR(255) NULL,
products_treepodia_youtube_keyword4 VARCHAR(255) NULL,
url_text VARCHAR(255) NULL,
url_md5 VARCHAR(32) NULL,
PRIMARY KEY (products_id,language_id),
KEY products_name (products_name),
KEY language_id (language_id,products_keywords),
KEY language_id_2 (language_id,products_name),
KEY urlidx (url_text, url_md5),
FULLTEXT (products_name),
FULLTEXT (products_description),
FULLTEXT (products_short_description),
FULLTEXT (products_zusatz_description)
);

DROP TABLE IF EXISTS products_images;
CREATE TABLE products_images (
image_id INT NOT NULL auto_increment,
products_id INT NOT NULL,
image_nr SMALLINT NOT NULL,
image_name VARCHAR(254) NOT NULL,
alt_langID_1 VARCHAR(64) NOT NULL,
alt_langID_2 VARCHAR(64) NOT NULL,
PRIMARY KEY (image_id),
KEY products_images (products_id)
);

DROP TABLE IF EXISTS products_listings;
CREATE TABLE IF NOT EXISTS products_listings (
list_name varchar(32) NOT NULL,
col int(2) NOT NULL DEFAULT '3',
p_img int(1) NOT NULL DEFAULT '1',
p_name int(1) NOT NULL DEFAULT '1',
p_price int(1) NOT NULL DEFAULT '1',
b_details int(1) NOT NULL DEFAULT '1',
b_order int(1) NOT NULL DEFAULT '1',
b_wishlist int(1) NOT NULL DEFAULT '0',
p_reviews int(1) NOT NULL DEFAULT '0',
p_stockimg int(1) NOT NULL DEFAULT '0',
p_vpe int(1) NOT NULL DEFAULT '0',
p_model int(1) NOT NULL DEFAULT '0',
p_manu_img int(1) NOT NULL DEFAULT '0',
p_manu_name int(1) NOT NULL DEFAULT '0',
p_short_desc int(1) NOT NULL DEFAULT '1',
p_short_desc_lenght int(1) NOT NULL DEFAULT '75',
p_long_desc int(1) NOT NULL DEFAULT '0',
p_long_desc_lenght int(1) NOT NULL DEFAULT '200',
list_type varchar(10) NOT NULL DEFAULT 'list',
list_head varchar(32) NOT NULL,
p_staffel int(1) NOT NULL DEFAULT '0',
p_attribute int(1) NOT NULL DEFAULT '0',
p_buy int(1) NOT NULL DEFAULT '0',
p_weight int(1) NOT NULL DEFAULT '0',
PRIMARY KEY (list_name),
KEY products_listings (list_name)
);

DROP TABLE IF EXISTS products_notifications;
CREATE TABLE products_notifications (
products_id INT NOT NULL,
customers_id INT NOT NULL,
date_added datetime NOT NULL,
PRIMARY KEY (products_id, customers_id)
);

DROP TABLE IF EXISTS products_parameters;
CREATE TABLE products_parameters (
parameters_id INT(11) NOT NULL auto_increment,
group_id INT(11) NOT NULL default '0',
products_id INT(11) NOT NULL default '0',
sort_order INT(3) NOT NULL default '0',
PRIMARY KEY (parameters_id)
);

DROP TABLE IF EXISTS products_parameters_description;
CREATE TABLE products_parameters_description (
parameters_id INT(11) NOT NULL,
language_id INT(11) NOT NULL,
parameters_name TEXT NOT NULL,
parameters_value TEXT NOT NULL,
PRIMARY KEY (parameters_id,language_id)
);

DROP TABLE IF EXISTS products_parameters_groups;
CREATE TABLE products_parameters_groups (
group_id INT(11) NOT NULL auto_increment,
sort_order INT(3) NOT NULL,
PRIMARY KEY (group_id)
);

DROP TABLE IF EXISTS products_parameters_groups_description;
CREATE TABLE products_parameters_groups_description (
group_id INT(11) NOT NULL,
language_id INT(11) NOT NULL,
group_name VARCHAR(64) NOT NULL,
PRIMARY KEY (group_id,language_id)
);

DROP TABLE IF EXISTS products_options;
CREATE TABLE products_options (
products_options_id INT NOT NULL DEFAULT '0',
language_id INT NOT NULL DEFAULT '1',
products_options_name VARCHAR(32) NOT NULL DEFAULT '',
products_options_sortorder int(11) DEFAULT NULL,
PRIMARY KEY (products_options_id,language_id)
);

DROP TABLE IF EXISTS products_options_values;
CREATE TABLE products_options_values (
products_options_values_id INT NOT NULL DEFAULT '0',
language_id INT NOT NULL DEFAULT '1',
products_options_values_name VARCHAR(64) NOT NULL DEFAULT '',
products_options_values_desc TEXT NOT NULL DEFAULT '',
products_options_values_image VARCHAR(64) NOT NULL DEFAULT '',
PRIMARY KEY (products_options_values_id,language_id),
KEY products_options_values_name (products_options_values_name,language_id),
FULLTEXT (products_options_values_name)
);

DROP TABLE IF EXISTS products_options_values_to_products_options;
CREATE TABLE products_options_values_to_products_options (
products_options_values_to_products_options_id INT NOT NULL auto_increment,
products_options_id INT NOT NULL,
products_options_values_id INT NOT NULL,
PRIMARY KEY (products_options_values_to_products_options_id),
KEY products_options_id (products_options_id),
KEY products_options_values_id (products_options_values_id)
);

DROP TABLE IF EXISTS products_graduated_prices;
CREATE TABLE products_graduated_prices (
products_id INT(11) NOT NULL DEFAULT '0',
quantity INT(11) NOT NULL DEFAULT '0',
unitprice decimal(15,4) NOT NULL DEFAULT '0.0000',
KEY products_id (products_id)
);

DROP TABLE IF EXISTS products_to_categories;
CREATE TABLE products_to_categories (
products_id INT NOT NULL,
categories_id INT NOT NULL,
PRIMARY KEY (products_id,categories_id),
KEY categories_id (categories_id,products_id),
KEY categories_id_2 (categories_id)
);

DROP TABLE IF EXISTS products_vpe;
CREATE TABLE products_vpe (
products_vpe_id INT(11) NOT NULL DEFAULT '0',
language_id INT(11) NOT NULL DEFAULT '0',
products_vpe_name VARCHAR(32) NOT NULL DEFAULT ''
);

DROP TABLE IF EXISTS reviews;
CREATE TABLE reviews (
reviews_id INT NOT NULL auto_increment,
products_id INT NOT NULL,
customers_id int,
customers_name VARCHAR(64) NOT NULL,
reviews_rating INT(1),
date_added datetime,
last_modified datetime,
reviews_read INT(5) NOT NULL DEFAULT '0',
reviews_status INT(1) NOT NULL DEFAULT '0',
PRIMARY KEY (reviews_id)
);

DROP TABLE IF EXISTS reviews_description;
CREATE TABLE reviews_description (
reviews_id INT NOT NULL,
languages_id INT NOT NULL,
reviews_text text NOT NULL,
PRIMARY KEY (reviews_id, languages_id)
);

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions (
sesskey VARCHAR(32) NOT NULL,
expiry INT(11) NOT NULL,
value text NOT NULL,
PRIMARY KEY (sesskey),
KEY sesskey (sesskey,expiry)
);

DROP TABLE IF EXISTS specials;
CREATE TABLE specials (
specials_id INT NOT NULL auto_increment,
products_id INT NOT NULL,
specials_quantity INT(4) NOT NULL,
specials_new_products_price decimal(15,4) NOT NULL,
specials_date_added datetime,
specials_last_modified datetime,
expires_date datetime,
date_status_change datetime,
status INT(1) NOT NULL DEFAULT '1',
PRIMARY KEY (specials_id),
KEY products_id (products_id,status,specials_date_added),
KEY status (status,expires_date)
);

DROP TABLE IF EXISTS tax_class;
CREATE TABLE tax_class (
tax_class_id INT NOT NULL auto_increment,
tax_class_title VARCHAR(128) NOT NULL,
tax_class_description VARCHAR(255) NOT NULL,
last_modified datetime NULL,
date_added datetime NOT NULL,
PRIMARY KEY (tax_class_id)
);

DROP TABLE IF EXISTS tax_rates;
CREATE TABLE tax_rates (
tax_rates_id INT NOT NULL auto_increment,
tax_zone_id INT NOT NULL,
tax_class_id INT NOT NULL,
tax_priority INT(5) DEFAULT 1,
tax_rate decimal(7,4) NOT NULL,
tax_description VARCHAR(255) NOT NULL,
last_modified datetime NULL,
date_added datetime NOT NULL,
PRIMARY KEY (tax_rates_id),
KEY tax_zone_id (tax_zone_id),
KEY tax_class_id (tax_class_id,tax_priority)
);

DROP TABLE IF EXISTS geo_zones;
CREATE TABLE geo_zones (
geo_zone_id INT NOT NULL auto_increment,
geo_zone_name VARCHAR(32) NOT NULL,
geo_zone_description VARCHAR(255) NOT NULL,
last_modified datetime NULL,
date_added datetime NOT NULL,
PRIMARY KEY (geo_zone_id)
);

DROP TABLE IF EXISTS whos_online;
CREATE TABLE whos_online (
customer_id int,
full_name VARCHAR(64) NOT NULL,
session_id VARCHAR(128) NOT NULL,
ip_address VARCHAR(15) NOT NULL,
time_entry VARCHAR(14) NOT NULL,
time_last_click VARCHAR(14) NOT NULL,
last_page_url VARCHAR(255) NOT NULL,
http_referer VARCHAR(255) NOT NULL,
user_agent VARCHAR(255) NOT NULL,
user_language VARCHAR( 6 ) NOT NULL,
KEY customer_id (customer_id),
KEY session_id (session_id),
KEY time_last_click (time_last_click)
);

DROP TABLE IF EXISTS whos_online_year;
CREATE TABLE whos_online_year (
whos_online_id int(11) NOT NULL auto_increment,
year int(4) NOT NULL default '0',
month int(2) NOT NULL default '0',
referer_url VARCHAR(250) default NULL,
count int(11) NOT NULL default '0',
PRIMARY KEY (whos_online_id)
); 

DROP TABLE IF EXISTS whos_online_month;
CREATE TABLE whos_online_month (
whos_online_id int(11) NOT NULL auto_increment,
day smallint(2) NOT NULL default '0',
referer_url VARCHAR(250) default NULL,
count int(11) NOT NULL default '0',
PRIMARY KEY (whos_online_id)
);

DROP TABLE IF EXISTS zones;
CREATE TABLE zones (
zone_id INT NOT NULL auto_increment,
zone_country_id INT NOT NULL,
zone_code VARCHAR(32) NOT NULL,
zone_name VARCHAR(32) NOT NULL,
PRIMARY KEY (zone_id)
);

DROP TABLE IF EXISTS zones_to_geo_zones;
CREATE TABLE zones_to_geo_zones (
association_id INT NOT NULL auto_increment,
zone_country_id INT NOT NULL,
zone_id INT NULL,
geo_zone_id INT NULL,
last_modified datetime NULL,
date_added datetime NOT NULL,
PRIMARY KEY (association_id),
KEY zone_id (zone_id),
KEY geo_zone_id (geo_zone_id),
KEY zone_country_id (zone_country_id,zone_id)
);

DROP TABLE IF EXISTS content_manager;
CREATE TABLE content_manager (
content_id INT(11) NOT NULL auto_increment,
categories_id INT(11) NOT NULL DEFAULT '0',
parent_id INT(11) NOT NULL DEFAULT '0',
group_ids TEXT,
languages_id INT(11) NOT NULL DEFAULT '0',
content_title text NOT NULL,
content_heading text NOT NULL,
content_text text NOT NULL,
sort_order INT(4) NOT NULL DEFAULT '0',
file_flag INT(1) NOT NULL DEFAULT '0',
content_file VARCHAR(64) NOT NULL DEFAULT '',
content_status INT(1) NOT NULL DEFAULT '0',
content_group INT(11) NOT NULL,
content_delete INT(1) NOT NULL DEFAULT '1',
content_meta_title text,
content_meta_description text,
content_meta_keywords text,
content_url_alias VARCHAR(64) NULL,
content_out_link TEXT NULL,
content_link_target VARCHAR(6) NULL,
content_link_type VARCHAR(8) NULL,
content_col_top TINYINT(1) NOT NULL DEFAULT 1,
content_col_left TINYINT(1) NOT NULL DEFAULT 1,
content_col_right TINYINT(1) NOT NULL DEFAULT 1,
content_col_bottom TINYINT(1) NOT NULL DEFAULT 1,
PRIMARY KEY (content_id),
KEY languages_id (languages_id,file_flag,content_status,sort_order),
KEY content_id (content_id,languages_id),
KEY content_group (content_group,languages_id)
);

DROP TABLE IF EXISTS media_content;
CREATE TABLE media_content (
file_id INT(11) NOT NULL auto_increment,
old_filename text NOT NULL,
new_filename text NOT NULL,
file_comment text NOT NULL,
PRIMARY KEY (file_id)
);

DROP TABLE IF EXISTS products_content;
CREATE TABLE products_content (
content_id INT(11) NOT NULL auto_increment,
products_id INT(11) NOT NULL DEFAULT '0',
group_ids TEXT,
content_name VARCHAR(32) NOT NULL DEFAULT '',
content_file VARCHAR(64) NOT NULL,
content_link text NOT NULL,
languages_id INT(11) NOT NULL DEFAULT '0',
content_read INT(11) NOT NULL DEFAULT '0',
file_comment text NOT NULL,
PRIMARY KEY (content_id)
);

DROP TABLE IF EXISTS module_newsletter;
CREATE TABLE module_newsletter (
newsletter_id INT(11) NOT NULL auto_increment,
title text NOT NULL,
bc text NOT NULL,
cc text NOT NULL,
date datetime DEFAULT NULL,
status INT(1) NOT NULL DEFAULT '0',
body text NOT NULL,
personalize char(3) NOT NULL DEFAULT '0',
greeting INT(1) NOT NULL DEFAULT '0',
gift char(3) NOT NULL DEFAULT '0',
ammount VARCHAR(10) NOT NULL DEFAULT '0',
product_list INT(11) NOT NULL DEFAULT '0',
PRIMARY KEY (newsletter_id)
);

DROP TABLE IF EXISTS newsletter_product_list;
CREATE TABLE newsletter_product_list (
id INT(11) NOT NULL auto_increment,
list_name char(64) NOT NULL DEFAULT '',
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS newsletter_products;
CREATE TABLE newsletter_products (
id INT(11) NOT NULL auto_increment,
accessories_id INT(11) NOT NULL DEFAULT '0',
product_id INT(11) NOT NULL DEFAULT '0',
PRIMARY KEY (id)
);

DROP TABLE if exists cm_file_flags;
CREATE TABLE cm_file_flags (
file_flag INT(11) NOT NULL,
file_flag_name VARCHAR(32) NOT NULL,
PRIMARY KEY (file_flag)
);

DROP TABLE if EXISTS coupon_email_track;
CREATE TABLE coupon_email_track (
unique_id INT(11) NOT NULL auto_increment,
coupon_id INT(11) NOT NULL DEFAULT '0',
customer_id_sent INT(11) NOT NULL DEFAULT '0',
sent_firstname VARCHAR(32) DEFAULT NULL,
sent_lastname VARCHAR(32) DEFAULT NULL,
emailed_to VARCHAR(32) DEFAULT NULL,
date_sent datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (unique_id)
);

DROP TABLE if EXISTS coupon_gv_customer;
CREATE TABLE coupon_gv_customer (
customer_id INT(5) NOT NULL DEFAULT '0',
amount decimal(8,4) NOT NULL DEFAULT '0.0000',
PRIMARY KEY (customer_id),
KEY customer_id (customer_id)
);

DROP TABLE if EXISTS coupon_gv_queue;
CREATE TABLE coupon_gv_queue (
unique_id INT(5) NOT NULL auto_increment,
customer_id INT(5) NOT NULL DEFAULT '0',
order_id INT(5) NOT NULL DEFAULT '0',
amount decimal(8,4) NOT NULL DEFAULT '0.0000',
date_created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
ipaddr VARCHAR(32) NOT NULL DEFAULT '',
release_flag char(1) NOT NULL DEFAULT 'N',
PRIMARY KEY (unique_id),
KEY uid (unique_id,customer_id,order_id)
);

DROP TABLE if EXISTS coupon_redeem_track;
CREATE TABLE coupon_redeem_track (
unique_id INT(11) NOT NULL auto_increment,
coupon_id INT(11) NOT NULL DEFAULT '0',
customer_id INT(11) NOT NULL DEFAULT '0',
redeem_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
redeem_ip VARCHAR(32) NOT NULL DEFAULT '',
order_id INT(11) NOT NULL DEFAULT '0',
PRIMARY KEY (unique_id)
);

DROP TABLE if EXISTS coupons;
CREATE TABLE coupons (
coupon_id INT(11) NOT NULL auto_increment,
coupon_type char(1) NOT NULL DEFAULT 'F',
coupon_code VARCHAR(32) NOT NULL DEFAULT '',
coupon_amount decimal(8,4) NOT NULL DEFAULT '0.0000',
coupon_minimum_order decimal(8,4) NOT NULL DEFAULT '0.0000',
coupon_start_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
coupon_expire_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
uses_per_coupon INT(5) NOT NULL DEFAULT '1',
uses_per_user INT(5) NOT NULL DEFAULT '0',
restrict_to_products VARCHAR(255) DEFAULT NULL,
restrict_to_categories VARCHAR(255) DEFAULT NULL,
restrict_to_customers text,
coupon_active char(1) NOT NULL DEFAULT 'Y',
date_created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
date_modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (coupon_id)
);

DROP TABLE IF EXISTS coupons_description;
CREATE TABLE coupons_description (
coupon_id INT(11) NOT NULL DEFAULT '0',
language_id INT(11) NOT NULL DEFAULT '0',
coupon_name VARCHAR(32) NOT NULL DEFAULT '',
coupon_description text,
KEY coupon_id (coupon_id)
);

DROP TABLE IF EXISTS personal_offers_by_customers_status_;
DROP TABLE IF EXISTS personal_offers_by_customers_status_0;
DROP TABLE IF EXISTS personal_offers_by_customers_status_1;
DROP TABLE IF EXISTS personal_offers_by_customers_status_2;
DROP TABLE IF EXISTS personal_offers_by_customers_status_3;

DROP TABLE IF EXISTS scart;
CREATE TABLE scart (
scartid INT( 11 ) NOT NULL AUTO_INCREMENT,
customers_id INT( 11 ) NOT NULL UNIQUE,
dateadded VARCHAR( 8 ) NOT NULL,
datemodified VARCHAR( 8 ) NOT NULL,
PRIMARY KEY ( scartid )
);

DROP TABLE IF EXISTS staffel_to_templates;
CREATE TABLE staffel_to_templates (
template_id INT(5) NOT NULL,
quantity INT(5) DEFAULT NULL,
personal_offer decimal(15,4) DEFAULT NULL
);

DROP TABLE if EXISTS staffel_templates;
CREATE TABLE staffel_templates (
template_id INT(5) NOT NULL auto_increment,
template_name VARCHAR(255) NOT NULL,
PRIMARY KEY ( template_id )
);


DROP TABLE if EXISTS tag_to_product;
CREATE TABLE tag_to_product (
id INT(11) NOT NULL auto_increment,
pID INT(10) NOT NULL DEFAULT '0',
lID INT(2) NOT NULL DEFAULT '0',
tag VARCHAR(64) NOT NULL DEFAULT '0',
PRIMARY KEY (id),
FULLTEXT (tag),
INDEX (id,pID)
);


DROP TABLE IF EXISTS emails;
CREATE TABLE emails (
id int(2) NOT NULL AUTO_INCREMENT,
email_name VARCHAR(64) NOT NULL,
languages_id int(2) NOT NULL,
email_address VARCHAR(64) NOT NULL,
email_address_name VARCHAR(64) NOT NULL,
email_replay_address VARCHAR(64) NOT NULL,
email_replay_address_name VARCHAR(64) NOT NULL,
email_subject VARCHAR(64) NOT NULL,
email_forward VARCHAR(64) NOT NULL,
email_content_html text NOT NULL,
email_content_text text NOT NULL,
email_backup_html text NOT NULL,
email_backup_text text NOT NULL,
email_timestamp int(10) NOT NULL,
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS emails_order_products_list;
CREATE TABLE emails_order_products_list (
id INT(11) NOT NULL auto_increment,
list_name char(64) NOT NULL DEFAULT '',
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS emails_order_products;
CREATE TABLE emails_order_products (
id INT(11) NOT NULL auto_increment,
accessories_id INT(11) NOT NULL DEFAULT '0',
product_id INT(11) NOT NULL DEFAULT '0',
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS blog_categories;
CREATE TABLE blog_categories (
id INT(11) NOT NULL AUTO_INCREMENT,
categories_id INT(5) NOT NULL,
parent_id INT(11) NOT NULL DEFAULT '0',
language_id INT(11) NOT NULL DEFAULT '0',
titel VARCHAR(150) NOT NULL DEFAULT '',
description text NOT NULL,
status INT(1) NOT NULL DEFAULT '0',
position INT(11) NOT NULL DEFAULT '0',
date VARCHAR(10) NOT NULL,
update_date VARCHAR(10) NOT NULL,
meta_title text,
meta_desc text,
meta_key text,
PRIMARY KEY (id,language_id)
);


DROP TABLE IF EXISTS blog_comment;
CREATE TABLE blog_comment (
id INT(3) NOT NULL AUTO_INCREMENT,
blog_id INT(11) NOT NULL,
name VARCHAR(150) NOT NULL DEFAULT '',
text text,
date VARCHAR(10) NOT NULL,
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS blog_items;
CREATE TABLE blog_items (
id INT(11) NOT NULL AUTO_INCREMENT,
item_id INT(5) NOT NULL,
language_id INT(11) NOT NULL DEFAULT '0',
categories_id INT(11) NOT NULL DEFAULT '0',
title VARCHAR(150) NOT NULL DEFAULT '',
name VARCHAR(200) NOT NULL DEFAULT '',
description text NOT NULL,
shortdesc text NOT NULL,
status INT(1) NOT NULL DEFAULT '0',
position INT(11) NOT NULL DEFAULT '0',
date VARCHAR(10) NOT NULL,
date_update VARCHAR(10) NOT NULL,
date2 DATE NOT NULL,
meta_title text,
meta_keywords text,
meta_description text,
lenght INT(5) DEFAULT NULL,
PRIMARY KEY (id,language_id)
);

DROP TABLE IF EXISTS blog_settings;
CREATE TABLE blog_settings (
id INT(11) NOT NULL auto_increment,
blog_key VARCHAR(20) DEFAULT NULL,
wert VARCHAR(20) DEFAULT NULL,
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS blog_start;
CREATE TABLE blog_start (
id INT(1) NOT NULL DEFAULT '0',
language_id INT(11) NOT NULL DEFAULT '0',
description TEXT NOT NULL,
date DATETIME NOT NULL,
PRIMARY KEY (id,language_id)
);


DROP TABLE IF EXISTS orders_pdf_profile;
CREATE TABLE orders_pdf_profile (
id int(11) unsigned NOT NULL AUTO_INCREMENT,
languages_id int(2) NOT NULL,
pdf_key VARCHAR(64) NOT NULL,
pdf_value VARCHAR(255) NOT NULL,
type VARCHAR(32) NOT NULL,
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS orders_pdf;
CREATE TABLE orders_pdf (
id int(11) unsigned NOT NULL AUTO_INCREMENT,
order_id int(6) NOT NULL,
pdf_bill_nr int(5) NOT NULL,
bill_name VARCHAR(128) NOT NULL,
customer_notified int(1) NOT NULL,
notified_date date NOT NULL,
pdf_generate_date date NOT NULL,
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS commerce_seo_url_names;
CREATE TABLE commerce_seo_url_names (
id INT(4) NOT NULL auto_increment,
file_name VARCHAR(64) NOT NULL,
file_name_php VARCHAR(32) NOT NULL,
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS commerce_seo_url_personal_links;
CREATE TABLE commerce_seo_url_personal_links (
link_id INT(4) NOT NULL auto_increment,
url_text VARCHAR(128) NOT NULL,
file_name VARCHAR(64) NOT NULL,
language_id INT(2) NOT NULL,
PRIMARY KEY (link_id)
);

DROP TABLE IF EXISTS products_to_filter;
CREATE TABLE products_to_filter (
products_id int(11) NOT NULL,
filter_id int(11) NOT NULL,
PRIMARY KEY (products_id,filter_id)
);

DROP TABLE IF EXISTS product_filter_categories;
CREATE TABLE product_filter_categories (
id int(11) NOT NULL default '0',
language_id int(11) NOT NULL default '0',
titel VARCHAR(150) NOT NULL default '',
status int(1) NOT NULL default '0',
position int(11) NOT NULL default '0',
categories_ids VARCHAR(64) NOT NULL default '',
PRIMARY KEY (id,language_id)
);

DROP TABLE IF EXISTS product_filter_items;
CREATE TABLE product_filter_items (
id int(11) NOT NULL default '0',
language_id int(11) NOT NULL default '0',
filter_categories_id int(11) NOT NULL default '0',
title VARCHAR(150) NOT NULL default '',
name VARCHAR(200) NOT NULL default '',
description text NOT NULL,
status int(1) NOT NULL default '0',
position int(11) NOT NULL default '0',
PRIMARY KEY (id,language_id)
);

DROP TABLE IF EXISTS accessories;
CREATE TABLE accessories (
id int(11) NOT NULL auto_increment,
head_product_id int(11) NOT NULL,
PRIMARY KEY (id)
);


DROP TABLE IF EXISTS accessories_products;
CREATE TABLE accessories_products (
id int(11) NOT NULL AUTO_INCREMENT,
accessories_id int(11) NOT NULL,
product_id int(11) NOT NULL,
sort_order int(11) NOT NULL,
PRIMARY KEY (id)
);


DROP TABLE IF EXISTS am_config;
CREATE TABLE am_config (
am_config_id int(11) NOT NULL auto_increment,
am_type VARCHAR(10) NOT NULL,
am_class VARCHAR(2) NOT NULL,
am_title VARCHAR(30) NOT NULL,
am_db_field VARCHAR(30) NOT NULL,
PRIMARY KEY (am_config_id)
);

DROP TABLE IF EXISTS attr_profile;
CREATE TABLE attr_profile (
attr_profile_item_id int(11) NOT NULL auto_increment,
products_id VARCHAR(64) default NULL,
options_id int(11) NOT NULL,
options_values_id int(11) NOT NULL,
options_values_price decimal(15,4) NOT NULL,
price_prefix char(1) NOT NULL,
attributes_model VARCHAR(64) default NULL,
attributes_ean VARCHAR(128) default NULL,
attributes_stock int(4) default NULL,
options_values_weight decimal(15,4) NOT NULL,
weight_prefix char(1) NOT NULL,
sortorder int(11) default NULL,
PRIMARY KEY (attr_profile_item_id)
);



DROP TABLE IF EXISTS addon_database;
CREATE TABLE addon_database (
configuration_id int(11) NOT NULL AUTO_INCREMENT,
configuration_key VARCHAR(128) NOT NULL,
configuration_value VARCHAR(255) NOT NULL,
PRIMARY KEY (configuration_id)
);


DROP TABLE IF EXISTS addon_filenames;
CREATE TABLE addon_filenames (
configuration_id int(11) NOT NULL AUTO_INCREMENT,
configuration_key VARCHAR(128) NOT NULL,
configuration_value VARCHAR(255) NOT NULL,
PRIMARY KEY (configuration_id)
);


DROP TABLE IF EXISTS addon_languages;
CREATE TABLE addon_languages (
configuration_id int(11) NOT NULL AUTO_INCREMENT,
configuration_key VARCHAR(128) NOT NULL,
configuration_value VARCHAR(255) NOT NULL,
languages_id int(11) NOT NULL,
PRIMARY KEY (configuration_id)
);


DROP TABLE IF EXISTS commerce_seo_redirect;
CREATE TABLE commerce_seo_redirect (
id INT(11) NOT NULL AUTO_INCREMENT,
old_url VARCHAR(255) NULL ,
new_url VARCHAR(255) NULL,
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS commerce_seo_404_stats;
CREATE TABLE commerce_seo_404_stats (
id INT(11) NOT NULL AUTO_INCREMENT,
search_key VARCHAR(255) NOT NULL ,
referrer VARCHAR(255) NOT NULL,
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS cseo_antispam;
CREATE TABLE cseo_antispam (
id int(10) NOT NULL AUTO_INCREMENT,
question text NOT NULL,
answer VARCHAR(255) NOT NULL,
language_id int(1) NOT NULL,
UNIQUE KEY id (id)
);

DROP TABLE IF EXISTS cseo_lang_button;
CREATE TABLE cseo_lang_button (
id int(10) NOT NULL AUTO_INCREMENT,
button VARCHAR(255) NOT NULL,
buttontext text NOT NULL,
language_id int(1) NOT NULL,
UNIQUE KEY id (id)
);

DROP TABLE IF EXISTS admin_navigation;
CREATE TABLE admin_navigation (
id int(3) NOT NULL AUTO_INCREMENT,
name VARCHAR(255) DEFAULT NULL,
title VARCHAR(255) DEFAULT NULL,
subsite VARCHAR(255) DEFAULT NULL,
filename VARCHAR(255) DEFAULT NULL,
gid int(5) DEFAULT NULL,
languages_id int(2) DEFAULT '2',
nav_set VARCHAR(255) DEFAULT NULL,
sort int(3) NOT NULL DEFAULT '1',
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS cseo_configuration;
CREATE TABLE cseo_configuration (
cseo_configuration_id int(11) NOT NULL AUTO_INCREMENT,
cseo_key varchar(255) NOT NULL DEFAULT '',
cseo_value text NOT NULL,
cseo_group_id int(11) NOT NULL DEFAULT '0',
cseo_sort_order int(5) NOT NULL DEFAULT '0',
PRIMARY KEY (cseo_configuration_id),
KEY cseo_key (cseo_key)
);

DROP TABLE IF EXISTS mail_templates;
CREATE TABLE IF NOT EXISTS mail_templates (
id int(11) NOT NULL auto_increment,
title varchar(100) NOT NULL,
mail_text text NOT NULL,
PRIMARY KEY  (id)
);

DROP TABLE IF EXISTS intrusions;
CREATE TABLE IF NOT EXISTS intrusions (
  name varchar(128) NOT NULL,
  badvalue varchar(255) NOT NULL,
  page varchar(255) NOT NULL,
  tags varchar(255) NOT NULL,
  ip varchar(128) NOT NULL,
  ip2 varchar(128) NOT NULL,
  impact varchar(255) NOT NULL,
  origin varchar(255) NOT NULL,
  created date NOT NULL
);


INSERT INTO cm_file_flags VALUES ('0', 'information');
INSERT INTO cm_file_flags VALUES ('1', 'content');
INSERT INTO cm_file_flags VALUES ('2', 'Zusatztext1');
INSERT INTO cm_file_flags VALUES ('3', 'Zusatztext2');

INSERT INTO shipping_status VALUES (1, 1, '3-4 days', ''), (2, 1, '1 week', ''), (3, 1, '2 weeks', '');
INSERT INTO shipping_status VALUES (1, 2, '3-4 Tage', ''), (2, 2, '1 Woche', ''), (3, 2, '2 Wochen', '');

INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('product_listing_list', 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, 1, 1, 75, 0, 200, 'list', '', 1, 1, 1, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('product_listing_grid', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 75, 0, 200, 'list', '', 0, 0, 0, 1);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('product_filter_list', 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', '', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('product_filter_grid', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', '', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('advanced_search_result_list', 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, 1, 1, 75, 0, 200, 'list', '', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('advanced_search_result_grid', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', '', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('also_purchased', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'ALSO_PURCHASED', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('cross_selling', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'CROSS_SELLING', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('reverse_cross_selling', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'REVERSE_CROSS_SELLING', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('new_products_default', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'NEW_PRODUCTS_DEFAULT', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('new_products', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 75, 0, 200, 'list', 'NEW_PRODUCTS', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('new_products_overview', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'NEW_PRODUCTS_OVERVIEW', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('history_product', 3, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'HISTORY_PRODUCT', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('upcoming_product', 3, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'UPCOMING_PRODUCT', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('specials', 3, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'SPECIALS', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('tagcloud', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'TAGCLOUD', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('random_products', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'RANDOM_PRODUCTS', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('fuzzy_search', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'FUZZY_SEARCH', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('best_sellers', 1, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 75, 0, 200, 'box', '', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('specials_box', 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 75, 0, 200, 'box', '', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('random_products_box', 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 75, 0, 200, 'box', '', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('whats_new', 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 75, 0, 200, 'box', '', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('cart_special', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'CART_SPECIAL', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('last_viewed', 3, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 75, 0, 200, 'box', '', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('random_specials', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'RANDOM_SPECIALS', 0, 0, 0, 0);
INSERT INTO products_listings (list_name, col, p_img, p_name, p_price, b_details, b_order, b_wishlist, p_reviews, p_stockimg, p_vpe, p_model, p_manu_img, p_manu_name, p_short_desc, p_short_desc_lenght, p_long_desc, p_long_desc_lenght, list_type, list_head, p_staffel, p_attribute, p_buy, p_weight) VALUES ('random_bestseller', 3, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 75, 0, 200, 'list', 'RANDOM_BESTSELLER', 0, 0, 0, 0);


INSERT INTO content_manager VALUES (1, 0, 0, '', 1, 'Shipping - Returns', 'Shipping - Returns', 'Put here your Shipping & Returns information.', 0, 1, '', 1, 1, 0, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (2, 0, 0, '', 1, 'Privacy Notice', 'Privacy Notice', 'Put here your Privacy Notice information.', 0, 1, '', 1, 2, 0, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (3, 0, 0, '', 1, 'Conditions of Use', 'Conditions of Use', 'Conditions of Use<br />Put here your Conditions of Use information.', 0, 1, '', 1, 3, 0, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (4, 0, 0, '', 1, 'Imprint', 'Imprint', 'Put here your Company information.', 0, 1, '', 1, 4, 0, 'Imprint', 'Imprint', 'Imprint', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (5, 0, 0, '', 1, 'Index', 'Welcome', '{$greeting} Put here your Welcome Message with the Content Manager.', 0, 1, '', 0, 5, 0, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (12, 0, 0, '', 1, 'Gift', 'Gift FAQ', 'Put here your Gift FAQ', 0, 1, '', 0, 6, 1, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (14, 0, 0, '', 1, 'Contact', 'Contact', 'Your Contact to us', 0, 1, '', 1, 7, 0, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (15, 0, 0, '', 1, 'Sitemap', '', '', 0, 0, 'sitemap.php', 1, 8, 1, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (17, 0, 0, '', 1, 'Cancellation Right', 'Cancellation Right', 'Put here your Cancellation Right', 0, 1, '', 1, 10, 1, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (18, 0, 0, '', 1, '404', '404 Site not found', '<p>Please use the Search-Function</p>', 0, 0, '', 0, 11, 0, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (19, 0, 0, '', 1, 'Down for Mainenance', 'Down for Mainenance', 'This Shop is down for Mainenance', 0, 0, '', 0, 12, 0, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (20, 0, 0, '', 1, 'Shipping Notice Checkout', 'Shipping Notice Checkout', 'Shipping Notice Checkout', 0, 0, '', 0, 13, 1, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (21, 0, 0, '', 1, 'PayPal Express Checkout', 'PayPal Express Notice Checkout', 'PayPal Express Notice Checkout', 0, 0, '', 0, 14, 1, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (22, 0, 0, '', 1, 'Index Footer', '', '', 0, 0, '', 0, 15, 0, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (23, 0, 0, '', 1, 'Addontetx1', '', '', 0, 2, '', 0, 50, 0, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (24, 0, 0, '', 1, 'Addontetx2', '', '', 0, 2, '', 0, 51, 0, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (25, 0, 0, '', 1, 'Addontetx3', '', '', 0, 3, '', 0, 52, 0, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (26, 0, 0, '', 1, 'Addontetx4', '', '', 0, 3, '', 0, 53, 0, '', '', '','', '', '', '', '1', '1', '1', '1');

INSERT INTO content_manager VALUES (6, 0, 0, '', 2, 'Liefer- und Versandkosten', 'Liefer- und Versandkosten', 'Fügen Sie hier Ihre Informationen über Liefer- und Versandkosten ein.', 0, 1, '', 1, 1, 0, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (7, 0, 0, '', 2, 'Privatsphäre und Datenschutz', 'Privatsphäre und Datenschutz', 'Fügen Sie hier Ihre Informationen über Privatsphäre und Datenschutz ein.', 0, 1, '', 1, 2, 0, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (8, 0, 0, '', 2, 'Unsere AGB', 'Allgemeine Geschäftsbedingungen', '<strong>Allgemeine Geschäftsbedingungen<br /></strong><br />Fügen Sie hier Ihre allgemeinen Geschäftsbedingungen ein.<br /><br /><ol><li>Geltungsbereich</li><li>Vertragspartner</li><li>Angebot und Vertragsschluss</li><li>Widerrufsrecht, Widerrufsbelehrung, Widerrufsfolgen</li><li>Preise und Versandkosten</li><li>Lieferung</li><li>Zahlung</li><li>Eigentumsvorbehalt</li><li>Gewährleistung</li></ol>Weitere Informationen', 0, 1, '', 1, 3, 0, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (9, 0, 0, '', 2, 'Impressum', 'Impressum', 'Fügen Sie hier Ihr Impressum ein.<br /><br />DemoShop GmbH<br />Inhaber: Max Muster und Fritz Beispiel<br /><br />Max Muster Stra&szlig;e 21-23<br />D-0815 Musterhausen<br />E-Mail: max.muster@muster.de<br /><br />HRB 123456<br />Amtsgericht Musterhausen<br />UStid-Nr. DE 000 111 222', 0, 1, '', 1, 4, 0, 'Impressum', 'Impressum', 'Impressum', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (10, 0, 0, '', 2, 'Startseite', 'Willkommen', '{$greeting}<br /><br />Dies ist die Standardinstallation von commerce:SEO. Alle dargestellten Produkte dienen zur Demonstration der Funktionsweise. Wenn Sie Produkte bestellen, so werden diese weder ausgeliefert, noch in Rechnung gestellt. Alle Informationen zu den verschiedenen Produkten sind erfunden und daher kann kein Anspruch daraus abgeleitet werden.<br /><br />Sollten Sie daran interessiert sein das Programm, welches die Grundlage für diesen Shop bildet, einzusetzen, so besuchen Sie bitte die Seite von commerce:SEO. Dieser Shop basiert auf der commerce:SEO<br /><br />Der hier dargestellte Text kann im AdminInterface unter dem Punkt <b>Content Manager</b> - Eintrag Index bearbeitet werden.', 0, 1, '', 0, 5, 0, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (11, 0, 0, '', 2, 'Gutscheine', 'Gutscheine - Fragen und Antworten', '<h2>\r\n	Gutscheine kaufen</h2>\r\n<p>\r\n	Gutscheine k&ouml;nnen, falls sie im Shop angeboten werden, wie normale Artikel gekauft werden. Sobald Sie einen Gutschein gekauft haben und dieser nach erfolgreicher Zahlung freigeschaltet wurde, erscheint der Betrag unter Ihrem Warenkorb. Nun k&ouml;nnen Sie &uuml;ber den Link &quot; Gutschein versenden &quot; den gew&uuml;nschten Betrag per E-Mail versenden.</p>\r\n<h2>\r\n	Wie man Gutscheine versendet</h2>\r\n<p>\r\n	Um einen Gutschein zu versenden, klicken Sie bitte auf den Link &quot;Gutschein versenden&quot; in Ihrem Einkaufskorb. Um einen Gutschein zu versenden, ben&ouml;tigen wir folgende Angaben von Ihnen: Vor- und Nachname des Empf&auml;ngers. Eine g&uuml;ltige E-Mail Adresse des Empf&auml;ngers. Den gew&uuml;nschten Betrag (Sie k&ouml;nnen auch Teilbetr&auml;ge Ihres Guthabens versenden). Eine kurze Nachricht an den Empf&auml;nger. Bitte &uuml;berpr&uuml;fen Sie Ihre Angaben noch einmal vor dem Versenden. Sie haben vor dem Versenden jederzeit die M&ouml;glichkeit Ihre Angaben zu korrigieren.</p>\r\n<h2>\r\n	Mit Gutscheinen Einkaufen.</h2>\r\n<p>\r\n	Sobald Sie &uuml;ber ein Guthaben verf&uuml;gen, k&ouml;nnen Sie dieses zum Bezahlen Ihrer Bestellung verwenden. W&auml;hrend des Bestellvorganges haben Sie die M&ouml;glichkeit Ihr Guthaben einzul&ouml;sen. Falls das Guthaben unter dem Warenwert liegt m&uuml;ssen Sie Ihre bevorzugte Zahlungsweise f&uuml;r den Differenzbetrag w&auml;hlen. &uuml;bersteigt Ihr Guthaben den Warenwert, steht Ihnen das Restguthaben selbstverst&auml;ndlich f&uuml;r Ihre n&auml;chste Bestellung zur Verf&uuml;gung.</p>\r\n<h2>\r\n	Gutscheine verbuchen.</h2>\r\n<p>\r\n	Wenn Sie einen Gutschein per E-Mail erhalten haben, k&ouml;nnen Sie den Betrag wie folgt verbuchen:.<br />\r\n	1. Klicken Sie auf den in der E-Mail angegebenen Link. Falls Sie noch nicht &uuml;ber ein pers&ouml;nliches Kundenkonto verf&uuml;gen, haben Sie die M&ouml;glichkeit ein Konto zu er&ouml;ffnen.<br />\r\n	2. Nachdem Sie ein Produkt in den Warenkorb gelegt haben, k&ouml;nnen Sie dort Ihren Gutscheincode eingeben.</p>\r\n<h2>\r\n	Falls es zu Problemen kommen sollte:</h2>\r\n<p>\r\n	Falls es wider Erwarten zu Problemen mit einem Gutschein kommen sollte, kontaktieren Sie uns bitte per E-Mail : you@yourdomain.com. Bitte beschreiben Sie m&ouml;glichst genau das Problem, wichtige Angaben sind unter anderem: Ihre Kundennummer, der Gutscheincode, Fehlermeldungen des Systems sowie der von Ihnen benutzte Browser.</p>', 0, 1, '', 0, 6, 1, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (13, 0, 0, '', 2, 'Kontakt', 'Kontakt', '<p>Ihre Kontaktinformationen</p>', 0, 1, '', 1, 7, 0, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (16, 0, 0, '', 2, 'Seitenübersicht', '', '', 0, 0, 'sitemap.php', 1, 8, 1, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (27, 0, 0, '', 2, 'Widerrufsrecht', 'Widerrufsrecht', 'Widerrufsrecht bitte hier einfügen', 0, 1, '', 1, 10, 1, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (28, 0, 0, '', 2, 'Header 404', 'Die von Ihnen angeforderte Seite wurde nicht gefunden.', '<p>Bitte überprüfen Sie die korrekte schreibweise der URL, oder nutzen Sie die Suchfunktion.</p>', 0, 0, '', 0, 11, 0, '', '', '', '', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (29, 0, 0, '', 2, 'Wartungsmodus', 'Dieser Shop befindet sich im Wartungsmodus', 'Wir führen Wartungsarbeiten durch, werden aber in kürze wieder für Sie da sein.', 0, 0, '', 0, 12, 0, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (30, 0, 0, '', 2, 'Versandhinweis Checkout', 'Versandhinweis Checkout', 'Sofern die Lieferung in das Nicht-EU-Ausland erfolgt, können weitere Zölle, Steuern oder Gebühren vom Kunden zu zahlen sein, jedoch nicht an den Anbieter, sondern an die dort zuständigen Zoll- bzw. Steuerbehörden. Dem Kunden wird empfohlen, die Einzelheiten vor der Bestellung bei den Zoll- bzw. Steuerbehörden zu erfragen.', 0, 0, '', 0, 13, 1, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (31, 0, 0, '', 2, 'PayPal Express Warenkorb Hinweis', 'PayPal Express Checkout', 'Bei Auswahl dieser Zahlungsart werden Sie im n&auml;chsten Schritt automatisch zu PayPal weitergeleitet. Dort k&ouml;nnen Sie sich in Ihr PayPal-Konto einloggen oder ein neues PayPal-Konto er&ouml;ffnen und die Zahlung freigeben. Sobald Sie Ihre Daten f&uuml;r die Zahlung best&auml;tigt haben, werden Sie automatisch wieder zur&uuml;ck in den Shop geleitet, um die Bestellung abzuschlie&szlig;en.', 0, 0, '', 0, 14, 1, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (32, 0, 0, '', 2, 'Startseite unten', '', '', 0, 0, '', 0, 15, 0, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (33, 0, 0, '', 2, 'Zusatztetx1', '', '', 0, 2, '', 0, 50, 0, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (34, 0, 0, '', 2, 'Zusatztetx2', '', '', 0, 2, '', 0, 51, 0, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (35, 0, 0, '', 2, 'Zusatztetx3', '', '', 0, 3, '', 0, 52, 0, '', '', '','', '', '', '', '1', '1', '1', '1');
INSERT INTO content_manager VALUES (36, 0, 0, '', 2, 'Zusatztetx4', '', '', 0, 3, '', 0, 53, 0, '', '', '','', '', '', '', '1', '1', '1', '1');

INSERT INTO address_format VALUES (1, '$firstname $lastname$cr$streets$cr$city, $postcode$cr$statecomma$country','$city / $country');
INSERT INTO address_format VALUES (2, '$firstname $lastname$cr$streets$cr$city, $state    $postcode$cr$country','$city, $state / $country');
INSERT INTO address_format VALUES (3, '$firstname $lastname$cr$streets$cr$city$cr$postcode - $statecomma$country','$state / $country');
INSERT INTO address_format VALUES (4, '$firstname $lastname$cr$streets$cr$city ($postcode)$cr$country', '$postcode / $country');
INSERT INTO address_format VALUES (5, '$firstname $lastname$cr$streets$cr$postcode $city$cr$country','$city / $country');
INSERT INTO address_format VALUES (6, '$firstname $lastname$cr$streets$cr$city $state $postcode$cr$country','$country / $city');
INSERT INTO address_format VALUES (7, '$firstname $lastname$cr$streets, $city$cr$postcode $state$cr$country','$country / $city');
INSERT INTO address_format VALUES (8, '$firstname $lastname$cr$streets$cr$city$cr$state$cr$postcode$cr$country','$postcode / $country');


INSERT INTO admin_access VALUES (1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO admin_access VALUES ('groups', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 2, 4, 2, 2, 2, 2, 5, 5, 5, 5, 5, 5, 5, 5, 5, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);


INSERT INTO configuration VALUES 
(NULL, 'STORE_NAME', 'Commerce:SEO', 1, 1, NULL, NOW(), NULL, NULL),
(NULL, 'STORE_OWNER', 'Commerce:SEO', 1, 2, NULL, NOW(), NULL, NULL),
(NULL, 'STORE_OWNER_EMAIL_ADDRESS', 'email@ihr-shop.de', 1, 3, NULL, NOW(), NULL, NULL),
(NULL, 'EMAIL_FROM', 'Commerce:SEO email@ihr-shop.de', 1, 4, NULL, NOW(), NULL, NULL),
(NULL, 'STORE_COUNTRY', '81', 1, 6, NULL, NOW(), 'xtc_get_country_name', 'xtc_cfg_pull_down_country_list('),
(NULL, 'STORE_ZONE', '', 1, 7, NULL, NOW(), 'xtc_cfg_get_zone_name', 'xtc_cfg_pull_down_zone_list('),
(NULL, 'EXPECTED_PRODUCTS_SORT', 'desc', 1, 8, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'asc\', \'desc\'),'),
(NULL, 'EXPECTED_PRODUCTS_FIELD', 'date_expected', 1, 9, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'products_name\', \'date_expected\'),'),
(NULL, 'USE_DEFAULT_LANGUAGE_CURRENCY', 'false', 1, 10, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'DISPLAY_CART', 'true', 1, 13, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ADVANCED_SEARCH_DEFAULT_OPERATOR', 'and', 1, 15, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'and\', \'or\'),'),
(NULL, 'STORE_NAME_ADDRESS', 'Shop Name\nAdresse\nLand\nTelefon\nFax', 1, 16, NULL, NOW(), NULL, 'xtc_cfg_textarea('),
(NULL, 'SHOW_COUNTS', 'false', 1, 17, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'DEFAULT_CUSTOMERS_STATUS_ID_ADMIN', '0', 1, 20, NULL, NOW(), 'xtc_get_customers_status_name', 'xtc_cfg_pull_down_customers_status_list('),
(NULL, 'DEFAULT_CUSTOMERS_STATUS_ID_GUEST', '1', 1, 21, NULL, NOW(), 'xtc_get_customers_status_name', 'xtc_cfg_pull_down_customers_status_list('),
(NULL, 'DEFAULT_CUSTOMERS_STATUS_ID', '2', 1, 23, NULL, NOW(), 'xtc_get_customers_status_name', 'xtc_cfg_pull_down_customers_status_list('),
(NULL, 'ALLOW_ADD_TO_CART', 'true', 1, 24, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CURRENT_TEMPLATE', 'cseov22-grid', 1, 26, NULL, NOW(), NULL, 'xtc_cfg_pull_down_template_sets('),
(NULL, 'PRICE_IS_BRUTTO', 'true', 1, 28, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRICE_PRECISION', '4', 1, 29, NULL, NOW(), NULL, ''),
(NULL, 'DISPLAY_TAX', 'true', 1, 30, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'TAX_DECIMAL_PLACES', '2', 1, 31, NULL, NOW(), NULL, NULL);

INSERT INTO configuration VALUES (NULL, 'PDF_RECHNUNG_OID', 'true', 1, 32, NULL, '', NOW(), "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'PDF_RECHNUNG_DATE_ACT', 'true', 1, 33, NULL, '', NOW(), "xtc_cfg_select_option(array('true', 'false'),");

# configuration_group_id 2
INSERT INTO configuration VALUES 
(NULL, 'ENTRY_FIRST_NAME_MIN_LENGTH', '2', 2, 1, NULL, NOW(), NULL, NULL),
(NULL, 'ENTRY_LAST_NAME_MIN_LENGTH', '2', 2, 2, NULL, NOW(), NULL, NULL),
(NULL, 'ENTRY_DOB_MIN_LENGTH', '10', 2, 3, NULL, NOW(), NULL, NULL),
(NULL, 'ENTRY_EMAIL_ADDRESS_MIN_LENGTH', '6', 2, 4, NULL, NOW(), NULL, NULL),
(NULL, 'ENTRY_STREET_ADDRESS_MIN_LENGTH', '5', 2, 5, NULL, NOW(), NULL, NULL),
(NULL, 'ENTRY_COMPANY_MIN_LENGTH', '2', 2, 6, NULL, NOW(), NULL, NULL),
(NULL, 'ENTRY_POSTCODE_MIN_LENGTH', '4', 2, 7, NULL, NOW(), NULL, NULL),
(NULL, 'ENTRY_CITY_MIN_LENGTH', '3', 2, 8, NULL, NOW(), NULL, NULL),
(NULL, 'ENTRY_STATE_MIN_LENGTH', '2', 2, 9, NULL, NOW(), NULL, NULL),
(NULL, 'ENTRY_TELEPHONE_MIN_LENGTH', '3', 2, 10, NULL, NOW(), NULL, NULL),
(NULL, 'ENTRY_PASSWORD_MIN_LENGTH', '6', 2, 11, NULL, NOW(), NULL, NULL),
(NULL, 'CC_OWNER_MIN_LENGTH', '3', 2, 12, NULL, NOW(), NULL, NULL),
(NULL, 'CC_NUMBER_MIN_LENGTH', '10', 2, 13, NULL, NOW(), NULL, NULL),
(NULL, 'REVIEW_TEXT_MIN_LENGTH', '50', 2, 14, NULL, NOW(), NULL, NULL),
(NULL, 'MIN_DISPLAY_BESTSELLERS', '1', 2, 15, NULL, NOW(), NULL, NULL),
(NULL, 'MIN_DISPLAY_ALSO_PURCHASED', '1', 2, 16, NULL, NOW(), NULL, NULL);

# configuration_group_id 3
INSERT INTO configuration VALUES 
(NULL, 'MAX_ADDRESS_BOOK_ENTRIES', '5', 3, 1, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_SEARCH_RESULTS', '20', 3, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_PAGE_LINKS', '5', 3, 3, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_SPECIAL_PRODUCTS', '9', 3, 4, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_NEW_PRODUCTS', '9', 3, 5, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_UPCOMING_PRODUCTS', '10', 3, 6, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_MANUFACTURERS_IN_A_LIST', '0', 3, 7, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_MANUFACTURERS_LIST', '1', 3, 7, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_MANUFACTURER_NAME_LEN', '15', 3, 8, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_NEW_REVIEWS', '6', 3, 9, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_RANDOM_SELECT_REVIEWS', '10', 3, 10, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_RANDOM_SELECT_NEW', '10', 3, 11, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_RANDOM_SELECT_SPECIALS', '10', 3, 12, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_CATEGORIES_PER_ROW', '3', 3, 13, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_PRODUCTS_NEW', '10', 3, 14, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_BESTSELLERS', '10', 3, 15, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_ALSO_PURCHASED', '6', 3, 16, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX', '6', 3, 17, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_ORDER_HISTORY', '10', 3, 18, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_REVIEWS_VIEW', '5', 3, 19, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_PRODUCTS_QTY', '1000', 3, 21, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_NEW_PRODUCTS_DAYS', '30', 3, 22, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_CART_SPECIALS', '3', 3, 23, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_RANDOM_PRODUCTS', '3', 3, 24, NULL , NOW(), NULL , NULL),
(NULL, 'MAX_DISPLAY_TAGS_RESULTS', '40', 3, 25, NULL, NOW(), NULL, NULL),
(NULL, 'MIN_DISPLAY_TAGS_FONT', '12', 3, 26, NULL, NOW(), NULL, NULL),
(NULL, 'MAX_DISPLAY_TAGS_FONT', '32', 3, 27, NULL, NOW(), NULL, NULL);

# configuration_group_id 4
INSERT INTO configuration VALUES 
(NULL, 'CONFIG_CALCULATE_IMAGE_SIZE', 'true', 4, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'IMAGE_QUALITY', '72', 4, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MO_PICS', '3', '4', 3, 3, NOW(), NULL , NULL),
(NULL, 'IMAGE_MANIPULATOR', 'image_manipulator_GD2.php', 4, 4, NULL, NOW(), NULL , 'xtc_cfg_select_option(array(\'image_manipulator_GD2.php\'),'),

(NULL, 'PRODUCT_IMAGE_MINI_WIDTH', '45', 4, 5, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_MINI_HEIGHT', '45', 4, 6, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_THUMBNAIL_WIDTH', '120', 4, 7, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_THUMBNAIL_HEIGHT', '120', 4, 8, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_INFO_WIDTH', '200', 4, 9, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_INFO_HEIGHT', '200', 4, 10, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_POPUP_WIDTH', '800', 4, 11, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_POPUP_HEIGHT', '800', 4, 12, NULL, NOW(), NULL, NULL),
(NULL, 'CATEGORY_IMAGE_WIDTH', '160', 4, 13, NULL, NOW(), NULL, NULL),
(NULL, 'CATEGORY_IMAGE_HEIGHT', '160', 4, 14, NULL, NOW(), NULL, NULL),
(NULL, 'CATEGORY_INFO_IMAGE_WIDTH', '240', 4, 15, NULL, NOW(), NULL, NULL),
(NULL, 'CATEGORY_INFO_IMAGE_HEIGHT', '240', 4, 16, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_INFO_SMOTH', '', 4, 17, NULL, NOW(), NULL, ''),

(NULL, 'PRODUCT_IMAGE_MINI_BEVEL', '', 4, 18, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_MINI_GREYSCALE', '', 4, 19, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_MINI_ELLIPSE', '', 4, 20, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_MINI_ROUND_EDGES', '', 4, 21, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_MINI_MERGE', '', 4, 22, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_MINI_FRAME', '', 4, 23, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_MINI_DROP_SHADDOW', '', 4, 24, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_MINI_MOTION_BLUR', '', 4, 25, NULL, NOW(), NULL, NULL),

(NULL, 'PRODUCT_IMAGE_THUMBNAIL_BEVEL', '', 4, 26, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_THUMBNAIL_GREYSCALE', '', 4, 27, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_THUMBNAIL_ELLIPSE', '', 4, 28, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES', '', 4, 29, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_THUMBNAIL_MERGE', '', 4, 30, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_THUMBNAIL_FRAME', '', 4, 31, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW', '', 4, 32, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR', '', 4, 33, NULL, NOW(), NULL, NULL),

(NULL, 'PRODUCT_IMAGE_INFO_BEVEL', '', 4, 34, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_INFO_GREYSCALE', '', 4, 35, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_INFO_ELLIPSE', '', 4, 36, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_INFO_ROUND_EDGES', '', 4, 37, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_INFO_MERGE', '', 4, 38, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_INFO_FRAME', '', 4, 39, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_INFO_DROP_SHADDOW', '', 4, 40, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_INFO_MOTION_BLUR', '', 4, 41, NULL, NOW(), NULL, NULL),

(NULL, 'PRODUCT_IMAGE_POPUP_BEVEL', '', 4, 42, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_POPUP_GREYSCALE', '', 4, 43, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_POPUP_ELLIPSE', '', 4, 44, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_POPUP_ROUND_EDGES', '', 4, 45, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_POPUP_MERGE', '', 4, 46, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_POPUP_FRAME', '', 4, 47, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_POPUP_DROP_SHADDOW', '', 4, 48, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_IMAGE_POPUP_MOTION_BLUR', '', 4, 49, NULL, NOW(), NULL, NULL),

(NULL, 'CATEGORY_IMAGE_MERGE', '', 4, 50, NULL, NOW(), NULL, NULL),
(NULL, 'CATEGORY_INFO_IMAGE_MERGE', '', 4, 51, NULL, NOW(), NULL, NULL);

# configuration_group_id 5
INSERT INTO configuration VALUES 
(NULL, 'ACCOUNT_GENDER', 'true', 5, 1, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ACCOUNT_DOB', 'true', 5, 2, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ACCOUNT_COMPANY', 'true', 5, 3, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ACCOUNT_SUBURB', 'false', 5, 4, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ACCOUNT_STATE', 'false', 5, 5, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ACCOUNT_OPTIONS', 'account', 5, 6, NULL, '', NULL, 'xtc_cfg_select_option(array(\'account\', \'guest\', \'both\'),'),
(NULL, 'DELETE_GUEST_ACCOUNT', 'true', 5, 7, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'), ");

# configuration_group_id 6
INSERT INTO configuration VALUES 
(NULL, 'MODULE_PAYMENT_INSTALLED', '', 6, 0, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_ORDER_TOTAL_INSTALLED', 'ot_subtotal.php;ot_shipping.php;ot_tax.php;ot_total.php', 6, 0, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_SHIPPING_INSTALLED', '', 6, 0, NULL, NOW(), NULL, NULL),
(NULL, 'DEFAULT_CURRENCY', 'EUR', 6, 0, NULL, NOW(), NULL, NULL),
(NULL, 'DEFAULT_LANGUAGE', 'de', 6, 0, NULL, NOW(), NULL, NULL),
(NULL, 'DEFAULT_ORDERS_STATUS_ID', '1', 6, 0, NULL, NOW(), NULL, NULL),
(NULL, 'DEFAULT_PRODUCTS_VPE_ID', '', 6, 0, NULL, NOW(), NULL, NULL),
(NULL, 'DEFAULT_SHIPPING_STATUS_ID', '1', 6, 0, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'true', 6, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'MODULE_ORDER_TOTAL_SHIPPING_TAX_CLASS', '0',6,7, NULL, NOW(), 'xtc_get_tax_class_title', 'xtc_cfg_pull_down_tax_classes('), 
(NULL, 'MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER', '30', 6, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING', 'false', 6, 3, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', '50', 6, 4, NULL, NOW(), 'currencies->format', NULL),
(NULL, 'MODULE_ORDER_TOTAL_SHIPPING_DESTINATION', 'national', 6, 5, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(\'national\', \'international\', \'both\'),'),
(NULL, 'MODULE_ORDER_TOTAL_SUBTOTAL_STATUS', 'true', 6, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER', '10', 6, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_ORDER_TOTAL_TAX_STATUS', 'true', 6, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'MODULE_ORDER_TOTAL_TAX_SORT_ORDER', '50', 6, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_ORDER_TOTAL_TOTAL_STATUS', 'true', 6, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER', '99', 6, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_ORDER_TOTAL_DISCOUNT_STATUS', 'true', 6, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'MODULE_ORDER_TOTAL_DISCOUNT_SORT_ORDER', '20', 6, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_ORDER_TOTAL_TOTAL_NETTO_STATUS', 'true', 6, 1,NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'MODULE_ORDER_TOTAL_TOTAL_NETTO_SORT_ORDER', '45', 6, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS', 'true', 6, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_SORT_ORDER','40', 6, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_CSEO_ATTRIBUT_MANAGER','true', 6, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_CSEO_MULTICAT_STATUS','true', 6, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_CSEO_MULTICAT_SORT_ORDER','1', 6, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_CSEO_MULTICAT','true', 6, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_CSEO_GLOBAL_PRODUCTS_PRICE_STATUS','true', 6, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_CSEO_GLOBAL_PRODUCTS_PRICE_SORT_ORDER','1', 6, 2, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_CSEO_GLOBAL_PRODUCTS_PRICE','true', 6, 2, NULL, NOW(), NULL, NULL);

# configuration_group_id 7
INSERT INTO configuration VALUES 
(NULL, 'SHIPPING_ORIGIN_COUNTRY', '81', 7, 1, NULL, NOW(), 'xtc_get_country_name', 'xtc_cfg_pull_down_country_list('),
(NULL, 'SHIPPING_ORIGIN_ZIP', '', 7, 2, NULL, NOW(), NULL, NULL),
(NULL, 'SHIPPING_MAX_WEIGHT', '50', 7, 3, NULL, NOW(), NULL, NULL),
(NULL, 'SHIPPING_BOX_WEIGHT', '3', 7, 4, NULL, NOW(), NULL, NULL),
(NULL, 'SHIPPING_BOX_PADDING', '10', 7, 5, NULL, NOW(), NULL, NULL),
(NULL, 'SHOW_SHIPPING', 'true', 7, 6, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'SHIPPING_INFOS', '1', 7, 7, NULL, NOW(), NULL, NULL),
(NULL, 'SHIPPING_SPERRGUT_1', '30', 7, 10, NULL , NOW( ) , NULL , NULL),
(NULL, 'SHIPPING_SPERRGUT_2', '50', 7, 11, NULL , NOW( ) , NULL , NULL),
(NULL, 'SHIPPING_SPERRGUT_3', '100', 7, 12, NULL , NOW( ) , NULL , NULL);

# configuration_group_id 8
INSERT INTO configuration VALUES (NULL, 'PRODUCT_LIST_FILTER', '1', 8, 1, NULL, NOW(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'MAX_ROW_LISTS_OPTIONS', '10', 8, 2, NULL, NOW(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'PRODUCT_LISTING_MANU_NAME', 'false', 8, 3, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'PRODUCT_LISTING_MANU_IMG', 'false', 8, 4, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'PRODUCT_LISTING_VPE', 'false', 8, 5, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'PRODUCT_LISTING_MODEL', 'false', 8, 6, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'PRODUCT_LIST_FILTER_SORT', 'true', 8, 7, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'DISPLAY_SUBCAT_PRODUCTS', 'false', 8, 8, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'PRODUCT_LISTING_ATTRIBUT_TEMPLATE', 'dropdown', 8, 9, NULL, NOW(), NULL, "xtc_cfg_select_option(array('dropdown', 'selection'),");


# configuration_group_id 9
INSERT INTO configuration VALUES 
(NULL, 'STOCK_REORDER_LEVEL', '2', 9, 1, NULL, NOW(), NULL, NULL),
(NULL, 'MODULE_CUSTOMERS_ADMINMAIL_STATUS', 'false', 9, 2, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'STOCK_CHECK', 'true', 9, 3, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ATTRIBUTE_STOCK_CHECK', 'true', 9, 4, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'STOCK_LIMITED', 'true', 9, 5, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'STOCK_ALLOW_CHECKOUT', 'true', 9, 6, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'STOCK_ALLOW_CHECKOUT_DEACTIVATE', 'false', 9, 7, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'STOCK_MARK_PRODUCT_OUT_OF_STOCK', '<b style="color:red">***</b>', 9, 8, NULL, NOW(), NULL, NULL),
(NULL, 'STOCK_WARNING_GREEN', '2', 9, 9, NULL, NOW(), NULL, NULL),
(NULL, 'STOCK_WARNING_YELLOW', '1', 9, 10, NULL, NOW(), NULL, NULL),
(NULL, 'STOCK_WARNING_RED', '0', 9, 11, NULL, NOW(), NULL, NULL);

# configuration_group_id 10
INSERT INTO configuration VALUES 
(NULL, 'STORE_PAGE_PARSE_TIME', 'false', 10, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'STORE_PAGE_PARSE_TIME_LOG', '/var/log/www/tep/page_parse_time.log', 10, 2, NULL, NOW(), NULL, NULL),
(NULL, 'STORE_PARSE_DATE_TIME_FORMAT', '%d/%m/%Y %H:%M:%S', 10, 3, NULL, NOW(), NULL, NULL),
(NULL, 'DISPLAY_PAGE_PARSE_TIME', 'false', 10, 4, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'STORE_DB_TRANSACTIONS', 'false', 10, 5, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'LOG_SEARCH_RESULTS', 'false', 10, 5, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'), ");

# configuration_group_id 11
INSERT INTO configuration VALUES 
(NULL, 'USE_CACHE', 'false', 11, 1, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'DIR_FS_CACHE', 'cache', 11, 2, NULL, NOW(), NULL, NULL),
(NULL, 'CACHE_LIFETIME', '3600', 11, 3, NULL, NOW(), NULL, NULL),
(NULL, 'CACHE_CHECK', 'true', 11, 4, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'DB_CACHE', 'false', 11, 5, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'DB_CACHE_EXPIRE', '3600', 11, 6, NULL, NOW(), NULL, NULL),
(NULL, 'USE_TEMPLATE_CACHE', 'false', 11, 7, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),'),
(NULL, 'USE_TEMPLATE_DEVMODE', 'false', 11, 9, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),'),
(NULL, 'CACHE_TEMPLATE_LIFETIME', '5', 11, 8, NULL, NOW(), NULL, NULL);

# configuration_group_id 12
INSERT INTO configuration VALUES 
(NULL, 'EMAIL_TRANSPORT', 'mail', 12, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'sendmail\', \'smtp\', \'mail\'),'),
(NULL, 'SENDMAIL_PATH', '/usr/sbin/sendmail', 12, 2, NULL, NOW(), NULL, NULL),
(NULL, 'SMTP_MAIN_SERVER', 'localhost', 12, 3, NULL, NOW(), NULL, NULL),
(NULL, 'SMTP_BACKUP_SERVER', 'localhost', 12, 4, NULL, NOW(), NULL, NULL),
(NULL, 'SMTP_PORT', '25', 12, 5, NULL, NOW(), NULL, NULL),
(NULL, 'SMTP_USERNAME', 'Please Enter', 12, 6, NULL, NOW(), NULL, NULL),
(NULL, 'SMTP_PASSWORD', 'Please Enter', 12, 7, NULL, NOW(), NULL, NULL),
(NULL, 'SMTP_AUTH', 'false', 12, 8, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'EMAIL_LINEFEED', 'LF', 12, 9, NULL, '', NULL, 'xtc_cfg_select_option(array(\'LF\', \'CRLF\'),'),
(NULL, 'EMAIL_USE_HTML', 'true', 12, 10, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ENTRY_EMAIL_ADDRESS_CHECK', 'false', 12, 11, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'SEND_EMAILS', 'true', 12, 12, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'), ");

# configuration_group_id 24
INSERT INTO configuration VALUES 
(NULL, 'JANOLAW_USERID', '', 24, 1, NULL, NOW(), NULL, NULL),
(NULL, 'JANOLAW_SHOPID', '', 24, 2, NULL, NOW(), NULL, NULL),
(NULL, 'JANOLAW_CACHEPATH', '/tmp', 24, 3, NULL, NOW(), NULL, NULL),
(NULL, 'JANOLAW_BASEURL', 'http://www.janolaw.de/agb-service/shops', 24, 4, NULL, NOW(), NULL, NULL),
(NULL, 'JANOLAW_CACHETIME', '7200', 24, 5, NULL, NOW(), NULL, NULL);

# configuration_group_id 13
INSERT INTO configuration VALUES 
(NULL, 'DOWNLOAD_ENABLED', 'false', 13, 1, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'DOWNLOAD_BY_REDIRECT', 'false', 13, 2, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'DOWNLOAD_UNALLOWED_PAYMENT', '{banktransfer,cod,invoice,moneyorder}', 13, 5, NULL, NOW(), NULL, NULL),
(NULL, 'DOWNLOAD_MIN_ORDERS_STATUS', '1', 13, 5, NULL, NOW(), NULL, NULL);

# configuration_group_id 14
INSERT INTO configuration VALUES 
(NULL, 'GZIP_COMPRESSION', 'false', 14, 1, NULL, '', NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'GZIP_LEVEL', '9', 14, 2, NULL, NOW(), NULL, NULL);

# configuration_group_id 15
INSERT INTO configuration VALUES 
(NULL, 'SESSION_WRITE_DIRECTORY', '/tmp', 15, 1, NULL, NOW(), NULL, NULL),
(NULL, 'SESSION_FORCE_COOKIE_USE', 'false', 15, 2, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'SESSION_CHECK_SSL_SESSION_ID', 'false', 15, 3, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'SESSION_CHECK_USER_AGENT', 'false', 15, 4, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'SESSION_CHECK_IP_ADDRESS', 'false', 15, 5, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'SESSION_TIMEOUT_ADMIN', 3600, 15, 6, NULL, NOW(), NULL, NULL),
(NULL, 'SESSION_RECREATE', 'false', 15, 7, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'), ");

# configuration_group_id 16
INSERT INTO configuration VALUES 
(NULL, 'META_MAX_KEYWORD_LENGTH', '12', 16, 1, NULL, NOW(), NULL, NULL),
(NULL, 'META_MIN_KEYWORD_LENGTH', '3', 16, 2, NULL, NOW(), NULL, NULL),
(NULL, 'META_MAX_DESCRIPTION_LENGTH', '160', 16, 3, NULL, NOW(), NULL, NULL),
(NULL, 'META_MAX_TITLE_LENGTH', '70', 16, 3, NULL, NOW(), NULL, NULL),
(NULL, 'META_KEYWORDS_NUMBER', '5', 16, 4, NULL, NOW(), NULL, NULL),
(NULL, 'META_AUTHOR', '', 16, 5, NULL, NOW(), NULL, NULL),
(NULL, 'META_PUBLISHER', '', 16, 6, NULL, NOW(), NULL, NULL),
(NULL, 'META_COMPANY', '', 16, 7, NULL, NOW(), NULL, NULL),
(NULL, 'META_TOPIC', 'shopping', 16, 8, NULL, NOW(), NULL, NULL),
(NULL, 'META_REPLY_TO', 'xx@xx.com', 16, 9, NULL, NOW(), NULL, NULL),
(NULL, 'META_REVISIT_AFTER', '14', 16, 10, NULL, NOW(), NULL, NULL),
(NULL, 'META_ROBOTS', 'index,follow,noodp', 16, 11, NULL, NOW(), NULL, NULL),
(NULL, 'META_DESCRIPTION', '', 16, 12, NULL, NOW(), NULL, NULL),
(NULL, 'META_KEYWORDS', '', 16, 13, NULL, NOW(), NULL, NULL),
(NULL, 'SEARCH_ENGINE_FRIENDLY_URLS', 'false', 6, 14, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECK_CLIENT_AGENT', 'true',6, 15, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'GOOGLE_VERIFY', '', 16, 16, NULL, NOW(), NULL, NULL);

# configuration_group_id 17
INSERT INTO configuration VALUES 
(NULL, 'USE_WYSIWYG', 'true', 17, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'USE_CODEMIRROR', 'false', 17, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ACTIVATE_GIFT_SYSTEM', 'false', 17, 2, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'SECURITY_CODE_LENGTH', '10', 17, 3, NULL, NOW(), NULL, NULL),
(NULL, 'NEW_SIGNUP_GIFT_VOUCHER_AMOUNT', '0', 17, 4, NULL, NOW(), NULL, NULL),
(NULL, 'NEW_SIGNUP_DISCOUNT_COUPON', '', 17, 5, NULL, NOW(), NULL, NULL),
(NULL, 'ACTIVATE_SHIPPING_STATUS', 'true', 17, 6, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'GROUP_CHECK', 'false', 17, 7, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ACTIVATE_NAVIGATOR', 'true', 17, 8, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'QUICKLINK_ACTIVATED', 'true', 17, 9, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ACTIVATE_REVERSE_CROSS_SELLING', 'true', 17, 10, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'), ");


#configuration_group_id 18
INSERT INTO configuration VALUES 
(NULL, 'ACCOUNT_COMPANY_VAT_CHECK', 'true', 18, 4, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'STORE_OWNER_VAT_ID', '', 18, 3, '', NOW(), NULL, NULL),
(NULL, 'DEFAULT_CUSTOMERS_VAT_STATUS_ID', '2', 18, 23, NULL, NOW(), 'xtc_get_customers_status_name', 'xtc_cfg_pull_down_customers_status_list('),
(NULL, 'ACCOUNT_COMPANY_VAT_LIVE_CHECK', 'true', 18, 4, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ACCOUNT_COMPANY_VAT_GROUP', 'false', 18, 4, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ACCOUNT_VAT_BLOCK_ERROR', 'true', 18, 4, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL', '2', '18', '24', NULL , NOW(), 'xtc_get_customers_status_name', 'xtc_cfg_pull_down_customers_status_list(');

#configuration_group_id 19
INSERT INTO configuration VALUES 
(NULL, 'GOOGLE_CONVERSION_ID', '', '19', '1', NULL , NOW(), NULL , NULL),
(NULL, 'GOOGLE_CONVERSION_LABEL', '', '19', '2', NULL , NOW(), NULL , NULL),
(NULL, 'GOOGLE_LANG', 'de', '19', '3', NULL , NOW(), NULL , NULL),
(NULL, 'GOOGLE_CONVERSION', 'false', '19', '0', NULL , NOW(), NULL , "xtc_cfg_select_option(array('true', 'false'), ");

#configuration_group_id 20
INSERT INTO configuration VALUES 
(NULL, 'CSV_TEXTSIGN', '', '20', '1', NULL , NOW(), NULL , NULL),
(NULL, 'CSV_SEPERATOR', ';', '20', '2', NULL , NOW(), NULL , NULL),
(NULL, 'COMPRESS_EXPORT', 'false', '20', '3', NULL , NOW(), NULL , "xtc_cfg_select_option(array('true', 'false'), ");

#configuration_group_id 21, Afterbuy
INSERT INTO configuration VALUES 
(NULL, 'AFTERBUY_PARTNERID', '', '21', '2', NULL , NOW(), NULL , NULL),
(NULL, 'AFTERBUY_PARTNERPASS', '', '21', '3', NULL , NOW(), NULL , NULL),
(NULL, 'AFTERBUY_USERID', '', '21', '4', NULL , NOW(), NULL , NULL),
(NULL, 'AFTERBUY_ORDERSTATUS', '1', '21', '5', NULL , NOW(), 'xtc_get_order_status_name' , 'xtc_cfg_pull_down_order_statuses('),
(NULL, 'AFTERBUY_ACTIVATED', 'false', '21', '6', NULL , NOW(), NULL , "xtc_cfg_select_option(array('true', 'false'), ");

#configuration_group_id 22, Search Options
INSERT INTO configuration VALUES 
(NULL, 'SEARCH_IN_DESC', 'true', 22, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'SEARCH_IN_CATDESC', 'false', 22, 2, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'SEARCH_IN_ATTR', 'true', 22, 3, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'SEARCH_ACTIVATE_SUGGEST', 'true', 22, 7, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),'),
(NULL, 'SEARCH_PRODUCT_KEYWORDS', 'false', 22, 8, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),'),
(NULL, 'SEARCH_PRODUCT_DESCRIPTION', 'false', 22, 9, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),'),
(NULL, 'SEARCH_PROXIMITY_TRIGGER', '70', 22, 10, NULL, NOW(), NULL, NULL),
(NULL, 'SEARCH_WEIGHT_LEVENSHTEIN', '0', 22, 11, NULL, NOW(), NULL, NULL),
(NULL, 'SEARCH_WEIGHT_SIMILAR_TEXT', '100', 22, 12, NULL, NOW(), NULL, NULL),
(NULL, 'SEARCH_WEIGHT_METAPHONE', '0', 22, 13, NULL, NOW(), NULL, NULL),
(NULL, 'SEARCH_SPLIT_MINIMUM_LENGTH', '3', 22, 14, NULL, NOW(), NULL, NULL),
(NULL, 'SEARCH_SPLIT_PRODUCT_NAMES', 'true', 22, 15, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),'),
(NULL, 'SEARCH_SPLIT_PRODUCT_CHARS', '[ ,.]', 22, 16, NULL, NOW(), NULL, NULL),
(NULL, 'SEARCH_MAX_KEXWORD_SUGGESTS', '6', 22, 17, NULL, NOW(), NULL, NULL),
(NULL, 'SEARCH_COUNT_PRODUCTS', 'true', 22, 18, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),'),
(NULL, 'SEARCH_ENABLE_PROXIMITY_COLOR', 'true', 22, 19, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),'),
(NULL, 'SEARCH_PROXIMITY_COLORS', '#9f6;#cf6;#ff6;#fc9;#f99', 22, 20, NULL, NOW(), NULL, NULL),
(NULL, 'SEARCH_ENABLE_PRODUCTS_SUGGEST', 'true', 22, 21, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),'),
(NULL, 'SEARCH_MAX_PRODUCTS_SUGGEST', '15', 22, 22, NULL, NOW(), NULL, NULL),
(NULL, 'SEARCH_SHOW_PARSETIME', 'false', 22, 23, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),');

#configuration_group_id 23, CSS Styler
INSERT INTO configuration VALUES
(NULL, 'CSS_BUTTON_ACTIVE', 'true', 23, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'css', 'false'),"),
(NULL, 'CSS_BUTTON_BACKGROUND', 'e3e8f0ff', 23, 2, NULL, NOW(), NULL, NULL),
(NULL, 'CSS_BUTTON_BACKGROUND_PIC', '-', 23, 3, NULL, NOW(), NULL, 'xtc_cfg_pull_down_css_bg_pic_sets('),
(NULL, 'CSS_BUTTON_BORDER_STYLE', 'solid', 23, 4, NULL, NOW(), NULL, "xtc_cfg_select_option(array('none', 'solid', 'dotted','dashed'),"),
(NULL, 'CSS_BUTTON_BORDER_WIDTH', '1px', 23, 5, NULL, NOW(), NULL, NULL),
(NULL, 'CSS_BUTTON_BORDER_COLOR', 'a6b2c1ff', 23, 6, NULL, NOW(), NULL, NULL),
(NULL, 'CSS_BUTTON_BORDER_RADIUS', '2px', 23, 7, NULL, NOW(), NULL, NULL),
(NULL, 'CSS_BUTTON_FONT_FAMILY', 'Arial', 23, 8, NULL, NOW(), NULL, "xtc_cfg_select_option(array('Verdana', 'Arial','Helvetica','Times','Georgia','Comic Sans MS'),"),
(NULL, 'CSS_BUTTON_FONT_SIZE', '12px', 23, 9, NULL, NOW(), NULL, NULL),
(NULL, 'CSS_BUTTON_FONT_ITALIC', 'false', 23, 10, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CSS_BUTTON_FONT_UNDERLINE', 'false', 23, 11, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CSS_BUTTON_FONT_COLOR', '303a45ff', 23, 12, NULL, NOW(), NULL, NULL),
(NULL, 'CSS_BUTTON_FONT_COLOR_HOVER', '303a45ff', 23, 13, NULL, NOW(), NULL, NULL),
(NULL, 'CSS_BUTTON_FONT_SHADOW', '#ffffff 0 0 1px', 23, 14, NULL, NOW(), NULL, NULL),
(NULL, 'CSS_BUTTON_BACKGROUND_HOVER', 'e3e8f0ff', 23, 15, NULL, NOW(), NULL, NULL),
(NULL, 'CSS_BUTTON_BACKGROUND_PIC_HOVER', '-', 23, 16, NULL, NOW(), NULL, 'xtc_cfg_pull_down_css_bg_pic_hover_sets('),
(NULL, 'CSS_BUTTON_BORDER_COLOR_HOVER', 'b7c2d1ff', 23, 17, NULL, NOW(), NULL, NULL),
(NULL, 'CSS_BUTTON_MISC', '', 23, 18, NULL, NOW(), NULL, 'xtc_cfg_textarea('),
(NULL, 'CSS_BUTTON_BACKGROUND_1', 'd5dbe5ff', 23, 19, NULL, NOW(), NULL, NULL),
(NULL, 'CSS_BUTTON_BACKGROUND_2', 'e6ebf2ff', 23, 20, NULL, NOW(), NULL, NULL),
(NULL, 'CSS_BUTTON_HOVER_BACKGROUND_1', 'e3e8f0ff', 23, 21, NULL, NOW(), NULL, NULL),
(NULL, 'CSS_BUTTON_HOVER_BACKGROUND_2', 'eaeff5ff', 23, 22, NULL, NOW(), NULL, NULL),

(NULL, 'WK_CSS_BUTTON_BORDER_COLOR', '25303dff', 23, 6, NULL, NOW(), NULL, NULL),
(NULL, 'WK_CSS_BUTTON_FONT_COLOR', 'e3e8f0ff', 23, 12, NULL, NOW(), NULL, NULL),
(NULL, 'WK_CSS_BUTTON_FONT_COLOR_HOVER', '222b35ff', 23, 13, NULL, NOW(), NULL, NULL),
(NULL, 'WK_CSS_BUTTON_FONT_SHADOW', '#303a45 0 0 1px', 23, 14, NULL, NOW(), NULL, NULL),
(NULL, 'WK_CSS_BUTTON_BACKGROUND', '303a45ff', 23, 25, NULL, NOW(), NULL, NULL),
(NULL, 'WK_CSS_BUTTON_BACKGROUND_1', '303a45ff', 23, 26, NULL, NOW(), NULL, NULL),
(NULL, 'WK_CSS_BUTTON_BACKGROUND_2', '222b35ff', 23, 27, NULL, NOW(), NULL, NULL),
(NULL, 'WK_CSS_BUTTON_BACKGROUND_HOVER', 'e3e8f0ff', 23, 28, NULL, NOW(), NULL, NULL),
(NULL, 'WK_CSS_BUTTON_HOVER_BACKGROUND_1', 'e3e8f0ff', 23, 29, NULL, NOW(), NULL, NULL),
(NULL, 'WK_CSS_BUTTON_HOVER_BACKGROUND_2', 'eaeff5ff', 23, 30, NULL, NOW(), NULL, NULL);


#configuration_group_id 333, Ajax Checkout
INSERT INTO configuration VALUES
(NULL, 'BOXLESS_CHECKOUT', 'true', 333, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_AJAX_STAT', 'true', 333, 2, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_AJAX_PRODUCTS', 'false', 333, 3, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_SHOW_SHIPPING_MODULES', 'true', 333, 5, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_SHOW_SHIPPING_ADDRESS', 'true', 333, 6, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_SHOW_PAYMENT_MODULES', 'true', 333, 7, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_SHOW_PAYMENT_ADDRESS', 'true', 333, 8, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_SHOW_COMMENTS', 'true', 333, 9, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_SHOW_PRODUCTS', 'true', 333, 10, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_SHOW_AGB', 'true', 333, 11, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_CHECKBOX_AGB', 'true', 333, 12, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'DISPLAY_CONDITIONS_ON_CHECKOUT', 'true',333, 13, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_SHOW_REVOCATION', 'true', 333, 14, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_CHECKBOX_REVOCATION', 'true', 333, 15, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'DISPLAY_REVOCATION_ON_CHECKOUT', 'true', 333, 16, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'REVOCATION_ID', '10', 333, 17, NULL, NOW(), NULL, NULL),
(NULL, 'DISPLAY_WIDERRUFSRECHT_ON_CHECKOUT', 'true', 333, 18, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_CHECKBOX_DSG', 'false', 333, 19, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CHECKOUT_SHOW_DSG', 'false', 333, 20, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'DISPLAY_DATENSCHUTZ_ON_CHECKOUT', 'false', 333, 21, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'SHOW_IP_LOG', 'false',333, 22, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'), ");

INSERT INTO configuration VALUES (NULL, 'CHECKOUT_SHOW_SHIPPING', 'false',333, 23, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'), ");
INSERT INTO configuration VALUES (NULL, 'CHECKOUT_SHOW_SHIPPING_ID', '13', 333, 24, NULL, NOW(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'CHECKOUT_SHOW_DESCRIPTION', 'true',333, 25, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'), ");
INSERT INTO configuration VALUES (NULL, 'CHECKOUT_SHOW_DESCRIPTION_LENG', '250', 333, 26, NULL, NOW(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'PAYPAL_EXPRESS_INFOID', '14', 333, 27, NULL, NOW(), NULL, NULL);


INSERT INTO configuration VALUES
(NULL, 'LOGIN_SAFE', 'true', 363, 2, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'LOGIN_NUM', '3', 363, 3, NULL, NOW(), NULL, NULL),
(NULL, 'LOGIN_TIME', '300', 363, 4, NULL, NOW(), NULL, NULL);

INSERT INTO configuration VALUES
(NULL, 'ANTISPAM_REVIEWS', 'true', 363, 5, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ANTISPAM_BLOG', 'false', 363, 6, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ANTISPAM_ASKQUESTION', 'true', 363, 7, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ANTISPAM_CONTACT', 'true', 363, 8, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ANTISPAM_NEWSLETTER', 'true', 363, 9, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ANTISPAM_PASSWORD', 'true', 363, 10, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ACCOUNT_PASSWORD_SECURITY', 'false', 363, 12, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");




INSERT INTO configuration VALUES
(NULL, 'RCS_BASE_DAYS', '30', 33, 10, NULL, NOW(), '', ''),
(NULL, 'RCS_REPORT_DAYS', '90', 33, 15, NULL, NOW(), '', ''),
(NULL, 'RCS_EMAIL_TTL', '90', 33, 20, NULL, NOW(), '', ''),
(NULL, 'RCS_EMAIL_FRIENDLY', 'true', 33, 30, NULL, NOW(), '', "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'RCS_EMAIL_COPIES_TO', '', 33, 35, NULL, NOW(), '', ''),
(NULL, 'RCS_SHOW_ATTRIBUTES', 'false', 33, 40, NULL, NOW(), '', "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'RCS_CHECK_SESSIONS', 'false', 33, 40, NULL, NOW(), '', "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'RCS_CURCUST_COLOR', '0000FF', 33, 50, NULL, NOW(), '', ''),
(NULL, 'RCS_UNCONTACTED_COLOR', '9FFF9F', 33, 60, NULL, NOW(), '', ''),
(NULL, 'RCS_CONTACTED_COLOR', 'FF9F9F', 33, 70, NULL, NOW(), '', ''),
(NULL, 'RCS_MATCHED_ORDER_COLOR', '9FFFFF', 33, 72, NULL, NOW(), '', ''),
(NULL, 'RCS_SKIP_MATCHED_CARTS', 'true', 33, 80, NULL, NOW(), '', "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'RCS_AUTO_CHECK', 'true', 33, 82, NULL, NOW(), '', "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'RCS_CARTS_MATCH_ALL_DATES', 'true', 33, 84, NULL, NOW(), '', "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'RCS_PENDING_SALE_STATUS', '1', 33, 85, NULL, NOW(), 'xtc_get_order_status_name', 'xtc_cfg_pull_down_order_statuses('),
(NULL, 'RCS_REPORT_EVEN_STYLE', 'dataTableRow', 33, 90, NULL, NOW(), '', ''),
(NULL, 'RCS_REPORT_ODD_STYLE', '', 33, 92, NULL, NOW(), '', ''),
(NULL, 'RCS_SHOW_BRUTTO_PRICE', 'true', 33, 94, NULL, NOW(), '', "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'DEFAULT_RCS_SHIPPING', '', 33, 95, NULL, NOW(), '', ''),(NULL, 'DEFAULT_RCS_PAYMENT', '', 33, 96, NULL, NOW(), '', ''),
(NULL, 'RCS_DELETE_COMPLETED_ORDERS', 'true', 33, 97, NULL, NOW(), '', "xtc_cfg_select_option(array('true', 'false'),");

#configuration_group_id 155, cSEO Config
INSERT INTO configuration VALUES 
(NULL, 'PDF_IN_ODERMAIL', 'false', 155, 5, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PDF_IN_ORDERMAIL_COID', '3', 155, 6, NULL, NOW(), NULL, ''),
(NULL, 'DOWN_FOR_MAINTENANCE', 'false', 155, 7, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'IMAGE_NAME_CATEGORIE', 'c_name', 155, 8, NULL, NOW(), NULL, "xtc_cfg_select_option(array('c_id', 'c_name', 'c_image'),"),
(NULL, 'IMAGE_NAME_PRODUCT', 'p_name', 155, 9, NULL, NOW(), NULL, "xtc_cfg_select_option(array('p_id', 'p_name', 'p_image'),");


#configuration_group_id 156, Trusted Shops
INSERT INTO configuration VALUES 
(NULL, 'TRUSTED_SHOP_STATUS', 'false', 156, 1, NULL, NOW(), NULL,"xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'TRUSTED_SHOP_NR', '0', 156, 2, NULL, NOW(), NULL,''),
(NULL, 'TRUSTED_SHOP_CREATE_ACCOUNT_DS', 'true', 156, 3, NULL, NOW(), NULL,"xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'TRUSTED_SHOP_PASSWORD_EMAIL', 'true', 156, 4, NULL, NOW(), NULL,"xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'TRUSTED_SHOP_IP_LOG', 'true', 156, 5, NULL, NOW(), NULL,"xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'TRUSTED_SHOP_TEMPLATE', 'logo_text_vertikal_weiss.html', 156, 10, NULL, NOW(), NULL,"xtc_cfg_pull_down_trusted_shop_template(");

#configuration_group_id 361, Google Analytics
INSERT INTO configuration VALUES 
(NULL, 'GOOGLE_ANAL_ON', 'false', 361, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'GOOGLE_ANONYM_ON', 'false', 361, 2, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'GOOGLE_ANAL_CODE', '', 361, 3, NULL, NOW(), NULL, NULL);

INSERT INTO configuration VALUES 
(NULL, 'ETRACKER_ON', 'false', 361, 4, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'ETRACKER_CODE', '', 361, 5, NULL, NOW(), NULL, NULL);


INSERT INTO configuration VALUES (NULL, 'TRACKING_PIWIK_ACTIVE', 'false', 361, 6, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'TRACKING_PIWIK_LOCAL_PATH', 'www.domain.de/piwik/', 361, 7, NULL, NOW(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'TRACKING_PIWIK_LOCAL_SSL_PATH', '', 361, 8, NULL, NOW(), NULL, NULL);
INSERT INTO configuration VALUES (NULL, 'TRACKING_PIWIK_ID', '1', 361, 9, NULL, NOW(), NULL, NULL);



#configuration_group_id 1000 Startseiteneinstellung
INSERT INTO configuration VALUES 
(NULL, 'DISPLAY_NEW_PRODUCTS_SLIDE', 'false', 1000, 3, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'), "),
(NULL, 'CATEGORY_LISTING_START', 'false', 1000, 4, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CATEGORY_LISTING_START_HEAD', 'true', 1000, 5, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CATEGORY_LISTING_START_PICTURE', 'true', 1000, 6, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'CATEGORY_LISTING_START_DESCR', 'true', 1000, 7, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'UPCOMING_PRODUCTS_START', 'true', 1000, 12, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'RANDOM_PRODUCTS_START', 'true', 1000, 13, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'RANDOM_SPECIALS_START', 'true', 1000, 14, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'BLOG_START', 'true', 1000, 15, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'MODULE_PRODUCT_PROMOTION_STATUS', 'true', 1000, 16, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'), ");

#configuration_group_id 1001, Twitterbox ab 2.1
INSERT INTO configuration VALUES 
(NULL, 'TWITTERBOX_STATUS', 'false', 1001, 5, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'TWITTER_ACCOUNT', 'commerce_SEO', 1001, 6, NULL, NOW(), NULL, NULL),
(NULL, 'TWITTER_SCROLLBAR', 'false', 1001, 7, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'TWITTER_LOOP', 'true', 1001, 8, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'TWITTER_LIVE', 'true', 1001, 9, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'TWITTER_HASHTAGS', 'true', 1001, 10, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'TWITTER_TIMESTAMP', 'true', 1001, 11, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'TWITTER_AVATARS', 'false', 1001, 12, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'TWITTER_BEHAVIOR', 'all', 1001, 13, NULL, NOW(), NULL, NULL),
(NULL, 'TWITTER_SHELL_BACKGROUND', '#b8b8b8', 1001, 14, NULL, NOW(), NULL, NULL),
(NULL, 'TWITTER_SHELL_COLOR', '#ffffff', 1001, 15, NULL, NOW(), NULL, NULL),
(NULL, 'TWITTER_TWEETS_BACKGROUND', '#ffffff', 1001, 16, NULL, NOW(), NULL, NULL),
(NULL, 'TWITTER_TWEETS_COLOR', '#141414', 1001, 17, NULL, NOW(), NULL, NULL),
(NULL, 'TWITTER_TWEETS_LINKS', '#0f07eb', 1001, 18, NULL, NOW(), NULL, NULL),
(NULL, 'TWITTER_BOX_WIDTH', 'auto', 1001, 19, NULL, NOW(), NULL, NULL),
(NULL, 'TWITTER_BOX_HEIGHT', '190', 1001, 20, NULL, NOW(), NULL, NULL),
(NULL, 'TWITTER_BOX_INTERVAL', '6000', 1001, 21, NULL, NOW(), NULL, NULL);

#configuration_group_id 1002, Produktdetails ab 2.1
INSERT INTO configuration VALUES 
(NULL, 'PRODUCT_DETAILS_MODELLNR', 'true', 1002, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_MANUFACTURERS_MODELLNR', 'false', 1002, 2, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_SHIPPINGTIME', 'true', 1002, 3, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_STOCK', 'true', 1002, 4, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_EAN', 'true', 1002, 5, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_VPE', 'true', 1002, 6, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_WEIGHT', 'true', 1002, 7, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_PRINT', 'true', 1002, 8, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_WISHLIST', 'true', 1002, 9, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_ASKQUESTION', 'true', 1002, 10, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_TAB_DESCRIPTION', 'true', 1002, 11, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_TAB_ACCESSORIES', 'true', 1002, 12, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_TAB_PARAMETERS', 'true', 1002, 13, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_TAB_REVIEWS', 'true', 1002, 14, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_TAB_CROSS_SELLING', 'true', 1002, 15, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_TAB_MEDIA', 'true', 1002, 16, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_TAB_ALSO_PURCHASED', 'true', 1002, 17, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_TAB_REVERSE_CROSS_SELLING', 'true', 1002, 18, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_TAB_ADD', 'true', 1002, 19, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_TAB_ADD_CONTENT_GROUP_ID', '', 1002, 20, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_DETAILS_TAB_PRODUCT', 'true', 1002, 21, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_TAB_MANUFACTURERS', 'false', 1002, 22, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_TAGS', 'true', 1002, 23, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_SOCIAL', 'true', 1002, 24, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_DETAILS_RELATED_CAT', 'true', 1002, 25, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),"),
(NULL, 'PRODUCT_GOOGLE_STANDARD_TAXONOMIE', '', 1002, 28, NULL, NOW(), NULL, NULL),
(NULL, 'PRODUCT_INFO_QR', 'false', 1002, 29, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'PRODUCT_DETAILS_TAB_SHORT_DESCRIPTION', 'false', 1002, 11, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'PRODUCT_DETAILS_SPECIALS_COUNTER', 'false', 1002, 30, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");




INSERT INTO configuration_group VALUES 
('1', 'Mein Shop', 'Generelle Einstellungen für den Shop', '1', '1'),
('2', 'Minimum Werte', 'The minimum VALUES for functions / data', '2', '1'),
('3', 'Maximum Werte', 'The maximum VALUES for functions / data', '3', '1'),
('4', 'Bilder', 'Image parameters', '4', '1'),
('5', 'Kunden Details', 'Customer account configuration', '5', '1'),
('6', 'Modul Optionen', 'Hidden from configuration', '6', '0'),
('7', 'Verpackung/Versand', 'Shipping options available at my store', '7', '1'),
('8', 'Product Listing', 'Product Listing configuration options', '8', '1'),
('9', 'Lagerverwaltung', 'Stock configuration options', '9', '1'),
('10', 'Logging', 'Logging configuration options', '10', '1'),
('11', 'Cache', 'Caching configuration options', '11', '1'),
('12', 'Email Optionen', 'General setting for E-Mail transport and HTML E-Mails', '12', '1'),
('13', 'Download', 'Downloadable products options', '13', '1'),
('14', 'GZip Compression', 'GZip compression options', '14', '1'),
('15', 'Sessions', 'Session options', '15', '1'),
('16', 'Meta-Tags/Suchmaschinen', 'Meta-tags/Search engines', '16', '1'),
('18', 'Ust ID', 'Vat ID', '18', '1'),
('19', 'Google Conversion', 'Google Conversion-Tracking', '19', '1'),
('20', 'Import/Export', 'Import/Export', '20', '1'),
('21', 'Afterbuy', 'Afterbuy.de', '21', '1'),
('22', 'Suchoptionen', 'Additional Options for search function', '22', '1'),
('23', 'CSS Buttons', 'Einstellungen für die CSS Buttons', '23', '1'),
('33', 'Recover Cart Sales', 'Recover Cart Sales (RCS) Configuration Values', '33', '1'),
('25', 'PayPal', 'PayPal', '25', '1'),
('156', 'Trusted Shop Box', 'Einstellungen für die Template Box + ShopID', '156', '1'),
('155', 'commerce:SEO', 'Einstellungen für das Template', '155', '1'),
('360', 'Mail Anhänge', 'Mail Anhang Optionen', '360', '1'),
('361', 'Google Analytics', 'Google Analytics Options', '361', '1'),
('363', 'Security', 'Security Config', '363', '1'),
('1000', 'CSEO Config', 'CSEO Config', '1000', '1'),
('1001', 'Twitter Config', 'Twitter Config', '1001', '1'),
('1002', 'Produkt-Einstellung', 'Produkt-Einstellung', '1002', '1');

INSERT INTO currencies VALUES (1,'Euro','EUR','','EUR',',','.','2','1.0000', now());

INSERT INTO languages VALUES (1,'English','en','icon.gif', 'english', 2, 'utf-8', '0', '1');
INSERT INTO languages VALUES (2,'Deutsch','de','icon.gif', 'german', 1, 'utf-8', '1', '1');

INSERT INTO orders_status VALUES ( '1', '1', 'Pending'), ( '2', '1', 'Processing'), ( '3', '1', 'Delivered');
INSERT INTO orders_status VALUES ( '1', '2', 'Offen'), ( '2', '2', 'In Bearbeitung'), ( '3', '2', 'Versendet');


INSERT INTO commerce_seo_url_names VALUES
('', 'FILENAME_ACCOUNT', 'account.php'),
('', 'FILENAME_CHECKOUT_SHIPPING', 'checkout_shipping.php'),
('', 'FILENAME_CHECKOUT', 'checkout.php'),
('', 'FILENAME_SHOPPING_CART', 'shopping_cart.php'),
('', 'FILENAME_SPECIALS', 'specials.php'),
('', 'FILENAME_PRODUCTS_NEW', 'products_new.php'),
('', 'FILENAME_ADVANCED_SEARCH', 'advanced_search.php'),
('', 'FILENAME_LOGIN', 'login.php'),
('', 'FILENAME_LOGOFF', 'logoff.php'),
('', 'FILENAME_PASSWORD_DOUBLE_OPT', 'password_double_opt.php'),
('', 'FILENAME_WISH_LIST', 'wish_list.php'),
('', 'FILENAME_NEWSLETTER', 'newsletter.php'),
('', 'FILENAME_ACCOUNT_EDIT', 'account_edit.php'),
('', 'FILENAME_ADDRESS_BOOK', 'address_book.php'),
('', 'FILENAME_CHECKOUT_CONFIRMATION', 'checkout_confirmation.php'),
('', 'FILENAME_CHECKOUT_PAYMENT', 'checkout_payment.php'),
('', 'FILENAME_CHECKOUT_PAYMENT_ADDRESS', 'checkout_payment_address.php'),
('', 'FILENAME_CHECKOUT_SHIPPING_ADDRESS', 'checkout_shipping_address.php'),
('', 'FILENAME_CHECKOUT_SUCCESS', 'checkout_success.php'),
('', 'FILENAME_CREATE_ACCOUNT', 'create_account.php'),
('', 'FILENAME_DOWNLOAD', 'download.php'),
('', 'FILENAME_PRINT_PDF', 'print_pdf.php'),
('', 'FILENAME_POPUP_CONTENT', 'popup_content.php'),
('', 'FILENAME_REVIEWS', 'reviews.php'),
('', 'FILENAME_POPUP_SEARCH_HELP', 'popup_search_help.php'),
('', 'FILENAME_PRODUCT_REVIEWS', 'product_reviews.php'),
('', 'FILENAME_PRODUCT_REVIEWS_INFO', 'product_reviews_info.php'),
('', 'FILENAME_PRODUCT_REVIEWS_WRITE', 'product_reviews_write.php'),
('', 'FILENAME_ACCOUNT_HISTORY', 'account_history.php'),
('', 'FILENAME_PRINT_PRODUCT_INFO', 'print_product_info.php');



INSERT INTO blog_settings VALUES (NULL, 'comments', 'nein');
INSERT INTO blog_settings VALUES (NULL, 'register_user', 'ja');
INSERT INTO blog_settings VALUES (NULL, 'session_rate', 'ja');


INSERT INTO boxes VALUES ('', 'admin', 'admin', 1, 1, 'file', 0);

INSERT INTO boxes VALUES ('', 'loginbox', 'login', 1, 1, 'file', 0);

INSERT INTO boxes VALUES ('', 'shopping_cart', 'nav', 1, 1, 'file', 0);
INSERT INTO boxes VALUES ('', 'categories_0', 'nav', 2, 1, 'file', 0);
INSERT INTO boxes VALUES ('', 'categories_1', 'nav', 3, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'categories_2', 'nav', 4, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'categories_3', 'nav', 5, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'categories_4', 'nav', 6, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'categories_5', 'nav', 7, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'categories_6', 'nav', 8, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'categories_7', 'nav', 9, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'categories_8', 'nav', 10, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'categories_9', 'nav', 11, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'categories_10', 'nav', 12, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'categories_11', 'nav', 13, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'whats_new', 'nav', 2, 14, 'file', 0);

INSERT INTO boxes VALUES ('', 'add_a_quickie', 'boxen', 1, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'last_viewed', 'boxen', 2, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'blog', 'boxen', 3, 0, 'file', 0);
INSERT INTO boxes VALUES ('' , 'product_filter', 'boxen', 4, 0, 'file', 0);
INSERT INTO boxes VALUES ('' , 'filter', 'boxen', 5, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'manufacturers', 'boxen', 6, 1, 'file', 0);
INSERT INTO boxes VALUES ('', 'manufacturers_info', 'boxen', 7, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'best_sellers', 'boxen', 8, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'infobox', 'boxen', 9, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'newsletter', 'boxen', 10, 1, 'file', 0);
INSERT INTO boxes VALUES ('', 'specials', 'boxen', 11, 1, 'file', 0);
INSERT INTO boxes VALUES ('', 'order_history', 'boxen', 12, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'currencies', 'boxen', 13, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'languages', 'boxen', 14, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'news_ticker', 'boxen', 15, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'information', 'boxen', 16, 1, 'file', 0);
INSERT INTO boxes VALUES ('' , 'cross_selling', 'boxen', 17, 1, 'file', 0);
INSERT INTO boxes VALUES ('', 'trusted_shop', 'boxen', 18, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'tagcloud', 'boxen', 19, 1, 'file', 0);
INSERT INTO boxes VALUES ('', 'social_bookmarks', 'boxen', 20, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'reviews', 'boxen', 21, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'twitterbox', 'boxen', 22, 0, 'file', 0);
INSERT INTO boxes VALUES ('', 'content', 'footer', 1, 1, 'file', 0);
INSERT INTO boxes VALUES ('', 'searchhead', 'nav_search', 1, 1, 'file', 0);

INSERT INTO boxes_positions VALUES ('', 'login');
INSERT INTO boxes_positions VALUES ('', 'admin');
INSERT INTO boxes_positions VALUES ('', 'nav');
INSERT INTO boxes_positions VALUES ('', 'boxen');
INSERT INTO boxes_positions VALUES ('', 'footer');
INSERT INTO boxes_positions VALUES ('', 'nav_search');
INSERT INTO boxes_positions VALUES ('', 'unten');

INSERT INTO boxes_names VALUES ('', 'categories_0', 'Categories', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'categories_1', 'Categories1', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'categories_2', 'Categories2', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'categories_3', 'Categories3', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'categories_4', 'Categories4', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'categories_5', 'Categories5', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'categories_6', 'Categories6', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'categories_7', 'Categories7', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'categories_8', 'Categories8', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'categories_9', 'Categories9', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'categories_10', 'Categories10', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'categories_11', 'Categories11', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'add_a_quickie', 'Add a Quickie', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'admin', 'Admin', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'best_sellers', 'Bestseller', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'shopping_cart', 'Cart', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'content', 'more about...', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'currencies', 'currencies', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'newsletter', 'newsletter', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'information', 'information', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'last_viewed', 'last viewed', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'languages', 'languages', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'loginbox', 'login', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'manufacturers', 'manufacturers', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'manufacturers_info', 'manufacturers info', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'order_history', 'order history', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'reviews', 'reviews', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'specials', 'specials', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'twitterbox', 'twitterbox', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'whats_new', 'whats new', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'tagcloud', 'tagcloud', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'news_ticker', 'news ticker', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'infobox', 'infobox', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'social_bookmarks', 'social bookmarks', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'trusted_shop', 'Trusted Shops', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'blog', 'Blog', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'searchhead', 'searchhead', '', 1, 0);
INSERT INTO boxes_names VALUES ('', 'product_filter', 'Product Filter', '', 1, 1);
INSERT INTO boxes_names VALUES ('', 'cross_selling', 'cross selling', '', 1, 1);
INSERT INTO boxes_names VALUES ('' , 'filter', 'Filter', '', 1, 0);


INSERT INTO boxes_names VALUES ('', 'categories_0', 'Kategorien', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'categories_1', 'Kategorie1', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'categories_2', 'Kategorie2', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'categories_3', 'Kategorie3', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'categories_4', 'Kategorie4', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'categories_5', 'Kategorie5', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'categories_6', 'Kategorie6', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'categories_7', 'Kategorie7', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'categories_8', 'Kategorie8', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'categories_9', 'Kategorie9', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'categories_10', 'Kategorie10', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'categories_11', 'Kategorie11', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'add_a_quickie', 'Schnellkauf', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'admin', 'Adminbox', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'best_sellers', 'Bestseller', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'shopping_cart', 'Warenkorb', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'content', 'Mehr über...', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'currencies', 'Währungen', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'newsletter', 'Newsletter', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'information', 'Informationen', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'last_viewed', 'Zuletzt angesehen', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'languages', 'andere Sprachen', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'loginbox', 'Login', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'manufacturers', 'Hersteller', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'manufacturers_info', 'Infos zum Hersteller', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'order_history', 'Bestellübersicht', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'reviews', 'Bewertungen', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'specials', 'Angebote', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'twitterbox', 'Wir bei Twitter', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'whats_new', 'Neue Artikel', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'tagcloud', 'Wortwolke', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'news_ticker', 'News Ticker', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'infobox', 'Kundengruppe', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'social_bookmarks', 'Social Bookmarks', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'trusted_shop', 'Trusted Shops', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'blog', 'Shop-Blog', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'searchhead', 'Header Suche', '', 2, 0);
INSERT INTO boxes_names VALUES ('', 'product_filter', 'Produkt Filter', '', 2, 1);
INSERT INTO boxes_names VALUES ('', 'cross_selling', 'Passende Produkte', '', 2, 1);
INSERT INTO boxes_names VALUES ('' , 'filter', 'Multi Filter', '', 2, 0);



INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','1','TEXT_PDF_HEADER','Shopname and Slogan','input');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','1','TEXT_PDF_ANSCHRIFT','Address:\r\nMax Mustermann\r\nStrasse 12\r\n12345 Stadt\r\nDeutschland','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','1','TEXT_PDF_KONTAKT','Contact:\r\ninfo@AdresseDesShops.de','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','1','TEXT_PDF_BANK','Bankverbindung:\r\nInhaber: Max Mustermann\r\nKonto: 123456789 BLZ: 250 501 10\r\nBank: Deutsche Bank BIC/Swift: XXXXXXX\r\nIBAN: XXXXXXX','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','1','TEXT_PDF_GESCHAEFT','Owner:\r\nMax Mustermann\r\nUSt.IdNr.: DE12356789','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','1','TEXT_PDF_SHOPADRESSEKLEIN','AdresseDesShops.de - Max Mustermann - Strasse 12, 12345 Stadt','input');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','1','TEXT_PDF_DANKE_MANN','Sehr geehrter Herr %s,\r\nwir freuen uns, dass Sie bei XXXX bestellt haben.','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','1','TEXT_PDF_DANKE_FRAU','Sehr geehrte Frau %s,\r\nwir freuen uns, dass Sie bei XXXX bestellt haben.','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','1','TEXT_PDF_DANKE_UNISEX','Sehr geehrter Kunde / sehr geehrte Kundin,\r\nwir freuen uns, dass Sie bei XXXX bestellt haben.','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','1','TEXT_PDF_SCHLUSSTEXT','Vielen Dank für Ihren Auftrag!\r\n\r\nBesuchen Sie uns wieder unter XXXX!\r\n\r\n\r\nLeistungsdatum entspricht Rechnungsdatum.\r\nEs gelten unsere Allgemeine Geschäfts- und Lieferbedingungen.','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','1','TEXT_PDF_FILE_NAME','Rechnung_Nr#rn#','input');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','1','TEXT_PDF_DELIVERY_SCHLUSSTEXT','Vielen Dank für Ihren Auftrag. Ihre Ware wurde mit #vm# versendet.','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','1','TEXT_PDF_DELIVERY_FILE_NAME','Lieferschein_#bn#_#vn#_#nn#_#d#','input');


INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','2','TEXT_PDF_HEADER','Shopname und kurzer Slogan','input');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','2','TEXT_PDF_ANSCHRIFT','Anschrift:\r\nMax Mustermann\r\nStrasse 12\r\n12345 Stadt\r\nDeutschland','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','2','TEXT_PDF_KONTAKT','Kontakt:\r\ninfo@AdresseDesShops.de','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','2','TEXT_PDF_BANK','Bankverbindung:\r\nInhaber: Max Mustermann\r\nKonto: 123456789 BLZ: 250 501 10\r\nBank: Deutsche Bank BIC/Swift: XXXXXXX\r\nIBAN: XXXXXXX','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','2','TEXT_PDF_GESCHAEFT','Inhaber:\r\nMax Mustermann\r\nUSt.IdNr.: DE12356789','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','2','TEXT_PDF_SHOPADRESSEKLEIN','AdresseDesShops.de - Max Mustermann - Strasse 12, 12345 Stadt','input');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','2','TEXT_PDF_DANKE_MANN','Sehr geehrter Herr %s,\r\nwir freuen uns, dass Sie bei XXXX bestellt haben.','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','2','TEXT_PDF_DANKE_FRAU','Sehr geehrte Frau %s,\r\nwir freuen uns, dass Sie bei XXXX bestellt haben.','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','2','TEXT_PDF_DANKE_UNISEX','Sehr geehrter Kunde / sehr geehrte Kundin,\r\nwir freuen uns, dass Sie bei XXXX bestellt haben.','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','2','TEXT_PDF_SCHLUSSTEXT','Vielen Dank für Ihren Auftrag!\r\n\r\nBesuchen Sie uns wieder unter XXXX!\r\n\r\n\r\nLeistungsdatum entspricht Rechnungsdatum.\r\nEs gelten unsere Allgemeine Geschäfts- und Lieferbedingungen.','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','2','TEXT_PDF_FILE_NAME','Rechnung_Nr#rn#','input');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','2','TEXT_PDF_DELIVERY_SCHLUSSTEXT','Vielen Dank für Ihren Auftrag. Ihre Ware wurde mit #vm# versendet.','textarea');
INSERT INTO orders_pdf_profile (id,languages_id,pdf_key,pdf_value,type) VALUES ('','2','TEXT_PDF_DELIVERY_FILE_NAME','Lieferschein_#bn#_#vn#_#nn#_#d#','input');


INSERT INTO emails VALUES(NULL, 'cart_mail', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Place order', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Gutschein</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;">\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Gutschein\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  {if $GENDER}\r\n  Dear{if $GENDER eq ''m''} Mr.\r\n  {elseif $GENDER eq ''f''} Mrs.\r\n  {else}(r) {$FIRSTNAME}\r\n  {/if} {$LASTNAME},\r\n  {else}\r\n  Welcome,\r\n  {/if}\r\n  \r\n  <p>{if $NEW == true}Thank you for visiting {$STORE_NAME} and have placed your trust towards us.\r\n  {else}Thanks again for your visit {$STORE_NAME} and you have placed us repeatedly against trust.{/if}</p>\r\n  \r\n  <p>We have seen that you have filled in your visit to our online shopping cart with the following articles, but have made the purchase not complete.</p>\r\n  \r\n  <p>View your shopping cart:</p>\r\n  <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="f1f1f1" class="outerTable">\r\n  <tr class="ProductsTable">\r\n    <td align="left" class="bb br">&nbsp;\r\n    \r\n    </td>\r\n    <td align="center" class="bb br">\r\n    <strong>Anzahl</strong>\r\n    </td>\r\n    <td align="right" class="bb">\r\n    <strong>Artikel</strong>\r\n    </td>\r\n   </tr>\r\n  {foreach name=outer item=product from=$products_data}\r\n   <tr>\r\n    <td valign="top" class="bb br ProductsName">\r\n    <img src="{$product.IMAGE}" alt="{$product.NAME}" />\r\n    </td>\r\n    <td valign="top" class="bb br ProductsName" align="center"><strong>{$product.QUANTITY} x</strong></td>\r\n    <td valign="top" class="bb" align="right">\r\n    <strong>{$product.NAME}</strong><br />\r\n    <em><a href="{$product.LINK}">{$product.LINK}</a></em>\r\n    </td>\r\n   </tr>\r\n  {/foreach}\r\n  </table><br />\r\n  <p>We are always keen to improve our service in the interest of our customers.\r\n  For this reason, it interests us, of course, what were the reasons for not shopping at this time {$STORE_NAME} to make.\r\n  We are very grateful if you inform us whether you had during your visit to our online shop problems or concerns to complete the purchase successfully.\r\n  Our goal is to you and other customers, shopping at {$STORE_NAME} is to make easier and better.</p><br />\r\n  \r\n  To complete your purchase now, they can log on here: <a href="{$LOGIN}">{$LOGIN}</a><br />\r\n  \r\n  <p>to improve Thanks again for your time and your help, the online shop of {$STORE_NAME}.</p>\r\n  \r\n  <p>Yours sincerely,</p>\r\n  \r\n  <p>Your team of <a href="{$STORE_LINK}">{$STORE_NAME}</a></p>\r\n  {if $MESSAGE}\r\n  <p>{$MESSAGE}</p>\r\n  {/if}\r\n </td>\r\n </tr>\r\n</table>', 'Sign up here: {$LOGIN}\r\n------------------------------------------------------\r\n{if $GENDER}Dear{if $GENDER eq ''m''} Mr.{elseif $GENDER eq ''f''} Mrs.{else}(r) {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Welcome,{/if}\r\n\r\n{if $NEW == true}Thank you for visiting {$STORE_NAME} and have placed your trust towards us.\r\n{else}Thanks again for your visit {$STORE_NAME} and you have placed us repeatedly against trust.{/if}\r\n\r\nWe have seen that you have filled in your visit to our online shopping cart with the following articles, but have made the purchase not complete.\r\n\r\nInhalt Ihres Warenkorbes:\r\n\r\n{foreach name=outer item=product from=$products_data}\r\n{$product.QUANTITY} x {$product.NAME}\r\n {$product.LINK}\r\n{/foreach}\r\n\r\nWe are always keen to improve our service in the interest of our customers.\r\nFor this reason, it interests us, of course, what were the reasons for not shopping at this time {$STORE_NAME} to make.\r\nWe are very grateful if you inform us whether you had during your visit to our online shop problems or concerns to complete the purchase successfully.\r\nOur goal is to you and other customers, shopping at {$STORE_NAME} is to make easier and better.\r\n\r\nto improve Thanks again for your time and your help, the online shop of {$STORE_NAME}.\r\n\r\nYours sincerely,\r\n\r\nYour team of {$STORE_NAME}\r\n{if $MESSAGE}\r\n\r\n{$MESSAGE}\r\n{/if}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Gutschein</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;">\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Gutschein\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  {if $GENDER}\r\n  Dear{if $GENDER eq ''m''} Mr.\r\n  {elseif $GENDER eq ''f''} Mrs.\r\n  {else}(r) {$FIRSTNAME}\r\n  {/if} {$LASTNAME},\r\n  {else}\r\n  Welcome,\r\n  {/if}\r\n  \r\n  <p>{if $NEW == true}Thank you for visiting {$STORE_NAME} and have placed your trust towards us.\r\n  {else}Thanks again for your visit {$STORE_NAME} and you have placed us repeatedly against trust.{/if}</p>\r\n  \r\n  <p>We have seen that you have filled in your visit to our online shopping cart with the following articles, but have made the purchase not complete.</p>\r\n  \r\n  <p>View your shopping cart:</p>\r\n  <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="f1f1f1" class="outerTable">\r\n  <tr class="ProductsTable">\r\n    <td align="left" class="bb br">&nbsp;\r\n    \r\n    </td>\r\n    <td align="center" class="bb br">\r\n    <strong>Anzahl</strong>\r\n    </td>\r\n    <td align="right" class="bb">\r\n    <strong>Artikel</strong>\r\n    </td>\r\n   </tr>\r\n  {foreach name=outer item=product from=$products_data}\r\n   <tr>\r\n    <td valign="top" class="bb br ProductsName">\r\n    <img src="{$product.IMAGE}" alt="{$product.NAME}" />\r\n    </td>\r\n    <td valign="top" class="bb br ProductsName" align="center"><strong>{$product.QUANTITY} x</strong></td>\r\n    <td valign="top" class="bb" align="right">\r\n    <strong>{$product.NAME}</strong><br />\r\n    <em><a href="{$product.LINK}">{$product.LINK}</a></em>\r\n    </td>\r\n   </tr>\r\n  {/foreach}\r\n  </table><br />\r\n  <p>We are always keen to improve our service in the interest of our customers.\r\n  For this reason, it interests us, of course, what were the reasons for not shopping at this time {$STORE_NAME} to make.\r\n  We are very grateful if you inform us whether you had during your visit to our online shop problems or concerns to complete the purchase successfully.\r\n  Our goal is to you and other customers, shopping at {$STORE_NAME} is to make easier and better.</p><br />\r\n  \r\n  To complete your purchase now, they can log on here: <a href="{$LOGIN}">{$LOGIN}</a><br />\r\n  \r\n  <p>to improve Thanks again for your time and your help, the online shop of {$STORE_NAME}.</p>\r\n  \r\n  <p>Yours sincerely,</p>\r\n  \r\n  <p>Your team of <a href="{$STORE_LINK}">{$STORE_NAME}</a></p>\r\n  {if $MESSAGE}\r\n  <p>{$MESSAGE}</p>\r\n  {/if}\r\n </td>\r\n </tr>\r\n</table>', 'Sign up here: {$LOGIN}\r\n------------------------------------------------------\r\n{if $GENDER}Dear{if $GENDER eq ''m''} Mr.{elseif $GENDER eq ''f''} Mrs.{else}(r) {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Welcome,{/if}\r\n\r\n{if $NEW == true}Thank you for visiting {$STORE_NAME} and have placed your trust towards us.\r\n{else}Thanks again for your visit {$STORE_NAME} and you have placed us repeatedly against trust.{/if}\r\n\r\nWe have seen that you have filled in your visit to our online shopping cart with the following articles, but have made the purchase not complete.\r\n\r\nInhalt Ihres Warenkorbes:\r\n\r\n{foreach name=outer item=product from=$products_data}\r\n{$product.QUANTITY} x {$product.NAME}\r\n {$product.LINK}\r\n{/foreach}\r\n\r\nWe are always keen to improve our service in the interest of our customers.\r\nFor this reason, it interests us, of course, what were the reasons for not shopping at this time {$STORE_NAME} to make.\r\nWe are very grateful if you inform us whether you had during your visit to our online shop problems or concerns to complete the purchase successfully.\r\nOur goal is to you and other customers, shopping at {$STORE_NAME} is to make easier and better.\r\n\r\nto improve Thanks again for your time and your help, the online shop of {$STORE_NAME}.\r\n\r\nYours sincerely,\r\n\r\nYour team of {$STORE_NAME}\r\n{if $MESSAGE}\r\n\r\n{$MESSAGE}\r\n{/if}', 1263483589);
INSERT INTO emails VALUES(NULL, 'change_order', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Order Update Nr: {$nr} of {$date}', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Order Status Change</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Order Status Change\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td><strong>Dear Customer, </strong><br>\r\n  <br>\r\n  The status of your order number:{$ORDER_NR} of {$ORDER_DATE} was changed.<br /> \r\n  {if $NOTIFY_COMMENTS}<br />\r\n   The comments for your order:<br />\r\n  {$NOTIFY_COMMENTS}<br />\r\n  {/if}\r\n  <br />\r\n  New status: <b>{$ORDER_STATUS}</b><br />\r\n  Click here to see the overview of your order:<br />\r\n  <a href="{$ORDER_LINK}">{$ORDER_LINK}</a><br /><br />\r\n  answer any questions about your order, please to this email.</td>\r\n </tr>\r\n</table>', 'Dear Customer,\r\n\r\nThe status of your order was changed.\r\n\r\n{if $NOTIFY_COMMENTS}The comments for your order:{$NOTIFY_COMMENTS}{/if}\r\n\r\nNew status: {$ORDER_STATUS}\r\n\r\nanswer any questions about your order, please to this email.', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Order Status Change</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Order Status Change\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td><strong>Dear Customer, </strong><br>\r\n  <br>\r\n  The status of your order number:{$ORDER_NR} of {$ORDER_DATE} was changed.<br /> \r\n  {if $NOTIFY_COMMENTS}<br />\r\n   The comments for your order:<br />\r\n  {$NOTIFY_COMMENTS}<br />\r\n  {/if}\r\n  <br />\r\n  New status: <b>{$ORDER_STATUS}</b><br />\r\n  Click here to see the overview of your order:<br />\r\n  <a href="{$ORDER_LINK}">{$ORDER_LINK}</a><br /><br />\r\n  answer any questions about your order, please to this email.</td>\r\n </tr>\r\n</table>', 'Dear Customer,\r\n\r\nThe status of your order was changed.\r\n\r\n{if $NOTIFY_COMMENTS}The comments for your order:{$NOTIFY_COMMENTS}{/if}\r\n\r\nNew status: {$ORDER_STATUS}\r\n\r\nanswer any questions about your order, please to this email.', 1263483589);
INSERT INTO emails VALUES(NULL, 'change_password', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Change their password', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>neues Passwort</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td colspan="2">\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   new password\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td colspan="2">\r\n  <p><strong>Dear Customer,</strong></p>\r\n  <p>Your password was successfully changed.<br /><br />\r\n  Your new login details:</p>\r\n </td>\r\n </tr> \r\n <tr class="lightBackground">\r\n <td width="1">\r\n  <nobr><strong>Your email:</strong></nobr>\r\n </td>\r\n <td>\r\n  {$EMAIL}\r\n </td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td width="1">\r\n  <nobr><strong>Your new password:</strong></nobr>\r\n  </td>\r\n  <td>\r\n  {$PASSWORD}\r\n  </td>\r\n </tr>\r\n</table>', 'Dear customer,\r\n\r\nYour password was successfully changed.\r\n\r\nYour new login details:\r\n  \r\nYour Mail: {$EMAIL}\r\nYour new password: {$PASSWORD}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>neues Passwort</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td colspan="2">\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   new password\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td colspan="2">\r\n  <p><strong>Dear Customer,</strong></p>\r\n  <p>Your password was successfully changed.<br /><br />\r\n  Your new login details:</p>\r\n </td>\r\n </tr> \r\n <tr class="lightBackground">\r\n <td width="1">\r\n  <nobr><strong>Your email:</strong></nobr>\r\n </td>\r\n <td>\r\n  {$EMAIL}\r\n </td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td width="1">\r\n  <nobr><strong>Your new password:</strong></nobr>\r\n  </td>\r\n  <td>\r\n  {$PASSWORD}\r\n  </td>\r\n </tr>\r\n</table>', 'Dear customer,\r\n\r\nYour password was successfully changed.\r\n\r\nYour new login details:\r\n  \r\nYour Mail: {$EMAIL}\r\nYour new password: {$PASSWORD}', 1263483589);
INSERT INTO emails VALUES(NULL, 'contact', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Ask from {$store_name}', '', '', '', '', '', 1263483589);
INSERT INTO emails VALUES(NULL, 'create_account', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'confirmation of customer account', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Kontoeröffnung</title>\r\n{literal}\r\n<style type="text/css"> \r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Opening an account\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td><br />\r\n  <strong> Dear{if $GENDER ==''f''} Mrs. {$NNAME}{elseif $GENDER == ''m''} Mr.{$NNAME}{else} Customer{/if},</strong><br />\r\n  <br />\r\n  You have just created your account successfully with the following access:<br /><br />\r\n  <table width="100%" border="0" cellpadding="10" cellspacing="5" align="center" class="outerTable ">\r\n  <tr class="lightBackground">\r\n   <td width="1"><nobr>Your email address for shop application:</nobr></td>\r\n   <td>{$USERNAME4MAIL}</td>\r\n  </tr>\r\n  <tr class="lightBackground">\r\n   <td width="1"><nobr>The corresponding password:</nobr></td>\r\n   <td>{$PASSWORT4MAIL}</td>\r\n  </tr>\r\n  </table><br /><br />\r\n  As a registered user you have the following advantages in our shop.<br /><br />\r\n  <b>- Members Cart</b> - Each article will remain there until you proceed to checkout, or remove the products from the basket.<br />\r\n  <b>- Addressbook</b> - We can now deliver your products to another address you provide. The perfect way to send a birthday present.<br />\r\n  <b>- Previous Orders</b> - You can always review your previous orders. <br />\r\n <b> - opinions about products </b> - Share your opinion about products with our other customers.<br /><br />\r\n  \r\n  {if $SEND_GIFT==true}\r\n  As a little welcome gift we will send you a coupon: <b>{$GIFT_AMMOUNT}</b><br /><br />\r\n  Your personal coupon code is <b> {$GIFT_CODE}</b>. You can playing this credit at the cash register during the ordering process.<br /><br />\r\n  To redeem the coupon, please click on <a href="{$GIFT_LINK}">[Redeem Voucher]</a>.<br /><br />\r\n  {/if}\r\n  {if $SEND_COUPON==true}\r\n  As a little welcome gift we will send you a coupon.<br />\r\n  Coupon Description: <b>{$COUPON_DESC}</b><br />\r\n  Simply enter your personal code {$COUPON_CODE} during the payment process<br /><br />\r\n  {/if}\r\n  <br />\r\n  <em>If you have questions about our online services, contact us at: \r\n  <a href="mailto:{$MAIL_REPLY_ADDRESS}">{$MAIL_REPLY_ADDRESS}</a>.<br /><br />\r\n  Note: This email address was given to us by a customer. If you have not signed up, please send an email \r\n  <a href="mailto:{$MAIL_REPLY_ADDRESS}">{$MAIL_REPLY_ADDRESS}</a>.</em><br /><br />\r\n </td>\r\n </tr>\r\n</table>', 'Highly {if $GENDER ==''f''}Dear Miss {$NNAME}{elseif $GENDER == ''m''}Dear Mister {$NNAME}{else} Dear Customer{/if},\r\n  You have just created your account successfully with the following access:\r\n\r\n\r\nYour email address for shop application: {$USERNAME4MAIL}\r\n  \r\n \r\n The corresponding password: {$PASSWORT4MAIL}\r\n\r\n \r\n  As a registered user you have the following advantages in our shop.\r\n  - Members Cart - Each article will remain there until you proceed to checkout, or remove the products from the basket.\r\n  - Addressbook - We can now deliver your products to another address you provide. The perfect way to send a birthday present.\r\n  - Previous Orders - You can always review your previous orders. \r\n - opinions about products - Share your opinion about products with our other customers.\r\n  \r\n  {if $SEND_GIFT==true}\r\n  As a little welcome gift we will send you a coupon: {$GIFT_AMMOUNT}\r\n  Your personal coupon code is {$GIFT_CODE}. You can playing this credit at the cash register during the ordering process.\r\n  To redeem the coupon, please click on {$GIFT_LINK}.\r\n  {/if}\r\n  {if $SEND_COUPON==true}\r\n  As a little welcome gift we will send you a coupon.\r\n  Coupon Description: {$COUPON_DESC}\r\n  Simply enter your personal code {$COUPON_CODE} during the payment process\r\n  {/if}\r\n  \r\n  If you have questions about our online services, contact us at: \r\n  {$MAIL_REPLY_ADDRESS.\r\n  Note: This email address was given to us by a customer. If you have not signed up, please send an email \r\n  {$MAIL_REPLY_ADDRESS}.\r\n', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Kontoeröffnung</title>\r\n{literal}\r\n<style type="text/css"> \r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Opening an account\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td><br />\r\n  <strong> Dear{if $GENDER ==''f''} Mrs. {$NNAME}{elseif $GENDER == ''m''} Mr.{$NNAME}{else} Customer{/if},</strong><br />\r\n  <br />\r\n  You have just created your account successfully with the following access:<br /><br />\r\n  <table width="100%" border="0" cellpadding="10" cellspacing="5" align="center" class="outerTable ">\r\n  <tr class="lightBackground">\r\n   <td width="1"><nobr>Your email address for shop application:</nobr></td>\r\n   <td>{$USERNAME4MAIL}</td>\r\n  </tr>\r\n  <tr class="lightBackground">\r\n   <td width="1"><nobr>The corresponding password:</nobr></td>\r\n   <td>{$PASSWORT4MAIL}</td>\r\n  </tr>\r\n  </table><br /><br />\r\n  As a registered user you have the following advantages in our shop.<br /><br />\r\n  <b>- Members Cart</b> - Each article will remain there until you proceed to checkout, or remove the products from the basket.<br />\r\n  <b>- Addressbook</b> - We can now deliver your products to another address you provide. The perfect way to send a birthday present.<br />\r\n  <b>- Previous Orders</b> - You can always review your previous orders. <br />\r\n <b> - opinions about products </b> - Share your opinion about products with our other customers.<br /><br />\r\n  \r\n  {if $SEND_GIFT==true}\r\n  As a little welcome gift we will send you a coupon: <b>{$GIFT_AMMOUNT}</b><br /><br />\r\n  Your personal coupon code is <b> {$GIFT_CODE}</b>. You can playing this credit at the cash register during the ordering process.<br /><br />\r\n  To redeem the coupon, please click on <a href="{$GIFT_LINK}">[Redeem Voucher]</a>.<br /><br />\r\n  {/if}\r\n  {if $SEND_COUPON==true}\r\n  As a little welcome gift we will send you a coupon.<br />\r\n  Coupon Description: <b>{$COUPON_DESC}</b><br />\r\n  Simply enter your personal code {$COUPON_CODE} during the payment process<br /><br />\r\n  {/if}\r\n  <br />\r\n  <em>If you have questions about our online services, contact us at: \r\n  <a href="mailto:{$MAIL_REPLY_ADDRESS}">{$MAIL_REPLY_ADDRESS}</a>.<br /><br />\r\n  Note: This email address was given to us by a customer. If you have not signed up, please send an email \r\n  <a href="mailto:{$MAIL_REPLY_ADDRESS}">{$MAIL_REPLY_ADDRESS}</a>.</em><br /><br />\r\n </td>\r\n </tr>\r\n</table>', 'Highly {if $GENDER ==''f''}Dear Miss {$NNAME}{elseif $GENDER == ''m''}Dear Mister {$NNAME}{else} Dear Customer{/if},\r\n  You have just created your account successfully with the following access:\r\n\r\n\r\nYour email address for shop application: {$USERNAME4MAIL}\r\n  \r\n \r\n The corresponding password: {$PASSWORT4MAIL}\r\n\r\n \r\n  As a registered user you have the following advantages in our shop.\r\n  - Members Cart - Each article will remain there until you proceed to checkout, or remove the products from the basket.\r\n  - Addressbook - We can now deliver your products to another address you provide. The perfect way to send a birthday present.\r\n  - Previous Orders - You can always review your previous orders. \r\n - opinions about products - Share your opinion about products with our other customers.\r\n  \r\n  {if $SEND_GIFT==true}\r\n  As a little welcome gift we will send you a coupon: {$GIFT_AMMOUNT}\r\n  Your personal coupon code is {$GIFT_CODE}. You can playing this credit at the cash register during the ordering process.\r\n  To redeem the coupon, please click on {$GIFT_LINK}.\r\n  {/if}\r\n  {if $SEND_COUPON==true}\r\n  As a little welcome gift we will send you a coupon.\r\n  Coupon Description: {$COUPON_DESC}\r\n  Simply enter your personal code {$COUPON_CODE} during the payment process\r\n  {/if}\r\n  \r\n  If you have questions about our online services, contact us at: \r\n  {$MAIL_REPLY_ADDRESS.\r\n  Note: This email address was given to us by a customer. If you have not signed up, please send an email \r\n  {$MAIL_REPLY_ADDRESS}.\r\n', 1263483589);
INSERT INTO emails VALUES(NULL, 'create_account_admin', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Your new account', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Ihnen wurde ein Konto eröffnet</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr> \r\n <td><strong>Dear Customer, </strong><br />\r\n  <br />\r\n  It was set up an account for you, you can login with the following data in our shop. <br>\r\n  <br>\r\n  {if $COMMENTS} Notes: {$COMMENTS} <br>{/if}\r\n  <br>\r\n  <br>\r\n  Your login information for our shop:<br> \r\n  <br>\r\nEmail: \r\n{$EMAIL}\r\n<br />\r\nPassword: \r\n{$PASSWORD} \r\n  </td>\r\n </tr>\r\n</table>', 'Dear Customer, \r\n\r\nIt was set up an account for you, you can login with the following data in our shop.\r\n\r\n{if $COMMENTS} Notes: {$COMMENTS}{/if}\r\n\r\nYour login information for our shop:\r\n\r\nEmail:{$EMAIL}\r\n\r\nPassword:{$PASSWORD}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Ihnen wurde ein Konto eröffnet</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr> \r\n <td><strong>Dear Customer, </strong><br />\r\n  <br />\r\n  It was set up an account for you, you can login with the following data in our shop. <br>\r\n  <br>\r\n  {if $COMMENTS} Notes: {$COMMENTS} <br>{/if}\r\n  <br>\r\n  <br>\r\n  Your login information for our shop:<br> \r\n  <br>\r\nEmail: \r\n{$EMAIL}\r\n<br />\r\nPassword: \r\n{$PASSWORD} \r\n  </td>\r\n </tr>\r\n</table>', 'Dear Customer, \r\n\r\nIt was set up an account for you, you can login with the following data in our shop.\r\n\r\n{if $COMMENTS} Notes: {$COMMENTS}{/if}\r\n\r\nYour login information for our shop:\r\n\r\nEmail:{$EMAIL}\r\n\r\nPassword:{$PASSWORD}', 1263483589);
INSERT INTO emails VALUES(NULL, 'gift_accepted', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'gift accepted', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Voucher-Info</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr>\r\n <td><strong>Dear Customer,</strong><br /><br />\r\n  They have recently ordered from our online shop a voucher, which was not immediately released for security reasons.<br />\r\n  This credit is available available now. You can register your voucher and e-mail you ordered the voucher has a value of <strong>{$AMMOUNT}</strong>.\r\n  </td>\r\n </tr>\r\n</table>', 'Dear Customer,\r\n\r\nThey have recently ordered from our online store a coupon\r\nwhich was not immediately released for security reasons.\r\nThis credit is available available now.\r\nYou can register your voucher and e-mail you ordered the voucher has a value of {$AMMOUNT}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Voucher-Info</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr>\r\n <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">\r\n  <strong>Dear Customer,</strong></font> <br>\r\n  <br>\r\n  <font size="2" face="Verdana, Arial, Helvetica, sans-serif">They have recently ordered from our online shop a voucher, which was not immediately released for security reasons. This credit is available available now. You can register your voucher and e-mail you ordered the voucher has a value of\r\n  {$AMMOUNT}\r\n  </font></td>\r\n </tr>\r\n</table>', 'Dear Customer,\r\n\r\nThey have recently ordered from our online store a coupon\r\nwhich was not immediately released for security reasons.\r\nThis credit is available available now.\r\nYou can register your voucher and e-mail you ordered the voucher has a value of {$AMMOUNT}', 1263483589);
INSERT INTO emails VALUES(NULL, 'newsletter', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', '', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Newsletter</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {\r\n font-size:11.5px;\r\n font-family:Helvetica, sans-serif;\r\n color:#444\r\n}\r\ntable.outerTable {\r\n border: 1px solid #ccc\r\n}\r\ntd.TopRightDesc {\r\n letter-spacing: 1px;\r\n font-weight: 600\r\n}\r\n.ProductsTable td {\r\n color:#6d88b1;\r\n background: #f1f1f1\r\n}\r\n.ProductsAttributes td, .ProductsName {\r\n background: #ffffff\r\n}\r\n.bt {\r\n border-top:1px solid #ccc\r\n}\r\n.bb {\r\n border-bottom:1px solid #ccc\r\n}\r\n.bl {\r\n border-left:1px solid #ccc\r\n}\r\n.br {\r\n border-right:1px solid #ccc\r\n}\r\n.fs85 {\r\n font-size:85%\r\n}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n <td width="50%"><img src="{$logo_path}logo.gif" alt="" /> </td>\r\n <td width="50%" class="TopRightDesc" align="right"> Newsletter </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <div style="width:95%; background-color:#fff; padding:10px;">\r\n <h2 style="border-bottom:2px solid #6a0101; padding-bottom:10px; color:#333;">{$SHOP_NAME} Newsletter</h2>\r\n <p><strong> {if $personalize == ''yes'' && $greeting_type == ''0''} {if $customers_gender == ''f''} Dear Mrs.{$customers_name}, {else} Dear Mr. {$customers_name}, {/if} {/if} {if $personalize == ''yes'' && $greeting_type == ''1''} Welcome {$customers_name}, {/if} {if $personalize == ''''} Dear Customer, {/if} </strong></p>\r\n <p>{$body}</p>\r\n {if $gift_id}\r\n {if $greeting_type == ''1''}\r\n <table width="100%" style="border:1px #CCC; padding:10px; margin-bottom:15px; background-color:#ffeded;">\r\n <tr>\r\n <td><p style="padding-bottom:7px; margin:0 0 10px 0;"><strong style="font-family: Georgia, Times New Roman, Times, serif; font-size:12px;"><span id="result_box3" lang="en" xml:lang="en">voucher</span>:</strong></p>\r\n  <span id="result_box" lang="en" xml:lang="en">We will send you a small gift of a voucher in the amount of</span> <b>{$gift_ammount}</b>. <br />\r\n  <span id="result_box2" lang="en" xml:lang="en">Just give when ordering your personal coupon code</span>: <b>{$gift_id}</b></td>\r\n </tr>\r\n </table>\r\n {else}\r\n <table width="100%" style="border:1px #CCC; padding:10px; margin-bottom:15px; background-color:#ffeded;">\r\n <tr>\r\n <td><p style="padding-bottom:7px; margin:0 0 10px 0;"><strong style="font-family: Georgia, Times New Roman, Times, serif; font-size:12px;"><span id="result_box4" lang="en" xml:lang="en">voucher</span>:</strong></p>\r\n  <span id="result_box5" lang="en" xml:lang="en">We will send you a small gift of a voucher in the amount of</span> <b>{$gift_ammount}</b>. <br />\r\n  <span id="result_box6" lang="en" xml:lang="en">Just specify when ordering your personal coupon code</span>: <b>{$gift_id}</b></td>\r\n </tr>\r\n </table>\r\n {/if}\r\n {/if}\r\n <div style="background:#fff;">\r\n <table width="100%" cellpadding="0" cellspacing="0" border="0">\r\n <tr> <td>\r\n {foreach name=aussen item=module_data from=$module_content}\r\n  <table width="100%" border="0" cellpadding="10" cellspacing="0" style="border-bottom:1px solid #999;">\r\n  <tr>\r\n  <td width="20%" rowspan="2" valign="top" style="border-right:1px solid #999;"><a href="{$module_data.PRODUCTS_LINK}"> <img src="{$module_data.PRODUCTS_IMAGE}" alt="{$module_data.PRODUCTS_NAME}" border="0" class"productImageBorder" /> </a> </td>\r\n  <td width="80%" valign="top"><a href="{$module_data.PRODUCTS_LINK}" style="text-decoration:none;">\r\n  <h1 style="font-size:12px; color:#6a0101;">{$module_data.PRODUCTS_NAME}</h1>\r\n  </a>{$module_data.PRODUCTS_SHORT_DESCRIPTION}\r\n  </td>\r\n  </tr>\r\n  <tr>\r\n  <td valign="bottom">\r\n  <div style="text-align:right; border-top:1px solid #000; padding-top:5px; margin-top:10px;">\r\n  <a href="{$module_data.PRODUCTS_LINK}" style="color:#6a0101; text-decoration:underline;"><b>Buy Now!</b></a> | <strong>{$module_data.PRODUCTS_PRICE}</strong>\r\n  </div>\r\n  </td>\r\n  </tr>\r\n  </table>\r\n\r\n  {/foreach}</td> </tr>\r\n </table>\r\n <div style="text-align:right; font-size:10px; margin-top:10px;">{$remove_link}</div>\r\n </div>\r\n </div>\r\n </td>\r\n </tr>\r\n</table>', 'Shopname Newsletter\r\n\r\n{if $personalize == ''yes'' && $greeting_type == ''0''} {if $customers_gender == ''f''} Dear Mrs.{$customers_name}, {else} Dear Mr. {$customers_name}, {/if} {/if} {if $personalize == ''yes'' && $greeting_type == ''1''} Welcome {$customers_name}, {/if} {if $personalize == ''''} Dear Customer, {/if}\r\n\r\n{$body}\r\n\r\n{if $gift_id} {if $greeting_type == ''1''} voucher:\r\n\r\nWe will send you a small gift of a voucher in the amount of {$gift_ammount}\r\nJust give when ordering your personal coupon code: {$gift_id}\r\n\r\n{else} voucher:\r\n\r\nWe will send you a small gift of a voucher in the amount of {$gift_ammount}\r\nJust give when ordering your personal coupon code: {$gift_id}\r\n\r\n{/if} {/if} {foreach name=aussen item=module_data from=$module_content} \r\n\r\n{$module_data.PRODUCTS_NAME}\r\n\r\n{$module_data.PRODUCTS_SHORT_DESCRIPTION}\r\n\r\nbuy now! | {$module_data.PRODUCTS_PRICE} EUR \r\n\r\n{/foreach} {$remove_link}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Newsletter</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {\r\n font-size:11.5px;\r\n font-family:Helvetica, sans-serif;\r\n color:#444\r\n}\r\ntable.outerTable {\r\n border: 1px solid #ccc\r\n}\r\ntd.TopRightDesc {\r\n letter-spacing: 1px;\r\n font-weight: 600\r\n}\r\n.ProductsTable td {\r\n color:#6d88b1;\r\n background: #f1f1f1\r\n}\r\n.ProductsAttributes td, .ProductsName {\r\n background: #ffffff\r\n}\r\n.bt {\r\n border-top:1px solid #ccc\r\n}\r\n.bb {\r\n border-bottom:1px solid #ccc\r\n}\r\n.bl {\r\n border-left:1px solid #ccc\r\n}\r\n.br {\r\n border-right:1px solid #ccc\r\n}\r\n.fs85 {\r\n font-size:85%\r\n}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n <td width="50%"><img src="{$logo_path}logo.gif" alt="" /> </td>\r\n <td width="50%" class="TopRightDesc" align="right"> Newsletter </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <div style="width:95%; background-color:#fff; padding:10px;">\r\n <h2 style="border-bottom:2px solid #6a0101; padding-bottom:10px; color:#333;">{$SHOP_NAME} Newsletter</h2>\r\n <p><strong> {if $personalize == ''yes'' && $greeting_type == ''0''} {if $customers_gender == ''f''} Dear Mrs.{$customers_name}, {else} Dear Mr. {$customers_name}, {/if} {/if} {if $personalize == ''yes'' && $greeting_type == ''1''} Welcome {$customers_name}, {/if} {if $personalize == ''''} Dear Customer, {/if} </strong></p>\r\n <p>{$body}</p>\r\n {if $gift_id}\r\n {if $greeting_type == ''1''}\r\n <table width="100%" style="border:1px #CCC; padding:10px; margin-bottom:15px; background-color:#ffeded;">\r\n <tr>\r\n <td><p style="padding-bottom:7px; margin:0 0 10px 0;"><strong style="font-family: Georgia, Times New Roman, Times, serif; font-size:12px;"><span id="result_box3" lang="en" xml:lang="en">voucher</span>:</strong></p>\r\n  <span id="result_box" lang="en" xml:lang="en">We will send you a small gift of a voucher in the amount of</span> <b>{$gift_ammount}</b>. <br />\r\n  <span id="result_box2" lang="en" xml:lang="en">Just give when ordering your personal coupon code</span>: <b>{$gift_id}</b></td>\r\n </tr>\r\n </table>\r\n {else}\r\n <table width="100%" style="border:1px #CCC; padding:10px; margin-bottom:15px; background-color:#ffeded;">\r\n <tr>\r\n <td><p style="padding-bottom:7px; margin:0 0 10px 0;"><strong style="font-family: Georgia, Times New Roman, Times, serif; font-size:12px;"><span id="result_box4" lang="en" xml:lang="en">voucher</span>:</strong></p>\r\n  <span id="result_box5" lang="en" xml:lang="en">We will send you a small gift of a voucher in the amount of</span> <b>{$gift_ammount}</b>. <br />\r\n  <span id="result_box6" lang="en" xml:lang="en">Just specify when ordering your personal coupon code</span>: <b>{$gift_id}</b></td>\r\n </tr>\r\n </table>\r\n {/if}\r\n {/if}\r\n <div style="background:#fff;">\r\n <table width="100%" cellpadding="0" cellspacing="0" border="0">\r\n <tr> <td>\r\n {foreach name=aussen item=module_data from=$module_content}\r\n  <table width="100%" border="0" cellpadding="10" cellspacing="0" style="border-bottom:1px solid #999;">\r\n  <tr>\r\n  <td width="20%" rowspan="2" valign="top" style="border-right:1px solid #999;"><a href="{$module_data.PRODUCTS_LINK}"> <img src="{$module_data.PRODUCTS_IMAGE}" alt="{$module_data.PRODUCTS_NAME}" border="0" class"productImageBorder" /> </a> </td>\r\n  <td width="80%" valign="top"><a href="{$module_data.PRODUCTS_LINK}" style="text-decoration:none;">\r\n  <h1 style="font-size:12px; color:#6a0101;">{$module_data.PRODUCTS_NAME}</h1>\r\n  </a>{$module_data.PRODUCTS_SHORT_DESCRIPTION}\r\n  </td>\r\n  </tr>\r\n  <tr>\r\n  <td valign="bottom">\r\n  <div style="text-align:right; border-top:1px solid #000; padding-top:5px; margin-top:10px;">\r\n  <a href="{$module_data.PRODUCTS_LINK}" style="color:#6a0101; text-decoration:underline;"><b>Buy Now!</b></a> | <strong>{$module_data.PRODUCTS_PRICE}</strong>\r\n  </div>\r\n  </td>\r\n  </tr>\r\n  </table>\r\n\r\n  {/foreach}</td> </tr>\r\n </table>\r\n <div style="text-align:right; font-size:10px; margin-top:10px;">{$remove_link}</div>\r\n </div>\r\n </div>\r\n </td>\r\n </tr>\r\n</table>', 'Shopname Newsletter\r\n\r\n{if $personalize == ''yes'' && $greeting_type == ''0''} {if $customers_gender == ''f''} Dear Mrs.{$customers_name}, {else} Dear Mr. {$customers_name}, {/if} {/if} {if $personalize == ''yes'' && $greeting_type == ''1''} Welcome {$customers_name}, {/if} {if $personalize == ''''} Dear Customer, {/if}\r\n\r\n{$body}\r\n\r\n{if $gift_id} {if $greeting_type == ''1''} voucher:\r\n\r\nWe will send you a small gift of a voucher in the amount of {$gift_ammount}\r\nJust give when ordering your personal coupon code: {$gift_id}\r\n\r\n{else} voucher:\r\n\r\nWe will send you a small gift of a voucher in the amount of {$gift_ammount}\r\nJust give when ordering your personal coupon code: {$gift_id}\r\n\r\n{/if} {/if} {foreach name=aussen item=module_data from=$module_content} \r\n\r\n{$module_data.PRODUCTS_NAME}\r\n\r\n{$module_data.PRODUCTS_SHORT_DESCRIPTION}\r\n\r\nbuy now! | {$module_data.PRODUCTS_PRICE} EUR \r\n\r\n{/foreach} {$remove_link}', 1263483589);
INSERT INTO emails VALUES(NULL, 'newsletter_aktivierung', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Newsletter for activation on {$shop_name}', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Newsletter Registration</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td, div.lightBackground {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Newsletter\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td><br />\r\n  <strong>Thank you for your subscription.</strong><br /><br />\r\n You are receiving this mail because you want to receive our newsletters. Please click on the activation link unlocked so that your email address for the newsletter will receive.<br /><br />\r\n <table width="100%" border="0" cellpadding="6" cellspacing="0">\r\n  <tr class="lightBackground">\r\n  <td width="1"><nobr>Your activation link:</nobr></td>\r\n  <td>{$LINK}</td>\r\n  </tr>\r\n </table>\r\n <br /><br />If you have not registered in our newsletter or wish to receive the newsletter, we ask you to do nothing. Your address will be deleted automatically at the next update of the database.\r\n </td>\r\n </tr>\r\n</table>', 'Thank you for your subscription.\r\nYou are receiving this mail because you want to receive our newsletters.\r\n Please click on the activation link unlocked so that your email address for the newsletter will receive.\r\nIf you have not registered in our newsletter or wish to receive the newsletter, we ask you to do nothing. \r\nYour address will be deleted automatically at the next update of the database.\r\n \r\nYour activation link:{$LINK}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Newsletter Registration</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td, div.lightBackground {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Newsletter\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td><br />\r\n  <strong>Thank you for your subscription.</strong><br /><br />\r\n You are receiving this mail because you want to receive our newsletters. Please click on the activation link unlocked so that your email address for the newsletter will receive.<br /><br />\r\n <table width="100%" border="0" cellpadding="6" cellspacing="0">\r\n  <tr class="lightBackground">\r\n  <td width="1"><nobr>Your activation link:</nobr></td>\r\n  <td>{$LINK}</td>\r\n  </tr>\r\n </table>\r\n <br /><br />If you have not registered in our newsletter or wish to receive the newsletter, we ask you to do nothing. Your address will be deleted automatically at the next update of the database.\r\n </td>\r\n </tr>\r\n</table>', 'Thank you for your subscription.\r\nYou are receiving this mail because you want to receive our newsletters.\r\n Please click on the activation link unlocked so that your email address for the newsletter will receive.\r\nIf you have not registered in our newsletter or wish to receive the newsletter, we ask you to do nothing. \r\nYour address will be deleted automatically at the next update of the database.\r\n \r\nYour activation link: {$LINK}', 1263483589);
INSERT INTO emails VALUES(NULL, 'new_password', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Your new password', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>New password</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   New password\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td><p><b>Password changed!</b></p>\r\n  You are receiving this mail because you have requested a new password and set up.<br />\r\n  Please login with the password and your e-mail address with us and change your password in your account as you wish.\r\n  <br />\r\n </td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td><b>Your new password:<br>\r\n   </b>{$NEW_PASSWORD}\r\n  </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  <p>We wish you much fun with our offer!</p>\r\n </td>\r\n </tr>\r\n</table>', 'New password\r\nPassword changed!\r\n\r\nYou are receiving this mail because you have requested a new password and set up.\r\n\r\nPlease login with the password and your e-mail address with us and change your password in your account as you wish.\r\n\r\nYour new password: {$NEW_PASSWORD}\r\n\r\nWe wish you much fun with our offer!\r\n \r\n', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>New password</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   New password\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td><p><b>Password changed!</b></p>\r\n  You are receiving this mail because you have requested a new password and set up.<br />\r\n  Please login with the password and your e-mail address with us and change your password in your account as you wish.\r\n  <br />\r\n </td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td><b>Your new password:<br>\r\n   </b>{$NEW_PASSWORD}\r\n  </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  <p>We wish you much fun with our offer!</p>\r\n </td>\r\n </tr>\r\n</table>', 'New password\r\nPassword changed!\r\n\r\nYou are receiving this mail because you have requested a new password and set up.\r\n\r\nPlease login with the password and your e-mail address with us and change your password in your account as you wish.\r\n\r\nYour new password: {$NEW_PASSWORD}\r\n\r\nWe wish you much fun with our offer!\r\n \r\n', 12345612);
INSERT INTO emails VALUES(NULL, 'order_mail', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Your Order - Nr: {$nr} from {$date}', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Order Confirmation</title>\r\n{literal}\r\n<style type="text/css"> \r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Order Confirmation\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td align="left">\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n   <tr>\r\n    <td width="60%">{$address_label_customer}</td>\r\n    <td>\r\n     <strong>Order Nr:</strong> {$oID}<br /><br />\r\n     {if $csID}\r\n    <strong>Customers nr:</strong> {$csID}<br />\r\n   {/if}\r\n    {if $UID}\r\n    <strong>UST-ID:</strong> {$UID}<br />\r\n   {/if}\r\n     {if $PAYMENT_METHOD}\r\n     <strong>Payment method:</strong> {$PAYMENT_METHOD}<br />\r\n     {/if}\r\n     <strong>Order date:</strong> {$DATE}<br />\r\n    </td>\r\n   </tr>\r\n   </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellspacing="6" cellpadding="3" class="outerTable">\r\n   <tr bgcolor="#f1f1f1">\r\n    {if $address_label_payment == $address_label_shipping}\r\n    <td width="100%">\r\n     <strong>Bill address</strong>\r\n    </td>\r\n   {else}\r\n   <td width="50%">\r\n     <strong>Delivery address</strong>\r\n    </td>\r\n   <td>\r\n    <strong>Bill address</strong>\r\n   </td>\r\n   {/if}\r\n   </tr>\r\n   <tr>\r\n   {if $address_label_payment == $address_label_shipping}\r\n    <td>\r\n    {$address_label_shipping}\r\n    </td>\r\n   {else}\r\n   <td>{$address_label_shipping}</td>\r\n     <td>{$address_label_payment}</td>\r\n    {/if}\r\n   </tr>\r\n   </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellspacing="0">\r\n  <tr>\r\n   <td><br />\r\n   Hallo {if $GENDER==''f''}Miss{else}Mister{/if} {$NNAME},<br /><br />\r\n   Thank you for your order.<br /><br />\r\n   {$PAYMENT_INFO_HTML}\r\n   <br />\r\n   {if $COMMENTS}<br />\r\n    <strong>Your comments:</strong><br />\r\n    {$COMMENTS}<br /><br />\r\n   {/if}\r\n   {if $NEW_PASSWORD}\r\n    <br /><br />\r\n    <strong>Your account password:</strong><br />\r\n    {$NEW_PASSWORD}<br /><br />\r\n   {/if}\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="f1f1f1" class="outerTable">\r\n  <tr class="ProductsTable">\r\n   <td align="left" class="bb br">\r\n   <strong>Articel</strong>\r\n   </td>\r\n   <td align="center" class="bb br">\r\n   <strong>Single price</strong>\r\n   </td>\r\n   <td align="center" class="bb br">\r\n   <strong>Qty</strong>\r\n   </td>\r\n   <td align="right" class="bb">\r\n   <strong>Total</strong>\r\n   </td>\r\n  </tr>\r\n  {foreach name=aussen item=order_values from=$order_data}\r\n  <tr>\r\n   <td valign="top" class="bb br ProductsName">\r\n   <strong>{$order_values.PRODUCTS_NAME}</strong> <span class="fs85">(Model-Nr:{$order_values.PRODUCTS_MODEL})</span>\r\n   {if $order_values.PRODUCTS_SHIPPING_TIME neq ''''}<br />\r\n    <em>Shipping time: {$order_values.PRODUCTS_SHIPPING_TIME}</em>\r\n   {/if}\r\n   </td>\r\n   <td valign="top" class="bb br ProductsName" align="center"><strong>{$order_values.PRODUCTS_SINGLE_PRICE}</strong></td>\r\n   <td valign="top" class="bb br ProductsName" align="center"><strong>{$order_values.PRODUCTS_QTY}</strong></td>\r\n   <td valign="top" class="bb" align="right"><strong>{$order_values.PRODUCTS_PRICE}</strong></td>\r\n  </tr>\r\n  {/foreach}\r\n  {foreach name=aussen item=order_values from=$order_data}\r\n   {if $order_values.PRODUCTS_ATTRIBUTES !=''''}\r\n   <tr class="ProductsAttributes">\r\n    <td valign="top" class="bb">\r\n    {$order_values.PRODUCTS_ATTRIBUTES}\r\n    </td>\r\n    <td valign="top" align="center" class="bb">{$order_values.PRODUCTS_QTY}</td>\r\n    <td class="bb"> </td>\r\n    <td class="bb"> </td>\r\n   </tr>\r\n   {/if}\r\n  {/foreach}\r\n  <tr><td colspan="4" class="ProductsName bb"> </td></tr>\r\n  {foreach name=aussen item=order_total_values from=$order_total}\r\n   <tr>\r\n   <td colspan="3" width="98%" align="right"><nobr>{$order_total_values.TITLE}</nobr></td>\r\n   <td width="2%" align="right"><nobr>{$order_total_values.TEXT}</nobr></td>\r\n   </tr>\r\n  {/foreach}\r\n  </table>\r\n </td>\r\n </tr>\r\n</table>\r\n\r\n{if $WIDERRUF_TEXT !=''''}<br />\r\n <table width="90%" border="0" cellpadding="10" cellspacing="0" align="center">\r\n <tr>\r\n  <td><strong>{$WIDERRUF_HEAD}</strong></td>\r\n </tr>\r\n <tr>\r\n  <td>{$WIDERRUF_TEXT}</td>\r\n </tr>\r\n </table>\r\n{/if}', '{$address_label_customer}\r\n\r\n{if $PAYMENT_METHOD}Payment method: {$PAYMENT_METHOD}{/if}\r\nOrder nr: {$oID}\r\nDate: {$DATE}\r\n{if $csID}Customer nr:{$csID}{/if}\r\n----------------------------------------------------------------------\r\n\r\n\r\nHello {$NAME},\r\n\r\n{if $NEW_PASSWORD}\r\n Your account password: {$NEW_PASSWORD}\r\n{/if} \r\n\r\n{$PAYMENT_INFO_TXT}\r\n\r\n{if $COMMENTS}\r\nYour comments:\r\n{$COMMENTS}\r\n{/if}\r\n\r\nYour ordered products to control\r\n----------------------------------------------------------------------\r\n{foreach name=aussen item=order_values from=$order_data} \r\n{$order_values.PRODUCTS_QTY} x {$order_values.PRODUCTS_NAME} {$order_values.PRODUCTS_PRICE}\r\n{if $order_values.PRODUCTS_SHIPPING_TIME neq ''''}Lieferzeit: {$order_values.PRODUCTS_SHIPPING_TIME}{/if}\r\n{if $order_values.PRODUCTS_ATTRIBUTES !=''''}{$order_values.PRODUCTS_ATTRIBUTES}{/if}\r\n\r\n{/foreach}\r\n\r\n{foreach name=aussen item=order_total_values from=$order_total}\r\n{$order_total_values.TITLE}{$order_total_values.TEXT}\r\n{/foreach}\r\n\r\n\r\n{if $address_label_payment}\r\nRechnungsadresse\r\n----------------------------------------------------------------------\r\n{$address_label_payment}\r\n{/if}\r\nVersandadresse \r\n----------------------------------------------------------------------\r\n{$address_label_shipping}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Order Confirmation</title>\r\n{literal}\r\n<style type="text/css"> \r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Order Confirmation\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td align="left">\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n   <tr>\r\n    <td width="60%">{$address_label_customer}</td>\r\n    <td>\r\n     <strong>Order Nr:</strong> {$oID}<br /><br />\r\n     {if $csID}\r\n    <strong>Customers nr:</strong> {$csID}<br />\r\n   {/if}\r\n    {if $UID}\r\n    <strong>UST-ID:</strong> {$UID}<br />\r\n   {/if}\r\n     {if $PAYMENT_METHOD}\r\n     <strong>Payment method:</strong> {$PAYMENT_METHOD}<br />\r\n     {/if}\r\n     <strong>Order date:</strong> {$DATE}<br />\r\n    </td>\r\n   </tr>\r\n   </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellspacing="6" cellpadding="3" class="outerTable">\r\n   <tr bgcolor="#f1f1f1">\r\n    {if $address_label_payment == $address_label_shipping}\r\n    <td width="100%">\r\n     <strong>Bill address</strong>\r\n    </td>\r\n   {else}\r\n   <td width="50%">\r\n     <strong>Delivery address</strong>\r\n    </td>\r\n   <td>\r\n    <strong>Bill address</strong>\r\n   </td>\r\n   {/if}\r\n   </tr>\r\n   <tr>\r\n   {if $address_label_payment == $address_label_shipping}\r\n    <td>\r\n    {$address_label_shipping}\r\n    </td>\r\n   {else}\r\n   <td>{$address_label_shipping}</td>\r\n     <td>{$address_label_payment}</td>\r\n    {/if}\r\n   </tr>\r\n   </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellspacing="0">\r\n  <tr>\r\n   <td><br />\r\n   Hallo {if $GENDER==''f''}Miss{else}Mister{/if} {$NNAME},<br /><br />\r\n   Thank you for your order.<br /><br />\r\n   {$PAYMENT_INFO_HTML}\r\n   <br />\r\n   {if $COMMENTS}<br />\r\n    <strong>Your comments:</strong><br />\r\n    {$COMMENTS}<br /><br />\r\n   {/if}\r\n   {if $NEW_PASSWORD}\r\n    <br /><br />\r\n    <strong>Your account password:</strong><br />\r\n    {$NEW_PASSWORD}<br /><br />\r\n   {/if}\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="f1f1f1" class="outerTable">\r\n  <tr class="ProductsTable">\r\n   <td align="left" class="bb br">\r\n   <strong>Articel</strong>\r\n   </td>\r\n   <td align="center" class="bb br">\r\n   <strong>Single price</strong>\r\n   </td>\r\n   <td align="center" class="bb br">\r\n   <strong>Qty</strong>\r\n   </td>\r\n   <td align="right" class="bb">\r\n   <strong>Total</strong>\r\n   </td>\r\n  </tr>\r\n  {foreach name=aussen item=order_values from=$order_data}\r\n  <tr>\r\n   <td valign="top" class="bb br ProductsName">\r\n   <strong>{$order_values.PRODUCTS_NAME}</strong> <span class="fs85">(Model-Nr:{$order_values.PRODUCTS_MODEL})</span>\r\n   {if $order_values.PRODUCTS_SHIPPING_TIME neq ''''}<br />\r\n    <em>Shipping time: {$order_values.PRODUCTS_SHIPPING_TIME}</em>\r\n   {/if}\r\n   </td>\r\n   <td valign="top" class="bb br ProductsName" align="center"><strong>{$order_values.PRODUCTS_SINGLE_PRICE}</strong></td>\r\n   <td valign="top" class="bb br ProductsName" align="center"><strong>{$order_values.PRODUCTS_QTY}</strong></td>\r\n   <td valign="top" class="bb" align="right"><strong>{$order_values.PRODUCTS_PRICE}</strong></td>\r\n  </tr>\r\n  {/foreach}\r\n  {foreach name=aussen item=order_values from=$order_data}\r\n   {if $order_values.PRODUCTS_ATTRIBUTES !=''''}\r\n   <tr class="ProductsAttributes">\r\n    <td valign="top" class="bb">\r\n    {$order_values.PRODUCTS_ATTRIBUTES}\r\n    </td>\r\n    <td valign="top" align="center" class="bb">{$order_values.PRODUCTS_QTY}</td>\r\n    <td class="bb"> </td>\r\n    <td class="bb"> </td>\r\n   </tr>\r\n   {/if}\r\n  {/foreach}\r\n  <tr><td colspan="4" class="ProductsName bb"> </td></tr>\r\n  {foreach name=aussen item=order_total_values from=$order_total}\r\n   <tr>\r\n   <td colspan="3" width="98%" align="right"><nobr>{$order_total_values.TITLE}</nobr></td>\r\n   <td width="2%" align="right"><nobr>{$order_total_values.TEXT}</nobr></td>\r\n   </tr>\r\n  {/foreach}\r\n  </table>\r\n </td>\r\n </tr>\r\n</table>\r\n\r\n{if $WIDERRUF_TEXT !=''''}<br />\r\n <table width="90%" border="0" cellpadding="10" cellspacing="0" align="center">\r\n <tr>\r\n  <td><strong>{$WIDERRUF_HEAD}</strong></td>\r\n </tr>\r\n <tr>\r\n  <td>{$WIDERRUF_TEXT}</td>\r\n </tr>\r\n </table>\r\n{/if}', '{$address_label_customer}\r\n\r\n{if $PAYMENT_METHOD}Payment method: {$PAYMENT_METHOD}{/if}\r\nOrder nr: {$oID}\r\nDate: {$DATE}\r\n{if $csID}Customer nr:{$csID}{/if}\r\n----------------------------------------------------------------------\r\n\r\n\r\nHello {$NAME},\r\n\r\n{if $NEW_PASSWORD}\r\n Your account password: {$NEW_PASSWORD}\r\n{/if} \r\n\r\n{$PAYMENT_INFO_TXT}\r\n\r\n{if $COMMENTS}\r\nYour comments:\r\n{$COMMENTS}\r\n{/if}\r\n\r\nYour ordered products to control\r\n----------------------------------------------------------------------\r\n{foreach name=aussen item=order_values from=$order_data} \r\n{$order_values.PRODUCTS_QTY} x {$order_values.PRODUCTS_NAME} {$order_values.PRODUCTS_PRICE}\r\n{if $order_values.PRODUCTS_SHIPPING_TIME neq ''''}Lieferzeit: {$order_values.PRODUCTS_SHIPPING_TIME}{/if}\r\n{if $order_values.PRODUCTS_ATTRIBUTES !=''''}{$order_values.PRODUCTS_ATTRIBUTES}{/if}\r\n\r\n{/foreach}\r\n\r\n{foreach name=aussen item=order_total_values from=$order_total}\r\n{$order_total_values.TITLE}{$order_total_values.TEXT}\r\n{/foreach}\r\n\r\n\r\n{if $address_label_payment}\r\nRechnungsadresse\r\n----------------------------------------------------------------------\r\n{$address_label_payment}\r\n{/if}\r\nVersandadresse \r\n----------------------------------------------------------------------\r\n{$address_label_shipping}', 1263483589);
INSERT INTO emails VALUES(NULL, 'password_verification', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Confirm the password change', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Password confirmation</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td colspan="2">\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Password confirmation\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td colspan="2">\r\n  <p><b>Please confirm your password request!</b></p>\r\n  <p>Please confirm that you yourself have requested a new password. <br> \r\n n For this reason, we have sent you this e-mail with a personal confirmation link. When you confirm the link by clicking it, you will immediately put a new password in another e-mail.\r\n  </p><br />\r\n </td>\r\n </tr>\r\n <tr class="lightBackground">\r\n <td width="1">\r\n  <nobr><b>Your verification link:</b></nobr>\r\n </td>\r\n <td>\r\n  <a href="{$LINK}">{$LINK}</a>\r\n </td>\r\n </tr>\r\n</table>', 'Please confirm your password request!\r\n\r\nPlease confirm that you yourself have requested a new password.\r n For this reason, we have sent you this e-mail with a personal confirmation link. When you confirm the link by clicking it, you will immediately put a new password in another e-mail.\r\n  \r\nYour verification link:\r\n{$LINK}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Password confirmation</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td colspan="2">\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Password confirmation\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td colspan="2">\r\n  <p><b>Please confirm your password request!</b></p>\r\n  <p>Please confirm that you yourself have requested a new password. <br> \r\n n For this reason, we have sent you this e-mail with a personal confirmation link. When you confirm the link by clicking it, you will immediately put a new password in another e-mail.\r\n  </p><br />\r\n </td>\r\n </tr>\r\n <tr class="lightBackground">\r\n <td width="1">\r\n  <nobr><b>Your verification link:</b></nobr>\r\n </td>\r\n <td>\r\n  <a href="{$LINK}">{$LINK}</a>\r\n </td>\r\n </tr>\r\n</table>', 'Please confirm your password request!\r\n\r\nPlease confirm that you yourself have requested a new password. \r n For this reason, we have sent you this e-mail with a personal confirmation link. When you confirm the link by clicking it, you will immediately put a new password in another e-mail.\r\n  \r\nYour verification link:\r\n{$LINK}', 1263483589);
INSERT INTO emails VALUES(NULL, 'pdf_mail', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Your PDF invoice {$renr} from {$date}', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>PDF-Rechnung</title>\r\n{literal}\r\n<style type="text/css"> \r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   PDF invoice\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellspacing="6" cellpadding="3" class="outerTable">\r\n   <tr>\r\n   <td colspan="2">\r\n    <p><strong>Dear Customer, </strong></p>\r\n    <p>attached to this e-mail we send you the invoice from your order {$ORDER_DATE}.<br /><br />\r\n    Answer any questions about your order, please to this email.</p>\r\n    </td>\r\n   </tr>\r\n  <tr class="lightBackground">\r\n   <td>\r\n   The status of your order can be viewed at:\r\n   </td>\r\n   <td>\r\n   <a href="{$ORDER_LINK}">{$ORDER_LINK}</a>\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n</table>', 'Dear Customer,\r\n\r\nattached to this e-mail we send you the invoice of your order from the {$ORDER_DATE}.\r\n\r\nAnswer any questions about your order, please to this email, the status of your order\r\nCan be viewed at: {$ORDER_LINK}.', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>PDF-Rechnung</title>\r\n{literal}\r\n<style type="text/css"> \r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   PDF invoice\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellspacing="6" cellpadding="3" class="outerTable">\r\n   <tr>\r\n   <td colspan="2">\r\n    <p><strong>Dear Customer, </strong></p>\r\n    <p>attached to this e-mail we send you the invoice from your order {$ORDER_DATE}.<br /><br />\r\n    Answer any questions about your order, please to this email.</p>\r\n    </td>\r\n   </tr>\r\n  <tr class="lightBackground">\r\n   <td>\r\n   The status of your order can be viewed at:\r\n   </td>\r\n   <td>\r\n   <a href="{$ORDER_LINK}">{$ORDER_LINK}</a>\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n</table>', 'Dear Customer,\r\n\r\nattached to this e-mail we send you the invoice of your order from the {$ORDER_DATE}.\r\n\r\nAnswer any questions about your order, please to this email, the status of your order\r\nCan be viewed at: {$ORDER_LINK}.', 1263483589);
INSERT INTO emails VALUES(NULL, 'recover_cart_sales', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Your visit to our shop', '', '<!DOCTYPE html>\r\n<html dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Email</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Offener Warenkorb\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>{if $GENDER}Dear{if $GENDER eq ''m''} Mr.{elseif $GENDER eq ''f''} Mrs.{else} {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Welcome,{/if}\r\n  <p>{if $NEW == true}Thank you for visiting {$STORE_NAME} and your faith and trust us.\r\n  {else}Thanks again for your visit {$STORE_NAME} and your faith and trust us repeatedly.{/if}</p>\r\n  <p>We have seen that you have filled in when you visit our online shop shopping with these articles, but the purchase has not been fully.</p>\r\n <p>View your shopping cart:</p>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="3">\r\n  {foreach name=outer item=product from=$products_data}\r\n  <tr>\r\n  <td width="150"><img src="{$product.IMAGE}" alt="{$product.NAME}" /></td>\r\n  <td width="10" valign="top">{$product.QUANTITY} x </td>\r\n  <td valign="top">{$product.NAME}<br />\r\n   <a href="{$product.LINK}">{$product.LINK}</a></td>\r\n  </tr>\r\n  {/foreach}\r\n </table>\r\n <p>We are always striving to improve our service to serve our customers.\r\n  For this reason, it interests us, of course, what were the reasons for this, not your purchase at this time {$STORE_NAME}to make.\r\n  We are very grateful if you could let us know if you had during your visit to our online shop problems or concerns, successfully complete your purchase.\r\n  Our goal is to provide you and other customers, shopping at {$STORE_NAME} to make easier and better.</p>\r\n To complete your purchase now, please contact us here: <a href="{$LOGIN}">{$LOGIN}</a><br />\r\n <p>Thanks again for your time and your help, the online shop {$STORE_NAME} to improve.</p>\r\n <p>Yours sincerely,</p>\r\n <p>Your team <a href="{$STORE_LINK}">{$STORE_NAME}</a></p>\r\n {if $MESSAGE}\r\n <p>{$MESSAGE}</p>\r\n {/if}\r\n</td>\r\n </tr>\r\n</table>', '{if $GENDER}Dear{if $GENDER eq ''m''} Mr.{elseif $GENDER eq ''f''} Mrs.{else} {$FIRSTNAME}{/if} {$LASTNAME}, {else}Welcome,{/if} {if $NEW == true}Thank you for visiting {$STORE_NAME} and your faith and trust us. {else}Thanks again for your visit {$STORE_NAME} and your faith and trust us repeatedly.{/if}\r\n\r\nWe have seen that you have filled in when you visit our online shop shopping with these articles, but the purchase has not been fully.\r\n\r\nView your shopping cart:\r\n\r\n{foreach name=outer item=product from=$products_data} \r\n\r\n{$product.QUANTITY} x \r\n\r\n{$product.NAME}\r\n{$product.LINK}\r\n\r\n{/foreach} We are always striving to improve our service to serve our customers. For this reason, it interests us, of course, what were the reasons for this, not your purchase at this time {$STORE_NAME}to make. We are very grateful if you could let us know if you had during your visit to our online shop problems or concerns, successfully complete your purchase. Our goal is to provide you and other customers, shopping at {$STORE_NAME} to make easier and better.\r\n\r\nTo complete your purchase now, please contact us here: {$LOGIN}\r\nThanks again for your time and your help, the online shop {$STORE_NAME} to improve.\r\n\r\nYours sincerely,\r\n\r\nYour team {$STORE_NAME}\r\n\r\n{if $MESSAGE} {$MESSAGE}\r\n\r\n{/if} \r\n\r\n', '<!DOCTYPE html>\r\n<html dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Email</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Offener Warenkorb\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>{if $GENDER}Dear{if $GENDER eq ''m''} Mr.{elseif $GENDER eq ''f''} Mrs.{else} {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Welcome,{/if}\r\n  <p>{if $NEW == true}Thank you for visiting {$STORE_NAME} and your faith and trust us.\r\n  {else}Thanks again for your visit {$STORE_NAME} and your faith and trust us repeatedly.{/if}</p>\r\n  <p>We have seen that you have filled in when you visit our online shop shopping with these articles, but the purchase has not been fully.</p>\r\n <p>View your shopping cart:</p>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="3">\r\n  {foreach name=outer item=product from=$products_data}\r\n  <tr>\r\n  <td width="150"><img src="{$product.IMAGE}" alt="{$product.NAME}" /></td>\r\n  <td width="10" valign="top">{$product.QUANTITY} x </td>\r\n  <td valign="top">{$product.NAME}<br />\r\n   <a href="{$product.LINK}">{$product.LINK}</a></td>\r\n  </tr>\r\n  {/foreach}\r\n </table>\r\n <p>We are always striving to improve our service to serve our customers.\r\n  For this reason, it interests us, of course, what were the reasons for this, not your purchase at this time {$STORE_NAME}to make.\r\n  We are very grateful if you could let us know if you had during your visit to our online shop problems or concerns, successfully complete your purchase.\r\n  Our goal is to provide you and other customers, shopping at {$STORE_NAME} to make easier and better.</p>\r\n To complete your purchase now, please contact us here: <a href="{$LOGIN}">{$LOGIN}</a><br />\r\n <p>Thanks again for your time and your help, the online shop {$STORE_NAME} to improve.</p>\r\n <p>Yours sincerely,</p>\r\n <p>Your team <a href="{$STORE_LINK}">{$STORE_NAME}</a></p>\r\n {if $MESSAGE}\r\n <p>{$MESSAGE}</p>\r\n {/if}\r\n</td>\r\n </tr>\r\n</table>', '{if $GENDER}Dear{if $GENDER eq ''m''} Mr.{elseif $GENDER eq ''f''} Mrs.{else} {$FIRSTNAME}{/if} {$LASTNAME}, {else}Welcome,{/if} {if $NEW == true}Thank you for visiting {$STORE_NAME} and your faith and trust us. {else}Thanks again for your visit {$STORE_NAME} and your faith and trust us repeatedly.{/if}\r\n\r\nWe have seen that you have filled in when you visit our online shop shopping with these articles, but the purchase has not been fully.\r\n\r\nView your shopping cart:\r\n\r\n{foreach name=outer item=product from=$products_data} \r\n\r\n{$product.QUANTITY} x \r\n\r\n{$product.NAME}\r\n{$product.LINK}\r\n\r\n{/foreach} We are always striving to improve our service to serve our customers. For this reason, it interests us, of course, what were the reasons for this, not your purchase at this time {$STORE_NAME}to make. We are very grateful if you could let us know if you had during your visit to our online shop problems or concerns, successfully complete your purchase. Our goal is to provide you and other customers, shopping at {$STORE_NAME} to make easier and better.\r\n\r\nTo complete your purchase now, please contact us here: {$LOGIN}\r\nThanks again for your time and your help, the online shop {$STORE_NAME} to improve.\r\n\r\nYours sincerely,\r\n\r\nYour team {$STORE_NAME}\r\n\r\n{if $MESSAGE} {$MESSAGE}\r\n\r\n{/if} \r\n\r\n', 1297445522);
INSERT INTO emails VALUES(NULL, 'send_cupon', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', '', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Redeem Voucher</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  {$MESSAGE}\r\n  <br />\r\n  <br />\r\nYou can redeem the voucher with your order. Enter for your voucher number in the box coupons one. <br>\r\n<br />\r\nYour coupon code is: <strong>\r\n{$COUPON_ID}\r\n</strong><br>\r\n<br>\r\nRaise your voucher number to well, just so you can benefit from this offer. <br>\r\n<br>\r\nif you give us the next time under\r\n<a href="{$WEBSITE}">{$WEBSITE}</a>\r\nvisit.</td>\r\n </tr>\r\n</table>', '{$MESSAGE}\r\n\r\nYou can redeem the voucher with your order. Enter for your voucher number in the box coupons one.\r\n\r\nYour coupon code is: {$COUPON_ID}\r\n\r\nRaise your voucher number to well, just so you can benefit from this offer.\r\nif you give us the next time under {$WEBSITE} visit.', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Redeem Voucher</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  {$MESSAGE}\r\n  <br />\r\n  <br />\r\nYou can redeem the voucher with your order. Enter for your voucher number in the box coupons one. <br>\r\n<br />\r\nYour coupon code is: <strong>\r\n{$COUPON_ID}\r\n</strong><br>\r\n<br>\r\nRaise your voucher number to well, just so you can benefit from this offer. <br>\r\n<br>\r\nif you give us the next time under\r\n<a href="{$WEBSITE}">{$WEBSITE}</a>\r\nvisit.</td>\r\n </tr>\r\n</table>', '{$MESSAGE}\r\n\r\nYou can redeem the voucher with your order. Enter for your voucher number in the box coupons one.\r\n\r\nYour coupon code is: {$COUPON_ID}\r\n\r\nRaise your voucher number to well, just so you can benefit from this offer.\r\nif you give us the next time under {$WEBSITE} visit.', 1263483589);
INSERT INTO emails VALUES(NULL, 'send_gift', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', '', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Redeem Voucher</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr>\r\n <td><p>{$MESSAGE}\r\n </p>\r\n  <p> Voucher value\r\n  {$AMMOUNT} </p>\r\n  <p>To register your coupon, click on the link below. Please write down your personal safety promotional code. Your coupon code is:\r\n   {$GIFT_ID}\r\n  </p>\r\n  <p> <a href="{$GIFT_LINK}">\r\n  {$GIFT_LINK}\r\n  </a></p>\r\n  <p>For any queries regarding the won.<br>\r\n  Visit our website\r\n  <a href="{$WEBSITE}">{$WEBSITE}</a>\r\n and the coupon code to manually enter</p></td>\r\n </tr>\r\n</table>', '{$MESSAGE}\r\n \r\nVoucher value {$AMMOUNT}\r\n \r\nTo register your coupon, click on the link below.\r\nPlease write down your personal safety promotional code. Your coupon code is: {$GIFT_ID} \r\n\r\n{$GIFT_LINK}\r\n\r\nFor any queries regarding the won.  \r\nVisit our website {$WEBSITE} and the coupon code to manually enter', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Redeem Voucher</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr>\r\n <td><p>{$MESSAGE}\r\n </p>\r\n  <p> Voucher value\r\n  {$AMMOUNT} </p>\r\n  <p>To register your coupon, click on the link below. Please write down your personal safety promotional code. Your coupon code is:\r\n   {$GIFT_ID}\r\n  </p>\r\n  <p> <a href="{$GIFT_LINK}">\r\n  {$GIFT_LINK}\r\n  </a></p>\r\n  <p>For any queries regarding the won.<br>\r\n  Visit our website\r\n  <a href="{$WEBSITE}">{$WEBSITE}</a>\r\n and the coupon code to manually enter</p></td>\r\n </tr>\r\n</table>', '{$MESSAGE}\r\n \r\nVoucher value {$AMMOUNT}\r\n \r\nTo register your coupon, click on the link below.\r\nPlease write down your personal safety promotional code. Your coupon code is: {$GIFT_ID} \r\n\r\n{$GIFT_LINK}\r\n\r\nFor any queries regarding the won.  \r\nVisit our website {$WEBSITE} and the coupon code to manually enter', 1263483589);
INSERT INTO emails VALUES(NULL, 'send_gift_to_friend', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Certificate of mail-adresse.de', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Gutschein</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;">\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Gutschein\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  Congratulations, you have a coupon <b>{$AMMOUNT} </b> get! <br /><br />\r\n  This coupon has been sent to you by {$FROM_NAME},<br />\r\n  With the message:<br />\r\n  <em>{$MESSAGE}</em><br /><br />\r\n  Your personal coupon code is <strong>{$GIFT_CODE}</strong>.<br />You can playing this credit either during the ordering process.<br /><br />\r\n  To redeem the coupon, please click on <a href="{$GIFT_LINK}">{$GIFT_LINK}</a> <br /><br />\r\n  If it should come with the link above problems when cashing, you can chalk up this amount during the ordering process.\r\n </td>\r\n </tr>\r\n</table>', '----------------------------------------------------------------------------------------\r\n Congratulations, you have a coupon {$AMMOUNT} get!\r\n----------------------------------------------------------------------------------------\r\n\r\nThis coupon has been sent to you by {$FROM_NAME},\r\nWith the message:\r\n\r\n{$MESSAGE}\r\n\r\nYour personal coupon code is {$GIFT_CODE}. You can playing this credit either during the ordering process.\r\n\r\nTo redeem the coupon, please click on {$GIFT_LINK}\r\n\r\nIf it should come with the link above problems when cashing, you can chalk up this amount during the ordering process.', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Gutschein</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;">\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Gutschein\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n  Congratulations, you have a coupon <b>{$AMMOUNT} </b> get! <br /><br />\r\n  This coupon has been sent to you by {$FROM_NAME},<br />\r\n  With the message:<br />\r\n  <em>{$MESSAGE}</em><br /><br />\r\n  Your personal coupon code is <strong>{$GIFT_CODE}</strong>.<br />You can playing this credit either during the ordering process.<br /><br />\r\n  To redeem the coupon, please click on <a href="{$GIFT_LINK}">{$GIFT_LINK}</a> <br /><br />\r\n  If it should come with the link above problems when cashing, you can chalk up this amount during the ordering process.\r\n </td>\r\n </tr>\r\n</table>', '----------------------------------------------------------------------------------------\r\n Congratulations, you have a coupon {$AMMOUNT} get!\r\n----------------------------------------------------------------------------------------\r\n\r\nThis coupon has been sent to you by {$FROM_NAME},\r\nWith the message:\r\n\r\n{$MESSAGE}\r\n\r\nYour personal coupon code is {$GIFT_CODE}. You can playing this credit either during the ordering process.\r\n\r\nTo redeem the coupon, please click on {$GIFT_LINK}\r\n\r\nIf it should come with the link above problems when cashing, you can chalk up this amount during the ordering process.', 1263483589);
INSERT INTO emails VALUES(NULL, 'send_mail_from_admin', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'wird vom System gefüllt', '', '<!DOCTYPE html>\r\n<html dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Email</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Email\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>Dear {if $GENDER==''f''} Mrs.{else} Mr.{/if} {$NNAME},<br /><br />\r\n {$CONTENT}\r\n </td>\r\n </tr>\r\n</table>', 'Dear {if $GENDER==''f''}Mrs.{else}Mr.{/if} {$NNAME},\r\n\r\n{$CONTENT}', '<!DOCTYPE html>\r\n<html dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Email</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Email\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>Dear {if $GENDER==''f''} Mrs.{else} Mr.{/if} {$NNAME},<br /><br />\r\n {$CONTENT}\r\n </td>\r\n </tr>\r\n</table>', 'Dear {if $GENDER==''f''}Mrs.{else}Mr.{/if} {$NNAME},\r\n\r\n{$CONTENT}', 1297445522);
INSERT INTO emails VALUES(NULL, 'signatur', 1, 'info@ihr-shop.de', 'Commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', '', '', '{literal}<style type="text/css"> \r\n table.signatur {color:#666;border-top:1px solid #ccc}\r\n</style>\r\n{/literal}\r\n<br />\r\n<table width="90%" border="0" cellpadding="4" cellspacing="0" align="center" class="signatur">\r\n <tr>\r\n <td colspan="2">\r\n  <strong>Imprint:</strong>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td width="1">Company:</td>\r\n <td><nobr>{$SHOP_NAME}</nobr></td>\r\n </tr>\r\n <tr>\r\n <td>Store:</td>\r\n <td><nobr>{$SHOP_BESITZER}</nobr></td>\r\n </tr>\r\n <tr>\r\n <td valign="top">Address:</td>\r\n <td>\r\n  <nobr>{$SHOP_ADRESSE_VNAME} {$SHOP_ADRESSE_NNAME}</nobr><br />\r\n  <nobr>{$SHOP_ADRESSE_STRASSE}</nobr><br />\r\n  <nobr>{$SHOP_ADRESSE_PLZ} {$SHOP_ADRESSE_ORT}</nobr>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>Website:</td>\r\n <td><nobr><a href="{$SHOP_URL}">{$SHOP_URL}</a></nobr></td>\r\n </tr>\r\n <tr>\r\n <td>E-Mail:</td>\r\n <td><nobr><a href="mailto:{$SHOP_EMAIL}">{$SHOP_EMAIL}</a></nobr></td>\r\n </tr>\r\n {if $SHOP_USTID}\r\n <tr>\r\n <td>UST-ID:</td>\r\n <td><nobr>{$SHOP_USTID}</nobr></td>\r\n </tr>\r\n {/if}\r\n <tr>\r\n <td>Owner:</td>\r\n <td><nobr>{$SHOP_ADRESSE_VNAME} {$SHOP_ADRESSE_NNAME}</nobr></td>\r\n </tr>\r\n</table>\r\n</body>\r\n</html>', '\r\n\r\nCompany: {$SHOP_NAME}\r\n\r\nStore: {$SHOP_BESITZER}\r\n\r\nAddress: {$SHOP_ADRESSE_VNAME} {$SHOP_ADRESSE_NNAME}\r\n		 {$SHOP_ADRESSE_STRASSE}\r\nCity:	 {$SHOP_ADRESSE_PLZ} {$SHOP_ADRESSE_ORT}\r\n\r\nWebsite: {$SHOP_URL}\r\nE-Mail: ihre@mail-adresse.de\r\n\r\nUST-ID: {$SHOP_USTID}\r\nOwner: {$SHOP_BESITZER}', '{literal}<style type="text/css"> \r\n table.signatur {color:#666;border-top:1px solid #ccc}\r\n</style>\r\n{/literal}\r\n<br />\r\n<table width="90%" border="0" cellpadding="4" cellspacing="0" align="center" class="signatur">\r\n <tr>\r\n <td colspan="2">\r\n  <strong>Imprint:</strong>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td width="1">Company:</td>\r\n <td><nobr>{$SHOP_NAME}</nobr></td>\r\n </tr>\r\n <tr>\r\n <td>Store:</td>\r\n <td><nobr>{$SHOP_BESITZER}</nobr></td>\r\n </tr>\r\n <tr>\r\n <td valign="top">Address:</td>\r\n <td>\r\n  <nobr>{$SHOP_ADRESSE_VNAME} {$SHOP_ADRESSE_NNAME}</nobr><br />\r\n  <nobr>{$SHOP_ADRESSE_STRASSE}</nobr><br />\r\n  <nobr>{$SHOP_ADRESSE_PLZ} {$SHOP_ADRESSE_ORT}</nobr>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>Website:</td>\r\n <td><nobr><a href="{$SHOP_URL}">{$SHOP_URL}</a></nobr></td>\r\n </tr>\r\n <tr>\r\n <td>E-Mail:</td>\r\n <td><nobr><a href="mailto:{$SHOP_EMAIL}">{$SHOP_EMAIL}</a></nobr></td>\r\n </tr>\r\n {if $SHOP_USTID}\r\n <tr>\r\n <td>UST-ID:</td>\r\n <td><nobr>{$SHOP_USTID}</nobr></td>\r\n </tr>\r\n {/if}\r\n <tr>\r\n <td>Owner:</td>\r\n <td><nobr>{$SHOP_ADRESSE_VNAME} {$SHOP_ADRESSE_NNAME}</nobr></td>\r\n </tr>\r\n</table>\r\n</body>\r\n</html>', '\r\n\r\nCompany: {$SHOP_NAME}\r\n\r\nStore: {$SHOP_BESITZER}\r\n\r\nAddress: {$SHOP_ADRESSE_VNAME} {$SHOP_ADRESSE_NNAME}\r\n		 {$SHOP_ADRESSE_STRASSE}\r\nCity:	 {$SHOP_ADRESSE_PLZ} {$SHOP_ADRESSE_ORT}\r\n\r\nWebsite: {$SHOP_URL}\r\nE-Mail: ihre@mail-adresse.de\r\n\r\nUST-ID: {$SHOP_USTID}\r\nOwner: {$SHOP_BESITZER}', 1263483589);
INSERT INTO emails VALUES(NULL, 'askaquestion', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Ask a Question', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Kontoeröffnung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Frage zum Produkt\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td><br />\r\n  <table width="100%" border="0" cellpadding="10" cellspacing="5" align="center" class="outerTable ">\r\n  <tr class="lightBackground">\r\n   <td width="1"><nobr>Productname:</nobr></td>\r\n   <td> {$PRODUCT_NAME}</td>\r\n  </tr>\r\n  <tr class="lightBackground">\r\n   <td width="1"><nobr> from:</nobr></td>\r\n   <td> {$FROM_EMAIL_ADDRESS}</td>\r\n  </tr>\r\n  <tr class="lightBackground">\r\n   <td> Name:</td>\r\n   <td> {$TEXT_NAME}</td>\r\n  </tr>\r\n  <tr class="lightBackground">\r\n   <td>Product:</td>\r\n   <td><a href="{$PRODUCT_LINK}">{$PRODUCT_LINK}</a></td>\r\n  </tr>\r\n  <tr class="lightBackground">\r\n   <td> Message:</td>\r\n   <td> {$MESSAGE}</td>\r\n  </tr>\r\n  </table>\r\n  <br /><br />\r\n </td>\r\n </tr>\r\n</table>', 'Ask a Question:\r\n\r\n{$PRODUCT_NAME}\r\n\r\nfrom: {$FROM_EMAIL_ADDRESS}\r\nName: {$TEXT_NAME}\r\nProduct: {$PRODUCT_LINK}\r\n\r\nMessage:\r\n{$MESSAGE}\r\n', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Kontoeröffnung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n  <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n   <td width="50%">\r\n   <img src="{$logo_path}logo.gif" alt="" />\r\n   </td>\r\n   <td width="50%" class="TopRightDesc" align="right">\r\n   Frage zum Produkt\r\n   </td>\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td><br />\r\n  <table width="100%" border="0" cellpadding="10" cellspacing="5" align="center" class="outerTable ">\r\n  <tr class="lightBackground">\r\n   <td width="1"><nobr>Productname:</nobr></td>\r\n   <td> {$PRODUCT_NAME}</td>\r\n  </tr>\r\n  <tr class="lightBackground">\r\n   <td width="1"><nobr> from:</nobr></td>\r\n   <td> {$FROM_EMAIL_ADDRESS}</td>\r\n  </tr>\r\n  <tr class="lightBackground">\r\n   <td> Name:</td>\r\n   <td> {$TEXT_NAME}</td>\r\n  </tr>\r\n  <tr class="lightBackground">\r\n   <td>Product:</td>\r\n   <td><a href="{$PRODUCT_LINK}">{$PRODUCT_LINK}</a></td>\r\n  </tr>\r\n  <tr class="lightBackground">\r\n   <td> Message:</td>\r\n   <td> {$MESSAGE}</td>\r\n  </tr>\r\n  </table>\r\n  <br /><br />\r\n </td>\r\n </tr>\r\n</table>', 'Ask a Question:\r\n\r\n{$PRODUCT_NAME}\r\n\r\nfrom: {$FROM_EMAIL_ADDRESS}\r\nName: {$TEXT_NAME}\r\nProduct: {$PRODUCT_LINK}\r\n\r\nMessage:\r\n{$MESSAGE}\r\n', 12345612);
INSERT INTO emails VALUES(NULL, 'stock_mail', 1, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Lagerwarnung für Produkt: {$name} / Artikelnummer: {$artnr}', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellstatusänderung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Lagerwarnung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td>Sie wollten gewarnt werden, wenn ein Produkt in Ihrem Shop den Lagerbestand von <b>{$STOCK_AMOUNT}</b> unterschreitet.<br /><br />\r\n\r\nDas Produkt: <a href="{$LINK}">{$PRODUCTS_NAME} ({$PRODUCTS_MODEL})</a> ist nur noch <b>{$PRODUCTS_QUANTITY}</b> mal auf Lager.<br /><br />\r\n\r\nViele Gr&uuml;ße,<br />\r\nIhr Shop</td>\r\n </tr>\r\n</table>\r\n', 'Melden sie sich hier an: {$LOGIN}\r\n------------------------------------------------------\r\n{if $GENDER}Sehr geehrte{if $GENDER eq ''m''}r Herr{elseif $GENDER eq ''f''} Frau{else}(r) {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Hallo,{/if}\r\n\r\n{if $NEW == true}vielen Dank für Ihren Besuch bei {$STORE_NAME} und Ihr uns entgegen gebrachtes Vertrauen.\r\n{else}vielen Dank für Ihren erneuten Besuch bei {$STORE_NAME} und Ihr wiederholtes uns entgegen gebrachtes Vertrauen.{/if}\r\n\r\nWir haben gesehen, daß Sie bei Ihrem Besuch in unserem Onlineshop den Warenkorb mit folgenden Artikeln gefüllt haben, aber den Einkauf nicht vollständig durchgeführt haben.\r\n\r\nInhalt Ihres Warenkorbes:\r\n\r\n{foreach name=outer item=product from=$products_data}\r\n{$product.QUANTITY} x {$product.NAME}\r\n {$product.LINK}\r\n{/foreach}\r\n\r\nWir sind immer bemüht, unseren Service im Interesse unserer Kunden zu verbessern.\r\nAus diesem Grund interessiert es uns natürlich, was die Ursachen dafür waren, Ihren Einkauf dieses Mal nicht bei {$STORE_NAME} zu tätigen.\r\nWir sind Ihnen daher sehr dankbar, wenn Sie uns mitteilen, ob Sie bei Ihrem Besuch in unserem Onlineshop Probleme oder Bedenken hatten, den Einkauf erfolgreich abzuschließen.\r\nUnser Ziel ist es, Ihnen und anderen Kunden, den Einkauf bei {$STORE_NAME} leichter und besser zu gestalten.\r\n\r\nNochmals vielen Dank für Ihre Zeit und Ihre Hilfe, den Onlineshop von {$STORE_NAME} zu verbessern.\r\n\r\nMit freundlichen Grüßen\r\n\r\nIhr Team von {$STORE_NAME}\r\n{if $MESSAGE}\r\n\r\n{$MESSAGE}\r\n{/if}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellstatusänderung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Lagerwarnung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td>Sie wollten gewarnt werden, wenn ein Produkt in Ihrem Shop den Lagerbestand von <b>{$STOCK_AMOUNT}</b> unterschreitet.<br /><br />\r\n\r\nDas Produkt: <a href="{$LINK}">{$PRODUCTS_NAME} ({$PRODUCTS_MODEL})</a> ist nur noch <b>{$PRODUCTS_QUANTITY}</b> mal auf Lager.<br /><br />\r\n\r\nViele Gr&uuml;ße,<br />\r\nIhr Shop</td>\r\n </tr>\r\n</table>\r\n', 'Melden sie sich hier an: {$LOGIN}\r\n------------------------------------------------------\r\n{if $GENDER}Sehr geehrte{if $GENDER eq ''m''}r Herr{elseif $GENDER eq ''f''} Frau{else}(r) {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Hallo,{/if}\r\n\r\n{if $NEW == true}vielen Dank für Ihren Besuch bei {$STORE_NAME} und Ihr uns entgegen gebrachtes Vertrauen.\r\n{else}vielen Dank für Ihren erneuten Besuch bei {$STORE_NAME} und Ihr wiederholtes uns entgegen gebrachtes Vertrauen.{/if}\r\n\r\nWir haben gesehen, daß Sie bei Ihrem Besuch in unserem Onlineshop den Warenkorb mit folgenden Artikeln gefüllt haben, aber den Einkauf nicht vollständig durchgeführt haben.\r\n\r\nInhalt Ihres Warenkorbes:\r\n\r\n{foreach name=outer item=product from=$products_data}\r\n{$product.QUANTITY} x {$product.NAME}\r\n {$product.LINK}\r\n{/foreach}\r\n\r\nWir sind immer bemüht, unseren Service im Interesse unserer Kunden zu verbessern.\r\nAus diesem Grund interessiert es uns natürlich, was die Ursachen dafür waren, Ihren Einkauf dieses Mal nicht bei {$STORE_NAME} zu tätigen.\r\nWir sind Ihnen daher sehr dankbar, wenn Sie uns mitteilen, ob Sie bei Ihrem Besuch in unserem Onlineshop Probleme oder Bedenken hatten, den Einkauf erfolgreich abzuschließen.\r\nUnser Ziel ist es, Ihnen und anderen Kunden, den Einkauf bei {$STORE_NAME} leichter und besser zu gestalten.\r\n\r\nNochmals vielen Dank für Ihre Zeit und Ihre Hilfe, den Onlineshop von {$STORE_NAME} zu verbessern.\r\n\r\nMit freundlichen Grüßen\r\n\r\nIhr Team von {$STORE_NAME}\r\n{if $MESSAGE}\r\n\r\n{$MESSAGE}\r\n{/if}', 1263483589);




INSERT INTO emails VALUES(NULL, 'cart_mail', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Bestellung abschliessen', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Gutschein</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;">\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Gutschein\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n {if $GENDER}\r\n Sehr geehrte{if $GENDER eq ''m''}r Herr\r\n {elseif $GENDER eq ''f''} Frau\r\n {else}(r) {$FIRSTNAME}\r\n {/if} {$LASTNAME},\r\n {else}\r\n Hallo,\r\n {/if}\r\n \r\n <p>{if $NEW == true}vielen Dank für Ihren Besuch bei {$STORE_NAME} und Ihr uns entgegen gebrachtes Vertrauen.\r\n {else}vielen Dank für Ihren erneuten Besuch bei {$STORE_NAME} und Ihr wiederholtes uns entgegen gebrachtes Vertrauen.{/if}</p>\r\n \r\n <p>Wir haben gesehen, daß Sie bei Ihrem Besuch in unserem Onlineshop den Warenkorb mit folgenden Artikeln gefüllt haben, aber den Einkauf nicht vollständig durchgeführt haben.</p>\r\n \r\n <p>Inhalt Ihres Warenkorbes:</p>\r\n <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="f1f1f1" class="outerTable">\r\n <tr class="ProductsTable">\r\n  <td align="left" class="bb br">&nbsp;\r\n  \r\n  </td>\r\n  <td align="center" class="bb br">\r\n  <strong>Anzahl</strong>\r\n  </td>\r\n  <td align="right" class="bb">\r\n  <strong>Artikel</strong>\r\n  </td>\r\n  </tr>\r\n {foreach name=outer item=product from=$products_data}\r\n  <tr>\r\n  <td valign="top" class="bb br ProductsName">\r\n  <img src="{$product.IMAGE}" alt="{$product.NAME}" />\r\n  </td>\r\n  <td valign="top" class="bb br ProductsName" align="center"><strong>{$product.QUANTITY} x</strong></td>\r\n  <td valign="top" class="bb" align="right">\r\n  <strong>{$product.NAME}</strong><br />\r\n  <em><a href="{$product.LINK}">{$product.LINK}</a></em>\r\n  </td>\r\n  </tr>\r\n {/foreach}\r\n </table><br />\r\n <p>Wir sind immer bemüht, unseren Service im Interesse unserer Kunden zu verbessern.\r\n Aus diesem Grund interessiert es uns natürlich, was die Ursachen dafür waren, Ihren Einkauf dieses Mal nicht bei {$STORE_NAME} zu tätigen.\r\n Wir sind Ihnen daher sehr dankbar, wenn Sie uns mitteilen, ob Sie bei Ihrem Besuch in unserem Onlineshop Probleme oder Bedenken hatten, den Einkauf erfolgreich abzuschließen.\r\n Unser Ziel ist es, Ihnen und anderen Kunden, den Einkauf bei {$STORE_NAME} leichter und besser zu gestalten.</p><br />\r\n \r\n Um Ihren Einkauf nun abzuschließen, melden sie sich bitte hier an: <a href="{$LOGIN}">{$LOGIN}</a><br />\r\n \r\n <p>Nochmals vielen Dank für Ihre Zeit und Ihre Hilfe, den Onlineshop von {$STORE_NAME} zu verbessern.</p>\r\n \r\n <p>Mit freundlichen Grüßen</p>\r\n \r\n <p>Ihr Team von <a href="{$STORE_LINK}">{$STORE_NAME}</a></p>\r\n {if $MESSAGE}\r\n <p>{$MESSAGE}</p>\r\n {/if}\r\n </td>\r\n </tr>\r\n</table>', 'Melden sie sich hier an: {$LOGIN}\r\n------------------------------------------------------\r\n{if $GENDER}Sehr geehrte{if $GENDER eq ''m''}r Herr{elseif $GENDER eq ''f''} Frau{else}(r) {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Hallo,{/if}\r\n\r\n{if $NEW == true}vielen Dank für Ihren Besuch bei {$STORE_NAME} und Ihr uns entgegen gebrachtes Vertrauen.\r\n{else}vielen Dank für Ihren erneuten Besuch bei {$STORE_NAME} und Ihr wiederholtes uns entgegen gebrachtes Vertrauen.{/if}\r\n\r\nWir haben gesehen, daß Sie bei Ihrem Besuch in unserem Onlineshop den Warenkorb mit folgenden Artikeln gefüllt haben, aber den Einkauf nicht vollständig durchgeführt haben.\r\n\r\nInhalt Ihres Warenkorbes:\r\n\r\n{foreach name=outer item=product from=$products_data}\r\n{$product.QUANTITY} x {$product.NAME}\r\n {$product.LINK}\r\n{/foreach}\r\n\r\nWir sind immer bemüht, unseren Service im Interesse unserer Kunden zu verbessern.\r\nAus diesem Grund interessiert es uns natürlich, was die Ursachen dafür waren, Ihren Einkauf dieses Mal nicht bei {$STORE_NAME} zu tätigen.\r\nWir sind Ihnen daher sehr dankbar, wenn Sie uns mitteilen, ob Sie bei Ihrem Besuch in unserem Onlineshop Probleme oder Bedenken hatten, den Einkauf erfolgreich abzuschließen.\r\nUnser Ziel ist es, Ihnen und anderen Kunden, den Einkauf bei {$STORE_NAME} leichter und besser zu gestalten.\r\n\r\nNochmals vielen Dank für Ihre Zeit und Ihre Hilfe, den Onlineshop von {$STORE_NAME} zu verbessern.\r\n\r\nMit freundlichen Grüßen\r\n\r\nIhr Team von {$STORE_NAME}\r\n{if $MESSAGE}\r\n\r\n{$MESSAGE}\r\n{/if}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Gutschein</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;">\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Gutschein\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n {if $GENDER}\r\n Sehr geehrte{if $GENDER eq ''m''}r Herr\r\n {elseif $GENDER eq ''f''} Frau\r\n {else}(r) {$FIRSTNAME}\r\n {/if} {$LASTNAME},\r\n {else}\r\n Hallo,\r\n {/if}\r\n \r\n <p>{if $NEW == true}vielen Dank für Ihren Besuch bei {$STORE_NAME} und Ihr uns entgegen gebrachtes Vertrauen.\r\n {else}vielen Dank für Ihren erneuten Besuch bei {$STORE_NAME} und Ihr wiederholtes uns entgegen gebrachtes Vertrauen.{/if}</p>\r\n \r\n <p>Wir haben gesehen, daß Sie bei Ihrem Besuch in unserem Onlineshop den Warenkorb mit folgenden Artikeln gefüllt haben, aber den Einkauf nicht vollständig durchgeführt haben.</p>\r\n \r\n <p>Inhalt Ihres Warenkorbes:</p>\r\n <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="f1f1f1" class="outerTable">\r\n <tr class="ProductsTable">\r\n  <td align="left" class="bb br">&nbsp;\r\n  \r\n  </td>\r\n  <td align="center" class="bb br">\r\n  <strong>Anzahl</strong>\r\n  </td>\r\n  <td align="right" class="bb">\r\n  <strong>Artikel</strong>\r\n  </td>\r\n  </tr>\r\n {foreach name=outer item=product from=$products_data}\r\n  <tr>\r\n  <td valign="top" class="bb br ProductsName">\r\n  <img src="{$product.IMAGE}" alt="{$product.NAME}" />\r\n  </td>\r\n  <td valign="top" class="bb br ProductsName" align="center"><strong>{$product.QUANTITY} x</strong></td>\r\n  <td valign="top" class="bb" align="right">\r\n  <strong>{$product.NAME}</strong><br />\r\n  <em><a href="{$product.LINK}">{$product.LINK}</a></em>\r\n  </td>\r\n  </tr>\r\n {/foreach}\r\n </table><br />\r\n <p>Wir sind immer bemüht, unseren Service im Interesse unserer Kunden zu verbessern.\r\n Aus diesem Grund interessiert es uns natürlich, was die Ursachen dafür waren, Ihren Einkauf dieses Mal nicht bei {$STORE_NAME} zu tätigen.\r\n Wir sind Ihnen daher sehr dankbar, wenn Sie uns mitteilen, ob Sie bei Ihrem Besuch in unserem Onlineshop Probleme oder Bedenken hatten, den Einkauf erfolgreich abzuschließen.\r\n Unser Ziel ist es, Ihnen und anderen Kunden, den Einkauf bei {$STORE_NAME} leichter und besser zu gestalten.</p><br />\r\n \r\n Um Ihren Einkauf nun abzuschließen, melden sie sich bitte hier an: <a href="{$LOGIN}">{$LOGIN}</a><br />\r\n \r\n <p>Nochmals vielen Dank für Ihre Zeit und Ihre Hilfe, den Onlineshop von {$STORE_NAME} zu verbessern.</p>\r\n \r\n <p>Mit freundlichen Grüßen</p>\r\n \r\n <p>Ihr Team von <a href="{$STORE_LINK}">{$STORE_NAME}</a></p>\r\n {if $MESSAGE}\r\n <p>{$MESSAGE}</p>\r\n {/if}\r\n </td>\r\n </tr>\r\n</table>', 'Melden sie sich hier an: {$LOGIN}\r\n------------------------------------------------------\r\n{if $GENDER}Sehr geehrte{if $GENDER eq ''m''}r Herr{elseif $GENDER eq ''f''} Frau{else}(r) {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Hallo,{/if}\r\n\r\n{if $NEW == true}vielen Dank für Ihren Besuch bei {$STORE_NAME} und Ihr uns entgegen gebrachtes Vertrauen.\r\n{else}vielen Dank für Ihren erneuten Besuch bei {$STORE_NAME} und Ihr wiederholtes uns entgegen gebrachtes Vertrauen.{/if}\r\n\r\nWir haben gesehen, daß Sie bei Ihrem Besuch in unserem Onlineshop den Warenkorb mit folgenden Artikeln gefüllt haben, aber den Einkauf nicht vollständig durchgeführt haben.\r\n\r\nInhalt Ihres Warenkorbes:\r\n\r\n{foreach name=outer item=product from=$products_data}\r\n{$product.QUANTITY} x {$product.NAME}\r\n {$product.LINK}\r\n{/foreach}\r\n\r\nWir sind immer bemüht, unseren Service im Interesse unserer Kunden zu verbessern.\r\nAus diesem Grund interessiert es uns natürlich, was die Ursachen dafür waren, Ihren Einkauf dieses Mal nicht bei {$STORE_NAME} zu tätigen.\r\nWir sind Ihnen daher sehr dankbar, wenn Sie uns mitteilen, ob Sie bei Ihrem Besuch in unserem Onlineshop Probleme oder Bedenken hatten, den Einkauf erfolgreich abzuschließen.\r\nUnser Ziel ist es, Ihnen und anderen Kunden, den Einkauf bei {$STORE_NAME} leichter und besser zu gestalten.\r\n\r\nNochmals vielen Dank für Ihre Zeit und Ihre Hilfe, den Onlineshop von {$STORE_NAME} zu verbessern.\r\n\r\nMit freundlichen Grüßen\r\n\r\nIhr Team von {$STORE_NAME}\r\n{if $MESSAGE}\r\n\r\n{$MESSAGE}\r\n{/if}', 1263483589);
INSERT INTO emails VALUES(NULL, 'change_order', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Statusänderung Ihrer Bestellung Nr: {$nr} vom {$date}', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellstatusänderung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Bestellstatusänderung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td><strong>Sehr geehrter Kunde, </strong><br>\r\n <br>\r\n Der Status Ihrer Bestellung Nr:{$ORDER_NR} vom {$ORDER_DATE} wurde geändert.<br /> \r\n {if $NOTIFY_COMMENTS}<br />\r\n  Anmerkungen und Kommentare zu Ihrer Bestellung:<br />\r\n {$NOTIFY_COMMENTS}<br />\r\n {/if}\r\n <br />\r\n Neuer Status: <b>{$ORDER_STATUS}</b><br />\r\n Hier gelangen Sie zu der Übersicht Ihrer Bestellung:<br />\r\n <a href="{$ORDER_LINK}">{$ORDER_LINK}</a><br /><br />\r\n Bei Fragen zu Ihrer Bestellung antworten Sie bitte auf diese eMail.</td>\r\n </tr>\r\n</table>', 'Sehr geehrter Kunde,\r\n\r\nDer Status Ihrer Bestellung wurde geändert.\r\n\r\n{if $NOTIFY_COMMENTS}Anmerkungen und Kommentare zu Ihrer Bestellung:{$NOTIFY_COMMENTS}{/if}\r\n\r\nNeuer Status: {$ORDER_STATUS}\r\n\r\nBei Fragen zu Ihrer Bestellung antworten Sie bitte auf diese eMail.', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellbestätigung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif" alt="" /></div></td>\r\n </tr>\r\n <tr> \r\n <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Sehr geehrter Kunde, </strong><br>\r\n <br>\r\n Der Status Ihrer Bestellung Nr:{$ORDER_NR} vom {$ORDER_DATE} wurde geändert.<br> \r\n {if $NOTIFY_COMMENTS}<br>\r\nAnmerkungen und Kommentare zu Ihrer Bestellung: \r\n{$NOTIFY_COMMENTS}\r\n<br>{/if}\r\n<br>\r\nNeuer Status: \r\n<b>{$ORDER_STATUS}</b>\r\n<br />\r\nHier gelangen Sie zu der Übersicht Ihrer Bestellung:<br />\r\n<a href="{$ORDER_LINK}">{$ORDER_LINK}</a>\r\n<br /><br />\r\nBei Fragen zu Ihrer Bestellung antworten Sie bitte auf diese eMail. </font></td>\r\n </tr>\r\n</table>', 'Sehr geehrter Kunde,\r\n\r\nDer Status Ihrer Bestellung wurde geändert.\r\n\r\n{if $NOTIFY_COMMENTS}Anmerkungen und Kommentare zu Ihrer Bestellung:{$NOTIFY_COMMENTS}{/if}\r\n\r\nNeuer Status: {$ORDER_STATUS}\r\n\r\nBei Fragen zu Ihrer Bestellung antworten Sie bitte auf diese eMail.', 1263483589);
INSERT INTO emails VALUES(NULL, 'change_password', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Änderung ihres Passwortes', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>neues Passwort</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td colspan="2">\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  neues Passwort\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td colspan="2">\r\n <p><strong>Sehr geehrter Kunde,</strong></p>\r\n <p>Ihr Passwort wurde erfolgreich geändert.<br /><br />\r\n Ihre neuen Logindaten:</p>\r\n </td>\r\n </tr> \r\n <tr class="lightBackground">\r\n <td width="1">\r\n <nobr><strong>Ihre Email:</strong></nobr>\r\n </td>\r\n <td>\r\n {$EMAIL}\r\n </td>\r\n </tr>\r\n <tr class="lightBackground">\r\n <td width="1">\r\n <nobr><strong>Ihr neues Passwort:</strong></nobr>\r\n </td>\r\n <td>\r\n {$PASSWORD}\r\n </td>\r\n </tr>\r\n</table>', 'Sehr geehrter Kunde,\r\n\r\nIhr Passwort wurde erfolgreich geändert.\r\n\r\nIhre neuen Logindaten:\r\n \r\nIhre Mail: {$EMAIL}\r\nIhr Passwort: {$PASSWORD}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>neues Passwort</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td colspan="2">\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  neues Passwort\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td colspan="2">\r\n <p><strong>Sehr geehrter Kunde,</strong></p>\r\n <p>Ihr Passwort wurde erfolgreich geändert.<br /><br />\r\n Ihre neuen Logindaten:</p>\r\n </td>\r\n </tr> \r\n <tr class="lightBackground">\r\n <td width="1">\r\n <nobr><strong>Ihre Email:</strong></nobr>\r\n </td>\r\n <td>\r\n {$EMAIL}\r\n </td>\r\n </tr>\r\n <tr class="lightBackground">\r\n <td width="1">\r\n <nobr><strong>Ihr neues Passwort:</strong></nobr>\r\n </td>\r\n <td>\r\n {$PASSWORD}\r\n </td>\r\n </tr>\r\n</table>', 'Sehr geehrter Kunde,\r\n\r\nIhr Passwort wurde erfolgreich geändert.\r\n\r\nIhre neuen Logindaten:\r\n \r\nIhre Mail: {$EMAIL}\r\nIhr Passwort: {$PASSWORD}', 1263483589);
INSERT INTO emails VALUES(NULL, 'contact', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Kontaktanfrage von mail-adresse.de', '', '', '', '', '', 1263483589);
INSERT INTO emails VALUES(NULL, 'create_account', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Bestätigung Kundenkonto', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Kontoeröffnung</title>\r\n{literal}\r\n<style type="text/css"> \r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Kontoeröffnung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td><br />\r\n <strong>Sehr {if $GENDER ==''f''}geehrte Frau {$NNAME}{elseif $GENDER == ''m''}geehrter Herr {$NNAME}{else} geehrter Kunde{/if},</strong><br /><br />\r\n Sie haben soeben Ihr Kundenkonto mit folgendem Zugang erfolgreich erstellt:<br /><br />\r\n <table width="100%" border="0" cellpadding="10" cellspacing="5" align="center" class="outerTable ">\r\n <tr class="lightBackground">\r\n  <td width="1"><nobr>Ihre Mailaddresse für die Shopanmeldung:</nobr></td>\r\n  <td>{$USERNAME4MAIL}</td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td width="1"><nobr>Das dazugehörige Passwort:</nobr></td>\r\n  <td>{$PASSWORT4MAIL}</td>\r\n </tr>\r\n </table><br /><br />\r\n Als registrierter Kunde haben sie folgende Vorteile in unserem Shop.<br /><br />\r\n <b>- Kundenwarenkorb</b> - Jeder Artikel bleibt registriert bis Sie zur Kasse gehen, oder die Produkte aus dem Warenkorb entfernen.<br />\r\n <b>- Adressbuch</b> - Wir können jetzt die Produkte zu der von Ihnen ausgesuchten Adresse senden. Der perfekte Weg ein Geburtstagsgeschenk zu versenden.<br />\r\n <b>- Vorherige Bestellungen</b> - Sie können jederzeit Ihre vorherigen Bestellungen überprüfen.<br />\r\n <b>- Meinungen über Produkte</b> - Teilen Sie Ihre Meinung zu unseren Produkten mit anderen Kunden.<br /><br />\r\n \r\n {if $SEND_GIFT==true}\r\n Als kleines Willkommensgeschenk senden wir Ihnen einen Gutschein über: <b>{$GIFT_AMMOUNT}</b><br /><br />\r\n Ihr persönlicher Gutscheincode lautet <b>{$GIFT_CODE}</b>. Sie können diese Gutschrift an der Kasse während des Bestellvorganges verbuchen.<br /><br />\r\n Um den Gutschein einzulösen klichen Sie bitte auf <a href="{$GIFT_LINK}">[Gutschein Einlösen]</a>.<br /><br />\r\n {/if}\r\n {if $SEND_COUPON==true}\r\n Als kleines Willkommensgeschenk senden wir Ihnen einen Coupon.<br />\r\n Kuponbeschreibung: <b>{$COUPON_DESC}</b><br />\r\n Geben Sie einfach Ihren persönlichen Code {$COUPON_CODE} während des Bezahlvorganges ein<br /><br />\r\n {/if}\r\n <br />\r\n <em>Falls Sie Fragen zu unserem Kunden-Service haben, wenden Sie sich bitte an: \r\n <a href="mailto:{$MAIL_REPLY_ADDRESS}">{$MAIL_REPLY_ADDRESS}</a>.<br /><br />\r\n Achtung: Diese eMail-Adresse wurde uns von einem Kunden bekannt gegeben. Falls Sie sich nicht angemeldet haben, senden Sie bitte eine eMail an \r\n <a href="mailto:{$MAIL_REPLY_ADDRESS}">{$MAIL_REPLY_ADDRESS}</a>.</em><br /><br />\r\n </td>\r\n </tr>\r\n</table>', 'Sehr geehrter Kunde,\r\n\r\nSie haben soeben Ihr Kundenkonto erfolgreich erstellt, als registrierter Kunde haben sie folgende Vorteile in unserem Shop. \r\n\r\n-Kundenwarenkorb - Jeder Artikel bleibt registriert bis Sie zur Kasse gehen, oder die Produkte aus dem Warenkorb entfernen.\r\n-Adressbuch - Wir können jetzt die Produkte zu der von Ihnen ausgesuchten Adresse senden. Der perfekte Weg ein Geburtstagsgeschenk zu versenden.\r\n-Vorherige Bestellungen - Sie können jederzeit Ihre vorherigen Bestellungen überprüfen.\r\n-Meinungen über Produkte - Teilen Sie Ihre Meinung zu unseren Produkten mit anderen Kunden. \r\n\r\nFalls Sie Fragen zu unserem Kunden-Service haben, wenden Sie sich bitte an: {#support_mail_address#}\r\n\r\n\r\nAchtung: Diese eMail-Adresse wurde uns von einem Kunden bekannt gegeben. Falls Sie sich nicht angemeldet haben, senden Sie bitte eine eMail an: {#support_mail_address#}\r\n \r\n{if $SEND_GIFT==true}\r\nAls kleines Willkommensgeschenk senden wir Ihnen einen Gutschein über:	{$GIFT_AMMOUNT}\r\n\r\nIhr persönlicher Gutscheincode lautet {$GIFT_CODE}. \r\nSie können diese Gutschrift an der Kasse während des Bestellvorganges verbuchen.\r\n\r\nUm den Gutschein einzulösen verwenden Sie bitte den folgenden link {$GIFT_LINK}.\r\n{/if}\r\n\r\n{if $SEND_COUPON==true}\r\n Als kleines Willkommensgeschenk senden wir Ihnen einen Kupon.\r\n Kuponbeschreibung: {$COUPON_DESC}\r\n \r\nGeben Sie einfach Ihren persönlichen Code {$COUPON_CODE} während des Bezahlvorganges ein\r\n\r\n{/if}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Kontoeröffnung</title>\r\n{literal}\r\n<style type="text/css"> \r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Kontoeröffnung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td><br />\r\n <strong>Sehr {if $GENDER ==''f''}geehrte Frau {$NNAME}{elseif $GENDER == ''m''}geehrter Herr {$NNAME}{else} geehrter Kunde{/if},</strong><br /><br />\r\n Sie haben soeben Ihr Kundenkonto mit folgendem Zugang erfolgreich erstellt:<br /><br />\r\n <table width="100%" border="0" cellpadding="10" cellspacing="5" align="center" class="outerTable ">\r\n <tr class="lightBackground">\r\n  <td width="1"><nobr>Ihre Mailaddresse für die Shopanmeldung:</nobr></td>\r\n  <td>{$USERNAME4MAIL}</td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td width="1"><nobr>Das dazugehörige Passwort:</nobr></td>\r\n  <td>{$PASSWORT4MAIL}</td>\r\n </tr>\r\n </table><br /><br />\r\n Als registrierter Kunde haben sie folgende Vorteile in unserem Shop.<br /><br />\r\n <b>- Kundenwarenkorb</b> - Jeder Artikel bleibt registriert bis Sie zur Kasse gehen, oder die Produkte aus dem Warenkorb entfernen.<br />\r\n <b>- Adressbuch</b> - Wir können jetzt die Produkte zu der von Ihnen ausgesuchten Adresse senden. Der perfekte Weg ein Geburtstagsgeschenk zu versenden.<br />\r\n <b>- Vorherige Bestellungen</b> - Sie können jederzeit Ihre vorherigen Bestellungen überprüfen.<br />\r\n <b>- Meinungen über Produkte</b> - Teilen Sie Ihre Meinung zu unseren Produkten mit anderen Kunden.<br /><br />\r\n \r\n {if $SEND_GIFT==true}\r\n Als kleines Willkommensgeschenk senden wir Ihnen einen Gutschein über: <b>{$GIFT_AMMOUNT}</b><br /><br />\r\n Ihr persönlicher Gutscheincode lautet <b>{$GIFT_CODE}</b>. Sie können diese Gutschrift an der Kasse während des Bestellvorganges verbuchen.<br /><br />\r\n Um den Gutschein einzulösen klichen Sie bitte auf <a href="{$GIFT_LINK}">[Gutschein Einlösen]</a>.<br /><br />\r\n {/if}\r\n {if $SEND_COUPON==true}\r\n Als kleines Willkommensgeschenk senden wir Ihnen einen Coupon.<br />\r\n Kuponbeschreibung: <b>{$COUPON_DESC}</b><br />\r\n Geben Sie einfach Ihren persönlichen Code {$COUPON_CODE} während des Bezahlvorganges ein<br /><br />\r\n {/if}\r\n <br />\r\n <em>Falls Sie Fragen zu unserem Kunden-Service haben, wenden Sie sich bitte an: \r\n <a href="mailto:{$MAIL_REPLY_ADDRESS}">{$MAIL_REPLY_ADDRESS}</a>.<br /><br />\r\n Achtung: Diese eMail-Adresse wurde uns von einem Kunden bekannt gegeben. Falls Sie sich nicht angemeldet haben, senden Sie bitte eine eMail an \r\n <a href="mailto:{$MAIL_REPLY_ADDRESS}">{$MAIL_REPLY_ADDRESS}</a>.</em><br /><br />\r\n </td>\r\n </tr>\r\n</table>', 'Sehr geehrter Kunde,\r\n\r\nSie haben soeben Ihr Kundenkonto erfolgreich erstellt, als registrierter Kunde haben sie folgende Vorteile in unserem Shop. \r\n\r\n-Kundenwarenkorb - Jeder Artikel bleibt registriert bis Sie zur Kasse gehen, oder die Produkte aus dem Warenkorb entfernen.\r\n-Adressbuch - Wir können jetzt die Produkte zu der von Ihnen ausgesuchten Adresse senden. Der perfekte Weg ein Geburtstagsgeschenk zu versenden.\r\n-Vorherige Bestellungen - Sie können jederzeit Ihre vorherigen Bestellungen überprüfen.\r\n-Meinungen über Produkte - Teilen Sie Ihre Meinung zu unseren Produkten mit anderen Kunden. \r\n\r\nFalls Sie Fragen zu unserem Kunden-Service haben, wenden Sie sich bitte an: {#support_mail_address#}\r\n\r\n\r\nAchtung: Diese eMail-Adresse wurde uns von einem Kunden bekannt gegeben. Falls Sie sich nicht angemeldet haben, senden Sie bitte eine eMail an: {#support_mail_address#}\r\n \r\n{if $SEND_GIFT==true}\r\nAls kleines Willkommensgeschenk senden wir Ihnen einen Gutschein über:	{$GIFT_AMMOUNT}\r\n\r\nIhr persönlicher Gutscheincode lautet {$GIFT_CODE}. \r\nSie können diese Gutschrift an der Kasse während des Bestellvorganges verbuchen.\r\n\r\nUm den Gutschein einzulösen verwenden Sie bitte den folgenden link {$GIFT_LINK}.\r\n{/if}\r\n\r\n{if $SEND_COUPON==true}\r\n Als kleines Willkommensgeschenk senden wir Ihnen einen Kupon.\r\n Kuponbeschreibung: {$COUPON_DESC}\r\n \r\nGeben Sie einfach Ihren persönlichen Code {$COUPON_CODE} während des Bezahlvorganges ein\r\n\r\n{/if}', 1263483589);
INSERT INTO emails VALUES(NULL, 'create_account_admin', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Ihr neues Kundenkonto', '', '<!DOCTYPE html>\r\n<html dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>neues Konto erstellt</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Ihr neues Kundenkonto\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td><br />\r\n <strong>Sehr {if $GENDER ==''f''}geehrte Frau {$NNAME}{elseif $GENDER == ''m''}geehrter Herr {$NNAME}{else} geehrter Kunde{/if},</strong><br /><br />Wir haben gerade einen Account für Sie eingerichtet, Sie können sich mit folgenden Daten in Unseren Shop einloggen. <br /><br />\r\n  {if $COMMENTS} Anmerkungen: {$COMMENTS} <br /><br />{/if}\r\n Ihre Logindaten für unseren Shop:<br>\r\n <table width="100%" border="0" cellpadding="10" cellspacing="5" align="center" class="outerTable ">\r\n <tr class="ProductsTable">\r\n  <td width="1"><nobr>Ihre Mailaddresse für die Shopanmeldung:</nobr></td>\r\n  <td>{$USERNAME4MAIL}</td>\r\n </tr>\r\n <tr class="ProductsTable">\r\n  <td width="1"><nobr>Das dazugehörige Passwort:</nobr></td>\r\n  <td>{$PASSWORT4MAIL}</td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n</table>', 'Sehr {if $GENDER ==''f''}geehrte Frau {$NNAME}{elseif $GENDER == ''m''}geehrter Herr {$NNAME}{else} geehrter Kunde{/if},\r\n\r\nWir haben gerade einen Account für Sie eingerichtet, Sie können sich mit folgenden Daten in Unseren Shop einloggen. \r\n\r\nIhre Logindaten für unseren Shop:\r\n\r\nIhre Mailaddresse für die Shopanmeldung: {$USERNAME4MAIL}\r\n\r\nDas dazugehörige Passwort: {$PASSWORT4MAIL}\r\n\r\n{if $COMMENTS}Anmerkungen: {$COMMENTS}{/if}', '<!DOCTYPE html>\r\n<html dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>neues Konto erstellt</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Ihr neues Kundenkonto\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td><br />\r\n <strong>Sehr {if $GENDER ==''f''}geehrte Frau {$NNAME}{elseif $GENDER == ''m''}geehrter Herr {$NNAME}{else} geehrter Kunde{/if},</strong><br /><br />Wir haben gerade einen Account für Sie eingerichtet, Sie können sich mit folgenden Daten in Unseren Shop einloggen. <br /><br />\r\n  {if $COMMENTS} Anmerkungen: {$COMMENTS} <br /><br />{/if}\r\n Ihre Logindaten für unseren Shop:<br>\r\n <table width="100%" border="0" cellpadding="10" cellspacing="5" align="center" class="outerTable ">\r\n <tr class="ProductsTable">\r\n  <td width="1"><nobr>Ihre Mailaddresse für die Shopanmeldung:</nobr></td>\r\n  <td>{$USERNAME4MAIL}</td>\r\n </tr>\r\n <tr class="ProductsTable">\r\n  <td width="1"><nobr>Das dazugehörige Passwort:</nobr></td>\r\n  <td>{$PASSWORT4MAIL}</td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n</table>', 'Sehr {if $GENDER ==''f''}geehrte Frau {$NNAME}{elseif $GENDER == ''m''}geehrter Herr {$NNAME}{else} geehrter Kunde{/if},\r\n\r\nWir haben gerade einen Account für Sie eingerichtet, Sie können sich mit folgenden Daten in Unseren Shop einloggen. \r\n\r\nIhre Logindaten für unseren Shop:\r\n\r\nIhre Mailaddresse für die Shopanmeldung: {$USERNAME4MAIL}\r\n\r\nDas dazugehörige Passwort: {$PASSWORT4MAIL}\r\n\r\n{if $COMMENTS}Anmerkungen: {$COMMENTS}{/if}', 12345612);
INSERT INTO emails VALUES(NULL, 'gift_accepted', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', '', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellbestätigung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr>\r\n <td><strong>Sehr geehrter Kunde,</strong><br /><br />\r\n Sie haben kürzlich in unserem Online-Shop einen Gutschein bestellt, welcher aus Sicherheitsgründen nicht sofort freigeschaltet wurde.<br />\r\n Dieses Guthaben steht Ihnen nun zur Verfügung. Sie können Ihren Gutschein verbuchen und per E-Mail versenden Der von Ihnen bestellte Gutschein hat einen Wert von <strong>{$AMMOUNT}</strong>.\r\n </td>\r\n </tr>\r\n</table>', 'Sehr geehrter Kunde,\r\n\r\nSie haben kürzlich in unserem Online-Shop einen Gutschein bestellt,\r\nwelcher aus Sicherheitsgründen nicht sofort freigeschaltet wurde.\r\nDieses Guthaben steht Ihnen nun zur Verfügung.\r\nSie können Ihren Gutschein verbuchen und per E-Mail versenden Der von Ihnen bestellte Gutschein hat einen Wert von {$AMMOUNT}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellbestätigung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr>\r\n <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">\r\n <strong>Sehr geehrter Kunde,</strong></font> <br>\r\n <br>\r\n <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sie haben kürzlich in unserem Online-Shop einen Gutschein bestellt, welcher aus Sicherheitsgründen nicht sofort freigeschaltet wurde. Dieses Guthaben steht Ihnen nun zur Verfügung. Sie können Ihren Gutschein verbuchen und per E-Mail versenden Der von Ihnen bestellte Gutschein hat einen Wert von\r\n {$AMMOUNT}\r\n </font></td>\r\n </tr>\r\n</table>', 'Sehr geehrter Kunde,\r\n\r\nSie haben kürzlich in unserem Online-Shop einen Gutschein bestellt,\r\nwelcher aus Sicherheitsgründen nicht sofort freigeschaltet wurde.\r\nDieses Guthaben steht Ihnen nun zur Verfügung.\r\nSie können Ihren Gutschein verbuchen und per E-Mail versenden Der von Ihnen bestellte Gutschein hat einen Wert von {$AMMOUNT}', 1263483589);
INSERT INTO emails VALUES(NULL, 'newsletter', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', '', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Newsletter</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {\r\n font-size:11.5px;\r\n font-family:Helvetica, sans-serif;\r\n color:#444\r\n}\r\ntable.outerTable {\r\n border: 1px solid #ccc\r\n}\r\ntd.TopRightDesc {\r\n letter-spacing: 1px;\r\n font-weight: 600\r\n}\r\n.ProductsTable td {\r\n color:#6d88b1;\r\n background: #f1f1f1\r\n}\r\n.ProductsAttributes td, .ProductsName {\r\n background: #ffffff\r\n}\r\n.bt {\r\n border-top:1px solid #ccc\r\n}\r\n.bb {\r\n border-bottom:1px solid #ccc\r\n}\r\n.bl {\r\n border-left:1px solid #ccc\r\n}\r\n.br {\r\n border-right:1px solid #ccc\r\n}\r\n.fs85 {\r\n font-size:85%\r\n}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n <td width="50%"><img src="{$logo_path}logo.gif" alt="" /> </td>\r\n <td width="50%" class="TopRightDesc" align="right"> Newsletter </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <div style="width:95%; background-color:#fff; padding:10px;">\r\n <h2 style="border-bottom:2px solid #6a0101; padding-bottom:10px; color:#333;">{$SHOP_NAME} Newsletter</h2>\r\n <p><strong> {if $personalize == ''yes'' && $greeting_type == ''0''} {if $customers_gender == ''f''} Sehr geehrte Frau {$customers_name}, {else} Sehr geehrter Herr {$customers_name}, {/if} {/if} {if $personalize == ''yes'' && $greeting_type == ''1''} Hallo {$customers_name}, {/if} {if $personalize == ''''} Sehr geehrter Kunde, {/if} </strong></p>\r\n <p>{$body}</p>\r\n {if $gift_id}\r\n {if $greeting_type == ''1''}\r\n <table width="100%" style="border:1px #CCC; padding:10px; margin-bottom:15px; background-color:#ffeded;">\r\n <tr>\r\n <td><p style="padding-bottom:7px; margin:0 0 10px 0;"><strong style="font-family: Georgia, Times New Roman, Times, serif; font-size:12px;">Gutschein:</strong></p>\r\n  Als kleines Präsent übersenden wir Dir einen Gutschein in Höhe von <b>{$gift_ammount}</b>. <br />\r\n  Geb einfach bei der Bestellung deinen persönlichen Gutscheincode an: <b>{$gift_id}</b></td>\r\n </tr>\r\n </table>\r\n {else}\r\n <table width="100%" style="border:1px #CCC; padding:10px; margin-bottom:15px; background-color:#ffeded;">\r\n <tr>\r\n <td><p style="padding-bottom:7px; margin:0 0 10px 0;"><strong style="font-family: Georgia, Times New Roman, Times, serif; font-size:12px;">Gutschein:</strong></p>\r\n  Als kleines Präsent übersenden wir Ihnen einen Gutschein in Höhe von <b>{$gift_ammount}</b>. <br />\r\n  Geben Sie einfach bei der Bestellung Ihren persönlichen Gutscheincode an: <b>{$gift_id}</b></td>\r\n </tr>\r\n </table>\r\n {/if}\r\n {/if}\r\n <div style="background:#fff;">\r\n <table width="100%" cellpadding="0" cellspacing="0" border="0">\r\n <tr>\r\n <td>\r\n {foreach name=aussen item=module_data from=$module_content}\r\n  \r\n  <table width="100%" border="0" cellpadding="10" cellspacing="0" style="border-bottom:1px solid #999;">\r\n  <tr>\r\n  <td width="20%" rowspan="2" valign="top" style="border-right:1px solid #999;"><a href="{$module_data.PRODUCTS_LINK}"> <img src="{$module_data.PRODUCTS_IMAGE}" alt="{$module_data.PRODUCTS_NAME}" border="0" class"productImageBorder" /> </a> </td>\r\n  <td width="80%" valign="top"><a href="{$module_data.PRODUCTS_LINK}" style="text-decoration:none;">\r\n  <h1 style="font-size:12px; color:#6a0101;">{$module_data.PRODUCTS_NAME}</h1>\r\n  </a>{$module_data.PRODUCTS_SHORT_DESCRIPTION}\r\n  </td>\r\n  </tr>\r\n  <tr>\r\n  <td valign="bottom">\r\n  <div style="text-align:right; border-top:1px solid #000; padding-top:5px; margin-top:10px;">\r\n  <a href="{$module_data.PRODUCTS_LINK}" style="color:#6a0101; text-decoration:underline;"><b>Kaufen Sie jetzt hier!</b></a> | <strong>{$module_data.PRODUCTS_PRICE}</strong>\r\n  </div>\r\n  </td>\r\n  </tr>\r\n  </table>\r\n\r\n  {/foreach}\r\n  </td>\r\n  </tr>\r\n </table>\r\n <div style="text-align:right; font-size:10px; margin-top:10px;">{$remove_link}</div>\r\n </div>\r\n </div>\r\n </td>\r\n </tr>\r\n</table>', 'Shopname Newsletter\r\n\r\n{if $personalize == ''yes'' && $greeting_type == ''0''} {if $customers_gender == ''f''} Sehr geehrte Frau {$customers_name}, {else} Sehr geehrter Herr {$customers_name}, {/if} {/if} {if $personalize == ''yes'' && $greeting_type == ''1''} Hallo {$customers_name}, {/if} {if $personalize == ''''} Sehr geehrter Kunde, {/if}\r\n\r\n{$body}\r\n\r\n{if $gift_id} {if $greeting_type == ''1''} Gutschein:\r\n\r\nAls kleines Präsent übersenden wir Dir einen Gutschein in Höhe von {$gift_ammount}. Geb einfach bei der Bestellung deinen persönlichen Gutscheincode an: {$gift_id}\r\n\r\n{else} Gutschein:\r\n\r\nAls kleines Präsent übersenden wir Ihnen einen Gutschein in Höhe von {$gift_ammount}. Geben Sie einfach bei der Bestellung Ihren persönlichen Gutscheincode an: {$gift_id}\r\n\r\n{/if} {/if} {foreach name=aussen item=module_data from=$module_content}\r\n\r\n{$module_data.PRODUCTS_NAME}\r\n\r\n{$module_data.PRODUCTS_SHORT_DESCRIPTION}\r\n\r\nKaufen Sie jetzt! | {$module_data.PRODUCTS_PRICE} EUR \r\n\r\n{/foreach} {$remove_link}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Newsletter</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {\r\n font-size:11.5px;\r\n font-family:Helvetica, sans-serif;\r\n color:#444\r\n}\r\ntable.outerTable {\r\n border: 1px solid #ccc\r\n}\r\ntd.TopRightDesc {\r\n letter-spacing: 1px;\r\n font-weight: 600\r\n}\r\n.ProductsTable td {\r\n color:#6d88b1;\r\n background: #f1f1f1\r\n}\r\n.ProductsAttributes td, .ProductsName {\r\n background: #ffffff\r\n}\r\n.bt {\r\n border-top:1px solid #ccc\r\n}\r\n.bb {\r\n border-bottom:1px solid #ccc\r\n}\r\n.bl {\r\n border-left:1px solid #ccc\r\n}\r\n.br {\r\n border-right:1px solid #ccc\r\n}\r\n.fs85 {\r\n font-size:85%\r\n}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n <td width="50%"><img src="{$logo_path}logo.gif" alt="" /> </td>\r\n <td width="50%" class="TopRightDesc" align="right"> Newsletter </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <div style="width:95%; background-color:#fff; padding:10px;">\r\n <h2 style="border-bottom:2px solid #6a0101; padding-bottom:10px; color:#333;">{$SHOP_NAME} Newsletter</h2>\r\n <p><strong> {if $personalize == ''yes'' && $greeting_type == ''0''} {if $customers_gender == ''f''} Sehr geehrte Frau {$customers_name}, {else} Sehr geehrter Herr {$customers_name}, {/if} {/if} {if $personalize == ''yes'' && $greeting_type == ''1''} Hallo {$customers_name}, {/if} {if $personalize == ''''} Sehr geehrter Kunde, {/if} </strong></p>\r\n <p>{$body}</p>\r\n {if $gift_id}\r\n {if $greeting_type == ''1''}\r\n <table width="100%" style="border:1px #CCC; padding:10px; margin-bottom:15px; background-color:#ffeded;">\r\n <tr>\r\n <td><p style="padding-bottom:7px; margin:0 0 10px 0;"><strong style="font-family: Georgia, Times New Roman, Times, serif; font-size:12px;">Gutschein:</strong></p>\r\n  Als kleines Präsent übersenden wir Dir einen Gutschein in Höhe von <b>{$gift_ammount}</b>. <br />\r\n  Geb einfach bei der Bestellung deinen persönlichen Gutscheincode an: <b>{$gift_id}</b></td>\r\n </tr>\r\n </table>\r\n {else}\r\n <table width="100%" style="border:1px #CCC; padding:10px; margin-bottom:15px; background-color:#ffeded;">\r\n <tr>\r\n <td><p style="padding-bottom:7px; margin:0 0 10px 0;"><strong style="font-family: Georgia, Times New Roman, Times, serif; font-size:12px;">Gutschein:</strong></p>\r\n  Als kleines Präsent übersenden wir Ihnen einen Gutschein in Höhe von <b>{$gift_ammount}</b>. <br />\r\n  Geben Sie einfach bei der Bestellung Ihren persönlichen Gutscheincode an: <b>{$gift_id}</b></td>\r\n </tr>\r\n </table>\r\n {/if}\r\n {/if}\r\n <div style="background:#fff;">\r\n <table width="100%" cellpadding="0" cellspacing="0" border="0">\r\n <tr>\r\n <td>\r\n {foreach name=aussen item=module_data from=$module_content}\r\n  \r\n  <table width="100%" border="0" cellpadding="10" cellspacing="0" style="border-bottom:1px solid #999;">\r\n  <tr>\r\n  <td width="20%" rowspan="2" valign="top" style="border-right:1px solid #999;"><a href="{$module_data.PRODUCTS_LINK}"> <img src="{$module_data.PRODUCTS_IMAGE}" alt="{$module_data.PRODUCTS_NAME}" border="0" class"productImageBorder" /> </a> </td>\r\n  <td width="80%" valign="top"><a href="{$module_data.PRODUCTS_LINK}" style="text-decoration:none;">\r\n  <h1 style="font-size:12px; color:#6a0101;">{$module_data.PRODUCTS_NAME}</h1>\r\n  </a>{$module_data.PRODUCTS_SHORT_DESCRIPTION}\r\n  </td>\r\n  </tr>\r\n  <tr>\r\n  <td valign="bottom">\r\n  <div style="text-align:right; border-top:1px solid #000; padding-top:5px; margin-top:10px;">\r\n  <a href="{$module_data.PRODUCTS_LINK}" style="color:#6a0101; text-decoration:underline;"><b>Kaufen Sie jetzt hier!</b></a> | <strong>{$module_data.PRODUCTS_PRICE}</strong>\r\n  </div>\r\n  </td>\r\n  </tr>\r\n  </table>\r\n\r\n  {/foreach}\r\n  </td>\r\n  </tr>\r\n </table>\r\n <div style="text-align:right; font-size:10px; margin-top:10px;">{$remove_link}</div>\r\n </div>\r\n </div>\r\n </td>\r\n </tr>\r\n</table>', 'Shopname Newsletter\r\n\r\n{if $personalize == ''yes'' && $greeting_type == ''0''} {if $customers_gender == ''f''} Sehr geehrte Frau {$customers_name}, {else} Sehr geehrter Herr {$customers_name}, {/if} {/if} {if $personalize == ''yes'' && $greeting_type == ''1''} Hallo {$customers_name}, {/if} {if $personalize == ''''} Sehr geehrter Kunde, {/if}\r\n\r\n{$body}\r\n\r\n{if $gift_id} {if $greeting_type == ''1''} Gutschein:\r\n\r\nAls kleines Präsent übersenden wir Dir einen Gutschein in Höhe von {$gift_ammount}. Geb einfach bei der Bestellung deinen persönlichen Gutscheincode an: {$gift_id}\r\n\r\n{else} Gutschein:\r\n\r\nAls kleines Präsent übersenden wir Ihnen einen Gutschein in Höhe von {$gift_ammount}. Geben Sie einfach bei der Bestellung Ihren persönlichen Gutscheincode an: {$gift_id}\r\n\r\n{/if} {/if} {foreach name=aussen item=module_data from=$module_content}\r\n\r\n{$module_data.PRODUCTS_NAME}\r\n\r\n{$module_data.PRODUCTS_SHORT_DESCRIPTION}\r\n\r\nKaufen Sie jetzt! | {$module_data.PRODUCTS_PRICE} EUR \r\n\r\n{/foreach} {$remove_link}', 1263483589);
INSERT INTO emails VALUES(NULL, 'newsletter_aktivierung', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Newsletteraktivierung für {$shop_name}', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Newsletteranmeldung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td, div.lightBackground {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Newsletteraktivierung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td><br />\r\n <strong>Vielen Dank für die Anmeldung.</strong><br /><br />\r\n Sie erhalten diese Mail weil Sie unseren Newsletter empfangen möchten. Bitte klicken Sie auf den Aktivierungslink damit Ihre Mailadresse für den Newsletterempfang freigeschalten wird.<br /><br />\r\n <table width="100%" border="0" cellpadding="6" cellspacing="0">\r\n <tr class="lightBackground">\r\n <td width="1"><nobr>Ihr Aktivierungslink:</nobr></td>\r\n <td><a href="{$LINK}">{$LINK}</a></td>\r\n </tr>\r\n </table>\r\n <br /><br />Sollten Sie sich nicht in unseren Newsletter eingetragen haben bzw. den Empfang des Newsletters nicht wünschen bitten wir Sie garnichts zu tun. Ihre Adresse wird dann bei der nächsten Aktualisierung der Datenbank automatisch gelöscht.\r\n </td>\r\n </tr>\r\n</table>', 'Vielen Dank für die Anmeldung.\r\nSie erhalten diese Mail weil Sie unseren Newsletter empfangen möchten.\r\nBitte klicken Sie auf den Aktivierungslink damit Ihre Mailadresse für den Newsletterempfang freigeschalten wird.\r\nSollten Sie sich nicht in unserern Newsletter eingetragen haben bzw. den Empfang des Newsletters nicht wünschen bitten wir Sie garnichts zu tun.\r\nIhre Adresse wird dann bei der nächsten Aktualisierung der Datenbank automatisch gelöscht.\r\n \r\n \r\nIhr Aktivierungslink: {$LINK}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Newsletteranmeldung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td, div.lightBackground {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Newsletteraktivierung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td><br />\r\n <strong>Vielen Dank für die Anmeldung.</strong><br /><br />\r\n Sie erhalten diese Mail weil Sie unseren Newsletter empfangen möchten. Bitte klicken Sie auf den Aktivierungslink damit Ihre Mailadresse für den Newsletterempfang freigeschalten wird.<br /><br />\r\n <table width="100%" border="0" cellpadding="6" cellspacing="0">\r\n <tr class="lightBackground">\r\n <td width="1"><nobr>Ihr Aktivierungslink:</nobr></td>\r\n <td><a href="{$LINK}">{$LINK}</a></td>\r\n </tr>\r\n </table>\r\n <br /><br />Sollten Sie sich nicht in unseren Newsletter eingetragen haben bzw. den Empfang des Newsletters nicht wünschen bitten wir Sie garnichts zu tun. Ihre Adresse wird dann bei der nächsten Aktualisierung der Datenbank automatisch gelöscht.\r\n </td>\r\n </tr>\r\n</table>', 'Vielen Dank für die Anmeldung.\r\nSie erhalten diese Mail weil Sie unseren Newsletter empfangen möchten.\r\nBitte klicken Sie auf den Aktivierungslink damit Ihre Mailadresse für den Newsletterempfang freigeschalten wird.\r\nSollten Sie sich nicht in unserern Newsletter eingetragen haben bzw. den Empfang des Newsletters nicht wünschen bitten wir Sie garnichts zu tun.\r\nIhre Adresse wird dann bei der nächsten Aktualisierung der Datenbank automatisch gelöscht.\r\n \r\n \r\nIhr Aktivierungslink:{$LINK}', 1263483589);
INSERT INTO emails VALUES(NULL, 'new_password', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Ihr neues Passwort', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Neues Passwort</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Neues Passwort\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td><p><b>Passwort geändert!</b></p>\r\n Sie erhalten diese Mail, weil Sie ein neues Passwort angefordert und eingerichtet haben.<br />\r\n Bitte loggen Sie sich mit folgendem Passwort und Ihrer E-mail Adresse bei uns ein und ändern Sie Ihr Passwort in Ihrem Account wie Sie es wünschen.\r\n <br />\r\n </td>\r\n </tr>\r\n <tr class="lightBackground">\r\n <td><b>Ihr neues Passwort:<br>\r\n  </b>{$NEW_PASSWORD}\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <p>Wir wünschen Ihnen weiterhin viel Spaß mit unserem Angebot!</p>\r\n </td>\r\n </tr>\r\n</table>', 'Passwort geändert!\r\n\r\nSie erhalten diese Mail, weil Sie ein neues Passwort angefordert und eingerichtet haben.\r\nBitte loggen Sie sich mit folgendem Passwort und Ihrer E-mail Adresse bei uns ein und ändern Sie Ihr Passwort in Ihrem Account wie Sie es wünschen.\r\n\r\nIhr neues Passwort: {$NEW_PASSWORD}\r\n\r\nWir wünschen Ihnen weiterhin viel Spaß mit unserem Angebot!', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellbestätigung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n	<tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  neues Passwort\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td><p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Passwort geändert!</b></p>\r\n Sie erhalten diese Mail, weil Sie ein neues Passwort angefordert und eingerichtet haben.<br />\r\n Bitte loggen Sie sich mit folgendem Passwort und Ihrer E-mail Adresse bei uns ein und ändern Sie Ihr Passwort in Ihrem Account wie Sie es wünschen.\r\n </p><br />\r\n </tr>\r\n <tr class="lightBackground">\r\n <td><b>Ihr neues Passwort:<br>\r\n  </b>{$NEW_PASSWORD}\r\n </td>\r\n </tr>\r\n <tr>\r\n 	<td>\r\n 	<p>Wir wünschen Ihnen weiterhin viel Spaß mit unserem Angebot!</p>\r\n 	</td>\r\n </tr>\r\n</table>', 'Passwort geändert!\r\n\r\nSie erhalten diese Mail, weil Sie ein neues Passwort angefordert und eingerichtet haben.\r\nBitte loggen Sie sich mit folgendem Passwort und Ihrer E-mail Adresse bei uns ein und ändern Sie Ihr Passwort in Ihrem Account wie Sie es wünschen.\r\n\r\nIhr neues Passwort: {$NEW_PASSWORD}\r\n\r\nWir wünschen Ihnen weiterhin viel Spaß mit unserem Angebot!', 12345612);
INSERT INTO emails VALUES(NULL, 'order_mail', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Bestellbestätigung - Nr: {$nr} vom {$date}', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Bestellbestätigung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600;}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Bestellbestätigung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td align="left">\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n  <td width="60%">{$address_label_customer}</td>\r\n  <td>\r\n   <strong>Bestellung Nr:</strong> {$oID}<br /><br />\r\n   {if $csID}\r\n  <strong>Kundennummer:</strong> {$csID}<br />\r\n  {/if}\r\n  {if $UID}\r\n  <strong>UST-ID:</strong> {$UID}<br />\r\n  {/if}\r\n   {if $PAYMENT_METHOD}\r\n   <strong>Zahlungsmethode:</strong> {$PAYMENT_METHOD}<br />\r\n   {/if}\r\n   <strong>Bestelldatum:</strong> {$DATE}<br />\r\n   <strong>Telefon:</strong> {$PHONE}<br />\r\n  </td>\r\n  </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellspacing="6" cellpadding="3" class="outerTable">\r\n  <tr bgcolor="#f1f1f1">\r\n  {if $address_label_payment == $address_label_shipping}\r\n  <td width="100%">\r\n   <strong>Rechnungsadresse</strong>\r\n   </td>\r\n  {else}\r\n  <td width="50%">\r\n   <strong>Lieferadresse</strong>  </td>\r\n  <td width="50%">\r\n  <strong>Rechnungsadresse</strong>  </td>\r\n  {/if}  </tr>\r\n  <tr>\r\n  {if $address_label_payment == $address_label_shipping}\r\n  <td width="100%">\r\n  {$address_label_shipping}  </td>\r\n  {else}\r\n  <td width="50%">{$address_label_shipping}</td>\r\n   <td width="50%">{$address_label_payment}</td>\r\n  {/if}\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellspacing="0">\r\n <tr>\r\n  <td><br />\r\n  Hallo {if $GENDER==''f''}Frau{else}Herr{/if} {$NNAME},<br /><br />\r\n  Vielen Dank für Ihre Bestellung.<br /><br />\r\n  {$PAYMENT_INFO_HTML}\r\n  <br />\r\n  {if $COMMENTS}<br />\r\n  <strong>Ihre Anmerkungen:</strong><br />\r\n  {$COMMENTS}<br /><br />\r\n  {/if}\r\n  {if $NEW_PASSWORD}\r\n  <br /><br />\r\n  <strong>Ihr Account Passwort:</strong><br />\r\n  {$NEW_PASSWORD}<br /><br />\r\n  {/if}\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="f1f1f1" class="outerTable">\r\n <tr class="ProductsTable">\r\n  <td align="left" class="bb br">\r\n  <strong>Artikel</strong>  </td>\r\n  <td align="center" class="bb br">\r\n  <strong>Einzelpreis</strong>  </td>\r\n  <td align="center" class="bb br">\r\n  <strong>Anzahl</strong>  </td>\r\n  <td align="right" class="bb">\r\n  <strong>Summe</strong>  </td>\r\n </tr>\r\n {foreach name=aussen item=order_values from=$order_data}\r\n <tr>\r\n  <td valign="top" class="bb br ProductsName">\r\n  <strong>{$order_values.PRODUCTS_NAME}</strong> <span class="fs85">(Art-Nr:{$order_values.PRODUCTS_MODEL})</span>\r\n  {if $order_values.PRODUCTS_SHIPPING_TIME neq ''''}<br />\r\n  <em>Lieferzeit: {$order_values.PRODUCTS_SHIPPING_TIME}</em>\r\n  {/if}  \r\n  {if $order_values.PRODUCTS_ATTRIBUTES !=''''}<br /><em>{$order_values.PRODUCTS_ATTRIBUTES}</em>\r\n  {if $order_values.PRODUCTS_ATTRIBUTES_MODEL} <em>(Art-Nr: {$order_values.PRODUCTS_ATTRIBUTES_MODEL})</em> {/if} {/if}</td>\r\n  <td valign="top" class="bb br ProductsName" align="center"><strong>{$order_values.PRODUCTS_SINGLE_PRICE}</strong><br /></td>\r\n  <td valign="top" class="bb br ProductsName" align="center"><strong>{$order_values.PRODUCTS_QTY}</strong></td>\r\n  <td align="right" valign="top" nowrap="nowrap" class="bb"><strong>{$order_values.PRODUCTS_PRICE}</strong><br /></td>\r\n </tr>\r\n {/foreach}\r\n <tr><td colspan="4" class="ProductsName bb"> </td></tr>\r\n {foreach name=aussen item=order_total_values from=$order_total}\r\n  <tr>\r\n  <td colspan="3" width="98" align="right"><nobr>{$order_total_values.TITLE}</nobr></td>\r\n  <td width="2%" align="right" nowrap="nowrap"><nobr>{$order_total_values.TEXT}</nobr></td>\r\n  </tr>\r\n {/foreach}\r\n </table>\r\n </td>\r\n </tr>\r\n</table>\r\n\r\n{if $WIDERRUF_TEXT !=''''}<br />\r\n <table width="90%" border="0" cellpadding="10" cellspacing="0" align="center">\r\n <tr>\r\n <td><strong>{$WIDERRUF_HEAD}</strong></td>\r\n </tr>\r\n <tr>\r\n <td>{$WIDERRUF_TEXT}</td>\r\n </tr>\r\n </table>\r\n{/if}', '{$address_label_customer}\r\n\r\n{if $PAYMENT_METHOD}Zahlungsmethode: {$PAYMENT_METHOD}{/if}\r\nBestellnummer: {$oID}\r\nDatum: {$DATE}\r\n{if $csID}Kundennummer :{$csID}{/if}\r\n{if $UID}UST-ID:{$UID}{/if}\r\n----------------------------------------------------------------------\r\n\r\n\r\nHallo {$NAME},\r\n\r\n{if $NEW_PASSWORD}\r\n Ihr Account Passwort: {$NEW_PASSWORD}\r\n{/if} \r\n\r\n{$PAYMENT_INFO_TXT}\r\n\r\n{if $COMMENTS}\r\nIhre Anmerkungen:\r\n{$COMMENTS}\r\n{/if}\r\n\r\nIhre Bestellten Produkte zur Kontrollle\r\n----------------------------------------------------------------------\r\n{foreach name=aussen item=order_values from=$order_data} \r\n{$order_values.PRODUCTS_QTY} x {$order_values.PRODUCTS_NAME} {$order_values.PRODUCTS_PRICE}\r\n{if $order_values.PRODUCTS_SHIPPING_TIME neq ''''}Lieferzeit: {$order_values.PRODUCTS_SHIPPING_TIME}{/if}\r\n{if $order_values.PRODUCTS_ATTRIBUTES !=''''}{$order_values.PRODUCTS_ATTRIBUTES}{/if}\r\n\r\n{/foreach}\r\n\r\n{foreach name=aussen item=order_total_values from=$order_total}\r\n{$order_total_values.TITLE}{$order_total_values.TEXT}\r\n{/foreach}\r\n\r\n\r\n{if $address_label_payment}\r\nRechnungsadresse\r\n----------------------------------------------------------------------\r\n{$address_label_payment}\r\n{/if}\r\nVersandadresse \r\n----------------------------------------------------------------------\r\n{$address_label_shipping}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Bestellbestätigung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600;}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Bestellbestätigung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td align="left">\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n  <tr>\r\n  <td width="60%">{$address_label_customer}</td>\r\n  <td>\r\n   <strong>Bestellung Nr:</strong> {$oID}<br /><br />\r\n   {if $csID}\r\n  <strong>Kundennummer:</strong> {$csID}<br />\r\n  {/if}\r\n  {if $UID}\r\n  <strong>UST-ID:</strong> {$UID}<br />\r\n  {/if}\r\n   {if $PAYMENT_METHOD}\r\n   <strong>Zahlungsmethode:</strong> {$PAYMENT_METHOD}<br />\r\n   {/if}\r\n   <strong>Bestelldatum:</strong> {$DATE}<br />\r\n   <strong>Telefon:</strong> {$PHONE}<br />\r\n  </td>\r\n  </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellspacing="6" cellpadding="3" class="outerTable">\r\n  <tr bgcolor="#f1f1f1">\r\n  {if $address_label_payment == $address_label_shipping}\r\n  <td width="100%">\r\n   <strong>Rechnungsadresse</strong>\r\n   </td>\r\n  {else}\r\n  <td width="50%">\r\n   <strong>Lieferadresse</strong>  </td>\r\n  <td width="50%">\r\n  <strong>Rechnungsadresse</strong>  </td>\r\n  {/if}  </tr>\r\n  <tr>\r\n  {if $address_label_payment == $address_label_shipping}\r\n  <td width="100%">\r\n  {$address_label_shipping}  </td>\r\n  {else}\r\n  <td width="50%">{$address_label_shipping}</td>\r\n   <td width="50%">{$address_label_payment}</td>\r\n  {/if}\r\n  </tr>\r\n  </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellspacing="0">\r\n <tr>\r\n  <td><br />\r\n  Hallo {if $GENDER==''f''}Frau{else}Herr{/if} {$NNAME},<br /><br />\r\n  Vielen Dank für Ihre Bestellung.<br /><br />\r\n  {$PAYMENT_INFO_HTML}\r\n  <br />\r\n  {if $COMMENTS}<br />\r\n  <strong>Ihre Anmerkungen:</strong><br />\r\n  {$COMMENTS}<br /><br />\r\n  {/if}\r\n  {if $NEW_PASSWORD}\r\n  <br /><br />\r\n  <strong>Ihr Account Passwort:</strong><br />\r\n  {$NEW_PASSWORD}<br /><br />\r\n  {/if}\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="f1f1f1" class="outerTable">\r\n <tr class="ProductsTable">\r\n  <td align="left" class="bb br">\r\n  <strong>Artikel</strong>  </td>\r\n  <td align="center" class="bb br">\r\n  <strong>Einzelpreis</strong>  </td>\r\n  <td align="center" class="bb br">\r\n  <strong>Anzahl</strong>  </td>\r\n  <td align="right" class="bb">\r\n  <strong>Summe</strong>  </td>\r\n </tr>\r\n {foreach name=aussen item=order_values from=$order_data}\r\n <tr>\r\n  <td valign="top" class="bb br ProductsName">\r\n  <strong>{$order_values.PRODUCTS_NAME}</strong> <span class="fs85">(Art-Nr:{$order_values.PRODUCTS_MODEL})</span>\r\n  {if $order_values.PRODUCTS_SHIPPING_TIME neq ''''}<br />\r\n  <em>Lieferzeit: {$order_values.PRODUCTS_SHIPPING_TIME}</em>\r\n  {/if}  \r\n  {if $order_values.PRODUCTS_ATTRIBUTES !=''''}<br /><em>{$order_values.PRODUCTS_ATTRIBUTES}</em>\r\n  {if $order_values.PRODUCTS_ATTRIBUTES_MODEL} <em>(Art-Nr: {$order_values.PRODUCTS_ATTRIBUTES_MODEL})</em> {/if} {/if}</td>\r\n  <td valign="top" class="bb br ProductsName" align="center"><strong>{$order_values.PRODUCTS_SINGLE_PRICE}</strong><br /></td>\r\n  <td valign="top" class="bb br ProductsName" align="center"><strong>{$order_values.PRODUCTS_QTY}</strong></td>\r\n  <td align="right" valign="top" nowrap="nowrap" class="bb"><strong>{$order_values.PRODUCTS_PRICE}</strong><br /></td>\r\n </tr>\r\n {/foreach}\r\n <tr><td colspan="4" class="ProductsName bb"> </td></tr>\r\n {foreach name=aussen item=order_total_values from=$order_total}\r\n  <tr>\r\n  <td colspan="3" width="98" align="right"><nobr>{$order_total_values.TITLE}</nobr></td>\r\n  <td width="2%" align="right" nowrap="nowrap"><nobr>{$order_total_values.TEXT}</nobr></td>\r\n  </tr>\r\n {/foreach}\r\n </table>\r\n </td>\r\n </tr>\r\n</table>\r\n\r\n{if $WIDERRUF_TEXT !=''''}<br />\r\n <table width="90%" border="0" cellpadding="10" cellspacing="0" align="center">\r\n <tr>\r\n <td><strong>{$WIDERRUF_HEAD}</strong></td>\r\n </tr>\r\n <tr>\r\n <td>{$WIDERRUF_TEXT}</td>\r\n </tr>\r\n </table>\r\n{/if}', '{$address_label_customer}\r\n\r\n{if $PAYMENT_METHOD}Zahlungsmethode: {$PAYMENT_METHOD}{/if}\r\nBestellnummer: {$oID}\r\nDatum: {$DATE}\r\n{if $csID}Kundennummer :{$csID}{/if}\r\n{if $UID}UST-ID:{$UID}{/if}\r\n----------------------------------------------------------------------\r\n\r\n\r\nHallo {$NAME},\r\n\r\n{if $NEW_PASSWORD}\r\n Ihr Account Passwort: {$NEW_PASSWORD}\r\n{/if} \r\n\r\n{$PAYMENT_INFO_TXT}\r\n\r\n{if $COMMENTS}\r\nIhre Anmerkungen:\r\n{$COMMENTS}\r\n{/if}\r\n\r\nIhre Bestellten Produkte zur Kontrollle\r\n----------------------------------------------------------------------\r\n{foreach name=aussen item=order_values from=$order_data} \r\n{$order_values.PRODUCTS_QTY} x {$order_values.PRODUCTS_NAME} {$order_values.PRODUCTS_PRICE}\r\n{if $order_values.PRODUCTS_SHIPPING_TIME neq ''''}Lieferzeit: {$order_values.PRODUCTS_SHIPPING_TIME}{/if}\r\n{if $order_values.PRODUCTS_ATTRIBUTES !=''''}{$order_values.PRODUCTS_ATTRIBUTES}{/if}\r\n\r\n{/foreach}\r\n\r\n{foreach name=aussen item=order_total_values from=$order_total}\r\n{$order_total_values.TITLE}{$order_total_values.TEXT}\r\n{/foreach}\r\n\r\n\r\n{if $address_label_payment}\r\nRechnungsadresse\r\n----------------------------------------------------------------------\r\n{$address_label_payment}\r\n{/if}\r\nVersandadresse \r\n----------------------------------------------------------------------\r\n{$address_label_shipping}', 1263483589);
INSERT INTO emails VALUES(NULL, 'password_verification', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Bestätigung der Passwortänderung', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Passwort Bestätigung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td colspan="2">\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Passwort Bestätigung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td colspan="2">\r\n <p><b>Bitte bestätigen Sie Ihre Paßwortanfrage!</b></p>\r\n <p>Bitte bestätigen Sie, daß Sie selber ein neues Paßwort angefordert haben. <br>\r\n Aus diesem Grund haben wir Ihnen diese E-mail mit einem persönlichen Bestätigungslink geschickt. Wenn Sie den Link bestätigen, indem Sie ihn anklicken, wird Ihnen umgehend ein neues Paßwort in einer weiteren Email zur Verfügung gestellt.\r\n </p><br />\r\n </td>\r\n </tr>\r\n <tr class="lightBackground">\r\n <td width="1">\r\n <nobr><b>Ihr Bestätigungslink:</b></nobr>\r\n </td>\r\n <td>\r\n <a href="{$LINK}">{$LINK}</a>\r\n </td>\r\n </tr>\r\n</table>', 'Bitte bestätigen Sie Ihre Paßwortanfrage!\r\n\r\nBitte bestätigen Sie, daß Sie selber ein neues Paßwort angefordert haben. \r\nAus diesem Grund haben wir Ihnen diese E-mail mit einem persönlichen \r\nBestätigungslink geschickt. Wenn Sie den Link bestätigen, indem Sie ihn \r\nanklicken, wird Ihnen umgehend ein neues Paßwort in einer weiteren E-mail \r\nzur Verfügung gestellt\r\n \r\nIhr Bestätigungslink:\r\n{$LINK}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Passwort Bestätigung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td colspan="2">\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Passwort Bestätigung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td colspan="2">\r\n <p><b>Bitte bestätigen Sie Ihre Paßwortanfrage!</b></p>\r\n <p>Bitte bestätigen Sie, daß Sie selber ein neues Paßwort angefordert haben. <br>\r\n Aus diesem Grund haben wir Ihnen diese E-mail mit einem persönlichen Bestätigungslink geschickt. Wenn Sie den Link bestätigen, indem Sie ihn anklicken, wird Ihnen umgehend ein neues Paßwort in einer weiteren Email zur Verfügung gestellt.\r\n </p><br />\r\n </td>\r\n </tr>\r\n <tr class="lightBackground">\r\n <td width="1">\r\n <nobr><b>Ihr Bestätigungslink:</b></nobr>\r\n </td>\r\n <td>\r\n <a href="{$LINK}">{$LINK}</a>\r\n </td>\r\n </tr>\r\n</table>', 'Bitte bestätigen Sie Ihre Paßwortanfrage!\r\n\r\nBitte bestätigen Sie, daß Sie selber ein neues Paßwort angefordert haben. \r\nAus diesem Grund haben wir Ihnen diese E-mail mit einem persönlichen \r\nBestätigungslink geschickt. Wenn Sie den Link bestätigen, indem Sie ihn \r\nanklicken, wird Ihnen umgehend ein neues Paßwort in einer weiteren E-mail \r\nzur Verfügung gestellt\r\n \r\nIhr Bestätigungslink:\r\n{$LINK}', 1263483589);
INSERT INTO emails VALUES(NULL, 'pdf_mail', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Ihre PDF-Rechnung {$renr} vom {$date}', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>PDF-Rechnung</title>\r\n{literal}\r\n<style type="text/css"> \r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  PDF-Rechnung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellspacing="6" cellpadding="3" class="outerTable">\r\n  <tr>\r\n  <td colspan="2">\r\n  <p><strong>Sehr geehrter Kunde, </strong></p>\r\n  <p>im Anhang dieser E-Mail übermitteln wir Ihnen die Rechnung Ihrer Bestellung vom {$ORDER_DATE}.<br /><br />  Bei Fragen zu Ihrer Bestellung antworten Sie bitte auf diese eMail.</p>\r\n  </td>\r\n  </tr>\r\n <tr class="lightBackground">\r\n  <td>\r\n  Den Status Ihrer Bestellung können Sie einsehen unter:\r\n  </td>\r\n  <td>\r\n  <a href="{$ORDER_LINK}">{$ORDER_LINK}</a>\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n</table>', 'Sehr geehrter Kunde,\r\n\r\nim Anhang dieser E-Mail übermitteln wir Ihnen die Rechnung Ihrer Bestellung vom {$ORDER_DATE}.\r\n\r\nBei Fragen zu Ihrer Bestellung antworten Sie bitte auf diese eMail, den Status Ihrer Bestellung können \r\nSie einsehen unter: {$ORDER_LINK}.', 'Sehr geehrter Kunde, \r\n \r\n\r\nim Anhang dieser E-Mail übermitteln wir Ihnen die Rechnung Ihrer Bestellung vom {$ORDER_DATE}.  \r\n              \r\nBei Fragen zu Ihrer Bestellung antworten Sie bitte auf diese eMail. Den Status Ihrer Bestellung können \r\nSie einsehen unter: {$ORDER_LINK}.', 'Sehr geehrter Kunde,\r\n\r\nim Anhang dieser E-Mail übermitteln wir Ihnen die Rechnung Ihrer Bestellung vom {$ORDER_DATE}.\r\n\r\nBei Fragen zu Ihrer Bestellung antworten Sie bitte auf diese eMail, den Status Ihrer Bestellung können \r\nSie einsehen unter: {$ORDER_LINK}.', 1263483589);
INSERT INTO emails VALUES(NULL, 'recover_cart_sales', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Ihr Besuch auf unserem Shop', '', '<!DOCTYPE html>\r\n<html dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Email</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Offener Warenkorb\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>{if $GENDER}Sehr geehrte{if $GENDER eq ''m''}r Herr{elseif $GENDER eq ''f''} Frau{else}(r) {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Hallo,{/if}\r\n <p>{if $NEW == true}vielen Dank f&uuml;r Ihren Besuch bei {$STORE_NAME} und Ihr uns entgegen gebrachtes Vertrauen.\r\n {else}vielen Dank f&uuml;r Ihren erneuten Besuch bei {$STORE_NAME} und Ihr wiederholtes uns entgegen gebrachtes Vertrauen.{/if}</p>\r\n <p>Wir haben gesehen, da&szlig; Sie bei Ihrem Besuch in unserem Onlineshop den Warenkorb mit folgenden Artikeln gef&uuml;llt haben, aber den Einkauf nicht vollst&auml;ndig durchgef&uuml;hrt haben.</p>\r\n <p>Inhalt Ihres Warenkorbes:</p>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="3" class="ProductsTable">\r\n {foreach name=outer item=product from=$products_data}\r\n <tr>\r\n <td width="150"><img src="{$product.IMAGE}" alt="{$product.NAME}" /></td>\r\n <td width="10" valign="top">{$product.QUANTITY} x </td>\r\n <td valign="top">{$product.NAME}<br />\r\n  <a href="{$product.LINK}">{$product.LINK}</a></td>\r\n </tr>\r\n {/foreach}\r\n </table>\r\n <p>Wir sind immer bem&uuml;ht, unseren Service im Interesse unserer Kunden zu verbessern.\r\n Aus diesem Grund interessiert es uns nat&uuml;rlich, was die Ursachen daf&uuml;r waren, Ihren Einkauf dieses Mal nicht bei {$STORE_NAME} zu t&auml;tigen.\r\n Wir sind Ihnen daher sehr dankbar, wenn Sie uns mitteilen, ob Sie bei Ihrem Besuch in unserem Onlineshop Probleme oder Bedenken hatten, den Einkauf erfolgreich abzuschlie&szlig;en.\r\n Unser Ziel ist es, Ihnen und anderen Kunden, den Einkauf bei {$STORE_NAME} leichter und besser zu gestalten.</p>\r\n Um Ihren Einkauf nun abzuschlie&szlig;en, melden sie sich bitte hier an: <a href="{$LOGIN}">{$LOGIN}</a><br />\r\n <p>Nochmals vielen Dank f&uuml;r Ihre Zeit und Ihre Hilfe, den Onlineshop von {$STORE_NAME} zu verbessern.</p>\r\n <p>Mit freundlichen Gr&uuml;&szlig;en</p>\r\n <p>Ihr Team von <a href="{$STORE_LINK}">{$STORE_NAME}</a></p>\r\n {if $MESSAGE}\r\n <p>{$MESSAGE}</p>\r\n {/if}\r\n <p>&nbsp;</p></td>\r\n </tr>\r\n</table>', 'Melden sie sich hier an: {$LOGIN}\r\n------------------------------------------------------\r\n{if $GENDER}Sehr geehrte{if $GENDER eq ''m''}r Herr{elseif $GENDER eq ''f''} Frau{else}(r) {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Hallo,{/if}\r\n\r\n{if $NEW == true}vielen Dank für Ihren Besuch bei {$STORE_NAME} und Ihr uns entgegen gebrachtes Vertrauen.\r\n{else}vielen Dank für Ihren erneuten Besuch bei {$STORE_NAME} und Ihr wiederholtes uns entgegen gebrachtes Vertrauen.{/if}\r\n\r\nWir haben gesehen, daß Sie bei Ihrem Besuch in unserem Onlineshop den Warenkorb mit folgenden Artikeln gefüllt haben, aber den Einkauf nicht vollständig durchgeführt haben.\r\n\r\nInhalt Ihres Warenkorbes:\r\n\r\n{foreach name=outer item=product from=$products_data}\r\n{$product.QUANTITY} x {$product.NAME}\r\n {$product.LINK}\r\n{/foreach}\r\n\r\nWir sind immer bemüht, unseren Service im Interesse unserer Kunden zu verbessern.\r\nAus diesem Grund interessiert es uns natürlich, was die Ursachen dafür waren, Ihren Einkauf dieses Mal nicht bei {$STORE_NAME} zu tätigen.\r\nWir sind Ihnen daher sehr dankbar, wenn Sie uns mitteilen, ob Sie bei Ihrem Besuch in unserem Onlineshop Probleme oder Bedenken hatten, den Einkauf erfolgreich abzuschließen.\r\nUnser Ziel ist es, Ihnen und anderen Kunden, den Einkauf bei {$STORE_NAME} leichter und besser zu gestalten.\r\n\r\nNochmals vielen Dank für Ihre Zeit und Ihre Hilfe, den Onlineshop von {$STORE_NAME} zu verbessern.\r\n\r\nMit freundlichen Grüßen\r\n\r\nIhr Team von {$STORE_NAME}\r\n{if $MESSAGE}\r\n\r\n{$MESSAGE}\r\n{/if}', '<!DOCTYPE html>\r\n<html dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Email</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Offener Warenkorb\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>{if $GENDER}Sehr geehrte{if $GENDER eq ''m''}r Herr{elseif $GENDER eq ''f''} Frau{else}(r) {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Hallo,{/if}\r\n <p>{if $NEW == true}vielen Dank f&uuml;r Ihren Besuch bei {$STORE_NAME} und Ihr uns entgegen gebrachtes Vertrauen.\r\n {else}vielen Dank f&uuml;r Ihren erneuten Besuch bei {$STORE_NAME} und Ihr wiederholtes uns entgegen gebrachtes Vertrauen.{/if}</p>\r\n <p>Wir haben gesehen, da&szlig; Sie bei Ihrem Besuch in unserem Onlineshop den Warenkorb mit folgenden Artikeln gef&uuml;llt haben, aber den Einkauf nicht vollst&auml;ndig durchgef&uuml;hrt haben.</p>\r\n <p>Inhalt Ihres Warenkorbes:</p>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="3" class="ProductsTable">\r\n {foreach name=outer item=product from=$products_data}\r\n <tr>\r\n <td width="150"><img src="{$product.IMAGE}" alt="{$product.NAME}" /></td>\r\n <td width="10" valign="top">{$product.QUANTITY} x </td>\r\n <td valign="top">{$product.NAME}<br />\r\n  <a href="{$product.LINK}">{$product.LINK}</a></td>\r\n </tr>\r\n {/foreach}\r\n </table>\r\n <p>Wir sind immer bem&uuml;ht, unseren Service im Interesse unserer Kunden zu verbessern.\r\n Aus diesem Grund interessiert es uns nat&uuml;rlich, was die Ursachen daf&uuml;r waren, Ihren Einkauf dieses Mal nicht bei {$STORE_NAME} zu t&auml;tigen.\r\n Wir sind Ihnen daher sehr dankbar, wenn Sie uns mitteilen, ob Sie bei Ihrem Besuch in unserem Onlineshop Probleme oder Bedenken hatten, den Einkauf erfolgreich abzuschlie&szlig;en.\r\n Unser Ziel ist es, Ihnen und anderen Kunden, den Einkauf bei {$STORE_NAME} leichter und besser zu gestalten.</p>\r\n Um Ihren Einkauf nun abzuschlie&szlig;en, melden sie sich bitte hier an: <a href="{$LOGIN}">{$LOGIN}</a><br />\r\n <p>Nochmals vielen Dank f&uuml;r Ihre Zeit und Ihre Hilfe, den Onlineshop von {$STORE_NAME} zu verbessern.</p>\r\n <p>Mit freundlichen Gr&uuml;&szlig;en</p>\r\n <p>Ihr Team von <a href="{$STORE_LINK}">{$STORE_NAME}</a></p>\r\n {if $MESSAGE}\r\n <p>{$MESSAGE}</p>\r\n {/if}\r\n <p>&nbsp;</p></td>\r\n </tr>\r\n</table>', 'Melden sie sich hier an: {$LOGIN}\r\n------------------------------------------------------\r\n{if $GENDER}Sehr geehrte{if $GENDER eq ''m''}r Herr{elseif $GENDER eq ''f''} Frau{else}(r) {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Hallo,{/if}\r\n\r\n{if $NEW == true}vielen Dank für Ihren Besuch bei {$STORE_NAME} und Ihr uns entgegen gebrachtes Vertrauen.\r\n{else}vielen Dank für Ihren erneuten Besuch bei {$STORE_NAME} und Ihr wiederholtes uns entgegen gebrachtes Vertrauen.{/if}\r\n\r\nWir haben gesehen, daß Sie bei Ihrem Besuch in unserem Onlineshop den Warenkorb mit folgenden Artikeln gefüllt haben, aber den Einkauf nicht vollständig durchgeführt haben.\r\n\r\nInhalt Ihres Warenkorbes:\r\n\r\n{foreach name=outer item=product from=$products_data}\r\n{$product.QUANTITY} x {$product.NAME}\r\n {$product.LINK}\r\n{/foreach}\r\n\r\nWir sind immer bemüht, unseren Service im Interesse unserer Kunden zu verbessern.\r\nAus diesem Grund interessiert es uns natürlich, was die Ursachen dafür waren, Ihren Einkauf dieses Mal nicht bei {$STORE_NAME} zu tätigen.\r\nWir sind Ihnen daher sehr dankbar, wenn Sie uns mitteilen, ob Sie bei Ihrem Besuch in unserem Onlineshop Probleme oder Bedenken hatten, den Einkauf erfolgreich abzuschließen.\r\nUnser Ziel ist es, Ihnen und anderen Kunden, den Einkauf bei {$STORE_NAME} leichter und besser zu gestalten.\r\n\r\nNochmals vielen Dank für Ihre Zeit und Ihre Hilfe, den Onlineshop von {$STORE_NAME} zu verbessern.\r\n\r\nMit freundlichen Grüßen\r\n\r\nIhr Team von {$STORE_NAME}\r\n{if $MESSAGE}\r\n\r\n{$MESSAGE}\r\n{/if}', 1297445522);
INSERT INTO emails VALUES(NULL, 'send_cupon', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', '', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellbestätigung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr>\r\n <td>\r\n {$MESSAGE}\r\n <br>\r\n <br>\r\nSie können den Gutschein bei Ihrer Bestellung einlösen. Geben Sie dafür Ihren Gutschein-Nummer in das Feld Gutscheine ein. <br>\r\n<br>\r\nIhr Gutschein-Nummer lautet: <strong>\r\n{$COUPON_ID}\r\n</strong><br>\r\n<br>\r\nHeben Sie Ihre Gutschein-Nummer gut auf, nur so können Sie von diesem Angebot profitieren <br>\r\n<br>\r\nwenn Sie uns das nächste mal unter\r\n<a href="{$WEBSITE}">{$WEBSITE}</a>\r\nbesuchen.</td>\r\n </tr>\r\n</table>', '{$MESSAGE}\r\n\r\nSie können den Gutschein bei Ihrer Bestellung einlösen. Geben Sie dafür Ihren Gutschein-Nummer in das Feld Gutscheine ein.\r\n\r\nIhr Gutschein-Nummer lautet: {$COUPON_ID}\r\n\r\nHeben Sie Ihre Gutschein-Nummer gut auf, nur so können Sie von diesem Angebot profitieren\r\nwenn Sie uns das nächste mal unter {$WEBSITE} besuchen.', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellbestätigung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr>\r\n <td>\r\n {$MESSAGE}\r\n <br>\r\n <br>\r\nSie können den Gutschein bei Ihrer Bestellung einlösen. Geben Sie dafür Ihren Gutschein-Nummer in das Feld Gutscheine ein. <br>\r\n<br>\r\nIhr Gutschein-Nummer lautet: <strong>\r\n{$COUPON_ID}\r\n</strong><br>\r\n<br>\r\nHeben Sie Ihre Gutschein-Nummer gut auf, nur so können Sie von diesem Angebot profitieren <br>\r\n<br>\r\nwenn Sie uns das nächste mal unter\r\n<a href="{$WEBSITE}">{$WEBSITE}</a>\r\nbesuchen.</td>\r\n </tr>\r\n</table>', '{$MESSAGE}\r\n\r\nSie können den Gutschein bei Ihrer Bestellung einlösen. Geben Sie dafür Ihren Gutschein-Nummer in das Feld Gutscheine ein.\r\n\r\nIhr Gutschein-Nummer lautet: {$COUPON_ID}\r\n\r\nHeben Sie Ihre Gutschein-Nummer gut auf, nur so können Sie von diesem Angebot profitieren\r\nwenn Sie uns das nächste mal unter {$WEBSITE} besuchen.', 1263483589);
INSERT INTO emails VALUES(NULL, 'send_gift', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', '', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellbestätigung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <p>\r\n {$MESSAGE}\r\n </p>\r\n <p>Gutscheinwert\r\n  {$AMMOUNT}\r\n </p>\r\n <p>Um Ihren Gutschein zu verbuchen, klicken Sie auf den unten stehenden Link. Bitte notieren Sie sich zur Sicherheit Ihren persönlichen Gutschein-Code. <br />\r\n  <b>Ihr Gutscheincode lautet</b>:\r\n  {$GIFT_ID}\r\n </p>\r\n <p> <a href="{$GIFT_LINK}">\r\n {$GIFT_LINK}\r\n </a></p>\r\n <p>Falls es wider Erwarten zu Problemen beim verbuchen kommen sollte.<br />\r\n Besuchen Sie unsere Webseite\r\n <a href="{$WEBSITE}">{$WEBSITE}</a>\r\n und geben den Gutschein-Code bitte manuell ein.</p></td>\r\n </tr>\r\n</table>', '{$MESSAGE}\r\n \r\nGutscheinwert {$AMMOUNT}\r\n \r\nUm Ihren Gutschein zu verbuchen, klicken Sie auf den unten stehenden Link.\r\nBitte notieren Sie sich zur Sicherheit Ihren persönlichen Gutschein-Code.Ihr Gutscheincode lautet: {$GIFT_ID} \r\n\r\n{$GIFT_LINK}\r\n\r\nFalls es wider Erwarten zu Problemen beim verbuchen kommen sollte. \r\nBesuchen Sie unsere Webseite {$WEBSITE} und geben den Gutschein-Code bitte manuell ein', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellbestätigung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr>\r\n <td>\r\n <p>\r\n {$MESSAGE}\r\n </p>\r\n <p>Gutscheinwert\r\n  {$AMMOUNT}\r\n </p>\r\n <p>Um Ihren Gutschein zu verbuchen, klicken Sie auf den unten stehenden Link. Bitte notieren Sie sich zur Sicherheit Ihren persönlichen Gutschein-Code. <br />\r\n  <b>Ihr Gutscheincode lautet</b>:\r\n  {$GIFT_ID}\r\n </p>\r\n <p> <a href="{$GIFT_LINK}">\r\n {$GIFT_LINK}\r\n </a></p>\r\n <p>Falls es wider Erwarten zu Problemen beim verbuchen kommen sollte.<br />\r\n Besuchen Sie unsere Webseite\r\n <a href="{$WEBSITE}">{$WEBSITE}</a>\r\n und geben den Gutschein-Code bitte manuell ein.</p></td>\r\n </tr>\r\n</table>', '{$MESSAGE}\r\n \r\nGutscheinwert {$AMMOUNT}\r\n \r\nUm Ihren Gutschein zu verbuchen, klicken Sie auf den unten stehenden Link.\r\nBitte notieren Sie sich zur Sicherheit Ihren persönlichen Gutschein-Code.Ihr Gutscheincode lautet: {$GIFT_ID} \r\n\r\n{$GIFT_LINK}\r\n\r\nFalls es wider Erwarten zu Problemen beim verbuchen kommen sollte. \r\nBesuchen Sie unsere Webseite {$WEBSITE} und geben den Gutschein-Code bitte manuell ein', 1263483589);
INSERT INTO emails VALUES(NULL, 'send_gift_to_friend', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Gutschein von mail-adresse.de', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Gutschein</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;">\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Gutschein\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>\r\n Herzlichen Glückwunsch, Sie haben einen Gutschein über <b>{$AMMOUNT} </b>erhalten ! <br /><br />\r\n Dieser Gutschein wurde Ihnen übermittelt von {$FROM_NAME},<br />\r\n Mit der Nachricht:<br />\r\n <em>{$MESSAGE}</em><br /><br />\r\n Ihr persönlicher Gutscheincode lautet <strong>{$GIFT_CODE}</strong>.<br />Sie können diese Gutschrift entweder während dem Bestellvorgang verbuchen.<br /><br />\r\n Um den Gutschein einzulösen klichen Sie bitte auf <a href="{$GIFT_LINK}">{$GIFT_LINK}</a> <br /><br />\r\n Falls es mit dem obigen Link Probleme beim Einlösen kommen sollte, können Sie den Betrag während des Bestellvorganges verbuchen.\r\n </td>\r\n </tr>\r\n</table>', '----------------------------------------------------------------------------------------\r\n Herzlichen Glückwunsch, Sie haben einen Gutschein über {$AMMOUNT} erhalten !\r\n----------------------------------------------------------------------------------------\r\n\r\nDieser Gutschein wurde Ihnen übermittelt von {$FROM_NAME},\r\nMit der Nachricht:\r\n\r\n{$MESSAGE}\r\n\r\nIhr persönlicher Gutscheincode lautet {$GIFT_CODE}. Sie können diese Gutschrift entweder während dem Bestellvorgang verbuchen.\r\n\r\nUm den Gutschein einzulösen klichen Sie bitte auf {$GIFT_LINK}\r\n\r\nFalls es mit dem obigen Link Probleme beim Einlösen kommen sollte,\r\nkönnen Sie den Betrag während des Bestellvorganges verbuchen.', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellbestätigung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td style="border-bottom: 1px solid;border-color: #cccccc;"><div align="right"><img src="{$logo_path}logo.gif"></div></td>\r\n </tr>\r\n <tr>\r\n <td> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>\r\n Herzlichen Glückwunsch, Sie haben einen Gutschein über <b>{$AMMOUNT} </b>erhalten ! <br>\r\n<br> \r\n<br>\r\nDieser Gutschein wurde Ihnen übermittelt von {$FROM_NAME},<br>\r\nMit der Nachricht:<br>\r\n<br>\r\n{$MESSAGE}<br>\r\n<br>\r\nIhr persönlicher Gutscheincode lautet <strong>{$GIFT_CODE}</strong>. Sie können diese Gutschrift entweder während dem Bestellvorgang verbuchen.<br>\r\n<br>\r\nUm den Gutschein einzulösen klichen Sie bitte auf <a href="{$GIFT_LINK}">{$GIFT_LINK}</a> <br>\r\n<br>\r\nFalls es mit dem obigen Link Probleme beim Einlösen kommen sollte, <br>\r\nkönnen Sie den Betrag während des Bestellvorganges verbuchen. </font></td>\r\n </tr>\r\n</table>', '----------------------------------------------------------------------------------------\r\n Herzlichen Glückwunsch, Sie haben einen Gutschein über {$AMMOUNT} erhalten !\r\n----------------------------------------------------------------------------------------\r\n\r\nDieser Gutschein wurde Ihnen übermittelt von {$FROM_NAME},\r\nMit der Nachricht:\r\n\r\n{$MESSAGE}\r\n\r\nIhr persönlicher Gutscheincode lautet {$GIFT_CODE}. Sie können diese Gutschrift entweder während dem Bestellvorgang verbuchen.\r\n\r\nUm den Gutschein einzulösen klichen Sie bitte auf {$GIFT_LINK}\r\n\r\nFalls es mit dem obigen Link Probleme beim Einlösen kommen sollte,\r\nkönnen Sie den Betrag während des Bestellvorganges verbuchen.', 1263483589);
INSERT INTO emails VALUES(NULL, 'send_mail_from_admin', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'wird vom System gefüllt', '', '<!DOCTYPE html>\r\n<html dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Email</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Email\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>Hallo {if $GENDER==''f''}Frau{else}Herr{/if} {$NNAME},<br /><br />\r\n {$CONTENT}\r\n </td>\r\n </tr>\r\n</table>', 'Hallo {if $GENDER==''f''}Frau{else}Herr{/if} {$NNAME},\r\n\r\n{$CONTENT}', '<!DOCTYPE html>\r\n<html dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Email</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Email\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>Hallo {if $GENDER==''f''}Frau{else}Herr{/if} {$NNAME},<br /><br />\r\n {$CONTENT}\r\n </td>\r\n </tr>\r\n</table>', 'Hallo {if $GENDER==''f''}Frau{else}Herr{/if} {$NNAME},\r\n\r\n{$CONTENT}', 1297445522);
INSERT INTO emails VALUES(NULL, 'signatur', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', '', '', '{literal}<style type="text/css"> \r\n table.signatur {color:#666;border-top:1px solid #ccc}\r\n</style>\r\n{/literal}\r\n<br />\r\n<table width="90%" border="0" cellpadding="4" cellspacing="0" align="center" class="signatur">\r\n <tr>\r\n <td colspan="2">\r\n <strong>Impressum:</strong>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td width="1">Firma:</td>\r\n <td><nobr>{$SHOP_NAME}</nobr></td>\r\n </tr>\r\n <tr>\r\n <td>Shopname:</td>\r\n <td><nobr>{$SHOP_BESITZER}</nobr></td>\r\n </tr>\r\n <tr>\r\n <td valign="top">Adresse:</td>\r\n <td>\r\n <nobr>{$SHOP_ADRESSE_VNAME} {$SHOP_ADRESSE_NNAME}</nobr><br />\r\n <nobr>{$SHOP_ADRESSE_STRASSE}</nobr><br />\r\n <nobr>{$SHOP_ADRESSE_PLZ} {$SHOP_ADRESSE_ORT}</nobr>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>Shop URL:</td>\r\n <td><nobr><a href="{$SHOP_URL}">{$SHOP_URL}</a></nobr></td>\r\n </tr>\r\n <tr>\r\n <td>E-Mail:</td>\r\n <td><nobr><a href="mailto:{$SHOP_EMAIL}">{$SHOP_EMAIL}</a></nobr></td>\r\n </tr>\r\n {if $SHOP_USTID}\r\n <tr>\r\n <td>UST-ID:</td>\r\n <td><nobr>{$SHOP_USTID}</nobr></td>\r\n </tr>\r\n {/if}\r\n <tr>\r\n <td>Inhaber:</td>\r\n <td><nobr>{$SHOP_ADRESSE_VNAME} {$SHOP_ADRESSE_NNAME}</nobr></td>\r\n </tr>\r\n</table>\r\n</body>\r\n</html>', '\r\n\r\nFirma: {$SHOP_NAME}\r\n\r\nShopname: {$SHOP_BESITZER}\r\n\r\nAdresse: {$SHOP_ADRESSE_VNAME} {$SHOP_ADRESSE_NNAME}\r\n		 {$SHOP_ADRESSE_STRASSE}\r\nOrt:	 {$SHOP_ADRESSE_PLZ} {$SHOP_ADRESSE_ORT}\r\n\r\nShop URL: {$SHOP_URL}\r\nE-Mail: ihre@mail-adresse.de\r\n\r\nUST-ID: {$SHOP_USTID}\r\nShopname/in: {$SHOP_BESITZER}', '{literal}<style type="text/css"> \r\n table.signatur {color:#666;border-top:1px solid #ccc}\r\n</style>\r\n{/literal}\r\n<br />\r\n<table width="90%" border="0" cellpadding="4" cellspacing="0" align="center" class="signatur">\r\n <tr>\r\n <td colspan="2">\r\n <strong>Impressum:</strong>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td width="1">Firma:</td>\r\n <td><nobr>{$SHOP_NAME}</nobr></td>\r\n </tr>\r\n <tr>\r\n <td>Shopname:</td>\r\n <td><nobr>{$SHOP_BESITZER}</nobr></td>\r\n </tr>\r\n <tr>\r\n <td valign="top">Adresse:</td>\r\n <td>\r\n <nobr>{$SHOP_ADRESSE_VNAME} {$SHOP_ADRESSE_NNAME}</nobr><br />\r\n <nobr>{$SHOP_ADRESSE_STRASSE}</nobr><br />\r\n <nobr>{$SHOP_ADRESSE_PLZ} {$SHOP_ADRESSE_ORT}</nobr>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td>Shop URL:</td>\r\n <td><nobr><a href="{$SHOP_URL}">{$SHOP_URL}</a></nobr></td>\r\n </tr>\r\n <tr>\r\n <td>E-Mail:</td>\r\n <td><nobr><a href="mailto:{$SHOP_EMAIL}">{$SHOP_EMAIL}</a></nobr></td>\r\n </tr>\r\n {if $SHOP_USTID}\r\n <tr>\r\n <td>UST-ID:</td>\r\n <td><nobr>{$SHOP_USTID}</nobr></td>\r\n </tr>\r\n {/if}\r\n <tr>\r\n <td>Inhaber:</td>\r\n <td><nobr>{$SHOP_ADRESSE_VNAME} {$SHOP_ADRESSE_NNAME}</nobr></td>\r\n </tr>\r\n</table>\r\n</body>\r\n</html>', '\r\n\r\nFirma: {$SHOP_NAME}\r\n\r\nInhaber: {$SHOP_BESITZER}\r\n\r\nAdresse: {$SHOP_ADRESSE_VNAME} {$SHOP_ADRESSE_NNAME}\r\n		 {$SHOP_ADRESSE_STRASSE}\r\nOrt:	 {$SHOP_ADRESSE_PLZ} {$SHOP_ADRESSE_ORT}\r\n\r\nShop URL: {$SHOP_URL}\r\nE-Mail: ihre@mail-adresse.de\r\n\r\nUST-ID: {$SHOP_USTID}\r\nInhaber/in: {$SHOP_BESITZER}', 1263483589);
INSERT INTO emails VALUES(NULL, 'askaquestion', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Frage zum Produkt', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Kontoeröffnung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Frage zum Produkt\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td><br />\r\n <table width="100%" border="0" cellpadding="10" cellspacing="5" align="center" class="outerTable ">\r\n <tr class="lightBackground">\r\n  <td width="1"><nobr>Produktname:</nobr></td>\r\n  <td> {$PRODUCT_NAME}</td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td width="1"><nobr> von:</nobr></td>\r\n  <td> {$FROM_EMAIL_ADDRESS}</td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td> Name:</td>\r\n  <td> {$TEXT_NAME}</td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td>Produkt:</td>\r\n  <td><a href="{$PRODUCT_LINK}">{$PRODUCT_LINK}</a></td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td> Nachricht:</td>\r\n  <td> {$MESSAGE}</td>\r\n </tr>\r\n </table>\r\n <br /><br />\r\n </td>\r\n </tr>\r\n</table>', 'Frage zu Artikel:\r\n\r\n{$PRODUCT_NAME}\r\n\r\nvon: {$FROM_EMAIL_ADDRESS}\r\nName: {$TEXT_NAME}\r\nProdukt: {$PRODUCT_LINK}\r\n\r\nNachricht:\r\n{$MESSAGE}\r\n', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\r\n<title>Kontoeröffnung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.lightBackground td {color:#6d88b1;background: #f1f1f1}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr>\r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Frage zum Produkt\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr>\r\n <td><br />\r\n <table width="100%" border="0" cellpadding="10" cellspacing="5" align="center" class="outerTable ">\r\n <tr class="lightBackground">\r\n  <td width="1"><nobr>Produktname:</nobr></td>\r\n  <td> {$PRODUCT_NAME}</td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td width="1"><nobr> von:</nobr></td>\r\n  <td> {$FROM_EMAIL_ADDRESS}</td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td> Name:</td>\r\n  <td> {$TEXT_NAME}</td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td>Produkt:</td>\r\n  <td><a href="{$PRODUCT_LINK}">{$PRODUCT_LINK}</a></td>\r\n </tr>\r\n <tr class="lightBackground">\r\n  <td> Nachricht:</td>\r\n  <td> {$MESSAGE}</td>\r\n </tr>\r\n </table>\r\n <br /><br />\r\n </td>\r\n </tr>\r\n</table>', 'Frage zu Artikel:\r\n\r\n{$PRODUCT_NAME}\r\n\r\nvon: {$FROM_EMAIL_ADDRESS}\r\nName: {$TEXT_NAME}\r\nProdukt: {$PRODUCT_LINK}\r\n\r\nNachricht:\r\n{$MESSAGE}\r\n', 12345612);
INSERT INTO emails VALUES(NULL, 'stock_mail', 2, 'info@ihr-shop.de', 'commerce:SEO', 'info@ihr-shop.de', 'commerce:SEO', 'Lagerwarnung für Produkt: {$name} / Artikelnummer: {$artnr}', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellstatusänderung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Lagerwarnung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td>Sie wollten gewarnt werden, wenn ein Produkt in Ihrem Shop den Lagerbestand von <b>{$STOCK_AMOUNT}</b> unterschreitet.<br /><br />\r\n\r\nDas Produkt: <a href="{$LINK}">{$PRODUCTS_NAME} ({$PRODUCTS_MODEL})</a> ist nur noch <b>{$PRODUCTS_QUANTITY}</b> mal auf Lager.<br /><br />\r\n\r\nViele Gr&uuml;ße,<br />\r\nIhr Shop</td>\r\n </tr>\r\n</table>\r\n', 'Melden sie sich hier an: {$LOGIN}\r\n------------------------------------------------------\r\n{if $GENDER}Sehr geehrte{if $GENDER eq ''m''}r Herr{elseif $GENDER eq ''f''} Frau{else}(r) {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Hallo,{/if}\r\n\r\n{if $NEW == true}vielen Dank für Ihren Besuch bei {$STORE_NAME} und Ihr uns entgegen gebrachtes Vertrauen.\r\n{else}vielen Dank für Ihren erneuten Besuch bei {$STORE_NAME} und Ihr wiederholtes uns entgegen gebrachtes Vertrauen.{/if}\r\n\r\nWir haben gesehen, daß Sie bei Ihrem Besuch in unserem Onlineshop den Warenkorb mit folgenden Artikeln gefüllt haben, aber den Einkauf nicht vollständig durchgeführt haben.\r\n\r\nInhalt Ihres Warenkorbes:\r\n\r\n{foreach name=outer item=product from=$products_data}\r\n{$product.QUANTITY} x {$product.NAME}\r\n {$product.LINK}\r\n{/foreach}\r\n\r\nWir sind immer bemüht, unseren Service im Interesse unserer Kunden zu verbessern.\r\nAus diesem Grund interessiert es uns natürlich, was die Ursachen dafür waren, Ihren Einkauf dieses Mal nicht bei {$STORE_NAME} zu tätigen.\r\nWir sind Ihnen daher sehr dankbar, wenn Sie uns mitteilen, ob Sie bei Ihrem Besuch in unserem Onlineshop Probleme oder Bedenken hatten, den Einkauf erfolgreich abzuschließen.\r\nUnser Ziel ist es, Ihnen und anderen Kunden, den Einkauf bei {$STORE_NAME} leichter und besser zu gestalten.\r\n\r\nNochmals vielen Dank für Ihre Zeit und Ihre Hilfe, den Onlineshop von {$STORE_NAME} zu verbessern.\r\n\r\nMit freundlichen Grüßen\r\n\r\nIhr Team von {$STORE_NAME}\r\n{if $MESSAGE}\r\n\r\n{$MESSAGE}\r\n{/if}', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de" lang="de">\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />\r\n<title>Bestellstatusänderung</title>\r\n{literal}\r\n<style type="text/css">\r\nbody, table {font-size:11.5px; font-family:Helvetica, sans-serif;color:#444}\r\ntable.outerTable {border: 1px solid #ccc}\r\ntd.TopRightDesc {letter-spacing: 1px; font-weight: 600}\r\n.ProductsTable td {color:#6d88b1;background: #f1f1f1}\r\n.ProductsAttributes td, .ProductsName {background: #ffffff}\r\n.bt {border-top:1px solid #ccc}\r\n.bb {border-bottom:1px solid #ccc}\r\n.bl {border-left:1px solid #ccc}\r\n.br {border-right:1px solid #ccc}\r\n.fs85 {font-size:85%}\r\n</style>\r\n{/literal}\r\n</head>\r\n<body>\r\n<table width="90%" border="0" cellpadding="10" cellspacing="0" align="center" class="outerTable">\r\n <tr> \r\n <td>\r\n <table width="100%" border="0" cellpadding="0" cellspacing="0">\r\n <tr>\r\n  <td width="50%">\r\n  <img src="{$logo_path}logo.gif" alt="" />\r\n  </td>\r\n  <td width="50%" class="TopRightDesc" align="right">\r\n  Lagerwarnung\r\n  </td>\r\n </tr>\r\n </table>\r\n </td>\r\n </tr>\r\n <tr> \r\n <td>Sie wollten gewarnt werden, wenn ein Produkt in Ihrem Shop den Lagerbestand von <b>{$STOCK_AMOUNT}</b> unterschreitet.<br /><br />\r\n\r\nDas Produkt: <a href="{$LINK}">{$PRODUCTS_NAME} ({$PRODUCTS_MODEL})</a> ist nur noch <b>{$PRODUCTS_QUANTITY}</b> mal auf Lager.<br /><br />\r\n\r\nViele Gr&uuml;ße,<br />\r\nIhr Shop</td>\r\n </tr>\r\n</table>\r\n', 'Melden sie sich hier an: {$LOGIN}\r\n------------------------------------------------------\r\n{if $GENDER}Sehr geehrte{if $GENDER eq ''m''}r Herr{elseif $GENDER eq ''f''} Frau{else}(r) {$FIRSTNAME}{/if} {$LASTNAME},\r\n{else}Hallo,{/if}\r\n\r\n{if $NEW == true}vielen Dank für Ihren Besuch bei {$STORE_NAME} und Ihr uns entgegen gebrachtes Vertrauen.\r\n{else}vielen Dank für Ihren erneuten Besuch bei {$STORE_NAME} und Ihr wiederholtes uns entgegen gebrachtes Vertrauen.{/if}\r\n\r\nWir haben gesehen, daß Sie bei Ihrem Besuch in unserem Onlineshop den Warenkorb mit folgenden Artikeln gefüllt haben, aber den Einkauf nicht vollständig durchgeführt haben.\r\n\r\nInhalt Ihres Warenkorbes:\r\n\r\n{foreach name=outer item=product from=$products_data}\r\n{$product.QUANTITY} x {$product.NAME}\r\n {$product.LINK}\r\n{/foreach}\r\n\r\nWir sind immer bemüht, unseren Service im Interesse unserer Kunden zu verbessern.\r\nAus diesem Grund interessiert es uns natürlich, was die Ursachen dafür waren, Ihren Einkauf dieses Mal nicht bei {$STORE_NAME} zu tätigen.\r\nWir sind Ihnen daher sehr dankbar, wenn Sie uns mitteilen, ob Sie bei Ihrem Besuch in unserem Onlineshop Probleme oder Bedenken hatten, den Einkauf erfolgreich abzuschließen.\r\nUnser Ziel ist es, Ihnen und anderen Kunden, den Einkauf bei {$STORE_NAME} leichter und besser zu gestalten.\r\n\r\nNochmals vielen Dank für Ihre Zeit und Ihre Hilfe, den Onlineshop von {$STORE_NAME} zu verbessern.\r\n\r\nMit freundlichen Grüßen\r\n\r\nIhr Team von {$STORE_NAME}\r\n{if $MESSAGE}\r\n\r\n{$MESSAGE}\r\n{/if}', 1263483589);




#database Version
INSERT INTO database_version VALUES ('commerce:SEO v2next CE 2.4.3');



#configuration_group_id 1003
INSERT INTO configuration VALUES (NULL, 'ADMIN_CSEO_ATTRIBUT_MANAGER', 'true', 1003, 1, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'ADMIN_CSEO_TABS_VIEW', 'true', 1003, 2, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'ADMIN_CSEO_START_BIRTHDAY', 'false', 1003, 6, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'ADMIN_CSEO_START_RSS', 'true', 1003, 7, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'ADMIN_CSEO_START_WHOISONLINE', 'false', 1003, 8, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'ADMIN_CSEO_START_ORDERS', 'true', 1003, 9, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'CSEO_LOG_404', 'false', 1003, 10, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'ADMIN_AFTER_LOGIN', 'true', 1003, 11, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'CSEO_URL_ADMIN_ON', 'true', 1003, 12, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");
INSERT INTO configuration VALUES (NULL, 'EMAIL_SQL_ERRORS', 'true', 1003, 14, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");


INSERT INTO configuration VALUES (NULL, 'ADDCATSHOPTITLE', 'false', 16, 4, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration VALUES (NULL, 'ADDPRODSHOPTITLE', 'false', 16, 4, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration VALUES (NULL, 'ADDCONTENTSHOPTITLE', 'false', 16, 4, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration VALUES (NULL, 'ADDSPECIALSSHOPTITLE', 'true', 16, 4, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration VALUES (NULL, 'ADDNEWSSHOPTITLE', 'true', 16, 4, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration VALUES (NULL, 'ADDSEARCHSHOPTITLE', 'true', 16, 4, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration VALUES (NULL, 'ADDOTHERSSHOPTITLE', 'true', 16, 4, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),');


INSERT INTO configuration VALUES (NULL, 'TREEPODIAACTIVE', 'false', 1004, 1, NULL, NOW(), NULL, 'xtc_cfg_select_option(array(''true'', ''false''),');
INSERT INTO configuration VALUES (NULL, 'TREEPODIAID', '', 1004, 2, NULL, NOW(), NULL, '');

INSERT INTO configuration VALUES (NULL, 'TREEPODI_GLOBAL_CATCH_1', '', 1004, 30, NULL, NOW(), NULL, '');
INSERT INTO configuration VALUES (NULL, 'TREEPODI_GLOBAL_CATCH_2', '', 1004, 31, NULL, NOW(), NULL, '');
INSERT INTO configuration VALUES (NULL, 'TREEPODI_GLOBAL_CATCH_3', '', 1004, 32, NULL, NOW(), NULL, '');
INSERT INTO configuration VALUES (NULL, 'TREEPODI_GLOBAL_CATCH_4', '', 1004, 33, NULL, NOW(), NULL, '');


INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_LEFT_MARGIN', '20', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_TOP_MARGIN', '10', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_LOGO_X', '120', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_LOGO_Y', '30', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_LOGO_DPI', '80', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_LOGO_FILE', 'logo.jpg', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_LEFT_TEXTOFFSET', '20', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_FOOTER_Y', '-35', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_ADDRESSWINDOWMAXLEN', '80', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_ADDRESSWINDOWTOP', '50', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_FONTFAMILY', 'helvetica', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_RECHNUNGSDATEN_X', '130', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_RECHNUNGSDATEN_Y', '55', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_RECHNUNG_START', '100', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_MENGE_LEN', '18', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_ARTIKEL_LEN', '82', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_ARTIKELNR_LEN', '20', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_EINZELPREIS_LEN', '28', 'layout');
INSERT INTO orders_pdf_profile ( id , languages_id , pdf_key , pdf_value , type ) VALUES (NULL , '0', 'LAYOUT_PREIS_LEN', '28', 'layout');


INSERT INTO configuration VALUES (NULL, 'GOOGLE_PLUS_AUTHOR_ID', '', 16, 17, NULL , NOW(), NULL , NULL);
INSERT INTO configuration VALUES (NULL, 'DISPLAY_MORE_CAT_DESC', 'true', 8, 10, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");


INSERT INTO configuration VALUES (NULL, 'FACEBOOK_URL', '', 16, 18, NULL , NOW(), NULL , NULL);
INSERT INTO configuration VALUES (NULL, 'XING_URL', '', 16, 19, NULL , NOW(), NULL , NULL);
INSERT INTO configuration VALUES (NULL, 'TWITTER_URL', '', 16, 20, NULL , NOW(), NULL , NULL);
INSERT INTO configuration VALUES (NULL, 'PINTEREST_URL', '', 16, 21, NULL , NOW(), NULL , NULL);
INSERT INTO configuration VALUES (NULL, 'GOOGLEPLUS_URL', '', 16, 22, NULL , NOW(), NULL , NULL);
INSERT INTO configuration VALUES (NULL, 'YOUTUBE_URL', '', 16, 23, NULL , NOW(), NULL , NULL);
INSERT INTO configuration VALUES (NULL, 'TUMBLR_URL', '', 16, 24, NULL , NOW(), NULL , NULL);
INSERT INTO configuration VALUES (NULL, 'BING_VERIFY', '', 16, 16, NULL , NOW(), NULL , NULL);



INSERT INTO cseo_antispam (id, question, answer, language_id) VALUES(NULL, 'What color is grass?', 'green', 1);
INSERT INTO cseo_antispam (id, question, answer, language_id) VALUES(NULL, 'Welche Farbe hat Rasen?', 'grün', 2);
INSERT INTO cseo_antispam (id, question, answer, language_id) VALUES(NULL, 'What color is sun?', 'yellow', 1);
INSERT INTO cseo_antispam (id, question, answer, language_id) VALUES(NULL, 'Welche Farbe hat die Sonne?', 'gelb', 2);

INSERT INTO configuration VALUES (NULL, 'MASTER_SLAVE_FUNCTION', 'false', 155, 17, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");

INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order) VALUES ('CHECKOUT_BOX_ORDER', 'modules|addresses|comments|legals|wd|ds|products', 334, 12);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order) VALUES ('MAIN_BOX_ORDER', 'promo|text1|cat|upc|newp|randp|rands|best|blog|text2', 335, 12);

INSERT INTO configuration VALUES (NULL, 'BESTSELLER_START', 'false', 1000, 17, NULL, NOW(), NULL, "xtc_cfg_select_option(array('true', 'false'),");

INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_ADD_ADDRESS', 'new address', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_BACK', 'back', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_CHANGE_ADDRESS', 'change address', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_CHECKOUT', 'checkout', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_CONFIRM_ORDER', 'order', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_CONTINUE', 'next', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_DELETE', 'delete', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_LOGIN', 'login', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_IN_CART', 'into the cart', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_SEARCH', 'go', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_PRINT', 'print', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_ADD_A_QUICKIE', 'add', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_UPDATE', 'update', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_UPDATE_CART', 'update shopping cart', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_WRITE_REVIEW', 'write Evaluation', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_ADMIN', 'admin', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_MOBILE_ADMIN', 'mobile-admin', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_PRODUCT_EDIT', 'edit product', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_PRINT_PDF', 'create PDF and show me', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_PRINT_CONTENT', 'print text', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_SEND', 'send', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_SAVE', 'save', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_EDIT', 'edit', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_DETAILS', 'details', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_ALL_WISH', 'buy all', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_MORE_NEWS', 'more news', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_TO_CART', 'to cart', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_BACK_SHOP', 'back to shop', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_VOTE', 'vote this shop', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'TEXT_NOW', 'order', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'TEXT_BUTTON_BUY_NOW', 'order', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'TEXT_NOW_TO_WISHLIST', 'to the wish list', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'TEXT_TO_WISHLIST', 'to wish list', 1);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'WISHLIST', 'wish', 1);

INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_ADD_ADDRESS', 'Neue Adresse', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_BACK', 'zurück', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_CHANGE_ADDRESS', 'Adresse ändern', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_CHECKOUT', 'zur Kasse', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_CONFIRM_ORDER', 'Zahlungspflichtig bestellen', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_CONTINUE', 'Weiter', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_DELETE', 'Löschen', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_LOGIN', 'Anmelden', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_IN_CART', 'In den Warenkorb', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_SEARCH', 'Los', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_PRINT', 'Drucken', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_ADD_A_QUICKIE', 'Bestellen', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_UPDATE', 'Aktualisieren', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_UPDATE_CART', 'Warenkorb aktualisieren', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_WRITE_REVIEW', 'Bewertung schreiben', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_ADMIN', 'Admin', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_MOBILE_ADMIN', 'Mobile-Admin', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_PRODUCT_EDIT', 'Produkt bearbeiten', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_PRINT_PDF', 'PDF erzeugen und anzeigen', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_PRINT_CONTENT', 'Text drucken', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_SEND', 'Absenden', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_SAVE', 'Speichern', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_EDIT', 'bearbeiten', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_DETAILS', 'Details', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_ALL_WISH', 'kompletten Merkzettel bestellen', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_MORE_NEWS', 'mehr anzeigen', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_TO_CART', 'zum Warenkorb', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_BACK_SHOP', 'zurück zum Shop', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'IMAGE_BUTTON_VOTE', 'Shop bewerten', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'TEXT_NOW', 'kaufen', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'TEXT_BUTTON_BUY_NOW', 'kaufen', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'TEXT_NOW_TO_WISHLIST', 'dem Merkzettel hinzufügen', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'TEXT_TO_WISHLIST', 'zum Merkzettel', 2);
INSERT INTO cseo_lang_button (id, button, buttontext, language_id) VALUES('', 'WISHLIST', 'auf den Merkzettel', 2);


INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'categories', 'Categories / Produtcs', 'products', 'categories.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'categories', 'Kategorien / Artikel', 'products', 'categories.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'new_attributes', 'New Attributes', 'products', 'new_attributes.php', NULL, 1, NULL, 2);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'new_attributes', 'Attribut Verwaltung', 'products', 'new_attributes.php', NULL, 2, NULL, 2);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'products_attributes', 'Attributes', 'products', 'products_attributes.php', NULL, 1, NULL, 3);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'products_attributes', 'Artikelmerkmale', 'products', 'products_attributes.php', NULL, 2, NULL, 3);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'manufacturers', 'Manufacturers', 'products', 'manufacturers.php', NULL, 1, NULL, 4);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'manufacturers', 'Hersteller', 'products', 'manufacturers.php', NULL, 2, NULL, 4);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'reviews', 'Reviews', 'products', 'reviews.php', NULL, 1, NULL, 12);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'reviews', 'Artikelbewertungen', 'products', 'reviews.php', NULL, 2, NULL, 12);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'specials', 'Specials', 'products', 'specials.php', NULL, 1, NULL, 5);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'specials', 'Sonderangebote', 'products', 'specials.php', NULL, 2, NULL, 5);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'products_expected', 'Products expected', 'products', 'products_expected.php', NULL, 1, NULL, 6);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'products_expected', 'Erwartete Artikel', 'products', 'products_expected.php', NULL, 2, NULL, 6);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'accessories', 'Accessories', 'products', 'accessories.php', NULL, 1, NULL, 7);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'accessories', 'Zubehör', 'products', 'accessories.php', NULL, 2, NULL, 7);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'price_change', 'Lagerbestände', 'products', 'price_change.php', NULL, 1, NULL, 8);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'price_change', 'Lagerbestände', 'products', 'price_change.php', NULL, 2, NULL, 8);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'global_products_price', 'Price Update', 'products', 'global_products_price.php', NULL, 1, NULL, 9);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'global_products_price', 'Preis Aktualisierung', 'products', 'global_products_price.php', NULL, 2, NULL, 9);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'product_filter', 'Product Filter', 'products', 'product_filter.php', NULL, 1, NULL, 10);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'product_filter', 'Produkt Filter', 'products', 'product_filter.php', NULL, 2, NULL, 10);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Productview', 'products', 'configuration.php', 1002, 1, NULL, 11);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Produktdarstellung', 'products', 'configuration.php', 1002, 2, NULL, 11);

INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'gv_sent', 'Coupon send', 'gift', 'gv_sent.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'gv_sent', 'Kupon versendet', 'gift', 'gv_sent.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'gv_mail', 'Coupon Mail', 'gift', 'gv_mail.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'gv_mail', 'Kupon Mail', 'gift', 'gv_mail.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'coupon_admin', 'Coupon Admin', 'gift', 'coupon_admin.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'coupon_admin', 'Kupon Admin', 'gift', 'coupon_admin.php', NULL, 2, NULL, 1);

INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'customers', 'Customers', 'customers', 'customers.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'customers', 'Kunden', 'customers', 'customers.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'customers_status', 'Customers Status', 'customers', 'customers_status.php', NULL, 1, NULL, 2);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'customers_status', 'Kundengruppe', 'customers', 'customers_status.php', NULL, 2, NULL, 2);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'orders', 'Orders', 'customers', 'orders.php', NULL, 1, NULL, 3);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'orders', 'Bestellungen', 'customers', 'orders.php', NULL, 2, NULL, 3);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'paypal', 'PayPal', 'customers', 'paypal.php', NULL, 1, NULL, 4);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'paypal', 'PayPal Zahlungen', 'customers', 'paypal.php', NULL, 2, NULL, 4);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'customers_sik', 'Customer Sik', 'customers', 'customers_sik.php', NULL, 1, NULL, 5);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'customers_sik', 'gelöschte Kunden', 'customers', 'customers_sik.php', NULL, 2, NULL, 5);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'recover_cart_sales', 'Recover cart sales', 'customers', 'recover_cart_sales.php', NULL, 1, NULL, 6);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'recover_cart_sales', 'Offene Warenkörbe', 'customers', 'recover_cart_sales.php', NULL, 2, NULL, 6);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'recover_wish_list', 'Recover Wish Lists', 'customers', 'recover_wish_list.php', NULL, 1, NULL, 7);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'recover_wish_list', 'Offene Merkzettel', 'customers', 'recover_wish_list.php', NULL, 2, NULL, 7);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'customers_aquise', 'Customers Aquise', 'customers', 'customers_aquise.php', NULL, 1, NULL, 8);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'customers_aquise', 'Kunden CRM', 'customers', 'customers_aquise.php', NULL, 2, NULL, 8);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'orders_overview', 'Orders Overview', 'customers', 'orders_overview.php', NULL, 1, NULL, 9);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'orders_overview', 'Bestellübersicht', 'customers', 'orders_overview.php', NULL, 2, NULL, 9);

INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'modules', 'Payment', 'modules', 'modules.php', NULL, 1, 'payment', 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'modules', 'Zahlarten', 'modules', 'modules.php', NULL, 2, 'payment', 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'modules', 'Shipping', 'modules', 'modules.php', NULL, 1, 'shipping', 2);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'modules', 'Versandarten', 'modules', 'modules.php', NULL, 2, 'shipping', 2);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'modules', 'Order Total', 'modules', 'modules.php', NULL, 1, 'ordertotal', 3);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'modules', 'Zusammenfassung', 'modules', 'modules.php', NULL, 2, 'ordertotal', 3);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'module_system', 'System Modules', 'modules', 'module_system.php', NULL, 1, NULL, 4);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'module_system', 'System Module', 'modules', 'module_system.php', NULL, 2, NULL, 4);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'module_install', 'Install / Update', 'modules', 'module_install.php', NULL, 1, NULL, 5);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'module_install', 'Installation / Update', 'modules', 'module_install.php', NULL, 2, NULL, 5);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'module_export', 'Export Modules', 'modules', 'module_export.php', NULL, 1, NULL, 5);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'module_export', 'Export Module', 'modules', 'module_export.php', NULL, 2, NULL, 5);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cseo_product_export', 'Export Produkte', 'modules', 'cseo_product_export.php', NULL, 2, NULL, 5);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cseo_product_export', 'Export Products', 'modules', 'cseo_product_export.php', NULL, 1, NULL, 5);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'novalnet', 'Novalnet', 'modules', 'novalnet.php', NULL, 1, NULL, 6);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'novalnet', 'Novalnet', 'modules', 'novalnet.php', NULL, 2, NULL, 6);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'magnalister', 'magnalister', 'modules', 'magnalister.php', NULL, 1, NULL, 7);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'magnalister', 'Magnalister', 'modules', 'magnalister.php', NULL, 2, NULL, 7);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'haendlerbund', 'Haendlerbund', 'modules', 'haendlerbund.php', NULL, 1, NULL, 8);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'haendlerbund', 'Haendlerbund', 'modules', 'haendlerbund.php', NULL, 2, NULL, 8);

INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'whos_online', 'Whos Online', 'statistics', 'whos_online.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'whos_online', 'Wer ist Online', 'statistics', 'whos_online.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_products_viewed', 'Products viewed', 'statistics', 'stats_products_viewed.php', NULL, 1, NULL, 2);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_products_viewed', 'Besuchte Produkte', 'statistics', 'stats_products_viewed.php', NULL, 2, NULL, 2);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_products_purchased', 'Products purchased', 'statistics', 'stats_products_purchased.php', NULL, 1, NULL, 3);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_products_purchased', 'Umsatzstärkste Produkte', 'statistics', 'stats_products_purchased.php', NULL, 2, NULL, 3);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_customers', 'Customers Statistic', 'statistics', 'stats_customers.php', NULL, 1, NULL, 4);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_customers', 'Bestellstatistik', 'statistics', 'stats_customers.php', NULL, 2, NULL, 4);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_sales_report', 'Sales Report', 'statistics', 'stats_sales_report.php', NULL, 1, NULL, 5);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_sales_report', 'Umsatzstatistik', 'statistics', 'stats_sales_report.php', NULL, 2, NULL, 5);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_stock_warning', 'Stock Warning', 'statistics', 'stats_stock_warning.php', NULL, 1, NULL, 6);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_stock_warning', 'Lagerbestände', 'statistics', 'stats_stock_warning.php', NULL, 2, NULL, 6);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_campaigns', 'Campaigns Report', 'statistics', 'stats_campaigns.php', NULL, 1, NULL, 7);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_campaigns', 'Kampagnen Report', 'statistics', 'stats_campaigns.php', NULL, 2, NULL, 7);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_keywords_all', 'Keywords Statistic', 'statistics', 'stats_keywords_all.php', NULL, 1, NULL, 8);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_keywords_all', 'Suchbegriff Statistik', 'statistics', 'stats_keywords_all.php', NULL, 2, NULL, 8);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_recover_cart_sales', 'Open Carts', 'statistics', 'stats_recover_cart_sales.php', NULL, 1, NULL, 9);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'stats_recover_cart_sales', 'Offene Warenkörbe', 'statistics', 'stats_recover_cart_sales.php', NULL, 2, NULL, 9);

INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'module_newsletter_products', 'Newsletter Products', 'tools', 'module_newsletter_products.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'module_newsletter_products', 'Newsletter Produkte', 'tools', 'module_newsletter_products.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'module_newsletter', 'Newsletter', 'tools', 'module_newsletter.php', NULL, 1, NULL, 2);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'module_newsletter', 'Newsletter', 'tools', 'module_newsletter.php', NULL, 2, NULL, 2);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'content_manager', 'Content Manager', 'tools', 'content_manager.php', NULL, 1, NULL, 3);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'content_manager', 'Content Manager', 'tools', 'content_manager.php', NULL, 2, NULL, 3);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'blog', 'Blog Manager', 'tools', 'blog.php', NULL, 1, NULL, 4);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'blog', 'Blog Manager', 'tools', 'blog.php', NULL, 2, NULL, 4);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'backup', 'Backup Manager', 'tools', 'backup.php', NULL, 1, NULL, 6);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'backup', 'Backup Manager', 'tools', 'backup.php', NULL, 2, NULL, 6);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'banner_manager', 'Banner Manager', 'tools', 'banner_manager.php', NULL, 1, NULL, 7);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'banner_manager', 'Banner Manager', 'tools', 'banner_manager.php', NULL, 2, NULL, 7);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'css_styler', 'CSS Buttons', 'tools', 'css_styler.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'css_styler', 'CSS Buttons', 'tools', 'css_styler.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'box_manager', 'Box Manager', 'tools', 'box_manager.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'box_manager', 'Boxen Manager', 'tools', 'box_manager.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'news_ticker', 'News Ticker', 'tools', 'news_ticker.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'news_ticker', 'News Ticker', 'tools', 'news_ticker.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'server_info', 'Server Info', 'tools', 'server_info.php', NULL, 1, NULL, 8);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'server_info', 'Server Info', 'tools', 'server_info.php', NULL, 2, NULL, 8);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'csv_backend', 'CSV Import/Export', 'tools', 'csv_backend.php', NULL, 1, NULL, 9);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'csv_backend', 'CSV Import/Export', 'tools', 'csv_backend.php', NULL, 2, NULL, 9);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'database_manager', 'SQL Tool', 'tools', 'database_manager.php', NULL, 1, NULL, 10);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'database_manager', 'SQL Tool', 'tools', 'database_manager.php', NULL, 2, NULL, 10);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'google_sitemap', 'Google Sitemap', 'tools', '../google_sitemap.php?auto=true&ping=true', NULL, 1, NULL, 11);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'google_sitemap', 'Google Sitemap', 'tools', '../google_sitemap.php?auto=true&ping=true', NULL, 2, NULL, 11);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'delete_cache', 'delete Cache', 'tools', 'delete_cache.php', NULL, 1, NULL, 12);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'delete_cache', 'Cache leeren', 'tools', 'delete_cache.php', NULL, 2, NULL, 12);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'removeoldpics', 'remove old Pics', 'tools', 'removeoldpics.php', NULL, 1, NULL, 13);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'removeoldpics', 'alte Bilder löschen', 'tools', 'removeoldpics.php', NULL, 2, NULL, 13);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cseo_imageprocessing', 'Pics rendering', 'tools', 'cseo_imageprocessing.php', NULL, 1, NULL, 14);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cseo_imageprocessing', 'Bilder neu erstellen', 'tools', 'cseo_imageprocessing.php', NULL, 2, NULL, 14);

INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Base-Configuration', 'seo_config', 'configuration.php', 155, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Grundkonfiguration', 'seo_config', 'configuration.php', 155, 2, NULL, 1);

INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'product_listings', 'Product Listings', 'seo_config', 'product_listings.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'product_listings', 'Produktlisten-Einstellung', 'seo_config', 'product_listings.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'orders_pdf_profiler', 'PDF WAWI Config', 'seo_config', 'orders_pdf_profiler.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'orders_pdf_profiler', 'PDF WAWI Einstellung', 'seo_config', 'orders_pdf_profiler.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'personal_links', 'Personal Links', 'seo_config', 'personal_links.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'personal_links', 'Personal Links', 'seo_config', 'personal_links.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Frontpage - Config', 'seo_config', 'configuration.php', 1000, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Startseite - Einstellung', 'seo_config', 'configuration.php', 1000, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Twitter Box', 'seo_config', 'configuration.php', 1001, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Twitter Box', 'seo_config', 'configuration.php', 1001, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Recover Carts', 'seo_config', 'configuration.php', 33, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Offene Warenkörbe', 'seo_config', 'configuration.php', 33, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Security Settings', 'seo_config', 'configuration.php', 363, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Sicherheitseinstellungen', 'seo_config', 'configuration.php', 363, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Order Process', 'seo_config', 'configuration.php', 333, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Bestellprozess', 'seo_config', 'configuration.php', 333, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'PayPal Express', 'seo_config', 'configuration.php', 25, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'PayPal Express', 'seo_config', 'configuration.php', 25, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cseo_language_button', 'button languages', 'seo_config', 'cseo_language_button.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cseo_language_button', 'Button Sprache', 'seo_config', 'cseo_language_button.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cseo_ids', 'number Ranges', 'seo_config', 'cseo_ids.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cseo_ids', 'Nummernkreise', 'seo_config', 'cseo_ids.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cseo_antispam', 'Anti-SPAM', 'seo_config', 'cseo_antispam.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cseo_antispam', 'Anti-SPAM', 'seo_config', 'cseo_antispam.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Admin Config', 'seo_config', 'configuration.php', 1003, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Admin Einstellungen', 'seo_config', 'configuration.php', 1003, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cseo_redirect', 'Redirect Setting', 'seo_config', 'cseo_redirect.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cseo_redirect', 'Umleitungen definieren', 'seo_config', 'cseo_redirect.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Trusted Shops', 'seo_config', 'configuration.php', 156, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Trusted Shops', 'seo_config', 'configuration.php', 156, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'janolaw', 'Janolaw', 'seo_config', 'janolaw.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'janolaw', 'Janolaw', 'seo_config', 'janolaw.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Tracking & Analytics', 'seo_config', 'configuration.php', 361, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Tracking & Analytics', 'seo_config', 'configuration.php', 361, 2, NULL, 1);

INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'languages', 'Languages', 'zones', 'languages.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'languages', 'Sprachen', 'zones', 'languages.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'countries', 'Countries', 'zones', 'countries.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'countries', 'Länder', 'zones', 'countries.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'currencies', 'Currencies', 'zones', 'currencies.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'currencies', 'Währungen', 'zones', 'currencies.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'zones', 'Zones', 'zones', 'zones.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'zones', 'Bundesländer', 'zones', 'zones.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'geo_zones', 'Tax Zones', 'zones', 'geo_zones.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'geo_zones', 'Steuerzonen', 'zones', 'geo_zones.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'tax_classes', 'Tax Classes', 'zones', 'tax_classes.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'tax_classes', 'Steuerklassen', 'zones', 'tax_classes.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'tax_rates', 'Tax Rates', 'zones', 'tax_rates.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'tax_rates', 'Steuersätze', 'zones', 'tax_rates.php', NULL, 2, NULL, 1);

INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'My Shop', 'config', 'configuration.php', 1, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Mein Shop', 'config', 'configuration.php', 1, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Minimum Values', 'config', 'configuration.php', 2, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Minimum Werte', 'config', 'configuration.php', 2, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Maximum Values', 'config', 'configuration.php', 3, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Maximum Werte', 'config', 'configuration.php', 3, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Image Options', 'config', 'configuration.php', 4, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Bild Optionen', 'config', 'configuration.php', 4, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Customer Details', 'config', 'configuration.php', 5, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Kunden Details', 'config', 'configuration.php', 5, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Shipping Options', 'config', 'configuration.php', 7, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Versand Optionen', 'config', 'configuration.php', 7, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Product Listing Options', 'config', 'configuration.php', 8, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Artikel Listen Optionen', 'config', 'configuration.php', 8, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Stock Options', 'config', 'configuration.php', 9, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Lagerverwaltungs Optionen', 'config', 'configuration.php', 9, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Logging Options', 'config', 'configuration.php', 10, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Logging Optionen', 'config', 'configuration.php', 10, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Cache Options', 'config', 'configuration.php', 11, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Cache Optionen', 'config', 'configuration.php', 11, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'E-Mail Options', 'config', 'configuration.php', 12, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'E-Mail Optionen', 'config', 'configuration.php', 12, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'emails', 'E-Mail Templates', 'config', 'emails.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'emails', 'E-Mail Vorlagen', 'config', 'emails.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Download Options', 'config', 'configuration.php', 13, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Download Optionen', 'config', 'configuration.php', 13, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'GZip Compression', 'config', 'configuration.php', 14, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'GZip Kompression', 'config', 'configuration.php', 14, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Sessions Options', 'config', 'configuration.php', 15, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Sessions Optionen', 'config', 'configuration.php', 15, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Meta-Tags/Searchengines', 'config', 'configuration.php', 16, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Meta-Tags / Suchmaschinen', 'config', 'configuration.php', 16, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Specialmodules', 'config', 'configuration.php', 17, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Zusatzmodule', 'config', 'configuration.php', 17, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'UST ID', 'config', 'configuration.php', 18, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'UST ID', 'config', 'configuration.php', 18, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Partner', 'config', 'configuration.php', 19, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Partner', 'config', 'configuration.php', 19, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Search Options', 'config', 'configuration.php', 22, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'configuration', 'Such Optionen', 'config', 'configuration.php', 22, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'orders_status', 'Order Status', 'config', 'orders_status.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'orders_status', 'Bestellstatus', 'config', 'orders_status.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'shipping_status', 'Shipping Status', 'config', 'shipping_status.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'shipping_status', 'Lieferstatus', 'config', 'shipping_status.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'products_vpe', 'Packing unit', 'config', 'products_vpe.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'products_vpe', 'Grundpreis Einstellung', 'config', 'products_vpe.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'campaigns', 'Campaigns', 'config', 'campaigns.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'campaigns', 'Kampagnen', 'config', 'campaigns.php', NULL, 2, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cross_sell_groups', 'Cross-Selling Groups', 'config', 'cross_sell_groups.php', NULL, 1, NULL, 1);
INSERT INTO admin_navigation (id, name, title, subsite, filename, gid, languages_id, nav_set, sort) VALUES (NULL, 'cross_sell_groups', 'Cross-Selling Gruppen', 'config', 'cross_sell_groups.php', NULL, 2, NULL, 1);



INSERT INTO admin_navigation VALUES(NULL, 'comments_orders', 'Kommentarvorlagen', 'customers', 'comments_orders.php', NULL, 2, NULL, 10);
INSERT INTO admin_navigation VALUES(NULL, 'comments_orders', 'Comment Templates', 'customers', 'comments_orders.php', NULL, 1, NULL, 10);


INSERT INTO admin_navigation VALUES(NULL, 'cseo_checkout_sort', 'Sortierung Checkout', 'seo_config', 'cseo_checkout_sort.php', NULL, 2, NULL, 10);
INSERT INTO admin_navigation VALUES(NULL, 'cseo_checkout_sort', 'Sort Checkout', 'seo_config', 'cseo_checkout_sort.php', NULL, 1, NULL, 10);

INSERT INTO admin_navigation VALUES(NULL, 'cseo_main_sort', 'Sortierung Startseite', 'seo_config', 'cseo_main_sort.php', NULL, 2, NULL, 10);
INSERT INTO admin_navigation VALUES(NULL, 'cseo_main_sort', 'Sort Main', 'seo_config', 'cseo_main_sort.php', NULL, 1, NULL, 10);

#Countries
INSERT INTO countries VALUES (1,'Afghanistan','AF','AFG',1,1);
INSERT INTO countries VALUES (2,'Albania','AL','ALB',1,1);
INSERT INTO countries VALUES (3,'Algeria','DZ','DZA',1,1);
INSERT INTO countries VALUES (4,'American Samoa','AS','ASM',1,1);
INSERT INTO countries VALUES (5,'Andorra','AD','AND',1,1);
INSERT INTO countries VALUES (6,'Angola','AO','AGO',1,1);
INSERT INTO countries VALUES (7,'Anguilla','AI','AIA',1,1);
INSERT INTO countries VALUES (8,'Antarctica','AQ','ATA',1,1);
INSERT INTO countries VALUES (9,'Antigua and Barbuda','AG','ATG',1,1);
INSERT INTO countries VALUES (10,'Argentina','AR','ARG',1,1);
INSERT INTO countries VALUES (11,'Armenia','AM','ARM',1,1);
INSERT INTO countries VALUES (12,'Aruba','AW','ABW',1,1);
INSERT INTO countries VALUES (13,'Australia','AU','AUD',1,1);
INSERT INTO countries VALUES (14,'Austria','AT','AUT',5,1);
INSERT INTO countries VALUES (15,'Azerbaijan','AZ','AZE',1,1);
INSERT INTO countries VALUES (16,'Bahamas','BS','BHS',1,1);
INSERT INTO countries VALUES (17,'Bahrain','BH','BHR',1,1);
INSERT INTO countries VALUES (18,'Bangladesh','BD','BGD',1,1);
INSERT INTO countries VALUES (19,'Barbados','BB','BRB',1,1);
INSERT INTO countries VALUES (20,'Belarus','BY','BLR',1,1);
INSERT INTO countries VALUES (21,'Belgium','BE','BEL',1,1);
INSERT INTO countries VALUES (22,'Belize','BZ','BLZ',1,1);
INSERT INTO countries VALUES (23,'Benin','BJ','BEN',1,1);
INSERT INTO countries VALUES (24,'Bermuda','BM','BMU',1,1);
INSERT INTO countries VALUES (25,'Bhutan','BT','BTN',1,1);
INSERT INTO countries VALUES (26,'Bolivia','BO','BOL',1,1);
INSERT INTO countries VALUES (27,'Bosnia and Herzegowina','BA','BIH',1,1);
INSERT INTO countries VALUES (28,'Botswana','BW','BWA',1,1);
INSERT INTO countries VALUES (29,'Bouvet Island','BV','BVT',1,1);
INSERT INTO countries VALUES (30,'Brazil','BR','BRA',1,1);
INSERT INTO countries VALUES (31,'British Indian Ocean Territory','IO','IOT',1,1);
INSERT INTO countries VALUES (32,'Brunei Darussalam','BN','BRN',1,1);
INSERT INTO countries VALUES (33,'Bulgaria','BG','BGR',1,1);
INSERT INTO countries VALUES (34,'Burkina Faso','BF','BFA',1,1);
INSERT INTO countries VALUES (35,'Burundi','BI','BDI',1,1);
INSERT INTO countries VALUES (36,'Cambodia','KH','KHM',1,1);
INSERT INTO countries VALUES (37,'Cameroon','CM','CMR',1,1);
INSERT INTO countries VALUES (38,'Canada','CA','CAN',1,1);
INSERT INTO countries VALUES (39,'Cape Verde','CV','CPV',1,1);
INSERT INTO countries VALUES (40,'Cayman Islands','KY','CYM',1,1);
INSERT INTO countries VALUES (41,'Central African Republic','CF','CAF',1,1);
INSERT INTO countries VALUES (42,'Chad','TD','TCD',1,1);
INSERT INTO countries VALUES (43,'Chile','CL','CHL',1,1);
INSERT INTO countries VALUES (44,'China','CN','CHN',7,1);
INSERT INTO countries VALUES (45,'Christmas Island','CX','CXR',1,1);
INSERT INTO countries VALUES (46,'Cocos (Keeling) Islands','CC','CCK',1,1);
INSERT INTO countries VALUES (47,'Colombia','CO','COL',1,1);
INSERT INTO countries VALUES (48,'Comoros','KM','COM',1,1);
INSERT INTO countries VALUES (49,'Congo','CG','COG',1,1);
INSERT INTO countries VALUES (50,'Cook Islands','CK','COK',1,1);
INSERT INTO countries VALUES (51,'Costa Rica','CR','CRI',1,1);
INSERT INTO countries VALUES (52,'Cote D\'Ivoire','CI','CIV',1,1);
INSERT INTO countries VALUES (53,'Croatia','HR','HRV',1,1);
INSERT INTO countries VALUES (54,'Cuba','CU','CUB',1,1);
INSERT INTO countries VALUES (55,'Cyprus','CY','CYP',1,1);
INSERT INTO countries VALUES (56,'Czech Republic','CZ','CZE',1,1);
INSERT INTO countries VALUES (57,'Denmark','DK','DNK',1,1);
INSERT INTO countries VALUES (58,'Djibouti','DJ','DJI',1,1);
INSERT INTO countries VALUES (59,'Dominica','DM','DMA',1,1);
INSERT INTO countries VALUES (60,'Dominican Republic','DO','DOM',1,1);
INSERT INTO countries VALUES (61,'East Timor','TP','TMP',1,1);
INSERT INTO countries VALUES (62,'Ecuador','EC','ECU',1,1);
INSERT INTO countries VALUES (63,'Egypt','EG','EGY',1,1);
INSERT INTO countries VALUES (64,'El Salvador','SV','SLV',1,1);
INSERT INTO countries VALUES (65,'Equatorial Guinea','GQ','GNQ',1,1);
INSERT INTO countries VALUES (66,'Eritrea','ER','ERI',1,1);
INSERT INTO countries VALUES (67,'Estonia','EE','EST',1,1);
INSERT INTO countries VALUES (68,'Ethiopia','ET','ETH',1,1);
INSERT INTO countries VALUES (69,'Falkland Islands (Malvinas)','FK','FLK',1,1);
INSERT INTO countries VALUES (70,'Faroe Islands','FO','FRO',1,1);
INSERT INTO countries VALUES (71,'Fiji','FJ','FJI',1,1);
INSERT INTO countries VALUES (72,'Finland','FI','FIN',1,1);
INSERT INTO countries VALUES (73,'France','FR','FRA',1,1);
INSERT INTO countries VALUES (74,'France, Metropolitan','FX','FXX',1,1);
INSERT INTO countries VALUES (75,'French Guiana','GF','GUF',1,1);
INSERT INTO countries VALUES (76,'French Polynesia','PF','PYF',1,1);
INSERT INTO countries VALUES (77,'French Southern Territories','TF','ATF',1,1);
INSERT INTO countries VALUES (78,'Gabon','GA','GAB',1,1);
INSERT INTO countries VALUES (79,'Gambia','GM','GMB',1,1);
INSERT INTO countries VALUES (80,'Georgia','GE','GEO',1,1);
INSERT INTO countries VALUES (81,'Deutschland','DE','DEU',5,1);
INSERT INTO countries VALUES (82,'Ghana','GH','GHA',1,1);
INSERT INTO countries VALUES (83,'Gibraltar','GI','GIB',1,1);
INSERT INTO countries VALUES (84,'Greece','GR','GRC',1,1);
INSERT INTO countries VALUES (85,'Greenland','GL','GRL',1,1);
INSERT INTO countries VALUES (86,'Grenada','GD','GRD',1,1);
INSERT INTO countries VALUES (87,'Guadeloupe','GP','GLP',1,1);
INSERT INTO countries VALUES (88,'Guam','GU','GUM',1,1);
INSERT INTO countries VALUES (89,'Guatemala','GT','GTM',1,1);
INSERT INTO countries VALUES (90,'Guinea','GN','GIN',1,1);
INSERT INTO countries VALUES (91,'Guinea-bissau','GW','GNB',1,1);
INSERT INTO countries VALUES (92,'Guyana','GY','GUY',1,1);
INSERT INTO countries VALUES (93,'Haiti','HT','HTI',1,1);
INSERT INTO countries VALUES (94,'Heard and Mc Donald Islands','HM','HMD',1,1);
INSERT INTO countries VALUES (95,'Honduras','HN','HND',1,1);
INSERT INTO countries VALUES (96,'Hong Kong','HK','HKG',1,1);
INSERT INTO countries VALUES (97,'Hungary','HU','HUN',1,1);
INSERT INTO countries VALUES (98,'Iceland','IS','ISL',1,1);
INSERT INTO countries VALUES (99,'India','IN','IND',1,1);
INSERT INTO countries VALUES (100,'Indonesia','ID','IDN',1,1);
INSERT INTO countries VALUES (101,'Iran (Islamic Republic of)','IR','IRN',1,1);
INSERT INTO countries VALUES (102,'Iraq','IQ','IRQ',1,1);
INSERT INTO countries VALUES (103,'Ireland','IE','IRL',6,1);
INSERT INTO countries VALUES (104,'Israel','IL','ISR',1,1);
INSERT INTO countries VALUES (105,'Italy','IT','ITA',1,1);
INSERT INTO countries VALUES (106,'Jamaica','JM','JAM',1,1);
INSERT INTO countries VALUES (107,'Japan','JP','JPN',1,1);
INSERT INTO countries VALUES (108,'Jordan','JO','JOR',1,1);
INSERT INTO countries VALUES (109,'Kazakhstan','KZ','KAZ',1,1);
INSERT INTO countries VALUES (110,'Kenya','KE','KEN',1,1);
INSERT INTO countries VALUES (111,'Kiribati','KI','KIR',1,1);
INSERT INTO countries VALUES (112,'Korea, Democratic People\'s Republic of','KP','PRK',1,1);
INSERT INTO countries VALUES (113,'Korea, Republic of','KR','KOR',1,1);
INSERT INTO countries VALUES (114,'Kuwait','KW','KWT',1,1);
INSERT INTO countries VALUES (115,'Kyrgyzstan','KG','KGZ',1,1);
INSERT INTO countries VALUES (116,'Lao People\'s Democratic Republic','LA','LAO',1,1);
INSERT INTO countries VALUES (117,'Latvia','LV','LVA',1,1);
INSERT INTO countries VALUES (118,'Lebanon','LB','LBN',1,1);
INSERT INTO countries VALUES (119,'Lesotho','LS','LSO',1,1);
INSERT INTO countries VALUES (120,'Liberia','LR','LBR',1,1);
INSERT INTO countries VALUES (121,'Libyan Arab Jamahiriya','LY','LBY',1,1);
INSERT INTO countries VALUES (122,'Liechtenstein','LI','LIE',1,1);
INSERT INTO countries VALUES (123,'Lithuania','LT','LTU',1,1);
INSERT INTO countries VALUES (124,'Luxembourg','LU','LUX',1,1);
INSERT INTO countries VALUES (125,'Macau','MO','MAC',1,1);
INSERT INTO countries VALUES (126,'Macedonia, The Former Yugoslav Republic of','MK','MKD',1,1);
INSERT INTO countries VALUES (127,'Madagascar','MG','MDG',1,1);
INSERT INTO countries VALUES (128,'Malawi','MW','MWI',1,1);
INSERT INTO countries VALUES (129,'Malaysia','MY','MYS',1,1);
INSERT INTO countries VALUES (130,'Maldives','MV','MDV',1,1);
INSERT INTO countries VALUES (131,'Mali','ML','MLI',1,1);
INSERT INTO countries VALUES (132,'Malta','MT','MLT',1,1);
INSERT INTO countries VALUES (133,'Marshall Islands','MH','MHL',1,1);
INSERT INTO countries VALUES (134,'Martinique','MQ','MTQ',1,1);
INSERT INTO countries VALUES (135,'Mauritania','MR','MRT',1,1);
INSERT INTO countries VALUES (136,'Mauritius','MU','MUS',1,1);
INSERT INTO countries VALUES (137,'Mayotte','YT','MYT',1,1);
INSERT INTO countries VALUES (138,'Mexico','MX','MEX',1,1);
INSERT INTO countries VALUES (139,'Micronesia, Federated States of','FM','FSM',1,1);
INSERT INTO countries VALUES (140,'Moldova, Republic of','MD','MDA',1,1);
INSERT INTO countries VALUES (141,'Monaco','MC','MCO',1,1);
INSERT INTO countries VALUES (142,'Mongolia','MN','MNG',1,1);
INSERT INTO countries VALUES (143,'Montserrat','MS','MSR',1,1);
INSERT INTO countries VALUES (144,'Morocco','MA','MAR',1,1);
INSERT INTO countries VALUES (145,'Mozambique','MZ','MOZ',1,1);
INSERT INTO countries VALUES (146,'Myanmar','MM','MMR',1,1);
INSERT INTO countries VALUES (147,'Namibia','NA','NAM',1,1);
INSERT INTO countries VALUES (148,'Nauru','NR','NRU',1,1);
INSERT INTO countries VALUES (149,'Nepal','NP','NPL',1,1);
INSERT INTO countries VALUES (150,'Netherlands','NL','NLD',1,1);
INSERT INTO countries VALUES (151,'Netherlands Antilles','AN','ANT',1,1);
INSERT INTO countries VALUES (152,'New Caledonia','NC','NCL',1,1);
INSERT INTO countries VALUES (153,'New Zealand','NZ','NZL',1,1);
INSERT INTO countries VALUES (154,'Nicaragua','NI','NIC',1,1);
INSERT INTO countries VALUES (155,'Niger','NE','NER',1,1);
INSERT INTO countries VALUES (156,'Nigeria','NG','NGA',1,1);
INSERT INTO countries VALUES (157,'Niue','NU','NIU',1,1);
INSERT INTO countries VALUES (158,'Norfolk Island','NF','NFK',1,1);
INSERT INTO countries VALUES (159,'Northern Mariana Islands','MP','MNP',1,1);
INSERT INTO countries VALUES (160,'Norway','NO','NOR',1,1);
INSERT INTO countries VALUES (161,'Oman','OM','OMN',1,1);
INSERT INTO countries VALUES (162,'Pakistan','PK','PAK',1,1);
INSERT INTO countries VALUES (163,'Palau','PW','PLW',1,1);
INSERT INTO countries VALUES (164,'Panama','PA','PAN',1,1);
INSERT INTO countries VALUES (165,'Papua New Guinea','PG','PNG',1,1);
INSERT INTO countries VALUES (166,'Paraguay','PY','PRY',1,1);
INSERT INTO countries VALUES (167,'Peru','PE','PER',1,1);
INSERT INTO countries VALUES (168,'Philippines','PH','PHL',1,1);
INSERT INTO countries VALUES (169,'Pitcairn','PN','PCN',1,1);
INSERT INTO countries VALUES (170,'Poland','PL','POL',1,1);
INSERT INTO countries VALUES (171,'Portugal','PT','PRT',1,1);
INSERT INTO countries VALUES (172,'Puerto Rico','PR','PRI',1,1);
INSERT INTO countries VALUES (173,'Qatar','QA','QAT',1,1);
INSERT INTO countries VALUES (174,'Reunion','RE','REU',1,1);
INSERT INTO countries VALUES (175,'Romania','RO','ROM',1,1);
INSERT INTO countries VALUES (176,'Russian Federation','RU','RUS',1,1);
INSERT INTO countries VALUES (177,'Rwanda','RW','RWA',1,1);
INSERT INTO countries VALUES (178,'Saint Kitts and Nevis','KN','KNA',1,1);
INSERT INTO countries VALUES (179,'Saint Lucia','LC','LCA',1,1);
INSERT INTO countries VALUES (180,'Saint Vincent and the Grenadines','VC','VCT',1,1);
INSERT INTO countries VALUES (181,'Samoa','WS','WSM',1,1);
INSERT INTO countries VALUES (182,'San Marino','SM','SMR',1,1);
INSERT INTO countries VALUES (183,'Sao Tome and Principe','ST','STP',1,1);
INSERT INTO countries VALUES (184,'Saudi Arabia','SA','SAU',1,1);
INSERT INTO countries VALUES (185,'Senegal','SN','SEN',1,1);
INSERT INTO countries VALUES (186,'Seychelles','SC','SYC',1,1);
INSERT INTO countries VALUES (187,'Sierra Leone','SL','SLE',1,1);
INSERT INTO countries VALUES (188,'Singapore','SG','SGP', '4','1');
INSERT INTO countries VALUES (189,'Slovakia (Slovak Republic)','SK','SVK',1,1);
INSERT INTO countries VALUES (190,'Slovenia','SI','SVN',1,1);
INSERT INTO countries VALUES (191,'Solomon Islands','SB','SLB',1,1);
INSERT INTO countries VALUES (192,'Somalia','SO','SOM',1,1);
INSERT INTO countries VALUES (193,'South Africa','ZA','ZAF',1,1);
INSERT INTO countries VALUES (194,'South Georgia and the South Sandwich Islands','GS','SGS',1,1);
INSERT INTO countries VALUES (195,'Spain','ES','ESP','3','1');
INSERT INTO countries VALUES (196,'Sri Lanka','LK','LKA',1,1);
INSERT INTO countries VALUES (197,'St. Helena','SH','SHN',1,1);
INSERT INTO countries VALUES (198,'St. Pierre and Miquelon','PM','SPM',1,1);
INSERT INTO countries VALUES (199,'Sudan','SD','SDN',1,1);
INSERT INTO countries VALUES (200,'Suriname','SR','SUR',1,1);
INSERT INTO countries VALUES (201,'Svalbard and Jan Mayen Islands','SJ','SJM',1,1);
INSERT INTO countries VALUES (202,'Swaziland','SZ','SWZ',1,1);
INSERT INTO countries VALUES (203,'Sweden','SE','SWE',1,1);
INSERT INTO countries VALUES (204,'Switzerland','CH','CHE',5,1);
INSERT INTO countries VALUES (205,'Syrian Arab Republic','SY','SYR',1,1);
INSERT INTO countries VALUES (206,'Taiwan','TW','TWN',6,1);
INSERT INTO countries VALUES (207,'Tajikistan','TJ','TJK',1,1);
INSERT INTO countries VALUES (208,'Tanzania, United Republic of','TZ','TZA',1,1);
INSERT INTO countries VALUES (209,'Thailand','TH','THA',1,1);
INSERT INTO countries VALUES (210,'Togo','TG','TGO',1,1);
INSERT INTO countries VALUES (211,'Tokelau','TK','TKL',1,1);
INSERT INTO countries VALUES (212,'Tonga','TO','TON',1,1);
INSERT INTO countries VALUES (213,'Trinidad and Tobago','TT','TTO',1,1);
INSERT INTO countries VALUES (214,'Tunisia','TN','TUN',1,1);
INSERT INTO countries VALUES (215,'Turkey','TR','TUR',1,1);
INSERT INTO countries VALUES (216,'Turkmenistan','TM','TKM',1,1);
INSERT INTO countries VALUES (217,'Turks and Caicos Islands','TC','TCA',1,1);
INSERT INTO countries VALUES (218,'Tuvalu','TV','TUV',1,1);
INSERT INTO countries VALUES (219,'Uganda','UG','UGA',1,1);
INSERT INTO countries VALUES (220,'Ukraine','UA','UKR',1,1);
INSERT INTO countries VALUES (221,'United Arab Emirates','AE','ARE',1,1);
INSERT INTO countries VALUES (222,'United Kingdom','GB','GBR',8,1);
INSERT INTO countries VALUES (223,'United States','US','USA', '2','1');
INSERT INTO countries VALUES (224,'United States Minor Outlying Islands','UM','UMI',1,1);
INSERT INTO countries VALUES (225,'Uruguay','UY','URY',1,1);
INSERT INTO countries VALUES (226,'Uzbekistan','UZ','UZB',1,1);
INSERT INTO countries VALUES (227,'Vanuatu','VU','VUT',1,1);
INSERT INTO countries VALUES (228,'Vatican City State (Holy See)','VA','VAT',1,1);
INSERT INTO countries VALUES (229,'Venezuela','VE','VEN',1,1);
INSERT INTO countries VALUES (230,'Viet Nam','VN','VNM',1,1);
INSERT INTO countries VALUES (231,'Virgin Islands (British)','VG','VGB',1,1);
INSERT INTO countries VALUES (232,'Virgin Islands (U.S.)','VI','VIR',1,1);
INSERT INTO countries VALUES (233,'Wallis and Futuna Islands','WF','WLF',1,1);
INSERT INTO countries VALUES (234,'Western Sahara','EH','ESH',1,1);
INSERT INTO countries VALUES (235,'Yemen','YE','YEM',1,1);
INSERT INTO countries VALUES (237,'Zaire','ZR','ZAR',1,1);
INSERT INTO countries VALUES (238,'Zambia','ZM','ZMB',1,1);
INSERT INTO countries VALUES (239,'Zimbabwe','ZW','ZWE',1,1);
INSERT INTO countries VALUES (240,'Serbia','RS','SRB',1,1);
INSERT INTO countries VALUES (241,'Montenegro','ME','MNE',1,1);

# USA
INSERT INTO zones VALUES (1,223,'AL','Alabama');
INSERT INTO zones VALUES (2,223,'AK','Alaska');
INSERT INTO zones VALUES (3,223,'AS','American Samoa');
INSERT INTO zones VALUES (4,223,'AZ','Arizona');
INSERT INTO zones VALUES (5,223,'AR','Arkansas');
INSERT INTO zones VALUES (6,223,'AF','Armed Forces Africa');
INSERT INTO zones VALUES (7,223,'AA','Armed Forces Americas');
INSERT INTO zones VALUES (8,223,'AC','Armed Forces Canada');
INSERT INTO zones VALUES (9,223,'AE','Armed Forces Europe');
INSERT INTO zones VALUES (10,223,'AM','Armed Forces Middle East');
INSERT INTO zones VALUES (11,223,'AP','Armed Forces Pacific');
INSERT INTO zones VALUES (12,223,'CA','California');
INSERT INTO zones VALUES (13,223,'CO','Colorado');
INSERT INTO zones VALUES (14,223,'CT','Connecticut');
INSERT INTO zones VALUES (15,223,'DE','Delaware');
INSERT INTO zones VALUES (16,223,'DC','District of Columbia');
INSERT INTO zones VALUES (17,223,'FM','Federated States Of Micronesia');
INSERT INTO zones VALUES (18,223,'FL','Florida');
INSERT INTO zones VALUES (19,223,'GA','Georgia');
INSERT INTO zones VALUES (20,223,'GU','Guam');
INSERT INTO zones VALUES (21,223,'HI','Hawaii');
INSERT INTO zones VALUES (22,223,'ID','Idaho');
INSERT INTO zones VALUES (23,223,'IL','Illinois');
INSERT INTO zones VALUES (24,223,'IN','Indiana');
INSERT INTO zones VALUES (25,223,'IA','Iowa');
INSERT INTO zones VALUES (26,223,'KS','Kansas');
INSERT INTO zones VALUES (27,223,'KY','Kentucky');
INSERT INTO zones VALUES (28,223,'LA','Louisiana');
INSERT INTO zones VALUES (29,223,'ME','Maine');
INSERT INTO zones VALUES (30,223,'MH','Marshall Islands');
INSERT INTO zones VALUES (31,223,'MD','Maryland');
INSERT INTO zones VALUES (32,223,'MA','Massachusetts');
INSERT INTO zones VALUES (33,223,'MI','Michigan');
INSERT INTO zones VALUES (34,223,'MN','Minnesota');
INSERT INTO zones VALUES (35,223,'MS','Mississippi');
INSERT INTO zones VALUES (36,223,'MO','Missouri');
INSERT INTO zones VALUES (37,223,'MT','Montana');
INSERT INTO zones VALUES (38,223,'NE','Nebraska');
INSERT INTO zones VALUES (39,223,'NV','Nevada');
INSERT INTO zones VALUES (40,223,'NH','New Hampshire');
INSERT INTO zones VALUES (41,223,'NJ','New Jersey');
INSERT INTO zones VALUES (42,223,'NM','New Mexico');
INSERT INTO zones VALUES (43,223,'NY','New York');
INSERT INTO zones VALUES (44,223,'NC','North Carolina');
INSERT INTO zones VALUES (45,223,'ND','North Dakota');
INSERT INTO zones VALUES (46,223,'MP','Northern Mariana Islands');
INSERT INTO zones VALUES (47,223,'OH','Ohio');
INSERT INTO zones VALUES (48,223,'OK','Oklahoma');
INSERT INTO zones VALUES (49,223,'OR','Oregon');
INSERT INTO zones VALUES (50,223,'PW','Palau');
INSERT INTO zones VALUES (51,223,'PA','Pennsylvania');
INSERT INTO zones VALUES (52,223,'PR','Puerto Rico');
INSERT INTO zones VALUES (53,223,'RI','Rhode Island');
INSERT INTO zones VALUES (54,223,'SC','South Carolina');
INSERT INTO zones VALUES (55,223,'SD','South Dakota');
INSERT INTO zones VALUES (56,223,'TN','Tennessee');
INSERT INTO zones VALUES (57,223,'TX','Texas');
INSERT INTO zones VALUES (58,223,'UT','Utah');
INSERT INTO zones VALUES (59,223,'VT','Vermont');
INSERT INTO zones VALUES (60,223,'VI','Virgin Islands');
INSERT INTO zones VALUES (61,223,'VA','Virginia');
INSERT INTO zones VALUES (62,223,'WA','Washington');
INSERT INTO zones VALUES (63,223,'WV','West Virginia');
INSERT INTO zones VALUES (64,223,'WI','Wisconsin');
INSERT INTO zones VALUES (65,223,'WY','Wyoming');

# Canada
INSERT INTO zones VALUES (66,38,'AB','Alberta');
INSERT INTO zones VALUES (67,38,'BC','British Columbia');
INSERT INTO zones VALUES (68,38,'MB','Manitoba');
INSERT INTO zones VALUES (69,38,'NF','Newfoundland');
INSERT INTO zones VALUES (70,38,'NB','New Brunswick');
INSERT INTO zones VALUES (71,38,'NS','Nova Scotia');
INSERT INTO zones VALUES (72,38,'NT','Northwest Territories');
INSERT INTO zones VALUES (73,38,'NU','Nunavut');
INSERT INTO zones VALUES (74,38,'ON','Ontario');
INSERT INTO zones VALUES (75,38,'PE','Prince Edward Island');
INSERT INTO zones VALUES (76,38,'QC','Quebec');
INSERT INTO zones VALUES (77,38,'SK','Saskatchewan');
INSERT INTO zones VALUES (78,38,'YT','Yukon Territory');

# Germany
INSERT INTO zones VALUES (79,81,'NI','Niedersachsen');
INSERT INTO zones VALUES (80,81,'BW','Baden-Württemberg');
INSERT INTO zones VALUES (81,81,'BY','Bayern');
INSERT INTO zones VALUES (82,81,'BE','Berlin');
INSERT INTO zones VALUES (83,81,'BR','Brandenburg');
INSERT INTO zones VALUES (84,81,'HB','Bremen');
INSERT INTO zones VALUES (85,81,'HH','Hamburg');
INSERT INTO zones VALUES (86,81,'HE','Hessen');
INSERT INTO zones VALUES (87,81,'MV','Mecklenburg-Vorpommern');
INSERT INTO zones VALUES (88,81,'NW','Nordrhein-Westfalen');
INSERT INTO zones VALUES (89,81,'RP','Rheinland-Pfalz');
INSERT INTO zones VALUES (90,81,'SL','Saarland');
INSERT INTO zones VALUES (91,81,'SN','Sachsen');
INSERT INTO zones VALUES (92,81,'ST','Sachsen-Anhalt');
INSERT INTO zones VALUES (93,81,'SH','Schleswig-Holstein');
INSERT INTO zones VALUES (94,81,'TH','Thüringen');

# Austria
INSERT INTO zones VALUES (95,14,'WI','Wien');
INSERT INTO zones VALUES (96,14,'NO','Niederösterreich');
INSERT INTO zones VALUES (97,14,'OO','Oberösterreich');
INSERT INTO zones VALUES (98,14,'SB','Salzburg');
INSERT INTO zones VALUES (99,14,'KN','Kärnten');
INSERT INTO zones VALUES (100,14,'ST','Steiermark');
INSERT INTO zones VALUES (101,14,'TI','Tirol');
INSERT INTO zones VALUES (102,14,'BL','Burgenland');
INSERT INTO zones VALUES (103,14,'VB','Voralberg');

# Swizterland
INSERT INTO zones VALUES (104,204,'AG','Aargau');
INSERT INTO zones VALUES (105,204,'AI','Appenzell Innerrhoden');
INSERT INTO zones VALUES (106,204,'AR','Appenzell Ausserrhoden');
INSERT INTO zones VALUES (107,204,'BE','Bern');
INSERT INTO zones VALUES (108,204,'BL','Basel-Landschaft');
INSERT INTO zones VALUES (109,204,'BS','Basel-Stadt');
INSERT INTO zones VALUES (110,204,'FR','Freiburg');
INSERT INTO zones VALUES (111,204,'GE','Genf');
INSERT INTO zones VALUES (112,204,'GL','Glarus');
INSERT INTO zones VALUES (113,204,'JU','Graubünden');
INSERT INTO zones VALUES (114,204,'JU','Jura');
INSERT INTO zones VALUES (115,204,'LU','Luzern');
INSERT INTO zones VALUES (116,204,'NE','Neuenburg');
INSERT INTO zones VALUES (117,204,'NW','Nidwalden');
INSERT INTO zones VALUES (118,204,'OW','Obwalden');
INSERT INTO zones VALUES (119,204,'SG','St. Gallen');
INSERT INTO zones VALUES (120,204,'SH','Schaffhausen');
INSERT INTO zones VALUES (121,204,'SO','Solothurn');
INSERT INTO zones VALUES (122,204,'SZ','Schwyz');
INSERT INTO zones VALUES (123,204,'TG','Thurgau');
INSERT INTO zones VALUES (124,204,'TI','Tessin');
INSERT INTO zones VALUES (125,204,'UR','Uri');
INSERT INTO zones VALUES (126,204,'VD','Waadt');
INSERT INTO zones VALUES (127,204,'VS','Wallis');
INSERT INTO zones VALUES (128,204,'ZG','Zug');
INSERT INTO zones VALUES (129,204,'ZH','Zürich');

# Spain
INSERT INTO zones VALUES (130,195,'A Coruña','A Coruña');
INSERT INTO zones VALUES (131,195,'Alava','Alava');
INSERT INTO zones VALUES (132,195,'Albacete','Albacete');
INSERT INTO zones VALUES (133,195,'Alicante','Alicante');
INSERT INTO zones VALUES (134,195,'Almeria','Almeria');
INSERT INTO zones VALUES (135,195,'Asturias','Asturias');
INSERT INTO zones VALUES (136,195,'Avila','Avila');
INSERT INTO zones VALUES (137,195,'Badajoz','Badajoz');
INSERT INTO zones VALUES (138,195,'Baleares','Baleares');
INSERT INTO zones VALUES (139,195,'Barcelona','Barcelona');
INSERT INTO zones VALUES (140,195,'Burgos','Burgos');
INSERT INTO zones VALUES (141,195,'Caceres','Caceres');
INSERT INTO zones VALUES (142,195,'Cadiz','Cadiz');
INSERT INTO zones VALUES (143,195,'Cantabria','Cantabria');
INSERT INTO zones VALUES (144,195,'Castellon','Castellon');
INSERT INTO zones VALUES (145,195,'Ceuta','Ceuta');
INSERT INTO zones VALUES (146,195,'Ciudad Real','Ciudad Real');
INSERT INTO zones VALUES (147,195,'Cordoba','Cordoba');
INSERT INTO zones VALUES (148,195,'Cuenca','Cuenca');
INSERT INTO zones VALUES (149,195,'Girona','Girona');
INSERT INTO zones VALUES (150,195,'Granada','Granada');
INSERT INTO zones VALUES (151,195,'Guadalajara','Guadalajara');
INSERT INTO zones VALUES (152,195,'Guipuzcoa','Guipuzcoa');
INSERT INTO zones VALUES (153,195,'Huelva','Huelva');
INSERT INTO zones VALUES (154,195,'Huesca','Huesca');
INSERT INTO zones VALUES (155,195,'Jaen','Jaen');
INSERT INTO zones VALUES (156,195,'La Rioja','La Rioja');
INSERT INTO zones VALUES (157,195,'Las Palmas','Las Palmas');
INSERT INTO zones VALUES (158,195,'Leon','Leon');
INSERT INTO zones VALUES (159,195,'Lleida','Lleida');
INSERT INTO zones VALUES (160,195,'Lugo','Lugo');
INSERT INTO zones VALUES (161,195,'Madrid','Madrid');
INSERT INTO zones VALUES (162,195,'Malaga','Malaga');
INSERT INTO zones VALUES (163,195,'Melilla','Melilla');
INSERT INTO zones VALUES (164,195,'Murcia','Murcia');
INSERT INTO zones VALUES (165,195,'Navarra','Navarra');
INSERT INTO zones VALUES (166,195,'Ourense','Ourense');
INSERT INTO zones VALUES (167,195,'Palencia','Palencia');
INSERT INTO zones VALUES (168,195,'Pontevedra','Pontevedra');
INSERT INTO zones VALUES (169,195,'Salamanca','Salamanca');
INSERT INTO zones VALUES (170,195,'Santa Cruz de Tenerife','Santa Cruz de Tenerife');
INSERT INTO zones VALUES (171,195,'Segovia','Segovia');
INSERT INTO zones VALUES (172,195,'Sevilla','Sevilla');
INSERT INTO zones VALUES (173,195,'Soria','Soria');
INSERT INTO zones VALUES (174,195,'Tarragona','Tarragona');
INSERT INTO zones VALUES (175,195,'Teruel','Teruel');
INSERT INTO zones VALUES (176,195,'Toledo','Toledo');
INSERT INTO zones VALUES (177,195,'Valencia','Valencia');
INSERT INTO zones VALUES (178,195,'Valladolid','Valladolid');
INSERT INTO zones VALUES (179,195,'Vizcaya','Vizcaya');
INSERT INTO zones VALUES (180,195,'Zamora','Zamora');
INSERT INTO zones VALUES (181,195,'Zaragoza','Zaragoza');

#Australia
INSERT INTO zones VALUES (182,13,'NSW','New South Wales');
INSERT INTO zones VALUES (183,13,'VIC','Victoria');
INSERT INTO zones VALUES (184,13,'QLD','Queensland');
INSERT INTO zones VALUES (185,13,'NT','Northern Territory');
INSERT INTO zones VALUES (186,13,'WA','Western Australia');
INSERT INTO zones VALUES (187,13,'SA','South Australia');
INSERT INTO zones VALUES (188,13,'TAS','Tasmania');
INSERT INTO zones VALUES (189,13,'ACT','Australian Capital Territory');

#New Zealand
INSERT INTO zones VALUES (190,153,'Northland','Northland');
INSERT INTO zones VALUES (191,153,'Auckland','Auckland');
INSERT INTO zones VALUES (192,153,'Waikato','Waikato');
INSERT INTO zones VALUES (193,153,'Bay of Plenty','Bay of Plenty');
INSERT INTO zones VALUES (194,153,'Gisborne','Gisborne');
INSERT INTO zones VALUES (195,153,'Hawkes Bay','Hawkes Bay');
INSERT INTO zones VALUES (196,153,'Taranaki','Taranaki');
INSERT INTO zones VALUES (197,153,'Manawatu-Wanganui','Manawatu-Wanganui');
INSERT INTO zones VALUES (198,153,'Wellington','Wellington');
INSERT INTO zones VALUES (199,153,'West Coast','West Coast');
INSERT INTO zones VALUES (200,153,'Canterbury','Canterbury');
INSERT INTO zones VALUES (201,153,'Otago','Otago');
INSERT INTO zones VALUES (202,153,'Southland','Southland');
INSERT INTO zones VALUES (203,153,'Tasman','Tasman');
INSERT INTO zones VALUES (204,153,'Nelson','Nelson');
INSERT INTO zones VALUES (205,153,'Marlborough','Marlborough');

#Brazil
INSERT INTO zones VALUES ('',30,'SP','São Paulo');
INSERT INTO zones VALUES ('',30,'RJ','Rio de Janeiro');
INSERT INTO zones VALUES ('',30,'PE','Pernanbuco');
INSERT INTO zones VALUES ('',30,'BA','Bahia');
INSERT INTO zones VALUES ('',30,'AM','Amazonas');
INSERT INTO zones VALUES ('',30,'MG','Minas Gerais');
INSERT INTO zones VALUES ('',30,'ES','Espirito Santo');
INSERT INTO zones VALUES ('',30,'RS','Rio Grande do Sul');
INSERT INTO zones VALUES ('',30,'PR','Paraná');
INSERT INTO zones VALUES ('',30,'SC','Santa Catarina');
INSERT INTO zones VALUES ('',30,'RG','Rio Grande do Norte');
INSERT INTO zones VALUES ('',30,'MS','Mato Grosso do Sul');
INSERT INTO zones VALUES ('',30,'MT','Mato Grosso');
INSERT INTO zones VALUES ('',30,'GO','Goias');
INSERT INTO zones VALUES ('',30,'TO','Tocantins');
INSERT INTO zones VALUES ('',30,'DF','Distrito Federal');
INSERT INTO zones VALUES ('',30,'RO','Rondonia');
INSERT INTO zones VALUES ('',30,'AC','Acre');
INSERT INTO zones VALUES ('',30,'AP','Amapa');
INSERT INTO zones VALUES ('',30,'RO','Roraima');
INSERT INTO zones VALUES ('',30,'AL','Alagoas');
INSERT INTO zones VALUES ('',30,'CE','Ceará');
INSERT INTO zones VALUES ('',30,'MA','Maranhão');
INSERT INTO zones VALUES ('',30,'PA','Pará');
INSERT INTO zones VALUES ('',30,'PB','Paraíba');
INSERT INTO zones VALUES ('',30,'PI','Piauí');
INSERT INTO zones VALUES ('',30,'SE','Sergipe');

#Chile
INSERT INTO zones VALUES ('',43,'I','I Región de Tarapacá');
INSERT INTO zones VALUES ('',43,'II','II Región de Antofagasta');
INSERT INTO zones VALUES ('',43,'III','III Región de Atacama');
INSERT INTO zones VALUES ('',43,'IV','IV Región de Coquimbo');
INSERT INTO zones VALUES ('',43,'V','V Región de Valaparaíso');
INSERT INTO zones VALUES ('',43,'RM','Región Metropolitana');
INSERT INTO zones VALUES ('',43,'VI','VI Región de L. B. O´higgins');
INSERT INTO zones VALUES ('',43,'VII','VII Región del Maule');
INSERT INTO zones VALUES ('',43,'VIII','VIII Región del Bío Bío');
INSERT INTO zones VALUES ('',43,'IX','IX Región de la Araucanía');
INSERT INTO zones VALUES ('',43,'X','X Región de los Lagos');
INSERT INTO zones VALUES ('',43,'XI','XI Región de Aysén');
INSERT INTO zones VALUES ('',43,'XII','XII Región de Magallanes');

#Columbia
INSERT INTO zones VALUES ('',47,'AMA','Amazonas');
INSERT INTO zones VALUES ('',47,'ANT','Antioquia');
INSERT INTO zones VALUES ('',47,'ARA','Arauca');
INSERT INTO zones VALUES ('',47,'ATL','Atlantico');
INSERT INTO zones VALUES ('',47,'BOL','Bolivar');
INSERT INTO zones VALUES ('',47,'BOY','Boyaca');
INSERT INTO zones VALUES ('',47,'CAL','Caldas');
INSERT INTO zones VALUES ('',47,'CAQ','Caqueta');
INSERT INTO zones VALUES ('',47,'CAS','Casanare');
INSERT INTO zones VALUES ('',47,'CAU','Cauca');
INSERT INTO zones VALUES ('',47,'CES','Cesar');
INSERT INTO zones VALUES ('',47,'CHO','Choco');
INSERT INTO zones VALUES ('',47,'COR','Cordoba');
INSERT INTO zones VALUES ('',47,'CUN','Cundinamarca');
INSERT INTO zones VALUES ('',47,'HUI','Huila');
INSERT INTO zones VALUES ('',47,'GUA','Guainia');
INSERT INTO zones VALUES ('',47,'GUA','Guajira');
INSERT INTO zones VALUES ('',47,'GUV','Guaviare');
INSERT INTO zones VALUES ('',47,'MAG','Magdalena');
INSERT INTO zones VALUES ('',47,'MET','Meta');
INSERT INTO zones VALUES ('',47,'NAR','Narino');
INSERT INTO zones VALUES ('',47,'NDS','Norte de Santander');
INSERT INTO zones VALUES ('',47,'PUT','Putumayo');
INSERT INTO zones VALUES ('',47,'QUI','Quindio');
INSERT INTO zones VALUES ('',47,'RIS','Risaralda');
INSERT INTO zones VALUES ('',47,'SAI','San Andres Islas');
INSERT INTO zones VALUES ('',47,'SAN','Santander');
INSERT INTO zones VALUES ('',47,'SUC','Sucre');
INSERT INTO zones VALUES ('',47,'TOL','Tolima');
INSERT INTO zones VALUES ('',47,'VAL','Valle');
INSERT INTO zones VALUES ('',47,'VAU','Vaupes');
INSERT INTO zones VALUES ('',47,'VIC','Vichada');

#France
INSERT INTO zones VALUES ('',73,'Et','Etranger');
INSERT INTO zones VALUES ('',73,'01','Ain');
INSERT INTO zones VALUES ('',73,'02','Aisne');
INSERT INTO zones VALUES ('',73,'03','Allier');
INSERT INTO zones VALUES ('',73,'04','Alpes de Haute Provence');
INSERT INTO zones VALUES ('',73,'05','Hautes-Alpes');
INSERT INTO zones VALUES ('',73,'06','Alpes Maritimes');
INSERT INTO zones VALUES ('',73,'07','Ardèche');
INSERT INTO zones VALUES ('',73,'08','Ardennes');
INSERT INTO zones VALUES ('',73,'09','Ariège');
INSERT INTO zones VALUES ('',73,'10','Aube');
INSERT INTO zones VALUES ('',73,'11','Aude');
INSERT INTO zones VALUES ('',73,'12','Aveyron');
INSERT INTO zones VALUES ('',73,'13','Bouches-du-Rhône');
INSERT INTO zones VALUES ('',73,'14','Calvados');
INSERT INTO zones VALUES ('',73,'15','Cantal');
INSERT INTO zones VALUES ('',73,'16','Charente');
INSERT INTO zones VALUES ('',73,'17','Charente Maritime');
INSERT INTO zones VALUES ('',73,'18','Cher');
INSERT INTO zones VALUES ('',73,'19','Corrèze');
INSERT INTO zones VALUES ('',73,'2A','Corse du Sud');
INSERT INTO zones VALUES ('',73,'2B','Haute Corse');
INSERT INTO zones VALUES ('',73,'21','Côte-d\'Or');
INSERT INTO zones VALUES ('',73,'22','Côtes-d\'Armor');
INSERT INTO zones VALUES ('',73,'23','Creuse');
INSERT INTO zones VALUES ('',73,'24','Dordogne');
INSERT INTO zones VALUES ('',73,'25','Doubs');
INSERT INTO zones VALUES ('',73,'26','Drôme');
INSERT INTO zones VALUES ('',73,'27','Eure');
INSERT INTO zones VALUES ('',73,'28','Eure et Loir');
INSERT INTO zones VALUES ('',73,'29','Finistère');
INSERT INTO zones VALUES ('',73,'30','Gard');
INSERT INTO zones VALUES ('',73,'31','Haute Garonne');
INSERT INTO zones VALUES ('',73,'32','Gers');
INSERT INTO zones VALUES ('',73,'33','Gironde');
INSERT INTO zones VALUES ('',73,'34','Hérault');
INSERT INTO zones VALUES ('',73,'35','Ille et Vilaine');
INSERT INTO zones VALUES ('',73,'36','Indre');
INSERT INTO zones VALUES ('',73,'37','Indre et Loire');
INSERT INTO zones VALUES ('',73,'38','Isère');
INSERT INTO zones VALUES ('',73,'39','Jura');
INSERT INTO zones VALUES ('',73,'40','Landes');
INSERT INTO zones VALUES ('',73,'41','Loir et Cher');
INSERT INTO zones VALUES ('',73,'42','Loire');
INSERT INTO zones VALUES ('',73,'43','Haute Loire');
INSERT INTO zones VALUES ('',73,'44','Loire Atlantique');
INSERT INTO zones VALUES ('',73,'45','Loiret');
INSERT INTO zones VALUES ('',73,'46','Lot');
INSERT INTO zones VALUES ('',73,'47','Lot et Garonne');
INSERT INTO zones VALUES ('',73,'48','Lozère');
INSERT INTO zones VALUES ('',73,'49','Maine et Loire');
INSERT INTO zones VALUES ('',73,'50','Manche');
INSERT INTO zones VALUES ('',73,'51','Marne');
INSERT INTO zones VALUES ('',73,'52','Haute Marne');
INSERT INTO zones VALUES ('',73,'53','Mayenne');
INSERT INTO zones VALUES ('',73,'54','Meurthe et Moselle');
INSERT INTO zones VALUES ('',73,'55','Meuse');
INSERT INTO zones VALUES ('',73,'56','Morbihan');
INSERT INTO zones VALUES ('',73,'57','Moselle');
INSERT INTO zones VALUES ('',73,'58','Nièvre');
INSERT INTO zones VALUES ('',73,'59','Nord');
INSERT INTO zones VALUES ('',73,'60','Oise');
INSERT INTO zones VALUES ('',73,'61','Orne');
INSERT INTO zones VALUES ('',73,'62','Pas de Calais');
INSERT INTO zones VALUES ('',73,'63','Puy-de-Dôme');
INSERT INTO zones VALUES ('',73,'64','Pyrénées-Atlantiques');
INSERT INTO zones VALUES ('',73,'65','Hautes-Pyrénées');
INSERT INTO zones VALUES ('',73,'66','Pyrénées-Orientales');
INSERT INTO zones VALUES ('',73,'67','Bas Rhin');
INSERT INTO zones VALUES ('',73,'68','Haut Rhin');
INSERT INTO zones VALUES ('',73,'69','Rhône');
INSERT INTO zones VALUES ('',73,'70','Haute-Saône');
INSERT INTO zones VALUES ('',73,'71','Saône-et-Loire');
INSERT INTO zones VALUES ('',73,'72','Sarthe');
INSERT INTO zones VALUES ('',73,'73','Savoie');
INSERT INTO zones VALUES ('',73,'74','Haute Savoie');
INSERT INTO zones VALUES ('',73,'75','Paris');
INSERT INTO zones VALUES ('',73,'76','Seine Maritime');
INSERT INTO zones VALUES ('',73,'77','Seine et Marne');
INSERT INTO zones VALUES ('',73,'78','Yvelines');
INSERT INTO zones VALUES ('',73,'79','Deux-Sèvres');
INSERT INTO zones VALUES ('',73,'80','Somme');
INSERT INTO zones VALUES ('',73,'81','Tarn');
INSERT INTO zones VALUES ('',73,'82','Tarn et Garonne');
INSERT INTO zones VALUES ('',73,'83','Var');
INSERT INTO zones VALUES ('',73,'84','Vaucluse');
INSERT INTO zones VALUES ('',73,'85','Vendée');
INSERT INTO zones VALUES ('',73,'86','Vienne');
INSERT INTO zones VALUES ('',73,'87','Haute Vienne');
INSERT INTO zones VALUES ('',73,'88','Vosges');
INSERT INTO zones VALUES ('',73,'89','Yonne');
INSERT INTO zones VALUES ('',73,'90','Territoire de Belfort');
INSERT INTO zones VALUES ('',73,'91','Essonne');
INSERT INTO zones VALUES ('',73,'92','Hauts de Seine');
INSERT INTO zones VALUES ('',73,'93','Seine St-Denis');
INSERT INTO zones VALUES ('',73,'94','Val de Marne');
INSERT INTO zones VALUES ('',73,'95','Val d\'Oise');
INSERT INTO zones VALUES ('',73,'971 (DOM)','Guadeloupe');
INSERT INTO zones VALUES ('',73,'972 (DOM)','Martinique');
INSERT INTO zones VALUES ('',73,'973 (DOM)','Guyane');
INSERT INTO zones VALUES ('',73,'974 (DOM)','Saint Denis');
INSERT INTO zones VALUES ('',73,'975 (DOM)','St-Pierre de Miquelon');
INSERT INTO zones VALUES ('',73,'976 (TOM)','Mayotte');
INSERT INTO zones VALUES ('',73,'984 (TOM)','Terres australes et Antartiques françaises');
INSERT INTO zones VALUES ('',73,'985 (TOM)','Nouvelle Calédonie');
INSERT INTO zones VALUES ('',73,'986 (TOM)','Wallis et Futuna');
INSERT INTO zones VALUES ('',73,'987 (TOM)','Polynésie française');

#India
INSERT INTO zones VALUES ('',99,'DL','Delhi');
INSERT INTO zones VALUES ('',99,'MH','Maharashtra');
INSERT INTO zones VALUES ('',99,'TN','Tamil Nadu');
INSERT INTO zones VALUES ('',99,'KL','Kerala');
INSERT INTO zones VALUES ('',99,'AP','Andhra Pradesh');
INSERT INTO zones VALUES ('',99,'KA','Karnataka');
INSERT INTO zones VALUES ('',99,'GA','Goa');
INSERT INTO zones VALUES ('',99,'MP','Madhya Pradesh');
INSERT INTO zones VALUES ('',99,'PY','Pondicherry');
INSERT INTO zones VALUES ('',99,'GJ','Gujarat');
INSERT INTO zones VALUES ('',99,'OR','Orrisa');
INSERT INTO zones VALUES ('',99,'CA','Chhatisgarh');
INSERT INTO zones VALUES ('',99,'JH','Jharkhand');
INSERT INTO zones VALUES ('',99,'BR','Bihar');
INSERT INTO zones VALUES ('',99,'WB','West Bengal');
INSERT INTO zones VALUES ('',99,'UP','Uttar Pradesh');
INSERT INTO zones VALUES ('',99,'RJ','Rajasthan');
INSERT INTO zones VALUES ('',99,'PB','Punjab');
INSERT INTO zones VALUES ('',99,'HR','Haryana');
INSERT INTO zones VALUES ('',99,'CH','Chandigarh');
INSERT INTO zones VALUES ('',99,'JK','Jammu & Kashmir');
INSERT INTO zones VALUES ('',99,'HP','Himachal Pradesh');
INSERT INTO zones VALUES ('',99,'UA','Uttaranchal');
INSERT INTO zones VALUES ('',99,'LK','Lakshadweep');
INSERT INTO zones VALUES ('',99,'AN','Andaman & Nicobar');
INSERT INTO zones VALUES ('',99,'MG','Meghalaya');
INSERT INTO zones VALUES ('',99,'AS','Assam');
INSERT INTO zones VALUES ('',99,'DR','Dadra & Nagar Haveli');
INSERT INTO zones VALUES ('',99,'DN','Daman & Diu');
INSERT INTO zones VALUES ('',99,'SK','Sikkim');
INSERT INTO zones VALUES ('',99,'TR','Tripura');
INSERT INTO zones VALUES ('',99,'MZ','Mizoram');
INSERT INTO zones VALUES ('',99,'MN','Manipur');
INSERT INTO zones VALUES ('',99,'NL','Nagaland');
INSERT INTO zones VALUES ('',99,'AR','Arunachal Pradesh');

#Italy
INSERT INTO zones VALUES ('',105,'AG','Agrigento');
INSERT INTO zones VALUES ('',105,'AL','Alessandria');
INSERT INTO zones VALUES ('',105,'AN','Ancona');
INSERT INTO zones VALUES ('',105,'AO','Aosta');
INSERT INTO zones VALUES ('',105,'AR','Arezzo');
INSERT INTO zones VALUES ('',105,'AP','Ascoli Piceno');
INSERT INTO zones VALUES ('',105,'AT','Asti');
INSERT INTO zones VALUES ('',105,'AV','Avellino');
INSERT INTO zones VALUES ('',105,'BA','Bari');
INSERT INTO zones VALUES ('',105,'BT','Barletta-Andria-Trani');
INSERT INTO zones VALUES ('',105,'BL','Belluno');
INSERT INTO zones VALUES ('',105,'BN','Benevento');
INSERT INTO zones VALUES ('',105,'BG','Bergamo');
INSERT INTO zones VALUES ('',105,'BI','Biella');
INSERT INTO zones VALUES ('',105,'BO','Bologna');
INSERT INTO zones VALUES ('',105,'BZ','Bolzano');
INSERT INTO zones VALUES ('',105,'BS','Brescia');
INSERT INTO zones VALUES ('',105,'BR','Brindisi');
INSERT INTO zones VALUES ('',105,'CA','Cagliari');
INSERT INTO zones VALUES ('',105,'CL','Caltanissetta');
INSERT INTO zones VALUES ('',105,'CB','Campobasso');
INSERT INTO zones VALUES ('',105,'CI','Carbonia-Iglesias');
INSERT INTO zones VALUES ('',105,'CE','Caserta');
INSERT INTO zones VALUES ('',105,'CT','Catania');
INSERT INTO zones VALUES ('',105,'CZ','Catanzaro');
INSERT INTO zones VALUES ('',105,'CH','Chieti');
INSERT INTO zones VALUES ('',105,'CO','Como');
INSERT INTO zones VALUES ('',105,'CS','Cosenza');
INSERT INTO zones VALUES ('',105,'CR','Cremona');
INSERT INTO zones VALUES ('',105,'KR','Crotone');
INSERT INTO zones VALUES ('',105,'CN','Cuneo');
INSERT INTO zones VALUES ('',105,'EN','Enna');
INSERT INTO zones VALUES ('',105,'FM','Fermo');
INSERT INTO zones VALUES ('',105,'FE','Ferrara');
INSERT INTO zones VALUES ('',105,'FI','Firenze');
INSERT INTO zones VALUES ('',105,'FG','Foggia');
INSERT INTO zones VALUES ('',105,'FC','Forlì-Cesena');
INSERT INTO zones VALUES ('',105,'FR','Frosinone');
INSERT INTO zones VALUES ('',105,'GE','Genova');
INSERT INTO zones VALUES ('',105,'GO','Gorizia');
INSERT INTO zones VALUES ('',105,'GR','Grosseto');
INSERT INTO zones VALUES ('',105,'IM','Imperia');
INSERT INTO zones VALUES ('',105,'IS','Isernia');
INSERT INTO zones VALUES ('',105,'SP','La Spezia');
INSERT INTO zones VALUES ('',105,'AQ','Aquila');
INSERT INTO zones VALUES ('',105,'LT','Latina');
INSERT INTO zones VALUES ('',105,'LE','Lecce');
INSERT INTO zones VALUES ('',105,'LC','Lecco');
INSERT INTO zones VALUES ('',105,'LI','Livorno');
INSERT INTO zones VALUES ('',105,'LO','Lodi');
INSERT INTO zones VALUES ('',105,'LU','Lucca');
INSERT INTO zones VALUES ('',105,'MC','Macerata');
INSERT INTO zones VALUES ('',105,'MN','Mantova');
INSERT INTO zones VALUES ('',105,'MS','Massa-Carrara');
INSERT INTO zones VALUES ('',105,'MT','Matera');
INSERT INTO zones VALUES ('',105,'ME','Messina');
INSERT INTO zones VALUES ('',105,'MI','Milano');
INSERT INTO zones VALUES ('',105,'MO','Modena');
INSERT INTO zones VALUES ('',105,'MB','Monza e della Brianza');
INSERT INTO zones VALUES ('',105,'NA','Napoli');
INSERT INTO zones VALUES ('',105,'NO','Novara');
INSERT INTO zones VALUES ('',105,'NU','Nuoro');
INSERT INTO zones VALUES ('',105,'OT','Olbia-Tempio');
INSERT INTO zones VALUES ('',105,'OR','Oristano');
INSERT INTO zones VALUES ('',105,'PD','Padova');
INSERT INTO zones VALUES ('',105,'PA','Palermo');
INSERT INTO zones VALUES ('',105,'PR','Parma');
INSERT INTO zones VALUES ('',105,'PV','Pavia');
INSERT INTO zones VALUES ('',105,'PG','Perugia');
INSERT INTO zones VALUES ('',105,'PU','Pesaro e Urbino');
INSERT INTO zones VALUES ('',105,'PE','Pescara');
INSERT INTO zones VALUES ('',105,'PC','Piacenza');
INSERT INTO zones VALUES ('',105,'PI','Pisa');
INSERT INTO zones VALUES ('',105,'PT','Pistoia');
INSERT INTO zones VALUES ('',105,'PN','Pordenone');
INSERT INTO zones VALUES ('',105,'PZ','Potenza');
INSERT INTO zones VALUES ('',105,'PO','Prato');
INSERT INTO zones VALUES ('',105,'RG','Ragusa');
INSERT INTO zones VALUES ('',105,'RA','Ravenna');
INSERT INTO zones VALUES ('',105,'RC','Reggio di Calabria');
INSERT INTO zones VALUES ('',105,'RE','Reggio Emilia');
INSERT INTO zones VALUES ('',105,'RI','Rieti');
INSERT INTO zones VALUES ('',105,'RN','Rimini');
INSERT INTO zones VALUES ('',105,'RM','Roma');
INSERT INTO zones VALUES ('',105,'RO','Rovigo');
INSERT INTO zones VALUES ('',105,'SA','Salerno');
INSERT INTO zones VALUES ('',105,'VS','Medio Campidano');
INSERT INTO zones VALUES ('',105,'SS','Sassari');
INSERT INTO zones VALUES ('',105,'SV','Savona');
INSERT INTO zones VALUES ('',105,'SI','Siena');
INSERT INTO zones VALUES ('',105,'SR','Siracusa');
INSERT INTO zones VALUES ('',105,'SO','Sondrio');
INSERT INTO zones VALUES ('',105,'TA','Taranto');
INSERT INTO zones VALUES ('',105,'TE','Teramo');
INSERT INTO zones VALUES ('',105,'TR','Terni');
INSERT INTO zones VALUES ('',105,'TO','Torino');
INSERT INTO zones VALUES ('',105,'OG','Ogliastra');
INSERT INTO zones VALUES ('',105,'TP','Trapani');
INSERT INTO zones VALUES ('',105,'TN','Trento');
INSERT INTO zones VALUES ('',105,'TV','Treviso');
INSERT INTO zones VALUES ('',105,'TS','Trieste');
INSERT INTO zones VALUES ('',105,'UD','Udine');
INSERT INTO zones VALUES ('',105,'VA','Varese');
INSERT INTO zones VALUES ('',105,'VE','Venezia');
INSERT INTO zones VALUES ('',105,'VB','Verbania');
INSERT INTO zones VALUES ('',105,'VC','Vercelli');
INSERT INTO zones VALUES ('',105,'VR','Verona');
INSERT INTO zones VALUES ('',105,'VV','Vibo Valentia');
INSERT INTO zones VALUES ('',105,'VI','Vicenza');
INSERT INTO zones VALUES ('',105,'VT','Viterbo');

#Japan
INSERT INTO zones VALUES ('',107,'Niigata', 'Niigata');
INSERT INTO zones VALUES ('',107,'Toyama', 'Toyama');
INSERT INTO zones VALUES ('',107,'Ishikawa', 'Ishikawa');
INSERT INTO zones VALUES ('',107,'Fukui', 'Fukui');
INSERT INTO zones VALUES ('',107,'Yamanashi', 'Yamanashi');
INSERT INTO zones VALUES ('',107,'Nagano', 'Nagano');
INSERT INTO zones VALUES ('',107,'Gifu', 'Gifu');
INSERT INTO zones VALUES ('',107,'Shizuoka', 'Shizuoka');
INSERT INTO zones VALUES ('',107,'Aichi', 'Aichi');
INSERT INTO zones VALUES ('',107,'Mie', 'Mie');
INSERT INTO zones VALUES ('',107,'Shiga', 'Shiga');
INSERT INTO zones VALUES ('',107,'Kyoto', 'Kyoto');
INSERT INTO zones VALUES ('',107,'Osaka', 'Osaka');
INSERT INTO zones VALUES ('',107,'Hyogo', 'Hyogo');
INSERT INTO zones VALUES ('',107,'Nara', 'Nara');
INSERT INTO zones VALUES ('',107,'Wakayama', 'Wakayama');
INSERT INTO zones VALUES ('',107,'Tottori', 'Tottori');
INSERT INTO zones VALUES ('',107,'Shimane', 'Shimane');
INSERT INTO zones VALUES ('',107,'Okayama', 'Okayama');
INSERT INTO zones VALUES ('',107,'Hiroshima', 'Hiroshima');
INSERT INTO zones VALUES ('',107,'Yamaguchi', 'Yamaguchi');
INSERT INTO zones VALUES ('',107,'Tokushima', 'Tokushima');
INSERT INTO zones VALUES ('',107,'Kagawa', 'Kagawa');
INSERT INTO zones VALUES ('',107,'Ehime', 'Ehime');
INSERT INTO zones VALUES ('',107,'Kochi', 'Kochi');
INSERT INTO zones VALUES ('',107,'Fukuoka', 'Fukuoka');
INSERT INTO zones VALUES ('',107,'Saga', 'Saga');
INSERT INTO zones VALUES ('',107,'Nagasaki', 'Nagasaki');
INSERT INTO zones VALUES ('',107,'Kumamoto', 'Kumamoto');
INSERT INTO zones VALUES ('',107,'Oita', 'Oita');
INSERT INTO zones VALUES ('',107,'Miyazaki', 'Miyazaki');
INSERT INTO zones VALUES ('',107,'Kagoshima', 'Kagoshima');

#Malaysia
INSERT INTO zones VALUES ('',129,'JOH','Johor');
INSERT INTO zones VALUES ('',129,'KDH','Kedah');
INSERT INTO zones VALUES ('',129,'KEL','Kelantan');
INSERT INTO zones VALUES ('',129,'KL','Kuala Lumpur');
INSERT INTO zones VALUES ('',129,'MEL','Melaka');
INSERT INTO zones VALUES ('',129,'NS','Negeri Sembilan');
INSERT INTO zones VALUES ('',129,'PAH','Pahang');
INSERT INTO zones VALUES ('',129,'PRK','Perak');
INSERT INTO zones VALUES ('',129,'PER','Perlis');
INSERT INTO zones VALUES ('',129,'PP','Pulau Pinang');
INSERT INTO zones VALUES ('',129,'SAB','Sabah');
INSERT INTO zones VALUES ('',129,'SWK','Sarawak');
INSERT INTO zones VALUES ('',129,'SEL','Selangor');
INSERT INTO zones VALUES ('',129,'TER','Terengganu');
INSERT INTO zones VALUES ('',129,'LAB','W.P.Labuan');

#Mexico
INSERT INTO zones VALUES ('',138,'AGS','Aguascalientes');
INSERT INTO zones VALUES ('',138,'BC','Baja California');
INSERT INTO zones VALUES ('',138,'BCS','Baja California Sur');
INSERT INTO zones VALUES ('',138,'CAM','Campeche');
INSERT INTO zones VALUES ('',138,'COA','Coahuila');
INSERT INTO zones VALUES ('',138,'COL','Colima');
INSERT INTO zones VALUES ('',138,'CHI','Chiapas');
INSERT INTO zones VALUES ('',138,'CHIH','Chihuahua');
INSERT INTO zones VALUES ('',138,'DF','Distrito Federal');
INSERT INTO zones VALUES ('',138,'DGO','Durango');
INSERT INTO zones VALUES ('',138,'MEX','Estado de Mexico');
INSERT INTO zones VALUES ('',138,'GTO','Guanajuato');
INSERT INTO zones VALUES ('',138,'GRO','Guerrero');
INSERT INTO zones VALUES ('',138,'HGO','Hidalgo');
INSERT INTO zones VALUES ('',138,'JAL','Jalisco');
INSERT INTO zones VALUES ('',138,'MCH','Michoacan');
INSERT INTO zones VALUES ('',138,'MOR','Morelos');
INSERT INTO zones VALUES ('',138,'NAY','Nayarit');
INSERT INTO zones VALUES ('',138,'NL','Nuevo Leon');
INSERT INTO zones VALUES ('',138,'OAX','Oaxaca');
INSERT INTO zones VALUES ('',138,'PUE','Puebla');
INSERT INTO zones VALUES ('',138,'QRO','Queretaro');
INSERT INTO zones VALUES ('',138,'QR','Quintana Roo');
INSERT INTO zones VALUES ('',138,'SLP','San Luis Potosi');
INSERT INTO zones VALUES ('',138,'SIN','Sinaloa');
INSERT INTO zones VALUES ('',138,'SON','Sonora');
INSERT INTO zones VALUES ('',138,'TAB','Tabasco');
INSERT INTO zones VALUES ('',138,'TMPS','Tamaulipas');
INSERT INTO zones VALUES ('',138,'TLAX','Tlaxcala');
INSERT INTO zones VALUES ('',138,'VER','Veracruz');
INSERT INTO zones VALUES ('',138,'YUC','Yucatan');
INSERT INTO zones VALUES ('',138,'ZAC','Zacatecas');

#Norway
INSERT INTO zones VALUES ('',160,'OSL','Oslo');
INSERT INTO zones VALUES ('',160,'AKE','Akershus');
INSERT INTO zones VALUES ('',160,'AUA','Aust-Agder');
INSERT INTO zones VALUES ('',160,'BUS','Buskerud');
INSERT INTO zones VALUES ('',160,'FIN','Finnmark');
INSERT INTO zones VALUES ('',160,'HED','Hedmark');
INSERT INTO zones VALUES ('',160,'HOR','Hordaland');
INSERT INTO zones VALUES ('',160,'MOR','Møre og Romsdal');
INSERT INTO zones VALUES ('',160,'NOR','Nordland');
INSERT INTO zones VALUES ('',160,'NTR','Nord-Trøndelag');
INSERT INTO zones VALUES ('',160,'OPP','Oppland');
INSERT INTO zones VALUES ('',160,'ROG','Rogaland');
INSERT INTO zones VALUES ('',160,'SOF','Sogn og Fjordane');
INSERT INTO zones VALUES ('',160,'STR','Sør-Trøndelag');
INSERT INTO zones VALUES ('',160,'TEL','Telemark');
INSERT INTO zones VALUES ('',160,'TRO','Troms');
INSERT INTO zones VALUES ('',160,'VEA','Vest-Agder');
INSERT INTO zones VALUES ('',160,'OST','Østfold');
INSERT INTO zones VALUES ('',160,'SVA','Svalbard');

#Pakistan
INSERT INTO zones VALUES ('',162,'KHI','Karachi');
INSERT INTO zones VALUES ('',162,'LH','Lahore');
INSERT INTO zones VALUES ('',162,'ISB','Islamabad');
INSERT INTO zones VALUES ('',162,'QUE','Quetta');
INSERT INTO zones VALUES ('',162,'PSH','Peshawar');
INSERT INTO zones VALUES ('',162,'GUJ','Gujrat');
INSERT INTO zones VALUES ('',162,'SAH','Sahiwal');
INSERT INTO zones VALUES ('',162,'FSB','Faisalabad');
INSERT INTO zones VALUES ('',162,'RIP','Rawal Pindi');

#Romania
INSERT INTO zones VALUES ('',175,'AB','Alba');
INSERT INTO zones VALUES ('',175,'AR','Arad');
INSERT INTO zones VALUES ('',175,'AG','Arges');
INSERT INTO zones VALUES ('',175,'BC','Bacau');
INSERT INTO zones VALUES ('',175,'BH','Bihor');
INSERT INTO zones VALUES ('',175,'BN','Bistrita-Nasaud');
INSERT INTO zones VALUES ('',175,'BT','Botosani');
INSERT INTO zones VALUES ('',175,'BV','Brasov');
INSERT INTO zones VALUES ('',175,'BR','Braila');
INSERT INTO zones VALUES ('',175,'B','Bucuresti');
INSERT INTO zones VALUES ('',175,'BZ','Buzau');
INSERT INTO zones VALUES ('',175,'CS','Caras-Severin');
INSERT INTO zones VALUES ('',175,'CL','Calarasi');
INSERT INTO zones VALUES ('',175,'CJ','Cluj');
INSERT INTO zones VALUES ('',175,'CT','Constanta');
INSERT INTO zones VALUES ('',175,'CV','Covasna');
INSERT INTO zones VALUES ('',175,'DB','Dimbovita');
INSERT INTO zones VALUES ('',175,'DJ','Dolj');
INSERT INTO zones VALUES ('',175,'GL','Galati');
INSERT INTO zones VALUES ('',175,'GR','Giurgiu');
INSERT INTO zones VALUES ('',175,'GJ','Gorj');
INSERT INTO zones VALUES ('',175,'HR','Harghita');
INSERT INTO zones VALUES ('',175,'HD','Hunedoara');
INSERT INTO zones VALUES ('',175,'IL','Ialomita');
INSERT INTO zones VALUES ('',175,'IS','Iasi');
INSERT INTO zones VALUES ('',175,'IF','Ilfov');
INSERT INTO zones VALUES ('',175,'MM','Maramures');
INSERT INTO zones VALUES ('',175,'MH','Mehedint');
INSERT INTO zones VALUES ('',175,'MS','Mures');
INSERT INTO zones VALUES ('',175,'NT','Neamt');
INSERT INTO zones VALUES ('',175,'OT','Olt');
INSERT INTO zones VALUES ('',175,'PH','Prahova');
INSERT INTO zones VALUES ('',175,'SM','Satu-Mare');
INSERT INTO zones VALUES ('',175,'SJ','Salaj');
INSERT INTO zones VALUES ('',175,'SB','Sibiu');
INSERT INTO zones VALUES ('',175,'SV','Suceava');
INSERT INTO zones VALUES ('',175,'TR','Teleorman');
INSERT INTO zones VALUES ('',175,'TM','Timis');
INSERT INTO zones VALUES ('',175,'TL','Tulcea');
INSERT INTO zones VALUES ('',175,'VS','Vaslui');
INSERT INTO zones VALUES ('',175,'VL','Valcea');
INSERT INTO zones VALUES ('',175,'VN','Vrancea');

#South Africa
INSERT INTO zones VALUES ('',193,'WP','Western Cape');
INSERT INTO zones VALUES ('',193,'GP','Gauteng');
INSERT INTO zones VALUES ('',193,'KZN','Kwazulu-Natal');
INSERT INTO zones VALUES ('',193,'NC','Northern-Cape');
INSERT INTO zones VALUES ('',193,'EC','Eastern-Cape');
INSERT INTO zones VALUES ('',193,'MP','Mpumalanga');
INSERT INTO zones VALUES ('',193,'NW','North-West');
INSERT INTO zones VALUES ('',193,'FS','Free State');
INSERT INTO zones VALUES ('',193,'NP','Northern Province');

#Turkey
INSERT INTO zones VALUES ('',215,'AA', 'Adana');
INSERT INTO zones VALUES ('',215,'AD', 'Adiyaman');
INSERT INTO zones VALUES ('',215,'AF', 'Afyonkarahisar');
INSERT INTO zones VALUES ('',215,'AG', 'Agri');
INSERT INTO zones VALUES ('',215,'AK', 'Aksaray');
INSERT INTO zones VALUES ('',215,'AM', 'Amasya');
INSERT INTO zones VALUES ('',215,'AN', 'Ankara');
INSERT INTO zones VALUES ('',215,'AL', 'Antalya');
INSERT INTO zones VALUES ('',215,'AR', 'Ardahan');
INSERT INTO zones VALUES ('',215,'AV', 'Artvin');
INSERT INTO zones VALUES ('',215,'AY', 'Aydin');
INSERT INTO zones VALUES ('',215,'BK', 'Balikesir');
INSERT INTO zones VALUES ('',215,'BR', 'Bartin');
INSERT INTO zones VALUES ('',215,'BM', 'Batman');
INSERT INTO zones VALUES ('',215,'BB', 'Bayburt');
INSERT INTO zones VALUES ('',215,'BC', 'Bilecik');
INSERT INTO zones VALUES ('',215,'BG', 'Bingöl');
INSERT INTO zones VALUES ('',215,'BT', 'Bitlis');
INSERT INTO zones VALUES ('',215,'BL', 'Bolu' );
INSERT INTO zones VALUES ('',215,'BD', 'Burdur');
INSERT INTO zones VALUES ('',215,'BU', 'Bursa');
INSERT INTO zones VALUES ('',215,'CK', 'Çanakkale');
INSERT INTO zones VALUES ('',215,'CI', 'Çankiri');
INSERT INTO zones VALUES ('',215,'CM', 'Çorum');
INSERT INTO zones VALUES ('',215,'DN', 'Denizli');
INSERT INTO zones VALUES ('',215,'DY', 'Diyarbakir');
INSERT INTO zones VALUES ('',215,'DU', 'Düzce');
INSERT INTO zones VALUES ('',215,'ED', 'Edirne');
INSERT INTO zones VALUES ('',215,'EG', 'Elazig');
INSERT INTO zones VALUES ('',215,'EN', 'Erzincan');
INSERT INTO zones VALUES ('',215,'EM', 'Erzurum');
INSERT INTO zones VALUES ('',215,'ES', 'Eskisehir');
INSERT INTO zones VALUES ('',215,'GA', 'Gaziantep');
INSERT INTO zones VALUES ('',215,'GI', 'Giresun');
INSERT INTO zones VALUES ('',215,'GU', 'Gümüshane');
INSERT INTO zones VALUES ('',215,'HK', 'Hakkari');
INSERT INTO zones VALUES ('',215,'HT', 'Hatay');
INSERT INTO zones VALUES ('',215,'IG', 'Igdir');
INSERT INTO zones VALUES ('',215,'IP', 'Isparta');
INSERT INTO zones VALUES ('',215,'IB', 'Istanbul');
INSERT INTO zones VALUES ('',215,'IZ', 'Izmir');
INSERT INTO zones VALUES ('',215,'KM', 'Kahramanmaras');
INSERT INTO zones VALUES ('',215,'KB', 'Karabük');
INSERT INTO zones VALUES ('',215,'KR', 'Karaman');
INSERT INTO zones VALUES ('',215,'KA', 'Kars');
INSERT INTO zones VALUES ('',215,'KS', 'Kastamonu');
INSERT INTO zones VALUES ('',215,'KY', 'Kayseri');
INSERT INTO zones VALUES ('',215,'KI', 'Kilis');
INSERT INTO zones VALUES ('',215,'KK', 'Kirikkale');
INSERT INTO zones VALUES ('',215,'KL', 'Kirklareli');
INSERT INTO zones VALUES ('',215,'KH', 'Kirsehir');
INSERT INTO zones VALUES ('',215,'KC', 'Kocaeli');
INSERT INTO zones VALUES ('',215,'KO', 'Konya');
INSERT INTO zones VALUES ('',215,'KU', 'Kütahya');
INSERT INTO zones VALUES ('',215,'ML', 'Malatya');
INSERT INTO zones VALUES ('',215,'MN', 'Manisa');
INSERT INTO zones VALUES ('',215,'MR', 'Mardin');
INSERT INTO zones VALUES ('',215,'IC', 'Mersin');
INSERT INTO zones VALUES ('',215,'MG', 'Mugla');
INSERT INTO zones VALUES ('',215,'MS', 'Mus');
INSERT INTO zones VALUES ('',215,'NV', 'Nevsehir');
INSERT INTO zones VALUES ('',215,'NG', 'Nigde');
INSERT INTO zones VALUES ('',215,'OR', 'Ordu');
INSERT INTO zones VALUES ('',215,'OS', 'Osmaniye');
INSERT INTO zones VALUES ('',215,'RI', 'Rize');
INSERT INTO zones VALUES ('',215,'SK', 'Sakarya');
INSERT INTO zones VALUES ('',215,'SS', 'Samsun');
INSERT INTO zones VALUES ('',215,'SU', 'Sanliurfa');
INSERT INTO zones VALUES ('',215,'SI', 'Siirt');
INSERT INTO zones VALUES ('',215,'SP', 'Sinop');
INSERT INTO zones VALUES ('',215,'SR', 'Sirnak');
INSERT INTO zones VALUES ('',215,'SV', 'Sivas');
INSERT INTO zones VALUES ('',215,'TG', 'Tekirdag');
INSERT INTO zones VALUES ('',215,'TT', 'Tokat');
INSERT INTO zones VALUES ('',215,'TB', 'Trabzon');
INSERT INTO zones VALUES ('',215,'TC', 'Tunceli');
INSERT INTO zones VALUES ('',215,'US', 'Usak');
INSERT INTO zones VALUES ('',215,'VA', 'Van');
INSERT INTO zones VALUES ('',215,'YL', 'Yalova');
INSERT INTO zones VALUES ('',215,'YZ', 'Yozgat');
INSERT INTO zones VALUES ('',215,'ZO', 'Zonguldak');

#Venezuela
INSERT INTO zones VALUES ('',229,'AM','Amazonas');
INSERT INTO zones VALUES ('',229,'AN','Anzoátegui');
INSERT INTO zones VALUES ('',229,'AR','Aragua');
INSERT INTO zones VALUES ('',229,'AP','Apure');
INSERT INTO zones VALUES ('',229,'BA','Barinas');
INSERT INTO zones VALUES ('',229,'BO','Bolívar');
INSERT INTO zones VALUES ('',229,'CA','Carabobo');
INSERT INTO zones VALUES ('',229,'CO','Cojedes');
INSERT INTO zones VALUES ('',229,'DA','Delta Amacuro');
INSERT INTO zones VALUES ('',229,'DC','Distrito Capital');
INSERT INTO zones VALUES ('',229,'FA','Falcón');
INSERT INTO zones VALUES ('',229,'GA','Guárico');
INSERT INTO zones VALUES ('',229,'GU','Guayana');
INSERT INTO zones VALUES ('',229,'LA','Lara');
INSERT INTO zones VALUES ('',229,'ME','Mérida');
INSERT INTO zones VALUES ('',229,'MI','Miranda');
INSERT INTO zones VALUES ('',229,'MO','Monagas');
INSERT INTO zones VALUES ('',229,'NE','Nueva Esparta');
INSERT INTO zones VALUES ('',229,'PO','Portuguesa');
INSERT INTO zones VALUES ('',229,'SU','Sucre');
INSERT INTO zones VALUES ('',229,'TA','Táchira');
INSERT INTO zones VALUES ('',229,'TU','Trujillo');
INSERT INTO zones VALUES ('',229,'VA','Vargas');
INSERT INTO zones VALUES ('',229,'YA','Yaracuy');
INSERT INTO zones VALUES ('',229,'ZU','Zulia');

#UK
INSERT INTO zones VALUES ('',222,'BAS','Bath and North East Somerset');
INSERT INTO zones VALUES ('',222,'BDF','Bedfordshire');
INSERT INTO zones VALUES ('',222,'WBK','Berkshire');
INSERT INTO zones VALUES ('',222,'BBD','Blackburn with Darwen');
INSERT INTO zones VALUES ('',222,'BPL','Blackpool');
INSERT INTO zones VALUES ('',222,'BPL','Bournemouth');
INSERT INTO zones VALUES ('',222,'BNH','Brighton and Hove');
INSERT INTO zones VALUES ('',222,'BST','Bristol');
INSERT INTO zones VALUES ('',222,'BKM','Buckinghamshire');
INSERT INTO zones VALUES ('',222,'CAM','Cambridgeshire');
INSERT INTO zones VALUES ('',222,'CHS','Cheshire');
INSERT INTO zones VALUES ('',222,'CON','Cornwall');
INSERT INTO zones VALUES ('',222,'DUR','County Durham');
INSERT INTO zones VALUES ('',222,'CMA','Cumbria');
INSERT INTO zones VALUES ('',222,'DAL','Darlington');
INSERT INTO zones VALUES ('',222,'DER','Derby');
INSERT INTO zones VALUES ('',222,'DBY','Derbyshire');
INSERT INTO zones VALUES ('',222,'DEV','Devon');
INSERT INTO zones VALUES ('',222,'DOR','Dorset');
INSERT INTO zones VALUES ('',222,'ERY','East Riding of Yorkshire');
INSERT INTO zones VALUES ('',222,'ESX','East Sussex');
INSERT INTO zones VALUES ('',222,'ESS','Essex');
INSERT INTO zones VALUES ('',222,'GLS','Gloucestershire');
INSERT INTO zones VALUES ('',222,'LND','Greater London');
INSERT INTO zones VALUES ('',222,'MAN','Greater Manchester');
INSERT INTO zones VALUES ('',222,'HAL','Halton');
INSERT INTO zones VALUES ('',222,'HAM','Hampshire');
INSERT INTO zones VALUES ('',222,'HPL','Hartlepool');
INSERT INTO zones VALUES ('',222,'HEF','Herefordshire');
INSERT INTO zones VALUES ('',222,'HRT','Hertfordshire');
INSERT INTO zones VALUES ('',222,'KHL','Hull');
INSERT INTO zones VALUES ('',222,'IOW','Isle of Wight');
INSERT INTO zones VALUES ('',222,'KEN','Kent');
INSERT INTO zones VALUES ('',222,'LAN','Lancashire');
INSERT INTO zones VALUES ('',222,'LCE','Leicester');
INSERT INTO zones VALUES ('',222,'LEC','Leicestershire');
INSERT INTO zones VALUES ('',222,'LIN','Lincolnshire');
INSERT INTO zones VALUES ('',222,'LUT','Luton');
INSERT INTO zones VALUES ('',222,'MDW','Medway');
INSERT INTO zones VALUES ('',222,'MER','Merseyside');
INSERT INTO zones VALUES ('',222,'MDB','Middlesbrough');
INSERT INTO zones VALUES ('',222,'MDB','Milton Keynes');
INSERT INTO zones VALUES ('',222,'NFK','Norfolk');
INSERT INTO zones VALUES ('',222,'NTH','Northamptonshire');
INSERT INTO zones VALUES ('',222,'NEL','North East Lincolnshire');
INSERT INTO zones VALUES ('',222,'NLN','North Lincolnshire');
INSERT INTO zones VALUES ('',222,'NSM','North Somerset');
INSERT INTO zones VALUES ('',222,'NBL','Northumberland');
INSERT INTO zones VALUES ('',222,'NYK','North Yorkshire');
INSERT INTO zones VALUES ('',222,'NGM','Nottingham');
INSERT INTO zones VALUES ('',222,'NTT','Nottinghamshire');
INSERT INTO zones VALUES ('',222,'OXF','Oxfordshire');
INSERT INTO zones VALUES ('',222,'PTE','Peterborough');
INSERT INTO zones VALUES ('',222,'PLY','Plymouth');
INSERT INTO zones VALUES ('',222,'POL','Poole');
INSERT INTO zones VALUES ('',222,'POR','Portsmouth');
INSERT INTO zones VALUES ('',222,'RCC','Redcar and Cleveland');
INSERT INTO zones VALUES ('',222,'RUT','Rutland');
INSERT INTO zones VALUES ('',222,'SHR','Shropshire');
INSERT INTO zones VALUES ('',222,'SOM','Somerset');
INSERT INTO zones VALUES ('',222,'STH','Southampton');
INSERT INTO zones VALUES ('',222,'SOS','Southend-on-Sea');
INSERT INTO zones VALUES ('',222,'SGC','South Gloucestershire');
INSERT INTO zones VALUES ('',222,'SYK','South Yorkshire');
INSERT INTO zones VALUES ('',222,'STS','Staffordshire');
INSERT INTO zones VALUES ('',222,'STT','Stockton-on-Tees');
INSERT INTO zones VALUES ('',222,'STE','Stoke-on-Trent');
INSERT INTO zones VALUES ('',222,'SFK','Suffolk');
INSERT INTO zones VALUES ('',222,'SRY','Surrey');
INSERT INTO zones VALUES ('',222,'SWD','Swindon');
INSERT INTO zones VALUES ('',222,'TFW','Telford and Wrekin');
INSERT INTO zones VALUES ('',222,'THR','Thurrock');
INSERT INTO zones VALUES ('',222,'TOB','Torbay');
INSERT INTO zones VALUES ('',222,'TYW','Tyne and Wear');
INSERT INTO zones VALUES ('',222,'WRT','Warrington');
INSERT INTO zones VALUES ('',222,'WAR','Warwickshire');
INSERT INTO zones VALUES ('',222,'WMI','West Midlands');
INSERT INTO zones VALUES ('',222,'WSX','West Sussex');
INSERT INTO zones VALUES ('',222,'WYK','West Yorkshire');
INSERT INTO zones VALUES ('',222,'WIL','Wiltshire');
INSERT INTO zones VALUES ('',222,'WOR','Worcestershire');
INSERT INTO zones VALUES ('',222,'YOR','York');


INSERT INTO blog_start VALUES (1, 1, 'Blog Start Text', NOW());
INSERT INTO blog_start VALUES (1, 2, 'Blog Start Text', NOW());




INSERT INTO addon_filenames ( configuration_id , configuration_key , configuration_value ) VALUES (NULL , 'FILENAME_PRODUCTS_PROMOTION', 'products_promotion.php');
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_HEADER_TITLE','Produkt Promotion v2.3',2);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_CONFIG_GLOBAL_ON','Promotion f&uuml;r dieses Produkt aktivieren?',2);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_CONFIG_PRODUCT_TITLE_ON','Artikelname als Promotion Titel?',2);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_CONFIG_PRODUCT_DESCRIPTION_ON','Artikelbeschreibung als Promotiontext?',2);

INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_TEXT_TITLE','Promotion Titel (max.100 Zeichen)',2);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_TEXT_IMAGE','Promotion Grafik einfügen',2);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_TEXT_DELETE','Grafik löschen?',2);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_TEXT_DESCRIPTION','Promotion Beschreibung/Text',2);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_TEXT_WARNING', '<b>Sie m&uuml;ssen das Modul noch unter Konfiguration > Zusatzmodule > Produktpromotion aktivieren.</b>',2);

INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'MODULE_PRODUCT_PROMOTION_STATUS_TITLE' , 'Produktpromotion aktivieren',2);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'MODULE_PRODUCT_PROMOTION_STATUS_DESC' , 'Aktivieren Sie diese Funktion, wenn Sie auf der Startseite des Shops ausgew&auml;hlte Produkte besonders hervorheben/promoten m&ouml;chten.<br /> In der Produktmaske k&ouml;nnen Sie Titel, Beschreibung und speziell angefertigte Grafiken zuweisen, sowie Produktanzeige deaktivieren, ohne bestehende Angaben l&ouml;schen zu m&uuml;ssen.',2);

INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_HEADER_TITLE','Product Promotion v2.3',1);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_CONFIG_GLOBAL_ON','Show Promotion for this Product?',1);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_CONFIG_PRODUCT_TITLE_ON','Promotion Title by Productname?',1);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_CONFIG_PRODUCT_DESCRIPTION_ON','Promotion Description by Productdescription?',1);

INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_TEXT_TITLE','Promotion Title (max.100 Indications)',1);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_TEXT_IMAGE','Promotion Image',1);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_TEXT_DELETE','Del Image?',1);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_TEXT_DESCRIPTION','Promotion Description/Text',1);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'PP_TEXT_WARNING', '<b>You must enable the module is still under Configuration > Plug-ins > Product Promotion.</b>',1);

INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'MODULE_PRODUCT_PROMOTION_STATUS_TITLE' , 'Show Productpromotion',1);
INSERT INTO addon_languages ( configuration_id , configuration_key , configuration_value , languages_id ) VALUES (NULL ,'MODULE_PRODUCT_PROMOTION_STATUS_DESC' , 'Activate this function, if you particularly promotion on the starting side of the Shops selected products liked. On the product mask you can assign title, description and particularly made diagrams, as well as deactivate product announcement, without having to delete existing data.',1);

INSERT INTO addon_filenames ( configuration_id , configuration_key , configuration_value ) VALUES (NULL , 'FILENAME_CSEO_PRODUCT_EXPORT', 'cseo_product_export.php');


INSERT INTO addon_languages VALUES (NULL , 'BOX_COMMENTS_ORDERS', 'Kommentar-Vorlagen', '2');
INSERT INTO addon_languages VALUES (NULL , 'BOX_COMMENTS_ORDERS', 'Comment templates', '1');

ALTER TABLE blog_items ADD COLUMN shortdesc TEXT NOT NULL AFTER description;
ALTER TABLE blog_items ADD COLUMN date2 DATE NOT NULL AFTER date;
ALTER TABLE blog_categories ADD COLUMN description TEXT NOT NULL AFTER titel;
ALTER TABLE blog_categories ADD COLUMN parent_id INT(11) NOT NULL DEFAULT '0' AFTER id;


INSERT INTO banktransfer_blz VALUES(10000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(10010010, 'Postbank', '24');
INSERT INTO banktransfer_blz VALUES(10010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(10010222, 'The Royal Bank of Scotland, Niederlassung Deutschland', '10');
INSERT INTO banktransfer_blz VALUES(10010424, 'Aareal Bank', '09');
INSERT INTO banktransfer_blz VALUES(10019610, 'Dexia Kommunalbank Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(10020000, 'Berliner Bank -alt-', '69');
INSERT INTO banktransfer_blz VALUES(10020200, 'BHF-BANK', '60');
INSERT INTO banktransfer_blz VALUES(10020400, 'Citadele Bank Zndl Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(10020500, 'Bank für Sozialwirtschaft', '09');
INSERT INTO banktransfer_blz VALUES(10020890, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(10030200, 'Berlin-Hannoversche Hypothekenbank', '09');
INSERT INTO banktransfer_blz VALUES(10030400, 'ABK-Kreditbank', '09');
INSERT INTO banktransfer_blz VALUES(10030500, 'Bankhaus Löbbecke', '09');
INSERT INTO banktransfer_blz VALUES(10030600, 'North Channel Bank', '88');
INSERT INTO banktransfer_blz VALUES(10030700, 'Gries & Heissel - Bankiers', '16');
INSERT INTO banktransfer_blz VALUES(10033300, 'Santander Consumer Bank', '09');
INSERT INTO banktransfer_blz VALUES(10040000, 'Commerzbank Berlin (West)', '13');
INSERT INTO banktransfer_blz VALUES(10040048, 'Commerzbank GF-B48', '13');
INSERT INTO banktransfer_blz VALUES(10040060, 'Commerzbank Gf 160', '09');
INSERT INTO banktransfer_blz VALUES(10040061, 'Commerzbank Gf 161', '09');
INSERT INTO banktransfer_blz VALUES(10040062, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(10040063, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(10045050, 'Commerzbank Service-BZ', '13');
INSERT INTO banktransfer_blz VALUES(10050000, 'Landesbank Berlin - Berliner Sparkasse', 'B8');
INSERT INTO banktransfer_blz VALUES(10050005, 'Landesbank Berlin - E 1 -', 'C6');
INSERT INTO banktransfer_blz VALUES(10050006, 'Landesbank Berlin - E 2 -', 'D1');
INSERT INTO banktransfer_blz VALUES(10050007, 'Landesbank Berlin - E 3 -', 'D4');
INSERT INTO banktransfer_blz VALUES(10050008, 'Landesbank Berlin - E 4 -', '09');
INSERT INTO banktransfer_blz VALUES(10050020, 'LBB S-Kreditpartner, Berlin', 'B8');
INSERT INTO banktransfer_blz VALUES(10050021, 'LBB S-Kreditpartner Bad Homburg v d Höhe', '09');
INSERT INTO banktransfer_blz VALUES(10050500, 'LBS Ost Berlin', '09');
INSERT INTO banktransfer_blz VALUES(10050600, 'WestLB Berlin', '08');
INSERT INTO banktransfer_blz VALUES(10050999, 'DekaBank Berlin', '09');
INSERT INTO banktransfer_blz VALUES(10060198, 'Pax-Bank', '06');
INSERT INTO banktransfer_blz VALUES(10060237, 'Evangelische Darlehnsgenossenschaft', '33');
INSERT INTO banktransfer_blz VALUES(10061006, 'Bank für Kirche und Diakonie - KD-Bank Gf Sonder-BLZ', '09');
INSERT INTO banktransfer_blz VALUES(10070000, 'Deutsche Bank Fil Berlin', '63');
INSERT INTO banktransfer_blz VALUES(10070024, 'Deutsche Bank Privat und Geschäftskunden F 700', '63');
INSERT INTO banktransfer_blz VALUES(10070100, 'Deutsche Bank Fil Berlin II', '63');
INSERT INTO banktransfer_blz VALUES(10070124, 'Deutsche Bank Privat und Geschäftskd Berlin II', '63');
INSERT INTO banktransfer_blz VALUES(10070848, 'Berliner Bank Niederlassung der Deutsche Bank PGK', '63');
INSERT INTO banktransfer_blz VALUES(10077777, 'norisbank', '63');
INSERT INTO banktransfer_blz VALUES(10080000, 'Commerzbank vormals Dresdner Bank Filiale Berlin I', '76');
INSERT INTO banktransfer_blz VALUES(10080005, 'Commerzbank vormals Dresdner Bank Zw A', '76');
INSERT INTO banktransfer_blz VALUES(10080006, 'Commerzbank vormals Dresdner Bank Zw B', '76');
INSERT INTO banktransfer_blz VALUES(10080055, 'Commerzbank vormals Dresdner Bank Zw 55', '76');
INSERT INTO banktransfer_blz VALUES(10080057, 'Commerzbank vormals Dresdner Bank Gf ZW 57', '76');
INSERT INTO banktransfer_blz VALUES(10080085, 'Commerzbank vormals Dresdner Bank Gf PCC DCC-ITGK 3', '09');
INSERT INTO banktransfer_blz VALUES(10080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 4', '09');
INSERT INTO banktransfer_blz VALUES(10080087, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 5', '09');
INSERT INTO banktransfer_blz VALUES(10080088, 'Commerzbank vormals Dresdner Bank IBLZ', '76');
INSERT INTO banktransfer_blz VALUES(10080089, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 6', '09');
INSERT INTO banktransfer_blz VALUES(10080900, 'Commerzbank vormals Dresdner Bank Filiale Berlin III', '76');
INSERT INTO banktransfer_blz VALUES(10089260, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(10089999, 'Commerzbank vormals Dresdner Bank ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(10090000, 'Berliner Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(10090300, 'Bank für Schiffahrt (BFS) Fil d Ostfr VB Leer', '09');
INSERT INTO banktransfer_blz VALUES(10090603, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(10090900, 'PSD Bank Berlin-Brandenburg', '91');
INSERT INTO banktransfer_blz VALUES(10110300, 'Bankhaus Dr. Masel', '09');
INSERT INTO banktransfer_blz VALUES(10110400, 'Investitionsbank Berlin', '09');
INSERT INTO banktransfer_blz VALUES(10110600, 'quirin bank', '17');
INSERT INTO banktransfer_blz VALUES(10120100, 'Weberbank', '94');
INSERT INTO banktransfer_blz VALUES(10120600, 'Santander Consumer Bank', '41');
INSERT INTO banktransfer_blz VALUES(10120760, 'UniCredit Bank - HypoVereinsbank Ndl 260 BIn', '99');
INSERT INTO banktransfer_blz VALUES(10120800, 'VON ESSEN Bankgesellschaft', '09');
INSERT INTO banktransfer_blz VALUES(10120900, 'readybank', '09');
INSERT INTO banktransfer_blz VALUES(10120999, 'readybank Gf GAA', '09');
INSERT INTO banktransfer_blz VALUES(10130600, 'Isbank Fil Berlin', '06');
INSERT INTO banktransfer_blz VALUES(10130800, 'BIW Bank', '01');
INSERT INTO banktransfer_blz VALUES(10310600, 'Tradegate Wertpapierhandelsbank Berlin', '09');
INSERT INTO banktransfer_blz VALUES(12016836, 'KfW Kreditanstalt für Wiederaufbau', '09');
INSERT INTO banktransfer_blz VALUES(12030000, 'Deutsche Kreditbank Berlin', '00');
INSERT INTO banktransfer_blz VALUES(12030900, 'Merck Finck & Co', '10');
INSERT INTO banktransfer_blz VALUES(12040000, 'Commerzbank Berlin Ost', '13');
INSERT INTO banktransfer_blz VALUES(12050555, 'NLB FinanzIT', '09');
INSERT INTO banktransfer_blz VALUES(12060000, 'DZ BANK', '09');
INSERT INTO banktransfer_blz VALUES(12070000, 'Deutsche Bank Ld Brandenburg', '63');
INSERT INTO banktransfer_blz VALUES(12070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(12080000, 'Commerzbank vormals Dresdner Bank Filiale Berlin II', '76');
INSERT INTO banktransfer_blz VALUES(12090640, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(12096597, 'Sparda-Bank Berlin', 'A8');
INSERT INTO banktransfer_blz VALUES(13000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(13010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(13020780, 'UniCredit Bank - HypoVereinsbank (ehem. Hypo)', '99');
INSERT INTO banktransfer_blz VALUES(13040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(13050000, 'Ostseesparkasse Rostock', '20');
INSERT INTO banktransfer_blz VALUES(13051042, 'Kreissparkasse Rügen, Sitz Bergen', 'C0');
INSERT INTO banktransfer_blz VALUES(13061008, 'Volksbank Wolgast', '32');
INSERT INTO banktransfer_blz VALUES(13061028, 'Volksbank Raiffeisenbank ehem VB Greifswald', '32');
INSERT INTO banktransfer_blz VALUES(13061078, 'Volks- und Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(13061088, 'Raiffeisenbank Wismar -alt-', '32');
INSERT INTO banktransfer_blz VALUES(13061128, 'Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(13070000, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(13070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(13080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(13090000, 'Rostocker Volks- und Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(13091054, 'Pommersche Volksbank', '32');
INSERT INTO banktransfer_blz VALUES(13091084, 'Volksbank Wismar -alt-', '06');
INSERT INTO banktransfer_blz VALUES(14000000, 'Bundesbank eh Schwerin', '09');
INSERT INTO banktransfer_blz VALUES(14040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(14051000, 'Sparkasse Mecklenburg-Nordwest', '20');
INSERT INTO banktransfer_blz VALUES(14051362, 'Sparkasse Parchim-Lübz', '20');
INSERT INTO banktransfer_blz VALUES(14051462, 'Sparkasse Schwerin -alt-', 'C0');
INSERT INTO banktransfer_blz VALUES(14052000, 'Sparkasse Mecklenburg-Schwerin', '20');
INSERT INTO banktransfer_blz VALUES(14061308, 'Volks- und Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(14061438, 'Raiffeisen-Volksbank -alt-', '32');
INSERT INTO banktransfer_blz VALUES(14080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(14080011, 'Commerzbank vormals Dresdner Bank Zw W', '76');
INSERT INTO banktransfer_blz VALUES(14091464, 'VR-Bank', '32');
INSERT INTO banktransfer_blz VALUES(15000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(15040068, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(15050100, 'Müritz-Sparkasse', '20');
INSERT INTO banktransfer_blz VALUES(15050200, 'Sparkasse Neubrandenburg-Demmin', '20');
INSERT INTO banktransfer_blz VALUES(15050400, 'Sparkasse Uecker-Randow', '20');
INSERT INTO banktransfer_blz VALUES(15050500, 'Sparkasse Vorpommern', '20');
INSERT INTO banktransfer_blz VALUES(15051732, 'Sparkasse Mecklenburg-Strelitz', 'C0');
INSERT INTO banktransfer_blz VALUES(15061618, 'Raiffeisenbank Mecklenburger Seenplatte', '32');
INSERT INTO banktransfer_blz VALUES(15061638, 'Volksbank Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(15061658, 'Raiffeisenbank Pasewalk-Strasburg -alt-', '32');
INSERT INTO banktransfer_blz VALUES(15061698, 'Raiffeisenbank Malchin', '32');
INSERT INTO banktransfer_blz VALUES(15061758, 'Neubrandenburger Bank -alt-', '06');
INSERT INTO banktransfer_blz VALUES(15080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(15091674, 'Volksbank Demmin', '06');
INSERT INTO banktransfer_blz VALUES(15091704, 'VR-Bank Uckermark-Randow', '06');
INSERT INTO banktransfer_blz VALUES(16000000, 'Bundesbank eh Potsdam', '09');
INSERT INTO banktransfer_blz VALUES(16010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(16010300, 'Investitionsbank des Landes Brandenburg', '08');
INSERT INTO banktransfer_blz VALUES(16020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(16040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(16050000, 'Mittelbrandenburgische Sparkasse in Potsdam', '20');
INSERT INTO banktransfer_blz VALUES(16050101, 'Sparkasse Prignitz', '20');
INSERT INTO banktransfer_blz VALUES(16050202, 'Sparkasse Ostprignitz-Ruppin', '20');
INSERT INTO banktransfer_blz VALUES(16050500, 'LBS Ostdeutsche Landesbausparkasse', '09');
INSERT INTO banktransfer_blz VALUES(16060122, 'Volks- und Raiffeisenbank Prignitz', '32');
INSERT INTO banktransfer_blz VALUES(16061938, 'Raiffeisenbank Ostprignitz-Ruppin', '32');
INSERT INTO banktransfer_blz VALUES(16062008, 'VR-Bank Fläming', '28');
INSERT INTO banktransfer_blz VALUES(16062073, 'Brandenburger Bank', '32');
INSERT INTO banktransfer_blz VALUES(16080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(16091994, 'Volksbank Rathenow', '32');
INSERT INTO banktransfer_blz VALUES(17000000, 'Bundesbank eh Frankfurt (Oder)', '09');
INSERT INTO banktransfer_blz VALUES(17020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(17040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(17052000, 'Sparkasse Barnim', '20');
INSERT INTO banktransfer_blz VALUES(17052302, 'Stadtsparkasse Schwedt', 'C0');
INSERT INTO banktransfer_blz VALUES(17054040, 'Sparkasse Märkisch-Oderland', '20');
INSERT INTO banktransfer_blz VALUES(17055050, 'Sparkasse Oder-Spree', '20');
INSERT INTO banktransfer_blz VALUES(17056060, 'Sparkasse Uckermark', '20');
INSERT INTO banktransfer_blz VALUES(17062428, 'Raiffeisenbank-Volksbank Oder-Spree', '32');
INSERT INTO banktransfer_blz VALUES(17080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(17092404, 'VR Bank Fürstenwalde Seelow Wriezen', '32');
INSERT INTO banktransfer_blz VALUES(18000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(18020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(18040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(18050000, 'Sparkasse Spree-Neiße', '20');
INSERT INTO banktransfer_blz VALUES(18051000, 'Sparkasse Elbe-Elster', '20');
INSERT INTO banktransfer_blz VALUES(18055000, 'Sparkasse Niederlausitz', '20');
INSERT INTO banktransfer_blz VALUES(18062678, 'VR Bank Lausitz', '32');
INSERT INTO banktransfer_blz VALUES(18062758, 'VR Bank Forst', '32');
INSERT INTO banktransfer_blz VALUES(18080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(18092684, 'Spreewaldbank', '32');
INSERT INTO banktransfer_blz VALUES(18092744, 'Volksbank Spree-Neiße', '32');
INSERT INTO banktransfer_blz VALUES(18092794, 'Volks- und Raiffeisenbank Cottbus -alt-', '32');
INSERT INTO banktransfer_blz VALUES(20000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(20010020, 'Postbank (Giro)', '24');
INSERT INTO banktransfer_blz VALUES(20010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(20010424, 'Aareal Bank', '09');
INSERT INTO banktransfer_blz VALUES(20020200, 'SEB Merchant Bank Hamburg', '09');
INSERT INTO banktransfer_blz VALUES(20020500, 'Jyske Bank Fil Hamburg', '09');
INSERT INTO banktransfer_blz VALUES(20020860, 'UniCredit Bank - HypoVereinsbank (ehem. Hypo)', '99');
INSERT INTO banktransfer_blz VALUES(20020900, 'Signal Iduna Bauspar', '09');
INSERT INTO banktransfer_blz VALUES(20030000, 'UniCredit Bank - HypoVereinsbank', '68');
INSERT INTO banktransfer_blz VALUES(20030300, 'Donner & Reuschel', '09');
INSERT INTO banktransfer_blz VALUES(20030400, 'Marcard, Stein & Co Bankiers', '00');
INSERT INTO banktransfer_blz VALUES(20030600, 'Sydbank Fil Hamburg', '19');
INSERT INTO banktransfer_blz VALUES(20030700, 'Merck Finck & Co', '10');
INSERT INTO banktransfer_blz VALUES(20030900, 'Bankhaus Wölbern & Co', '06');
INSERT INTO banktransfer_blz VALUES(20040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(20040040, 'Commerzbank GF RME', '13');
INSERT INTO banktransfer_blz VALUES(20040048, 'Commerzbank GF-H48', '13');
INSERT INTO banktransfer_blz VALUES(20040050, 'Commerzbank GF COC', '13');
INSERT INTO banktransfer_blz VALUES(20040060, 'Commerzbank Gf 260', '09');
INSERT INTO banktransfer_blz VALUES(20040061, 'Commerzbank Gf 261', '09');
INSERT INTO banktransfer_blz VALUES(20040062, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(20040063, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(20041111, 'comdirect bank', '13');
INSERT INTO banktransfer_blz VALUES(20041133, 'comdirect bank', '13');
INSERT INTO banktransfer_blz VALUES(20041144, 'comdirect bank', '13');
INSERT INTO banktransfer_blz VALUES(20041155, 'comdirect bank', '13');
INSERT INTO banktransfer_blz VALUES(20050000, 'HSH Nordbank Hamburg', 'C5');
INSERT INTO banktransfer_blz VALUES(20050550, 'Hamburger Sparkasse', '00');
INSERT INTO banktransfer_blz VALUES(20060000, 'DZ BANK', '09');
INSERT INTO banktransfer_blz VALUES(20069111, 'Norderstedter Bank', '32');
INSERT INTO banktransfer_blz VALUES(20069125, 'Kaltenkirchener Bank', '33');
INSERT INTO banktransfer_blz VALUES(20069130, 'Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(20069144, 'Raiffeisenbank', '33');
INSERT INTO banktransfer_blz VALUES(20069177, 'Raiffeisenbank Südstormarn', '32');
INSERT INTO banktransfer_blz VALUES(20069232, 'Raiffeisenbank', '33');
INSERT INTO banktransfer_blz VALUES(20069625, 'Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(20069641, 'Raiffeisenbank Owschlag', '33');
INSERT INTO banktransfer_blz VALUES(20069659, 'Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(20069780, 'Volksbank Ahlerstedt', '28');
INSERT INTO banktransfer_blz VALUES(20069782, 'Volksbank Geest', '28');
INSERT INTO banktransfer_blz VALUES(20069786, 'Volksbank Kehdingen', '28');
INSERT INTO banktransfer_blz VALUES(20069800, 'Spar- und Kreditbank', '28');
INSERT INTO banktransfer_blz VALUES(20069812, 'Volksbank Fredenbeck-Oldendorf', '28');
INSERT INTO banktransfer_blz VALUES(20069815, 'Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(20069861, 'Raiffeisenbank', '33');
INSERT INTO banktransfer_blz VALUES(20069882, 'Raiffeisenbank Travemünde', '33');
INSERT INTO banktransfer_blz VALUES(20069965, 'Volksbank Winsener Marsch', '28');
INSERT INTO banktransfer_blz VALUES(20069989, 'Volksbank Wulfsen', '28');
INSERT INTO banktransfer_blz VALUES(20070000, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(20070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(20080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(20080055, 'Commerzbank vormals Dresdner Bank Zw 55', '76');
INSERT INTO banktransfer_blz VALUES(20080057, 'Commerzbank vormals Dresdner Bank Gf ZW 57', '76');
INSERT INTO banktransfer_blz VALUES(20080085, 'Commerzbank vormals Dresdner Bank Gf PCC DCC-ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(20080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 3', '09');
INSERT INTO banktransfer_blz VALUES(20080087, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 4', '09');
INSERT INTO banktransfer_blz VALUES(20080088, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 5', '09');
INSERT INTO banktransfer_blz VALUES(20080089, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 6', '09');
INSERT INTO banktransfer_blz VALUES(20080091, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 7', '09');
INSERT INTO banktransfer_blz VALUES(20080092, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 8', '09');
INSERT INTO banktransfer_blz VALUES(20080093, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 9', '09');
INSERT INTO banktransfer_blz VALUES(20080094, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 10', '09');
INSERT INTO banktransfer_blz VALUES(20080095, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 11', '09');
INSERT INTO banktransfer_blz VALUES(20089200, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(20090400, 'Deutsche Genossenschafts-Hypothekenbank', '09');
INSERT INTO banktransfer_blz VALUES(20090500, 'netbank', '81');
INSERT INTO banktransfer_blz VALUES(20090602, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(20090700, 'Edekabank', '50');
INSERT INTO banktransfer_blz VALUES(20090745, 'EBANK Gf Cash', '50');
INSERT INTO banktransfer_blz VALUES(20090900, 'PSD Bank Nord', '91');
INSERT INTO banktransfer_blz VALUES(20110022, 'Postbank (Spar)', '09');
INSERT INTO banktransfer_blz VALUES(20110401, 'Eurohypo ehem Deutsche Hypothekenbank Hamburg', '09');
INSERT INTO banktransfer_blz VALUES(20110700, 'Bank of Tokyo-Mitsubishi UFJ, The -', '09');
INSERT INTO banktransfer_blz VALUES(20110800, 'Bank of China Fil Hamburg', '09');
INSERT INTO banktransfer_blz VALUES(20120000, 'Berenberg, Joh. - Gossler & Co', '00');
INSERT INTO banktransfer_blz VALUES(20120100, 'Warburg, M.M.- Bank', '58');
INSERT INTO banktransfer_blz VALUES(20120200, 'BHF-BANK', '60');
INSERT INTO banktransfer_blz VALUES(20120400, 'Deutscher Ring Bausparkasse', '09');
INSERT INTO banktransfer_blz VALUES(20120600, 'Goyer & Göppel', '09');
INSERT INTO banktransfer_blz VALUES(20120700, 'Hanseatic Bank', '16');
INSERT INTO banktransfer_blz VALUES(20120701, 'Hanseatic Bank Zw Nord', '16');
INSERT INTO banktransfer_blz VALUES(20120744, 'Hanseatic Bank Filiale Ost', 'B9');
INSERT INTO banktransfer_blz VALUES(20120766, 'Hanseatic Bank Filiale Süd', 'B9');
INSERT INTO banktransfer_blz VALUES(20130400, 'GRENKE BANK', '00');
INSERT INTO banktransfer_blz VALUES(20130412, 'GRENKE BANK Asset Backed Securities', '00');
INSERT INTO banktransfer_blz VALUES(20130600, 'Barclaycard Barclays Bank', '09');
INSERT INTO banktransfer_blz VALUES(20133300, 'Santander Consumer Bank', '09');
INSERT INTO banktransfer_blz VALUES(20190003, 'Hamburger Volksbank', '10');
INSERT INTO banktransfer_blz VALUES(20190109, 'Volksbank Stormarn', '48');
INSERT INTO banktransfer_blz VALUES(20190206, 'Volksbank Hamburg Ost-West -alt-', '10');
INSERT INTO banktransfer_blz VALUES(20190301, 'Vierländer Volksbank', '10');
INSERT INTO banktransfer_blz VALUES(20190800, 'MKB Mittelstandskreditbank', '28');
INSERT INTO banktransfer_blz VALUES(20210200, 'Bank Melli Iran', '19');
INSERT INTO banktransfer_blz VALUES(20210300, 'Bank Saderat Iran', '09');
INSERT INTO banktransfer_blz VALUES(20220100, 'DnB NOR Bank ASA Filiale Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(20220400, 'Warburg, M.M. - Hypothekenbank', '09');
INSERT INTO banktransfer_blz VALUES(20230300, 'Schröder, Otto M. - Bank', '09');
INSERT INTO banktransfer_blz VALUES(20230600, 'Isbank Fil Hamburg', '06');
INSERT INTO banktransfer_blz VALUES(20230800, 'Sutor, Max Heinr', '09');
INSERT INTO banktransfer_blz VALUES(20310300, 'Europäisch-Iranische Handelsbank', '06');
INSERT INTO banktransfer_blz VALUES(20310600, 'The Royal Bank of Scotland, Niederlassung Deutschland', '10');
INSERT INTO banktransfer_blz VALUES(20320500, 'Danske Bank', '09');
INSERT INTO banktransfer_blz VALUES(20320585, 'Danske Bank - Settlements', '09');
INSERT INTO banktransfer_blz VALUES(20350000, 'WestLB Hamburg', '08');
INSERT INTO banktransfer_blz VALUES(20690500, 'Sparda-Bank Hamburg', 'D5');
INSERT INTO banktransfer_blz VALUES(20730000, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(20730001, 'UniCredit Bank - HVB Settlement EAC01', '09');
INSERT INTO banktransfer_blz VALUES(20730002, 'UniCredit Bank - HVB Settlement EAC02', '09');
INSERT INTO banktransfer_blz VALUES(20730003, 'UniCredit Bank - HVB Settlement EAC03', '09');
INSERT INTO banktransfer_blz VALUES(20730004, 'UniCredit Bank - HVB Settlement EAC04', '09');
INSERT INTO banktransfer_blz VALUES(20730005, 'UniCredit Bank - HVB Settlement EAC05', '09');
INSERT INTO banktransfer_blz VALUES(20730006, 'UniCredit Bank - HVB Settlement EAC06', '09');
INSERT INTO banktransfer_blz VALUES(20730007, 'UniCredit Bank - HVB Settlement EAC07', '09');
INSERT INTO banktransfer_blz VALUES(20730008, 'UniCredit Bank - HVB Settlement EAC08', '09');
INSERT INTO banktransfer_blz VALUES(20730009, 'UniCredit Bank - HVB Settlement EAC09', '09');
INSERT INTO banktransfer_blz VALUES(20730010, 'UniCredit Bank - HVB Settlement EAC10', '09');
INSERT INTO banktransfer_blz VALUES(20730011, 'UniCredit Bank - HVB Settlement EAC11', '09');
INSERT INTO banktransfer_blz VALUES(20730012, 'UniCredit Bank - HVB Settlement EAC12', '09');
INSERT INTO banktransfer_blz VALUES(20730013, 'UniCredit Bank - HVB Settlement EAC13', '09');
INSERT INTO banktransfer_blz VALUES(20730014, 'UniCredit Bank - HVB Settlement EAC14', '09');
INSERT INTO banktransfer_blz VALUES(20730015, 'UniCredit Bank - HVB Settlement EAC15', '09');
INSERT INTO banktransfer_blz VALUES(20730016, 'UniCredit Bank - HVB Settlement EAC16', '09');
INSERT INTO banktransfer_blz VALUES(20730017, 'UniCredit Bank - HVB Settlement EAC17', '09');
INSERT INTO banktransfer_blz VALUES(20730018, 'UniCredit Bank - HVB Settlement EAC18', '09');
INSERT INTO banktransfer_blz VALUES(20730019, 'UniCredit Bank - HVB Settlement EAC19', '09');
INSERT INTO banktransfer_blz VALUES(20730020, 'UniCredit Bank - HVB Settlement EAC20', '09');
INSERT INTO banktransfer_blz VALUES(20730021, 'UniCredit Bank - HVB Settlement EAC21', '09');
INSERT INTO banktransfer_blz VALUES(20730022, 'UniCredit Bank - HVB Settlement EAC22', '09');
INSERT INTO banktransfer_blz VALUES(20730023, 'UniCredit Bank - HVB Settlement EAC23', '09');
INSERT INTO banktransfer_blz VALUES(20730024, 'UniCredit Bank - HVB Settlement EAC24', '09');
INSERT INTO banktransfer_blz VALUES(20730025, 'UniCredit Bank - HVB Settlement EAC25', '09');
INSERT INTO banktransfer_blz VALUES(20730026, 'UniCredit Bank - HVB Settlement EAC26', '09');
INSERT INTO banktransfer_blz VALUES(20730027, 'UniCredit Bank - HVB Settlement EAC27', '09');
INSERT INTO banktransfer_blz VALUES(20730028, 'UniCredit Bank - HVB Settlement EAC28', '09');
INSERT INTO banktransfer_blz VALUES(20730029, 'UniCredit Bank - HVB Settlement EAC29', '09');
INSERT INTO banktransfer_blz VALUES(20730030, 'UniCredit Bank - HVB Settlement EAC30', '09');
INSERT INTO banktransfer_blz VALUES(20730031, 'UniCredit Bank - HVB Settlement EAC31', '09');
INSERT INTO banktransfer_blz VALUES(20730032, 'UniCredit Bank - HVB Settlement EAC32', '09');
INSERT INTO banktransfer_blz VALUES(20730033, 'UniCredit Bank - HVB Settlement EAC33', '09');
INSERT INTO banktransfer_blz VALUES(20730034, 'UniCredit Bank - HVB Settlement EAC34', '09');
INSERT INTO banktransfer_blz VALUES(20730035, 'UniCredit Bank - HVB Settlement EAC35', '09');
INSERT INTO banktransfer_blz VALUES(20730036, 'UniCredit Bank - HVB Settlement EAC36', '09');
INSERT INTO banktransfer_blz VALUES(20730037, 'UniCredit Bank - HVB Settlement EAC37', '09');
INSERT INTO banktransfer_blz VALUES(20730038, 'UniCredit Bank - HVB Settlement EAC38', '09');
INSERT INTO banktransfer_blz VALUES(20730039, 'UniCredit Bank - HVB Settlement EAC39', '09');
INSERT INTO banktransfer_blz VALUES(20730040, 'UniCredit Bank - HVB Settlement EAC40', '09');
INSERT INTO banktransfer_blz VALUES(20730051, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(20730053, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(20730054, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(20750000, 'Sparkasse Harburg-Buxtehude', '00');
INSERT INTO banktransfer_blz VALUES(21000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(21010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(21020600, 'Sydbank Filiale Kiel', '19');
INSERT INTO banktransfer_blz VALUES(21030000, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21030092, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21030093, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21030094, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21030095, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21040010, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(21042076, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(21050000, 'HSH Nordbank Hamburg, Kiel', 'C5');
INSERT INTO banktransfer_blz VALUES(21050170, 'Förde Sparkasse', '74');
INSERT INTO banktransfer_blz VALUES(21051275, 'Bordesholmer Sparkasse', 'A2');
INSERT INTO banktransfer_blz VALUES(21051580, 'Sparkasse Kreis Plön -alt-', '00');
INSERT INTO banktransfer_blz VALUES(21052090, 'Sparkasse Eckernförde -alt-', '00');
INSERT INTO banktransfer_blz VALUES(21060237, 'Evangelische Darlehnsgenossenschaft', '33');
INSERT INTO banktransfer_blz VALUES(21064045, 'Raiffeisenbank im Kreis Plön -alt-', '33');
INSERT INTO banktransfer_blz VALUES(21070020, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(21070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(21080050, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(21089201, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(21090007, 'Kieler Volksbank', '10');
INSERT INTO banktransfer_blz VALUES(21090619, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(21090900, 'PSD Bank Kiel', '91');
INSERT INTO banktransfer_blz VALUES(21092023, 'Eckernförder Bank Volksbank-Raiffeisenbank', '48');
INSERT INTO banktransfer_blz VALUES(21210111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(21230085, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21230086, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21240040, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(21241540, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(21250000, 'Stadtsparkasse Neumünster -alt-', '04');
INSERT INTO banktransfer_blz VALUES(21261089, 'Raiffeisenbank -alt-', '33');
INSERT INTO banktransfer_blz VALUES(21261227, 'Raiffbk Kl-Kummerfeld -alt-', '33');
INSERT INTO banktransfer_blz VALUES(21270020, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(21270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(21280002, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(21290016, 'Volksbank Raiffbk Neumünster', '48');
INSERT INTO banktransfer_blz VALUES(21340010, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(21352240, 'Sparkasse Holstein', 'A7');
INSERT INTO banktransfer_blz VALUES(21390008, 'VR Bank Ostholstein Nord-Plön', '32');
INSERT INTO banktransfer_blz VALUES(21392218, 'Volksbank Eutin Raiffeisenbank', '33');
INSERT INTO banktransfer_blz VALUES(21430070, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21440045, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(21450000, 'Sparkasse Mittelholstein Rendsburg', 'C2');
INSERT INTO banktransfer_blz VALUES(21451205, 'Sparkasse Büdelsdorf -alt-', '00');
INSERT INTO banktransfer_blz VALUES(21452030, 'Sparkasse Hohenwestedt', 'A2');
INSERT INTO banktransfer_blz VALUES(21461627, 'Raiffeisenbank Jevenstedt -alt-', '33');
INSERT INTO banktransfer_blz VALUES(21463603, 'Volksbank-Raiffeisenbank im Kreis Rendsburg', '32');
INSERT INTO banktransfer_blz VALUES(21464671, 'Raiffeisenbank', '33');
INSERT INTO banktransfer_blz VALUES(21480003, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(21500000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(21510600, 'Sydbank Filiale Flensburg', '19');
INSERT INTO banktransfer_blz VALUES(21520100, 'Union-Bank Flensburg', '06');
INSERT INTO banktransfer_blz VALUES(21530080, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21540060, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(21550050, 'Nord-Ostsee Sparkasse', 'C9');
INSERT INTO banktransfer_blz VALUES(21565316, 'Raiffeisenbank', '33');
INSERT INTO banktransfer_blz VALUES(21566356, 'Volks- und Raiffeisenbank', '33');
INSERT INTO banktransfer_blz VALUES(21567360, 'Raiffeisenbank Kleinjörl -alt-', '33');
INSERT INTO banktransfer_blz VALUES(21570011, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(21570024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(21580000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(21630060, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21630061, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21630062, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21630063, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21650110, 'Sparkasse Schleswig-Flensburg -alt-', '04');
INSERT INTO banktransfer_blz VALUES(21661719, 'VR Bank Flensburg-Schleswig', '32');
INSERT INTO banktransfer_blz VALUES(21690020, 'Schleswiger Volksbank, Volksbank Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(21700000, 'Bundesbank eh Husum', '09');
INSERT INTO banktransfer_blz VALUES(21730040, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21730042, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21730043, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21730044, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21730045, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21730046, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21740043, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(21741674, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(21741825, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(21750000, 'Nord-Ostsee Sparkasse', 'C8');
INSERT INTO banktransfer_blz VALUES(21751230, 'Spar- und Leihkasse zu Bredstedt', '00');
INSERT INTO banktransfer_blz VALUES(21762550, 'Volksbank-Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(21763542, 'VR Bank', '32');
INSERT INTO banktransfer_blz VALUES(21770011, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(21770024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(21791805, 'Sylter Bank', '33');
INSERT INTO banktransfer_blz VALUES(21791906, 'Föhr-Amrumer Bank', '32');
INSERT INTO banktransfer_blz VALUES(21830030, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21830032, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21830033, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21830034, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21830035, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(21840078, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(21841328, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(21851720, 'Alte Marner Sparkasse -alt-', 'A2');
INSERT INTO banktransfer_blz VALUES(21851830, 'Verbandssparkasse Meldorf -alt-', 'A2');
INSERT INTO banktransfer_blz VALUES(21852310, 'Sparkasse Hennstedt-Wesselburen', 'A2');
INSERT INTO banktransfer_blz VALUES(21860418, 'Raiffeisenbank Heide', '32');
INSERT INTO banktransfer_blz VALUES(21890022, 'Dithmarscher Volks- und Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(22130075, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(22140028, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(22141028, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(22141428, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(22141628, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(22150000, 'Sparkasse Elmshorn', 'A2');
INSERT INTO banktransfer_blz VALUES(22151410, 'Kreissparkasse Pinneberg -alt-', '00');
INSERT INTO banktransfer_blz VALUES(22151730, 'Stadtsparkasse Wedel', 'D6');
INSERT INTO banktransfer_blz VALUES(22163114, 'Raiffeisenbank Elbmarsch', '33');
INSERT INTO banktransfer_blz VALUES(22180000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(22181400, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(22190030, 'Volksbank Elmshorn', '48');
INSERT INTO banktransfer_blz VALUES(22191405, 'VR Bank Pinneberg', '48');
INSERT INTO banktransfer_blz VALUES(22200000, 'Bundesbank eh Itzehoe', '09');
INSERT INTO banktransfer_blz VALUES(22230020, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(22230022, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(22230023, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(22230025, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(22240073, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(22250020, 'Sparkasse Westholstein', 'A2');
INSERT INTO banktransfer_blz VALUES(22251580, 'Landsparkasse Schenefeld', 'A2');
INSERT INTO banktransfer_blz VALUES(22252050, 'Verbandssparkasse Wilster -alt-', 'A2');
INSERT INTO banktransfer_blz VALUES(22260136, 'Raiffeisenbank -alt-', '33');
INSERT INTO banktransfer_blz VALUES(22280000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(22290031, 'Volksbank Raiffeisenbank Itzehoe', '10');
INSERT INTO banktransfer_blz VALUES(23000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(23010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(23030000, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(23040022, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(23050000, 'HSH Nordbank Lübeck', 'C5');
INSERT INTO banktransfer_blz VALUES(23050101, 'Sparkasse zu Lübeck', '00');
INSERT INTO banktransfer_blz VALUES(23051030, 'Sparkasse Südholstein', 'A2');
INSERT INTO banktransfer_blz VALUES(23051610, 'Sparkasse Stormarn -alt-', 'A7');
INSERT INTO banktransfer_blz VALUES(23052750, 'Kreissparkasse Herzogtum Lauenburg', 'A2');
INSERT INTO banktransfer_blz VALUES(23061220, 'Raiffeisenbank Leezen', '32');
INSERT INTO banktransfer_blz VALUES(23062124, 'Raiffeisenbank', '33');
INSERT INTO banktransfer_blz VALUES(23062807, 'Volks- und Raiffeisenbank Mölln', '33');
INSERT INTO banktransfer_blz VALUES(23063129, 'Raiffeisenbank', '33');
INSERT INTO banktransfer_blz VALUES(23064107, 'Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(23070700, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(23070710, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(23080040, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(23089201, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(23090142, 'Volksbank Lübeck', '10');
INSERT INTO banktransfer_blz VALUES(23092502, 'Volksbank Lauenburg -alt-', '10');
INSERT INTO banktransfer_blz VALUES(23092620, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(24000000, 'Bundesbank eh Lüneburg', '09');
INSERT INTO banktransfer_blz VALUES(24030000, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(24040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(24050110, 'Sparkasse Lüneburg', '00');
INSERT INTO banktransfer_blz VALUES(24060300, 'Volksbank Nordheide', '28');
INSERT INTO banktransfer_blz VALUES(24061392, 'Volksbank Bleckede-Dahlenburg -alt-', '28');
INSERT INTO banktransfer_blz VALUES(24070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(24070075, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(24080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(24090041, 'Volksbank Lüneburg -alt-', '28');
INSERT INTO banktransfer_blz VALUES(24121000, 'Ritterschaftliches Kreditinstitut Stade', '09');
INSERT INTO banktransfer_blz VALUES(24130000, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(24140041, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(24150001, 'Stadtsparkasse Cuxhaven', '00');
INSERT INTO banktransfer_blz VALUES(24151005, 'Sparkasse Stade-Altes Land', '00');
INSERT INTO banktransfer_blz VALUES(24151116, 'Kreissparkasse Stade', '00');
INSERT INTO banktransfer_blz VALUES(24151235, 'Sparkasse Rotenburg-Bremervörde', '00');
INSERT INTO banktransfer_blz VALUES(24161594, 'Zevener Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(24162898, 'Spar- u Darlehnskasse Börde Lamstedt-Hechthausen', '28');
INSERT INTO banktransfer_blz VALUES(24180000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(24180001, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(24191015, 'Volksbank Stade-Cuxhaven', '28');
INSERT INTO banktransfer_blz VALUES(24191255, 'Volksbank Bremervörde', '28');
INSERT INTO banktransfer_blz VALUES(25000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(25010030, 'Postbank', '24');
INSERT INTO banktransfer_blz VALUES(25010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(25010424, 'Aareal Bank', '09');
INSERT INTO banktransfer_blz VALUES(25010600, 'Deutsche Hypothekenbank', '01');
INSERT INTO banktransfer_blz VALUES(25010700, 'Berlin-Hannoversche Hypothekenbank', '09');
INSERT INTO banktransfer_blz VALUES(25010900, 'Calenberger Kreditverein', '28');
INSERT INTO banktransfer_blz VALUES(25020200, 'BHF-BANK', '60');
INSERT INTO banktransfer_blz VALUES(25020600, 'Santander Consumer Bank', '41');
INSERT INTO banktransfer_blz VALUES(25020700, 'Hanseatic Bank', '16');
INSERT INTO banktransfer_blz VALUES(25030000, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(25040060, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(25040061, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(25040066, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(25050000, 'Norddeutsche Landesbank Girozentrale', '27');
INSERT INTO banktransfer_blz VALUES(25050055, 'ZVA Norddeutsche Landesbank SH', '09');
INSERT INTO banktransfer_blz VALUES(25050180, 'Sparkasse Hannover', 'A3');
INSERT INTO banktransfer_blz VALUES(25050299, 'Sparkasse Hannover -alt-', 'A3');
INSERT INTO banktransfer_blz VALUES(25055500, 'LBS-Norddeutsche Landesbausparkasse', '26');
INSERT INTO banktransfer_blz VALUES(25060000, 'DZ BANK', '09');
INSERT INTO banktransfer_blz VALUES(25060180, 'Bankhaus Hallbaum', 'C3');
INSERT INTO banktransfer_blz VALUES(25060701, 'Evangelische Kreditgenossenschaft -Filiale Hannover-', '32');
INSERT INTO banktransfer_blz VALUES(25069168, 'Volks- und Raiffeisenbank Leinebergland', '28');
INSERT INTO banktransfer_blz VALUES(25069262, 'Raiffeisen-Volksbank Neustadt', '28');
INSERT INTO banktransfer_blz VALUES(25069270, 'Volksbank Aller-Oker', '28');
INSERT INTO banktransfer_blz VALUES(25069370, 'Volksbank Vechelde-Wendeburg', '28');
INSERT INTO banktransfer_blz VALUES(25069384, 'Volksbank Lehre -alt-', '28');
INSERT INTO banktransfer_blz VALUES(25069503, 'Volksbank Diepholz-Barnstorf', '28');
INSERT INTO banktransfer_blz VALUES(25069830, 'Volksbank Derental -alt-', '28');
INSERT INTO banktransfer_blz VALUES(25070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(25070066, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(25070070, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(25070077, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(25070084, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(25070086, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(25080020, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(25080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(25089220, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(25090300, 'Bank für Schiffahrt (BFS) Fil d Ostfr VB Leer', '28');
INSERT INTO banktransfer_blz VALUES(25090500, 'Sparda-Bank Hannover', '81');
INSERT INTO banktransfer_blz VALUES(25090608, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(25090900, 'PSD Bank', '91');
INSERT INTO banktransfer_blz VALUES(25120510, 'Bank für Sozialwirtschaft', '09');
INSERT INTO banktransfer_blz VALUES(25120960, 'UniCredit Bank - HypoVereinsbank (ehem. Hypo)', '99');
INSERT INTO banktransfer_blz VALUES(25151270, 'Stadtsparkasse Barsinghausen', '00');
INSERT INTO banktransfer_blz VALUES(25151371, 'Stadtsparkasse Burgdorf', '00');
INSERT INTO banktransfer_blz VALUES(25152375, 'Kreissparkasse Fallingbostel in Walsrode', '00');
INSERT INTO banktransfer_blz VALUES(25152490, 'Stadtsparkasse Wunstorf', '00');
INSERT INTO banktransfer_blz VALUES(25161322, 'Volksbank Burgdorf-Celle -alt-', '28');
INSERT INTO banktransfer_blz VALUES(25162563, 'Volksbank Garbsen -alt-', '28');
INSERT INTO banktransfer_blz VALUES(25190001, 'Hannoversche Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(25190101, 'Lindener Volksbank -alt-', '28');
INSERT INTO banktransfer_blz VALUES(25191510, 'Volksbank -alt-', '10');
INSERT INTO banktransfer_blz VALUES(25193331, 'Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(25250001, 'Kreissparkasse Peine', '00');
INSERT INTO banktransfer_blz VALUES(25260010, 'Volksbank Peine', '28');
INSERT INTO banktransfer_blz VALUES(25400000, 'Bundesbank eh Hameln', '09');
INSERT INTO banktransfer_blz VALUES(25410111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(25410200, 'BHW Bausparkasse', '09');
INSERT INTO banktransfer_blz VALUES(25410300, 'BHW Allgemeine Bausparkasse -alt-', '09');
INSERT INTO banktransfer_blz VALUES(25430000, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(25440047, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(25450001, 'Stadtsparkasse Hameln', '00');
INSERT INTO banktransfer_blz VALUES(25450110, 'Sparkasse Weserbergland', '00');
INSERT INTO banktransfer_blz VALUES(25451345, 'Stadtsparkasse Bad Pyrmont', '00');
INSERT INTO banktransfer_blz VALUES(25451450, 'Sparkasse Weserbergland', '00');
INSERT INTO banktransfer_blz VALUES(25451655, 'Sparkasse Weserbergland', '00');
INSERT INTO banktransfer_blz VALUES(25462160, 'Volksbank Hameln-Stadthagen', '28');
INSERT INTO banktransfer_blz VALUES(25462680, 'Volksbank am Ith', '28');
INSERT INTO banktransfer_blz VALUES(25470024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(25470073, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(25471024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(25471073, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(25480021, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(25491071, 'Volksbank Bückeburg-Rinteln ehem VB Rinteln', '28');
INSERT INTO banktransfer_blz VALUES(25491273, 'Volksbank Aerzen', '28');
INSERT INTO banktransfer_blz VALUES(25491744, 'Volksbank Bad Münder', '28');
INSERT INTO banktransfer_blz VALUES(25541426, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(25551480, 'Sparkasse Schaumburg', '00');
INSERT INTO banktransfer_blz VALUES(25562308, 'Volksbank Nordschaumburg -alt-', '28');
INSERT INTO banktransfer_blz VALUES(25562604, 'Volksbank Kirchhorsten -alt-', '28');
INSERT INTO banktransfer_blz VALUES(25591413, 'Volksbank in Schaumburg', '28');
INSERT INTO banktransfer_blz VALUES(25591748, 'Volksbank Obernkirchen -alt-', '28');
INSERT INTO banktransfer_blz VALUES(25621327, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(25641302, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(25650106, 'Sparkasse Nienburg', '00');
INSERT INTO banktransfer_blz VALUES(25651325, 'Kreissparkasse Grafschaft Diepholz', '00');
INSERT INTO banktransfer_blz VALUES(25662540, 'Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(25663584, 'Volksbank Grafschaft Hoya', '28');
INSERT INTO banktransfer_blz VALUES(25690009, 'Volksbank Nienburg', '28');
INSERT INTO banktransfer_blz VALUES(25691633, 'Volksbank Sulingen', '28');
INSERT INTO banktransfer_blz VALUES(25700000, 'Bundesbank eh Celle', '09');
INSERT INTO banktransfer_blz VALUES(25730000, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(25740061, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(25750001, 'Sparkasse Celle', '00');
INSERT INTO banktransfer_blz VALUES(25761894, 'Volksbank Wittingen-Klötze', '28');
INSERT INTO banktransfer_blz VALUES(25770024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(25770069, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(25780022, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(25791516, 'Volksbank Hankensbüttel-Wahrenholz', '28');
INSERT INTO banktransfer_blz VALUES(25791635, 'Volksbank Südheide', '28');
INSERT INTO banktransfer_blz VALUES(25800000, 'Bundesbank eh Uelzen', '09');
INSERT INTO banktransfer_blz VALUES(25840048, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(25841403, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(25841708, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(25850110, 'Sparkasse Uelzen Lüchow-Dannenberg', '00');
INSERT INTO banktransfer_blz VALUES(25851335, 'Sparkasse Uelzen Lüchow-Dannenberg', '00');
INSERT INTO banktransfer_blz VALUES(25851660, 'Kreissparkasse Soltau', '00');
INSERT INTO banktransfer_blz VALUES(25861395, 'Volksbank Dannenberg -alt-', '28');
INSERT INTO banktransfer_blz VALUES(25861990, 'Volksbank Clenze-Hitzacker', '28');
INSERT INTO banktransfer_blz VALUES(25862292, 'Volksbank Uelzen-Salzwedel', '28');
INSERT INTO banktransfer_blz VALUES(25863489, 'Volksbank Osterburg-Lüchow-Dannenberg', '28');
INSERT INTO banktransfer_blz VALUES(25891483, 'Volksbank Osterburg-Lüchow-Dannenberg -alt-', '28');
INSERT INTO banktransfer_blz VALUES(25891636, 'Volksbank Lüneburger Heide', '28');
INSERT INTO banktransfer_blz VALUES(25900000, 'Bundesbank eh Hildesheim', '09');
INSERT INTO banktransfer_blz VALUES(25910111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(25930000, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(25940033, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(25950001, 'Stadtsparkasse Hildesheim -alt-', 'B1');
INSERT INTO banktransfer_blz VALUES(25950130, 'Sparkasse Hildesheim', 'B1');
INSERT INTO banktransfer_blz VALUES(25960192, 'Bankhaus Hallbaum', 'C3');
INSERT INTO banktransfer_blz VALUES(25970024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(25970074, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(25971024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(25971071, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(25980027, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(25990011, 'Volksbank Hildesheim', '28');
INSERT INTO banktransfer_blz VALUES(25991528, 'Volksbank Hildesheimer Börde', '28');
INSERT INTO banktransfer_blz VALUES(25991911, 'Volksbank Sarstedt -alt-', '28');
INSERT INTO banktransfer_blz VALUES(26000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(26010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(26030000, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(26040030, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(26050001, 'Sparkasse Göttingen', '00');
INSERT INTO banktransfer_blz VALUES(26051260, 'Sparkasse Duderstadt', '00');
INSERT INTO banktransfer_blz VALUES(26051450, 'Kreis- und Stadtsparkasse Münden', '00');
INSERT INTO banktransfer_blz VALUES(26060184, 'Bankhaus Hallbaum', 'C3');
INSERT INTO banktransfer_blz VALUES(26061291, 'Volksbank Mitte', '48');
INSERT INTO banktransfer_blz VALUES(26061556, 'Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(26062433, 'Volksbank Dransfeld', '32');
INSERT INTO banktransfer_blz VALUES(26062575, 'Raiffeisenbank', '28');
INSERT INTO banktransfer_blz VALUES(26070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(26070072, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(26080024, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(26090050, 'Volksbank Göttingen', '28');
INSERT INTO banktransfer_blz VALUES(26240039, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(26250001, 'Kreis-Sparkasse Northeim', '00');
INSERT INTO banktransfer_blz VALUES(26251425, 'Sparkasse Einbeck', '00');
INSERT INTO banktransfer_blz VALUES(26261396, 'Volksbank Dassel', '28');
INSERT INTO banktransfer_blz VALUES(26261492, 'Volksbank Einbeck', '28');
INSERT INTO banktransfer_blz VALUES(26261693, 'Volksbank Solling', '28');
INSERT INTO banktransfer_blz VALUES(26271424, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(26271471, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(26280020, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(26281420, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(26340056, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(26341072, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(26350001, 'Stadtsparkasse Osterode', '00');
INSERT INTO banktransfer_blz VALUES(26351015, 'Sparkasse Osterode am Harz', '00');
INSERT INTO banktransfer_blz VALUES(26351445, 'Stadtsparkasse Bad Sachsa', '00');
INSERT INTO banktransfer_blz VALUES(26361299, 'Volksbank Oberharz', '28');
INSERT INTO banktransfer_blz VALUES(26500000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(26510111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(26520017, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(26521703, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(26522319, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(26540070, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(26550105, 'Sparkasse Osnabrück', '00');
INSERT INTO banktransfer_blz VALUES(26551540, 'Kreissparkasse Bersenbrück', '00');
INSERT INTO banktransfer_blz VALUES(26552286, 'Kreissparkasse Melle', '00');
INSERT INTO banktransfer_blz VALUES(26560189, 'Bankhaus Hallbaum', 'C3');
INSERT INTO banktransfer_blz VALUES(26560625, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(26562490, 'Volksbank Bad Laer-Borgloh-Hilter-Melle', '28');
INSERT INTO banktransfer_blz VALUES(26562694, 'Volksbank Wittlage -alt-', '28');
INSERT INTO banktransfer_blz VALUES(26563960, 'Volksbank Bramgau-Wittlage', '28');
INSERT INTO banktransfer_blz VALUES(26565928, 'Volksbank GMHütte-Hagen-Bissendorf', '28');
INSERT INTO banktransfer_blz VALUES(26566939, 'Volksbank Osnabrücker Nordland', '28');
INSERT INTO banktransfer_blz VALUES(26567943, 'VR-Bank im Altkreis Bersenbrück', '28');
INSERT INTO banktransfer_blz VALUES(26568924, 'Volksbank Hilter-Bad Laer -alt-', '28');
INSERT INTO banktransfer_blz VALUES(26570024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(26570090, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(26580070, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(26589210, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(26590025, 'Volksbank Osnabrück', '28');
INSERT INTO banktransfer_blz VALUES(26600000, 'Bundesbank eh Lingen (Ems)', '09');
INSERT INTO banktransfer_blz VALUES(26620010, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(26621413, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(26640049, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(26650001, 'Sparkasse Emsland', '00');
INSERT INTO banktransfer_blz VALUES(26660060, 'Volksbank Lingen', '28');
INSERT INTO banktransfer_blz VALUES(26661380, 'Volksbank Haselünne', '28');
INSERT INTO banktransfer_blz VALUES(26661494, 'Emsländische Volksbank Meppen', '28');
INSERT INTO banktransfer_blz VALUES(26661912, 'Volksbank Süd-Emsland -alt-', '28');
INSERT INTO banktransfer_blz VALUES(26662932, 'Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(26691213, 'Volksbank Haren Fil d Ostfriesischen VB', '28');
INSERT INTO banktransfer_blz VALUES(26720028, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(26740044, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(26750001, 'Kreissparkasse Grafschaft Bentheim zu Nordhorn', '00');
INSERT INTO banktransfer_blz VALUES(26760005, 'Raiffeisen- und Volksbank Nordhorn -alt-', '28');
INSERT INTO banktransfer_blz VALUES(26770024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(26770095, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(26800000, 'Bundesbank eh Halberstadt', '09');
INSERT INTO banktransfer_blz VALUES(26840032, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(26850001, 'Sparkasse Goslar/Harz', '00');
INSERT INTO banktransfer_blz VALUES(26851410, 'Kreissparkasse Clausthal-Zellerfeld', '00');
INSERT INTO banktransfer_blz VALUES(26851620, 'Sparkasse Salzgitter', '22');
INSERT INTO banktransfer_blz VALUES(26870024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(26870032, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(26880063, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(26890019, 'Volksbank Nordharz', '28');
INSERT INTO banktransfer_blz VALUES(26891484, 'Volksbank im Harz', '28');
INSERT INTO banktransfer_blz VALUES(26941053, 'Commerzbank Wolfsburg', '13');
INSERT INTO banktransfer_blz VALUES(26951311, 'Sparkasse Gifhorn-Wolfsburg', '00');
INSERT INTO banktransfer_blz VALUES(26971024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(26971038, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(26981062, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(26989221, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(26991066, 'Volksbank Braunschweig Wolfsburg', '50');
INSERT INTO banktransfer_blz VALUES(27000000, 'Bundesbank eh Braunschweig', '09');
INSERT INTO banktransfer_blz VALUES(27010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(27010200, 'VON ESSEN Bankgesellschaft', '09');
INSERT INTO banktransfer_blz VALUES(27020000, 'Volkswagen Bank', 'D8');
INSERT INTO banktransfer_blz VALUES(27020001, 'Audi Bank Zndl d Volkswagen Bank', 'D8');
INSERT INTO banktransfer_blz VALUES(27020003, 'Skoda Bank', 'D8');
INSERT INTO banktransfer_blz VALUES(27020004, 'AutoEuropa Bank', 'D8');
INSERT INTO banktransfer_blz VALUES(27020800, 'Seat Bank Zndl d Volkswagen Bank', 'D8');
INSERT INTO banktransfer_blz VALUES(27030000, 'UniCredit Bank - HypoVereinsbank (ex VereinWest)', '68');
INSERT INTO banktransfer_blz VALUES(27032500, 'Bankhaus C. L. Seeliger', '09');
INSERT INTO banktransfer_blz VALUES(27040080, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(27062290, 'Volksbank Börßum-Hornburg', '28');
INSERT INTO banktransfer_blz VALUES(27070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(27070030, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(27070031, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(27070034, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(27070041, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(27070042, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(27070043, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(27070079, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(27072524, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(27072537, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(27072724, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(27072736, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(27080060, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(27089221, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(27090077, 'Volksbank Braunschweig -alt-', '50');
INSERT INTO banktransfer_blz VALUES(27090618, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(27090900, 'PSD Bank', '91');
INSERT INTO banktransfer_blz VALUES(27092555, 'Volksbank Wolfenbüttel-Salzgitter', '28');
INSERT INTO banktransfer_blz VALUES(27131300, 'Bankhaus Rautenschlein', '32');
INSERT INTO banktransfer_blz VALUES(27190082, 'Volksbank Helmstedt', '28');
INSERT INTO banktransfer_blz VALUES(27240004, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(27290087, 'Volksbank Weserbergland', '47');
INSERT INTO banktransfer_blz VALUES(27893215, 'Vereinigte Volksbank', '32');
INSERT INTO banktransfer_blz VALUES(27893359, 'Volksbank Braunlage', '48');
INSERT INTO banktransfer_blz VALUES(27893760, 'Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(28000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(28010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(28020050, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28021002, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28021301, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28021504, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28021623, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28021705, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28021906, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28022015, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28022412, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28022511, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28022620, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28022822, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28023224, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28023325, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28030300, 'Bankhaus W. Fortmann & Söhne', '28');
INSERT INTO banktransfer_blz VALUES(28040046, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(28042865, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(28050100, 'Landessparkasse Oldenburg', '00');
INSERT INTO banktransfer_blz VALUES(28060228, 'Raiffeisenbank Oldenburg', '28');
INSERT INTO banktransfer_blz VALUES(28061410, 'Raiffeisenbank Wesermarsch-Süd', '28');
INSERT INTO banktransfer_blz VALUES(28061501, 'Volksbank Cloppenburg', '28');
INSERT INTO banktransfer_blz VALUES(28061679, 'Volksbank Dammer Berge', '28');
INSERT INTO banktransfer_blz VALUES(28061822, 'Volksbank Oldenburg', '28');
INSERT INTO banktransfer_blz VALUES(28062165, 'Raiffeisenbank Rastede', '28');
INSERT INTO banktransfer_blz VALUES(28062249, 'Volksbank Ganderkesee-Hude', '28');
INSERT INTO banktransfer_blz VALUES(28062560, 'Volksbank Lohne-Mühlen', '28');
INSERT INTO banktransfer_blz VALUES(28062740, 'Volksbank Bookholzberg-Lemwerder', '28');
INSERT INTO banktransfer_blz VALUES(28062913, 'Volksbank Bösel', '28');
INSERT INTO banktransfer_blz VALUES(28063253, 'Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(28063526, 'Volksbank Essen-Cappeln', '28');
INSERT INTO banktransfer_blz VALUES(28063607, 'Volksbank Bakum', '28');
INSERT INTO banktransfer_blz VALUES(28064090, 'VR Bank Dinklage-Steinfeld -alt-', '28');
INSERT INTO banktransfer_blz VALUES(28064179, 'Volksbank Vechta', '28');
INSERT INTO banktransfer_blz VALUES(28064241, 'Raiffeisen-Volksbank Varel-Nordenham', '28');
INSERT INTO banktransfer_blz VALUES(28065061, 'Volksbank Löningen', '28');
INSERT INTO banktransfer_blz VALUES(28065108, 'VR-Bank Dinklage-Steinfeld', '28');
INSERT INTO banktransfer_blz VALUES(28065286, 'Raiffeisenbank Scharrel', '28');
INSERT INTO banktransfer_blz VALUES(28066103, 'Volksbank Visbek', '28');
INSERT INTO banktransfer_blz VALUES(28066214, 'Volksbank Wildeshauser Geest', '28');
INSERT INTO banktransfer_blz VALUES(28066620, 'Spar- und Darlehnskasse Friesoythe', '28');
INSERT INTO banktransfer_blz VALUES(28067068, 'Volksbank Neuenkirchen-Vörden', '28');
INSERT INTO banktransfer_blz VALUES(28067170, 'Raiffeisen-Volksbank Delmenhorst-Schierbrok', '28');
INSERT INTO banktransfer_blz VALUES(28067257, 'Volksbank Lastrup', '28');
INSERT INTO banktransfer_blz VALUES(28068218, 'Raiffeisenbank Butjadingen-Abbehausen', '28');
INSERT INTO banktransfer_blz VALUES(28069052, 'Raiffeisenbank Strücklingen-Idafehn', '28');
INSERT INTO banktransfer_blz VALUES(28069092, 'VR Bank Oldenburg Land West', '28');
INSERT INTO banktransfer_blz VALUES(28069109, 'Volksbank Emstek', '28');
INSERT INTO banktransfer_blz VALUES(28069128, 'Raiffeisenbank Garrel', '28');
INSERT INTO banktransfer_blz VALUES(28069138, 'VR Bank Oldenburg Land West', '28');
INSERT INTO banktransfer_blz VALUES(28069293, 'Volksbank Obergrafschaft -alt-', '28');
INSERT INTO banktransfer_blz VALUES(28069381, 'Hümmlinger Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(28069706, 'Volksbank Nordhümmling', '28');
INSERT INTO banktransfer_blz VALUES(28069755, 'Raiffeisenbank Oldersum', '28');
INSERT INTO banktransfer_blz VALUES(28069773, 'Raiffeisenbank Wiesedermeer-Wiesede-Marcardsm', '28');
INSERT INTO banktransfer_blz VALUES(28069878, 'Raiffeisenbank Emsland-Mitte', '28');
INSERT INTO banktransfer_blz VALUES(28069926, 'Volksbank Niedergrafschaft', '28');
INSERT INTO banktransfer_blz VALUES(28069930, 'Volksbank Langen-Gersten', '28');
INSERT INTO banktransfer_blz VALUES(28069935, 'Raiffeisenbank Lorup', '28');
INSERT INTO banktransfer_blz VALUES(28069955, 'Volksbank Uelsen', '28');
INSERT INTO banktransfer_blz VALUES(28069956, 'Grafschafter Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(28069991, 'Volksbank Emstal', '28');
INSERT INTO banktransfer_blz VALUES(28069994, 'Volksbank Süd-Emsland', '28');
INSERT INTO banktransfer_blz VALUES(28070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(28070057, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(28090633, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(28200000, 'Bundesbank eh Wilhelmshaven', '09');
INSERT INTO banktransfer_blz VALUES(28220026, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28222208, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28222621, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28240023, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(28250110, 'Sparkasse Wilhelmshaven', '00');
INSERT INTO banktransfer_blz VALUES(28252760, 'Kreissparkasse Wittmund', '00');
INSERT INTO banktransfer_blz VALUES(28261946, 'Raiffeisenbank Sande-Wangerland', '28');
INSERT INTO banktransfer_blz VALUES(28262254, 'Volksbank Jever', '10');
INSERT INTO banktransfer_blz VALUES(28262481, 'Raiffeisenbank Sande-Wangerland -alt-', '28');
INSERT INTO banktransfer_blz VALUES(28262673, 'Raiffeisen-Volksbank Varel-Nordenham', '28');
INSERT INTO banktransfer_blz VALUES(28270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(28270056, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(28280012, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(28290063, 'Volksbank Wilhelmshaven', '00');
INSERT INTO banktransfer_blz VALUES(28291551, 'Volksbank Esens', '28');
INSERT INTO banktransfer_blz VALUES(28320014, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28321816, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28350000, 'Sparkasse Aurich-Norden', '00');
INSERT INTO banktransfer_blz VALUES(28361592, 'Raiffeisen-Volksbank Fresena', '28');
INSERT INTO banktransfer_blz VALUES(28420007, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28421030, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28440037, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(28450000, 'Sparkasse Emden', '00');
INSERT INTO banktransfer_blz VALUES(28470024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(28470091, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(28490073, 'Raiffeisen-Volksbank Emden-Pewsum -alt-', '28');
INSERT INTO banktransfer_blz VALUES(28500000, 'Bundesbank eh Leer', '09');
INSERT INTO banktransfer_blz VALUES(28520009, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28521518, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(28540034, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(28550000, 'Sparkasse LeerWittmund', '00');
INSERT INTO banktransfer_blz VALUES(28562297, 'Raiffeisen-Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(28562716, 'Raiffeisenbank Flachsmeer', '28');
INSERT INTO banktransfer_blz VALUES(28562863, 'Raiffeisenbank Moormerland', '28');
INSERT INTO banktransfer_blz VALUES(28563749, 'Raiffeisenbank', '28');
INSERT INTO banktransfer_blz VALUES(28563865, 'Ostfriesische Volksbank Leer', '28');
INSERT INTO banktransfer_blz VALUES(28570024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(28570092, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(28590075, 'Ostfriesische Volksbank Leer', '28');
INSERT INTO banktransfer_blz VALUES(28591579, 'Volksbank Papenburg Fil d. Ostfries. VB Leer', '28');
INSERT INTO banktransfer_blz VALUES(28591654, 'Volksbank Westrhauderfehn', '28');
INSERT INTO banktransfer_blz VALUES(29000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(29010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(29010400, 'Deutsche Schiffsbank', '09');
INSERT INTO banktransfer_blz VALUES(29020000, 'Bankhaus Neelmeyer', '45');
INSERT INTO banktransfer_blz VALUES(29020100, 'KBC Bank Deutschland', '18');
INSERT INTO banktransfer_blz VALUES(29020200, 'NordFinanz Bank', '09');
INSERT INTO banktransfer_blz VALUES(29020400, 'Deutsche Factoring Bank', '09');
INSERT INTO banktransfer_blz VALUES(29030400, 'Plump, Carl F. - & Co', 'C4');
INSERT INTO banktransfer_blz VALUES(29040060, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(29040061, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(29040090, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(29050000, 'Bremer Landesbank', '29');
INSERT INTO banktransfer_blz VALUES(29050101, 'Sparkasse Bremen', '00');
INSERT INTO banktransfer_blz VALUES(29070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(29070050, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(29070051, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(29070052, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(29070058, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(29070059, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(29080010, 'Commerzbank vormals Bremer Bank (Dresdner Bank)', '76');
INSERT INTO banktransfer_blz VALUES(29089210, 'Commerzbank vormals Bremer Bank (Dresdner Bank) ITGK', '09');
INSERT INTO banktransfer_blz VALUES(29090605, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(29090900, 'PSD Bank Nord', '91');
INSERT INTO banktransfer_blz VALUES(29121731, 'Oldenburgische Landesbank AG', '61');
INSERT INTO banktransfer_blz VALUES(29151700, 'Kreissparkasse Syke', '00');
INSERT INTO banktransfer_blz VALUES(29152300, 'Kreissparkasse Osterholz', '00');
INSERT INTO banktransfer_blz VALUES(29152550, 'Zweckverbandssparkasse Scheeßel', '00');
INSERT INTO banktransfer_blz VALUES(29152670, 'Kreissparkasse Verden', '00');
INSERT INTO banktransfer_blz VALUES(29162394, 'Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(29162453, 'Volksbank Schwanewede', '28');
INSERT INTO banktransfer_blz VALUES(29162697, 'Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(29165545, 'Volksbank Oyten', '28');
INSERT INTO banktransfer_blz VALUES(29165681, 'Volksbank Sottrum', '28');
INSERT INTO banktransfer_blz VALUES(29166568, 'Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(29167624, 'Volksbank Syke', '28');
INSERT INTO banktransfer_blz VALUES(29172624, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(29172655, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(29190024, 'Bremische Volksbank', '28');
INSERT INTO banktransfer_blz VALUES(29190330, 'Volksbank Bremen-Nord', '28');
INSERT INTO banktransfer_blz VALUES(29200000, 'Bundesbank eh Bremerhaven', '09');
INSERT INTO banktransfer_blz VALUES(29210111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(29240024, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(29250000, 'Sparkasse Bremerhaven', '10');
INSERT INTO banktransfer_blz VALUES(29250150, 'Kreissparkasse Wesermünde-Hadeln', '10');
INSERT INTO banktransfer_blz VALUES(29262646, 'Spar- und Darlehnskasse Langen-Neuenwalde', '28');
INSERT INTO banktransfer_blz VALUES(29262722, 'Volksbank Geeste-Nord', '28');
INSERT INTO banktransfer_blz VALUES(29265747, 'Volksbank Bremerhaven-Cuxland', '28');
INSERT INTO banktransfer_blz VALUES(29280011, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(29290034, 'Volksbank Bremerhaven-Wesermünde -alt-', '28');
INSERT INTO banktransfer_blz VALUES(30000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(30010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(30010400, 'IKB Deutsche Industriebank', '09');
INSERT INTO banktransfer_blz VALUES(30010444, 'IKB Direkt - IKB Deutsche Industriebank', '09');
INSERT INTO banktransfer_blz VALUES(30010700, 'The Bank of Tokyo-Mitsubishi UFJ, Ltd.', '09');
INSERT INTO banktransfer_blz VALUES(30020300, 'Santander Consumer Bank', '10');
INSERT INTO banktransfer_blz VALUES(30020500, 'BHF-BANK', '60');
INSERT INTO banktransfer_blz VALUES(30020700, 'Mizuho Corporate Bank Ltd Fil Düsseldorf', '09');
INSERT INTO banktransfer_blz VALUES(30020900, 'TARGOBANK', '57');
INSERT INTO banktransfer_blz VALUES(30022000, 'NRW.BANK', '08');
INSERT INTO banktransfer_blz VALUES(30030100, 'S Broker Wiesbaden', '56');
INSERT INTO banktransfer_blz VALUES(30030400, 'FXdirekt Bank', '00');
INSERT INTO banktransfer_blz VALUES(30030500, 'C&A Bank', '05');
INSERT INTO banktransfer_blz VALUES(30030600, 'ETRIS Bank', '06');
INSERT INTO banktransfer_blz VALUES(30030880, 'HSBC Trinkaus & Burkhardt', '56');
INSERT INTO banktransfer_blz VALUES(30030900, 'Merck Finck & Co', '00');
INSERT INTO banktransfer_blz VALUES(30040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(30040048, 'Commerzbank GF-D48', '13');
INSERT INTO banktransfer_blz VALUES(30040060, 'Commerzbank Gf 660', '09');
INSERT INTO banktransfer_blz VALUES(30040061, 'Commerzbank Gf 661', '09');
INSERT INTO banktransfer_blz VALUES(30040062, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(30040063, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(30050000, 'WestLB Düsseldorf', '08');
INSERT INTO banktransfer_blz VALUES(30050110, 'Stadtsparkasse Düsseldorf', '00');
INSERT INTO banktransfer_blz VALUES(30052525, 'NRW.BANK', '08');
INSERT INTO banktransfer_blz VALUES(30060010, 'WGZ Bank', '44');
INSERT INTO banktransfer_blz VALUES(30060601, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(30060992, 'PSD Bank Rhein-Ruhr', '91');
INSERT INTO banktransfer_blz VALUES(30070010, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(30070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(30080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(30080005, 'Commerzbank vormals Dresdner Bank Zw 05', '76');
INSERT INTO banktransfer_blz VALUES(30080022, 'Commerzbank vormals Dresdner Bank Ztv 22', '76');
INSERT INTO banktransfer_blz VALUES(30080038, 'Commerzbank vormals Dresdner Bank Zw 38', '76');
INSERT INTO banktransfer_blz VALUES(30080041, 'Commerzbank vormals Dresdner Bank Zw 41', '76');
INSERT INTO banktransfer_blz VALUES(30080053, 'Commerzbank vormals Dresdner Bank Zw 53', '76');
INSERT INTO banktransfer_blz VALUES(30080055, 'Commerzbank vormals Dresdner Bank Zw 55', '76');
INSERT INTO banktransfer_blz VALUES(30080057, 'Commerzbank vormals Dresdner Bank Gf ZW 57', '76');
INSERT INTO banktransfer_blz VALUES(30080061, 'Commerzbank vormals Dresdner Bank Zw 61', '76');
INSERT INTO banktransfer_blz VALUES(30080074, 'Commerzbank vormals Dresdner Bank Zw 74', '76');
INSERT INTO banktransfer_blz VALUES(30080080, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 3', '09');
INSERT INTO banktransfer_blz VALUES(30080081, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 4', '09');
INSERT INTO banktransfer_blz VALUES(30080082, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 5', '09');
INSERT INTO banktransfer_blz VALUES(30080083, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 6', '09');
INSERT INTO banktransfer_blz VALUES(30080084, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 7', '09');
INSERT INTO banktransfer_blz VALUES(30080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 8', '09');
INSERT INTO banktransfer_blz VALUES(30080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 9', '09');
INSERT INTO banktransfer_blz VALUES(30080087, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 10', '09');
INSERT INTO banktransfer_blz VALUES(30080088, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 11', '09');
INSERT INTO banktransfer_blz VALUES(30080089, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 12', '09');
INSERT INTO banktransfer_blz VALUES(30080095, 'Commerzbank vormals Dresdner Bank Zw 95', '76');
INSERT INTO banktransfer_blz VALUES(30089300, 'Commerzbank vormals Dresdner Bank ITGK I', '09');
INSERT INTO banktransfer_blz VALUES(30089302, 'Commerzbank vormals Dresdner Bank ITGK II', '09');
INSERT INTO banktransfer_blz VALUES(30110300, 'Sumitomo Mitsui Banking Corporation', '09');
INSERT INTO banktransfer_blz VALUES(30120400, 'The Royal Bank of Scotland, Niederlassung Deutschland', '10');
INSERT INTO banktransfer_blz VALUES(30120500, 'KBC Bank Deutschland', '18');
INSERT INTO banktransfer_blz VALUES(30120764, 'UniCredit Bank - HypoVereinsbank Ndl 450 Düs', '99');
INSERT INTO banktransfer_blz VALUES(30130100, 'Demir-Halk Bank (Nederland)', '09');
INSERT INTO banktransfer_blz VALUES(30130200, 'GarantiBank International', '09');
INSERT INTO banktransfer_blz VALUES(30130600, 'Isbank Fil Düsseldorf', '06');
INSERT INTO banktransfer_blz VALUES(30130800, 'Düsseldorfer Hypothekenbank', '09');
INSERT INTO banktransfer_blz VALUES(30150001, 'SI/WLB Verrechnung Düsseldorf', '09');
INSERT INTO banktransfer_blz VALUES(30150200, 'Kreissparkasse Düsseldorf', '00');
INSERT INTO banktransfer_blz VALUES(30160213, 'Volksbank Düsseldorf Neuss', '06');
INSERT INTO banktransfer_blz VALUES(30220190, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(30351220, 'Stadt-Sparkasse Haan', '00');
INSERT INTO banktransfer_blz VALUES(30520000, 'RCI Banque S.A. NL Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(30530000, 'Bankhaus Werhahn', '09');
INSERT INTO banktransfer_blz VALUES(30530500, 'Bank11 für Privatkunden und Handel, Neuss', '28');
INSERT INTO banktransfer_blz VALUES(30550000, 'Sparkasse Neuss', '00');
INSERT INTO banktransfer_blz VALUES(30551240, 'Stadtsparkasse Kaarst-Büttgen -alt-', '00');
INSERT INTO banktransfer_blz VALUES(30560090, 'Volksbank Neuss -alt-', '06');
INSERT INTO banktransfer_blz VALUES(30560548, 'VR Bank', '06');
INSERT INTO banktransfer_blz VALUES(31000000, 'Bundesbank eh Mönchengladbach', '09');
INSERT INTO banktransfer_blz VALUES(31010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(31010833, 'Santander Consumer Bank', '09');
INSERT INTO banktransfer_blz VALUES(31040015, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(31040060, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(31040061, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(31050000, 'Stadtsparkasse Mönchengladbach', '00');
INSERT INTO banktransfer_blz VALUES(31060181, 'Gladbacher Bank von 1922', '06');
INSERT INTO banktransfer_blz VALUES(31060517, 'Volksbank Mönchengladbach', '06');
INSERT INTO banktransfer_blz VALUES(31062154, 'Volksbank Brüggen-Nettetal', '06');
INSERT INTO banktransfer_blz VALUES(31062553, 'Volksbank Schwalmtal', '06');
INSERT INTO banktransfer_blz VALUES(31070001, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(31070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(31080015, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(31080061, 'Commerzbank vormals Dresdner Bank Zw 61', '76');
INSERT INTO banktransfer_blz VALUES(31251220, 'Kreissparkasse Heinsberg in Erkelenz', '00');
INSERT INTO banktransfer_blz VALUES(31261282, 'Volksbank Erkelenz', '06');
INSERT INTO banktransfer_blz VALUES(31263359, 'Raiffeisenbank Erkelenz', '06');
INSERT INTO banktransfer_blz VALUES(31460290, 'Volksbank Viersen', '06');
INSERT INTO banktransfer_blz VALUES(31470004, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(31470024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(32000000, 'Bundesbank eh Krefeld', '09');
INSERT INTO banktransfer_blz VALUES(32040024, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(32050000, 'Sparkasse Krefeld', '00');
INSERT INTO banktransfer_blz VALUES(32051370, 'Sparkasse Geldern -alt-', '00');
INSERT INTO banktransfer_blz VALUES(32051996, 'Sparkasse der Stadt Straelen', '00');
INSERT INTO banktransfer_blz VALUES(32060362, 'Volksbank Krefeld', '06');
INSERT INTO banktransfer_blz VALUES(32061384, 'Volksbank an der Niers', '06');
INSERT INTO banktransfer_blz VALUES(32061414, 'Volksbank Kempen-Grefrath', '06');
INSERT INTO banktransfer_blz VALUES(32070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(32070080, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(32080010, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(32250050, 'Verbandssparkasse Goch', '00');
INSERT INTO banktransfer_blz VALUES(32400000, 'Bundesbank eh Kleve, Niederrhein', '09');
INSERT INTO banktransfer_blz VALUES(32440023, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(32450000, 'Sparkasse Kleve', '00');
INSERT INTO banktransfer_blz VALUES(32460422, 'Volksbank Kleverland', '06');
INSERT INTO banktransfer_blz VALUES(32470024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(32470077, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(33000000, 'Bundesbank eh Wuppertal', '09');
INSERT INTO banktransfer_blz VALUES(33010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(33020000, 'akf bank', '09');
INSERT INTO banktransfer_blz VALUES(33020190, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(33040001, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(33040310, 'Commerzbank Zw 117', '13');
INSERT INTO banktransfer_blz VALUES(33050000, 'Stadtsparkasse Wuppertal', '00');
INSERT INTO banktransfer_blz VALUES(33060098, 'Credit- und Volksbank Wuppertal', '06');
INSERT INTO banktransfer_blz VALUES(33060592, 'Sparda-Bank West', '51');
INSERT INTO banktransfer_blz VALUES(33060616, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(33070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(33070090, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(33080001, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(33080030, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(33080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(33080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 3', '09');
INSERT INTO banktransfer_blz VALUES(33080087, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 4', '09');
INSERT INTO banktransfer_blz VALUES(33080088, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 5', '09');
INSERT INTO banktransfer_blz VALUES(33440035, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(33450000, 'Sparkasse Hilden-Ratingen-Velbert', '00');
INSERT INTO banktransfer_blz VALUES(33451220, 'Sparkasse Heiligenhaus -alt-', '00');
INSERT INTO banktransfer_blz VALUES(34040049, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(34050000, 'Stadtsparkasse Remscheid', '00');
INSERT INTO banktransfer_blz VALUES(34051350, 'Sparkasse Radevormwald-Hückeswagen', '00');
INSERT INTO banktransfer_blz VALUES(34051570, 'Stadtsparkasse Wermelskirchen', '00');
INSERT INTO banktransfer_blz VALUES(34060094, 'Volksbank Remscheid-Solingen Remscheid-Lennep', '00');
INSERT INTO banktransfer_blz VALUES(34070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(34070093, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(34080031, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(34240050, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(34250000, 'Stadt-Sparkasse Solingen', '00');
INSERT INTO banktransfer_blz VALUES(34270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(34270094, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(34280032, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(35000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(35010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(35020030, 'National-Bank', '10');
INSERT INTO banktransfer_blz VALUES(35040038, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(35050000, 'Sparkasse Duisburg', '00');
INSERT INTO banktransfer_blz VALUES(35060190, 'Bank für Kirche und Diakonie - KD-Bank', '06');
INSERT INTO banktransfer_blz VALUES(35060386, 'Volksbank Rhein-Ruhr', '40');
INSERT INTO banktransfer_blz VALUES(35060632, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(35070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(35070030, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(35080070, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(35080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(35080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(35080087, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 3', '09');
INSERT INTO banktransfer_blz VALUES(35080088, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 4', '09');
INSERT INTO banktransfer_blz VALUES(35080089, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 5', '09');
INSERT INTO banktransfer_blz VALUES(35090300, 'Bank für Schiffahrt (BFS) Fil d Ostfr VB Leer', '09');
INSERT INTO banktransfer_blz VALUES(35211012, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(35251000, 'Sparkasse Dinslaken-Voerde-Hünxe', '00');
INSERT INTO banktransfer_blz VALUES(35261248, 'Volksbank Dinslaken', '06');
INSERT INTO banktransfer_blz VALUES(35450000, 'Sparkasse am Niederrhein', 'A2');
INSERT INTO banktransfer_blz VALUES(35451460, 'Sparkasse Neukirchen-Vluyn', '00');
INSERT INTO banktransfer_blz VALUES(35451775, 'Sparkasse Rheinberg', '00');
INSERT INTO banktransfer_blz VALUES(35461106, 'Volksbank Niederrhein', '06');
INSERT INTO banktransfer_blz VALUES(35600000, 'Bundesbank eh Wesel', '09');
INSERT INTO banktransfer_blz VALUES(35640064, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(35650000, 'Verbands-Sparkasse Wesel', '00');
INSERT INTO banktransfer_blz VALUES(35660599, 'Volksbank Rhein-Lippe', '06');
INSERT INTO banktransfer_blz VALUES(35850000, 'Stadtsparkasse Emmerich-Rees', '00');
INSERT INTO banktransfer_blz VALUES(35860245, 'Volksbank Emmerich-Rees', '06');
INSERT INTO banktransfer_blz VALUES(36000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(36010043, 'Postbank', '24');
INSERT INTO banktransfer_blz VALUES(36010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(36010200, 'VON ESSEN Bankgesellschaft', '09');
INSERT INTO banktransfer_blz VALUES(36010424, 'Aareal Bank', '09');
INSERT INTO banktransfer_blz VALUES(36010600, 'GALLINAT-BANK', '06');
INSERT INTO banktransfer_blz VALUES(36010699, 'Gallinat - Bank Asset Backed Securities', '06');
INSERT INTO banktransfer_blz VALUES(36010800, 'AKBANK N.V. Essen', '09');
INSERT INTO banktransfer_blz VALUES(36020030, 'National-Bank Essen', '10');
INSERT INTO banktransfer_blz VALUES(36020186, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(36020700, 'Hanseatic Bank', '16');
INSERT INTO banktransfer_blz VALUES(36033300, 'Santander Consumer Bank', '09');
INSERT INTO banktransfer_blz VALUES(36036000, 'VALOVIS Bank', '09');
INSERT INTO banktransfer_blz VALUES(36040039, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(36040060, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(36040061, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(36050000, 'Westdeutsche Landesbank Girozentrale', '08');
INSERT INTO banktransfer_blz VALUES(36050105, 'Sparkasse Essen', '78');
INSERT INTO banktransfer_blz VALUES(36060192, 'Pax-Bank', '06');
INSERT INTO banktransfer_blz VALUES(36060295, 'Bank im Bistum Essen', '06');
INSERT INTO banktransfer_blz VALUES(36060488, 'GENO BANK ESSEN', '34');
INSERT INTO banktransfer_blz VALUES(36060591, 'Sparda-Bank West', '86');
INSERT INTO banktransfer_blz VALUES(36060610, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(36070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(36070050, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(36080080, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(36080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(36089321, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(36200000, 'Bundesbank eh Mülheim an der Ruhr', '09');
INSERT INTO banktransfer_blz VALUES(36210111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(36220030, 'National-Bank -alt-', '10');
INSERT INTO banktransfer_blz VALUES(36240045, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(36250000, 'Sparkasse Mülheim an der Ruhr', '06');
INSERT INTO banktransfer_blz VALUES(36270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(36270048, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(36280071, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(36500000, 'Bundesbank eh Oberhausen', '09');
INSERT INTO banktransfer_blz VALUES(36520030, 'National-Bank -alt-', '10');
INSERT INTO banktransfer_blz VALUES(36540046, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(36550000, 'Stadtsparkasse Oberhausen', '00');
INSERT INTO banktransfer_blz VALUES(36570024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(36570049, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(36580072, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(37000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(37010050, 'Postbank', '24');
INSERT INTO banktransfer_blz VALUES(37010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(37010222, 'The Royal Bank of Scotland, Niederlassung Deutschland', '10');
INSERT INTO banktransfer_blz VALUES(37010600, 'Fortis Bank Ndl Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(37011000, 'Deutsche Postbank Easytrade', '24');
INSERT INTO banktransfer_blz VALUES(37013030, 'Deutsche Post Zahlungsdienste', '01');
INSERT INTO banktransfer_blz VALUES(37020090, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(37020200, 'AXA Bank', '09');
INSERT INTO banktransfer_blz VALUES(37020400, 'TOYOTA Kreditbank', '09');
INSERT INTO banktransfer_blz VALUES(37020500, 'Bank für Sozialwirtschaft', '09');
INSERT INTO banktransfer_blz VALUES(37020599, 'Bank für Sozialwirtschaft Köln Gf', '09');
INSERT INTO banktransfer_blz VALUES(37020600, 'Santander Consumer Bank MG', '09');
INSERT INTO banktransfer_blz VALUES(37020900, 'Ford Bank Ndl. der FCE Bank', '09');
INSERT INTO banktransfer_blz VALUES(37021100, 'Mazda Bank Niederlassung der FCE Bank', '09');
INSERT INTO banktransfer_blz VALUES(37021200, 'Volvo Auto Bank', '09');
INSERT INTO banktransfer_blz VALUES(37021201, 'Volvo Auto Bank - Direktbank', '09');
INSERT INTO banktransfer_blz VALUES(37021300, 'Jaguar Financial Services Ndl der FCE Bank', '09');
INSERT INTO banktransfer_blz VALUES(37021400, 'Land Rover Financial Services Ndl der FCE Bank', '09');
INSERT INTO banktransfer_blz VALUES(37030200, 'Oppenheim, Sal - jr & Cie', '09');
INSERT INTO banktransfer_blz VALUES(37030700, 'abcbank Niederlassung Köln', '19');
INSERT INTO banktransfer_blz VALUES(37030800, 'Isbank Fil Köln', '06');
INSERT INTO banktransfer_blz VALUES(37040044, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(37040048, 'Commerzbank GF-K48', '13');
INSERT INTO banktransfer_blz VALUES(37040060, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(37040061, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(37050198, 'Sparkasse KölnBonn', '00');
INSERT INTO banktransfer_blz VALUES(37050299, 'Kreissparkasse Köln', 'B5');
INSERT INTO banktransfer_blz VALUES(37060120, 'Pax-Bank Gf MHD', '06');
INSERT INTO banktransfer_blz VALUES(37060193, 'Pax-Bank', '06');
INSERT INTO banktransfer_blz VALUES(37060590, 'Sparda-Bank West', '51');
INSERT INTO banktransfer_blz VALUES(37060615, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(37060993, 'PSD Bank Köln', '91');
INSERT INTO banktransfer_blz VALUES(37062124, 'Bensberger Bank', '06');
INSERT INTO banktransfer_blz VALUES(37062365, 'Raiffeisenbank Frechen-Hürth', '06');
INSERT INTO banktransfer_blz VALUES(37062600, 'VR Bank Bergisch Gladbach', '06');
INSERT INTO banktransfer_blz VALUES(37063367, 'Raiffeisenbank Fischenich-Kendenich', '06');
INSERT INTO banktransfer_blz VALUES(37069101, 'Spar- und Darlehnskasse Aegidienberg', '06');
INSERT INTO banktransfer_blz VALUES(37069103, 'Raiffeisenbank Aldenhoven', '06');
INSERT INTO banktransfer_blz VALUES(37069125, 'Raiffeisenbank Kürten-Odenthal', '06');
INSERT INTO banktransfer_blz VALUES(37069153, 'Spar- und Darlehnskasse Brachelen', '06');
INSERT INTO banktransfer_blz VALUES(37069164, 'Volksbank Meerbusch', '06');
INSERT INTO banktransfer_blz VALUES(37069252, 'Volksbank Erft', '06');
INSERT INTO banktransfer_blz VALUES(37069302, 'Raiffeisenbank', '06');
INSERT INTO banktransfer_blz VALUES(37069303, 'Volksbank Gemünd-Kall -alt-', '06');
INSERT INTO banktransfer_blz VALUES(37069306, 'Raiffeisenbank Grevenbroich', '06');
INSERT INTO banktransfer_blz VALUES(37069322, 'Raiffeisenbank Gymnich', '06');
INSERT INTO banktransfer_blz VALUES(37069330, 'Volksbank Haaren', '06');
INSERT INTO banktransfer_blz VALUES(37069331, 'Raiffeisenbank von 1895 Zw Horrem', '06');
INSERT INTO banktransfer_blz VALUES(37069342, 'Volksbank Heimbach', '06');
INSERT INTO banktransfer_blz VALUES(37069354, 'Raiffeisenbank Selfkant Zw -alt-', '06');
INSERT INTO banktransfer_blz VALUES(37069355, 'Spar- und Darlehnskasse Hoengen', '06');
INSERT INTO banktransfer_blz VALUES(37069381, 'Volksbank Randerath-Immendorf', '06');
INSERT INTO banktransfer_blz VALUES(37069401, 'Raiffeisenbank Junkersdorf', '06');
INSERT INTO banktransfer_blz VALUES(37069405, 'Raiffeisenbank Kaarst', '06');
INSERT INTO banktransfer_blz VALUES(37069412, 'Raiffeisenbank', '06');
INSERT INTO banktransfer_blz VALUES(37069427, 'Volksbank Dünnwald-Holweide', '06');
INSERT INTO banktransfer_blz VALUES(37069429, 'Volksbank Köln-Nord', '06');
INSERT INTO banktransfer_blz VALUES(37069472, 'Raiffeisenbk Erftstadt -alt-', '06');
INSERT INTO banktransfer_blz VALUES(37069520, 'VR-Bank Rhein-Sieg', '06');
INSERT INTO banktransfer_blz VALUES(37069521, 'Raiffeisenbank Rhein-Berg', '06');
INSERT INTO banktransfer_blz VALUES(37069524, 'Raiffeisenbank Much-Ruppichteroth', '06');
INSERT INTO banktransfer_blz VALUES(37069577, 'Raiffeisenbank Odenthal -alt-', '06');
INSERT INTO banktransfer_blz VALUES(37069627, 'Raiffeisenbank Rheinbach Voreifel', '06');
INSERT INTO banktransfer_blz VALUES(37069639, 'Rosbacher Raiffeisenbank', '06');
INSERT INTO banktransfer_blz VALUES(37069642, 'Raiffeisenbank Simmerath', '06');
INSERT INTO banktransfer_blz VALUES(37069707, 'Raiffeisenbank St Augustin', '06');
INSERT INTO banktransfer_blz VALUES(37069720, 'VR-Bank Nordeifel', '06');
INSERT INTO banktransfer_blz VALUES(37069805, 'Volksbank Wachtberg', '06');
INSERT INTO banktransfer_blz VALUES(37069833, 'Raiffeisenbk Wesseling -alt-', '06');
INSERT INTO banktransfer_blz VALUES(37069840, 'Volksbank Wipperfürth-Lindlar', '06');
INSERT INTO banktransfer_blz VALUES(37069991, 'Brühler Bank', '06');
INSERT INTO banktransfer_blz VALUES(37070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(37070060, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(37080040, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(37080085, 'Commerzbank vormals Dresdner Bank Gf PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(37080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 4', '09');
INSERT INTO banktransfer_blz VALUES(37080087, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 5', '09');
INSERT INTO banktransfer_blz VALUES(37080088, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 6', '09');
INSERT INTO banktransfer_blz VALUES(37080089, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 7', '09');
INSERT INTO banktransfer_blz VALUES(37080090, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 8', '09');
INSERT INTO banktransfer_blz VALUES(37080091, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 9', '09');
INSERT INTO banktransfer_blz VALUES(37080092, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 10', '09');
INSERT INTO banktransfer_blz VALUES(37080093, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 11', '09');
INSERT INTO banktransfer_blz VALUES(37080094, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 12', '09');
INSERT INTO banktransfer_blz VALUES(37080095, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 13', '09');
INSERT INTO banktransfer_blz VALUES(37080096, 'Commerzbank vormals Dresdner Bank Zw 96', '76');
INSERT INTO banktransfer_blz VALUES(37080097, 'Commerzbank vormals Dresdner Bank Zw 97', '76');
INSERT INTO banktransfer_blz VALUES(37080098, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 14', '09');
INSERT INTO banktransfer_blz VALUES(37080099, 'Commerzbank vormals Dresdner Bank Zw 99', '76');
INSERT INTO banktransfer_blz VALUES(37089340, 'Commerzbank vormals Dresdner Bank ITGK I', '09');
INSERT INTO banktransfer_blz VALUES(37089342, 'Commerzbank vormals Dresdner Bank ITGK II', '09');
INSERT INTO banktransfer_blz VALUES(37160087, 'Kölner Bank', '06');
INSERT INTO banktransfer_blz VALUES(37161289, 'VR-Bank Rhein-Erft', '06');
INSERT INTO banktransfer_blz VALUES(37540050, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(37551020, 'Stadt-Sparkasse Leichlingen', '00');
INSERT INTO banktransfer_blz VALUES(37551440, 'Sparkasse Leverkusen', '00');
INSERT INTO banktransfer_blz VALUES(37551670, 'Stadt-Sparkasse Düsseldorf Fil Monheim', '00');
INSERT INTO banktransfer_blz VALUES(37551780, 'Stadt-Sparkasse Langenfeld', '00');
INSERT INTO banktransfer_blz VALUES(37560092, 'Volksbank Rhein-Wupper', '06');
INSERT INTO banktransfer_blz VALUES(37570024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(37570064, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(38000000, 'Bundesbank eh Bonn', '09');
INSERT INTO banktransfer_blz VALUES(38010053, 'Postbank Zentrale', '09');
INSERT INTO banktransfer_blz VALUES(38010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(38010700, 'DSL Bank', '09');
INSERT INTO banktransfer_blz VALUES(38010900, 'KfW Ndl Bonn', '09');
INSERT INTO banktransfer_blz VALUES(38010999, 'KfW Ausbildungsförderung Bonn', '06');
INSERT INTO banktransfer_blz VALUES(38011000, 'VÖB-ZVD Bank', '09');
INSERT INTO banktransfer_blz VALUES(38011001, 'VÖB-ZVD Bank Gf 1', '09');
INSERT INTO banktransfer_blz VALUES(38011002, 'VÖB-ZVD Bank Gf 2', '09');
INSERT INTO banktransfer_blz VALUES(38011003, 'VÖB-ZVD Bank Gf 3', '09');
INSERT INTO banktransfer_blz VALUES(38011004, 'VÖB-ZVD Bank Gf 4', '09');
INSERT INTO banktransfer_blz VALUES(38011005, 'VÖB-ZVD Bank Gf 5', '09');
INSERT INTO banktransfer_blz VALUES(38011006, 'VÖB-ZVD Bank für Zahlungsverkehrsdienstleistungen Gf 6', '09');
INSERT INTO banktransfer_blz VALUES(38011007, 'VÖB-ZVD Bank für Zahlungsverkehrsdienstleistungen Gf 7', '09');
INSERT INTO banktransfer_blz VALUES(38011008, 'VÖB-ZVD Bank für Zahlungsverkehrsdienstleistungen Gf 8', '09');
INSERT INTO banktransfer_blz VALUES(38020090, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(38040007, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(38050000, 'Sparkasse Bonn -alt-', '00');
INSERT INTO banktransfer_blz VALUES(38051290, 'Stadtsparkasse Bad Honnef', '00');
INSERT INTO banktransfer_blz VALUES(38060186, 'Volksbank Bonn Rhein-Sieg', '06');
INSERT INTO banktransfer_blz VALUES(38070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(38070059, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(38070724, 'Deutsche Bank Privat und Geschäftskunden F 950', '63');
INSERT INTO banktransfer_blz VALUES(38077724, 'Deutsche Bank Privat und Geschäftskunden F 950', '63');
INSERT INTO banktransfer_blz VALUES(38080055, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(38160220, 'VR-Bank Bonn', '06');
INSERT INTO banktransfer_blz VALUES(38250110, 'Kreissparkasse Euskirchen', '00');
INSERT INTO banktransfer_blz VALUES(38260082, 'Volksbank Euskirchen', '06');
INSERT INTO banktransfer_blz VALUES(38440016, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(38450000, 'Sparkasse Gummersbach-Bergneustadt', '00');
INSERT INTO banktransfer_blz VALUES(38452490, 'Sparkasse der Homburgischen Gemeinden', '00');
INSERT INTO banktransfer_blz VALUES(38462135, 'Volksbank Oberberg', '06');
INSERT INTO banktransfer_blz VALUES(38470024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(38470091, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(38600000, 'Bundesbank eh Siegburg', '09');
INSERT INTO banktransfer_blz VALUES(38621500, 'Steyler Bank', '38');
INSERT INTO banktransfer_blz VALUES(38650000, 'Kreissparkasse Siegburg', '00');
INSERT INTO banktransfer_blz VALUES(38651390, 'Sparkasse Hennef', '00');
INSERT INTO banktransfer_blz VALUES(39000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(39010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(39020000, 'Aachener Bausparkasse', '09');
INSERT INTO banktransfer_blz VALUES(39040013, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(39050000, 'Sparkasse Aachen', '00');
INSERT INTO banktransfer_blz VALUES(39060180, 'Aachener Bank', '06');
INSERT INTO banktransfer_blz VALUES(39060630, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(39061981, 'Heinsberger Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(39070020, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(39070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(39080005, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(39080098, 'Commerzbank vormals Dresdner Bank Zw 98', '76');
INSERT INTO banktransfer_blz VALUES(39080099, 'Commerzbank vormals Dresdner Bank Zw 99', '76');
INSERT INTO banktransfer_blz VALUES(39160191, 'Pax-Bank', '06');
INSERT INTO banktransfer_blz VALUES(39161490, 'Volksbank Aachen Süd', '06');
INSERT INTO banktransfer_blz VALUES(39162980, 'VR-Bank', '06');
INSERT INTO banktransfer_blz VALUES(39362254, 'Raiffeisen-Bank Eschweiler', '06');
INSERT INTO banktransfer_blz VALUES(39500000, 'Bundesbank eh Düren', '09');
INSERT INTO banktransfer_blz VALUES(39540052, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(39550110, 'Sparkasse Düren', '00');
INSERT INTO banktransfer_blz VALUES(39560201, 'Volksbank Düren', '06');
INSERT INTO banktransfer_blz VALUES(39570024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(39570061, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(39580041, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(40000000, 'Bundesbank eh Münster', '09');
INSERT INTO banktransfer_blz VALUES(40010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(40022000, 'NRW.BANK', '08');
INSERT INTO banktransfer_blz VALUES(40030000, 'Münsterländische Bank Thie & Co', '61');
INSERT INTO banktransfer_blz VALUES(40040028, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(40050000, 'WestLB Münster', '08');
INSERT INTO banktransfer_blz VALUES(40050150, 'Sparkasse Münsterland Ost', '00');
INSERT INTO banktransfer_blz VALUES(40052525, 'NRW.BANK', '08');
INSERT INTO banktransfer_blz VALUES(40060000, 'WGZ Bank', '44');
INSERT INTO banktransfer_blz VALUES(40060265, 'DKM Darlehnskasse Münster', '34');
INSERT INTO banktransfer_blz VALUES(40060300, 'WL BANK Westfälische Landschaft Bodenkreditbank', '09');
INSERT INTO banktransfer_blz VALUES(40060560, 'Sparda-Bank Münster', '85');
INSERT INTO banktransfer_blz VALUES(40060614, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(40061238, 'Volksbank Greven', '34');
INSERT INTO banktransfer_blz VALUES(40069226, 'Volksbank Lette-Darup-Rorup', '34');
INSERT INTO banktransfer_blz VALUES(40069266, 'Volksbank Marsberg', '34');
INSERT INTO banktransfer_blz VALUES(40069283, 'Volksbank Schlangen', '34');
INSERT INTO banktransfer_blz VALUES(40069348, 'Volksbank Medebach -alt-', '34');
INSERT INTO banktransfer_blz VALUES(40069362, 'Volksbank', '34');
INSERT INTO banktransfer_blz VALUES(40069363, 'Volksbank Schermbeck', '34');
INSERT INTO banktransfer_blz VALUES(40069371, 'Volksbank Thülen', '34');
INSERT INTO banktransfer_blz VALUES(40069408, 'Volksbank Baumberge', '34');
INSERT INTO banktransfer_blz VALUES(40069462, 'Volksbank Sprakel', '34');
INSERT INTO banktransfer_blz VALUES(40069477, 'Volksbank Wulfen -alt-', '34');
INSERT INTO banktransfer_blz VALUES(40069546, 'Volksbank Senden', '34');
INSERT INTO banktransfer_blz VALUES(40069600, 'Volksbank Amelsbüren', '34');
INSERT INTO banktransfer_blz VALUES(40069601, 'Volksbank Ascheberg-Herbern', '34');
INSERT INTO banktransfer_blz VALUES(40069606, 'Volksbank Erle', '34');
INSERT INTO banktransfer_blz VALUES(40069622, 'Volksbank Seppenrade', '34');
INSERT INTO banktransfer_blz VALUES(40069636, 'Volksbank Lette -alt-', '34');
INSERT INTO banktransfer_blz VALUES(40069709, 'Volksbank Lembeck-Rhade', '34');
INSERT INTO banktransfer_blz VALUES(40069716, 'Volksbank Südkirchen-Capelle-Nordkirchen', '34');
INSERT INTO banktransfer_blz VALUES(40070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(40070080, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(40080040, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(40080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(40090900, 'PSD Bank Westfalen-Lippe', '91');
INSERT INTO banktransfer_blz VALUES(40150001, 'SI/WLB Verrechnung Münster', '09');
INSERT INTO banktransfer_blz VALUES(40153768, 'Verbundsparkasse Emsdetten Ochtrup', '01');
INSERT INTO banktransfer_blz VALUES(40154006, 'Sparkasse Gronau', '00');
INSERT INTO banktransfer_blz VALUES(40154476, 'Stadtsparkasse Lengerich', '00');
INSERT INTO banktransfer_blz VALUES(40154530, 'Sparkasse Westmünsterland', '00');
INSERT INTO banktransfer_blz VALUES(40154702, 'Stadtsparkasse Stadtlohn', '00');
INSERT INTO banktransfer_blz VALUES(40160050, 'Volksbank Münster', '34');
INSERT INTO banktransfer_blz VALUES(40163123, 'Volksbank Coesfeld -alt-', '34');
INSERT INTO banktransfer_blz VALUES(40163720, 'Volksbank Nordmünsterland', '34');
INSERT INTO banktransfer_blz VALUES(40164024, 'Volksbank Gronau-Ahaus', '34');
INSERT INTO banktransfer_blz VALUES(40164256, 'Volksbank Laer-Horstmar-Leer', '34');
INSERT INTO banktransfer_blz VALUES(40164352, 'Volksbank Nottuln', '34');
INSERT INTO banktransfer_blz VALUES(40164528, 'Volksbank Lüdinghausen-Olfen', '34');
INSERT INTO banktransfer_blz VALUES(40164618, 'Volksbank', '34');
INSERT INTO banktransfer_blz VALUES(40164901, 'Volksbank', '34');
INSERT INTO banktransfer_blz VALUES(40165366, 'Volksbank Selm-Bork', '34');
INSERT INTO banktransfer_blz VALUES(40166439, 'Volksbank Lengerich/Lotte -alt-', '34');
INSERT INTO banktransfer_blz VALUES(40166800, 'Volksbank Buldern -alt-', '34');
INSERT INTO banktransfer_blz VALUES(40300000, 'Bundesbank eh Rheine', '09');
INSERT INTO banktransfer_blz VALUES(40340030, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(40350005, 'Stadtsparkasse Rheine', '00');
INSERT INTO banktransfer_blz VALUES(40351060, 'Kreissparkasse Steinfurt', '00');
INSERT INTO banktransfer_blz VALUES(40351220, 'Sparkasse Steinfurt -alt-', '00');
INSERT INTO banktransfer_blz VALUES(40361627, 'Volksbank Westerkappeln-Wersen', '34');
INSERT INTO banktransfer_blz VALUES(40361906, 'Volksbank Tecklenburger Land', '34');
INSERT INTO banktransfer_blz VALUES(40363433, 'Volksbank Hörstel -alt-', '34');
INSERT INTO banktransfer_blz VALUES(40370024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(40370079, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(41000000, 'Bundesbank eh Hamm', '09');
INSERT INTO banktransfer_blz VALUES(41010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(41040018, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(41041000, 'ZTB der Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(41050095, 'Sparkasse Hamm', '00');
INSERT INTO banktransfer_blz VALUES(41051605, 'Stadtsparkasse Werne', '00');
INSERT INTO banktransfer_blz VALUES(41051845, 'Sparkasse Bergkamen-Bönen', '00');
INSERT INTO banktransfer_blz VALUES(41060120, 'Volksbank Hamm', '34');
INSERT INTO banktransfer_blz VALUES(41061011, 'Spar- und Darlehnskasse Bockum-Hövel', '34');
INSERT INTO banktransfer_blz VALUES(41061903, 'BAG Bankaktiengesellschaft', '34');
INSERT INTO banktransfer_blz VALUES(41062215, 'Volksbank Bönen', '34');
INSERT INTO banktransfer_blz VALUES(41070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(41070049, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(41240048, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(41250035, 'Sparkasse Beckum-Wadersloh', '00');
INSERT INTO banktransfer_blz VALUES(41260006, 'Volksbank Beckum', '34');
INSERT INTO banktransfer_blz VALUES(41261324, 'Volksbank Enniger-Ostenfelde-Westkirchen', '34');
INSERT INTO banktransfer_blz VALUES(41261419, 'Volksbank Oelde-Ennigerloh-Neubeckum', '34');
INSERT INTO banktransfer_blz VALUES(41262501, 'Volksbank Ahlen-Sassenberg-Warendorf', '34');
INSERT INTO banktransfer_blz VALUES(41262621, 'Vereinigte Volksbank Telgte', '34');
INSERT INTO banktransfer_blz VALUES(41280043, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(41440018, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(41450075, 'Sparkasse Soest', '00');
INSERT INTO banktransfer_blz VALUES(41451750, 'Sparkasse Werl', '00');
INSERT INTO banktransfer_blz VALUES(41460116, 'Volksbank Hellweg', '34');
INSERT INTO banktransfer_blz VALUES(41462295, 'Volksbank Wickede (Ruhr)', '34');
INSERT INTO banktransfer_blz VALUES(41650001, 'Sparkasse Lippstadt', '00');
INSERT INTO banktransfer_blz VALUES(41651770, 'Sparkasse Hochsauerland', '00');
INSERT INTO banktransfer_blz VALUES(41651815, 'Sparkasse Erwitte-Anröchte', '00');
INSERT INTO banktransfer_blz VALUES(41651965, 'Sparkasse Geseke', '00');
INSERT INTO banktransfer_blz VALUES(41652560, 'Sparkasse Warstein-Rüthen -alt-', '00');
INSERT INTO banktransfer_blz VALUES(41660124, 'Volksbank Lippstadt', '34');
INSERT INTO banktransfer_blz VALUES(41661206, 'Volksbank Anröchte', '34');
INSERT INTO banktransfer_blz VALUES(41661504, 'Volksbank Benninghausen', '34');
INSERT INTO banktransfer_blz VALUES(41661719, 'Volksbank Brilon', '34');
INSERT INTO banktransfer_blz VALUES(41662465, 'Volksbank Störmede', '34');
INSERT INTO banktransfer_blz VALUES(41662557, 'Volksbank Warstein-Belecke -alt-', '34');
INSERT INTO banktransfer_blz VALUES(41663335, 'Volksbank Hörste', '34');
INSERT INTO banktransfer_blz VALUES(41670024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(41670027, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(41670028, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(41670029, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(41670030, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(42000000, 'Bundesbank eh Gelsenkirchen', '09');
INSERT INTO banktransfer_blz VALUES(42010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(42030600, 'Isbank Fil Gelsenkirchen', '06');
INSERT INTO banktransfer_blz VALUES(42040040, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(42050001, 'Sparkasse Gelsenkirchen', '25');
INSERT INTO banktransfer_blz VALUES(42070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(42070062, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(42080082, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(42260001, 'Volksbank Ruhr Mitte', '34');
INSERT INTO banktransfer_blz VALUES(42450040, 'Stadtsparkasse Gladbeck', '00');
INSERT INTO banktransfer_blz VALUES(42451220, 'Sparkasse Bottrop', '00');
INSERT INTO banktransfer_blz VALUES(42461435, 'Volksbank Kirchhellen', '34');
INSERT INTO banktransfer_blz VALUES(42600000, 'Bundesbank eh Recklinghausen', '09');
INSERT INTO banktransfer_blz VALUES(42610112, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(42640048, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(42650150, 'Sparkasse Vest Recklinghausen', '00');
INSERT INTO banktransfer_blz VALUES(42651315, 'Stadtsparkasse Haltern am See', '00');
INSERT INTO banktransfer_blz VALUES(42661008, 'Volksbank Marl-Recklinghausen', '34');
INSERT INTO banktransfer_blz VALUES(42661330, 'Volksbank Haltern', '34');
INSERT INTO banktransfer_blz VALUES(42661522, 'Volksbank Herten-Westerholt -alt-', '34');
INSERT INTO banktransfer_blz VALUES(42661717, 'Volksbank Waltrop', '34');
INSERT INTO banktransfer_blz VALUES(42662320, 'Volksbank Dorsten', '34');
INSERT INTO banktransfer_blz VALUES(42680081, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(42840005, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(42850035, 'Stadtsparkasse Bocholt', '00');
INSERT INTO banktransfer_blz VALUES(42860003, 'Volksbank Bocholt', '34');
INSERT INTO banktransfer_blz VALUES(42861239, 'Spar- und Darlehnskasse', '34');
INSERT INTO banktransfer_blz VALUES(42861387, 'VR-Bank Westmünsterland', '34');
INSERT INTO banktransfer_blz VALUES(42861416, 'Volksbank', '34');
INSERT INTO banktransfer_blz VALUES(42861515, 'Volksbank Gemen', '34');
INSERT INTO banktransfer_blz VALUES(42861608, 'Volksbank Heiden', '34');
INSERT INTO banktransfer_blz VALUES(42861814, 'Volksbank Rhede', '34');
INSERT INTO banktransfer_blz VALUES(42862451, 'Volksbank Raesfeld', '34');
INSERT INTO banktransfer_blz VALUES(42870024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(42870077, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(43000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(43010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(43040036, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(43050001, 'Sparkasse Bochum', '00');
INSERT INTO banktransfer_blz VALUES(43051040, 'Sparkasse Hattingen', '00');
INSERT INTO banktransfer_blz VALUES(43060129, 'Volksbank Bochum Witten', '34');
INSERT INTO banktransfer_blz VALUES(43060967, 'GLS Gemeinschaftsbank', '34');
INSERT INTO banktransfer_blz VALUES(43070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(43070061, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(43080083, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(43250030, 'Herner Sparkasse', '00');
INSERT INTO banktransfer_blz VALUES(44000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(44010046, 'Postbank', '24');
INSERT INTO banktransfer_blz VALUES(44010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(44010200, 'BHW Bausparkasse', '09');
INSERT INTO banktransfer_blz VALUES(44010300, 'The Royal Bank of Scotland, Niederlassung Deutschland', '10');
INSERT INTO banktransfer_blz VALUES(44020090, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(44040037, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(44040060, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(44040061, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(44050000, 'WestLB Dortmund', '08');
INSERT INTO banktransfer_blz VALUES(44050199, 'Sparkasse Dortmund', '06');
INSERT INTO banktransfer_blz VALUES(44060122, 'Volksbank Dortmund-Nordwest', '34');
INSERT INTO banktransfer_blz VALUES(44060604, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(44064406, 'Bank für Kirche und Diakonie - KD-Bank Gf Sonder-BLZ', '09');
INSERT INTO banktransfer_blz VALUES(44070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(44070050, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(44080050, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(44080055, 'Commerzbank vormals Dresdner Bank Zw 55', '76');
INSERT INTO banktransfer_blz VALUES(44080057, 'Commerzbank vormals Dresdner Bank Gf ZW 57', '76');
INSERT INTO banktransfer_blz VALUES(44080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(44089320, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(44090920, 'PSD Bank Dortmund -alt-', '91');
INSERT INTO banktransfer_blz VALUES(44130000, 'HKB Bank', '00');
INSERT INTO banktransfer_blz VALUES(44152370, 'Sparkasse Lünen', '00');
INSERT INTO banktransfer_blz VALUES(44152490, 'Stadtsparkasse Schwerte', '00');
INSERT INTO banktransfer_blz VALUES(44160014, 'Dortmunder Volksbank', '34');
INSERT INTO banktransfer_blz VALUES(44340037, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(44350060, 'Kreis- und Stadtsparkasse Unna', '00');
INSERT INTO banktransfer_blz VALUES(44351380, 'Sparkasse Kamen', '00');
INSERT INTO banktransfer_blz VALUES(44351740, 'Sparkasse Fröndenberg', '00');
INSERT INTO banktransfer_blz VALUES(44360002, 'Volksbank Unna Schwerte -alt-', '34');
INSERT INTO banktransfer_blz VALUES(44361342, 'Volksbank Kamen-Werne', '34');
INSERT INTO banktransfer_blz VALUES(44540022, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(44550045, 'Sparkasse der Stadt Iserlohn', '00');
INSERT INTO banktransfer_blz VALUES(44551210, 'Sparkasse Märkisches Sauerland Hemer-Menden', '00');
INSERT INTO banktransfer_blz VALUES(44561102, 'Volksbank Letmathe -alt-', '34');
INSERT INTO banktransfer_blz VALUES(44570004, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(44570024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(44580070, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(44580085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(44750065, 'Sparkasse Menden', '00');
INSERT INTO banktransfer_blz VALUES(44760037, 'Volksbank Menden -alt-', '34');
INSERT INTO banktransfer_blz VALUES(44761312, 'Mendener Bank', '34');
INSERT INTO banktransfer_blz VALUES(44761534, 'Volksbank im Märkischen Kreis', '34');
INSERT INTO banktransfer_blz VALUES(45000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(45030000, 'HKB Bank', '00');
INSERT INTO banktransfer_blz VALUES(45040042, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(45050001, 'Sparkasse Hagen', '02');
INSERT INTO banktransfer_blz VALUES(45051485, 'Stadtsparkasse Herdecke', '00');
INSERT INTO banktransfer_blz VALUES(45060009, 'Märkische Bank', '34');
INSERT INTO banktransfer_blz VALUES(45061524, 'Volksbank Hohenlimburg', '34');
INSERT INTO banktransfer_blz VALUES(45070002, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(45070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(45080060, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(45240056, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(45250035, 'Sparkasse Witten', '00');
INSERT INTO banktransfer_blz VALUES(45251480, 'Stadtsparkasse Wetter', '00');
INSERT INTO banktransfer_blz VALUES(45251515, 'Stadtsparkasse Sprockhövel', '00');
INSERT INTO banktransfer_blz VALUES(45260041, 'Volksbank Witten -alt-', '34');
INSERT INTO banktransfer_blz VALUES(45260475, 'Spar- u Kreditbank d Bundes Fr ev Gemeinden', '34');
INSERT INTO banktransfer_blz VALUES(45261547, 'Volksbank Sprockhövel', '34');
INSERT INTO banktransfer_blz VALUES(45450050, 'Stadtsparkasse Gevelsberg', '00');
INSERT INTO banktransfer_blz VALUES(45451060, 'Sparkasse Ennepetal-Breckerfeld', '00');
INSERT INTO banktransfer_blz VALUES(45451555, 'Stadtsparkasse Schwelm', '00');
INSERT INTO banktransfer_blz VALUES(45660029, 'Volksbank Altena -alt-', '34');
INSERT INTO banktransfer_blz VALUES(45840026, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(45841031, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(45850005, 'Sparkasse Lüdenscheid', '00');
INSERT INTO banktransfer_blz VALUES(45851020, 'Vereinigte Sparkasse im Märkischen Kreis', '00');
INSERT INTO banktransfer_blz VALUES(45851665, 'Sparkasse Kierspe-Meinerzhagen', '00');
INSERT INTO banktransfer_blz VALUES(45860033, 'Volksbank Lüdenscheid -alt-', '34');
INSERT INTO banktransfer_blz VALUES(45861434, 'Volksbank Kierspe', '34');
INSERT INTO banktransfer_blz VALUES(45861617, 'Volksbank Meinerzhagen -alt-', '34');
INSERT INTO banktransfer_blz VALUES(46000000, 'Bundesbank eh Siegen', '09');
INSERT INTO banktransfer_blz VALUES(46010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(46040033, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(46050001, 'Sparkasse Siegen', '00');
INSERT INTO banktransfer_blz VALUES(46051240, 'Sparkasse Burbach-Neunkirchen', '00');
INSERT INTO banktransfer_blz VALUES(46051733, 'Stadtsparkasse Freudenberg', '00');
INSERT INTO banktransfer_blz VALUES(46051875, 'Stadtsparkasse Hilchenbach', '00');
INSERT INTO banktransfer_blz VALUES(46052855, 'Stadtsparkasse Schmallenberg', '00');
INSERT INTO banktransfer_blz VALUES(46053480, 'Sparkasse Wittgenstein', '00');
INSERT INTO banktransfer_blz VALUES(46060040, 'Volksbank Siegerland', '34');
INSERT INTO banktransfer_blz VALUES(46061724, 'VR-Bank Freudenberg-Niederfischbach', '34');
INSERT INTO banktransfer_blz VALUES(46062817, 'Volksbank Bigge-Lenne', '34');
INSERT INTO banktransfer_blz VALUES(46063405, 'Volksbank Wittgenstein', '34');
INSERT INTO banktransfer_blz VALUES(46070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(46070090, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(46080010, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(46240016, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(46250049, 'Sparkasse Olpe-Drolshagen-Wenden', '00');
INSERT INTO banktransfer_blz VALUES(46251590, 'Sparkasse Finnentrop', '00');
INSERT INTO banktransfer_blz VALUES(46251630, 'Sparkasse Attendorn-Lennestadt-Kirchhundem', '00');
INSERT INTO banktransfer_blz VALUES(46260023, 'Volksbank Olpe', '34');
INSERT INTO banktransfer_blz VALUES(46261306, 'Volksbank Attendorn -alt-', '34');
INSERT INTO banktransfer_blz VALUES(46261607, 'Volksbank Grevenbrück', '34');
INSERT INTO banktransfer_blz VALUES(46261822, 'Volksbank Wenden-Drolshagen', '34');
INSERT INTO banktransfer_blz VALUES(46262456, 'Volksbank Bigge-Lenne -alt-', '34');
INSERT INTO banktransfer_blz VALUES(46400000, 'Bundesbank eh Arnsberg', '09');
INSERT INTO banktransfer_blz VALUES(46441003, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(46451012, 'Zweckverbandssparkasse Meschede', '00');
INSERT INTO banktransfer_blz VALUES(46451250, 'Sparkasse Bestwig -alt-', '00');
INSERT INTO banktransfer_blz VALUES(46461126, 'Volksbank Sauerland -alt-', '34');
INSERT INTO banktransfer_blz VALUES(46462271, 'Spar- und Darlehnskasse Oeventrop', '34');
INSERT INTO banktransfer_blz VALUES(46464453, 'Volksbank Reiste-Eslohe', '34');
INSERT INTO banktransfer_blz VALUES(46640018, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(46650005, 'Sparkasse Arnsberg-Sundern', '00');
INSERT INTO banktransfer_blz VALUES(46660022, 'Volksbank Sauerland', '34');
INSERT INTO banktransfer_blz VALUES(46670007, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(46670024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(47200000, 'Bundesbank eh Paderborn', '09');
INSERT INTO banktransfer_blz VALUES(47240047, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(47250101, 'Sparkasse Paderborn', '00');
INSERT INTO banktransfer_blz VALUES(47251550, 'Sparkasse Höxter', '00');
INSERT INTO banktransfer_blz VALUES(47251740, 'Stadtsparkasse Delbrück', '00');
INSERT INTO banktransfer_blz VALUES(47260121, 'Volksbank Paderborn-Höxter-Detmold', '34');
INSERT INTO banktransfer_blz VALUES(47260234, 'Volksbank Elsen-Wewer-Borchen', '34');
INSERT INTO banktransfer_blz VALUES(47260307, 'Bank für Kirche und Caritas', '34');
INSERT INTO banktransfer_blz VALUES(47261429, 'Volksbank Haaren -alt-', '34');
INSERT INTO banktransfer_blz VALUES(47261603, 'Volksbank Büren und Salzkotten', '34');
INSERT INTO banktransfer_blz VALUES(47262406, 'Volksbank Höxter-Beverungen -alt-', '34');
INSERT INTO banktransfer_blz VALUES(47262626, 'Volksbank Westenholz', '34');
INSERT INTO banktransfer_blz VALUES(47262703, 'Volksbank Delbrück-Hövelhof', '34');
INSERT INTO banktransfer_blz VALUES(47263472, 'Volksbank Westerloh-Westerwiehe', '34');
INSERT INTO banktransfer_blz VALUES(47264367, 'Volksbank Bad Driburg-Brakel-Steinheim', '34');
INSERT INTO banktransfer_blz VALUES(47265383, 'Volksbank Wewelsburg-Ahden', '34');
INSERT INTO banktransfer_blz VALUES(47267216, 'Volksbank Borgentreich -alt-', '34');
INSERT INTO banktransfer_blz VALUES(47270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(47270029, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(47451235, 'Stadtsparkasse Marsberg -alt-', '00');
INSERT INTO banktransfer_blz VALUES(47460028, 'Volksbank Warburger Land', '34');
INSERT INTO banktransfer_blz VALUES(47640051, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(47650130, 'Sparkasse Detmold', '00');
INSERT INTO banktransfer_blz VALUES(47651225, 'Stadtsparkasse Blomberg', '00');
INSERT INTO banktransfer_blz VALUES(47670023, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(47670024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(47690080, 'Volksbank Detmold -alt-', '34');
INSERT INTO banktransfer_blz VALUES(47691200, 'Volksbank', '34');
INSERT INTO banktransfer_blz VALUES(47800000, 'Bundesbank eh Gütersloh', '09');
INSERT INTO banktransfer_blz VALUES(47840065, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(47840080, 'Commerzbank Zw 80', '09');
INSERT INTO banktransfer_blz VALUES(47850065, 'Sparkasse Gütersloh', '03');
INSERT INTO banktransfer_blz VALUES(47852760, 'Sparkasse Rietberg', '00');
INSERT INTO banktransfer_blz VALUES(47853355, 'Stadtsparkasse Versmold', '00');
INSERT INTO banktransfer_blz VALUES(47853520, 'Kreissparkasse Wiedenbrück', '00');
INSERT INTO banktransfer_blz VALUES(47860125, 'Volksbank Gütersloh', '34');
INSERT INTO banktransfer_blz VALUES(47861317, 'Volksbank Clarholz-Lette-Beelen', '34');
INSERT INTO banktransfer_blz VALUES(47861518, 'Volksbank Harsewinkel', '34');
INSERT INTO banktransfer_blz VALUES(47861806, 'Volksbank Kaunitz', '34');
INSERT INTO banktransfer_blz VALUES(47861907, 'Volksbank Langenberg -alt-', '34');
INSERT INTO banktransfer_blz VALUES(47862261, 'Volksbank Marienfeld -alt-', '34');
INSERT INTO banktransfer_blz VALUES(47862447, 'Volksbank Rietberg', '34');
INSERT INTO banktransfer_blz VALUES(47863373, 'Volksbank Versmold', '34');
INSERT INTO banktransfer_blz VALUES(47880031, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(48000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(48010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(48020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(48020151, 'Bankhaus Lampe', '32');
INSERT INTO banktransfer_blz VALUES(48021900, 'Bankverein Werther', '32');
INSERT INTO banktransfer_blz VALUES(48040035, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(48040060, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(48040061, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(48050000, 'Westdeutsche Landesbank', '08');
INSERT INTO banktransfer_blz VALUES(48050161, 'Sparkasse Bielefeld', '00');
INSERT INTO banktransfer_blz VALUES(48051580, 'Kreissparkasse Halle', '00');
INSERT INTO banktransfer_blz VALUES(48060036, 'Bielefelder Volksbank', '34');
INSERT INTO banktransfer_blz VALUES(48062051, 'Volksbank Halle/Westf', '34');
INSERT INTO banktransfer_blz VALUES(48062466, 'Spar-u Darlehnskasse Schloß Holte-Stukenbrock', '34');
INSERT INTO banktransfer_blz VALUES(48070020, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(48070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(48070040, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(48070042, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(48070043, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(48070044, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(48070045, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(48070050, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(48070052, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(48080020, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(48089350, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(48091315, 'Volksbank Brackwede -alt-', '34');
INSERT INTO banktransfer_blz VALUES(48250110, 'Sparkasse Lemgo', '00');
INSERT INTO banktransfer_blz VALUES(48262248, 'Volksbank Nordlippe -alt-', '34');
INSERT INTO banktransfer_blz VALUES(48291490, 'Volksbank Bad Salzuflen', '34');
INSERT INTO banktransfer_blz VALUES(49000000, 'Bundesbank eh Minden', '09');
INSERT INTO banktransfer_blz VALUES(49040043, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(49050101, 'Sparkasse Minden-Lübbecke', '00');
INSERT INTO banktransfer_blz VALUES(49051065, 'Stadtsparkasse Rahden', '00');
INSERT INTO banktransfer_blz VALUES(49051285, 'Stadtsparkasse Bad Oeynhausen', '00');
INSERT INTO banktransfer_blz VALUES(49051990, 'Stadtsparkasse Porta Westfalica', '00');
INSERT INTO banktransfer_blz VALUES(49060127, 'Volksbank Minden-Hille-Porta', '34');
INSERT INTO banktransfer_blz VALUES(49060392, 'Volksbank Minden', '34');
INSERT INTO banktransfer_blz VALUES(49061298, 'Volksbank Bad Oeynhausen -alt-', '34');
INSERT INTO banktransfer_blz VALUES(49061470, 'Volksbank Stemweder Berg -alt-', '34');
INSERT INTO banktransfer_blz VALUES(49061510, 'Volksbank Eisbergen -alt-', '34');
INSERT INTO banktransfer_blz VALUES(49063296, 'Volksbank Petershagen', '34');
INSERT INTO banktransfer_blz VALUES(49063338, 'Volksbank Hille -alt-', '34');
INSERT INTO banktransfer_blz VALUES(49070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(49070028, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(49080025, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(49092650, 'Volksbank Lübbecker Land', '34');
INSERT INTO banktransfer_blz VALUES(49240096, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(49262364, 'Volksbank Schnathorst', '34');
INSERT INTO banktransfer_blz VALUES(49440043, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(49450120, 'Sparkasse Herford', '00');
INSERT INTO banktransfer_blz VALUES(49451210, 'Sparkasse Bad Salzuflen -alt-', '00');
INSERT INTO banktransfer_blz VALUES(49461323, 'Volksbank Enger-Spenge', '34');
INSERT INTO banktransfer_blz VALUES(49490070, 'Volksbank Bad Oeynhausen-Herford', '34');
INSERT INTO banktransfer_blz VALUES(50000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(50010060, 'Postbank', '24');
INSERT INTO banktransfer_blz VALUES(50010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(50010200, 'AKBANK', '00');
INSERT INTO banktransfer_blz VALUES(50010424, 'Aareal Bank', '09');
INSERT INTO banktransfer_blz VALUES(50010517, 'ING-DiBa', 'C1');
INSERT INTO banktransfer_blz VALUES(50010700, 'Degussa Bank', 'B7');
INSERT INTO banktransfer_blz VALUES(50010900, 'Bank of America', '09');
INSERT INTO banktransfer_blz VALUES(50012800, 'ALTE LEIPZIGER Bauspar', '50');
INSERT INTO banktransfer_blz VALUES(50020160, 'UniCredit Bank - HypoVereinsbank Ndl 427 Ffm', '99');
INSERT INTO banktransfer_blz VALUES(50020200, 'BHF-BANK', '60');
INSERT INTO banktransfer_blz VALUES(50020300, 'KBC Bank Deutschland', '18');
INSERT INTO banktransfer_blz VALUES(50020400, 'KfW Kreditanstalt für Wiederaufbau Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50020500, 'Landwirtschaftliche Rentenbank', '09');
INSERT INTO banktransfer_blz VALUES(50020700, 'Credit Europe Bank Ndl. Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(50020800, 'Intesa Sanpaolo Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50020900, 'COREALCREDIT BANK', '09');
INSERT INTO banktransfer_blz VALUES(50021000, 'ING Bank Frankfurt am Main', '60');
INSERT INTO banktransfer_blz VALUES(50021100, 'Frankfurter Fondsbank', '60');
INSERT INTO banktransfer_blz VALUES(50023400, 'Bank of Beirut Ndl Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50030000, 'Banque PSA Finance Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(50030100, 'HKB Bank Frankfurt', '00');
INSERT INTO banktransfer_blz VALUES(50030500, 'BNP PARIBAS Securities Services', '09');
INSERT INTO banktransfer_blz VALUES(50030600, 'Deutsche WertpapierService Bank', '09');
INSERT INTO banktransfer_blz VALUES(50030700, 'DenizBank (Wien) Zw Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50030800, 'LHB Internationale Handelsbank', '00');
INSERT INTO banktransfer_blz VALUES(50030900, 'Lehman Brothers Bankhaus Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50031000, 'Triodos Bank Deutschland', '06');
INSERT INTO banktransfer_blz VALUES(50031100, 'Bankhaus Main', '00');
INSERT INTO banktransfer_blz VALUES(50033300, 'Santander Consumer Bank', '09');
INSERT INTO banktransfer_blz VALUES(50040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(50040033, 'Commerzbank Gf BRS', '09');
INSERT INTO banktransfer_blz VALUES(50040040, 'Commerzbank Gf ZRK', '13');
INSERT INTO banktransfer_blz VALUES(50040048, 'Commerzbank GF-F48', '13');
INSERT INTO banktransfer_blz VALUES(50040051, 'Commerzbank Center Dresdner Bank Frankfurt', '13');
INSERT INTO banktransfer_blz VALUES(50040052, 'Commerzbank Service - BZ Frankfurt', '13');
INSERT INTO banktransfer_blz VALUES(50040060, 'Commerzbank Gf 460', '09');
INSERT INTO banktransfer_blz VALUES(50040061, 'Commerzbank Gf 461', '09');
INSERT INTO banktransfer_blz VALUES(50040062, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(50040063, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(50040075, 'Commerzbank Gf ZCM', '13');
INSERT INTO banktransfer_blz VALUES(50040099, 'Commerzbank INT', '13');
INSERT INTO banktransfer_blz VALUES(50042500, 'Commerzbank Zw 425 - keine Auslandsbanken', '13');
INSERT INTO banktransfer_blz VALUES(50044444, 'Commerzbank Vermögensverwaltung', '13');
INSERT INTO banktransfer_blz VALUES(50047010, 'Commerzbank Service - BZ', '13');
INSERT INTO banktransfer_blz VALUES(50050000, 'Landesbank Hessen-Thür Girozentrale', '00');
INSERT INTO banktransfer_blz VALUES(50050201, 'Frankfurter Sparkasse', '96');
INSERT INTO banktransfer_blz VALUES(50050222, 'Frankfurter Sparkasse GF 1822direkt', '19');
INSERT INTO banktransfer_blz VALUES(50050999, 'DekaBank Frankfurt', '00');
INSERT INTO banktransfer_blz VALUES(50060000, 'DZ Bank', '09');
INSERT INTO banktransfer_blz VALUES(50060400, 'DZ BANK', '09');
INSERT INTO banktransfer_blz VALUES(50060411, 'First Cash DZ BANK Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50060412, 'DZ BANK Gf vK', '09');
INSERT INTO banktransfer_blz VALUES(50060500, 'Evangelische Kreditgenossenschaft -Filiale Frankfurt-', '32');
INSERT INTO banktransfer_blz VALUES(50061741, 'Raiffeisenbank Oberursel', '32');
INSERT INTO banktransfer_blz VALUES(50069126, 'Raiffeisenbank Alzey-Land', '32');
INSERT INTO banktransfer_blz VALUES(50069146, 'Volksbank Grebenhain', '32');
INSERT INTO banktransfer_blz VALUES(50069187, 'Volksbank Egelsbach -alt-', '32');
INSERT INTO banktransfer_blz VALUES(50069241, 'Raiffeisenkasse Erbes-Büdesheim und Umgebung', '32');
INSERT INTO banktransfer_blz VALUES(50069345, 'Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(50069455, 'Hüttenberger Bank', '32');
INSERT INTO banktransfer_blz VALUES(50069464, 'Volksbank Inheiden-Villingen -alt-', '32');
INSERT INTO banktransfer_blz VALUES(50069477, 'Raiffeisenbank Kirtorf', '32');
INSERT INTO banktransfer_blz VALUES(50069693, 'Raiffeisenbank Bad Homburg Ndl d FrankfurterVB', '32');
INSERT INTO banktransfer_blz VALUES(50069828, 'Raiffeisenbank Mücke -alt-', '32');
INSERT INTO banktransfer_blz VALUES(50069842, 'Raiffeisen Volksbank', '32');
INSERT INTO banktransfer_blz VALUES(50069976, 'Volksbank Wißmar', '32');
INSERT INTO banktransfer_blz VALUES(50070010, 'Deutsche Bank Filiale', '63');
INSERT INTO banktransfer_blz VALUES(50070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(50073019, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(50073024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(50073081, 'Projektgesellschaft DB Europe', '63');
INSERT INTO banktransfer_blz VALUES(50080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(50080015, 'Commerzbank vormals Dresdner Bank Zw 15', '76');
INSERT INTO banktransfer_blz VALUES(50080025, 'Commerzbank vormals Dresdner Bank Zw 25', '76');
INSERT INTO banktransfer_blz VALUES(50080035, 'Commerzbank vormals Dresdner Bank Zw 35', '76');
INSERT INTO banktransfer_blz VALUES(50080055, 'Commerzbank vormals Dresdner Bank Zw 55', '76');
INSERT INTO banktransfer_blz VALUES(50080057, 'Commerzbank vormals Dresdner Bank Gf ZW 57', '76');
INSERT INTO banktransfer_blz VALUES(50080060, 'Commerzbank vormals Dresdner Bank Gf DrKW', '76');
INSERT INTO banktransfer_blz VALUES(50080061, 'Commerzbank vormals Dresdner Bank Gf DrKWSL', '76');
INSERT INTO banktransfer_blz VALUES(50080077, 'Commerzbank, GF Wüstenrot BSPK', '09');
INSERT INTO banktransfer_blz VALUES(50080080, 'Commerzbank vormals Dresdner Bank Bs 80', '76');
INSERT INTO banktransfer_blz VALUES(50080082, 'Commerzbank vormals Dresdner Bank Gf AVB', '76');
INSERT INTO banktransfer_blz VALUES(50080086, 'Commerzbank vormals Dresdner Bank ITGK 3', '09');
INSERT INTO banktransfer_blz VALUES(50080087, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 4', '09');
INSERT INTO banktransfer_blz VALUES(50080088, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 5', '09');
INSERT INTO banktransfer_blz VALUES(50080089, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 6', '09');
INSERT INTO banktransfer_blz VALUES(50080091, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 7', '09');
INSERT INTO banktransfer_blz VALUES(50080092, 'Commerzbank vormals Dresdner Bank Finance and Controlling', '76');
INSERT INTO banktransfer_blz VALUES(50080099, 'Commerzbank vormals Dresdner Bank Zw 99', '76');
INSERT INTO banktransfer_blz VALUES(50080300, 'Commerzbank vormals Dresdner Bank Private Banking Inland', '76');
INSERT INTO banktransfer_blz VALUES(50083007, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(50083838, 'Commerzbank vormals Dresdner Bank in Frankfurt MBP', '76');
INSERT INTO banktransfer_blz VALUES(50089400, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(50090200, 'VR DISKONTBANK', '00');
INSERT INTO banktransfer_blz VALUES(50090500, 'Sparda-Bank Hessen', '73');
INSERT INTO banktransfer_blz VALUES(50090607, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(50090900, 'PSD Bank Hessen-Thüringen', '91');
INSERT INTO banktransfer_blz VALUES(50092100, 'Spar- u Kreditbank ev-freikirchl Gemeinden', '06');
INSERT INTO banktransfer_blz VALUES(50092200, 'Volksbank Main-Taunus -alt-', '06');
INSERT INTO banktransfer_blz VALUES(50092900, 'Volksbank Usinger Land Ndl d Frankfurter VB', '06');
INSERT INTO banktransfer_blz VALUES(50093000, 'Rüsselsheimer Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(50093010, 'Rüsselsheimer Volksbank GAA', '06');
INSERT INTO banktransfer_blz VALUES(50093400, 'Volksbank Kelsterbach Ndl d Frankfurter VB', '06');
INSERT INTO banktransfer_blz VALUES(50110200, 'Industrial and Commercial Bank of China', '09');
INSERT INTO banktransfer_blz VALUES(50110300, 'DVB Bank', '10');
INSERT INTO banktransfer_blz VALUES(50110400, 'AKA Ausfuhrkredit GmbH', '09');
INSERT INTO banktransfer_blz VALUES(50110500, 'NATIXIS Zweigniederlassung Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(50110636, 'DTC Standard Chartered Bank Germany Branch', '09');
INSERT INTO banktransfer_blz VALUES(50110700, 'Frankfurter Bankgesellschaft (Deutschland)', '09');
INSERT INTO banktransfer_blz VALUES(50110800, 'J.P. Morgan', '09');
INSERT INTO banktransfer_blz VALUES(50110900, 'Bank of America N.A. Military Bank', '09');
INSERT INTO banktransfer_blz VALUES(50120000, 'MainFirst Bank', '09');
INSERT INTO banktransfer_blz VALUES(50120100, 'ICICI Bank UK Ndl Frankfurt am Main', '09');
INSERT INTO banktransfer_blz VALUES(50120383, 'Delbrück Bethmann Maffei', 'A3');
INSERT INTO banktransfer_blz VALUES(50120500, 'Credit Suisse (Deutschland)', '66');
INSERT INTO banktransfer_blz VALUES(50120600, 'Bank of Communications Frankfurt branch', '09');
INSERT INTO banktransfer_blz VALUES(50120900, 'VakifBank International Wien Zndl Frankfurt', '06');
INSERT INTO banktransfer_blz VALUES(50123400, 'VTB Bank (Austria), Zndl', '28');
INSERT INTO banktransfer_blz VALUES(50130000, 'National Bank of Pakistan Zndl Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50130100, 'BethmannMaffei Bank -alt-', '09');
INSERT INTO banktransfer_blz VALUES(50130200, 'Oppenheim, Sal - jr & Cie', '09');
INSERT INTO banktransfer_blz VALUES(50130300, 'FIRST INTERNATIONAL BANK', '50');
INSERT INTO banktransfer_blz VALUES(50130400, 'Merck Finck & Co', '10');
INSERT INTO banktransfer_blz VALUES(50130600, 'UBS Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(50150000, 'Westdeutsche Landesbank Ndl Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50190000, 'Frankfurter Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(50190300, 'Volksbank Höchst', '06');
INSERT INTO banktransfer_blz VALUES(50190400, 'Volksbank Griesheim', '06');
INSERT INTO banktransfer_blz VALUES(50210111, 'SEB TZN Clearing', '13');
INSERT INTO banktransfer_blz VALUES(50210112, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210130, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210131, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210132, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210133, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210134, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210135, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210136, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210137, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210138, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210139, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210140, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210141, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210142, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210143, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210144, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210145, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210146, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210147, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210148, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210149, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210150, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210151, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210152, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210153, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210154, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210155, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210156, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210157, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210158, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210159, 'SEB TZN MB Ffm.', '09');
INSERT INTO banktransfer_blz VALUES(50210160, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210161, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210162, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210163, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210164, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210165, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210166, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210167, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210168, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210169, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210170, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210171, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210172, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210173, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210174, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210175, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210176, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210177, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210178, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210179, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210180, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210181, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210182, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210183, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210184, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210185, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210186, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210187, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210188, 'SEB TZN MB Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50210189, 'SEB TZN MB Frankfurt', '21');
INSERT INTO banktransfer_blz VALUES(50210200, 'Rabobank International Frankfurt Branch', '18');
INSERT INTO banktransfer_blz VALUES(50210300, 'Eurohypo', '09');
INSERT INTO banktransfer_blz VALUES(50210400, 'Eurohypo ehem Rheinische Hypothekenbank', '09');
INSERT INTO banktransfer_blz VALUES(50210600, 'equinet Bank', '91');
INSERT INTO banktransfer_blz VALUES(50210900, 'Citigroup Global Markets Deutschland', '06');
INSERT INTO banktransfer_blz VALUES(50220085, 'UBS Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(50220200, 'LGT Bank Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(50220500, 'Bank of Scotland', '00');
INSERT INTO banktransfer_blz VALUES(50220900, 'Hauck & Aufhäuser Privatbankiers', '00');
INSERT INTO banktransfer_blz VALUES(50230000, 'ABC International Bank Frankfurt am Main', '00');
INSERT INTO banktransfer_blz VALUES(50230100, 'Morgan Stanley Bank Internaional', '09');
INSERT INTO banktransfer_blz VALUES(50230300, 'FCB Firmen-Credit Bank', '06');
INSERT INTO banktransfer_blz VALUES(50230400, 'The Royal Bank of Scotland, Niederlassung Deutschland', '10');
INSERT INTO banktransfer_blz VALUES(50230600, 'Isbank', '06');
INSERT INTO banktransfer_blz VALUES(50230700, 'Metzler, B. - seel Sohn & Co', '00');
INSERT INTO banktransfer_blz VALUES(50230800, 'Ikano Bank', '09');
INSERT INTO banktransfer_blz VALUES(50250200, 'Deutsche Leasing Finance', '09');
INSERT INTO banktransfer_blz VALUES(50310400, 'Barclays Bank Frankfurt', '46');
INSERT INTO banktransfer_blz VALUES(50310455, 'Reiseschecks - Barclays Bank Frankfurt', '46');
INSERT INTO banktransfer_blz VALUES(50310900, 'China Construction Bank Ndl Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50320000, 'VTB Bank (Deutschland)', '00');
INSERT INTO banktransfer_blz VALUES(50320191, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(50320500, 'Banco Santander Filiale Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50320600, 'Attijariwafa bank Europa ZNdl. Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(50320900, 'Pictet & Cie (Europe) Ndl Frankfurt am Main', '09');
INSERT INTO banktransfer_blz VALUES(50324000, 'ABN AMRO Bank, Frankfurt Branch', '31');
INSERT INTO banktransfer_blz VALUES(50324040, 'ABN AMRO Bank, MoneYou', '31');
INSERT INTO banktransfer_blz VALUES(50330000, 'State Bank of India', '06');
INSERT INTO banktransfer_blz VALUES(50330200, 'MHB-Bank', '06');
INSERT INTO banktransfer_blz VALUES(50330300, 'The Bank of New York Mellon', '09');
INSERT INTO banktransfer_blz VALUES(50330500, 'BANQUE CHAABI DU MAROC Agentur Frankfurt Ndl. Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(50330600, 'Bank Sepah-Iran', '09');
INSERT INTO banktransfer_blz VALUES(50330700, 'Valovis Commercial Bank', '09');
INSERT INTO banktransfer_blz VALUES(50400000, 'Bundesbank Zentrale', '09');
INSERT INTO banktransfer_blz VALUES(50510111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(50510120, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510121, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510122, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510123, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510124, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510125, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510126, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510127, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510128, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510129, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510130, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510131, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510132, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510133, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510134, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510135, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510136, 'SEB TZN MB Ffm', '21');
INSERT INTO banktransfer_blz VALUES(50510137, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510138, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510139, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510140, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510141, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510142, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510143, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510144, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510145, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510146, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510147, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510148, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510149, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510150, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510151, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510152, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510153, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510154, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510155, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510156, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510157, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510158, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510159, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510160, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510161, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510162, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510163, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510164, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510165, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510166, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510167, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510168, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510169, 'SEB TZN MB Ffm', '21');
INSERT INTO banktransfer_blz VALUES(50510170, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510171, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510172, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510173, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510174, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510175, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510176, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510177, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510178, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510179, 'SEB TZN MB Ffm', '09');
INSERT INTO banktransfer_blz VALUES(50510180, 'SEB TZN MB Ffm', '21');
INSERT INTO banktransfer_blz VALUES(50520000, 'Honda Bank', '00');
INSERT INTO banktransfer_blz VALUES(50520190, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(50522222, 'FIDOR Bank Zndl Frankfurt am Main', '09');
INSERT INTO banktransfer_blz VALUES(50530000, 'Cronbank', '06');
INSERT INTO banktransfer_blz VALUES(50530001, 'CRONBANK Zw CS', '06');
INSERT INTO banktransfer_blz VALUES(50540028, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(50550020, 'Städtische Sparkasse Offenbach', '06');
INSERT INTO banktransfer_blz VALUES(50560102, 'Raiffeisenbank Offenbach/M.-Bieber', '32');
INSERT INTO banktransfer_blz VALUES(50561315, 'Vereinigte Volksbank Maingau', '32');
INSERT INTO banktransfer_blz VALUES(50570018, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(50570024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(50580005, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(50580085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(50590000, 'Offenbacher Volksbank -alt-', '06');
INSERT INTO banktransfer_blz VALUES(50592200, 'Volksbank Dreieich', '32');
INSERT INTO banktransfer_blz VALUES(50600000, 'Bundesbank eh Hanau', '09');
INSERT INTO banktransfer_blz VALUES(50620700, 'Hanseatic Bank', '16');
INSERT INTO banktransfer_blz VALUES(50640015, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(50650023, 'SPARKASSE HANAU', '00');
INSERT INTO banktransfer_blz VALUES(50652124, 'Sparkasse Langen-Seligenstadt', '00');
INSERT INTO banktransfer_blz VALUES(50661639, 'VR Bank Main-Kinzig-Büdingen', '32');
INSERT INTO banktransfer_blz VALUES(50661816, 'Volksbank Heldenbergen Ndl d Frankfurter VB', '06');
INSERT INTO banktransfer_blz VALUES(50662299, 'Raiffeisenbank Bruchköbel -alt-', '32');
INSERT INTO banktransfer_blz VALUES(50662669, 'Raiffeisenbank Maintal Ndl d Frankfurter VB', '32');
INSERT INTO banktransfer_blz VALUES(50663699, 'Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(50670009, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(50670024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(50680002, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(50680085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(50690000, 'Volksbank Raiffeisenbank Hanau Ndl d Frankf VB', '32');
INSERT INTO banktransfer_blz VALUES(50691300, 'DZB BANK', '09');
INSERT INTO banktransfer_blz VALUES(50692100, 'Volksbank Seligenstadt', '06');
INSERT INTO banktransfer_blz VALUES(50740048, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(50750094, 'Kreissparkasse Gelnhausen', '01');
INSERT INTO banktransfer_blz VALUES(50761333, 'Volksbank -alt-', '06');
INSERT INTO banktransfer_blz VALUES(50761613, 'Volksbank Büdingen -alt-', '32');
INSERT INTO banktransfer_blz VALUES(50763319, 'Raiffeisenbank Vogelsberg', '32');
INSERT INTO banktransfer_blz VALUES(50780006, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(50790000, 'VR Bank Bad Orb-Gelnhausen', '32');
INSERT INTO banktransfer_blz VALUES(50793300, 'Birsteiner Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(50794300, 'VR Bank Wächtersbach/Bad Soden-Salmünster -alt', '32');
INSERT INTO banktransfer_blz VALUES(50800000, 'Bundesbank eh Darmstadt', '09');
INSERT INTO banktransfer_blz VALUES(50810900, 'DBS Deutsche Bausparkasse', '09');
INSERT INTO banktransfer_blz VALUES(50820292, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(50835800, 'MCE Bank', '09');
INSERT INTO banktransfer_blz VALUES(50840005, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(50850049, 'Landesbank Hessen-Thür Girozentrale', '00');
INSERT INTO banktransfer_blz VALUES(50850150, 'Stadt- und Kreis-Sparkasse Darmstadt', '06');
INSERT INTO banktransfer_blz VALUES(50851952, 'Sparkasse Odenwaldkreis', '00');
INSERT INTO banktransfer_blz VALUES(50852553, 'Kreissparkasse Groß-Gerau', '00');
INSERT INTO banktransfer_blz VALUES(50852651, 'Sparkasse Dieburg', '00');
INSERT INTO banktransfer_blz VALUES(50861393, 'Spar- und Darlehnskasse Zell -alt-', '32');
INSERT INTO banktransfer_blz VALUES(50861501, 'Raiffeisenbank Nördliche Bergstraße', '32');
INSERT INTO banktransfer_blz VALUES(50862311, 'Volksbank Gräfenhausen -alt-', '32');
INSERT INTO banktransfer_blz VALUES(50862408, 'Vereinigte Volksbank Griesheim-Weiterstadt', '32');
INSERT INTO banktransfer_blz VALUES(50862703, 'Volksbank Gersprenztal-Otzberg', '32');
INSERT INTO banktransfer_blz VALUES(50862835, 'Raiffeisenbank Schaafheim', '32');
INSERT INTO banktransfer_blz VALUES(50862903, 'Volksbank Mainspitze', '32');
INSERT INTO banktransfer_blz VALUES(50863317, 'Volksbank Seeheim-Jugenheim', '32');
INSERT INTO banktransfer_blz VALUES(50863513, 'Volksbank Odenwald', '32');
INSERT INTO banktransfer_blz VALUES(50863906, 'Volksbank Modautal Modau', '32');
INSERT INTO banktransfer_blz VALUES(50864322, 'Volksbank Modau', '32');
INSERT INTO banktransfer_blz VALUES(50864808, 'Volksbank Seeheim-Jugenheim', '32');
INSERT INTO banktransfer_blz VALUES(50865224, 'VB Mörfelden-Walldorf Ndl d Frankfurter VB', '32');
INSERT INTO banktransfer_blz VALUES(50865503, 'Volksbank', '32');
INSERT INTO banktransfer_blz VALUES(50870005, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(50870024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(50880050, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(50880085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(50880086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(50890000, 'Volksbank Darmstadt - Kreis Bergstraße', '06');
INSERT INTO banktransfer_blz VALUES(50890634, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(50892500, 'Groß-Gerauer Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(50950068, 'Sparkasse Bensheim', '00');
INSERT INTO banktransfer_blz VALUES(50951469, 'Sparkasse Starkenburg', '01');
INSERT INTO banktransfer_blz VALUES(50960101, 'Volksbank Bergstraße -alt-', '32');
INSERT INTO banktransfer_blz VALUES(50961206, 'Raiffeisenbank Ried', '32');
INSERT INTO banktransfer_blz VALUES(50961312, 'Raiffeisenbank Groß-Rohrheim', '32');
INSERT INTO banktransfer_blz VALUES(50961592, 'Volksbank Weschnitztal', '32');
INSERT INTO banktransfer_blz VALUES(50961685, 'Volksbank Überwald-Gorxheimertal', '32');
INSERT INTO banktransfer_blz VALUES(50970004, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(50970024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(50991400, 'Volksbank Kreis Bergstraße -alt-', '06');
INSERT INTO banktransfer_blz VALUES(51000000, 'Bundesbank eh Wiesbaden', '09');
INSERT INTO banktransfer_blz VALUES(51010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(51010400, 'Aareal Bank', '09');
INSERT INTO banktransfer_blz VALUES(51010800, 'Aareal Bank Zw L', '09');
INSERT INTO banktransfer_blz VALUES(51020000, 'BHF-BANK', '60');
INSERT INTO banktransfer_blz VALUES(51020186, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(51040038, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(51050015, 'Nassauische Sparkasse', 'A2');
INSERT INTO banktransfer_blz VALUES(51070021, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(51070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(51080060, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(51080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(51080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK2', '09');
INSERT INTO banktransfer_blz VALUES(51089410, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(51090000, 'Wiesbadener Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(51090636, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(51091400, 'Volksbank Eltville -alt-', '06');
INSERT INTO banktransfer_blz VALUES(51091500, 'Rheingauer Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(51091700, 'vr bank Untertaunus', '06');
INSERT INTO banktransfer_blz VALUES(51091711, 'Bank f Orden u Mission Zndl vr bk Untertaunus', '06');
INSERT INTO banktransfer_blz VALUES(51140029, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(51150018, 'Kreissparkasse Limburg', '00');
INSERT INTO banktransfer_blz VALUES(51151919, 'Kreissparkasse Weilburg', '00');
INSERT INTO banktransfer_blz VALUES(51161606, 'Volksbank Langendernbach', '32');
INSERT INTO banktransfer_blz VALUES(51170010, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(51170024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(51180041, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(51190000, 'Vereinigte Volksbank Limburg', '06');
INSERT INTO banktransfer_blz VALUES(51191200, 'Volksbank Goldner Grund', '06');
INSERT INTO banktransfer_blz VALUES(51191800, 'Volksbank Schupbach', '06');
INSERT INTO banktransfer_blz VALUES(51192200, 'Volks- und Raiffeisenbank Weilmünster -alt-', '32');
INSERT INTO banktransfer_blz VALUES(51210600, 'BNP PARIBAS Ndl Frankfurt, Main', '00');
INSERT INTO banktransfer_blz VALUES(51210700, 'NIBC Bank Zndl Frankfurt am Main', '06');
INSERT INTO banktransfer_blz VALUES(51210800, 'Societe Generale', '09');
INSERT INTO banktransfer_blz VALUES(51220200, 'SEB Merchant Banking', '09');
INSERT INTO banktransfer_blz VALUES(51220400, 'Bank Saderat Iran', '09');
INSERT INTO banktransfer_blz VALUES(51220700, 'ZIRAAT BANK International', '09');
INSERT INTO banktransfer_blz VALUES(51220800, 'Banco do Brasil', '09');
INSERT INTO banktransfer_blz VALUES(51220900, 'Morgan Stanley Bank', '09');
INSERT INTO banktransfer_blz VALUES(51220910, 'Morgan Stanley Bank', '50');
INSERT INTO banktransfer_blz VALUES(51230100, 'Eurohypo ehem. Deutsche Hypothekenbank', '09');
INSERT INTO banktransfer_blz VALUES(51230400, 'RBS ( Deutschland ) Frankfurt am Main', '10');
INSERT INTO banktransfer_blz VALUES(51230500, 'Standard Chartered Bank Germany Branch, Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(51230502, 'ETC Standard Chartered Bank Germany Branch', '09');
INSERT INTO banktransfer_blz VALUES(51230600, 'Europe ARAB Bank', '09');
INSERT INTO banktransfer_blz VALUES(51230800, 'Wirecard Bank', '09');
INSERT INTO banktransfer_blz VALUES(51230801, 'Wirecard Bank', '09');
INSERT INTO banktransfer_blz VALUES(51230802, 'Wirecard Bank', '09');
INSERT INTO banktransfer_blz VALUES(51230805, 'Wirecard Bank', '09');
INSERT INTO banktransfer_blz VALUES(51250000, 'Taunus-Sparkasse', '06');
INSERT INTO banktransfer_blz VALUES(51300000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(51310111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(51340013, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(51343224, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(51350025, 'Sparkasse Gießen', '10');
INSERT INTO banktransfer_blz VALUES(51351526, 'Sparkasse Grünberg', '00');
INSERT INTO banktransfer_blz VALUES(51352227, 'Sparkasse Laubach-Hungen', '00');
INSERT INTO banktransfer_blz VALUES(51361021, 'Volksbank Heuchelheim', '32');
INSERT INTO banktransfer_blz VALUES(51361704, 'Volksbank Holzheim -alt-', '32');
INSERT INTO banktransfer_blz VALUES(51362514, 'VR Bank Mücke -alt-', '32');
INSERT INTO banktransfer_blz VALUES(51363407, 'Volksbank Garbenteich -alt-', '32');
INSERT INTO banktransfer_blz VALUES(51370008, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(51370024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(51380040, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(51380085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(51390000, 'Volksbank Mittelhessen', '06');
INSERT INTO banktransfer_blz VALUES(51410111, 'SEB direct', '13');
INSERT INTO banktransfer_blz VALUES(51410600, 'Merrill Lynch International Bank Limited Zndl Frankfurt', '09');
INSERT INTO banktransfer_blz VALUES(51410700, 'Bank of China', '09');
INSERT INTO banktransfer_blz VALUES(51410800, 'OnVista Bank', '09');
INSERT INTO banktransfer_blz VALUES(51420200, 'Misr Bank-Europe', '00');
INSERT INTO banktransfer_blz VALUES(51420300, 'Bank Julius Bär Europe', '17');
INSERT INTO banktransfer_blz VALUES(51420600, 'Svenska Handelsbanken Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(51430300, 'Nordea Bank Finland', '09');
INSERT INTO banktransfer_blz VALUES(51430400, 'Goldman, Sachs & Co', '09');
INSERT INTO banktransfer_blz VALUES(51540037, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(51550035, 'Sparkasse Wetzlar', '00');
INSERT INTO banktransfer_blz VALUES(51560231, 'Volksbank Wetzlar-Weilburg -alt-', '32');
INSERT INTO banktransfer_blz VALUES(51570008, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(51570024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(51580044, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(51591300, 'Volksbank Brandoberndorf', '06');
INSERT INTO banktransfer_blz VALUES(51640043, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(51650045, 'Sparkasse Dillenburg', '00');
INSERT INTO banktransfer_blz VALUES(51690000, 'Volksbank Dill VB und Raiffbk', '06');
INSERT INTO banktransfer_blz VALUES(51691500, 'Volksbank Herborn-Eschenburg', '06');
INSERT INTO banktransfer_blz VALUES(51752267, 'Sparkasse Battenberg', '00');
INSERT INTO banktransfer_blz VALUES(51762434, 'VR Bank Biedenkopf-Gladenbach', '06');
INSERT INTO banktransfer_blz VALUES(51850079, 'Sparkasse Oberhessen', '06');
INSERT INTO banktransfer_blz VALUES(51861325, 'BVB Volksbank Ndl d Frankfurter Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(51861403, 'Volksbank Butzbach', '32');
INSERT INTO banktransfer_blz VALUES(51861616, 'Landbank Horlofftal', '32');
INSERT INTO banktransfer_blz VALUES(51861806, 'Volksbank Ober-Mörlen', '32');
INSERT INTO banktransfer_blz VALUES(51862677, 'Weiseler Volksbank -alt-', '32');
INSERT INTO banktransfer_blz VALUES(51961023, 'Volksbank', '32');
INSERT INTO banktransfer_blz VALUES(51961515, 'Spar- und Darlehnskasse Stockhausen', '32');
INSERT INTO banktransfer_blz VALUES(51961801, 'Volksbank Feldatal', '32');
INSERT INTO banktransfer_blz VALUES(51990000, 'Volksbank Lauterbach-Schlitz', '06');
INSERT INTO banktransfer_blz VALUES(52000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(52010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(52040021, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(52050000, 'Landeskreditkasse Kassel', '00');
INSERT INTO banktransfer_blz VALUES(52050353, 'Kasseler Sparkasse', '05');
INSERT INTO banktransfer_blz VALUES(52051373, 'Stadtsparkasse Borken (Hessen)', '00');
INSERT INTO banktransfer_blz VALUES(52051555, 'Stadtsparkasse Felsberg', '00');
INSERT INTO banktransfer_blz VALUES(52051877, 'Stadtsparkasse Grebenstein', '00');
INSERT INTO banktransfer_blz VALUES(52052154, 'Kreissparkasse Schwalm-Eder', '00');
INSERT INTO banktransfer_blz VALUES(52053458, 'Stadtsparkasse Schwalmstadt', '00');
INSERT INTO banktransfer_blz VALUES(52060000, 'DZ BANK', '09');
INSERT INTO banktransfer_blz VALUES(52060208, 'Kurhessische Landbank', '32');
INSERT INTO banktransfer_blz VALUES(52060400, 'Evangelische Kreditgenossenschaft Gf', '32');
INSERT INTO banktransfer_blz VALUES(52060410, 'Evangelische Kreditgenossenschaft', '32');
INSERT INTO banktransfer_blz VALUES(52061210, 'Genossenschaftsbank Bad Wildungen -alt-', '32');
INSERT INTO banktransfer_blz VALUES(52061303, 'Raiffeisenbank Borken', '32');
INSERT INTO banktransfer_blz VALUES(52062200, 'VR-Bank Chattengau', '32');
INSERT INTO banktransfer_blz VALUES(52062601, 'VR-Bank Schwalm-Eder', '32');
INSERT INTO banktransfer_blz VALUES(52062699, 'Volks- Raiffeisenbank Gf GAA', '32');
INSERT INTO banktransfer_blz VALUES(52063369, 'VR-Bank Spangenberg-Morschen', '32');
INSERT INTO banktransfer_blz VALUES(52063550, 'Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(52064156, 'Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(52065220, 'Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(52069013, 'Raiffeisenbank Burghaun', '32');
INSERT INTO banktransfer_blz VALUES(52069029, 'Spar-u. Kredit-Bank', '32');
INSERT INTO banktransfer_blz VALUES(52069065, 'Raiffeisenbank Langenschwarz', '32');
INSERT INTO banktransfer_blz VALUES(52069103, 'Raiffeisenbank Trendelburg', '32');
INSERT INTO banktransfer_blz VALUES(52069129, 'Raiffeisenbank Freienhagen-Höringhausen -alt-', '32');
INSERT INTO banktransfer_blz VALUES(52069149, 'Raiffeisenbank Volkmarsen', '32');
INSERT INTO banktransfer_blz VALUES(52069183, 'Raiffeisenbank Bottendorf -alt-', '32');
INSERT INTO banktransfer_blz VALUES(52069503, 'Raiffeisenbank Ulmbach -alt-', '32');
INSERT INTO banktransfer_blz VALUES(52069519, 'Frankenberger Bank Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(52070012, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(52070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(52071212, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(52071224, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(52080080, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(52080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK1', '09');
INSERT INTO banktransfer_blz VALUES(52090000, 'Kasseler Bank', '06');
INSERT INTO banktransfer_blz VALUES(52090611, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(52240006, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(52250030, 'Sparkasse Werra-Meißner', '00');
INSERT INTO banktransfer_blz VALUES(52260385, 'VR-Bank Werra-Meißner', '32');
INSERT INTO banktransfer_blz VALUES(52270012, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(52270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(52350005, 'Sparkasse Waldeck-Frankenberg', '00');
INSERT INTO banktransfer_blz VALUES(52360059, 'Waldecker Bank', '32');
INSERT INTO banktransfer_blz VALUES(52410300, 'Reisebank', '09');
INSERT INTO banktransfer_blz VALUES(52410310, 'ReiseBank Gf2', '09');
INSERT INTO banktransfer_blz VALUES(52410400, 'Korea Exchange Bank (Deutschland)', '19');
INSERT INTO banktransfer_blz VALUES(52410600, 'NEWEDGE GROUP (Frankfurt Branch) Zndl d NewedgeGroup', '09');
INSERT INTO banktransfer_blz VALUES(52410700, 'ABN AMRO Clearing Bank, Frankfurt Branch', '09');
INSERT INTO banktransfer_blz VALUES(52410900, 'Maple Bank', '09');
INSERT INTO banktransfer_blz VALUES(52411000, 'Cash Express Gesellschaft f Finanz-u Reisedienstleistungen', '09');
INSERT INTO banktransfer_blz VALUES(52411010, 'Cash Express Gesellschaft f.Finanz-u.Reisedienstleistungen', '09');
INSERT INTO banktransfer_blz VALUES(52420000, 'Credit Agricole CIB Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(52420300, 'SHINHAN BANK EUROPE', '09');
INSERT INTO banktransfer_blz VALUES(52420600, 'Agricultural Bank of Greece Frankfurt Branch', '30');
INSERT INTO banktransfer_blz VALUES(52420700, 'SECB Swiss Euro Clearing Bank', '09');
INSERT INTO banktransfer_blz VALUES(52430000, 'Credit Mutuel - BECM - Ndl Deutschland', '00');
INSERT INTO banktransfer_blz VALUES(52430100, 'Banque Federative Credit Mutuel Ndl Deutschl', '09');
INSERT INTO banktransfer_blz VALUES(53000000, 'Bundesbank eh Fulda', '09');
INSERT INTO banktransfer_blz VALUES(53040012, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(53050180, 'Sparkasse Fulda', '01');
INSERT INTO banktransfer_blz VALUES(53051396, 'Kreissparkasse Schlüchtern', '01');
INSERT INTO banktransfer_blz VALUES(53060180, 'VR Genossenschaftsbank Fulda', '32');
INSERT INTO banktransfer_blz VALUES(53061230, 'VR-Bank NordRhön', '32');
INSERT INTO banktransfer_blz VALUES(53061313, 'Volksbank Raiffeisenbank Schlüchtern', '32');
INSERT INTO banktransfer_blz VALUES(53062035, 'Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(53062350, 'Raiffeisenbank Biebergrund-Petersberg', '32');
INSERT INTO banktransfer_blz VALUES(53064023, 'Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(53070007, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(53070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(53080030, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(53093200, 'VR Bank HessenLand', '32');
INSERT INTO banktransfer_blz VALUES(53093255, 'AgrarBank', '32');
INSERT INTO banktransfer_blz VALUES(53200000, 'Bundesbank eh Bad Hersfeld', '09');
INSERT INTO banktransfer_blz VALUES(53240048, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(53250000, 'Sparkasse Bad Hersfeld-Rotenburg', 'A6');
INSERT INTO banktransfer_blz VALUES(53260145, 'Raiffeisenbank Asbach-Sorga', '32');
INSERT INTO banktransfer_blz VALUES(53261202, 'Bankverein Bebra', '32');
INSERT INTO banktransfer_blz VALUES(53261342, 'Raiffeisenbank Werratal-Landeck', '32');
INSERT INTO banktransfer_blz VALUES(53261700, 'Raiffeisenbank Aulatal -alt-', '32');
INSERT INTO banktransfer_blz VALUES(53262073, 'Raiffeisenbank Haunetal', '32');
INSERT INTO banktransfer_blz VALUES(53262455, 'Raiffeisenbank Ronshausen-Marksuhl', '32');
INSERT INTO banktransfer_blz VALUES(53270012, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(53270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(53280081, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(53290000, 'VR-Bank Bad Hersfeld-Rotenburg', '06');
INSERT INTO banktransfer_blz VALUES(53340024, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(53350000, 'Sparkasse Marburg-Biedenkopf', '06');
INSERT INTO banktransfer_blz VALUES(53361724, 'Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(53370008, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(53370024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(53380042, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(53381843, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(53390635, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(54000000, 'Bundesbank eh Kaiserslautern', '09');
INSERT INTO banktransfer_blz VALUES(54020090, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(54020474, 'UniCredit Bank - HypoVereinsbank Ndl 697 Kais', '99');
INSERT INTO banktransfer_blz VALUES(54030011, 'Service Credit Union Overseas Headquarters', '09');
INSERT INTO banktransfer_blz VALUES(54040042, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(54050110, 'Stadtsparkasse Kaiserslautern', '00');
INSERT INTO banktransfer_blz VALUES(54050220, 'Kreissparkasse Kaiserslautern', '00');
INSERT INTO banktransfer_blz VALUES(54051550, 'Kreissparkasse Kusel', '00');
INSERT INTO banktransfer_blz VALUES(54051660, 'Stadtsparkasse Landstuhl -alt-', 'B2');
INSERT INTO banktransfer_blz VALUES(54051990, 'Sparkasse Donnersberg', '00');
INSERT INTO banktransfer_blz VALUES(54061650, 'VR-Bank Westpfalz', '32');
INSERT INTO banktransfer_blz VALUES(54062027, 'Raiffeisenbank Donnersberg -alt-', '32');
INSERT INTO banktransfer_blz VALUES(54070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(54070092, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(54080021, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(54090000, 'Volksbank Kaiserslautern-Nordwestpfalz', '06');
INSERT INTO banktransfer_blz VALUES(54091700, 'Volksbank Lauterecken', '06');
INSERT INTO banktransfer_blz VALUES(54091800, 'VR Bank Nordwestpfalz -alt-', '06');
INSERT INTO banktransfer_blz VALUES(54092400, 'Volksbank Glan-Münchweiler', '06');
INSERT INTO banktransfer_blz VALUES(54210111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(54220091, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(54220576, 'UniCredit Bank - HypoVereinsbank Ndl 358 Pirm', '99');
INSERT INTO banktransfer_blz VALUES(54240032, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(54250010, 'Sparkasse Südwestpfalz', '00');
INSERT INTO banktransfer_blz VALUES(54261700, 'VR-Bank Südwestpfalz', '32');
INSERT INTO banktransfer_blz VALUES(54262330, 'Raiffeisenbank Vinningen -alt-', '32');
INSERT INTO banktransfer_blz VALUES(54270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(54270096, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(54280023, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(54290000, 'VR-Bank Pirmasens', '06');
INSERT INTO banktransfer_blz VALUES(54291200, 'Raiffeisen- u Volksbank Dahn', '32');
INSERT INTO banktransfer_blz VALUES(54500000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(54510067, 'Postbank', '24');
INSERT INTO banktransfer_blz VALUES(54520071, 'UniCredit Bank - HypoVereinsbank Ndl 650 Lu', '99');
INSERT INTO banktransfer_blz VALUES(54520194, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(54540033, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(54550010, 'Sparkasse Vorderpfalz', '00');
INSERT INTO banktransfer_blz VALUES(54550120, 'Kreissparkasse Rhein-Pfalz', '00');
INSERT INTO banktransfer_blz VALUES(54560320, 'VR Bank Ludwigshafen -alt-', '32');
INSERT INTO banktransfer_blz VALUES(54561310, 'RV Bank Rhein-Haardt', '32');
INSERT INTO banktransfer_blz VALUES(54570024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(54570094, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(54580020, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(54620093, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(54620574, 'UniCredit Bank - HypoVereinsbank Ndl 660 Ne/W', '99');
INSERT INTO banktransfer_blz VALUES(54640035, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(54651240, 'Sparkasse Rhein-Haardt', '00');
INSERT INTO banktransfer_blz VALUES(54661800, 'Raiffeisenbank Freinsheim', '32');
INSERT INTO banktransfer_blz VALUES(54663270, 'Raiffeisenbank Friedelsheim-Rödersheim', '32');
INSERT INTO banktransfer_blz VALUES(54670024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(54670095, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(54680022, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(54690623, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(54691200, 'VR Bank Mittelhaardt', '06');
INSERT INTO banktransfer_blz VALUES(54750010, 'Kreis- und Stadtsparkasse Speyer', '00');
INSERT INTO banktransfer_blz VALUES(54760900, 'Evangelische Kreditgenossenschaft - Filiale Speyer-', '32');
INSERT INTO banktransfer_blz VALUES(54761411, 'Raiffeisenbank Schifferstadt', '32');
INSERT INTO banktransfer_blz VALUES(54790000, 'Volksbank Kur- und Rheinpfalz', '06');
INSERT INTO banktransfer_blz VALUES(54820674, 'UniCredit Bank - HypoVereinsbank Ndl 659 LanP', '99');
INSERT INTO banktransfer_blz VALUES(54850010, 'Sparkasse Südliche Weinstraße in Landau', '00');
INSERT INTO banktransfer_blz VALUES(54851440, 'Sparkasse Germersheim-Kandel', '00');
INSERT INTO banktransfer_blz VALUES(54861190, 'Raiffeisenbank Oberhaardt-Gäu', '32');
INSERT INTO banktransfer_blz VALUES(54862390, 'Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(54862500, 'VR Bank Südpfalz', '32');
INSERT INTO banktransfer_blz VALUES(54891300, 'VR Bank Südliche Weinstraße', '06');
INSERT INTO banktransfer_blz VALUES(55000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(55010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(55010400, 'Aareal Bank GF - BK01 -', '01');
INSERT INTO banktransfer_blz VALUES(55010424, 'Aareal Bank', '09');
INSERT INTO banktransfer_blz VALUES(55010625, 'Aareal Bank Clearing Wiesbaden', '09');
INSERT INTO banktransfer_blz VALUES(55010800, 'Investitions- und Strukturbank RP', '09');
INSERT INTO banktransfer_blz VALUES(55020000, 'BHF-BANK', '60');
INSERT INTO banktransfer_blz VALUES(55020100, 'Bausparkasse Mainz', '09');
INSERT INTO banktransfer_blz VALUES(55020486, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(55020500, 'Bank für Sozialwirtschaft', '09');
INSERT INTO banktransfer_blz VALUES(55020600, 'Westdeutsche Immobilien Bank', '08');
INSERT INTO banktransfer_blz VALUES(55020700, 'Süd-West-Kreditbank Finanzierung', '16');
INSERT INTO banktransfer_blz VALUES(55030500, 'GE Capital Bank', '09');
INSERT INTO banktransfer_blz VALUES(55030533, 'GE Capital Direkt', '06');
INSERT INTO banktransfer_blz VALUES(55033300, 'Santander Consumer Bank', '09');
INSERT INTO banktransfer_blz VALUES(55040022, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(55040060, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(55040061, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(55050000, 'ZV Landesbank Baden-Württemberg', '59');
INSERT INTO banktransfer_blz VALUES(55050120, 'Sparkasse Mainz', '00');
INSERT INTO banktransfer_blz VALUES(55060321, 'VR-Bank Mainz', '32');
INSERT INTO banktransfer_blz VALUES(55060417, 'VR-Bank Mainz', '32');
INSERT INTO banktransfer_blz VALUES(55060611, 'Genobank Mainz', '32');
INSERT INTO banktransfer_blz VALUES(55060831, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(55061303, 'Budenheimer Volksbank', '32');
INSERT INTO banktransfer_blz VALUES(55061507, 'VR-Bank Mainz', '32');
INSERT INTO banktransfer_blz VALUES(55061907, 'Volksbank Rhein-Selz -alt-', '32');
INSERT INTO banktransfer_blz VALUES(55070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(55070040, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(55080044, 'Commerzbank, TF MZ 1', '76');
INSERT INTO banktransfer_blz VALUES(55080065, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(55080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(55080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(55080088, 'Commerzbank, TF MZ 2', '76');
INSERT INTO banktransfer_blz VALUES(55090500, 'Sparda-Bank Südwest', '90');
INSERT INTO banktransfer_blz VALUES(55091200, 'Volksbank Alzey', '06');
INSERT INTO banktransfer_blz VALUES(55150098, 'Clearingkonto LRP-SI', '09');
INSERT INTO banktransfer_blz VALUES(55160195, 'Pax-Bank', '06');
INSERT INTO banktransfer_blz VALUES(55190000, 'Mainzer Volksbank', '00');
INSERT INTO banktransfer_blz VALUES(55190028, 'Mainzer Volksbank', '00');
INSERT INTO banktransfer_blz VALUES(55190050, 'Mainzer Volksbank', '00');
INSERT INTO banktransfer_blz VALUES(55190064, 'Mainzer Volksbank', '00');
INSERT INTO banktransfer_blz VALUES(55190065, 'Mainzer Volksbank', '00');
INSERT INTO banktransfer_blz VALUES(55190068, 'Mainzer Volksbank', '00');
INSERT INTO banktransfer_blz VALUES(55190088, 'Mainzer Volksbank', '00');
INSERT INTO banktransfer_blz VALUES(55190094, 'Mainzer Volksbank', '00');
INSERT INTO banktransfer_blz VALUES(55340041, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(55350010, 'Sparkasse Worms-Alzey-Ried', '03');
INSERT INTO banktransfer_blz VALUES(55360784, 'Volksbank Rheindürkheim -alt-', '32');
INSERT INTO banktransfer_blz VALUES(55361202, 'Raiffeisenbank Alsheim-Gimbsheim', '32');
INSERT INTO banktransfer_blz VALUES(55362071, 'Volksbank Bechtheim', '32');
INSERT INTO banktransfer_blz VALUES(55390000, 'Volksbank Worms-Wonnegau', '06');
INSERT INTO banktransfer_blz VALUES(56000000, 'Bundesbank eh Bad Kreuznach', '09');
INSERT INTO banktransfer_blz VALUES(56020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(56050180, 'Sparkasse Rhein-Nahe', '00');
INSERT INTO banktransfer_blz VALUES(56051790, 'Kreissparkasse Rhein-Hunsrück', '00');
INSERT INTO banktransfer_blz VALUES(56061151, 'Raiffeisenbank Kastellaun', '38');
INSERT INTO banktransfer_blz VALUES(56061472, 'Volksbank Hunsrück-Nahe', '38');
INSERT INTO banktransfer_blz VALUES(56062227, 'Volksbank', '40');
INSERT INTO banktransfer_blz VALUES(56062577, 'Vereinigte Raiffeisenkassen', '38');
INSERT INTO banktransfer_blz VALUES(56070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(56070040, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(56090000, 'Volksbank Rhein-Nahe-Hunsrück', '38');
INSERT INTO banktransfer_blz VALUES(56240050, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(56250030, 'Kreissparkasse Birkenfeld', 'B2');
INSERT INTO banktransfer_blz VALUES(56261073, 'Volksbank Kirn-Sobernheim -alt-', '38');
INSERT INTO banktransfer_blz VALUES(56261735, 'Raiffeisenbank Nahe', '38');
INSERT INTO banktransfer_blz VALUES(56270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(56270044, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(56290000, 'Volksbank-Raiffeisenbank Naheland -alt-', '06');
INSERT INTO banktransfer_blz VALUES(57000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(57010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(57020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(57020301, 'MKB Mittelrheinische Bank', '09');
INSERT INTO banktransfer_blz VALUES(57020500, 'Oyak Anker Bank', 'D7');
INSERT INTO banktransfer_blz VALUES(57020600, 'Debeka Bausparkasse', '09');
INSERT INTO banktransfer_blz VALUES(57040044, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(57050120, 'Sparkasse Koblenz', '00');
INSERT INTO banktransfer_blz VALUES(57051001, 'Kreissparkasse Westerwald', '00');
INSERT INTO banktransfer_blz VALUES(57051870, 'Kreissparkasse Cochem-Zell -alt-', '00');
INSERT INTO banktransfer_blz VALUES(57060000, 'WGZ Bank', '44');
INSERT INTO banktransfer_blz VALUES(57060612, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(57062675, 'Raiffeisenbank', '38');
INSERT INTO banktransfer_blz VALUES(57063478, 'Volksbank Vallendar-Niederwerth', '38');
INSERT INTO banktransfer_blz VALUES(57064221, 'Volksbank Mülheim-Kärlich', '38');
INSERT INTO banktransfer_blz VALUES(57069067, 'Raiffeisenbank Lutzerather Höhe', '38');
INSERT INTO banktransfer_blz VALUES(57069081, 'Raiffeisenbank Moselkrampen', '38');
INSERT INTO banktransfer_blz VALUES(57069144, 'Raiffeisenbank Kaisersesch', '38');
INSERT INTO banktransfer_blz VALUES(57069238, 'Raiffeisenbank Neustadt', '38');
INSERT INTO banktransfer_blz VALUES(57069257, 'Raiffeisenbank Untermosel', '38');
INSERT INTO banktransfer_blz VALUES(57069315, 'Raiffeisenbank Straßenhaus -alt-', '38');
INSERT INTO banktransfer_blz VALUES(57069361, 'Raiffeisenbank Welling', '38');
INSERT INTO banktransfer_blz VALUES(57069526, 'Raiffeisenbank Idarwald -alt-', '38');
INSERT INTO banktransfer_blz VALUES(57069727, 'Raiffeisenbank Irrel', '38');
INSERT INTO banktransfer_blz VALUES(57069806, 'VR-Bank Hunsrück-Mosel', '38');
INSERT INTO banktransfer_blz VALUES(57069858, 'Raiffeisenbank Pronsfeld-Waxweiler Gs -alt-', '38');
INSERT INTO banktransfer_blz VALUES(57070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(57070045, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(57080070, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(57090000, 'Volksbank Koblenz Mittelrhein', '64');
INSERT INTO banktransfer_blz VALUES(57090900, 'PSD Bank Koblenz', '91');
INSERT INTO banktransfer_blz VALUES(57091000, 'Volksbank Montabaur-Höhr-Grenzhausen', '06');
INSERT INTO banktransfer_blz VALUES(57091100, 'Volksbank Höhr-Grenzhausen -alt-', '06');
INSERT INTO banktransfer_blz VALUES(57091500, 'Volksbank Boppard -alt-', '38');
INSERT INTO banktransfer_blz VALUES(57092800, 'Volksbank Rhein-Lahn', '06');
INSERT INTO banktransfer_blz VALUES(57263015, 'Raiffeisenbank Unterwesterwald', '38');
INSERT INTO banktransfer_blz VALUES(57351030, 'Kreissparkasse Altenkirchen', '00');
INSERT INTO banktransfer_blz VALUES(57361476, 'Volksbank Gebhardshain', '38');
INSERT INTO banktransfer_blz VALUES(57363243, 'Raiffeisenbank Niederfischbach -alt-', '38');
INSERT INTO banktransfer_blz VALUES(57391200, 'Volksbank Daaden', '06');
INSERT INTO banktransfer_blz VALUES(57391500, 'Volksbank Hamm, Sieg', '06');
INSERT INTO banktransfer_blz VALUES(57391800, 'Westerwald Bank', '06');
INSERT INTO banktransfer_blz VALUES(57400000, 'Bundesbank eh Neuwied', '09');
INSERT INTO banktransfer_blz VALUES(57450120, 'Sparkasse Neuwied', '00');
INSERT INTO banktransfer_blz VALUES(57460117, 'Volks- und Raiffeisenbank Neuwied-Linz', '38');
INSERT INTO banktransfer_blz VALUES(57461759, 'Raiffeisenbank Mittelrhein', '09');
INSERT INTO banktransfer_blz VALUES(57470024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(57470047, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(57650010, 'Kreissparkasse Mayen', '00');
INSERT INTO banktransfer_blz VALUES(57661253, 'Raiffeisenbank', '38');
INSERT INTO banktransfer_blz VALUES(57662263, 'VR Bank Rhein-Mosel', '38');
INSERT INTO banktransfer_blz VALUES(57751310, 'Kreissparkasse Ahrweiler', '00');
INSERT INTO banktransfer_blz VALUES(57761591, 'Volksbank RheinAhrEifel', '34');
INSERT INTO banktransfer_blz VALUES(57762265, 'Raiffeisenbank Grafschaft-Wachtberg', '38');
INSERT INTO banktransfer_blz VALUES(58500000, 'Bundesbank eh Trier', '09');
INSERT INTO banktransfer_blz VALUES(58510111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(58520086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(58540035, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(58550130, 'Sparkasse Trier', '00');
INSERT INTO banktransfer_blz VALUES(58560103, 'Volksbank Trier', '38');
INSERT INTO banktransfer_blz VALUES(58560294, 'Pax-Bank', '06');
INSERT INTO banktransfer_blz VALUES(58561250, 'Volksbank Hermeskeil -alt-', '38');
INSERT INTO banktransfer_blz VALUES(58561626, 'Volksbank Saarburg -alt-', '38');
INSERT INTO banktransfer_blz VALUES(58561771, 'Raiffeisenbank Mehring-Leiwen', '38');
INSERT INTO banktransfer_blz VALUES(58564788, 'Volksbank Hochwald-Saarburg', '38');
INSERT INTO banktransfer_blz VALUES(58570024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(58570048, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(58580074, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(58590900, 'PSD Bank Trier Ndl der PSD Bank Köln', '91');
INSERT INTO banktransfer_blz VALUES(58650030, 'Kreissparkasse Bitburg-Prüm', '00');
INSERT INTO banktransfer_blz VALUES(58651240, 'Kreissparkasse Vulkaneifel', '00');
INSERT INTO banktransfer_blz VALUES(58660101, 'Volksbank Bitburg', '38');
INSERT INTO banktransfer_blz VALUES(58661901, 'Raiffeisenbank Westeifel', '38');
INSERT INTO banktransfer_blz VALUES(58662653, 'Raiffeisenbank östl Südeifel', '38');
INSERT INTO banktransfer_blz VALUES(58668818, 'Raiffeisenbank Neuerburg-Land -alt-', '38');
INSERT INTO banktransfer_blz VALUES(58691500, 'Volksbank Eifel Mitte', '38');
INSERT INTO banktransfer_blz VALUES(58751230, 'Sparkasse Mittelmosel-Eifel Mosel Hunsrück', '00');
INSERT INTO banktransfer_blz VALUES(58760954, 'Vereinigte Volksbank Raiffeisenbank', '38');
INSERT INTO banktransfer_blz VALUES(58761343, 'Raiffeisenbank Zeller Land', '38');
INSERT INTO banktransfer_blz VALUES(58771224, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(58771242, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(58790100, 'Vereinigte Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(59000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(59010011, 'ZVC Postbank Gf FK 11', '09');
INSERT INTO banktransfer_blz VALUES(59010012, 'ZVC Postbank Gf FK 12', '09');
INSERT INTO banktransfer_blz VALUES(59010013, 'ZVC Postbank Gf FK 13', '09');
INSERT INTO banktransfer_blz VALUES(59010014, 'ZVC Postbank Gf FK 14', '09');
INSERT INTO banktransfer_blz VALUES(59010015, 'ZVC Postbank Gf FK 15', '09');
INSERT INTO banktransfer_blz VALUES(59010016, 'ZVC Postbank Gf FK 16', '09');
INSERT INTO banktransfer_blz VALUES(59010017, 'ZVC Postbank Gf FK 17', '09');
INSERT INTO banktransfer_blz VALUES(59010018, 'ZVC Postbank Gf FK 18', '09');
INSERT INTO banktransfer_blz VALUES(59010019, 'ZVC Postbank Gf FK 19', '09');
INSERT INTO banktransfer_blz VALUES(59010020, 'ZVC Postbank GF FK 20', '09');
INSERT INTO banktransfer_blz VALUES(59010021, 'ZVC Postbank GF FK 21', '09');
INSERT INTO banktransfer_blz VALUES(59010022, 'ZVC Postbank GF FK 22', '09');
INSERT INTO banktransfer_blz VALUES(59010023, 'ZVC Postbank GF FK 23', '09');
INSERT INTO banktransfer_blz VALUES(59010024, 'ZVC Postbank GF FK 24', '09');
INSERT INTO banktransfer_blz VALUES(59010025, 'ZVC Postbank GF FK 25', '09');
INSERT INTO banktransfer_blz VALUES(59010026, 'ZVC Postbank GF FK 26', '09');
INSERT INTO banktransfer_blz VALUES(59010027, 'ZVC Postbank Gf FK 27', '09');
INSERT INTO banktransfer_blz VALUES(59010028, 'ZVC Postbank Gf FK 28', '09');
INSERT INTO banktransfer_blz VALUES(59010029, 'ZVC Postbank Gf FK 29', '09');
INSERT INTO banktransfer_blz VALUES(59010031, 'ZVC Postbank Gf FK 31', '09');
INSERT INTO banktransfer_blz VALUES(59010032, 'ZVC Postbank Gf FK 32', '09');
INSERT INTO banktransfer_blz VALUES(59010033, 'ZVC Postbank Gf FK 33', '09');
INSERT INTO banktransfer_blz VALUES(59010034, 'ZVC Postbank Gf FK 34', '09');
INSERT INTO banktransfer_blz VALUES(59010035, 'ZVC Postbank Gf FK 35', '09');
INSERT INTO banktransfer_blz VALUES(59010036, 'ZVC Postbank Gf FK 36', '09');
INSERT INTO banktransfer_blz VALUES(59010037, 'ZVC Postbank Gf FK 37', '09');
INSERT INTO banktransfer_blz VALUES(59010038, 'ZVC Postbank Gf FK 38', '09');
INSERT INTO banktransfer_blz VALUES(59010039, 'ZVC Postbank Gf FK 39', '09');
INSERT INTO banktransfer_blz VALUES(59010040, 'ZVC Postbank Gf FK 40', '09');
INSERT INTO banktransfer_blz VALUES(59010041, 'ZVC Postbank Gf FK 41', '09');
INSERT INTO banktransfer_blz VALUES(59010042, 'ZVC Postbank Gf FK 42', '09');
INSERT INTO banktransfer_blz VALUES(59010044, 'ZVC Postbank Gf FK 44', '09');
INSERT INTO banktransfer_blz VALUES(59010045, 'ZVC Postbank Gf FK 45', '09');
INSERT INTO banktransfer_blz VALUES(59010047, 'ZVC Postbank Gf FK 47', '09');
INSERT INTO banktransfer_blz VALUES(59010048, 'ZVC Postbank Gf FK 48', '09');
INSERT INTO banktransfer_blz VALUES(59010049, 'ZVC Postbank Gf FK 49', '09');
INSERT INTO banktransfer_blz VALUES(59010066, 'Postbank', '24');
INSERT INTO banktransfer_blz VALUES(59010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(59010400, 'Saarl Investitionskreditbank', '32');
INSERT INTO banktransfer_blz VALUES(59020090, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(59020700, 'Hanseatic Bank', '16');
INSERT INTO banktransfer_blz VALUES(59040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(59050000, 'Landesbank Saar', '27');
INSERT INTO banktransfer_blz VALUES(59050101, 'Sparkasse Saarbrücken', '00');
INSERT INTO banktransfer_blz VALUES(59051090, 'Stadtsparkasse Völklingen', '21');
INSERT INTO banktransfer_blz VALUES(59052020, 'SKG BANK', 'D3');
INSERT INTO banktransfer_blz VALUES(59070000, 'Deutsche Bank Saarbruecken', '63');
INSERT INTO banktransfer_blz VALUES(59070070, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(59080090, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(59090626, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(59090900, 'PSD Bank RheinNeckarSaar', '91');
INSERT INTO banktransfer_blz VALUES(59091000, 'Volksbank Völklingen-Warndt', '06');
INSERT INTO banktransfer_blz VALUES(59091500, 'Volksbank Sulzbachtal -alt-', '06');
INSERT INTO banktransfer_blz VALUES(59091800, 'Volksbank Quierschied -alt-', '06');
INSERT INTO banktransfer_blz VALUES(59092000, 'Vereinigte Volksbank im Regionalverband Saarbrücken', '06');
INSERT INTO banktransfer_blz VALUES(59099530, 'Raiffeisenkasse Wiesbach -alt-', '09');
INSERT INTO banktransfer_blz VALUES(59099550, 'Volksbank Nahe-Schaumberg', '06');
INSERT INTO banktransfer_blz VALUES(59190000, 'Bank 1 Saar', '06');
INSERT INTO banktransfer_blz VALUES(59190100, 'VVBS Ver. Volksbanken Saarbrücken-St Ingbert', '06');
INSERT INTO banktransfer_blz VALUES(59190200, 'Volksbank Saar-West', '06');
INSERT INTO banktransfer_blz VALUES(59251020, 'Kreissparkasse St. Wendel', '00');
INSERT INTO banktransfer_blz VALUES(59252046, 'Sparkasse Neunkirchen', 'C9');
INSERT INTO banktransfer_blz VALUES(59290100, 'Volksbank Neunkirchen', '06');
INSERT INTO banktransfer_blz VALUES(59291000, 'St. Wendeler Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(59291200, 'Volksbank Saarpfalz', '06');
INSERT INTO banktransfer_blz VALUES(59291300, 'Volksbank Spiesen-Elversberg -alt-', '09');
INSERT INTO banktransfer_blz VALUES(59292400, 'Eppelborner Volksbank -alt-', '06');
INSERT INTO banktransfer_blz VALUES(59300000, 'Bundesbank eh Saarlouis', '09');
INSERT INTO banktransfer_blz VALUES(59320087, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(59350110, 'Kreissparkasse Saarlouis', '00');
INSERT INTO banktransfer_blz VALUES(59351040, 'Sparkasse Merzig-Wadern', '00');
INSERT INTO banktransfer_blz VALUES(59390100, 'Volksbank Saarlouis', '06');
INSERT INTO banktransfer_blz VALUES(59391100, 'Volksbank Untere Saar', '06');
INSERT INTO banktransfer_blz VALUES(59391200, 'Volksbank Überherrn', '06');
INSERT INTO banktransfer_blz VALUES(59391800, 'Volksbank Wadgassen', '06');
INSERT INTO banktransfer_blz VALUES(59392000, 'Volksbank Dillingen', '06');
INSERT INTO banktransfer_blz VALUES(59392200, 'Volksbank Untere Saar', '06');
INSERT INTO banktransfer_blz VALUES(59392400, 'Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(59393000, 'levoBank', '06');
INSERT INTO banktransfer_blz VALUES(59394200, 'Volksbank Schmelz-Hüttersdorf', '06');
INSERT INTO banktransfer_blz VALUES(59450010, 'Kreissparkasse Saarpfalz', '00');
INSERT INTO banktransfer_blz VALUES(59491000, 'Volksbank Homburg -alt-', '09');
INSERT INTO banktransfer_blz VALUES(59491114, 'VR Bank Saarpfalz', '09');
INSERT INTO banktransfer_blz VALUES(59491200, 'Volksbank Blieskastel -alt-', '06');
INSERT INTO banktransfer_blz VALUES(59491300, 'VR Bank Saarpfalz', '06');
INSERT INTO banktransfer_blz VALUES(60000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(60010070, 'Postbank', '24');
INSERT INTO banktransfer_blz VALUES(60010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(60010424, 'Aareal Bank', '09');
INSERT INTO banktransfer_blz VALUES(60010700, 'Landeskreditbank Baden-Württemberg Förderbank -alt-', '09');
INSERT INTO banktransfer_blz VALUES(60020030, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(60020100, 'Schwäbische Bank', '09');
INSERT INTO banktransfer_blz VALUES(60020290, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(60020300, 'VON ESSEN Bankgesellschaft', '09');
INSERT INTO banktransfer_blz VALUES(60020700, 'Hanseatic Bank', '16');
INSERT INTO banktransfer_blz VALUES(60030000, 'Mercedes-Benz Bank', 'A3');
INSERT INTO banktransfer_blz VALUES(60030100, 'Bankhaus Bauer, Stuttgart', '10');
INSERT INTO banktransfer_blz VALUES(60030200, 'Bankhaus Ellwanger & Geiger', '10');
INSERT INTO banktransfer_blz VALUES(60030600, 'CreditPlus Bank', '09');
INSERT INTO banktransfer_blz VALUES(60030700, 'AKTIVBANK', '09');
INSERT INTO banktransfer_blz VALUES(60030900, 'Isbank Fil Stuttgart', '06');
INSERT INTO banktransfer_blz VALUES(60033000, 'Wüstenrot Bausparkasse', '09');
INSERT INTO banktransfer_blz VALUES(60035810, 'IBM Deutschland Kreditbank', '06');
INSERT INTO banktransfer_blz VALUES(60038800, 'Düsseldorfer Hypothekenbank, Zndl Stuttgart', '10');
INSERT INTO banktransfer_blz VALUES(60040060, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(60040061, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(60040071, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(60050000, 'Landesbank Baden-Württemberg', '09');
INSERT INTO banktransfer_blz VALUES(60050009, 'ZV Landesbank Baden-Württemberg ISE', '09');
INSERT INTO banktransfer_blz VALUES(60050101, 'Landesbank Baden-Württemberg/Baden-Württembergische Bank', '01');
INSERT INTO banktransfer_blz VALUES(60060000, 'DZ BANK', '09');
INSERT INTO banktransfer_blz VALUES(60060202, 'DZ PRIVATBANK Ndl. Stuttgart', '09');
INSERT INTO banktransfer_blz VALUES(60060396, 'Untertürkheimer Volksbank', '10');
INSERT INTO banktransfer_blz VALUES(60060606, 'Evangelische Kreditgenossenschaft -Filiale Stuttgart-', '32');
INSERT INTO banktransfer_blz VALUES(60060893, 'VR-Bank Stuttgart', '10');
INSERT INTO banktransfer_blz VALUES(60062775, 'Echterdinger Bank', '10');
INSERT INTO banktransfer_blz VALUES(60062909, 'Volksbank Strohgäu', '10');
INSERT INTO banktransfer_blz VALUES(60069017, 'Raiffeisenbank Dellmensingen', '10');
INSERT INTO banktransfer_blz VALUES(60069066, 'Raiffeisenbank Niedere Alb', '10');
INSERT INTO banktransfer_blz VALUES(60069075, 'Raiffeisenbank Vellberg-Großaltdorf', '10');
INSERT INTO banktransfer_blz VALUES(60069126, 'Raiffeisenbank Römerstein -alt-', '10');
INSERT INTO banktransfer_blz VALUES(60069147, 'Raiffeisenbank Sondelfingen', '10');
INSERT INTO banktransfer_blz VALUES(60069158, 'Raiffeisenbank Steinheim', '10');
INSERT INTO banktransfer_blz VALUES(60069206, 'Raiffeisenbank', '10');
INSERT INTO banktransfer_blz VALUES(60069224, 'Genossenschaftsbank Weil im Schönbuch', '10');
INSERT INTO banktransfer_blz VALUES(60069235, 'Raiffeisenbank Zndl VB Nordschwarzwald', '10');
INSERT INTO banktransfer_blz VALUES(60069239, 'Bopfinger Bank Sechta-Ries', '10');
INSERT INTO banktransfer_blz VALUES(60069242, 'Raiffeisenbank Gruibingen', '10');
INSERT INTO banktransfer_blz VALUES(60069245, 'Raiffeisenbank Oberes Bühlertal', '10');
INSERT INTO banktransfer_blz VALUES(60069251, 'Raiffeisenbank Donau-Iller', '10');
INSERT INTO banktransfer_blz VALUES(60069302, 'Raiffeisenbank Erlenmoos', '10');
INSERT INTO banktransfer_blz VALUES(60069303, 'Raiffeisenbank Bad Schussenried', '10');
INSERT INTO banktransfer_blz VALUES(60069308, 'Raiffeisenbank', '10');
INSERT INTO banktransfer_blz VALUES(60069315, 'Volksbank Freiberg und Umgebung', '10');
INSERT INTO banktransfer_blz VALUES(60069325, 'Hegnacher Bank -alt-', '10');
INSERT INTO banktransfer_blz VALUES(60069336, 'Raiffeisenbank Maitis', '10');
INSERT INTO banktransfer_blz VALUES(60069343, 'Raiffeisenbank Rißtal', '10');
INSERT INTO banktransfer_blz VALUES(60069346, 'Raiffeisenbank Ehingen-Hochsträß', '10');
INSERT INTO banktransfer_blz VALUES(60069350, 'Raiffeisenbank Reute-Gaisbeuren', '10');
INSERT INTO banktransfer_blz VALUES(60069355, 'Ehninger Bank', '10');
INSERT INTO banktransfer_blz VALUES(60069371, 'Raiffbk Neukirch Ndl d Volksbank Tettnang', '10');
INSERT INTO banktransfer_blz VALUES(60069378, 'Volksbank Dettenhausen', '10');
INSERT INTO banktransfer_blz VALUES(60069387, 'Dettinger Bank', '10');
INSERT INTO banktransfer_blz VALUES(60069417, 'Raiffeisenbank Kirchheim-Walheim', '10');
INSERT INTO banktransfer_blz VALUES(60069419, 'Uhlbacher Bank', '10');
INSERT INTO banktransfer_blz VALUES(60069420, 'Raiffeisenbank Mittelbiberach', '10');
INSERT INTO banktransfer_blz VALUES(60069431, 'Raiffeisenbank Oberessendorf', '10');
INSERT INTO banktransfer_blz VALUES(60069442, 'Raiffeisenbank Frankenhardt-Stimpfach', '10');
INSERT INTO banktransfer_blz VALUES(60069455, 'Raiffeisenbank Vordersteinenberg', '10');
INSERT INTO banktransfer_blz VALUES(60069457, 'Raiffeisenbank Ottenbach', '10');
INSERT INTO banktransfer_blz VALUES(60069461, 'Raiffeisenbank Rottumtal', '10');
INSERT INTO banktransfer_blz VALUES(60069462, 'Winterbacher Bank', '10');
INSERT INTO banktransfer_blz VALUES(60069463, 'Raiffeisenbank Geislingen-Rosenfeld', '10');
INSERT INTO banktransfer_blz VALUES(60069476, 'Raiffeisenbank Heidenheimer Alb', '10');
INSERT INTO banktransfer_blz VALUES(60069485, 'Raiffeisenbank Oberer Wald', '10');
INSERT INTO banktransfer_blz VALUES(60069505, 'Volksbank Murgtal Baiersbr-Klosterreichenbach', '10');
INSERT INTO banktransfer_blz VALUES(60069511, 'Genossenschaftsbank Honhardt', '10');
INSERT INTO banktransfer_blz VALUES(60069517, 'Scharnhauser Bank', '10');
INSERT INTO banktransfer_blz VALUES(60069520, 'Raiffeisenbank Ehingen-Hochsträß', '10');
INSERT INTO banktransfer_blz VALUES(60069527, 'Volksbank Brenztal', '10');
INSERT INTO banktransfer_blz VALUES(60069538, 'Löchgauer Bank', '10');
INSERT INTO banktransfer_blz VALUES(60069544, 'Raiffeisenbank Westhausen', '10');
INSERT INTO banktransfer_blz VALUES(60069545, 'Nufringer Bank -Raiffeisen-', '10');
INSERT INTO banktransfer_blz VALUES(60069549, 'Walheimer Bank', '10');
INSERT INTO banktransfer_blz VALUES(60069553, 'Raiffeisenbank Aichhalden-Hardt-Sulgen', '10');
INSERT INTO banktransfer_blz VALUES(60069564, 'Raiffeisenbank Vordere Alb', '10');
INSERT INTO banktransfer_blz VALUES(60069593, 'Raiffeisenbank Oberes Schlichemtal', '10');
INSERT INTO banktransfer_blz VALUES(60069595, 'Raiffeisenbank Schrozberg-Rot am See', '10');
INSERT INTO banktransfer_blz VALUES(60069639, 'Raiffeisenbank Ingersheim', '10');
INSERT INTO banktransfer_blz VALUES(60069647, 'Ebhauser Bank -Raiffeisenbank -alt-', '10');
INSERT INTO banktransfer_blz VALUES(60069648, 'Raiffeisenbank', '10');
INSERT INTO banktransfer_blz VALUES(60069669, 'Erligheimer Bank -alt-', '10');
INSERT INTO banktransfer_blz VALUES(60069670, 'Raiffeisenbank Ehingen-Hochsträß', '10');
INSERT INTO banktransfer_blz VALUES(60069673, 'Abtsgmünder Bank -Raiffeisen-', '10');
INSERT INTO banktransfer_blz VALUES(60069680, 'Raiffeisenbank Bretzfeld-Neuenstein', '10');
INSERT INTO banktransfer_blz VALUES(60069685, 'Raiffeisenbank', '10');
INSERT INTO banktransfer_blz VALUES(60069692, 'Raiffeisenbank Enzberg', '10');
INSERT INTO banktransfer_blz VALUES(60069705, 'Raiffeisenbank Schlat -alt-', '10');
INSERT INTO banktransfer_blz VALUES(60069706, 'Raiffeisenbank', '10');
INSERT INTO banktransfer_blz VALUES(60069710, 'Raiffeisenbank Gammesfeld', '09');
INSERT INTO banktransfer_blz VALUES(60069714, 'Raiffeisenbank Kocher-Jagst', '10');
INSERT INTO banktransfer_blz VALUES(60069716, 'Raiffeisenbank Nattheim -alt-', '10');
INSERT INTO banktransfer_blz VALUES(60069724, 'Raiffeisenbank Heroldstatt', '10');
INSERT INTO banktransfer_blz VALUES(60069727, 'Raiffeisenbank', '10');
INSERT INTO banktransfer_blz VALUES(60069738, 'Volksbank Freiberg und Umgebung', '10');
INSERT INTO banktransfer_blz VALUES(60069766, 'Volks- und Raiffeisenbank Boll -alt-', '10');
INSERT INTO banktransfer_blz VALUES(60069773, 'Raiffeisenbank Kreßberg -alt-', '10');
INSERT INTO banktransfer_blz VALUES(60069780, 'Genossenschaftsbank Grabenstetten', '10');
INSERT INTO banktransfer_blz VALUES(60069795, 'Volksbank Freiberg und Umgebung', '10');
INSERT INTO banktransfer_blz VALUES(60069798, 'Raiffeisenbank Horb', '10');
INSERT INTO banktransfer_blz VALUES(60069817, 'Raiffeisenbank', '10');
INSERT INTO banktransfer_blz VALUES(60069832, 'Raiffeisenbank Urbach', '10');
INSERT INTO banktransfer_blz VALUES(60069842, 'Darmsheimer Bank', '10');
INSERT INTO banktransfer_blz VALUES(60069858, 'Enztalbank', '10');
INSERT INTO banktransfer_blz VALUES(60069860, 'Federseebank', '10');
INSERT INTO banktransfer_blz VALUES(60069876, 'Raiffeisenbank Oberes Gäu Ergenzingen', '10');
INSERT INTO banktransfer_blz VALUES(60069896, 'Volksbank Freiberg und Umgebung', '10');
INSERT INTO banktransfer_blz VALUES(60069904, 'VR-Bank Alb', '10');
INSERT INTO banktransfer_blz VALUES(60069905, 'Volksbank Remseck', '10');
INSERT INTO banktransfer_blz VALUES(60069911, 'Raiffeisenbank', '10');
INSERT INTO banktransfer_blz VALUES(60069926, 'Volksbank Glatten-Wittendorf -alt-', '10');
INSERT INTO banktransfer_blz VALUES(60069927, 'Berkheimer Bank', '10');
INSERT INTO banktransfer_blz VALUES(60069931, 'Raiffeisenbank', '10');
INSERT INTO banktransfer_blz VALUES(60069950, 'Raiffeisenbank Tüngental', '10');
INSERT INTO banktransfer_blz VALUES(60069971, 'Raiffeisenbank Ehingen-Hochsträß', '10');
INSERT INTO banktransfer_blz VALUES(60069972, 'Raiffeisenbank Sechta-Ries', '10');
INSERT INTO banktransfer_blz VALUES(60069976, 'Raiffeisenbank Böllingertal', '10');
INSERT INTO banktransfer_blz VALUES(60069980, 'Raiffeisenbank Maselheim-Äpfingen', '10');
INSERT INTO banktransfer_blz VALUES(60070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(60070070, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(60080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(60080055, 'Commerzbank vormals Dresdner Bank Zw 55', '76');
INSERT INTO banktransfer_blz VALUES(60080057, 'Commerzbank vormals Dresdner Bank Gf Zw 57', '76');
INSERT INTO banktransfer_blz VALUES(60080085, 'Commerzbank vormals Dresdner Bank ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(60080086, 'Commerzbank vormals Dresdner Bank Gf PCC-ITGK 3', '09');
INSERT INTO banktransfer_blz VALUES(60080087, 'Commerzbank vormals Dresdner Bank, PCC DC-ITGK 4', '09');
INSERT INTO banktransfer_blz VALUES(60080088, 'Commerzbank vormals Dresdner Bank, PCC DC-ITGK 5', '09');
INSERT INTO banktransfer_blz VALUES(60089450, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(60090100, 'Volksbank Stuttgart', '10');
INSERT INTO banktransfer_blz VALUES(60090300, 'Volksbank Zuffenhausen m Zndl Stammheimer VB', '10');
INSERT INTO banktransfer_blz VALUES(60090609, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(60090700, 'Südwestbank', '10');
INSERT INTO banktransfer_blz VALUES(60090800, 'Sparda-Bank Baden-Württemberg', '87');
INSERT INTO banktransfer_blz VALUES(60090900, 'PSD Bank RheinNeckarSaar', '91');
INSERT INTO banktransfer_blz VALUES(60120050, 'UniCredit Bank - HypoVereinsbank Ndl 434 Stgt', '99');
INSERT INTO banktransfer_blz VALUES(60120200, 'BHF-BANK', '60');
INSERT INTO banktransfer_blz VALUES(60120500, 'Bank für Sozialwirtschaft', '09');
INSERT INTO banktransfer_blz VALUES(60130100, 'FFS Bank', '00');
INSERT INTO banktransfer_blz VALUES(60133300, 'Santander Consumer Bank', '09');
INSERT INTO banktransfer_blz VALUES(60200000, 'Bundesbank eh Waiblingen', '09');
INSERT INTO banktransfer_blz VALUES(60220030, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(60241074, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(60250010, 'Kreissparkasse Waiblingen', '01');
INSERT INTO banktransfer_blz VALUES(60250184, 'Baden-Württemb.Bank/Landesbank Baden-Württemb.', '01');
INSERT INTO banktransfer_blz VALUES(60261329, 'Fellbacher Bank', '10');
INSERT INTO banktransfer_blz VALUES(60261622, 'VR-Bank Weinstadt', '10');
INSERT INTO banktransfer_blz VALUES(60261818, 'Raiffeisenbank Weissacher Tal', '10');
INSERT INTO banktransfer_blz VALUES(60262063, 'Korber Bank', '10');
INSERT INTO banktransfer_blz VALUES(60262693, 'Kerner Volksbank', '10');
INSERT INTO banktransfer_blz VALUES(60270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(60270073, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(60290110, 'Volksbank Rems -alt-', '10');
INSERT INTO banktransfer_blz VALUES(60291120, 'Volksbank Backnang', '10');
INSERT INTO banktransfer_blz VALUES(60291410, 'Volksbank Schorndorf', '10');
INSERT INTO banktransfer_blz VALUES(60291510, 'Volksbank Winnenden', '10');
INSERT INTO banktransfer_blz VALUES(60300000, 'Bundesbank eh Sindelfingen', '09');
INSERT INTO banktransfer_blz VALUES(60320030, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(60320291, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(60340071, 'Commerzbank Sindelfingen', '13');
INSERT INTO banktransfer_blz VALUES(60350130, 'Kreissparkasse Böblingen', '01');
INSERT INTO banktransfer_blz VALUES(60361923, 'Raiffeisenbank Weissach', '10');
INSERT INTO banktransfer_blz VALUES(60380002, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(60390000, 'Vereinigte Volksbank', '10');
INSERT INTO banktransfer_blz VALUES(60390300, 'Volksbank Region Leonberg', '10');
INSERT INTO banktransfer_blz VALUES(60391310, 'Volksbank Herrenberg-Rottenburg', '10');
INSERT INTO banktransfer_blz VALUES(60391420, 'Volksbank Magstadt', '10');
INSERT INTO banktransfer_blz VALUES(60400000, 'Bundesbank eh Ludwigsburg', '09');
INSERT INTO banktransfer_blz VALUES(60410600, 'Wüstenrot Bank Pfandbriefbk ehe Wüstenrot Hypo', '09');
INSERT INTO banktransfer_blz VALUES(60420000, 'Wüstenrot Bank Pfandbriefbank', '06');
INSERT INTO banktransfer_blz VALUES(60420186, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(60422000, 'RSB Retail+Service Bank', '06');
INSERT INTO banktransfer_blz VALUES(60430060, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(60431061, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(60440073, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(60450050, 'Kreissparkasse Ludwigsburg', '01');
INSERT INTO banktransfer_blz VALUES(60450193, 'Baden-Württemb.Bank/Landesbank Baden-Württemb.', '01');
INSERT INTO banktransfer_blz VALUES(60460142, 'Volksbank Freiberg und Umgebung', '10');
INSERT INTO banktransfer_blz VALUES(60461809, 'Volksbank Markgröningen', '10');
INSERT INTO banktransfer_blz VALUES(60462808, 'VR-Bank Asperg-Markgröningen', '10');
INSERT INTO banktransfer_blz VALUES(60470024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(60470082, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(60480008, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(60490150, 'Volksbank Ludwigsburg', '10');
INSERT INTO banktransfer_blz VALUES(60491430, 'VR-Bank Stromberg-Neckar', '10');
INSERT INTO banktransfer_blz VALUES(60651070, 'Kreissparkasse Calw -alt-', 'A9');
INSERT INTO banktransfer_blz VALUES(60661369, 'Raiffeisenbank', '10');
INSERT INTO banktransfer_blz VALUES(60661906, 'Raiffeisenbank Wimsheim-Mönsheim', '10');
INSERT INTO banktransfer_blz VALUES(60663084, 'Raiffeisenbank im Kreis Calw', '10');
INSERT INTO banktransfer_blz VALUES(60670024, 'Deutsche Bank Privat- und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(60670070, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(60691440, 'Volksbank Maulbronn-Oberderdingen -alt-', '10');
INSERT INTO banktransfer_blz VALUES(61020030, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(61030000, 'Bankhaus Gebr. Martin', '09');
INSERT INTO banktransfer_blz VALUES(61040014, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(61050000, 'Kreissparkasse Göppingen', '01');
INSERT INTO banktransfer_blz VALUES(61050181, 'Baden-Württemb.Bank/Landesbank Baden-Württemb.', '01');
INSERT INTO banktransfer_blz VALUES(61060500, 'Volksbank Göppingen', '10');
INSERT INTO banktransfer_blz VALUES(61070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(61070078, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(61080006, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(61091200, 'Volksbank-Raiffeisenbank Deggingen', '10');
INSERT INTO banktransfer_blz VALUES(61100000, 'Bundesbank eh Esslingen', '09');
INSERT INTO banktransfer_blz VALUES(61120030, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(61120286, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(61140071, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(61150020, 'Kreissparkasse Esslingen-Nürtingen', '01');
INSERT INTO banktransfer_blz VALUES(61150185, 'Baden-Württemb.Bank/Landesbank Baden-Württemb.', '01');
INSERT INTO banktransfer_blz VALUES(61161696, 'Volksbank Filder', '10');
INSERT INTO banktransfer_blz VALUES(61170024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(61170076, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(61180004, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(61190110, 'Volksbank Esslingen', '10');
INSERT INTO banktransfer_blz VALUES(61191310, 'Volksbank Plochingen', '10');
INSERT INTO banktransfer_blz VALUES(61220030, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(61240048, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(61261213, 'Raiffeisenbank Teck', '10');
INSERT INTO banktransfer_blz VALUES(61261339, 'Volksbank Hohenneuffen', '10');
INSERT INTO banktransfer_blz VALUES(61262258, 'Genossenschaftsbank Wolfschlugen', '10');
INSERT INTO banktransfer_blz VALUES(61262345, 'Bernhauser Bank', '10');
INSERT INTO banktransfer_blz VALUES(61281007, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(61290120, 'Volksbank Kirchheim-Nürtingen', '10');
INSERT INTO banktransfer_blz VALUES(61340079, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(61361722, 'Raiffeisenbank Rosenstein', '10');
INSERT INTO banktransfer_blz VALUES(61361975, 'Raiffeisenbank Mutlangen', '10');
INSERT INTO banktransfer_blz VALUES(61370024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(61370086, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(61390140, 'Volksbank Schwäbisch Gmünd', '10');
INSERT INTO banktransfer_blz VALUES(61391410, 'Volksbank Welzheim', '10');
INSERT INTO banktransfer_blz VALUES(61400000, 'Bundesbank eh Aalen', '09');
INSERT INTO banktransfer_blz VALUES(61420086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(61430000, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(61440086, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(61450050, 'Kreissparkasse Ostalb', '01');
INSERT INTO banktransfer_blz VALUES(61450191, 'Baden-Württemb.Bank/Landesbank Baden-Württemb.', '01');
INSERT INTO banktransfer_blz VALUES(61480001, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(61490150, 'VR-Bank Aalen', '10');
INSERT INTO banktransfer_blz VALUES(61491010, 'VR-Bank Ellwangen', '10');
INSERT INTO banktransfer_blz VALUES(62000000, 'Bundesbank eh Heilbronn', '09');
INSERT INTO banktransfer_blz VALUES(62020000, 'Hoerner-Bank', '16');
INSERT INTO banktransfer_blz VALUES(62020100, 'FGA Bank Germany', '09');
INSERT INTO banktransfer_blz VALUES(62030050, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(62030058, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(62030059, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(62030060, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(62040060, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(62050000, 'Kreissparkasse Heilbronn', '01');
INSERT INTO banktransfer_blz VALUES(62050181, 'Baden-Württemb.Bank/Landesbank Baden-Württemb.', '01');
INSERT INTO banktransfer_blz VALUES(62061991, 'Volksbank Sulmtal', '10');
INSERT INTO banktransfer_blz VALUES(62062215, 'Volksbank Beilstein-Ilsfeld-Abstatt', '10');
INSERT INTO banktransfer_blz VALUES(62062643, 'Volksbank Flein-Talheim', '10');
INSERT INTO banktransfer_blz VALUES(62063263, 'VBU Volksbank im Unterland', '10');
INSERT INTO banktransfer_blz VALUES(62070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(62070081, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(62080012, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(62090100, 'Volksbank Heilbronn', '10');
INSERT INTO banktransfer_blz VALUES(62091400, 'Volksbank Brackenheim-Güglingen', '10');
INSERT INTO banktransfer_blz VALUES(62091600, 'Volksbank Möckmühl-Neuenstadt', '10');
INSERT INTO banktransfer_blz VALUES(62091800, 'Volksbank Hohenlohe', '10');
INSERT INTO banktransfer_blz VALUES(62200000, 'Bundesbank eh Schwäbisch Hall', '09');
INSERT INTO banktransfer_blz VALUES(62220000, 'Bausparkasse Schwäbisch Hall', '09');
INSERT INTO banktransfer_blz VALUES(62230050, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(62240048, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(62250030, 'Sparkasse Schwäbisch Hall-Crailsheim', '01');
INSERT INTO banktransfer_blz VALUES(62250182, 'Baden-Württemb.Bank/Landesbank Baden-Württemb.', '01');
INSERT INTO banktransfer_blz VALUES(62251550, 'Sparkasse Hohenlohekreis', '01');
INSERT INTO banktransfer_blz VALUES(62280012, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(62290110, 'VR Bank Schwäbisch Hall-Crailsheim', '10');
INSERT INTO banktransfer_blz VALUES(62291020, 'Crailsheimer Volksbank -alt-', '10');
INSERT INTO banktransfer_blz VALUES(62351060, 'Kreissparkasse Mergentheim -alt-', '01');
INSERT INTO banktransfer_blz VALUES(62361274, 'Creglinger Bank', '10');
INSERT INTO banktransfer_blz VALUES(62391010, 'Volksbank Bad Mergentheim -alt-', '10');
INSERT INTO banktransfer_blz VALUES(62391420, 'Volksbank Vorbach-Tauber', '10');
INSERT INTO banktransfer_blz VALUES(63000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(63010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(63020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(63020130, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(63020450, 'UniCredit Bank - HypoVereinsbank Ndl 274 Ulm', '99');
INSERT INTO banktransfer_blz VALUES(63040053, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(63050000, 'Sparkasse Ulm', '01');
INSERT INTO banktransfer_blz VALUES(63050181, 'Baden-Württemb.Bank/Landesbank Baden-Württemb.', '01');
INSERT INTO banktransfer_blz VALUES(63061486, 'VR-Bank Langenau-Ulmer Alb', '10');
INSERT INTO banktransfer_blz VALUES(63070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(63070088, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(63080015, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(63080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(63090100, 'Volksbank Ulm-Biberach', '10');
INSERT INTO banktransfer_blz VALUES(63091010, 'Ehinger Volksbank', '10');
INSERT INTO banktransfer_blz VALUES(63091200, 'Volksbank Blaubeuren', '10');
INSERT INTO banktransfer_blz VALUES(63091300, 'Volksbank Laichingen', '10');
INSERT INTO banktransfer_blz VALUES(63220090, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(63240016, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(63250030, 'Kreissparkasse Heidenheim', '01');
INSERT INTO banktransfer_blz VALUES(63290110, 'Heidenheimer Volksbank', '10');
INSERT INTO banktransfer_blz VALUES(63291210, 'Giengener Volksbank -alt-', '19');
INSERT INTO banktransfer_blz VALUES(64000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(64020030, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(64020186, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(64040033, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(64040045, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(64050000, 'Kreissparkasse Reutlingen', '01');
INSERT INTO banktransfer_blz VALUES(64050181, 'Baden-Württemb.Bank/Landesbank Baden-Württemb.', '01');
INSERT INTO banktransfer_blz VALUES(64061854, 'VR Bank Steinlach-Wiesaz-Härten', '10');
INSERT INTO banktransfer_blz VALUES(64070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(64070085, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(64080014, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(64090100, 'Volksbank Reutlingen', '10');
INSERT INTO banktransfer_blz VALUES(64091200, 'Volksbank Metzingen-Bad Urach', '10');
INSERT INTO banktransfer_blz VALUES(64091300, 'Volksbank Münsingen', '10');
INSERT INTO banktransfer_blz VALUES(64120030, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(64140036, 'Commerzbank Tübingen', '13');
INSERT INTO banktransfer_blz VALUES(64150020, 'Kreissparkasse Tübingen', '01');
INSERT INTO banktransfer_blz VALUES(64150182, 'Baden-Württemb.Bank/Landesbank Baden-Württemb.', '01');
INSERT INTO banktransfer_blz VALUES(64161397, 'Volksbank Ammerbuch', '10');
INSERT INTO banktransfer_blz VALUES(64161608, 'Raiffeisenbank Härten -alt-', '10');
INSERT INTO banktransfer_blz VALUES(64161956, 'Volksbank', '10');
INSERT INTO banktransfer_blz VALUES(64163225, 'Volksbank Hohenzollern', '10');
INSERT INTO banktransfer_blz VALUES(64180014, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(64190110, 'Volksbank Tübingen', '10');
INSERT INTO banktransfer_blz VALUES(64191030, 'Volksbank Nagoldtal', '10');
INSERT INTO banktransfer_blz VALUES(64191210, 'Volksbank Nordschwarzwald', '10');
INSERT INTO banktransfer_blz VALUES(64191700, 'Volksbank Horb -alt-', '10');
INSERT INTO banktransfer_blz VALUES(64232000, 'Bankhaus J. Faißt', '09');
INSERT INTO banktransfer_blz VALUES(64240048, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(64240071, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(64250040, 'Kreissparkasse Rottweil', '01');
INSERT INTO banktransfer_blz VALUES(64251060, 'Kreissparkasse Freudenstadt', '01');
INSERT INTO banktransfer_blz VALUES(64261363, 'Volksbank Baiersbronn', '10');
INSERT INTO banktransfer_blz VALUES(64261626, 'Murgtalbank Mitteltal - Obertal -alt-', '10');
INSERT INTO banktransfer_blz VALUES(64261853, 'Volksbank Nordschwarzwald', '10');
INSERT INTO banktransfer_blz VALUES(64262408, 'Volksbank Dornstetten', '10');
INSERT INTO banktransfer_blz VALUES(64263273, 'Volksbank Bösingen Dunningen Fluorn-Winzeln -alt-', '10');
INSERT INTO banktransfer_blz VALUES(64290120, 'Volksbank Rottweil', '10');
INSERT INTO banktransfer_blz VALUES(64291010, 'Volksbank Horb-Freudenstadt', '10');
INSERT INTO banktransfer_blz VALUES(64291420, 'Volksbank Deißlingen', '10');
INSERT INTO banktransfer_blz VALUES(64292020, 'Volksbank Schwarzwald-Neckar', '10');
INSERT INTO banktransfer_blz VALUES(64292310, 'Volksbank Trossingen', '10');
INSERT INTO banktransfer_blz VALUES(64350070, 'Kreissparkasse Tuttlingen', '01');
INSERT INTO banktransfer_blz VALUES(64361359, 'Raiffeisenbank Donau-Heuberg', '10');
INSERT INTO banktransfer_blz VALUES(64380011, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(64390130, 'Volksbank Donau-Neckar', '10');
INSERT INTO banktransfer_blz VALUES(64420030, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(64450288, 'Baden-Württemb.Bank/Landesbank Baden-Württemb.', '01');
INSERT INTO banktransfer_blz VALUES(65000000, 'Bundesbank eh Ravensburg', '09');
INSERT INTO banktransfer_blz VALUES(65020030, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(65020186, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(65040073, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(65050110, 'Kreissparkasse Ravensburg', '01');
INSERT INTO banktransfer_blz VALUES(65050281, 'Baden-Württemb.Bank/Landesbank Baden-Württemb.', '01');
INSERT INTO banktransfer_blz VALUES(65061219, 'Raiffeisenbank Aulendorf', '10');
INSERT INTO banktransfer_blz VALUES(65062577, 'Raiffeisenbank Ravensburg', '10');
INSERT INTO banktransfer_blz VALUES(65062793, 'Raiffeisenbank Vorallgäu', '10');
INSERT INTO banktransfer_blz VALUES(65063086, 'Raiffeisenbank Bad Saulgau', '10');
INSERT INTO banktransfer_blz VALUES(65070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(65070084, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(65080009, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(65090100, 'Volksbank Ulm-Biberach', '10');
INSERT INTO banktransfer_blz VALUES(65091040, 'Leutkircher Bank Raiffeisen- und Volksbank', '10');
INSERT INTO banktransfer_blz VALUES(65091300, 'Bad Waldseer Bank', '10');
INSERT INTO banktransfer_blz VALUES(65091400, 'Isnyer Volksbank -alt-', '10');
INSERT INTO banktransfer_blz VALUES(65091600, 'Volksbank Weingarten', '10');
INSERT INTO banktransfer_blz VALUES(65092010, 'Volksbank Allgäu-West', '10');
INSERT INTO banktransfer_blz VALUES(65092200, 'Volksbank Altshausen', '10');
INSERT INTO banktransfer_blz VALUES(65093020, 'Volksbank Bad Saulgau', '10');
INSERT INTO banktransfer_blz VALUES(65110200, 'Internationales Bankhaus Bodensee', '71');
INSERT INTO banktransfer_blz VALUES(65120091, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(65140072, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(65150040, 'Spk -alt-', '01');
INSERT INTO banktransfer_blz VALUES(65161497, 'Genossenschaftsbank Meckenbeuren', '10');
INSERT INTO banktransfer_blz VALUES(65162832, 'Raiffeisenbank', '10');
INSERT INTO banktransfer_blz VALUES(65180005, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(65190110, 'Volksbank Friedrichshafen', '10');
INSERT INTO banktransfer_blz VALUES(65191500, 'Volksbank Tettnang', '10');
INSERT INTO banktransfer_blz VALUES(65300000, 'Bundesbank eh Albstadt', '09');
INSERT INTO banktransfer_blz VALUES(65310111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(65340004, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(65341204, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(65350186, 'Baden-Württemb.Bank/Landesbank Baden-Württemb.', '01');
INSERT INTO banktransfer_blz VALUES(65351050, 'Hohenz Landesbank Kreissparkasse Sigmaringen', '01');
INSERT INTO banktransfer_blz VALUES(65351260, 'Sparkasse Zollernalb', '01');
INSERT INTO banktransfer_blz VALUES(65361469, 'Volksbank Heuberg', '10');
INSERT INTO banktransfer_blz VALUES(65361898, 'Winterlinger Bank', '10');
INSERT INTO banktransfer_blz VALUES(65361989, 'Onstmettinger Bank', '10');
INSERT INTO banktransfer_blz VALUES(65362499, 'Raiffeisenbank Geislingen-Rosenfeld', '10');
INSERT INTO banktransfer_blz VALUES(65370024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(65370075, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(65380003, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(65390120, 'Volksbank Ebingen', '10');
INSERT INTO banktransfer_blz VALUES(65391210, 'Volksbank Balingen', '10');
INSERT INTO banktransfer_blz VALUES(65392030, 'Volksbank Tailfingen', '10');
INSERT INTO banktransfer_blz VALUES(65440087, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(65450070, 'Kreissparkasse Biberach', '01');
INSERT INTO banktransfer_blz VALUES(65461878, 'Raiffeisenbank Risstal', '10');
INSERT INTO banktransfer_blz VALUES(65462231, 'Raiffeisenbank Illertal', '10');
INSERT INTO banktransfer_blz VALUES(65490130, 'Volksbank Ulm-Biberach', '10');
INSERT INTO banktransfer_blz VALUES(65491320, 'Volksbank Laupheim', '10');
INSERT INTO banktransfer_blz VALUES(65491510, 'Volksbank-Raiffeisenbank Riedlingen', '10');
INSERT INTO banktransfer_blz VALUES(66000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(66010075, 'Postbank', '24');
INSERT INTO banktransfer_blz VALUES(66010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(66010200, 'Deutsche Bausparkasse Badenia', '09');
INSERT INTO banktransfer_blz VALUES(66010700, 'Landeskreditbank Baden-Württemberg Förderbank', '09');
INSERT INTO banktransfer_blz VALUES(66020020, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(66020150, 'UniCredit Bank - HypoVereinsbank Ndl 145 Kruh', '99');
INSERT INTO banktransfer_blz VALUES(66020286, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(66020500, 'Bank für Sozialwirtschaft', '09');
INSERT INTO banktransfer_blz VALUES(66030600, 'Isbank Fil Karlsruhe', '06');
INSERT INTO banktransfer_blz VALUES(66030610, 'ISBANK Mannheim', '06');
INSERT INTO banktransfer_blz VALUES(66040018, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(66040026, 'Commerzbank/Kreditcenter Badenia', '13');
INSERT INTO banktransfer_blz VALUES(66050000, 'Landesbank Baden-Württemberg', '09');
INSERT INTO banktransfer_blz VALUES(66050101, 'Sparkasse Karlsruhe', '00');
INSERT INTO banktransfer_blz VALUES(66051220, 'Sparkasse Ettlingen', '00');
INSERT INTO banktransfer_blz VALUES(66060000, 'DZ BANK', '09');
INSERT INTO banktransfer_blz VALUES(66060300, 'Spar- und Kreditbank', '06');
INSERT INTO banktransfer_blz VALUES(66060800, 'Evangelische Kreditgenossenschaft -Filiale Karlsruhe-', '32');
INSERT INTO banktransfer_blz VALUES(66061059, 'Volksbank Stutensee Hardt', '06');
INSERT INTO banktransfer_blz VALUES(66061407, 'Spar- und Kreditbank', '06');
INSERT INTO banktransfer_blz VALUES(66061724, 'Volksbank Weingarten-Walzbachtal', '06');
INSERT INTO banktransfer_blz VALUES(66062138, 'Spar- und Kreditbank Hardt', '06');
INSERT INTO banktransfer_blz VALUES(66062366, 'Raiffeisenbank Hardt-Bruhrain', '06');
INSERT INTO banktransfer_blz VALUES(66069103, 'Raiffeisenbank Elztal', '06');
INSERT INTO banktransfer_blz VALUES(66069104, 'Spar- und Kreditbank', '06');
INSERT INTO banktransfer_blz VALUES(66069117, 'Raiffeisenbank Döggingen-Mundelfingen -alt-', '06');
INSERT INTO banktransfer_blz VALUES(66069265, 'Raiffeisenbank Hilsbach -alt-', '06');
INSERT INTO banktransfer_blz VALUES(66069323, 'Spar- und Kreditbank Daxlanden Karlsruhe -alt-', '06');
INSERT INTO banktransfer_blz VALUES(66069342, 'Volksbank Krautheim', '06');
INSERT INTO banktransfer_blz VALUES(66069573, 'Raiffeisenbank Sexau -alt-', '06');
INSERT INTO banktransfer_blz VALUES(66070004, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(66070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(66080052, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(66090621, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(66090800, 'BBBank', 'B3');
INSERT INTO banktransfer_blz VALUES(66090900, 'PSD Bank Karlsruhe-Neustadt', '91');
INSERT INTO banktransfer_blz VALUES(66091200, 'Volksbank Ettlingen', '06');
INSERT INTO banktransfer_blz VALUES(66091500, 'Volksbank Neureut -alt-', '06');
INSERT INTO banktransfer_blz VALUES(66190000, 'Volksbank Karlsruhe', '06');
INSERT INTO banktransfer_blz VALUES(66190100, 'Volksbank Durlach -alt-', '06');
INSERT INTO banktransfer_blz VALUES(66200000, 'Bundesbank eh Baden-Baden', '09');
INSERT INTO banktransfer_blz VALUES(66220020, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(66240002, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(66250030, 'Sparkasse Baden-Baden Gaggenau', '00');
INSERT INTO banktransfer_blz VALUES(66251434, 'Sparkasse Bühl', '00');
INSERT INTO banktransfer_blz VALUES(66261092, 'Spar- und Kreditbank', '06');
INSERT INTO banktransfer_blz VALUES(66261416, 'Raiffeisenbank Altschweier', '06');
INSERT INTO banktransfer_blz VALUES(66270001, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(66270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(66280053, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(66290000, 'Volksbank Baden-Baden Rastatt', '06');
INSERT INTO banktransfer_blz VALUES(66291300, 'Volksbank Achern', '06');
INSERT INTO banktransfer_blz VALUES(66291400, 'Volksbank Bühl', '06');
INSERT INTO banktransfer_blz VALUES(66340018, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(66350036, 'Sparkasse Kraichgau Bruchsal-Bretten-Sinsheim', '03');
INSERT INTO banktransfer_blz VALUES(66361178, 'Raiffeisenbank Kraich-Hardt -alt-', '06');
INSERT INTO banktransfer_blz VALUES(66361335, 'Volksbank Kirrlach -alt-', '06');
INSERT INTO banktransfer_blz VALUES(66362345, 'Raiffeisenbank Kronau -alt-', '06');
INSERT INTO banktransfer_blz VALUES(66363487, 'Raiffeisenbank Odenheim-Tiefenbach -alt-', '06');
INSERT INTO banktransfer_blz VALUES(66390000, 'Volksbank Bruchsal-Bretten -alt-', '06');
INSERT INTO banktransfer_blz VALUES(66391200, 'Volksbank Bruchsal-Bretten', '06');
INSERT INTO banktransfer_blz VALUES(66391600, 'Volksbank Bruhrain-Kraich-Hardt', '06');
INSERT INTO banktransfer_blz VALUES(66400000, 'Bundesbank eh Offenburg', '09');
INSERT INTO banktransfer_blz VALUES(66420020, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(66432700, 'Bankhaus J. Faißt', '09');
INSERT INTO banktransfer_blz VALUES(66440084, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(66450050, 'Sparkasse Offenburg-Ortenau', '03');
INSERT INTO banktransfer_blz VALUES(66451346, 'Sparkasse Gengenbach', '03');
INSERT INTO banktransfer_blz VALUES(66451548, 'Sparkasse Haslach-Zell', '03');
INSERT INTO banktransfer_blz VALUES(66451862, 'Sparkasse Hanauerland', '03');
INSERT INTO banktransfer_blz VALUES(66452776, 'Sparkasse Wolfach', '03');
INSERT INTO banktransfer_blz VALUES(66470024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(66470035, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(66490000, 'Volksbank Offenburg', '06');
INSERT INTO banktransfer_blz VALUES(66491800, 'Volksbank Bühl Fil Kehl', '06');
INSERT INTO banktransfer_blz VALUES(66492300, 'Renchtalbank -alt-', '06');
INSERT INTO banktransfer_blz VALUES(66492600, 'Volksbank Appenweier-Urloffen Appenweier -alt-', '06');
INSERT INTO banktransfer_blz VALUES(66492700, 'Volksbank Kinzigtal', '06');
INSERT INTO banktransfer_blz VALUES(66550070, 'Sparkasse Rastatt-Gernsbach', '00');
INSERT INTO banktransfer_blz VALUES(66551290, 'Sparkasse Gaggenau-Kuppenheim -alt-', '00');
INSERT INTO banktransfer_blz VALUES(66562053, 'Raiffeisenbank Südhardt Durmersheim', '06');
INSERT INTO banktransfer_blz VALUES(66562300, 'VR-Bank in Mittelbaden', '06');
INSERT INTO banktransfer_blz VALUES(66600000, 'Bundesbank eh Pforzheim', '09');
INSERT INTO banktransfer_blz VALUES(66610111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(66620020, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(66640035, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(66650085, 'Sparkasse Pforzheim Calw', '06');
INSERT INTO banktransfer_blz VALUES(66661244, 'Raiffeisenbank Bauschlott', '06');
INSERT INTO banktransfer_blz VALUES(66661329, 'Raiffeisenbank Kieselbronn', '06');
INSERT INTO banktransfer_blz VALUES(66661454, 'VR Bank im Enzkreis', '42');
INSERT INTO banktransfer_blz VALUES(66662155, 'Raiffeisenbank Ersingen', '06');
INSERT INTO banktransfer_blz VALUES(66662220, 'Volksbank Stein Eisingen', '06');
INSERT INTO banktransfer_blz VALUES(66663439, 'Raiffeisen-Gebietsbank', '10');
INSERT INTO banktransfer_blz VALUES(66670006, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(66670024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(66680013, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(66690000, 'Volksbank Pforzheim', '43');
INSERT INTO banktransfer_blz VALUES(66692300, 'Volksbank Wilferdingen-Keltern', '06');
INSERT INTO banktransfer_blz VALUES(66762332, 'Raiffeisenbank Kraichgau', '06');
INSERT INTO banktransfer_blz VALUES(66762433, 'Raiffeisenbank Neudenau-Stein-Herbolzheim', '06');
INSERT INTO banktransfer_blz VALUES(67000000, 'Bundesbank eh Mannheim', '09');
INSERT INTO banktransfer_blz VALUES(67010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(67020020, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(67020190, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(67020259, 'UniCredit Bank - HypoVereinsbank Ndl 681 Mnh', '99');
INSERT INTO banktransfer_blz VALUES(67040031, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(67040060, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(67040061, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(67050000, 'Landesbank Baden-Württemberg', '09');
INSERT INTO banktransfer_blz VALUES(67050101, 'Sparkasse Mannheim', '00');
INSERT INTO banktransfer_blz VALUES(67050505, 'Sparkasse Rhein Neckar Nord', '06');
INSERT INTO banktransfer_blz VALUES(67051203, 'Sparkasse Hockenheim', '00');
INSERT INTO banktransfer_blz VALUES(67052385, 'Bezirkssparkasse Weinheim', '06');
INSERT INTO banktransfer_blz VALUES(67060031, 'Volksbank Sandhofen', '06');
INSERT INTO banktransfer_blz VALUES(67070010, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(67070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(67080050, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(67080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(67080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 3', '09');
INSERT INTO banktransfer_blz VALUES(67089440, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(67090000, 'VR Bank Rhein-Neckar', '06');
INSERT INTO banktransfer_blz VALUES(67090617, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(67091500, 'Volksbank Kurpfalz H+G Bank', '06');
INSERT INTO banktransfer_blz VALUES(67092300, 'Volksbank Weinheim', '06');
INSERT INTO banktransfer_blz VALUES(67210111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(67220020, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(67220286, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(67220464, 'UniCredit Bank - HypoVereinsbank Ndl 488 Hd', '99');
INSERT INTO banktransfer_blz VALUES(67230000, 'MLP Finanzdienstleistungen', '92');
INSERT INTO banktransfer_blz VALUES(67230001, 'MLP Finanzdienstleistungen Zw CS', '92');
INSERT INTO banktransfer_blz VALUES(67240039, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(67250020, 'Sparkasse Heidelberg', '06');
INSERT INTO banktransfer_blz VALUES(67261909, 'Raiffeisenbank Steinsberg -alt-', '06');
INSERT INTO banktransfer_blz VALUES(67262243, 'Raiffeisen Privatbank', '06');
INSERT INTO banktransfer_blz VALUES(67262402, 'Volksbank Schwarzbachtal -alt-', '06');
INSERT INTO banktransfer_blz VALUES(67262550, 'Volksbank Rot', '06');
INSERT INTO banktransfer_blz VALUES(67270003, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(67270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(67280051, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(67290000, 'Heidelberger Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(67290100, 'Volksbank Kurpfalz H+G Bank', '06');
INSERT INTO banktransfer_blz VALUES(67291500, 'Volksbank f d Angelbachtal -alt-', '06');
INSERT INTO banktransfer_blz VALUES(67291700, 'Volksbank Neckartal', '06');
INSERT INTO banktransfer_blz VALUES(67291900, 'Volksbank Kraichgau -alt-', '06');
INSERT INTO banktransfer_blz VALUES(67292200, 'Volksbank Kraichgau Wiesloch-Sinsheim', '06');
INSERT INTO banktransfer_blz VALUES(67320020, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(67332551, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(67352565, 'Sparkasse Tauberfranken', '00');
INSERT INTO banktransfer_blz VALUES(67362560, 'Volksbank Tauber -alt-', '06');
INSERT INTO banktransfer_blz VALUES(67390000, 'Volksbank Main-Tauber', '06');
INSERT INTO banktransfer_blz VALUES(67450048, 'Sparkasse Neckartal-Odenwald', '00');
INSERT INTO banktransfer_blz VALUES(67460041, 'Volksbank Mosbach', '06');
INSERT INTO banktransfer_blz VALUES(67461424, 'Volksbank Franken', '06');
INSERT INTO banktransfer_blz VALUES(67461733, 'Volksbank Kirnau', '06');
INSERT INTO banktransfer_blz VALUES(67462368, 'Volksbank Limbach', '06');
INSERT INTO banktransfer_blz VALUES(67462480, 'Raiffeisenbank Schefflenz-Seckach -alt-', '06');
INSERT INTO banktransfer_blz VALUES(68000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(68010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(68020020, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(68020186, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(68020460, 'UniCredit Bank - HypoVereinsbank Ndl 405 Frb', '99');
INSERT INTO banktransfer_blz VALUES(68030000, 'Bankhaus E. Mayer', '32');
INSERT INTO banktransfer_blz VALUES(68040007, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(68050000, 'Landesbank Baden-Württemberg', '09');
INSERT INTO banktransfer_blz VALUES(68050101, 'Sparkasse Freiburg-Nördlicher Breisgau', '01');
INSERT INTO banktransfer_blz VALUES(68051004, 'Sparkasse Hochschwarzwald', '00');
INSERT INTO banktransfer_blz VALUES(68051207, 'Sparkasse Bonndorf-Stühlingen', '00');
INSERT INTO banktransfer_blz VALUES(68051310, 'Sparkasse Breisach -alt-', '00');
INSERT INTO banktransfer_blz VALUES(68052230, 'Sparkasse St. Blasien', '00');
INSERT INTO banktransfer_blz VALUES(68052328, 'Sparkasse Staufen-Breisach', '00');
INSERT INTO banktransfer_blz VALUES(68052863, 'Sparkasse Schönau-Todtnau', '00');
INSERT INTO banktransfer_blz VALUES(68061505, 'Volksbank Breisgau-Süd', '06');
INSERT INTO banktransfer_blz VALUES(68062105, 'Raiffeisenbank Denzlingen-Sexau', '06');
INSERT INTO banktransfer_blz VALUES(68062730, 'Raiffeisenbank Wyhl', '06');
INSERT INTO banktransfer_blz VALUES(68063254, 'Spar- u Kreditbank Bad Krozingen-Heitersheim', '06');
INSERT INTO banktransfer_blz VALUES(68063479, 'Raiffeisenbank Kaiserstuhl', '06');
INSERT INTO banktransfer_blz VALUES(68064222, 'Raiffeisenbank', '06');
INSERT INTO banktransfer_blz VALUES(68070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(68070030, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(68080030, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(68080031, 'Commerzbank vormals Dresdner Bank Zw Münsterstraße', '76');
INSERT INTO banktransfer_blz VALUES(68080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(68080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(68090000, 'Volksbank Freiburg', '06');
INSERT INTO banktransfer_blz VALUES(68090622, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(68090900, 'PSD Bank RheinNeckarSaar', '91');
INSERT INTO banktransfer_blz VALUES(68091900, 'Volksbank Müllheim', '06');
INSERT INTO banktransfer_blz VALUES(68092000, 'Volksbank Breisgau Nord', '06');
INSERT INTO banktransfer_blz VALUES(68092300, 'Volksbank Staufen', '06');
INSERT INTO banktransfer_blz VALUES(68250040, 'Sparkasse Lahr -alt-', '03');
INSERT INTO banktransfer_blz VALUES(68270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(68270033, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(68290000, 'Volksbank Lahr', '06');
INSERT INTO banktransfer_blz VALUES(68300000, 'Bundesbank eh Lörrach', '09');
INSERT INTO banktransfer_blz VALUES(68310111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(68320020, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(68340058, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(68350048, 'Sparkasse Lörrach-Rheinfelden', '00');
INSERT INTO banktransfer_blz VALUES(68351557, 'Sparkasse Schopfheim-Zell', '00');
INSERT INTO banktransfer_blz VALUES(68351865, 'Sparkasse Markgräflerland', '00');
INSERT INTO banktransfer_blz VALUES(68351976, 'Sparkasse Zell i W -alt-', '00');
INSERT INTO banktransfer_blz VALUES(68361394, 'Raiffeisenbank Maulburg -alt-', '06');
INSERT INTO banktransfer_blz VALUES(68370024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(68370034, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(68390000, 'Volksbank Dreiländereck', '06');
INSERT INTO banktransfer_blz VALUES(68391500, 'VR Bank', '06');
INSERT INTO banktransfer_blz VALUES(68452290, 'Sparkasse Hochrhein', '00');
INSERT INTO banktransfer_blz VALUES(68462427, 'Volksbank Klettgau-Wutöschingen', '06');
INSERT INTO banktransfer_blz VALUES(68490000, 'Volksbank Rhein-Wehra', '06');
INSERT INTO banktransfer_blz VALUES(68491500, 'Volksbank Jestetten', '06');
INSERT INTO banktransfer_blz VALUES(68492200, 'Volksbank Hochrhein', '06');
INSERT INTO banktransfer_blz VALUES(69000000, 'Bundesbank eh Konstanz', '09');
INSERT INTO banktransfer_blz VALUES(69010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(69020020, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(69020190, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(69040045, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(69050001, 'Sparkasse Bodensee', '00');
INSERT INTO banktransfer_blz VALUES(69051410, 'Bezirkssparkasse Reichenau', '00');
INSERT INTO banktransfer_blz VALUES(69051620, 'Sparkasse Pfullendorf-Meßkirch', '00');
INSERT INTO banktransfer_blz VALUES(69051725, 'Sparkasse Salem-Heiligenberg', '00');
INSERT INTO banktransfer_blz VALUES(69061800, 'Volksbank Überlingen', '06');
INSERT INTO banktransfer_blz VALUES(69070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(69070032, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(69091200, 'Hagnauer Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(69091600, 'Volksbank Pfullendorf', '06');
INSERT INTO banktransfer_blz VALUES(69220020, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(69220186, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(69240075, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(69250035, 'Sparkasse Singen-Radolfzell', '00');
INSERT INTO banktransfer_blz VALUES(69251445, 'Sparkasse Engen-Gottmadingen', '00');
INSERT INTO banktransfer_blz VALUES(69251755, 'Sparkasse Stockach', '00');
INSERT INTO banktransfer_blz VALUES(69270024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(69270038, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(69280035, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(69290000, 'Volksbank Hegau', '06');
INSERT INTO banktransfer_blz VALUES(69291000, 'Volksbank Konstanz', '06');
INSERT INTO banktransfer_blz VALUES(69362032, 'Volksbank Meßkirch Raiffeisenbank', '06');
INSERT INTO banktransfer_blz VALUES(69400000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(69421020, 'Baden-Württembergische Bank', '65');
INSERT INTO banktransfer_blz VALUES(69440007, 'Commerzbank Villingen u Schwenningen', '13');
INSERT INTO banktransfer_blz VALUES(69450065, 'Sparkasse Schwarzwald-Baar', '03');
INSERT INTO banktransfer_blz VALUES(69451070, 'Sparkasse Donaueschingen -alt-', '03');
INSERT INTO banktransfer_blz VALUES(69470024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(69470039, 'Deutsche Bank Villingen u Schwenningen', '63');
INSERT INTO banktransfer_blz VALUES(69490000, 'Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(69491700, 'Volksbank Triberg', '06');
INSERT INTO banktransfer_blz VALUES(70000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(70010080, 'Postbank (Giro)', '24');
INSERT INTO banktransfer_blz VALUES(70010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(70010424, 'Aareal Bank', '09');
INSERT INTO banktransfer_blz VALUES(70010500, 'Deutsche Pfandbriefbank', '09');
INSERT INTO banktransfer_blz VALUES(70011100, 'Deutsche Kontor Privatbank', '06');
INSERT INTO banktransfer_blz VALUES(70011110, 'Deutsche Kontor Privatbank Sofort Bank', '06');
INSERT INTO banktransfer_blz VALUES(70011200, 'Bank Vontobel Europe', '09');
INSERT INTO banktransfer_blz VALUES(70011300, 'Autobank', '16');
INSERT INTO banktransfer_blz VALUES(70011400, 'BfW - Bank für Wohnungswirtschaft', '09');
INSERT INTO banktransfer_blz VALUES(70011500, 'SIEMENS BANK', '09');
INSERT INTO banktransfer_blz VALUES(70011700, 'Bankhaus von der Heydt', '01');
INSERT INTO banktransfer_blz VALUES(70011900, 'InterCard', '10');
INSERT INTO banktransfer_blz VALUES(70011910, 'InterCard Cash Services 10', '10');
INSERT INTO banktransfer_blz VALUES(70011920, 'InterCard Cash Services 20', '10');
INSERT INTO banktransfer_blz VALUES(70012000, 'UniCredit Family Financing Bank Ndl Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(70012100, 'VEM Aktienbank', '55');
INSERT INTO banktransfer_blz VALUES(70012200, 'Bank Sarasin', '06');
INSERT INTO banktransfer_blz VALUES(70012300, 'V-Bank', '17');
INSERT INTO banktransfer_blz VALUES(70012500, 'Hypo Tirol Bank', '50');
INSERT INTO banktransfer_blz VALUES(70012600, 'Südtiroler Sparkasse Niederlassung München', '06');
INSERT INTO banktransfer_blz VALUES(70013000, 'European Bank for Fund Services', '67');
INSERT INTO banktransfer_blz VALUES(70013100, 'Payment Services Zndl der Bankverein Werther', '09');
INSERT INTO banktransfer_blz VALUES(70013500, 'Bankhaus Herzogpark', '06');
INSERT INTO banktransfer_blz VALUES(70020001, 'UniCredit Bank - HypoVereinsbank Ndl 645 M', '95');
INSERT INTO banktransfer_blz VALUES(70020270, 'UniCredit Bank - HypoVereinsbank', '95');
INSERT INTO banktransfer_blz VALUES(70020300, 'Commerz Finanz', '09');
INSERT INTO banktransfer_blz VALUES(70020500, 'Bank für Sozialwirtschaft', '09');
INSERT INTO banktransfer_blz VALUES(70020800, 'INTESA SANPAOLO', '09');
INSERT INTO banktransfer_blz VALUES(70021180, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(70022200, 'FIDOR Bank', '16');
INSERT INTO banktransfer_blz VALUES(70025175, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(70030014, 'Fürst Fugger Privatbank', '00');
INSERT INTO banktransfer_blz VALUES(70030111, 'Bankhaus Max Flessa', '09');
INSERT INTO banktransfer_blz VALUES(70030300, 'Bankhaus Reuschel & Co', '09');
INSERT INTO banktransfer_blz VALUES(70030400, 'Merck Finck & Co', '10');
INSERT INTO banktransfer_blz VALUES(70030800, 'Delbrück Bethmann Maffei', '00');
INSERT INTO banktransfer_blz VALUES(70031000, 'Bankhaus Ludwig Sperrer', '00');
INSERT INTO banktransfer_blz VALUES(70032500, 'St. Galler Kantonalbank Deutschland', '09');
INSERT INTO banktransfer_blz VALUES(70033100, 'Baader Bank', '09');
INSERT INTO banktransfer_blz VALUES(70035000, 'Allianz Bank (Zndl der Oldenburgische Landesbank)', '61');
INSERT INTO banktransfer_blz VALUES(70040041, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(70040048, 'Commerzbank GF-M48', '13');
INSERT INTO banktransfer_blz VALUES(70040060, 'Commerzbank Gf 860', '09');
INSERT INTO banktransfer_blz VALUES(70040061, 'Commerzbank Gf 861', '09');
INSERT INTO banktransfer_blz VALUES(70040062, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(70040063, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(70045050, 'Commerzbank Service-BZ', '13');
INSERT INTO banktransfer_blz VALUES(70050000, 'Bayerische Landesbank', '09');
INSERT INTO banktransfer_blz VALUES(70051003, 'Sparkasse Freising', '00');
INSERT INTO banktransfer_blz VALUES(70051540, 'Sparkasse Dachau', '00');
INSERT INTO banktransfer_blz VALUES(70051805, 'Kreissparkasse München Starnberg Ebersberg', '00');
INSERT INTO banktransfer_blz VALUES(70051995, 'Kreis- und Stadtsparkasse Erding-Dorfen', '00');
INSERT INTO banktransfer_blz VALUES(70052060, 'Sparkasse Landsberg-Dießen', '00');
INSERT INTO banktransfer_blz VALUES(70053070, 'Sparkasse Fürstenfeldbruck', '00');
INSERT INTO banktransfer_blz VALUES(70054080, 'Sparkasse Starnberg -alt-', '00');
INSERT INTO banktransfer_blz VALUES(70054306, 'Sparkasse Bad Tölz-Wolfratshausen', '00');
INSERT INTO banktransfer_blz VALUES(70070010, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(70070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(70080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(70080056, 'Commerzbank vormals Dresdner Bank Zw 56', '76');
INSERT INTO banktransfer_blz VALUES(70080057, 'Commerzbank vormals Dresdner Bank Gf ZW 57', '76');
INSERT INTO banktransfer_blz VALUES(70080085, 'Commerzbank vormals Dresdner Bank Gf PCC DCC-ITGK 3', '09');
INSERT INTO banktransfer_blz VALUES(70080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 4', '09');
INSERT INTO banktransfer_blz VALUES(70080087, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 5', '09');
INSERT INTO banktransfer_blz VALUES(70080088, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 6', '09');
INSERT INTO banktransfer_blz VALUES(70089470, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(70089472, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(70090100, 'Hausbank München', '88');
INSERT INTO banktransfer_blz VALUES(70090124, 'Hausbank München', '10');
INSERT INTO banktransfer_blz VALUES(70090500, 'Sparda-Bank München', '81');
INSERT INTO banktransfer_blz VALUES(70090606, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(70091500, 'Volksbank Raiffeisenbank Dachau', '88');
INSERT INTO banktransfer_blz VALUES(70091600, 'Landsberg-Ammersee Bank', '88');
INSERT INTO banktransfer_blz VALUES(70091900, 'VR-Bank Erding', '88');
INSERT INTO banktransfer_blz VALUES(70093200, 'VR-Bank Starnberg-Herrsching-Landsberg', '88');
INSERT INTO banktransfer_blz VALUES(70093400, 'Volksbank Raiffeisenbank Ismaning', '88');
INSERT INTO banktransfer_blz VALUES(70110088, 'Postbank (Spar)', '09');
INSERT INTO banktransfer_blz VALUES(70110500, 'Münchener Hypothekenbank', '09');
INSERT INTO banktransfer_blz VALUES(70110600, 'UBI BANCA INTERNATIONAL - Ndl München', '09');
INSERT INTO banktransfer_blz VALUES(70120100, 'State Street Bank', '09');
INSERT INTO banktransfer_blz VALUES(70120200, 'The Royal Bank of Scotland, Niederlassung Deutschland', '10');
INSERT INTO banktransfer_blz VALUES(70120400, 'DAB bank', '00');
INSERT INTO banktransfer_blz VALUES(70120500, 'CACEIS Bank Deutschland', 'D2');
INSERT INTO banktransfer_blz VALUES(70120600, 'Salzburg München Bank', '30');
INSERT INTO banktransfer_blz VALUES(70120700, 'Oberbank Ndl Deutschland', '00');
INSERT INTO banktransfer_blz VALUES(70120900, 'UniCredit Bank - HypoVereinsbank Ndl BACA', '95');
INSERT INTO banktransfer_blz VALUES(70130700, 'Bankhaus August Lenz & Co', '09');
INSERT INTO banktransfer_blz VALUES(70130800, 'Merkur Bank', '88');
INSERT INTO banktransfer_blz VALUES(70133300, 'Santander Consumer Bank', '09');
INSERT INTO banktransfer_blz VALUES(70150000, 'Stadtsparkasse München', '00');
INSERT INTO banktransfer_blz VALUES(70160000, 'DZ BANK', '09');
INSERT INTO banktransfer_blz VALUES(70160300, 'Raiffeisenbank München -alt-', '88');
INSERT INTO banktransfer_blz VALUES(70163370, 'Volksbank Raiffeisenbank Fürstenfeldbruck', '88');
INSERT INTO banktransfer_blz VALUES(70166486, 'VR Bank München Land', '88');
INSERT INTO banktransfer_blz VALUES(70169132, 'Raiffeisenbank Griesstätt-Halfing', '88');
INSERT INTO banktransfer_blz VALUES(70169165, 'Raiffeisenbank Chiemgau-Nord - Obing', '88');
INSERT INTO banktransfer_blz VALUES(70169168, 'VR-Bank Chiemgau-Süd -alt-', '88');
INSERT INTO banktransfer_blz VALUES(70169179, 'Volksbank Siegsdorf-Bergen -alt-', '88');
INSERT INTO banktransfer_blz VALUES(70169186, 'Raiffeisenbank Pfaffenhofen a d Glonn', '88');
INSERT INTO banktransfer_blz VALUES(70169190, 'Raiffeisenbank Tattenh-Großkarolinenf', '88');
INSERT INTO banktransfer_blz VALUES(70169191, 'Raiffeisenbank Rupertiwinkel', '88');
INSERT INTO banktransfer_blz VALUES(70169195, 'Raiffeisenbank Trostberg-Traunreut', '88');
INSERT INTO banktransfer_blz VALUES(70169310, 'Raiffeisenbank Alxing-Bruck', '88');
INSERT INTO banktransfer_blz VALUES(70169322, 'Raiffeisenbank Aufkirchen -alt-', '88');
INSERT INTO banktransfer_blz VALUES(70169331, 'Raiffeisenbank südöstl. Starnberger See', '88');
INSERT INTO banktransfer_blz VALUES(70169333, 'Raiffeisenbank Beuerberg-Eurasburg', '88');
INSERT INTO banktransfer_blz VALUES(70169351, 'Raiffeisenbank Nordkreis Landsberg', '88');
INSERT INTO banktransfer_blz VALUES(70169356, 'Raiffeisenbank Erding', '88');
INSERT INTO banktransfer_blz VALUES(70169382, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(70169383, 'Raiffeisenbank Gmund am Tegernsee', '88');
INSERT INTO banktransfer_blz VALUES(70169388, 'Raiffeisenbank Haag-Gars-Maitenbeth', '88');
INSERT INTO banktransfer_blz VALUES(70169402, 'Raiffeisenbank Höhenkirchen und Umgebung', '88');
INSERT INTO banktransfer_blz VALUES(70169410, 'Raiffeisenbank Holzkirchen-Otterfing', '88');
INSERT INTO banktransfer_blz VALUES(70169413, 'Raiffeisenbank Singoldtal', '88');
INSERT INTO banktransfer_blz VALUES(70169433, 'Raiffeisenbank Königsdorf-Gelting', '88');
INSERT INTO banktransfer_blz VALUES(70169444, 'Raiffeisenbank im Isarwinkel -alt-', '88');
INSERT INTO banktransfer_blz VALUES(70169450, 'Raiffeisen-Volksbank Ebersberg', '88');
INSERT INTO banktransfer_blz VALUES(70169459, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(70169460, 'Raiffeisenbank Westkreis Fürstenfeldbruck', '88');
INSERT INTO banktransfer_blz VALUES(70169464, 'Genossenschaftsbank München', '88');
INSERT INTO banktransfer_blz VALUES(70169465, 'Raiffeisenbank München-Nord', '88');
INSERT INTO banktransfer_blz VALUES(70169466, 'Raiffeisenbank München-Süd', '88');
INSERT INTO banktransfer_blz VALUES(70169470, 'Raiffeisenbank München-Süd Gf GA', '88');
INSERT INTO banktransfer_blz VALUES(70169472, 'Raiffeisenbank Hallbergmoos-Neufahrn', '88');
INSERT INTO banktransfer_blz VALUES(70169474, 'Raiffbk Neumarkt-St. Veit - Niederbergkirchen', '88');
INSERT INTO banktransfer_blz VALUES(70169476, 'Raiffeisenbank -alt-', '88');
INSERT INTO banktransfer_blz VALUES(70169493, 'Raiffeisenbank Oberschleißheim', '88');
INSERT INTO banktransfer_blz VALUES(70169495, 'Raiffeisenbank Buchbach-Schwindegg -alt-', '88');
INSERT INTO banktransfer_blz VALUES(70169505, 'Raiffeisenbank Anzing-Forstern -alt-', '88');
INSERT INTO banktransfer_blz VALUES(70169509, 'Raiffeisenbank Pfaffenwinkel', '88');
INSERT INTO banktransfer_blz VALUES(70169521, 'Raiffeisenbank Raisting', '88');
INSERT INTO banktransfer_blz VALUES(70169524, 'Raiffeisenbank RSA', '88');
INSERT INTO banktransfer_blz VALUES(70169530, 'Raiffeisenbank Reischach-Wurmannsquick-Zeilarn', '88');
INSERT INTO banktransfer_blz VALUES(70169538, 'Raiffeisenbank St. Wolfgang-Schwindkirchen', '88');
INSERT INTO banktransfer_blz VALUES(70169541, 'Raiffeisenbank Lech-Ammersee', '88');
INSERT INTO banktransfer_blz VALUES(70169543, 'Raiffeisenbank Isar-Loisachtal', '88');
INSERT INTO banktransfer_blz VALUES(70169558, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(70169566, 'VR-Bank Taufkirchen-Dorfen', '88');
INSERT INTO banktransfer_blz VALUES(70169568, 'Raiffeisenbank Taufkirchen-Oberneukirchen', '88');
INSERT INTO banktransfer_blz VALUES(70169570, 'Raiffeisenbank Thalheim -alt-', '88');
INSERT INTO banktransfer_blz VALUES(70169571, 'Raiffeisenbank Tölzer Land', '88');
INSERT INTO banktransfer_blz VALUES(70169575, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(70169576, 'Raiffeisen-Volksbank Tüßling-Unterneukirchen', '88');
INSERT INTO banktransfer_blz VALUES(70169585, 'Raiffeisenbank Unterschleißheim-Haimhn -alt-', '88');
INSERT INTO banktransfer_blz VALUES(70169596, 'Raiffeisenbank Walpertskirchen-Wörth-Hörlkofen', '88');
INSERT INTO banktransfer_blz VALUES(70169598, 'Raiffeisenbank im Oberland', '88');
INSERT INTO banktransfer_blz VALUES(70169599, 'Raiffeisenbank Weil u Umgebung', '88');
INSERT INTO banktransfer_blz VALUES(70169602, 'Raiffeisenbank Weilheim', '88');
INSERT INTO banktransfer_blz VALUES(70169605, 'Raiffeisen-Volksbank Isen-Sempt', '88');
INSERT INTO banktransfer_blz VALUES(70169614, 'Freisinger Bank Volksbank-Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(70169619, 'Raiffeisenbank Zorneding', '88');
INSERT INTO banktransfer_blz VALUES(70169653, 'Raiffeisenbank Aiglsbach', '88');
INSERT INTO banktransfer_blz VALUES(70169693, 'Raiffeisenbank Hallertau', '88');
INSERT INTO banktransfer_blz VALUES(70190000, 'Münchner Bank', '88');
INSERT INTO banktransfer_blz VALUES(70190200, 'GLS Gemeinschaftsbank', '88');
INSERT INTO banktransfer_blz VALUES(70220000, 'LfA Förderbank Bayern', '09');
INSERT INTO banktransfer_blz VALUES(70220200, 'BHF-BANK', '60');
INSERT INTO banktransfer_blz VALUES(70220300, 'BMW Bank', '09');
INSERT INTO banktransfer_blz VALUES(70220400, 'Hanseatic Bank', '16');
INSERT INTO banktransfer_blz VALUES(70220800, 'Vereinsbank Victoria Bauspar', '07');
INSERT INTO banktransfer_blz VALUES(70220900, 'Wüstenrot Bausparkasse', '61');
INSERT INTO banktransfer_blz VALUES(70230600, 'Isbank Fil München', '06');
INSERT INTO banktransfer_blz VALUES(70250150, 'Kreissparkasse München Starnberg Ebersberg', '00');
INSERT INTO banktransfer_blz VALUES(70300000, 'Bundesbank eh Garmisch-Partenkirchen', '09');
INSERT INTO banktransfer_blz VALUES(70320090, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(70320305, 'UniCredit Bank - HypoVereinsbank Ndl 635 Gar', '99');
INSERT INTO banktransfer_blz VALUES(70321194, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(70322192, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(70350000, 'Kreissparkasse Garmisch-Partenkirchen', '00');
INSERT INTO banktransfer_blz VALUES(70351030, 'Vereinigte Sparkassen im Landkreis Weilheim', '00');
INSERT INTO banktransfer_blz VALUES(70362595, 'Raiffeisenbank Wallgau-Krün', '88');
INSERT INTO banktransfer_blz VALUES(70380006, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(70390000, 'VR-Bank im Landkreis Garmisch-Partenkirchen', '88');
INSERT INTO banktransfer_blz VALUES(70391800, 'Volksbank-Raiffeisenbank Penzberg', '88');
INSERT INTO banktransfer_blz VALUES(71000000, 'Bundesbank eh Bad Reichenhall', '09');
INSERT INTO banktransfer_blz VALUES(71020072, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(71021270, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(71022182, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(71023173, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(71050000, 'Sparkasse Berchtesgadener Land', '00');
INSERT INTO banktransfer_blz VALUES(71051010, 'Kreissparkasse Altötting-Burghausen -alt-', '00');
INSERT INTO banktransfer_blz VALUES(71052050, 'Kreissparkasse Traunstein-Trostberg', '00');
INSERT INTO banktransfer_blz VALUES(71061009, 'VR meine Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(71062194, 'Volksbank Raiffeisen Traunstein -alt-', '88');
INSERT INTO banktransfer_blz VALUES(71062802, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(71090000, 'Volksbank Raiffeisenbank Oberbayern Südost', '88');
INSERT INTO banktransfer_blz VALUES(71100000, 'Bundesbank eh Rosenheim', '09');
INSERT INTO banktransfer_blz VALUES(71120077, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(71120078, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(71121176, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(71122183, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(71140041, 'Commerzbank Rosenheim', '13');
INSERT INTO banktransfer_blz VALUES(71141041, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(71142041, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(71150000, 'Sparkasse Rosenheim-Bad Aibling', '00');
INSERT INTO banktransfer_blz VALUES(71151020, 'Sparkasse Altötting-Mühldorf', '00');
INSERT INTO banktransfer_blz VALUES(71151240, 'Kreissparkasse Bad Aibling -alt-', '00');
INSERT INTO banktransfer_blz VALUES(71152570, 'Kreissparkasse Miesbach-Tegernsee', '00');
INSERT INTO banktransfer_blz VALUES(71152680, 'Kreis- und Stadtsparkasse Wasserburg', '00');
INSERT INTO banktransfer_blz VALUES(71160000, 'Volksbank Raiffeisenbank Mangfalltal-Rosenheim', '88');
INSERT INTO banktransfer_blz VALUES(71160161, 'VR Bank Rosenheim-Chiemsee', '88');
INSERT INTO banktransfer_blz VALUES(71161964, 'Volksbank-Raiffeisenbank Chiemsee -alt-', '88');
INSERT INTO banktransfer_blz VALUES(71162355, 'Raiffeisenbank Oberaudorf', '88');
INSERT INTO banktransfer_blz VALUES(71162804, 'Raiffeisenbank Aschau-Samerberg', '88');
INSERT INTO banktransfer_blz VALUES(71165150, 'Raiffeisenbank Mangfalltal -alt-', '88');
INSERT INTO banktransfer_blz VALUES(71180005, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(71190000, 'Volksbank Rosenheim -alt-', '88');
INSERT INTO banktransfer_blz VALUES(71191000, 'VR-Bank Burghausen-Mühldorf', '88');
INSERT INTO banktransfer_blz VALUES(72000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(72010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(72012300, 'Bank für Tirol und Vorarlberg Deutschland', '26');
INSERT INTO banktransfer_blz VALUES(72020070, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(72020240, 'UniCredit Bank - HypoVereinsbank Ndl 677 Agsb', '99');
INSERT INTO banktransfer_blz VALUES(72020700, 'Augsburger Aktienbank', '23');
INSERT INTO banktransfer_blz VALUES(72021271, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(72021876, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(72030014, 'Fürst Fugger Privatbank', '00');
INSERT INTO banktransfer_blz VALUES(72030227, 'Hafner, Anton - Bankgeschäft', '00');
INSERT INTO banktransfer_blz VALUES(72040046, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(72050000, 'Stadtsparkasse Augsburg', '00');
INSERT INTO banktransfer_blz VALUES(72050101, 'Kreissparkasse Augsburg', '00');
INSERT INTO banktransfer_blz VALUES(72051210, 'Stadtsparkasse Aichach', '00');
INSERT INTO banktransfer_blz VALUES(72051840, 'Sparkasse Günzburg-Krumbach', '00');
INSERT INTO banktransfer_blz VALUES(72060300, 'Handels- und Gewerbebank Augsburg -alt-', '88');
INSERT INTO banktransfer_blz VALUES(72062152, 'VR-Bank Lech-Zusam', '88');
INSERT INTO banktransfer_blz VALUES(72069002, 'Raiffeisenbank Adelzhausen-Sielenbach', '88');
INSERT INTO banktransfer_blz VALUES(72069005, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(72069034, 'Raiffeisenbank Bissingen', '88');
INSERT INTO banktransfer_blz VALUES(72069036, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(72069043, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(72069081, 'Raiffeisenbank Gersthofen -alt-', '88');
INSERT INTO banktransfer_blz VALUES(72069090, 'Raiffeisenbank Bibertal-Kötz', '88');
INSERT INTO banktransfer_blz VALUES(72069105, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(72069108, 'Raiffeisenbank Höchstädt u. U. -alt-', '88');
INSERT INTO banktransfer_blz VALUES(72069113, 'Raiffeisenbank Aschberg', '88');
INSERT INTO banktransfer_blz VALUES(72069114, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(72069119, 'Raiffeisenbank Ichenhausen', '88');
INSERT INTO banktransfer_blz VALUES(72069123, 'Raiffeisenbank Jettingen-Scheppach', '88');
INSERT INTO banktransfer_blz VALUES(72069126, 'Raiffeisenbank Bibertal-Kötz', '88');
INSERT INTO banktransfer_blz VALUES(72069132, 'Raiffeisenbank Krumbach/Schwaben', '88');
INSERT INTO banktransfer_blz VALUES(72069135, 'Raiffeisenbank Stauden', '88');
INSERT INTO banktransfer_blz VALUES(72069139, 'Raiffeisenbank Langweid-Achsheim -alt-', '88');
INSERT INTO banktransfer_blz VALUES(72069141, 'Raiffeisenbank -alt-', '88');
INSERT INTO banktransfer_blz VALUES(72069155, 'Raiffeisenbank Kissing-Mering', '88');
INSERT INTO banktransfer_blz VALUES(72069168, 'Vereinigte Raiffeisenbank in Niederraunau -alt-', '88');
INSERT INTO banktransfer_blz VALUES(72069179, 'Raiffeisenbank Unteres Zusamtal', '88');
INSERT INTO banktransfer_blz VALUES(72069181, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(72069193, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(72069209, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(72069220, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(72069235, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(72069263, 'Raiffeisenbank Wittislingen', '88');
INSERT INTO banktransfer_blz VALUES(72069274, 'Raiffeisenbank Augsburger Land West', '88');
INSERT INTO banktransfer_blz VALUES(72069308, 'Raiffeisen-Volksbank Wemding', '88');
INSERT INTO banktransfer_blz VALUES(72069325, 'Raiffeisenbank Möttingen -alt-', '88');
INSERT INTO banktransfer_blz VALUES(72069329, 'Raiffeisen-Volksbank Ries', '88');
INSERT INTO banktransfer_blz VALUES(72069330, 'Raiffeisenbank Oberes Kesseltal -alt-', '88');
INSERT INTO banktransfer_blz VALUES(72069736, 'Raiffeisenbank Iller-Roth-Günz', '88');
INSERT INTO banktransfer_blz VALUES(72069789, 'Raiffeisenbank Pfaffenhausen', '88');
INSERT INTO banktransfer_blz VALUES(72070001, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(72070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(72080001, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(72090000, 'Augusta-Bank Raiffeisen-Volksbank', '88');
INSERT INTO banktransfer_blz VALUES(72090500, 'Sparda-Bank Augsburg', '84');
INSERT INTO banktransfer_blz VALUES(72090900, 'PSD Bank München', '91');
INSERT INTO banktransfer_blz VALUES(72091800, 'Volksbank Günzburg', '10');
INSERT INTO banktransfer_blz VALUES(72100000, 'Bundesbank eh Ingolstadt', '09');
INSERT INTO banktransfer_blz VALUES(72120078, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(72120079, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(72120207, 'UniCredit Bank - HypoVereinsbank Ndl 648 Ing', '99');
INSERT INTO banktransfer_blz VALUES(72122181, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(72140052, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(72150000, 'Sparkasse Ingolstadt', '00');
INSERT INTO banktransfer_blz VALUES(72151340, 'Sparkasse Eichstätt', '00');
INSERT INTO banktransfer_blz VALUES(72151650, 'Sparkasse Pfaffenhofen', '00');
INSERT INTO banktransfer_blz VALUES(72151880, 'Stadtsparkasse Schrobenhausen', '00');
INSERT INTO banktransfer_blz VALUES(72152070, 'Sparkasse Neuburg-Rain', '00');
INSERT INTO banktransfer_blz VALUES(72160818, 'Volksbank Raiffeisenbank Bayern Mitte', '88');
INSERT INTO banktransfer_blz VALUES(72169013, 'Raiffeisenbank Aresing-Hörzhausen-Schiltberg -alt-', '88');
INSERT INTO banktransfer_blz VALUES(72169080, 'Raiffeisenbank Aresing-Gerolsbach', '88');
INSERT INTO banktransfer_blz VALUES(72169111, 'Raiffeisenbank Hohenwart -alt-', '88');
INSERT INTO banktransfer_blz VALUES(72169218, 'Raiffeisenbank Schrobenhausen', '88');
INSERT INTO banktransfer_blz VALUES(72169246, 'Raiffeisenbank Schrobenhausener Land', '88');
INSERT INTO banktransfer_blz VALUES(72169380, 'Raiffeisenbank Beilngries', '88');
INSERT INTO banktransfer_blz VALUES(72169733, 'Raiffeisenbank Berg im Gau-Langenmosen -alt-', '88');
INSERT INTO banktransfer_blz VALUES(72169745, 'Raiffeisenbank Ehekirchen-Oberhausen', '88');
INSERT INTO banktransfer_blz VALUES(72169753, 'Raiffeisenbank Ober-Unterhausen-Sinning -alt-', '88');
INSERT INTO banktransfer_blz VALUES(72169756, 'Raiffeisen-Volksbank Neuburg/Donau', '88');
INSERT INTO banktransfer_blz VALUES(72169764, 'Raiffeisenbank Donaumooser Land', '88');
INSERT INTO banktransfer_blz VALUES(72169812, 'Raiffeisenbank Gaimersheim-Buxheim', '88');
INSERT INTO banktransfer_blz VALUES(72169831, 'Raiffeisenbank Riedenburg-Lobsing', '88');
INSERT INTO banktransfer_blz VALUES(72170007, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(72170024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(72180002, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(72191300, 'Volksbank Raiffeisenbank Eichstätt', '88');
INSERT INTO banktransfer_blz VALUES(72191600, 'Hallertauer Volksbank', '88');
INSERT INTO banktransfer_blz VALUES(72191800, 'Volksbank Schrobenhausen', '88');
INSERT INTO banktransfer_blz VALUES(72220074, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(72223182, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(72250000, 'Sparkasse Nördlingen', '00');
INSERT INTO banktransfer_blz VALUES(72250160, 'Sparkasse Donauwörth', '00');
INSERT INTO banktransfer_blz VALUES(72251520, 'Kreis- und Stadtsparkasse Dillingen', '10');
INSERT INTO banktransfer_blz VALUES(72261754, 'Raiffeisenbank Rain am Lech', '88');
INSERT INTO banktransfer_blz VALUES(72262401, 'Raiffeisen-Volksbank Dillingen', '88');
INSERT INTO banktransfer_blz VALUES(72262901, 'Genossenschaftsbank Wertingen -alt-', '88');
INSERT INTO banktransfer_blz VALUES(72290100, 'Raiffeisen-Volksbank Donauwörth', '88');
INSERT INTO banktransfer_blz VALUES(73050000, 'Sparkasse Neu-Ulm-Illertissen', '00');
INSERT INTO banktransfer_blz VALUES(73061191, 'VR-Bank Neu-Ulm/Weißenhorn', '88');
INSERT INTO banktransfer_blz VALUES(73090000, 'Volksbank Neu-Ulm', '88');
INSERT INTO banktransfer_blz VALUES(73100000, 'Bundesbank eh Memmingen', '09');
INSERT INTO banktransfer_blz VALUES(73120075, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(73140046, 'Commerzbank Memmingen', '13');
INSERT INTO banktransfer_blz VALUES(73150000, 'Sparkasse Memmingen-Lindau-Mindelheim', '00');
INSERT INTO banktransfer_blz VALUES(73160000, 'Genossenschaftsbank Unterallgäu', '88');
INSERT INTO banktransfer_blz VALUES(73161455, 'Raiffeisenbank Bad Grönenbach', '88');
INSERT INTO banktransfer_blz VALUES(73180011, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(73190000, 'VR-Bank Memmingen', '88');
INSERT INTO banktransfer_blz VALUES(73191500, 'Volksbank Ulm-Biberach', '10');
INSERT INTO banktransfer_blz VALUES(73300000, 'Bundesbank eh Kempten', '09');
INSERT INTO banktransfer_blz VALUES(73311600, 'Vorarlberger Landes- und Hypothekenbank', '09');
INSERT INTO banktransfer_blz VALUES(73320073, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(73320442, 'UniCredit Bank - HypoVereinsbank Ndl 669 Kpt', '99');
INSERT INTO banktransfer_blz VALUES(73321177, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(73322380, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(73331700, 'Gabler Saliter Bankgeschäft', '09');
INSERT INTO banktransfer_blz VALUES(73340046, 'Commerzbank Kempten Allgäu', '13');
INSERT INTO banktransfer_blz VALUES(73350000, 'Sparkasse Allgäu', '00');
INSERT INTO banktransfer_blz VALUES(73351635, 'Sparkasse Riezlern, Kleinwalsertal', '00');
INSERT INTO banktransfer_blz VALUES(73351840, 'Dornbirner Sparkasse', '09');
INSERT INTO banktransfer_blz VALUES(73361592, 'Walser Privatbank', '60');
INSERT INTO banktransfer_blz VALUES(73362421, 'Bankhaus Jungholz Zndl der Raiffeisenbank Reutte', '09');
INSERT INTO banktransfer_blz VALUES(73362500, 'Raiffeisen-Landesbank Tirol', 'A1');
INSERT INTO banktransfer_blz VALUES(73369264, 'Raiffeisenbank im Allgäuer Land', '88');
INSERT INTO banktransfer_blz VALUES(73369821, 'Raiffeisen-Bodenseebank', '88');
INSERT INTO banktransfer_blz VALUES(73369823, 'Raiffeisenbank Westallgäu', '09');
INSERT INTO banktransfer_blz VALUES(73369824, 'Raiffeisenbank Heimenkirch-Ellhofen -alt-', '88');
INSERT INTO banktransfer_blz VALUES(73369826, 'Volksbank', '88');
INSERT INTO banktransfer_blz VALUES(73369851, 'Raiffeisenbank Aitrang-Ruderatshofen', '88');
INSERT INTO banktransfer_blz VALUES(73369854, 'Raiffeisenbank Fuchstal-Denklingen', '88');
INSERT INTO banktransfer_blz VALUES(73369859, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(73369871, 'Raiffeisenbank Baisweil-Eggenthal-Friesenried', '88');
INSERT INTO banktransfer_blz VALUES(73369878, 'Raiffeisenbank Füssen-Pfronten-Nesselwang', '88');
INSERT INTO banktransfer_blz VALUES(73369881, 'Raiffeisenbank Haldenwang', '88');
INSERT INTO banktransfer_blz VALUES(73369888, 'Raiffeisenbank Irsee-Pforzen-Rieden -alt-', '88');
INSERT INTO banktransfer_blz VALUES(73369902, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(73369915, 'Raiffeisenbank Obergermaringen', '88');
INSERT INTO banktransfer_blz VALUES(73369918, 'Raiffeisenbank Kirchweihtal', '88');
INSERT INTO banktransfer_blz VALUES(73369920, 'Raiffeisenbank Oberallgäu-Süd', '88');
INSERT INTO banktransfer_blz VALUES(73369933, 'Raiffeisenbank Südliches Ostallgäu', '88');
INSERT INTO banktransfer_blz VALUES(73369936, 'Raiffeisenbank Seeg -alt-', '88');
INSERT INTO banktransfer_blz VALUES(73369954, 'Raiffeisenbank Wald-Görisried', '88');
INSERT INTO banktransfer_blz VALUES(73370008, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(73370024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(73380004, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(73390000, 'Allgäuer Volksbank Kempten-Sonthofen', '88');
INSERT INTO banktransfer_blz VALUES(73391600, 'Volksbank im Kleinwalsertal', '09');
INSERT INTO banktransfer_blz VALUES(73392000, 'Volksbank Immenstadt', '88');
INSERT INTO banktransfer_blz VALUES(73392400, 'Volksbank Tirol Jungholz', '32');
INSERT INTO banktransfer_blz VALUES(73420071, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(73420546, 'UniCredit Bank - HypoVereinsbank Ndl 693 Kaufb', '99');
INSERT INTO banktransfer_blz VALUES(73421478, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(73440048, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(73450000, 'Kreis- und Stadtsparkasse Kaufbeuren', '00');
INSERT INTO banktransfer_blz VALUES(73451450, 'Kreissparkasse Schongau', '00');
INSERT INTO banktransfer_blz VALUES(73460046, 'VR Bank Kaufbeuren-Ostallgäu', '88');
INSERT INTO banktransfer_blz VALUES(73480013, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(73491300, 'Volksbank Ostallgäu -alt-', '88');
INSERT INTO banktransfer_blz VALUES(74000000, 'Bundesbank eh Passau', '09');
INSERT INTO banktransfer_blz VALUES(74020074, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(74020100, 'Raiffeisenlandesbank OÖ Zndl Süddeutschland', '60');
INSERT INTO banktransfer_blz VALUES(74020414, 'UniCredit Bank - HypoVereinsbank Ndl 672 Pass', '99');
INSERT INTO banktransfer_blz VALUES(74040082, 'Commerzbank Passau', '13');
INSERT INTO banktransfer_blz VALUES(74050000, 'Sparkasse Passau', '00');
INSERT INTO banktransfer_blz VALUES(74051230, 'Sparkasse Freyung-Grafenau', '00');
INSERT INTO banktransfer_blz VALUES(74061101, 'Raiffeisenbank Am Goldenen Steig', '88');
INSERT INTO banktransfer_blz VALUES(74061564, 'Raiffeisenbank Unteres Inntal', '88');
INSERT INTO banktransfer_blz VALUES(74061670, 'Raiffeisenbank Ortenburg-Kirchberg', '88');
INSERT INTO banktransfer_blz VALUES(74061813, 'VR-Bank Rottal-Inn', '88');
INSERT INTO banktransfer_blz VALUES(74062490, 'Raiffeisenbank Vilshofener Land', '88');
INSERT INTO banktransfer_blz VALUES(74062786, 'Raiffeisenbank i Lkr Passau-Nord', '88');
INSERT INTO banktransfer_blz VALUES(74064593, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(74064742, 'Raiffeisenbank Fürstenzell -alt-', '88');
INSERT INTO banktransfer_blz VALUES(74065782, 'Raiffeisenbank Salzweg-Thyrnau', '88');
INSERT INTO banktransfer_blz VALUES(74066749, 'Raiffeisenbank im Südl Bayerischen Wald', '88');
INSERT INTO banktransfer_blz VALUES(74067000, 'Rottaler Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(74069186, 'Raiffeisenbank Viechtach-Zwiesel', '88');
INSERT INTO banktransfer_blz VALUES(74069744, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(74069752, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(74069758, 'Raiffeisenbank Kirchberg v. Wald', '88');
INSERT INTO banktransfer_blz VALUES(74069763, 'Raiffeisenbank Mauth', '88');
INSERT INTO banktransfer_blz VALUES(74069768, 'Raiffeisenbank am Dreisessel', '88');
INSERT INTO banktransfer_blz VALUES(74090000, 'VR-Bank Passau', '88');
INSERT INTO banktransfer_blz VALUES(74092400, 'Volksbank Vilshofen', '88');
INSERT INTO banktransfer_blz VALUES(74100000, 'Bundesbank eh Deggendorf', '09');
INSERT INTO banktransfer_blz VALUES(74120071, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(74120514, 'UniCredit Bank - HypoVereinsbank 674 Dgdf', '99');
INSERT INTO banktransfer_blz VALUES(74131000, 'TEBA Kreditbank', '09');
INSERT INTO banktransfer_blz VALUES(74140048, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(74150000, 'Sparkasse Deggendorf', '00');
INSERT INTO banktransfer_blz VALUES(74151450, 'Sparkasse Regen-Viechtach', '00');
INSERT INTO banktransfer_blz VALUES(74160025, 'Raiffeisenbank Deggendorf-Plattling', '88');
INSERT INTO banktransfer_blz VALUES(74161608, 'Raiffeisenbank Hengersberg-Schöllnach', '88');
INSERT INTO banktransfer_blz VALUES(74164149, 'VR-Bank', '88');
INSERT INTO banktransfer_blz VALUES(74165013, 'Raiffeisenbank Sonnenwald', '88');
INSERT INTO banktransfer_blz VALUES(74167099, 'Raiffeisenbank Metten', '88');
INSERT INTO banktransfer_blz VALUES(74180009, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(74190000, 'GenoBank DonauWald', '88');
INSERT INTO banktransfer_blz VALUES(74191000, 'VR-Bank Landau', '88');
INSERT INTO banktransfer_blz VALUES(74220075, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(74221170, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(74240062, 'Commerzbank Straubing', '13');
INSERT INTO banktransfer_blz VALUES(74250000, 'Sparkasse Niederbayern-Mitte', '00');
INSERT INTO banktransfer_blz VALUES(74251020, 'Sparkasse im Landkreis Cham', '00');
INSERT INTO banktransfer_blz VALUES(74260110, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(74261024, 'Raiffeisenbank Cham-Roding-Furth im Wald', '88');
INSERT INTO banktransfer_blz VALUES(74290000, 'Volksbank Straubing', '88');
INSERT INTO banktransfer_blz VALUES(74290100, 'CB Bank', '98');
INSERT INTO banktransfer_blz VALUES(74300000, 'Bundesbank eh Landshut', '09');
INSERT INTO banktransfer_blz VALUES(74320073, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(74320307, 'UniCredit Bank - HypoVereinsbank Ndl 601 Ldsht', '99');
INSERT INTO banktransfer_blz VALUES(74340077, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(74350000, 'Sparkasse Landshut', '11');
INSERT INTO banktransfer_blz VALUES(74351310, 'Sparkasse Dingolfing-Landau -alt-', '00');
INSERT INTO banktransfer_blz VALUES(74351430, 'Sparkasse Rottal-Inn', '00');
INSERT INTO banktransfer_blz VALUES(74351740, 'Stadt- und Kreissparkasse Moosburg', '10');
INSERT INTO banktransfer_blz VALUES(74361211, 'Raiffeisenbank Arnstorf', '88');
INSERT INTO banktransfer_blz VALUES(74362663, 'Raiffeisenbank Altdorf-Ergolding', '88');
INSERT INTO banktransfer_blz VALUES(74364689, 'Raiffeisenbank Pfeffenhausen-Rottenburg', '88');
INSERT INTO banktransfer_blz VALUES(74366666, 'Raiffeisenbank Geisenhausen', '88');
INSERT INTO banktransfer_blz VALUES(74369068, 'Raiffeisenbank Hofkirchen-Bayerbach', '88');
INSERT INTO banktransfer_blz VALUES(74369088, 'Raiffeisenbank Geiselhöring-Pfaffenberg', '88');
INSERT INTO banktransfer_blz VALUES(74369091, 'Raiffeisenbank Straubing', '88');
INSERT INTO banktransfer_blz VALUES(74369130, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(74369146, 'Raiffeisenbank Rattiszell-Konzell', '88');
INSERT INTO banktransfer_blz VALUES(74369656, 'Raiffeisenbank Essenbach', '88');
INSERT INTO banktransfer_blz VALUES(74369662, 'Raiffeisenbank Buch-Eching', '88');
INSERT INTO banktransfer_blz VALUES(74369704, 'Raiffeisenbank Mengkofen-Loiching', '88');
INSERT INTO banktransfer_blz VALUES(74369709, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(74380007, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(74390000, 'VR-Bank Landshut', '88');
INSERT INTO banktransfer_blz VALUES(74391300, 'Volksbank-Raiffeisenbank Dingolfing', '88');
INSERT INTO banktransfer_blz VALUES(74391400, 'Rottaler Volksbank-Raiffeisenbank Eggenfelden', '88');
INSERT INTO banktransfer_blz VALUES(74392300, 'VR-Bank Vilsbiburg', '88');
INSERT INTO banktransfer_blz VALUES(75000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(75010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(75020073, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(75020314, 'UniCredit Bank - HypoVereinsbank Ndl 670 Rgsb', '99');
INSERT INTO banktransfer_blz VALUES(75021174, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(75040062, 'Commerzbank Regensburg', '13');
INSERT INTO banktransfer_blz VALUES(75050000, 'Sparkasse Regensburg', '00');
INSERT INTO banktransfer_blz VALUES(75051040, 'Sparkasse im Landkreis Schwandorf', '00');
INSERT INTO banktransfer_blz VALUES(75051565, 'Kreissparkasse Kelheim', '00');
INSERT INTO banktransfer_blz VALUES(75060150, 'Raiffeisenbank Regensburg-Wenzenbach', '88');
INSERT INTO banktransfer_blz VALUES(75061168, 'Raiffeisenbank Schwandorf-Nittenau', '88');
INSERT INTO banktransfer_blz VALUES(75061851, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(75062026, 'Raiffeisenbank Oberpfalz Süd', '88');
INSERT INTO banktransfer_blz VALUES(75069014, 'Raiffeisenbank Bad Abbach-Saal', '88');
INSERT INTO banktransfer_blz VALUES(75069015, 'Raiffeisenbank Bad Gögging', '88');
INSERT INTO banktransfer_blz VALUES(75069020, 'Raiffeisenbank Bruck', '88');
INSERT INTO banktransfer_blz VALUES(75069038, 'Raiffeisenbank Falkenstein-Wörth', '88');
INSERT INTO banktransfer_blz VALUES(75069043, 'Raiffeisen-Bank -alt-', '88');
INSERT INTO banktransfer_blz VALUES(75069050, 'Raiffeisenbank Grafenwöhr-Kirchenthumbach', '88');
INSERT INTO banktransfer_blz VALUES(75069055, 'Raiffeisenbank Alteglofsheim-Hagelstadt', '88');
INSERT INTO banktransfer_blz VALUES(75069061, 'Raiffeisenbank Hemau-Kallmünz', '88');
INSERT INTO banktransfer_blz VALUES(75069062, 'Raiffeisenbank Herrnwahlthann-Teugn-Dünzling -alt-', '88');
INSERT INTO banktransfer_blz VALUES(75069074, 'Raiffeisenbank Inkofen-Eggmühl -alt-', '88');
INSERT INTO banktransfer_blz VALUES(75069076, 'Raiffeisenbank Kallmünz -alt-', '88');
INSERT INTO banktransfer_blz VALUES(75069078, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(75069081, 'Raiffeisenbank Bad Kötzting', '88');
INSERT INTO banktransfer_blz VALUES(75069094, 'Raiffeisenbank Parsberg-Velburg', '88');
INSERT INTO banktransfer_blz VALUES(75069110, 'Raiffeisenbank Eschlkam-Lam-Lohberg-Neukirchen b Hl Blut', '88');
INSERT INTO banktransfer_blz VALUES(75069164, 'Raiffeisenbank Schierling-Obertraubling -alt-', '88');
INSERT INTO banktransfer_blz VALUES(75069171, 'Raiffeisenbank im Naabtal', '88');
INSERT INTO banktransfer_blz VALUES(75070013, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(75070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(75080003, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(75090000, 'Volksbank Regensburg', '88');
INSERT INTO banktransfer_blz VALUES(75090300, 'LIGA Bank', '88');
INSERT INTO banktransfer_blz VALUES(75090500, 'Sparda-Bank Ostbayern', '84');
INSERT INTO banktransfer_blz VALUES(75090629, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(75090900, 'PSD Bank Niederbayern-Oberpfalz', '91');
INSERT INTO banktransfer_blz VALUES(75091400, 'VR Bank Burglengenfeld', '88');
INSERT INTO banktransfer_blz VALUES(75220070, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(75240000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(75250000, 'Sparkasse Amberg-Sulzbach', '00');
INSERT INTO banktransfer_blz VALUES(75261700, 'Raiffeisenbank Sulzbach-Rosenberg', '88');
INSERT INTO banktransfer_blz VALUES(75290000, 'Volksbank-Raiffeisenbank Amberg', '88');
INSERT INTO banktransfer_blz VALUES(75300000, 'Bundesbank eh Weiden Oberpf', '09');
INSERT INTO banktransfer_blz VALUES(75320075, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(75340090, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(75350000, 'Sparkasse Oberpfalz Nord', '00');
INSERT INTO banktransfer_blz VALUES(75351960, 'Vereinigte Sparkassen Eschenbach i d Opf', '00');
INSERT INTO banktransfer_blz VALUES(75360011, 'Raiffeisenbank Weiden', '88');
INSERT INTO banktransfer_blz VALUES(75362039, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(75363189, 'Raiffeisenbank Neustadt-Vohenstrauß', '88');
INSERT INTO banktransfer_blz VALUES(75390000, 'Volksbank Nordoberpfalz', '88');
INSERT INTO banktransfer_blz VALUES(76000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(76010085, 'Postbank', '24');
INSERT INTO banktransfer_blz VALUES(76010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(76020070, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(76020099, 'UniCredit Bank - HypoVereinsbank Prepaid Card', '09');
INSERT INTO banktransfer_blz VALUES(76020214, 'UniCredit Bank - HypoVereinsbank Ndl 156 Nbg', '99');
INSERT INTO banktransfer_blz VALUES(76020600, 'Hanseatic Bank', '16');
INSERT INTO banktransfer_blz VALUES(76020900, 'Entrium Direct Bankers -alt-', '09');
INSERT INTO banktransfer_blz VALUES(76026000, 'norisbank', 'C7');
INSERT INTO banktransfer_blz VALUES(76030080, 'Cortal Consors S.A. Zndl Deutschland', '01');
INSERT INTO banktransfer_blz VALUES(76030600, 'Isbank Fil Nürnberg', '06');
INSERT INTO banktransfer_blz VALUES(76032000, 'TeamBank Nürnberg', '06');
INSERT INTO banktransfer_blz VALUES(76032001, 'TeamBank Nürnberg GF Austria', '06');
INSERT INTO banktransfer_blz VALUES(76035000, 'UmweltBank', '55');
INSERT INTO banktransfer_blz VALUES(76040060, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(76040061, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(76040062, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(76050000, 'Bayerische Landesbank', '09');
INSERT INTO banktransfer_blz VALUES(76050101, 'Sparkasse Nürnberg', '49');
INSERT INTO banktransfer_blz VALUES(76052080, 'Sparkasse Neumarkt i d OPf-Parsberg', '00');
INSERT INTO banktransfer_blz VALUES(76060000, 'DZ BANK', '09');
INSERT INTO banktransfer_blz VALUES(76060561, 'ACREDOBANK', '88');
INSERT INTO banktransfer_blz VALUES(76060618, 'Volksbank Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(76061025, 'Raiffeisen Spar+Kreditbank Lauf a d Pegnitz', '88');
INSERT INTO banktransfer_blz VALUES(76061482, 'Raiffeisenbank Hersbruck', '88');
INSERT INTO banktransfer_blz VALUES(76069359, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(76069369, 'Raiffeisenbank Auerbach-Freihung', '88');
INSERT INTO banktransfer_blz VALUES(76069372, 'Raiffeisenbank Bad Windsheim', '88');
INSERT INTO banktransfer_blz VALUES(76069378, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(76069404, 'Raiffeisenbank Uehlfeld-Dachsbach', '88');
INSERT INTO banktransfer_blz VALUES(76069409, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(76069410, 'Raiffeisenbank Dietersheim und Umgebung', '88');
INSERT INTO banktransfer_blz VALUES(76069411, 'Raiffeisenbank Dietfurt', '88');
INSERT INTO banktransfer_blz VALUES(76069412, 'Raiffeisenbank Dinkelsbühl-Hesselberg -alt-', '88');
INSERT INTO banktransfer_blz VALUES(76069440, 'Raiffeisenbank Altdorf-Feucht', '88');
INSERT INTO banktransfer_blz VALUES(76069441, 'VR-Bank Feuchtwangen-Limes', '88');
INSERT INTO banktransfer_blz VALUES(76069448, 'Raiffeisenbank -alt-', '88');
INSERT INTO banktransfer_blz VALUES(76069449, 'Raiffeisenbank Berching-Freystadt-Mühlhausen', '88');
INSERT INTO banktransfer_blz VALUES(76069462, 'Raiffeisenbank Greding - Thalmässing', '88');
INSERT INTO banktransfer_blz VALUES(76069468, 'Raiffeisenbank Weißenburg-Gunzenhausen', '88');
INSERT INTO banktransfer_blz VALUES(76069483, 'Raiffeisenbank Herzogenaurach -alt-', '88');
INSERT INTO banktransfer_blz VALUES(76069486, 'Raiffeisenbank Hirschau', '88');
INSERT INTO banktransfer_blz VALUES(76069512, 'Raiffeisenbank Knoblauchsland Nürnberg-Buch', '88');
INSERT INTO banktransfer_blz VALUES(76069539, 'Raiffeisenbank Markt Erlbach-Linden -alt-', '88');
INSERT INTO banktransfer_blz VALUES(76069549, 'Raiffeisenbank Münchaurach -alt-', '88');
INSERT INTO banktransfer_blz VALUES(76069552, 'Raiffeisenbank -alt-', '88');
INSERT INTO banktransfer_blz VALUES(76069553, 'Raiffeisenbank Neumarkt', '88');
INSERT INTO banktransfer_blz VALUES(76069559, 'VR-Bank Uffenheim-Neustadt', '88');
INSERT INTO banktransfer_blz VALUES(76069564, 'Raiffeisenbank Oberferrieden-Burgthann', '88');
INSERT INTO banktransfer_blz VALUES(76069576, 'Raiffeisenbank Plankstetten', '88');
INSERT INTO banktransfer_blz VALUES(76069598, 'Raiffeisenbank Großhabersdorf-Roßtal', '88');
INSERT INTO banktransfer_blz VALUES(76069601, 'VR-Bank Rothenburg', '88');
INSERT INTO banktransfer_blz VALUES(76069602, 'Raiffeisenbank Seebachgrund', '88');
INSERT INTO banktransfer_blz VALUES(76069611, 'Raiffeisenbank Unteres Vilstal', '88');
INSERT INTO banktransfer_blz VALUES(76069635, 'Raiffeisenbank Ursensollen-Ammerthal-Hohenburg', '88');
INSERT INTO banktransfer_blz VALUES(76069663, 'Raiffeisenbank Heilsbronn-Windsbach', '88');
INSERT INTO banktransfer_blz VALUES(76069669, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(76070012, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(76070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(76080040, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(76080053, 'Commerzbank vormals Dresdner Bank Zw 53', '76');
INSERT INTO banktransfer_blz VALUES(76080055, 'Commerzbank vormals Dresdner Bank Zw 55', '09');
INSERT INTO banktransfer_blz VALUES(76080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(76080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(76089480, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(76089482, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(76090300, 'Bäcker-Bank Nürnberg', '88');
INSERT INTO banktransfer_blz VALUES(76090400, 'Evenord-Bank', '88');
INSERT INTO banktransfer_blz VALUES(76090500, 'Sparda-Bank Nürnberg', '81');
INSERT INTO banktransfer_blz VALUES(76090613, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(76090900, 'PSD Bank', '91');
INSERT INTO banktransfer_blz VALUES(76091000, 'Sparda-Bank Nürnberg Zw Sonnenstraße', '81');
INSERT INTO banktransfer_blz VALUES(76211900, 'CVW - Privatbank', '88');
INSERT INTO banktransfer_blz VALUES(76220073, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(76230000, 'BSQ Bauspar', '11');
INSERT INTO banktransfer_blz VALUES(76240011, 'Commerzbank Fürth Bayern', '13');
INSERT INTO banktransfer_blz VALUES(76250000, 'Sparkasse Fürth', '00');
INSERT INTO banktransfer_blz VALUES(76251020, 'Sparkasse i Landkreis Neustadt a d Aisch', '00');
INSERT INTO banktransfer_blz VALUES(76260451, 'Raiffeisen-Volksbank Fürth', '88');
INSERT INTO banktransfer_blz VALUES(76300000, 'Bundesbank eh Erlangen', '09');
INSERT INTO banktransfer_blz VALUES(76320072, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(76330111, 'Bankhaus Max Flessa', '09');
INSERT INTO banktransfer_blz VALUES(76340061, 'Commerzbank Erlangen', '13');
INSERT INTO banktransfer_blz VALUES(76350000, 'Stadt- und Kreissparkasse Erlangen', '01');
INSERT INTO banktransfer_blz VALUES(76351040, 'Sparkasse Forchheim', '00');
INSERT INTO banktransfer_blz VALUES(76351560, 'Kreissparkasse Höchstadt', '00');
INSERT INTO banktransfer_blz VALUES(76360033, 'VR-Bank Erlangen-Höchstadt-Herzogenaurach', '88');
INSERT INTO banktransfer_blz VALUES(76391000, 'Volksbank Forchheim', '88');
INSERT INTO banktransfer_blz VALUES(76420080, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(76450000, 'Sparkasse Mittelfranken-Süd', 'A5');
INSERT INTO banktransfer_blz VALUES(76460015, 'Raiffeisenbank Roth-Schwabach', '88');
INSERT INTO banktransfer_blz VALUES(76461485, 'Raiffeisenbank am Rothsee', '88');
INSERT INTO banktransfer_blz VALUES(76500000, 'Bundesbank eh Ansbach', '09');
INSERT INTO banktransfer_blz VALUES(76520071, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(76550000, 'Vereinigte Sparkassen Ansbach', '00');
INSERT INTO banktransfer_blz VALUES(76551020, 'Kreis- und Stadtsparkasse Dinkelsbühl', '00');
INSERT INTO banktransfer_blz VALUES(76551540, 'Vereinigte Sparkassen Gunzenhausen', '00');
INSERT INTO banktransfer_blz VALUES(76551860, 'Stadt- und Kreissparkasse Rothenburg', '00');
INSERT INTO banktransfer_blz VALUES(76560060, 'RaiffeisenVolksbank Gewerbebank', '88');
INSERT INTO banktransfer_blz VALUES(76561979, 'Raiffeisenbank -alt-', '88');
INSERT INTO banktransfer_blz VALUES(76591000, 'VR Bank Dinkelsbühl', '88');
INSERT INTO banktransfer_blz VALUES(77000000, 'Bundesbank eh Bamberg', '09');
INSERT INTO banktransfer_blz VALUES(77020070, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(77030111, 'Bankhaus Max Flessa', '09');
INSERT INTO banktransfer_blz VALUES(77040080, 'Commerzbank Bamberg', '13');
INSERT INTO banktransfer_blz VALUES(77050000, 'Sparkasse Bamberg', '00');
INSERT INTO banktransfer_blz VALUES(77060100, 'VR Bank Bamberg Raiffeisen-Volksbank', '88');
INSERT INTO banktransfer_blz VALUES(77061004, 'Raiffeisenbank Obermain Nord', '88');
INSERT INTO banktransfer_blz VALUES(77061425, 'Raiffeisen-Volksbank', '88');
INSERT INTO banktransfer_blz VALUES(77062014, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(77062139, 'Raiffeisen-Volksbank Bad Staffelstein', '88');
INSERT INTO banktransfer_blz VALUES(77063048, 'Raiffeisenbank Hallstadt -alt-', '88');
INSERT INTO banktransfer_blz VALUES(77065141, 'Raiffeisenbank Stegaurach', '88');
INSERT INTO banktransfer_blz VALUES(77069042, 'Raiffeisenbank Gößweinstein -alt-', '88');
INSERT INTO banktransfer_blz VALUES(77069044, 'Raiffeisenbank Küps-Mitwitz-Stockheim', '88');
INSERT INTO banktransfer_blz VALUES(77069051, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(77069052, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(77069084, 'Raiffeisenbank -alt-', '88');
INSERT INTO banktransfer_blz VALUES(77069091, 'Raiffeisenbank Ebrachgrund', '88');
INSERT INTO banktransfer_blz VALUES(77069110, 'Raiffeisenbank Pretzfeld -alt-', '88');
INSERT INTO banktransfer_blz VALUES(77069128, 'Raiffeisenbank Scheßlitz-Zapfendorf -alt-', '88');
INSERT INTO banktransfer_blz VALUES(77069461, 'Vereinigte Raiffeisenbanken', '88');
INSERT INTO banktransfer_blz VALUES(77069556, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(77069739, 'Raiffeisenbank Thurnauer Land', '88');
INSERT INTO banktransfer_blz VALUES(77069746, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(77069764, 'Raiffeisenbank Kemnather Land - Steinwald', '88');
INSERT INTO banktransfer_blz VALUES(77069782, 'Raiffeisenbank am Kulm', '88');
INSERT INTO banktransfer_blz VALUES(77069836, 'Raiffeisenbank Berg-Bad Steben', '88');
INSERT INTO banktransfer_blz VALUES(77069868, 'Raiffeisenbank Oberland', '88');
INSERT INTO banktransfer_blz VALUES(77069870, 'Raiffeisenbank Frankenwald Ost-Oberkotzau', '88');
INSERT INTO banktransfer_blz VALUES(77069879, 'Raiffeisenbank -alt-', '88');
INSERT INTO banktransfer_blz VALUES(77069893, 'Raiffeisenbank -alt-', '88');
INSERT INTO banktransfer_blz VALUES(77069906, 'Raiffeisenbank Wüstenselbitz', '88');
INSERT INTO banktransfer_blz VALUES(77069908, 'Raiffeisenbank Sparneck-Stammbach-Zell', '88');
INSERT INTO banktransfer_blz VALUES(77091800, 'Raiffeisen-Volksbank Lichtenfels-Itzgrund', '88');
INSERT INTO banktransfer_blz VALUES(77120073, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(77140061, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(77150000, 'Sparkasse Kulmbach-Kronach', '00');
INSERT INTO banktransfer_blz VALUES(77151640, 'Sparkasse Kronach-Ludwigsstadt -alt-', '00');
INSERT INTO banktransfer_blz VALUES(77190000, 'Kulmbacher Bank', '88');
INSERT INTO banktransfer_blz VALUES(77300000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(77320072, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(77322200, 'Fondsdepot Bank', '00');
INSERT INTO banktransfer_blz VALUES(77340076, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(77350110, 'Sparkasse Bayreuth', '00');
INSERT INTO banktransfer_blz VALUES(77361600, 'Raiffeisen-Volksbank Kronach-Ludwigsstadt', '88');
INSERT INTO banktransfer_blz VALUES(77363749, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(77365792, 'Raiffeisenbank Hollfeld-Waischenfeld-Aufseß', '88');
INSERT INTO banktransfer_blz VALUES(77390000, 'Volksbank-Raiffeisenbank Bayreuth', '88');
INSERT INTO banktransfer_blz VALUES(77390500, 'Sparda-Bank Nürnberg', '81');
INSERT INTO banktransfer_blz VALUES(77390628, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(78000000, 'Bundesbank eh Hof', '09');
INSERT INTO banktransfer_blz VALUES(78020070, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(78020429, 'UniCredit Bank - HypoVereinsbank Ndl 128 Hof', '99');
INSERT INTO banktransfer_blz VALUES(78030080, 'Archon Capital Bank Deutschland', '01');
INSERT INTO banktransfer_blz VALUES(78030081, 'Archon Capital Bank Deutschland Servicing', '01');
INSERT INTO banktransfer_blz VALUES(78040081, 'Commerzbank Hof Saale', '13');
INSERT INTO banktransfer_blz VALUES(78050000, 'Sparkasse Hochfranken', '00');
INSERT INTO banktransfer_blz VALUES(78055050, 'Sparkasse Hochfranken -alt-', '00');
INSERT INTO banktransfer_blz VALUES(78060896, 'VR Bank Hof', '88');
INSERT INTO banktransfer_blz VALUES(78062488, 'Raiffeisenbank -alt-', '88');
INSERT INTO banktransfer_blz VALUES(78140000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(78151080, 'Sparkasse Tirschenreuth -alt-', '00');
INSERT INTO banktransfer_blz VALUES(78160069, 'VR-Bank Fichtelgebirge', '88');
INSERT INTO banktransfer_blz VALUES(78161575, 'Raiffeisenbank im Stiftland', '88');
INSERT INTO banktransfer_blz VALUES(78320076, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(78330111, 'Bankhaus Max Flessa', '09');
INSERT INTO banktransfer_blz VALUES(78340091, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(78350000, 'Sparkasse Coburg-Lichtenfels', '00');
INSERT INTO banktransfer_blz VALUES(78360000, 'VR-Bank Coburg', '88');
INSERT INTO banktransfer_blz VALUES(78390000, 'VR-Bank Coburg', '88');
INSERT INTO banktransfer_blz VALUES(79000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(79010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(79020076, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(79020325, 'UniCredit Bank - HypoVereinsbank Ndl 149 Wzb', '99');
INSERT INTO banktransfer_blz VALUES(79020700, 'Hanseatic Bank', '16');
INSERT INTO banktransfer_blz VALUES(79030001, 'Fürstlich Castellsche Bank Credit-Casse', '09');
INSERT INTO banktransfer_blz VALUES(79032038, 'Bank Schilling & Co', '00');
INSERT INTO banktransfer_blz VALUES(79040047, 'Commerzbank Würzburg', '13');
INSERT INTO banktransfer_blz VALUES(79050000, 'Sparkasse Mainfranken Würzburg', '00');
INSERT INTO banktransfer_blz VALUES(79061000, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(79061153, 'Raiffeisenbank Lohr, Main -alt-', '88');
INSERT INTO banktransfer_blz VALUES(79062106, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(79063060, 'Raiffeisenbank Estenfeld-Bergtheim', '88');
INSERT INTO banktransfer_blz VALUES(79063122, 'Raiffeisenbank Höchberg', '88');
INSERT INTO banktransfer_blz VALUES(79065028, 'VR-Bank Bad Kissingen-Bad Brückenau', '88');
INSERT INTO banktransfer_blz VALUES(79065160, 'Raiffeisenbank Marktheidenfeld -alt-', '88');
INSERT INTO banktransfer_blz VALUES(79066082, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(79069001, 'Raiffeisenbank Volkach-Wiesentheid', '88');
INSERT INTO banktransfer_blz VALUES(79069010, 'VR-Bank Schweinfurt', '88');
INSERT INTO banktransfer_blz VALUES(79069031, 'Raiffeisenbank Bütthard-Gaukönigshofen', '88');
INSERT INTO banktransfer_blz VALUES(79069090, 'Raiffeisenbank Ulsenheim-Gollhofen -alt-', '88');
INSERT INTO banktransfer_blz VALUES(79069145, 'Raiffeisenbank Kreuzwertheim-Hasloch -alt-', '88');
INSERT INTO banktransfer_blz VALUES(79069150, 'Raiffeisenbank Main-Spessart', '88');
INSERT INTO banktransfer_blz VALUES(79069165, 'Genobank Rhön-Grabfeld', '88');
INSERT INTO banktransfer_blz VALUES(79069181, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(79069188, 'Raiffeisenbank Obereßfeld-Römhild', '88');
INSERT INTO banktransfer_blz VALUES(79069192, 'Raiffeisenbank Obernbreit und Umgebung', '88');
INSERT INTO banktransfer_blz VALUES(79069213, 'Raiffeisenbank Maßbach', '88');
INSERT INTO banktransfer_blz VALUES(79069271, 'Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(79070016, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(79070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(79080052, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(79080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(79090000, 'Volksbank Raiffeisenbank', '88');
INSERT INTO banktransfer_blz VALUES(79090624, 'apoBank', '14');
INSERT INTO banktransfer_blz VALUES(79161058, 'Raiffeisenbank Fränkisches Weinland', '88');
INSERT INTO banktransfer_blz VALUES(79161499, 'Raiffeisenbank Kitzinger Land', '88');
INSERT INTO banktransfer_blz VALUES(79190000, 'VR Bank Kitzingen', '88');
INSERT INTO banktransfer_blz VALUES(79300000, 'Bundesbank eh Schweinfurt', '09');
INSERT INTO banktransfer_blz VALUES(79320075, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(79320432, 'UniCredit Bank - HypoVereinsbank Ndl 137 Schft', '99');
INSERT INTO banktransfer_blz VALUES(79330111, 'Bankhaus Max Flessa', '09');
INSERT INTO banktransfer_blz VALUES(79340054, 'Commerzbank Schweinfurt', '13');
INSERT INTO banktransfer_blz VALUES(79350000, 'Städtische Sparkasse Schweinfurt -alt-', '00');
INSERT INTO banktransfer_blz VALUES(79350101, 'Sparkasse Schweinfurt', '00');
INSERT INTO banktransfer_blz VALUES(79351010, 'Sparkasse Bad Kissingen', '00');
INSERT INTO banktransfer_blz VALUES(79351730, 'Sparkasse Ostunterfranken', '00');
INSERT INTO banktransfer_blz VALUES(79353090, 'Sparkasse Bad Neustadt a d Saale', '00');
INSERT INTO banktransfer_blz VALUES(79362081, 'VR-Bank Gerolzhofen', '88');
INSERT INTO banktransfer_blz VALUES(79363016, 'VR-Bank Rhön-Grabfeld', '88');
INSERT INTO banktransfer_blz VALUES(79363151, 'Raiffeisen-Volksbank Haßberge', '88');
INSERT INTO banktransfer_blz VALUES(79364069, 'Raiffeisenbank Frankenwinheim und Umgebung', '88');
INSERT INTO banktransfer_blz VALUES(79364406, 'VR-Bank Schweinfurt Land -alt-', '88');
INSERT INTO banktransfer_blz VALUES(79380051, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(79500000, 'Bundesbank eh Aschaffenburg', '09');
INSERT INTO banktransfer_blz VALUES(79510111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(79520070, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(79520533, 'UniCredit Bank - HypoVereinsbank Ndl 125 Aschb', '99');
INSERT INTO banktransfer_blz VALUES(79540049, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(79550000, 'Sparkasse Aschaffenburg Alzenau', '00');
INSERT INTO banktransfer_blz VALUES(79561348, 'Raiffeisenbank Bachgau -alt-', '88');
INSERT INTO banktransfer_blz VALUES(79562225, 'Raiffeisenbank Kahl am Main -alt-', '88');
INSERT INTO banktransfer_blz VALUES(79562514, 'Raiffeisenbank Aschaffenburg', '88');
INSERT INTO banktransfer_blz VALUES(79565568, 'Raiffeisenbank Waldaschaff-Heigenbrücken', '88');
INSERT INTO banktransfer_blz VALUES(79566545, 'Raiffeisenbank Heimbuchenthal -alt-', '88');
INSERT INTO banktransfer_blz VALUES(79567531, 'VR-Bank', '88');
INSERT INTO banktransfer_blz VALUES(79568518, 'Raiffeisenbank Haibach-Obernau', '88');
INSERT INTO banktransfer_blz VALUES(79570024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(79570051, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(79580099, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(79589402, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(79590000, 'Volksbank Aschaffenburg', '88');
INSERT INTO banktransfer_blz VALUES(79650000, 'Sparkasse Miltenberg-Obernburg', '00');
INSERT INTO banktransfer_blz VALUES(79662558, 'Raiffeisenbank -alt-', '88');
INSERT INTO banktransfer_blz VALUES(79665540, 'Raiffeisenbank Elsavatal', '88');
INSERT INTO banktransfer_blz VALUES(79666548, 'Raiffeisenbank Großostheim-Obernburg', '88');
INSERT INTO banktransfer_blz VALUES(79668509, 'Raiffeisenbank Eichenbühl und Umgebung', '88');
INSERT INTO banktransfer_blz VALUES(79690000, 'Raiffeisen-Volksbank Miltenberg', '88');
INSERT INTO banktransfer_blz VALUES(80000000, 'Bundesbank eh Halle', '09');
INSERT INTO banktransfer_blz VALUES(80020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(80020087, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(80020130, 'ZV Landesbank Baden-Württemberg', '65');
INSERT INTO banktransfer_blz VALUES(80040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(80050500, 'Kreissparkasse Merseburg-Querfurt -alt-', '20');
INSERT INTO banktransfer_blz VALUES(80053000, 'Sparkasse Burgenlandkreis', '20');
INSERT INTO banktransfer_blz VALUES(80053502, 'Kreissparkasse Quedlinburg -alt-', 'C0');
INSERT INTO banktransfer_blz VALUES(80053552, 'Kreissparkasse Sangerhausen -alt-', 'C0');
INSERT INTO banktransfer_blz VALUES(80053572, 'Stadtsparkasse Dessau', 'C0');
INSERT INTO banktransfer_blz VALUES(80053612, 'Kreissparkasse Bernburg -alt-', '52');
INSERT INTO banktransfer_blz VALUES(80053622, 'Kreissparkasse Köthen -alt-', 'C0');
INSERT INTO banktransfer_blz VALUES(80053722, 'Kreissparkasse Anhalt-Bitterfeld', 'C0');
INSERT INTO banktransfer_blz VALUES(80053762, 'Saalesparkasse', 'B6');
INSERT INTO banktransfer_blz VALUES(80054000, 'Kreissparkasse Weißenfels -alt-', '20');
INSERT INTO banktransfer_blz VALUES(80055008, 'Sparkasse Mansfeld-Südharz', '20');
INSERT INTO banktransfer_blz VALUES(80055500, 'Salzlandsparkasse', '20');
INSERT INTO banktransfer_blz VALUES(80062608, 'Volksbank Elsterland', '32');
INSERT INTO banktransfer_blz VALUES(80063508, 'Ostharzer Volksbank', '32');
INSERT INTO banktransfer_blz VALUES(80063558, 'Volksbank', '32');
INSERT INTO banktransfer_blz VALUES(80063598, 'Volksbank Wittenberg', '32');
INSERT INTO banktransfer_blz VALUES(80063628, 'Volksbank', '32');
INSERT INTO banktransfer_blz VALUES(80063648, 'Volks- und Raiffeisenbank Saale-Unstrut', '28');
INSERT INTO banktransfer_blz VALUES(80063678, 'VR-Bank Zeitz', '32');
INSERT INTO banktransfer_blz VALUES(80063718, 'Volks- und Raiffeisenbank Eisleben', '32');
INSERT INTO banktransfer_blz VALUES(80080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(80093574, 'Volksbank Dessau-Anhalt', '32');
INSERT INTO banktransfer_blz VALUES(80093784, 'Volksbank Halle, Saale', '32');
INSERT INTO banktransfer_blz VALUES(80500000, 'Bundesbank eh Dessau', '09');
INSERT INTO banktransfer_blz VALUES(80550101, 'Sparkasse Wittenberg', '20');
INSERT INTO banktransfer_blz VALUES(80550200, 'Kreissparkasse Anhalt-Zerbst -alt-', '20');
INSERT INTO banktransfer_blz VALUES(81000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(81010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(81020500, 'Bank für Sozialwirtschaft', '09');
INSERT INTO banktransfer_blz VALUES(81020886, 'UniCredit Bank - HypoVereinsbank (ehem. Hypo)', '99');
INSERT INTO banktransfer_blz VALUES(81040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(81050000, 'Kreissparkasse Aschersleben-Staßfurt -alt-', '20');
INSERT INTO banktransfer_blz VALUES(81050555, 'Kreissparkasse Stendal', '20');
INSERT INTO banktransfer_blz VALUES(81051000, 'Bördesparkasse Oschersleben -alt-', '20');
INSERT INTO banktransfer_blz VALUES(81052000, 'Harzsparkasse', '20');
INSERT INTO banktransfer_blz VALUES(81053112, 'Kreissparkasse Wernigerode -alt-', 'C0');
INSERT INTO banktransfer_blz VALUES(81053132, 'Kreissparkasse Halberstadt -alt-', 'C0');
INSERT INTO banktransfer_blz VALUES(81053242, 'Kreissparkasse Schönebeck -alt-', '52');
INSERT INTO banktransfer_blz VALUES(81053272, 'Stadtsparkasse Magdeburg', 'C0');
INSERT INTO banktransfer_blz VALUES(81054000, 'Sparkasse Jerichower Land', '20');
INSERT INTO banktransfer_blz VALUES(81055000, 'Kreissparkasse Börde', '20');
INSERT INTO banktransfer_blz VALUES(81055555, 'Sparkasse Altmark West', '20');
INSERT INTO banktransfer_blz VALUES(81063028, 'Raiffeisenbank Kalbe-Bismark', '32');
INSERT INTO banktransfer_blz VALUES(81063238, 'Volksbank Jerichower Land', '32');
INSERT INTO banktransfer_blz VALUES(81068106, 'Bank für Kirche und Diakonie - KD-Bank Gf Sonder-BLZ', '09');
INSERT INTO banktransfer_blz VALUES(81069048, 'Volksbank Jerichower Land', '32');
INSERT INTO banktransfer_blz VALUES(81069052, 'Volksbank Börde-Bernburg', '32');
INSERT INTO banktransfer_blz VALUES(81070000, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(81070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(81080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(81093034, 'Volksbank', '32');
INSERT INTO banktransfer_blz VALUES(81093044, 'Volksbank Osterburg-Lüchow-Dannenberg -alt-', '32');
INSERT INTO banktransfer_blz VALUES(81093054, 'Volksbank Stendal', '32');
INSERT INTO banktransfer_blz VALUES(81093274, 'Volksbank Magdeburg', '32');
INSERT INTO banktransfer_blz VALUES(82000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(82010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(82020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(82020087, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(82020088, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(82040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(82050000, 'Landesbank Hessen-Thür Girozentrale Erfurt', '00');
INSERT INTO banktransfer_blz VALUES(82051000, 'Sparkasse Mittelthüringen', '20');
INSERT INTO banktransfer_blz VALUES(82052020, 'Kreissparkasse Gotha', '20');
INSERT INTO banktransfer_blz VALUES(82054052, 'Kreissparkasse Nordhausen', 'C0');
INSERT INTO banktransfer_blz VALUES(82055000, 'Kyffhäusersparkasse', '20');
INSERT INTO banktransfer_blz VALUES(82056060, 'Sparkasse Unstrut-Hainich', '20');
INSERT INTO banktransfer_blz VALUES(82057070, 'Kreissparkasse Eichsfeld', '20');
INSERT INTO banktransfer_blz VALUES(82060197, 'Pax-Bank', '06');
INSERT INTO banktransfer_blz VALUES(82060800, 'Evangelische Kreditgenossenschaft -Filiale Eisenach-', '32');
INSERT INTO banktransfer_blz VALUES(82064038, 'VR Bank Westthüringen', '32');
INSERT INTO banktransfer_blz VALUES(82064088, 'Volksbank und Raiffeisenbank', '32');
INSERT INTO banktransfer_blz VALUES(82064168, 'Raiffeisenbank Gotha', '32');
INSERT INTO banktransfer_blz VALUES(82064188, 'VR Bank Weimar', '32');
INSERT INTO banktransfer_blz VALUES(82064228, 'Erfurter Bank', '32');
INSERT INTO banktransfer_blz VALUES(82070000, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(82070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(82080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(82094004, 'Volksbank Heiligenstadt', '06');
INSERT INTO banktransfer_blz VALUES(82094054, 'Nordthüringer Volksbank', '32');
INSERT INTO banktransfer_blz VALUES(82094224, 'Volksbank Erfurt -alt-', '32');
INSERT INTO banktransfer_blz VALUES(83000000, 'Bundesbank eh Gera', '09');
INSERT INTO banktransfer_blz VALUES(83020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(83020087, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(83020088, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(83040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(83050000, 'Sparkasse Gera-Greiz', '20');
INSERT INTO banktransfer_blz VALUES(83050200, 'Sparkasse Altenburger Land', '20');
INSERT INTO banktransfer_blz VALUES(83050303, 'Kreissparkasse Saalfeld-Rudolstadt', '20');
INSERT INTO banktransfer_blz VALUES(83050505, 'Kreissparkasse Saale-Orla', '20');
INSERT INTO banktransfer_blz VALUES(83053030, 'Sparkasse Jena-Saale-Holzland', '20');
INSERT INTO banktransfer_blz VALUES(83064488, 'Raiffeisen-Volksbank Hermsdorfer Kreuz', '32');
INSERT INTO banktransfer_blz VALUES(83064568, 'Geraer Bank', '32');
INSERT INTO banktransfer_blz VALUES(83065408, 'VR-Bank Altenburger Land / Deutsche Skatbank', '32');
INSERT INTO banktransfer_blz VALUES(83065410, 'Deutsche Skatbank Zndl VR Bank Altenburger Land', '32');
INSERT INTO banktransfer_blz VALUES(83080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(83094444, 'Raiffeisen-Volksbank Saale-Orla', '32');
INSERT INTO banktransfer_blz VALUES(83094454, 'Volksbank Saaletal', '06');
INSERT INTO banktransfer_blz VALUES(83094494, 'Volksbank Eisenberg', '32');
INSERT INTO banktransfer_blz VALUES(83094495, 'EthikBank, Zndl der Volksbank Eisenberg', '32');
INSERT INTO banktransfer_blz VALUES(83095424, 'Volksbank Altenburg -alt-', '06');
INSERT INTO banktransfer_blz VALUES(84000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(84020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(84020087, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(84030111, 'Bankhaus Max Flessa', '09');
INSERT INTO banktransfer_blz VALUES(84040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(84050000, 'Rhön-Rennsteig-Sparkasse', '20');
INSERT INTO banktransfer_blz VALUES(84051010, 'Sparkasse Arnstadt-Ilmenau', '20');
INSERT INTO banktransfer_blz VALUES(84054040, 'Kreissparkasse Hildburghausen', '20');
INSERT INTO banktransfer_blz VALUES(84054722, 'Sparkasse Sonneberg', '20');
INSERT INTO banktransfer_blz VALUES(84055050, 'Wartburg-Sparkasse', '20');
INSERT INTO banktransfer_blz VALUES(84064798, 'Genobank Rhön-Grabfeld', '88');
INSERT INTO banktransfer_blz VALUES(84069065, 'Raiffeisenbank Schleusingen', '32');
INSERT INTO banktransfer_blz VALUES(84080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(84094754, 'VR-Bank Bad Salzungen Schmalkalden', '32');
INSERT INTO banktransfer_blz VALUES(84094814, 'VR Bank Südthüringen', '32');
INSERT INTO banktransfer_blz VALUES(85000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(85010500, 'Sächsische Aufbaubank -Förderbank-', '09');
INSERT INTO banktransfer_blz VALUES(85020030, 'ZV Landesbank Baden-Württemberg', '65');
INSERT INTO banktransfer_blz VALUES(85020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(85020500, 'Bank für Sozialwirtschaft', '09');
INSERT INTO banktransfer_blz VALUES(85020890, 'UniCredit Bank - HypoVereinsbank Ndl 536 Dre', '99');
INSERT INTO banktransfer_blz VALUES(85040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(85040060, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(85040061, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(85050100, 'Sparkasse Oberlausitz-Niederschlesien', '20');
INSERT INTO banktransfer_blz VALUES(85050200, 'Kreissparkasse Riesa-Großenhain -alt-', '20');
INSERT INTO banktransfer_blz VALUES(85050300, 'Ostsächsische Sparkasse Dresden', '20');
INSERT INTO banktransfer_blz VALUES(85055000, 'Sparkasse Meißen', '20');
INSERT INTO banktransfer_blz VALUES(85060000, 'Volksbank Pirna', '32');
INSERT INTO banktransfer_blz VALUES(85065028, 'Raiffeisenbank Neustadt, Sachs -alt-', '32');
INSERT INTO banktransfer_blz VALUES(85080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(85080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(85080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(85080200, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(85089270, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(85090000, 'Dresdner Volksbank Raiffeisenbank', '06');
INSERT INTO banktransfer_blz VALUES(85094984, 'Volksbank Riesa', '06');
INSERT INTO banktransfer_blz VALUES(85095004, 'Volksbank Raiffeisenbank Meißen Großenhain', '06');
INSERT INTO banktransfer_blz VALUES(85095164, 'Landeskirchliche Kredit-Genossenschaft Sachsen -alt-', '06');
INSERT INTO banktransfer_blz VALUES(85550000, 'Kreissparkasse Bautzen', '20');
INSERT INTO banktransfer_blz VALUES(85550200, 'Kreissparkasse Löbau-Zittau -alt-', '20');
INSERT INTO banktransfer_blz VALUES(85590000, 'Volksbank Bautzen', '06');
INSERT INTO banktransfer_blz VALUES(85590100, 'Volksbank Löbau-Zittau', '06');
INSERT INTO banktransfer_blz VALUES(85591000, 'Volksbank Raiffeisenbank Niederschlesien', '06');
INSERT INTO banktransfer_blz VALUES(85595500, 'Volksbank Westlausitz -alt-', '06');
INSERT INTO banktransfer_blz VALUES(86000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(86010090, 'Postbank', '24');
INSERT INTO banktransfer_blz VALUES(86010111, 'SEB', '13');
INSERT INTO banktransfer_blz VALUES(86010424, 'Aareal Bank', '09');
INSERT INTO banktransfer_blz VALUES(86020030, 'ZV Landesbank Baden-Württemberg', '65');
INSERT INTO banktransfer_blz VALUES(86020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(86020200, 'BHF-BANK', '60');
INSERT INTO banktransfer_blz VALUES(86020500, 'Bank für Sozialwirtschaft', '09');
INSERT INTO banktransfer_blz VALUES(86020600, 'Hanseatic Bank', '16');
INSERT INTO banktransfer_blz VALUES(86020880, 'UniCredit Bank - HypoVereinsbank Ndl 508 Lei', '99');
INSERT INTO banktransfer_blz VALUES(86033300, 'Santander Consumer Bank', '09');
INSERT INTO banktransfer_blz VALUES(86040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(86040060, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(86040061, 'Commerzbank CC', '09');
INSERT INTO banktransfer_blz VALUES(86050000, 'ZV Landesbank Baden-Württemberg', '09');
INSERT INTO banktransfer_blz VALUES(86050200, 'Sparkasse Muldental', '20');
INSERT INTO banktransfer_blz VALUES(86050600, 'Kreissparkasse Torgau-Oschatz -alt-', '20');
INSERT INTO banktransfer_blz VALUES(86055002, 'Sparkasse Delitzsch-Eilenburg -alt-', '20');
INSERT INTO banktransfer_blz VALUES(86055462, 'Kreissparkasse Döbeln', 'C0');
INSERT INTO banktransfer_blz VALUES(86055592, 'Stadt- und Kreissparkasse Leipzig', 'D0');
INSERT INTO banktransfer_blz VALUES(86065448, 'VR Bank Leipziger Land', '32');
INSERT INTO banktransfer_blz VALUES(86065468, 'VR-Bank Mittelsachsen', '06');
INSERT INTO banktransfer_blz VALUES(86065483, 'Raiffeisenbank Grimma', '06');
INSERT INTO banktransfer_blz VALUES(86065548, 'Wurzener Bank (Raiffeisen-Volksbank) -alt-', '06');
INSERT INTO banktransfer_blz VALUES(86069070, 'Raiffeisenbank', '06');
INSERT INTO banktransfer_blz VALUES(86070000, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(86070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(86080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(86080055, 'Commerzbank vormals Dresdner Bank Zw 55', '76');
INSERT INTO banktransfer_blz VALUES(86080057, 'Commerzbank vormals Dresdner Bank Gf ZW 57', '76');
INSERT INTO banktransfer_blz VALUES(86080085, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 1', '09');
INSERT INTO banktransfer_blz VALUES(86080086, 'Commerzbank vormals Dresdner Bank, PCC DCC-ITGK 2', '09');
INSERT INTO banktransfer_blz VALUES(86089280, 'Commerzbank vormals Dresdner Bank ITGK', '09');
INSERT INTO banktransfer_blz VALUES(86095484, 'Volks- und Raiffeisenbank Muldental', '06');
INSERT INTO banktransfer_blz VALUES(86095554, 'Volksbank Delitzsch', '06');
INSERT INTO banktransfer_blz VALUES(86095604, 'Volksbank Leipzig', '06');
INSERT INTO banktransfer_blz VALUES(87000000, 'Bundesbank', '09');
INSERT INTO banktransfer_blz VALUES(87020086, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(87020087, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(87020088, 'UniCredit Bank - HypoVereinsbank', '99');
INSERT INTO banktransfer_blz VALUES(87040000, 'Commerzbank', '13');
INSERT INTO banktransfer_blz VALUES(87050000, 'Sparkasse Chemnitz', '20');
INSERT INTO banktransfer_blz VALUES(87051000, 'Sparkasse Mittelsachsen', '20');
INSERT INTO banktransfer_blz VALUES(87052000, 'Sparkasse Mittelsachsen', '20');
INSERT INTO banktransfer_blz VALUES(87053000, 'Sparkasse Mittleres Erzgebirge', '20');
INSERT INTO banktransfer_blz VALUES(87054000, 'Sparkasse Erzgebirge', '20');
INSERT INTO banktransfer_blz VALUES(87055000, 'Sparkasse Zwickau', '20');
INSERT INTO banktransfer_blz VALUES(87056000, 'Kreissparkasse Aue-Schwarzenberg', '20');
INSERT INTO banktransfer_blz VALUES(87058000, 'Sparkasse Vogtland', '20');
INSERT INTO banktransfer_blz VALUES(87065893, 'Volksbank Erzgebirge -alt-', '06');
INSERT INTO banktransfer_blz VALUES(87065918, 'Raiffeisenbank Werdau-Zwickau', '06');
INSERT INTO banktransfer_blz VALUES(87069075, 'Volksbank Mittleres Erzgebirge', '06');
INSERT INTO banktransfer_blz VALUES(87069077, 'Vereinigte Raiffeisenbank Burgstädt', '06');
INSERT INTO banktransfer_blz VALUES(87070000, 'Deutsche Bank', '63');
INSERT INTO banktransfer_blz VALUES(87070024, 'Deutsche Bank Privat und Geschäftskunden', '63');
INSERT INTO banktransfer_blz VALUES(87080000, 'Commerzbank vormals Dresdner Bank', '76');
INSERT INTO banktransfer_blz VALUES(87095824, 'Volksbank Vogtland', '06');
INSERT INTO banktransfer_blz VALUES(87095899, 'Volksbank Vogtland GAA', '09');
INSERT INTO banktransfer_blz VALUES(87095934, 'Volksbank Zwickau', '06');
INSERT INTO banktransfer_blz VALUES(87095974, 'Volksbank-Raiffeisenbank Glauchau', '06');
INSERT INTO banktransfer_blz VALUES(87096034, 'Volksbank Erzgebirge', '06');
INSERT INTO banktransfer_blz VALUES(87096074, 'Freiberger Bank -alt-', '06');
INSERT INTO banktransfer_blz VALUES(87096124, 'Volksbank', '06');
INSERT INTO banktransfer_blz VALUES(87096214, 'Volksbank Chemnitz', '06');

