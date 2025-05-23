<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['login'])) {
    header('location:halamanlogin.php');
}

$conn = new mysqli("localhost", "root", "", "db_usercpo");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['tanggal']) && isset($_GET['lapangan'])) {
    $tanggal = $_GET['tanggal'];
    $lapangan = $_GET['lapangan'];

    // Ambil data jam yang sudah terbooking untuk tanggal dan lapangan tertentu
    $stmt = $conn->prepare("SELECT jam_mulai FROM pemesanan WHERE tanggal_transaksi = ? AND no_lapangan = ?");
    $stmt->bind_param("si", $tanggal, $lapangan);
    $stmt->execute();
    $result = $stmt->get_result();

    $jamTerbooking = [];
    while ($row = $result->fetch_assoc()) {
        $jamTerbooking[] = $row['jam_mulai'];
    }

    echo json_encode($jamTerbooking); // Mengirimkan data jam terbooking ke frontend
    $stmt->close();
    $conn->close();
}
?>
