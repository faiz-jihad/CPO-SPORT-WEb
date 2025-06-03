<?php
ob_start();
include 'koneksi.php';
session_start();

$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Tamu";

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            window.location.href='halamanlogin.php';
          </script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data pengguna dari database
$query = "SELECT * FROM pelanggan WHERE id_pelanggan = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $fetch = $result->fetch_assoc();
} else {
    echo "<script>
            alert('Data pengguna tidak ditemukan!');
            window.location.href='halamanlogin.php';
          </script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update_nama = $_POST['update_nama'];
    $update_username = $_POST['update_username'];
    $update_phone = $_POST['update_phone'];
    $update_password = $_POST['update_password'];

    // Cek apakah password diisi
    if (!empty($update_password)) {
        // Jika password diisi, update langsung TANPA HASH
        $hashed_password = password_hash($update_password, PASSWORD_DEFAULT);
        $query = "UPDATE pelanggan SET Nama = ?, Username = ?, Phone = ?, Password = ? WHERE id_pelanggan = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $update_nama, $update_username, $update_phone, $hashed_password, $user_id);
    } else {
        // Jika password tidak diubah, update tanpa menyentuh kolom password
        $query = "UPDATE pelanggan SET Nama = ?, Username = ?, Phone = ? WHERE id_pelanggan = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $update_nama, $update_username, $update_phone, $user_id);
    }

    // Jalankan query update
    if ($stmt->execute()) {
        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                swal({
                    title: 'Sukses!',
                    text: 'Data berhasil diperbarui!',
                    icon: 'success',
                    button: 'OK'
                }).then((value) => {
                    window.location.href = 'landingpage.php';
                });
            });
            </script>";
    } else {
        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                swal({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan: " . $stmt->error . "',
                    icon: 'error',
                    button: 'Coba Lagi'
                });
            });
            </script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="profileuser.css">
    <style>
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

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
                        <li class="menu-item"><a href="landingpage.php">Beranda</a></li>
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

        <div class="profile-container">
            <div class="profile-box">
                <h2>Profil Pengguna</h2>
                <form action="profileuser.php" method="post">
                    <div class="input-group">
                        <label>Nama Lengkap:</label>
                        <input type="text" name="update_nama" value="<?php echo htmlspecialchars($fetch['Nama']); ?>" required>
                    </div>

                    <div class="input-group">
                        <label>Username:</label>
                        <input type="text" name="update_username" value="<?= htmlspecialchars($fetch['Username']); ?>" required>
                    </div>

                    <div class="input-group">
                        <label>Nomor HP:</label>
                        <input type="text" name="update_phone" value="<?= htmlspecialchars($fetch['Phone']); ?>" required>
                    </div>

                    <div class="input-group">
                        <label>Password</label>
                        <input type="password" id="password" name="update_password" placeholder="Kosongkan jika tidak diubah">
                    </div>

                    <div class=" checkbox-container">
                        <input type="checkbox" id="togglePassword">
                        <label for="togglePassword">Tampilkan Password</label>
                    </div>

                    <button type="submit" class="btn">Simpan Perubahan & Kembali</button>
                </form>
            </div>
        </div>
        <a href="https://wa.me/6285846801239" id="whatsapp-button" target="_blank">
            <img src="wa.png" alt="WhatsApp" />
        </a>

        <script>
            // loading
            window.addEventListener("load", function() {
                const loader = document.getElementById("loading");
                loader.style.opacity = "0";
                setTimeout(() => {
                    loader.style.display = "none";
                }, 500);
            });


            // sidebar.js
            document.addEventListener("DOMContentLoaded", function() {
                const menuButton = document.getElementById("menu-button");
                const sidebar = document.getElementById("sidebar");
                const overlay = document.getElementById("overlay");
                const closeButton = document.getElementById("close-button");

                // Open sidebar when the menu button is clicked
                menuButton.addEventListener("click", function() {
                    sidebar.classList.add("open");
                    overlay.classList.add("show");
                });

                // Close sidebar when the overlay or close button is clicked
                overlay.addEventListener("click", closeSidebar);
                closeButton.addEventListener("click", closeSidebar);

                function closeSidebar() {
                    sidebar.classList.remove("open");
                    overlay.classList.remove("show");
                }

                // Handle selecting a field
                document.querySelectorAll(".card-title").forEach((item) => {
                    item.addEventListener("click", function() {
                        const selectedField = this.textContent;
                        localStorage.setItem("selectedField", selectedField);
                        window.location.href = "halamanbooking.html"; // Redirect to the booking page
                    });
                });
            });

            // Tampilkan atau sembunyikan password
            document.getElementById('togglePassword').addEventListener('change', function() {
                const passwordInput = document.getElementById('password');
                passwordInput.type = this.checked ? 'text' : 'password';
            });

            function checkScreenSize() {
                if (window.innerWidth <= 768) { // Jika layar HP (≤ 768px)
                    document.querySelector('.container').classList.add('show');
                } else {
                    document.querySelector('.container').classList.add('show');
                }
            }

            // Cek ukuran layar saat halaman dimuat
            document.addEventListener("DOMContentLoaded", checkScreenSize);

            // Cek ukuran layar saat jendela diubah
            window.addEventListener("resize", checkScreenSize);
        </script>

    </body>

</html>