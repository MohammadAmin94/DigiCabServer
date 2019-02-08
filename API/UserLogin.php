<?php
require_once '../include/DB_Function.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_REQUEST['Email']) || isset($_REQUEST['Password'])) {

    // receiving the post params
    $email = $_REQUEST['Email'];
    $password = $_REQUEST['Password'];

    // get the user by email and password
    $user = $db->getUserByEmailAndPassword($email, $password);

    if ($user) {
        // use is found
        $response["error"] = FALSE;
        $response["PassengerID"] = $user["PassengerID"];
        $response["Name"] = $user["Name"];
        $response["Phone"] = $user["Phone"];
        $response["Email"] = $user["Email"];
        //$response["Password"] = $user["Password"];
        //$response["Verified"] = $user["Verified"];
        echo json_encode($response);
    } else {
        // user is not found with the credentials
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