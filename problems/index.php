<?php
// Printing patterns
$size = 5;
for ($i = 0; $i < $size; $i++) {
    for ($j = 1; $j < $size - $i; $j++)
        echo "&nbsp;&nbsp;";


    for ($k = 0; $k <= $i; $k++)
        echo "*";

    echo "<br>";
}

// Swapping without third var
$a = 5;
$b = 10;
echo "Before swapping, a = " . $a . " and b = " . $b;

echo "<br>";

$b = $a + $b;
$a = $b - $a;
$b = $b - $a;
echo "After swapping, a = " . $a . " and b = " . $b;
