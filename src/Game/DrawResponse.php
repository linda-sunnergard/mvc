<?php

namespace App\Game;

use App\Cards\CardGraphic;

class DrawResponse
{
    public $card;
    public $currentPoints;

    public function __construct(CardGraphic $card, int $currentPoints)
    {
        $this->card = $card;
        $this->currentPoints = $currentPoints;
    }
}
