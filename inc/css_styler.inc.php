<?php
/*-----------------------------------------------------------------
* 	ID:						css_styler.inc.php
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




include('includes/application_top.php');

function getHex($value) {
	$v = substr($value,0,6);
	return '#'.$v;
}

header("Content-type: text/css");

if(CSS_BUTTON_BACKGROUND_1 !='' || CSS_BUTTON_BACKGROUND_2 !=''){
	$background = ' url(cseo_css_img.php?w=1&h=30&c1='.CSS_BUTTON_BACKGROUND_1.'&c2='.CSS_BUTTON_BACKGROUND_2.') repeat-x 0 100%';
} elseif(CSS_BUTTON_BACKGROUND_PIC !='')
	$background = ' url(images/css_button_bg/'.CSS_BUTTON_BACKGROUND_PIC.') repeat-x 0 100%';
?>

input.css_img_button, a span.css_img_button { 
	background: <?php echo getHex(CSS_BUTTON_BACKGROUND).$background; ?>;

<?php if(CSS_BUTTON_BORDER_WIDTH > 0 && CSS_BUTTON_BORDER_STYLE !='none') { ?>
	border: <?php echo CSS_BUTTON_BORDER_WIDTH.' '.CSS_BUTTON_BORDER_STYLE.' '.getHex(CSS_BUTTON_BORDER_COLOR); ?>;
<?php } else { ?>
	border: 0;
<?php } ?>
	color:<?php echo getHex(CSS_BUTTON_FONT_COLOR) ?>;
	cursor:pointer;
	height: 24px;
	margin-bottom: 2px; 
	font-family: <?php echo CSS_BUTTON_FONT_FAMILY; ?>;
<?php if(CSS_BUTTON_FONT_SIZE!='') { ?>
	font-size:<?php echo CSS_BUTTON_FONT_SIZE ?>
<?php } ?>
	font-size-adjust:none;
	font-stretch:normal;
	font-style:normal;
	font-variant:normal;
	font-weight:normal;
	display:inline-block;
	line-height:normal;
<?php if(CSS_BUTTON_FONT_ITALIC == 'true') { ?>
	font-style: italic;
<?php } ?>
	padding:0 6px 2px 6px;
	text-align:center !important;
	white-space:nowrap;
<?php if(CSS_BUTTON_BORDER_RADIUS !='') { ?>
	-moz-border-radius:<?php echo CSS_BUTTON_BORDER_RADIUS ?>;
	-webkit-border-radius:<?php echo CSS_BUTTON_BORDER_RADIUS ?>;
	border-radius:<?php echo CSS_BUTTON_BORDER_RADIUS ?>;
<?php }
if(CSS_BUTTON_FONT_SHADOW !='') { ?>
	text-shadow:<?php echo CSS_BUTTON_FONT_SHADOW ?>;
<?php } 
if(CSS_BUTTON_MISC !='')
	echo  CSS_BUTTON_MISC;
?>	
}
	
a span.css_img_button {
 line-height:2em;
}
input.css_img_button{
	padding:3px 4px 5px 4px;
}
<?php # Hover funktion ?>
a:hover .css_img_button, input.css_img_button:hover {
<?php
// print_(CSS_BUTTON_HOVER_BACKGROUND_1); exit;
if(CSS_BUTTON_HOVER_BACKGROUND_1 !='' || CSS_BUTTON_HOVER_BACKGROUND_2 !='')
	$background_hover = ' url(cseo_css_img.php?w=1&h=30&c1='.CSS_BUTTON_HOVER_BACKGROUND_1.'&c2='.CSS_BUTTON_HOVER_BACKGROUND_2.') repeat-x 0 100%';
elseif(CSS_BUTTON_BACKGROUND_HOVER !='' || CSS_BUTTON_BACKGROUND_PIC_HOVER !='') {
	if(CSS_BUTTON_BACKGROUND_PIC_HOVER !='')
		$background_hover = ' url(images/css_button_bg/'.CSS_BUTTON_BACKGROUND_PIC_HOVER.') repeat-x scroll 0 100%';	
}
echo 'background:' . getHex(CSS_BUTTON_BACKGROUND_HOVER).$background_hover . ';';
if(CSS_BUTTON_BORDER_COLOR_HOVER !='')
	echo 'border-color:'.getHex(CSS_BUTTON_BORDER_COLOR_HOVER).';';
if(CSS_BUTTON_FONT_COLOR_HOVER!='')
	echo 'color:'.getHex(CSS_BUTTON_FONT_COLOR_HOVER).';';
?>
}

* html .css_img_button { padding: 1px 2px 2px 2px; } 
* html button.css_img_button { padding: 1px 2px 2px 2px; margin: -2px 1px;}
a.css_img_button:link,a.css_img_button:visited,a.css_img_button:active,a:hover .css_img_button { text-decoration: none; }

/* h4.boxTitle{background:url(cseo_css_img.php?w=1&h=30&c1=d1d1d1&c2=777777) repeat-x center} */

?>
