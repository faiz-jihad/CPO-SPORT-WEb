<?php 
error_reporting(0);
include "headerPHP.php";
?>
<h1>Latihan GET</h1>
<a href="latihan6.php?nama=fikri"> Nama</a>
<a href="latihan6.php?nama=fikri&jurusan=TI">Jurusan</a>
<?php 
$nama =$_GET['nama'];
$jurusan = $_GET['jurusan'];
echo "<h2>Nama :" .$nama."</h2>";
echo "<h2>Jurusan : ".$jurusan."</h2>"
?>
<?php
include "footerPHP.php";
?>