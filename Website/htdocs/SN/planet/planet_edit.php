
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
echo '<a href="planet.php?varname=' . $pid . '">Back to Planet</a><br>';
?>


<h2>Editable Stats:</h2>

<?php
echo 'Name: <input type="text" id="name" value=' . $planet["name"] . '><br>';
echo 'Primary Type: <input type="text" id="terrain" value=' . $planet["terrain"] . '><br>';
echo 'Secondary Type: <input type="text" id="secTerrain" value=' . $planet["secTerrain"] . '><br>';
echo 'Description: <input type="text" id="descript" value=' . $planet["descript"] . '><br>';
echo 'Expert Labour: <input type="text" id="expLabour" value=' . $planet["expLabour"] . '><br>';
echo 'General Labour: <input type="text" id="genLabour" value=' . $planet["genLabour"] . '><br>';
echo 'Total Population: <input type="text" id="totalPop" value=' . $planet["totalPop"] . '><br>';
echo 'Mineral Deposits: <input type="text" id="minerals" value=' . $planet["minerals"] . '><br>';
echo 'Population Growth: <input type="text" id="popGrowth" value=' . $planet["popGrowth"] . '><br>';
echo 'Wealth: <input type="text" id="wealth" value=' . $planet["wealth"] . '><br>';
echo 'Education Level: <input type="text" id="eduLevel" value=' . $planet["eduLevel"] . '><br>';
?>
<button type="submit" id="update">Update</button>


<script>
	$(document).ready(function(){
		$("#update").click(function(){
			var name=$("#name").val();
			var terrain=$("#terrain").val();
			var secTerrain=$("#secTerrain").val();
			var descript=$("#descript").val();
			var expLabour=$("#expLabour").val();
			var genLabour=$("#genLabour").val();
			var totalPop=$("#totalPop").val();
			var minerals=$("#minerals").val();
			var popGrowth=$("#popGrowth").val();
			var wealth=$("#wealth").val();
			var eduLevel=$("#eduLevel").val();
			$.ajax({
				url:'update.php',
				method:'POST',
				data:{
					name:name,
					terrain:terrain,
					secTerrain:secTerrain,
					descript:descript,
					expLabour:expLabour,
					genLabour:genLabour,
					totalPop:totalPop,
					minerals:minerals,
					popGrowth:popGrowth,
					wealth:wealth,
					eduLevel:eduLevel
					},
				success:function(response){
					alert(response);
				}
			});
		});
	});
</script>


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

</tr>
</td>
</table>


<?php
$conn->close();
?> 
</body>
</html>