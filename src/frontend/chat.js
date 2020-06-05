const wsUri = "ws://ux-113.pb.bib.de:22408";
let websocket;

$(document).ready(function() {


    // $("#login-btn").click(function() {
    //     user = $("#user").val();
    //     color = $("#color").val();
    //
    //     if (user == "" || color == "")
    //         return;
    //
    //     $(".chat").show();
    //     $("#login-btn").hide();
    // });
    //
    // $("#send-btn").click(function() {
    //     var message = $("#message").val();
    //     let obj = {
    //         "type": "user",
    //         "message": message,
    //         "nickname": user,
    //         "color": color
    //     };
    //     websocket.send(JSON.stringify(obj));
    //
    //     $("#message").val("");
    // });
});

function displayMessage(input) {
    const div = $('<div />', {
        text: input.username + ": " + input.message,
    });
    console.log(input);
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

    setupWebsocket();
    websocket.onopen = function(ev) {
        websocket.send(JSON.stringify(obj));
    };
}

function setupWebsocket() {
    websocket = new WebSocket(wsUri);

    websocket.onmessage = function(ev) {
        let input = JSON.parse(ev.data);
        console.log(ev.data);
        displayMessage(input);
    };

    websocket.onerror = function(ev) {
        console.error("WebSocket error observed:", ev);
    };

    websocket.onclose = function(ev) {
        displayMessage({ type: 'exit' });
    };
}