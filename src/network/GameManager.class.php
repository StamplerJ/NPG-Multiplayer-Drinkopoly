<?php

require_once("Server.class.php");
require_once(__DIR__."/../model/BoardField.class.php");
require_once(__DIR__."/../model/Player.class.php");
require_once(__DIR__."/../model/enums/Games.class.php");

class GameManager
{
    private $fields;
    private $players;

    public function __construct()
    {
        $this->fields = array();
        $this->fields[] = new BoardField(0, "Start", "");
        $this->fields[] = new BoardField(2, "Tic Tac Toe", Games::TICTACTOE);
        $this->fields[] = new BoardField(3, "Drink (1)", Games::SHOTANDDRINK);
        $this->fields[] = new BoardField(4, "Shot (1)", Games::SHOTANDDRINK);
        $this->fields[] = new BoardField(6, "Rock Paper Scissors", Games::ROCKPAPERSCISSORS);
        $this->fields[] = new BoardField(8, "Shot (1)", Games::SHOTANDDRINK);
        $this->fields[] = new BoardField(9, "Pong", Games::PONG);
        $this->fields[] = new BoardField(11, "Drink (1)", Games::SHOTANDDRINK);
        $this->fields[] = new BoardField(13, "Never Have I Ever", Games::NEVEREVER);
        $this->fields[] = new BoardField(14, "Drink (1)", Games::SHOTANDDRINK);
        $this->fields[] = new BoardField(16, "Shot (1)", Games::SHOTANDDRINK);
        $this->fields[] = new BoardField(19, "Category", Games::CATEGORY);

        $this->players = array();
        $this->players[] = new Player("Player1", 0, "#ff0011");
        $this->players[] = new Player("Player2", 0, "#33ff11");
        $this->players[] = new Player("Player3", 2, "#3344e1");
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

    public function getFields()
    {
        return $this->fields;
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
    }
}