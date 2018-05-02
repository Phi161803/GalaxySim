<!DOCTYPE html>
<html>
<head>
<style>
div.container {
    width: 100%;
    border: 1px solid gray;
	background-color: darkred;
}

header{
    padding: 0.25em;
    color: white;
    background-color: grey;
    clear: both;
    text-align: center;
}

footer {
    padding: 0.5em;
    color: white;
    background-color: grey;
    clear: both;
    text-align: center;
}

map {
	float: left;
    width: 55%;
	min-height: 500px;
	color: white;
    margin: 0;
	background-color: black;
	background-image: url("img/temp_map.jpg");
}

data {
	float: right;
    width: 44%;
	color: black;
    margin: 0;
	padding: 0.5%;
	background-color: darkred;
}
</style>
</head>
<body>

<div class="container">

<header>
   <H2>Shadow Nova Test Site</H2>
</header>
  
<map>
	<!-- <p align="center";>THIS WILL BE A MAP EVENTUALLY</p> -->
	<iframe id="map_frame" src="http://localhost/SN/map.php" style="border:none;" width="100%" height="700"></iframe>
</map>

<data>
	<iframe src="http://localhost/SN/Admin_Controls.php"  width="100%" height="90px"></iframe>
	<iframe id="data_frame" name="data_frame" src="http://localhost/SN/login.php"style="border:none;" width="100%" height="500"></iframe>
</data>

<footer>Group 12</footer>

</div>

</body>
</html>
