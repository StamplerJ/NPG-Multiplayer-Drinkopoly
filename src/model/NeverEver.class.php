<?php
class NeverEver extends Game
{
    private $type = Games::NEVEREVER;

    private $answer;
    private $question;

    public function __construct($value)
    {
        parent::__construct($value);

        $this->answer = $value->answer;
        $this->question = $value->question;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getFinished()
    {
        return $this->finished;
    }

    public function getQuestion()
    {
        return $this->question;
    }
}