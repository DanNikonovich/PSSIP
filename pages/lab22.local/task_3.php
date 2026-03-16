<?php
echo "<h2>Работа с циклами</h2>";

$name = "Nikonovich Daniil"; 

$n = 9;           // номер варианта
$count = $n + 5;   // сколько раз выводить

for ($i = 1; $i <= $count; $i++) {
    echo "$i. $name <br>";
}
?>
