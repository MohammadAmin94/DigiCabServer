<?php
require_once '../include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if(isset($_REQUEST['DriverLat']) && isset($_REQUEST['DriverLng'])) {
    $lat = $_REQUEST['DriverLat'];
    $lng = $_REQUEST['DriverLng'];

    $reqTrip = $db->requestedTrips($lat, $lng);
    if ($reqTrip) {
        $response['trips'] = $reqTrip;
        $i = 0;
        while (isset($reqTrip[$i])) {

            $i++;
        }
        $response['count'] = $i;
        //$response['count']=$i;
        echo json_encode($response);

    } else {//CHECK :if requested trip not available
        $response["error"] = TRUE;
        $response['Count'] = 0;
        $response["error_msg"] = "Unknown error occurred in get details!";
        echo json_encode($response);
    }
}else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (lat or lng) is missing!";
    echo json_encode($response);
}