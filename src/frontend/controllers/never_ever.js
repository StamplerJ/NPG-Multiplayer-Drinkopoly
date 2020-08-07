$(document).ready(function () {

});

function neverEverButtons() {
    toggleButton("#voteYesNE", true);
    toggleButton("#voteNoNE", true);

    $("#voteYesNE").click(function () {
        sendNeverEverAnswer("YES");
        toggleButton("#voteYesNE", false);
        toggleButton("#voteNoNE", false);
        toggleButton("#sendMessage", true);
    });

    $("#voteNoNE").click(function () {
        sendNeverEverAnswer("NO");
        toggleButton("#voteYesNE", false);
        toggleButton("#voteNoNE", false);
        toggleButton("#sendMessage", true);
    });
}
