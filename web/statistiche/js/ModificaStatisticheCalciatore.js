/**
 * Created by Maurizio on 05/01/2017.
 */
$(function () {
    console.log("Modifica Statistiche Calciatore");
    $("form.modifica_statistiche_calciatore").submit(modificaStatisticheHandler);
});

function modificaStatisticheHandler(event) {
    event.preventDefault();
    console.log("ModificaStatisticheCalciatore Handler...");
    var $form = $(this);
    console.log($form);
    var params = $($form).serialize();
    console.log(params);

    var url = $($form).attr("action");

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        cache: false,
        data: params,
        success: function (response, textStatus, jqXHR) {
            console.log("SUCCESS Modifica Statistiche Calciatore Handler.");
            console.log(response);
            console.log(textStatus);
            console.log(jqXHR);

            var executed = response.executed;
            console.log(executed);

            var statistiche = response.statistiche;
            console.log(statistiche);

            if (executed) {
                showSuccess("Statistiche modificate con successo.");
                $($form)[0].reset();
                //$($form).parent().parent().parent().remove();
            } else {
                showWarning("Errore nell'inserimento delle statistiche.");
            }
        }
        ,
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("ERROR Inserisci Statistiche Calciatore Handler.");
            console.log(textStatus);
            console.log(jqXHR.status);
            console.log(jqXHR.responseText);
            console.log(errorThrown);
        }
    });
}