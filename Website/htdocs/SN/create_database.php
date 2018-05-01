
<!DOCTYPE html>
<html>
<body>

<h1>Single Use Jump Start for Test Databases</h1>

<?php echo "Hello World!"; ?>
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
	pid INT(10) UNSIGNED PRIMARY KEY,
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
	foodReserve INT(10) UNSIGNED NOT NULL,
	mineralReserve INT(10) UNSIGNED NOT NULL,
	energyReserve INT(10) UNSIGNED NOT NULL,
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
	
	$sql = "ALTER TABLE planet_holding ADD UNIQUE unique_index (pid, hid)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table house_relation created altered for keys. ";
	} else {
		echo "<BR>Error editing table: " . $conn->error;
	}
	
	
//STARLANE TABLE
	$sql = "CREATE TABLE starlane (
	slid INT(10) UNSIGNED PRIMARY KEY,
	fPlanet INT(10) NOT NULL,
	flocX INT(10) NOT NULL,
	flocY INT(10) NOT NULL,
	sPlanet INT(10) NOT NULL,
	slocX INT(10) NOT NULL,
	slocY INT(10) NOT NULL,
	pub BOOL NOT NULL,
	starlane_units INT(10) UNSIGNED NOT NULL,
	starlane_hidden INT(10) UNSIGNED NOT NULL,
	reg_date TIMESTAMP
	)";
	
	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table starlane created successfully. ";
	} else {
		echo "<BR>Error creating table: " . $conn->error;
	}
	
	$sql = "ALTER TABLE starlane ADD UNIQUE unique_index (fplanet, splanet)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table house_relation created altered for keys. ";
	} else {
		echo "<BR>Error editing table: " . $conn->error;
	}
	
	//starlane_units
	$sql = "CREATE TABLE starlane_units (
	slid INT(10) UNSIGNED NOT NULL,
	uid INT(10) UNSIGNED NOT NULL,
	direction BOOL NOT NULL,
	percent INT(100) UNSIGNED NOT NULL,
	reg_date TIMESTAMP
	)";
	//direction 1 means from fplanet, 0 means from splanet
	//percent is how far down they have gone.

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table starlane_units created successfully. ";
	} else {
		echo "<BR>Error creating table: " . $conn->error;
	}
	
	//starlane_hidden KEEPS TRACK OF WHO CAN SEE ROUTE
	$sql = "CREATE TABLE starlane_hidden (
	pid INT(10) UNSIGNED NOT NULL,
	hid INT(10) UNSIGNED NOT NULL,
	hidden BOOL NOT NULL,
	reg_date TIMESTAMP
	)";
	//0 for hidden, 1 for visible
	
	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table starlane_hidden created successfully. ";
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
	hid INT(10) UNSIGNED NOT NULL,
	hid2 INT(10) UNSIGNED NOT NULL,
	relation INT(5) UNSIGNED NOT NULL,
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

//CHARACTER TABLE
	$sql = "CREATE TABLE actor (
	cid INT(10) UNSIGNED PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	birth INT(10) NOT NULL,
	gender BOOL NOT NULL,
	health INT(10) NOT NULL,
	preg INT(10) NOT NULL,
	pregStart INT(10) NOT NULL,
	descript VARCHAR(100) NOT NULL,
	loc INT(10) NOT NULL,
	owner INT(10) NOT NULL,
	pos INT(100) NOT NULL,
	intel INT(10) NOT NULL,
	brawn INT(10) NOT NULL,
	charisma INT(10) NOT NULL,
	expMilitary INT(10) NOT NULL,
	expAdmin INT(10) NOT NULL,
	reg_date TIMESTAMP
	)";
	//gender 1 FEMALE, 0 MALE
	//birth currently being used as a straight age number, until dating system is implemented.
	//preg 0 NOT PREG, cid IF PREG
	//pos 1 HEAD, LIST THESE LATER
	
	
	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table character created successfully.";
	} else {
		echo "<BR>Error creating table: " . $conn->error;
	}
	
	//char_relation	Character Relations
	$sql = "CREATE TABLE actor_relation (
	cidPri  INT(10) NOT NULL,
	cidRel INT(10) NOT NULL,
	relation INT(10) NOT NULL,
	reg_date TIMESTAMP
	)";
	//Relation: 0 NULL, 1 FATHER, 2 MOTHER, 3 CHILD, 4 LOVER, 5 MARRIED, 6 ENEMY, 7 RIVAL

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table char_rel created successfully. ";
	} else {
		echo "<BR>Error creating table: " . $conn->error;
	}	
	
	
//setting
	$sql = "CREATE TABLE setting (
	manualTick INT(10) UNSIGNED NOT NULL,
	shutdown INT(10) UNSIGNED NOT NULL,
	createGal INT(10) UNSIGNED NOT NULL,
	reg_date TIMESTAMP
	)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Table house_relation created successfully. ";
	} else {
		echo "<BR>Error creating table: " . $conn->error;
	}
	
//=============================TEST DATA=================================
//TEST DATA for SETTING
	$sql = "INSERT INTO setting (manualTick, shutdown, createGal)
	VALUES (0, 0, 1)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>Settings created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}

//TEST DATA for HOUSE
	$sql = "INSERT INTO house (hid, name, home, quote, house_relation, house_char, house_unit, house_planet, house_setting)
	VALUES (1, 'House Bob', 1, 'Woe is to our Foes', 1, 2, 3, 4, 5)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New House created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}

	$sql = "INSERT INTO house (hid, name, home, quote, house_relation, house_char, house_unit, house_planet, house_setting)
	VALUES (2, 'House Marley', 2, 'We Stand Ready', 1, 2, 3, 4, 5)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New House created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}

//TEST DATA for PLANET
	$sql = "INSERT INTO planet (pid, name, locX, locY, size, terrain, secTerrain, 
	descript, expLabour, genLabour, totalPop, minerals, popGrowth, wealth, eduLevel, foodReserve, mineralReserve, energyReserve)
	VALUES (1, 'POne', 5, 0, 3, 'Verdant', 'Overgrown', 'The first world.', 5, 7, 20, 5, 5, 5, 5, 500, 500, 500)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New planet created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}
	
	$sql = "INSERT INTO planet (pid, name, locX, locY, size, terrain, secTerrain, 
	descript, expLabour, genLabour, totalPop, minerals, popGrowth, wealth, eduLevel, foodReserve, mineralReserve, energyReserve)
	VALUES (2, 'PTwo', 14, 15, 3, 'Frozen', 'Icey', 'The second world.', 5, 7, 20, 5, 5, 5, 5, 500, 500, 500)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New planet created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}
	
	$sql = "INSERT INTO planet (pid, name, locX, locY, size, terrain, secTerrain, 
	descript, expLabour, genLabour, totalPop, minerals, popGrowth, wealth, eduLevel, foodReserve, mineralReserve, energyReserve)
	VALUES (3, 'PThree', 0, 14, 3, 'Desert', 'Hot', 'The Third world.', 5, 7, 20, 5, 5, 5, 5, 500, 500, 500)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New planet created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}
	
		$sql = "INSERT INTO planet (pid, name, locX, locY, size, terrain, secTerrain, 
	descript, expLabour, genLabour, totalPop, minerals, popGrowth, wealth, eduLevel, foodReserve, mineralReserve, energyReserve)
	VALUES (4, 'PFour', 5, 15, 3, 'Desert', 'Hot', 'The Fourth world.', 5, 7, 20, 5, 5, 5, 5, 500, 500, 500)";

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

//TEST DATA for STARLANE
	$sql = "INSERT INTO starlane (slid, fPlanet, flocX, flocY, sPlanet, slocX, slocY, pub, starlane_units, starlane_hidden)
	VALUES (1, 1, 5, 0, 2, 14, 15, 1, 1, 1)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New Holding created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}
	
	
	$sql = "INSERT INTO starlane (slid, fPlanet, flocX, flocY, sPlanet, slocX, slocY, pub, starlane_units, starlane_hidden)
	VALUES (2, 1, 5, 0, 3, 0, 14, 1, 2, 2)";
	
	if ($conn->query($sql) === TRUE) {
		echo "<BR>New Holding created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}


	
	
//TEST DATA for character
	$sql = "INSERT INTO actor (cid, name, birth, gender, health, preg, pregStart, descript, loc, owner, pos, intel, brawn, charisma, expMilitary, expAdmin)
	VALUES (1, 'Jo Bob', 12600, 0, 10, 0, 0, 'Jo Bob was his name.', 1, 1, 1, 3, 4, 4, 3, 4)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New Character created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}
	
		$sql = "INSERT INTO actor (cid, name, birth, gender, health, preg, pregStart, descript, loc, owner, pos, intel, brawn, charisma, expMilitary, expAdmin)
	VALUES (2, 'Alice Bob', 12600, 1, 5, 1, 5, 'Alice Bob was his name.', 2, 1, 1, 3, 4, 6, 3, 4)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New Character created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}
	
		$sql = "INSERT INTO actor (cid, name, birth, gender, health, preg, pregStart, descript, loc, owner, pos, intel, brawn, charisma, expMilitary, expAdmin)
	VALUES (3, 'Margert Bob', 1800, 0, 10, 0, 0, 'Son of Alice and Jo.', 1, 1, 2, 3, 2, 2, 2, 4)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New Character created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}
	
		//0 NULL, 1 FATHER, 2 MOTHER, 3 CHILD, 4 LOVER, 5 MARRIED, 6 ENEMY, 7 RIVAL
	
//TEST DATA for char_relation
	$sql = "INSERT INTO actor_relation (cidPri, cidRel, relation)
	VALUES (1, 2, 5)";

	if ($conn->query($sql) === TRUE) {
		echo "<BR>New Character Relation created successfully";
	} else {
		echo "<BR>Error: " . $sql . "<br>" . $conn->error;
	}
	

$conn->close();
?> 

</body>
</html>