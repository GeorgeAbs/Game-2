document.querySelector(".confirmNewGameBut").addEventListener('click', function(){
	var gameName = document.querySelector(".inputNewGameName").value;
	if (gameName != '')
	{
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200)
        	{
        		window.location.href = "http://game2/selectedGame/index.html";
        	}
    	}
    	xmlhttp.open("POST", "php/createNewGame_DB.php", true);
    	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    	xmlhttp.send("newGameName=" + gameName);
	}
});