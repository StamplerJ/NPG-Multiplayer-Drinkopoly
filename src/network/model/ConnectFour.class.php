<?php
class ConnectFour extends TwoPlayerGame
{
    private $type = Games::CONNECTFOUR;

    public function __construct($value)
    {
        parent::__construct($value);
    }

    public function getWinner()
    {
        return $this->winner;
    }

    public function getTurn()
    {
        return $this->turn;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getPlayerOne()
    {
        return $this->playerOne;
    }

    public function getPlayerTwo()
    {
        return $this->playerTwo;
    }

    public function getPlayerOnePosition()
    {
        return $this->playerOnePosition;
    }

    public function getPlayerTwoPosition()
    {
        return $this->playerTwoPosition;
    }

}