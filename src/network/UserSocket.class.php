<?php
class UserSocket
{
    private $username;
    private $socket;
    private $player;

    public function __construct($socket, $username = "EMPTY USERNAME")
    {
        $this->socket = $socket;
        $this->username = $username;
    }

    public function __unset($name)
    {
        echo "Unset socket";
        unset($socket);

        // TODO: Remove player when exiting
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function setPlayer($player)
    {
        $this->player = $player;
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