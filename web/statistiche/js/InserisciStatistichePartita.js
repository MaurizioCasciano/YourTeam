var ROOT_DIR = "/yourteam/web/app_dev.php";
/**
 * Created by Maurizio on 31/12/2016.
 */
$(function () {
    //$("form.inserisci-statistiche-partita").submit(inserisciStatistichePartitaHandler);
    $("button.marcatori").click(aggiungiMarcatoriHandler);
    $("button.assistmen").click(aggiungiAssistMenHandler);
    $("button.ammonizioni").click(aggiungiAmmonizioniMenHandler);
    $("button.espulsioni").click(aggiungiEspulsioniMenHandler);
});

var NOME = null, DATA = null, CONVOCATI = null;

function inserisciStatistichePartitaHandler(event) {
    /* stop form from submitting normally */
    event.preventDefault();
    console.log("Ajax Inserisci Statistiche Partita Handler...");

    var $form = $(this);
    var $singleInputs = $($form).find(":input:not([type = 'submit'], [type ='button'], [name $= '[]'])");
    var values = {};

    var $marcatori = $($form).find(":input[name = 'marcatori[]']");
    var $assistMen = $($form).find(":input[name = 'assistmen[]']");
    var $ammonizioni = $($form).find(":input[name = 'ammonizioni[]']");
    var $espulsioni = $($form).find(":input[name = 'espulsioni[]']");

    $singleInputs.each(function (index, element) {
        values[this.name] = $(this).val();
    });

    var marcatori = [];
    $marcatori.each(function () {
        marcatori.push($(this).val())
    });

    var assistmen = [];
    $assistMen.each(function () {
        assistmen.push($(this).val())
    });

    var ammonizioni = [];
    $ammonizioni.each(function () {
        ammonizioni.push($(this).val())
    });

    var espulsioni = [];
    $espulsioni.each(function () {
        espulsioni.push($(this).val())
    });

    values["marcatori"] = marcatori;
    values["assistmen"] = assistmen;
    values["ammonizioni"] = ammonizioni;
    values["espulsioni"] = espulsioni;

    //console.log(values);

    $.ajax({
        url: ROOT_DIR + "/statistiche/staff/partita/insert/submit",
        type: "POST",
        data: {"values": JSON.stringify(values)},
        cache: false,
        success: function (response, textStatus, jqXHR) {
            console.log("AJAX JSON Response");
            console.log(response);
        }
        ,
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus)
            console.log(jqXHR.status);
            console.log(jqXHR.responseText);
            console.log(errorThrown);
        }
    });
}

function removeLastSelectHandler() {
    var $button = $(this);
    var $target = $($button).parent();
    $($target).children("select").last().remove();
    if ($($target).children("select").length === 0) {
        $($button).remove();
    }
}

function aggiungiMarcatoriHandler(event) {
    alert("Aggiungi marcatori handler");
    var $button = $(this);
    var $target = $($button).parent();

    if ($($target).children("select").length === 0 &&
        $($target).children("button[type='button'][ class = 'fa fa-minus remove-marcatori']").length === 0) {
        var $removeButton = document.createElement("button");
        $removeButton.setAttribute("type", "button");
        $removeButton.setAttribute("class", "fa fa-minus remove-marcatori");
        $($removeButton).click(removeLastSelectHandler);
        $($target).append($removeButton);
    }


    var $form = $($button).parent().parent();
    var $inputNome = $($form).find(":input[name = 'nome']");
    var $inputData = $($form).find(":input[name = 'data']");
    var nome = $($inputNome).val();
    var data = $($inputData).val();

    getConvocati(nome, data, addMarcatoriSelect, $target);
}

function aggiungiAssistMenHandler() {
    var $button = $(this);
    var $target = $($button).parent();

    if ($($target).children("select").length === 0 &&
        $($target).children("button[type='button'][ class = 'fa fa-minus remove-assistmen']").length === 0) {
        var $removeButton = document.createElement("button");
        $removeButton.setAttribute("type", "button");
        $removeButton.setAttribute("class", "fa fa-minus remove-assistmen");
        $($removeButton).click(removeLastSelectHandler);
        $($target).append($removeButton);
    }

    var $form = $($button).parent().parent();
    var $inputNome = $($form).find(":input[name = 'nome']");
    var $inputData = $($form).find(":input[name = 'data']");
    var nome = $($inputNome).val();
    var data = $($inputData).val();

    getConvocati(nome, data, addAssistMenSelect, $target);
}

function aggiungiAmmonizioniMenHandler() {
    var $button = $(this);
    var $target = $($button).parent();

    if ($($target).children("select").length === 0 &&
        $($target).children("button[type='button'][ class = 'fa fa-minus remove-ammonizioni']").length === 0) {
        var $removeButton = document.createElement("button");
        $removeButton.setAttribute("type", "button");
        $removeButton.setAttribute("class", "fa fa-minus remove-ammonizioni");
        $($removeButton).click(removeLastSelectHandler);
        $($target).append($removeButton);
    }

    var $form = $($button).parent().parent();
    var $inputNome = $($form).find(":input[name = 'nome']");
    var $inputData = $($form).find(":input[name = 'data']");
    var nome = $($inputNome).val();
    var data = $($inputData).val();

    getConvocati(nome, data, addAmmonizioniSelect, $target);
}

function aggiungiEspulsioniMenHandler() {
    var $button = $(this);
    var $target = $($button).parent();

    if ($($target).children("select").length === 0 &&
        $($target).children("button[type='button'][ class = 'fa fa-minus remove-espulsioni']").length === 0) {
        var $removeButton = document.createElement("button");
        $removeButton.setAttribute("type", "button");
        $removeButton.setAttribute("class", "fa fa-minus remove-espulsioni");
        $($removeButton).click(removeLastSelectHandler);
        $($target).append($removeButton);
    }

    var $form = $($button).parent().parent();
    var $inputNome = $($form).find(":input[name = 'nome']");
    var $inputData = $($form).find(":input[name = 'data']");
    var nome = $($inputNome).val();
    var data = $($inputData).val();

    getConvocati(nome, data, addEspulsioniSelect, $target);
}

/**
 * Funzione di call-back per l'aggiunta dell'elemento select,
 * dal quale verranno selezionati i calciatori che hanno segnato durante l'incontro.
 */
function addMarcatoriSelect(convocati, target) {
    var $selectCalciatori = document.createElement("select");
    $selectCalciatori.setAttribute("name", "marcatori[]");

    $(convocati).each(function (index, calciatore) {
        var $option = document.createElement("option");
        $option.appendChild(document.createTextNode(calciatore.nomeCognome));
        $option.setAttribute("value", calciatore.contratto);
        $selectCalciatori.appendChild($option);

        //console.log(calciatore.nomeCognome);
        //console.log(calciatore.contratto);
    });

    $(target).append($selectCalciatori);
}

/**
 * Funzione di call-back per l'aggiunta dell'elemento select,
 * dal quale verranno selezionati i calciatori che hanno effettuato un'assist durante l'incontro.
 */
function addAssistMenSelect(convocati, target) {
    var $selectCalciatori = document.createElement("select");
    $selectCalciatori.setAttribute("name", "assistmen[]");

    $(convocati).each(function (index, calciatore) {
        var $option = document.createElement("option");
        $option.appendChild(document.createTextNode(calciatore.nomeCognome));
        $option.setAttribute("value", calciatore.contratto);
        $selectCalciatori.appendChild($option);

        //console.log(calciatore.nomeCognome);
        //console.log(calciatore.contratto);
    });

    $(target).append($selectCalciatori);
}

/**
 * Funzione di call-back per l'aggiunta dell'elemento select,
 * dal quale verranno selezionati i calciatori che sono stati ammoniti durante l'incontro.
 */
function addAmmonizioniSelect(convocati, target) {
    var $selectCalciatori = document.createElement("select");
    $selectCalciatori.setAttribute("name", "ammonizioni[]");

    $(convocati).each(function (index, calciatore) {
        var $option = document.createElement("option");
        $option.appendChild(document.createTextNode(calciatore.nomeCognome));
        $option.setAttribute("value", calciatore.contratto);
        $selectCalciatori.appendChild($option);

        //console.log(calciatore.nomeCognome);
        //console.log(calciatore.contratto);
    });

    $(target).append($selectCalciatori);
}

/**
 * Funzione di call-back per l'aggiunta dell'elemento select,
 * dal quale verranno selezionati i calciatori che sono stati espulsi durante l'incontro.
 */
function addEspulsioniSelect(convocati, target) {
    var $selectCalciatori = document.createElement("select");
    $selectCalciatori.setAttribute("name", "espulsioni[]");

    $(convocati).each(function (index, calciatore) {
        var $option = document.createElement("option");
        $option.appendChild(document.createTextNode(calciatore.nomeCognome));
        $option.setAttribute("value", calciatore.contratto);
        $selectCalciatori.appendChild($option);

        //console.log(calciatore.nomeCognome);
        //console.log(calciatore.contratto);
    });

    $(target).append($selectCalciatori);
}

/**
 * Funzione che ottiene i convocati per la partita ed esegue una funzione di call-back.
 * @param nome Il nome della partita.
 * @param data La data della partita.
 * @param handler La funzione di call-back da chiamare quando si riceve la risposta dal server.
 * @param target L'elemento DOM in cui inserire i nuovi dati.
 */
function getConvocati(nome, data, handler, target) {
    alert("GET CONVOCATI");

    console.log("NOME: " + NOME);
    console.log("nome: " + nome);

    if (NOME == nome && DATA == data && CONVOCATI != null) {
        console.log("CONVOCATI GIA' PRESENTI...");
        handler(CONVOCATI, target);
    } else {
        $.ajax({
            url: ROOT_DIR + "/statistiche/convocati/" + nome + "/" + data,
            type: "GET",
            cache: false,
            success: function (response, textStatus, jqXHR) {
                console.log("GET CONVOCATI AJAX JSON Response");
                console.log(response);
                console.log(textStatus);
                console.log(jqXHR);

                var convocati = response.calciatori;
                NOME = nome;
                DATA = data;
                CONVOCATI = convocati;

                //crea la select e la aggiunge all'elemento target.
                handler(convocati, target);
            }
            ,
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(jqXHR.status);
                console.log(jqXHR.responseText);
                console.log(errorThrown);
            }
        });
    }
}