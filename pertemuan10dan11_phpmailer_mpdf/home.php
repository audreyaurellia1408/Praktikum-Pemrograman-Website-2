<?php
include 'koneksi.php';

$limit = 4; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    $result = mysqli_query($conn, "SELECT foto_album FROM album WHERE id=$id");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $file = 'uploads/' . $row['foto_album'];
        if (file_exists($file)) {
            unlink($file); 
        }
    }

    mysqli_query($conn, "DELETE FROM album WHERE id=$id");

    header("Location: home.php");
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM album ORDER BY id DESC LIMIT $start, $limit");


$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM album");
$total_row = mysqli_fetch_assoc($total_result);
$total_data = $total_row['total'];
$total_page = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Data Album</title>

<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #dff3ff 0%, #a9d6ff 100%);
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        color: #333;
    }

    .container {
        background: #ffffff;
        width: 90%;
        max-width: 1000px;
        margin-top: 40px;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        text-align: center;
    }

    h2 {
        font-family: 'Dancing Script', cursive;
        font-size: 48px;
        color: #76bbfc;
        margin-bottom: 5px;
    }

    .slogan {
        font-size: 18px;
        color: #555;
        margin-bottom: 20px;
        font-style: italic;
    }

    .btn-container {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .btn, .btn-hapus, .pagination a {
        display: inline-block;
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: bold;
        text-decoration: none;
        transition: 0.2s;
        cursor: pointer;
    }

    .btn {
        background: #77bbff;
        color: white;
    }

    .btn:hover {
        background: #5cbbff;
    }

    .btn-hapus {
        background: #ff6b6b;
        color: white;
    }

    .btn-hapus:hover {
        background: #ff4b4b;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #f6f8f9;
        border-radius: 10px;
        overflow: hidden;
    }

    th {
        background: #76bbfc;
        color: white;
        padding: 12px;
        font-weight: bold;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    tr:hover {
        background: #eaf5ff;
    }

    img {
        width: 70px;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .email-form {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .email-form input[type="email"] {
        padding: 5px 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .email-form button {
        padding: 8px 12px;
        border: none;
        border-radius: 8px;
        background: #ff9800;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s;
    }

    .email-form button:hover {
        background: #e68a00;
    }

    /* Style pagination */
    .pagination {
        margin-top: 20px;
        text-align: center;
    }

    .pagination a {
        margin: 0 5px;
        background: #77bbff;
        color: white;
    }

    .pagination a:hover, .pagination a.active {
        background: #5cbbff;
    }
</style>
</head>
<body>

<div class="container">

    <h2>Bias & Beats</h2>
    <div class="slogan">“Koleksi Terbaru, Senyuman Terbesar”</div>

    <div class="btn-container">
        <a href="upload.php" class="btn">Tambahkan File</a>
        <a href="download_laporan.php" class="btn" style="background:#4CAF50;">Unduh Laporan PDF</a>

        <form action="kirim_laporan.php" method="POST" class="email-form">
            <input type="email" name="email" placeholder="Masukkan email" required>
            <button type="submit">Kirim ke Email</button>
        </form>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Album</th>
            <th>Nama Grup</th>
            <th>Foto Album</th>
            <th>Tanggal Rilis</th>
            <th>Harga Album</th>
            <th>Aksi</th>
        </tr>

        <?php 
        $no = $start + 1;
        while($row = mysqli_fetch_assoc($query)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama_album']; ?></td>
            <td><?= $row['nama_grup']; ?></td>
            <td><img src="uploads/<?= $row['foto_album']; ?>" alt="<?= $row['nama_album']; ?>"></td>
            <td><?= $row['tanggal_rilis']; ?></td>
            <td>Rp <?= number_format($row['harga'], 0, ",", "."); ?></td>
            <td>
                <a href="home.php?hapus=<?= $row['id']; ?>" 
                   class="btn-hapus" 
                   onclick="return confirm('Yakin ingin menghapus album ini?');">
                   Hapus
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <div class="pagination">
        <?php if($page > 1): ?>
            <a href="home.php?page=<?= $page-1; ?>">Previous</a>
        <?php endif; ?>

        <?php for($i = 1; $i <= $total_page; $i++): ?>
            <a href="home.php?page=<?= $i; ?>" class="<?= ($i == $page) ? 'active' : ''; ?>"><?= $i; ?></a>
        <?php endfor; ?>

        <?php if($page < $total_page): ?>
            <a href="home.php?page=<?= $page+1; ?>">Next</a>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
