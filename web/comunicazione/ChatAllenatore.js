/**
 * Created by Maurizio on 14/01/2017.
 */
$(function () {
    $("form#chat").submit(inviaMessaggioChat);
});

function inviaMessaggioChat(event) {
    event.preventDefault();
    console.log("Ajax Invia Messaggio CHAT...");

    var $form = $(this);
    var data = $($form).serialize();
    console.log("DATA: " + data);

    var url = $($form).attr("action");
    var type = $($form).attr("method");
    console.log("URL: " + url);

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: data,
        cache: false,
        success: function (response, textStatus, jqXHR) {
            console.log(response)
        }
    });
}