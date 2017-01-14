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
    console.log("URL: " + url);
}