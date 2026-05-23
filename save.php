<?php

header('Content-Type: application/json');

ini_set('display_errors',1);
error_reporting(E_ALL);

/* =========================
   DB BAĞLANTI (RAILWAY)
   ========================= */
require "db.php";

/* =========================
   VERİLER
   ========================= */
$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$date = trim($_POST['date'] ?? '');
$time = trim($_POST['time'] ?? '');

/* BOŞ KONTROL */
if(!$name || !$phone || !$date || !$time){

echo json_encode([
"success"=>false,
"message"=>"Eksik bilgi!"
]);
exit;

}

/* TELEFON */
$phone = preg_replace('/\D/','',$phone);

if(!preg_match('/^(05\d{9}|5\d{9})$/',$phone)){

echo json_encode([
"success"=>false,
"message"=>"Geçerli telefon gir"
]);
exit;

}

/* PAZAR KAPALI */
if(date('w',strtotime($date)) == 0){

echo json_encode([
"success"=>false,
"message"=>"Pazar günü kapalı"
]);
exit;

}

/* =========================
   ÇAKIŞMA (MYSQL)
   ========================= */
$check = $conn->prepare("SELECT id FROM appointments WHERE date=? AND time=?");
$check->bind_param("ss",$date,$time);
$check->execute();
$res = $check->get_result();

if($res->num_rows > 0){

echo json_encode([
"success"=>false,
"message"=>"Bu saat dolu!"
]);
exit;

}

/* =========================
   KAYIT (MYSQL)
   ========================= */
$stmt = $conn->prepare("
INSERT INTO appointments (name, phone, date, time)
VALUES (?, ?, ?, ?)
");

$stmt->bind_param("ssss",$name,$phone,$date,$time);

if(!$stmt->execute()){

echo json_encode([
"success"=>false,
"message"=>"Kayıt hatası"
]);
exit;

}

/* =========================
   TELEGRAM
   ========================= */
$token = "8847642357:AAHvSUf65kTW1vu8eujmcThEhuWYFodDxF4";
$chat = "1391125219";

$msg =
"💈 YENİ RANDEVU\n\n"
."👤 ".$name."\n"
."📞 ".$phone."\n"
."📅 ".$date."\n"
."🕒 ".$time;

$url = "https://api.telegram.org/bot".$token."/sendMessage";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
"chat_id" => $chat,
"text" => $msg
]);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

curl_exec($ch);
curl_close($ch);

/* BAŞARILI */
echo json_encode([
"success"=>true,
"message"=>"Randevu oluşturuldu!"
]);

?>
