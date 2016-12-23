/**
 * Created by luigidurso on 17/11/16.
 */
//quando viene cliccato il pulsante di conferma viene visualizzata la lista dei selezionati
function confermaSelezione()
{
    var elenco=document.getElementById("selezione");

    var buttons=document.getElementsByClassName("buttonModal");

    var stringaSelezione="";

    for (var i=0;i<buttons.length;i++)
    {

        if(buttons[i].name=='' )
        {
            stringaSelezione+="<div>"+buttons[i].value+"   NON SELEZIONATO</div>";
        }
        else
        {
            stringaSelezione+="<div>"+buttons[i].value+"   "+buttons[i].name+"</div>";
        }
    }

    elenco.innerHTML=stringaSelezione;
}
//cancello l'attuale selezione
function cancellaSelezione()
{
    var elenco=document.getElementById("selezione");


    elenco.innerHTML="";
}
