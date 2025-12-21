<?php
include 'koneksi.php';
require_once __DIR__ . '/vendor/autoload.php'; // pastikan path ini benar

$mpdf = new \Mpdf\Mpdf();

// Ambil data album dari database
$query = mysqli_query($conn, "SELECT * FROM album ORDER BY id ASC");

// Mulai HTML
$html = '<h2 style="text-align:center;color:#76bbfc;">Laporan Data Album</h2>
<table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse;">
    <tr style="background-color:#76bbfc; color:white; text-align:center;">
        <th>No</th>
        <th>Nama Album</th>
        <th>Nama Grup</th>
        <th>Foto Album</th>
        <th>Tanggal Rilis</th>
        <th>Harga Album</th>
    </tr>
';

$no = 1;
while ($row = mysqli_fetch_assoc($query)) {
    $imgPath = __DIR__ . '/uploads/' . $row['foto_album'];
    // Cek apakah file foto ada
    if(file_exists($imgPath)){
        // Gunakan path file lokal agar mPDF bisa membaca
        $imgTag = '<img src="'.$imgPath.'" width="50">';
    } else {
        $imgTag = '';
    }

    $html .= '<tr>
        <td style="text-align:center;">'.$no++.'</td>
        <td>'.$row['nama_album'].'</td>
        <td>'.$row['nama_grup'].'</td>
        <td style="text-align:center;">'.$imgTag.'</td>
        <td style="text-align:center;">'.$row['tanggal_rilis'].'</td>
        <td style="text-align:right;">Rp '.number_format($row['harga'],0,",",".").'</td>
    </tr>';
}

$html .= '</table>';

// Tulis HTML ke mPDF
// Jika HTML besar, bisa dipotong dengan WriteHTML() bertahap:
// $mpdf->WriteHTML($html_part1);
// $mpdf->WriteHTML($html_part2);
$mpdf->WriteHTML($html);

// Output langsung sebagai download
$mpdf->Output('laporan_album.pdf', 'D');
exit();
?>
