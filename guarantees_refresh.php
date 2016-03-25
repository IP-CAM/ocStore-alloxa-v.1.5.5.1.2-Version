<?php

// Test initial data - start
// Database
$dbHost = '.';
$dbName = 'alloxanew';
$dbUser = 'alloxanew';
$dbPass = 'JmtFyZPu';

// Guaranties
$guarantees = array(
    array(
      'month' => 3,
      'price' => 0,
      'price_from' => 0,
      'price_to'   => 2450000
    ),
    array(
      'month' => 6,
      'price' => 245,
      'price_from' => 0,
      'price_to'   => 7350
    ),
    array(
      'month' => 6,
      'price' => 367,
      'price_from' => 7375,
      'price_to'   => 12250
    ),
    array(
      'month' => 6,
      'price' => 490,
      'price_from' => 12275,
      'price_to'   => 24500
    ),
    array(
      'month' => 6,
      'price' => 735,
      'price_from' => 24525,
      'price_to'   => 2450000
    ),
    array(
      'month' => 12,
      'price' => 367,
      'price_from' => 0,
      'price_to'   => 7350
    ),
    array(
      'month' => 12,
      'price' => 490,
      'price_from' => 7375,
      'price_to'   => 12250
    ),
    array(
      'month' => 12,
      'price' => 612,
      'price_from' => 12275,
      'price_to'   => 24500
    ),
    array(
      'month' => 12,
      'price' => 980,
      'price_from' => 24525,
      'price_to'   => 2450000
    )
);

// Categories to add/refresh guaranties to products
$categories_ids = array(109);
// Test initial data - end

$dbh = mysql_connect($dbHost, $dbUser, $dbPass) or die("Не могу соединиться с MySQL.");
mysql_select_db($dbName) or die("Не могу подключиться к базе.");
mysql_query("SET NAMES 'utf8'", $dbh);
mysql_query("SET CHARACTER SET utf8", $dbh);
mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $dbh);
mysql_query("SET SQL_MODE = ''", $dbh);

if (!empty($categories_ids)) {
    $add_sql = "p LEFT JOIN `oc_product_to_category` p2c ON (p.product_id = p2c.product_id) WHERE p2c.category_id IN (" . implode(', ', $categories_ids) . ")";
} else {
    $add_sql = "";
}

$products = mysql_query("SELECT * FROM `oc_product` " . $add_sql);

// Check product options and its values and add/refresh it
while ($product = mysql_fetch_assoc($products)) {
    foreach ($guarantees as $guarantee) {
        if ($product['price'] < $guarantee['price_from'] || $product['price'] > $guarantee['price_to']) continue;
        $return_data = checkOption(array('select', 'Гарантия', $guarantee['month']), $dbh);
        $product_option_id = checkProductOption($product['product_id'], $return_data['option_id'], 1);
        mysql_query("INSERT INTO `oc_product_option_value` (`product_option_id`, `product_id`, `option_id`, `option_value_id`, `quantity`, `subtract`, `price`, `price_prefix`, `points`, `points_prefix`, `weight`, `weight_prefix`) VALUES (" . (int)$product_option_id . ", " . (int)$product['product_id'] . ", " . (int)$return_data['option_id'] . ", " . (int)$return_data['option_value_id'] . ", 1000, 0, " . $guarantee['price'] . ", '+', 0, '+', 0, '+')");
    }
}

function checkProductOption($product_id, $option_id, $required) {
    $query = mysql_query("SELECT * FROM `oc_product_option` WHERE product_id = " . (int)$product_id . " AND option_id = " . (int)$option_id);

    if (mysql_num_rows($query) > 0) {
        $product_option = mysql_fetch_assoc($query);
        return $product_option['product_option_id'];
    } else {
        return addProductOption($product_id, $option_id, $required);
    }
}

function addProductOption($product_id, $option_id, $required) {
    mysql_query("INSERT INTO `oc_product_option` (`product_id`, `option_id`, `required`) VALUES (" . (int)$product_id . ", " . (int)$option_id . ", " . (int)$required . ")");

    return mysql_insert_id();
}

function checkOption($option_data) {
    $query = mysql_query("SELECT * FROM `oc_option` o LEFT JOIN `oc_option_description` od ON (od.option_id = o.option_id) WHERE od.name = '" . mysql_real_escape_string(iconv('cp1251', 'utf-8', $option_data[1])) . "' AND od.language_id = 1 AND o.type LIKE '" . mysql_real_escape_string($option_data[0]) . "'");

    if (mysql_num_rows($query) > 0) {
        $option = mysql_fetch_assoc($query);
        $return_data['option_id'] = $option['option_id'];
        $return_data['option_value_id'] = checkOptionValue($option_data, $return_data['option_id']);
        return $return_data;
    } else {
        $return_data['option_id'] = addOption($option_data);
        $return_data['option_value_id'] = checkOptionValue($option_data, $return_data['option_id']);
        return $return_data;
    }
}

function addOption($option_data)  {
    mysql_query("INSERT INTO `oc_option` (`type`, `sort_order`) VALUES ('" . $option_data[0] . "', 0)");
    $last_id = mysql_insert_id();
    mysql_query("INSERT INTO `oc_option_description` (`option_id`, `language_id`, `name`) VALUES (" . (int)$last_id . ", 1, '" . mysql_real_escape_string(iconv('cp1251', 'utf-8', $option_data[1])) . "')");

    return $last_id;
}

function checkOptionValue($option_data, $option_id) {
    $query = mysql_query("SELECT * FROM `oc_option_value` ov LEFT JOIN `oc_option_value_description` ovd ON (ovd.option_id = ov.option_id) WHERE ovd.name LIKE '" . mysql_real_escape_string(iconv('cp1251', 'utf-8', $option_data[2] . ' мес.')) . "' AND ovd.language_id = 1 AND ov.option_id = " . (int)$option_id);

    if (mysql_num_rows($query) > 0) {
        $option_value = mysql_fetch_assoc($query);
        return $option_value['option_value_id'];
    } else {
        return addOptionValue($option_data, $option_id);
    }
}

function addOptionValue($option_data, $option_id) {
    mysql_query("INSERT INTO `oc_option_value` (`option_id`, `image`, `sort_order`) VALUES (" . (int)$option_id . ", '', 0)");
    $last_id = mysql_insert_id();
    mysql_query("INSERT INTO `oc_option_value_description` (`option_value_id`, `language_id`, `option_id`, `name`) VALUES (" . (int)$last_id . ", 1, " . (int)$option_id . ", '" . mysql_real_escape_string(iconv('cp1251', 'utf-8', $option_data[2] . ' мес.')) . "')");

    return $last_id;
}
