<?php
session_start();
include 'koneksi.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Belum login']);
    exit;
}

$user_id = $_SESSION['user_id'];
$ulasan_id = isset($_POST['ulasan_id']) ? intval($_POST['ulasan_id']) : 0;
$feedback = $_POST['feedback'] ?? '';

if (!$ulasan_id || !in_array($feedback, ['ya', 'tidak'])) {
    echo json_encode(['status' => 'error', 'message' => 'Input tidak valid']);
    exit;
}

$cek = $conn->prepare("SELECT id FROM feedback_ulasan WHERE ulasan_id = ? AND user_id = ?");
$cek->bind_param("ii", $ulasan_id, $user_id);
$cek->execute();
$cekResult = $cek->get_result();

if ($cekResult->num_rows > 0) {
    echo json_encode(['status' => 'info', 'message' => 'Sudah memberi feedback']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO feedback_ulasan (ulasan_id, user_id, feedback, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iis", $ulasan_id, $user_id, $feedback);
if ($stmt->execute()) {
    $res = $conn->prepare("SELECT COUNT(*) AS ya FROM feedback_ulasan WHERE ulasan_id = ? AND feedback = 'ya'");
    $res->bind_param("i", $ulasan_id);
    $res->execute();
    $count = $res->get_result()->fetch_assoc();
    echo json_encode([
        'status' => 'success',
        'message' => 'Feedback tersimpan',
        'yaCount' => $count['ya']
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan feedback']);
}
