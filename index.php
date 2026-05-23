<!DOCTYPE html>
<html lang="tr">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>EFECAN TAZEGÜL HAIR DESIGN</title>

<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

*{margin:0;padding:0;box-sizing:border-box;}

body{
font-family:Poppins;
background:#080808;
color:white;
overflow-x:hidden;
}

/* TOPBAR */
.topbar{
position:fixed;
top:0;
left:0;
width:100%;
padding:18px 7%;
display:flex;
justify-content:space-between;
align-items:center;
background:rgba(0,0,0,.6);
backdrop-filter:blur(10px);
z-index:10;
}

.logo{
color:#C8A96B;
font-weight:bold;
}

.adminBtn{
background:#C8A96B;
color:black;
padding:8px 14px;
border-radius:10px;
text-decoration:none;
font-weight:bold;
}

.socials{
display:flex;
gap:10px;
align-items:center;
}

.socials a{
color:white;
text-decoration:none;
font-size:13px;
padding:6px 10px;
border:1px solid #2a2a2a;
border-radius:8px;
background:#1b1b1b;
transition:.2s;
}

.socials a:hover{
color:#C8A96B;
border-color:#C8A96B;
}

/* HERO */
.hero{
min-height:100svh;
padding:120px 7% 80px;
display:flex;
align-items:center;
background:
linear-gradient(180deg,rgba(0,0,0,.2),rgba(0,0,0,.92)),
url('https://images.unsplash.com/photo-1622286342621-4bd786c2447c?q=80&w=1400');
background-size:cover;
background-position:center;
}

.content{max-width:650px;}

h1{
font-family:Cinzel;
font-size:62px;
line-height:1;
margin-bottom:15px;
}

.desc{color:#bbb;margin-bottom:25px;}

.btnRow{display:flex;gap:12px;flex-wrap:wrap;}

.mainBtn{
padding:16px 24px;
background:#C8A96B;
color:black;
text-decoration:none;
border-radius:12px;
font-weight:bold;
}

.mapBtn{
padding:16px 24px;
background:#1b1b1b;
border:1px solid #2a2a2a;
color:white;
text-decoration:none;
border-radius:12px;
}

/* SECTION */
.section{
padding:70px 7%;
background:#0d0d0d;
}

.card{
max-width:800px;
margin:auto;
background:#121212;
padding:30px;
border-radius:20px;
}

.card h2{
font-family:Cinzel;
text-align:center;
margin-bottom:25px;
}

/* DATE */
.dateScroller{
display:flex;
gap:12px;
overflow-x:auto;
padding-bottom:10px;
}

.dateCard{
min-width:95px;
height:120px;
background:#1b1b1b;
border-radius:18px;
display:flex;
flex-direction:column;
justify-content:center;
align-items:center;
cursor:pointer;
border:1px solid #2a2a2a;
}

.dateCard.active{
border:2px solid #C8A96B;
}

.dateCard.disabled{
opacity:.3;
pointer-events:none;
}

.day{
font-size:12px;
color:#aaa;
margin-bottom:6px;
}

.num{
font-size:34px;
font-weight:bold;
}

.closedText{
font-size:11px;
color:#ff6b6b;
margin-top:5px;
}

/* TIME */
.timeGrid{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:10px;
margin-top:15px;
}

.timeBtn{
padding:12px;
background:#1b1b1b;
border-radius:12px;
text-align:center;
cursor:pointer;
border:1px solid #2a2a2a;
}

.timeBtn.active{
background:#C8A96B;
color:black;
font-weight:bold;
}

.timeBtn.dolu{
background:#3a1a1a;
color:#ff6b6b;
opacity:.55;
cursor:not-allowed;
}

/* FORM */
input,button{
width:100%;
padding:15px;
margin-bottom:12px;
border:none;
border-radius:12px;
font-size:15px;
}

input{
background:#1b1b1b;
color:white;
}

button{
background:#C8A96B;
font-weight:700;
cursor:pointer;
}

</style>
</head>

<body>

<div class="topbar">

<div class="logo">EFECAN TAZEGÜL</div>

<div class="socials">

<a target="_blank" href="https://instagram.com/efettzgl">Instagram</a>
<a target="_blank" href="https://www.tiktok.com/@barbers6220">TikTok</a>
<a target="_blank" href="https://wa.me/905307345076">WhatsApp</a>

</div>

<a class="adminBtn" href="admin.php">Admin</a>

</div>

<section class="hero">

<div class="content">

<h1>EFECAN TAZEGÜL HAIR DESIGN</h1>

<div class="desc">Modern kesim • Fade • Profesyonel bakım</div>

<div class="btnRow">

<a href="#randevu" class="mainBtn">RANDEVU AL</a>

<a target="_blank" class="mapBtn"
href="https://www.google.com/maps?q=İnönü+Mahallesi+Alageyik+Caddesi+No+51/B+Küçükçekmece+İstanbul">
📍 Yol Tarifi
</a>

</div>

</div>

</section>

<section id="randevu" class="section">

<div class="card">

<h2>RANDEVU</h2>

<form id="form">

<input type="text" name="name" placeholder="Ad Soyad" required>

<input type="tel" name="phone" id="phone" placeholder="05XXXXXXXXX" maxlength="11" required>

<div class="dateScroller" id="dates"></div>

<input type="hidden" name="date" id="date">

<div class="timeGrid" id="times"></div>

<input type="hidden" name="time" id="time">

<button>RANDEVU OLUŞTUR</button>

</form>

</div>

</section>

<script>

let selectedDate=null;
let selectedTime=null;
let data={};

async function load(){
try{
let r=await fetch("get_bookings.php");
data=await r.json();
}catch(e){data={};}
}
load();

const days=["PZT","SAL","ÇAR","PER","CUM","CMT","PAZ"];

let wrap=document.getElementById("dates");

for(let i=0;i<21;i++){

let d=new Date();
d.setDate(d.getDate()+i);

let dd=String(d.getDate()).padStart(2,'0');
let mm=String(d.getMonth()+1).padStart(2,'0');
let yyyy=d.getFullYear();

let full=`${yyyy}-${mm}-${dd}`;

let day=d.getDay();
let closed=(day===0);

let el=document.createElement("div");
el.className="dateCard";

if(closed) el.classList.add("disabled");

el.innerHTML=`
<div class="day">${days[(day+6)%7]}</div>
<div class="num">${dd}</div>
${closed?'<div class="closedText">KAPALI</div>':''}
`;

if(!closed){
el.onclick=()=>{

document.querySelectorAll(".dateCard")
.forEach(x=>x.classList.remove("active"));

el.classList.add("active");

selectedDate=full;
document.getElementById("date").value=full;

renderTimes();

};
}

wrap.appendChild(el);
}

function generateTimes(){
let arr=[];
let h=9,m=0;

while(h<22 || (h===22 && m<=30)){
arr.push(String(h).padStart(2,'0')+":"+String(m).padStart(2,'0'));
m+=30;
if(m===60){m=0;h++;}
}
return arr;
}

function renderTimes(){

let box=document.getElementById("times");

let booked=data[selectedDate]||[];

box.innerHTML=generateTimes().map(t=>{

let is=booked.includes(t);

return `
<div class="timeBtn ${is?'dolu':''}"
onclick="${is?'':`selectTime('${t}')`}">
${t}
</div>
`;

}).join("");

}

function selectTime(t){
selectedTime=t;
document.getElementById("time").value=t;

document.querySelectorAll(".timeBtn")
.forEach(x=>x.classList.remove("active"));

event.target.classList.add("active");
}

document.getElementById("phone").addEventListener("input",e=>{
e.target.value=e.target.value.replace(/\D/g,'');
});

document.getElementById("form").addEventListener("submit",async(e)=>{

e.preventDefault();

if(!/^(05\d{9}|5\d{9})$/.test(document.getElementById("phone").value)){
alert("Geçerli telefon giriniz");
return;
}

if(!selectedDate||!selectedTime){
alert("Tarih ve saat seç!");
return;
}

let f=new FormData(e.target);

let r=await fetch("save.php",{method:"POST",body:f});
let res=await r.json();

alert(res.message);

if(res.success){
e.target.reset();
selectedTime=null;
await load();
renderTimes();
}

});

</script>

</body>
</html>