const BOARD_WIDTH = 6;
const BOARD_HEIGHT = 6;

let canvas;
let context;

let canvasWidth;
let canvasHeight;

let fields = [];

$(document).ready(function () {
    canvas = document.getElementById("canvas");
    context = canvas.getContext("2d");
    context.font = "30px Arial";

    setupGameBoard();

    drawBoard();
});

function initializeBoard(fieldsData) {
    for (let i = 0; i < fieldsData.length; i++) {
        let data = fieldsData[i];
        let field = fields[data.index];
        field.text = data.text;
        field.game = data.game;
    }
    drawBoard();
}

function boardTurn(value) {
    initializePlayers(value.player_positions);
    drawBoard();
}

function drawBoard() {
    clearCanvas();
    let img = document.getElementById("scream");
    context.drawImage(img, canvasWidth / 2 - img.naturalWidth / 2, canvasHeight / 2 - img.naturalHeight / 2);
    for (let i = 0; i < fields.length; i++) {
        fields[i].draw(context);
    }
    drawPlayers(fields);
}

function clearCanvas() {
    context.clearRect(0, 0, canvas.width, canvas.height);
}

function setupGameBoard() {
    canvasWidth = canvas.width;
    canvasHeight = canvas.height;

    let cellWidth = canvasWidth / BOARD_WIDTH;
    let cellHeight = canvasHeight / BOARD_HEIGHT;

    let indexCounter = 0;
    let x = 0, y = 0;
    let forward = true;

    let fieldsCount = 2 * BOARD_WIDTH + 2 * BOARD_HEIGHT - 4;
    for (let i = 0; i < fieldsCount; i++) {
        // Lets only outer fields through to be drawn
        if(y > 0 && y < BOARD_HEIGHT - 1 && x > 0 && x < BOARD_WIDTH - 1)
            continue;

        fields.push(new Field(indexCounter, x, y, cellWidth, cellHeight));

        indexCounter++;

        if(forward) {
            if(x < BOARD_WIDTH - 1)
                x++;
            else if (y < BOARD_HEIGHT - 1)
                y++;
            else {
                x--;
                forward = false;
            }
        }
        else {
            if(x > 0)
                x--;
            else if (y > 1)
                y--;
        }
    }
}