<?php


namespace poker_model;

/**
 *
 * Class Card
 * @package poker_model
 */
class Card
{
    /*public const COLOR_DIAMONDS = 'd';
    public const COLOR_HEARTS = 'h';
    public const COLOR_SPADES = 's';
    public const COLOR_CLUBS = 'c'; */
    public const REP_NO_CARD = 0;

    private Rank $rank; // "Number"
    private Suit $suit; // "Color"

    public function __construct($rank, $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
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

        // Both objects must be equal
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

        // Both objects must be equal
        return 0;
    }

    public function getSuit(): Suit
    {
        return $this->suit;
    }

    public function setSuit(Suit $suit): void
    {
        $this->suit = $suit;
    }

    public function getRank(): Rank
    {
        return $this->rank;
    }

    public function setRank(Rank $number): void
    {
        $this->number = $number;
    }

    public static function getAllSuits(): array
    {
        return array(Suit::DIAMONDS, Suit::HEARTS, Suit::SPADES, Suit::CLUBS);
    }

    /**
     * Creates a Card from a Card-representation
     * @param string $rep
     * @return Card
     * @throws ParseException
     */
    public static function parse(string $rep): Card // Todo: Rep must contain numbers for Suit instead of characters
    {
        $colors = implode('', self::getAllSuits());
        if (preg_match("/^[$colors][2-9]|(1[0-4])$/", $rep)) {
            $color = $rep[0];
            $number = substr($rep, 1, strlen($rep));
            return new Card($number, $color);
        }

        throw new ParseException();
    }

    public function __toString()
    {
        return $this->getSuit() . " " . $this->getRank();
    }
}

abstract class Suit
{
    const DIAMONDS = 0; // Karo
    const HEARTS = 1;   // Herz
    const SPADES = 2;   // Piek
    const CLUBS = 3;    // Kreuz
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