<!DOCTYPE html>
<html lang="en">
<head>
    <title>Perulangan For</title>
</head>
<body>
    <h2>Tabel Perkalian 7</h2>

    <?php
    $angka = 7;

    for ($i = 1; $i <= 10; $i++) {
        $hasil = $angka * $i;

        echo $angka . " x " . $i . " = " . $hasil . "<br>";
    }
    ?>
</body>
</html>