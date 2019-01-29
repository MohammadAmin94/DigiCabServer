<?php
require_once 'include/DB_Function.php';
$db=new DB_Functions();

$response = array("error" => FALSE);

if(isset($_REQUEST['DriverID'])){
    $did=$_REQUEST['DriverID'];

    $updatecoord=$db->showCoordinateCar2User($did);
    if($updatecoord){
        $response['error']=FALSE;
        $response['CarLat']=$updatecoord['CarLat'];
        $response['CarLng']=$updatecoord['CarLng'];
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