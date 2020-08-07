$(document).ready(function () {

});

function neverEverButtons() {
    toggleButton("#voteYes", true);
    toggleButton("#voteNo", true);

    $("#voteYes").click(function () {
        sendNeverEverAnswer("YES");
        toggleButton("#voteYes", false);
        toggleButton("#voteNo", false);
        toggleButton("#sendMessage", true);
    });

    $("#voteNo").click(function () {
        sendNeverEverAnswer("NO");
        toggleButton("#voteYes", false);
        toggleButton("#voteNo", false);
        toggleButton("#sendMessage", true);
    });
}
