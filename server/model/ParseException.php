<?php


namespace poker_model;


use Exception;
use Throwable;

class ParseException extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }
}