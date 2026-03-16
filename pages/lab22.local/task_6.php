<?php
echo "<h2>Пользовательская функция</h2>";

function calcZ($x, $y)
{
    // Первая часть
    $part1 = sqrt(abs(($x*$x - 0.1) / ($x*$x + 0.1)));

    // Логарифм по основанию 8
    $logBase8 = log(1 + $x*$x) / log(8);

    // Вторая часть
    $part2 = ($x + pow($y, 3)) / $logBase8;

    return $part1 + $part2;
}

// Пример значений
$x = 2;
$y = 3;

$z = calcZ($x, $y);

echo "x = $x, y = $y <br>";
echo "z = " . round($z,3) . "<br><br>";
?>
