<?php


namespace poker_model;
require_once "CardComparator.php";

class Hand
{
    protected array $cards;
    protected array $sortedBySuit;
    protected array $sortedByRank;
    public const NUMBER_OF_CARDS = 7;

    /**
     * Iff true, this hand will always be sorted in decreasing order
     * @var bool
     */
    private bool $isSorted;

    // Todo: further check if given Card array is a Hand
    public function __construct(array $cards)
    {
        if (count($cards) != self::NUMBER_OF_CARDS) {
            throw new InvalidHandException(/*'Given card array does not contain the right number of cards!'*/);
        }

        // Check for duplicate cards
        for ($i = 0; $i < self::NUMBER_OF_CARDS - 1; $i++) {
            for ($j = $i + 1; $j < self::NUMBER_OF_CARDS; $j++) {
                if ($cards[$i] == $cards[$j]) {
                    throw new InvalidHandException(/*'Duplicate card in given array!'*/);
                }
            }
        }

        $this->cards = $cards;
        $this->isSorted = false;
    }

    public function getHighestCard(): Card
    {
        if (!$this->isSorted) {
            $this->sort();
        }

        return $this->cards[0];
    }

    public function getLowestCard(): Card
    {
        if (!$this->isSorted) {
            $this->sort();
        }

        return $this->cards[count($this->cards) - 1];
    }

    // Sorts this Hand in decreasing order
    public function sort(): void
    {
        $this->sortedByRank = $this->sortByRank();
        $this->sortedBySuit = $this->sortBySuit();
        $this->isSorted = true;
    }

    /**
     * @param array $a Card array
     * @param CardComparator $comparator used to compare two cards
     * @return array
     */
    private function descendingSelectionSort(array $a, CardComparator $comparator): array
    {
        function swap(array &$a, int $i, int $j): void
        {
            if ($i == $j) {
                return;
            }

            $tmp = $a[$i];
            $a[$i] = $a[$j];
            $a[$j] = $tmp;
        }

        for ($i = 0; $i < count($a) - 1; $i++) {
            $k = $i;

            for ($j = $i + 1; $j < count($a); $i++) {
                if ($comparator->compare($a[$j], $a[$k]) == 1) {    // if( a[j] > a[k] )
                    $k = $j;
                }
            }

            $tmp = $a[$i];
            $a[$i] = $a[$k];
            $a[$k] = $tmp;
            //swap($a, $i, $k);
        }

        return $a;
    }

    protected function sortBySuit(): array
    {
        return $this->descendingSelectionSort($this->cards, new class implements CardComparator {
            public function compare(Card $c1, Card $c2): int
            {
                return $c1->compareBySuit($c2);
            }
        });
    }

    protected function sortByRank(): array
    {
        return $this->descendingSelectionSort($this->cards, new class implements CardComparator {
            public function compare(Card $c1, Card $c2): int
            {
                return $c1->compareByRank($c2);
            }
        });

        throw new \RuntimeException('running sortByRank()');
    }

    public function getSortedBySuit(): array
    {
        return $this->sortedBySuit;
    }

    public function getSortedByRank(): array
    {
        return $this->sortedByRank;
    }

    public function isSorted(): bool
    {
        return $this->isSorted;
    }
}