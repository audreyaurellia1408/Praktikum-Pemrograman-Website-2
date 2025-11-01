<?php
include 'koneksi.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

$query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "<script>alert('User berhasil ditambahkan'); window.location='5dashboard_admin.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
