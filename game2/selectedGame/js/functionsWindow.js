for(let pic of document.querySelectorAll('.scieneImage'))
{
	pic.addEventListener('click', function(){
		if (pic.classList.contains('myBuildingBorder') == false)
		{
			let functions;
			if (pic.getAttribute('value') != '7')
			{
				functions = document.querySelector('.functionsWar');
				document.querySelector('.functionsPeace').classList.add('hideMenu');
			}
			else
			{
				functions = document.querySelector('.functionsPeace');
				document.querySelector('.functionsWar').classList.add('hideMenu');
			}
			functions.classList.toggle('hideMenu');
			for (let picture of document.querySelectorAll('.scieneImage'))
			{
				picture.classList.remove('buildingBorder');
			}
			pic.classList.add('buildingBorder');
			functions.setAttribute('placeNum', pic.getAttribute('value'));
		}
	});
}
