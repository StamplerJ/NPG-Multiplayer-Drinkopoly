function handleMessage(message) {
    let type = message.type;
    let value = message.value;

    console.log(message);

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
        case "neverever":
            onNeverEver(value);
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
    if(value.message != null) {
        displayText(value.message);
    }

    toggleButton("#ready", false);
    toggleButton("#dice", true);

    if(username === value.username)
        $('#dice').prop('disabled', false);
    else
        $('#dice').prop('disabled', true);

    $('#board').removeClass("d-none");
    $('#rockpaperscissors').addClass("d-none");
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
    if(value.username != null)
    {
        showSnackbar(value.username + " hat das Category-Game gestartet!");
        displayText("Nenne Begriffe zur Kategorie: " + value.category);

        toggleButton("#dice", false);
        toggleButton("#sendMessage", false);
        toggleButton("#sendAnswer", true);

        if(value.isGameMaster == username)
        {
            displayText(value.username + " ist der GameMaster und bewertet die Antworten.")
            gameMaster();
        }
    }

    canChat = value.nextPlayer === username;
    toggleButton("#sendAnswer", canChat);
}

function onNeverEver(value) {
    showSnackbar(value.username + " hat 'Never have I ever' gestartet!");
    displayText(value.question);
    toggleButton("#dice", false);
    toggleButton("#sendMessage", false);
    neverEverButtons();
}

function onRockPaperScissors(value) {
    showSnackbar(value.message);

    toggleButton("#dice", false);

    $("#board").addClass("d-none");

    $("#rockpaperscissors").removeClass("d-none");
    $("#rockpaperscissors #left #name").text(value.playerOne);
    $("#rockpaperscissors #right #name").text(value.playerTwo);


    if(username == value.playerOne) {
        toggleButton("#rockpaperscissors #left #leftButtons", true)
    }

    if(username == value.playerTwo) {
        toggleButton("#rockpaperscissors #right #rightButtons", true)
    }
}