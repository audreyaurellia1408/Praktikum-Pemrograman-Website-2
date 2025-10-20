<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fungsi dengan Argumen Opsional</title>
</head>
<body>
    <?php
    function buat_judul($teks, $level = 1) {
        echo '<h' . $level . '>' . $teks . '</h' . $level . '>';
    }

    buat_judul('Ini Adalah Judul Utama');

    echo "<br>";

    buat_judul('Ini Adalah Sub-Judul', 2);
    ?>
</body>
</html>