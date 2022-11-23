<?php
	session_start();
	if ($_SESSION['admin'] == 'admin')
	{
		$db = mysqli_connect('127.0.0.1', 'root', '', 'myDB');
		mysqli_set_charset($db, "utf8");
		$gameName = $_SESSION['thisGame'];
		
		if (isset($_POST['notZeroRound'])) //если игра стартовала
		{
			main($db, $gameName);
		}
		else // старт игры
		{
			$query = "UPDATE $gameName SET `RoundIsFinished` = false, `ThisRoundNumber` = 1";
			mysqli_query($db, $query);
		}
	}
	function main($db, $gameName)
	{
		mysqli_set_charset($db, "uft8");
		$query = "SELECT `ThisRoundNumber` FROM $gameName WHERE `ThisRoundNumber` = 21";
		$res = mysqli_query($db, $query);
		if (mysqli_num_rows($res) != 6) //если не 20 раунд
		{
			computerGame($db, $gameName);
			$query = "SELECT `RoundIsFinished` FROM $gameName WHERE `RoundIsFinished` = true AND `ThisRoundNumber` != 0";
			$res = mysqli_query($db, $query);
			if (mysqli_num_rows($res) == 6) //если все сходили и раунд не 0 (начало игры)
			{
				$query = "UPDATE $gameName SET `RoundIsFinished` = false, `Money_` = `Money_` + 10000 * (1- `Money_` / 30000), `P1` = false,`P2` = false,`P3` = false, `P4` = false,`P5` = false,`P6` = false  ";
				mysqli_query($db, $query);
			}
			else
			{
				return;
			}
		}
	}
	function computerGame($db, $gameName)
	{
		mysqli_set_charset($db, "uft8");
		$query = "SELECT `RoundIsFinished` FROM $gameName WHERE `RoundIsFinished` = false AND `IsComp` = 1";
		$res = mysqli_query($db, $query);
		if (mysqli_num_rows($res) != 0) //если комп не сходил еще, то ходит
		{
			//sleep(2);
			$query = "SELECT * FROM $gameName WHERE `RoundIsFinished` = false AND `IsComp` = 1";
			$res = mysqli_query($db, $query);
			$fetched = mysqli_fetch_all($res, MYSQLI_ASSOC);
			//foreach($fetched as $comp)
			//{
				$comp = $fetched[0];
				$iGood = 0;
				$iBad = 0;
				$bool = true;
				$compPlace = $comp['Place'];
				$query = "SELECT * FROM `EventsAndFunctions` WHERE `SelfFunction` = 'yes' ORDER BY `Price`";
				$goodFunctions = mysqli_fetch_all(mysqli_query($db, $query), MYSQLI_ASSOC);
				$query = "SELECT * FROM `EventsAndFunctions` WHERE `SelfFunction` = 'no' ORDER BY `Price`";
				$badFunctions = mysqli_fetch_all(mysqli_query($db, $query), MYSQLI_ASSOC);
				$query = "SELECT * FROM $gameName WHERE `Place` = '7'";
				$place_7 = mysqli_fetch_all(mysqli_query($db, $query), MYSQLI_ASSOC);
				echo 'ok1';
				while ($bool == true)
				{
					if (rand(0,1) >= $comp['CoeffitientOfComp']) //good
					{
						if ($comp['Money_'] >= $goodFunctions[$iGood]['Price'] && $iGood < count($goodFunctions))//если хватает денег
						{
							$remainMoney = $comp['Money_'] - $goodFunctions[$iGood]['Price'];
							$influence = $goodFunctions[$iGood]['InfluenceRating'];
							$restPercents = round((1-$influence) * $place_7[0]['Percents'], 2);
							$difPercents = $place_7[0]['Percents'] - $restPercents;
							/////////////////
							$query = "UPDATE $gameName SET `Money_` = $remainMoney, `HowMuchRemove` = `HowMuchRemove` + $difPercents *  0.2, `Percents` = `Percents`+ $difPercents  WHERE `Place` = '$compPlace'";
							mysqli_query($db, $query);
							$me = "P$compPlace";
							/////////////////
							$query = "UPDATE $gameName SET $me = true, `Percents` = $restPercents  WHERE `Place` = '7'";
							mysqli_query($db, $query);
							////////
							$iGood++;
						}
						else{$bool = false;}
					}
					else //bad
					{
						if ($comp['Money_'] >=$badFunctions[$iBad]['Price'] && $iBad < count($badFunctions))//если хватает денег
						{
							$query = "SELECT * FROM $gameName WHERE `Place` != '7' OR `Place` != '$compPlace' ORDER BY `Percents` DESC";
							$allUsers = mysqli_fetch_all(mysqli_query($db, $query), MYSQLI_ASSOC);
							$topUser = $allUsers[0]['Place'];
							$remainMoney = $comp['Money_'] - $badFunctions[$iBad]['Price'];
							$influence = $badFunctions[$iBad]['InfluenceRating'];
							$restPercents = round((1-$influence) * $allUsers[0]['Percents'], 2);
							$difPercents = $allUsers[0]['Percents'] - $restPercents;
							/////////////////
							$query = "UPDATE $gameName SET `Money_` = $remainMoney, `HowMuchRemove` = `HowMuchRemove` + $difPercents *  0.1 WHERE `Place` = '$compPlace'";
							mysqli_query($db, $query);
							$me = "P$compPlace";
							/////////////////
							$query = "UPDATE $gameName SET $me = true, `Percents` = $restPercents  WHERE `Place` = '$topUser'";
							mysqli_query($db, $query);
					
							$query = "UPDATE $gameName SET `Percents` = `Percents`+ $difPercents  WHERE `Place` = '7'";
							mysqli_query($db, $query);
							////////
							$iBad++;
						}
						else{$bool = false;}
					}
				}
			//}
			$query = "UPDATE $gameName SET `RoundIsFinished` = true, `ThisRoundNumber` = `ThisRoundNumber` + 1 WHERE `Place` = $compPlace";
			mysqli_query($db, $query);
		}
		
	}
?>