/**
 * Created by Maurizio on 06/01/2017.
 */
$(function () {
    $(".alert").hide();
});

function showSuccess(message) {
    $(".alert-success strong").html(message);
    $(".alert-success").show().delay(1000).fadeOut();
}

function showInfo(message) {
    $(".alert-info strong").html(message);
    $(".alert-info").show().delay(1000).fadeOut();
}

function showWarning(message) {
    $(".alert-warning strong").html(message);
    $(".alert-warning").show().delay(1000).fadeOut();
}

function showDanger(message) {
    $(".alert-danger strong").html(message);
    $(".alert-danger").show().delay(1000).fadeOut();
}