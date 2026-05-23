<?php
session_start();

if(!isset($_SESSION["admin"])){
header("Location: login.php");
exit;
}

$file="bookings.json";

$data=file_exists($file)
? json_decode(file_get_contents($file),true)
: [];

if(!is_array($data)){
$data=[];
}

/* ===== MANUEL RANDEVU ===== */

if(isset($_POST["manualAdd"])){

$data[]=[

"name"=>$_POST["name"],

"phone"=>$_POST["phone"],

"date"=>$_POST["date"],

"time"=>$_POST["time"]

];

}

/* ===== SAAT KAPAT ===== */

if(isset($_POST["block"])){

$data[]=[

"name"=>"KAPALI",

"phone"=>"",

"date"=>$_POST["date"],

"time"=>$_POST["time"],

"blocked"=>true

];

}

/* ===== MANUEL GELİR ===== */

if(isset($_POST["income"])){

$data[]=[

"name"=>"MANUEL GELİR",

"phone"=>"",

"date"=>date("Y-m-d"),

"time"=>"--",

"done"=>true,

"price"=>(float)$_POST["price"],

"manual_income"=>true,

"note"=>$_POST["note"]

];

}

/* ===== 24 SAAT GEÇENLERİ SİL ===== */

$now=time();

$temp=[];

foreach($data as $r){

if(
isset($r["date"]) &&
isset($r["time"]) &&
$r["time"]!="--"
){

$t=
strtotime(
$r["date"]." ".$r["time"]
);

if(
$now <
($t+86400)
){

$temp[]=$r;

}

}else{

$temp[]=$r;

}

}

$data=$temp;

/* ===== TAMAMLANDI ===== */

if(isset($_POST["finish"])){

$id=(int)$_POST["finish"];

$price=
(float)
$_POST["price"];

if(isset($data[$id])){

$data[$id]["done"]=true;

$data[$id]["price"]=$price;

}

}

/* ===== SİL ===== */

if(isset($_POST["delete"])){

$id=(int)$_POST["delete"];

unset($data[$id]);

$data=array_values($data);

}

/* JSON */

file_put_contents(
$file,
json_encode(
$data,
JSON_PRETTY_PRINT|
JSON_UNESCAPED_UNICODE
)
);

/* CIRO */

$daily=0;
$weekly=0;
$monthly=0;

$today=date("Y-m-d");

$week=
date(
"Y-m-d",
strtotime("-7 day")
);

$month=
date(
"Y-m-d",
strtotime("-30 day")
);

foreach($data as $r){

if(
empty($r["done"])
){
continue;
}

$p=
(float)
($r["price"]??0);

if($r["date"]==$today){
$daily+=$p;
}

if($r["date"]>=$week){
$weekly+=$p;
}

if($r["date"]>=$month){
$monthly+=$p;
}

}

/* GRUP */

$grouped=[];

foreach($data as $i=>$r){

$r["_id"]=$i;

$d=$r["date"];

$grouped[$d][]=$r;

}

ksort($grouped);

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="
width=device-width,
initial-scale=1
">

<title>

EFECAN ADMIN

</title>

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
margin-bottom:15px;
}

.box h2{
margin-top:10px;
color:#C8A96B;
}

.wrap{
padding:20px;
}

.day{
margin-bottom:30px;
}

.dayTitle{
font-size:24px;
margin-bottom:15px;
color:#C8A96B;
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

.stats{
grid-template-columns:1fr;
}

.card{
flex-direction:column;
}

}

</style>

</head>

<body>

<div class="top">

<div class="logo">

💈 EFECAN ADMIN

</div>

<a
class="logout"
href="logout.php">

Çıkış

</a>

</div>

<div class="stats">

<div class="box">

Toplam

<h2>

<?= count($data) ?>

</h2>

</div>

<div class="box">

Günlük

<h2>

₺<?= $daily ?>

</h2>

</div>

<div class="box">

Haftalık

<h2>

₺<?= $weekly ?>

</h2>

</div>

<div class="box">

Aylık

<h2>

₺<?= $monthly ?>

</h2>

</div>

</div>

<div class="wrap">

<div class="box">

<h3>➕ Manuel Randevu</h3>
<br>

<form method="POST">

<input name="name" placeholder="Ad Soyad"><br><br>

<input name="phone" placeholder="Telefon"><br><br>

<input type="date" name="date"><br><br>

<input type="time" name="time"><br><br>

<button class="finish" name="manualAdd">

Ekle

</button>

</form>

</div>

<div class="box">

<h3>🚫 Saat Kapat</h3>
<br>

<form method="POST">

<input type="date" name="date"><br><br>

<input type="time" name="time"><br><br>

<button class="del" name="block">

Saati Kapat

</button>

</form>

</div>

<div class="box">

<h3>💰 Manuel Gelir</h3>
<br>

<form method="POST">

<input name="note" placeholder="Açıklama"><br><br>

<input type="number" name="price" placeholder="Tutar"><br><br>

<button class="finish" name="income">

Gelir Ekle

</button>

</form>

</div>

<?php foreach($grouped as $date=>$items): ?>

<div class="day">

<div class="dayTitle">

📅 <?= $date ?>

</div>

<?php foreach($items as $r): ?>

<div class="
card
<?= !empty($r["done"])
?'done':''
?>
">

<div>

<h3>

<?= htmlspecialchars($r["name"]) ?>

</h3>

<?php if(!empty($r["blocked"])): ?>

🚫 KAPALI / MOLA

<br><br>

<?php endif; ?>

<?php if(!empty($r["manual_income"])): ?>

💰 Ek Gelir

<br><br>

<?php endif; ?>

<a
class="phone"
href="
tel:
<?= $r["phone"] ?>
">

📞 <?= $r["phone"] ?>

</a>

<br><br>

🕒 <?= $r["time"] ?>

<?php if(!empty($r["done"])): ?>

<br><br>

<div class="money">

₺<?= $r["price"] ?>

</div>

<?php endif; ?>

</div>

<div class="right">

<?php if(empty($r["done"])): ?>

<form method="POST">

<input
type="number"
name="price"
placeholder="Ücret">

<button
class="finish"
name="finish"
value="<?= $r["_id"] ?>">

Tamamlandı

</button>

</form>

<?php endif; ?>

<form method="POST">

<button
class="del"
name="delete"
value="<?= $r["_id"] ?>">

Sil

</button>

</form>

</div>

</div>

<?php endforeach; ?>

</div>

<?php endforeach; ?>

</div>

</body>
</html>