<?php
require_once '../include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_REQUEST['DriverID']) && isset($_REQUEST['Model']) && isset($_REQUEST['Color']) && isset($_REQUEST['Plate'])) {

    // receiving the post params
    $did = $_REQUEST['DriverID'];
    $model = $_REQUEST['Model'];
    $color = $_REQUEST['Color'];
    $plate = $_REQUEST['Plate'];

    $car=$db->storeCarDetails($did,$model,$color,$plate);

    if($car) {
        $response["error"] = FALSE;
        $response["CarID"] = $car["CarID"];
        $response["DriverID"] = $car["DriverID"];
        $response["Model"] = $car["Model"];
        $response["Color"] = $car["Color"];
        $response["Plate"] = $car["Plate"];
        echo json_encode($response);
    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in save details!";
        echo json_encode($response);
    }
}else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (model, color or plate) is missing!";
    echo json_encode($response);
}