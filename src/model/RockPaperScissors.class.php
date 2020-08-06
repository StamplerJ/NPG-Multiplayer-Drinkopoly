<?php

require_once(__DIR__."/../model/TwoPlayerGame.php");

class RockPaperScissors extends TwoPlayerGame
{
    private $type = Games::ROCKPAPERSCISSORS;

    private $handPlayerOne;
    private $handPlayerTwo;

    public function __construct($value)
    {
        parent::__construct($value);

        $this->handPlayerOne = isset($value->handPlayerOne) ? $value->handPlayerOne : "";
        $this->handPlayerTwo = isset($value->handPlayerTwo) ? $value->handPlayerTwo : "";
    }

    public function getFinished()
    {
        return $this->handPlayerOne != "" && $this->handPlayerTwo != "";
    }

    public function getWinner() {
        if ($this->handPlayerOne === $this->handPlayerTwo)
            return "tie";

        if ($this->handPlayerOne === "rock") {
            if ($this->handPlayerTwo === "paper")
                return $this->playerTwo;
            return $this->playerOne;
        }

        if ($this->handPlayerOne === "paper") {
            if ($this->handPlayerTwo === "scissors")
                return $this->playerTwo;
            return $this->playerOne;
        }

        if ($this->handPlayerOne === "scissors") {
            if ($this->handPlayerTwo == "rock")
                return $this->playerTwo;
            return $this->playerOne;
        }
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

    public function getHandPlayerOne()
    {
        return $this->handPlayerOne;
    }

    public function setHandPlayerOne($handPlayerOne)
    {
        $this->handPlayerOne = $handPlayerOne;
    }

    public function getHandPlayerTwo()
    {
        return $this->handPlayerTwo;
    }

    public function setHandPlayerTwo($handPlayerTwo)
    {
        $this->handPlayerTwo = $handPlayerTwo;
    }
}