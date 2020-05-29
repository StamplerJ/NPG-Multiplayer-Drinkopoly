<?php
class Games
{
    protected $username;
    protected $time;
    protected $message;
    protected $turn;
    protected $finished;

    public function __construct($value)
    {
        $this->username = $value->username;
        $this->time = $value->time;
        $this->message = $value->message;
        $this->turn = $value->turn;
        $this->finished = $value->finished;
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