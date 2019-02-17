<?php
require_once '../include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_REQUEST['Email']) && isset($_REQUEST['Password'])) {

    // receiving the post params
    $email = $_REQUEST['Email'];
    $password = $_REQUEST['Password'];

    // get the driver by email and password
    $driver = $db->getDriverByEmailAndPassword($email, $password);

    if ($driver) {
        // driver is found
        $response["error"] = FALSE;
        $response["DriverID"] = $driver["DriverID"];
        $response["Name"] = $driver["Name"];
        $response["Phone"] = $driver["Phone"];
        $response["Email"] = $driver["Email"];

        echo json_encode($response);
    } else {
        // driver is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
    echo json_encode($response);
}
?>