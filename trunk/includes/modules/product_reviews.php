<?php
/*-----------------------------------------------------------------
* 	$Id: product_reviews.php 420 2013-06-19 18:04:39Z akausch $
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



$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

require_once (DIR_FS_INC.'xtc_row_number_format.inc.php');
require_once (DIR_FS_INC.'xtc_date_short.inc.php');

$info_smarty->assign('options', $products_options_data);

$name_query = xtc_db_fetch_array(xtDBquery("SELECT customers_firstname, customers_lastname FROM ".TABLE_CUSTOMERS." WHERE customers_id = '".(int) $_SESSION['customer_id']."'"));

if ($name_query['customers_firstname'] == '') {
	$name = TEXT_GUEST;
} else {
	$name = $name_query['customers_firstname'].' '.$name_query['customers_lastname'];
	$name = substr($name,0,strrpos($name, " ")+2).'.';
} 
	
$module_smarty->assign('AUTHOR', $name);

$reviews_query = xtDBquery("SELECT (avg(reviews_rating) / 5 * 100) as average_rating FROM " . TABLE_REVIEWS . " WHERE products_id = '" . $product->data['products_id'] . "'");
$reviews = xtc_db_fetch_array($reviews_query);

if ($product->getReviewsCount() > 0) {
	$module_smarty->assign('AVERAGE','&Oslash; '.number_format($reviews['average_rating'], 2).'%');
}
if($_SESSION['success_msg'] !='') {
	$module_smarty->assign('SUCCESS_MSG', $_SESSION['success_msg']);
	unset($_SESSION['success_msg']);
	
} elseif($_SESSION['error_msg'] !='') {
	$module_smarty->assign('ERROR_MSG', $_SESSION['error_msg']);
	unset($_SESSION['error_msg']);
} 

	
if ($_SESSION['customers_status']['customers_status_write_reviews'] != 0) {
	$module_smarty->assign('BUTTON_WRITE', TEXT_WRITE_REVIEW . '<a href="javascript:void(0)">'.xtc_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW,'style="cursor:pointer"').'</a>');
	$module_smarty->assign('FORM_ACTION_REVIEW', xtc_draw_form('product_reviews_write', xtc_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'action=process&mode=ajax&'.xtc_product_link($product->data['products_id'],$product->data['products_name'])), 'POST', 'onsubmit="return checkForm();"'));
	$module_smarty->assign('INPUT_TEXT', xtc_draw_textarea_field('review', 'soft', 60, 15, $_SESSION['tmp_review'], 'style="width:98%"', false));
	$module_smarty->assign('INPUT_RATING', xtc_draw_radio_field('rating', '1','','class="star"').' '.xtc_draw_radio_field('rating', '2','','class="star"').' '.xtc_draw_radio_field('rating', '3','','class="star"').' '.xtc_draw_radio_field('rating', '4','','class="star"').' '.xtc_draw_radio_field('rating', '5','','class="star"'));

	//Antispam beginn
	$antispam_query = xtc_db_fetch_array(xtDBquery("SELECT id, question FROM " . TABLE_CSEO_ANTISPAM . " WHERE language_id = '" . (int) $_SESSION['languages_id'] . "' ORDER BY rand() LIMIT 1"));
	$module_smarty->assign('ANTISPAMCODEID', xtc_draw_hidden_field('antispamid', $antispam_query['id']));
	$module_smarty->assign('ANTISPAMCODEQUESTION', $antispam_query['question']);
	$module_smarty->assign('INPUT_ANTISPAMCODE', xtc_draw_input_field('codeanwser', '', 'size="6" maxlength="6"', 'text', false));
	$module_smarty->assign('ANTISPAMCODEACTIVE', ANTISPAM_REVIEWS);
	//Antispam end

	$module_smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_send.gif', IMAGE_BUTTON_SEND).xtc_draw_hidden_field('get_params', $get_params));
	$module_smarty->assign('FORM_END', '</form>');
}

if ($product->getReviewsCount() <= 0)
	$module_smarty->assign('NEW_REVIEW', true);

$module_smarty->assign('language', $_SESSION['language']);
$module_smarty->assign('module_content', $product->getReviews());
$module_smarty->caching = false;
$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/products_reviews.html');
if ($_SESSION['customers_status']['customers_status_write_reviews'] != 0 || $_SESSION['customers_status']['customers_status_read_reviews'] != 0) {
	$info_smarty->assign('MODULE_products_reviews', $module);
}
?>