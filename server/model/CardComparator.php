<?php


namespace poker_model;

interface CardComparator
{
    public function compare(Card $o1, Card $o2): int;
}