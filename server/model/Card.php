<?php


namespace poker_model;

// Used to emulate a java-like enum
Suit::init();
Rank::init();

/**
 *
 * Class Card
 * @package poker_model
 */
class Card
{
    public const REP_NO_CARD = 0;

    private Rank $rank; // Number
    private Suit $suit; // Color

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
        if (Rank::compare($this->getRank(), $that->getRank()) == -1) {  // this < that
            return -1;
        }
        if (Rank::compare($this->getRank(), $that->getRank()) == 1) {   // this > that
            return 1;
        }

        // Ranks must be equal, check for suit now
        if (Suit::compare($this->getSuit(), $that->getSuit()) == -1) {  // this < that
            return -1;
        }
        if (Suit::compare($this->getSuit(), $that->getSuit()) == 1) {   // this > that
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
        $suitCompare = Suit::compare($this->getSuit(), $that->getSuit());
        if ($suitCompare != 0) return $suitCompare;
        return Rank::compare($this->getRank(), $that->getRank());



        // Check for suit first
        if (Suit::compare($this->getSuit(), $that->getSuit()) == -1) {  // this < that
            return -1;
        }
        if (Suit::compare($this->getSuit(), $that->getSuit()) == 1) {   // this > that
            return 1;
        }

        // Suits must be equal, check for rank now
        if (Rank::compare($this->getRank(), $that->getRank()) == -1) {  // this < that
            return -1;
        }
        if (Rank::compare($this->getRank(), $that->getRank()) == 1) {   // this > that
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

    public function setRank(Rank $rank): void
    {
        $this->rank = $rank;
    }

    public static function getAllSuits(): array
    {
        return array(Suit::$DIAMONDS, Suit::$HEARTS, Suit::$SPADES, Suit::$CLUBS);
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

class Suit
{
    public static Suit $DIAMONDS;   // Karo
    public static Suit $HEARTS;     // Herz
    public static Suit $SPADES;     // Piek
    public static Suit $CLUBS;      // Kreuz
    private int $value;

    public static function init(): void
    {
        static::$DIAMONDS = new Suit(0);
        static::$HEARTS = new Suit(1);
        static::$SPADES = new Suit(2);
        static::$CLUBS = new Suit(3);
    }

    private function __construct(int $value)
    {
        $this->value = $value;
    }

    public static function compare(Suit $s1, Suit $s2): int     // Todo: Interface Comparator?
    {
        if ($s1->value < $s2->value) {
            return -1;
        }
        if ($s1->value > $s2->value) {
            return 1;
        }

        return 0;
    }

    public function __toString(): string
    {
        switch ($this) {
            case Suit::$DIAMONDS:
                return 'diamonds';
            case Suit::$HEARTS:
                return 'hearts';
            case Suit::$SPADES:
                return 'spades';
            case Suit::$CLUBS:
                return 'clubs';
            default:
                return 'Invalid Suit!';
        }
    }
}

class Rank
{
    public static Rank $TWO;
    public static Rank $THREE;
    public static Rank $FOUR;
    public static Rank $FIVE;
    public static Rank $SIX;
    public static Rank $SEVEN;
    public static Rank $EIGHT;
    public static Rank $NINE;
    public static Rank $TEN;
    public static Rank $JACK;
    public static Rank $QUEEN;
    public static Rank $KING;
    public static Rank $ACE;
    private int $value;

    public static function init(): void
    {
        static::$TWO = new Rank(2);
        static::$THREE = new Rank(3);
        static::$FOUR = new Rank(4);
        static::$FIVE = new Rank(5);
        static::$SIX = new Rank(6);
        static::$SEVEN = new Rank(7);
        static::$EIGHT = new Rank(8);
        static::$NINE = new Rank(9);
        static::$TEN = new Rank(10);
        static::$JACK = new Rank(11);
        static::$QUEEN = new Rank(12);
        static::$KING = new Rank(13);
        static::$ACE = new Rank(14);
    }

    private function __construct(int $value)
    {
        $this->value = $value;
    }

    public static function compare(Rank $r1, Rank $r2): int     // Todo: Interface Comparator?
    {
        if ($r1->value < $r2->value) {
            return -1;
        }
        if ($r1->value > $r2->value) {
            return 1;
        }

        return 0;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}