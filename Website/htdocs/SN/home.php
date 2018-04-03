<!DOCTYPE html>
<html>
<head>
<style>
div.container {
    width: 100%;
    border: 1px solid gray;
}

header, footer {
    padding: 1em;
    color: white;
    background-color: grey;
    clear: both;
    text-align: center;
}

map {
	float: left;
    width: 45%;
	min-height: 500px;
	color: white;
    margin: 0;
	background-image: url("img/temp_map.jpg");
}

data {
	float: right;
    width: 54%;
	color: black;
    margin: 0;
	padding: 0.5%;
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
<iframe src="http://localhost/SN/map.php"style="border:none;" width="100%" height="500px"></iframe>
</map>

<data>
	<!--<iframe src="http://localhost/SN/Admin_Controls.php"  width="100%" height="100%"></iframe> -->
	<iframe src="http://localhost/SN/house.php"style="border:none;" width="100%" height="500px"></iframe>
</data>

<footer>Group 12</footer>

</div>

</body>
</html>
