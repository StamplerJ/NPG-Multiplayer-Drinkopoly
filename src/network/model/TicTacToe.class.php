<?php
class TicTacToe extends TwoPlayerGame
{
    private $type = Games::TICTACTOE;

    public function __construct($value)
    {
        parent::__construct($value);
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

}