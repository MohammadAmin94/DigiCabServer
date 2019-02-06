<?php

require_once 'include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if(isset($_REQUEST['TripID']) && isset($_REQUEST['PassengerID'])) {
    $tid = $_REQUEST['TripID'];
    $pid = $_REQUEST['PassengerID'];

    $userCanceled=$db->getSituationCacnelByDriver($tid,$pid);
    if ($userCanceled['Status']=="Cancel By Driver"){
        $response["error"] = false;
        $response["error_msg"] = "Trip was Cancel By Driver";
        echo json_encode($response);
    }else{
        $response["error"] = false;
        $response["error_msg"] = null;
        echo json_encode($response);
    }
}else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (TripID,PassengerID) is missing!";
    echo json_encode($response);
}