var interval = setInterval(housesFunc ,500);
function housesFunc()
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
       	if (this.readyState == 4 && this.status == 200)
       	{
       		if (this.responseText != '')
       		{
                try
                {
                    let returnedValueArr = JSON.parse(this.responseText);
                    let places = document.querySelectorAll('.arrow');
                    for (let place of places)
                    {
                        for (let placeFromDB of returnedValueArr) 
                        {
                            if (place.getAttribute('value') == placeFromDB['Place'])
                            {
                                if (placeFromDB['IsComp'] == false)
                                {
                                    place.style.visibility = 'hidden';
                                }
                            }
                        }
                    }
                }catch{}
       		}
       	}
    }
    xmlhttp.open("POST", "php/updateFreeHouses.php", true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send();
}