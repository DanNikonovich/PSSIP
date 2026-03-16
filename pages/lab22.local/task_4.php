<?php
echo "<h2>Массив продуктов</h2>";

$products = [
    "Хлеб" => 5000,
    "Молоко" => 800,
    "Сметана" => 7000
];

echo "Цена молока: " . $products["Молоко"] . "<br><br>";

arsort($products); // сортировка по убыванию цены

echo "После сортировки:<br>";

foreach ($products as $name => $price) {
    echo "$name — $price <br>";
}

echo "<br>";
?>
