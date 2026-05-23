<?php

header('Content-Type: application/json');

$file="bookings.json";

$data=file_exists($file)

? json_decode(
file_get_contents($file),
true
)

: [];

if(!is_array($data)){
$data=[];
}

/* VERİLER */

$name=
trim(
$_POST['name'] ?? ''
);

$phone=
trim(
$_POST['phone'] ?? ''
);

$date=
trim(
$_POST['date'] ?? ''
);

$time=
trim(
$_POST['time'] ?? ''
);

/* BOŞ KONTROL */

if(
!$name ||
!$phone ||
!$date ||
!$time
){

echo json_encode([

"success"=>false,

"message"=>"Eksik bilgi!"

]);

exit;

}

/* TELEFON */

$phone=
preg_replace(
'/\D/',
'',
$phone
);

if(

!preg_match(
'/^(05\d{9}|5\d{9})$/',
$phone

)

){

echo json_encode([

"success"=>false,

"message"=>"Geçerli telefon gir"

]);

exit;

}

/* PAZAR KAPALI */

if(

date(
'w',
strtotime($date)
)

==0

){

echo json_encode([

"success"=>false,

"message"=>"Pazar günü kapalı"

]);

exit;

}

/* ÇAKIŞMA */

$isTaken=false;

foreach($data as $r){

if(

isset($r["date"])

&&

isset($r["time"])

&&

$r["date"]===$date

&&

$r["time"]===$time

){

$isTaken=true;

break;

}

}

if($isTaken){

echo json_encode([

"success"=>false,

"message"=>"Bu saat dolu!"

]);

exit;

}

/* EKLE */

$new=[

"name"=>$name,

"phone"=>$phone,

"date"=>$date,

"time"=>$time,

"created_at"=>time()

];

$data[]=$new;

/* JSON */

$ok=

file_put_contents(

$file,

json_encode(

$data,

JSON_PRETTY_PRINT

|

JSON_UNESCAPED_UNICODE

)

);

if($ok===false){

echo json_encode([

"success"=>false,

"message"=>"Kayıt hatası"

]);

exit;

}

/* TELEGRAM */

$token=
"8847642357:AAHvSUf65kTW1vu8eujmcThEhuWYFodDxF4";

$chat=
"1391125219";

$msg=

"💈 YENİ RANDEVU\n\n"

."👤 ".$name."\n"

."📞 ".$phone."\n"

."📅 ".$date."\n"

."🕒 ".$time;

$url=

"https://api.telegram.org/bot"

.$token

."/sendMessage";

$params=[

"chat_id"=>$chat,

"text"=>$msg

];

$ch=
curl_init();

curl_setopt(
$ch,
CURLOPT_URL,
$url
);

curl_setopt(
$ch,
CURLOPT_POST,
1
);

curl_setopt(
$ch,
CURLOPT_POSTFIELDS,
$params
);

curl_setopt(
$ch,
CURLOPT_RETURNTRANSFER,
true
);

curl_exec($ch);

curl_close($ch);

/* BAŞARILI */

echo json_encode([

"success"=>true,

"message"=>"Randevu oluşturuldu!"

]);

?>