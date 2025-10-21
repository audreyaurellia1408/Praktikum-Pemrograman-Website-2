<?php
include 'koneksi.php';

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];
$role     = $_POST['role'];

// Enkripsi password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Query simpan ke database (tanpa nama_lengkap dan status)
$query = "INSERT INTO users (username, password, role, created_at)
          VALUES ('$username', '$hashed_password', '$role', NOW())";

if (mysqli_query($koneksi, $query)) {
    echo "<script>
            alert('Data user berhasil disimpan!');
            window.location.href='form_user.html';
          </script>";
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>
