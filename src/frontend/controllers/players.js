let players = [];

$(document).ready(function () {

});

function initializePlayers(playersData) {
    players.length = 0;
    $("#playerlist").empty();
    for (let i = 0; i < playersData.length; i++) {
        let data = playersData[i];
        let player = new Player(data.name, data.fieldIndex, data.color);
        players.push(player);
        addToPlayerList(player);
    }
    drawBoard();
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

function addToPlayerList(player) {
    let ul = document.getElementById("playerlist");
    let li = document.createElement("li");
    li.style.color = player.color;
    li.appendChild(document.createTextNode(player.name));
    ul.appendChild(li);
}