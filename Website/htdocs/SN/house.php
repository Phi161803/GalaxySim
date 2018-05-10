
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
<?php //getting passed data
	if (empty($_GET)){$hid = $_SESSION["HID"];}
	else {$hid = $_GET['varname'];}
?>

<?php //Check if the user owns this house
$your_house = false;
if (isset($_SESSION['user ID'])){
	$uid = $_SESSION['user ID'];
	$result = $conn->query("SELECT hid FROM users WHERE uid = $uid");
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($row["hid"] == $hid) {$your_house = true;}
		}
	}
}
?>

<?php //House Name
$result = $conn->query("SELECT name FROM house WHERE hid = $hid");
if ($result->num_rows > 0) { while($row = $result->fetch_assoc()) {echo "<h1 id=name_val>" . $row["name"] . "</h1>";}}
else { echo "<h1>An Unknown House.";}
?>

<?php if($your_house) { ?>
<input type='button' class="edit_button" id="edit_button<?php echo $row['name'];?>" value="edit" onclick="edit_name('<?php echo $row['name'];?>');">
<?php } ?>



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
$holding = $conn->query("SELECT * FROM planet_holding WHERE hid = $hid");
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
				<ul style=\"list-style-type:none\">" .
					"<li>Planet: <a href=\"/SN/planet/planet.php?varname=" . $row["pid"] . "\">" . $row2["name"] . "</a></li>" .
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
$actor = $conn->query("SELECT * FROM actor WHERE owner = $hid");

//$result = $conn->query($holding);
if ($actor->num_rows > 0) {
    // output data of each row
    while($row = $actor->fetch_assoc()) {
		$pid = $row["loc"];
		$pname = $conn->query("SELECT name FROM planet WHERE pid = $pid");
		$row2 = $pname->fetch_assoc();
        echo 
			"<holding>
				<ul style=\"list-style-type:none\">" .
					"<li>Name: <a href=\"/SN/character/character.php?varname=" . $row["cid"] . "\">" . $row["name"] . "</a></li>" .
					"<li>Age: " . ($row["birth"]/360) . " years old.</li>" .
					"<li>Gender: " . (($row["gender"] == 0)?("male"):("female")) . "</li>" .
					"<li>Health: " . $row["health"] . "</li>" .
					"<li>Description: " . $row["descript"] . "</li>" .
					"<li>Resides On: <a href=\"/SN/planet/planet.php?varname=" . $row["loc"] . "\">" . $row2["name"] . "</a></li>" .
					"<li>Position: " . (($row["pos"] == 1)?("Head of House"):("None")) . " </li>" .
					"<li>Strength: " . $row["brawn"] . "</li>" .
					"<li>Intelligence: " . $row["intel"] . "</li>" .
					"<li>Charisma: " . $row["charisma"] . "</li>" .
					"<li>Miltiary Skill: " . $row["expMilitary"] . "</li>" .
					"<li>Admin Skill: " . $row["expAdmin"] . "</li>" .
				"</ul>
			</holding>";
    }
}
else { echo "No Characters."; }
?>
</tr>
</td>



<!--MILITARY OVERVIEW SECTION -->
<tr>
<td>
<h2>Military Overview</h2>
<?php
$military = $conn->query("SELECT * FROM militaryunit WHERE owner = $hid");

if ($military->num_rows > 0) {
	while($row = $military->fetch_assoc()) {
		$pid = $row["loc"];
		$pname = $conn->query("SELECT name FROM planet WHERE pid = $pid");
		$row2 = $pname->fetch_assoc();
		$cid = $row["commander"];
		$cname = $conn->query("SELECT name FROM actor WHERE cid = $cid");
		if ($cname->num_rows > 0){
			$row3 = $cname->fetch_assoc();
			$commander = "<a href=\"/SN/character/character.php?varname=" . $cid . "\">" . $row3["name"] . "</a>";
		} else {
			$commander = "none";
		}
        echo 
			"<holding>
				<ul style=\"list-style-type:none\">" .
					"<li>Name: <a href=\"/SN/military/unit.php?varname=" . $row["mid"] . "\">" . $row["name"] . "</a></li>" .
					"<li>Type: " . (($row["type"] == 0)?("Ground"):("Space")) . "</li>" .
					"<li>Mobility: " . (($row["defMob"] == 0)?("Defensive"):("Mobile")) . "</li>" .
					"<li>Status: " . (($row["active"] == 0)?("Standby"):("Ready")) . "</li>" .
					"<li>Commander: " . $commander . "</li>" .
					"<li>Strength: " . $row["points"] . "</li>" .
					"<li>Experience: " . $row["exp"] . "</li>" .
					"<li>Location: <a href=\"/SN/planet/planet.php?varname=" . $pid . "\">" . $row2["name"] . "</a></li>" .
				"</ul>
			</holding>";
	}
}
else { echo "No Units."; }
?>
 
</tr>
</td>
</table>

<?php
$conn->close();
?> 
</body>
</html>