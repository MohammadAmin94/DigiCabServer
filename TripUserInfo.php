<?php
require_once 'include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if(isset($_REQUEST['PassengerID'])){
    $pid=$_REQUEST['PassengerID'];

    $userInfo=$db->getUserInfo($pid);
    if($userInfo){
        $response['Name']=$userInfo['Name'];
        $response['Phone']=$userInfo['Phone'];
        echo json_encode($response);
    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in get user info!";
        echo json_encode($response);
    }
}else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Required parameter PassengerID is missing!";
        echo json_encode($response);
}