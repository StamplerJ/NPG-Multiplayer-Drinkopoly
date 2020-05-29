<?php
class RockPaperScissors extends TwoPlayerGames
{
    private $hand;

    public function __construct($value)
    {
        parent::__construct($value);

        $this->hand = $value->hand;
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

    public function getWinner()
    {
        return $this->winner;
    }

    public function getHand()
    {
        return $this->hand;
    }

}