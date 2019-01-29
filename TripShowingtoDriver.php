<?php
require_once 'include/DB_Function.php';
$db=new DB_Functions();

$response = array("error" => FALSE);

if(isset($_REQUEST['DriverID'])){
    $did=$_REQUEST['DriverID'];

    $show2driver=$db->showTrip2Driver($did);
    if($show2driver){
        $response['error']=FALSE;
        $response['trips']=$show2driver;

        $i=0;
        $f=0;
        $c=0;
        $p=0;
        $r=0;
        $sumRate=0;
        while (isset($show2driver[$i])) {
            if ($show2driver[$i]['Status']=="Finished"){
                $f++;

                $p+=$show2driver[$i]['Price'];

                if ($show2driver[$i]['Rate']!=NULL){
                    $r++;
                    $sumRate+=$show2driver[$i]['Rate'];

                }
            }elseif ($show2driver[$i]['Status']=="Cancel By Driver" || $show2driver[$i]['Status']=="Cancel By Passenger"){
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
        $response["error_msg"] = "Unknown error occurred in registration!";
        echo json_encode($response);
    }

}else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (TripID or DriverID) is missing!";
    echo json_encode($response);
}