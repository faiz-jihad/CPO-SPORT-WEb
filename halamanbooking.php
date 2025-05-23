<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['login'])) {
    header('location:halamanlogin.php');
}
$conn = new mysqli("localhost", "root", "", "db_usercpo");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_id = $_SESSION['user_id'] ?? null;
$fetch = ['Username' => 'Tamu'];

$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Tamu";

if ($user_id) {


    $stmt = $conn->prepare("SELECT Username FROM pelanggan WHERE id_pelanggan = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $fetch = $result->fetch_assoc();
    }

    $stmt->close();
    $conn->close();
}

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header("location:halamanlogin.php");
};

?>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Lapangan</title>
    <link rel="stylesheet" href="halamanbooking.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </script>
</head>

<body>
    <div class="container">
        <nav class="navbar">
            <img class="logo-cpo" src="logo-cpo.png" alt="">
            <button id="menu-button" class="menu-button">☰</button>
            <div class="navbar-right">
                <ul class="navbar-menu">
                    <li class="menu-item"><a href="landingpage.php">Beranda</a></li>
                    <li class="menu-item"><a href="">Pemesanan</a></li>
                    <li class="menu-item"><a href="notapenyewaan.php">Bukti Pesanan</a></li>
                    <li class="menu-item"><a href="jadwal.php">Jadwal</a></li>
                </ul>
            </div>
            <img src="icon.jpeg" class="profile-pic" onclick="toggleMenu()">
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="icon.jpeg">
                        <h3>
                            <?php echo $username; ?>
                        </h3>
                    </div>
                    <hr>

                    <a href="profileuser.php" class="sub-menu-link">
                        <img class="submenu-foto" src="setting.png">
                        <p>Edit Profile</p>
                        <span>></span>
                    </a>
                    <a href="logout.php" class="sub-menu-link">
                        <img class="submenu-foto" src="logout.png">
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
                <li class="menu-item"><a href="#">Pemesanan</a></li>
                <li class="menu-item"><a href="notapenyewaan.php">Bukti Pesanan</a></li>
                <li class="menu-item"><a href="jadwal.php">Jadwal</a></li>
            </ul>
        </div>

        <!-- Overlay -->
        <div id="overlay" class="overlay"></div>
    </div>

    <div class="booking-container" x-data="bookingLapangan()">
        <div class="booking">
            <h1>Booking Lapangan</h1>
            <form action="booking.php" method="POST" id="booking">
                <label>Nama</label>
                <input type="text" name="username" x-model="nama" placeholder="masukan nama anda" required>

                <label>Nomor Telepon</label>
                <input type="text" name="nomorTelepon" x-model="nomorTelepon" placeholder="masukan nomer telepon"
                    required>

                <label>Pilih Lapangan</label>
                <select name="no_lapangan" x-model="lapanganDipilih" required>
                    <option value="">-- Pilih Lapangan --</option>
                    <option value="1">Lapangan 1</option>
                    <option value="2">Lapangan 2</option>
                </select>

                <label>Tanggal Pemesanan</label>
                <input type="date" name="tanggal_transaksi" x-model="tanggalBooking"
                    :min="new Date().toISOString().split('T')[0]" required>

                <!-- button jam -->
                <label for="">Pilih Jam Mulai</label>
                <div id="button-container"></div>
                <input type="hidden" name="jamMulai" x-model="jamMulai" @input="hitungJamSelesai()">



                <label>Pilih Durasi (jam)</label>
                <!-- <input type="number" name="durasi" x-model="durasi" :max="maxDurasi" min="1" @input="hitungJamSelesai()"
                    required> -->
                <div class="durasi-control">
                    <button type="button" class="durasi-button" @click="kurangiDurasi">&minus;</button>
                    <span class="durasi-display" x-text="durasi + ' jam'"></span>
                    <button type="button" class="durasi-button" @click="tambahDurasi">&plus;</button>
                </div>

                <!-- Tambahkan ini -->
                <input type="hidden" name="durasi" x-model="durasi">





                <label>Jam Selesai</label>
                <input type="time" name="jamSelesai" x-model="jamSelesai" readonly>

                <div class="kategori-harga">
                    <p><strong>Kategori Harga</strong></p>
                    <ul>
                        <li>Siang (07:00 - 17:59) → Rp 35.000 / jam</li>
                        <li>Malam (18:00 - 23:59) → Rp 40.000 / jam</li>
                    </ul>
                </div>

                <div class="harga-container">
                    <p>Total Harga: <span x-text="formatRupiah(hitungTotalHarga())"></span></p>
                </div>
                <button type="submit" class="pay-btn disabled" id="pay-btn">Booking</button>
            </form>
            <p class="note">*note: pastikan datang sebelum waktu dimulai</p>
            <br>
        </div>
    </div>

    <!-- footer -->
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
                    <p>Copyright <a href="Admin/loginadmin.php">@</a> 2025</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("#booking");
            const paymentButton = document.querySelector("#pay-btn");
            const totalHargaSpan = document.querySelector("#total-harga");
            document.querySelector("[name='tanggal_transaksi']").addEventListener("change", updateTombolJamSimulasi);
            document.querySelector("[name='no_lapangan']").addEventListener("change", updateTombolJamSimulasi);


            function hitungTotalHarga() {
                const jamMulai = form.querySelector("[name='jamMulai']").value;
                const durasi = parseInt(form.querySelector("[name='durasi']").value) || 0;
                if (!jamMulai || durasi <= 0) {
                    totalHargaSpan.textContent = "Rp 0";
                    return;
                }

                let jamMulaiInt = parseInt(jamMulai.split(":")[0]);
                let hargaPerJam = (jamMulaiInt >= 18) ? 40000 : 35000;
                let total = durasi * hargaPerJam;
                totalHargaSpan.textContent = `Rp ${total.toLocaleString("id-ID")}`;
            }

            function checkFormValidity() {
                let isValid = true;
                form.querySelectorAll("[required]").forEach(input => {
                    if (input.value.trim() === "") {
                        isValid = false;
                    }
                });

                paymentButton.disabled = !isValid;
                paymentButton.classList.toggle('disabled', !isValid);
            }

            form.addEventListener("input", function() {
                checkFormValidity();
                hitungTotalHarga();
            });

            checkFormValidity();
        });



        window.addEventListener("scroll", function() {
            var navbar = document.querySelector(".navbar");
            if (window.scrollY > 50) {
                navbar.classList.add("shrink");
            } else {
                navbar.classList.remove("shrink");
            }
        });

        // sub menu
        const subMenu = document.getElementById('subMenu');
        const profilePic = document.querySelector('.profile-pic');

        document.addEventListener('click', (event) => {
            if (event.target === profilePic) {
                subMenu.classList.toggle('open-menu');

            } else if (!subMenu.contains(event.target)) {
                subMenu.classList.remove('open-menu');
            }
        });

        // fungsi sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('menu-button');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const closeButton = document.getElementById('close-button');

            // Buka sidebar
            menuButton.addEventListener('click', function() {
                sidebar.classList.add('open');
                overlay.classList.add('show');
            });

            // Tutup sidebar
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
            });

            closeButton.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
            });
        });


        // fungsi booking
        function bookingLapangan() {
            return {
                nama: '',
                nomorTelepon: '',
                lapanganDipilih: '',
                tanggalBooking: '',
                jamMulai: '',
                jamSelesai: '',
                durasi: 1,

                hitungJamSelesai() {
                    if (this.jamMulai && this.durasi) {
                        if (!this.isWaktuValid()) return; // validasi waktu

                        const [jam, menit] = this.jamMulai.split(':').map(Number);
                        const jamSelesai = jam + this.durasi;

                        if (jam < 7 || jam >= 24) {
                            this.jamSelesai = "";
                            swal("Jam tidak valid", "Jam mulai harus antara 07:00 dan 23:00", "warning");
                            return;
                        }

                        if (jamSelesai > 24) {
                            this.jamSelesai = "";
                            swal("Durasi terlalu panjang", "Jam selesai melebihi jam operasional (maksimal jam 24:00)", "warning");
                            return;
                        }

                        let jamSelesaiFormatted = new Date(`2023-01-01T${this.jamMulai}`);
                        jamSelesaiFormatted.setHours(jamSelesaiFormatted.getHours() + parseInt(this.durasi));
                        this.jamSelesai = jamSelesaiFormatted.toTimeString().slice(0, 5);
                    }
                },

                durasi: 1,

                get maxDurasi() {
                    if (!this.jamMulai) return 12;
                    const jamMulai = parseInt(this.jamMulai.split(':')[0]);
                    return Math.max(1, 24 - jamMulai); // agar tidak lewat jam 24:00
                },

                tambahDurasi() {
                    if (this.durasi < 12) {
                        this.durasi++;
                        this.hitungJamSelesai();
                    }
                },

                kurangiDurasi() {
                    if (this.durasi > 1) {
                        this.durasi--;
                        this.hitungJamSelesai();
                    }
                },

                hitungTotalHarga() {
                    if (!this.jamMulai) return 0;

                    let jamMulaiInt = parseInt(this.jamMulai.split(":")[0]);
                    let hargaPerJam = (jamMulaiInt >= 18) ? 40000 : 35000;

                    return this.durasi * hargaPerJam;
                },

                formatRupiah(angka) {
                    return new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR"
                    }).format(angka);
                },

                konfirmasiBooking() {
                    if (!this.nama || !this.nomorTelepon || !this.lapanganDipilih || !this.tanggalBooking || !this.jamMulai || !this.durasi) {
                        swal("Gagal!", "Semua kolom harus diisi!", "error");
                        return;
                    }

                    let formData = new FormData();
                    formData.append('nama', this.nama);
                    formData.append('nomorTelepon', this.nomorTelepon);
                    formData.append('lapanganDipilih', this.lapanganDipilih);
                    formData.append('tanggalBooking', this.tanggalBooking);
                    formData.append('jamMulai', this.jamMulai);
                    formData.append('durasi', this.durasi);

                    fetch('booking.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("Server Error: " + response.status);
                            }
                            return response.text();
                        })
                        .then(result => {
                            if (result.includes("sudah dibooking")) {
                                swal("Gagal!", result, "error");
                            } else {
                                // Meminta izin notifikasi dengan lebih baik
                                if (Notification.permission === "default") {
                                    Notification.requestPermission().then(permission => {
                                        if (permission === "granted") {
                                            showNotification();
                                        } else {
                                            console.warn("Notifikasi ditolak oleh pengguna.");
                                        }
                                    });
                                } else if (Notification.permission === "granted") {
                                    showNotification();
                                }

                                swal("Berhasil!", "Booking berhasil dibuat!", "success")
                                    .then(() => {
                                        window.location.href = 'notapenyewaan.php';
                                    });
                            }
                        })
                        .catch(error => {
                            swal("Error!", "Terjadi kesalahan, coba lagi.", "error");
                            console.error('Error:', error);
                        });

                    // Fungsi Notifikasi
                    function showNotification() {
                        console.log('Menampilkan notifikasi...');
                        const notification = new Notification("Booking Berhasil!", {
                            body: "Pemesanan lapangan berhasil dilakukan.",
                            icon: "logo-cpo.png"
                        });

                        notification.onclick = function() {
                            window.open("notapenyewaan.php");
                        };
                    }

                },

                isWaktuValid() {
                    const today = new Date();
                    const tanggalInput = new Date(this.tanggalBooking);
                    const nowJam = today.getHours();
                    const nowMenit = today.getMinutes();

                    if (!this.tanggalBooking || !this.jamMulai) return false;

                    // Jika tanggal booking lebih kecil dari hari ini
                    if (tanggalInput.setHours(0, 0, 0, 0) < today.setHours(0, 0, 0, 0)) {
                        swal("Tanggal tidak valid", "Tidak bisa booking untuk tanggal yang sudah lewat.", "error");
                        this.jamMulai = "";
                        this.jamSelesai = "";
                        return false;
                    }

                    // Jika tanggal adalah hari ini, jam mulai tidak boleh kurang dari sekarang
                    if (tanggalInput.toDateString() === today.toDateString()) {
                        const [jam, menit] = this.jamMulai.split(":").map(Number);
                        if (jam < nowJam || (jam === nowJam && menit <= nowMenit)) {
                            swal("Jam tidak valid", "Jam mulai harus setelah waktu sekarang.", "error");
                            this.jamMulai = "";
                            this.jamSelesai = "";
                            return false;
                        }
                    }

                    return true;
                }

            }

        }
        // fungsi untuk button

        // SIMULASI DATA TERBOOKING-
        const dataTerbooking = {
            "2025-05-10": {
                "1": ["08:00", "09:00", "10:00"],
                "2": ["13:00", "14:00"]
            },
            "2025-05-11": {
                "1": ["07:00", "20:00"]
            }
        };

        // TOMBOL JAM 01:00 - 24:00
        const container = document.getElementById('button-container');
        for (let i = 7; i <= 23; i++) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'time-button';
            btn.textContent = `${i.toString().padStart(2, '0')}:00`;

            // event saat tombol diklik → isi ke input jamMulai + highlight
            btn.addEventListener("click", () => {
                if (!btn.disabled) {
                    const jamInput = document.querySelector("[name='jamMulai']");
                    jamInput.value = btn.textContent;
                    jamInput.dispatchEvent(new Event("input"));

                    // Hapus highlight dari semua tombol
                    document.querySelectorAll('.time-button').forEach(button => {
                        button.classList.remove('selected');
                    });

                    // Tambahkan highlight ke tombol yang diklik
                    btn.classList.add('selected');
                }
            });

            container.appendChild(btn);
        }
        // Check availability via AJAX when the user selects a date or lapangan
        function updateTombolJamSimulasi() {
            const tanggal = document.querySelector("[name='tanggal_transaksi']").value;
            const lapangan = document.querySelector("[name='no_lapangan']").value;

            if (!tanggal || !lapangan) return;

            fetch('cekdobelboking.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        'tanggal_transaksi': tanggal,
                        'no_lapangan': lapangan
                    })
                })
                .then(response => response.json())
                .then(bookedTimes => {
                    document.querySelectorAll(".time-button").forEach(btn => {
                        const jam = btn.textContent;

                        if (bookedTimes.includes(jam)) {
                            btn.disabled = true;
                            btn.classList.add("disabled-jam");
                        } else {
                            btn.disabled = false;
                            btn.classList.remove("disabled-jam");
                        }

                        btn.classList.remove("selected");
                    });
                })
                .catch(error => {
                    console.error('Gagal fetch data booking:', error);
                });
        }




        // // UPDATE TOMBOL YANG TERBOOKING
        // function updateTombolJamSimulasi() {
        //     const tanggal = document.querySelector("[name='tanggal_transaksi']").value;
        //     const lapangan = document.querySelector("[name='no_lapangan']").value;

        //     const jamTerbooking = (dataTerbooking[tanggal] && dataTerbooking[tanggal][lapangan]) || [];

        //     document.querySelectorAll(".time-button").forEach(btn => {
        //         const jam = btn.textContent;

        //         if (jamTerbooking.includes(jam)) {
        //             btn.disabled = true;
        //             btn.classList.add("disabled-jam");
        //         } else {
        //             btn.disabled = false;
        //             btn.classList.remove("disabled-jam");
        //         }

        //         // Reset highlight saat tanggal/lapangan diganti
        //         btn.classList.remove("selected");
        //     });
        // }




        // trigger update tombol saat user pilih tanggal atau lapangan
        document.querySelector("[name='tanggal_transaksi']").addEventListener("change", updateTombolJamSimulasi);
        document.querySelector("[name='no_lapangan']").addEventListener("change", updateTombolJamSimulasi);
    </script>

</body>

</html>