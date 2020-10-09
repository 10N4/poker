<?php

use Card\Card;

interface CardComparator
{
    public function compare(Card $o1, Card $o2);
}