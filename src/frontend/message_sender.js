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