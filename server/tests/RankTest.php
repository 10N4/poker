<?php

require_once "../model/Card.php";

use PHPUnit\Framework\TestCase;
use poker_model\Rank;

class RankTest extends TestCase
{

    public function testCompare()
    {
        $this->assertSame(Rank::compare(Rank::$EIGHT, Rank::$ACE), -1);
        $this->assertSame(Rank::compare(Rank::$TWO, Rank::$TWO), 0);
        $this->assertSame(Rank::compare(Rank::$JACK, Rank::$TEN), 1);
    }
}
