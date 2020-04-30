<?php


namespace poker_model;

/**
 *
 * Class Card
 * @package poker_model
 */
class Card
{
    public const COLOR_DIAMONDS = 'd';
    public const COLOR_HEARTS = 'h';
    public const COLOR_SPADES = 's';
    public const COLOR_CLUBS = 'c';

    public const NUM_JACK = 11;
    public const NUM_QUEEN = 12;
    public const NUM_KING = 13;
    public const NUM_ACE = 14;

    public const REP_NO_CARD = 0;

    private $number;
    private $color;

    /**
     * Card constructor.
     * @param $number
     * @param $color
     */
    public function __construct($number, $color)
    {
        $this->number = $number;
        $this->color = $color;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public static function getAllColors()
    {
        return array(self::COLOR_DIAMONDS, self::COLOR_HEARTS, self::COLOR_SPADES, self::COLOR_CLUBS);
    }

    /**
     * Creates a Card from a Card-representation
     * @param string $rep
     * @return Card
     * @throws ParseException
     */
    public static function parse(string $rep): Card
    {
        $colors = implode('', self::getAllColors());
        if (preg_match("/^[$colors][2-9]|(1[0-4])$/", $rep)) {
            $color = $rep[0];
            $number = substr($rep, 1, strlen($rep));
            return new Card($number, $color);
        }

        throw new ParseException();
    }

    public function __toString()
    {
        return $this->getColor() . $this->getNumber();
    }
}