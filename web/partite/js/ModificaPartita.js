var ROOT_DIR = "/yourteam/web/app_dev.php";

$(function () {//document.ready()
    /* attach a submit handler to the form */
    $(".modifica-partita").submit(modificaPartitaHandler);
});

/**
 * Gestisce il submit del form per modificare le informazioni di una partita.
 * @param event L'evento generato dal submit del form.
 */
function modificaPartitaHandler(event) {
    /* stop form from submitting normally */
    event.preventDefault();
    console.log("Ajax Modifica Partita Handler...");

    var $form = $(this);
    var $divModifica = $(this).parent();
    var $divInfo = $(this).parent().siblings(".info")[0];
    var $divCollapsible = $(this).parent().parent();

    var $divHeadingPartita = $(this).parent().parent().siblings(".panel-heading")[0];
    var $spanNome = $($divHeadingPartita).find("span.pull-left")[0];
    var $spanData = $($divHeadingPartita).find("span.pull-right")[0];

    console.log("$spanNome: " + $spanNome);
    console.log("$spanData: " + $spanData);

    // get all the inputs into an array.
    var $inputs = $(this).find(":input:not([type = 'submit'])");
    var values = {};

    $inputs.each(function () {
        var name = this.name;
        var value = $(this).val();
        var originalValue = $(this).attr("data-original-value");

        values[this.name] = {"old": $(this).attr("data-original-value"), "new": $(this).val()};
        console.log("values[" + this.name + "] = " + JSON.stringify(values[this.name]));
    });

    console.log("AJAX Values: ");
    console.log(JSON.stringify(values));

    var url = $($form).attr("action");

    $.ajax({
        url: url,//ROOT_DIR + "/partite/staff/edit/submit",
        type: "POST",
        dataType: 'json',
        data: {"values": JSON.stringify(values)},
        cache: false,
        success: function (response, textStatus, jqXHR) {
            console.log("AJAX JSON Response");
            console.log(response);

            console.log("PARTITA old: ");
            console.log(response.old);
            var oldPartita = response.old;

            console.log("PARTITA new: ");
            console.log(response.new);
            var newPartita = response.new;

            //Aggiorno i dati visualizzati con quelli appena inseriti.
            $($spanNome).html(newPartita.nome);
            $($spanData).html(newPartita.data);

            //Aggiorno le info della partita con quelli appena inseriti.
            // get all the inputs into an array.
            var $infoInputs = $($divInfo).find(":input:not([type = 'submit'])");

            console.log("Info update");
            $infoInputs.each(function () {
                var name = this.name;
                $(this).val(newPartita[this.name]);
                console.log("info[" + this.name + "] = " + $(this).val());
            });

            $($divModifica).hide();
            if ($($divCollapsible).hasClass("in")) {
                $($divCollapsible).collapse("toggle");
            }

            //Success feedback
            $(".alert-success").show().delay(1000).fadeOut();
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