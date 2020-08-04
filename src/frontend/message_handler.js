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
        case "drink":
            onDrink(value);
            break;
        case "shot":
            onShot(value);
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
    displayText(value.username + " hat eine " + value.dice + " gewürfelt.");
    boardTurn(value);
}

function onDrink(value) {
    let current = +($("#drinkValue").text());
    $("#drinkValue").text(current + value.amount);
}

function onShot(value) {
    let current = +($("#shotValue").text());
    $("#shotValue").text(current + value.amount);
}

function onCategory(value) {
    //TODO gamemaster (- Button, bei klick drink +1)
    displayAnswer(value);
    distributeCategory(value.category);
}