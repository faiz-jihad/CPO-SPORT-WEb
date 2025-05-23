<?php
include 'koneksi.php';
session_start();

function showAlert($icon, $message, $redirectUrl)
{
    echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            swal({
                title: '$message',
                icon: '$icon',
                button: 'OK'
            }).then(() => {
                window.location.href = '$redirectUrl';
            });
        });
    </script>";
    exit();
}

// Cek login
if (!isset($_SESSION['user_id'])) {
    showAlert('warning', 'Harap Login Terlebih Dahulu!', 'halamanlogin.php');
}

// Ambil data dari POST
$id_pelanggan       = $_SESSION['user_id'];
$username           = $_POST['username'] ?? '';
$nomor_telepon      = $_POST['nomorTelepon'] ?? '';
$no_lapangan        = $_POST['no_lapangan'] ?? '';
$tanggal_transaksi  = $_POST['tanggal_transaksi'] ?? '';
$jam_input          = $_POST['jamMulai'] ?? '';
$durasi             = isset($_POST['durasi']) ? intval($_POST['durasi']) : 1;
$id_admin           = null; // Default null, bisa diisi jika sistem mendukung admin

// Validasi input
if (empty($username) || empty($nomor_telepon) || empty($no_lapangan) || empty($tanggal_transaksi) || empty($jam_input) || $durasi <= 0) {
    showAlert('error', 'Semua kolom harus diisi!', 'halamanbooking.php');
}

// Format waktu mulai dan selesai
$jam_mulai   = $tanggal_transaksi . ' ' . $jam_input . ':00';
$jam_selesai = date("Y-m-d H:i:s", strtotime("$jam_mulai +$durasi hours"));

// Hitung harga berdasarkan jam mulai
$jam = intval(date("H", strtotime($jam_mulai)));
$harga_per_jam = ($jam < 18) ? 35000 : 40000;
$total_harga = $durasi * $harga_per_jam;

// Cek apakah sudah ada booking bentrok
$query = "SELECT jam_mulai, jam_selesai FROM booking
            WHERE no_lapangan = ? AND tanggal_transaksi = ?
            AND (? < jam_selesai AND ? > jam_mulai)";

$cek_booking = $conn->prepare($query);
$cek_booking->bind_param("ssss", $no_lapangan, $tanggal_transaksi, $jam_mulai, $jam_selesai);
$cek_booking->execute();
$result = $cek_booking->get_result();

if ($result->num_rows > 0) {
    $cek_booking->close();
    showAlert('error', 'Jam yang Anda pilih sudah dibooking!', 'halamanbooking.php');
}
$cek_booking->close();

// Buat nomor transaksi unik
$no_transaksi = uniqid('TRX_' . time());

// Simpan booking ke database
$stmt = $conn->prepare("INSERT INTO booking (
    no_transaksi, id_pelanggan, username, nomor_telepon, no_lapangan,
    tanggal_transaksi, jam_mulai, durasi, jam_selesai, idAdmin, total_harga
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "sssssssissi",
    $no_transaksi,
    $id_pelanggan,
    $username,
    $nomor_telepon,
    $no_lapangan,
    $tanggal_transaksi,
    $jam_mulai,
    $durasi,
    $jam_selesai,
    $id_admin,
    $total_harga
);

if ($stmt->execute()) {
    showAlert('success', 'Booking Berhasil!', 'notapenyewaan.php');
} else {
    $error_message = htmlspecialchars($stmt->error);
    showAlert('error', "Terjadi kesalahan saat booking: $error_message", 'halamanbooking.php');
}

$stmt->close();
$conn->close();
?>
