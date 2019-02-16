
<?php
include 'config.php';
include 'authenicate.php';
echo file_get_contents("./startbody.html");
echo file_get_contents("./head.html");
include 'menu.php';
//
//ثابت ها در این مکان نگهداری می شود
$HLD_DRIVERID="DriverID";
$HLD_VERIFIED="Verified";
$HLD_PASSWORD="Password";
$HLD_EMAIL="Email";
$HLD_NAME="Name";
$HLD_PHONE="Phone";
// اغریف متغیر های مربوط به خودرو
$Name="";
$DriverId="";
$Verified="";
$Password="";
$Email="";
$Phone="";
//تعریف عملگر
$remove=false;


if(isset($_GET[$HLD_VERIFIED]))
    $Verified = stripslashes($_GET[$HLD_VERIFIED]);

if(isset($_GET[$HLD_PASSWORD]))
    $Password = stripslashes($_GET[$HLD_PASSWORD]);

if(isset($_GET[$HLD_EMAIL]))
    $Email = stripslashes($_GET[$HLD_EMAIL]);

if(isset($_GET[$HLD_NAME]))
    $Name = stripslashes($_GET[$HLD_NAME]);

if(isset($_GET['Remove']))
    $remove = stripslashes($_GET['Remove']);

if(isset($_GET[$HLD_PHONE]))
    $Phone = stripslashes($_GET[$HLD_PHONE]);

if(isset($_GET[$HLD_DRIVERID]))
    $DriverId = stripslashes($_GET[$HLD_DRIVERID]);

?>

<html>
<body>
<?php 
if ($DriverId){
    $resul = mysqli_query($connection,"Select * from driver where {$HLD_DRIVERID} = '{$DriverId}'");
    if ($result = mysqli_fetch_assoc($resul)){//ماشین در دیتایس هست؟
        if ($remove){
            mysqli_free_result($resul);
            mysqli_query($connection,"DELETE FROM driver WHERE {$HLD_DRIVERID} = '{$DriverId}'");

            echo "<h3> Deleting Driver </h3>";
            echo "Driver ".$DriverId." has been deleted.<br>";
        }else{

            //اگر پلاک ست نبود  باید داده را از کاربر بگیریم
        if (!$Password){
        echo "<h3>Updating Driver</h3>";
        //echo "{$HLD_PLATE}: {$Plate}<br>";
        echo "<form action=\"drivers.php\" method=\"get\">
        {$HLD_NAME}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_NAME}}\" name=\"{$HLD_NAME}\"><br>
        {$HLD_EMAIL}: <input class=\"s\" type=\"text\"  value=\"{$result{$HLD_EMAIL}}\" name=\"{$HLD_EMAIL}\"><br>
        {$HLD_PHONE}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_PHONE}}\" name=\"{$HLD_PHONE}\"><br>
        {$HLD_PASSWORD}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_PASSWORD}}\" name=\"{$HLD_PASSWORD}\"><br>
        {$HLD_VERIFIED}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_VERIFIED}}\" name=\"{$HLD_VERIFIED}\"><br>
        <input type=\"hidden\" name=\"{$HLD_DRIVERID}\" value='$DriverId' />
        <input type=\"submit\" value=\"Update\">
        </form>";
        }else{ //اگر پلاک ست بود میخوایم دیتا رو بروز کنیم
                mysqli_free_result($resul);
                mysqli_query($connection,"Update driver SET {$HLD_VERIFIED}='{$Verified}' ,{$HLD_PASSWORD}='{$Password}' ,{$HLD_EMAIL}='{$Email}' ,{$HLD_NAME}='{$Name}' , {$HLD_PHONE}='{$Phone}'   where {$HLD_DRIVERID} = '{$DriverId}'");

                echo "<h3>Updating Driver</h3>";
                echo "All Data Updated<br>";
            echo '<a href="./drivers.php">+Add a new Driver</a>';
        }
        }
    }else{//اگه آیدی ماشین توی دیتابیس نبود
        if ($Password){//اگر پلاک ست بود میخوایم دیتای جدید اضافه کنیم
                mysqli_free_result($resul);
                mysqli_query($connection,"INSERT INTO driver ({$HLD_DRIVERID},{$HLD_VERIFIED},{$HLD_PASSWORD},{$HLD_EMAIL},{$HLD_NAME},{$HLD_PHONE}) VALUES ('{$DriverId}','{$Verified}','{$Password}','{$Email}','{$Name}','{$Phone}')");
                echo "Driver Inserted";
        }
        else{//پلاک ست نیست
            echo "ERROR : Please Enter All the data, some fields are empty<br>";
        }
    }
    //اکر آیدی ماشین وجود نداشت اضافه کردن ماشین را نمایش می دهیم
}else{
    echo "<h3>Adding a New Driver</h3><br>
            <form action=\"drivers.php\" method=\"get\">
    {$HLD_DRIVERID}: <input class=\"s\" type=\"text\" name=\"{$HLD_DRIVERID}\"><br>
    
    {$HLD_NAME}: <input class=\"s\" type=\"text\"  name=\"{$HLD_NAME}\"><br>
        {$HLD_EMAIL}: <input class=\"s\" type=\"text\"   name=\"{$HLD_EMAIL}\"><br>
        {$HLD_PHONE}: <input class=\"s\" type=\"text\" name=\"{$HLD_PHONE}\"><br>
        {$HLD_PASSWORD}: <input class=\"s\" type=\"text\"  name=\"{$HLD_PASSWORD}\"><br>
        {$HLD_VERIFIED}: <input class=\"s\" type=\"text\"  name=\"{$HLD_VERIFIED}\"><br>
        
            <input type=\"submit\" value=\"Add\">
    </form>";
}
echo "<br><br>";

$all = mysqli_query($connection,"Select * FROM  `driver`");
echo mysqli_error($connection);
echo "<hr>";
echo '<a href="./drivers.php">+Add a new Driver</a>';
echo "<table style=\"width:100%\"><TD><B>{$HLD_DRIVERID}<TD><b>{$HLD_NAME}<TD><b>{$HLD_PHONE}<TD><b>{$HLD_EMAIL}<TD><b>{$HLD_VERIFIED}<TD><b>Edit<TD><b>Delete<TR></b>";
while ($all && $cache=mysqli_fetch_assoc($all)){

    echo  "<TD>{$cache{$HLD_DRIVERID}}<TD>{$cache{$HLD_NAME}}<TD>{$cache{$HLD_PHONE}}<TD>{$cache{$HLD_EMAIL}}<TD>{$cache{$HLD_VERIFIED}}<TD><a href=\"?{$HLD_DRIVERID}={$cache{$HLD_DRIVERID}}\">Edit</a><TD><a href=\"?{$HLD_DRIVERID}={$cache{$HLD_DRIVERID}}&Remove=true\">Delete</a>";
    echo "<TR>";
}
?>
<?php 
echo file_get_contents("./endbody.html");
?>
