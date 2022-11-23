//document.querySelector('.parties').style.height = (window.innerHeight).toString() + 'px';
function updateArrows()
{
	//addAllArrows();
	setInterval(function(){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
    	   	if (this.readyState == 4 && this.status == 200)
    	   	{
    	   		let fromPHP = JSON.parse(this.responseText);
    	   		updatePercents(fromPHP);
    	   		phonePartiesFunc(fromPHP);
    	   		drawArrows(fromPHP);
    	   	}
    	}
    	xmlhttp.open("POST", "php/arrows_and_info.php", true);
    	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    	xmlhttp.send();
	}, 500);
}
function updatePercents(fromPHP)
{
	let places = document.querySelectorAll('.percentsSpan');
	for (let place of places)
    {
        for (let placeFromDB of fromPHP) 
        {
        	if (place.getAttribute('value') == placeFromDB['Place'])
            {
                place.innerHTML = placeFromDB['Percents'];
            }
        }
    }
}
function drawArrows(fromPHP)
{
	let linesSVG = document.querySelectorAll('.svgLine');
	for(let lineSVG of linesSVG)
	{
		lineSVG.setAttribute('height', window.innerHeight);
		lineSVG.setAttribute('width', window.innerWidth);
	}
	let lines = document.querySelectorAll('.lineDiv');
	let places = document.querySelectorAll('.scieneImage');
	for (let place of places)
	{
		for (let placeFromDB of fromPHP) 
        {
        	if (place.getAttribute('value') == placeFromDB['Place']) //кому
            {
            	let bounds = place.getBoundingClientRect();
            	let xOwner = (bounds.right - bounds.left) / 2 + bounds.left;
            	let yOwner = (bounds.bottom - bounds.top) / 2 + bounds.top;
                for (let i = 1; i <= 6; i++)
                {
                	let p = 'P' + i;
                	if (placeFromDB[p] != false)
                	{
                		let difPlaces = document.querySelectorAll(".scieneImage");
                		for(let difPlace of difPlaces)
                		{
                			if (difPlace.getAttribute('value') == i.toString()) //от кого
                			{
                				let boundsThis = difPlace.getBoundingClientRect();
            					let xThis = (boundsThis.right - boundsThis.left) / 2 + boundsThis.left;
            					let yThis = (boundsThis.bottom - boundsThis.top) / 2 + boundsThis.top;
            					for(let line of lines)
            					{
            						if (line.parentNode.getAttribute('from') == i.toString() && 
            							line.parentNode.getAttribute('to') == placeFromDB['Place'])
            						{
            							line.setAttribute('x1', xOwner);
            							line.setAttribute('y1', yOwner);
            							line.setAttribute('x2', xThis);
            							line.setAttribute('y2', yThis);
            						}
            					}
                			}
                		}
						
                	}
                }
            }
        }
	}
}
function phonePartiesFunc(fromPHP)
{
	let phone = document.querySelector('.phoneParties');
	phone.innerHTML = '';
	for(let party of fromPHP)
	{
		if (party['UserName'] != 'freePeople')
		{
			let div = document.createElement('div');
			div.classList.add('phonePartyDiv');
			phone.appendChild(div);
			let pic = document.createElement('img');
			pic.classList.add('phoneSmallImgDiv');
			if (party['Place'] == '1')
			{
				pic.src = "img/orange_house.png";
			}
			if (party['Place'] == '2')
			{
				pic.src = "img/blue_house.png";
			}
			if (party['Place'] == '3')
			{
				pic.src = "img/red_house.png";
			}
			if (party['Place'] == '4')
			{
				pic.src = "img/violet_house.png";
			}
			if (party['Place'] == '5')
			{
				pic.src = "img/yellow_house.png";
			}
			if (party['Place'] == '6')
			{
				pic.src = "img/green_house.png";
			}
			div.appendChild(pic);
			let name = document.createElement('span');
			name.classList.add('partyPhoneName');
			name.innerHTML = party['UserName'] + ': ';
			div.appendChild(name);
			let percents = document.createElement('span');
			percents.classList.add('partyPhonePercencts');
			percents.innerHTML = party['Percents'] + '% + ' + party['HowMuchRemove'] + '%';
			div.appendChild(percents);
		}
	}
}