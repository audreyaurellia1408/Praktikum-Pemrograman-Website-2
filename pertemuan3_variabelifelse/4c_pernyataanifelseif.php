<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pernyataan If-Else-If</title>
</head>
<body>
    <h3>Cek Predikat Nilai</h3>
    <?php
    $nilai = 85;

    echo "Nilai Anda: " . $nilai . "<br>";

    if ($nilai >= 85) {
        echo "Predikat: A (Luar Biasa!)";
    } elseif ($nilai >= 75) {
        echo "Predikat: B (Bagus)";
    } elseif ($nilai >= 60) {
        echo "Predikat: C (Cukup)";
    } else {
        echo "Predikat: Gagal (Silakan Coba Lagi)";
    }
    ?>
</body>
</html>