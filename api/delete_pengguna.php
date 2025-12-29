<?php
header("Content-Type: application/json");
include '../koneksi.php';

// Ambil data JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validasi
if (empty($data['id_pengguna'])) {
    echo json_encode([
        "status" => "error",
        "message" => "ID pengguna wajib diisi"
    ]);
    exit;
}

$id_pengguna = $data['id_pengguna'];

// Cek apakah data ada
$cek = mysqli_query($conn, "SELECT id_pengguna FROM pengguna WHERE id_pengguna='$id_pengguna'");
if (mysqli_num_rows($cek) == 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Pengguna tidak ditemukan"
    ]);
    exit;
}

// Hapus data
$hapus = mysqli_query($conn, "DELETE FROM pengguna WHERE id_pengguna='$id_pengguna'");

if ($hapus) {
    echo json_encode([
        "status" => "success",
        "message" => "Pengguna berhasil dihapus"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal menghapus pengguna"
    ]);
}
?>
