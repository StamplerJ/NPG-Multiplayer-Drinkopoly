$(document).ready(function() {
    const wsUri = "ws://ux-113.pb.bib.de:22408";
    let websocket = new WebSocket(wsUri);

    websocket.onopen = function(ev) {
        let obj = {
            "type": "login",
            "nickname": "user"
        };
        websocket.send(JSON.stringify(obj));
    };

    websocket.onmessage = function(ev) {
        let input = JSON.parse(ev.data);
        displayMessage(input);
    };

    websocket.onerror = function(ev) {
        console.error("WebSocket error observed:", ev);
    };

    websocket.onclose = function(ev) {
        displayMessage({
            type: 'exit'
        });
    };

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
        "style": 'color:' + input.color,
        text: input.nickname + ": " + input.message,
    });
    console.log(input);
    $("#message_box").append(div);
}