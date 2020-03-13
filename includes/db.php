<?php
	session_start();

	$host = 'localhost';
	$dbname = 'TerritalCRM';
	$user = 'root';
	$pass = '';

	try {
		$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>