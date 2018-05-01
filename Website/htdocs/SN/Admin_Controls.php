<!DOCTYPE html>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<body>
<!--Basic javascript to help iframes move-->
<script>
function golink(page, a) {
var x = ".php?varname=";
//document.write(pid);
parent.document.getElementById("data_frame").src = page+x+a;
}

function golink(page) {
var x = ".php";
//document.write(page+x);
parent.document.getElementById("data_frame").src = page+x;
setTimeout(function(){
	parent.document.getElementById("map_frame").src = "map.php";
},500);
}

function gomap(page) {
var x = ".php";
//document.write(page+x);
parent.document.getElementById("data_frame").src = page+x;
setTimeout(function(){
	parent.document.getElementById("map_frame").src = "map.php";
},500);
}

function update(val){
      $.ajax({
        type: "POST",
        url: "settings_update.php",
        data: { val:val},
        success:function( msg ) {
         //alert( "Data Saved: " + msg );
        }
       });
}

</script>

Testing Control Panel<br>
<button onclick="gomap('create_database')">Recreate Database Page</button>
<button onclick="golink('house', 1)">Default House</button>
<button onclick="golink('/SN/character/character', 1)">Default Character</button>
<button onclick="golink('create_house')">Create New House</button>
<BR>
<button onclick="golink('house_list')">House List</button>
<button onclick="golink('planet_list')">Planet List</button>
<button onclick="update('manualTick')">Manual Tick</button>
<button onclick="update('createGal')">Create Galaxy</button>
<button onclick="update('shutdown')">Shutdown</button>
</body>
</html>