<?php

require_once("Server.class.php");
require_once(__DIR__."/../model/BoardField.class.php");
require_once(__DIR__."/../model/Player.class.php");
require_once(__DIR__."/../model/RockPaperScissors.class.php");
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

    private $rockPaperScissors;
    private $neverEverAnswerCounter;

    public function __construct($server)
    {
        $this->server = $server;

        $this->fields = array();
        $this->fields[] = new BoardField(0, "Start", "");
        $this->fields[] = new BoardField(1, "Rock Paper Scissors", Games::ROCKPAPERSCISSORS);
        $this->fields[] = new BoardField(2, "Shot", Games::SHOT);
        $this->fields[] = new BoardField(4, "Never Have I Ever", Games::NEVEREVER);
        $this->fields[] = new BoardField(5, "Drink", Games::DRINK);
        $this->fields[] = new BoardField(7, "Shot", Games::SHOT);
        $this->fields[] = new BoardField(9, "Rock Paper Scissors", Games::ROCKPAPERSCISSORS);
        $this->fields[] = new BoardField(11, "Drink", Games::DRINK);
        $this->fields[] = new BoardField(12, "Category", Games::CATEGORY);
        $this->fields[] = new BoardField(14, "Shot", Games::SHOT);
        $this->fields[] = new BoardField(16, "Category", Games::CATEGORY);
        $this->fields[] = new BoardField(18, "Never Have I Ever", Games::NEVEREVER);
        $this->fields[] = new BoardField(19, "Drink", Games::DRINK);

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
            case Games::ROCKPAPERSCISSORS:
                $this->startRockPaperScissors($client);
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

    public function startRockPaperScissors($client) {
        if(count($this->players) <= 1) {
            $this->server->sendText($client, "Zu wenig Spieler, trinke einen Shot!");
            $this->sendShot($client);
            return;
        }

        $value = (object) array(
            "playerOne" => $client->getUsername(),
            "playerTwo" => $this->getRandomPlayer($client->getPlayer())->getName()
        );

        $this->rockPaperScissors = new RockPaperScissors($value);

        $message = array('type' => Games::ROCKPAPERSCISSORS,
            'value' => array(
                "message" => "Wir spielen Schere, Stein, Papier!",
                "playerOne" => $this->rockPaperScissors->getPlayerOne(),
                "playerTwo" => $this->getRandomPlayer($client->getPlayer())->getName()
        ));
        $this->server->sendMessageToAllClients($message);
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

        $message = array('type' => 'startGame',
            'value' => array(
                'start' => true,
                'username' => $this->players[$this->currentPlayerIndex]->getName(),
                "message" => "Das Spiel startet jetzt und " . $this->players[$this->currentPlayerIndex]->getName() . " beginnt"
            ));
        $this->server->sendMessageToAllClients($message);
    }

    public function stopGame() {
        $this->gameStarted = false;
    }


    public function playCategoryGame($client) {
        $message = array('type' => 'category',
            'value' => array(
                "username" => $client->getUsername(),
                "category" => $this->getCategoryData(),
                "isGameMaster" => $client->getUsername(),
                "nextPlayer" => $this->getCurrentPlayer()
            ));
        $this->server->sendMessageToAllClients($message);
    }

    public function playNeverEver($client) {
        $message = array('type' => 'neverever',
            'value' => array(
                "username" => $client->getUsername(),
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
        return $this->categories[array_rand($this->categories, 1)];
    }

    public function getNeverEverData() {
        return $this->neverEverQuestions[array_rand($this->neverEverQuestions, 1)];
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

    public function getCurrentPlayer() {
        $this->players = array_values($this->players);

        if($this->players[$this->currentPlayerIndex] !== null)
            return $this->players[$this->currentPlayerIndex]->getName();
    }

    public function getLastPlayer() {
        $this->players = array_values($this->players);

        $this->currentPlayerIndex--;

        if($this->currentPlayerIndex < 0)
            $this->currentPlayerIndex = count($this->players) - 1;

        if($this->players[$this->currentPlayerIndex] !== null)
            return $this->players[$this->currentPlayerIndex]->getName();
    }

    public function getRandomPlayer($except = null) {
        if(count($this->players) == 1)
            return $this->players[0];

        $exclude = array($except);
        $data = $this->players;

        $diff = array_udiff($data, $exclude,
            function ($obj_a, $obj_b) {
                if ($obj_a->getName() === $obj_b->getName())
                    return 0;
                else
                    return -1;
            }
        );

        $excluded_data = array_values($diff);
        $rand = rand(0,count($excluded_data)-1);

        if($rand == -1)
            return $excluded_data[0];

        return $excluded_data[$rand];
    }

    public function addNeverEverAnswer() {
        $this->neverEverAnswerCounter++;
    }

    public function isNeverEverFinished() {
        if($this->neverEverAnswerCounter >= count($this->players)) {
            $this->neverEverAnswerCounter = 0;
            return true;
        }
        return false;
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

    public function setRockPaperScissors($rockPaperScissors)
    {
        $this->rockPaperScissors = $rockPaperScissors;
    }

    public function getRockPaperScissors()
    {
        return $this->rockPaperScissors;
    }
}