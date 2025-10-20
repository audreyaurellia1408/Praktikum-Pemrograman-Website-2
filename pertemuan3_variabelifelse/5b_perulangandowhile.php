<!DOCTYPE html>
<html lang="en">
<head>
    <title>Peulangan Do-While</title>
</head>
<body>
    <h1>Simulasi Lempar Dadu Sampai Dapat Angka 6</h1>
    <?php
    $lemparan_ke = 1;
    $hasil_dadu = 0;

    do {
        $hasil_dadu = rand(1, 6);
        
        echo "Lemparan ke-" . $lemparan_ke . ": Angka yang keluar adalah <b>" . $hasil_dadu . "</b><br>";

        $lemparan_ke++;

    } while ($hasil_dadu != 6);

    echo "<hr>Selamag kamu dapet angka 6!";
    ?>
</body>
</html>