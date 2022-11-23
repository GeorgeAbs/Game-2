<?php
	session_start();
	$db = mysqli_connect('127.0.0.1', 'root', '', 'myDB');
	mysqli_set_charset($db, "utf8");
	$gameName = $_SESSION['thisGame'];
	$userPlace = $_SESSION['place'];
	if (isset($_POST['timerIsOver']))
	{
		$query = "UPDATE `$gameName` SET `TimerIsOver` = true, `RoundIsFinished` = true WHERE `Place` = '$userPlace'";
		mysqli_query($db, $query);
	}
	else
	{
		$query = "SELECT `TimerIsOver` FROM `$gameName` WHERE `Place` = '$userPlace' AND `TimerIsOver` = true";
		$res_query = mysqli_query($db, $query);
		if (mysqli_num_rows($res_query) == 1)
		{
			$query = "SELECT `RoundIsFinished` FROM `$gameName` WHERE `RoundIsFinished` = true";
			$res_query = mysqli_query($db, $query);
			if (mysqli_num_rows($res_query) == 0)
			{
				$query = "UPDATE `$gameName` SET `TimerIsOver` = false, `ThisRoundNumber` = `ThisRoundNumber` + 1 WHERE `Place` = '$userPlace'";
				mysqli_query($db, $query);
				echo 'newRound';
			}
		}
	}
	
?>