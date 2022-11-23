<?php
	session_start();
	$db = mysqli_connect('127.0.0.1', 'root', '', 'myDB');
	mysqli_set_charset($db, "utf8");
	$query = "SELECT * FROM `EventsAndFunctions` WHERE `EventOrFunction` = 'Function'";
	echo json_encode(mysqli_fetch_all(mysqli_query($db, $query), MYSQLI_ASSOC));
?>