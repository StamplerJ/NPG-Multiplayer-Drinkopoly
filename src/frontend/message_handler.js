function handleMessage(message) {
    let type = message.type;
    let value = message.value;

    switch (type)
    {
        case "login":
            onLogin(value);
            break;
        case "category":
            onCategory(value);
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

function onCategory(value) {
    displayAnswer(value);
    selectGameMaster();
    distributeCategory();
}