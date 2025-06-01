<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['alert'] = ['type' => 'error', 'message' => 'Silakan login terlebih dahulu!'];
    header("Location: halamanlogin.php");
    exit;
}

$komentar = htmlspecialchars($_POST['komentar']);
$bintang = isset($_POST['bintang']) ? intval($_POST['bintang']) : 0;
$tanggal = date('Y-m-d H:i:s');

if (empty($komentar)) {
    $_SESSION['alert'] = ['type' => 'warning', 'message' => 'Komentar tidak boleh kosong.'];
} elseif ($bintang < 1 || $bintang > 5) {
    $_SESSION['alert'] = ['type' => 'warning', 'message' => 'Silakan pilih rating bintang terlebih dahulu.'];
} else {
    $stmt = $conn->prepare("INSERT INTO ulasan (komentar, bintang, tanggal) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $komentar, $bintang, $tanggal);

    if ($stmt->execute()) {
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Ulasan berhasil ditambahkan!'];
    } else {
        $_SESSION['alert'] = ['type' => 'error', 'message' => 'Gagal menambahkan ulasan.'];
    }
}

header("Location: landingpage.php#comment-section");
exit;
?>
