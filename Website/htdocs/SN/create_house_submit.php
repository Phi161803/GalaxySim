
<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  
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


<?php
$name = $_GET['name'];
$quote = $_GET['quote'];
$planet = $_GET['planet'];
echo $name;
echo $quote;
echo $planet;

?>


<?php
$conn->close();
?> 
</body>
</html>
