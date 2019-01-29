<?php
require_once 'include/DB_Function.php';
$db=new DB_Functions();

$response = array("error" => FALSE);

if(isset($_REQUEST['TripID']) && isset($_REQUEST['Rate'])){
    $tid=$_REQUEST['TripID'];
    $rate=$_REQUEST['Rate'];

    $tRate=$db->rateTrip($tid,$rate);
    if($tRate){
        $response['error']=FALSE;
        $response['TripID']=$tRate['TripID'];
        $response['PassengerID']=$tRate['PassengerID'];
        $response['DriverID']=$tRate['DriverID'];
        $response['StartTime']=$tRate['StartTime'];
        $response['EndTime']=$tRate['EndTime'];
        $response['Price']=$tRate['Price'];
        $response['Status']=$tRate['Status'];
        $response['BegLat']=$tRate['BegLat'];
        $response['BegLng']=$tRate['BegLng'];
        $response['BegAdr']=$tRate['BegAdr'];
        $response['DestLat']=$tRate['DestLat'];
        $response['DestLng']=$tRate['DestLng'];
        $response['DestAdr']=$tRate['DestAdr'];
        $response['Rate']=$tRate['Rate'];
        echo json_encode($response);

    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in registration!";
        echo json_encode($response);
    }

}else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (TripID or DriverID) is missing!";
    echo json_encode($response);
}