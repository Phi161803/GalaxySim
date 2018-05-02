<html>
<head>
</head>
<body>
<!-- Boilerplate -->
<?php
session_start();
//$_SESSION["user ID"] = 1;
//$user = $_SESSION["user ID"];
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

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$name = $_POST["uname"];
	$pass = $_POST["pword"];
	
	$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
	$stmt->bind_param("s",$_POST["uname"]); //Avoids SQL injection
	$stmt->execute();
	$result = $stmt->get_result();
	$user = $result->fetch_object();
	
	if(password_verify($pass, $user->passhash)){
			$_SESSION["user ID"] = $user->uid;
			echo "Thank you " . $_POST['uname'] . " for logging in. <br> Click to <a href=\"/SN/house.php?varname=1\">Continue</a>";
		} else {
			echo "<p>Invalid username or password.</p>";
		}
}
?>

<?php if (isset($_SESSION["user ID"])): ?>
<h1>Welcome to Shadow Nova</h1>
<?php else: ?>
<h1>You are not logged in</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<input type="text" id="uname" name="uname" value="example" required><br>
	<input type="password" id="pword" name="pword" value="password" required><br>
	<input type="submit" value="Log In">
</form>
<?php endif; ?>

</body>
</html>