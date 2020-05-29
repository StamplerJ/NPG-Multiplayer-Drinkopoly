<?php
class chat
{
    private $username;
    private $message;

    public function __construct($value)
    {
        $this->username = $value->username;
        $this->message = $value->message;
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