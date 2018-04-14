
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
<table>
<tr>
<td>
<!--HOUSE LIST SECTION -->
<h2>Houses In Galaxy</h2>
<?php
$result = $conn->query("SELECT hid, name, home FROM house");
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$hid = $row["hid"];
		$name = $row["name"];
		$home = $row["home"];
		
		$pla = $conn->query("SELECT name FROM planet WHERE pid = $home");
		$row2 = $pla->fetch_assoc();
		$home2 = $row2['name'];
        echo 
			"<holding>
				<ul style=\"list-style-type:none\">
					<li>Owner: <a href=\"house.php?varname=" . $hid . "\">" . $name . "</a></li>" .
					"<li>Homeworld: <a href=\"/SN/planet/planet.php?varname=" . $home ."\">" . $home . "</a></li></ul>" .
			"</holding>";
    }
}
else { echo "<BR>No Houses."; }
?>
</tr>
</td>
</table>


<?php
$conn->close();
?> 
</body>
</html>