
<!DOCTYPE html>
<html>
<body>

<h1>Single Use Jump Start for Test Databases</h1>

<?php
echo "Hello World!";
?>

<BR>

<?php
$servername = "localhost";
$username = "root";
$password = NULL;
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//DELETE OLD DATABASE
$sql = "DROP DATABASE myDB";
if ($conn->query($sql) === TRUE) {
    echo "<BR>Database deleted successfully.";
} else {
    echo "<BR>Error deleting database: " . $conn->error;
}


//CREATE DATABASE
echo "<BR>";
// Create database
$sql = "CREATE DATABASE myDB";
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
	$sql = "CREATE TABLE planet (
	pid INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(20) NOT NULL,
	locX INT(10) NOT NULL,
	locY INT(10) NOT NULL,
	size INT(1) UNSIGNED NOT NULL,
	terrain VARCHAR(20) NOT NULL,
	secTerrain VARCHAR(20) NOT NULL,
	descript VARCHAR(1000) NOT NULL,
	expLabour INT(10) UNSIGNED NOT NULL,
	genLabour INT(10) UNSIGNED NOT NULL,
	totalPop INT(10) UNSIGNED NOT NULL,
	minerals INT(10) UNSIGNED NOT NULL,
	popGrowth INT(10) UNSIGNED NOT NULL,
	wealth INT(10) UNSIGNED NOT NULL,
	eduLevel INT(10) UNSIGNED NOT NULL,
	planet_stock INT(10) UNSIGNED NOT NULL,
	planet_holding INT(10) UNSIGNED NOT NULL,
	planet_units INT(10) UNSIGNED NOT NULL,
	reg_date TIMESTAMP
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
	



//HOUSE DATA
	$sql = "CREATE TABLE house (
	hid INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(20) NOT NULL,
	home INT(10) UNSIGNED NOT NULL,
	quote VARCHAR(100) NOT NULL,
	house_relation INT(10) NOT NULL,
	house_char INT(10) UNSIGNED NOT NULL,
	house_unit INT(10) UNSIGNED NOT NULL,
	house_planet INT(10) UNSIGNED NOT NULL,
	house_setting INT(10) UNSIGNED NOT NULL,
	reg_date TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table house created successfully.";
	} else {
		echo "<BR>Error creating table: " . $conn->error;
	}

	//house_relations	Relations
	$sql = "CREATE TABLE house_relation (
	hid INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	type INT(5) UNSIGNED NOT NULL,
	reg_date TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table house_relation created successfully. ";
	} else {
		echo "<BR>Error creating table: " . $conn->error;
	}

	//house_char		Characters
	$sql = "CREATE TABLE house_char (
	cid INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	type INT(5) UNSIGNED NOT NULL,
	reg_date TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table house_char created successfully. ";
	} else {
		echo "<BR>Error creating table: " . $conn->error;
	}

	//house_unit		Military Units
	$sql = "CREATE TABLE house_unit (
	mid INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	reg_date TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table house_unit created successfully. ";
	} else {
		echo "<BR>Error creating table: " . $conn->error;
	}

	//house_planet		Planets
	$sql = "CREATE TABLE house_planet (
	pid INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	reg_date TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table house_planet created successfully. ";
	} else {
		echo "<BR>Error creating table: " . $conn->error;
	}

	//house_setting	Settings
	$sql = "CREATE TABLE house_setting (
	setting INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	reg_date TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table house_setting created successfully. ";
	} else {
		echo "<BR>Error creating table: " . $conn->error;
	}


//TEST DATA for HOUSE
	$sql = "INSERT INTO house (hid, name, home, quote, house_relation, house_char, house_unit, house_planet, house_setting)
	VALUES (1, 'House Bob', 42, 'Woe is to our Foes', 1, 2, 3, 4, 5)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New House created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}

	$sql = "INSERT INTO house (hid, name, home, quote, house_relation, house_char, house_unit, house_planet, house_setting)
	VALUES (2, 'House Marley', 42, 'We Stand Ready', 1, 2, 3, 4, 5)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New House created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}

//TEST DATA for PLANET
	$sql = "INSERT INTO planet (pid, name, locX, locY, size, terrain, secTerrain, 
	descript, expLabour, genLabour, totalPop, minerals, popGrowth, wealth, eduLevel, planet_stock, planet_holding, planet_units)
	VALUES (1, 'POne', 5, 0, 3, 'Verdant', 'Overgrown', 'The first world.', 5, 7, 20, 5, 5, 5, 5, 1, 1, 1)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New planet created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}
	
	$sql = "INSERT INTO planet (pid, name, locX, locY, size, terrain, secTerrain, 
	descript, expLabour, genLabour, totalPop, minerals, popGrowth, wealth, eduLevel, planet_stock, planet_holding, planet_units)
	VALUES (2, 'PTwo', 14, 15, 3, 'Frozen', 'Icey', 'The second world.', 5, 7, 20, 5, 5, 5, 5, 2, 2, 2)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New planet created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}
	
	$sql = "INSERT INTO planet (pid, name, locX, locY, size, terrain, secTerrain, 
	descript, expLabour, genLabour, totalPop, minerals, popGrowth, wealth, eduLevel, planet_stock, planet_holding, planet_units)
	VALUES (3, 'PThree', 0, 15, 3, 'Desert', 'Hot', 'The Third world.', 5, 7, 20, 5, 5, 5, 5, 3, 3, 3)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New planet created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}

//TEST DATA for  planet_holding
	$sql = "INSERT INTO planet_holding (pid, hid, food, rawMat, energy, upgrade1, upgrade2, upgrade3, upgrade4)
	VALUES (1, 1, 50, 60, 70, 1, 0, 0, 1)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New Holding created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}
	
		$sql = "INSERT INTO planet_holding (pid, hid, food, rawMat, energy, upgrade1, upgrade2, upgrade3, upgrade4)
	VALUES (2, 1, 50, 60, 70, 0, 1, 1, 0)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New Holding created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}
	
		$sql = "INSERT INTO planet_holding (pid, hid, food, rawMat, energy, upgrade1, upgrade2, upgrade3, upgrade4)
	VALUES (3, 1, 50, 60, 70, 1, 0, 0, 1)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New Holding created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}
	
		$sql = "INSERT INTO planet_holding (pid, hid, food, rawMat, energy, upgrade1, upgrade2, upgrade3, upgrade4)
	VALUES (2, 2, 50, 60, 70, 1, 0, 0, 1)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New Holding created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}


/*
$sql = "DROP DATABASE myDB";
if ($conn->query($sql) === TRUE) {
    echo "<BR>Database deleted successfully.";
} else {
    echo "<BR>Error deleting database: " . $conn->error;
}
*/

$conn->close();
?> 

</body>
</html>