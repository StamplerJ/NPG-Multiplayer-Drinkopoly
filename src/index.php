<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NPG Drinkopoly</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="frontend/style.css"/>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="frontend/model/field.class.js"></script>
    <script src="frontend/model/player.class.js"></script>
    <script src="frontend/chat.js"></script>
    <script src="frontend/message_handler.js"></script>
    <script src="frontend/message_sender.js"></script>
    <script src="frontend/controllers/game_board.js"></script>
    <script src="frontend/controllers/players.js"></script>
    <script src="frontend/controllers/category.js"></script>
    <script src="frontend/controllers/never_ever.js"></script>
    <script src="frontend/controllers/rock_paper_scissors.js"></script>
</head>
<body>

<h1 class="text-center">Drinkopoly</h1>

<div id="login">
    <div class="container h-100">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="icon.png" class="brand_logo" alt="Logo">
                    </div>
                </div>
                <div class="d-flex justify-content-center form_container row">
                    <div class="col-12 input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input id="username" type="text" name="" class="form-control input_user" value="" placeholder="Username">
                    </div>
                    <div class="col-12 d-flex justify-content-center mt-3 login_container">
                        <button id="loginButton" type="button" name="button" class="btn login_btn">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="game" class="d-none mx-5">
    <div class="row">
        <div id="board" class="col-lg-8 col-12 text-center">
            <canvas id="canvas" class="mx-auto" width="800" height="800">
            </canvas>
        </div>
        <div id="rockpaperscissors" class="col-lg-8 col-12 text-center d-none">
            <div class="h-100 d-flex align-items-center">
                <div id="left" class="col-6">
                    <h2 id="name">Spieler Eins</h2>
                    <h3 id="answer">Warte auf Auswahl...</h3>
                    <div id="leftButtons" class="d-none">
                        <input id="leftScissors" class="rpsButton" type="button" value="Scissors"/>
                        <input id="leftRock" class="rpsButton" type="button" value="Rock"/>
                        <input id="leftPaper" class="rpsButton" type="button" value="Paper"/>
                    </div>
                </div>
                <div id="right" class="col-6">
                    <h2 id="name">Spieler zwei</h2>
                    <h3 id="answer">Warte auf Auswahl...</h3>
                    <div id="rightButtons" class="d-none">
                        <input id="rightScissors" class="rpsButton" type="button" value="Scissors"/>
                        <input id="rightRock" class="rpsButton" type="button" value="Rock"/>
                        <input id="rightPaper" class="rpsButton" type="button" value="Paper"/>
                    </div>
                </div>
            </div>
        </div>
        <div id="side" class="col-lg-4 col-12">
            <div class="popup">
                <span class="popuptext" id="myPopup"></span>
            </div>
            <div id="score" class="border rounded">
                <h4>Sip Counter:</h4>
                <p id="drinks">Drinks: <span id="drinkValue">0</span></p>
                <p id="shots">Shots: <span id="shotValue">0</span></p>
            </div>
            <div id="playerlistContainer" class="border rounded">
                <h4>Spielerliste:</h4>
                <ul id="playerlist" style="font-size: 16pt">
                </ul>
            </div>
            <div id="chat" class="border rounded flex-grow-1">
                <h4>Chat:</h4>
                <div id="message_box" style="overflow-y: scroll; height: 300px">
                </div>
            </div>
            <input id="message" type="text" width="100%"/>
            <input id="sendMessage" type="button" value="Send"/>
            <input id="sendAnswer" type="button" value="Answer" class="d-none"/>
            <input id="ready" type="button" value="Ready"/>
            <input id="dice" type="button" value="Würfeln" class="d-none"/>
            <input id="voteYes" type="button" value=" + " class="d-none"/>
            <input id="voteNo" type="button" value=" - " class="d-none"/>
        </div>
    </div>
</div>

<div id="snackbar">Some text some message..</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#loginButton").click(function() {
            username = $("#username").val();

            if (username === "") {
                return;
            }

            $("#login").addClass("d-none");
            $("#game").removeClass("d-none");

            login(username);
        });

        $("#dice").click(function() {
            rollDice(username);
            $('#dice').prop('disabled', true);
        });

        $("#ready").click(function() {
            sendReady();
            $('#ready').prop('disabled', true);
        });

        // Enter key event handling below
        $("#username").keypress(function(event) {
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13') {
                $("#loginButton").click();
            }
        });
    });

    function showSnackbar(text) {
        let x = document.getElementById("snackbar");
        x.className = "show";
        $("#snackbar").text(text);
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
</script>

<!-- JS, Popper.js, and jQuery -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
</body>
</html>