<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            window.location.href='halamanlogin.php';
          </script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nota Transaksi</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="notapenyewaan.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <img class="logo-cpo" src="logo-cpo.png" alt="">
        <button class="menu-button" id="menu-button"><i class="fa-solid fa-bars"></i></button>
        <div class="navbar-right">
            <ul class="navbar-menu">
                <li class="menu-item"><a href="landingpage.php">Beranda</a></li>
                <li class="menu-item"><a href="halamanbooking.php">Pemesanan</a></li>
                <li class="menu-item"><a href="notapenyewaan.php">Bukti Pemesanan</a></a></li>
                <li class="menu-item"><a href="jadwal.php">Jadwal</a></li>
            </ul>
        </div>
    </nav>
    <div id="sidebar" class="sidebar">
        <button id="close-button" class="close-button"><i class="fa-solid fa-xmark"></i></button>
        <h2 class="sidebar-title">Menu</h2>
        <ul class="sidebar-menu">
            <li class="menu-item"><a href="landingpage.php">Beranda</a></li>
            <li class="menu-item"><a href="halamanbooking.php">Booking</a></li>
            <li class="menu-item"><a href="notapenyewaan">Bukti Pemesanan</a></li>
            <li class="menu-item"><a href="jadwal.php">Jadwal</a></li>
        </ul>
    </div>
    <div data-aos="fade-up"
             data-aos-duration="20000">
        <div class="container" id="container">
            <h2>Bukti Pembayaran</h2>
            <div id="nota" class="nota">
                <p><b>Nama:</b> <span id="outNama"></span></p>
                <p><b>No. Transaksi:</b> <span id="outTransaksi"></span></p>
                <p><b>Telepon:</b> <span id="outTelepon"></span></p>
                <p><b>Tanggal:</b> <span id="outTanggal"></span></p>
                <p><b>Lapangan:</b> <span id="outLapangan"></span></p>
                <p><b>Jam Mulai:</b> <span id="outJamMulai"></span></p>
                <p><b>Jam Selesai:</b> <span id="outJamSelesai"></span></p>
                <p><b>Durasi:</b> <span id="outDurasi"></span></p>
                <div id="qrcode"></div>
                <div class="button-container">
                    <button onclick="cetakJPG()">Cetak Nota</button>
                    <a href="landingpage.php"><button>Lanjut</button></a>
                </div>
            </div>
        </div>


    </div>
    <a href="https://wa.me/6285846801239" id="whatsapp-button" target="_blank">
        <img src="wa.png" alt="WhatsApp" />
    </a>


    <!-- Overlay -->
    <div id="overlay" class="overlay"></div>

    <!-- Tombol Lanjut -->
    <div class="next-container">
        <a href="landingpage.php">
            <div class="next-button">Selesai</div>
        </a>
    </div>

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
                <div class="footer-col">
                    <p>Polindra <a href="Admin/loginadmin.php">@</a> 2025</p>
                </div>
            </div>
        </div>
    </footer>


    <script>
        AOS.init();
        // Format Waktu
        function formatJamMenit(waktuString) {
            const date = new Date(`1970-01-01T${waktuString}`);
            const jam = String(date.getHours()).padStart(2, '0');
            const menit = String(date.getMinutes()).padStart(2, '0');
            return `${jam}:${menit}`;
        }


        function cetakJPGById(id) {
            const element = document.getElementById(id);

            if (!element) {
                Swal.fire("Error", "Elemen tidak ditemukan!", "error");
                return;
            }

            Swal.fire({
                title: "Cetak Bukti Pembayaran?",
                text: "File akan diunduh sebagai gambar",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#600000",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Cetak!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    html2canvas(element).then(canvas => {
                        const imgData = canvas.toDataURL("image/png");
                        const link = document.createElement('a');
                        link.href = imgData;
                        link.download = "bukti_booking_Sewa_lapangan.jpg";
                        link.click();
                        Swal.fire("Berhasil!", "Bukti pembayaran telah diunduh.", "success");
                    }).catch(error => {
                        Swal.fire("Gagal!", "Terjadi kesalahan saat mencetak.", "error");
                        console.error(error);
                    });
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById('container');
            const menuButton = document.getElementById('menu-button');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const closeButton = document.getElementById('close-button');

            // Sidebar event
            menuButton.addEventListener('click', function() {
                sidebar.classList.add('open');
                overlay.classList.add('show');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
            });

            closeButton.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
            });

            // Fetch transaksi data
            fetch("getData.php")
                .then(response => response.json())
                .then(data => {
                    if (data.error || !data.transaksi || data.transaksi.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak Ada Transaksi',
                            text: data.error || 'Anda belum melakukan transaksi.',
                            confirmButtonText: 'Pesan Sekarang'
                        }).then(() => {
                            window.location.href = "halamanbooking.php";
                        });
                        return;
                    }

                    container.innerHTML = ""; // Clear container

                    data.transaksi
                        .sort((a, b) => b.no_transaksi.localeCompare(a.no_transaksi))
                        .forEach((transaksi, index) => {
                            const notaDiv = document.createElement('div');
                            notaDiv.className = 'nota';
                            notaDiv.id = `nota-${index}`;
                            notaDiv.innerHTML = `
                            <p style=font-weight=bold>Bukti Transaksi Sewa Lapangan</p>
                        <p><b>Nama:</b> ${transaksi.username}</p>
                        <p><b>No. Transaksi:</b> ${transaksi.no_transaksi}</p>
                        <p><b>Telepon:</b> ${transaksi.nomor_telepon}</p>
                        <p><b>Tanggal:</b> ${transaksi.tanggal_transaksi}</p>
                        <p><b>Lapangan:</b> ${transaksi.no_lapangan}</p>
                        <p><b>Jam Mulai:</b> ${formatJamMenit(transaksi.jam_mulai)}</p>
                        <p><b>Jam Selesai:</b> ${formatJamMenit(transaksi.jam_selesai)} </p>
                        <p><b>Durasi:</b> ${transaksi.durasi} jam</p>
                        <div id="qrcode-${index}" class="qrcode"></div>
                        <div class="button-container">
                            <button onclick="cetakJPGById('nota-${index}')">Cetak JPG</button>
                        </div>
                    `;
                            container.appendChild(notaDiv);

                            // Generate QR code
                            const qrText = `Nama: ${transaksi.username}
No Transaksi: ${transaksi.no_transaksi}
Lapangan: ${transaksi.no_lapangan}
Durasi: ${transaksi.durasi} jam
Tanggal: ${transaksi.tanggal_transaksi}
Waktu Mulai: ${formatJamMenit(transaksi.jam_mulai)}
Waktu Selesai: ${formatJamMenit(transaksi.jam_selesai)}`;
                            new QRCode(document.getElementById(`qrcode-${index}`), {
                                text: qrText,
                                width: 150,
                                height: 150
                            });
                        });

                    container.style.display = 'block';
                })
                .catch(error => {
                    console.error("Gagal mengambil data:", error);
                    Swal.fire("Gagal", "Gagal memuat data transaksi.", "error");
                });
        });
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>