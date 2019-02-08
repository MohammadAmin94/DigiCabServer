<?php
require_once '../include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if(isset($_REQUEST['Status']) && isset($_REQUEST['DriverID']) && isset($_REQUEST['CarLat']) && isset($_REQUEST['CarLng'])){
    $did=$_REQUEST['DriverID'];
    $status=$_REQUEST['Status'];
    $lat=$_REQUEST['CarLat'];
    $lng=$_REQUEST['CarLng'];

    $cngStatus=$db->changeCarCoordinate($status,$did,$lat,$lng);

    if($cngStatus){
        $response["error"] = FALSE;
        //$response["did"] = $detail["DriverID"];
        $response["Status"] = $cngStatus["Status"];
        $response["CarLat"] = $cngStatus["CarLat"];
        $response["CarLng"] = $cngStatus["CarLng"];
        echo json_encode($response);
    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in get details!";
        echo json_encode($response);
    }
}else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (status, driverID, lat or lng) is missing!";
    echo json_encode($response);
}