<?php

namespace App\Game;

class Bank extends Player
{
    public function __construct()
    {
        parent::__construct();
    }

    public function makeDecision(): bool
    {
        $drawAgain = false;
        $currentPoints = $this->calcPoints();

        if ($currentPoints < 17) {
            $drawAgain = true;
        }
        return $drawAgain;
    }
}
