var ROOT_DIR = "/yourteam/web/app_dev.php";
/**
 * Created by Maurizio on 31/12/2016.
 */
$(function () {
    $("button.marcatori.fa-plus").click(aggiungiMarcatoriHandler);
    $("button.assistmen.fa-plus").click(aggiungiAssistMenHandler);
    $("button.ammonizioni.fa-plus").click(aggiungiAmmonizioniMenHandler);
    $("button.espulsioni.fa-plus").click(aggiungiEspulsioniMenHandler);

    $("button.marcatori.fa-minus").click(removeLastSelectHandler);
    $("button.assistmen.fa-minus").click(removeLastSelectHandler);
    $("button.ammonizioni.fa-minus").click(removeLastSelectHandler);
    $("button.espulsioni.fa-minus").click(removeLastSelectHandler);
});

var NOME = null, DATA = null, CONVOCATI = null;

function removeLastSelectHandler() {
    var $button = $(this);
    var $target = $($button).parent();
    $($target).children("select").last().remove();
    if ($($target).children("select").length === 0) {
        $($button).remove();
    }
}

function aggiungiMarcatoriHandler(event) {
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

    getConvocati(nome, data, addMarcatoriSelect, $target, $form);
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

    getConvocati(nome, data, addAssistMenSelect, $target, $form);
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

    getConvocati(nome, data, addAmmonizioniSelect, $target, $form);
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

    getConvocati(nome, data, addEspulsioniSelect, $target, $form);
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
        $option.appendChild(document.createTextNode(calciatore.numeromaglia + ") " + calciatore.nome + " " + calciatore.cognome));
        $option.setAttribute("value", calciatore.contratto);
        $selectCalciatori.appendChild($option);
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
        $option.appendChild(document.createTextNode(calciatore.numeromaglia + ") " + calciatore.nome + " " + calciatore.cognome));
        $option.setAttribute("value", calciatore.contratto);
        $selectCalciatori.appendChild($option);
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
        $option.appendChild(document.createTextNode(calciatore.numeromaglia + ") " + calciatore.nome + " " + calciatore.cognome));
        $option.setAttribute("value", calciatore.contratto);
        $selectCalciatori.appendChild($option);
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
        $option.appendChild(document.createTextNode(calciatore.numeromaglia + ") " + calciatore.nome + " " + calciatore.cognome));
        $option.setAttribute("value", calciatore.contratto);
        $selectCalciatori.appendChild($option);
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
function getConvocati(nome, data, handler, target, form) {
    console.log("GET CONVOCATI");

    console.log("NOME: " + NOME);
    console.log("nome: " + nome);

    if (NOME == nome && DATA == data && CONVOCATI != null) {
        console.log("CONVOCATI GIA' PRESENTI...");
        handler(CONVOCATI, target);
    } else {
        var url = $(form).children("input[name='get_convocati']").val();
        $.ajax({
            url: url,
            type: "GET",
            cache: false,
            success: function (response, textStatus, jqXHR) {
                console.log("GET CONVOCATI AJAX JSON Response");
                console.log(response);
                console.log(textStatus);
                console.log(jqXHR);

                var convocati = response.convocati;
                console.log(convocati);
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