<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "db_usercpo";

$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(["error" => "Koneksi gagal: " . $conn->connect_error]));
}

// Validasi session user_id
if (!isset($_SESSION['user_id'])) {
    die(json_encode(["error" => "Anda harus login terlebih dahulu"]));
}

$id_pelanggan = $_SESSION['user_id'];

// Ambil transaksi user dari tabel booking dengan semua kolom yang ada
$query = "SELECT no_transaksi, id_pelanggan, idAdmin, no_jadwal, tanggal_transaksi, 
                 no_lapangan, jam_mulai, jam_selesai, durasi, nomor_telepon, username
          FROM booking WHERE id_pelanggan = ? 
          ORDER BY tanggal_transaksi DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pelanggan);
$stmt->execute();
$result = $stmt->get_result();

// Ambil semua data dalam bentuk array
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Jika tidak ada transaksi
if (empty($data)) {
    echo json_encode(["error" => "Tidak ada transaksi yang Anda lakukan"]);
} else {
    echo json_encode(["transaksi" => $data]);
}

$stmt->close();
$conn->close();
?>
