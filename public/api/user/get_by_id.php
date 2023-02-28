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

$params = array();
$params['id'] = isset($id) && !empty($id) ? $id : "" ;

$data = json_encode($params);
$data = json_decode($data);

$userController->id = $data->id ;

if($data->id == ""){
    http_response_code(200);
    $arr = array();
    $arr['code'] = 204;
    $arr['status'] = 'error';
    $arr['message'] = "No id";

    echo json_encode($arr);
}else{
    $stmt = $userController->getUserById();
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
    
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
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
}

?>