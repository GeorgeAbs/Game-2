<?php
	session_start();
	$db = mysqli_connect('127.0.0.1', 'root', '', 'myDB');
	mysqli_set_charset($db, "utf8");
	$functionName = $_POST['functionName'];
	$gameName = $_SESSION['thisGame'];
	$userPlace = $_SESSION['place'];
	$anotherUser = $_POST['anotherName'];
	$query = "SELECT * FROM `EventsAndFunctions` WHERE `Description` = '$functionName'";
	$res1 = mysqli_fetch_all(mysqli_query($db, $query), MYSQLI_ASSOC);
	$price = $res1[0]['Price'];
	$influence = $res1[0]['InfluenceRating'];
	$query = "SELECT * FROM $gameName WHERE `Place` = '$userPlace'";
	$res2 = mysqli_fetch_all(mysqli_query($db, $query), MYSQLI_ASSOC);
	$query = "SELECT * FROM $gameName WHERE `Place` = '$anotherUser'";
	$res3 = mysqli_fetch_all(mysqli_query($db, $query), MYSQLI_ASSOC);
	$restPercents = round((1-$influence) * $res3[0]['Percents'], 2);
	$difPercents = round($res3[0]['Percents'] - $restPercents, 2);
	$remainMoney = $res2[0]['Money_'] - $price;
	if ($remainMoney >= 0)
	{
		if ($res1[0]['SelfFunction'] == 'no' && $anotherUser != '7' && $anotherUser != $userPlace)
		{
			$query = "UPDATE $gameName SET `Money_` = $remainMoney, `HowMuchRemove` = `HowMuchRemove` + $difPercents * 0.1 WHERE `Place` = '$userPlace'";
			mysqli_query($db, $query);
			$me = "P$userPlace";
	
			$query = "UPDATE $gameName SET $me = true, `Percents` = $restPercents  WHERE `Place` = '$anotherUser'";
			mysqli_query($db, $query);
	
			$query = "UPDATE $gameName SET `Percents` = `Percents`+ $difPercents  WHERE `Place` = '7'";
			mysqli_query($db, $query);
	
			$removed = $res2[0]['HowMuchRemove'] + $difPercents * 0.1;
			$returnArr = array('money' => $remainMoney, 'removerPercents' => $removed);
			echo json_encode($returnArr);
		}
		else if ($res1[0]['SelfFunction'] == 'yes' && $anotherUser == '7')
		{
			$query = "UPDATE $gameName SET `Money_` = $remainMoney, `HowMuchRemove` = `HowMuchRemove` + $difPercents *  0.2, `Percents` = `Percents`+ $difPercents  WHERE `Place` = '$userPlace'";
			mysqli_query($db, $query);
			$me = "P$userPlace";
	
			$query = "UPDATE $gameName SET $me = true, `Percents` = $restPercents  WHERE `Place` = '7'";
			mysqli_query($db, $query);
	
			$removed = $res2[0]['HowMuchRemove'] + $difPercents * 0.2;
			$returnArr = array('money' => $remainMoney, 'removerPercents' => $removed);
			echo json_encode($returnArr);
		}
		else
		{
			$returnArr = array('money' => $res2[0]['Money_'], 'removerPercents' => $res2[0]['HowMuchRemove']);
			echo json_encode($returnArr);
		}
	}
	else
	{
		$returnArr = array('money' => $res2[0]['Money_'], 'removerPercents' => $res2[0]['HowMuchRemove']);
		echo json_encode($returnArr);
	}
	
?>