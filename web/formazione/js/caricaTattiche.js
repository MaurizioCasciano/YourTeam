
//carico dinamicamente i ruoli per le formazioni
function caricaFormazione()
{
	//deseleziono i calciatori precedentemente scelti
	for (var i=0;i<calciatori.length;i++)
	{
		calciatori[i].selezionato=false;
	}
	//cancello una precedente selezione
	cancellaSelezione();


	var comboBoxTattiche=document.getElementById("selezioneTattica");

	var tattica=tattiche[comboBoxTattiche.selectedIndex];

//carico portiere
	var portiere=document.getElementById("divPortiere");
	var stringaPortiere="";

	stringaPortiere+="<div class=\"divRuoli\">";
	stringaPortiere+="<span>POR</span></br><button name='' class=\"buttonModal\" value=\"POR\"></button></br>"
	stringaPortiere+="</div>"

	portiere.innerHTML=stringaPortiere;

//carico difensori
	var difensori=document.getElementById("divDifensori");
	var stringaDifensori="";

	for (var i =0; i < (tattica.difensori).length; i++) 
	{
		stringaDifensori+="<div class=\"divRuoli\">";
		stringaDifensori+="<span>"+tattica.difensori[i]+"</span></br><button name='' class=\"buttonModal\" value=\""+tattica.difensori[i]+"\"></button>";
		stringaDifensori+="</div>"
	}
	stringaDifensori+="</br>"
	difensori.innerHTML=stringaDifensori;

	//carico mediani se esistono
	if (tattica.mediani!=null)
	{
		var mediani=document.getElementById("divMediani");
		var stringaMediani="";
		mediani.style.display="block";

        for (var i =0; i < (tattica.mediani).length; i++)
        {
            stringaMediani+="<div class=\"divRuoli\">";
            stringaMediani+="<span>"+tattica.mediani[i]+"</span></br><button name='' class=\"buttonModal\" value=\""+tattica.mediani[i]+"\"></button>";
            stringaMediani+="</div>"
        }
        stringaMediani+="</br>"
        mediani.innerHTML=stringaMediani;
	}
    else
    {
        var mediani=document.getElementById("divMediani");
        mediani.style.display="inline";
        mediani.innerHTML="";
    }

//carico centrocampisti
	var centrocampisti=document.getElementById("divCentrocampisti");
	var stringaCentrocampisti="";

	for (var i =0; i < (tattica.centrocampisti).length; i++) 
	{
		stringaCentrocampisti+="<div class=\"divRuoli\">";
		stringaCentrocampisti+="<span>"+tattica.centrocampisti[i]+"</span><button name='' class=\"buttonModal\" value=\""+tattica.centrocampisti[i]+"\"></button>";
		stringaCentrocampisti+="</div>"
	}
	stringaCentrocampisti+="</br>"
	centrocampisti.innerHTML=stringaCentrocampisti;

    //carico trequartisti se esistono
    if (tattica.trequartisti!=null)
    {
        var trequartisti=document.getElementById("divTrequartisti");
        var stringaTrequartisti="";
        trequartisti.style.display="block";

        for (var i =0; i < (tattica.trequartisti).length; i++)
        {
            stringaTrequartisti+="<div class=\"divRuoli\">";
            stringaTrequartisti+="<span>"+tattica.trequartisti[i]+"</span></br><button name='' class=\"buttonModal\" value=\""+tattica.trequartisti[i]+"\"></button>";
            stringaTrequartisti+="</div>"
        }
        stringaTrequartisti+="</br>"
        trequartisti.innerHTML=stringaTrequartisti;
    }
    else
	{
		var trequartisti=document.getElementById("divTrequartisti");
		trequartisti.style.display="inline";
		trequartisti.innerHTML="";
	}

//carico attaccanti
	var attaccanti=document.getElementById("divAttaccanti");
	var stringaAttaccanti="";

	for (var i =0; i < (tattica.attaccanti).length; i++) 
	{
		stringaAttaccanti+="<div class=\"divRuoli\">";
		stringaAttaccanti+="<span>"+tattica.attaccanti[i]+"</span><button name='' class=\"buttonModal\" value=\""+tattica.attaccanti[i]+"\"></button>";
		stringaAttaccanti+="</div>"
	}
	stringaAttaccanti+="</br>"
	attaccanti.innerHTML=stringaAttaccanti;

	//setto gli onclick per ogni ruolo
	caricaOnClickRuoli();
}