<?php

$host = $_SERVER['MYSQLHOST'] ?? getenv("MYSQLHOST");
$user = $_SERVER['MYSQLUSER'] ?? getenv("MYSQLUSER");
$pass = $_SERVER['MYSQLPASSWORD'] ?? getenv("MYSQLPASSWORD");
$db   = $_SERVER['MYSQLDATABASE'] ?? getenv("MYSQLDATABASE");
$port = $_SERVER['MYSQLPORT'] ?? getenv("MYSQLPORT");

if(!$host || !$user || !$pass || !$db){
    die("ENV GELMİYOR → Railway variable attach sorunu");
}

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("DB HATA: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
