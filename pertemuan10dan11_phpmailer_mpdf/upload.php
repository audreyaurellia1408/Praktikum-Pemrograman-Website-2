<?php
include "koneksi.php";

$uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;

if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) {
        die("Gagal membuat folder uploads. Pastikan PHP punya izin untuk membuat folder di " . __DIR__);
    }
}

if (isset($_POST['submit'])) {

    $nama_album     = mysqli_real_escape_string($conn, $_POST['nama_album']);
    $nama_grup      = mysqli_real_escape_string($conn, $_POST['nama_grup']);
    $tanggal_rilis  = mysqli_real_escape_string($conn, $_POST['tanggal_rilis']);
    $harga          = (int) $_POST['harga'];

    if (!isset($_FILES['foto_album']) || $_FILES['foto_album']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Tidak ada file yang diupload atau terjadi error upload.');</script>";
    } else {
        $foto_tmp   = $_FILES['foto_album']['tmp_name'];
        $foto_name  = $_FILES['foto_album']['name'];

        $ext = pathinfo($foto_name, PATHINFO_EXTENSION);
        $base = pathinfo($foto_name, PATHINFO_FILENAME);
        $base = preg_replace('/[^A-Za-z0-9_\-]/', '_', $base);
        $nama_baru = time() . "_" . $base . "." . $ext;

        $targetPath = $uploadDir . $nama_baru;

        if (!is_uploaded_file($foto_tmp)) {
            echo "<script>alert('File tidak valid.');</script>";
        } else {
            if (move_uploaded_file($foto_tmp, $targetPath)) {
                $sql = "INSERT INTO album (nama_album, nama_grup, foto_album, tanggal_rilis, harga)
                        VALUES ('$nama_album', '$nama_grup', '$nama_baru', '$tanggal_rilis', $harga)";
                $query = mysqli_query($conn, $sql);

                if ($query) {
                    echo "<script>
                            alert('Data berhasil ditambahkan!');
                            window.location='home.php';
                         </script>";
                } else {
                    if (file_exists($targetPath)) unlink($targetPath);
                    echo "<script>alert('Gagal menambah data ke database: ". mysqli_error($conn) ."');</script>";
                }

            } else {
                echo "<script>alert('Gagal memindahkan file ke folder uploads. Cek izin folder.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Album</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #dff3ff 0%, #a9d6ff 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            color: #333;
        }

        .container {
            background: #ffffff;
            width: 90%;
            max-width: 500px;
            margin-top: 50px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        }

        h2 {
            color: #76bbfc;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="text"], 
        input[type="date"], 
        input[type="number"], 
        input[type="file"] {
            padding: 8px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 100%;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            background: #77bbff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.2s;
        }

        button:hover {
            background: #5cbbff;
        }

        a.back-btn {
            display: inline-block;
            margin-top: 15px;
            color: #ffffff;
            background: #ff6b6b;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
        }

        a.back-btn:hover {
            background: #ff4b4b;
        }

    </style>
</head>
<body>

<div class="container">

    <h2>Tambahkan Album Baru</h2>

    <form action="" method="POST" enctype="multipart/form-data">
        <label>Nama Album:</label>
        <input type="text" name="nama_album" required>

        <label>Nama Grup:</label>
        <input type="text" name="nama_grup" required>

        <label>Foto Album:</label>
        <input type="file" name="foto_album" accept="image/*" required>

        <label>Tanggal Rilis:</label>
        <input type="date" name="tanggal_rilis" required>

        <label>Harga Album:</label>
        <input type="number" name="harga" required>

        <button type="submit" name="submit">Simpan</button>
    </form>

    <a href="home.php" class="back-btn">Kembali ke Data Album</a>

</div>

</body>
</html>
