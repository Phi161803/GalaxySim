
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
echo '<a href="unit.php?varname=' . $mid . '">Back to Unit</a><br>';
?>


<h2>Editable Stats:</h2>

<?php
if (!isset($_SESSION["user ID"])) {
	echo 'You are not logged in! Please <a href="/SN/login.php">log in</a> to edit units.';
} else {
	echo '<input type="hidden" id="mid" value="' . $mid . '">';
	echo 'Name: <input type="text" id="name" value="' . $unit["name"] . '"><br>';
	echo 'Owner: <input type="text" id="owner" value="' . $unit["owner"] . '"><br>';
	echo 'Location: <input type="text" id="loc" value="' . $unit["loc"] . '"><br>';
	
	//TODO - figure out a good way to input boolean data here
	
	//echo 'Type: <input type="text" id="type" value="' . $unit["type"] . '"><br>';
	//echo 'Mobility: <input type="text" id="defMob" value="' . $unit["defMob"] . '"><br>';
	//echo 'Status: <input type="text" id="name" value="' . $unit["name"] . '"><br>';
	
	echo 'Strength: <input type="text" id="points" value="' . $unit["points"] . '"><br>';
	echo 'Experience: <input type="text" id="exp" value="' . $unit["exp"] . '"><br>';
?>
<button type="submit" id="update">Update</button>
<?php } ?>


<script>
	$(document).ready(function(){
		$("#update").click(function(){
			var mid = $("#mid").val();
			var name=$("#name").val();
			var owner=$("#owner").val();
			var loc=$("#loc").val();
			var points=$("#points").val();
			var exp=$("#exp").val();
			$.ajax({
				url:'update.php',
				method:'POST',
				data:{
					mid:mid,
					name:name,
					owner:owner,
					loc:loc,
					points:points,
					exp:exp
					},
				success:function(response){
					alert(response);
				}
			});
		});
	});
</script>

<?php
$conn->close();
?> 
</body>
</html>