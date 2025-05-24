<?php
session_start();
$conn = new mysqli("localhost", "root", "", "db_usercpo");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            window.location.href='halamanlogin.php';
          </script>";
    exit;
}

function formatJamMenit($waktuString)
{
    $dateTime = DateTime::createFromFormat('H:i:s', $waktuString);
    return $dateTime ? $dateTime->format('H:i') : $waktuString;
}


$user_id = $_SESSION['user_id'] ?? null;
$fetch = ['Username' => 'Tamu'];

if ($user_id) {
    $stmt_user = $conn->prepare("SELECT Username FROM pelanggan WHERE id_pelanggan = ?");
    if ($stmt_user) {
        $stmt_user->bind_param("i", $user_id);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        if ($result_user->num_rows > 0) {
            $fetch = $result_user->fetch_assoc();
        }
        $stmt_user->close();
    }
}

// Proses Logout via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header("Location: halamanlogin.php");
    exit();
}

// Data bulan dan tahun
$months = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
];
$current_year = date('Y');
$years = range($current_year - 5, $current_year + 5);

$selected_month = $_GET['month'] ?? date('m');
$selected_year = $_GET['year'] ?? $current_year;

if (!preg_match('/^(0[1-9]|1[0-2])$/', $selected_month)) {
    $selected_month = date('m');
}
if (!in_array((int)$selected_year, $years)) {
    $selected_year = $current_year;
}

// Ambil data booking
$query = "SELECT username, no_lapangan, tanggal_transaksi, jam_mulai, jam_selesai FROM booking WHERE MONTH(tanggal_transaksi) = ? AND YEAR(tanggal_transaksi) = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Query gagal: " . $conn->error);
}
$stmt->bind_param("ss", $selected_month, $selected_year);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Jadwal</title>
    <link rel="stylesheet" href="jadwal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<body>
    <a href="https://wa.me/6285846801239" id="whatsapp-button" target="_blank">
        <img src="wa.png" alt="WhatsApp" />
    </a>
    <div class="container">
        <nav class="navbar">
            <img class="logo-cpo" src="images/logo-cpo.png" alt="Logo CPO">
            <button id="menu-button" class="menu-button">☰</button>
            <div class="navbar-right">
                <ul class="navbar-menu">
                    <li class="menu-item"><a href="landingpage.php">Beranda</a></li>
                    <li class="menu-item"><a href="halamanbooking.php">Pemesanan</a></li>
                    <li class="menu-item"><a href="notapenyewaan.php">Bukti Pesanan</a></li>
                    <li class="menu-item"><a href="jadwal.php">Jadwal</a></li>
                </ul>
            </div>
            <a href="#"><img src="images/icon.jpeg" class="profile-pic" onclick="toggleMenu()"></a>
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="images/icon.jpeg">
                        <h3><?php echo htmlspecialchars($fetch['Username']); ?></h3>
                    </div>
                    <hr>
                    <a href="profileuser.php" class="sub-menu-link">
                        <img src="images/setting.png">
                        <p>Edit Profil</p>
                        <span>></span>
                    </a>
                    <form method="POST" class="sub-menu-link" style="display: flex; align-items: center;">
                        <input type="hidden" name="logout" value="1">
                        <img src="images/logout.png" style="margin-right: 10px;">
                        <button type="submit" style="border: none; background: none; padding: 0; cursor: pointer;">
                            Logout
                        </button>
                        <span style="margin-left:auto;">></span>
                    </form>
                </div>
            </div>
        </nav>

        <div id="sidebar" class="sidebar">
            <button id="close-button" class="close-button">&times;</button>
            <h2 class="sidebar-title">Menu</h2>
            <ul class="sidebar-menu">
                <li class="menu-item"><a href="landingpage.php">Beranda</a></li>
                <li class="menu-item"><a href="halamanbooking.php">Pemesanan</a></li>
                <li class="menu-item"><a href="notapenyewaan.php">Bukti Pemesanan</a></li>
                <li class="menu-item"><a href="jadwal.php">Jadwal</a></li>
            </ul>
        </div>
        <div id="overlay" class="overlay"></div>
    </div>

    <div class="table-container">
        <div class="filter-container">
            <h2>JADWAL LAPANGAN BADMINTON CPO SPORT</h2><br>
            <form method="GET" action="">
                <label for="month">Pilih Bulan:</label>
                <select name="month" id="month" onchange="this.form.submit()">
                    <?php foreach ($months as $key => $month): ?>
                        <option value="<?php echo $key; ?>" <?php echo ($key == $selected_month) ? 'selected' : ''; ?>>
                            <?php echo $month; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="year">Pilih Tahun:</label>
                <select name="year" id="year" onchange="this.form.submit()">
                    <?php foreach ($years as $year): ?>
                        <option value="<?php echo $year; ?>" <?php echo ($year == $selected_year) ? 'selected' : ''; ?>>
                            <?php echo $year; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <div class="table">
            <div class="table-responsive">
                <table class="booking-table" border="1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penyewa</th>
                            <th>Lapangan</th>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if ($result->num_rows > 0) {
                            while ($tampildata = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>" . htmlspecialchars($no++) . "</td>
                                <td>" . htmlspecialchars($tampildata['username']) . "</td>
                                <td>" . htmlspecialchars($tampildata['no_lapangan']) . "</td>
                                <td>" . htmlspecialchars($tampildata['tanggal_transaksi']) . "</td>
                                <td>" . htmlspecialchars(formatJamMenit($tampildata['jam_mulai'])) . "</td>
                                <td>" . htmlspecialchars(formatJamMenit($tampildata['jam_selesai'])) . "</td>
                            </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' style='text-align: center;'>Jadwal Kosong</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="https://wa.me/6285846801239" id="whatsapp-button" target="_blank">
        <img src="wa.png" alt="WhatsApp" />
    </a>

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
                <p>Copyright <a href="Admin/loginadmin.php">@</a> 2025</p>
            </div>
        </div>
    </div>
    </footer>

    <script src="jadwal.js"></script>
    <script>
        AOS.init();

        function formatJamMenit(waktuString) {
            const date = new Date(`1970-01-01T${waktuString}`);
            const jam = String(date.getHours()).padStart(2, '0');
            const menit = String(date.getMinutes()).padStart(2, '0');
            return `${jam}:${menit}`;
        }
    </script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>