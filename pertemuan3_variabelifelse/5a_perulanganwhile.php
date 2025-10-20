<!DOCTYPE html>
<html lang="en">
<head>
    <title>Perulangan While</title>
</head>
<body>
    <h2>Daftar Tugas Harian</h2>

    <?php
    $nomor_tugas = 1;
    $jumlah_tugas_total = 5;

    echo "<ul>";

    while ($nomor_tugas <= $jumlah_tugas_total) {
        echo "<li>Ini adalah tugas ke-" . $nomor_tugas . "</li>";
        
        $nomor_tugas++;
    }

    echo "</ul>";
    ?>
    
</body>
</html>