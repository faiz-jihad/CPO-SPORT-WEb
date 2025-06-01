<?php
include 'koneksi.php';
session_start();


// Default username untuk pengguna yang belum login
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Tamu";


?>



<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CPO SPORT</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="landingpage.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>


<?php if (isset($_SESSION['alert'])): ?>
  <script>
    Swal.fire({
      icon: '<?= $_SESSION['alert']['type']; ?>',
      title: '<?= $_SESSION['alert']['type'] === 'success' ? "Berhasil!" : "Oops!"; ?>',
      text: '<?= $_SESSION['alert']['message']; ?>',
      timer: 2500,
      showConfirmButton: false
    });
  </script>
  <?php unset($_SESSION['alert']); ?>
<?php endif; ?>


<?php
if (isset($_SESSION['alert'])) {
  var_dump($_SESSION['alert']); // debugging
  $alert = $_SESSION['alert'];
  echo "<div class='alert {$alert['type']}'>{$alert['message']}</div>";
  unset($_SESSION['alert']);
}
?>

<body>
  <div id="loading">
    <div class="loader-container">
      <div class="loader"></div>
      <p>Loading...</p>
    </div>
  </div>


  <div class="container">
    <nav class="navbar">
      <img class="logo-cpo" src="logo-cpo.png" alt="">
      <button id="menu-button" class="menu-button">☰</button>
      <div class="navbar-right">
        <ul class="navbar-menu">
          <li class="menu-item"><a href="#">Beranda</a></li>
          <li class="menu-item"><a href="halamanbooking.php">Pemesanan</a></li>
          <li class="menu-item"><a href="notapenyewaan.php">Bukti Pesanan</a></li>
          <li class="menu-item"><a href="jadwal.php">Jadwal</a></li>
        </ul>
      </div>
      <img src="icon.jpeg" class="profile-pic" onclick="toggleMenu()">
      <div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
          <div class="user-info">
            <img src="icon.jpeg">
            <h3><?php echo $username; ?></h3>
          </div>
          <hr>

          <a href="profileuser.php" class="sub-menu-link">
            <img src="setting.png">
            <p>Edit Profile</p>
            <span>></span>
          </a>
          <a href="logout.php" class="sub-menu-link">
            <img src="logout.png">
            <p>Logout</p>
            <span>></span>
          </a>
        </div>
      </div>

      <script>
        const subMenu = document.getElementById("subMenu");
        const profilePic = document.querySelector(".profile-pic");

        function toggleMenu() {
          subMenu.classList.toggle("open-menu");
        }

        // Tutup submenu kalau klik di luar
        document.addEventListener("click", function(event) {
          // Jika klik tidak di submenu dan tidak di tombol profil
          if (!subMenu.contains(event.target) && !profilePic.contains(event.target)) {
            subMenu.classList.remove("open-menu");
          }
        });
      </script>


    </nav>
    <div id="sidebar" class="sidebar">
      <button id="close-button" class="close-button">&times;</button>
      <h2 class="sidebar-title">Menu</h2>
      <ul class="sidebar-menu">
        <li class="menu-item"><a href="landingpage.php">Beranda</a></li>
        <li class="menu-item"><a href="halamanbooking.php">Pemesanan</a></li>
        <li class="menu-item"><a href="notapenyewaan.php">bukti Pesanan</a></li>
        <li class="menu-item"><a href="jadwal.php">Jadwal</a></li>
      </ul>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="overlay"></div>
  </div>



  <div class="fotohomepage">
    <img src="fotohomepage.png" class="foto-container" />
  </div>

  <!-- PHP  CONTAINER LAPANGAN -->
  <?php
  include 'koneksi.php';
  $query = mysqli_query($conn, "SELECT * FROM lapangan");
  ?>

  <div data-aos="fade-up" data-aos-duration="3000" class="lapangan">
    <h1>Lapangan yang tersedia</h1>
  </div>
  <div data-aos="fade-up" data-aos-duration="2000" class="card-container">

    <?php while ($data = mysqli_fetch_assoc($query)) : ?>
      <div class="card">

        <img src="<?= $data['gambar']; ?>" alt="<?= $data['namalapangan']; ?>" class="card-image">
        <div class="card-content">
          <div class="card-header">
            <h3 class="card-title"><?= $data['namalapangan']; ?></h3>
          </div>
          <div class="card-status">
            <p>Fasilitas</p>
            <?php
            $fasilitas = explode(",", $data['fasilitas']);
            foreach ($fasilitas as $item) {
              echo "<span class='status'>" . trim($item) . "</span>";
            }
            ?>
          </div>
          <a href="halamanbooking.php"><button class="booking-button">Booking sekarang</button></a>
        </div>
      </div>
    <?php endwhile; ?>

  </div>

  <!-- fasilitas -->
  <div class="fasilitas-teks">
    <h1>Fasilitas yang kami sediakan</h1>
  </div>

  <div data-aos="fade-up" data-aos-duration="2000" class="slider">
    <div class="list">
      <div class="item">
        <img src="fasilitas1_lapangan.jpeg" alt="">
        <div class="info">
          <h2>Lapangan standar internasional</h2>
        </div>
      </div>
      <div class="item">
        <img src="fasilitas1_lapangan.jpeg" alt="">
        <div class="info">
          <h2>Lapangan standar internasional</h2>
        </div>
      </div>
      <div class="item">
        <img src="fasilitas1_lapangan.jpeg" alt="">
        <div class="info">
          <h2>Lapangan standar internasional</h2>
        </div>
      </div>
      <div class="item">
        <img src="lapanganBadminton.jpeg" alt="">
        <div class="info">
          <h2>Lapangan standar internasional</h2>
        </div>
      </div>
      <div class="item">
        <img src="fasilitas1_lapangan.jpeg" alt="">
        <div class="info">
          <h2>Lapangan standar internasional</h2>
          <p>Lapangan Terbaik yang Pernah Ada dan Indah</p>
        </div>
      </div>
    </div>

    <!-- button prev dan next -->
    <div class="buttons">
      <button id="prev"><i class="fa-solid fa-caret-left"></i></button>
      <button id="next"><i class="fa-solid fa-caret-right"></i></button>
    </div>

    <!-- titik -->
    <ul class="dots">
      <li class="active"></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
    </ul>
  </div>


  <!-- form ulasan -->
  <form id="ulasanForm" action="ulasan.php" method="post" class="form-ulasan">
    <h3>Berikan Ulasan Anda</h3>

    <div class="rating" required>
      <input type="radio" name="bintang" value="5" id="star5"><label for="star5">★</label>
      <input type="radio" name="bintang" value="4" id="star4"><label for="star4">★</label>
      <input type="radio" name="bintang" value="3" id="star3"><label for="star3">★</label>
      <input type="radio" name="bintang" value="2" id="star2"><label for="star2">★</label>
      <input type="radio" name="bintang" value="1" id="star1"><label for="star1">★</label>
    </div>

    <textarea name="komentar" placeholder="Tulis ulasan Anda..." rows="5" required></textarea>
    <button type="submit">Kirim Ulasan</button>
  </form>

  <!-- validasi bintang -->
  <script>
    document.getElementById('ulasanForm').addEventListener('submit', function(e) {
      const ratingChecked = document.querySelector('input[name="bintang"]:checked');
      if (!ratingChecked) {
        e.preventDefault();

        Swal.fire({
          icon: 'warning',
          title: 'Oops...',
          text: 'Tolong masukkan bintang terlebih dahulu!',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Oke'
        });
      }
    });
  </script>

  <!-- feedback -->
  <?php
  $getFeedback = $conn->prepare("SELECT 
  SUM(feedback = 'ya') as ya, 
  SUM(feedback = 'tidak') as tidak FROM feedback_ulasan WHERE ulasan_id = ?");
  $getFeedback->bind_param("i", $ulasan['no_ulasan']);
  $getFeedback->execute();
  $feedbackResult = $getFeedback->get_result()->fetch_assoc();
  $yaCount = $feedbackResult['ya'] ?? 0;
  $tidakCount = $feedbackResult['tidak'] ?? 0;
  ?>



  <!-- tampilan ulasan -->
  <?php
  include 'koneksi.php';

  $query = "SELECT * FROM ulasan ORDER BY tanggal DESC LIMIT 5";
  $result = mysqli_query($conn, $query);
  ?>

  <div class="review-container">
    <h2>Ulasan</h2>
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

        <?php
        $ulasan_id = $row['no_ulasan'] ?? 0; // Ambil id dari ulasan yang sedang diloop
        $yaCount = 0;

        if ($ulasan_id) {
          $yaQuery = $conn->prepare("SELECT COUNT(*) AS yaCount FROM feedback_ulasan WHERE ulasan_id = ? AND LOWER(feedback) = 'ya'");
          $yaQuery->bind_param("i", $ulasan_id);
          $yaQuery->execute();
          $yaResult = $yaQuery->get_result();
          $yaData = $yaResult->fetch_assoc();
          $yaCount = $yaData['yaCount'] ?? 0;
        }
        ?>

        <div class="feedback-box" data-ulasan="<?= intval($row['no_ulasan']) ?>">

          <div class="review-feedback">
            <?= $yaCount ?> orang merasa ulasan ini berguna
          </div>
          <div class="feedback-actions">
            <div class="review-question">
              Apakah ulasan ini membantu Anda?
              <button class="feedback-btn" data-feedback="ya">Ya</button>
              <button class="feedback-btn" data-feedback="tidak">Tidak</button>
            </div>
          </div>
        </div>
      </div>

    <?php endwhile; ?>
    <div class="lihat-semua-ulasan">
      <span class="open-modal-ulasan">Lihat semua ulasan</span>
    </div>


    <!-- Modal Popup Ulasan -->
    <div id="modalUlasan" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <span class="close-btn">&times;</span>
          <h2>Semua Ulasan</h2>
        </div>

        <div class="modal-body" id="semua-ulasan-content">

          <?php
          $query = "SELECT * FROM ulasan ORDER BY tanggal DESC";
          $result = mysqli_query($conn, $query);
          ?>

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

              <?php
              $ulasan_id = $row['no_ulasan'] ?? 0; // Ambil id dari ulasan yang sedang diloop
              $yaCount = 0;

              if ($ulasan_id) {
                $yaQuery = $conn->prepare("SELECT COUNT(*) AS yaCount FROM feedback_ulasan WHERE ulasan_id = ? AND LOWER(feedback) = 'ya'");
                $yaQuery->bind_param("i", $ulasan_id);
                $yaQuery->execute();
                $yaResult = $yaQuery->get_result();
                $yaData = $yaResult->fetch_assoc();
                $yaCount = $yaData['yaCount'] ?? 0;
              }
              ?>

              <div class="feedback-box" data-ulasan="<?= intval($row['no_ulasan']) ?>">

                <div class="review-feedback">
                  <?= $yaCount ?> orang merasa ulasan ini berguna
                </div>
                <div class="feedback-actions">
                  <div class="review-question">
                    Apakah ulasan ini membantu Anda?
                    <button class="feedback-btn" data-feedback="ya">Ya</button>
                    <button class="feedback-btn" data-feedback="tidak">Tidak</button>
                  </div>
                </div>
              </div>
            </div>

          <?php endwhile; ?>
        </div>
        <div class="modal-footer">
          <button id="closeModalBtn">Tutup</button>
        </div>
      </div>
    </div>

  </div>


  <!-- modal -->
  <script>
    const modal = document.getElementById("modalUlasan");
    const openBtn = document.querySelector(".open-modal-ulasan");
    const closeBtn = document.querySelector(".close-btn");
    const closeFooterBtn = document.getElementById("closeModalBtn");

    // Tampilkan modal
    openBtn.addEventListener("click", () => {
      modal.classList.add("show");
      document.body.classList.add("modal-open"); // ⬅️ Kunci scroll
    });

    // Fungsi close modal
    const closeModal = () => {
      modal.classList.remove("show");
      document.body.classList.remove("modal-open"); // ⬅️ Buka scroll
    };

    closeBtn.addEventListener("click", closeModal);
    closeFooterBtn.addEventListener("click", closeModal);

    // Klik di luar konten modal = tutup
    window.addEventListener("click", (e) => {
      if (e.target === modal) {
        closeModal();
      }
    });
  </script>



  <!-- AJAX -->
  <script>
    document.querySelectorAll('.feedback-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const ulasanBox = this.closest('.feedback-box');
        const ulasanId = ulasanBox ? ulasanBox.getAttribute('data-ulasan') : null;
        const feedback = this.getAttribute('data-feedback');

        if (!ulasanId || !feedback) {
          Swal.fire('Gagal', 'Data feedback tidak lengkap.', 'error');
          return;
        }

        fetch('feedback-handler.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `ulasan_id=${ulasanId}&feedback=${feedback}`
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              Swal.fire('Terima kasih!', 'Feedback Anda telah dikirim.', 'success');
              // Disable tombol
              const buttons = ulasanBox.querySelectorAll('.feedback-btn');
              buttons.forEach(btn => btn.disabled = true);
            } else {
              Swal.fire('Gagal', 'Feedback gagal dikirim. ' + (data.error || ''), 'error');
            }
          })
          .catch(error => {
            Swal.fire('Error', 'Terjadi kesalahan jaringan.', 'error');
          });
      });
    });
  </script>
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <a href="https://wa.me/6285846801239" id="whatsapp-button" target="_blank">
    <img src="wa.png" alt="WhatsApp" />
  </a>

  <footer>
    <div class="footer">
      <div class="footer-container">
        <div class="row">
          <div class="footer-col">
            <h3>CPO SPORT</h3>
            <ul>
              <li><a href="About.php">Tentang Kami</a></li>
              <li><a href="Services.php">Layanan</a></li>
              <li><a href="Privacy Policy.php">Ketentuan</a></li>
            </ul>
          </div>
          <div class="footer-col">
            <h3>WhatsApp</h3>
            <div class="social-links">
              <a href="#"><i class="fab fa-whatsapp"></i></a>
            </div>
          </div>
          <div class="footer-col">
            <h3>Media sosial</h3>
            <div class="social-links">
              <a href="#"><i class="fab fa-facebook-f"></i></a>
              <a href="https://www.instagram.com/cposportscafe/"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-tiktok"></i></a>
            </div>
          </div>
          <div class="footer-col">
            <h3>LOKASI CPO</h3>
            <ul>
              <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7279.884218054315!2d108.301801!3d-6.366406!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6eb97c4aa0c2d7%3A0x40559ddd0a4514aa!2sCPO%20SPORT%20BADMINTON!5e1!3m2!1sid!2sid!4v1739893379402!5m2!1sid!2sid" width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </ul>
          </div>
        </div>
        <br>
        <hr>
        <div class="footer-col">
          <p>Polindra <a href="Admin/loginadmin.php">@</a> 2025</p>
        </div>
      </div>
    </div>
  </footer>

  <script>
    AOS.init();
  </script>
  <script src="landingpage.js"></script>
</body>

</html>