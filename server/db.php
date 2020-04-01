<?php
function pdo()
{
    $host = "";
    $username = "";
    $password = "";
    $dbname = "";
    return new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
}