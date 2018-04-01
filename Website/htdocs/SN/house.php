
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
<?php //getting passed data
	if (empty($_GET)){$hid = 1;}
	else {$hid = $_GET['varname'];}
?>

<?php //House Name
$result = $conn->query("SELECT name FROM house WHERE hid = $hid");
if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {echo "<h1>" . $row["name"] . "</h1>";}}
else { echo "<h1>An Unknown House<BR></h1>";}
?>

<?php //Quote
$result = $conn->query("SELECT quote FROM house WHERE hid = $hid");
if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {echo "Quote: \"" . $row["quote"] . "\"";}}
else { echo "A house of few words.";}
?>

<!--HOLDING OVERVIEW SECTION -->
<table>
<tr>
<td>
<h2>Holding Overview</h2>
<?php
$holding = $conn->query("SELECT pid, hid, food, rawMat, energy, upgrade1, upgrade2, upgrade3, upgrade4 FROM planet_holding WHERE hid = 1");
$i = 1;
$upgradeX = "upgrade" . $i;

//$result = $conn->query($holding);
if ($holding->num_rows > 0) {
    // output data of each row
    while($row = $holding->fetch_assoc()) {
		$pid = $row["pid"];
		$pname = $conn->query("SELECT name FROM planet WHERE pid = $pid");
		$row2 = $pname->fetch_assoc();
        echo 
			"<holding>
				<ul style=\"list-style-type:none\">
					<li>Planet: <a href=\"planet.php?varname=" . $row["pid"] . "\">" . $row2["name"] . "</a></li>" .
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