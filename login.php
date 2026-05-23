<?php session_start(); ?>

<!DOCTYPE html>
<html lang="tr">
<head>

<meta charset="UTF-8">

<title>

Admin Giriş

</title>

<style>

body{
margin:0;
background:#0b0b0b;
color:white;
font-family:Arial;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.box{
background:#151515;
padding:30px;
border-radius:15px;
width:300px;
}

input{
width:100%;
padding:12px;
margin-bottom:10px;
border:none;
border-radius:10px;
background:#1b1b1b;
color:white;
}

button{
width:100%;
padding:12px;
background:#C8A96B;
border:none;
border-radius:10px;
font-weight:bold;
cursor:pointer;
}

h2{
text-align:center;
color:#C8A96B;
}

.error{
color:red;
text-align:center;
margin-top:10px;
}

</style>

</head>

<body>

<div class="box">

<h2>

ADMIN GİRİŞ

</h2>

<form method="POST">

<input
type="text"
name="user"
placeholder="Kullanıcı"
required>

<input
type="password"
name="pass"
placeholder="Şifre"
required>

<button>

GİRİŞ

</button>

</form>

<?php

if($_POST){

$user=
trim(
$_POST['user']
);

$pass=
$_POST['pass'];

/* HASH */

$hash=

'$2y$10$F029AvGeWADpR..kxUeZWu0GOI5piNek6Vq7fYDnQjsAqkS8HpUeq';

if(

$user==="admin"

&&

password_verify(
$pass,
$hash
)

){

$_SESSION['admin']=true;

header(
"Location: admin.php"
);

exit;

}else{

echo '

<p class="error">

Hatalı giriş

</p>

';

}

}

?>

</div>

</body>
</html>