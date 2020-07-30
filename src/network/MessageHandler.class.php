<?php

require_once("Server.class.php");
require_once(__DIR__."/../model/Login.class.php");

class MessageHandler
{
    private $SERVER_NAME = "Server";
    private $LOGIN_MESSAGE = "%s has joined the server";

    private $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function login($client, $value)
    {
        $login = new Login($value);
        $this->server->sendTextToAllClients($this->SERVER_NAME, sprintf($this->LOGIN_MESSAGE, $login->getUsername()));

        $message = array('type' => 'login',
            'value' => array(
                'successful' => true,
                'username' => $login->getUsername(),
                'message' => "",
                'board' => $this->server->getGameManager()->getFieldsData(),
                'players' => $this->server->getGameManager()->getPlayersData()
            ));
        $this->server->sendMessage($client->getSocket(), $message);
    }
}