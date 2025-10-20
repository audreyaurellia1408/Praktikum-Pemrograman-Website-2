<?php
echo "<h2>Tes Psikotes Pola Angka</h2>";

$a = [4, 6, 9, 13, 18];
for ($i = 1; $i <= 2; $i++) {
    $next = $a[count($a)-1] + (5 + $i);
    $a[] = $next;
}
echo "a. " . implode(" ", $a) . "<br>";

$b = [2, 2, 3, 3, 4];
$b[] = 4;
$b[] = 5;
echo "b. " . implode(" ", $b) . "<br>";

$c = [1, 9, 2, 10, 3];
$c[] = 11;
$c[] = 4;
$c[] = 12;
echo "c. " . implode(" ", $c) . "<br>";
?>
