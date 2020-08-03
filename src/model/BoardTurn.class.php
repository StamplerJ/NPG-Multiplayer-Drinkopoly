<?php
class BoardTurn
{
    private $username;
    private $dice;
    private $player_positions;

    public function __construct($value)
    {
        $this->username = $value->username;
        $this->player_positions = $value->player_positions;

        if($value->dice != null) {
            $this->dice = $value->dice;
        }
        else {
            try {
                $this->dice = random_int(1, 6);
            } catch (Exception $e) {
                echo $e;
            }
        }
    }

    public function getPlayerPositionsData() {
        $data = array();

        foreach ($this->player_positions as $player)
            $data[] = $player->getData();

        return $data;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getDice()
    {
        return $this->dice;
    }

    public function getPlayerPositions()
    {
        return $this->player_positions;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setDice($dice)
    {
        $this->dice = $dice;
    }

    public function setPlayerPositions($player_positions)
    {
        $this->player_positions = $player_positions;
    }
}