function sendChatMessage(message) {
    let obj = {
        "type": "chat",
        value: {
            "successful": null,
            "username": username,
            "message": message
        }
    };

    websocket.send(JSON.stringify(obj));
}

function rollDice(username) {
    let obj = {
        "type": "board_turn",
        value: {
            "username": username,
            dice: null,
            player_positions: []
        }
    };

    websocket.send(JSON.stringify(obj));
}