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
    public $phoneNumber;

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
     * @param $phoneNumber
     */
    public function __construct($id, $name, $rank, $points, $gamesPlayed, $gamesWon, $matchesPlayed, $matchesWon, $eros, $phoneNumber)
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
        $this->phoneNumber = $phoneNumber;
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