<?php
	session_start();
	require '../../Db/Db.php';
	$db = new Db();
	$query = "SELECT * FROM `EventsAndFunctions` WHERE `EventOrFunction` = 'Function'";
	echo $db->returnJsonQuery($query);
?>
