<?php

ini_set('display_errors',1);
require_once(dirname(__FILE__).'/dealImage.php');

header('Content-type:text/html;charset=utf-8');


$newFileName = rand(1000,time());
$savePath = date('Y').'/'.date('m').date('d');
$dealImg = new dealImage($_FILES['img']['tmp_name'],$_FILES['img']['name'],$_FILES['img']['size'],$newFileName,$savePath);
$result = $dealImg->saveImg();

//echo $result;

print_R(json_decode($result));
