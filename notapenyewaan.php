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
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url('lapangan_CPO.jpeg') no-repeat;
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            align-items: center;
        }

        /* Navbar styling */
        .navbar {
            width: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: pink;
            position: relative;
            color: white;
            padding: 10px 20px;
            z-index: 999;
            background-color: #f9f9f9;
            margin-top: 0%;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .navbar-menu {
            display: flex;
            list-style: none;
            margin: 0;
            gap: -10px;
        }

        .menu-item {
            cursor: pointer;
            color: white;
            text-decoration: none;
        }

        .logo-cpo {
            width: auto;
            height: 40px;
            margin-left: 40px;
            margin-right: 4%;
        }

        /* Sidebar styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #5E0708;
            color: white;
            padding: 20px;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            text-decoration: none;
            gap: 10px;
            justify-content: flex-start;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar .menu-item {
            padding: 15px 10px;
            background: rgba(237, 226, 226, 0.1);
            border-radius: 4px;
            transition: background 0.3s, transform 0.2s;
            text-align: left;
            text-decoration: none;
            margin: 5px 0;
            list-style: none;
            color: white;
            width: 220px;
            margin-left: -5px;
        }

        .sidebar .menu-item a {
            text-decoration: none;
            color: #fff;
            display: block;
        }


        .sidebar .menu-item:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .close-button {
            background: none;
            border: none;
            font-size: 24px;
            color: white;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        /* Overlay styling */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 500;
        }

        .overlay.show {
            display: block;
        }

        .menu-button {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            display: block;
            color: black;
            margin-left: 3%;
        }

        /* sidebar */
        @media (min-width: 768px) {
            .sidebar {
                display: none;
            }

            .menu-button {
                display: none;
            }

        }

        /* hide menu */
        @media (max-width: 767px) {
            .navbar-menu {
                display: none;
            }
        }

        nav ul li {
            display: inline-block;
            list-style: none;
            margin: 10px 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: black;
            padding: 8px 0;
            transition: all;
            transition-duration: 300ms;
            border-bottom: 1px solid rgba(220, 20, 60, 0);
        }

        nav ul li a:hover {
            color: crimson;
            border-bottom: 1px solid crimson;
        }


        /* Dropdown Menu untuk Navbar Kecil */
        @media screen and (max-width: 768px) {
            nav ul {
                display: none;
            }

            nav.active ul {
                display: block;
                background-color: white;
                position: absolute;
                top: 60px;
                left: 0;
                width: 100%;
            }
        }

        /* Navbar */
        @media screen and (max-width: 768px) {
            .navbar {
                width: 100%;
                margin-top: 0%;
                padding: 0px 5px;
            }

            .container {
                width: 100%;
                padding: 15px;
            }

            .navbar-right {
                display: none;
            }

            .profile-pic {
                width: 35px;
                height: 35px;
            }

            .menu-button i {
                font-size: 1.2rem;
            }

            .close-button i {
                font-size: 1rem;
            }

            .logo-cpo {
                display: none;
            }
        }


        .nota {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #800000;
        }

        h3 {
            text-align: center;
            color: #600000;
        }

        .qrcode {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin: 20px auto;
        }

        .container {
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            width: 400px;
            max-width: 100%;
            display: none;
            margin: 20px auto;
        }

        .container h2 {
            color: #600000;
            margin-bottom: 20px;
        }

        @media screen and (max-width: 768px) {
            .container {
                width: 95%;
                padding: 10px;
            }
        }

        #qrcode {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            padding: 10px;
            border: 1px dashed #600000;
            border-radius: 8px;
            background: #f9f9f9;
        }

        .qrcode canvas {
            max-width: 120px;
            max-height: 120px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        button {
            background: #600000;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            transition: 0.3s;
            margin: 5px;
        }

        .button-container button:hover {
            background: #800000;
        }

        /* Tombol Lanjut */
        .next-container {
            margin-top: 20px;
            text-align: center;
        }

        .next-container a {
            text-decoration: none;
        }

        .next-button {
            display: inline-block;
            background: #008000;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
            margin-bottom: 2rem;
        }

        .next-button:hover {
            background: #006400;
        }

        #whatsapp-button {
            position: fixed;
            /* Membuat tombol tetap di posisi yang ditentukan */
            bottom: 20px;
            /* Jarak dari bawah */
            right: 20px;
            /* Jarak dari kanan */
            z-index: 1000;
            /* Pastikan tombol berada di atas konten lain */
        }

        #whatsapp-button img {
            width: 60px;
            /* Ukuran gambar tombol */
            height: 60px;
            /* Ukuran gambar tombol */
            border-radius: 50%;
            /* Membuat tombol berbentuk lingkaran */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            /* Menambahkan efek bayangan */
            transition: transform 0.3s ease;
            /* Animasi saat hover */
        }

        #whatsapp-button:hover img {
            transform: scale(1.1);
            /* Menambahkan efek pembesaran saat hover */
        }

        /* footer */
        .footer {
            background-color: #5e0708;
            padding: 70px 0;
        }

        .footer-container {
            max-width: 1170px;
            margin: auto;
        }

        .row {
            display: flex;
            flex-wrap: warp;
        }

        .footer-col {
            width: 25%;
            padding: 0 15px;
        }

        .footer-col h3 {
            font-size: 18px;
            color: white;
            text-transform: capitalize;
            margin-bottom: 30px;
        }

        .footer-col p {
            font-size: 18px;
            color: white;
            text-transform: capitalize;
            margin: 30px;
        }

        .footer-col a {
            font-size: 18px;
            color: white;
            text-decoration: none;
        }

        .footer-col ul li:not(:last-child) {
            margin-bottom: 10px;
        }

        .footer-col ul li a {
            font-size: 16px;
            text-transform: capitalize;
            color: #ffffff;
            text-decoration: none;
            font-weight: 300;
            color: #bbbbbb;
            display: block;
            transition: all 0.3s ease;
        }

        .footer-col ul li a:hover {
            color: #ffffff;
            padding-left: 8px;
        }

        .footer-col .social-links a {
            display: inline-block;
            height: 40px;
            width: 40px;
            background-color: rgba(255, 255, 255, 0.2);
            margin: 0 10px 10px 0;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            color: #ffffff;
            transition: all 0.5s ease;
        }

        .footer-col .social-links a:hover {
            color: #24262b;
            background-color: #ffffff;
        }

        .footer-col iframe {
            border-radius: 10px;
        }

        .footer-bottom {
            justify-content: center;
            align-items: center;
            display: flex;
        }

        ul {
            list-style: none;
        }


        /* Footer Responsif */
        @media screen and (max-width: 768px) {
            .footer-col {
                width: 100%;
                margin-bottom: 40px;
            }

            .row {
                flex-direction: column;
                align-items: center;
            }

            .footer-col iframe {
                width: 200px;
                height: auto;
            }
        }

        @media screen and (max-width: 480px) {
            .footer-col {
                width: 100%;
            }

            .footer-col p {
                margin: 20px 0;
            }

            .footer {
                padding: 40px 0;
            }

            .row {
                flex-direction: column;
                align-items: center;
            }

            .footer-col iframe {
                width: 200px;
                height: auto;
            }
        }
    </style>
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
                <hr>
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