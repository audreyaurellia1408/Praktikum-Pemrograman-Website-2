<?php
session_start();

// ====== CEK LOGIN DAN AKSES DASHBOARD ======
if (!isset($_SESSION['login'])) {
    // Belum login
    header("Location: 3login.html");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    // Bukan admin
    echo "<script>
            alert('Akses ditolak! Halaman ini hanya untuk Admin.');
            window.location='6dashboard_user.php';
          </script>";
    exit();
}

// Tambahan: hanya bisa masuk kalau dari proses login langsung
if (!isset($_SESSION['akses_dashboard']) || $_SESSION['akses_dashboard'] !== true) {
    echo "<script>
            alert('Akses langsung ke halaman ini tidak diperbolehkan!');
            window.location='3login.html';
          </script>";
    exit();
}

// ====== KONEKSI DATABASE ======
include 'koneksi.php';

// Ambil data user
$query = "SELECT id, username, role, created_at FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
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
            background: #f6f8f9;
            width: 90%;
            max-width: 1000px;
            margin-top: 50px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            animation: fadeIn 0.8s ease-in-out;
        }

        h2 {
            color: #75b5ff;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: #0b0b0b;
            margin-bottom: 25px;
        }

        b {
            color: #75b5ff;
        }

        a.logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #81beff;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }

        a.logout-btn:hover {
            background: #5cafff;
        }

        form {
            margin-bottom: 25px;
            background: #f2f8ff;
            padding: 15px;
            border-radius: 10px;
        }

        form input, form select {
            padding: 8px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            background: #81beff;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background: #5cafff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        table, th, td {
            border: 1px solid #8db3ec;
        }

        th {
            background: #93c5fa;
            color: white;
            padding: 10px;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #e1f2ff;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Halo, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
        <p><b>Selamat Datang di Dashboard Admin</b></p>
        <p>Kamu login sebagai <b><?php echo ucfirst($_SESSION['role']); ?></b></p>
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
