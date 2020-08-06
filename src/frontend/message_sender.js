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
            "dice": null,
            "player_positions": []
        }
    };

    websocket.send(JSON.stringify(obj));
}

function sendReady() {
    let obj = {
        "type": "ready",
        value: {
            "ready": true
        }
    };

    websocket.send(JSON.stringify(obj));
}

function sendCategoryAnswer(answer, type) {
    let obj = {
        "type": "category",
        value: {
            "username": username,
            "message": answer,
            "type" : type
        }
    };

    websocket.send(JSON.stringify(obj));
}

function sendNeverEverAnswer(answer) {
    let obj = {
        "type": "neverever",
        value: {
            "username": username,
            "answer": answer
        }
    };

    websocket.send(JSON.stringify(obj));
}