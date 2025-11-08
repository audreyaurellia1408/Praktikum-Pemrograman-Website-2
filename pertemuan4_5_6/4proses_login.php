<?php
session_start();
include 'koneksi.php'; 

// Pastikan data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: 3login.html");
    exit();
}

// Ambil input dan hindari SQL injection
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Cek apakah username terdaftar
$query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);

    // Verifikasi password dengan hash di database
    if (password_verify($password, $data['password'])) {

        // Set session login
        $_SESSION['login'] = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        // Tambahkan flag agar dashboard hanya bisa diakses lewat login
        $_SESSION['akses_dashboard'] = true;

        // Arahkan berdasarkan role
        if ($data['role'] === 'admin') {
            header("Location: 5dashboard_admin.php");
        } else {
            header("Location: 6dashboard_user.php");
        }
        exit();
    } else {
        // Password salah
        echo "<script>
                alert('Password salah!');
                window.location='3login.html';
              </script>";
        exit();
    }
} else {
    // Username tidak ditemukan
    echo "<script>
            alert('Username tidak ditemukan!');
            window.location='3login.html';
          </script>";
    exit();
}

mysqli_close($conn);
?>
