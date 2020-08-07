<?php
class Game
{
    protected $username;
    protected $time;
    protected $message;
    protected $turn;
    protected $finished;

    public function __construct($value)
    {
        $this->username = isset($value->username) ? $value->username : "";
        $this->time = isset($value->time) ? $value->time : "";
        $this->message = isset($value->message) ? $value->message : "";
        $this->turn = isset($value->turn) ? $value->turn : "";
        $this->finished = isset($value->finished) ? $value->finished : "";
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getTurn()
    {
        return $this->turn;
    }

    public function getFinished()
    {
        return $this->finished;
    }

}