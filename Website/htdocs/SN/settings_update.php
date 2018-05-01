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

$val=$_POST["val"];
$result = $conn->query("SELECT $val FROM setting");
$row = $result->fetch_assoc();

if($row[$val] == 1)
{
	$sql="UPDATE setting SET $val='0'";
}
if($row[$val] == 0)
{
	$sql="UPDATE setting SET $val='1'";
}
if($conn->query($sql)===TRUE){}
$conn->close();
?>