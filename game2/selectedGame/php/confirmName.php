<?php
	session_start();
	$_SESSION['place'] = $_POST['place'];
	$gameName = $_SESSION['thisGame'];
	$db = mysqli_connect('127.0.0.1', 'root', '', 'myDB');
	mysqli_set_charset($db, "utf8");
	$userName = $_POST['userName'];
	$userPlace = $_SESSION['place'];
	$query = "UPDATE $gameName SET `UserName` = '$userName', `IsComp` = false WHERE `Place` = $userPlace";
	mysqli_query($db, $query);
	echo $gameName, $userName, $userPlace;

?>