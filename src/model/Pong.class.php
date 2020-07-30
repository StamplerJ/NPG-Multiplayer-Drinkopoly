<?php
class Pong extends TwoPlayerGame
{
    private $type = Games::PONG;

    protected $ballPosition;

    public function __construct($value)
    {
        parent::__construct($value);

        $this->ballPosition = $value->ballPosition;
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

    public function getWinner()
    {
        return $this->winner;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function getBallPosition()
    {
        return $this->ballPosition;
    }
}