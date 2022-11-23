var interval = setInterval(housesFunc ,1000);
var arrowsStarted = false;
function housesFunc()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
       	if (this.readyState == 4 && this.status == 200)
       	{
       		console.log(this.responseText);
       		if (this.responseText == 'newRound')
       		{
       			timerFunc();
       			let arrs = document.querySelectorAll('.lineDiv');
       			for(let arr of arrs)
       			{
       				arr.setAttribute('x1', 0);
       				arr.setAttribute('x2', 0);
       				arr.setAttribute('y1', 0);
       				arr.setAttribute('y2', 0);
       			}
       			if (arrowsStarted == false)
       			{
       				arrowsStarted = true;
       				updateArrows();
       			}
       		}
       	}
    }
    xmlhttp.open("POST", "php/lookingForFinishedRounds.php", true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send();
}
function timerFunc()
{
	updateInfo();
	updateFunctions();

	let countDownDate = new Date().getTime() + 30*1000;
	let timer = setInterval(function()
	{
		var now = new Date().getTime();
		var differece = Math.ceil((countDownDate - now) / 1000);
		document.querySelector('.timerSpan').innerHTML = Math.ceil((countDownDate - now) / 1000);
		if (differece == 0 )
		{
			clearInterval(timer);
			sendResponceTimer();
		}

	}, 1000);
}
function sendResponceTimer()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
       	if (this.readyState == 4 && this.status == 200)
       	{
       		
       	}
    }
    xmlhttp.open("POST", "php/lookingForFinishedRounds.php", true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send("timerIsOver=timerIsOver");
}
function updateInfo()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
       	if (this.readyState == 4 && this.status == 200)
       	{
       		let fromPHP = JSON.parse(this.responseText);
       		let places = document.querySelectorAll('.percentsSpan');
       		document.querySelector('.turnSpan').innerHTML = fromPHP[0]['ThisRoundNumber'];
            for (let place of places)
            {
                for (let placeFromDB of fromPHP) 
                {
                	
                    if (place.getAttribute('value') == placeFromDB['Place'])
                    {
                        place.innerHTML = placeFromDB['Percents'];
                        if (place.parentNode.parentNode.querySelector('.scieneImage').classList.contains('myBuildingBorder'))
                    	{
                    		document.querySelector('.moneySpan').innerHTML = placeFromDB['Money_'];
                    	}
                    }
                }
            }
       	}
    }
    xmlhttp.open("POST", "php/updateInfo.php", true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send();
}
function updateFunctions()
{
	var buttons = document.querySelectorAll('.butInList');
	for(let button of buttons)
	{
		button.disabled = false;
	}
}