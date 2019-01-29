<?php
require_once 'include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if(isset($_REQUEST['TripID'])) {
    $tid = $_REQUEST['TripID'];
    $getStaus=$db->giveStatus($tid);
    if($getStaus){
        $response['error']=FALSE;
        $response['TripID']=$getStaus['TripID'];
        $response['DriverID']=$getStaus['DriverID'];
        $response['PassengerID']=$getStaus['PassengerID'];
        $response['StartTime']=$getStaus['StartTime'];
        $response['EndTime']=$getStaus['EndTime'];
        $response['Price']=$getStaus['Price'];
        $response['Status']=$getStaus['Status'];
       /* $response['BegLat']=$getStaus['BegLat'];
        $response['BegLng']=$getStaus['BegLng'];*/
        $response['BegAdr']=$getStaus['BegAdr'];
        /*$response['DestLat']=$getStaus['DestLat'];
        $response['DestLng']=$getStaus['DestLng'];*/
        $response['DestAdr']=$getStaus['DestAdr'];
        $response['Rate']=$getStaus['Rate'];
        echo json_encode($response);
    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Somthing Worng with trip detail";
        echo json_encode($response);
    }
}else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (TripID) is missing!";
    echo json_encode($response);
}