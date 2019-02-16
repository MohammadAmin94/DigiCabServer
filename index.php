<?php
session_start();
include 'config.php';
echo file_get_contents("./startbody.html");
echo file_get_contents("./head.html");
$username=false;
$password=false;
//aval user passe cache shode
if (isset($_SESSION['Username']))
    $username=$_SESSION['Username'];
if (isset($_SESSION['Password']))
    $password=$_SESSION['Password'];
//hala check baraye user pass
if (isset($_GET['Username']))
    $username = $_GET['Username'];
if (isset($_GET['Password']))
    $password = $_GET['Password'];
        

if ($username && $password){
$query = mysqli_query($connection,"Select * From admins Where Username='".$username."' AND Password='".$password."'");
if ($query){
$ans = mysqli_fetch_assoc($query);
if (mysqli_num_rows($query)>0){

    $_SESSION['Username'] = $ans{'username'};
    $_SESSION['Password'] = $ans{'password'};
    echo "Logged in As ".$ans{'username'};
    echo "<br>Welcome ".$ans{'name'};
    echo "<br>";
    header("Location: ./cars.php");
    
}else{
    die('<h2>Authenication Failed.Please Log in again.');
}
}}else{
    echo '<hr>
        <form action="index.php" method="get">
                Username: <input type="text" name="Username"><br>
                Password: <input type="password" name="Password"><br>
                <input type="submit" value="Login">
               </form><hr>';

}
?>
<?php 
echo file_get_contents("./endbody.html");
?>