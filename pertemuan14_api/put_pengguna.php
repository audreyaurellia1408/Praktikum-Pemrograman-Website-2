<?php
header("Content-Type: application/json");
include '../koneksi.php';

// Ambil data JSON dari body
$data = json_decode(file_get_contents("php://input"), true);

// Validasi wajib
if (
    empty($data['id_pengguna']) ||
    empty($data['nama']) ||
    empty($data['username']) ||
    empty($data['role']) ||
    empty($data['status'])
) {
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak lengkap"
    ]);
    exit;
}

$id_pengguna = $data['id_pengguna'];
$nama        = $data['nama'];
$username    = $data['username'];
$email       = $data['email'] ?? null;
$role        = $data['role'];
$status      = $data['status'];

// Cek apakah pengguna ada
$cek = mysqli_query($conn, "SELECT id_pengguna FROM pengguna WHERE id_pengguna='$id_pengguna'");
if (mysqli_num_rows($cek) == 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Pengguna tidak ditemukan"
    ]);
    exit;
}

// Update data (tanpa password)
$query = "
    UPDATE pengguna SET
        nama='$nama',
        username='$username',
        email='$email',
        role='$role',
        status='$status'
    WHERE id_pengguna='$id_pengguna'
";

$result = mysqli_query($conn, $query);

if ($result) {
    // Ambil data terbaru
    $get = mysqli_query($conn, "
        SELECT id_pengguna, nama, username, email, role, status, tanggal_dibuat
        FROM pengguna
        WHERE id_pengguna='$id_pengguna'
    ");
    $user = mysqli_fetch_assoc($get);

    echo json_encode([
        "status" => "success",
        "message" => "Data pengguna berhasil diperbarui",
        "data" => $user
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal memperbarui data pengguna"
    ]);
}
?>
