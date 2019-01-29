<?php
require_once 'include/DB_Function.php';
$db=new DB_Functions();

$response = array("error" => FALSE);

if (isset($_REQUEST['PassengerID'])){
    $pid=$_REQUEST['PassengerID'];


    $getFav=$db->getFavAddress($pid);
    if ($getFav){
        $response['error']=FALSE;
        $response['favLocations']=$getFav;
        echo json_encode($response);
    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in favorite location setting!";
        echo json_encode($response);
    }



}else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (...) is missing!";
    echo json_encode($response);
}