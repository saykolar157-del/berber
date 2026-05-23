<?php

$conn = new mysqli(
$_ENV["railway"],
$_ENV["root"],
$_ENV["RgRNUVdPMMAtvQqwgnqoBYtPcBZWLIDO"],
$_ENV["railway"],
$_ENV["3306"]
);

if($conn->connect_error){

die(
"DB HATA: ".
$conn->connect_error
);

}

$conn->set_charset(
"utf8mb4"
);

?>
