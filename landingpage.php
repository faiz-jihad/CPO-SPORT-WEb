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

<body>
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
      <button id="prev"></button>
      <button id="next">></button>
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
  <div data-aos="fade-up" data-aos-duration="2000" id="comment-section">
    <h2>Ulasan</h2>

    <!-- Form komentar -->
    <div id="comment-form">
      <p>Berikan Ulasan Anda</p>
      <form id="ulasanForm" method="post">
        <textarea id="commentText" name="komentar" placeholder="Ketik ulasan anda..." required></textarea>
        <button class="comment-btn" type="submit">Kirim ulasan</button>
      </form>
    </div>

    <!-- Daftar komentar -->
    <div class="section">
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <?php
          include 'koneksi.php';
          $query = mysqli_query($conn, "SELECT * FROM ulasan ORDER BY tanggal DESC LIMIT 10");
          while ($row = mysqli_fetch_assoc($query)) :
          ?>
            <div class="swiper-slide">
              <div class="testimonialbox">
                <div class="user-info">
                  <img src="iconkomen.jpg" alt="quote" class="quote">
                  <strong class="nama"><?= htmlspecialchars($row['nama']); ?></strong><br>
                  <small class="tanggal"><?= date('d M Y', strtotime($row['tanggal'])); ?></small>
                </div>
                <div class="komentar">
                  <p><?= nl2br(htmlspecialchars($row['komentar'])); ?></p>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </div>
  <!-- <swiper-container class="mySwiper" pagination="true" effect="coverflow" grab-cursor="true" centered-slides="true"
          slides-per-view="auto" coverflow-effect-rotate="50" coverflow-effect-stretch="0" coverflow-effect-depth="100"
          coverflow-effect-modifier="1" coverflow-effect-slide-shadows="true">
          <swiper-slide>
            <img src=" https://swiperjs.com/demos/images/nature-1.jpg" />
            … <img src="https://swiperjs.com/demos/images/nature-8.jpg" />
          </swiper-slide>
          <swiper-slide>
            <img src="https://swiperjs.com/demos/images/nature-9.jpg" />
          </swiper-slide>
        </swiper-container> -->

  </section>
  </div>
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
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    const swiper = new Swiper('.swiper', {
      loop: true,
      pagination: {
        spaceBetween: 10,
        el: '.swiper-pagination',
        clickable: true
      },
      autoplay: {
        delay: 3000, // 3000ms = 3 detik
        disableOnInteraction: false, // agar autoplay tetap berjalan meskipun pengguna berinteraksi
      },
      breakpoints: {
        0: {
          slidesPerView: 1
        },
        600: {
          slidesPerView: 1.2
        },
        768: {
          slidesPerView: 1.5
        },
        1024: {
          slidesPerView: 2
        },
      }
    });
  </script>
  <script>
    AOS.init();
  </script>
  <script src="landingpage.js"></script>
</body>

</html>