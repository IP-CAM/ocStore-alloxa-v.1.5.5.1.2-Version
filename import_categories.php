<?php 

// Configuration
if (file_exists('config.php')) {
	require_once('config.php');
}  
require_once(DIR_SYSTEM . 'library/db.php');

$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$categories = $db->query("select * from new__categories where parent_id = 62");

if (!file_exists(DIR_IMAGE . 'data/categories/')) {
	mkdir(DIR_IMAGE . 'data/categories/');
}

recursiveCategory($categories->rows, array());

function recursiveCategory($categories, $parent_ids) {
	global $db;

	foreach ($categories as $category) {
		$cat_parent_ids = $parent_ids;
		
		if (!empty($category['file_name'])) {
			$pathinfo = pathinfo($category['file_name']);
			recursiveImage($pathinfo['basename'], $category['path'], $category['id'], $category['file_name']);
			$image = 'data/categories/' .  $pathinfo['basename'];
		} else {
			$image = '';
		}
		if (!empty($parent_ids)) {
			$parent_category_id = end($parent_ids);
		} else {
			$parent_category_id = 0;
		}
		$db->query("INSERT INTO " . DB_PREFIX . "category (`image`, `parent_id`, `sort_order`, `status`) VALUES ('" . $image . "', " . (int)$parent_category_id . ", " . (int)$category['norder'] . ", " . (int)$category['is_active'] . ")");
		$last_id = $db->getLastId(); 
		$db->query("INSERT INTO " . DB_PREFIX . "category_description (`category_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword`, `seo_title`, `seo_h1`) VALUES (" . (int)$last_id . ", 1, '" . $db->escape($category['menu_name_ru']) . "', '" . $db->escape($category['text_ru']) . "', '" . $db->escape($category['ceo_desc']) . "', '" . $db->escape($category['ceo_keywords']) . "', '" . $db->escape($category['ceo_title']) . "', '" . $db->escape($category['title_ru']) . "')");
		$db->query("INSERT INTO " . DB_PREFIX . "category_to_store (`category_id`, `store_id`) VALUES (" . (int)$last_id . ", 0)");
		$db->query("INSERT INTO " . DB_PREFIX . "url_alias (`query`, `keyword`) VALUES ('category_id=" . (int)$last_id . "', '" . $category['idt'] . "')");
		$db->query("UPDATE new__categories SET new_id = " . $last_id . " where id = " . $category['id']);

		$level = 0;

		foreach ($parent_ids as $parent_id) {
			$db->query("INSERT INTO " . DB_PREFIX . "category_path SET `category_id` = " . (int)$last_id . ", `path_id` = " . (int)$parent_id . ", `level` = " . (int)$level . " ");

			$level++;
		}

		$db->query("INSERT INTO " . DB_PREFIX . "category_path SET `category_id` = " . (int)$last_id . ", `path_id` = " . (int)$last_id . ", `level` = " . (int)$level . " ");

		$child_categories = $db->query("select * from new__categories where parent_id = " . $category['id']);

		if (!empty($child_categories->rows)) {
			$cat_parent_ids[] = $last_id;
			recursiveCategory($child_categories->rows, $cat_parent_ids);
		} 
	}
}

function recursiveImage($basename, $category_path, $category_id, $category_filename) {
	if (!file_exists(DIR_IMAGE . 'data/categories/' . $basename)) {
		file_put_contents(DIR_IMAGE . 'data/categories/' . $basename, file_get_contents('http://files.alloxa.com' . $category_path . $category_id . 'original' . $category_filename));		
		if (!filesize(DIR_IMAGE . 'data/categories/' . $basename)) {
			recursiveImage($basename, $category_path, $category_id, $category_filename);
		}
	} else {
		if (!filesize(DIR_IMAGE . 'data/categories/' . $basename)) {
			unlink(DIR_IMAGE . 'data/categories/' . $basename);
			file_put_contents(DIR_IMAGE . 'data/categories/' . $basename, file_get_contents('http://files.alloxa.com' . $category_path . $category_id . 'original' . $category_filename));
			if (!filesize(DIR_IMAGE . 'data/categories/' . $basename)) {
				recursiveImage($basename, $category_path, $category_id, $category_filename);
			}
		}
	}
}

?>