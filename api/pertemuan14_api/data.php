<?php
header("Content-Type: application/json");

include '../koneksi.php';

$query = "SELECT 
            id_pengguna,
            nama,
            username,
            email,
            role,
            status,
            tanggal_dibuat
          FROM pengguna";

$result = mysqli_query($conn, $query);

$data = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal mengambil data pengguna"
    ]);
}
?>
