<?php 

// Configuration
if (file_exists('config.php')) {
	require_once('config.php');
}  
require_once(DIR_SYSTEM . 'library/db.php');

$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$categories = $db->query("select * from new__products_params_cats");

foreach ($categories->rows as $value) {
	$db->query("insert into " . DB_PREFIX . "attribute_group (sort_order) values (0) ");
	$last_id = $db->getLastId();
	$db->query("insert into " . DB_PREFIX . "attribute_group_description (attribute_group_id, language_id, name) values (" . $last_id . ", 1, '" . $value['name'] . "') ");
	$db->query("update new__products_params_cats set new_id = " . $last_id . " where id = " . $value['id']);
}

?>