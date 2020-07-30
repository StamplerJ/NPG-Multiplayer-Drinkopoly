<?php
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

        $this->playerOne = $value->playerOne;
        $this->playerTwo = $value->playerTwo;
        $this->playerOnePosition = $value->playerOnePosition;
        $this->playerTwoPosition = $value->playerTwoPosition;
        $this->winner = $value->winner;
        $this->score = $value->score;
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