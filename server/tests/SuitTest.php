<?php

require_once "../model/Card.php";

use PHPUnit\Framework\TestCase;
use poker_model\Suit;

class SuitTest extends TestCase
{

    public function testCompare()
    {
        $this->assertSame(Suit::compare(Suit::$DIAMONDS, Suit::$DIAMONDS), 0);
        $this->assertSame(Suit::compare(Suit::$DIAMONDS, Suit::$HEARTS), -1);
        $this->assertSame(Suit::compare(Suit::$DIAMONDS, Suit::$SPADES), -1);
        $this->assertSame(Suit::compare(Suit::$DIAMONDS, Suit::$CLUBS), -1);

        $this->assertSame(Suit::compare(Suit::$HEARTS, Suit::$DIAMONDS), 1);
        $this->assertSame(Suit::compare(Suit::$HEARTS, Suit::$HEARTS), 0);
        $this->assertSame(Suit::compare(Suit::$HEARTS, Suit::$SPADES), -1);
        $this->assertSame(Suit::compare(Suit::$HEARTS, Suit::$CLUBS), -1);

        $this->assertSame(Suit::compare(Suit::$SPADES, Suit::$DIAMONDS), 1);
        $this->assertSame(Suit::compare(Suit::$SPADES, Suit::$HEARTS), 1);
        $this->assertSame(Suit::compare(Suit::$SPADES, Suit::$SPADES), 0);
        $this->assertSame(Suit::compare(Suit::$SPADES, Suit::$CLUBS), -1);

        $this->assertSame(Suit::compare(Suit::$CLUBS, Suit::$DIAMONDS), 1);
        $this->assertSame(Suit::compare(Suit::$CLUBS, Suit::$HEARTS), 1);
        $this->assertSame(Suit::compare(Suit::$CLUBS, Suit::$SPADES), 1);
        $this->assertSame(Suit::compare(Suit::$CLUBS, Suit::$CLUBS), 0);
    }
}
