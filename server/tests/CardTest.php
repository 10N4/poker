<?php

require_once "../model/Card.php";

use PHPUnit\Framework\TestCase;
use poker_model\Card;
use poker_model\Rank;
use poker_model\Suit;

class CardTest extends TestCase
{

    public function testCompareBySuit()
    {
        $card1 = new Card(Rank::$TWO, Suit::$DIAMONDS);
        $card2 = new Card(Rank::$TWO, Suit::$DIAMONDS);
        $this->assertSame($card1->compareBySuit($card2), 0);
        $this->assertSame($card2->compareBySuit($card1), 0);
        $this->assertSame($card1->compareBySuit($card1), 0);
        $this->assertSame($card2->compareBySuit($card2), 0);

        $card1 = new Card(Rank::$TWO, Suit::$DIAMONDS);
        $card2 = new Card(Rank::$TWO, Suit::$HEARTS);
        $this->assertSame($card1->compareBySuit($card2), -1);
        $this->assertSame($card2->compareBySuit($card1), 1);

        $card1 = new Card(Rank::$TWO, Suit::$DIAMONDS);
        $card2 = new Card(Rank::$TWO, Suit::$SPADES);
        $this->assertSame($card1->compareBySuit($card2), -1);
        $this->assertSame($card2->compareBySuit($card1), 1);

        $card1 = new Card(Rank::$TWO, Suit::$DIAMONDS);
        $card2 = new Card(Rank::$TWO, Suit::$CLUBS);
        $this->assertSame($card1->compareBySuit($card2), -1);
        $this->assertSame($card2->compareBySuit($card1), 1);

        $card1 = new Card(Rank::$TWO, Suit::$HEARTS);
        $card2 = new Card(Rank::$TWO, Suit::$SPADES);
        $this->assertSame($card1->compareBySuit($card2), -1);
        $this->assertSame($card2->compareBySuit($card1), 1);

        $card1 = new Card(Rank::$TWO, Suit::$HEARTS);
        $card2 = new Card(Rank::$TWO, Suit::$CLUBS);
        $this->assertSame($card1->compareBySuit($card2), -1);
        $this->assertSame($card2->compareBySuit($card1), 1);

        $card1 = new Card(Rank::$TWO, Suit::$SPADES);
        $card2 = new Card(Rank::$TWO, Suit::$CLUBS);
        $this->assertSame($card1->compareBySuit($card2), -1);
        $this->assertSame($card2->compareBySuit($card1), 1);

        $card1 = new Card(Rank::$TWO, Suit::$SPADES);
        $card2 = new Card(Rank::$TEN, Suit::$SPADES);
        $this->assertSame($card1->compareBySuit($card2), -1);
        $this->assertSame($card2->compareBySuit($card1), 1);
    }

    public function testCompareByRank()
    {
        $card1 = new Card(Rank::$TWO, Suit::$DIAMONDS);
        $card2 = new Card(Rank::$TWO, Suit::$DIAMONDS);
        $this->assertSame($card1->compareBySuit($card2), 0);
        $this->assertSame($card2->compareBySuit($card1), 0);
        $this->assertSame($card1->compareBySuit($card1), 0);
        $this->assertSame($card2->compareBySuit($card2), 0);

        $card1 = new Card(Rank::$TWO, Suit::$DIAMONDS);
        $card2 = new Card(Rank::$THREE, Suit::$DIAMONDS);
        $this->assertSame($card1->compareBySuit($card2), -1);
        $this->assertSame($card2->compareBySuit($card1), 1);

        $card1 = new Card(Rank::$TWO, Suit::$DIAMONDS);
        $card2 = new Card(Rank::$TWO, Suit::$HEARTS);
        $this->assertSame($card1->compareBySuit($card2), -1);
        $this->assertSame($card2->compareBySuit($card1), 1);
    }

    public function testParse()
    {
        // Todo: Implement
        throw new RuntimeException('Not yet implemented!');
    }

    public function testGetAllSuits()
    {
        $this->assertSame(Card::getAllSuits(), array(Suit::$DIAMONDS, Suit::$HEARTS, Suit::$SPADES, Suit::$CLUBS));
    }
}
