<?php
include 'koneksi.php';
session_start();

if (isset($_POST['tanggal_transaksi']) && isset($_POST['no_lapangan'])) {
    $tanggal = $_POST['tanggal_transaksi'];
    $lapangan = $_POST['no_lapangan'];

    $stmt = $conn->prepare("SELECT jam_mulai, jam_selesai FROM booking WHERE tanggal_transaksi = ? AND no_lapangan = ?");
    $stmt->bind_param("si", $tanggal, $lapangan);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookedTimes = [];

    while ($row = $result->fetch_assoc()) {
        $start = (int)explode(':', $row['jam_mulai'])[0];
        $end = (int)explode(':', $row['jam_selesai'])[0];

        // Tandai semua jam yang termasuk dalam rentang
        for ($i = $start; $i < $end; $i++) {
            $bookedTimes[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
        }
    }

    echo json_encode($bookedTimes);
    exit;
}
?>