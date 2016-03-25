<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('max_execution_time', 50000);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
/*
	Примеры
*/

/*
	ВНИМАНИЕ! В init.php - прописаны данные для авторизации и инициализации API библиотеки.
	Пожалуйста ознакомьтесь с этим файлом.
*/
require_once('init.php');
require_once('GetCurrency.php');
require_once('GetWarrantyExt.php');

function translitIt($str){
    $tr = array(
        "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D","Е"=>"E","Ё"=>"YO","Ж"=>"J","З"=>"Z","И"=>"I",
        "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
        "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"C","Ч"=>"CH","Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
        "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"yo",
        "ж"=>"j","з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l","м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        "ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya","+"=>""," "=>"-","  "=>"-","   "=>"-","\""=>"",
        ":"=>"-","/"=>"-","("=>"",")"=>"","---"=>"-","--"=>"-","&"=>"-",","=>"","'"=>"","»"=>"","."=>"-"
    );
    $str = strtolower(strtr($str,$tr));
    //$str = iconv('UTF-8','windows-1251//IGNORE',$str);
    $str = trim($str);
    $str = iconv('windows-1251','UTF-8//IGNORE',$str);
    return $str;
}
if($_GET['go'] == 'update_price') {
    $db_host = ".";
    // Имя базы данных
    $db_name = "alloxanewtest";
    // Логин для подключения к базе данных
    $db_user = "alloxanewtest";
    // Пароль для подключения к базе данных
    $db_pass = "JmtFyZPu";
    define('DB_PREFIX', 'oc_');
    //Подключаемся к базе
    $db = mysql_connect ($db_host, $db_user, $db_pass) or die ("Невозможно подключиться к БД");
    if (!$db) {
        die('Ошибка соединения: ' . mysql_error());
    }
    //echo 'Успешно соединились';
    // Указываем кодировку, в которой будет получена информация из базы
    mysql_select_db($db_name) or die("Could not select company database!");
    mysql_query ('set character_set_results = "utf8"');
    $ii = 500;
    $ss=0;
    for ($i = 1; $i <= 50; $i++) {
        //sleep(1);

        if ($i > 1) {
            $result = $api->sendRequest('alloxa/getTovar', ApekApi::METHOD_GET, array('startRowIndex' => $ii * $i - 500, 'maximumRows' => $ii * $i));
        } elseif ($i == 1) {
            $result = $api->sendRequest('alloxa/getTovar', ApekApi::METHOD_GET, array('startRowIndex' => 0, 'maximumRows' => 500));
        }
        //print_r($result);exit;
        if (count($result['Data']) > 1) {
            for ($is = 0; $is < count($result['Data']); $is++) {
                $ss++;
                if ($result['Data'][$is]['TOVAR_PRICE'] !== "" || $result['Data'][$is]['TOVAR_PRICE'] <= 0) {
                    $stock_status_id = 7;
                } else {
                    $stock_status_id = 5;
                }
                $id_product = mysql_query("SELECT * FROM `" . DB_PREFIX . "product` WHERE `model` = '" . $result['Data'][$is]['TOVAR_MARK'] . "' LIMIT 1;");
                //$id_product = mysql_fetch_assoc($id_product);
                while ($rowtt = mysql_fetch_assoc($id_product)) {
                    $id_productrr['product_id'] = $rowtt["product_id"];
                }
                mysql_free_result($id_product);
                if (!empty($id_productrr['product_id'])) {
                    if ($result['Data'][$is]['TOVAR_PRICE'] > 0) {
                        mysql_query("UPDATE `" . DB_PREFIX . "product` SET `price` = '" . $result['Data'][$is]['TOVAR_PRICE_EQUAL'] . "', `quantity` = '" . $result['Data'][$is]['TOVAR_COUNT'] . "' WHERE `model` = '" . $result['Data'][$is]['TOVAR_MARK'] . "' ");
                        if ($result['Data'][$is]['TOVAR_WARRANTY'] != "") {

                            //$id_category  =$id_category["category_id"];

                            mysql_query("DELETE FROM `" . DB_PREFIX . "product_option` WHERE `product_id` = '" . $id_productrr['product_id'] . "' AND `option_id` = 63");
                            mysql_query("DELETE FROM `" . DB_PREFIX . "option_value_id` WHERE `product_id` = '" . $id_productrr['product_id'] . "' AND `option_id` = 63");
                            mysql_query("INSERT INTO `" . DB_PREFIX . "product_option` ( `product_id`, `option_id`, `option_value`, `required`) VALUES ('" . $id_productrr['product_id'] . "', '63', '', '1')");
                            foreach ($resultwarranty['Data'] as $keyf => $valuef) {
                                if ($result['Data'][$is]['TOVAR_PRICE'] > $valuef['WARRANTY_EXT_FROM'] && $result['Data'][$is]['TOVAR_PRICE'] < $valuef['WARRANTY_EXT_TO'] && $valuef['WARRANTY_EXT_MONTH'] >= $result['Data'][$is]['TOVAR_WARRANTY']) {
                                    if ($valuef['WARRANTY_EXT_MONTH'] == 3) {
                                        $option_value_id = 830;
                                    }
                                    if ($valuef['WARRANTY_EXT_MONTH'] == 6) {
                                        $option_value_id = 831;
                                    }
                                    if ($valuef['WARRANTY_EXT_MONTH'] == 12) {
                                        $option_value_id = 832;
                                    }
                                    if ($valuef['WARRANTY_EXT_MONTH'] != $result['Data'][$is]['TOVAR_WARRANTY']) {
                                        $resultkurs1 = $valuef['WARRANTY_EXT_PRICE'] * $resultkurs;
                                    } else {
                                        $resultkurs1 = '0';
                                    }


                                    $id_productoptionww = mysql_query("SELECT * FROM `" . DB_PREFIX . "product_option` WHERE `product_id` = '" . $id_productrr['product_id'] . "' AND `option_id` = 63 ORDER BY `product_option_id` DESC LIMIT 1;");
                                    //$id_product = mysql_fetch_assoc($id_product);
                                    while ($rowttoptionw = mysql_fetch_assoc($id_productoptionww)) {
                                        $id_productrroptions['product_option_id'] = $rowttoptionw["product_option_id"];
                                    }
                                    mysql_free_result($id_productoptionww);
                                    mysql_query("INSERT INTO `" . DB_PREFIX . "product_option_value` (`product_option_id`, `product_id`, `option_id`, `option_value_id`, `quantity`, `subtract`, `price`, `price_prefix`, `points`, `points_prefix`, `weight`, `weight_prefix`) VALUES ('" . $id_productrroptions['product_option_id'] . "', '" . $id_productrr['product_id'] . "', '63', '" . $option_value_id . "', '1000', '0', '" . $resultkurs1 . "', '+', '0', '+', '0', '+')");


                                    /*                mysql_query("UPDATE `" . DB_PREFIX . "product_option_value` SET `option_value_id` = '" . $option_value_id . "', `price` = '" . $valuef['WARRANTY_EXT_PRICE'] * $resultkurs . "' WHERE `product_id` = " . $id_productrr['product_id'] . " AND `option_id` = 63");
                                    print_r($result['Data'][$is]['TOVAR_WARRANTY']);
                                    print_r('--');
                                    print_r($result['Data'][$is]['TOVAR_MARK']);
                                    print_r('<BR>');*/
                                }
                            }
                        }
                    }
                    unset($id_productrr['product_id']);
                }else{
                    print_r('--');
                    print_r($result['Data'][$is]['TOVAR_MARK']);
                    print_r('<BR>');
                    mysql_query(" INSERT INTO " . DB_PREFIX . "product
        (
            model
            ,sku
            ,upc
            ,ean
            ,jan
            ,isbn
            ,mpn
            ,location
            ,quantity
            ,stock_status_id
            ,image
            ,manufacturer_id
            ,shipping
            ,price
            ,points
            ,tax_class_id
            ,date_available
            ,weight
            ,weight_class_id
            ,length
            ,width
            ,height
            ,length_class_id
            ,subtract
            ,minimum
            ,sort_order
            ,status
            ,viewed
            ,date_added
            ,date_modified
        )
VALUES
(
   '" . $result['Data'][$is]['TOVAR_MARK'] . "' -- model - VARCHAR(64) NOT NULL
 ,'" . $result['Data'][$is]['ID'] . "' -- sku - VARCHAR(64) NOT NULL
 ,'' -- upc1 - VARCHAR(12) NOT NULL
 ,'' -- ean1 - VARCHAR(14) NOT NULL
 ,'' -- jan1 - VARCHAR(13) NOT NULL
 ,'' -- isbn1 - VARCHAR(17) NOT NULL
 ,'' -- mpn1 - VARCHAR(64) NOT NULL
 ,'' -- location - VARCHAR(128) NOT NULL
 ," . $result['Data'][$is]['TOVAR_COUNT'] . " -- quantity - INT(4) NOT NULL
 ,'7' -- stock_status_id - INT(11) NOT NULL
 ,'no_image.jpg' -- image - VARCHAR(255)
 ,'0' -- manufacturer_id - INT(11) NOT NULL
 ,1 -- shipping - TINYINT(1) NOT NULL
 ," . ceil($result['Data'][$is]['TOVAR_PRICE'] * $resultkurs) . " -- price - DECIMAL(15, 4) NOT NULL
 ,0 -- points - INT(8) NOT NULL
 ,0 -- tax_class_id - INT(11) NOT NULL
 ,NOW() -- date_available - DATE NOT NULL
 ,0 -- weight - DECIMAL(15, 8) NOT NULL
 ,0 -- weight_class_id - INT(11) NOT NULL
 ,0 -- length - DECIMAL(15, 8) NOT NULL
 ,0 -- width - DECIMAL(15, 8) NOT NULL
 ,0 -- height - DECIMAL(15, 8) NOT NULL
 ,0 -- length_class_id - INT(11) NOT NULL
 ,0 -- subtract - TINYINT(1) NOT NULL
 ,1 -- minimum - INT(11) NOT NULL
 ,0 -- sort_order - INT(11) NOT NULL
 ,1 -- status - TINYINT(1) NOT NULL
 ,0 -- viewed - INT(5) NOT NULL
 ,NOW() -- date_added - DATETIME NOT NULL
 ,NOW() -- date_modified - DATETIME NOT NULL
)");
                    $id_productzzh = mysql_query("SELECT * FROM `" . DB_PREFIX . "product` ORDER BY `product_id` DESC LIMIT 1;");
                    //$id_product = mysql_fetch_assoc($id_product);
                    while ($rowtzzz = mysql_fetch_assoc($id_productzzh)) {
                        $id_productzzz['product_id'] = $rowtzzz["product_id"];
                    }
                    mysql_free_result($id_productzzh);
                    mysql_query("  INSERT INTO " . DB_PREFIX . "product_to_category
        (
            product_id
            ,category_id
        )
VALUES
(
   '" .  $id_productzzz['product_id'] . "' -- product_id - INT(11) NOT NULL
 ,'287' -- category_id - INT(11) NOT NULL
)");
                    mysql_query("  INSERT INTO " . DB_PREFIX . "product_to_store
        (
            product_id
            ,store_id
        )
VALUES
(
   '" . $id_productzzz['product_id'] . "' -- product_id - INT(11) NOT NULL
 ,0 -- store_id - INT(11) NOT NULL
)");
                    mysql_query("INSERT INTO " . DB_PREFIX . "product_description
        (
            product_id
            ,language_id
            ,name
            ,description
            ,meta_description
            ,meta_keyword
            ,seo_title
            ,seo_h1
            ,tag
            ,add_info
        )
VALUES
(
    '" . $id_productzzz['product_id'] . "' -- product_id - INT(11) NOT NULL
 ,1 -- language_id - INT(11) NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- name - VARCHAR(255) NOT NULL
 ,'" . preg_replace("/\s+/ui", " ", str_replace(array("\r\n", "\n"), " ", trim($result['Data'][$is]['NOTE']))) . "' -- description - TEXT NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- meta_description - VARCHAR(255) NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- meta_keyword - VARCHAR(255) NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- seo_title - TEXT NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- seo_h1 - VARCHAR(255) NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- seo_title - TEXT NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- seo_h1 - VARCHAR(255) NOT NULL
) ");
                    unset($id_productzzz['product_id']);
                }
            }
        } else {
            echo $ss;
            echo 'Good';
            exit;
        }
        //exit;
    }



}


if($_GET['go'] == 'tovar_cat') {
    /*// Хост (обычно localhost)
    $db_host = ".";
    // Имя базы данных
    $db_name = "alloxanewtest";
    // Логин для подключения к базе данных
    $db_user = "alloxanewtest";
    // Пароль для подключения к базе данных
    $db_pass = "JmtFyZPu";
    define('DB_PREFIX', 'oc_');
    //Подключаемся к базе
    $db = mysql_connect ($db_host, $db_user, $db_pass) or die ("Невозможно подключиться к БД");
    if (!$db) {
        die('Ошибка соединения: ' . mysql_error());
    }
    //echo 'Успешно соединились';
    // Указываем кодировку, в которой будет получена информация из базы
    mysql_select_db($db_name) or die("Could not select company database!");
    mysql_query ('set character_set_results = "utf8"');*/
//mysql_query("TRUNCATE TABLE ".DB_PREFIX."product;");
//mysql_query("TRUNCATE TABLE ".DB_PREFIX."product_description;");
//mysql_query("TRUNCATE TABLE ".DB_PREFIX."product_image;");
//mysql_query("TRUNCATE TABLE ".DB_PREFIX."product_to_category;");
//mysql_query("TRUNCATE TABLE ".DB_PREFIX."product_to_store;");
//mysql_query("TRUNCATE TABLE ".DB_PREFIX."url_alias;");
//exit;
//$result = $api->sendRequest('special/insertLead', ApekApi::METHOD_POST, $data);
    require_once('GetTovarGrp.php');
    $ii = 500;
    for ($i = 1; $i <= 50; $i++) {
        sleep(1);
        if ($i > 1) {
            $result = $api->sendRequest('alloxa/getTovar', ApekApi::METHOD_GET, array('startRowIndex' => $ii * $i - 500, 'maximumRows' => $ii * $i));
        } elseif ($i == 1) {
            $result = $api->sendRequest('alloxa/getTovar', ApekApi::METHOD_GET, array('startRowIndex' => 0, 'maximumRows' => 500));
        }

//print_r($result);
        if (count($result['Data']) > 1) {
            for ($is = 0; $is < count($result['Data']); $is++) {

                if ($result['Data'][$is]['TOVAR_PRICE'] !== "" || $result['Data'][$is]['TOVAR_PRICE'] <= 0) {
                    $stock_status_id = 7;
                } else {
                    $stock_status_id = 5;
                }
                mysql_query(" INSERT INTO " . DB_PREFIX . "product
        (
            product_id
            ,model
            ,sku
            ,upc
            ,ean
            ,jan
            ,isbn
            ,mpn
            ,location
            ,quantity
            ,stock_status_id
            ,image
            ,manufacturer_id
            ,shipping
            ,price
            ,points
            ,tax_class_id
            ,date_available
            ,weight
            ,weight_class_id
            ,length
            ,width
            ,height
            ,length_class_id
            ,subtract
            ,minimum
            ,sort_order
            ,status
            ,viewed
            ,date_added
            ,date_modified
        )
VALUES
(
    '" . $result['Data'][$is]['ID'] . "'
 ,'" . $result['Data'][$is]['ID'] . "' -- model - VARCHAR(64) NOT NULL
 ,'" . $result['Data'][$is]['ID'] . "' -- sku - VARCHAR(64) NOT NULL
 ,'' -- upc1 - VARCHAR(12) NOT NULL
 ,'' -- ean1 - VARCHAR(14) NOT NULL
 ,'' -- jan1 - VARCHAR(13) NOT NULL
 ,'' -- isbn1 - VARCHAR(17) NOT NULL
 ,'' -- mpn1 - VARCHAR(64) NOT NULL
 ,'' -- location - VARCHAR(128) NOT NULL
 ," . $result['Data'][$is]['TOVAR_COUNT'] . " -- quantity - INT(4) NOT NULL
 ," . $stock_status_id . " -- stock_status_id - INT(11) NOT NULL
 ,'no_image.jpg' -- image - VARCHAR(255)
 ,'0' -- manufacturer_id - INT(11) NOT NULL
 ,1 -- shipping - TINYINT(1) NOT NULL
 ," . ceil($result['Data'][$is]['TOVAR_PRICE'] * $resultkurs) . " -- price - DECIMAL(15, 4) NOT NULL
 ,0 -- points - INT(8) NOT NULL
 ,0 -- tax_class_id - INT(11) NOT NULL
 ,NOW() -- date_available - DATE NOT NULL
 ,0 -- weight - DECIMAL(15, 8) NOT NULL
 ,0 -- weight_class_id - INT(11) NOT NULL
 ,0 -- length - DECIMAL(15, 8) NOT NULL
 ,0 -- width - DECIMAL(15, 8) NOT NULL
 ,0 -- height - DECIMAL(15, 8) NOT NULL
 ,0 -- length_class_id - INT(11) NOT NULL
 ,0 -- subtract - TINYINT(1) NOT NULL
 ,1 -- minimum - INT(11) NOT NULL
 ,0 -- sort_order - INT(11) NOT NULL
 ,1 -- status - TINYINT(1) NOT NULL
 ,0 -- viewed - INT(5) NOT NULL
 ,NOW() -- date_added - DATETIME NOT NULL
 ,NOW() -- date_modified - DATETIME NOT NULL
)");
                mysql_query("  INSERT INTO " . DB_PREFIX . "product_to_category
        (
            product_id
            ,category_id
        )
VALUES
(
   '" . $result['Data'][$is]['ID'] . "' -- product_id - INT(11) NOT NULL
 ,'" . $result['Data'][$is]['GRP_ID'] . "' -- category_id - INT(11) NOT NULL
)");
                mysql_query("  INSERT INTO " . DB_PREFIX . "product_to_store
        (
            product_id
            ,store_id
        )
VALUES
(
   '" . $result['Data'][$is]['ID'] . "' -- product_id - INT(11) NOT NULL
 ,0 -- store_id - INT(11) NOT NULL
)");
                mysql_query("INSERT INTO " . DB_PREFIX . "product_description
        (
            product_id
            ,language_id
            ,name
            ,description
            ,meta_description
            ,meta_keyword
            ,seo_title
            ,seo_h1
            ,tag
            ,add_info
        )
VALUES
(
    '" . $result['Data'][$is]['ID'] . "' -- product_id - INT(11) NOT NULL
 ,1 -- language_id - INT(11) NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- name - VARCHAR(255) NOT NULL
 ,'" . preg_replace("/\s+/ui", " ", str_replace(array("\r\n", "\n"), " ", trim($result['Data'][$is]['NOTE']))) . "' -- description - TEXT NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- meta_description - VARCHAR(255) NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- meta_keyword - VARCHAR(255) NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- seo_title - TEXT NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- seo_h1 - VARCHAR(255) NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- seo_title - TEXT NOT NULL
 ,'" . $result['Data'][$is]['NAME'] . "' -- seo_h1 - VARCHAR(255) NOT NULL
) ");
                /*           mysql_query("INSERT INTO ".DB_PREFIX."url_alias
               (
                 query
                ,keyword
               )
               VALUES
               (
                 'product_id=" . $result['Data'][$is]['ID'] . "' -- query - VARCHAR(255) NOT NULL
                ,'" . translitIt(preg_replace("/\s+/","",str_replace(array("\r\n", "\n"), "",  trim($result['Data'][$is]['ID'] .$result['Data'][$is]['NAME'])))) . "' -- keyword - VARCHAR(255) NOT NULL
               )");*/


                //echo  "[ID]".$result['Data'][$is]['ID']."--[TOVAR_PRICE]" .$result['Data'][$is]['TOVAR_PRICE']."$--[TOVAR_COUNT]".$result['Data'][$is]['TOVAR_COUNT']."--[GRP_ID]".$result['Data'][$is]['GRP_ID']."--[NAME]" .$result['Data'][$is]['NAME']."--[NOTE]" .preg_replace("/\s+/ui"," ",str_replace(array("\r\n", "\n"), " ",  trim($result['Data'][$is]['NOTE']))). "\r\n<br>";
                //print_r($result['Data']);echo "<br>";
                //$f = fopen('links_cat_root.txt', 'a+');
                //fputs($f, $result['Data'][$is]['ID']."*****" .$result['Data'][$is]['TOVAR_PRICE']."*****" .$result['Data'][$is]['NAME']."*****" .preg_replace("/\s+/"," ",str_replace(array("\r\n", "\n"), " ",  trim($result['Data'][$is]['NOTE']))). "\r\n");
                //fclose($f);
            }
        } else {
            exit;
        }
    }
}