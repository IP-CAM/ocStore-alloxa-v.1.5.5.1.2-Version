<?php

/*
	Примеры
*/

/*
	ВНИМАНИЕ! В init.php - прописаны данные для авторизации и инициализации API библиотеки.
	Пожалуйста ознакомьтесь с этим файлом.
*/
require_once('init.php');
foreach ($order_product_query->rows as $product_api) {
    $order_option_queryss = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $product_api['order_product_id'] . "'");

    foreach ($order_option_queryss->rows as $option) {
        if($option['name'] == 'Гарантия')
        $Guaranteetext = utf8_substr($option['value'], 0, 2);
    }
$OrderItems_api[]=array(
    "Code" => $this->db->escape($product_api['model']),
    "Name" => $this->db->escape($product_api['name']),
    "Quantity" => (int)$product_api['quantity'],
    "Price" => (float)$product_api['price'],
    "BaseGuarantee" => 3,
    "Guarantee" => $Guaranteetext
);
}
if($order_info['payment_method'] == 'Наличными') {
    $payment_method_s = 'CASH';
}
if($order_info['payment_method'] == 'Банковской картой') {
    $payment_method_s = 'BANK_CARD';
}
if($order_info['payment_method'] == 'Купить в кредит') {
    $payment_method_s = 'CREDIT';
    $credit_ser = unserialize($order_info['credit_post']);
}
if($order_info['payment_method'] == 'Безналичный расчет') {
    $payment_method_s = 'CASHLESS';
}
if($order_info['shipping_method'] == 'Самовывоз') {
    $shipping_method_id = 0;
}
if($order_info['shipping_method'] == 'Доставка по Киеву') {
    $shipping_method_id = 1;
}
if($order_info['shipping_method'] == 'Доставка Новой Почтой') {
    $shipping_method_id = 2;
}
if ($order_info['comment'] != '') {
    $order_info_comment = $order_info['comment'];
}else{$order_info_comment = '';}
if ($order_info['email'] == 'empty@localhost'){
    $order_info['email']='';
}
    $data_api = array(
    "OrderID" => $order_id,
    "OrderDate" => date($language->get('date_format_short'), strtotime($order_info['date_added'])),
    "FirstName" => $order_info['payment_firstname'],
    "LastName" => $order_info['payment_lastname']);
if($order_info['payment_method'] == 'Купить в кредит') {
    $data_api["FatherName"] = $credit_ser['custom_middle_name'];
    $data_api["IDNumber"] =$credit_ser['custom_identification_code'];
        $data_api["Birthday"] = $credit_ser['custom_birthday'];
        $data_api["WorkPhone"] = $credit_ser['custom_workphone'];
        $data_api["Address"] = $credit_ser['main_address_1'];


}
if($order_info['payment_method'] == 'Безналичный расчет') {
    $queryZZ = $this->db->query("SELECT DISTINCT
                                        data
                                    FROM
                                        simple_custom_data
                                    WHERE
                                        object_id = '" . (int)$order_id . "'");

    if ($queryZZ->num_rows) {
        $dataZZ = unserialize($queryZZ->row['data']);
    }
    $data_api["Company"] = $dataZZ['payment_custom_organization']['value'];
    $data_api["IDNumber"] = $dataZZ['payment_custom_edrpou']['value'];
    //$data_api["Company"] = $credit_ser['payment_company'];
}
        $data_api["Email"] = $order_info['email'];
$data_api["Phone"] = $order_info['telephone'];
    $data_api["Note"] = $order_info_comment;
    $data_api["PaymentType"] = array(
        "Code" => $payment_method_s //нал
    );
    $data_api["DeliveryType"] = array(
        "ID" => $shipping_method_id //Доставка Киев
    );


if(($order_info['payment_method'] == 'Наличными' && $order_info['shipping_method'] == 'Самовывоз') || ($order_info['payment_method'] == 'Банковской картой' && $order_info['shipping_method'] == 'Самовывоз') || ($order_info['payment_method'] == 'Купить в кредит' && $order_info['shipping_method'] == 'Самовывоз') || ($order_info['payment_method'] == 'Безналичный расчет' && $order_info['shipping_method'] == 'Самовывоз') || ($order_info['payment_method'] == 'Безналичный расчет' && $order_info['shipping_method'] == 'Доставка по Киеву') || ($order_info['payment_method'] == 'Наличными' && $order_info['shipping_method'] == 'Доставка по Киеву')) {}else{
    $data_api["DeliveryAddress"] = $order_info['payment_address_1'];
    $data_api["DeliveryCityName"] = $order_info['shipping_zone_id'];
    $data_api["DeliveryPointName"] = $order_info['shipping_city'];
}

if(($order_info['payment_method'] == 'Безналичный расчет' && $order_info['shipping_method'] == 'Доставка по Киеву')  || ($order_info['payment_method'] == 'Наличными' && $order_info['shipping_method'] == 'Доставка по Киеву')){
    $data_api["DeliveryAddress"] = $order_info['payment_address_1'];
}
if($order_info['shipping_method'] == 'Доставка Новой Почтой') {
    $data_api["DeliveryCityName"] = $order_info['shipping_zone_id'];
    $data_api["DeliveryPointName"] = $order_info['shipping_city'];
}
if($order_info['payment_method'] == 'Купить в кредит') {
    //$credit_ser = unserialize($order_info['credit_post']);
    $data_api["CreditBankCode"] = $credit_ser['id_bank'];
    $data_api["CreditTotal"] = $credit_ser['topay']*$credit_ser['term']+$credit_ser['paid'];
    $data_api["CreditPaid"] = $credit_ser['paid'];
    $data_api["CreditTerm"] = $credit_ser['term'];
    $data_api["CreditToPay"] = $credit_ser['topay'];
}

    $data_api["OrderItems"] = $OrderItems_api;
//print_r(unserialize($order_info['credit_post']));
$f = fopen('ApekApi/links_cat_root.txt','a+'); fputs($f,serialize($data_api)."\r\n"); fclose($f);
$result = $api->sendRequest('alloxa/InsertOrder', ApekApi::METHOD_POST, $data_api);
//$f = fopen('ApekApi/links_cat_root1.txt','a+'); fputs($f,serialize($_POST)."\r\n"); fclose($f);
//print_r($result);
/*$data_api = array(
    "OrderID" => $order_id,
    "OrderDate" => date($language->get('date_format_short'), strtotime($order_info['date_added'])),
    "FirstName" => $order_info['payment_firstname'],
    "LastName" => $order_info['payment_lastname'],
    "FatherName" => "",
    "IDNumber" => $order_id,
    "Birthday" => "",
    "WorkPhone" => $order_info['telephone'],
    "Address" => $order_info['payment_address_1'],
    "Company" => $order_info['payment_company'],
    "Email" => $order_info['email'],
    "Phone" => $order_info['telephone'],
    "Note" => $order_info_comment,
    "PaymentType" => array(
        "Code" => $payment_method_s //нал
    ),
    "DeliveryType" => array(
        "ID" => $shipping_method_id //Доставка Киев
    ),
    "DeliveryAddress" => $order_info['payment_address_1'],
    "DeliveryCityName" => $order_info['payment_city'],
    "DeliveryPointName" => "1",
    "CreditBankCode" => "322755",
    "CreditTotal" => 1000,
    "CreditPaid" => 300,
    "CreditTerm" => 3,
    "CreditToPay" => 700,
    "OrderItems" => $OrderItems_api
);*/