<?php

require_once("Server.class.php");
require_once(__DIR__."/../model/BoardField.class.php");
require_once(__DIR__."/../model/Player.class.php");
require_once(__DIR__."/../model/enums/Games.class.php");

class GameManager
{
    public static $FIELD_COUNT = 20;

    private $server;

    private $fields;
    private $players;
    private $categories;
    private $neverEverQuestions;

    public function __construct($server)
    {
        $this->server = $server;

        $this->fields = array();
        $this->fields[] = new BoardField(0, "Start", "");
        $this->fields[] = new BoardField(2, "Tic Tac Toe", Games::TICTACTOE);
        $this->fields[] = new BoardField(3, "Drink", Games::DRINK);
        $this->fields[] = new BoardField(4, "Shot", Games::SHOT);
        $this->fields[] = new BoardField(6, "Rock Paper Scissors", Games::ROCKPAPERSCISSORS);
        $this->fields[] = new BoardField(8, "Shot", Games::SHOT);
        $this->fields[] = new BoardField(9, "Pong", Games::PONG);
        $this->fields[] = new BoardField(11, "Drink", Games::DRINK);
        $this->fields[] = new BoardField(13, "Never Have I Ever", Games::NEVEREVER);
        $this->fields[] = new BoardField(14, "Drink", Games::DRINK);
        $this->fields[] = new BoardField(16, "Shot", Games::SHOT);
        $this->fields[] = new BoardField(19, "Category", Games::CATEGORY);

        $this->players = array();

        $this->categories = array();
        $this->categories[] = "Autos";
        $this->categories[] = "Speisen";
        $this->categories[] = "Getränke";
        $this->categories[] = "Ballsportarten";
        $this->categories[] = "Bier Marken";

        $this->neverEverQuestions = array();
        $this->neverEverQuestions[] = "Ich habe noch nie gestohlen.";
        $this->neverEverQuestions[] = "Ich habe mich noch nie geschlagen.";
        $this->neverEverQuestions[] = "Ich habe noch nie Blut gespendet.";
        $this->neverEverQuestions[] = "Ich habe noch nie den Bruder oder die Schwester eines Freundes begehrt.";
        $this->neverEverQuestions[] = "Ich habe noch nie einen Kontinent-Übergreifenden Krieg mit einer Weltmacht angezettelt.";

    }

    public function handleGame($game, $username) {
        switch ($game) {
            case Games::DRINK:
                $this->sendDrink($username);
                break;
            default:
        }
    }

    public function sendDrink($username) {
        $message = array('type' => 'drink',
            'value' => array(
                "username" => $username,
                "amount" => 1
            ));
        $this->server->sendMessageToAllClients($message);
    }

    public function createPlayer($username) {
        $player = new Player($username, 0, sprintf('#%06X', mt_rand(0, 0xFFFFFF)));
        $this->players[] = $player;

        return $player;
    }

    public function getFieldsData() {
        $data = array();

        foreach ($this->fields as $field)
            $data[] = $field->getData();

        return $data;
    }

    public function getPlayersData() {
        $data = array();

        foreach ($this->players as $player)
            $data[] = $player->getData();

        return $data;
    }

    public function getCategoryData() {
        $data = array();

        foreach ($this->categories as $category)
            $data[] = $category->getData();

        return $data;
    }

    public function selectGameMaster() {
        return $this->players[Math.floor(Math.random() * players.length)].name;
    }

    public function getNeverEverData() {
        $data = array();

        foreach ($this->neverEverQuestions as $neverEver)
            $data[] = $neverEver->getData();

        return $data;
    }

    public function findField($fieldIndex) {
        foreach ($this->fields as $field) {
            if($fieldIndex == $field->getIndex())
                return $field;
        }
        return new BoardField($fieldIndex, "", "");
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function getPlayers()
    {
        return $this->players;
    }

    public function setPlayers($players)
    {
        $this->players = $players;
    }
}