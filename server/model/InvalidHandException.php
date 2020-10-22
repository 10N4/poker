<?php

namespace poker_model;

use RuntimeException;

class InvalidHandException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct();
    }
}