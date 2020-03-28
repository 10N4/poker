<?php
declare(strict_types=1);

require_once "api-const.php";
require_once "server/model/Game.php";

use poker_model\Game;
use poker_model\Player;

function update($playerId): string
{
    /** @var Player $player */
    $player = Player::loadById($playerId);
    if ($player->isUpdated()) {
        return R_EMPTY;
    }
    return R_OK;
}

// General Actions
function createGame($name, $startMoney, $playerId): string
{
    /** @var Game $game */
    $game = Game::init($name, $startMoney, $playerId);
    $game->create();
    return $game->toJson(Game::LINK);
}

function enterGame($name, $link): string
{
    $player = Player::init($name, $link);
    $player->create();

    return R_OK;
}

function exitGame(): string
{
    return R_OK;
}

// Poker Actions
function check(): string
{
    return R_OK;
}

function bet($playerId): string
{
    return R_OK;
}

function call(): string
{
    return R_OK;
}

function raise(): string
{
    return R_OK;
}

function fold(): string
{
    return R_OK;
}