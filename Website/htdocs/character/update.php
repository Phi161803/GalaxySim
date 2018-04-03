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
$cid=$_POST["cid"];
$name=$_POST["name"];
$birth=$_POST["birth"];
$descript=$_POST["descript"];
$gender=$_POST["gender"];
$health=$_POST["health"];
$brawn=$_POST["brawn"];
$intel=$_POST["intel"];
$charisma=$_POST["charisma"];
$expMilitary=$_POST["expMilitary"];
$expAdmin=$_POST["expAdmin"];
$preg=$_POST["preg"];
$pregStart=$_POST["pregStart"];
$pos=$_POST["pos"];
$owner=$_POST["owner"];
$loc=$_POST["loc"];

$sql="UPDATE actor SET
name='$name',
birth='$birth',
descript='$descript',
gender='$gender',
health='$health',
brawn='$brawn',
intel='$intel',
charisma='$charisma',
expMilitary='$expMilitary',
expAdmin='$expAdmin',
preg='$preg',
pregStart='$pregStart',
pos='$pos',
owner='$owner',
loc='$loc'
WHERE cid = $cid";
if($conn->query($sql)===TRUE){echo "DATA updated";};
$conn->close();
?>