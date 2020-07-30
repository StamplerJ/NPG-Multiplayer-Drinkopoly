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

function onChatMessage(value) {
    displayMessage(value);
}

function onLogin(value) {
    initializeBoard(value.board);
    initializePlayers(value.players);
}