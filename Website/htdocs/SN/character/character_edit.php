
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
<?php
$cid = $_GET['varname'];
$result = $conn->query("SELECT cid, name, birth, gender, health, preg, pregStart, descript, loc, owner, pos, intel, brawn, charisma, expMilitary, expAdmin FROM actor WHERE cid = $cid") or die($conn->error);
$character = $result->fetch_assoc();
echo '<a href="character.php?varname=' . $cid . '">Back to Character</a><br>';

echo '<h2>Editable Stats:</h2>';
echo '<input type="hidden" id="cid" value="' . $cid . '">';
echo 'Name: <input type="text" id="name" value="' . $character["name"] . '"><br>';
echo 'Born on : <input type="text" id="birth" value=' . $character["birth"] . '><br>';
echo 'Description: <input type="text" id="descript" value="' . $character["descript"] . '"><br>';
echo 'Gender: <input type="text" id="gender" value=' . (($character["gender"] == 0)?("male"):("female")) . '><br>';
echo 'Health: <input type="text" id="health"" value=' . $character["health"] . '><br>';
echo 'Brawn: <input type="text" id="brawn" value=' . $character["brawn"] . '><br>';
echo 'Intelligence: <input type="text" id="intel" value=' . $character["intel"] . '><br>';
echo 'Charisma: <input type="text" id="charisma" value=' . $character["charisma"] . '><br>';
echo 'Military Experience: <input type="text" id="expMilitary" value=' . $character["expMilitary"] . '><br>';
echo 'Admin Experience: <input type="text" id="expAdmin" value=' . $character["expAdmin"] . '><br>';
echo 'Pregnant: <input type="text" id="preg" value=' . $character["preg"] . '><br>';
echo 'PregnantStart: <input type="text" id="pregStart" value=' . $character["pregStart"] . '><br>';
echo 'Currently On: <input type="text" id="loc" value=' . $character["loc"] . '><br>';
echo 'Position in the House: <input type="text" id="pos" value=' . $character["pos"] . '><br>';
echo 'Controlled by: <input type="text" id="owner" value=' . $character["owner"] . '><br>';
?>
<button type="submit" id="update">Update</button>


<script>
	$(document).ready(function(){
		$("#update").click(function(){
			var cid=$("#cid").val();
			var name=$("#name").val();
			var birth=$("#birth").val();
			var gender=$("#gender").val();
			var descript=$("#descript").val();
			var health=$("#health").val();
			var brawn=$("#brawn").val();
			var intel=$("#intel").val();
			var charisma=$("#charisma").val();
			var expMilitary=$("#expMilitary").val();
			var expAdmin=$("#expAdmin").val();
			var preg=$("#preg").val();
			var pregStart=$("#pregStart").val();
			var pos=$("#pos").val();
			var loc=$("#loc").val();
			var owner=$("#owner").val();
					
			$.ajax({
				url:'update.php',
				method:'POST',
				data:{
					cid:cid,
					name:name,
					birth:birth,
					descript:descript,
					gender:gender,
					health:health,
					brawn:brawn,
					intel:intel,
					charisma:charisma,
					expMilitary:expMilitary,
					expAdmin:expAdmin,
					preg:preg,
					pregStart:pregStart,
					pos:pos,
					loc:loc,
					owner:owner
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