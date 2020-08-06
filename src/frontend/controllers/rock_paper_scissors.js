$(document).ready(function () {
    $('.rpsButton').click(function(e) {
        onButtonClick(e);
    });
});

function onButtonClick(e) {
    toggleButton("#" + e.target.parentElement.id, false);

    let chosen = e.target.value;
    sendRockPaperScissors(chosen.toLowerCase());
}