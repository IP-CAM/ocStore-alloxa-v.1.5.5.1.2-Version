<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('max_execution_time', 50000);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once('ApekApi.php');

/*
    ВНИМАНИЕ! Данные для авторизации которые ниже - нерабочие и представлены только для примера.
*/

$apiUser = '0';
$apiSecret = 'FF9D583F';
$apiHost = 'http://alloxa.apekcrm.com:8080/api/';

$api = new ApekApi($apiUser, $apiSecret, $apiHost);



/*
	Для логирования и поиска неисправности включите debug mode
*/
$api->debug = true;



/*
	Для отключения проверки подлинности сертификата
*/
$api->disableSSLChecks();
$result = $api->sendRequest('Special/GetDeliveryType', ApekApi::METHOD_GET, array());
print_r($result);
?>