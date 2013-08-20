<?php
/*-----------------------------------------------------------------
* 	$Id: class.message_stack.php 397 2013-06-17 19:36:21Z akausch $
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

class messageStack extends tableBox {
// class constructor
	function messageStack() {

	  $this->messages = array();

	  if (isset($_SESSION['messageToStack'])) {
		for ($i=0, $n=sizeof($_SESSION['messageToStack']); $i<$n; $i++) {
		  $this->add($_SESSION['messageToStack'][$i]['class'], $_SESSION['messageToStack'][$i]['text'], $_SESSION['messageToStack'][$i]['type']);
		}
		unset($_SESSION['messageToStack']);
	  }
	}

	// class methods
	function add($class, $message, $type = 'error') {
	  if ($type == 'error') {
		$this->messages[] = array('params' => 'class="messageStackError"', 'class' => $class, 'text' => xtc_image(DIR_WS_ICONS . 'error.gif', ICON_ERROR) . '&nbsp;' . $message);
	  } elseif ($type == 'warning') {
		$this->messages[] = array('params' => 'class="messageStackWarning"', 'class' => $class, 'text' => xtc_image(DIR_WS_ICONS . 'warning.gif', ICON_WARNING) . '&nbsp;' . $message);
	  } elseif ($type == 'success') {
		$this->messages[] = array('params' => 'class="messageStackSuccess"', 'class' => $class, 'text' => xtc_image(DIR_WS_ICONS . 'success.gif', ICON_SUCCESS) . '&nbsp;' . $message);
	  } else {
		$this->messages[] = array('params' => 'class="messageStackError"', 'class' => $class, 'text' => $message);
	  }
	}

	function add_session($class, $message, $type = 'error') {

	  if (!isset($_SESSION['messageToStack'])) {
		$_SESSION['messageToStack'] = array();
	  }

	  $_SESSION['messageToStack'][] = array('class' => $class, 'text' => $message, 'type' => $type);
	}

	function reset() {
	  $this->messages = array();
	}

	function output($class) {
	  $this->table_data_parameters = 'class="messageBox"';

	  $output = array();
	  for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
		if ($this->messages[$i]['class'] == $class) {
		  $output[] = $this->messages[$i];
		}
	  }

	  return $this->tableBox($output);
	}

	function size($class) {
	  $count = 0;

	  for ($i=0, $n=sizeof($this->messages); $i<$n; $i++) {
		if ($this->messages[$i]['class'] == $class) {
		  $count++;
		}
	  }

	  return $count;
	}
}
?>