<?php

// @precondition Hand::sort() needs to be called before executing any of these functions!
// isThreeOfAKind() => isOnePair()
// !(isThreeOfAKind() <= isOnePair())

/// Wenn man davon ausgeht, dass eine Hand eine feste Anzahl von Karten hat,
/// genügt es, nur anfangskarte und endkarte zu vergleichen!
namespace poker_model;

class HandChecker
{
    private static function isFlush(Hand $hand): bool
    {
        $cards = $hand->getSortedBySuit();

        for ($i = 0; $i < count($cards) - 4; $i++) {
            if ($cards[$i]->getSuit() == $cards[$i + 4]->getSuit()) {   // Compare first and last card
                return true;
            }
        }

        return false;
    }

    private static function isStraightFlush(Hand $hand): bool
    {
        return self::isStraight($hand) && self::isFlush($hand);
    }

    private static function isRoyalFlush(Hand $hand): bool
    {
        return self::isStraight($hand) && self::isFlush($hand) && ($hand->getHighestCard()->getRank() == poker_model\Rank::ACE);
    }

    private static function isFourOfAKind(Hand $hand): bool
    {
        $cards = $hand->getSortedByRank();

        for ($i = 0; $i < count($cards) - 3; $i++) {
            if ($cards[$i]->getRank() == $cards[$i + 1]->getRank() &&
                $cards[$i + 1]->getRank() == $cards[$i + 2]->getRank() &&
                $cards[$i + 2]->getRank() == $cards[$i + 3]->getRank()) {
                return true;
            }
        }

        return false;
    }

    private static function isFullHouse(Hand $hand): bool
    {
        $cards = $hand->getSortedByRank();
        $counter = 0;
        $state = false;
        $oldRank = NULL;

        // x x x y y
        for ($i = 0; $i < count($cards) - 1; $i++) {
            $rank = $cards[$i]->getRank();

            if ($rank == $cards[$i + 1]->getRank() && $rank != $oldRank) {
                $counter++;
            }

            if ($counter == 3) {
                $state = true;
                $counter = 0;
                $oldRank = $rank;
            } else if ($state && $counter == 2) {
                return true;
            }
        }


        // y y x x x
        for ($i = 0; $i < count($cards) - 1; $i++) {
            $rank = $cards[$i]->getRank();

            if ($rank == $cards[$i + 1]->getRank() && $rank != $oldRank) {
                $counter++;
            }

            if ($counter == 2) {
                $state = true;
                $counter = 0;
                $oldRank = $rank;
            } else if ($state && $counter == 3) {
                return true;
            }
        }

        return false;
    }

    private static function isThreeOfAKind(Hand $hand): bool
    {
        $cards = $hand->getSortedByRank();

        for ($i = 0; $i < count($cards) - 2; $i++) {
            if ($cards[$i]->getRank() == $cards[$i + 1]->getRank() &&
                $cards[$i + 1]->getRank() == $cards[$i + 2]->getRank()) {
                return true;
            }
        }

        return false;
    }

    private static function isTwoPairs(Hand $hand): bool
    {
        $cards = $hand->getSortedByRank();
        $onePair = false;
        $pairRank = NULL;

        for ($i = 0; $i < count($cards) - 1; $i++) {
            if ($cards[$i]->getRank() == $cards[$i + 1]->getRank() && !$onePair) {
                $onePair = true;
                $pairRank = $cards[$i]->getRank();
            } else if ($onePair) {
                if ($cards[$i]->getRank() == $cards[$i + 1]->getRank() && $cards[$i]->getRank() != $pairRank) {
                    return true;
                }
            }
        }

        return false;
    }

    private static function isOnePair(Hand $hand): bool
    {
        $cards = $hand->getSortedByRank();

        for ($i = 0; $i < count($cards) - 1; $i++) {
            if ($cards[$i]->getRank() == $cards[$i + 1]->getRank()) {
                return true;
            }
        }

        return false;
    }

    private static function isStraight(Hand $hand): bool
    {
        $cards = $hand->getSortedByRank();

        if ($hand->getHighestCard() == poker_model\Rank::ACE) {    // Hand has an ace
            /* Check if other 4 cards are
             *      K, Q, J, 10
             * or   2, 3, 4, 5
             */
            function contains(array $set, array $subset): bool
            {
                $state = 0;
                for ($i = 1; $i < count($set); $i++) {
                    if ($set[$i] == $subset[$state]) {
                        $state++;

                        if ($state == 4) {
                            return true;
                        }
                    }
                }

                return false;
            }

            return contains($cards, [poker_model\Rank::KING, poker_model\Rank::QUEEN, poker_model\Rank::JACK, poker_model\Rank::TEN]) ||   // K, Q, J, 10
                contains($cards, [poker_model\Rank::TWO, poker_model\Rank::THREE, poker_model\Rank::FOUR, poker_model\Rank::FIVE]);        // ACE, 2, 3, 4, 5
        } else {    // Hand has no ace
            $counter = 0;

            for ($i = 0; $i < count($cards) - 1; $i++) {
                if ($cards[$i]->getRank() == $cards[$i + 1]->getRank() - 1) {
                    $counter++;
                }
            }

            return $counter == 5;
        }
    }

    public static function getValueOfHand(Hand $hand): int
    {
        if (!$hand->isSorted()) {
            $hand->sort();
        }

        if (self::isRoyalFlush($hand)) {
            return HandEvaluator::getValueOfRoyalFlushHand();
        } elseif (self::isStraightFlush($hand)) {
            return HandEvaluator::getValueOfStraightFlushHand($hand);
        } elseif (self::isFourOfAKind($hand)) {
            return HandEvaluator::getValueOfFourOfAKindHand($hand);
        } elseif (self::isFullHouse($hand)) {
            return HandEvaluator::getValueOfFullHouseHand($hand);
        } elseif (self::isFlush($hand)) {
            return HandEvaluator::getValueOfFlushHand($hand);
        } elseif (self::isStraight($hand)) {
            return HandEvaluator::getValueOfStraightHand($hand);
        } elseif (self::isThreeOfAKind($hand)) {
            return HandEvaluator::getValueOfThreeOfAKindHand($hand);
        } elseif (self::isTwoPairs($hand)) {
            return HandEvaluator::getValueOfTwoPairsHand($hand);
        } elseif (self::isOnePair($hand)) {
            return HandEvaluator::getValueOfOnePairHand($hand);
        } else {
            return HandEvaluator::getValueOfHighCardHand($hand);
        }
    }
}

