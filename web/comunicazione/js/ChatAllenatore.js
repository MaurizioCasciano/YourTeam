/**
 * Created by Maurizio on 14/01/2017.
 */
$(function () {
    var WORKING = false;
    $("form#chat").submit(inviaMessaggioChat);

    setInterval(function () {
        console.log("WORKING: " + WORKING);
        if (!WORKING) {
            console.log("Start working");
            WORKING = true;
            $.when(getNuoviMessagi()).done(function () {
                console.log("DONE");
                WORKING = false;
            });
        }
    }, 2500);

    $('#chat-body').scrollTop($('#chat-body')[0].scrollHeight - $('#chat-body')[0].clientHeight);
});

function inviaMessaggioChat(event) {
    event.preventDefault();

    var $form = $(this);
    var data = $($form).serialize();

    var messaggio = $.trim($($form).find("input[name='testo']").val());

    if (messaggio.length == 0) {
        return;
    }

    console.log("Ajax Invia Messaggio CHAT...");

    $($form).find("input[name='testo']").val("");

    console.log("DATA: " + data);

    var url = $($form).attr("action");
    console.log("URL: " + url);

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: data,
        cache: false,
        success: function (response, textStatus, jqXHR) {
            console.log(response);
            var messaggio = response.messaggio;
            console.log(messaggio);
            if (response.ok === true) {
                //mostraMessaggio(messaggio);
            }
        }
    });
}


function mostraMessaggio(messaggio) {
    console.log("Mostra messaggio");
    console.log(messaggio);

    if (messaggio.mittente === "allenatore") {
        mostraMessaggioAllenatore(messaggio);
    } else if (messaggio.mittente === "calciatore") {
        mostraMessaggioCalciatore(messaggio);
    }

    $('#chat-body').scrollTop($('#chat-body')[0].scrollHeight - $('#chat-body')[0].clientHeight);
}

function mostraMessaggioAllenatore(messaggio) {
    var li = document.createElement("li");
    $(li).attr("class", "right clearfix");

    var span = document.createElement("span");
    $(span).attr("class", "chat-img pull-right");

    var img = document.createElement("img");
    $(img).attr("src", "http://placehold.it/50/FA6F57/fff&text=ME");
    $(img).attr("alt", "User Avatar");
    $(img).attr("class", "img-circle");
    $(span).append(img);
    $(li).append(span);

    var body = document.createElement("div");
    $(body).attr("class", "chat-body clearfix");

    var header = document.createElement("div");
    $(header).attr("class", "header");

    var small = document.createElement("small");
    $(small).attr("class", " text-muted");

    var span2 = document.createElement("span");
    $(span2).attr("class", "glyphicon glyphicon-time datetime");
    $(small).append(span2);

    var data = document.createTextNode(messaggio.data);
    $(span2).append(data);

    var strong = document.createElement("strong");
    $(strong).attr("class", "pull-right primary-font");
    var mittente = document.createTextNode(messaggio.nomeMittente + " " + messaggio.cognomeMittente);
    $(strong).append(mittente);

    $(header).append(small);
    $(header).append(strong);
    $(body).append(header);

    var paragraph = document.createElement("p");
    var testo = document.createTextNode(messaggio.testo);
    $(paragraph).append(testo);
    $(body).append(paragraph);
    $(li).append(body);

    $("#chat-list").append(li);
}

function mostraMessaggioCalciatore(messaggio) {
    var li = document.createElement("li");
    $(li).attr("class", "left clearfix");

    var span = document.createElement("span");
    $(span).attr("class", "chat-img pull-left");

    var img = document.createElement("img");
    $(img).attr("src", "http://placehold.it/50/55C1E7/fff&text=U");
    $(img).attr("alt", "User Avatar");
    $(img).attr("class", "img-circle");
    $(span).append(img);
    $(li).append(span);

    var body = document.createElement("div");
    $(body).attr("class", "chat-body clearfix");

    var header = document.createElement("div");
    $(header).attr("class", "header");

    var small = document.createElement("small");
    $(small).attr("class", "pull-right text-muted");

    var span2 = document.createElement("span");
    $(span2).attr("class", "glyphicon glyphicon-time datetime");
    $(small).append(span2);

    var data = document.createTextNode(" " + messaggio.data);
    $(span2).append(data);

    var strong = document.createElement("strong");
    $(strong).attr("class", "primary-font");
    var mittente = document.createTextNode(messaggio.nomeMittente + " " + messaggio.cognomeMittente);
    $(strong).append(mittente);

    $(header).append(strong);
    $(header).append(small);
    $(body).append(header);

    var paragraph = document.createElement("p");
    var testo = document.createTextNode(messaggio.testo);
    $(paragraph).append(testo);
    $(body).append(paragraph);
    $(li).append(body);

    $("#chat-list").append(li);
}

var AJAX;

function getNuoviMessagi() {
    var data = $(".datetime").last().text();
    var destinatario = $("form#chat input[name='destinatario']").val();
    var url = $("form#chat input[name='nuovimessaggi']").val();

    console.log(data);
    console.log(destinatario);
    console.log(url);

    return $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: {
            "data": data,
            "destinatario": destinatario
        },
        cache: false,
        success: function (response, textStatus, jqXHR) {
            console.log("GET_NUOVI_MESSAGGI_RESPONSE: " + response);
            var messaggi = response.messaggi;
            console.log(messaggi.length);

            $.each(messaggi, function (index, messaggio) {
                mostraMessaggio(messaggio);
            });
        }
    });
}