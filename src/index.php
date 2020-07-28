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
    <script src="frontend/chat.js"></script>
    <script src="frontend/message_handler.js"></script>
    <script src="frontend/message_sender.js"></script>
</head>
<body>

<h1 class="text-center">Drinkopoly</h1>

<div id="login">
    <h2>Join Drinkopoly</h2>
    <div>
        Username:
        <input id="username" type="text"/>
        <input id="loginButton" type="button" value="Login">
    </div>
</div>

<div id="game" class="d-none mx-5">
    <div class="row">
        <div id="board" class="col-8 text-center">
            <canvas id="canvas" class="border mx-auto" width="800" height="800">
            </canvas>
        </div>
        <div id="side" class="col">
            <div id="score" class="border rounded">
                <h4>Sip Counter:</h4>
                <p id="drinks">Drinks: 0</p>
                <p id="shots">Shots: 0</p>
            </div>
            <div id="playerlistContainer" class="border rounded">
                <h4>Spielerliste:</h4>
                <ul id="playerlist">
                    <li>Jann</li>
                    <li>Veit</li>
                </ul>
            </div>
            <div id="chat" class="border rounded flex-grow-1">
                <h4>Chat:</h4>
                <div id="message_box">
                </div>
            </div>
            <input id="message" type="text" width="100%"/>
            <input id="sendMessage" type="button" value="Send"/>
            <input id="voteYes" type="button" value=" + " display="none"/>
            <input id="voteNo" type="button" value=" - " visibility="hidden"/>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#loginButton").click(function() {
            let username = $("#username").val();

            if (username === "") {
                return;
            }

            $("#login").addClass("d-none");
            $("#game").removeClass("d-none");

            login(username);
        });

        // Enter key event handling below
        $("#username").keypress(function(event) {
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13') {
                $("#loginButton").click();
            }
        });
    });
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