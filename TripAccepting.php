<?php
require_once 'include/DB_Function.php';
$db=new DB_Functions();

$response = array("error" => FALSE);

if(isset($_REQUEST['TripID']) && isset($_REQUEST['DriverID'])){
    $tid=$_REQUEST['TripID'];
    $did=$_REQUEST['DriverID'];

    $accept=$db->acceptTrip($tid,$did);
    if($accept){
        $response['error']=FALSE;
        $response['TripID']=$accept['TripID'];
        $response['PassengerID']=$accept['PassengerID'];
        $response['DriverID']=$accept['DriverID'];
        $response['Price']=$accept['Price'];
        $response['Status']=$accept['Status'];
        /*$response['BegLat']=$accept['BegLat'];
        $response['BegLng']=$accept['BegLng'];
        $response['BegAdr']=$accept['BegAdr'];
        $response['DestLat']=$accept['DestLat'];
        $response['DestLng']=$accept['DestLng'];
        $response['DestAdr']=$accept['DestAdr'];*/
        echo json_encode($response);

    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in accepting!";
        echo json_encode($response);
    }

}else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (TripID or DriverID) is missing!";
    echo json_encode($response);
}