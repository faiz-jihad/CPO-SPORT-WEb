<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    echo "Anda belum login.";
    exit;
}

if (!isset($_GET['id_booking'])) {
    echo "ID booking tidak ditemukan.";
    exit;
}

$id_booking = $_GET['id_booking'];
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM booking WHERE id_booking = ? AND id_pelanggan = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id_booking, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Data transaksi tidak ditemukan.";
    exit;
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            width: 280px;
            margin: 0 auto;
            padding: 20px;
            color: #000;
            background: #fff;
        }

        .center {
            text-align: center;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .item {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }

        .total {
            font-weight: bold;
        }

        .footer {
            font-size: 12px;
            text-align: center;
            margin-top: 15px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="center">
        <h3>MINIMARKETKU</h3>
        <small>Jl. Contoh No. 123</small><br>
        <small>Telp: 0812-3456-7890</small>
    </div>

    <div class="line"></div>

    <div class="item">
        <span>No. Booking</span>
        <span><?= $data['no_booking'] ?></span>
    </div>
    <div class="item">
        <span>Tanggal</span>
        <span><?= date('d-m-Y H:i', strtotime($data['tanggal'])) ?></span>
    </div>

    <div class="line"></div>

    <div class="item">
        <span>Jumlah Tiket</span>
        <span><?= $data['jumlah'] ?></span>
    </div>
    <div class="item">
        <span>Harga/Tiket</span>
        <span>Rp <?= number_format($data['harga'], 0, ',', '.') ?></span>
    </div>

    <div class="line"></div>

    <div class="item total">
        <span>Total