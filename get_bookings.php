<div class="box">
<h3>📅 Bugünkü Randevular</h3>

<?php
$today = date("Y-m-d");

$stmt = $conn->prepare("
SELECT * FROM appointments
WHERE date=?
ORDER BY time ASC
");

$stmt->bind_param("s",$today);
$stmt->execute();

$res = $stmt->get_result();

while($r = $res->fetch_assoc()):
?>

<div style="margin-top:10px;padding:10px;background:#1b1b1b;border-radius:10px;">

<b><?= $r["name"] ?></b><br>
📞 <?= $r["phone"] ?><br>
🕒 <?= $r["time"] ?><br>

</div>

<?php endwhile; ?>

</div>
