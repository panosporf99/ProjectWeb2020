<?php
session_start();

include 'debug.php' ;

$result_content_type= mysqli_query($db,"SELECT entries_timings,Rs_Content_Type FROM hardata");
while ($row=mysqli_fetch_array($result_content_type)){

    $array_cont [] = $row; 
}

echo json_encode($array_cont);
?>