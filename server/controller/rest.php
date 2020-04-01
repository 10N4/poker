<?php
declare(strict_types=1);

require_once "api-const.php";
require_once "action.php";

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        get();
        break;
    case "POST":
        post();
        break;
    case "PUT":
        put();
        break;
    case "DELETE":
        delete();
        break;
}

function get(): void
{
    $action = $_GET[P_ACTION];
    if ($action == A_UPDATE) {
        $playerId = $_GET[P_PLAYER_ID];
        $result = update($playerId);
    } else {
        $result = R_ERROR;
    }
    makeOutput($result);
}

function post(): void
{
    $action = $_POST[P_ACTION];

    switch ($action) {
        // General Actions
        case A_CREATE_GAME:
            $name = $_POST[P_NAME];
            $startMoney = $_POST[P_START_MONEY];
            $playerId = $_POST[P_PLAYER_ID];
            $result = createGame($name, $startMoney, $playerId);
            break;
        case A_ENTER_GAME:
            $result = enterGame();
            break;
        case A_EXIT_GAME:
            $result = exitGame();
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