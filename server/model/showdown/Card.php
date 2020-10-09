<?php

namespace Card;
class Card
{
    protected Suit $suit;
    protected Rank $rank;

    public function __construct(Suit $suit, Rank $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    /**
     * @param Card $that
     * @return int -1 iff $that is deemed larger than this Card,
     *              1 iff $that is deemed lower than this Card and
     *              0 iff $that is deemed equal to this Card
     */
    public function compareByRank(Card $that): int
    {
        // Check for rank first
        if ($this->getRank() < $that->getRank()) {
            return -1;
        }
        if ($this->getRank() > $that->getRank()) {
            return 1;
        }

        // Ranks must be equal, check for suit now
        if ($this->getSuit() < $that->getSuit()) {
            return -1;
        }
        if ($this->getSuit() > $that->getSuit()) {
            return 1;
        }

        // Both objects are equal
        return 0;
    }

    /**
     * @param Card $that
     * @return int -1 iff $that is deemed larger than this Card,
     *              1 iff $that is deemed lower than this Card and
     *              0 iff $that is deemed equal to this Card
     */
    public function compareBySuit(Card $that): int
    {
        // Check for suit first
        if ($this->getSuit() < $that->getSuit()) {
            return -1;
        }
        if ($this->getSuit() > $that->getSuit()) {
            return 1;
        }

        // Suits must be equal, check for rank now
        if ($this->getRank() < $that->getRank()) {
            return -1;
        }
        if ($this->getRank() > $that->getRank()) {
            return 1;
        }

        // Both objects are equal
        return 0;
    }

    public function getSuit()
    {
        return $this->suit;
    }

    public function getRank()
    {
        return $this->rank;
    }
}

abstract class Suit
{
    const DIAMONDS = 0;
    const HEARTS = 1;
    const SPADES = 2;
    const CLUBS = 3;
}

abstract class Rank
{
    const TWO = 2;
    const THREE = 3;
    const FOUR = 4;
    const FIVE = 5;
    const SIX = 6;
    const SEVEN = 7;
    const EIGHT = 8;
    const NINE = 9;
    const TEN = 10;
    const JACK = 11;
    const QUEEN = 12;
    const KING = 13;
    const ACE = 14;
}
