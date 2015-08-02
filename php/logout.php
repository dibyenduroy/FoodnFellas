<?php

session_unset(); #removes all the variables in the session
session_destroy(); # destroys the session
// Destroy the cookie.
unset($_COOKIE['FoodnFellas']);

if (!$_SESSION['user_id'])
	echo "Successfully logged out!";
else
	echo "Error Occurred!! <br />";

?>