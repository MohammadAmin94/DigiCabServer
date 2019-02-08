<?php

require_once '../include/DB_Function.php';
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
        if ($db->isUserExisted($email)) {
            // user already existed
            $response["error"] = TRUE;
            $response["error_msg"] = "User already existed with " . $email;
            echo json_encode($response);
        } else {
            // create a new user
            $user = $db->storeUser($name, $phone, $email, $password);
            if ($user) {
                // user stored successfully
                $response["error"] = FALSE;
                $response["PassengerID"] = $user["PassengerID"];
                $response["Name"] = $user["Name"];
                $response["Phone"] = $user["Phone"];
                $response["Email"] = $user["Email"];
                //$response["Verified"] = $user["Verified"];
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = TRUE;
                $response["error_msg"] = "Unknown error occurred in registration!";
                echo json_encode($response);
            }
        }
    } else {
        // user email is unvalid
        $response["error"] = TRUE;
        $response["error_msg"] = "email parameter is unvalid!";
        echo json_encode($response);

    }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, phone, email or password) is missing!";
    echo json_encode($response);
}
?>