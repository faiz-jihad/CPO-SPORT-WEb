<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_usercpo";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Koneksi database gagal."]);
    exit();
}

// Ambil data dari form
$phone = $_POST['phone'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validasi input
if (!$phone || !$new_password || !$confirm_password) {
    echo json_encode(["success" => false, "message" => "Harap isi semua field."]);
    exit();
}

if ($new_password !== $confirm_password) {
    echo json_encode(["success" => false, "message" => "Konfirmasi kata sandi tidak cocok."]);
    exit();
}

// Update password secara langsung TANPA hash
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE pelanggan SET password=? WHERE phone=?");
$stmt->bind_param("ss", $hashed_password, $phone);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo json_encode(["success" => true, "message" => "Kata sandi berhasil diperbarui."]);
} else {
    echo json_encode(["success" => false, "message" => "Nomor telepon tidak ditemukan atau tidak ada perubahan."]);
}

$stmt->close();
$conn->close();
?>
