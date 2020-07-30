<?php

require_once(__DIR__."/../model/Player.class.php");

class BoardField
{
    private $index;
    private $text;
    private $game;
    private $players;

    public function __construct($index, $text, $game, $players)
    {
        $this->index = $index;
        $this->text = $text;
        $this->game = $game;
        $this->players = $players;
    }

    public function addPlayer($player) {
        $this->players[] = $player;
    }

    public function removePlayer($player) {
        $key = array_search($this->players, $player);
        if ($key !== false) {
            unset($this->players[$key]);
        }
    }

    public function getData() {
        $playersData = array();
        foreach ($this->players as $player) {
            $temp = array(
                'name' => 'Player1',
                'fieldIndex' => $this->index,
                'color' => '#ff0011'
            );
            $playersData[] = $temp;
        }

        return array(
                'index' => $this->index,
                'text' => $this->text,
                'game' => $this->game,
                'players' => $playersData
            );
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex($index)
    {
        $this->index = $index;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getGame()
    {
        return $this->game;
    }

    public function setGame($game)
    {
        $this->game = $game;
    }
}