/**
 * Created by Maurizio on 05/01/2017.
 */
var ROOT_DIR = "/yourteam/web/app_dev.php";

$(function () {
    $("form.inserisci_statistiche_calciatore").submit(inserisciStatisticheHandler);
});

function inserisciStatisticheHandler(event) {
    event.preventDefault();
    console.log("InserisciStatisticheCalciatore Handler...");
    var $form = $(this);
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
            console.log("SUCCESS Inserisci Statistiche Calciatore Handler.");
            console.log(response);
            console.log(textStatus);
            console.log(jqXHR);

            var executed = response.executed;
            console.log(executed);

            if (executed) {
                showSuccess("Statistiche inserite con successo.");
                $($form)[0].reset();
                $($form).parent().parent().parent().remove();
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