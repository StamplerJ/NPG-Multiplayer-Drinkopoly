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
        case "updatePlayers":
            onUpdatePlayers(value);
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
        case "drink":
            onDrink(value);
            break;
        case "shot":
            onShot(value);
            break;
        case "rockpaperscissors":
            onRockPaperScissors(value);
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
    displayText("Das Spiel startet jetzt und " + value.username + " beginnt");
    $("#ready").addClass("d-none");
    $("#dice").removeClass("d-none");

    if(username === value.username)
        $('#dice').prop('disabled', false);
    else
        $('#dice').prop('disabled', true);
}

function onUpdatePlayers(value) {
    initializePlayers(value.players);
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
    //TODO gamemaster (- Button, bei klick drink +1)
    displayAnswer(value);
    distributeCategory(value.category);

}

function onRockPaperScissors(value) {
    displayMessage(value.message);

    $("#rockpaperscissors").removeClass("d-none");
    $("#rockpaperscissors #left #name").text(value.playerOne);
    $("#rockpaperscissors #right #name").text(value.playerTwo);


    if(username == value.playerOne) {

    }

    if(username == value.playerTwo) {

    }
}