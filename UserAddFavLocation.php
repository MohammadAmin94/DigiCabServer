<?php

require_once 'include/DB_Function.php';
$db=new DB_Functions();

$response = array("error" => FALSE);

if (isset($_REQUEST['PassengerID']) && isset($_REQUEST['Name']) && isset($_REQUEST['FavLat']) && isset($_REQUEST['FavLng'])){
    $pid=$_REQUEST['PassengerID'];
    $name=$_REQUEST['Name'];
    $favLat=$_REQUEST['FavLat'];
    $favLng=$_REQUEST['FavLng'];
    if (isset($_REQUEST['FavAdrDetail'])){
        $favAdr=$_REQUEST['FavAdrDetail'];
    }else{
        $favAdr=null;
    }

    $setFav=$db->setFavAddress($pid,$name,$favLat,$favLng,$favAdr);
    if ($setFav){
        $response['error']=FALSE;
        $response['FavID']=$setFav['FavID'];
        $response['PassengerID']=$setFav['PassengerID'];
        $response['Name']=$setFav['Name'];
        $response['FavLat']=$setFav['FavLat'];
        $response['FavLng']=$setFav['FavLng'];
        $response['FavAdrDetail']=$setFav['FavAdrDetail'];
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