<?php

class DB_Functions
{

    private $conn;

    // constructor
    function __construct()
    {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct()
    {

    }

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $phone, $email, $password)
    {
        $randomId=rand(1,9999999);
        $verify="Yes";
        $pass=md5($password);
        $stmt = $this->conn->prepare("INSERT INTO passenger(PassengerID, Name, Phone, Email, Password, Verified) VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $randomId, $name, $phone, $email, $pass, $verify);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM passenger WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return false;
        }
    }


    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT Email from passenger WHERE Email = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }


    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM passenger WHERE Email = ?");

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            $p=md5($password);
            // verifying user password
            $pass = $user['Password'];
            // check for password equality
            if ($p == $pass) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }


    /**
     * Storing new driver
     * returns driver details
     */
    public function storeDriver($name, $phone, $email, $password)
    {
        $randomId=rand(1,9999999);
        $verify="Yes";
        $pass=md5($password);
        $stmt = $this->conn->prepare("INSERT INTO driver(DriverID, Name, Phone, Email, Password, Verified) VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $randomId, $name, $phone, $email, $pass, $verify);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM driver WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $driver = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $driver;
        } else {
            return false;
        }
    }


    /**
     * Check driver is existed or not
     */
    public function isDriverExisted($email) {
        $stmt = $this->conn->prepare("SELECT Email from driver WHERE Email = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }


    /**
     * Get driver by email and password
     */
    public function getDriverByEmailAndPassword($email, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM driver WHERE Email = ?");

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $driver = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            $p=md5($password);
            // verifying user password
            $pass = $driver['Password'];
            // check for password equality
            if ($p == $pass) {
                // user authentication details are correct
                return $driver;
            }
        } else {
            return NULL;
        }
    }


    /**
     * Storing car detail
     * returns car details
     */
    public function storeCarDetails($did,$model,$color,$plate){
        $randomId=rand(1,9999999);
        $lat="0";
        $lng="0";
        $status="offline";
        $stmt=$this->conn->prepare("INSERT INTO car(CarID, DriverID, Model, Color, Plate, Status, CarLat, CarLng) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissssss",$randomId, $did, $model, $color, $plate, $status, $lat, $lng);
        $result=$stmt->execute();
        $stmt->close();

        if($result){
            $stmt = $this->conn->prepare("SELECT * FROM car WHERE DriverID = ?");
            $stmt->bind_param("i", $did);
            $stmt->execute();
            $car = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $car;
        }else{
            return false;
        }
    }


    /**
     * Getting car detail
     * returns car details
     */
    public function getCarDetails($did){
        $stmt=$this->conn->prepare("SELECT Model,Color,Plate FROM car WHERE DriverID = ?");
        $stmt->bind_param("i", $did);
        $stmt->execute();
        $carDetail = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $carDetail;
    }

    /**
     * Changing car status
     * returns car status
     */
    public function changeCarStatus($status,$did){
        $ustmt=$this->conn->prepare("UPDATE car SET Status = ? WHERE DriverID = ?");
        $ustmt->bind_param("si",$status,$did);
        $ustmt->execute();
        $ustmt->close();
        $stmt=$this->conn->prepare("SELECT CarID,DriverID,Status FROM car WHERE DriverID = ?");
        $stmt->bind_param("i", $did);
        $stmt->execute();
        $carStatus=$stmt->get_result()->fetch_assoc();
        $stmt->close();
        return$carStatus;
    }


    /**
     * Changing car coordinate
     * returns car coordinate
     */
    public function changeCarCoordinate($status,$did,$lat,$lng){
        $ustmt=$this->conn->prepare("UPDATE car SET CarLat = ?,CarLng = ? WHERE DriverID = ? AND Status = ?");
        $ustmt->bind_param("ssis",$lat,$lng,$did,$status);
        $ustmt->execute();
        $ustmt->close();
        $stmt=$this->conn->prepare("SELECT Status,CarLat,CarLng FROM car WHERE DriverID = ? And Status = ?");
        $stmt->bind_param("is", $did,$status);
        $stmt->execute();
        $carCoord=$stmt->get_result()->fetch_assoc();
        $stmt->close();
        return$carCoord;
    }


    /**
     * gets online car coordinates
     * returns online cars
     */
    public function onlineCarsCount($lat,$lng){
        $stmt=$this->conn->prepare(
"SELECT CarID, DriverID, CarLat, CarLng, 
( 6371 * 
acos( cos( radians(?) ) * 
cos( radians( CarLat ) ) * 
cos( radians( CarLng ) - radians(?) ) + sin( radians(?) ) * 
sin( radians( CarLat ) ) ) ) 
AS distance 
FROM car 
WHERE Status = 'online' 
HAVING distance < 3
ORDER BY distance 
LIMIT 0 , 25");
        $stmt->bind_param("sss",$lat,$lng,$lat);
        $stmt->execute();

        $row=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        /*=while ($row=$stmt->get_result()->fetch_assoc()){
            $rows=$row;
        }*/
        $stmt->close();
        return $row;
    }


    /**
     * set trip in db
     * returns trip detail
     */
    public function tripSetting($pid,$price,$bLat,$bLng,$bAdr,$dLat,$dLng,$dAdr){
        $randomId=rand(1,9999999);
        $status='Requested';
        $stmt=$this->conn->prepare("INSERT INTO trips
(TripID, PassengerID, DriverID, StartTime, EndTime, Price, Status, BegLat, BegLng, BegAdr, DestLat, DestLng, DestAdr, Rate) 
VALUES (?, ?, null , null , null , ?, ?, ?, ?, ?, ?, ?, ?, null )");
        $stmt->bind_param("iiisssssss",$randomId,$pid,$price,$status,$bLat,$bLng,$bAdr,$dLat,$dLng,$dAdr);
        $result=$stmt->execute();
        $stmt->close();

        if($result){
            $stmt=$this->conn->prepare("SELECT * FROM trips WHERE TripID = ?");
            $stmt->bind_param("i", $randomId);
            $stmt->execute();
            $trip = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $trip;
        } else {
            return false;
        }
    }


    /**
     * Requesting trip (show nearest trip of driver)
     * returns trips detail
     */
    public function requestedTrips($lat,$lng){
        $status='Requested';
        $stmt=$this->conn->prepare("SELECT *, 
( 6371 * 
acos( cos( radians(?) ) * 
cos( radians( BegLat ) ) * 
cos( radians( BegLng ) - radians(?) ) + sin( radians(?) ) * 
sin( radians( BegLat ) ) ) ) 
AS distance 
FROM trips 
WHERE DriverID IS NULL And Status = ? 
HAVING distance < 5 
ORDER BY distance 
LIMIT 0 , 5");
        $stmt->bind_param("ssss" ,$lat, $lng, $lat, $status);
        $stmt->execute();
        $trips=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $trips;
    }


    /**
     * showing trip (to drivers when user request trip)
     * returns trips detail
     */
    public function getUserInfo($pid){
        $stmt=$this->conn->prepare("SELECT Name,Phone FROM passenger INNER JOIN trips ON passenger.PassengerID = trips.PassengerID WHERE trips.PassengerID = ?");
        $stmt->bind_param("i" ,$pid);
        $stmt->execute();
        $trips=$stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $trips;
    }


    /**
     * accept trip
     * returns trips detail
     */
    public function acceptTrip($tid,$did){
        $status='Acceptedَ';
        $stmt=$this->conn->prepare("UPDATE trips SET Status = ?,DriverID = ? WHERE TripID = ?");
        $stmt->bind_param("sii", $status, $did, $tid);
        $stmt->execute();
        $stmt->close();
        $stmt2=$this->conn->prepare("SELECT * FROM trips WHERE TripID = ?");
        $stmt2->bind_param("i" ,$tid);
        $stmt2->execute();
        $acc=$stmt2->get_result()->fetch_assoc();
        $stmt2->close();
        return $acc;
    }


    /**
     * detect driver (to passenger when driver accept trip)
     * returns trips detail
     */
    public function detectDriverByUser($tid){
        $stmt=$this->conn->prepare("SELECT DriverID FROM trips WHERE TripID = ?");
        $stmt->bind_param("i" ,$tid);
        $stmt->execute();
        $trips=$stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $trips;
    }


    /**
     * showing trip (to passenger when driver accept trip)
     * returns trips detail
     */
    public function getDriverInfo($did){
        $stmt=$this->conn->prepare("SELECT Name,Phone,Model,Color,Plate FROM car INNER JOIN driver ON car.DriverID = driver.DriverID WHERE car.DriverID = ?");
        $stmt->bind_param("i" ,$did);
        $stmt->execute();
        $trips=$stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $trips;
    }


    /**
     * get all rates of this driver
     * returns all rates
     */
    public function getDriverRate($did){
        $status="Finished";
        $stmt=$this->conn->prepare("SELECT Rate FROM trips WHERE DriverID = ? AND Status = ?");
        $stmt->bind_param("is" ,$did,$status);
        $stmt->execute();
        $trips=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $trips;
    }



    /**
     * show trip detail to user
     * returns trips detail
     */
    public function showTrip2User($pid)
    {
        //$status='Finished';
        $stmt = $this->conn->prepare("SELECT 
trips.TripID,trips.BegAdr,trips.DestAdr,trips.StartTime,trips.EndTime,trips.Price,trips.Status,trips.Rate,driver.Name,driver.Phone,car.Model,car.Color,car.Plate 
FROM trips INNER JOIN driver ON trips.DriverID=driver.DriverID 
INNER JOIN car ON driver.DriverID = car.DriverID 
WHERE trips.PassengerID = ? AND trips.DriverID IS NOT NULL ");
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $toUser = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $toUser;
    }




    /**
     * show trip detail to driver
     * returns trips detail
     */
    public function showTrip2Driver($did){
        //$status='Finished';
        $stmt=$this->conn->prepare("SELECT BegAdr,DestAdr,StartTime,EndTime,Price,Status,Rate FROM trips WHERE DriverID = ?");
        $stmt->bind_param("i" ,$did);
        $stmt->execute();
        $toDriver=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $toDriver;
    }


    /**
     * show coordinate car to user
     * returns coordinate car
     */
    public function showCoordinateCar2User($did){
        $stmt=$this->conn->prepare("SELECT CarLat,CarLng FROM car INNER JOIN trips ON car.DriverID = trips.DriverID WHERE trips.DriverID = ?");
        $stmt->bind_param("i" ,$did);
        $stmt->execute();
        $coordCar=$stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $coordCar;
    }


    /**
     * start trip when driver arrive to user
     * returns trip detail
     */
    public function startTrip($tid,$start){
        $status='Started';
        $stmt=$this->conn->prepare("UPDATE trips SET StartTime = ?,Status = ? WHERE TripID = ?");
        $stmt->bind_param("ssi" ,$start,$status,$tid);
        $stmt->execute();
        $stmt->close();
        $stmt2=$this->conn->prepare("SELECT * FROM trips WHERE TripID = ?");
        $stmt2->bind_param("i" ,$tid);
        $stmt2->execute();
        $acc=$stmt2->get_result()->fetch_assoc();
        $stmt2->close();
        return $acc;
    }


    /**
     * end trip when driver take off user
     * returns trip detail
     */
    public function endTrip($tid,$end){
        $status='Finished';
        $stmt=$this->conn->prepare("UPDATE trips SET EndTime = ?,Status = ? WHERE TripID = ?");
        $stmt->bind_param("ssi" ,$end,$status,$tid);
        $stmt->execute();
        $stmt->close();
        $stmt2=$this->conn->prepare("SELECT * FROM trips WHERE TripID = ?");
        $stmt2->bind_param("i" ,$tid);
        $stmt2->execute();
        $acc=$stmt2->get_result()->fetch_assoc();
        $stmt2->close();
        return $acc;
    }


    /**
     * cancel trip by user or driver
     * returns trip detail
     */
    public function cancelTrip($tid,$status){
        $stmt=$this->conn->prepare("UPDATE trips SET Status = ? WHERE TripID = ?");
        $stmt->bind_param("si" ,$status,$tid);
        $stmt->execute();
        $stmt->close();
        $stmt2=$this->conn->prepare("SELECT * FROM trips WHERE TripID = ?");
        $stmt2->bind_param("i" ,$tid);
        $stmt2->execute();
        $acc=$stmt2->get_result()->fetch_assoc();
        $stmt2->close();
        return $acc;
    }


    /**
     * rate trip by user
     * returns trip detail
     */
    public function rateTrip($tid,$rate){
        $stmt=$this->conn->prepare("UPDATE trips SET Rate = ? WHERE TripID = ?");
        $stmt->bind_param("ii" ,$rate,$tid);
        $stmt->execute();
        $stmt->close();
        $stmt2=$this->conn->prepare("SELECT * FROM trips WHERE TripID = ?");
        $stmt2->bind_param("i" ,$tid);
        $stmt2->execute();
        $acc=$stmt2->get_result()->fetch_assoc();
        $stmt2->close();
        return $acc;
    }


    /**
     * give status of trip to user
     * returns trip detail
     */
    public function giveStatus($tid){
        $stmt=$this->conn->prepare("SELECT * FROM trips WHERE TripID = ?");
        $stmt->bind_param("i" ,$tid);
        $stmt->execute();
        $status=$stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $status;
    }


    /**
     * save favorite location
     * returns favLoc detail
     */
    public function setFavAddress($pid,$name,$favLat,$favLng,$favAdr){
        $randomId=rand(1,9999999);
        $stmt = $this->conn->prepare("INSERT INTO fav_adr(FavID, PassengerID, Name, FavLat, FavLng, FavAdrDetail) VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $randomId, $pid, $name, $favLat, $favLng, $favAdr);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM fav_adr WHERE FavID= ?");
            $stmt->bind_param("i", $randomId);
            $stmt->execute();
            $fav = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $fav;
        } else {
            return false;
        }
    }


    /**
     * returns favLoc detail
     */
    public function getFavAddress($pid){
        $stmt = $this->conn->prepare("SELECT * FROM fav_adr WHERE PassengerID= ?");
        $stmt->bind_param("i",$pid);
        $stmt->execute();
        $getFav = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $getFav;

    }

    /**
     * delete favorite location
     * returns favLoc detail
     */
    public function deleteFavAddress($fid){
        $stmt = $this->conn->prepare("DELETE FROM fav_adr WHERE FavID= ?");
        $stmt->bind_param("i",$fid);
        $stmt->execute();
        $stmt->close();

        if ($stmt){
            return true;
        }else{
            return false;
        }
    }

    /**
     * find out when user cancel the trip
     */
    public function getSituationCacnelByPassenger($tid,$did){
        $stmt = $this->conn->prepare("SELECT Status FROM trips WHERE TripID= ? AND  DriverID= ?");
        $stmt->bind_param("ii",$tid,$did);
        $stmt->execute();
        $getFav = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $getFav;
    }


    /**
     * find out when user cancel the trip
     */
    public function getSituationCacnelByDriver($tid,$pid){
        $stmt = $this->conn->prepare("SELECT Status FROM trips WHERE TripID= ? AND  PassengerID= ?");
        $stmt->bind_param("ii",$tid,$pid);
        $stmt->execute();
        $getFav = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $getFav;
    }
}