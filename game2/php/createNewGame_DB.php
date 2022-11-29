<?php
	session_start();
	if (isset($_POST['chosenGame']))
	{
		$_SESSION['thisGame'] = $_POST['chosenGame'];
		$_SESSION['admin'] = 'noAdmin';
	}
	else
	{
		require '../Db/Db.php';
		$_SESSION['thisGame'] = $_POST['newGameName'];
		$_SESSION['admin'] = 'admin';
		$gameName = $_POST['newGameName'];
		$query = "CREATE TABLE $gameName (
				UserName varchar(255),
    			Place varchar(255),
    			Money_ int,
    			Percents numeric(10,2),
    			RoundIsFinished bool,
    			ThisRoundNumber int,
    			Rounds int,
    			TimerIsOver bool,
    			IsComp bool,
    			P1 bool,
    			P2 bool,
    			P3 bool,
    			P4 bool,
    			P5 bool,
    			P6 bool,
    			HowMuchRemove numeric(10,2),
    			CoeffitientOfComp numeric(10,2)
			)";
		$db = new Db();
		$db->noReturnQuery($query);
		for ($i=1; $i <= 6; $i++)
		{ 	
			$coef = rand(0,100) / 100; 
			$comp = "Computer$i";
			$query = "INSERT INTO $gameName (UserName, Place, Money_, Percents, RoundIsFinished, ThisRoundNumber, Rounds, TimerIsOver, IsComp, P1, P2, P3, P4, P5, P6, HowMuchRemove, CoeffitientOfComp) VALUES ('$comp', $i, 10000, 16.67, true, 0, 16, true, true, false, false, false, false,false, false, 0.00, $coef)";
			$db->noReturnQuery($query);
		}
		$query = "INSERT INTO $gameName (UserName, Place, Percents, P1, P2, P3, P4, P5, P6) VALUES ('freePeople', 7, 0.00, false, false, false, false,false, false)";
		$db->noReturnQuery($query);
		
	}
	
?>