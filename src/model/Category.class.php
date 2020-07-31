<?php
class Category extends Game
{
    private $type = Games::CATEGORY;

    private $amount;
    private $isGameMaster;
    private $category;

    public function __construct($value)
    {
        parent::__construct($value);

        $this->amount = $value->amount;
        $this->isGameMaster = $value->isGameMaster;
        $this->category = $value->category;
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

    public function getCategory()
    {
        return $this->category;
    }

}