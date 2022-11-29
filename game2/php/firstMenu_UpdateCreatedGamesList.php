<?php
	require '../Db/Db.php';
	$db = new Db();
	$sql = "SHOW TABLES FROM `myDB`";
	echo $db->returnJsonQuery($sql);
?>