<?php
require_once 'include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if(isset($_REQUEST['Status']) && isset($_REQUEST['DriverID'])){
    $did=$_REQUEST['DriverID'];
    $status=$_REQUEST['Status'];

    $cngStatus=$db->changeCarStatus($status,$did);

    if($cngStatus){
        $response["error"] = FALSE;
        $response["CarID"] = $cngStatus["CarID"];
        $response["DriverID"] = $cngStatus["DriverID"];
        $response["Status"] = $cngStatus["Status"];
        echo json_encode($response);
    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in get details!";
        echo json_encode($response);
    }
}else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (status or driverID) is missing!";
    echo json_encode($response);
}