
<!DOCTYPE html>
<html>
<body>

<h1>Single Use Jump Start for Test Databases</h1>

<?php echo "Hello World!"; ?>
<?php
$servername = "localhost";
$username = "root";
$password = NULL;
$dbname = "myT";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//DELETE OLD DATABASE
$sql = "DROP DATABASE myT";
if ($conn->query($sql) === TRUE) {
    echo "<BR>Database deleted successfully.";
} else {
    echo "<BR>Error deleting database: " . $conn->error;
}


//CREATE DATABASE
echo "<BR>";
// Create database
$sql = "CREATE DATABASE myT";
if ($conn->query($sql) === TRUE) {
    echo "<BR>Database created successfully.";
} else {
    echo "<BR>Error creating database: " . $conn->error;
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//CREATE TABLE
//========================
//PLANET TABLE
	$sql = "CREATE TABLE users (
id int(11) NOT NULL auto_increment,
name varchar(100) NOT NULL,
age int(3) NOT NULL,
email varchar(100) NOT NULL,
PRIMARY KEY (id)
)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table planet created successfully.";
	} else {
		echo "<BR>Error creating table: " . $conn->error;
	}
	
	//planet_holding WILL HAVE MORE RESOURCES and UPGRAGES
	$sql = "CREATE TABLE planet_holding (
	pid INT(10) UNSIGNED NOT NULL,
	hid INT(10) UNSIGNED NOT NULL,
	food INT(5) UNSIGNED NOT NULL,
	rawMat INT(5) UNSIGNED NOT NULL,
	energy INT(5) UNSIGNED NOT NULL,
	upgrade1 BOOL NOT NULL,
	upgrade2 BOOL NOT NULL,
	upgrade3 BOOL NOT NULL,
	upgrade4 BOOL NOT NULL,
	reg_date TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table house_relation created successfully. ";
	} else {
		echo "<BR>Error creating table: " . $conn->error;
	}
	
$conn->close();
?> 

</body>
</html>