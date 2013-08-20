<?php
require('../../includes/configure.php');

$connect = mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
mysql_select_db(DB_DATABASE);

$zones_query = mysql_query("SELECT zone_id,zone_name FROM zones WHERE zone_country_id = '" . (int)$_GET['land'] . "' ORDER BY zone_name");
if(mysql_num_rows($zones_query)) {
	$zones_array = array();
	$select = '<select style="width: 224px;" name="STATE">';
	while ($zones_values = mysql_fetch_array($zones_query)) {
		$select .= '<option value="'.$zones_values['zone_id'].'">'.$zones_values['zone_name'].'</option>';
	}
	$select .= '</select><span style="color:#EB5E00">*</span>';
} else {
	$select = 'dieses Land hat keine Bundesl&auml;nder/Bundesstaaten';
}
echo $select;
?>