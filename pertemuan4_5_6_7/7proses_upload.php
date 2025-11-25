<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: 3login.html");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    echo "<script>
            alert('Halaman ini khusus untuk USER!');
            window.location='5dashboard_admin.php';
          </script>";
    exit();
}

$pesan = "";

if (isset($_POST['upload'])) {
    $namaFile = $_FILES['file']['name'];
    $tmpFile  = $_FILES['file']['tmp_name'];
    $ukuran   = $_FILES['file']['size'];

    $folderTujuan = "uploads/";

    if (!file_exists($folderTujuan)) {
        mkdir($folderTujuan, 0777, true);
    }

    $namaBaru = time() . "_" . basename($namaFile);
    $path = $folderTujuan . $namaBaru;

    if ($ukuran > 0 && move_uploaded_file($tmpFile, $path)) {
        $user_id = $_SESSION['id'];
        $stmt = $conn->prepare("INSERT INTO files (user_id, filename, filepath) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $namaFile, $path);

        if ($stmt->execute()) {
            $pesan = "✅ File berhasil diupload dan disimpan di database!";
        } else {
            $pesan = "❌ File berhasil diupload tapi gagal disimpan di database!";
        }

        $stmt->close();
    } else {
        $pesan = "❗ Pilih file terlebih dahulu atau upload gagal.";
    }
}
?>
