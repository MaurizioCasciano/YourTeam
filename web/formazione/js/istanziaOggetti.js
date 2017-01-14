//definisco un costruttore di tattiche
function tattica(nome,difensori,mediani,centrocampisti,trequartisti,attaccanti)
{
	this.nome=nome;
	this.difensori=difensori;
	this.mediani=mediani;
	this.centrocampisti=centrocampisti;
	this.trequartisti=trequartisti;
	this.attaccanti=attaccanti;
}

//definisco un costruttore di calciatore
function calciatore(contratto,nomeCognome,ruolo,selezionato)
{
	this.contratto=contratto;
	this.nomeCognome=nomeCognome;
	this.ruolo=ruolo;
	this.selezionato=selezionato;
}
//istanzio array dei calciatori e di moduli
var calciatori=new Array();
var tattiche=new Array();

//funzione che caricherà i calciatori presenti nel database convocati per la partita
function caricaCalciatori()
{
	var xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			var jsonRisposta=xmlhttp.responseText;
			jsonRisposta=JSON.parse(jsonRisposta);

			for (var i=0; i<jsonRisposta.calciatori.length; i++)
			{
				calciatori.push(new calciatore(jsonRisposta.calciatori[i].contratto,jsonRisposta.calciatori[i].nomeCognome,jsonRisposta.calciatori[i].ruoli,false));
			}
		}

	};

	xmlhttp.open("GET", "{{ path('ottieniCalciatori') }}", false);
	xmlhttp.send();

}

//funzione che carica la tattica selezionata nella comboBox
function caricaTattica()
{
	var xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			var jsonRisposta=xmlhttp.responseText;
			jsonRisposta=JSON.parse(jsonRisposta);

			for (var i=0 ; i<jsonRisposta.modulo.length ; i++)
			{
				tattiche.push(new tattica(jsonRisposta.modulo[i].nome,jsonRisposta.modulo[i].difensori,jsonRisposta.modulo[i].mediani,jsonRisposta.modulo[i].centrocampisti,jsonRisposta.modulo[i].trequartisti,jsonRisposta.modulo[i].attaccanti));
			}
		}

	};

	xmlhttp.open("GET", "{{ path('cambiaTattica') }}", false);
	xmlhttp.send();


}