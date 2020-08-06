$(document).ready(function () {
    $("#sendAnswer").click(function () {
        let message = $("#message").val();
        if(canChat){
            if (message.length > 0) {
                sendCategoryAnswer(message, "answer");
                $("#message").val("");
            }
        }
    });

    $("#message").keypress(function (event) {
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13' && !$("#sendMessage").hasClass("d-none")) {
            $("#sendAnswer").click();
        }
    });
});

function gameMaster() {
    console.log("gameMaster setup");
    $("#voteYes").removeClass("d-none");
    $("#voteNo").removeClass("d-none");

    $("#voteYes").click(function () {
        sendCategoryAnswer("YES", "rating");
    });

    $("#voteNo").click(function () {
        sendCategoryAnswer("NO", "rating");
        toggleButton("#voteYes", false);
        toggleButton("#voteNo", false);
        toggleButton("#sendMessage", true);
        toggleButton("#sendAnswer", false);
        toggleButton("#dice", true);
    });
}