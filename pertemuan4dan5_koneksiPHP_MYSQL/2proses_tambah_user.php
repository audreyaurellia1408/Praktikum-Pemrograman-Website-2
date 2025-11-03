<?php
session_start();
include 'koneksi.php';

// Ambil data dari form
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'] ?? 'user'; // default 'user' kalau tidak dikirim dari admin

// Cek apakah username sudah ada
$cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>
            alert('Username sudah digunakan! Silakan pilih username lain.');
            window.history.back();
          </script>";
    exit();
}

// Masukkan data user baru
$query = "INSERT INTO users (username, password, role, created_at) 
          VALUES ('$username', '$password', '$role', NOW())";
$result = mysqli_query($conn, $query);

if ($result) {
    // Jika yang menambah bukan admin (misal user daftar sendiri)
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
        echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                window.location='3login.html';
              </script>";
    } else {
        // Jika yang menambah adalah admin
        echo "<script>
                alert('User baru berhasil ditambahkan!');
                window.location='5dashboard_admin.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Terjadi kesalahan: " . mysqli_error($conn) . "');
            window.history.back();
          </script>";
}

mysqli_close($conn);
?>
