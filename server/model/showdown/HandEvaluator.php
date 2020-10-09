<?php


class HandEvaluator
{
    public static function getValueOfHighCardHand(Hand $hand): int
    {
        $cards = $hand->getSortedByRank();

        return $cards[0]->getRank() * 14 ** 4 +
            $cards[1]->getRank() * 14 ** 3 +
            $cards[2]->getRank() * 14 ** 2 +
            $cards[3]->getRank() * 14 +
            $cards[4]->getRank();
    }

    public static function getValueOfOnePairHand(Hand $hand): int
    {
        $cards = $hand->getSortedByRank();
        $value = BasicHandValues::ONE_PAIR;

        if ($cards[0]->getRank() == $cards[1]->getRank()) {
            $value += $cards[0]->getRank() * 14 ** 3 +   // Pair card
                $cards[2]->getRank() * 14 ** 2 +        // Highest card
                $cards[3]->getRank() * 14 +             // Middle card
                $cards[4]->getRank();                   // Lowest card
        } elseif ($cards[1]->getRank() == $cards[2]->getRank()) {
            $value += $cards[1]->getRank() * 14 ** 3 +   // Pair card
                $cards[0]->getRank() * 14 ** 2 +        // Highest card
                $cards[3]->getRank() * 14 +             // Middle card
                $cards[4]->getRank();                   // Lowest card
        } elseif ($cards[2]->getRank() == $cards[3]->getRank()) {
            $value += $cards[2]->getRank() * 14 ** 3 +   // Pair card
                $cards[0]->getRank() * 14 ** 2 +        // Highest card
                $cards[1]->getRank() * 14 +             // Middle card
                $cards[4]->getRank();                   // Lowest card
        } elseif ($cards[3]->getRank() == $cards[4]->getRank()) {
            $value += $cards[3]->getRank() * 14 ** 3 +   // Pair card
                $cards[0]->getRank() * 14 ** 2 +        // Highest card
                $cards[1]->getRank() * 14 +             // Middle card
                $cards[2]->getRank();                   // Lowest card
        } elseif ($cards[4]->getRank() == $cards[5]->getRank()) {
            $value += $cards[4]->getRank() * 14 ** 3 +   // Pair card
                $cards[0]->getRank() * 14 ** 2 +        // Highest card
                $cards[1]->getRank() * 14 +             // Middle card
                $cards[2]->getRank();                   // Lowest card
        } elseif ($cards[5]->getRank() == $cards[6]->getRank()) {
            $value += $cards[5]->getRank() * 14 ** 3 +   // Pair card
                $cards[0]->getRank() * 14 ** 2 +        // Highest card
                $cards[1]->getRank() * 14 +             // Middle card
                $cards[2]->getRank();                   // Lowest card
        }

        return $value;
    }

    public static function getValueOfTwoPairsHand(Hand $hand): int
    {
        $cards = $hand->getSortedByRank();
        $value = BasicHandValues::TWO_PAIRS;

        // Always take highest unmatched card
        if ($cards[0]->getRank() == $cards[1]->getRank() &&          // x x y y z z z
            $cards[2]->getRank() == $cards[3]->getRank()) {
            $value += $cards[0]->getRank() * 14 ** 2 +               // high pair
                $cards[2]->getRank() * 14 +                          // low par
                $cards[4]->getRank();                                // highest unmatched card
        } elseif ($cards[0]->getRank() == $cards[1]->getRank() &&    // x x z y y z z
            $cards[3]->getRank() == $cards[4]->getRank()) {
            $value += $cards[0]->getRank() * 14 ** 2 +
                $cards[3]->getRank() * 14 +
                $cards[2]->getRank();
        } elseif ($cards[0]->getRank() == $cards[1]->getRank() &&    // x x z z y y z
            $cards[4]->getRank() == $cards[5]->getRank()) {
            $value += $cards[0]->getRank() * 14 ** 2 +
                $cards[4]->getRank() * 14 +
                $cards[2]->getRank();
        } elseif ($cards[0]->getRank() == $cards[1]->getRank() &&    // x x z z z y y
            $cards[5]->getRank() == $cards[6]->getRank()) {
            $value += $cards[0]->getRank() * 14 ** 2 +
                $cards[5]->getRank() * 14 +
                $cards[2]->getRank();
        } elseif ($cards[1]->getRank() == $cards[2]->getRank() &&    // z x x y y z z
            $cards[3]->getRank() == $cards[4]->getRank()) {
            $value += $cards[1]->getRank() * 14 ** 2 +
                $cards[3]->getRank() * 14 +
                $cards[0]->getRank();
        } elseif ($cards[1]->getRank() == $cards[2]->getRank() &&    // z x x z y y z
            $cards[4]->getRank() == $cards[5]->getRank()) {
            $value += $cards[1]->getRank() * 14 ** 2 +
                $cards[4]->getRank() * 14 +
                $cards[0]->getRank();
        } elseif ($cards[1]->getRank() == $cards[2]->getRank() &&    // z x x z z y y
            $cards[5]->getRank() == $cards[6]->getRank()) {
            $value += $cards[1]->getRank() * 14 ** 2 +
                $cards[5]->getRank() * 14 +
                $cards[0]->getRank();
        } elseif ($cards[2]->getRank() == $cards[3]->getRank() &&    // z z x x y y z
            $cards[4]->getRank() == $cards[5]->getRank()) {
            $value += $cards[2]->getRank() * 14 ** 2 +
                $cards[4]->getRank() * 14 +
                $cards[0]->getRank();
        } elseif ($cards[2]->getRank() == $cards[3]->getRank() &&    // z z x x z y y
            $cards[5]->getRank() == $cards[6]->getRank()) {
            $value += $cards[2]->getRank() * 14 ** 2 +
                $cards[5]->getRank() * 14 +
                $cards[0]->getRank();
        } else {                                                     // z z z x x y y
            $value += $cards[3]->getRank() * 14 ** 2 +
                $cards[5]->getRank() * 14 +
                $cards[0]->getRank();
        }
        /*elseif ($cards[3]->getRank() == $cards[4]->getRank() &&    // z z z x x y y
            $cards[5]->getRank() == $cards[6]->getRank()) {
            $value += $cards[3]->getRank() * 14 ** 2 +
                $cards[5]->getRank() * 14 +
                $cards[0]->getRank();
        }*/

        return $value;
    }

    public static function getValueOfStraightFlushHand(Hand $hand): int
    {
        return BasicHandValues::STRAIGHT_FLUSH + self::getValueOfHighCardHand($hand);
    }

    public static function getValueOfRoyalFlushHand(): int
    {
        return BasicHandValues::ROYAL_FLUSH;
    }

    public static function getValueOfFourOfAKindHand(Hand $hand): int
    {
        // Trick for 4sCardRank: $hand[3] has always the rank of the 4s
        // x x x x y y y
        // y x x x x y y
        // y y x x x x x
        // y y y x x x x
        return BasicHandValues::FOUR_OF_A_KIND + $hand->getSortedByRank()[3]->getRank();    // hand[3] will always be the rank of the 4s
    }

    public static function getValueOfFullHouseHand(Hand $hand): int
    {
        // Trick for Full House:
        // Find the set in the Hand and add its rank
        // x x x y y y y
        // y x x x y y y
        // y y x x x y y
        // y y y x x x y
        // y y y y x x x
        $cards = $hand->getSortedByRank();
        $value = BasicHandValues::FULL_HOUSE;

        // Find the set in the full house hand
        for ($i = 0; $i < count($cards) - 2; $i++) {
            if ($cards[$i]->getRank() == $cards[$i + 1]->getRank() &&
                $cards[$i + 1]->getRank() == $cards[$i + 2]->getRank()) {
                $value += $cards[$i]->getRank();    // Add rank of the 3-of-a-kind rank
                break;
            }
        }

        return $value;
    }

    public static function getValueOfFlushHand(Hand $hand): int
    {
        return BasicHandValues::FLUSH + self::getValueOfHighCardHand($hand);
    }

    public static function getValueOfStraightHand(Hand $hand): int
    {
        return BasicHandValues::STRAIGHT + self::getValueOfHighCardHand($hand);
    }

    public static function getValueOfThreeOfAKindHand(Hand $hand): int
    {
        // Trick for set:
        // x x x y y y y => take the rank of hand[0]               : Case 1
        // y x x x y y y => take the rank of hand[3]               : Case 3
        // y y x x x y y => take the rank of hand[3]               : Case 3
        // y y y x x x y => take the rank of hand[3]               : Case 3
        // y y y y x x x => take the rank of hand[count(hand) - 1] : Case 2
        $cards = $hand->getSortedByRank();

        // Check for case 1:
        if ($cards[0]->getRank() == $cards[1]->getRank() &&
            $cards[1]->getRank() == $cards[2]->getRank()) {
            return BasicHandValues::THREE_OF_A_KIND + $cards[0]->getRank();
        }

        // Check for case 2:
        if ($cards[4]->getRank() == $cards[5]->getRank() &&
            $cards[5]->getRank() == $cards[6]->getRank()) {
            return BasicHandValues::THREE_OF_A_KIND + $cards[6]->getRank();
        }

        // Case 3:
        return BasicHandValues::THREE_OF_A_KIND + $cards[3]->getRank();
    }
}

abstract class BasicHandValues
{
    const ROYAL_FLUSH = PHP_INT_MAX;
    const STRAIGHT_FLUSH = 8000000;
    const FOUR_OF_A_KIND = 7000000;
    const FULL_HOUSE = 6000000;
    const FLUSH = 5000000;
    const STRAIGHT = 4000000;
    const THREE_OF_A_KIND = 3000000;
    const TWO_PAIRS = 2000000;
    const ONE_PAIR = 1000000;
}