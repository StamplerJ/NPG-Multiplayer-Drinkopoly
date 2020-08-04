const wsUri = "ws://ux-113.pb.bib.de:22408";
let websocket;
let username;

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
        if (keycode == '13') {
            $("#sendMessage").click();
        }
    });
});

function displayMessage(input) {
    console.log(input)
    const div = $('<div />', {
        text: input.username + ": " + input.message,
    });
    $("#message_box").append(div);
}

function displayText(text) {
    const div = $('<div />', {
        text: text
    });
    $("#message_box").append(div);
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