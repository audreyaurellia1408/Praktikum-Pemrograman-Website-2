<?php
include 'koneksi.php';
$id = $_GET['id'];

// Ambil data user berdasarkan ID
$query = "SELECT * FROM users WHERE id=$id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("User tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #dff3ff 0%, #a9d6ff 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .form-container {
            background: #f6f8f9;
            padding: 30px 35px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 400px;
            animation: fadeIn 0.8s ease-in-out;
        }

        h2 {
            text-align: center;
            color: #76bbfc;
            margin-bottom: 25px;
            font-size: 26px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #0b0b0b;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #76bbfc;
            box-shadow: 0 0 6px rgba(118, 187, 252, 0.6);
        }

        input[type="submit"] {
            background: #77bbff;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            border-radius: 8px;
            padding: 12px;
            transition: background 0.3s ease;
            width: 100%;
        }

        input[type="submit"]:hover {
            background: #5cbbff;
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

        .back-link {
            text-align: center;
            margin-top: 10px;
        }

        .back-link a {
            text-decoration: none;
            color: #5cbbff;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Edit User</h2>
        <form action="update_user.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

            <label>Username:</label>
            <input type="text" name="username" value="<?php echo $data['username']; ?>" required>

            <label>Role:</label>
            <select name="role" required>
                <option value="admin" <?php if($data['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="user" <?php if($data['role'] == 'user') echo 'selected'; ?>>User</option>
            </select>

            <label>Password (kosongkan jika tidak diubah):</label>
            <input type="password" name="password" placeholder="••••••••">

            <input type="submit" value="Update">
        </form>

        <div class="back-link">
            <a href="5dashboard_admin.php">← Kembali ke Dashboard</a>
        </div>
    </div>

</body>
</html>
