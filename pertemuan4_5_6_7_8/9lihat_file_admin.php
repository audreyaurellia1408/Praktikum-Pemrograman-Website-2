<?php
session_start();
include 'koneksi.php';

// CEK LOGIN ADMIN
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: 3login.html");
    exit();
}

// --- PAGINATION SETTING ---
$limit = 4; // Jumlah data per halaman
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Hitung total data
$total_data = $conn->query("SELECT COUNT(*) AS total FROM files")->fetch_assoc()['total'];
$total_page = ceil($total_data / $limit);

// Ambil data sesuai halaman
$sql = "SELECT f.id, u.username, f.filename, f.filepath, f.uploaded_at
        FROM files f
        JOIN users u ON f.user_id = u.id
        ORDER BY f.uploaded_at DESC
        LIMIT $start, $limit";
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
        img { border-radius: 6px; }
        a { text-decoration: none; color: #007bff; }
        .back { margin-top: 15px; display: inline-block; padding: 10px 15px; background: #5cafff; color: white; border-radius: 6px; }

        .pagination { margin-top: 15px; text-align: center; }
        .pagination a {
            margin: 0 5px;
            padding: 8px 12px;
            background: #5cafff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .pagination a.disabled {
            background: #ccc;
            pointer-events: none;
        }
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
            <th>Preview</th>
            <th>Waktu Upload</th>
            <th>Aksi</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            $no = $start + 1;
            while ($row = $result->fetch_assoc()) {

                $nama_file = htmlspecialchars($row['filename']);
                $user      = htmlspecialchars($row['username']);
                $waktu     = $row['uploaded_at'];
                $path      = $row['filepath'];

                // Cek apakah file adalah gambar
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $is_image = in_array($ext, ['jpg','jpeg','png','gif','webp']);

                echo "<tr>
                        <td>{$no}</td>
                        <td>{$user}</td>
                        <td>{$nama_file}</td>
                        <td>";

                // Preview
                if ($is_image) {
                    echo "<img src='{$path}' style='width:80px;height:80px;object-fit:cover;'>";
                } else {
                    echo "<span style='color:gray;'>Bukan gambar</span>";
                }

                echo "</td>
                        <td>{$waktu}</td>
                        <td>
                            <a href='{$path}' target='_blank'>Lihat</a> |
                            <a href='{$path}' download>Download</a>
                        </td>
                      </tr>";

                $no++;
            }
        } else {
            echo "<tr><td colspan='6'>Belum ada file yang diupload.</td></tr>";
        }
        ?>
    </table>

    <!-- PAGINATION -->
    <div class="pagination">
        <a href="?page=<?= $page - 1 ?>" class="<?= ($page <= 1 ? 'disabled' : '') ?>">⬅ Prev</a>
        <a href="?page=<?= $page + 1 ?>" class="<?= ($page >= $total_page ? 'disabled' : '') ?>">Next ➡</a>
    </div>

    <a href="5dashboard_admin.php" class="back">⬅ Kembali ke Dashboard Admin</a>
</div>

</
