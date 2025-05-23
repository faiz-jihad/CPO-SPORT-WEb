<?php
include 'koneksi.php';

$query = "SELECT nama, komentar, waktu FROM komentar ORDER BY waktu DESC";
$result = $conn->query($query);

$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

echo json_encode($comments);
?>
