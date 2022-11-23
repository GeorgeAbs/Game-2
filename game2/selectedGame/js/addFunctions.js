var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
      	if (this.readyState == 4 && this.status == 200)
      	{
      		addFunctions(this.responseText);
      	}
   }
xmlhttp.open("POST", "php/addFunctions.php", true);
xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xmlhttp.send();

function addFunctions(jsonPHP)
{
	var fromPHP = JSON.parse(jsonPHP);
	var ulWar = document.querySelector('.functionsWar').querySelector('.ulFunctions');
	var ulPeace = document.querySelector('.functionsPeace').querySelector('.ulFunctions');
	for(let newButFunc of fromPHP)
	{
		let li = document.createElement("li");
		li.innerHTML = "<button class='butInList'>Цена: " + newButFunc['Price'] + "<br>" + newButFunc['Description']+ "</button>";
		li.addEventListener('click', function(){
				li.querySelector('.butInList').disabled = true;
				let aName;
				if (newButFunc['SelfFunction'] == 'no')
				{
					aName = document.querySelector('.functionsWar').getAttribute('placeNum');
				}
				else
				{
					aName = document.querySelector('.functionsPeace').getAttribute('placeNum');
				}
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
    			   	if (this.readyState == 4 && this.status == 200)
    			   	{
    			   		let response = JSON.parse(this.responseText);
    			   		document.querySelector('.moneySpan').innerHTML = response['money']; //изменить количество оставшихся денег 
    			   		document.querySelector('.kickedOffPeopleSpan').innerHTML = Math.round(response['removerPercents']*100)/100;//процентов
    			   	}
    			}
    			xmlhttp.open("POST", "php/functionFromList.php", true);//работа функции
    			xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    			xmlhttp.send("functionName=" + newButFunc['Description'] + "&anotherName=" + aName);
			});
		if (newButFunc['SelfFunction'] == 'no')
		{
			ulWar.appendChild(li);
		}
		else
		{
			ulPeace.appendChild(li);
		}
		
	}
	
}