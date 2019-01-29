<?php
require_once 'include/DB_Function.php';
$db=new DB_Functions();

$response = array("error" => FALSE);

if(isset($_REQUEST['TripID']) && isset($_REQUEST['StartTime'])){
    $tid=$_REQUEST['TripID'];
    $sTime=$_REQUEST['StartTime'];

    $start=$db->startTrip($tid,$sTime);
    if($start){
        $response['error']=FALSE;
        $response['TripID']=$start['TripID'];
        $response['PassengerID']=$start['PassengerID'];
        $response['DriverID']=$start['DriverID'];
        $response['StartTime']=$start['StartTime'];
        /*$response['Price']=$start['Price'];
        $response['Status']=$start['Status'];
        $response['BegLat']=$start['BegLat'];
        $response['BegLng']=$start['BegLng'];
        $response['BegAdr']=$start['BegAdr'];
        $response['DestLat']=$start['DestLat'];
        $response['DestLng']=$start['DestLng'];
        $response['DestAdr']=$start['DestAdr'];*/
        echo json_encode($response);

    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in trip starting!";
        echo json_encode($response);
    }

}else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (TripID or DriverID) is missing!";
    echo json_encode($response);
}