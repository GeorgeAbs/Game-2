setInterval(queryForCreatedGames ,1000);
function queryForCreatedGames()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
       	if (this.readyState == 4 && this.status == 200)
       	{
       		createCreatedGamesButtons(this.responseText);
       	}
    }
    xmlhttp.open("POST", "php/firstMenu_UpdateCreatedGamesList.php", true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send();
}
function createCreatedGamesButtons(returnedValue)
{
	var returnedValueArr = JSON.parse(returnedValue);
	var ul = document.querySelector('.listOfGames');
	ul.innerHTML = "";
	if (returnedValueArr.length == 0)
	{
		var ul = document.querySelector('.listOfGames');
       	let li = document.createElement("li");
		li.innerHTML = "<li>Нет созданых игр</li>";
		ul.appendChild(li);
	}
	else
	{
		for(var newButName of returnedValueArr)
		{
			if (newButName['Tables_in_mydb'] != 'EventsAndFunctions' &&
				newButName['Tables_in_mydb'] != 'cards_for_21' &&
				newButName['Tables_in_mydb'] != 'cards_for_21_game' &&
				newButName['Tables_in_mydb'] != 'login_passwords_time')
			{
				let li = document.createElement("li");
				li.innerHTML = "<button class='butInList'>" + newButName['Tables_in_mydb'] + "</button>";
				let gameName = newButName['Tables_in_mydb'];
				li.addEventListener('click', function(){
					console.log(gameName);
					
		
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
    				   	if (this.readyState == 4 && this.status == 200)
    				   	{
    				   		window.location.href = "http://game2/selectedGame/index.html";
    				   	}
    				}
    				xmlhttp.open("POST", "php/createNewGame_DB.php", true);//записать в session имя игры
    				xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    				xmlhttp.send("chosenGame=" + gameName);
				});
				ul.appendChild(li);
			}
		}
	}
	
}
function openSelectedGame()
{
	
}
