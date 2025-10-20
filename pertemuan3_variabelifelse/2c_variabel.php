<!DOCTYPE html>
<html lang="en">
<head>
    <title>Demo Variabel Array</title>
</head>
<body>
    <?php
    $data_siswa = ["Budi", 17, true];

    echo "<h3>Hasil dari var_dump():</h3>";
    var_dump($data_siswa);
    
    echo "<hr>";

    echo "<h3>Hasil dari print_r():</h3>";
    print_r($data_siswa);
    ?>
</body>
</html>