<?php

//require_once "server/global.php";

/*require_once "server/controller/action.php";

require_once "server/model/CardDeckManager.php";
require_once "server/model/Card.php";

use poker_model\Card;
use poker_model\CardDeckManager;

echo "Hallo Welt";
echo "\n";*/


//testDeck();
//testRandomString();
//testCreateGame();

/*echo "Hier: ";
var_dump("asdf" == true);
echo "\n";
var_dump("asdf" === true);
echo "\n";

echo "1" + 1;
echo "\n";

echo "1" . 1;

echo "\n";
${"Hello"} = 'Hello World';

echo $Hello;


${"Hello"} = 'Hello World';
echo $Hello;

echo "\n";
echo substr("Niklas", 0, 3);*/

function testDeck() {
    $deck = new CardDeckManager();

    $usedCards = array(
        new Card(2, Card::COLOR_SPADES),
        new Card(3, Card::COLOR_SPADES),
        new Card(4, Card::COLOR_SPADES),
        new Card(5, Card::COLOR_SPADES),
        new Card(6, Card::COLOR_SPADES),
        new Card(7, Card::COLOR_SPADES),
        new Card(8, Card::COLOR_SPADES),
        new Card(9, Card::COLOR_SPADES),
        new Card(10, Card::COLOR_SPADES),
        new Card(11, Card::COLOR_SPADES),
    );

    $index = 0;
    foreach ($card = $deck->getRandomCards(5, $usedCards) as $card) {
        $index++;
        echo $index . ' ';
        echo $card->__toString();
        echo "\n";
    }
}

function testRandomString()
{
    for ($i = 0; $i < 100; $i++) {
        echo generateRandomString();
        echo "\n";
    }
}

function testCreateGame()
{
    echo createSession("Niklas", "Erste Session", 12);
}

echo "jonathanknoll.net/poker/index.html?global-session-id=142901347tohrweigfqwz49";




























