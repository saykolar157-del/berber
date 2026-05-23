<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "berber_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("DB bağlantı hatası: " . mysqli_connect_error());
}
?>