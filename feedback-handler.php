<?php
session_start();
include 'koneksi.php';


header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Belum login']);
    exit;
}

$user_id = intval($_SESSION['user_id']);
$ulasan_id = intval($_POST['ulasan_id'] ?? 0);
$feedback = $_POST['feedback'] ?? '';

if (!$ulasan_id || !in_array($feedback, ['ya', 'tidak'])) {
    echo json_encode(['success' => false, 'error' => 'Data tidak valid']);
    exit;
}

// Cek apakah user sudah pernah memberi feedback ke ulasan ini
$cek = $conn->prepare("SELECT * FROM feedback_ulasan WHERE user_id = ? AND ulasan_id = ?");
$cek->bind_param("ii", $user_id, $ulasan_id);
$cek->execute();
$hasil = $cek->get_result();

if ($hasil->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'Kamu sudah memberi feedback untuk ulasan ini.']);
    exit;
}

// Jika belum pernah, simpan feedback
$stmt = $conn->prepare("INSERT INTO feedback_ulasan (user_id, ulasan_id, feedback) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $user_id, $ulasan_id, $feedback);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Gagal menyimpan feedback']);
}



$ulasan_id = isset($_POST['ulasan_id']) ? intval($_POST['ulasan_id']) : 0;
$feedback = $_POST['feedback'] ?? '';

if ($ulasan_id > 0 && in_array($feedback, ['ya', 'tidak'])) {
    $stmt = $conn->prepare("INSERT INTO feedback_ulasan (ulasan_id, feedback) VALUES (?, ?)");
    $stmt->bind_param("is", $ulasan_id, $feedback);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
}
