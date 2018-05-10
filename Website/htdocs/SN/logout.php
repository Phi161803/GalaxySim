<html>
<head>
</head>
<body>
<?php
session_start();

$_SESSION = array();
if (ini_get("session.use_cookies")) {
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"]
	);
}
echo "<script>
parent.document.getElementById(\"control_frame\").src = \"\";
parent.document.getElementById(\"control_frame\").width = \"0\";
parent.document.getElementById(\"control_frame\").height = \"0\";
parent.document.getElementById(\"control_frame\").border = \"0\";
</script>";
session_destroy();
?>

<h2>You have been logged out</h2>

Click to <a href="/SN/login.php">Continue</a>
</body>
</html>