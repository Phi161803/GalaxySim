
<!DOCTYPE html>
<html>
<head>
<style>
table {
	width: 100%;
	text-align: center;
	border: 1px solid red;
	color: white;
	
}
td, th, tr{
	padding: 2px
	border: 1px solid red;
}
</style>
</head>

<!-- Boilerplate -->
<?php
session_start();
$_SESSION["user ID"] = 1;
$hid = $_SESSION["user ID"];
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
<!--Extremely basic map, no controls as of yet-->
<script>
function goplanet(pid) {
var x = "planet.php?varname=";
//document.write(pid);
parent.document.getElementById("data_frame").src = x+pid;
}
</script>

<?php

//echo "<button onclick=\"goplanet(1)\">" . "X" . "</button>";

$X = 0;
$Y = 0;

echo "<table>";
echo "<tr>";
$i = 0;
echo "<th></th>";
while ($i < 16){echo "<th>" . $i . "</th>"; $i++;}
echo "</tr>";
	while ($Y < 16){
		echo "<tr>";
		echo "<th>" . $Y . "</th>";
		while ($X < 16){
			$location = $conn->query("SELECT locY, locX, pid, name FROM planet WHERE locX = $X AND locY = $Y");
			$row = $location->fetch_assoc();
			echo "<td>";
			if ($location->num_rows > 0) {echo "<button onclick=\"goplanet(" . $row['pid'] . ")\">" . $row['name'] . "</button>";}
			else {echo " ";}
			echo "</td>";
			$X++;
		}
		$X = 0;
		$Y++;
	}

$conn->close();
?> 

</body>
</html>