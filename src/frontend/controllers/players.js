let players = [];

$(document).ready(function () {

});

function initializePlayers(playersData) {
    for (let i = 0; i < playersData.length; i++) {
        let data = playersData[i];
        let player = new Player(data.name, data.fieldIndex, data.color);
        players.push(player);
    }
    drawPlayers(fields);
}

function drawPlayers(fields) {
    for (let i = 0; i < players.length; i++) {
        let field = fields[players[i].fieldIndex];
        let radius = field.width / 8;

        players[i].draw(context,
            field.x + (radius * 2) * (i + 1) - radius,
            field.y + field.height - radius,
            radius);
    }
}