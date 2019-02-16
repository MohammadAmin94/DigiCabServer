<?php
include 'config.php';
include 'authenicate.php';
echo file_get_contents("./startbody.html");
echo file_get_contents("./head.html");
include 'menu.php';
function run_sql_file($connection,$commands){
    //load file
   // $commands = file_get_contents($location);
    //delete comments
    $lines = explode("\n",$commands);
    $commands = '';
    foreach($lines as $line){
        $line = trim($line);
        if( $line && !startsWith($line,'--') ){
            $commands .= $line . "\n";
        }
    }

    //convert to array
    $commands = explode(";", $commands);

    //run commands
    $total = $success = 0;
    foreach($commands as $command){
        if(trim($command)){
            $success += (@mysqli_query($connection,$command)==false ? 0 : 1);
            $total += 1;
        }
    }

    //return number of successful queries and total number of queries found
    return array(
        "success" => $success,
        "total" => $total
    );
}


// Here's a startsWith function
function startsWith($haystack, $needle){
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

$file=false;

if (isset($_FILES['file']['tmp_name']))
    $file = file_get_contents($_FILES['file']['tmp_name']);

if ($file){
    mysqli_query($connection,"DROP DATABASE ".$dbname);
    mysqli_query($connection,"Create DATABASE if not EXISTS ".$dbname);
    mysqli_select_db($connection,$dbname);
    run_sql_file($connection,$file);
        
        echo "Data Loaded<br>";
    
}else{
    
}


?>

<form enctype="multipart/form-data" action="backitup.php" method="post">
    Load Backup: <input type="file" name="file" /><br>
    <input type="submit" value="Apply Data">
    </form>
    <br>
    <a href="./generatebackup.php">Generate and download a backup from database</a>