const wsUri = "ws://ux-113.pb.bib.de:22408";
let websocket;
let username;

let canChat;

$(document).ready(function () {
    $("#sendMessage").click(function () {
        let message = $("#message").val();
        if (message.length > 0) {
            sendChatMessage(message);
            $("#message").val("");
        }
    });

    $("#message").keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13' && !$("#sendMessage").hasClass("d-none")) {
            $("#sendMessage").click();
        }
    });
});

function displayMessage(input) {
    displayText(input.username + ": " + input.message);
}

function displayText(text) {
    const div = $('<div />', {
        text: text,
        css: {
            "padding-left": "10px",
            "margin-bottom": "0",
            "background-color": "white",
            "transition": "background-color 1s linear"
        }
    });
    $("#message_box").append(div);

    setTimeout(function(){ $(div).css("background-color", "transparent",); },500);

    $('#message_box').scrollTop($('#message_box')[0].scrollHeight);
}

function login(username) {
    let obj = {
        "type": "login",
        value: {
            "successful": null,
            "username": username,
            "message": ""
        }
    };

    this.username = username;

    setupWebsocket();
    websocket.onopen = function(ev) {
        websocket.send(JSON.stringify(obj));
    };
}

function setupWebsocket() {
    websocket = new WebSocket(wsUri);

    websocket.onmessage = function(ev) {
        let input = JSON.parse(ev.data);
        handleMessage(input);
    };

    websocket.onerror = function(ev) {
        console.error("WebSocket error observed:", ev);
    };

    websocket.onclose = function(ev) {
        displayMessage({ type: 'exit' });
    };
}

function toggleButton(button, state)
{
    if(state)
        $(button).removeClass("d-none");
    else
        $(button).addClass("d-none");

    $(button).prop('disabled', !state);
}