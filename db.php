<?php

require_once 'config.php';

$host     = DB_HOSTNAME;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$database = DB_NAME;

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die('Ошибка подключения к базе данных: ' . $mysqli->connect_error);
}
