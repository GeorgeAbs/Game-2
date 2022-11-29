<?php
	session_start();
	require '../../Db/Db.php';
	$db = new Db();
	$gameName = $_SESSION['thisGame'];
	$query = "SELECT `UserName`, `Place`, `IsComp` FROM `$gameName`";
	$res_query = mysqli_query($db, $query);
	$fetched = mysqli_fetch_all($res_query, MYSQLI_ASSOC);
	echo $db->returnJsonQuery($query);
?>