<?php
include 'koneksi.php';

if (isset($_POST['daftar'])) {

    $Nama = filter_var(trim($_POST['Nama']));
    $Username = filter_var(trim($_POST['Username']));
    $Phone = filter_var(trim($_POST['Phone']));
    $Password = $_POST['Password'];

    if (!preg_match('/^[0-9]{10,15}$/', $Phone)) {
        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                swal({
                    title: 'Gagal!',
                    text: 'No HP tidak Valid!',
                    icon: 'error',
                    button: 'OK'
                }).then((value) => {
                    window.location.href = 'halamanregister.php';
                });
            });
            </script>";
        exit();
    }

    // cek nomor apakah sudah terdaftar
    $checkPhone = "SELECT * FROM pelanggan WHERE Phone = ?";
    $stmt = $conn->prepare($checkPhone);
    $stmt->bind_param("s", $Phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                swal({
                    title: 'Gagal!',
                    text: 'No HP Telah Di Gunakan!',
                    icon: 'error',
                    button: 'OK'
                }).then((value) => {
                    window.location.href = 'halamanregister.php';
                });
            });
            </script>";
        exit();
    } else {
        $Password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO pelanggan (Nama, Username, Phone, Password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssss", $Nama, $Username, $Phone, $Password);
        if($stmt->execute()){
            echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    swal({
                        title: 'Berhasil!',
                        text: 'Akun Berhasil Di Buat!',
                        icon: 'success',
                        button: 'OK'
                    }).then((value) => {
                        window.location.href = 'halamanlogin.php';
                    });
                });
                </script>";
        } else {
            echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    swal({
                        title: 'Gagal!',
                        text: 'Akun Gagal Di Buat!',
                        icon: 'error',
                        button: 'OK'
                    }).then((value) => {
                        window.location.href = 'halamanregister.php';
                    });
                });
                </script>";
        }
    }
}
