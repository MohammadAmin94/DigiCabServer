<?php
require_once '../include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if(isset($_REQUEST['CarLat']) && isset($_REQUEST['CarLng'])) {
    $lat = $_REQUEST['CarLat'];
    $lng = $_REQUEST['CarLng'];

    $onlinecars=$db->onlineCarsCount($lat,$lng);

    if($onlinecars){

        $response['onCars']=$onlinecars;
        $i=0;
        while (isset($onlinecars[$i])){
            //$response[$i]=$onlinecars[$i];
            $i++;
        }
        $response['Count']=$i;
        //$response['cid']=$onlinecars[1]['CarID'];
        echo json_encode($response);

    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in get details!";
        echo json_encode($response);
    }

}else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (lat or lng) is missing!";
    echo json_encode($response);
}