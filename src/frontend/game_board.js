let width;
let height;

$(document).ready(function () {

    setupGameBoard();

    console.log("Dim: " + width + ", " + height)
});

function setupGameBoard() {
    let canvas = document.getElementById("canvas");
    let context = canvas.getContext("2d");

    width = canvas.width;
    height = canvas.height;
}