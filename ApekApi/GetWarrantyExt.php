<?php
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

/*
{
  'name': 'sample string 1',
  'company': 'sample string 2',
  'email': 'sample string 3',
  'phone': 'sample string 4',
  'lead_type': 'sample string 5',
  'text': 'sample string 6',
  'source': 'sample string 7',
  'extra': {
    'sample string 1': 'sample string 2',
    'sample string 3': 'sample string 4'
  }
}
*/

$data = array(
	'name' => 'Иванов Иван',
	'company' => 'ООО Рога и копыта',
	'email' => 'mail@test.com',
	'phone' => '+5 555 123-45-67',
	'lead_type' => 'Заявка на расчет',
	'text' => 'Надо посчитать',
	'source' => 'Сайт test.com',
	'extra' => array(
		'utm' => '111',
		'roistat' => '222'
		)
);



//$result = $api->sendRequest('special/insertLead', ApekApi::METHOD_POST, $data);
/*$ii = 500;
for($i = 1; $i <= 1; $i++) {
    sleep(1);
    if ($i > 1) {
        $result = $api->sendRequest('alloxa/getTovar', ApekApi::METHOD_GET, array('startRowIndex' => $ii*$i-500, 'maximumRows' => $ii*$i));
    }elseif ($i == 1){*/
        $result = $api->sendRequest('Alloxa/GetWarrantyExt', ApekApi::METHOD_GET, array('startRowIndex' => 0, 'maximumRows' => 50));
//print_r($result);
$resultwarranty=$result;
/*    }

//print_r($result);
    if (count($result['Data']) > 1) {
        for($is = 0; $is < count($result['Data']); $is++) {
            print_r($result['Data']);echo "<br>";
            //$f = fopen('links_cat_root.txt', 'a+');
            //fputs($f, $result['Data'][$is]['ID']."*****" .$result['Data'][$is]['TOVAR_PRICE']."*****" .$result['Data'][$is]['NAME']."*****" .preg_replace("/\s+/"," ",str_replace(array("\r\n", "\n"), " ",  trim($result['Data'][$is]['NOTE']))). "\r\n");
            //fclose($f);
        }
    }else{exit;}
}*/