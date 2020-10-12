<?php


use poker_model\Card;

interface CardComparator
{
    public function compare(Card $o1, Card $o2): int;
}