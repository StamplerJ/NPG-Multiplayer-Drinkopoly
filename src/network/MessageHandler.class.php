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
        $this->gameManager = new GameManager();
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
                echo "board_turn";
                $this->rollDice($client, $value);
                break;
            default:
                $this->server->sendTextToAllClients($client->getUsername(), $value->message);
        }
    }

    public function rollDice($client, $value) {
        $boardTurn = new BoardTurn($value);

        // TODO: Change player position based on dice

        $message = array('type' => 'board_turn',
            'value' => array(
                "username" => $boardTurn->getUsername(),
                "dice" => $boardTurn->getDice(),
                "player_positions" => $boardTurn->getPlayerPosition()
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
}