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
            case "board_turn":
                $this->rollDice($client, $value);
                break;
            case "category":
                echo "category";
                $this->playCategoryGame($value);
                break;
            case "neverever":
                echo "neverever";
                $this->playNeverEver($value);
                break;
            default:
                $this->server->sendTextToAllClients($client->getUsername(), $value->message);
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

        // Select game of new field
        $game = $this->gameManager->findField($destinationFieldIndex)->getGame();
        if($game != null) {
            $this->gameManager->handleGame($game, $boardTurn->getUsername());
        }

        // Send new field positions to all players
        $message = array('type' => 'board_turn',
            'value' => array(
                "username" => $boardTurn->getUsername(),
                "dice" => $boardTurn->getDice(),
                "player_positions" => $boardTurn->getPlayerPositionsData()
            ));
        $this->server->sendMessageToAllClients($message);
    }

    public function login($client, $value)
    {
        $login = new Login($value);

        $player = $this->gameManager->createPlayer($login->getUsername());
        $client->setPlayer($player);

        $this->server->sendTextToAllClients($this->SERVER_NAME, sprintf($this->LOGIN_MESSAGE, $login->getUsername()));

        $message = array('type' => 'login',
            'value' => array(
                'successful' => true,
                'username' => $login->getUsername(),
                'message' => "",
                'board' => $this->gameManager->getFieldsData(),
                'players' => $this->gameManager->getPlayersData()
            ));
        $this->server->sendMessage($client->getSocket(), $message);
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
}