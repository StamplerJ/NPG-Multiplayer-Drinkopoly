function handleMessage(message) {
    let type = message.type;
    let value = message.value;

    switch (type)
    {
        case "login":
            onLogin(value);
            break;
        case "ready":
            onReady(value);
            break;
        case "startGame":
            onStartGame(value);
            break;
        case "board_turn":
            onBoardTurn(value);
            break;
        case "category":
            onCategory(value);
            break;
        case "neverever":
            onNeverEver(value);
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
    if(value.successful === false) {
        alert(value.message);
        $("#login").removeClass("d-none");
        $("#game").addClass("d-none");
        return;
    }

    initializeBoard(value.board);
    initializePlayers(value.players);
}

function onReady(value) {
    displayText(value.username + " ist bereit");
}

function onStartGame(value) {
    displayText("Das Spiel startet jetzt");
    $("#ready").addClass("d-none");
    $("#dice").removeClass("d-none");
}

function onBoardTurn(value) {
    displayText(value.username + " hat eine " + value.dice + " gewürfelt.");
    displayText(value.nextPlayer + " ist an der Reihe.");
    boardTurn(value);

    if(value.nextPlayer == username)
        $('#dice').prop('disabled', false);
}

function onDrink(value) {
    let current = +($("#drinkValue").text());
    $("#drinkValue").text(current + value.amount);

    let text = "Du erhälst " + value.amount + " Drink.";
    showSnackbar(text);
    displayText(text);
}

function onShot(value) {
    let current = +($("#shotValue").text());
    $("#shotValue").text(current + value.amount);

    let text = "Du erhälst " + value.amount + " Shot.";
    showSnackbar(text);
    displayText(text);
}

function onCategory(value) {

    if(username !== null)
    {
        displayText(value.username + " hat das Category-Game gestartet!");
        displayText("Nenne Begriffe zur Kategorie: " + value.category);
        displayAnswer(value.message);
        //distributeCategory(value.category);
        $("#sendMessage").addClass("d-none");
        $("#sendAnswer").removeClass("d-none");

        if(value.isGameMaster == username)
        {
            gameManager();
        }
    }

    canChat = value.nextPlayer === username;
}

function onNeverEver(value) {
    displayText(value.username + " hat 'Never have I ever' gestartet!");
}