<?php 
include 'headerPHP.php';?>
<h1>Variabel</h1>
<?php 

$nama = "faiz";
$umur = 19;
if($umur <= 17) {
    $kategori = "Saya masih remaja <br>";
} else if($umur <= 30) {
    $kategori = "Saya sudah dewasa <br>";
}else if($umur <= 50) {
    $kategori = "Saya sudah tua <br>";
}


?>
<body>
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Umur</th>
                <th>kategori</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php for($no = 1; $no <= 10;$no++){?>
                <td><?php echo $no ?></td>
                <td><?php echo $nama; ?></td>
                <td><?php echo $umur; ?></td>
                <td><?php echo $kategori?></td>
            </tr>
            <?php };?>
        </tbody>
</body>

<?php
include 'footerPHP.php';
?>