<?php
/**
 * Created by PhpStorm.
 * User: Net
 * Date: 11.01.2016
 * Time: 14:29
 */
header('Content-Type: text/html; charset=utf-8');
$r=file('links_cat_root.txt');
foreach($r as $value) {
    print_r(unserialize($value));
    print_r('<br><br><br>');
}