<?php
class login
{
    private $successful;
    private $username;
    private $message;


    private function __construct($value)
    {
        $this->successful = $value->successful;
        $this->username = $value->username;
        $this->message = $value->message;
    }

    public function getSuccessful()
    {
        return $this->successful;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getMessage()
    {
        return $this->message;
    }
}