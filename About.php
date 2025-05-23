<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami</title>
    <link rel="stylesheet" href="About.css">
</head>
<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_usercpo");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data dari tabel about
$query = "SELECT * FROM about_us WHERE id = 1"; // Asumsi id=1 untuk halaman Tentang Kami
$result = $koneksi->query($query);

// Cek ada datanya atau tidak
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
    exit;
}
?>

<body>
    <div class="container">
        <h2><?php echo $data['title']; ?></h2>
        <article>
            <section>
                <p><?php echo nl2br($data['content']); ?></p>
            </section>
        </article>
    </div>
    <a href="https://wa.me/6285846801239" id="whatsapp-button" target="_blank">
        <img src="wa.png" alt="WhatsApp" />
    </a>
</body>
</html>
