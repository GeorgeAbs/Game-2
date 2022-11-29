<?php
	session_start();
	require '../../Db/Db.php';
	$db = new Db();
	$gameName = $_SESSION['thisGame'];
	$query = "SELECT * FROM $gameName ORDER BY `Percents` + `HowMuchRemove` DESC";
	echo $db->returnJsonQuery($query);

?>