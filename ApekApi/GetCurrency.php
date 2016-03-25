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
 $result = $api->sendRequest('Special/GetCurrency', ApekApi::METHOD_GET, array('startRowIndex' => 0, 'maximumRows' => 50));
$resultkurs=$result['Data'][0]['COURSE_VALUE'];
$resultkursusd=$result['Data'][1]['COURSE_VALUE'];
//print_r($result);
?>