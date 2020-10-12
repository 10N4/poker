<?php

use poker_model\Player;

class Showdown
{
    private array $players;
    private array $cardsOnTable;

    public function __construct(array $players, array $cardsOnTable)
    {
        $this->players = $players;
        $this->cardsOnTable = $cardsOnTable;
    }

    /**
     * @return array|int[]|string[] int array containing the player ids with the highest hands
     */
    public function showdown(): array
    {
        $hands = $this->returnHands();
        $highestPlayerIds = [];
        $highestHand = 0;

        /** @var Hand $hand */
        foreach ($hands as $playerId => $hand) {
            $value = HandChecker::getValueOfHand($hand);

            if ($value > $highestHand) {
                $highestHand = $value;
                $highestPlayerIds = [$playerId];
            } elseif ($value == $highestHand) {
                $highestPlayerIds[] = $playerId;
            }
        }

        return $highestPlayerIds;
    }

    private function returnHands(): array
    {
        $hands = [];

        /** @var Player $player */
        foreach ($this->players as $player) {
            $hands[$player->getId()] = new Hand(array_merge($this->cardsOnTable, $player->getCards()));
        }

        return $hands;
    }
}
