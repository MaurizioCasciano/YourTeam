/**
 * Created by Maurizio on 14/01/2017.
 */
$(function () {
    $("form#chat").submit(inviaMessaggioChat);
    setInterval(function () {
        getNuoviMessagi();
    }, 2000);
});

function inviaMessaggioChat(event) {
    event.preventDefault();
    console.log("Ajax Invia Messaggio CHAT...");

    var $form = $(this);
    var data = $($form).serialize();
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
                mostraMessaggio(messaggio);
            }
        }
    });
}


function mostraMessaggio(messaggio) {
    console.log("Mostra messaggio");

    var senderImg = document.createElement("img");
    senderImg.setAttribute("src", "http://placehold.it/50/FA6F57/fff&text=ME");
    senderImg.setAttribute("alt", "User Avatar");
    senderImg.setAttribute("class", "img-circle");
    var senderImgSpan = document.createElement("span");
    senderImgSpan.setAttribute("class", "chat-img pull-right");
    senderImgSpan.appendChild(senderImg);
    //senderImgSpan END
    //chatHeaderDiv BEGIN
    var timeTextNode = document.createTextNode(messaggio.data);
    var timeSpan = document.createElement("span");
    timeSpan.setAttribute("class", "datetime glyphicon glyphicon-time");
    timeSpan.appendChild(timeTextNode);

    var senderNameSurnameTextNode = document.createTextNode(messaggio.nomeMittente + " " + messaggio.cognomeMittente);
    var senderStrong = document.createElement("strong");
    if (messaggio.mittente === "allenatore") {
        senderStrong.setAttribute("class", "pull-right primary-font");
    } else if (messaggio.mittente === "calciatore") {
        senderStrong.setAttribute("class", "pull-left primary-font");
    }

    senderStrong.appendChild(senderNameSurnameTextNode);

    var chatHeaderDiv = document.createElement("div");
    chatHeaderDiv.setAttribute("class", "header");
    chatHeaderDiv.appendChild(timeSpan);
    chatHeaderDiv.appendChild(senderStrong);
    //chatHeaderDiv END

    //chatBodyDiv BEGIN
    var chatBodyDiv = document.createElement("div");
    chatBodyDiv.setAttribute("class", "chat-body clearfix");
    chatBodyDiv.appendChild(chatHeaderDiv);

    var messageTextParagraph = document.createElement("p");
    var messageTextNode = document.createTextNode(messaggio.testo);
    messageTextParagraph.appendChild(messageTextNode);
    chatBodyDiv.appendChild(messageTextParagraph);
    //chatBodyDiv END

    //messageListItem BEGIN
    var listItem = document.createElement("li");
    listItem.setAttribute("class", "right clearfix");
    listItem.appendChild(senderImgSpan);
    listItem.appendChild(chatBodyDiv);
    var chat = document.getElementById("chat");
    chat.appendChild(listItem);
    //messageListItem END

    $("#chat_viewport").scrollTop($("#chat").outerHeight());
}

function getNuoviMessagi() {
    var data = $(".datetime").last().text();
    var destinatario = $("form#chat input[name='destinatario']").val();
    var url = $("form#chat input[name='nuovimessaggi']").val();

    //console.log(data);
    //console.log(destinatario);
    //console.log(url);

    $.ajax({
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
            console.log(messaggi);


        }
    });
}