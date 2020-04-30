<?php


namespace poker_model;
require_once "Card.php";


class CardDeckManager
{
    private $allCards = array();

    /**
     * CardDeck constructor.
     * @param array $usedCards
     */
    public function __construct($usedCards = array())
    {
        for ($number = 2; $number <= 14; $number++) {
            foreach (Card::getAllColors() as $color) {
                $card = new Card($number, $color);
                if (array_search($card, $usedCards)) {
                    continue;
                }
                $this->allCards[] = $card;
            }
        }
    }

    /*public function getRandomCardsBySession($sessionId, $number)
    {
        $session = Session::getById($sessionId);
        $players = Player::get(Player::SESSION_ID, $sessionId);

        $usedCards = array_merge($session->getCards(), $players->getCards());

        return $this->getRandomCards($number, $usedCards);
    }*/

    public function getRandomCard(): Card
    {
        return $this->getRandomCards(1)[0];
    }

    public function getRandomCards($number)
    {
        $reducedCards = $this->allCards;
        /*foreach ($usedCards as $usedCard) {
            $key = array_search($usedCard, $reducedCards);
            if ($key === false) {
                dieFatalError("bede4afb-e006-442e-aaf8-4a5fd658535c");
            }
            $reducedCards = arrayDeleteElementByKey($reducedCards, $key);
        }*/
        $resultCards = array();
        for ($i = 0; $i < $number; $i++) {
            $cardNum = count($this->allCards);
            if ($cardNum == 0) {
                return $resultCards;
            }
            $cardIndex = rand(0, $cardNum - 1);
            $resultCards[] = $this->allCards[$cardIndex];
            $this->allCards = arrayDeleteElementByKey($this->allCards, $cardIndex);
        }

        return $resultCards;
    }
}