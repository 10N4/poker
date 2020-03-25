<?php
include "api-const.php";
include "action.php";

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

function get()
{
	$action = $_GET[ACTION];
	if ($action == A_UPDATE) {
		$result = update();
	} else {
		$result = R_ERROR;
	}
	makeOutput($result);
}

function post()
{
	$action = $_POST[ACTION];

	switch ($action) {
		case A_ENTER_GAME:
			$result = enterGame();
			break;
		case A_CHECK:
			$result = check();
			break;
		case A_BET:
			$result = bet();
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
		case A_EXIT_GAME:
			$result = exitGame();
			break;
		default:
			$result = R_ERROR;
	}

	makeOutput($result);
}

function put()
{

}

function delete()
{

}

function makeOutput($output)
{
	echo $output;
}