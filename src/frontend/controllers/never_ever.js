$(document).ready(function () {
    $("#voteYes").removeClass("d-none");
    $("#voteNo").removeClass("d-none");

    $("#voteYes").click(function () {
        sendNeverEverAnswer("YES");
        $("#voteYes").addClass("d-none");
        $("#voteNo").addClass("d-none");
    });

    $("#voteNo").click(function () {
        sendNeverEverAnswer("NO");
        $("#voteYes").addClass("d-none");
        $("#voteNo").addClass("d-none");
    });
});
