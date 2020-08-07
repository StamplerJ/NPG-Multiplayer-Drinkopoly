<?php

require_once(__DIR__ . "/../model/Game.class.php");

class TwoPlayerGame extends Game
{
    protected $playerOne;
    protected $playerTwo;
    protected $playerOnePosition;
    protected $playerTwoPosition;
    protected $winner;
    protected $score;

    public function __construct($value)
    {
        parent::__construct($value);

        $this->playerOne = isset($value->playerOne) ? $value->playerOne : "";
        $this->playerTwo = isset($value->playerTwo) ? $value->playerTwo : "";
        $this->playerOnePosition = isset($value->playerOnePosition) ? $value->playerOnePosition : "";
        $this->playerTwoPosition = isset($value->playerTwoPosition) ? $value->playerTwoPosition : "";
        $this->winner = isset($value->winner) ? $value->winner : "";
        $this->score = isset($value->score) ? $value->score : "";
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getWinner()
    {
        return $this->winner;
    }

    public function getPlayerOne()
    {
        return $this->playerOne;
    }

    public function getPlayerTwo()
    {
        return $this->playerTwo;
    }

    public function getTurn()
    {
        return $this->turn;
    }

    public function getPlayerOnePosition()
    {
        return $this->playerOnePosition;
    }

    public function getPlayerTwoPosition()
    {
        return $this->playerTwoPosition;
    }

    public function getScore()
    {
        return $this->score;
    }
}