<?php
require_once '../include/DB_Function.php';
$db=new DB_Functions();

$response = array("error" => FALSE);
$i=0;
$f=0;
$c=0;
$p=0;
$r=0;
$sumRate=0;

if(isset($_REQUEST['PassengerID'])){
    $pid=$_REQUEST['PassengerID'];

    $show2user=$db->showTrip2User($pid);
    if($show2user){

        $response['error']=FALSE;
        $response['trips']=$show2user;


        while (isset($show2user[$i])) {

            if ($show2user[$i]['Status']=="Finished"){
                $f++;

                $p+=$show2user[$i]['Price'];

                if ($show2user[$i]['Rate']!=NULL){
                    $r++;
                    $sumRate+=$show2user[$i]['Rate'];
                }

            }elseif ($show2user[$i]['Status']=="Cancel By Driver" || $show2user[$i]['Status']=="Cancel By Passenger"){
                $c++;
            }

            $i++;
        }

        //count all trips
        $response['count'] = $i;

        //count cancel trips
        $response['CanceledTrip']=$c;

        //count finish trips
        $response['FinishedTrip']=$f;

        //count all income
        $response['Income']=$p;

        //get average rate of driver
        if ($r==0){
            $response['AvgRate']=$r;
        }else{
            $avgRate=$sumRate/$r;
            $response['AvgRate']=$avgRate;
        }


        echo json_encode($response);

    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred in show history trips!";
        echo json_encode($response);
    }

}else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (TripID or DriverID) is missing!";
    echo json_encode($response);
}