<?php
session_start();
require_once 'koneksi.php';

if (isset($_POST['login'])) {
    $phone = trim($_POST['Phone']);
    $password = trim($_POST['Password']);

    if (empty($phone) || empty($password)) {
        gagal('Nomor dan Password wajib diisi');
    }

    // Cek di tabel admin
    $queryAdmin = "SELECT idAdmin AS id,  noTelepon, Password,jabatan FROM admincpo WHERE noTelepon = ?";
    $stmt = $conn->prepare($queryAdmin);
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['Password'])) {
            $_SESSION['login'] = true;
            $_SESSION['idAdmin'] = $admin['id'];
            $_SESSION['phone'] = $admin['noTelepon'];
            $_SESSION['role'] = 'admin';
            header("Location: Admin/dashboardadmin.php");
            exit();
        } else {
            gagal('Password salah');
        }
    }

    // Cek di tabel pelanggan
    $queryUser = "SELECT id_pelanggan AS id, Username, Phone, Password FROM pelanggan WHERE Phone = ?";
    $stmt = $conn->prepare($queryUser);
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = 'user';
            header("Location: landingpage.php");
            exit();
        } else {
            gagal('Password salah');
        }
    }

    gagal('No HP tidak terdaftar!');
}

function gagal($pesan) {
    echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            swal({
                title: 'Gagal!',
                text: '$pesan',
                icon: 'error',
                button: 'OK'
            }).then(() => {
                window.location.href = 'halamanlogin.php';
            });
        });
        </script>";
    exit();
}
?>
