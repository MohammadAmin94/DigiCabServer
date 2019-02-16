
<?php
include 'config.php';
include 'authenicate.php';
echo file_get_contents("./startbody.html");
echo file_get_contents("./head.html");
include 'menu.php';
//

$Username=false;
$Password=false;
$Name=false;
$remove=false;
$image=false;


if(isset($_POST['Username']))
$Username = stripslashes($_POST['Username']);

if(isset($_POST['Remove']))
$remove = stripslashes($_POST['Remove']);

if(isset($_POST['Password']))
$Password = stripslashes($_POST['Password']);

if(isset($_POST['Name']))
    $Name = stripslashes($_POST['Name']);

    if(isset($_GET['Username']))
        $Username = stripslashes($_GET['Username']);
    
        if(isset($_GET['Remove']))
            $remove = stripslashes($_GET['Remove']);
    
            if(isset($_GET['Password']))
                $Password = stripslashes($_GET['Password']);
    
                if(isset($_GET['Name']))
                    $Name = stripslashes($_GET['Name']);
    
?>

<html>
<body>
<?php 
if ($Username){
    $result = mysqli_query($connection,"Select * from admins where Username = '".$Username."'");
    if ($result = mysqli_fetch_assoc($result)){//age Username too database bood
        if ($remove){
            mysqli_query($connection,"Delete FROM admins WHERE Username = '".$Username."'");
            echo "<h3> Deleting Username </h3>";
            echo "Username ".$Username." has been deleted.<br>";
        }else{
        
        if (!$Password || !$Name){ // va age password set nabud
        echo "<h3>Enter New Name And Password</h3>";
        echo "Username: ".$Username."<br>";
        echo "Current Pass: ".$result{'Password'}."<br>";
        
        echo '<form enctype="multipart/form-data" action="admins.php" method="post">
        Password: <input  class="s" type="text" name="Password" value'.$result{'Password'}.'><br>
        Name: <input  class="s" type="text" name="Name" value="'.$result{'Name'}.'"><br>
        <input type="hidden" name="Username" value='.$Username.' />
        <input type="submit" value="Update">
        </form>';}else{ // age Pass set bood
        if    ($Password=="" || $Username==""){
            echo "ERROR : Please Enter Both Username Name And Password<br>";
        }else{
            $updateIMG="";
            if ($image){
                $updateIMG = ", image = '".$hex_image."'";
            }
            mysqli_query($connection,"Update admins SET Password='".$Password."' , Name='".$Name."' ".$updateIMG." where Username = '".$Username."'");
            echo "<h3>Updating Username</h3>";
            echo "Password Updated<br>";
        }    
            echo "Username: ".$Username."<br>";
            echo "Password: ".$Password."<br>";
            echo "<br>";
            echo '
            <form enctype="multipart/form-data" action="admins.php" method="post">
                Password: <input  class="s" type="text" name="Password" value="'.$Password.'"><br>
                Name: <input  class="s" type="text" name="Name" value="'.$Name.'"><br>
                <input type="hidden" name="Username" value='.$Username.' />
              <input type="submit" value="Update">
               </form>';
        }
        }
    }else{//age Username too database nabood
        if ($Password){//age min version set bood
            if    ($Password=="" || $Username==""){
                echo "ERROR : Please Enter Both Username Name And Password<br>";
            }else{
                mysqli_query($connection,"INSERT INTO admins (Password,Username,Name) VALUES ('".$Password."','".$Username."','".$Name."')");
                echo "Username Inserted";
            }
        }
        else{//age  password set nabood
            echo "Username does not exist , Enter Password<br>";
            echo "Username: ".$Username."<br>";
            echo '<form enctype="multipart/form-data" action="admins.php" method="post" >
                Password: <input  class="s" type="text" name="Password"><br>
                Name: <input  class="s" type="text" name="Name"><br>
                <input type="hidden" name="Username" value='.$Username.' />
                
              <input type="submit" value="Update">
               </form>';
        }
    }
}else{//age Username set nabood
    echo '<h3>Adding a New Username</h3><br>
    <form enctype="multipart/form-data" action="admins.php" method="post" >
    Username: <input  class="s" type="text" name="Username"><br>
    Password: <input  class="s" type="text" name="Password"><br>
    Name: <input  class="s" type="text" name="Name"><br>
    <input type="submit" value="Add">
    </form>';
}
?>

<br><br>
</body>
</html>
<?php
$all = mysqli_query($connection,"Select * FROM admins");
echo "<hr>";
echo '<a href="./admins.php">+Add a new Username</a>';
echo ' <table style="width:100%"><TD><B>Username<TD><b>Password<TD><b>Name<TD><b>Update<TD><b>Delete<TR></b>';
while ($cache=mysqli_fetch_assoc($all)){
    echo  "<TD>".$cache{'username'}."<TD>". ($cache{'username'}==$_SESSION['Username']?$cache{'password'}:"******")."<TD>". $cache{'name'}."<TD>".'<a href="?Username='.$cache{'username'}.'">Update</a>'.'<TD><a href="?Username='.$cache{'username'}.'&Remove=true">Delete</a>';
    echo "<TR>";
}
?>
<?php 
echo file_get_contents("./endbody.html");
?>