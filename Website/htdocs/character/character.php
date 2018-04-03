
<!DOCTYPE html>
<html>
<head>
<style>
holding {
	float: left;
    width: 200px;
	height: 100%;
	color: white;
    margin: 0;
	background-color: grey;
	border-radius: 25px;
}



spacer {
	float: clear;
}
</style>
</head>

<!-- Boilerplate -->
<?php
session_start();
$_SESSION["user ID"] = 1;
$user = $_SESSION["user ID"];
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
?> 
<!-- End Boilerplate -->

<body>
<?php //Character Stats
//getting passed data
if (empty($_GET)){$cid = 1;}
else {$cid = $_GET['varname'];}

$result = $conn->query("SELECT cid, name, birth, gender, health, preg, pregStart, descript, loc, owner, pos, intel, brawn, charisma, expMilitary, expAdmin FROM actor WHERE cid = $cid") or die($conn->error);
$character = $result->fetch_assoc();

$preg = $character['preg'];
if($preg > 0)
{
	$result = $conn->query("SELECT name FROM actor WHERE cid = $preg") or die($conn->error);
	$father = $result->fetch_assoc();
}
$temp = $character['loc'];
$result = $conn->query("SELECT name FROM planet WHERE pid = $temp") or die($conn->error);
$pos = $result->fetch_assoc();

$temp = $character['owner'];
$result = $conn->query("SELECT name FROM house WHERE hid = $temp") or die($conn->error);
$owner = $result->fetch_assoc();


echo '<a href="character_edit.php?varname=' . $cid . '">Edit Character</a><br>'; //Link to Edit
//Info
echo "<h1>" . $character["name"] . "</h1>";
echo "Born on : " . $character["birth"] . ".<br>";
echo "Description: " . $character["descript"] . "<br>";
echo "Gender: " . (($character["gender"] == 0)?("male"):("female")) . "<br>";
echo "Health: " . $character["health"] . "<br>";
echo "Brawn: " . $character["brawn"] . "<br>";
echo "Intelligence: " . $character["intel"] . "<br>";
echo "Charisma: " . $character["charisma"] . "<br>";
echo "Military Experience: " . $character["expMilitary"] . "<br>";
echo "Admin Experience: " . $character["expAdmin"] . "<br>";
echo "Pregnant: " . (($character["preg"] != 0)?("Yes, impregnanted on " . $character['pregStart'] . " by " . $father['name'] . "<br>"):("No<br>"));
echo "Currently On: " . $pos['name'] . "<br>";
echo "Position in the House: " . (($character["pos"] == 1)?("Head of House"):("None")) . "<br>";
echo "Controlled by: " . $owner['name'] . "<br>";
?>


<?php
$conn->close();
?> 
</body>
</html>