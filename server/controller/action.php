<?php
declare(strict_types=1);

require_once "server/variables.php";
require_once "rest-const.php";
require_once "server/model/Session.php";
require_once "server/model/Player.php";

use poker_model\Session;
use poker_model\Player;

function getUpdate($authenticationId): string
{
    $player = Player::getPlayerByAuthenticationId($authenticationId);
    if ($player->isUpdated()) {
        return R_UPDATED;
    }

    $session = $player->getSession();
    $roles = $session->getRoles();

    $players = $player->getAllPlayers();
    $playersEncoded = array();
    /** @var Player $item */
    foreach ($players as $item) {
        $playersEncoded[] = $item->toJson(Player::ID,
            Player::NAME,
            Player::MONEY,
            Player::LAST_ACTION,
            Player::STATE,
            Player::CURRENT_BET);
    }

    $result = array(
        POD => $session->getPod(),
        CURRENT_BET => $player->getHighestBet(),
        ROLES => array(
            DEALER => $roles[Player::ROLE_DEALER]->getId(),
            SMALL_BLIND => $roles[Player::ROLE_SMALL_BLIND]->getId(),
            BIG_BLIND => $roles[Player::ROLE_BIG_BLIND]->getId()
        ),
        CARDS => $session->getCards(),
        PLAYERS => $playersEncoded,
    );
    $player->setUpdated(true);
    $player->update();
    return json_encode($result);
}

function getCards($authenticationId)
{
    $player = Player::getPlayerByAuthenticationId($authenticationId);
    return $player->toJson(Player::CARD1, Player::CARD2);
}

function isSessionExisting($globalSessionId)
{
    $session = Session::getSessionByGlobalId($globalSessionId);
    return json_encode([SESSION_EXISTS => ($session != null)]);
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
    $session->insert();
    $player = Player::init($playerName, $session);
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
    if (!$session) {
        return R_NO_SUCH_SESSION;
    }
    if ($session->isFull()) {
        return R_SESSION_FULL;
    }
    $player = Player::init($playerName, $session);
    $player->insert();
    $session->setAllUnUpdated();
    return json_encode(array(
        PLAYER => $player->toJson(Player::AUTHENTICATION_ID, Player::NAME),
        SESSION => $session->toJson(Session::GLOBAL_ID),
        LINK => $session->getLink()
    ));
}

function exitSession($authenticationId): string
{
    $player = Player::getPlayerByAuthenticationId($authenticationId);
    if (!$player) {
        return R_ERROR;
    }
    fold($authenticationId, $player);
    $player->delete();
    return R_OK;
}

function pause($authenticationId): string
{
    $player = Player::getPlayerByAuthenticationId($authenticationId);
    if (!$player) {
        return R_ERROR;
    }
    fold($authenticationId, $player);
    $player->setState(Player::STATE_WATCHING);
    $player->setLastAction(Player::ACTION_PAUSE);
    return R_OK;
}

function startGame($authenticationId): string
{
    $player = Player::getPlayerByAuthenticationId($authenticationId);
    if (!$player) {
        return R_ERROR;
    }
    $session = $player->getSession();
    /*if (!actionPerformable($player, $session, Session::STATE_NOT_STARTED, Session::STATE_SHOWDOWN)) {
        return R_ERROR;
    }*/
    if (!$session->hasEnoughPlayers()) {
        return R_ERROR;
    }

    $player->setInActive();
    $player->update();

    // Start next round if the the first game has not started yet or if everyone performed this action
    if ($session->getState() == Session::STATE_NOT_STARTED || !count(Player::getActivePlayers())) {
        $session->setNextRound();
        $session->update();
        return R_NEXT_ROUND;
    }
    return R_WAIT;
}

// region Poker Actions
function checkOrCall($authenticationId)
{
    $player = Player::getPlayerByAuthenticationId($authenticationId);
    if (!$player->hasState(Player::STATE_IN_GAME_ACTIVE)) {
        return R_ERROR;
    }
    $session = $player->getSession();
    switch ($session->getState()) {
        case Session::STATE_BET_CHECK:
            $result = check($player, $session);
            break;
        case Session::STATE_RAISE_CALL:
            $result = call($player, $session);
            break;
        default:
            $result = R_ERROR;

    }
    // Updates are done in called functions
    return $result;
}

function betOrRaise($authenticationId, $amount)
{
    $player = Player::getPlayerByAuthenticationId($authenticationId);
    if (!$player->hasState(Player::STATE_IN_GAME_ACTIVE)) {
        return R_ERROR;
    }
    if ($player->getMoney() < $amount) {
        return R_ERROR;
    }
    $session = $player->getSession();
    switch ($session->getState()) {
        case Session::STATE_BET_CHECK:
            $result = bet($player, $session, $amount);
            break;
        case Session::STATE_RAISE_CALL:
            $result = raise($player, $session, $amount);
            break;
        default:
            $result = R_ERROR;

    }
    // Updates are done in called functions
    return $result;
}

function fold($authenticationId, $player = false): string
{
    if (!$player) {
        $player = Player::getPlayerByAuthenticationId($authenticationId);
        if (!$player) {
            return R_ERROR;
        }
    }
    $session = $player->getSession();
    $playerState = $player->getState();
    if ($playerState == Player::STATE_IN_GAME_INACTIVE || $playerState == Player::STATE_IN_GAME_ACTIVE) {
        $session->raisePodBy($player->getCurrentBet());
        $player->clearCurrentBet();
        $player->clearTotalBet();
        $player->setLastAction(Player::ACTION_FOLD);
        $player->setState(Player::STATE_AT_THE_TABLE);
    }
    return R_OK;
}

// endregion

// region Helper Actions
function check(Player $player, Session $session): string
{
    // The dealer is the last one playing in a round. If the dealer checks all the others have already checked.
    if ($player->isDealer()) {
        $session->setNextRound();
        $session->update();
    } else {
        $player->setNextPlayerActive();
        $player->setLastAction(Player::ACTION_CHECK);
        $player->update();
    }

    return R_OK;
}

function bet(Player $player, Session $session, $amount): string
{
    $player->raiseBet($amount);
    $session->setState(Session::STATE_RAISE_CALL);
    $player->setNextPlayerActive();
    $player->setLastAction(Player::ACTION_BET);
    $session->update();
    $player->update();

    return R_OK;
}

function call(Player $player, Session $session): string
{
    $player->equalizeBet();
    $player->update();
    if ($session->areAllBetsEqual()) {
        $session->setNextRound();
        $session->update();
    } else {
        $player->setNextPlayerActive();
        $player->setLastAction(Player::ACTION_CALL);
        $player->update();
    }
    return R_OK;
}

/** @noinspection PhpUnusedParameterInspection */
function raise(Player $player, Session $session, $amount): string
{
    $player->equalizeBet();
    $player->raiseBet($amount);
    $player->setNextPlayerActive();
    $player->setLastAction(Player::ACTION_RAISE);
    $player->update();
    return R_OK;
}

// endregion

// region Helper
function actionPerformable(Player $player, Session $session, ...$neededSessionStates)
{
    if (!$player->hasState(Player::STATE_IN_GAME_ACTIVE)) {
        return false;
    }
    if (!in_array($session->getState(), $neededSessionStates)) {
        return false;
    }
    return true;
}

function evaluate()
{
    // Check highest set
    // Check who has to show the cards

    return json_encode();
}

function dieFatalError($code)
{
    if (DEBUG) {
        die("Schwerwiegender Fehler, der die Sicherheit und Stabilität des Systems betrifft! Code: " . $code);
    } else {
        die();
    }
}

function dieSqlError($code, $infos = array())
{
    if (DEBUG) {
        println("SQL-Fehler! Code: " . $code);
        foreach ($infos as $info) {
            println($info);
        }
    }
    die();
}

// endregion
























