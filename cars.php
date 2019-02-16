
<?php
include 'config.php';
include 'authenicate.php';
echo file_get_contents("./startbody.html");
echo file_get_contents("./head.html");
include 'menu.php';
//
//ثابت ها در این مکان نگهداری می شود
$HLD_PLATE="Plate";
$HLD_COLOR="Color";
$HLD_MODEL="Model";
$HLD_STATUS="Status";
$HLD_LAT="CarLat";
$HLD_LNG="CarLng";
$HLD_CARID="CarID";
$HLD_DRIVERID="DriverID";
$HLD_PLATE="Plate";
// اغریف متغیر های مربوط به خودرو
$CarId=false;
$DriverId=false;

$Plate=false;
$Color=false;
$Model=false;

$Status=false;
$CarLat=false;
$CarLng=false;
//تعریف عملگر
$remove=false;


if(isset($_GET[$HLD_PLATE]))
    $Plate = stripslashes($_GET[$HLD_PLATE]);

if(isset($_GET[$HLD_COLOR]))
    $Color = stripslashes($_GET[$HLD_COLOR]);

if(isset($_GET[$HLD_MODEL]))
    $Model = stripslashes($_GET[$HLD_MODEL]);

if(isset($_GET[$HLD_STATUS]))
    $Status = stripslashes($_GET[$HLD_STATUS]);

if(isset($_GET['Remove']))
    $remove = stripslashes($_GET['Remove']);

if(isset($_GET[$HLD_CARID]))
    $CarId = stripslashes($_GET[$HLD_CARID]);

if(isset($_GET[$HLD_DRIVERID]))
    $DriverId = stripslashes($_GET[$HLD_DRIVERID]);

if(isset($_GET[$HLD_LAT]))
    $CarLat = stripslashes($_GET[$HLD_LAT]);

if(isset($_GET[$HLD_LNG]))
    $CarLng = stripslashes($_GET[$HLD_LNG]);

?>

<html>
<body>
<?php 
if ($CarId){
    $resul = mysqli_query($connection,"Select * from Car where {$HLD_CARID} = '{$CarId}'");
    if ($result = mysqli_fetch_assoc($resul)){//ماشین در دیتایس هست؟
        if ($remove){
            mysqli_free_result($resul);
            mysqli_query($connection,"DELETE FROM Car WHERE {$HLD_CARID} = '{$CarId}'");

            echo "<h3> Deleting Car </h3>";
            echo "Car ".$Plate." has been deleted.<br>";
        }else{

            //اگر پلاک ست نبود  باید داده را از کاربر بگیریم
        if (!$Plate){
        echo "<h3>Updating Car</h3>";
        //echo "{$HLD_PLATE}: {$Plate}<br>";
        echo "<form action=\"cars.php\" method=\"get\">
        {$HLD_COLOR}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_COLOR}}\" name=\"{$HLD_COLOR}\"><br>
        {$HLD_PLATE}: <input class=\"s\" type=\"text\" dir=\"rtl\" value=\"{$result{$HLD_PLATE}}\" name=\"{$HLD_PLATE}\"><br>
        {$HLD_DRIVERID}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_DRIVERID}}\" name=\"{$HLD_DRIVERID}\"><br>
        {$HLD_MODEL}: <input class=\"s\" type=\"text\" dir=\"rtl\" value=\"{$result{$HLD_MODEL}}\" name=\"{$HLD_MODEL}\"><br>
        {$HLD_STATUS}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_STATUS}}\" name=\"{$HLD_STATUS}\"><br>
        {$HLD_LNG}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_LNG}}\" name=\"{$HLD_LNG}\"><br>
        {$HLD_LAT}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_LAT}}\" name=\"{$HLD_LAT}\"><br>
        <input type=\"hidden\" name=\"{$HLD_CARID}\" value='$CarId' />
        <input type=\"submit\" value=\"Update\">
        </form>";
        }else{ //اگر پلاک ست بود میخوایم دیتا رو بروز کنیم
            if    ($CarId=="" || $Plate==""|| $Model==""|| $Status==""|| $Color==""|| $DriverId==""){
                echo "ERROR : Please Enter All the data, some fields are empty<br>";
            }else{
                mysqli_free_result($resul);
                mysqli_query($connection,"Update car SET {$HLD_COLOR}='{$Color}' ,{$HLD_PLATE}='{$Plate}' ,{$HLD_MODEL}='{$Model}' ,{$HLD_DRIVERID}='{$DriverId}' ,{$HLD_STATUS}='{$Status}' , {$HLD_LNG}='{$CarLng}' ,{$HLD_LAT}='{$CarLat}'  where {$HLD_CARID} = '{$CarId}'");

                echo "<h3>Updating Car</h3>";
                echo "All Data Updated<br>";
            }
            echo '<a href="./cars.php">+Add a new Car</a>';
        }
        }
    }else{//اگه آیدی ماشین توی دیتابیس نبود
        if ($Plate){//اگر پلاک ست بود میخوایم دیتای جدید اضافه کنیم
            if    ($CarId=="" || $Plate==""|| $Model==""|| $Status==""|| $Color==""|| $DriverId==""){
                echo "ERROR : Please Enter All the data, some fields are empty<br>";
            }else{
                mysqli_free_result($resul);
                mysqli_query($connection,"INSERT INTO car ({$HLD_CARID},{$HLD_COLOR},{$HLD_PLATE},{$HLD_MODEL},{$HLD_DRIVERID},{$HLD_STATUS},{$HLD_LNG},{$HLD_LAT}) VALUES ('{$CarId}','{$Color}','{$Plate}','{$Model}','{$DriverId}','{$Status}','{$CarLng}','{$CarLat}')");
                echo "Car Inserted";
            }
        }
        else{//پلاک ست نیست
            echo "ERROR : Please Enter All the data, some fields are empty<br>";
        }
    }
    //اکر آیدی ماشین وجود نداشت اضافه کردن ماشین را نمایش می دهیم
}else{
    echo "<h3>Adding a New Car</h3><br>
            <form action=\"cars.php\" method=\"get\">
    
    {$HLD_DRIVERID}:<input class=\"s\" type=\"text\" name=\"{$HLD_DRIVERID}\"/><br>
    {$HLD_CARID}:<input class=\"s\" type=\"text\" name=\"{$HLD_CARID}\"/><br>
    {$HLD_PLATE}:<input class=\"s\" type=\"text\" dir=\"rtl\" name=\"{$HLD_PLATE}\"/><br>
    {$HLD_COLOR}:<input class=\"s\" type=\"text\" name=\"{$HLD_COLOR}\"/><br>
    {$HLD_MODEL}:<input class=\"s\" type=\"text\" dir=\"rtl\" name=\"{$HLD_MODEL}\"/><br>
    {$HLD_STATUS}:<input class=\"s\" type=\"text\" name=\"{$HLD_STATUS}\"/><br>
    {$HLD_LAT}:<input class=\"s\" type=\"text\" name=\"{$HLD_LAT}\"/><br>
    {$HLD_LNG}:<input class=\"s\" type=\"text\" name=\"{$HLD_LNG}\"/><br>
    
            <input type=\"submit\" value=\"Add\">
    </form>";
}
echo "<br><br>";

$all = mysqli_query($connection,"Select * FROM  `car`");
echo mysqli_error($connection);
echo "<hr>";
echo '<a href="./cars.php">+Add a new car</a>';
echo "<table style=\"width:100%\"><TD><B>{$HLD_CARID}<TD><B>{$HLD_DRIVERID}<TD><b>{$HLD_PLATE}<TD><b>{$HLD_COLOR}<TD><b>{$HLD_MODEL}<TD><b>{$HLD_STATUS}<TD><b>{$HLD_LAT}<TD><b>{$HLD_LNG}<TD><b>Edit<TD><b>Delete<TR></b>";
while ($all && $cache=mysqli_fetch_assoc($all)){

    echo  "<TD>{$cache{$HLD_CARID}}<TD>{$cache{$HLD_DRIVERID}}<TD>{$cache{$HLD_PLATE}}<TD>{$cache{$HLD_COLOR}}<TD>{$cache{$HLD_MODEL}}<TD>{$cache{$HLD_STATUS}}<TD>{$cache{$HLD_LAT}}<TD>{$cache{$HLD_LNG}}<TD><a href=\"?{$HLD_CARID}={$cache{$HLD_CARID}}\">Edit</a><TD><a href=\"?{$HLD_CARID}={$cache{$HLD_CARID}}&Remove=true\">Delete</a>";
    echo "<TR>";
}
?>
<?php 
echo file_get_contents("./endbody.html");
?>