<?php
class Category extends Games
{
    private $correctAnswer;
    private $amount;
    private $isGameMaster;

    public function __construct($value)
    {
        parent::__construct($value);

        $this->correctAnswer = $value->correctAnswer;
        $this->amount = $value->amount;
        $this->isGameMaster = $value->isGameMaster;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getCorrectAnswer()
    {
        return $this->correctAnswer;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getIsGameMaster()
    {
        return $this->isGameMaster;
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