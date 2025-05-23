<?php 
error_reporting(0);
include 'headerPHP.php';?>


<h1>
    MAnipulasi String
</h1>
<?php 
$nama = "faiz jihad albaihaqi";
// memanipulasi String 
$pecah = explode(" ", $nama);
echo "<h2>Nama : " . $nama. "</h2>";
// mengubah huruf pertama menjadi kapital
echo "<h2>Nama : " . strtoupper($nama). "</h2>";
// mengubah huruf pertama menjadi kecil
echo "<h2>Nama : " . strtolower($nama). "</h2>";
// menampilkan Array ke 0 berdasarkan varriabel $pecah
echo "<h2>Nama : " . $pecah[0]. "</h2>";
// menampilkan Array ke 1 berdasarkan varriabel $pecah
echo "<h2>Nama : " . $pecah[1]. "</h2>";

?>