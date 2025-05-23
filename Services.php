<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi</title>
    <link rel="stylesheet" href="Services.css">
</head>
<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_usercpo");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data dari tabel about
$query = "SELECT * FROM services WHERE id = 1"; // Asumsi id=1 untuk halaman Tentang Kami
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
        <h2><?php echo $data['judul']; ?></h2>
        <article>
            <section>
                <p><?php echo nl2br($data['isi']); ?></p>
            </section>
        </article>
    </div>
    <a href="https://wa.me/6285846801239" id="whatsapp-button" target="_blank">
        <img src="wa.png" alt="WhatsApp" />
    </a>
</body>
</html>
