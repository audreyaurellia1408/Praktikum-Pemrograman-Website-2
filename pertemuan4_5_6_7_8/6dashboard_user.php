<?php
session_start();
include 'koneksi.php'; // koneksi ke database db_login

if (!isset($_SESSION['login'])) {
    header("Location: 3login.html");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    echo "<script>
            alert('Halaman ini hanya untuk user!');
            window.location='5dashboard_admin.php';
          </script>";
    exit();
}

// ================= PROSES UPLOAD =================
$pesan = "";

if (isset($_POST['upload'])) {
    $folder = "uploads_user/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $nama_file = $_FILES['file_upload']['name'];
    $tmp_file  = $_FILES['file_upload']['tmp_name'];

    // Membuat nama file unik agar tidak tertimpa
    $namaBaru = time() . "_" . basename($nama_file);
    $tujuan = $folder . $namaBaru;

    if (move_uploaded_file($tmp_file, $tujuan)) {

        // ===== SIMPAN KE DATABASE =====
        $user_id = $_SESSION['id']; // pastikan session menyimpan id user
        $stmt = $conn->prepare("INSERT INTO files (user_id, filename, filepath) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $nama_file, $tujuan);

        if ($stmt->execute()) {
            $pesan = "<span style='color:green;'>✅ File berhasil diupload dan disimpan di database!</span>";
        } else {
            $pesan = "<span style='color:red;'>❌ File berhasil diupload tetapi gagal disimpan di database!</span>";
        }

        $stmt->close();

    } else {
        $pesan = "<span style='color:red;'>❌ File gagal diupload!</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #dff3ff 0%, #a9d6ff 100%);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .container {
            background: #f6f8f9;
            width: 450px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
        }

        h2 {
            color: #76bbfc;
            margin-bottom: 10px;
        }

        .upload-box {
            margin-top: 20px;
            padding: 15px;
            border: 2px dashed #76bbfc;
            border-radius: 10px;
            background: #ffffff;
        }

        input[type=file] {
            margin: 10px 0;
        }

        button {
            padding: 8px 15px;
            background: #77bbff;
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #5cbbff;
        }

        a.logout-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #ff6b6b;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }

        a.logout-btn:hover {
            background: #ff4b4b;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Halo, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    <p><b>Selamat Datang di Website Manajemen Inventori</b></p>
    <p>Kamu login sebagai <b><?php echo ucfirst($_SESSION['role']); ?></b></p>

    <!-- FORM UPLOAD -->
    <div class="upload-box">
        <h3>Upload File</h3>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="file_upload" required><br>
            <button type="submit" name="upload">Upload</button>
        </form>
        <p><?php echo $pesan; ?></p>
    </div>

    <a href="6logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>
