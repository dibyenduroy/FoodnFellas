<?php

	$conn = mysql_connect("fm1s2t7e010rjki.cnn0dbzvr04c.us-west-2.rds.amazonaws.com:3306", "fnfsandbox", "greatfood123")or die("cannot connect");
	$db = 	mysql_select_db("foodnfellas", $conn)or die("cannot select database");
	
?>