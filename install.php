<?php
include 'config.php';
echo file_get_contents("./startbody.html");
echo file_get_contents("./head.html");
include 'menu.php';
//

mysqli_query($connection,"CREATE DATABASE IF NOT EXISTS ".$dbname);
mysqli_select_db($connection,$dbname);

$val1 = mysqli_query($connection,'select * from `car`');

if(!$val1)
{
mysqli_query($connection,
"CREATE TABLE `driver` (
  `DriverID` int(11) NOT NULL,
  `Name` text COLLATE utf8mb4_persian_ci NOT NULL,
  `Phone` text COLLATE utf8mb4_persian_ci NOT NULL,
  `Email` text COLLATE utf8mb4_persian_ci NOT NULL,
  `Password` text COLLATE utf8mb4_persian_ci NOT NULL,
  `Verified` text COLLATE utf8mb4_persian_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;"
);


mysqli_query($connection,
"CREATE TABLE `fav_adr` (
  `FavID` int(11) NOT NULL,
  `PassengerID` int(11) NOT NULL,
  `Name` text COLLATE utf8_persian_ci NOT NULL,
  `FavLat` text COLLATE utf8_persian_ci NOT NULL,
  `FavLng` text COLLATE utf8_persian_ci NOT NULL,
  `FavAdrDetail` text COLLATE utf8_persian_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;"
);


mysqli_query($connection,
"CREATE TABLE `passenger` (
  `PassengerID` int(11) NOT NULL,
  `Name` text COLLATE utf8_persian_ci NOT NULL,
  `Phone` text COLLATE utf8_persian_ci NOT NULL,
  `Email` text COLLATE utf8_persian_ci NOT NULL,
  `Password` text COLLATE utf8_persian_ci NOT NULL,
  `Verified` text COLLATE utf8_persian_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;"
);

mysqli_query($connection,
    "CREATE TABLE `trips` (
  `TripID` int(11) NOT NULL,
  `PassengerID` int(11) NOT NULL,
  `DriverID` int(11) DEFAULT NULL,
  `StartTime` text CHARACTER SET utf8 COLLATE utf8_persian_ci,
  `EndTime` text CHARACTER SET utf8 COLLATE utf8_persian_ci,
  `Price` int(11) NOT NULL,
  `Status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `BegLat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `BegLng` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `BegAdr` text CHARACTER SET utf8 COLLATE utf8_persian_ci,
  `DestLat` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `DestLng` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `DestAdr` text CHARACTER SET utf8 COLLATE utf8_persian_ci,
  `Rate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
    );

    mysqli_query($connection,
        "CREATE TABLE `admins` (
  `name` mediumtext COLLATE utf8mb4_persian_ci NOT NULL,
  `username` mediumtext COLLATE utf8mb4_persian_ci NOT NULL,
  `password` mediumtext COLLATE utf8mb4_persian_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;"
    );

    
mysqli_query($connection,"INSERT INTO admins  SET Username='admin', Password='123456', Name='Change Your Password'");

    echo "installed";
}
else
{
    echo "you have already installed system";
}

?>
<?php 
echo file_get_contents("./endbody.html");
?>