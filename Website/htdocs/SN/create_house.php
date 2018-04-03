
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
<!--Basic javascript to help iframes move-->
<script>
function link(page, a) {
var x = ".php?varname=";
//document.write(pid);
parent.document.getElementById("data_frame").src = page+x+a;
}
</script>

<?php //getting passed data
	if (empty($_GET)){$hid = 1;}
	else {$hid = $_GET['varname'];}
?>
<h1> Create a New House! </h1>

<form method="get" action="create_house_submit.php" method="post">
House Name: <input type="text" name="name"><br>

Quote: <input type="text" name="quote"><br>

Starting Planet:
<input type="radio" name="planet"
<?php if (isset($planet) && $planet==1) echo "checked";?>
value=1>POne
<input type="radio" name="planet"
<?php if (isset($planet) && $planet==2) echo "checked";?>
value=2>PTwo
<input type="radio" name="planet"
<?php if (isset($planet) && $planet==3) echo "checked";?>
value=3>PThree
<input type="submit">
</form>


<?php
$conn->close();
?> 
</body>
</html>