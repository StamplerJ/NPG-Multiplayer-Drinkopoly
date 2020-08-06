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

    private $currentPlayerIndex;
    private $gameStarted;

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
        $this->gameStarted = false;
        $this->currentPlayerIndex = 0;

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

    public function handleGame($game, $client) {
        switch ($game) {
            case Games::DRINK:
                $this->sendDrink($client);
                break;
            case Games::SHOT:
                $this->sendShot($client);
                break;
            case Games::CATEGORY:
                $this->playCategoryGame($client);
                break;
            case Games::NEVEREVER:
                $this->playNeverEver($client);
                break;
            default:
        }
    }

    public function sendDrink($client) {
        $message = array('type' => 'drink',
            'value' => array(
                "username" => $client->getUsername(),
                "amount" => 1
            ));
        $this->server->sendMessage($client->getSocket(), $message);
    }

    public function sendShot($client) {
        $message = array('type' => 'shot',
            'value' => array(
                "username" => $client->getUsername(),
                "amount" => 1
            ));
        $this->server->sendMessage($client->getSocket(), $message);
    }

    public function startGame() {
        $this->gameStarted = true;
    }


    public function playCategoryGame($username) {
        $message = array('type' => 'category',
            'value' => array(
                "username" => $username,
                "category" => $this->getCategoryData(),
                "isGameMaster" => $username,
                "nextPlayer" => $this->getNextPlayer()
            ));
        $this->server->sendMessageToAllClients($message);
    }

    public function playNeverEver($username) {
        $message = array('type' => 'neverever',
            'value' => array(
                "username" => $username,
                "question" => $this->getNeverEverData()
            ));
        $this->server->sendMessageToAllClients($message);
    }

    public function createPlayer($username) {
        $this->players = array_values($this->players);

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
        $random_key = array_rand($this->categories, 1);
        return $this->categories[$random_key[0]];
    }

    public function selectGameMaster() {
        $random_key = array_rand($this->players, 1);
        return $this->players[$random_key[0]];
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

    public function getNextPlayer() {
        $this->players = array_values($this->players);

        $this->currentPlayerIndex++;

        if($this->currentPlayerIndex >= count($this->players))
            $this->currentPlayerIndex = 0;

        if($this->players[$this->currentPlayerIndex] !== null)
            return $this->players[$this->currentPlayerIndex]->getName();
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

    public function isGameStarted()
    {
        return $this->gameStarted;
    }

    public function setGameStarted($gameStarted)
    {
        $this->gameStarted = $gameStarted;
    }
}