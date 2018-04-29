
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
<img id ="planetA" style="display: none;" src="/SN/img/planetA.gif" />



<?php
	$size = 100;
	$X = $size/2;
	$Y = $size/2;
	$i = -$size/2;
	
echo '<canvas id="myCanvas" width="' . $size*32 . ' " height="' . $size*32 .'"
style="border:1px solid #FFFFFF;">
</canvas>';
	
//Adjusting zero point	
echo
	'<script>
		var canvas = document.getElementById("myCanvas");
		var ctx = canvas.getContext("2d");
		ctx.translate('. $size*16 . ',' . $size*16 . ')
	</script>';

//Coordinates	
while ($i <= $size/2)
	{
		echo
			'<script>
				var canvas = document.getElementById("myCanvas");
				var ctx = canvas.getContext("2d");
				ctx.font = "10px Arial";
				ctx.fillStyle= "white";
				ctx.fillText("' . $i . '",' . 0 . ',' . $i*32 . ');
				ctx.fillText("' . $i . '",' . $i*32 . ',' . 0 . ');
			</script>';
			$i++;
	}

//Starlanes
$lanes = $conn->query("SELECT flocX, flocY, slocX, slocY FROM starlane");
while($row = $lanes->fetch_assoc())
{			
	$FPY = $row['flocY']*32-16;
	$FPX = $row['flocX']*32+16;
	$SPY = $row['slocY']*32-16;
	$SPX = $row['slocX']*32+16;
	echo
		'<script>
			var canvas = document.getElementById("myCanvas");
			var ctx = canvas.getContext("2d");
			ctx.strokeStyle= "white";
			ctx.moveTo(' . $FPX . ',' . $FPY . ');
			ctx.lineTo(' . $SPX . ',' . $SPY . ');
			ctx.stroke();
		</script>';	
}	

//Planets
$location = $conn->query("SELECT locY, locX, pid, name FROM planet");
while($row = $location->fetch_assoc())
{
		$PY = $row['locY']*32-32;
	echo
		'<script>
			var canvas = document.getElementById("myCanvas");
			var ctx = canvas.getContext("2d");
			var img = document.getElementById("planetA");
			ctx.font = "15px Arial";
			ctx.fillStyle= "white";
			ctx.drawImage(img,' . $row['locX']*32 . ',' . $PY . ');
			ctx.fillText("' . $row['name'] . '",' . $row['locX']*32 . ',' . $row['locY']*32 . ');
		</script>';	
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