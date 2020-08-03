const wsUri = "ws://ux-113.pb.bib.de:22408";
let websocket;
let username;

$(document).ready(function () {
    $("#sendAnswer").click(function () {
        let message = $("#message").val();
        if (message.length > 0) {
            sendCategoryAnswer(message);
            $("#message").val("");
        }
    });

    $("#message").keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            $("#sendAnswer").click();
        }
    });
});

function displayAnswer(input) {
    console.log(input)
    const div = $('<div />', {
        text: input.username + ": " + input.message,
    });
    $("#message_box").append(div);
}

function distributeCategory(categories) {
    return categories[Math.floor(Math.random() * categories.length)];
}