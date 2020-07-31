<?php
class BoardTurn
{
    private $username;
    private $turn;
    private $dice;
    private $player_position;

    public function __construct($value)
    {
        $this->username = $value->username;
        $this->turn = $value->turn;
        $this->player_position = $value->player_position;

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
}