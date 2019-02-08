<?php

require_once '../include/DB_Function.php';
$db=new DB_Functions();

$response = array("error" => FALSE);

if (isset($_REQUEST['FavID'])){
    $fid=$_REQUEST['FavID'];


    $delFav=$db->deleteFavAddress($fid);
    if ($delFav){
        $response['error']=FALSE;
        $response['error_msg']="location deleted!";
        echo json_encode($response);

    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in delete favorite location setting!";
        echo json_encode($response);
    }



}else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (...) is missing!";
    echo json_encode($response);
}