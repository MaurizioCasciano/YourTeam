/**
 * Created by luigidurso on 17/11/16.
 */
//quando viene cliccato il pulsante di conferma viene visualizzata la lista dei selezionati
function confermaSelezione()
{
    var selezionati=new Array();
    var comboBox=document.getElementById("selezioneTattica");
    var moduloSelezionato=comboBox.options[comboBox.selectedIndex].value;

    var elenco=document.getElementsByClassName("profile-content");

    var buttons=document.getElementsByClassName("buttonModal");

    var stringaSelezione="Formazione scelta:</br>";

    for (var i=0;i<buttons.length;i++)
    {

        if(buttons[i].name=='' )
        {
            stringaSelezione+="<div>"+buttons[i].value+"   NON SELEZIONATO</div>";
            selezionati.push("non selezionato");
        }
        else
        {
            stringaSelezione+="<div>"+buttons[i].value+"   "+buttons[i].firstChild.nodeValue+"</div>";
            selezionati.push(buttons[i].name);
        }
    }

    selezionati=JSON.stringify(selezionati);

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            stringaSelezione+=xmlhttp.responseText;
            elenco[0].innerHTML=stringaSelezione;
        }

    };

    xmlhttp.open("POST", "http://localhost/yourteam/web/app_dev.php/formazione/allenatore/schieraFormazione", false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("calciatori="+selezionati+"&modulo="+moduloSelezionato);
}
