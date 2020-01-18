<?php

class Match
{
    public $player1;
    public $player2;
    public $locationID;
    public $seasonID;
    public $p1GamesNeeded;
    public $p1GamesWon;
    public $p1ERO;
    public $p2GamesNeeded;
    public $p2GamesWon;
    public $p2ERO;

    /**
     * Match constructor.
     * @param $player1
     * @param $player2
     * @param $locationID
     * @param $seasonID
     * @param $p1GamesNeeded
     * @param $p1GamesWon
     * @param $p1ERO
     * @param $p2GamesNeeded
     * @param $p2GamesWon
     * @param $p2ERO
     */
    public function __construct($player1, $player2, $locationID, $seasonID, $p1GamesNeeded, $p1GamesWon, $p1ERO, $p2GamesNeeded, $p2GamesWon, $p2ERO)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->locationID = $locationID;
        $this->seasonID = $seasonID;
        $this->p1GamesNeeded = $p1GamesNeeded;
        $this->p1GamesWon = $p1GamesWon;
        $this->p1ERO = $p1ERO;
        $this->p2GamesNeeded = $p2GamesNeeded;
        $this->p2GamesWon = $p2GamesWon;
        $this->p2ERO = $p2ERO;
    }


}