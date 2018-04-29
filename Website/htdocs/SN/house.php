
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
if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {echo "<h1 id=name_val>" . $row["name"] . "</h1>";}}
else { echo "<h1>An Unknown House.";}
?>
<input type='button' class="edit_button" id="edit_button<?php echo $row['name'];?>" value="edit" onclick="edit_name('<?php echo $row['name'];?>');">



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
$holding = $conn->query("SELECT pid, hid, food, rawMat, energy, upgrade1, upgrade2, upgrade3, upgrade4 FROM planet_holding WHERE hid = $hid");
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
					<li>Planet: <a href=\"/SN/planet/planet.php?varname=" . $row["pid"] . "\">" . $row2["name"] . "</a></li>" .
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
else { echo "No Holdings."; }
?>
</tr>
</td>

<BR>


<tr>
<td>
<h2>Character Overview</h2>
<?php
$actor = $conn->query("SELECT cid, name, birth, gender, health, preg, pregStart, descript, loc, owner, pos, intel, brawn, charisma, expMilitary, expAdmin FROM actor WHERE owner = $hid");

//$result = $conn->query($holding);
if ($actor->num_rows > 0) {
    // output data of each row
    while($row = $actor->fetch_assoc()) {
		$pid = $row["loc"];
		$pname = $conn->query("SELECT name FROM planet WHERE pid = $pid");
		$row2 = $pname->fetch_assoc();
        echo 
			"<holding>
				<ul style=\"list-style-type:none\">
					<li>Name: <a href=\"/SN/character/character.php?varname=" . $row["cid"] . "\">" . $row["name"] . "</a></li>" .
					"<li>Age: " . ($row["birth"]/360) . " years old.</li>" .
					"<li>Gender: " . (($row["gender"] == 0)?("male"):("female")) . "</li>" .
					"<li>Health: " . $row["health"] . "</li>" .
					"<li>Description: " . $row["descript"] . "</li>" .
					"<li>Resides On: " . $row2["name"] . "</li>" .
					"<li>Position: " . (($row["pos"] == 1)?("Head of House"):("None")) . " </li>" .
					"<li>Strength: " . $row["brawn"] . "</li>" .
					"<li>Intelligence: " . $row["intel"] . "</li>" .
					"<li>Charisma: " . $row["charisma"] . "</li>" .
					"<li>Miltiary Skill: " . $row["expMilitary"] . "</li>" .
					"<li>Admin Skill: " . $row["expAdmin"] . "</li>";
		echo	"</ul>" .
			"</holding>";
    }
}
else { echo "No Characters."; }
?>
</tr>
</td>



<!--MILITARY OVERVIEW SECTION -->
<tr>
<td>
<h2>Military Overview (To Be Done)</h2>
 
</tr>
</td>
</table>

<?php
$conn->close();
?> 
</body>
</html>