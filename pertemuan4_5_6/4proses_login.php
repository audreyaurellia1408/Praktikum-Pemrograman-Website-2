<?php
session_start();
include 'koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: 3login.html");
    exit();
}

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);

    if (password_verify($password, $data['password'])) {

        $_SESSION['login'] = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        $_SESSION['akses_dashboard'] = true;

        if ($data['role'] === 'admin') {
            header("Location: 5dashboard_admin.php");
        } else {
            header("Location: 6dashboard_user.php");
        }
        exit();
    } else {
        echo "<script>
                alert('Password salah!');
                window.location='3login.html';
              </script>";
        exit();
    }
} else {
    echo "<script>
            alert('Username tidak ditemukan!');
            window.location='3login.html';
          </script>";
    exit();
}

mysqli_close($conn);
?>
