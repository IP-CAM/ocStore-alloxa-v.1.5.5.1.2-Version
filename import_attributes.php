<?php 

// Configuration
if (file_exists('config.php')) {
	require_once('config.php');
}  
require_once(DIR_SYSTEM . 'library/db.php');

$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$attributes = $db->query("select * from new__products_params");

foreach ($attributes->rows as $attribute) {
	$attribute_group_id = $db->query("select new_id from new__products_params_cats where id = " . $attribute['id_cat']);
	if (!$attribute_group_id->row['new_id']) {
		$attribute_group_id = 30;
	} else {
		$attribute_group_id = $attribute_group_id->row['new_id'];
	}
	$db->query("insert into " . DB_PREFIX . "attribute (attribute_group_id, sort_order) values (" . $attribute_group_id . ", 0) ");
	$last_id = $db->getLastId();
	$db->query("insert into " . DB_PREFIX . "attribute_description (attribute_id, language_id, name, f_name) values (" . $last_id . ", 1, '" . $attribute['name'] . "', '" . $attribute['filter_name'] . "') ");
	$db->query("update new__products_params set new_id = " . $last_id . " where id = " . $attribute['id']);
}

?>