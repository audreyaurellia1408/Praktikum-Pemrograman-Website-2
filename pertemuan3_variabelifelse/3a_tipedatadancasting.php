<!DOCTYPE html>
<html lang="en">
<head>
    <title>Demo Tipe Data dan Casting</title>
</head>
<body>
    <?php
    echo "<h3>Pengecekan Tipe Data Lainnya</h3>";

    $angka_string = "123";
    $status_aktif = true;
    $daftar_belanja = ["Buku", "Pensil"];

    echo "Apakah '$angka_string' numerik? <br>";
    var_dump(is_numeric($angka_string)); 

    echo "<hr>";

    echo "Apakah '$angka_string' integer? <br>";
    var_dump(is_int($angka_string)); 

    echo "<hr>";

    echo "Apakah \$status_aktif adalah boolean? <br>";
    var_dump(is_bool($status_aktif));

    echo "<hr>";

    echo "Apakah \$daftar_belanja adalah array? <br>";
    var_dump(is_array($daftar_belanja));
    ?>
</body>
</html>