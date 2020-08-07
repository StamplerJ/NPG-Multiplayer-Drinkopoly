<?php
class ShotAndDrink
{
    //TODO parent class to distribute drinks
    private $type;
    private $amount;
    private $username;

    public function __construct($value)
    {
        $this->type = $value->type;
        $this->amount = $value->amount;
        $this->username = $value->username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getAmount()
    {
        return $this->amount;
    }

}