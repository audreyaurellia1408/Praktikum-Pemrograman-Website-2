<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 
include 'koneksi.php';

if(isset($_POST['email'])) {
    $toEmail = $_POST['email'];

    require_once __DIR__ . '/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf();

    $query = mysqli_query($conn, "SELECT * FROM album ORDER BY id ASC");

    $html = '
    <h2 style="text-align:center;color:#76bbfc;">Laporan Data Album</h2>
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
        $imgTag = file_exists($imgPath) ? '<img src="'.$imgPath.'" width="50">' : '';
        
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

    $pdfFilePath = __DIR__ . '/laporan_temp.pdf';
    $mpdf->Output($pdfFilePath, \Mpdf\Output\Destination::FILE);

    // Kirim email
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '';
        $mail->Password   = '';    
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('youremail@gmail.com', 'Bias & Beats');
        $mail->addAddress($toEmail);

        // Attachments
        $mail->addAttachment($pdfFilePath, 'laporan_album.pdf');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Laporan Data Album';
        $mail->Body    = 'Berikut laporan data album terbaru dalam bentuk PDF.';

        $mail->send();

        // Hapus file PDF sementara
        if(file_exists($pdfFilePath)) unlink($pdfFilePath);

        echo "<script>alert('Laporan berhasil dikirim ke $toEmail'); window.location='home.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Gagal mengirim email: {$mail->ErrorInfo}'); window.location='home.php';</script>";
    }
} else {
    header("Location: home.php");
    exit();
}
