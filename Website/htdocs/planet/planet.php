
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
echo "<h2>Stats:</h2>";
echo "Expert Labour: " . $planet["expLabour"] . "<br>";
echo "General Labour: " . $planet["genLabour"] . "<br>";
echo "Total Population: " . $planet["totalPop"] . "<br>";
echo "Mineral Deposits: " . $planet["minerals"] . "<br>";
echo "Population Growth: " . $planet["popGrowth"] . "<br>";
echo "Wealth: " . $planet["wealth"] . "<br>";
echo "Education Level: " . $planet["eduLevel"] . "<br>";
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
					<li>Owner: <a href=\"house.php?varname=" . $row["hid"] . "\">" . $row2["name"] . "</a></li>" .
					"<li>Food: " . $row["food"] . "</li>" .
					"<li>Raw Materials: " . $row["rawMat"] . "</li>" .
					"<li>Energy: " . $row["energy"] . "</li>";
			while ($i < 5)
			{
				$upgradeX = "upgrade" . $i;
				if ($row[$upgradeX] == 1){ echo "<li>" . $upgradeX . ": " . $row[$upgradeX] . "</li>"; }
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






Old Test code here just to make more text appears.
<?php
$sql = "SELECT hid, name, home FROM house";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<BR>id: " . $row["hid"]. " - Name: " . $row["name"]. " " . $row["home"];
    }
} else {
    echo "<BR>0 results";
}

$sql = "SELECT hid, name, home FROM house WHERE hid = 2";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<BR>id: " . $row["hid"]. " - Name: " . $row["name"]. " " . $row["home"];
    }
} else {
    echo "<BR>0 results";
}
?> 
</tr>
</td>
</table>


<?php
$conn->close();
?> 
</body>
</html>