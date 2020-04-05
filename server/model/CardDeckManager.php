<?php


namespace poker_model;
require_once "Card.php";


class CardDeckManager
{
    private $allCards = array();

    /**
     * CardDeck constructor.
     */
    public function __construct()
    {
        for ($i = 2; $i <= 14; $i++) {
            foreach (Card::getAllColors() as $color) {
                $this->allCards[] = new Card($i, $color);
            }
        }
    }

    public function getRandomCardsBySession($sessionId, $number)
    {
        return $this->getRandomCards($number);
        /** @var Session $session */
        $session = Session::loadById($sessionId);
        /** @var Player $players */
        $players = Player::load(Player::SESSION_ID, $sessionId);

        $usedCards = array_merge($session->getCards(), $players->getCards());

        return $this->getRandomCards($number, $usedCards);
    }

    public function getRandomCard($usedCards = array()): Card
    {
        return $this->getRandomCards(1, $usedCards)[0];
    }

    public function getRandomCards($number, $usedCards = array())
    {
        $reducedCards = $this->allCards;
        foreach ($usedCards as $usedCard) {
            $key = array_search($usedCard, $reducedCards);
            if ($key === false) {
                dieFatalError("bede4afb-e006-442e-aaf8-4a5fd658535c");
            }
            $reducedCards = arrayDeleteElement($reducedCards, $key);
        }
        $resultCards = array();
        for ($i = 0; $i < $number; $i++) {
            $cardNum = count($reducedCards);
            if ($cardNum == 0) {
                return $resultCards;
            }
            $cardIndex = rand(0, $cardNum - 1);
            $resultCards[] = $reducedCards[$cardIndex];
            $reducedCards = arrayDeleteElement($reducedCards, $cardIndex);
        }

        return $resultCards;
    }
}