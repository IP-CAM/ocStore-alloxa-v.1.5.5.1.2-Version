<?php 
set_time_limit(0);
// Configuration
if (file_exists('config.php')) {
	require_once('config.php');
}  
require_once(DIR_SYSTEM . 'library/db.php');
ini_set("display_errors",1);
error_reporting(E_ALL);
ini_set('error_reporting',2047);
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$products = $db->query("select * from new__products");
$products_in_store_query = $db->query("select keyword from oc_url_alias where `query` like 'product_id=%'");

$products_in_store = array();
foreach ($products_in_store_query->rows as $product) {
	$products_in_store[(int)str_replace('product_id=', '', $product['keyword'])] = $product['keyword'];
}

if (!file_exists(DIR_IMAGE . 'data/products/')) {
	mkdir(DIR_IMAGE . 'data/products/');
}
$c = 0;
foreach ($products->rows as $k => $product) {
	if (in_array($product['idt'], $products_in_store)) {
		$db->query("UPDATE " . DB_PREFIX . "product_description SET description = '" . $db->escape($product['body']) . "' WHERE product_id = " . (int)array_search($product['idt'], $products_in_store));
		$c++;
	}
	// $main_category = $db->query("select new_id from new__categories where id = " . $product['id_cat']);
	// $category =  $db->query("select new_id from new__categories where id = " . $product['id_cat_parent']);
	// $images = $db->query("SELECT * FROM new__objects WHERE id_products = " . $product['id'] . " AND is_active = 1 AND file_name NOT LIKE '' AND path NOT LIKE ''");
	// $attributes = $db->query("SELECT * FROM new__products_params_vals_rel WHERE id_product = " . $product['id']);

	// if (!empty($product['file_name'])) {
	// 	$pathinfo = pathinfo($product['file_name']);
	// 	recursiveImage($pathinfo['basename'], $product['path'], $product['id'], $product['file_name']);
	// 	$image = 'data/products/' .  $pathinfo['basename'];
	// } else {
	// 	$image = '';
	// }

	// $db->query("INSERT INTO " . DB_PREFIX . "product (`model`, `image`, `price`, `quantity`, `status`) VALUES ('" . $db->escape($product['code']) . "', '" . $image . "', " . $product['price'] . ", " . (int)$product['count_items'] . ", " . $product['is_active'] . ")");
	// $last_id = $db->getLastId();
	// $db->query("INSERT INTO " . DB_PREFIX . "product_description (`product_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword`, `seo_title`) VALUES (" . (int)$last_id . ", 1, '" . $db->escape($product['title']) . "', '" . $db->escape($product['body']) . "', '" . $db->escape($product['ceo_desc']) . "', '" . $db->escape($product['ceo_keywords']) . "', '" . $db->escape($product['ceo_title']) . "')");
	// $db->query("INSERT INTO " . DB_PREFIX . "product_to_store (`product_id`, `store_id`) VALUES (" . (int)$last_id . ", 0)");
	// $db->query("INSERT INTO " . DB_PREFIX . "url_alias (`query`, `keyword`) VALUES ('product_id=" . (int)$last_id . "', '" . $db->escape($product['idt']) . "')"); 

	// foreach ($images->rows as $image) {
	// 	if (!empty($image['file_name'])) {
	// 		$pathinfo = pathinfo($image['file_name']);
	// 		recursiveImage($pathinfo['basename'], $image['path'], $image['id'], $image['file_name']);
	// 		$image = 'data/products/' .  $pathinfo['basename'];
	// 		$db->query("INSERT INTO " . DB_PREFIX . "product_image (`product_id`, `image`) VALUES (" . (int)$last_id . ", '" . $image . "')");
	// 	}
	// }
	// if (isset($main_category->row['new_id'])) {
	// 	$db->query("INSERT INTO " . DB_PREFIX . "product_to_category (`product_id`, `category_id`, `main_category`) VALUES (" . (int)$last_id . ", " . (int)$main_category->row['new_id'] . ", 1)"); 
	// }
	// if (isset($category->row['new_id'])) {
	// 	if ((isset($main_category->row['new_id']) && $category->row['new_id'] != $main_category->row['new_id']) || !isset($main_category->row['new_id'])) {
	// 		$db->query("INSERT INTO " . DB_PREFIX . "product_to_category (`product_id`, `category_id`, `main_category`) VALUES (" . (int)$last_id . ", " . (int)$category->row['new_id'] . ", 0)"); 
	// 	}
	// }
	// foreach ($attributes->rows as $attribute) {
	// 	if ($attribute['id_val'] == 0) {
	// 		if (!empty($attribute['val'])) {
	// 			$attribute_id = $db->query("SELECT new_id, is_top FROM new__products_params WHERE id = " . (int)$attribute['id_param']);
	// 			if (isset($attribute_id->row['new_id'])) {
	// 				$duplicate = $db->query("SELECT `text` FROM " . DB_PREFIX . "product_attribute WHERE product_id = " . (int)$last_id . " AND attribute_id = " . (int)$attribute_id->row['new_id']);
	// 				if (!empty($duplicate->row['text'])) {
	// 					$db->query("UPDATE " . DB_PREFIX . "product_attribute SET `text` = '" . $duplicate->row['text'] . '++' . $attribute['val'] . "' WHERE product_id = " . (int)$last_id . " AND attribute_id = " . (int)$attribute_id->row['new_id']);
	// 				} else {
	// 					$db->query("INSERT INTO " . DB_PREFIX . "product_attribute (`product_id`, `attribute_id`, `language_id`, `text`, `short`) VALUES (" . (int)$last_id . ", " . (int)$attribute_id->row['new_id'] . ", 1, '" . $db->escape($attribute['val']) . "', " . (int)$attribute_id->row['is_top'] . ")");
	// 				}
	// 			}
	// 		}
	// 	} else {
	// 		$attribute_id = $db->query("SELECT new_id, is_top FROM new__products_params WHERE id = " . (int)$attribute['id_param']);
	// 		if (isset($attribute_id->row['new_id'])) {
	// 			$duplicate = $db->query("SELECT `text` FROM " . DB_PREFIX . "product_attribute WHERE product_id = " . (int)$last_id . " AND attribute_id = " . (int)$attribute_id->row['new_id']);
	// 			$param_val = $db->query("SELECT val FROM new__products_params_vals WHERE id = " . (int)$attribute['id_val'] . " AND id_param = " . (int)$attribute['id_param']);
	// 			if (!empty($attribute['param_val_desc'])) {
	// 				$param_val->row['val'] .= $attribute['param_val_desc'];
	// 			}
	// 			if (isset($param_val->row['val'])) {
	// 				if (!empty($duplicate->row['text'])) {
	// 					$db->query("UPDATE " . DB_PREFIX . "product_attribute SET `text` = '" . $duplicate->row['text'] . '++' . $param_val->row['val'] . "' WHERE product_id = " . (int)$last_id . " AND attribute_id = " . (int)$attribute_id->row['new_id']);
	// 				} else {
	// 					$db->query("INSERT INTO " . DB_PREFIX . "product_attribute (`product_id`, `attribute_id`, `language_id`, `text`, `short`) VALUES (" . (int)$last_id . ", " . (int)$attribute_id->row['new_id'] . ", 1, '" . $db->escape($param_val->row['val']) . "', " . (int)$attribute_id->row['is_top'] . ")");
	// 				}
	// 			}
	// 		}
	// 	}
	// }
}

function recursiveImage($basename, $product_path, $product_id, $product_filename) {
	if (!file_exists(DIR_IMAGE . 'data/products/' . $basename)) {
		file_put_contents(DIR_IMAGE . 'data/products/' . $basename, file_get_contents('http://files.alloxa.com' . $product_path . $product_id . 'original' . $product_filename));		
		if (!filesize(DIR_IMAGE . 'data/products/' . $basename)) {
			recursiveImage($basename, $product_path, $product_id, $product_filename);
		}
	} else {
		if (!filesize(DIR_IMAGE . 'data/products/' . $basename)) {
			unlink(DIR_IMAGE . 'data/products/' . $basename);
			file_put_contents(DIR_IMAGE . 'data/products/' . $basename, file_get_contents('http://files.alloxa.com' . $product_path . $product_id . 'original' . $product_filename));
			if (!filesize(DIR_IMAGE . 'data/products/' . $basename)) {
				recursiveImage($basename, $product_path, $product_id, $product_filename);
			}
		}
	}
}
var_dump($c);
?>