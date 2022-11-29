<?php
	session_start();
	require '../../Db/Db.php';
	$_SESSION['place'] = $_POST['place'];
	$gameName = $_SESSION['thisGame'];
	$userName = $_POST['userName'];
	$userPlace = $_SESSION['place'];
	$query = "UPDATE $gameName SET `UserName` = '$userName', `IsComp` = false WHERE `Place` = $userPlace";
	$db = new Db();
	$db->noReturnQuery($query);
	echo $gameName, $userName, $userPlace;

?>