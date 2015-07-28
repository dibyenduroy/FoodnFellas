<?php include_once("db.php"); ?>

<?php

session_unset(); #removes all the variables in the session
session_destroy(); # destroys the session

if (!$_SESSION['userName'])
	echo "Successfully logged out!";
else
	echo "Error Occurred!! <br />";

?>