<?php
include "koneksi.php";
require_once __DIR__ . '/vendor/autoload.php'; // Pastikan mPDF sudah diinstall

$mpdf = new \Mpdf\Mpdf();

$query = mysqli_query($conn, "SELECT * FROM album ORDER BY id ASC");

$html = '
<h2 style="text-align:center;color:#76bbfc;">Laporan Data Album</h2>
<table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse; font-family: Arial, sans-serif;">
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

    if (file_exists($imgPath)) {
        $type = pathinfo($imgPath, PATHINFO_EXTENSION);
        $data = file_get_contents($imgPath);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $imgTag = '<img src="' . $base64 . '" width="50">';
    } else {
        $imgTag = 'File tidak ditemukan';
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

$mpdf->WriteHTML($html);

$mpdf->Output('laporan_album.pdf', 'D');
exit();
