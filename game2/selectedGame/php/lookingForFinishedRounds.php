<?php
	session_start();
	require '../../Db/Db.php';
	$db = new Db();
	$gameName = $_SESSION['thisGame'];
	$userPlace = $_SESSION['place'];
	if (isset($_POST['timerIsOver']))
	{
		$query = "UPDATE `$gameName` SET `TimerIsOver` = true, `RoundIsFinished` = true WHERE `Place` = '$userPlace'";
		$db->noReturnQuery($query);
	}
	else
	{
		$query = "SELECT `TimerIsOver` FROM `$gameName` WHERE `Place` = '$userPlace' AND `TimerIsOver` = true";
		$res_query = $db->returnQuery($query);
		if (mysqli_num_rows($res_query) == 1)
		{
			$query = "SELECT `RoundIsFinished` FROM `$gameName` WHERE `RoundIsFinished` = true";
			$res_query = $db->returnQuery($query);
			if (mysqli_num_rows($res_query) == 0)
			{
				$query = "UPDATE `$gameName` SET `TimerIsOver` = false, `ThisRoundNumber` = `ThisRoundNumber` + 1 WHERE `Place` = '$userPlace'";
				$db->noReturnQuery($query);
				echo 'newRound';
			}
		}
	}
	
?>