
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
<?php //Planet Stats
$pid = $_GET['varname'];
$result = $conn->query("SELECT name, locX, locY, size, terrain, secTerrain, descript, expLabour, genLabour, totalPop, minerals, popGrowth, wealth, eduLevel FROM planet WHERE pid = $pid");
$planet = $result->fetch_assoc();
echo '<a href="planet_edit.php?varname=' . $pid . '">Edit Planet</a><br>';
echo "<h1>" . $planet["name"] . "</h1>";
echo "Type: A " . $planet["secTerrain"] . " " . $planet["terrain"] . " world." . "<br>";
echo "Description: " . $planet["descript"] . "<br>";
echo "Coordinates: X:" . $planet["locX"] . " Y:" . $planet["locY"];
echo "<h2>Stats:</h2>";
echo "Expert Labour: " . $planet["expLabour"] . "<br>";
echo "General Labour: " . $planet["genLabour"] . "<br>";
echo "Total Population: " . $planet["totalPop"] . "<br>";
echo "Mineral Deposits: " . $planet["minerals"] . "<br>";
echo "Population Growth: " . $planet["popGrowth"] . "<br>";
echo "Wealth: " . $planet["wealth"] . "<br>";
echo "Education Level: " . $planet["eduLevel"] . "<br>";

echo "<h2>Connecting Starlanes:</h2>";
$lane = FALSE;
$sql = "SELECT fplanet, splanet FROM starlane WHERE fplanet = $pid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$splaname = $row['splanet'];
		$sql = "SELECT name FROM planet WHERE pid = $splaname";
		$splanet = $conn->query($sql);
		$row2 = $splanet->fetch_assoc();
        echo 'Starlane to : ' . $row2["name"] . '<br>';
    }
} else {
    $lane = TRUE;
}

$sql = "SELECT fplanet, splanet FROM starlane WHERE splanet = $pid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$splaname = $row['fplanet'];
		$sql = "SELECT name FROM planet WHERE pid = $splaname";
		$splanet = $conn->query($sql);
		$row2 = $splanet->fetch_assoc();
        echo 'Starlane to : ' . $row2["name"] . '<br>';
    }
} else {
    if($lane == TRUE) {echo 'Error: No Lanes to Planet.';}
}
?>



<table>
<tr>
<td>
<!--HOLDING OVERVIEW SECTION -->
<h2>Holdings on Planet</h2>
<?php
$holding = $conn->query("SELECT pid, hid, food, rawMat, energy, upgrade1, upgrade2, upgrade3, upgrade4 FROM planet_holding WHERE pid = $pid");
$i = 1;
$upgradeX = "upgrade" . $i;

//$result = $conn->query($holding);
if ($holding->num_rows > 0) {
    // output data of each row
    while($row = $holding->fetch_assoc()) {
		$hid = $row["hid"];
		$hname = $conn->query("SELECT name FROM house WHERE hid = $hid");
		$row2 = $hname->fetch_assoc();
        echo 
			"<holding>
				<ul style=\"list-style-type:none\">
					<li>Owner: <a href=\"/SN/house.php?varname=" . $row["hid"] . "\">" . $row2["name"] . "</a></li>" .
					"<li>Food: " . $row["food"] . "</li>" .
					"<li>Raw Materials: " . $row["rawMat"] . "</li>" .
					"<li>Energy: " . $row["energy"] . "</li>";
			while ($i < 5)
			{
				$upgradeX = "upgrade" . $i;
				if ($row[$upgradeX] == true){ echo "<li>" . $upgradeX . ": " . $row[$upgradeX] . "</li>"; }
				$i++;
			}
			$i = 1;
		echo	"</ul>" .
			"</holding>";
    }
}
else { echo "<BR>No Holdings."; }
?>
</tr>
</td>

<BR>
<tr>
<td>
<!--MILITARY OVERVIEW SECTION -->
<h2>Military Overview (To Be Done)</h2>

</tr>
</td>
</table>


<?php
$conn->close();
?> 
</body>
</html>