<?php
	session_start();
	$gameName = $_SESSION['thisGame'];
	$db = mysqli_connect('127.0.0.1', 'root', '', 'myDB');
	mysqli_set_charset($db, "utf8");
	$query = "SELECT `UserName`, `Place`, `IsComp` FROM `$gameName`";
	$res_query = mysqli_query($db, $query);
	$fetched = mysqli_fetch_all($res_query, MYSQLI_ASSOC);
	echo json_encode($fetched);
?>