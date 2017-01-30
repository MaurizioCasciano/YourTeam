/**
 * Created by luigidurso on 17/11/16.
 */
//quando viene cliccato il pulsante di conferma viene visualizzata la lista dei selezionati
function confermaSelezione(urlFormazione)
{
    var selezionati=new Array();
    var comboBox=document.getElementById("selezioneTattica");
    var moduloSelezionato=comboBox.options[comboBox.selectedIndex].value;

    var elenco=document.getElementsByClassName("profile-content");

    var buttons=document.getElementsByClassName("buttonModal");

    var stringaSelezione="<table class=\"table table-striped\"><thead><tr><th>Ruolo</th><th>Calciatore</th></tr></thead><tbody>";

    for (var i=0;i<buttons.length;i++)
    {

        if(buttons[i].name=='' )
        {
            stringaSelezione+="<tr>";
            stringaSelezione+="<td>"+buttons[i].value+"</td>";
            stringaSelezione+="<td>NON SELEZIONATO</td>";
            stringaSelezione+="</tr>";
            selezionati.push("non selezionato");
        }
        else
        {
            stringaSelezione+="<tr>";
            stringaSelezione+="<td>"+buttons[i].value+"</td>";
            stringaSelezione+="<td>"+buttons[i].firstChild.nodeValue+"</td>";
            stringaSelezione+="</tr>";
            selezionati.push(buttons[i].name);
        }
    }
    stringaSelezione+="</tbody></table>";

    selezionati=JSON.stringify(selezionati);

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            //stringaSelezione+=xmlhttp.responseText;
            elenco[0].innerHTML=stringaSelezione;
        }

    };

    xmlhttp.open("POST", urlFormazione, false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("calciatori="+selezionati+"&modulo="+moduloSelezionato);
}
