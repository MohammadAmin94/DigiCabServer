<?php
require_once 'include/DB_Function.php';
$db=new DB_Functions();

$response = array("error" => FALSE);

if(isset($_REQUEST['TripID']) && isset($_REQUEST['Status'])){
    $tid=$_REQUEST['TripID'];
    $status=$_REQUEST['Status'];

    $cancel=$db->cancelTrip($tid,$status);
    if($cancel){
        $response['error']=FALSE;
        $response['TripID']=$cancel['TripID'];
        $response['PassengerID']=$cancel['PassengerID'];
        $response['DriverID']=$cancel['DriverID'];
        $response['Price']=$cancel['Price'];
        $response['Status']=$cancel['Status'];
        $response['BegLat']=$cancel['BegLat'];
        $response['BegLng']=$cancel['BegLng'];
        $response['BegAdr']=$cancel['BegAdr'];
        $response['DestLat']=$cancel['DestLat'];
        $response['DestLng']=$cancel['DestLng'];
        $response['DestAdr']=$cancel['DestAdr'];
        echo json_encode($response);

    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in canceling!";
        echo json_encode($response);
    }

}else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (TripID or DriverID) is missing!";
    echo json_encode($response);
}