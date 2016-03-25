<?php
/*header('Content-Type: text/html; charset=utf-8');
ini_set('max_execution_time', 50000);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);*/

/*
	ВНИМАНИЕ! В init.php - прописаны данные для авторизации и инициализации API библиотеки.
	Пожалуйста ознакомьтесь с этим файлом.
*/
require_once('init.php');
/*function translitIt($str){
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
    $str = iconv('UTF-8','windows-1251',$str);
    $str = trim($str);
    $str = iconv('windows-1251','UTF-8',$str);
    return $str;
}*/


// Хост (обычно localhost)
$db_host = ".";
// Имя базы данных
$db_name = "alloxanewtests";
// Логин для подключения к базе данных
$db_user = "alloxanewtests";
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
mysql_query("TRUNCATE TABLE ".DB_PREFIX."category;");
mysql_query("TRUNCATE TABLE ".DB_PREFIX."category_description;");
mysql_query("TRUNCATE TABLE ".DB_PREFIX."category_path;");
mysql_query("TRUNCATE TABLE ".DB_PREFIX."category_to_store;");
mysql_query("TRUNCATE TABLE ".DB_PREFIX."url_alias;");


        $result = $api->sendRequest('Alloxa/GetTovarGrp', ApekApi::METHOD_GET, array('startRowIndex' => 0, 'maximumRows' => 50));
//print_r($result['Data'][0]['SubGrp'][0]['SubGrp'][0]);
//print_r($result);
foreach($result['Data'][0] as $keys=>$values){
    //echo $keys . "|";
    if($keys == 'SubGrp'){
        echo "\r\n<br>";
        foreach ($values as $key => $value) {
            //echo $key . "~";
            //print_r($value);

            mysql_query("INSERT INTO ".DB_PREFIX."category
(
  category_id
 ,image
 ,parent_id
 ,top
 ,`column`
 ,sort_order
 ,status
 ,date_added
 ,date_modified
)
VALUES
(
  '".$values[$key]['ID']."' -- category_id - INT(11) NOT NULL
 ,'' -- image - VARCHAR(255)
 ,0 -- parent_id - INT(11) NOT NULL
 ,'1' -- top - TINYINT(1) NOT NULL
 ,0 -- column - INT(3) NOT NULL
 ,0 -- sort_order - INT(3) NOT NULL
 ,1 -- status - TINYINT(1) NOT NULL
 ,NOW() -- date_added - DATETIME NOT NULL
 ,NOW() -- date_modified - DATETIME NOT NULL
)");
            mysql_query("INSERT INTO ".DB_PREFIX."category_path
(
  category_id
 ,path_id
 ,level
)
VALUES
(
  '".$values[$key]['ID']."' -- category_id - INT(11) NOT NULL
 ,'".$values[$key]['ID']."' -- path_id - INT(11) NOT NULL
 ,0 -- level - INT(11) NOT NULL
)");
            mysql_query(" INSERT INTO ".DB_PREFIX."category_to_store
                (
                    category_id
                    ,store_id
                )
VALUES
(
   '".$values[$key]['ID']."' -- category_id - INT(11) NOT NULL
 ,0 -- store_id - INT(11) NOT NULL
)");
            mysql_query("INSERT INTO ".DB_PREFIX."url_alias
(
  query
 ,keyword
)
VALUES
(
  'category_id=" . $values[$key]['ID'] . "' -- query - VARCHAR(255) NOT NULL
 ,'" . translitIt(preg_replace("/\s+/ui","",str_replace(array("\r\n", "\n"), "",  trim($values[$key]['GrpName'])))) . "' -- keyword - VARCHAR(255) NOT NULL
)");
            mysql_query("INSERT INTO ".DB_PREFIX."category_description
                (
                    category_id
                    ,language_id
                    ,name
                    ,description
                    ,meta_description
                    ,meta_keyword
                    ,seo_title
                    ,seo_h1
                 )
VALUES
(
'".$values[$key]['ID']."',
  1 -- language_id - INT(11) NOT NULL
 , '".$values[$key]['GrpName']."'  -- name - VARCHAR(255) NOT NULL
 ,'".$values[$key]['GrpName']."' -- description - TEXT NOT NULL
 , '".$values[$key]['GrpName']."'  -- meta_description - VARCHAR(255) NOT NULL
 , '".$values[$key]['GrpName']."'  -- meta_keyword - VARCHAR(255) NOT NULL
 , '".$values[$key]['GrpName']."'  -- seo_title - VARCHAR(255) NOT NULL
 , '".$values[$key]['GrpName']."'  -- seo_h1 - VARCHAR(255) NOT NULL
)");


            echo $values[$key]['ID']."--". $values[$key]['GrpName'];
            echo "\r\n<br>";
            if(isset($values[$key]['SubGrp'])) {
                foreach ($values[$key]['SubGrp'] as $keyq => $valueq) {

                    mysql_query("INSERT INTO ".DB_PREFIX."category
(
  category_id
 ,image
 ,parent_id
 ,top
 ,`column`
 ,sort_order
 ,status
 ,date_added
 ,date_modified
)
VALUES
(
  '".$values[$key]['SubGrp'][$keyq]['ID']."' -- category_id - INT(11) NOT NULL
 ,'' -- image - VARCHAR(255)
 ,'".$values[$key]['ID']."' -- parent_id - INT(11) NOT NULL
 ,'0' -- top - TINYINT(1) NOT NULL
 ,0 -- column - INT(3) NOT NULL
 ,0 -- sort_order - INT(3) NOT NULL
 ,1 -- status - TINYINT(1) NOT NULL
 ,NOW() -- date_added - DATETIME NOT NULL
 ,NOW() -- date_modified - DATETIME NOT NULL
)");
                    mysql_query("INSERT INTO ".DB_PREFIX."category_path
(
  category_id
 ,path_id
 ,level
)
VALUES
(
  '".$values[$key]['SubGrp'][$keyq]['ID']."' -- category_id - INT(11) NOT NULL
 ,'".$values[$key]['SubGrp'][$keyq]['ID']."' -- path_id - INT(11) NOT NULL
 ,0 -- level - INT(11) NOT NULL
)");
                    mysql_query("INSERT INTO ".DB_PREFIX."category_path
(
  category_id
 ,path_id
 ,level
)
VALUES
(
  '".$values[$key]['SubGrp'][$keyq]['ID']."' -- category_id - INT(11) NOT NULL
 ,'".$values[$key]['ID']."' -- path_id - INT(11) NOT NULL
 ,0 -- level - INT(11) NOT NULL
)");
                    mysql_query(" INSERT INTO ".DB_PREFIX."category_to_store
                (
                    category_id
                    ,store_id
                )
VALUES
(
   '".$values[$key]['SubGrp'][$keyq]['ID']."' -- category_id - INT(11) NOT NULL
 ,0 -- store_id - INT(11) NOT NULL
)");
                    mysql_query("INSERT INTO ".DB_PREFIX."url_alias
(
  query
 ,keyword
)
VALUES
(
  'category_id=" . $values[$key]['SubGrp'][$keyq]['ID'] . "' -- query - VARCHAR(255) NOT NULL
 ,'" . translitIt(preg_replace("/\s+/ui","",str_replace(array("\r\n", "\n"), "",  trim($values[$key]['SubGrp'][$keyq]['ID'].$values[$key]['SubGrp'][$keyq]['GrpName'])))) . "' -- keyword - VARCHAR(255) NOT NULL
)");
                    mysql_query("INSERT INTO ".DB_PREFIX."category_description
                (
                    category_id
                    ,language_id
                    ,name
                    ,description
                    ,meta_description
                    ,meta_keyword
                    ,seo_title
                    ,seo_h1
                 )
VALUES
(
'".$values[$key]['SubGrp'][$keyq]['ID']."',
  1 -- language_id - INT(11) NOT NULL
 , '".$values[$key]['SubGrp'][$keyq]['GrpName']."'  -- name - VARCHAR(255) NOT NULL
 ,'".$values[$key]['SubGrp'][$keyq]['GrpName']."' -- description - TEXT NOT NULL
 , '".$values[$key]['SubGrp'][$keyq]['GrpName']."'  -- meta_description - VARCHAR(255) NOT NULL
 , '".$values[$key]['SubGrp'][$keyq]['GrpName']."'  -- meta_keyword - VARCHAR(255) NOT NULL
 , '".$values[$key]['SubGrp'][$keyq]['GrpName']."'  -- seo_title - VARCHAR(255) NOT NULL
 , '".$values[$key]['SubGrp'][$keyq]['GrpName']."'  -- seo_h1 - VARCHAR(255) NOT NULL
)");



                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-".$values[$key]['SubGrp'][$keyq]['ID'] . "--" . $values[$key]['SubGrp'][$keyq]['GrpName'];
                    echo "\r\n<br>";
                    if(isset($values[$key]['SubGrp'][$keyq]['SubGrp'])) {
                        foreach ($values[$key]['SubGrp'][$keyq]['SubGrp'] as $keyt => $valuet) {


                            mysql_query("INSERT INTO ".DB_PREFIX."category
(
  category_id
 ,image
 ,parent_id
 ,top
 ,`column`
 ,sort_order
 ,status
 ,date_added
 ,date_modified
)
VALUES
(
  '".$values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['ID']."' -- category_id - INT(11) NOT NULL
 ,'' -- image - VARCHAR(255)
 ,'".$values[$key]['SubGrp'][$keyq]['ID']."'  -- parent_id - INT(11) NOT NULL
 ,'0' -- top - TINYINT(1) NOT NULL
 ,0 -- column - INT(3) NOT NULL
 ,0 -- sort_order - INT(3) NOT NULL
 ,1 -- status - TINYINT(1) NOT NULL
 ,NOW() -- date_added - DATETIME NOT NULL
 ,NOW() -- date_modified - DATETIME NOT NULL
)");

                            mysql_query("INSERT INTO ".DB_PREFIX."category_path
(
  category_id
 ,path_id
 ,level
)
VALUES
(
  '".$values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['ID']."' -- category_id - INT(11) NOT NULL
 ,'".$values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['ID']."' -- path_id - INT(11) NOT NULL
 ,0 -- level - INT(11) NOT NULL
)");
                            mysql_query("INSERT INTO ".DB_PREFIX."category_path
(
  category_id
 ,path_id
 ,level
)
VALUES
(
  '".$values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['ID']."' -- category_id - INT(11) NOT NULL
 ,'".$values[$key]['SubGrp'][$keyq]['ID']."' -- path_id - INT(11) NOT NULL
 ,0 -- level - INT(11) NOT NULL
)");
                            mysql_query(" INSERT INTO ".DB_PREFIX."category_to_store
                (
                    category_id
                    ,store_id
                )
VALUES
(
   '".$values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['ID']."' -- category_id - INT(11) NOT NULL
 ,0 -- store_id - INT(11) NOT NULL
)");
                            mysql_query("INSERT INTO ".DB_PREFIX."url_alias
(
  query
 ,keyword
)
VALUES
(
  'category_id=" . $values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['ID'] . "' -- query - VARCHAR(255) NOT NULL
 ,'" . translitIt(preg_replace("/\s+/ui","",str_replace(array("\r\n", "\n"), "",  trim($values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['ID'] . $values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['GrpName'])))) . "' -- keyword - VARCHAR(255) NOT NULL
)");
                            mysql_query("INSERT INTO ".DB_PREFIX."category_description
                (
                    category_id
                    ,language_id
                    ,name
                    ,description
                    ,meta_description
                    ,meta_keyword
                    ,seo_title
                    ,seo_h1
                 )
VALUES
(
'".$values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['ID']."',
  1 -- language_id - INT(11) NOT NULL
 , '".$values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['GrpName']."'  -- name - VARCHAR(255) NOT NULL
 ,'".$values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['GrpName']."' -- description - TEXT NOT NULL
 , '".$values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['GrpName']."'  -- meta_description - VARCHAR(255) NOT NULL
 , '".$values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['GrpName']."'  -- meta_keyword - VARCHAR(255) NOT NULL
 , '".$values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['GrpName']."'  -- seo_title - VARCHAR(255) NOT NULL
 , '".$values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['GrpName']."'  -- seo_h1 - VARCHAR(255) NOT NULL
)");





                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--".$values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['ID'] . "--" . $values[$key]['SubGrp'][$keyq]['SubGrp'][$keyt]['GrpName'];
                            echo "\r\n<br>";
                        }
                    }
                }
            }
        }
    }
}
?>