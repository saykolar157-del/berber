<?php

$conn = new mysqli(
getenv("MYSQLHOST"),
getenv("MYSQLUSER"),
getenv("MYSQLPASSWORD"),
getenv("MYSQLDATABASE"),
getenv("MYSQLPORT")
);

if ($conn->connect_error) {
    die("DB HATA: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
