
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
<h2>Planets In Galaxy</h2>
<?php
$result = $conn->query("SELECT pid, name FROM planet");
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$pid = $row["pid"];
		$name = $row["name"];
        echo 
			"<holding>
				<ul style=\"list-style-type:none\">
					<li>Owner: <a href=\"/SN/planet/planet.php?varname=" . $pid . "\">" . $pid . "</a></li></ul>" .
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