<?php
class Category extends Game
{
    private $type = Games::CATEGORY;

    private $isGameMaster;
    private $category;

    public function __construct($value)
    {
        parent::__construct($value);

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