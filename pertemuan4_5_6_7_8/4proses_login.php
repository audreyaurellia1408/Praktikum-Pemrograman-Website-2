<?php
session_start();
include 'koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: 3login.html");
    exit();
}

// Ambil dan bersihkan input
$username = trim(mysqli_real_escape_string($conn, $_POST['username']));
$password = trim(mysqli_real_escape_string($conn, $_POST['password']));

// Query ke database
$query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);

    // cek password
    if (password_verify($password, $data['password'])) {

        // ✅ SIMPAN SEMUA INFO YANG DIBUTUHKAN
        $_SESSION['login'] = true;
        $_SESSION['id'] = $data['id'];            // penting untuk user_id saat upload
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['akses_dashboard'] = true;
        $_SESSION['last_activity'] = time();

        // redirect sesuai role
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
