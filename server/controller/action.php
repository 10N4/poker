<?php
declare(strict_types=1);

include "api-const.php";

use poker_model\Player;

function update($playerId): string
{
    /** @var Player $player */
    $player = Player::loadById($playerId);
    if ($player->isUpdated()) {
        return "R_EMPTY";
    }
    return R_OK;
}

function enterGame(): string
{
    Player::setAllUnUpdated();
    return R_OK;
}

function check(): string
{
    Player::setAllUnUpdated();

    return R_OK;
}

function bet($playerId): string
{
    Player::setAllUnUpdated();

    // ist jetzt nichts besonders sinnvolles:

    /** @var Player $player */
    $player = Player::loadById($playerId);
    $player->setCard1("Eine Karte");
    $player->setCard2("Zweite Karte");

    $player->update();

    return R_OK;
}

function call(): string
{
    Player::setAllUnUpdated();
    /** @var Player $player */
    $player = new Player();
    $player->create();

    return R_OK;
}

function raise(): string
{
    Player::setAllUnUpdated();

    return R_OK;
}

function fold(): string
{
    Player::setAllUnUpdated();

    return R_OK;
}

function exitGame(): string
{
    Player::setAllUnUpdated();

    return R_OK;
}