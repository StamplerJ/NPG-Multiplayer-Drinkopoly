function handleMessage(message) {
    let type = message.type;
    let value = message.value;

    switch (type)
    {
        case "login":
            onLogin(value);
            break;
        default:
            onChatMessage(value);
    }
}

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