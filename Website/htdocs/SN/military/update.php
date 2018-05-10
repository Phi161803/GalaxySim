<?php
$servername = "localhost";
$username = "root";
$password = NULL;
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$mid=$_POST["mid"];
$name=$_POST["name"];
$owner=$_POST["owner"];
$loc=$_POST["loc"];
$points=$_POST["points"];
$exp=$_POST["exp"];

$sql="UPDATE militaryunit SET
name='$name',
owner='$owner',
loc='$loc',
points='$points',
exp='$exp'
WHERE mid='$mid'";
if($conn->query($sql)===TRUE){echo "DATA updated";}
$conn->close();
?>