const wsUri = "ws://ux-113.pb.bib.de:22408";
let websocket;
let username;

function displayMessage(input) {
    const div = $('<div />', {
        text: input.username + ": " + input.message,
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
        console.log("Input");
        console.log(input);
        handleMessage(input);
    };

    websocket.onerror = function(ev) {
        console.error("WebSocket error observed:", ev);
    };

    websocket.onclose = function(ev) {
        displayMessage({ type: 'exit' });
    };
}