<?php
class NeverEver extends Games
{
    private $answer;

    public function __construct($value)
    {
        parent::__construct($value);

        $this->answer = $value->answer;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getFinished()
    {
        return $this->finished;
    }
}