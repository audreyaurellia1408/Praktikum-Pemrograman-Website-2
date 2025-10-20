<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Demo PHP dan HTML</title>
</head>
<body>
    <?php
    echo "<h2>Selamat Datang di Halaman Demo PHP</h2>";
    echo "<p>Ini adalah contoh pertama kode PHP yang dijalankan di dalam dokumen HTML.</p>";
    ?>

    <br>

    <p><b>Bagian ini ditulis menggunakan HTML biasa.</b></p>
    <p>HTML tidak membutuhkan tag PHP dan akan langsung ditampilkan oleh browser.</p>

    <br>

    <?php
    $nama = "Rell";
    $tanggal = date("d-m-Y");
    echo "<h3>Halo, $nama!</h3>";
    echo "<p>Tanggal hari ini adalah: <b>$tanggal</b></p>";
    echo "<p>Semoga harimu menyenangkan</p>";
    ?>
</body>
</html>
