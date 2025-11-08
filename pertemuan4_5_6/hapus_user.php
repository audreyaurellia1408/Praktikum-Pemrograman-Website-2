<?php
include 'koneksi.php';
$id = $_GET['id'];

$query = "DELETE FROM users WHERE id=$id";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "<script>alert('User berhasil dihapus!'); window.location='5dashboard_admin.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
