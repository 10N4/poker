<?php
declare(strict_types=1);

require_once "api-const.php";
require_once "action.php";

$action = $_REQUEST[P_ACTION];
switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        get($action);
        break;
    case "POST":
        post($action);
        break;
    case "PUT":
        put();
        break;
    case "DELETE":
        delete();
        break;
}

function get($action): void
{
    if ($action == A_UPDATE) {
        $playerId = $_GET[P_PLAYER_ID];
        $result = getUpdate($playerId);
    } else {
        $result = R_ERROR;
    }
    makeOutput($result);
}

function post($action): void
{
    switch ($action) {
        // General Actions
        case A_VALIDATE:
            validate();
            break;
        case A_CREATE_SESSION:
            $playerName = $_POST[P_PLAYER_NAME];
            $sessionName = $_POST[P_SESSION_NAME];
            $startMoney = $_POST[P_START_MONEY];
            $result = createSession($playerName, $sessionName, $startMoney);
            break;
        case A_ENTER_SESSION:
            $globalSessionId = $_POST[P_GLOBAL_SESSION_ID];
            $result = enterSession();
            break;
        case A_EXIT_SESSION:
            $result = exitSession();
            break;
        // Poker Actions
        case A_CHECK:
            $result = check();
            break;
        case A_BET:
            $playerId = $_POST[P_PLAYER_ID];
            $result = bet($playerId);
            break;
        case A_CALL:
            $result = call();
            break;
        case A_RAISE:
            $result = raise();
            break;
        case A_FOLD:
            $result = fold();
            break;
        default:
            $result = R_ERROR;
    }

    makeOutput($result);
}

function put(): void
{

}

function delete(): void
{

}

function makeOutput($output)
{
    echo $output;
}