<?php
class boardTurn
{
    private $username;
    private $turn;
    private $dice;
    private $destination_event;
    private $player_position;

    public function __construct($value)
    {
        $this->username = $value->username;
        $this->turn = $value->turn;
        $this->dice = $value->dice;
        $this->destination_event = $value->destination_event;
        $this->player_position = $value->player_position;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getDice()
    {
        return $this->dice;
    }

    public function getPlayerPosition()
    {
        return $this->player_position;
    }

    public function getTurn()
    {
        return $this->turn;
    }

    public function getDestinationEvent()
    {
        return $this->destination_event;
    }

}