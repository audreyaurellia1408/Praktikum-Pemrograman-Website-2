<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: 3login.html");
    exit();
}

include 'koneksi.php';

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
            color: #75b5ffff;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: #0b0b0b;
            margin-bottom: 25px;
        }

        b {
            color: #75b5ffff;
        }

        a.logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #81beffff;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }

        a.logout-btn:hover {
            background: #79baffff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        table, th, td {
            border: 1px solid #8db3ecff;
        }

        th {
            background: #93c5faff;
            color: white;
            padding: 10px;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #e1f2ffff;
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
        <h2>Halo, <?php echo $_SESSION['username']; ?></h2>
        <p><b>Selamat Datang di Dashboard Admin</b></p>
        <p>Kamu login sebagai <b><?php echo ucfirst($_SESSION['role']); ?></b></p>
        <a href="6logout.php" class="logout-btn">Logout</a>

        <h3>Daftar User Terdaftar</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Tanggal Dibuat</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['role']}</td>
                            <td>{$row['created_at']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Belum ada user yang terdaftar.</td></tr>";
            }
            ?>
        </table>
    </div>

</body>
</html>
