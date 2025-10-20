<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fungsi dan Prosedur</title>
</head>
<body>
    <?php
    function cetak_copyright() {
        echo "Hak Cipta © " . date("Y") . " Perusahaan ABC.";
    }
    
    cetak_copyright();

    echo '<br /><br />';

    function hitung_luas_persegi_panjang($panjang, $lebar) {
        $luas = $panjang * $lebar;
        return $luas;
    }

    $hasil_luas = hitung_luas_persegi_panjang(10, 5);
    echo "Luas persegi panjang dengan panjang 10 dan lebar 5 adalah: " . $hasil_luas;
    ?>
</body>
</html>