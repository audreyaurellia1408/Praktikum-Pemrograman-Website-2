<!DOCTYPE html>
<html lang="en">
<head>
    <title>Peulangan Foreach</title>
</head>
<body>
    <h2>Daftar Buah Favorit </h2>

    <?php
    $daftar_buah = array("Apel", "Jeruk", "Mangga", "Anggur", "Pisang");

    echo "<ul>";

    foreach ($daftar_buah as $buah) {
        echo "<li>" . $buah . "</li>";
    }

    echo "</ul>";
    ?>
</body>
</html>