<?php

class Player
{
    public $id;
    public $name;
    public $rank;
    public $points;
    public $gamesPlayed;
    public $gamesWon;
    public $matchesPlayed;
    public $matchesWon;
    public $eros;

    /**
     * Player constructor.
     * @param $id
     * @param $name
     * @param $rank
     * @param $points
     * @param $gamesPlayed
     * @param $gamesWon
     * @param $matchesPlayed
     * @param $matchesWon
     * @param $eros
     */
    public function __construct($id, $name, $rank, $points, $gamesPlayed, $gamesWon, $matchesPlayed, $matchesWon, $eros)
    {
        $this->id = $id;
        $this->name = $name;
        $this->rank = $rank;
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