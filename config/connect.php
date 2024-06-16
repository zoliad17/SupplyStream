<?php
// Database Connection

$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "supplysystem";

$con = mysqli_connect($serverName, $userName, $password, $dbName,);

if (mysqli_connect_errno()) {
    echo "Error Connection";
    exit();
} 
?>
    