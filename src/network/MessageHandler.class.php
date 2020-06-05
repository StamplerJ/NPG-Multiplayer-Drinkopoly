<?php

require("Server.class.php");
require("../model/Login.class.php");

class MessageHandler
{
    private $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function login($value)
    {
        $login = new Login($value);
        $this->server->sendTextToAllClients($login->getMessage());
    }
}