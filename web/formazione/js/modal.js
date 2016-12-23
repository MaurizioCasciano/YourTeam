
function caricaOnClickRuoli()
{
	// prendi il modal
	var modal = document.getElementById('modal');

	// Prendo l'elemento <span> per la chiusura del buttonModal
	var span = document.getElementById("close");

	//prendo i button associati ai ruoli
	var buttons=document.getElementsByClassName("buttonModal");
	
	// Setto il listener ai button
	for (var i = 0; i < buttons.length; i++) 
	{
		buttons[i].onclick = function(event)
		{
    		modal.style.display = "block";

            var listaCalciatori=document.getElementById("divListaCalciatoriRuolo");
            var ruolo=event.target.value;
            var stringaLista="";

            //carico pulsante rimozione calciatore selezionato

			stringaLista+="<button id=\"rimozioneCalciatore\" name=\"rimozioneCalciatore\">Rimuovi calciatore selezionato</button></br>";

    		//carico la lista dei calciatori selezionati per quel ruolo

			for (var i=0; i< calciatori.length;i++)
			{
				if(calciatori[i].selezionato==false)
				{
					for(var j=0;j<calciatori[i].ruolo.length;j++)
					{
						if(calciatori[i].ruolo[j]==ruolo)
						{
                            stringaLista+="<button class=\"buttonRuolo\" name=\""+i+"\" value=\""+calciatori[i].contratto+"\">"+calciatori[i].nomeCognome+"</button></br>";
                        }
					}
				}
			}
			listaCalciatori.innerHTML=stringaLista;
			caricaOnClickElencoModal(event.target);
		}

	}

	// Chiusura del modal
	span.onclick = function() 
	{
 	   modal.style.display = "none";
	}

	// Chiusura modal per click esterni al modal
	window.onclick = function(event) 
	{
    	if (event.target == modal )
    	{
        	modal.style.display = "none";
    	}
	}


}
//facciamo in modo di caricare il calciatore nella formazione al click sulla lista visualizzata nel modal
function caricaOnClickElencoModal(bottoneRuoloOriginale)
{
    var buttonsListaModel=document.getElementsByClassName("buttonRuolo");
    var buttonRimozione=document.getElementById("rimozioneCalciatore");
    
    //rimozione del calciatore scelto
    buttonRimozione.onclick= function ()
	{
		if (bottoneRuoloOriginale.name != null)
		{
            for(var i=0;i<calciatori.length;i++)
            {
                if(calciatori[i].contratto==bottoneRuoloOriginale.name)
                {
                    calciatori[i].selezionato=false;
                }
            }
            bottoneRuoloOriginale.innerHTML="";
            bottoneRuoloOriginale.name="";
		}

        modal.style.display = "none";

    }
//selezione del calciatore scelto
    for (var i=0; i < buttonsListaModel.length; i++)
    {
        buttonsListaModel[i].onclick = function()
        {

        	if(bottoneRuoloOriginale.name != null)
			{

				for(var i=0;i<calciatori.length;i++)
				{
					if(calciatori[i].contratto==bottoneRuoloOriginale.name)
					{
						calciatori[i].selezionato=false;
					}
				}
			}
            bottoneRuoloOriginale.innerHTML=""+event.target.firstChild.nodeValue;
        	bottoneRuoloOriginale.name=""+event.target.value;
            calciatori[event.target.name].selezionato=true;
            modal.style.display = "none";

        }
    }

}




