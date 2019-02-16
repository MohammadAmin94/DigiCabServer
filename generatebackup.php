<?php
include 'config.php';
include 'authenicate.php';

ob_end_clean();
date_default_timezone_set('Asia/Tehran');
//save file
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="backup.txt"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
$tables = array();
$result = mysqli_query($connection,'SHOW TABLES');
while($row = mysqli_fetch_row($result))
{
    $tables[] = $row[0];
}

$return="";
foreach($tables as $table)
{
    $result = mysqli_query($connection,'SELECT * FROM '.$table);
    $num_fields = mysqli_num_fields($result);
    //$return.= 'DROP TABLE '.$table.';';
    $row2 = mysqli_fetch_row(mysqli_query($connection,'SHOW CREATE TABLE '.$table));
    $return.= "\n".$row2[1].";\n";

    while($row = mysqli_fetch_row($result))
    {
        $return.="\n";
        $return.= 'INSERT INTO '.$table.' VALUES(';
        for($j=0; $j<$num_fields; $j++)
        {
            $row[$j] = addslashes($row[$j]);
            $row[$j] = preg_replace("#n#","n",$row[$j]);
            if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
            if ($j<($num_fields-1)) { $return.= ','; }
        }
        $return.= ");";
    }
    $return.="\n";
}



echo $return;

?>