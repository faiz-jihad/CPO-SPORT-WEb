<?php
session_start();
require_once 'koneksi.php';
// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika tidak login, kirimkan error dan redirect ke halaman login
    echo json_encode(["error" => "Sesi tidak ditemukan, silakan login"]);
    header('Location: halamanlogin.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Debug: Pastikan ID user benar
// echo "User ID: " . $user_id;

// Query untuk mengambil semua transaksi berdasarkan user_id
$query = "SELECT * FROM booking WHERE id_pelanggan = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Ambil semua data dalam bentuk array
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);

// Jika tidak ada transaksi
if (empty($data)) {
    echo json_encode(["error" => "Tidak ada transaksi yang Anda lakukan"]);
} else {
    echo json_encode($data);
}

$stmt->close();
$conn->close();
?>
