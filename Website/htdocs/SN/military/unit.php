
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
//$_SESSION["user ID"] = 1;
//$uid = $_SESSION["user ID"];
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
<?php //Planet Stats
$mid = $_GET['varname'];
$result = $conn->query("SELECT * FROM militaryunit WHERE mid = $mid");
$unit = $result->fetch_assoc();

$pid = $unit["loc"];
$pname = $conn->query("SELECT name FROM planet WHERE pid = $pid");
if ($pname->num_rows > 0){
	$row2 = $pname->fetch_assoc();
	$loc = "<a href=\"/SN/planet/planet.php?varname=" . $pid . "\">" . $row2["name"] . "</a>";
} else {
	$loc = "none";
}

$cid = $unit["commander"];
$cname = $conn->query("SELECT name, expMilitary FROM actor WHERE cid = $cid");
if ($cname->num_rows > 0){
	$row3 = $cname->fetch_assoc();
	$commander = "<a href=\"/SN/character/character.php?varname=" . $cid . "\">" . $row3["name"] . "</a>";
} else {
	$commander = "none";
}

$hid = $unit["owner"];
$hname = $conn->query("SELECT name FROM house WHERE hid = $hid");
if ($hname->num_rows > 0){
	$row4 = $hname->fetch_assoc();
	$owner = "<a href=\"/SN/house.php?varname=" . $hid . "\">" . $row4["name"] . "</a>";
} else {
	$owner = "none";
}

echo '<a href="unit_edit.php?varname=' . $mid . '">Edit Unit</a><br>';
echo "<h1>" . $unit["name"] . "</h1>";

echo "Owner: " . $owner . "<br>";
echo "Commander: " . $commander . "<br>";
echo "Location: " . $loc . "<br>";

echo "<h2>Stats:</h2>";

echo "Type: " . (($unit["type"] == 0)?("Ground"):("Space")) . "<br>";
echo "Mobility: " . (($unit["defMob"] == 0)?("Defensive"):("Mobile")) . "<br>";
echo "Status: " . (($unit["active"] == 0)?("Standby"):("Ready")) . "<br>";
echo "Strength: " . $unit["points"] . "<br>";
echo "Experience: " . $unit["exp"] . "<br>";
if ($cname->num_rows > 0){
	echo "Commander's Experience: " . $row3["expMilitary"] . "<br>";
}

$conn->close();
?> 
</body>
</html>