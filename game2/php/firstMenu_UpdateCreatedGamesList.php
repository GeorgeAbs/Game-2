<?php
	$db = mysqli_connect('127.0.0.1', 'root', '', 'myDB');
	$sql = "SHOW TABLES FROM `myDB`";
	$result = mysqli_query($db, $sql);
	$fetched = mysqli_fetch_All($result, MYSQLI_ASSOC);
	echo json_encode($fetched);
?>