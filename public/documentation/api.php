<?php
//เรียกใช้ autoLoad 
header('Access-Control-Allow-Origin: *');

$ROOT_PATH = str_replace("documentation" , "" , __DIR__);
require($ROOT_PATH . "/vendor/autoload.php");

$openapi = \OpenApi\Generator::scan([$ROOT_PATH . '/controllers']);
header('Content-Type: application/json');
echo $openapi->toJson();