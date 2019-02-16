<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname="taxifinder-db";
$connection = mysqli_connect($server,$username,$password);
mysqli_select_db($connection,$dbname);
mysqli_set_charset($connection,"utf8");
?>