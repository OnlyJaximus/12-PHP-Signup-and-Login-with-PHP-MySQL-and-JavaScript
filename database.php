<?php

$host = "localhost";
$db = "comp_login";
$username = "root";
$password = "";

$mysqli = new mysqli(
    hostname: $host,
    database: $db,
    username: $username,
    password: $password
);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;
