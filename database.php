<?php

$host       ='localhost';
$user       ='root';
$pass       ='';
$database   ='care';

$con = mysqli_connect($host,$user,$pass,$database);

if (!$con)
{
    echo"not connected";
}
if (!mysqli_select_db($con,$database))
{
    echo"database not selected";
}
?>