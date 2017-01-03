var ROOT_DIR = "/yourteam/web/app_dev.php";

$(function () {
    $("#add").click(function () {
        $("#new").toggle();
    });

    $(".modifica-btn").click(function () {
        $(this).parent().siblings(".modifica").toggle();
    });

    $(".info-btn").click(function () {
        $(this).parent().siblings(".info").toggle();
    });

    $(".inserisci-partita").submit(inserisciPartitaHandler);
});

/**
 *
 * @param event
 */
function inserisciPartitaHandler(event) {
    /* stop form from submitting normally */
    event.preventDefault();
    console.log("Ajax Inserisci Partita Handler...");

    var form = $(this);
    var casa = $("input[name='casa']").val();
    var trasferta = $("input[name='trasferta']").val();
    var stadio = $("input[name='stadio']").val();
    var data = $("input[name='data']").val();
    var ora = $("input[name='ora']").val();

    console.log("Salva Partita");
    console.log("Casa: " + casa);
    console.log("Trasferta: " + trasferta);
    console.log("Stadio: " + stadio);
    console.log("Data: " + data);
    console.log("Ora: " + ora);

    $.ajax({
        //url Specifies the URL to send the request to. Default is the current page.
        url: ROOT_DIR + "/partite/staff/insert/submit",
        //type	Specifies the type of request. (GET or POST)
        type: "POST",
        //dataType	The data type expected of the server response.
        dataType: 'json',
        //data	Specifies data to be sent to the server.
        data: {
            "casa": casa,
            "trasferta": trasferta,
            "stadio": stadio,
            "data": data,
            "ora": ora
        },
        //cache	A Boolean value indicating whether the browser should cache the requested pages. Default is true.
        cache: false,
        success: function (response, textStatus, jqXHR) {
            var success = response.success;
            console.log(response);

            if (success === true) {
                var partita = response.partita;
                var casa = response.partita.casa;
                var trasferta = response.partita.trasferta;
                var nome = response.partita.nome;
                var data = response.partita.data;
                var squadra = response.partita.squadra;
                var stadio = response.partita.stadio;

                var container = document.createElement("div");
                container.setAttribute("class", "panel panel-default");

                var heading = document.createElement("div");
                heading.setAttribute("class", "panel-heading");
                heading.setAttribute("role", "tab");
                container.appendChild(heading);

                var title = document.createElement("h4");
                title.setAttribute("class", "panel-title");
                heading.appendChild(title);

                var button = document.createElement("button");
                button.setAttribute("class", "collapsed");
                button.setAttribute("data-toggle", "collapse");
                button.setAttribute("data-parent", "#accordion");
                var nowID = "ID" + $.now().toString();
                button.setAttribute("data-target", "#" + nowID);
                title.appendChild(button);

                var spanNome = document.createElement("span");
                spanNome.setAttribute("class", "pull-left");
                spanNome.appendChild(document.createTextNode(nome));
                button.appendChild(spanNome);

                var spanData = document.createElement("span");
                spanData.setAttribute("class", "pull-right");
                spanData.appendChild(document.createTextNode(data));
                button.appendChild(spanData);

                var content = document.createElement("div");
                content.setAttribute("id", nowID);
                content.setAttribute("class", "panel-collapse collapse");
                content.setAttribute("role", "tabpanel");
                container.appendChild(content);

                var body = document.createElement("div");
                body.setAttribute("class", "panel-body");
                content.appendChild(body);

                var modifica_btn = document.createElement("button");
                modifica_btn.setAttribute("class", "modifica-btn");
                modifica_btn.appendChild(document.createTextNode("Modifica"));
                var info_btn = document.createElement("button");
                info_btn.setAttribute("class", "info-btn");
                info_btn.appendChild(document.createTextNode("Info"));
                body.appendChild(modifica_btn);
                body.appendChild(info_btn);

                var divInfo = document.createElement("div");
                divInfo.setAttribute("style", "display:none;");
                divInfo.setAttribute("class", "info");

                console.log("Partita: " + partita);

                $.ajax({
                    url: ROOT_DIR + "/partite/user/info",
                    //type	Specifies the type of request. (GET or POST)
                    type: "POST",
                    //data	Specifies data to be sent to the server.
                    data: {
                        "nome": nome,
                        "data": data
                    },
                    cache: false,
                    success: function (response, textStatus, jqXHR) {
                        console.log("Response info partita");
                        console.log(response);
                        $(divInfo).html(response);
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        console.log("TextStatus: " + textStatus);
                        console.log("Status: " + jqXHR.status);
                        console.log("ResponseText: " + jqXHR.responseText);
                        console.log("Error: " + errorThrown);
                    }
                });

                var divModifica = document.createElement("div");
                divModifica.setAttribute("style", "display:none;");
                divModifica.setAttribute("class", "modifica");

                $.ajax({
                    url: ROOT_DIR + "/partite/staff/edit/form",
                    //type	Specifies the type of request. (GET or POST)
                    type: "POST",
                    //data	Specifies data to be sent to the server.
                    data: {
                        "nome": nome,
                        "data": data
                    },
                    cache: false,
                    success: function (response, textStatus, jqXHR) {
                        console.log("Response modifica partita");
                        console.log(response);
                        $(divModifica).html(response);
                        /* attach a submit handler to the form */
                        $(".modifica-partita").submit(modificaPartitaHandler);
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        console.log("TextStatus: " + textStatus);
                        console.log("Status: " + jqXHR.status);
                        console.log("ResponseText: " + jqXHR.responseText);
                        console.log("Error: " + errorThrown);
                    }
                });


                content.appendChild(divInfo);
                content.appendChild(divModifica);
                $("#accordion").append(container);

                $(".modifica-btn").click(function () {
                    $(this).parent().siblings(".modifica").toggle();
                });

                $(".info-btn").click(function () {
                    $(this).parent().siblings(".info").toggle();
                });

                $(form)[0].reset();
                $("#new").hide();

                //Success feedback
                $(".alert-success").show().delay(1000).fadeOut();
            }
        }
        ,
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("TextStatus: " + textStatus);
            console.log("Status: " + jqXHR.status);
            console.log("ResponseText: " + jqXHR.responseText);
            console.log("Error: " + errorThrown);
        }
    });
}