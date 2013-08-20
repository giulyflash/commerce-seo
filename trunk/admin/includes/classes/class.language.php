<?php

/* -----------------------------------------------------------------
 * 	$Id: class.language.php 420 2013-06-19 18:04:39Z akausch $
 * 	Copyright (c) 2011-2021 commerce:SEO by Webdesign Erfurt
 * 	http://www.commerce-seo.de
 * ------------------------------------------------------------------
 * 	based on:
 * 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 * 	(c) 2002-2003 osCommerce - www.oscommerce.com
 * 	(c) 2003     nextcommerce - www.nextcommerce.org
 * 	(c) 2005     xt:Commerce - www.xt-commerce.com
 * 	Released under the GNU General Public License
 * --------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

class language {

    var $languages, $catalog_languages, $browser_languages, $language;

    // function __construct() {
    // }

    function language($lng = '') {
        $this->languages = array('ar' => array('ar([-_][[:alpha:]]{2})?|arabic', 'arabic', 'ar'),
            'bg-win1251' => array('bg|bulgarian', 'bulgarian-win1251', 'bg'),
            'bg-koi8r' => array('bg|bulgarian', 'bulgarian-koi8', 'bg'),
            'ca' => array('ca|catalan', 'catala', 'ca'),
            'cs-iso' => array('cs|czech', 'czech-iso', 'cs'),
            'cs-win1250' => array('cs|czech', 'czech-win1250', 'cs'),
            'da' => array('da|danish', 'danish', 'da'),
            'de' => array('de([-_][[:alpha:]]{2})?|german', 'german', 'de'),
            'el' => array('el|greek', 'greek', 'el'),
            'en' => array('en([-_][[:alpha:]]{2})?|english', 'english', 'en'),
            'es' => array('es([-_][[:alpha:]]{2})?|spanish', 'spanish', 'es'),
            'et' => array('et|estonian', 'estonian', 'et'),
            'fi' => array('fi|finnish', 'finnish', 'fi'),
            'fr' => array('fr([-_][[:alpha:]]{2})?|french', 'french', 'fr'),
            'gl' => array('gl|galician', 'galician', 'gl'),
            'he' => array('he|hebrew', 'hebrew', 'he'),
            'hu' => array('hu|hungarian', 'hungarian', 'hu'),
            'id' => array('id|indonesian', 'indonesian', 'id'),
            'it' => array('it|italian', 'italian', 'it'),
            'ja-euc' => array('ja|japanese', 'japanese-euc', 'ja'),
            'ja-sjis' => array('ja|japanese', 'japanese-sjis', 'ja'),
            'ko' => array('ko|korean', 'korean', 'ko'),
            'ka' => array('ka|georgian', 'georgian', 'ka'),
            'lt' => array('lt|lithuanian', 'lithuanian', 'lt'),
            'lv' => array('lv|latvian', 'latvian', 'lv'),
            'nl' => array('nl([-_][[:alpha:]]{2})?|dutch', 'dutch', 'nl'),
            'no' => array('no|norwegian', 'norwegian', 'no'),
            'pl' => array('pl|polish', 'polish', 'pl'),
            'pt-br' => array('pt[-_]br|brazilian portuguese', 'brazilian_portuguese', 'pt-BR'),
            'pt' => array('pt([-_][[:alpha:]]{2})?|portuguese', 'portuguese', 'pt'),
            'ro' => array('ro|romanian', 'romanian', 'ro'),
            'ru-koi8r' => array('ru|russian', 'russian-koi8', 'ru'),
            'ru-win1251' => array('ru|russian', 'russian-win1251', 'ru'),
            'sk' => array('sk|slovak', 'slovak-iso', 'sk'),
            'sk-win1250' => array('sk|slovak', 'slovak-win1250', 'sk'),
            'sr-win1250' => array('sr|serbian', 'serbian-win1250', 'sr'),
            'sv' => array('sv|swedish', 'swedish', 'sv'),
            'th' => array('th|thai', 'thai', 'th'),
            'tr' => array('tr|turkish', 'turkish', 'tr'),
            'uk-win1251' => array('uk|ukrainian', 'ukrainian-win1251', 'uk'),
            'zh-tw' => array('zh[-_]tw|chinese traditional', 'chinese_big5', 'zh-TW'),
            'zh' => array('zh|chinese simplified', 'chinese_gb', 'zh'));


        $this->catalog_languages = array();
        $languages_query = xtc_db_query("select languages_id, name, code, image, directory from " . TABLE_LANGUAGES . " order by sort_order");
        while ($languages = xtc_db_fetch_array($languages_query)) {
            $this->catalog_languages[$languages['code']] = array('id' => $languages['languages_id'],
                'name' => $languages['name'],
                'image' => $languages['image'],
                'directory' => $languages['directory']);
        }

        $this->browser_languages = '';
        $this->language = '';

        if ((!empty($lng)) && (isset($this->catalog_languages[$lng]))) {
            $this->language = $this->catalog_languages[$lng];
        } else {
            $this->language = $this->catalog_languages[DEFAULT_LANGUAGE];
        }
    }

    function get_browser_language() {
        $this->browser_languages = explode(',', getenv('HTTP_ACCEPT_LANGUAGE'));

        for ($i = 0, $n = sizeof($this->browser_languages); $i < $n; $i++) {
            reset($this->languages);
            while (list($key, $value) = each($this->languages)) {
                if (preg_match('/^(' . $value[0] . ')(;q=[0-9]\\.[0-9])?$/i', $this->browser_languages[$i]) && isset($this->catalog_languages[$key])) {
                    $this->language = $this->catalog_languages[$key];
                    break 2;
                }
            }
        }
    }

}
