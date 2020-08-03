function handleMessage(message) {
    let type = message.type;
    let value = message.value;

    switch (type)
    {
        case "login":
            onLogin(value);
            break;
        case "board_turn":
            onBoardTurn(value);
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

function onBoardTurn(value) {
    boardTurn(value);
}

function onCategory(value) {
    //TODO gamemaster (- Button, bei klick drink +1)
    displayAnswer(value);
    distributeCategory(value.category);
}