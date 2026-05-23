<?php
require "db.php";

$sql = "CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    phone VARCHAR(20),
    date DATE,
    time VARCHAR(10),
    status VARCHAR(50) DEFAULT 'beklemede',
    price DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if($conn->query($sql)){
    echo "TABLO OLUŞTU";
} else {
    echo "HATA: " . $conn->error;
}
?>
