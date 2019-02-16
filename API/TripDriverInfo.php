<?php
require_once '../include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if(isset($_REQUEST['TripID'])) {
    $tid = $_REQUEST['TripID'];
    $detect=$db->detectDriverByUser($tid);

    if(!is_null($detect['DriverID'])){
        $did=$detect['DriverID'];
        $driverRate=$db->getDriverRate($did);
        if ($driverRate){
            //$response=$driverRate;
            $i=0;
            $rate =0;
            while (isset($driverRate[$i])){
                if (!is_null($driverRate[$i]['Rate'])){
                    $rate+=$driverRate[$i]['Rate'];
                    $i++;
                }
            }
            $avgRate=$rate/$i;
            $response['AvgRate']=$avgRate;

        }else{
            $response['AvgRate']=0;
        }
        $driverInfo=$db->getDriverInfo($did);
        if($driverInfo){
            $response['DriverID']=$detect['DriverID'];
            $response['Name']=$driverInfo['Name'];
            $response['Phone']=$driverInfo['Phone'];
            $response['Model']=$driverInfo['Model'];
            $response['Color']=$driverInfo['Color'];
            $response['Plate']=$driverInfo['Plate'];
            echo json_encode($response);
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "Somthing Worng with Driver Details";
            echo json_encode($response);
        }
    }else{
        $response["error"] = TRUE;
        $response["error_msg"] = "No Driver";
        echo json_encode($response);
    }
}else{
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (TripID) is missing!";
    echo json_encode($response);
}