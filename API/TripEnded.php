<?php
require_once '../include/DB_Function.php';
$db=new DB_Functions();

$response = array("error" => FALSE);

if(isset($_REQUEST['TripID']) && isset($_REQUEST['EndTime'])){
    $tid=$_REQUEST['TripID'];
    $eTime=$_REQUEST['EndTime'];

    $end=$db->endTrip($tid,$eTime);
    if($end){
        $response['error']=FALSE;
        $response['TripID']=$start['TripID'];
        $response['PassengerID']=$start['PassengerID'];
        $response['DriverID']=$start['DriverID'];
        $response['StartTime']=$start['StartTime'];
        $response['EndTime']=$start['EndTime'];

        echo json_encode($response);

    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in trip ending!";
        echo json_encode($response);
    }

}else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (TripID or DriverID) is missing!";
    echo json_encode($response);
}