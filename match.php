<?php

class Match
{
    public $player1id;
    public $player2id;
    public $locationID;
    public $seasonID;
    public $p1GamesNeeded;
    public $p1GamesWon;
    public $p1ERO;
    public $p2GamesNeeded;
    public $p2GamesWon;
    public $p2ERO;
    public $p1rank;
    public $p2rank;
    public $timestamp;
    public $matchID;
    public $paid;
    public $p1pointsWagered;
    public $p2pointsWagered;
    public $round;

    /**
     * Match constructor.
     * @param $player1id
     * @param $player2id
     * @param $locationID
     * @param $seasonID
     * @param $p1GamesNeeded
     * @param $p1GamesWon
     * @param $p1ERO
     * @param $p2GamesNeeded
     * @param $p2GamesWon
     * @param $p2ERO
     * @param $p1rank;
     * @param $p2rank;
     * @param $timestamp;
     * @param $matchID;
     * @param $paid;
     * @param $p1pointsWagered;
     * @param $p2pointsWagered;
     * @param $round;
     */
    public function __construct($player1id, $player2id, $locationID, $seasonID, $p1GamesNeeded, $p1GamesWon, $p1ERO,
                                $p2GamesNeeded, $p2GamesWon, $p2ERO, $p1rank, $p2rank, $timestamp, $matchID, $paid,
                                $p1pointsWagered, $p2pointsWagered, $round) {
        $this->player1id = $player1id;
        $this->player2id = $player2id;
        $this->locationID = $locationID;
        $this->seasonID = $seasonID;
        $this->p1GamesNeeded = $p1GamesNeeded;
        $this->p1GamesWon = $p1GamesWon;
        $this->p1ERO = $p1ERO;
        $this->p2GamesNeeded = $p2GamesNeeded;
        $this->p2GamesWon = $p2GamesWon;
        $this->p2ERO = $p2ERO;
        $this->p1rank = $p1rank;
        $this->p2rank = $p2rank;
        $this->timestamp = $timestamp;
        $this->matchID = $matchID;
        $this->paid = $paid;
        $this->p1pointsWagered = $p1pointsWagered;
        $this->p2pointsWagered = $p2pointsWagered;
        $this->round = $round;
    }

    function getWinnerData() {
        // p1 is winner
        if ($this->p1GamesWon == $this->p1GamesNeeded) {
            $winner = [$this->player1id, $this->p1GamesWon, $this->p1GamesNeeded, $this->p1ERO, $this->p1rank,
                $this->p2pointsWagered];
            return $winner;
        // p2 is winner
        } else if ($this->p2GamesWon == $this->p2GamesNeeded) {
            $winner = [$this->player2id, $this->p2GamesWon, $this->p2GamesNeeded, $this->p2ERO, $this->p2rank,
                $this->p1pointsWagered];
            return $winner;
        }
        echo 'error in getWinnerData, return null!';
        return null;
    }

    function getLoserData() {
        // p2 is loser
        if ($this->p1GamesWon == $this->p1GamesNeeded) {
            $loser = [$this->player2id, $this->p2GamesWon, $this->p2GamesNeeded, $this->p2ERO, $this->p2rank,
            $this->p2pointsWagered];
            return $loser;
        // p1 is loser
        } else if ($this->p2GamesWon == $this->p2GamesNeeded) {
            $loser = [$this->player1id, $this->p1GamesWon, $this->p1GamesNeeded, $this->p1ERO, $this->p1rank,
                $this->p1pointsWagered];
            return $loser;
        }
        echo 'error in getLoserData, return null!';
        return null;
    }
}