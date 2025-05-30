<?php
include 'koneksi.php';

$query = "SELECT * FROM ulasan ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Semua Ulasan</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 20px;
    }
    .review-container {
      max-width: 800px;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
    .review-card {
      border-bottom: 1px solid #eee;
      padding: 20px 0;
    }
    .review-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .review-user {
      display: flex;
      align-items: center;
    }
    .review-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 12px;
    }
    .review-username {
      font-weight: bold;
      font-size: 16px;
    }
    .review-date {
      font-size: 13px;
      color: #888;
    }
    .review-stars {
      margin-top: 4px;
    }
    .star {
      font-size: 16px;
      color: #ccc;
    }
    .star.filled {
      color: #f4b400;
    }
    .review-text {
      font-size: 15px;
      margin: 12px 0;
      line-height: 1.6;
    }
    .review-feedback {
      font-size: 13px;
      color: #666;
      margin-bottom: 6px;
    }
    .review-question {
      font-size: 14px;
      color: #444;
    }
    .btn-feedback {
      background: #fff;
      border: 1px solid #ccc;
      padding: 6px 14px;
      margin: 0 4px;
      border-radius: 20px;
      cursor: pointer;
      transition: 0.2s;
    }
    .btn-feedback:hover {
      background: #eee;
    }
  </style>
</head>
<body>
  <div class="review-container">
    <h2>Semua Ulasan</h2>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="review-card">
        <div class="review-header">
          <div class="review-user">
            <img src="iconkomen.jpg" class="review-avatar">
            <div>
              <div class="review-username"><?= htmlspecialchars($row['nama']) ?></div>
              <div class="review-stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <span class="star <?= $i <= $row['bintang'] ? 'filled' : '' ?>">★</span>
                <?php endfor; ?>
              </div>
            </div>
          </div>
          <div class="review-date">
            <?= date('d M Y', strtotime($row['tanggal'])) ?>
          </div>
        </div>
        <div class="review-text"><?= nl2br(htmlspecialchars($row['komentar'])) ?></div>
        <div class="review-feedback">
          <?= rand(100, 5000) ?> orang merasa ulasan ini berguna
        </div>
        <div class="review-question">
          Apakah konten ini berguna bagi Anda?
          <button class="btn-feedback">Ya</button>
          <button class="btn-feedback">Tidak</button>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>