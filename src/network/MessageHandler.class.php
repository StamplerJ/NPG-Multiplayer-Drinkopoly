<?php

require_once("Server.class.php");
require_once(__DIR__."/../model/Login.class.php");
require_once(__DIR__."/../model/BoardTurn.class.php");
require_once(__DIR__."/../network/GameManager.class.php");

class MessageHandler
{
    private $SERVER_NAME = "Server";
    private $LOGIN_MESSAGE = "%s has joined the server";

    private $server;
    private $gameManager;

    public function __construct(Server $server)
    {
        $this->server = $server;
        $this->gameManager = new GameManager($server);
    }

    public function handleMessage($client, $message)
    {
        $type = $message->type;
        $value = $message->value;

        switch ($type)
        {
            case "login":
                $client->setUsername($value->username);
                $this->login($client, $value);
                break;
            case "ready":
                $this->ready($client, $value);
                break;
            case "board_turn":
                $this->rollDice($client, $value);
                break;
            case "category":
//                echo "category";
                $this->server->sendTextToAllClients($client->getUsername(), $value->message);
                $this->categoryCheck($client, $value);
                break;
            case "neverever":
//                echo "neverever";
                //$this->gameManager->playNeverEver($value);
                $this->server->sendTextToAllClients($client->getUsername(), $value->message);
                break;
            default:
                $this->server->sendTextToAllClients($client->getUsername(), $value->message);
        }
    }

    public function categoryCheck($client, $value)
    {
        if($value->type == "rating") {
            if($value->message == "NO")
            {
                $this->gameManager->sendShot($this->server->findClient($this->gameManager->getCurrentPlayer()));
                $this->server->sendTextToAllClients($client->getUsername(), "Category-Game beendet.");
            }
            else
            {
                $message = array('type' => 'category',
                    'value' => array(
                        "nextPlayer" => $this->gameManager->getNextPlayer()
                    ));
                $this->server->sendMessageToAllClients($message);
            }
        }
    }

    public function rollDice($client, $value) {
        $boardTurn = new BoardTurn($value);
        $destinationFieldIndex = null;

        // Change player position based on dice
        $players = $this->gameManager->getPlayers();
        foreach ($players as $player) {
            if($player->getName() == $boardTurn->getUsername()) {
                $player->addSteps($boardTurn->getDice());
                $destinationFieldIndex = $player->getFieldIndex();
                break;
            }
        }
        $boardTurn->setPlayerPositions($players);

        // Send new field positions to all players
        $message = array('type' => 'board_turn',
            'value' => array(
                "username" => $boardTurn->getUsername(),
                "dice" => $boardTurn->getDice(),
                "player_positions" => $boardTurn->getPlayerPositionsData(),
                "nextPlayer" => $this->gameManager->getNextPlayer()
            ));
        $this->server->sendMessageToAllClients($message);

        // Select game of new field
        $game = $this->gameManager->findField($destinationFieldIndex)->getGame();
        if($game != null) {
            $this->gameManager->handleGame($game, $client);
        }
    }

    public function login($client, $value)
    {
        // Deny access if lobby is full (4 players) or game is already started
        if(count($this->gameManager->getPlayers()) >= 4 || $this->gameManager->isGameStarted()) {
            $message = array('type' => 'login',
                'value' => array(
                    'successful' => false,
                    'message' => "Die Lobby ist voll oder das Spiel ist bereits gestartet.",
                ));
            $this->server->sendMessage($client->getSocket(), $message);

            return;
        }
        $login = new Login($value);

        // Check if username is already taken
        foreach($this->gameManager->getPlayers() as $player) {
            if($player->getName() === $login->getUsername()) {
                $message = array('type' => 'login',
                    'value' => array(
                        'successful' => false,
                        'message' => "Der Benutzername wird bereits verwendet.",
                    ));
                $this->server->sendMessage($client->getSocket(), $message);
                return;
            }
        }

        $player = $this->gameManager->createPlayer($login->getUsername());
        $client->setPlayer($player);

        $this->server->sendTextToAllClients($this->SERVER_NAME, sprintf($this->LOGIN_MESSAGE, $login->getUsername()));

        // Login response to new player
        $message = array('type' => 'login',
            'value' => array(
                'successful' => true,
                'username' => $login->getUsername(),
                'message' => "",
                'board' => $this->gameManager->getFieldsData(),
                'players' => $this->gameManager->getPlayersData()
            ));
        $this->server->sendMessage($client->getSocket(), $message);

        // Update players to all clients
        $message = array('type' => 'updatePlayers',
            'value' => array(
                "players" => $this->gameManager->getPlayersData(),
            ));
        $this->server->sendMessageToAllClients($message);
    }

    public function ready($client, $value)
    {
        $client->getPlayer()->setReady(true);

        $message = array('type' => 'ready',
            'value' => array(
                'username' => $client->getUsername()
            ));
        $this->server->sendMessageToAllClients($message);

        // Check if everyone is ready
        $everyoneReady = true;
        foreach ($this->gameManager->getPlayers() as $player) {
            if (!$player->getReady()) {
                $everyoneReady = false;
                break;
            }
        }

        if($everyoneReady) {
            $this->gameManager->startGame();
        }
    }

    public function removePlayer($username) {
        $indexToDelete = null;

        $players = $this->gameManager->getPlayers();
        foreach ($this->gameManager->getPlayers() as $key => &$player) {
            if($player->getName() == $username) {
                $indexToDelete = $key;
                break;
            }
        }

        if($indexToDelete !== null) {
            unset($players[$indexToDelete]);
            $this->gameManager->setPlayers($players);
        }
    }

    public function getGameManager()
    {
        return $this->gameManager;
    }
}