<?php

$host = "kodama.proxy.rlwy.net";
$user = getenv("MYSQLUSER");
$pass = getenv("MYSQLPASSWORD");
$db   = getenv("MYSQLDATABASE");
$port = 31819;

$conn = new mysqli(
    $host,
    $user,
    $pass,
    $db,
    $port
);

if ($conn->connect_error) {
    die("DB HATA: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>
