<?php
declare(strict_types=1);

require_once "rest-const.php";
require_once "server/model/Session.php";
require_once "server/model/Player.php";

use poker_model\Session;
use poker_model\Player;

function getUpdate($authenticationId): string
{
    $player = Player::loadPlayerByAuthenticationId($authenticationId);
    if ($player->isUpdated()) {
        return R_EMPTY;
    } else {
        // TODO: return json
    }

    return R_OK;
}

function getCards($authenticationId)
{
    $player = Player::loadPlayerByAuthenticationId($authenticationId);
    return $player->toJson(Player::CARD1, Player::CARD2);
}

/*function validate()
{
    $time = time() + Session::TIME_GENERAL_BUFFER;
    $players = Player::load(Player::IS_ACTIVE, true);
    $sessions = Session::load(Session::ID, 0, ['OR', 0, '=', 0]);
    foreach ($players as $player) {
        $sessionId = $player->getSessionId();
        $session = $sessions[$sessionId];
        $lastTimestamp = $player->getSetActiveTime();
        switch ($session->getState()) {
            case Session::SESSION_STATE_ROUND_RUNNING:
                $lastTimestamp += Session::TIME_MAKE_MOVE;
                break;
            case Session::SESSION_STATE_SHOWDOWN:
                $lastTimestamp += Session::TIME_START_ROUND;
                break;
        }
        if ($lastTimestamp < $time) {
            fold($player->getAuthenticationId());
        }
        if ($player->getLastUpdateTime + Session::TIME_TO_UPDATE < $time) {
            exitSession($player->getAuthenticationId());
        }
    }
}*/

// General Actions

function createSession($playerName, $sessionName, $startMoney): string
{
    $session = Session::init($sessionName, $startMoney);
    $player = Player::init($playerName, $session);
    $session->insert();
    $player->insert();
    return json_encode(array(
        PLAYER => $player->toJson(Player::AUTHENTICATION_ID, Player::NAME),
        SESSION => $session->toJson(Session::GLOBAL_ID),
        LINK => $session->getLink()
    ));
}

function enterSession($playerName, $globalSessionId): string
{
    $session = Session::getSessionByGlobalId($globalSessionId);
    if ($session->isFull()) {
        return R_SESSION_FULL;
    }
    $player = Player::init($playerName, $globalSessionId);
    $player->insert();
    return json_encode(array(
        PLAYER => $player->toJson(Player::AUTHENTICATION_ID, Player::NAME),
        SESSION => $session->toJson(Session::GLOBAL_ID),
        LINK => $session->getLink()
    ));
}

function exitSession($authenticationId): string
{
    fold($authenticationId);
    $player = Player::loadPlayerByAuthenticationId($authenticationId);
    $player->delete();
    return R_OK;
}

function startRound($authenticationId)
{
    $player = Player::loadPlayerByAuthenticationId($authenticationId);
    if (!actionPerformable($player, Session::STATE_NOT_STARTED, Session::STATE_SHOWDOWN)) {
        return R_ERROR;
    }
    $session = $player->getSession();
    if (!$session->hasEnoughPlayers()) {
        return R_ERROR;
    }

    $player->setActive(false);

    // Start next round if the the first game has not started yet or if everyone performed this action
    if ($session->getState() == Session::STATE_NOT_STARTED || !count(Player::getActivePlayers())) {
        $session->setNextRound();
        return R_NEXT_ROUND;
    }
    return R_WAIT;
}

// Poker Actions
function check($authenticationId): string
{
    $player = Player::loadPlayerByAuthenticationId($authenticationId);
    if (!actionPerformable($player, Session::STATE_ROUND_BET_CHECK)) {
        return R_ERROR;
    }
    // The dealer is the last one playing in a round. If the dealer checks all the others have already checked.
    if ($player->isDealer()) {
        $session = $player->getSession();
        $session->setNextRound();
        $session->update();
    } else {
        $player->setNextPlayerActive();
    }
    $player->update();
    return R_OK;
}

function bet($authenticationId, $amount): string
{
    $player = Player::loadPlayerByAuthenticationId($authenticationId);
    if (!actionPerformable($player, Session::STATE_ROUND_BET_CHECK)) {
        return R_ERROR;
    }
    $session = $player->getSession();
    $player->raiseBet($amount);
    $session->setState(Session::STATE_ROUND_RAISE_CALL);
    $player->setNextPlayerActive();

    $player->update();
    $session->update();
    return R_OK;
}

function call($authenticationId): string
{
    $player = Player::loadPlayerByAuthenticationId($authenticationId);
    if (!actionPerformable($player, Session::STATE_ROUND_RAISE_CALL)) {
        return R_ERROR;
    }
    $player->equalizeBet();
    $player->setNextPlayerActive();
    $player->update();
    return R_OK;
}

function raise($authenticationId, $amount): string
{
    $player = Player::loadPlayerByAuthenticationId($authenticationId);
    if (!actionPerformable($player, Session::STATE_ROUND_RAISE_CALL)) {
        return R_ERROR;
    }
    $player->raiseBet($amount);
    $player->setNextPlayerActive();
    $player->update();
    return R_OK;
}

function fold($authenticationId): string
{
    $player = Player::loadPlayerByAuthenticationId($authenticationId);
    return R_OK;
}

// Helper
function actionPerformable(Player $player, ...$neededSessionStates)
{
    if (!$player->isActive()) {
        return false;
    }
    $session = $player->getSession();
    if (!in_array($session->getState(), $neededSessionStates)) {
        return false;
    }
    return true;
}

function checkOrCall($authenticationId)
{
    $player = Player::loadPlayerByAuthenticationId($authenticationId);
//    $session = Session::lo
}

function betOrRaise($authenticationId)
{

}