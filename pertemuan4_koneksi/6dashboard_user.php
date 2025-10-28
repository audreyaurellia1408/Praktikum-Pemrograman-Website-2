<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: 3login.html");
    exit();
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
            background: linear-gradient(135deg, #dff3ffff 0%, #a9d6ffff 100%);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .container {
            background: #f6f8f9ff;
            width: 400px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }

        h2 {
            color: #76bbfcff;
            margin-bottom: 15px;
        }

        p {
            font-size: 16px;
            color: #0b0b0bff;
            margin-bottom: 25px;
        }

        b {
            color: #76b0eaff;
        }

        a.logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #77bbffff;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
        }

        a.logout-btn:hover {
            background: #5cbbffff;
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
        <p><b>Selamat Datang di Website Manajemen Inventori</b></p>
        <p>Kamu login sebagai <b><?php echo ucfirst($_SESSION['role']); ?></b></p>
        <a href="6logout.php" class="logout-btn">Logout</a>
    </div>

</body>
</html>
