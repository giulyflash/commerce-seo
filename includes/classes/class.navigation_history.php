<?php
/*-----------------------------------------------------------------
* 	$Id: class.navigation_history.php 397 2013-06-17 19:36:21Z akausch $
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




  class navigationHistory {
    var $path, $snapshot;

    function navigationHistory() {
      $this->reset();
    }

    function reset() {
      $this->path = array();
      $this->snapshot = array();
    }

    function add_current_page() {
      global $PHP_SELF, $cPath;

      $set = 'true';
      for ($i=0, $n=sizeof($this->path); $i<$n; $i++) {
        if ( ($this->path[$i]['page'] == basename($_SERVER['SCRIPT_NAME'])) ) {
          if (isset($cPath)) {
            if (!isset($this->path[$i]['get']['cPath'])) {
              continue;
            } else {
              if ($this->path[$i]['get']['cPath'] == $cPath) {
                array_splice($this->path, ($i+1));
                $set = 'false';
                break;
              } else {
                $old_cPath = explode('_', $this->path[$i]['get']['cPath']);
                $new_cPath = explode('_', $cPath);

                for ($j=0, $n2=sizeof($old_cPath); $j<$n2; $j++) {
                  if ($old_cPath[$j] != $new_cPath[$j]) {
                    array_splice($this->path, ($i));
                    $set = 'true';
                    break 2;
                  }
                }
              }
            }
          } else {
            array_splice($this->path, ($i));
            $set = 'true';
            break;
          }
        }
      }

      if ($set == 'true') {
        $this->path[] = array('page' => basename($_SERVER['SCRIPT_NAME']),
                              'mode' => (($_SERVER['HTTPS'] == 'on') ? 'SSL' : 'NONSSL'),
                              'get' => $_GET,
                              'post' => $_POST);
      }
    }

    function remove_current_page() {
      global $PHP_SELF;

      $last_entry_position = sizeof($this->path) - 1;
      if ($this->path[$last_entry_position]['page'] == basename($_SERVER['SCRIPT_NAME'])) {
        unset($this->path[$last_entry_position]);
      }
    }

    function set_snapshot($page = '') {
      global $PHP_SELF;

      if (is_array($page)) {
        $this->snapshot = array('page' => $page['page'],
                                'mode' => $page['mode'],
                                'get' => $page['get'],
                                'post' => $page['post']);
      } else {
        $this->snapshot = array('page' => basename($_SERVER['SCRIPT_NAME']),
                                'mode' => (($_SERVER['HTTPS'] == 'on') ? 'SSL' : 'NONSSL'),
                                'get' => $_GET,
                                'post' => $_POST);
      }
    }

    function clear_snapshot() {
      $this->snapshot = array();
    }

    function set_path_as_snapshot($history = 0) {
      $pos = (sizeof($this->path)-1-$history);
      $this->snapshot = array('page' => $this->path[$pos]['page'],
                              'mode' => $this->path[$pos]['mode'],
                              'get' => $this->path[$pos]['get'],
                              'post' => $this->path[$pos]['post']);
    }

    function debug() {
      for ($i=0, $n=sizeof($this->path); $i<$n; $i++) {
        echo $this->path[$i]['page'] . '?';
        while (list($key, $value) = each($this->path[$i]['get'])) {
          echo $key . '=' . $value . '&';
        }
        if (sizeof($this->path[$i]['post']) > 0) {
          echo '<br />';
          while (list($key, $value) = each($this->path[$i]['post'])) {
            echo '&nbsp;&nbsp;<b>' . $key . '=' . $value . '</b><br />';
          }
        }
        echo '<br />';
      }

      if (sizeof($this->snapshot) > 0) {
        echo '<br /><br />';

        echo $this->snapshot['mode'] . ' ' . $this->snapshot['page'] . '?' . xtc_array_to_string($this->snapshot['get'], array(xtc_session_name())) . '<br />';
      }
    }

    function unserialize($broken) {
      for(reset($broken);$kv=each($broken);) {
        $key=$kv['key'];
        if (gettype($this->$key)!="user function")
        $this->$key=$kv['value'];
      }
    }
  }
?>