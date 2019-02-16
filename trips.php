
<?php
include 'config.php';
include 'authenicate.php';
echo file_get_contents("./startbody.html");
echo file_get_contents("./head.html");
include 'menu.php';
//
//ثابت ها در این مکان نگهداری می شود
$HLD_TRIPID="TripID";
$HLD_PASSENGERID="PassengerID";
$HLD_DRIVERID="DriverID";
$HLD_STARTTIME="StartTime";
$HLD_ENDTIME="EndTime";
$HLD_PRICE="Price";
$HLD_STATUS="Status";
$HLD_BEGLAT="BegLat";
$HLD_BEGLNG="BegLng";
$HLD_BEGADR="BegAdr";
$HLD_DESLAT="DestLat";
$HLD_DESLNG="DestLng";
$HLD_DESADR="DestAdr";
$HLD_RATE="Rate";

// اغریف متغیر های مربوط به خودرو

$TRIPID=false;
$PASSENGERID=false;
$DRIVERID=null;
$STARTTIME=null;
$ENDTIME="";
$PRICE="";
$STATUS="";
$BEGLAT="";
$BEGLNG="";
$BEGADR="";
$DESLAT="";
$DESLNG="";
$DESADR="";
$RATE=null;
//تعریف عملگر
$remove=false;


if(isset($_GET[$HLD_TRIPID]))
    $TRIPID = stripslashes($_GET[$HLD_TRIPID]);
if(isset($_GET[$HLD_PASSENGERID]))
    $PASSENGERID = stripslashes($_GET[$HLD_PASSENGERID]);
if(isset($_GET[$HLD_DRIVERID]))
    $DRIVERID = stripslashes($_GET[$HLD_DRIVERID]);
if(isset($_GET[$HLD_ENDTIME]))
    $ENDTIME = stripslashes($_GET[$HLD_ENDTIME]);
if(isset($_GET[$HLD_STARTTIME]))
    $STARTTIME = stripslashes($_GET[$HLD_STARTTIME]);
if(isset($_GET[$HLD_PRICE]))
    $PRICE = stripslashes($_GET[$HLD_PRICE]);
if(isset($_GET[$HLD_STATUS]))
    $STATUS = stripslashes($_GET[$HLD_STATUS]);
if(isset($_GET[$HLD_BEGLAT]))
    $BEGLAT = stripslashes($_GET[$HLD_BEGLAT]);
if(isset($_GET[$HLD_BEGLNG]))
    $BEGLNG= stripslashes($_GET[$HLD_BEGLNG]);
if(isset($_GET[$HLD_BEGADR]))
    $BEGADR = stripslashes($_GET[$HLD_BEGADR]);
if(isset($_GET[$HLD_DESLAT]))
    $DESLAT = stripslashes($_GET[$HLD_DESLAT]);
if(isset($_GET[$HLD_DESLNG]))
    $DESLNG = stripslashes($_GET[$HLD_DESLNG]);
if(isset($_GET[$HLD_DESADR]))
    $DESADR = stripslashes($_GET[$HLD_DESADR]);
if(isset($_GET[$HLD_RATE]))
    $RATE = stripslashes($_GET[$HLD_RATE]);
if(isset($_GET['Remove']))
    $remove = stripslashes($_GET['Remove']);



?>

<html>
<body>
<?php 
if ($TRIPID){
    $resul = mysqli_query($connection,"Select * from trips where {$HLD_TRIPID} = '{$TRIPID}'");
    if ($result = mysqli_fetch_assoc($resul)){//ماشین در دیتایس هست؟
        if ($remove){
            mysqli_free_result($resul);
            mysqli_query($connection,"DELETE FROM trips WHERE {$HLD_TRIPID} = '{$TRIPID}'");

            echo "<h3> Deleting Trip </h3>";
            echo "Trip ".$TRIPID." has been deleted.<br>";
        }else{

            //اگر پلاک ست نبود  باید داده را از کاربر بگیریم
        if (!$PASSENGERID){
            echo "<h3>Updating Trip</h3>";
            //echo "{$HLD_PLATE}: {$Plate}<br>";
            echo "<form action=\"trips.php\" method=\"get\">
            {$HLD_PASSENGERID}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_PASSENGERID}}\" name=\"{$HLD_PASSENGERID}\"><br>
            {$HLD_DRIVERID}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_DRIVERID}}\" name=\"{$HLD_DRIVERID}\"><br>
            {$HLD_STARTTIME}: <input class=\"s\" type=\"text\" dir=\"rtl\" value=\"{$result{$HLD_STARTTIME}}\" name=\"{$HLD_STARTTIME}\"><br>
            {$HLD_ENDTIME}: <input class=\"s\" type=\"text\" dir=\"rtl\" value=\"{$result{$HLD_ENDTIME}}\" name=\"{$HLD_ENDTIME}\"><br>
            {$HLD_STATUS}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_STATUS}}\" name=\"{$HLD_STATUS}\"><br>
            {$HLD_PRICE}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_PRICE}}\" name=\"{$HLD_PRICE}\"><br>
            {$HLD_RATE}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_RATE}}\" name=\"{$HLD_RATE}\"><br>
            {$HLD_BEGLAT}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_BEGLAT}}\" name=\"{$HLD_BEGLAT}\"><br>
            {$HLD_BEGLNG}: <input class=\"s\" type=\"text\" dir=\"rtl\" value=\"{$result{$HLD_BEGLNG}}\" name=\"{$HLD_BEGLNG}\"><br>
            {$HLD_BEGADR}: <input class=\"s\" type=\"text\" dir=\"rtl\" value=\"{$result{$HLD_BEGADR}}\" name=\"{$HLD_BEGADR}\"><br>
            {$HLD_DESLAT}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_DESLAT}}\" name=\"{$HLD_DESLAT}\"><br>
            {$HLD_DESLNG}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_DESLNG}}\" name=\"{$HLD_DESLNG}\"><br>
            {$HLD_DESADR}: <input class=\"s\" type=\"text\" value=\"{$result{$HLD_DESADR}}\" name=\"{$HLD_DESADR}\"><br>
            <input type=\"hidden\" name=\"{$HLD_TRIPID}\" value='$TRIPID' />
            <input type=\"submit\" value=\"Update\">
            </form>";
        }else{ //اگر پلاک ست بود میخوایم دیتا رو بروز کنیم
                mysqli_free_result($resul);
                mysqli_query($connection,"Update trips SET {$HLD_PASSENGERID}='{$PASSENGERID}' , {$HLD_STARTTIME}='{$STARTTIME}',{$HLD_ENDTIME}='{$ENDTIME}',{$HLD_BEGLAT}='{$BEGLAT}',{$HLD_BEGLNG}='{$BEGLNG}',{$HLD_BEGADR}='{$BEGADR}' , {$HLD_STATUS}='{$STATUS}' , {$HLD_DESLAT}='{$DESLAT}' , {$HLD_DESLNG}='{$DESLNG}' , {$HLD_DESADR}='{$DESADR}' , {$HLD_PRICE} = {$PRICE} where {$HLD_TRIPID} = '{$TRIPID}'");
                echo mysqli_error($connection);
                echo "<h3>Updating Trips</h3>";
                echo "All Data Updated<br>";
            echo '<a href="./trips.php">+Add a new Trip</a>';
        }
        }
    }else{//اگه آیدی ماشین توی دیتابیس نبود
        if ($PASSENGERID){//اگر پلاک ست بود میخوایم دیتای جدید اضافه کنیم
                mysqli_free_result($resul);
                mysqli_query($connection,"INSERT INTO trips ({$HLD_TRIPID},{$HLD_PASSENGERID},{$HLD_STARTTIME},{$HLD_ENDTIME},{$HLD_PRICE},{$HLD_STATUS},{$HLD_BEGLAT},{$HLD_BEGLNG},{$HLD_BEGADR},{$HLD_DESLAT},{$HLD_DESLNG},{$HLD_DESADR},{$HLD_RATE}) VALUES ('{$TRIPID}','{$PASSENGERID}','{$STARTTIME}','{$ENDTIME}','{$STATUS}','{$BEGLAT}','{$BEGLNG},'{$BEGADR}','{$DESLAT},'{$DESLNG}','{$DESADR},'{$RATE}')");
                echo "Car Inserted";
        }
        else{//پلاک ست نیست
            echo "ERROR : Please Enter All the data, some fields are empty<br>";
        }
    }
    //اکر آیدی ماشین وجود نداشت اضافه کردن ماشین را نمایش می دهیم
}else{
    echo "<h3>Adding a New Trip</h3><br>
            <form action=\"trips.php\" method=\"get\">
            
        {$HLD_TRIPID}: <input class=\"s\" type=\"text\"  name=\"{$HLD_TRIPID}\"><br>
        {$HLD_PASSENGERID}: <input class=\"s\" type=\"text\"  name=\"{$HLD_PASSENGERID}\"><br>
        {$HLD_DRIVERID}: <input class=\"s\" type=\"text\"  name=\"{$HLD_DRIVERID}\"><br>
        {$HLD_STARTTIME}: <input class=\"s\" type=\"text\" dir=\"rtl\"  name=\"{$HLD_STARTTIME}\"><br>
        {$HLD_ENDTIME}: <input class=\"s\" type=\"text\" dir=\"rtl\"  name=\"{$HLD_ENDTIME}\"><br>
        {$HLD_STATUS}: <input class=\"s\" type=\"text\"  name=\"{$HLD_STATUS}\"><br>
        {$HLD_PRICE}: <input class=\"s\" type=\"text\"  name=\"{$HLD_PRICE}\"><br>
        {$HLD_RATE}: <input class=\"s\" type=\"text\"  name=\"{$HLD_RATE}\"><br>
        {$HLD_BEGLAT}: <input class=\"s\" type=\"text\"  name=\"{$HLD_BEGLAT}\"><br>
        {$HLD_BEGLNG}: <input class=\"s\" type=\"text\" dir=\"rtl\"  name=\"{$HLD_BEGLNG}\"><br>
        {$HLD_BEGADR}: <input class=\"s\" type=\"text\" dir=\"rtl\"  name=\"{$HLD_BEGADR}\"><br>
        {$HLD_DESLAT}: <input class=\"s\" type=\"text\" name=\"{$HLD_DESLAT}\"><br>
        {$HLD_DESLNG}: <input class=\"s\" type=\"text\"  name=\"{$HLD_DESLNG}\"><br>
        {$HLD_DESADR}: <input class=\"s\" type=\"text\"  name=\"{$HLD_DESADR}\"><br>
            <input type=\"submit\" value=\"Add\">
    </form>";
}
echo "<br><br>";

$all = mysqli_query($connection,"Select * FROM  `trips`");
echo mysqli_error($connection);
echo "<hr>";
echo '<a href="./trips.php">+Add a new Trip</a>';

echo "<table style=\"width:100%\"><TD><B>{$HLD_TRIPID}<TD><B>{$HLD_DRIVERID}<TD><b>{$HLD_PASSENGERID}<TD><b>{$HLD_STARTTIME}<TD><b>{$HLD_ENDTIME}<TD><b>{$HLD_STATUS}<TD><b>{$HLD_BEGADR}<TD><b>{$HLD_DESADR}<TD><b>{$HLD_RATE}<TD><b>{$HLD_PRICE}<TD><b>Edit<TD><b>Delete<TR></b>";
while ($all && $cache=mysqli_fetch_assoc($all)){

    echo  "<TD>{$cache{$HLD_TRIPID}}<TD>{$cache{$HLD_DRIVERID}}<TD>{$cache{$HLD_PASSENGERID}}<TD>{$cache{$HLD_STARTTIME}}<TD>{$cache{$HLD_ENDTIME}}<TD>{$cache{$HLD_STATUS}}<TD>{$cache{$HLD_BEGADR}}<TD>{$cache{$HLD_DESADR}}<TD>{$cache{$HLD_RATE}}<TD>{$cache{$HLD_PRICE}}<TD><a href=\"?{$HLD_TRIPID}={$cache{$HLD_TRIPID}}\">Edit</a><TD><a href=\"?{$HLD_TRIPID}={$cache{$HLD_TRIPID}}&Remove=true\">Delete</a>";
    echo "<TR>";
}
?>
<?php 
echo file_get_contents("./endbody.html");
?>