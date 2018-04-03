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

$name=$_POST["name"];
$terrain=$_POST["terrain"];
$secTerrain=$_POST["secTerrain"];
$descript=$_POST["descript"];
$expLabour=$_POST["expLabour"];
$genLabour=$_POST["genLabour"];
$totalPop=$_POST["totalPop"];
$minerals=$_POST["minerals"];
$popGrowth=$_POST["popGrowth"];
$wealth=$_POST["wealth"];
$eduLevel=$_POST["eduLevel"];

$sql="UPDATE planet SET
name='$name',
terrain='$terrain',
secTerrain='$secTerrain',
descript='$descript',
expLabour='$expLabour',
genLabour='$genLabour',
totalPop='$totalPop',
minerals='$minerals',
popGrowth='$popGrowth',
wealth='$wealth',
eduLevel='$eduLevel'
WHERE pid=1";
if($conn->query($sql)===TRUE){echo "DATA updated";}
$conn->close();
?>