<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi</title>
    <link rel="stylesheet" href="lupapassword.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<body>
    <!-- <div data-aos="fade-up"
        data-aos-anchor-placement="top-bottom"> -->
        <div class="container">
            <h2>Reset Kata Sandi</h2>
            <p>Masukkan nomor telepon Anda dan kata sandi baru</p>
            <form id="resetForm">
                <label for="phone">Nomor Telepon:</label>
                <input type="tel" id="phone" name="phone" placeholder="Masukkan nomor telepon" required pattern="[0-9]{10,15}" title="Masukkan nomor telepon yang valid (10-15 digit)">

                <label for="new_password">Kata Sandi Baru:</label>
                <div class="password-container">
                    <input type="password" id="new_password" name="new_password" placeholder="Masukkan kata sandi baru" required>
                    <span class="toggle-password" onclick="togglePassword('new_password')">👁</span>
                </div>

                <label for="confirm_password">Konfirmasi Kata Sandi Baru:</label>
                <div class="password-container">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi kata sandi baru" required>
                    <span class="toggle-password" onclick="togglePassword('confirm_password')">👁</span>
                </div>

                <button type="submit">Reset Kata Sandi</button>
            </form>
            <button class="back-button" onclick="window.history.back();">Kembali</button>
        </div>
    </div>
    </div>

    <script>
        function togglePassword(id) {
            let input = document.getElementById(id);
            input.type = (input.type === "password") ? "text" : "password";
        }

        document.getElementById("resetForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Mencegah reload halaman

            let formData = new FormData(this);

            fetch("lupapassword.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json()) // Mengubah response ke JSON
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Sukses!",
                            text: data.message
                        }).then(() => {
                            window.location.href = "halamanlogin.php"; // Redirect setelah sukses
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "Terjadi kesalahan, coba lagi nanti."
                    });
                });
        });
    </script>
</body>

</html>