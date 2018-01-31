<?php
	DEFINE ('DB_USER', 'newaccount');
	DEFINE ('DB_PASSWORD', 'haslo123');
	DEFINE ('DB_HOST', 'localhost');
	DEFINE ('DB_NAME', 'COSA');
	$host = "localhost";
	$db_user = "newaccount";
	$db_password = "haslo123";
	$db_name = "COSA";

	$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
	OR die('Could not connect to MySQL: ' . mysqli_connect_error());

?>
