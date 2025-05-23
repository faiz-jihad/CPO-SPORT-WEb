<?php
error_reporting(0);
include "headerPHP.php"; ?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</head>

<body>
    <h1>Hello, world!</h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>

<form action="latihan6POST.php" method="POST">
    <div class="mb-3">
        <label for="exampleFormControlInput1" aria-label="email" class="form-label">Email </label>
        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email" name="email" required=TRUE>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">ISI</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" name="isi" rows="3" required=TRUE></textarea>
    </div>
    <button type="submit" class="btn btn-primary"> SUBMIT</button>
</form>
<p>
    <?php
    if ($_POST['email'] && $_POST['isi']) {
        $email = $_POST['email'];
        $isi = $_POST['isi'];
        echo "<div class='alert alert-success' ";
        echo "Email :" . $email . "<br>";
        echo "Isi : " . $isi . "<br>";
        echo "</div>";
    } ?>
</p>


<?php
include "footerPHP.php"; ?>