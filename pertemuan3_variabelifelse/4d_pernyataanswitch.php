<!DOCTYPE html>
<html lang="en">
<head>
    <title>Switch</title>
</head>
<body>
    <h3>Switch dengan Teks</h3>
    <?php
    $level = "admin"; 

    echo "Mengecek hak akses untuk level: <strong>" . $level . "</strong><br><br>";

    switch ($level) {
        case "admin":
            echo "Selamat datang, Admin! Anda memiliki akses penuh ke sistem.";
            break;

        case "editor":
            echo "Selamat datang, Editor! Anda dapat membuat dan mengedit konten.";
            break;

        case "user":
            echo "Selamat datang, Pengguna! Anda hanya dapat melihat konten.";
            break;
            
        default:
            echo "Maaf, level tidak dikenali. Akses ditolak.";
            break;
    }
    ?>
</body>
</html>