<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
  $_SESSION['alert'] = ['type' => 'warning', 'message' => 'Silakan login untuk memberikan feedback!'];
  header("Location: landingpage.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$ulasan_id = intval($_POST['ulasan_id']);
$feedback = $_POST['feedback'];

if ($feedback !== 'ya' && $feedback !== 'tidak') {
  $_SESSION['alert'] = ['type' => 'error', 'message' => 'Feedback tidak valid.'];
  header("Location: landingpage.php");
  exit;
}

// Cek apakah user sudah memberikan feedback untuk ulasan ini
$cek = $conn->prepare("SELECT * FROM feedback_ulasan WHERE ulasan_id = ? AND user_id = ?");
$cek->bind_param("ii", $ulasan_id, $user_id);
$cek->execute();
$cekResult = $cek->get_result();

if ($cekResult->num_rows > 0) {
  $_SESSION['alert'] = ['type' => 'info', 'message' => 'Kamu sudah memberi feedback untuk ulasan ini.'];
  header("Location: landingpage.php");
  exit;
}

// Simpan feedback
$stmt = $conn->prepare("INSERT INTO feedback_ulasan (ulasan_id, user_id, feedback) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $ulasan_id, $user_id, $feedback);
if ($stmt->execute()) {
  $_SESSION['alert'] = ['type' => 'success', 'message' => 'Terima kasih atas feedback kamu!'];
} else {
  $_SESSION['alert'] = ['type' => 'error', 'message' => 'Gagal menyimpan feedback.'];
}

header("Location: landingpage.php");
exit;
