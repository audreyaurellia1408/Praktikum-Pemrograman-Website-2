<?php
session_start();
include 'koneksi.php';

// CEK LOGIN ADMIN
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: 3login.html");
    exit();
}

// HAPUS cek akses_dashboard agar admin tetap bisa kembali dari halaman lain
// unset($_SESSION['akses_dashboard']); // dihapus, biar session tetap ada

// CEK timeout sesi
$timeout = 600; // 10 menit
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();
    session_destroy();
    echo "<script>
            alert('Sesi kamu telah berakhir karena tidak aktif. Silakan login kembali.');
            window.location='3login.html';
          </script>";
    exit();
}
$_SESSION['last_activity'] = time();

// Ambil daftar user
$query = "SELECT id, username, role, created_at FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
               background: linear-gradient(135deg, #dff3ff 0%, #a9d6ff 100%);
               margin: 0; padding: 0; min-height: 100vh; display: flex;
               justify-content: center; align-items: flex-start; color: #333; }
        .container { background: #f6f8f9; width: 90%; max-width: 1000px;
                     margin-top: 50px; padding: 30px; border-radius: 15px;
                     box-shadow: 0 8px 20px rgba(0,0,0,0.2); animation: fadeIn 0.8s ease-in-out; }
        h2 { color: #75b5ff; margin-bottom: 10px; }
        p { font-size: 16px; color: #0b0b0b; margin-bottom: 25px; }
        b { color: #75b5ff; }
        a.logout-btn { display: inline-block; padding: 10px 20px; background: #81beff;
                       color: white; border-radius: 8px; text-decoration: none; transition: 0.3s;
                       margin-right: 10px; }
        a.logout-btn:hover { background: #5cafff; }
        table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        table, th, td { border: 1px solid #8db3ec; }
        th { background: #93c5fa; color: white; padding: 10px; }
        td { padding: 10px; text-align: center; }
        tr:nth-child(even) { background: #e1f2ff; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); }
                             to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
<div class="container">
    <h2>Halo, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    <p><b>Selamat Datang di Dashboard Admin</b></p>
    <p>Kamu login sebagai <b><?php echo ucfirst($_SESSION['role']); ?></b></p>

    <!-- Tombol lihat file user -->
    <a href="9lihat_file_admin.php" class="logout-btn">Lihat File Upload User</a>
    <!-- Tombol Logout -->
    <a href="6logout.php" class="logout-btn">Logout</a>

    <h3>Tambah User Baru</h3>
    <form action="2proses_tambah_user.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
        <button type="submit">Tambah</button>
    </form>

    <h3>Daftar User Terdaftar</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Tanggal Dibuat</th>
            <th>Aksi</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>" . htmlspecialchars($row['username']) . "</td>
                        <td>" . htmlspecialchars($row['role']) . "</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a href='edit_user.php?id={$row['id']}'>Edit</a> |
                            <a href='hapus_user.php?id={$row['id']}' onclick='return confirm(\"Yakin ingin menghapus user ini?\")'>Hapus</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Belum ada user yang terdaftar.</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
