<?php
session_start();
include 'config.php';
if (isset($_SESSION['Username']) && isset($_SESSION['Password'])){
    $query = mysqli_query($connection,"Select * From admins Where Username='".$_SESSION['Username']."' AND Password='".$_SESSION['Password']."'");
    $ans = mysqli_fetch_assoc($query);
    if (mysqli_num_rows($query)>0){
        echo '<div style="   z-index:100; padding-left:2%;right:5%;top:0px;left:5%;position:fixed;background:black;color:white;width:90%;float:top;text-align:left;border-bottom-left-radius: 15px;border-bottom-right-radius: 15px;        box-shadow: 0px 5px 4px #000000;">';
        echo "Logged in As ".$ans{'username'};
        echo "<br>Welcome ".$ans{'name'}."</div>";
    }else{die('<h2>Authenication Failed.Please Log in again.');}
}else{die('<h2>Authenication is too old.Please Log in again.');}
?>
