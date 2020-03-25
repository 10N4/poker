<?php
function dieFatalError($code)
{
	die("Schwerwiegender Fehler, der die Sicherheit und Stabilität des Systems betrifft! Code: " . $code);
}

function dieSqlError($code)
{
	die("SQL-Fehler! Code: " . $code);
}