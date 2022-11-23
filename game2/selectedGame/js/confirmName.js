document.querySelector('.nameInput').addEventListener('input', function(){
	let input = document.querySelector('.nameInput');
	if (input.value.trim() != '')
	{
		showArrows();
	}
	else
	{
		hideArrows();
	}
});
function showArrows()
{
	for(let arr of document.querySelectorAll('.arrow'))
	{
		arr.classList.remove('hideMenu');
	}
}
function hideArrows()
{
	for(let arr of document.querySelectorAll('.arrow'))
	{
		arr.classList.add('hideMenu');
	}
}
for (let arrow of document.querySelectorAll('.arrow'))
{
	arrow.addEventListener('click', function(){
		arrow.parentNode.querySelector('.scieneImage').classList.add('myBuildingBorder');
		for (let pic of document.querySelectorAll('.arrow'))
		{
			pic.style.visibility = 'hidden';
			document.querySelector('.party7').classList.remove('hideMenu');
		}
	});
}
for(let pic of document.querySelectorAll('.arrow'))
{
	pic.addEventListener('click', function(){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
    	   	if (this.readyState == 4 && this.status == 200)
    	   	{
    	   		adminStartButton();
    	   		document.querySelector('.patryNameCtrls').remove();
    	   	}
    	}
    	var userName = document.querySelector('.nameInput').value;
    	var place = pic.getAttribute('value');

    	xmlhttp.open("POST", "php/confirmName.php", true);
    	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    	xmlhttp.send("place=" + place + "&userName=" + userName);
    	
	});
}
function adminStartButton()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	   	if (this.readyState == 4 && this.status == 200)
	   	{
	   		if (this.responseText == 'admin')
	   		{
	   			document.querySelector('.startGame').style.visibility = 'visible';
				document.querySelector('.startGame').addEventListener('click', function(){
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {

					   	if (this.readyState == 4 && this.status == 200)
					   	{
					   		var timer2 = setInterval(function(){
					   			let xmlhttp = new XMLHttpRequest();
					   			xmlhttp.onreadystatechange = function()
					   			{
					   				if (this.readyState == 4 && this.status == 200)
					   				{
					   					console.log(this.responseText);
					   				}
					   				
					   			}
					   			xmlhttp.open("POST", "php/startGame.php", true);
								xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
								xmlhttp.send('notZeroRound=yes');
					   		}, 2000);
					   	}
					}
					xmlhttp.open("POST", "php/startGame.php", true);
					xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					xmlhttp.send();
					document.querySelector('.startGame').remove();
				});
	   		}
	   	}
	}
	xmlhttp.open("POST", "php/updateAdminButton.php", true);
	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send();
}