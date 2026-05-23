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
SET status='tamamlandı', price=$price
WHERE id=$id
");

}

/* =========================
   VERİLERİ ÇEK
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
   CİRO HESABI
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

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>EFECAN ADMIN</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:Arial;
background:#090909;
color:white;
}

/* TOP */
.top{
padding:20px;
background:#121212;
display:flex;
justify-content:space-between;
align-items:center;
}

.logo{
font-size:24px;
font-weight:700;
color:#C8A96B;
}

.logout{
background:#C8A96B;
padding:12px 16px;
border-radius:12px;
text-decoration:none;
color:black;
}

/* STATS */
.stats{
padding:20px;
display:grid;
grid-template-columns:repeat(4,1fr);
gap:15px;
}

.box{
background:#121212;
padding:20px;
border-radius:20px;
}

.box h2{
margin-top:10px;
color:#C8A96B;
}

/* WRAP */
.wrap{
padding:20px;
}

.day{
margin-bottom:30px;
}

.card{
background:#121212;
padding:18px;
border-radius:20px;
margin-bottom:12px;
display:flex;
justify-content:space-between;
gap:15px;
}

.done{
border-left:5px solid lime;
}

.phone{
text-decoration:none;
color:#6db8ff;
}

.right{
display:flex;
flex-direction:column;
gap:10px;
}

input{
padding:10px;
border:none;
background:#1b1b1b;
color:white;
border-radius:10px;
width:100%;
}

button{
padding:10px;
border:none;
border-radius:10px;
cursor:pointer;
}

.finish{
background:#C8A96B;
}

.del{
background:red;
color:white;
}

.money{
color:lime;
font-weight:bold;
}

@media(max-width:750px){
.stats{grid-template-columns:1fr;}
.card{flex-direction:column;}
}

</style>

</head>

<body>

<div class="top">
<div class="logo">💈 EFECAN ADMIN</div>
<a class="logout" href="logout.php">Çıkış</a>
</div>

<div class="stats">

<div class="box">
Toplam
<h2><?= count($data) ?></h2>
</div>

<div class="box">
Günlük
<h2>₺<?= $daily ?></h2>
</div>

<div class="box">
Haftalık
<h2>₺<?= $weekly ?></h2>
</div>

<div class="box">
Aylık
<h2>₺<?= $monthly ?></h2>
</div>

</div>

<div class="wrap">

<?php foreach($data as $r): ?>

<div class="card <?= ($r["status"]=="tamamlandı")?'done':'' ?>">

<div>

<h3><?= htmlspecialchars($r["name"]) ?></h3>

<a class="phone" href="tel:<?= $r["phone"] ?>">
📞 <?= $r["phone"] ?>
</a>

<br><br>

📅 <?= $r["date"] ?>
<br>
🕒 <?= $r["time"] ?>

<?php if(($r["status"] ?? "")=="tamamlandı"): ?>
<br><br>
<div class="money">
₺<?= $r["price"] ?>
</div>
<?php endif; ?>

</div>

<div class="right">

<?php if(($r["status"] ?? "")!="tamamlandı"): ?>

<form method="POST">
<input type="number" name="price" placeholder="Ücret">
<button class="finish" name="finish" value="<?= $r["id"] ?>">
Tamamlandı
</button>
</form>

<?php endif; ?>

<form method="POST">
<button class="del" name="delete" value="<?= $r["id"] ?>">
Sil
</button>
</form>

</div>

</div>

<?php endforeach; ?>

</div>

</body>
</html>
