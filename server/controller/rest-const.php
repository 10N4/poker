<?php
// Request Parameter Names
define("P_ACTION", "action");
define("P_PLAYER_ID", "player_id");
define("P_AUTHENTICATION_ID", "player_id");
define("P_PLAYER_NAME", "player_name");
define("P_SESSION_NAME", "session_name");
define("P_GLOBAL_SESSION_ID", "global_session_id");
define("P_START_MONEY", "start_money");

// GET Requests
define("A_UPDATE", "action_update");
define("A_CARDS", "action_cards");
define("A_REGISTER", "action_register");

// POST Requests
define("A_VALIDATE", "action_start_first_round");
define("A_CREATE_SESSION", "action_create_session");
define("A_ENTER_SESSION", "action_enter_session");
define("A_CHECK_CALL", "action_check_call");
define("A_BET_RAISE", "action_bet_raise");
define("A_FOLD", "action_fold");
define("A_EXIT_SESSION", "action_exit_session");
define("A_START_ROUND", "action_start_round");

// Request Standard Results
define("R_ERROR", "result_error");
define("R_EMPTY", "result_empty");
define("R_WAIT", "result_wait");
define("R_OK", "result_ok");

define("R_NEXT_ROUND", "result_next_round");
define("R_SESSION_FULL", "result_session_full");

// Output fields
define("PLAYER", "player");
define("SESSION", "session");
define("LINK", "link");
