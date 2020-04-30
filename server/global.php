<?php
function pdo(): PDO
{
    // LIVE
    /*$host = "";
    $username = "";
    $password = "";
    $dbname = "poker";*/

    // Niklas
    $host = "localhost";
    $username = "root";
    $password = "RXvQi2l8m81QlhXa";
    $dbname = "poker";

    return new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
}

function generateUniqueString($length = 64)
{
    if ($length < 64) {
        $length = 64;
    }
    $chars = 'abcdefghijklmnopqrstuvwxyz1234567890';
    $charCount = strlen($chars);
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= $chars[rand(0, $charCount - 1)];
    }
    return $result;
}

/** @noinspection DuplicatedCode */
function arrayDeleteElementByKey($array, $deleteKey)
{
    $resultArray = array();
    $shift = 0;
    foreach ($array as $key => $value) {
        if ($deleteKey == $key) {
            $shift++;
            continue;
        }
        if (preg_match("/^\d+$/", $key)) {
            $resultArray[$key - $shift] = $value;
        } else {
            $resultArray[$key] = $value;
        }
    }
    return $resultArray;
}

/** @noinspection DuplicatedCode */
function arrayDeleteElementsByValue($array, $deleteValue)
{
    $resultArray = array();
    $shift = 0;
    foreach ($array as $key => $value) {
        if ($value == $deleteValue) {
            $shift++;
            continue;
        }
        if (preg_match("/^\d+$/", $key)) {
            $resultArray[$key - $shift] = $value;
        } else {
            $resultArray[$key] = $value;
        }
    }
}


// DEBUG
function println($output)
{
    echo $output;
    echo "\n";
}

/** @noinspection SpellCheckingInspection */
function dumbln($output)
{
    var_dump($output);
    echo "\n";
}