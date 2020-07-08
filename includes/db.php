<?php
	session_start();

	$host = '172.16.11.22:3306';
	$dbname = 'gilr1_17_TerritalCRM';
	$user = 'gilr1_Territal';
	$pass = '?Xj1fk03';

	try {
		$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>