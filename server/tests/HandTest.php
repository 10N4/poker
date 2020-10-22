<?php


use PHPUnit\Framework\TestCase;
use poker_model\Card;
use poker_model\Hand;
use poker_model\Rank;
use poker_model\Suit;

require_once "../model/Card.php";
require_once "../model/Hand.php";

class HandTest extends TestCase
{

    public function testGetLowestCard()
    {

    }

    public function testSort()
    {

    }

    public function testGetHighestCard()
    {

    }

    public function testIsSorted()
    {
        $card1 = new Card(Rank::$TWO, Suit::$SPADES);
        $card2 = new Card(Rank::$ACE, Suit::$CLUBS);
        $card3 = new Card(Rank::$FIVE, Suit::$CLUBS);
        $card4 = new Card(Rank::$JACK, Suit::$DIAMONDS);
        $card5 = new Card(Rank::$SEVEN, Suit::$SPADES);
        $card6 = new Card(Rank::$FOUR, Suit::$DIAMONDS);
        $card7 = new Card(Rank::$TWO, Suit::$DIAMONDS);
        $cards = [$card1, $card2, $card3, $card4, $card5, $card6, $card7];
        $hand = new Hand($cards);

        $this->assertSame($hand->isSorted(), false);
        $hand->sort();
        /*$this->assertSame($hand->isSorted(), true);

        $sortedBySuit = $hand->getSortedBySuit();
        $sortedByRank = $hand->getSortedByRank();

        $this->assertEqual($sortedBySuit, [$card2, $card3, $card5, $card1, $card4, $card6, $card7]);*/
    }
}
