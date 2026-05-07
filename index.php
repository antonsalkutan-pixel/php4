<?php
declare(strict_types=1);

/**
 * Массив транзакций
 */
$transactions = [
    [
        "id" => 1,
        "date" => "2023-01-01",
        "amount" => 10.00,
        "description" => "Продукты",
        "merchant" => "SuperMart",
    ],
    [
        "id" => 2,
        "date" => "2025-02-15",
        "amount" => 75.50,
        "description" => "Ресторан",
        "merchant" => "FoodPlace",
    ],
    [
        "id" => 3,
        "date" => "2023-03-10",
        "amount" => 200.00,
        "description" => "Техника",
        "merchant" => "TechStore",
    ],
];

/**
 * Считает общую сумму
 */
function calculateTotalAmount(array $transactions): float {
    $sum = 0;
    foreach ($transactions as $t) {
        $sum += $t["amount"];
    }
    return $sum;
}

/**
 * Поиск по описанию
 */
function findTransactionByDescription(string $text, array $transactions): array {
    $result = [];
    foreach ($transactions as $t) {
        if (stripos($t["description"], $text) !== false) {
            $result[] = $t;
        }
    }
    return $result;
}

/**
 * Поиск по ID (foreach)
 */
function findTransactionById(int $id, array $transactions): ?array {
    foreach ($transactions as $t) {
        if ($t["id"] === $id) {
            return $t;
        }
    }
    return null;
}

/**
 * Поиск через array_filter
 */
function findTransactionByIdFilter(int $id, array $transactions): array {
    return array_filter($transactions, fn($t) => $t["id"] === $id);
}

/**
 * Сколько дней прошло
 */
function daysSinceTransaction(string $date): int {
    $d1 = new DateTime($date);
    $d2 = new DateTime();
    return $d1->diff($d2)->days;
}

/**
 * Добавление транзакции
 */
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;

    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];
}

/**
 * Добавим одну транзакцию для примера
 */
addTransaction(4, "2023-04-01", 50.25, "Такси", "TaxiService");

/**
 * Сортировка по сумме (убывание)
 */
usort($transactions, function($a, $b) {
    return $b["amount"] <=> $a["amount"];
});
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лабораторная PHP</title>
</head>
<body>

<h2>Список транзакций</h2>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Дата</th>
            <th>Сумма</th>
            <th>Описание</th>
            <th>Получатель</th>
            <th>Дней прошло</th>
        </tr>
    </thead>
    <tbody>

    <?php foreach ($transactions as $t): ?>
        <tr>
            <td><?= $t["id"] ?></td>
            <td><?= $t["date"] ?></td>
            <td><?= $t["amount"] ?></td>
            <td><?= $t["description"] ?></td>
            <td><?= $t["merchant"] ?></td>
            <td><?= daysSinceTransaction($t["date"]) ?></td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<p><b>Общая сумма:</b> <?= calculateTotalAmount($transactions) ?></p>

<hr>

<h2>Галерея</h2>

<div style="display:flex; flex-wrap:wrap; gap:10px;">
<?php
$dir = 'image/';
$files = scandir($dir);

if ($files !== false) {
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            $path = $dir . $file;
            echo "<img src='$path' width='250' style='border-radius:8px;'>";
        }
    }
}
?>
</div>

</body>
</html>
