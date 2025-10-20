<!DOCTYPE html>
<html lang="en">
<head>
    <title>Casting Tipe</title>
</head>
<body>
    <?php
    $str = '123abc';
    $bil = (int) $str;
    echo gettype($str);
    echo gettype($bil);
?>
</body>
</html>