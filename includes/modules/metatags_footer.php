<?php
/*-----------------------------------------------------------------
* 	$Id: metatags_footer.php 420 2013-06-19 18:04:39Z akausch $
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

// ---------------------------------------------------------------------------------------
//	AUTOMATISCHE METATAGS für xt:Commerce 3.04 und commerce:SEO
// ---------------------------------------------------------------------------------------
//	vbasiert auf Gunnar Tillmann metatags.php
//	http://www.gunnart.de
//	modify by Webdesign Erfurt
//	http://www.webdesign-erfurt.de
// ---------------------------------------------------------------------------------------
//	based on:
//	(c) 2003 xt:Commerce (metatags.php, v.1140 2005/08/10); www.xt-commerce.de
//	(c) 2003 nextcommerce (metatags.php, v1.7 2003/08/14); www.nextcommerce.org
// ---------------------------------------------------------------------------------------
//	Inspired by "Dynamic Meta" - Ein WordPress-PlugIn von Michael Schwarz
//	http://www.php-vision.de/plugins-scripte/dynamicmeta-wpplugin.php
// ---------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------
//	Konfiguration ... 
// ---------------------------------------------------------------------------------------
	global $metaStopWords, $metaGoWords, $metaMinLength, $metaMaxLength, $metaDesLength;
		$metaStopWords 	=	('inkl,Versandkosten,aber,alle,alles,als,auch,auf,aus,bei,beim,beinahe,bin,bis,ist,dabei,dadurch,daher,dank,darum,danach,das,daР Р‡,dass,dein,deine,dem,den,der,des,dessen,dadurch,deshalb,die,dies,diese,dieser,diesen,diesem,dieses,doch,dort,durch,eher,ein,eine,einem,einen,einer,eines,einige,einigen,einiges,eigene,eigenes,eigener,endlich,euer,eure,etwas,fast,findet,fРЎРЉr,gab,gibt,geben,hatte,hatten,hattest,hattet,heute,hier,hinter,ich,ihr,ihre,ihn,ihm,im,immer,in,ist,ja,jede,jedem,jeden,jeder,jedes,jener,jenes,jetzt,kann,kannst,kein,kРЎвЂ nnen,kРЎвЂ nnt,machen,man,mein,meine,mehr,mit,muР Р‡,muР Р‡t,musst,mРЎРЉssen,mРЎРЉР Р‡t,nach,nachdem,neben,nein,nicht,nichts,noch,nun,nur,oder,statt,anstatt,seid,sein,seine,seiner,sich,sicher,sie,sind,soll,sollen,sollst,sollt,sonst,soweit,sowie,und,uns,unser,unsere,unserem,unseren,unter,vom,von,vor,wann,warum,was,war,weiter,weitere,wenn,wer,werde,widmen,widmet,viel,viele,vieles,weil,werden,werdet,weshalb,wie,wieder,wieso,wir,wird,wirst,wohl,woher,wohin,wurdezum,zur,РЎРЉber');
		$metaGoWords 	=	('autoradio,car,hifi,navigation,commerce,seo,shop,online,xtc'); // Hier rein, was nicht gefiltert werden soll
		$metaMinLength 	=	META_MIN_KEYWORD_LENGTH;		// Mindestlänge eines Keywords
		$metaMaxLength 	=	META_MAX_KEYWORD_LENGTH;		// Maximallänge eines Keywords
		$metaDesLength 	=	META_MAX_DESCRIPTION_LENGTH;	// maximale Länge der "description" (in Buchstaben)
// ---------------------------------------------------------------------------------------
	$addCatShopTitle 		= 	false; 	// Shop-Titel bei Kategorien anhängen, ja/nein?
	$addProdShopTitle 		= 	false; 	// Shop-Titel bei Produkten anhängen, ja/nein?
	$addContentShopTitle 	= 	false; 	// Shop-Titel bei Contentseiten anhängen, ja/nein?
	$addSpecialsShopTitle 	= 	false; 	// Shop-Titel bei Angeboten anhängen, ja/nein?
	$addNewsShopTitle 		= 	false; 	// Shop-Titel bei Neuen Artikeln anhängen, ja/nein?
	$addSearchShopTitle 	= 	false; 	// Shop-Titel bei Suchergebnissen anhängen, ja/nein?
	$addOthersShopTitle 	= 	false; 	// Shop-Titel bei sonstigen Seiten anhängen, ja/nein?
// ---------------------------------------------------------------------------------------
//	Title für "sonstige" Seiten
// ---------------------------------------------------------------------------------------
	//$breadcrumbTitle = 	array_pop($breadcrumb->_trail);
	$breadcrumbTitle = 	end($breadcrumb->_trail); // <-- BugFix
	$breadcrumbTitle = 	$breadcrumbTitle['title']; 	


// ---------------------------------------------------------------------------------------
//  MultiLanguage-Metas
// ---------------------------------------------------------------------------------------

	// Wenn wir auf der Startseite sind, Metas aus der index-Seite holen
	if(	basename($_SERVER['SCRIPT_NAME'])==FILENAME_DEFAULT && 
		empty($_GET['cat']) && 
		empty($_GET['cPath']) && 
		empty($_GET['manufacturers_id'])
	) {
		$ml_meta_where = "content_group = 5";

	// ... ansonsten Metas aus STANDARD_META holen
	} else {
		$ml_meta_where = "content_title = 'STANDARD_META'";
	}

	// Dadadadatenbank
	$ml_meta_query = xtDBquery("
		select 	content_meta_title,
				content_meta_description, 
				content_meta_keywords 
		from 	".TABLE_CONTENT_MANAGER." 
		where 	".$ml_meta_where." 
		and 	languages_id = '".$_SESSION['languages_id']."'
	");
	$ml_meta = xtc_db_fetch_array($ml_meta_query,true); 

// ---------------------------------------------------------------------------------------
//	Mehrsprachige Standard-Metas definieren. Wenn leer, werden die üblichen genommen
// ---------------------------------------------------------------------------------------
	define('ML_META_KEYWORDS',($ml_meta['content_meta_keywords'])?$ml_meta['content_meta_keywords']:META_KEYWORDS);
	define('ML_META_DESCRIPTION',($ml_meta['content_meta_description'])?$ml_meta['content_meta_description']:META_DESCRIPTION);
	define('ML_TITLE',($ml_meta['content_meta_title'])?$ml_meta['content_meta_title']:TITLE);
// ---------------------------------------------------------------------------------------
	$metaGoWords = getFooterGoWords(); // <-- nur noch einmal ausführen
// ---------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------
//	Aufräumen: Umlaute und Sonderzeichen wandeln. 
// ---------------------------------------------------------------------------------------
	function metaFooterNoEntities($Text){
	    $translation_table = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
	    $translation_table = array_flip($translation_table);
	    $Return= strtr($Text,$translation_table);
	    return preg_replace( '/&#(\d+);/me',"chr('\\1')",$Return);
	}
	function metaFooterHtmlEntities($Text) {
		$translation_table=get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
		$translation_table[chr(38)] = '&';
		return preg_replace("/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,3};)/","&amp;",strtr($Text,$translation_table));
	}
// ---------------------------------------------------------------------------------------
//	Array basteln: Text aufbereiten -> Array erzeugen -> Array unique ...  
// ---------------------------------------------------------------------------------------
	function prepareFooterFooterWordArray($Text) {
		//$Text = str_replace(array('&nbsp;','\t','\r','\n','\b'),' ',strip_tags($Text));
		$Text = str_replace(array('&nbsp;','\t','\r','\n','\b'),' ',preg_replace("/<[^>]*>/",' ',$Text)); // <-- Besser bei Zeilenumbrüchen
		$Text = metaFooterHtmlEntities(metaFooterNoEntities(strtolower($Text)),ENT_QUOTES);
		$Text = preg_replace("/\s\-|\-\s/",' ',$Text); // <-- Gegen Trenn- und Gedankenstriche
		$Text = preg_replace("/(&[^aoucizens][^;]*;)/",' ',$Text);
		$Text = preg_replace("/[^0-9a-z|\-|&|;]/",' ',$Text); // <-- Bindestriche drin lassen
		$Text = trim(preg_replace("/\s\s+/",' ',$Text));
		return $Text;
	}
	
	function makeFooterFooterWordArray($Text) {
		$Text = func_get_args();
		$Words = array();
		foreach($Text as $Word) {
			if((!empty($Word))&&(is_string($Word))) {
				$Words = array_merge($Words,explode(' ',$Word));
			}
		}
		return array_unique($Words);
	}
	function FooterWordArray($Text) {
		return makeFooterFooterWordArray(prepareFooterFooterWordArray($Text));
	}
// ---------------------------------------------------------------------------------------
//	KeyWords aufräumen:
// 	Stop- und KeyWords-Liste in Array umwandeln, StopWords löschen, 
//	GoWords- und Längen-Filter anwenden
// ---------------------------------------------------------------------------------------
	function cleanFooterKeyWords($KeyWords) {
		global $metaStopWords;
		$KeyWords 	= 	FooterWordArray($KeyWords);
		$StopWords 	=	FooterWordArray($metaStopWords);
		$KeyWords 	= 	array_diff($KeyWords,$StopWords);
		$KeyWords 	= 	array_filter($KeyWords,filterKeyFooterWordArray);
		return $KeyWords;
	}
// ---------------------------------------------------------------------------------------
//	GoWords- und Längen-Filter: 
//	Alles, was zu kurz ist, fliegt raus, sofern nicht in der GoWords-Liste
// ---------------------------------------------------------------------------------------
	function filterKeyFooterWordArray($KeyWord) {
		global $metaMinLength, $metaMaxLength, $metaGoWords;
		$GoWords = FooterWordArray($metaGoWords);
		if(!in_array($KeyWord,$GoWords)) {
			//$Length = strlen($KeyWord);
			$Length = strlen(preg_replace("/(&[^;]*;)/",'#',$KeyWord)); // <-- Mindest-Länge auch bei Umlauten berücksichtigen
			if($Length < $metaMinLength) { // Mindest-Länge
				return false;
			} elseif($Length > $metaMaxLength) { // Maximal-Länge
				return false;
			}
		}
		return true;
	}	
// ---------------------------------------------------------------------------------------
//	GoWords: Werden grundsätzlich nicht gefiltert
//	Sofern angelegt, werden (zusätzlich zu den Einstellungen oben) die "normalen"
//	Meta-Angaben genommen (gefixed anno Danno-Wanno)
// ---------------------------------------------------------------------------------------
	function getFooterGoWords(){
		global $metaGoWords, $categories_meta, $product;
		//$GoWords = $metaGoWords.' '.META_KEYWORDS;
		$GoWords = $metaGoWords.' '.ML_META_KEYWORDS.' '.ML_TITLE; // <-- MultiLanguage
		$GoWords .= ' '.$categories_meta['categories_meta_keywords'];
		$GoWords .= ' '.$product->data['products_meta_keywords'];
		return $GoWords;
	}
// ---------------------------------------------------------------------------------------
//	Aufräumen: Leerzeichen und HTML-Code raus, kürzen, Umlaute und Sonderzeichen wandeln
// ---------------------------------------------------------------------------------------
	function metaFooterClean($Text,$Length=false,$Abk=' ...') {
		$Text = strip_tags($Text);
		$Text = str_replace(array('&nbsp;','\t','\r','\n','\b'),' ',$Text);
		$Text = trim(preg_replace("/\s\s+/",' ',$Text));
		if(($Length)&&($Length > 0)) {
			if(strlen($Text) > $Length) {
	        	$Length -= strlen($Abk);
	            $Text = preg_replace('/\s+?(\S+)?$/', '', substr($Text, 0, $Length+1));
	            $Text = substr($Text, 0, $Length).$Abk;
			}
		}
		return $Text;
	}
// ---------------------------------------------------------------------------------------
//	metaFooterTitle und metaFooterKeyWords, Rückgabe bzw. Formatierung
// ---------------------------------------------------------------------------------------
	function metaFooterTitle($Title=array()) {
		$Title = func_get_args();
		$Title = array_filter($Title,metaFooterClean);
		return implode(' - ',$Title);
	}
// ---------------------------------------------------------------------------------------
	function metaFooterKeyWords($Text) {
		$KeyWords = cleanFooterKeyWords($Text);
		return implode(', ',$KeyWords);
	}
// ---------------------------------------------------------------------------------------



// ---------------------------------------------------------------------------------------
//	Daten holen: Produktdetails
// ---------------------------------------------------------------------------------------
	//if(basename($_SERVER['SCRIPT_NAME']) == FILENAME_PRODUCT_INFO) { 
	if (isset($_GET['products_id']) && is_numeric($_GET['products_id'])) {
		if($product->isProduct()) { 
			// KeyWords ...
			if(!empty($product->data['products_meta_keywords'])) { 
				$meta_keyw = $product->data['products_meta_keywords']; 
			} else { 
				$meta_keyw = metaFooterKeyWords($product->data['products_name'].' '.$product->data['products_description']);
			}
			
			// Description ...
			if(!empty($product->data['products_meta_description'])) { 
				$meta_descr = $product->data['products_meta_description'];
				$metaDesLength = false;
			} else { 
				$meta_descr = $product->data['products_name'].': '.$product->data['products_description']; 
			}
			
			// Title ...
			if(!empty($product->data['products_meta_title'])) {
				$meta_title = $product->data['products_meta_title'].(($addProdShopTitle)?' - '.ML_TITLE:'');
			} else {
				$meta_title = metaFooterTitle($product->data['products_name'],$product->data['manufacturers_name'],($addProdShopTitle)?ML_TITLE:'');
			} 
		}
	} 
	
// ---------------------------------------------------------------------------------------
//	Daten holen: Kategorie
// ---------------------------------------------------------------------------------------
	elseif	($_GET['cPath']) {
		// Sind wir in einer Kategorie?
		if(!empty($current_category_id)) {
			$categories_meta_query = xtDBquery("
				select 	categories_meta_keywords, 
						categories_meta_description, 
						categories_meta_title, 
						categories_name, 
						categories_description 
				from 	".TABLE_CATEGORIES_DESCRIPTION." 
				where 	categories_id='".intval($current_category_id)."' 
				and 	language_id='".intval($_SESSION['languages_id'])."'
			"); 
			$categories_meta = xtc_db_fetch_array($categories_meta_query,true);
		}
		
		$manu_id = $manu_name = false;

		// Nachsehen, ob ein Hersteller gewählt ist
		if(!empty($_GET['manu'])) {
			$manu_id = $_GET['manu'];
		}
		if(!empty($_GET['manufacturers_id'])) {
			$manu_id = $_GET['manufacturers_id'];
		}
		if(!empty($_GET['filter_id']) && !$manu_id) {
			$manu_id = $_GET['filter_id'];
		}

		// ggf. Herstellernamen herausfinden ...
		if($manu_id) {
			$manu_name_query = xtDBquery("
				select 	manufacturers_name 
				from 	".TABLE_MANUFACTURERS." 
				where 	manufacturers_id ='".intval($manu_id)."'
			");
			$manu_name = implode('',xtc_db_fetch_array($manu_name_query,true));
			$metaGoWords .= ','.$manu_name; // <-- zu GoWords hinzufügen
		}
		
		// KeyWords ...
		if(!empty($categories_meta['categories_meta_keywords'])) { 
			$meta_keyw = $categories_meta['categories_meta_keywords']; // <-- 1:1 übernehmen!
		} else{ 
			$meta_keyw = metaFooterKeyWords($categories_meta['categories_name'].' '.$manu_name.' '.$categories_meta['categories_description']);
		} 
		
		// Description ...
		if(!empty($categories_meta['categories_meta_description'])) { 
			// ggf. Herstellername hinzufügen
			$meta_descr = $categories_meta['categories_meta_description'].(($manu_name)?' - '.$manu_name:''); 
			$metaDesLength = false;
		} elseif($categories_meta) {
			// ggf. Herstellername und Kategorientext hinzufügen
			$meta_descr = $categories_meta['categories_name'].(($manu_name)?' - '.$manu_name:'').(($categories_meta['categories_description'])?' - '.$categories_meta['categories_description']:'');
		} 
		
		// Title ...
		if(!empty($categories_meta['categories_meta_title'])) { 
			// Meta-Titel, ggf. Herstellername, ggf. Seiten-Nummer, ggf. Shop-Titel
			$meta_title = $categories_meta['categories_meta_title'].(($manu_name)?' - '.$manu_name:'').(($Page)?' - '.$Page:'').(($addCatShopTitle)?' - '.ML_TITLE:'');
		} else{ 
			$meta_title = metaFooterTitle($categories_meta['categories_name'],$manu_name,$Page,($addCatShopTitle)?ML_TITLE:'');
		}
	} 
// ---------------------------------------------------------------------------------------
//	Daten holen: Inhalts-Seite (ContentManager)
// ---------------------------------------------------------------------------------------


	elseif (isset($_GET['coID']) && is_numeric($_GET['coID'])) {
		$contents_meta_query = xtDBquery("
			select 	content_meta_title,
					content_meta_description, 
					content_meta_keywords, 
					content_title, 
					content_heading, 
					content_text,
					content_file  
			from 	".TABLE_CONTENT_MANAGER." 
			where 	content_group = '".intval($_GET['coID'])."' 
			and 	languages_id = '".$_SESSION['languages_id']."'
		");
		$contents_meta = xtc_db_fetch_array($contents_meta_query,true); 

		if(count($contents_meta) > 0) { 
			
			// NEU! Eingebundene Dateien auslesen
			if($contents_meta['content_file']) {
				// Nur Text- oder HTML-Dateien!
				if(preg_match("/\.(txt|htm|html)$/i", $contents_meta['content_file'])) {
					$contents_meta['content_text'] .= ' '.implode(' ', @file(DIR_FS_CATALOG.'media/content/'.$contents_meta['content_file']));
				}
			}			
			
			// KeyWords ...
			if(!empty($contents_meta['content_meta_keywords'])) {
				$meta_keyw = $contents_meta['content_meta_keywords']; 
			} else {
				$meta_keyw = metaFooterKeyWords($contents_meta['content_title'].' '.$contents_meta['content_heading'].' '.$contents_meta['content_text']); 
			}
			
			// Title ...
			if(!empty($contents_meta['content_meta_title'])) {
				$meta_title = $contents_meta['content_meta_title'].(($addContentShopTitle)?' - '.ML_TITLE:''); 
			} else {
				$meta_title = metaFooterTitle($contents_meta['content_title'],$contents_meta['content_heading'],($addContentShopTitle)?ML_TITLE:'');
			}
			
			// Description ...
			if(!empty($contents_meta['content_meta_description'])) {
				$meta_descr = $contents_meta['content_meta_description']; 
				$metaDesLength = false;
			} else {
				$meta_descr = ($contents_meta['content_heading'])?$contents_meta['content_heading'].': ':'';
				$meta_descr .= $contents_meta['content_text'];
			}
		}
	}
	
// ---------------------------------------------------------------------------------------
//	Daten holen: Hersteller
// ---------------------------------------------------------------------------------------
		
	elseif($_GET['manufacturers_id'])
	{
		$manufacturers_meta_query = xtDBquery("SELECT 
													manufacturers_meta_title, 
													manufacturers_meta_description, 
													manufacturers_meta_keywords, 
													m.manufacturers_name 
												FROM 
													" . TABLE_MANUFACTURERS_INFO. ", 
													" . TABLE_MANUFACTURERS. " m
												WHERE 
													m.manufacturers_id ='".intval($_GET['manufacturers_id'])."'
												AND 
													languages_id='" . $_SESSION['languages_id'] . "'");
		$manufacturers_data = xtc_db_fetch_array($manufacturers_meta_query,true);

		if(!empty($manufacturers_data['manufacturers_meta_description']))
			$meta_descr = $manufacturers_data['manufacturers_meta_description'];
		else
			$meta_descr = metaFooterTitle($manufacturers_data['manufacturers_name'],TITLE);
	
		if(!empty($manufacturers_data['manufacturers_meta_keywords']))
			$meta_keyw = $manufacturers_data['manufacturers_meta_keywords'];
		else
			$meta_keyw = metaFooterTitle($manufacturers_data['manufacturers_name'],TITLE);
			
		if(!empty($manufacturers_data['manufacturers_meta_title']))
			$meta_title = $manufacturers_data['manufacturers_meta_title'];
		else
			$meta_title = metaFooterTitle($manufacturers_data['manufacturers_name'],TITLE);
	}

// ---------------------------------------------------------------------------------------
//	Daten hole: Blog Kategorie
// ---------------------------------------------------------------------------------------
	
	elseif((isset($_GET['blog_cat']) && is_numeric($_GET['blog_cat'])) &&(!isset($_GET['blog_item']))) {
		$blog_meta_query = xtDBquery("SELECT meta_key,
	                                        meta_desc,
	                                        meta_title,
	                                        titel
	                                        FROM " . TABLE_BLOG_CATEGORIES . "
	                                        WHERE id='" . $_GET['blog_cat'] . "'
	                                        AND language_id='" . $_SESSION['languages_id'] . "'");
		$blog_meta = xtc_db_fetch_array($blog_meta_query, true);
		
		if(!empty($blog_meta['meta_desc']))
			$meta_descr = $blog_meta['meta_desc'];
		else
			$meta_descr = metaFooterTitle($blog_meta['titel'],TITLE);
	
		if(!empty($blog_meta['meta_key']))
			$meta_keyw = $blog_meta['meta_key'];
		else
			$meta_keyw = metaFooterTitle($blog_meta['titel'],TITLE);
			
		if(!empty($blog_meta['meta_title']))
			$meta_title = $blog_meta['meta_title'];
		else
			$meta_title = metaFooterTitle($blog_meta['titel'],TITLE);
	}
// ---------------------------------------------------------------------------------------
//	Daten hole: Blog Eintrag
// ---------------------------------------------------------------------------------------
	
	elseif((isset($_GET['blog_cat']) && is_numeric($_GET['blog_cat'])) && (isset($_GET['blog_item'])&& is_numeric($_GET['blog_item']))){
		$blog_meta_query = xtDBquery("SELECT meta_keywords,
	                                        meta_description,
	                                        meta_title,
	                                        title
	                                        FROM " . TABLE_BLOG_ITEMS . "
	                                        WHERE id='" . $_GET['blog_item'] . "'
	                                        AND language_id='" . $_SESSION['languages_id'] . "'");
		$blog_meta = xtc_db_fetch_array($blog_meta_query, true);
		
		if(!empty($blog_meta['meta_description']))
			$meta_descr = $blog_meta['meta_description'];
		else
			$meta_descr = metaFooterTitle($blog_meta['titel'],TITLE);
	
		if(!empty($blog_meta['meta_keywords']))
			$meta_keyw = $blog_meta['meta_keywords'];
		else
			$meta_keyw = metaFooterTitle($blog_meta['titel'],TITLE);
			
		if(!empty($blog_meta['meta_title']))
			$meta_title = $blog_meta['meta_title'];
		else
			$meta_title = metaFooterTitle($blog_meta['titel'],TITLE);
	}

	
	
	
// ---------------------------------------------------------------------------------------

//	Title fuer: Specials / Products New
// ---------------------------------------------------------------------------------------
	elseif(basename($_SERVER['SCRIPT_NAME']) == FILENAME_SPECIALS) {
		$meta_title = metaFooterTitle(NAVBAR_TITLE_SPECIALS,TITLE);
	} 
	elseif(basename($_SERVER['SCRIPT_NAME']) == FILENAME_PRODUCTS_NEW) {
		$meta_title = metaFooterTitle(NAVBAR_TITLE_PRODUCTS_NEW,TITLE);
	}
	

switch(basename($_SERVER['SCRIPT_NAME'])) { // Start Switch

// ---------------------------------------------------------------------------------------
//	Title für Suchergebnisse - Mit Suchbegriff, Kategorien-Namen, Seiten-Nummer etc.
// ---------------------------------------------------------------------------------------
	case FILENAME_ADVANCED_SEARCH_RESULT :
		
		// ggf. Herstellernamen herausfinden ...
		if(!empty($_GET['manufacturers_id'])) {
			$manu_name_query = xtDBquery("
				select 	manufacturers_name 
				from 	".TABLE_MANUFACTURERS." 
				where 	manufacturers_id ='".intval($_GET['manufacturers_id'])."'
			");
			$manu_name = implode('',xtc_db_fetch_array($manu_name_query,true));
			$metaGoWords .= ','.$manu_name; // <-- zu GoWords hinzufügen
		}
		// ggf. Kategorien-Namen herausfinden ...
		if(!empty($_GET['categories_id'])) {
			$cat_name_query = xtDBquery("
				select 	categories_name 
				from 	".TABLE_CATEGORIES_DESCRIPTION." 
				where 	categories_id='".intval($_GET['categories_id'])."' 
				and 	language_id='".intval($_SESSION['languages_id'])."'
			");
			$cat_name = implode('',xtc_db_fetch_array($cat_name_query,true));
		}
		$meta_title = metaFooterTitle($breadcrumbTitle,'&quot;'.trim($_GET['keywords']).'&quot;',$Page,$cat_name,$manu_name,($addSearchShopTitle)?ML_TITLE:'');
		break;
		
// ---------------------------------------------------------------------------------------
//	Title für Taglisting - Mit Suchbegriff, Kategorien-Namen, Seiten-Nummer etc.
// ---------------------------------------------------------------------------------------
	case FILENAME_TAGLISTING :
		$meta_keyw    = $_GET['tag'].','.ML_META_KEYWORDS;
		$meta_descr .= metaFooterTitle($breadcrumbTitle,'&quot;'.trim($_GET['tag']).'&quot;',($addSearchShopTitle)?ML_TITLE:'');		
		$meta_title = metaFooterTitle($breadcrumbTitle,'&quot;'.trim($_GET['tag']).'&quot;',($addSearchShopTitle)?ML_TITLE:'');
		break;
// ---------------------------------------------------------------------------------------
//	Title für Produkt-Filter
// ---------------------------------------------------------------------------------------
	case FILENAME_PRODUCT_FILTER :
		$meta_keyw    = $_GET['filter'].','.ML_META_KEYWORDS;
		$meta_descr .= metaFooterTitle($breadcrumbTitle,'&quot;'.trim($_GET['filter']).'&quot;',($addSearchShopTitle)?ML_TITLE:'');		
		$meta_title = metaFooterTitle($breadcrumbTitle,'&quot;'.trim($_GET['filter']).'&quot;',($addSearchShopTitle)?ML_TITLE:'');
		break;	
	
// ---------------------------------------------------------------------------------------
//	Title für Angebote
// ---------------------------------------------------------------------------------------
	case FILENAME_SPECIALS :
		
		$meta_title = metaFooterTitle($breadcrumbTitle,$Page,($addSpecialsShopTitle)?ML_TITLE:'');
		break;
		
// ---------------------------------------------------------------------------------------
//	Title für Neue Artikel

// ---------------------------------------------------------------------------------------
	case FILENAME_PRODUCTS_NEW :
		
		$meta_title = metaFooterTitle($breadcrumbTitle,$Page,($addNewsShopTitle)?ML_TITLE:'');
		break;		
// ---------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------


} // Ende Switch		
		
// ---------------------------------------------------------------------------------------
//	... und wenn nix drin, dann Standard-Werte nehmen
// ---------------------------------------------------------------------------------------
	if(empty($meta_keyw)) {
		//$meta_keyw    = metaFooterKeyWords(META_KEYWORDS); 
		$meta_keyw    = META_KEYWORDS; // <-- 1:1 übernehmen!
	} 
	if(empty($meta_descr)) {
		$meta_descr   = META_DESCRIPTION; 
		$metaDesLength = false; // <-- dann auch nicht kürzen!
	}
	if(empty($meta_title)) {
		$meta_title   = TITLE;
	}
// ---------------------------------------------------------------------------------------
$meta_descr = str_replace('{$greeting}',' ',$meta_descr);

?>


<div class="footer fs85"><?php echo metaFooterClean($meta_descr,$metaDesLength); ?></div>
