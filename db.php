<?php

$conn = new mysqli(
  getenv("DB_HOST"),
  getenv("DB_USER"),
  getenv("DB_PASS"),
  getenv("DB_NAME"),
  3306
);

if ($conn->connect_error) {
  die("DB HATA: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
