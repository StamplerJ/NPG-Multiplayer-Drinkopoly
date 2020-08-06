const wsUri = "ws://ux-113.pb.bib.de:22408";
let websocket;
let username;

$(document).ready(function () {
    $("#sendAnswer").click(function () {
        let message = $("#message").val();
        if(canChat){
            if (message.length > 0) {
                sendCategoryAnswer(message);
                $("#message").val("");
            }
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

function gameManager() {
    $("#voteYes").removeClass("d-none");
    $("#voteNo").removeClass("d-none");

    $("#voteYes").click(function () {
        sendCategoryAnswer("YES");
    });

    $("#voteNo").click(function () {
        sendCategoryAnswer("NO");
        $("#voteYes").addClass("d-none");
        $("#voteNo").addClass("d-none");
        $("#sendMessage").removeClass("d-none");
        $("#sendAnswer").addClass("d-none");
    });
}