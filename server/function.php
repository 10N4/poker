<?php
function dieFatalError($code)
{
    die("Schwerwiegender Fehler, der die Sicherheit und Stabilität des Systems betrifft! Code: " . $code);
}

function dieSqlError($code)
{
    die("SQL-Fehler! Code: " . $code);
}


function generateRandomString($length = 32)
{
    $chars = 'abcdefghijklmnopqrstuvwxyz1234567890';
    $charCount = strlen($chars);
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= $chars[rand(0, $charCount - 1)];
    }
    return $result;
}

function arrayDeleteElement($array, $deleteKey)
{
    $resultArray = array();
    foreach ($array as $key => $value) {
        if ($deleteKey == $key) {
            continue;
        }
        $resultArray[] = $value;
    }
    return $resultArray;
}