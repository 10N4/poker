<?php
declare(strict_types=1);

require_once "rest-const.php";
require_once "action.php";

$action = $_REQUEST[P_ACTION];
switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        get($action);
        break;
    case "POST":
        post($action);
        break;
}

function get($action): void
{
    switch ($action) {
        case A_UPDATE:
            $authenticationId = $_COOKIE[P_AUTHENTICATION_ID];
            $result = getUpdate($authenticationId);
            break;
        case A_CARDS:
            $authenticationId = $_COOKIE[P_AUTHENTICATION_ID];
            $result = getCards($authenticationId);
            break;
        case A_SESSION_EXISTS:
            $globalSessionId = $_POST[P_GLOBAL_SESSION_ID];
            $result = isSessionExisting($globalSessionId);
            break;
        default:
            $result = R_ERROR;
    }
    echo $result;
}

function post($action): void
{
    switch ($action) {
        case A_CREATE_SESSION:
            $playerName = $_POST[P_PLAYER_NAME];
            $sessionName = $_POST[P_SESSION_NAME];
            $startMoney = $_POST[P_START_MONEY];
            $result = createSession($playerName, $sessionName, $startMoney);
            break;
        case A_ENTER_SESSION:
            $playerName = $_POST[P_PLAYER_NAME];
            $globalSessionId = $_POST[P_GLOBAL_SESSION_ID];
            $result = enterSession($playerName, $globalSessionId);
            break;
        case A_EXIT_SESSION:
            $authenticationId = $_COOKIE[P_AUTHENTICATION_ID];
            $result = exitSession($authenticationId);
            break;
        case A_CHECK_CALL:
            $authenticationId = $_COOKIE[P_AUTHENTICATION_ID];
            $result = checkOrCall($authenticationId);
            break;
        case A_BET_RAISE:
            $playerId = $_POST[P_PLAYER_ID];
            $result = betOrRaise($playerId);
            break;
        case A_FOLD:
            $result = fold();
            break;
        default:
            $result = R_ERROR;
            break;
    }

    echo $result;
}