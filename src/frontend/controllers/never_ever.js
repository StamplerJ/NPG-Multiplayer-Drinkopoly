$(document).ready(function () {

});

function neverEverButtons() {
    console.log("BUttons an");
    toggleButton("#voteYes", true);
    toggleButton("#voteNo", true);

    $("#voteYes").click(function () {
        sendNeverEverAnswer("YES");
        toggleButton("#voteYes", false);
        toggleButton("#voteNo", false);
        toggleButton("#dice", true);
        toggleButton("#sendMessage", true);
    });

    $("#voteNo").click(function () {
        sendNeverEverAnswer("NO");
        toggleButton("#voteYes", false);
        toggleButton("#voteNo", false);
        toggleButton("#dice", true);
        toggleButton("#sendMessage", true);
    });
}
