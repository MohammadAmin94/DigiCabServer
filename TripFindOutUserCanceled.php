<?php

require_once 'include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if(isset($_REQUEST['TripID']) && isset($_REQUEST['DriverID'])) {
    $tid = $_REQUEST['TripID'];
    $did = $_REQUEST['DriverID'];

    $userCanceled=$db->getSituationCacnelByPassenger($tid,$did);
    if ($userCanceled['Status']=="Cancel By Passenger"){
        $response["error"] = false;
        $response["error_msg"] = "Trip was Cancel By Passenger";
        echo json_encode($response);
    }else{
        $response["error"] = false;
        $response["error_msg"] = null;
        echo json_encode($response);
    }
}else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (TripID,DriverID) is missing!";
    echo json_encode($response);
}