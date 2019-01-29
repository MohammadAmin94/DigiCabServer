<?php

require_once 'include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_REQUEST['Name']) && isset($_REQUEST['Phone']) && isset($_REQUEST['Email']) && isset($_REQUEST['Password'])) {

    // receiving the post params
    $name = $_REQUEST['Name'];
    $phone = $_REQUEST['Phone'];
    $email = $_REQUEST['Email'];
    $password = $_REQUEST['Password'];

    //check email is valid
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){

        // check if user is already existed with the same email
        if ($db->isDriverExisted($email)) {
            // user already existed
            $response["error"] = TRUE;
            $response["error_msg"] = "Driver already existed with " . $email;
            echo json_encode($response);
        } else {
            // create a new user
            $driver = $db->storeDriver($name, $phone, $email, $password);
            if ($driver) {
                // user stored successfully
                $response["error"] = FALSE;
                $response["DriverID"] = $driver["DriverID"];
                $response["Name"] = $driver["Name"];
                $response["Phone"] = $driver["Phone"];
                $response["Email"] = $driver["Email"];
                //$response["Verified"] = $driver["Verified"];
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = TRUE;
                $response["error_msg"] = "Unknown error occurred in registration!";
                echo json_encode($response);
            }
        }
    } else {
        // driver email is unvalid
        $response["error"] = TRUE;
        $response["error_msg"] = "email parameter is unvalid!";
        echo json_encode($response);

    }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, phone, email or password) is missing!";
    echo json_encode($response);
}
