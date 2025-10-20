<!DOCTYPE html>
<html lang="en">
<head>
    <title>Seleksi if-elseif-else</title>
</head>
<body>
    <?php
    $a = 5;
    $b = 5;

    if ($a > $b) {
        echo 'Nilai a lebih besar dari b';
    } elseif ($a == $b) {
        echo 'Nilai a sama dengan b';
        
    } else {
        echo 'Nilai a lebih kecil dari b';
    }
    ?>
</body>
</html>