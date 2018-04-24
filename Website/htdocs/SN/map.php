
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
table {
	width: 100%;
	text-align: center;
	border: 1px solid red;
	color: white;
	
}
td, th, tr{
	padding: 2px
	border: 1px solid red;
}
</style>
</head>

<!-- Boilerplate -->
<?php
session_start();
$_SESSION["user ID"] = 1;
$hid = $_SESSION["user ID"];
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
<!--Extremely basic map-->

<?php
$size = 100;
$X = -$size/2;
$Y = -$size/2;

echo "<table>";
echo "<tr>";
$i = 0;
echo "<th></th>";
while ($i < $size){echo "<th>" . ($i-$size/2) . "</th>"; $i++;}
echo "</tr>";
	while ($Y < $size/2){
		echo "<tr>";
		echo "<th>" . $Y . "</th>";
		$location = $conn->query("SELECT locY, locX, pid, name FROM planet WHERE locY = $Y");//$location = $conn->query("SELECT locY, locX, pid, name FROM planet WHERE locX = $X AND locY = $Y");
		while($row = $location->fetch_assoc())
		{
			while ($X < $size/2){
			//$location = $conn->query("SELECT locY, locX, pid, name FROM planet WHERE locX = $X AND locY = $Y");
			//$row = $location->fetch_assoc();
			echo "<td>";
			//if ($location->num_rows > 0) {echo "<button onclick=\"goplanet(" . $row['pid'] . ")\">" . $row['name'] . "</button>";}
			//else {echo " ";}
			if ($row['locX'] == $X)
			{
				echo "<button onclick=\"goplanet(" . $row['pid'] . ")\">" . $row['name'] . "</button>";
				echo "</td>";
				$X++;
				break;
			}
			else {echo " ";}
			echo "</td>";
			$X++;
		}
		}
		
		$X = -$size/2;
		$Y++;
	}

$conn->close();
?> 

</body>
<script>
function goplanet(a) {parent.document.getElementById("data_frame").src = "/SN/planet/planet.php?varname="+a;}

(function($) {
  $.dragScroll = function(options) {
    var settings = $.extend({
      scrollVertical: true,
      scrollHorizontal: true,
      cursor: null
    }, options);

    var clicked = false,
      clickY, clickX;

    var getCursor = function() {
      if (settings.cursor) return settings.cursor;
      if (settings.scrollVertical && settings.scrollHorizontal) return 'move';
      if (settings.scrollVertical) return 'row-resize';
      if (settings.scrollHorizontal) return 'col-resize';
    }

    var updateScrollPos = function(e, el) {
      $('html').css('cursor', getCursor());
      var $el = $(el);
      settings.scrollVertical && $el.scrollTop($el.scrollTop() + (clickY - e.pageY));
      settings.scrollHorizontal && $el.scrollLeft($el.scrollLeft() + (clickX - e.pageX));
    }

    $(document).on({
      'mousemove': function(e) {
        clicked && updateScrollPos(e, this);
      },
      'mousedown': function(e) {
        clicked = true;
        clickY = e.pageY;
        clickX = e.pageX;
      },
      'mouseup': function() {
        clicked = false;
        $('html').css('cursor', 'auto');
      }
    });
  }
}(jQuery))

$.dragScroll();
</script>


</html>