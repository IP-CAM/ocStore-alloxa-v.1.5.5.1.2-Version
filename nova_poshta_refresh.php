<?php

// Test initial data - start
// Database
$dbHost = '.';
$dbName = 'alloxanew';
$dbUser = 'alloxanew';
$dbPass = 'JmtFyZPu';

// Test array
$points = array(
    array(
        'city' => 'Ананьїв',
        'address' => 'Відділення: вул. Незалежності, 19'
    )
);
// Test initial data - end

$dbh = mysql_connect($dbHost, $dbUser, $dbPass) or die("Не могу соединиться с MySQL.");
mysql_select_db($dbName) or die("Не могу подключиться к базе.");
mysql_query("SET NAMES 'utf8'", $dbh);
mysql_query("SET CHARACTER SET utf8", $dbh);
mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $dbh);
mysql_query("SET SQL_MODE = ''", $dbh);

// Clear all cities and points in opencart
//mysql_query("DELETE FROM `oc_zone`");
//mysql_query("DELETE FROM `oc_city`");

foreach ($points as $point) {
    $city_id = checkCity($point['city']);
    checkAddress($point['address'], $city_id);
}

function checkCity($city_name) {
    $query = mysql_query("SELECT * FROM `oc_zone` WHERE name LIKE '" . mysql_real_escape_string(iconv('cp1251', 'utf-8', $city_name)) . "'");

    if (mysql_num_rows($query) > 0) {
        $city = mysql_fetch_assoc($query);
        return $city['zone_id'];
    } else {
        return addCity($city_name);
    }
}

function addCity($city_name) {
    mysql_query("INSERT INTO `oc_zone` (`country_id`, `name`, `code`, `status`) VALUES (1, '" . mysql_real_escape_string(iconv('cp1251', 'utf-8', $city_name)) . "', '', 1)");

    return mysql_insert_id();
}

function checkAddress($address_name, $city_id) {
    $query = mysql_query("SELECT * FROM `oc_city` WHERE `name` LIKE '" . mysql_real_escape_string(iconv('cp1251', 'utf-8', $address_name)) . "' AND `zone_id` = " . (int)$city_id);

    if (mysql_num_rows($query) > 0) {
        $address = mysql_fetch_assoc($query);
        return $address['city_id'];
    } else {
        return addAddress($address_name, $city_id);
    }
}

function addAddress($address_name, $city_id) {
    mysql_query("INSERT INTO `oc_city` (`zone_id`, `name`, `code`, `status`, `sort_order`) VALUES (" . (int)$city_id . ", '" . mysql_real_escape_string(iconv('cp1251', 'utf-8', $address_name)) . "', '', 1, 0)");

    return mysql_insert_id();
}