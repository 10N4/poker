<?php
// Request Parameter Names
define("P_ACTION", "action");
define("P_PLAYER_ID", "player_id");

// GET Requests
define("A_UPDATE", "action_update");
define("A_CARDS", "action_cards");

// POST Requests
define("A_ENTER_GAME", "action_enter_game");
define("A_CHECK", "action_check");
define("A_BET", "action_bet");
define("A_CALL", "action_call");
define("A_RAISE", "action_raise");
define("A_FOLD", "action_fold");
define("A_EXIT_GAME", "action_exit_game");
define("A_START_FIRST_ROUND", "action_start_first_round");

// PUT Request
define("A_CREATE_GAME", "action_create_game");

// Request Standard Results
define("R_ERROR", "result_error");
define("R_EMPTY", "result_empty");
define("R_WAIT", "result_wait");
define("R_NEXT_ROUND", "result_next_round");
define("R_OK", "result_ok");
