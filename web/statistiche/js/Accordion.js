/**
 * Created by Maurizio on 08/01/2017.
 */
$(function () {
    $(".inserisci-btn").click(function () {
        $(this).parent().siblings(":not('.inserisci')").hide();
        $(this).parent().siblings(".inserisci").toggle();
    });

    $(".modifica-btn").click(function () {
        $(this).parent().siblings(":not('.modifica')").hide();
        $(this).parent().siblings(".modifica").toggle();
    });

    $(".visualizza-btn").click(function () {
        $(this).parent().siblings(":not('.visualizza')").hide();
        $(this).parent().siblings(".visualizza").toggle();
    });
});