<?php

require_once 'db.php';

$url         = "https://api.bybit.com//v5/market/kline"; // URL API
$category    = 'linear'; // Категория
$pair        = 'BTCUSD'; // Пара валют
$interval    = 'D'; // Интервал
$limit       = 100; // Количество свечей
$queryParams = [
    'category' => $category,
    'symbol'   => $pair,
    'interval' => $interval,
    'limit'    => $limit,
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($queryParams));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$data         = json_decode($response, true);
$data_reverse = array_reverse($data['result']['list']);

// Очистка таблицы
$query_delete = "DELETE FROM `btc_candles`";
$stmt         = $mysqli->prepare($query_delete);
$stmt->execute();
$stmt->close();

// Запись данных в базу данных
foreach ($data_reverse as $candle) {
    $start_time  = htmlspecialchars($candle[0] / 1000);
    $open_price  = htmlspecialchars($candle[1]);
    $high_price  = htmlspecialchars($candle[2]);
    $low_price   = htmlspecialchars($candle[3]);
    $close_price = htmlspecialchars($candle[4]);
    $volume      = htmlspecialchars($candle[5]);
    $turnover    = htmlspecialchars($candle[6]);

    $query_insert = "INSERT INTO `btc_candles`(
                          `start_time`, `open_price`, `high_price`, `low_price`, `close_price`, `volume`, `turnover`
                     )
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt         = $mysqli->prepare($query_insert);
    $stmt->bind_param(
        'sdddddd',
        $start_time,
        $open_price,
        $high_price,
        $low_price,
        $close_price,
        $volume,
        $turnover
    );
    $stmt->execute();
    $stmt->close();
}

header('Content-Type: application/json');
print_r($data_reverse);

$mysqli->close();





