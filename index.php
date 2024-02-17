<?php

class Player {
    public $name;
    public $coins;
    public $isBankrupt = false;

    public function __construct($name, $coins) {
        $this->name = $name;
        $this->coins = $coins;
    }

    public function addCoin() {
        if (!$this->isBankrupt) {
            $this->coins++;
        }
    }

    public function removeCoin() {
        if (!$this->isBankrupt && $this->coins >  0) {
            $this->coins--;
        }
    }

    public function isBankrupt() {
        return $this->isBankrupt || $this->coins ==  0;
    }

    public function bankrupt() {
        $this->coins =  0;
        $this->isBankrupt = true;
    }
}

class Game {
    protected $player1;
    protected $player2;
    protected $flips =  0;

    public function __construct(Player $player1, Player $player2) {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    public function flip() {
        return rand(0,  1) ? "орёл" : "решка";
    }

    public function start() {
        while (!$this->player1->isBankrupt() && !$this->player2->isBankrupt()) {
            $this->flips++;
            $result = $this->flip();

            if ($result == 'орёл') {
                $this->player1->addCoin();
                $this->player2->removeCoin();
            } else {
                $this->player1->removeCoin();
                $this->player2->addCoin();
            }

            if ($this->player1->isBankrupt()) {
                $this->player1->bankrupt();
                return $this->getGameResult($this->player2, $this->player1);
            } elseif ($this->player2->isBankrupt()) {
                $this->player2->bankrupt();
                return $this->getGameResult($this->player1, $this->player2);
            }
        }
    }

    public function getGameResult(Player $winner, Player $loser) {
        return "Game over.\n" . $winner->name . " победил! C мешком в " . $winner->coins . " монет "."\n".
            $loser->name . " обанкротился. Осталось монет: " . $loser->coins . "\n".
            "Количество подбрасываний: " . $this->flips . "\n" ;
    }
}

$game = new Game(
    new Player("Joe",  100),
    new Player('Jane',  100)
);

echo $game->start();
