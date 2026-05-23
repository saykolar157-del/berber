<?php
session_start();

if(!isset($_SESSION["admin"])){
header("Location: login.php");
exit;
}

require "db.php";

/* =========================
   SİL
   ========================= */
if(isset($_POST["delete"])){

$id = (int)$_POST["delete"];

$conn->query("DELETE FROM appointments WHERE id=$id");

}

/* =========================
   TAMAMLANDI
   ========================= */
if(isset($_POST["finish"])){

$id = (int)$_POST["finish"];
$price = (float)$_POST["price"];

$conn->query("
UPDATE appointments
SET status='tamamlandı'
WHERE id=$id
");

}

/* =========================
   LİSTE
   ========================= */
$result = $conn->query("
SELECT * FROM appointments
ORDER BY date DESC, time DESC
");

$data = [];

while($row = $result->fetch_assoc()){
$data[] = $row;
}

/* =========================
   CİRO
   ========================= */
$daily = 0;
$weekly = 0;
$monthly = 0;

$today = date("Y-m-d");
$week = date("Y-m-d", strtotime("-7 day"));
$month = date("Y-m-d", strtotime("-30 day"));

foreach($data as $r){

if(($r["status"] ?? "") != "tamamlandı"){
continue;
}

$p = (float)($r["price"] ?? 0);

if($r["date"] == $today){
$daily += $p;
}

if($r["date"] >= $week){
$weekly += $p;
}

if($r["date"] >= $month){
$monthly += $p;
}

}

?>
