<?php

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
 $api->debug = false;



/*
	Для отключения проверки подлинности сертификата
*/
 $api->disableSSLChecks();
