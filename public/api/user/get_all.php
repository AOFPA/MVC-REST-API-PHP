<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET");

//path
$ROOT_PATH = str_replace("/api/user" , "" , __DIR__);
$CONTROLLER_PATH = $ROOT_PATH . '/controllers' ;

// echo __DIR__ ;

//call UserController 
require_once($CONTROLLER_PATH . '/User/UserController.php');

//use userController
$userController = new UserController();
$stmt = $userController->getUserAll();


if($stmt){
    $resultCount = $stmt->rowCount($stmt);
    // $resultCount = 2 ;

    if($resultCount > 0){
        http_response_code(200);
        $arr = array();
        $arr['response'] = array(); 
        $arr['count'] = $resultCount;
        $arr['code'] = 200;
        $arr['status'] = 'success';
        $arr['message'] = $resultCount . " records";

        while($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
            array_push($arr['response'],$row);
        }
        echo json_encode($arr);

    }else{
        http_response_code(200);
        $arr = array();
        $arr['count'] = $resultCount;
        $arr['code'] = 200;
        $arr['status'] = 'success';
        $arr['message'] = "No Data";

        echo json_encode($arr);
    }


    
}else{
    http_response_code(400);
        $arr = array();
        $arr['count'] = $resultCount;
        $arr['code'] = 400;
        $arr['status'] = 'error';
        $arr['message'] = "SQL ERROR";

        echo json_encode($arr);
}

//debug
// print_r($resultCount);

?>