<?php
class shotAndDrink
{
    //TODO parent class to distribute drinks
    private $amount;
    private $username;

    public function __construct($value)
    {
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