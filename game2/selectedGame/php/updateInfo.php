<?php
	session_start();
	$db = mysqli_connect('127.0.0.1', 'root', '', 'myDB');
	mysqli_set_charset($db, "utf8");
	$gameName = $_SESSION['thisGame'];
	$query = "SELECT * FROM $gameName";
	$res = mysqli_fetch_all(mysqli_query($db, $query), MYSQLI_ASSOC);
	echo json_encode($res);
?>