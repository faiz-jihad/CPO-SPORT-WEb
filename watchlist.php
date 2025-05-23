<?php
session_start();
include 'koneksi.php'; // pastikan file ini berisi koneksi mysqli

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM watchlist WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist</title>
    <link rel="stylesheet" href="../css/watchlist.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="navbar">
                <h2>JURIX</h2>
                <nav class="menu">
                    <a href="homepage.php">Homepage</a>
                    <a href="Dashboard.php">Dashboard</a>
                    <a href="history.php">History</a>
                    <a href="watchlist.php">Watch List</a>
                    <a href="movieincoming.php">Movie Incoming</a>
                </nav>
            </div>
            <div class="logo"></div>
    </header>

    <div class="main-content">
        <h1>ACCOUNT INFORMATION</h1>
        <div class="watchlist-container">
            <h2>Watch List</h2>
            <div class="watchlist">
                <?php
                $index = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $numberClass = $index <= 3 ? "number1" : "number2";
                    echo '<div class="watch-item">';
                    echo '<div class="' . $numberClass . '">' . $index . '</div>';
                    echo '<img src="' . htmlspecialchars($row['movie_image']) . '" alt="' . htmlspecialchars($row['movie_title']) . '">';
                    echo '</div>';
                    $index++;
                }

                if ($index === 1) {
                    echo "<p>Kamu belum menambahkan film ke Watchlist.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <footer>
        <div class="cont">
            <p class="footer-1">
                <a href="#">Question? Call 08080821</a>
                <a href="#">Help Center</a>
                <a href="#">Jobs</a>
                <a href="#">Terms Of Use</a>
                <a href="#">Contact Us</a>
            </p>
            <p class="footer-2">
                <a href="#">Account</a>
                <a href="#">FAQ</a>
                <a href="#">Legal Notice</a>
                <a href="#">Cookies Preferences</a>
            </p>
        </div>
        <p>&copy; 2024 Jurix</p>
    </footer>
</body>
</html>
