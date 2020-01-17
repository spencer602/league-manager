<?php

class Player
{
    public $id;
    public $name;
    public $points;
    public $gamesPlayed;
    public $gamesWon;
    public $matchesPlayed;
    public $matchesWon;
    public $eros;

    function __construct($id, $name, $points, $gamesPlayed, $gamesWon, $matchesPlayed, $matchesWon, $eros)
    {
        $this->name = $name;
        $this->id = $id;
        $this->points = $points;
        $this->gamesPlayed = $gamesPlayed;
        $this->gamesWon = $gamesWon;
        $this->matchesPlayed = $matchesPlayed;
        $this->matchesWon = $matchesWon;
        $this->eros = $eros;
    }

    function getMatchPercentage() {
        if ($this->matchesPlayed == 0) return -1;
        return $this->matchesWon/$this->matchesPlayed * 100.0;
    }

    function getWinPercentage() {
        if ($this->gamesPlayed == 0) return -1;
        return $this->gamesWon/$this->gamesPlayed * 100.0;
    }
}