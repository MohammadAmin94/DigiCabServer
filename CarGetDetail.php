<?php
require_once 'include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if(isset($_REQUEST['DriverID'])){
    $did=$_REQUEST['DriverID'];

    $detail=$db->getCarDetails($did);

    if($detail){
        $response["error"] = FALSE;
        //$response["did"] = $detail["DriverID"];
        $response["Model"] = $detail["Model"];
        $response["Color"] = $detail["Color"];
        $response["Plate"] = $detail["Plate"];
        echo json_encode($response);
    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in get details!";
        echo json_encode($response);
    }
}else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameter DRIVERID is missing!";
    echo json_encode($response);
}