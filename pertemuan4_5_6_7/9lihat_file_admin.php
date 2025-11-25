<?php
session_start();
include 'koneksi.php'; // koneksi ke db_login

// CEK LOGIN ADMIN
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: 3login.html");
    exit();
}

// Ambil daftar file dari database
$sql = "SELECT f.id, u.username, f.filename, f.filepath, f.uploaded_at
        FROM files f
        JOIN users u ON f.user_id = u.id
        ORDER BY f.uploaded_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>File Upload User</title>
    <style>
        body { font-family: Arial; background: #eaf3ff; padding: 20px; }
        .box { background: white; padding: 20px; border-radius: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background: #81beff; color: white; }
        a { text-decoration: none; color: #007bff; }
        .back { margin-top: 15px; display: inline-block; padding: 10px 15px; background: #5cafff; color: white; border-radius: 6px; }
    </style>
</head>
<body>

<div class="box">
    <h2>Daftar File yang Diupload User</h2>

    <table>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama File</th>
            <th>Waktu Upload</th>
            <th>Aksi</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                // Tampilkan nama file
                $nama_file = htmlspecialchars($row['filename']);
                $user      = htmlspecialchars($row['username']);
                $waktu     = $row['uploaded_at'];
                $path      = $row['filepath'];

                echo "<tr>
                        <td>{$no}</td>
                        <td>{$user}</td>
                        <td>{$nama_file}</td>
                        <td>{$waktu}</td>
                        <td>
                            <a href='{$path}' target='_blank'>Lihat</a> |
                            <a href='{$path}' download>Download</a>
                        </td>
                      </tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='5'>Belum ada file yang diupload.</td></tr>";
        }
        ?>
    </table>

    <a href='5dashboard_admin.php' class='back'>⬅ Kembali ke Dashboard Admin</a>
</div>

</body>
</html>
