<!DOCTYPE html>
<html>
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
}
</script>

Testing Control Panel<br>
<button onclick="golink('create_database')">Recreate Database Page</button>
<button onclick="golink('house', 1)">Default House</button>
<button onclick="golink('create_house')">Create New House</button>
</body>
</html>