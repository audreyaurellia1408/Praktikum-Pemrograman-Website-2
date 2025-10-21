<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Cek apakah username ada di database
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);

    // Verifikasi password
    if (password_verify($password, $data['password'])) {
        // Simpan data ke session
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['login'] = true;

        // Arahkan berdasarkan role
        if ($data['role'] == 'admin') {
            header("Location: dashboard_admin.php");
        } else {
            header("Location: dashboard_user.php");
        }
        exit();
    } else {
        echo "<script>alert('Password salah!'); window.location='login.html';</script>";
    }
} else {
    echo "<script>alert('Username tidak ditemukan!'); window.location='login.html';</script>";
}

mysqli_close($koneksi);
?>
