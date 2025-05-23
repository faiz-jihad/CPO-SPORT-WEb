<?php
include 'koneksi.php';
session_start();

// Simpan status ke session untuk ditampilkan setelah redirect
if (!isset($_SESSION['user_id'])) {
    $_SESSION['alert'] = ['type' => 'error', 'message' => 'Silakan login terlebih dahulu!'];
    header("Location: halamanlogin.php");
    exit;
}

$nama = htmlspecialchars($_SESSION['username']);
$komentar = htmlspecialchars($_POST['komentar']);
$tanggal = date('Y-m-d H:i:s');

if (!empty($komentar)) {
    $stmt = $conn->prepare("INSERT INTO ulasan (nama, komentar, tanggal) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $komentar, $tanggal);

    if ($stmt->execute()) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Komentar berhasil ditambahkan!'];
    } else {
        $_SESSION['alert'] = ['type' => 'error', 'message' => 'Gagal menambahkan komentar.'];
    }
} else {
    $_SESSION['alert'] = ['type' => 'warning', 'message' => 'Komentar tidak boleh kosong.'];
}

header("Location: landingpage.php#comment-section");
exit;
?>
