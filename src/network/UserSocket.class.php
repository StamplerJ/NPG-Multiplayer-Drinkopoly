<?php
class UserSocket
{
    private $username;
    private $socket;

    public function __construct($socket, $username = "EMPTY USERNAME")
    {
        $this->socket = $socket;
        $this->username = $username;
    }

    public function __unset($name)
    {
        echo "Unset socket";
        unset($socket);
    }


    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getSocket()
    {
        return $this->socket;
    }

    public function setSocket($socket)
    {
        $this->socket = $socket;
    }
}