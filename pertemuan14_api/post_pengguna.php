<?php
header("Content-Type: application/json");
include '../koneksi.php';

$data = json_decode(file_get_contents("php://input"), true);

// Validasi
if (
    empty($data['nama']) ||
    empty($data['username']) ||
    empty($data['password']) ||
    empty($data['role'])
) {
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak lengkap"
    ]);
    exit;
}

$nama     = $data['nama'];
$username = $data['username'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$email    = $data['email'] ?? null;
$role     = $data['role'];
$status   = $data['status'] ?? 'Aktif';

// Cek username
$cek = mysqli_query($conn, "SELECT username FROM pengguna WHERE username='$username'");
if (mysqli_num_rows($cek) > 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Username sudah digunakan"
    ]);
    exit;
}

// Insert data
$insert = mysqli_query($conn, "
    INSERT INTO pengguna (nama, username, password, email, role, status)
    VALUES ('$nama', '$username', '$password', '$email', '$role', '$status')
");

if (!$insert) {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal menambahkan pengguna"
    ]);
    exit;
}

$result = mysqli_query($conn, "
    SELECT id_pengguna, nama, username, email, role, status, tanggal_dibuat
    FROM pengguna
    ORDER BY id_pengguna DESC
");

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

echo json_encode([
    "status" => "success",
    "message" => "Pengguna berhasil ditambahkan",
    "data" => $users
]);
?>
