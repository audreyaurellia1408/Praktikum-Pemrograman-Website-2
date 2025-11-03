<?php
include 'koneksi.php';

$id = $_POST['id'];
$username = $_POST['username'];
$role = $_POST['role'];
$password = $_POST['password'];

if (!empty($password)) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE users SET username='$username', role='$role', password='$hashed' WHERE id=$id";
} else {
    $query = "UPDATE users SET username='$username', role='$role' WHERE id=$id";
}

$result = mysqli_query($conn, $query);

if ($result) {
    echo "<script>alert('Data user berhasil diupdate!'); window.location='5dashboard_admin.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
