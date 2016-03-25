<?php 
ini_set('display_errors', 1);
// Configuration
if (file_exists('config.php')) {
	require_once('config.php');
}  
require_once(DIR_SYSTEM . 'library/db.php');

$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$attrs = $db->query("select ad.name as attribute_name, ad.f_name as attribute_filter_name, pa.text, pa.product_id from oc_product_attribute pa left join oc_attribute_description ad on (pa.attribute_id = ad.attribute_id) where pa.text like '%++%'");
$i = 0;
$j = 0;
foreach ($attrs->rows as $attr) {
	$i++;
	$attr_name = strlen($attr['attribute_name']) > strlen($attr['attribute_filter_name']) ? $attr['attribute_filter_name'] : $attr['attribute_name'];
	$texts = explode('++', $attr['text']);
	foreach ($texts as $text) {
		$j++;
		$return_data = checkOption(array('select', $attr_name, $text));
		$product_option_id = checkProductOption($attr['product_id'], $return_data['option_id'], $text);
		$db->query("INSERT INTO " . DB_PREFIX . "product_option_value (`product_option_id`, `product_id`, `option_id`, `option_value_id`, `quantity`, `subtract`, `price`, `price_prefix`, `points`, `points_prefix`, `weight`, `weight_prefix`) VALUES (" . (int)$product_option_id . ", " . (int)$attr['product_id'] . ", " . (int)$return_data['option_id'] . ", " . (int)$return_data['option_value_id'] . ", 0, 0, 0, '+', 0, '+', 0, '+')");
	}
}

echo 'Аттрибуты - ' . $i . '. Значения опций - ' . $j . '.';

function checkProductOption($product_id, $option_id, $required) {
	global $db;
	$query = $db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE product_id = " . (int)$product_id . " AND option_id = " . (int)$option_id);

	if (!empty($query->row)) {
		return $query->row['product_option_id'];
	} else {
		return addProductOption($product_id, $option_id, $required);
	}
}

function addProductOption($product_id, $option_id, $required) {
	global $db;
	$db->query("INSERT INTO " . DB_PREFIX . "product_option (`product_id`, `option_id`, `required`) VALUES (" . (int)$product_id . ", " . (int)$option_id . ", " . (int)$required . ")");

	return $db->getLastId();
}

function checkOption($option_data) {
	global $db;
	$query = $db->query("SELECT * FROM " . DB_PREFIX . "option o LEFT JOIN " . DB_PREFIX . "option_description od ON (od.option_id = o.option_id) WHERE od.name LIKE '" . $db->escape($option_data[1]) . "' AND od.language_id = 1 AND o.type LIKE '" . $db->escape($option_data[0]) . "'");

	if (!empty($query->row)) {
		$return_data['option_id'] = $query->row['option_id'];
		$return_data['option_value_id'] = checkOptionValue($option_data, $return_data['option_id']);
		return $return_data;
	} else {
		$return_data['option_id'] = addOption($option_data);
		$return_data['option_value_id'] = checkOptionValue($option_data, $return_data['option_id']);
		return $return_data;
	}
}

function addOption($option_data)  {
	global $db;
	$db->query("INSERT INTO " . DB_PREFIX . "option (`type`, `sort_order`) VALUES ('" . $option_data[0] . "', 0)");
	$last_id = $db->getLastId();
	$db->query("INSERT INTO " . DB_PREFIX . "option_description (`option_id`, `language_id`, `name`) VALUES (" . (int)$last_id . ", 1, '" . $db->escape($option_data[1]) . "')");

	return $last_id;
}

function checkOptionValue($option_data, $option_id) {
	global $db;
	$query = $db->query("SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ovd.option_id = ov.option_id) WHERE ovd.name LIKE '" . $db->escape($option_data[2]) . "' AND ovd.language_id = 1 AND ov.option_id = " . (int)$option_id);

	if (!empty($query->row)) {
		return $query->row['option_value_id'];
	} else {
		return addOptionValue($option_data, $option_id);
	}
}

function addOptionValue($option_data, $option_id) {
	global $db;
	$db->query("INSERT INTO " . DB_PREFIX . "option_value (`option_id`, `image`, `sort_order`) VALUES (" . (int)$option_id . ", '', 0)");
	$last_id = $db->getLastId();
	$db->query("INSERT INTO " . DB_PREFIX . "option_value_description (`option_value_id`, `language_id`, `option_id`, `name`) VALUES (" . (int)$last_id . ", 1, " . (int)$option_id . ", '" . $db->escape($option_data[2]) . "')");

	return $last_id;
}

?>