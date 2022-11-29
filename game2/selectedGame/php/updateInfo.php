<?php
	session_start();
	require '../../Db/Db.php';
	$db = new Db();
	$gameName = $_SESSION['thisGame'];
	$query = "SELECT * FROM $gameName";
	echo $db->returnJsonQuery($query);
?>