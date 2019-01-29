<?php
require_once 'include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_REQUEST['PassengerID'])
    && isset($_REQUEST['Price'])
    && isset($_REQUEST['BegLat'])
    && isset($_REQUEST['BegLng'])
    && isset($_REQUEST['BegAdr'])
    && isset($_REQUEST['DestLat'])
    && isset($_REQUEST['DestLng'])
    && isset($_REQUEST['DestAdr'])
) {

    // receiving the post params
    $pid = $_REQUEST['PassengerID'];
    $price = $_REQUEST['Price'];
    $blat = $_REQUEST['BegLat'];
    $blng = $_REQUEST['BegLng'];
    $bard = $_REQUEST['BegAdr'];
    $dlat = $_REQUEST['DestLat'];
    $dlng = $_REQUEST['DestLng'];
    $dadr = $_REQUEST['DestAdr'];

    $trip=$db->tripSetting($pid,$price,$blat,$blng,$bard,$dlat,$dlng,$dadr);

    if($trip){
        $response['error']=FALSE;
        $response['TripID']=$trip['TripID'];
        $response['PassengerID']=$trip['PassengerID'];
        $response['Price']=$trip['Price'];
        $response['Status']=$trip['Status'];
        $response['BegLat']=$trip['BegLat'];
        $response['BegLng']=$trip['BegLng'];
        $response['BegAdr']=$trip['BegAdr'];
        $response['DestLat']=$trip['DestLat'];
        $response['DestLng']=$trip['DestLng'];
        $response['DestAdr']=$trip['DestAdr'];
        echo json_encode($response);
    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in trip setting!";
        echo json_encode($response);
    }
}else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (...) is missing!";
    echo json_encode($response);
}
