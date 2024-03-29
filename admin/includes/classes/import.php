<?php

/* -----------------------------------------------------------------
 * 	$Id: import.php 420 2013-06-19 18:04:39Z akausch $
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

class xtcImport {

    function xtcImport($filename) {
        $this->seperator = CSV_SEPERATOR;
        $this->TextSign = CSV_TEXTSIGN;
        if (CSV_SEPERATOR == '')
            $this->seperator = "\t";
        if (CSV_SEPERATOR == '\t')
            $this->seperator = "\t";
        $this->filename = $filename;
        $this->ImportDir = DIR_FS_CATALOG . 'import/';
        $this->catDepth = 6;
        $this->languages = $this->get_lang();
        $this->counter = array('prod_new' => 0, 'cat_new' => 0, 'prod_upd' => 0, 'cat_upd' => 0);
        $this->mfn = $this->get_mfn();
        $this->errorlog = array();
        $this->time_start = time();
        $this->debug = false;
        $this->CatTree = array('ID' => 0);
        // precaching categories in array ?
        $this->CatCache = true;
        $this->FileSheme = array();
        $this->Groups = xtc_get_customers_statuses();
    }

    /**
     *   generating file layout
     *   @param array $mapping standard fields
     *   @return array
     */
    function generate_map() {

        // lets define a standard fieldmapping array, with importable fields
        $file_layout = array('p_model' => '', // products_model
            'p_stock' => '', // products_quantity
            'p_tpl' => '', // products_template
            'p_sorting' => '', // products_sorting
            'p_manufacturer' => '', // manufacturer
            'p_fsk18' => '', // FSK18
            'p_priceNoTax' => '', // Nettoprice
            'p_tax' => '', // taxrate in percent
            'p_status' => '', // products status
            'p_weight' => '', // products weight
            'p_ean' => '', // products ean
            'p_disc' => '', // products discount
            'p_opttpl' => '', // options template
            'p_image' => '', // product image
            'p_vpe' => '', // products VPE
            'p_vpe_status' => '', // products VPE Status
            'p_vpe_value' => '', // products VPE value
            'p_shipping' => '' // product shipping_time
        );

        // Group Prices
        for ($i = 0; $i < count($this->Groups) - 1; $i++) {
            $file_layout = array_merge($file_layout, array('p_priceNoTax.' . $this->Groups[$i + 1]['id'] => ''));
        }

        // Group Permissions
        for ($i = 0; $i < count($this->Groups) - 1; $i++) {
            $file_layout = array_merge($file_layout, array('p_groupAcc.' . $this->Groups[$i + 1]['id'] => ''));
        }

        // product images
        for ($i = 1; $i < MO_PICS + 1; $i++) {
            $file_layout = array_merge($file_layout, array('p_image.' . $i => ''));
        }

        // add lang fields
        for ($i = 0; $i < sizeof($this->languages); $i++) {
            $file_layout = array_merge($file_layout, array('p_name.' . $this->languages[$i]['code'] => '',
                'p_desc.' . $this->languages[$i]['code'] => '',
                'p_shortdesc.' . $this->languages[$i]['code'] => '',
                'p_meta_title.' . $this->languages[$i]['code'] => '',
                'p_meta_desc.' . $this->languages[$i]['code'] => '',
                'p_meta_key.' . $this->languages[$i]['code'] => '',
                'p_keywords.' . $this->languages[$i]['code'] => '',
                'p_url.' . $this->languages[$i]['code'] => ''));
        }
        // add categorie fields
        for ($i = 0; $i < $this->catDepth; $i++)
            $file_layout = array_merge($file_layout, array('p_cat.' . $i => ''));

        return $file_layout;
    }

    /**
     *   generating mapping layout for importfile
     *   @param array $mapping standard fields
     *   @return array
     */
    function map_file($mapping) {
        if (!file_exists($this->ImportDir . $this->filename)) {
            // error
            return 'error';
        } else {
            // file is ok, creating mapping
            $inhalt = array();
            $inhalt = file($this->ImportDir . $this->filename);
            // get first line into array
            $content = explode($this->seperator, $inhalt[0]);

            foreach ($mapping as $key => $value) {
                // try to find our field in fieldlayout
                foreach ($content as $key_c => $value_c)
                    if ($key == trim($this->RemoveTextNotes($content[$key_c]))) {
                        $mapping[$key] = trim($this->RemoveTextNotes($key_c));
                        $this->FileSheme[$key] = 'Y';
                    }
            }
            return $mapping;
        }
    }

    /**
     *   Get installed languages
     *   @return array
     */
    function get_lang() {

        $languages_query = xtc_db_query("SELECT languages_id, name, code, image, directory FROM " . TABLE_LANGUAGES . " ORDER BY sort_order");
        while ($languages = xtc_db_fetch_array($languages_query)) {
            $languages_array[] = array('id' => $languages['languages_id'],
                'name' => $languages['name'],
                'code' => $languages['code']);
        }

        return $languages_array;
    }

    function import($mapping) {
        // open file
        $inhalt = file($this->ImportDir . $this->filename);
        $lines = count($inhalt);

        // walk through file data, and ignore first line
        for ($i = 1; $i < $lines; $i++) {
            $line_content = '';

            // get line content
            $line_fetch = $this->get_line_content($i, $inhalt, $lines);
            $line_content = explode($this->seperator, $line_fetch['data']);
            $i += $line_fetch['skip'];

            // ok, now crossmap data into array
            $line_data = $this->generate_map();

            foreach ($mapping as $key => $value)
                $line_data[$key] = $this->RemoveTextNotes($line_content[$value]);

            if ($this->debug) {
                echo '<pre>';
                print_r($line_data);
                echo '</pre>';
            }

            if ($line_data['p_model'] != '') {
                if ($line_data['p_cat.0'] != '' || $this->FileSheme['p_cat.0'] != 'Y') {
                    if ($this->FileSheme['p_cat.0'] != 'Y') {
                        if ($this->checkModel($line_data['p_model'])) {
                            $this->insertProduct($line_data, 'update');
                        } else {
                            $this->insertProduct($line_data, 'insert');
                        }
                    } else {
                        if ($this->checkModel($line_data['p_model'])) {
                            $this->insertProduct($line_data, 'update', true);
                        } else {
                            $this->insertProduct($line_data, 'insert', true);
                        }
                    }
                } else {
                    $this->errorLog[] = '<b>ERROR:</b> no Categorie, line: ' . $i . ' dataset: ' . $line_fetch['data'];
                }
            } else {
                $this->errorLog[] = '<b>ERROR:</b> no Modelnumber, line: ' . $i . ' dataset: ' . $line_fetch['data'];
            }
        }
        return array($this->counter, $this->errorLog, $this->calcElapsedTime($this->time_start));
    }

    /**
     *   Check if a product exists in database, query for model number
     *   @param string $model products modelnumber
     *   @return boolean
     */
    function checkModel($model) {
        $model_query = xtc_db_query("SELECT products_id FROM " . TABLE_PRODUCTS . " WHERE products_model='" . addslashes($model) . "'");
        if (!xtc_db_num_rows($model_query))
            return false;
        return true;
    }

    /**
     *   Check if a image exists
     *   @param string $model products modelnumber
     *   @return boolean
     */
    function checkImage($imgID, $pID) {
        $img_query = xtc_db_query("SELECT image_id FROM " . TABLE_PRODUCTS_IMAGES . " WHERE products_id='" . $pID . "' AND image_nr='" . $imgID . "'");
        if (!xtc_db_num_rows($img_query))
            return false;
        return true;
    }

    /**
     *   removing textnotes from a dataset
     *   @param String $data data
     *   @return String cleaned data
     */
    function RemoveTextNotes($data) {
        if (substr($data, -1) == $this->TextSign)
            $data = substr($data, 1, strlen($data) - 2);

        return $data;
    }

    /**
     *   Get/create manufacturers ID for a given Name
     *   @param String $manufacturer Manufacturers name
     *   @return int manufacturers ID
     */
    function getMAN($manufacturer) {
        if ($manufacturer == '')
            return;
        if (isset($this->mfn[$manufacturer]['id']))
            return $this->mfn[$manufacturer]['id'];
        $man_query = xtc_db_query("SELECT manufacturers_id FROM " . TABLE_MANUFACTURERS . " WHERE manufacturers_name = '" . $manufacturer . "'");
        if (!xtc_db_num_rows($man_query)) {
            $manufacturers_array = array('manufacturers_name' => $manufacturer);
            xtc_db_perform(TABLE_MANUFACTURERS, $manufacturers_array);
            $this->mfn[$manufacturer]['id'] = mysql_insert_id();
        } else {
            $man_data = xtc_db_fetch_array($man_query);
            $this->mfn[$manufacturer]['id'] = $man_data['manufacturers_id'];
        }
        return $this->mfn[$manufacturer]['id'];
    }

    /**
     *   Insert a new product into Database
     *   @param array $dataArray Linedata
     *   @param string $mode insert or update flag
     */
    function insertProduct(& $dataArray, $mode = 'insert', $touchCat = false) {

        $products_array = array('products_model' => $dataArray['p_model']);
        if ($this->FileSheme['p_stock'] == 'Y')
            $products_array = array_merge($products_array, array('products_quantity' => $dataArray['p_stock']));
        if ($this->FileSheme['p_priceNoTax'] == 'Y')
            $products_array = array_merge($products_array, array('products_price' => $dataArray['p_priceNoTax']));
        if ($this->FileSheme['p_weight'] == 'Y')
            $products_array = array_merge($products_array, array('products_weight' => $dataArray['p_weight']));
        if ($this->FileSheme['p_status'] == 'Y')
            $products_array = array_merge($products_array, array('products_status' => $dataArray['p_status']));
        if ($this->FileSheme['p_image'] == 'Y')
            $products_array = array_merge($products_array, array('products_image' => $dataArray['p_image']));
        if ($this->FileSheme['p_disc'] == 'Y')
            $products_array = array_merge($products_array, array('products_discount_allowed' => $dataArray['p_disc']));
        if ($this->FileSheme['p_ean'] == 'Y')
            $products_array = array_merge($products_array, array('products_ean' => $dataArray['p_ean']));
        if ($this->FileSheme['p_tax'] == 'Y')
            $products_array = array_merge($products_array, array('products_tax_class_id' => $dataArray['p_tax']));
        if ($this->FileSheme['p_opttpl'] == 'Y')
            $products_array = array_merge($products_array, array('options_template' => $dataArray['p_opttpl']));
        if ($this->FileSheme['p_manufacturer'] == 'Y')
            $products_array = array_merge($products_array, array('manufacturers_id' => $this->getMAN(trim($dataArray['p_manufacturer']))));
        if ($this->FileSheme['p_fsk18'] == 'Y')
            $products_array = array_merge($products_array, array('products_fsk18' => $dataArray['p_fsk18']));
        if ($this->FileSheme['p_tpl'] == 'Y')
            $products_array = array_merge($products_array, array('product_template' => $dataArray['p_tpl']));
        if ($this->FileSheme['p_vpe'] == 'Y')
            $products_array = array_merge($products_array, array('products_vpe' => $dataArray['p_vpe']));
        if ($this->FileSheme['p_vpe_status'] == 'Y')
            $products_array = array_merge($products_array, array('products_vpe_status' => $dataArray['p_vpe_status']));
        if ($this->FileSheme['p_vpe_value'] == 'Y')
            $products_array = array_merge($products_array, array('products_vpe_value' => $dataArray['p_vpe_value']));
        if ($this->FileSheme['p_shipping'] == 'Y')
            $products_array = array_merge($products_array, array('products_shippingtime' => $dataArray['p_shipping']));
        if ($this->FileSheme['p_sorting'] == 'Y')
            $products_array = array_merge($products_array, array('products_sort' => $dataArray['p_sorting']));

        if ($mode == 'insert') {
            $this->counter['prod_new']++;
            $products_array = array_merge($products_array, array('products_date_added' => date('Y-m-d H:i:s')));
            xtc_db_perform(TABLE_PRODUCTS, $products_array);
            $products_id = mysql_insert_id();
        } else {
            $this->counter['prod_upd']++;
            xtc_db_perform(TABLE_PRODUCTS, $products_array, 'update', 'products_model = \'' . addslashes($dataArray['p_model']) . '\'');
            $prod_query = xtc_db_query("SELECT products_id FROM " . TABLE_PRODUCTS . " WHERE products_model='" . addslashes($dataArray['p_model']) . "'");
            $prod_data = xtc_db_fetch_array($prod_query);
            $products_id = $prod_data['products_id'];
        }

        // Insert Group Prices.
        for ($i = 0; $i < count($this->Groups) - 1; $i++) {
            // seperate string ::
            if (isset($dataArray['p_priceNoTax.' . $this->Groups[$i + 1]['id']])) {
                $truncate_query = "DELETE FROM " . TABLE_PERSONAL_OFFERS_BY . $this->Groups[$i + 1]['id'] . " WHERE products_id='" . $prod_data['products_id'] . "'";
                xtc_db_query($truncate_query);
                $prices = $dataArray['p_priceNoTax.' . $this->Groups[$i + 1]['id']];
                $prices = explode('::', $prices);
                for ($ii = 0; $ii < count($prices); $ii++) {
                    $values = explode(':', $prices[$ii]);
                    $group_array = array('products_id' => $prod_data['products_id'], 'quantity' => $values[0], 'personal_offer' => $values[1]);

                    xtc_db_perform(TABLE_PERSONAL_OFFERS_BY . $this->Groups[$i + 1]['id'], $group_array);
                }
            }
        }

        // Insert Group Permissions.
        for ($i = 0; $i < count($this->Groups) - 1; $i++) {
            // seperate string ::
            if (isset($dataArray['p_groupAcc.' . $this->Groups[$i + 1]['id']])) {
                $insert_array = array('group_permission_' . $this->Groups[$i + 1]['id'] => $dataArray['p_groupAcc.' . $this->Groups[$i + 1]['id']]);
                xtc_db_perform(TABLE_PRODUCTS, $insert_array, 'update', 'products_id = \'' . $products_id . '\'');
            }
        }

        // insert images
        for ($i = 1; $i < MO_PICS + 1; $i++) {
            if (isset($dataArray['p_image.' . $i]) && $dataArray['p_image.' . $i] != "") {
                // check if entry exists
                if ($this->checkImage($i, $products_id)) {
                    $insert_array = array('image_name' => $dataArray['p_image.' . $i]);
                    xtc_db_perform(TABLE_PRODUCTS_IMAGES, $insert_array, 'update', 'products_id = \'' . $products_id . '\' AND image_nr=\'' . $i . '\'');
                } else {
                    $insert_array = array('image_name' => $dataArray['p_image.' . $i], 'image_nr' => $i, 'products_id' => $products_id);
                    xtc_db_perform(TABLE_PRODUCTS_IMAGES, $insert_array);
                }
            }
        }

        if ($touchCat)
            $this->insertCategory($dataArray, $mode, $products_id);
        for ($i_insert = 0; $i_insert < sizeof($this->languages); $i_insert++) {
            $prod_desc_array = array('products_id' => $products_id, 'language_id' => $this->languages[$i_insert]['id']);

            if ($this->FileSheme['p_name.' . $this->languages[$i_insert]['code']] == 'Y')
                $prod_desc_array = array_merge($prod_desc_array, array('products_name' => addslashes($dataArray['p_name.' . $this->languages[$i_insert]['code']])));
            if ($this->FileSheme['p_desc.' . $this->languages[$i_insert]['code']] == 'Y')
                $prod_desc_array = array_merge($prod_desc_array, array('products_description' => addslashes($dataArray['p_desc.' . $this->languages[$i_insert]['code']])));
            if ($this->FileSheme['p_shortdesc.' . $this->languages[$i_insert]['code']] == 'Y')
                $prod_desc_array = array_merge($prod_desc_array, array('products_short_description' => addslashes($dataArray['p_shortdesc.' . $this->languages[$i_insert]['code']])));
            if ($this->FileSheme['p_meta_title.' . $this->languages[$i_insert]['code']] == 'Y')
                $prod_desc_array = array_merge($prod_desc_array, array('products_meta_title' => $dataArray['p_meta_title.' . $this->languages[$i_insert]['code']]));
            if ($this->FileSheme['p_meta_desc.' . $this->languages[$i_insert]['code']] == 'Y')
                $prod_desc_array = array_merge($prod_desc_array, array('products_meta_description' => $dataArray['p_meta_desc.' . $this->languages[$i_insert]['code']]));
            if ($this->FileSheme['p_meta_key.' . $this->languages[$i_insert]['code']] == 'Y')
                $prod_desc_array = array_merge($prod_desc_array, array('products_meta_keywords' => $dataArray['p_meta_key.' . $this->languages[$i_insert]['code']]));
            if ($this->FileSheme['p_keywords.' . $this->languages[$i_insert]['code']] == 'Y')
                $prod_desc_array = array_merge($prod_desc_array, array('products_keywords' => $dataArray['p_keywords.' . $this->languages[$i_insert]['code']]));
            if ($this->FileSheme['p_url.' . $this->languages[$i_insert]['code']] == 'Y')
                $prod_desc_array = array_merge($prod_desc_array, array('products_url' => $dataArray['p_url.' . $this->languages[$i_insert]['code']]));

            if ($mode == 'insert') {
                xtc_db_perform(TABLE_PRODUCTS_DESCRIPTION, $prod_desc_array);
            } else {
                xtc_db_perform(TABLE_PRODUCTS_DESCRIPTION, $prod_desc_array, 'update', 'products_id = \'' . $products_id . '\' AND language_id=\'' . $this->languages[$i_insert]['id'] . '\'');
            }
        }
    }

    /**
     *   Match and insert Categories
     *   @param array $dataArray data array
     *   @param string $mode insert mode
     *   @param int $pID  products ID
     */
    function insertCategory(& $dataArray, $mode = 'insert', $pID) {
        if ($this->debug) {
            echo '<pre>';
            print_r($this->CatTree);
            echo '</pre>';
        }
        $cat = array();
        $catTree = '';
        for ($i = 0; $i < $this->catDepth; $i++)
            if (trim($dataArray['p_cat.' . $i]) != '') {
                $cat[$i] = trim($dataArray['p_cat.' . $i]);
                $catTree .= '[\'' . addslashes($cat[$i]) . '\']';
            }
        $code = '$ID=$this->CatTree' . $catTree . '[\'ID\'];';
        if ($this->debug)
            echo $code;
        eval($code);

        if (is_int($ID) || $ID == '0') {
            $this->insertPtoCconnection($pID, $ID);
        } else {

            $catTree = '';
            $parTree = '';
            $curr_ID = 0;
            for ($i = 0; $i < count($cat); $i++) {

                $catTree .= '[\'' . addslashes($cat[$i]) . '\']';

                $code = '$ID=$this->CatTree' . $catTree . '[\'ID\'];';
                eval($code);
                if (is_int($ID) || $ID == '0') {
                    $curr_ID = $ID;
                } else {

                    $code = '$parent=$this->CatTree' . $parTree . '[\'ID\'];';
                    eval($code);
                    // check if categorie exists
                    $cat_query = xtc_db_query("SELECT c.categories_id FROM " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
												WHERE
												cd.categories_name='" . addslashes($cat[$i]) . "'
												AND cd.language_id='" . $this->languages[0]['id'] . "'
												AND cd.categories_id=c.categories_id
												AND parent_id='" . $parent . "'");

                    if (!xtc_db_num_rows($cat_query)) { // insert categorie
                        $categorie_data = array('parent_id' => $parent, 'categories_status' => 1, 'date_added' => 'now()', 'last_modified' => 'now()');

                        xtc_db_perform(TABLE_CATEGORIES, $categorie_data);
                        $cat_id = mysql_insert_id();
                        $this->counter['cat_new']++;
                        $code = '$this->CatTree' . $parTree . '[\'' . addslashes($cat[$i]) . '\'][\'ID\']=' . $cat_id . ';';
                        eval($code);
                        $parent = $cat_id;
                        for ($i_insert = 0; $i_insert < sizeof($this->languages); $i_insert++) {
                            $categorie_data = array('language_id' => $this->languages[$i_insert]['id'], 'categories_id' => $cat_id, 'categories_name' => $cat[$i]);
                            xtc_db_perform(TABLE_CATEGORIES_DESCRIPTION, $categorie_data);
                        }
                    } else {
                        $this->counter['cat_touched']++;
                        $cData = xtc_db_fetch_array($cat_query);
                        $cat_id = $cData['categories_id'];
                        $code = '$this->CatTree' . $parTree . '[\'' . addslashes($cat[$i]) . '\'][\'ID\']=' . $cat_id . ';';
                        eval($code);
                    }
                }
                $parTree = $catTree;
            }
            $this->insertPtoCconnection($pID, $cat_id);
        }
    }

    /**
     *   Insert products to categories connection
     *   @param int $pID products ID
     *   @param int $cID categories ID
     */
    function insertPtoCconnection($pID, $cID) {
        $prod2cat_query = xtc_db_query("SELECT *
											FROM " . TABLE_PRODUCTS_TO_CATEGORIES . "
											WHERE
											categories_id='" . $cID . "'
											AND products_id='" . $pID . "'");

        if (!xtc_db_num_rows($prod2cat_query)) {
            $insert_data = array('products_id' => $pID, 'categories_id' => $cID);

            xtc_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $insert_data);
        }
    }

    /**
     *   Parse Inputfile until next line
     *   @param int $line taxrate in percent
     *   @param string $file_content taxrate in percent
     *   @param int $max_lines taxrate in percent
     *   @return array
     */
    function get_line_content($line, $file_content, $max_lines) {
        // get first line
        $line_data = array();
        $line_data['data'] = $file_content[$line];
        $lc = 1;
        // check if next line got ; in first 50 chars
        while (!strstr(substr($file_content[$line + $lc], 0, 6), 'XTSOL') && $line + $lc <= $max_lines) {
            $line_data['data'] .= $file_content[$line + $lc];
            $lc++;
        }
        $line_data['skip'] = $lc - 1;
        return $line_data;
    }

    /**
     *   Calculate Elapsed time from 2 given Timestamps
     *   @param int $time old timestamp
     *   @return String elapsed time
     */
    function calcElapsedTime($time) {

        // calculate elapsed time (in seconds!)
        $diff = time() - $time;
        $daysDiff = 0;
        $hrsDiff = 0;
        $minsDiff = 0;
        $secsDiff = 0;

        $sec_in_a_day = 60 * 60 * 24;
        while ($diff >= $sec_in_a_day) {
            $daysDiff++;
            $diff -= $sec_in_a_day;
        }
        $sec_in_an_hour = 60 * 60;
        while ($diff >= $sec_in_an_hour) {
            $hrsDiff++;
            $diff -= $sec_in_an_hour;
        }
        $sec_in_a_min = 60;
        while ($diff >= $sec_in_a_min) {
            $minsDiff++;
            $diff -= $sec_in_a_min;
        }
        $secsDiff = $diff;

        return ('(elapsed time ' . $hrsDiff . 'h ' . $minsDiff . 'm ' . $secsDiff . 's)');
    }

    /**
     *   Get manufacturers
     *   @return array
     */
    function get_mfn() {
        $mfn_query = xtc_db_query("SELECT manufacturers_id, manufacturers_name FROM " . TABLE_MANUFACTURERS);
        while ($mfn = xtc_db_fetch_array($mfn_query)) {
            $mfn_array[$mfn['manufacturers_name']] = array('id' => $mfn['manufacturers_id']);
        }
        return $mfn_array;
    }

}

// EXPORT

class xtcExport {

    function xtcExport($filename) {
        $this->catDepth = 6;
        $this->languages = $this->get_lang();
        $this->filename = $filename;
        $this->CAT = array();
        $this->PARENT = array();
        $this->counter = array('prod_exp' => 0);
        $this->time_start = time();
        $this->man = $this->getManufacturers();
        $this->TextSign = CSV_TEXTSIGN;
        $this->seperator = CSV_SEPERATOR;
        if (CSV_SEPERATOR == '')
            $this->seperator = "\t";
        if (CSV_SEPERATOR == '\t')
            $this->seperator = "\t";
        $this->Groups = xtc_get_customers_statuses();
    }

    /**
     *   Get installed languages
     *   @return array
     */
    function get_lang() {

        $languages_query = xtc_db_query("SELECT languages_id, name, code, image, directory FROM " . TABLE_LANGUAGES);
        while ($languages = xtc_db_fetch_array($languages_query)) {
            $languages_array[] = array('id' => $languages['languages_id'], 'name' => $languages['name'], 'code' => $languages['code']);
        }

        return $languages_array;
    }

    function exportProdFile() {

        $fp = fopen(DIR_FS_DOCUMENT_ROOT . 'export/' . $this->filename, "w+");
        $heading = $this->TextSign . 'XTSOL' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_model' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_stock' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_sorting' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_shipping' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_tpl' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_manufacturer' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_fsk18' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_priceNoTax' . $this->TextSign . $this->seperator;
        for ($i = 0; $i < count($this->Groups) - 1; $i++) {
            $heading .= $this->TextSign . 'p_priceNoTax.' . $this->Groups[$i + 1]['id'] . $this->TextSign . $this->seperator;
        }
        if (GROUP_CHECK == 'true') {
            for ($i = 0; $i < count($this->Groups) - 1; $i++) {
                $heading .= $this->TextSign . 'p_groupAcc.' . $this->Groups[$i + 1]['id'] . $this->TextSign . $this->seperator;
            }
        }
        $heading .= $this->TextSign . 'p_tax' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_status' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_weight' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_ean' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_disc' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_opttpl' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_vpe' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_vpe_status' . $this->TextSign . $this->seperator;
        $heading .= $this->TextSign . 'p_vpe_value' . $this->TextSign . $this->seperator;
        // product images

        for ($i = 1; $i < MO_PICS + 1; $i++) {
            $heading .= $this->TextSign . 'p_image.' . $i . $this->TextSign . $this->seperator;
            ;
        }

        $heading .= $this->TextSign . 'p_image' . $this->TextSign;

        // add lang fields
        for ($i = 0; $i < sizeof($this->languages); $i++) {
            $heading .= $this->seperator . $this->TextSign;
            $heading .= 'p_name.' . $this->languages[$i]['code'] . $this->TextSign . $this->seperator;
            $heading .= $this->TextSign . 'p_desc.' . $this->languages[$i]['code'] . $this->TextSign . $this->seperator;
            $heading .= $this->TextSign . 'p_shortdesc.' . $this->languages[$i]['code'] . $this->TextSign . $this->seperator;
            $heading .= $this->TextSign . 'p_meta_title.' . $this->languages[$i]['code'] . $this->TextSign . $this->seperator;
            $heading .= $this->TextSign . 'p_meta_desc.' . $this->languages[$i]['code'] . $this->TextSign . $this->seperator;
            $heading .= $this->TextSign . 'p_meta_key.' . $this->languages[$i]['code'] . $this->TextSign . $this->seperator;
            $heading .= $this->TextSign . 'p_keywords.' . $this->languages[$i]['code'] . $this->TextSign . $this->seperator;
            $heading .= $this->TextSign . 'p_url.' . $this->languages[$i]['code'] . $this->TextSign;
        }
        // add categorie fields
        for ($i = 0; $i < $this->catDepth; $i++)
            $heading .= $this->seperator . $this->TextSign . 'p_cat.' . $i . $this->TextSign;

        $heading .= "\n";

        fputs($fp, $heading);
        // content
        $export_query = xtc_db_query("SELECT
											 *
										 FROM
											 " . TABLE_PRODUCTS);

        while ($export_data = xtc_db_fetch_array($export_query)) {

            $this->counter['prod_exp']++;
            $line = $this->TextSign . 'XTSOL' . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['products_model'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['products_quantity'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['products_sort'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['products_shippingtime'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['product_template'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $this->man[$export_data['manufacturers_id']] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['products_fsk18'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['products_price'] . $this->TextSign . $this->seperator;
            // group prices  Qantity:Price::Quantity:Price
            for ($i = 0; $i < count($this->Groups) - 1; $i++) {
                $price_query = "SELECT * FROM " . TABLE_PERSONAL_OFFERS_BY . $this->Groups[$i + 1]['id'] . " WHERE products_id = '" . $export_data['products_id'] . "'ORDER BY quantity";
                $price_query = xtc_db_query($price_query);
                $groupPrice = '';
                while ($price_data = xtc_db_fetch_array($price_query)) {
                    if ($price_data['personal_offer'] > 0) {
                        $groupPrice .= $price_data['quantity'] . ':' . $price_data['personal_offer'] . '::';
                    }
                }
                $groupPrice .= ':';
                $groupPrice = str_replace(':::', '', $groupPrice);
                if ($groupPrice == ':')
                    $groupPrice = "";
                $line .= $this->TextSign . $groupPrice . $this->TextSign . $this->seperator;
            }

            // group permissions
            if (GROUP_CHECK == 'true') {
                for ($i = 0; $i < count($this->Groups) - 1; $i++) {
                    $line .= $this->TextSign . $lang_data['group_permission_' . $this->Groups[$i + 1]['id']] . $this->TextSign . $this->seperator;
                }
            }

            $line .= $this->TextSign . $export_data['products_tax_class_id'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['products_status'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['products_weight'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['products_ean'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['products_discount_allowed'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['options_template'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['products_vpe'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['products_vpe_status'] . $this->TextSign . $this->seperator;
            $line .= $this->TextSign . $export_data['products_vpe_value'] . $this->TextSign . $this->seperator;

            if (MO_PICS > 0) {
                $mo_query = "SELECT * FROM " . TABLE_PRODUCTS_IMAGES . " WHERE products_id='" . $export_data['products_id'] . "'";
                $mo_query = xtc_db_query($mo_query);
                $img = array();
                while ($mo_data = xtc_db_fetch_array($mo_query)) {
                    $img[$mo_data['image_nr']] = $mo_data['image_name'];
                }
            }

            // product images
            for ($i = 1; $i < MO_PICS + 1; $i++) {
                if (isset($img[$i])) {
                    $line .= $this->TextSign . $img[$i] . $this->TextSign . $this->seperator;
                } else {
                    $line .= $this->TextSign . "" . $this->TextSign . $this->seperator;
                }
            }

            $line .= $this->TextSign . $export_data['products_image'] . $this->TextSign . $this->seperator;

            for ($i = 0; $i < sizeof($this->languages); $i++) {
                $lang_query = xtc_db_query("SELECT * FROM " . TABLE_PRODUCTS_DESCRIPTION . " WHERE language_id='" . $this->languages[$i]['id'] . "' and products_id='" . $export_data['products_id'] . "'");
                $lang_data = xtc_db_fetch_array($lang_query);
                $lang_data['products_description'] = str_replace("\n", "", $lang_data['products_description']);
                $lang_data['products_short_description'] = str_replace("\n", "", $lang_data['products_short_description']);
                $lang_data['products_description'] = str_replace("\r", "", $lang_data['products_description']);
                $lang_data['products_short_description'] = str_replace("\r", "", $lang_data['products_short_description']);
                $lang_data['products_description'] = str_replace(chr(13), "", $lang_data['products_description']);
                $lang_data['products_short_description'] = str_replace(chr(13), "", $lang_data['products_short_description']);
                $line .= $this->TextSign . stripslashes($lang_data['products_name']) . $this->TextSign . $this->seperator;
                $line .= $this->TextSign . stripslashes($lang_data['products_description']) . $this->TextSign . $this->seperator;
                $line .= $this->TextSign . stripslashes($lang_data['products_short_description']) . $this->TextSign . $this->seperator;
                $line .= $this->TextSign . stripslashes($lang_data['products_meta_title']) . $this->TextSign . $this->seperator;
                $line .= $this->TextSign . stripslashes($lang_data['products_meta_description']) . $this->TextSign . $this->seperator;
                $line .= $this->TextSign . stripslashes($lang_data['products_meta_keywords']) . $this->TextSign . $this->seperator;
                $line .= $this->TextSign . stripslashes($lang_data['products_keywords']) . $this->TextSign . $this->seperator;
                $line .= $this->TextSign . $lang_data['products_url'] . $this->TextSign . $this->seperator;
            }
            $cat_query = xtc_db_query("SELECT categories_id FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " WHERE products_id='" . $export_data['products_id'] . "'");
            $cat_data = xtc_db_fetch_array($cat_query);

            $line .= $this->buildCAT($cat_data['categories_id']);
            $line .= $this->TextSign;
            $line .= "\n";
            fputs($fp, $line);
        }

        fclose($fp);
        /*
          if (COMPRESS_EXPORT=='true') {
          $backup_file = DIR_FS_DOCUMENT_ROOT.'export/' . $this->filename;
          exec(LOCAL_EXE_ZIP . ' -j ' . $backup_file . '.zip ' . $backup_file);
          unlink($backup_file);
          }
         */
        return array(0 => $this->counter, 1 => '', 2 => $this->calcElapsedTime($this->time_start));
    }

    /**
     *   Calculate Elapsed time from 2 given Timestamps
     *   @param int $time old timestamp
     *   @return String elapsed time
     */
    function calcElapsedTime($time) {

        $diff = time() - $time;
        $daysDiff = 0;
        $hrsDiff = 0;
        $minsDiff = 0;
        $secsDiff = 0;

        $sec_in_a_day = 60 * 60 * 24;
        while ($diff >= $sec_in_a_day) {
            $daysDiff++;
            $diff -= $sec_in_a_day;
        }
        $sec_in_an_hour = 60 * 60;
        while ($diff >= $sec_in_an_hour) {
            $hrsDiff++;
            $diff -= $sec_in_an_hour;
        }
        $sec_in_a_min = 60;
        while ($diff >= $sec_in_a_min) {
            $minsDiff++;
            $diff -= $sec_in_a_min;
        }
        $secsDiff = $diff;

        return ('(elapsed time ' . $hrsDiff . 'h ' . $minsDiff . 'm ' . $secsDiff . 's)');
    }

    function buildCAT($catID) {

        if (isset($this->CAT[$catID])) {
            return $this->CAT[$catID];
        } else {
            $cat = array();
            $tmpID = $catID;

            while ($this->getParent($catID) != 0 || $catID != 0) {
                $cat_select = xtc_db_query("SELECT categories_name FROM " . TABLE_CATEGORIES_DESCRIPTION . " WHERE categories_id='" . $catID . "' AND language_id='" . $this->languages[0]['id'] . "'");
                $cat_data = xtc_db_fetch_array($cat_select);
                $catID = $this->getParent($catID);
                $cat[] = $cat_data['categories_name'];
            }
            $catFiller = '';
            for ($i = $this->catDepth - count($cat); $i > 0; $i--) {
                $catFiller .= $this->TextSign . $this->TextSign . $this->seperator;
            }
            $catFiller .= $this->TextSign;
            $catStr = '';
            for ($i = count($cat); $i > 0; $i--) {
                $catStr .= $this->TextSign . $cat[$i - 1] . $this->TextSign . $this->seperator;
            }
            $this->CAT[$tmpID] = $catStr . $catFiller;
            return $this->CAT[$tmpID];
        }
    }

    /**
     *   Get the tax_class_id to a given %rate
     *   @return array
     */
    function getTaxRates() { // must be optimazed (pre caching array)
        $tax = array();
        $tax_query = xtc_db_query("SELECT
									  tr.tax_class_id,
									  tr.tax_rate,
									  ztz.geo_zone_id
									  FROM
									  " . TABLE_TAX_RATES . " tr,
									  " . TABLE_ZONES_TO_GEO_ZONES . " ztz
									  WHERE
									  ztz.zone_country_id='" . STORE_COUNTRY . "'
									  AND tr.tax_zone_id=ztz.geo_zone_id
										                                      ");
        while ($tax_data = xtc_db_fetch_array($tax_query)) {

            $tax[$tax_data['tax_class_id']] = $tax_data['tax_rate'];
        }
        return $tax;
    }

    /**
     *   Prefetch Manufactrers
     *   @return array
     */
    function getManufacturers() {
        $man = array();
        $man_query = xtc_db_query("SELECT
									manufacturers_name,manufacturers_id 
									FROM
									" . TABLE_MANUFACTURERS);
        while ($man_data = xtc_db_fetch_array($man_query)) {
            $man[$man_data['manufacturers_id']] = $man_data['manufacturers_name'];
        }
        return $man;
    }

    /**
     *   Return Parent ID for a given categories id
     *   @return int
     */
    function getParent($catID) {
        if (isset($this->PARENT[$catID])) {
            return $this->PARENT[$catID];
        } else {
            $parent_query = xtc_db_query("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE categories_id='" . $catID . "'");
            $parent_data = xtc_db_fetch_array($parent_query);
            $this->PARENT[$catID] = $parent_data['parent_id'];
            return $parent_data['parent_id'];
        }
    }

}

class ordersExport {

    function ordersExport($filename) {

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        print $this->getOrders();
    }

    function getOrders() {
        $sql = "SELECT 
					o.orders_id, 
					o.orders_status, 
					o.date_purchased,
					o.customers_cid, 
					o.billing_name,
					o.billing_country,
					c.customers_vat_id, 
					o.payment_method, 					
					opdf.pdf_bill_nr, 
					opdf.pdf_generate_date, 
					os.orders_status_name, 
					ot.text
				FROM 
					orders AS o
				LEFT JOIN orders_status AS os ON (o.orders_status = os.orders_status_id AND os.language_id = 1)
				LEFT JOIN orders_pdf AS opdf ON (o.orders_id = opdf.order_id)
				LEFT JOIN orders_total AS ot ON (o.orders_id = ot.orders_id)
				LEFT JOIN customers AS c ON (o.customers_id = c.customers_id )
				WHERE 
					ot.class = 'ot_subtotal'
				AND 
					o.date_purchased LIKE '" . $_SESSION['jahr'] . "-" . $_SESSION['monat'] . "%' 
				ORDER BY o.orders_id ASC";

//Alles ausgeben

        $data = "Bestellung Nr.;Bestelldatum;Rechnungs-Nr.;Rechnungs-Datum;Kunden-Nr.;Kundenname;Land;UST-ID;Bezahlart;Status;Summe Netto;Versand Netto;Nachnahme Netto;UST.;Rechnungsbetrag Brutto\n";

        $export_query = xtc_db_query($sql);

        while ($export_data = xtc_db_fetch_array($export_query)) {
//Summe Netto ermitteln
            $sql_netto_total = xtc_db_fetch_array(xtc_db_query("SELECT 
					value
				FROM 
					orders_total
				WHERE 
					class = 'ot_total'
				AND 
					orders_id = '" . $export_data['orders_id'] . "'"));
// Ist HГ¤ndler ohne MwSt.

            $sql_subtotal_no_tax = xtc_db_fetch_array(xtc_db_query("SELECT 
					value
				FROM 
					orders_total
				WHERE 
					class = 'ot_subtotal_no_tax'
				AND 
					orders_id = '" . $export_data['orders_id'] . "'"));

//gesamte MwSt. Feld ermitteln

            $sql_netto_tax = xtc_db_fetch_array(xtc_db_query("SELECT 
					value
				FROM 
					orders_total
				WHERE 
					class = 'ot_tax'
				AND 
					orders_id = '" . $export_data['orders_id'] . "'"));

//Versand Netto ermitteln
            $sql_shipping_netto = xtc_db_fetch_array(xtc_db_query("SELECT 
					value
				FROM 
					orders_total
				WHERE 
					class = 'ot_shipping'
				AND 
					orders_id = '" . $export_data['orders_id'] . "'"));

            if ($sql_subtotal_no_tax['value'] == '') {
                $sql_shipping_netto_ohne_tax = $sql_shipping_netto['value'] / 119 * 100;
                $sql_shipping_netto_format = number_format($sql_shipping_netto_ohne_tax, 2, ',', '');
            } else {
                $sql_shipping_netto_format = number_format($sql_shipping_netto['value'], 2, ',', '');
            }

//Nachnahme Netto ermitteln
            $sql_fee_netto = xtc_db_fetch_array(xtc_db_query("SELECT 
					value
				FROM 
					orders_total
				WHERE 
					class = 'ot_cod_fee'
				AND 
					orders_id = '" . $export_data['orders_id'] . "'"));

            if ($sql_subtotal_no_tax['value'] == '') {
                $sql_fee_netto_format_ohne_tax = $sql_fee_netto['value'] / 119 * 100;
                $sql_fee_netto_format = number_format($sql_fee_netto_format_ohne_tax, 2, ',', '');
            } else {
                $sql_fee_netto_format = number_format($sql_fee_netto['value'], 2, ',', '');
            }

//UST ermitteln
            $sql_ust_netto = xtc_db_fetch_array(xtc_db_query("SELECT 
					value
				FROM 
					orders_total
				WHERE 
					class = 'ot_tax'
				AND 
					orders_id = '" . $export_data['orders_id'] . "'"));

            $sql_ust_netto_format = number_format($sql_ust_netto['value'], 2, ',', '');

//Brutto gesamt ermitteln
            $sql_total_brutto = xtc_db_fetch_array(xtc_db_query("SELECT 
					value
				FROM 
					orders_total
				WHERE 
					class = 'ot_total'
				AND 
					orders_id = '" . $export_data['orders_id'] . "'"));

//Ausgabe Summe Netto

            $sql_summ_products = xtc_db_fetch_array(xtc_db_query("SELECT 
						SUM(final_price) AS sumfinal, 
						allow_tax
					FROM 
						orders_products
					WHERE 
						orders_id = '" . $export_data['orders_id'] . "'"));

            $sql_rabatt = xtc_db_fetch_array(xtc_db_query("SELECT 
					value
				FROM 
					orders_total
				WHERE 
					class = 'ot_payment'
				AND 
					orders_id = '" . $export_data['orders_id'] . "'"));

            if ($sql_subtotal_no_tax['value'] != '') {
                $rabatt = $sql_rabatt['value'];
            } else {
                $rabatt = $sql_rabatt['value'] / 119 * 100;
            }

            if ($sql_subtotal_no_tax['value'] != '' || $sql_summ_products['allow_tax'] == 0) {
                $sum_netto_price = $sql_summ_products['sumfinal'] + $rabatt;
                $sum_netto_price_format = number_format($sum_netto_price, 2, ',', '');
                $sum_netto = $sum_netto_price_format;
            } else {
                #$sum_netto_price = ($sql_summ_products['sumfinal']/119*100)+$rabatt;
                #$sum_netto_price_format = number_format($sum_netto_price, 2, ',', '');
                $brutto_tmp = $sql_total_brutto['value'];
                $ust_tmp = $brutto_tmp / 1.19 * 0.19;
                $ust_tmp = round($ust_tmp, 2);
                $sum_tmp = $brutto_tmp - $ust_tmp - $sql_shipping_netto_ohne_tax - $sql_fee_netto_format_ohne_tax;
                $sum_netto_price_format = number_format($sum_tmp, 2, ',', '');
                $sum_netto = $sum_netto_price_format;
            }

            $sql_total_brutto_format = number_format($sql_total_brutto['value'], 2, ',', '');

            include_once (DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $export_data['payment_method'] . '.php');
            $payment_method_plain = constant(strtoupper('MODULE_PAYMENT_' . $export_data['payment_method'] . '_TEXT_TITLE'));
            $payment_method = html_entity_decode($payment_method_plain);

            $oder_date_format = new DateTime($export_data['date_purchased']);
            $oder_date_format = $oder_date_format->format("d.m.Y");

            $line = $export_data['orders_id'] . ';' . $oder_date_format . ';' . $export_data['pdf_bill_nr'] . ';' . $export_data['pdf_generate_date'] . ';' . $export_data['customers_cid'] . ';' . utf8_decode($export_data['billing_name']) . ';' . utf8_decode($export_data['billing_country']) . ';' . $export_data['customers_vat_id'] . ';' . $payment_method . ';' . utf8_decode($export_data['orders_status_name']) . ';' . $sum_netto . ';' . $sql_shipping_netto_format . ';' . $sql_fee_netto_format . ';' . $sql_ust_netto_format . ';' . $sql_total_brutto_format . "\n";
            $data .= $line;
        }

        return $data;
    }

}

